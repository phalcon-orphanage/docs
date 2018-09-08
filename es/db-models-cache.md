<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Cache en ORM</a> 
      <ul>
        <li>
          <a href="#caching-resultsets">Cacheo de Resultsets</a>
        </li>
        <li>
          <a href="#forcing-cache">Forzando el caché</a>
        </li>
        <li>
          <a href="#caching-phql-queries">Cache de consultas PHQL</a>
        </li>
        <li>
          <a href="#reusable-related-records">Registros relacionados reutilizables</a>
        </li>
        <li>
          <a href="#caching-related-records">Cache de registros relacionados</a>
        </li>
        <li>
          <a href="#caching-related-records-recursively">Cache de registros relacionados recursivamente</a>
        </li>
        <li>
          <a href="#caching-based-on-conditions">Cache basado en condiciones</a>
        </li>
        <li>
          <a href="#caching-phql-execution-plan">Plan de ejecución para cacheo de PHQL</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='orm-caching'></a>

# Cache en ORM

Cada aplicación es diferente. En la mayoría de las aplicaciones sin embargo, hay datos que cambian con poca frecuencia. Uno de los cuellos de botella más comunes en términos de rendimiento, es el acceso a la base de datos. Esto es debido a los procesos complejos de conexión/comunicación que PHP utiliza con cada solicitud para obtener los datos de la base de datos. Por lo tanto, si queremos lograr un buen rendimiento, necesitamos agregar algunas capas de caché donde la aplicación lo requiera.

Este capítulo explica las posibles áreas donde es posible implementar el almacenamiento en caché para mejorar el rendimiento. Phalcon da a los desarrolladores las herramientas necesarias para implementar el cacheo donde su aplicación lo necesita.

<a name='caching-resultsets'></a>

## Cacheo de Resultsets

Una técnica bien establecida para evitar continuamente accediendo a la base de datos, es el cacheo de conjunto de resultados (Resultsets) que no cambian con frecuencia, utilizando un sistema de acceso más rápido (generalmente memoria).

Cuando `Phalcon\Mvc\Model` requiere un servicio de caché de conjunto de resultados, lo solicitará desde el contenedor de inyección de dependencia (DI). El servicio se llama `modelsCache`. Phalcon ofrece un componente de [caché](/[[language]]/[[version]]/cache) que puede almacenar cualquier tipo de datos. Ahora veremos cómo podemos integrarlo con nuestros modelos.

En primer lugar, necesitamos registrar el componente de caché como un servicio en el contenedor de DI.

```php
<?php

use Phalcon\Cache\Frontend\Data as FrontendData;
use Phalcon\Cache\Backend\Memcache as BackendMemcache;

// Configuración del servicio de cacheo para modelos
$di->set(
    'modelsCache',
    function () {
        // Almacenar datos por un día (valor por defecto)
        $frontCache = new FrontendData(
            [
                'lifetime' => 86400,
            ]
        );

        // Configuración de conexión a Memcached 
        $cache = new BackendMemcache(
            $frontCache,
            [
                'host' => 'localhost',
                'port' => '11211',
            ]
        );

        return $cache;
    }
);
```

Phalcon ofrece un control completo en la creación y personalización del componente de caché antes de registrarlo como un servicio en el contenedor de DI. Una vez que el componente de caché está correctamente configurado, los conjuntos de resultados pueden cachearse de la siguiente manera:

```php
<?php

// Obtener productos sin cache
$products = Products::find();

// Almacenar en el cache el Resultset. El cacheo expira en una hora (3600 segundos)
$products = Products::find(
    [
        'cache' => [
            'key' => 'my-cache',
        ],
    ]
);

// Almacenar el resultset por solo 5 minutos
$products = Products::find(
    [
        'cache' => [
            'key'      => 'my-cache',
            'lifetime' => 300,
        ],
    ]
);

// Utilizar el servicio 'cache' desde DI en vez del 'modelsCache'
$products = Products::find(
    [
        'cache' => [
            'key'     => 'my-cache',
            'service' => 'cache',
        ],
    ]
);
```

El cache también puede aplicarse a conjuntos de resultados generados mediante relaciones:

```php
<?php

// Consultamos algún post
$post = Post::findFirst();

// Obtenemos los comentarios relacionados y los cacheamos
$comments = $post->getComments(
    [
        'cache' => [
            'key' => 'my-key',
        ],
    ]
);

// Obtener los comentarios relacionados al post, configurando el tiempo de vida 'lifetime'
$comments = $post->getComments(
    [
        'cache' => [
            'key'      => 'my-key',
            'lifetime' => 3600,
        ],
    ]
);
```

Cuando un resultset en caché debe ser invalidado, simplemente se puede borrar la caché utilizando la clave especificada como se ve arriba.

Que resultset almacenar en caché y por cuánto tiempo es tarea del desarrollador, después de haber evaluado las necesidades de la aplicación. Los conjuntos de resultados que cambian con frecuencia no deben ser cacheados, ya que los resultados de la caché se invalidaran rápidamente. Además el cacheo de resultsets consume ciclos de procesamiento, por lo tanto el caché que pretendía acelerar la aplicación realmente la desacelera. Los resultsets que no cambian con frecuencia deben ser almacenados en caché para reducir al mínimo las interacciones de la base de datos. La decisión sobre dónde usar almacenamiento en caché y por cuánto tiempo, es dictada por las necesidades de aplicación.

<a name='forcing-cache'></a>

## Forzando el caché

Anteriormente vimos cómo `Phalcon\Mvc\Model` se integra con el componente de caché proporcionado por el framework. Para hacer cache de un registro o conjunto de resultados debemos pasar la clave `cache` en el array de parámetros:

```php
<?php

// Cachear el resultset por solo 5 minutos
$products = Products::find(
    [
        'cache' => [
            'key'      => 'my-cache',
            'lifetime' => 300,
        ],
    ]
);
```

Esto nos da la libertad para almacenar en caché consultas específicas, sin embargo si queremos almacenar en memoria a nivel global cada consulta realizada sobre el modelo, podemos sobrecargar los métodos `find()`/`findFirst()` para forzar el cacheo en cada consulta:

```php
<?php

use Phalcon\Mvc\Model;

class Robots extends Model
{
    /**
     * Implementar un método que retorne una clave en string
     * basada en los parámetros de la consulta
     */
    protected static function _createKey($parameters)
    {
        $uniqueKey = [];

        foreach ($parameters as $key => $value) {
            if (is_scalar($value)) {
                $uniqueKey[] = $key . ':' . $value;
            } elseif (is_array($value)) {
                $uniqueKey[] = $key . ':[' . self::_createKey($value) . ']';
            }
        }

        return join(',', $uniqueKey);
    }

    public static function find($parameters = null)
    {
        // Convertir parámetros a un array
        if (!is_array($parameters)) {
            $parameters = [$parameters];
        }

        // Chequear si la clave de cache no fue enviada,
        // en tal caso, crearla
        if (!isset($parameters['cache'])) {
            $parameters['cache'] = [
                'key'      => self::_createKey($parameters),
                'lifetime' => 300,
            ];
        }

        return parent::find($parameters);
    }

    public static function findFirst($parameters = null)
    {
        // ...
    }
}
```

El acceso a la base de datos es varias veces más lento que el cálculo de una clave de caché. Eres libre de implementar cualquier estrategia de generación de claves que encuentres mejor para tus necesidades. Tenga en cuenta que una buena clave evita colisiones tanto como sea posibles - lo que significa que diferentes claves deben devolver registros no relacionados.

Esto le da control total sobre cómo debería implementarse la caché para cada modelo. Si esta estrategia es común a varios modelos puede crear una clase base para todos ellos:

```php
<?php

use Phalcon\Mvc\Model;

class CacheableModel extends Model
{
    protected static function _createKey($parameters)
    {
        // ... Crear clave de cacheo con los parámetros
    }

    public static function find($parameters = null)
    {
        // ... Estrategia de cacheo personalizada
    }

    public static function findFirst($parameters = null)
    {
        // ... Estrategia de cacheo personalizada
    }
}
```

Luego utilice esta clase como clase base para cada modelo `Cacheable`:

```php
<?php

class Robots extends CacheableModel
{

}
```

<a name='caching-phql-queries'></a>

## Cache de consultas PHQL

Independientemente de la sintaxis que utilizamos para crearlos, todas las consultas en el ORM se manejan internamente con PHQL. Este lenguaje le da mucho más libertad a usted para crear todo tipo de consultas. Por supuesto estas consultas pueden ser almacenadas en caché:

```php
<?php

$phql = 'SELECT * FROM Cars WHERE name = :name:';

$query = $this->modelsManager->createQuery($phql);

$query->cache(
    [
        'key'      => 'cars-by-name',
        'lifetime' => 300,
    ]
);

$cars = $query->execute(
    [
        'name' => 'Audi',
    ]
);
```

<a name='reusable-related-records'></a>

## Registros relacionados reutilizables

Algunos modelos pueden tener relaciones con otros modelos. Esto nos permite comprobar fácilmente los registros que tienen instancias en memoria:

```php
<?php

// Buscar alguna factura
$invoice = Invoices::findFirst();

// Obtener el cliente relacionado a la factura
$customer = $invoice->customer;

// Imprimir su nombre
echo $customer->name, "\n";
```

Este ejemplo es muy simple, un cliente es consultado y se puede utilizar según sea necesario, por ejemplo, para mostrar su nombre. Esto también se aplica si recuperamos un conjunto de facturas para mostrar los clientes de las correspondientes facturas:

```php
<?php

// Obtener algunas facturas
// SELECT * FROM invoices;
$invoices = Invoices::find();

foreach ($invoices as $invoice) {
    // Obtener el cliente relacionado a la factura
    // SELECT * FROM customers WHERE id = ?;
    $customer = $invoice->customer;

    // Imprimir su nombre
    echo $customer->name, "\n";
}
```

Un cliente puede tener una o más facturas entonces, en este ejemplo, el mismo cliente puede ser consultado varias veces innecesariamente. Para evitar esto, podríamos marcar la relación como `reusable`; por ello le decimos al ORM que reutilice automáticamente registros de la memoria en lugar de volver a consultarles una y otra vez:

```php
<?php

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function initialize()
    {
        $this->belongsTo(
            'customers_id',
            'Customer',
            'id',
            [
                'reusable' => true,
            ]
        );
    }
}
```

Tenga en cuenta que este tipo de caché trabaja en memoria solamente, esto quiere decir que los datos almacenados en caché se liberan cuando se termina la petición.

<a name='caching-related-records'></a>

## Cache de registros relacionados

Cuando se consulta un registro relacionado, el ORM internamente construye la condición adecuada y obtiene los registros necesarios utilizando `find()`/`findFirst()` en el modelo; según la siguiente tabla:

| Tipo       | Descripción                                                                    | Método implícito |
| ---------- | ------------------------------------------------------------------------------ | ---------------- |
| Belongs-To | Devuelve una instancia del modelo relacionado directamente                     | `findFirst()`    |
| Has-One    | Devuelve una instancia del modelo relacionado directamente                     | `findFirst()`    |
| Has-Many   | Devuelve una colección de instancias del modelo, según el modelo de referencia | `find()`         |

Esto significa que cuando usted obtiene un registro relacionado, podría interceptar cómo los datos se obtuvieron aplicando el método correspondiente:

```php
<?php

// Obtener la primer factura
$invoice = Invoices::findFirst();

// Obtiene el cliente relacionado a la factura
$customer = $invoice->customer; // Invoices::findFirst('...');

// El mismo resultado que la linea anterior
$customer = $invoice->getCustomer(); // Invoices::findFirst('...');
```

En consecuencia, podríamos reemplazar el método `findFirst()` en el modelo Invoices e implementar la caché que consideramos más adecuada:

```php
<?php

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public static function findFirst($parameters = null)
    {
        // ... Estrategia de cache personalizada
    }
}
```

<a name='caching-related-records-recursively'></a>

## Cache de registros relacionados recursivamente

En este escenario, asumimos que en cada consulta de un registro también recuperamos sus registros asociados. Si almacenamos los registros encontrados junto con sus entidades relacionadas, quizá podríamos reducir un poco la sobrecarga requerida para obtener todas las entidades:

```php
<?php

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    protected static function _createKey($parameters)
    {
        // ... Creamos una clave de cache basada en los parámetros
    }

    protected static function _getCache($key)
    {
        // Retorna datos desde el cache
    }

    protected static function _setCache($key, $results)
    {
        // Almacena datos en cache
    }

    public static function find($parameters = null)
    {
        // Crea una clave única
        $key = self::_createKey($parameters);

        // Chequeamos si los datos están en cache
        $results = self::_getCache($key);

        // Validamos si los datos son un objecto
        if (is_object($results)) {
            return $results;
        }

        $results = [];

        $invoices = parent::find($parameters);

        foreach ($invoices as $invoice) {
            // Obtenemos los clientes relacionados
            $customer = $invoice->customer;

            // Los asignamos a la factura
            $invoice->customer = $customer;

            $results[] = $invoice;
        }

        // Almacenamos la factura en cache con sus clientes
        self::_setCache($key, $results);

        return $results;
    }

    public function initialize()
    {
        // Agregar relaciones e iniciar otras cosas
    }
}
```

Al recibir las facturas de la caché ya obtiene también los datos del cliente todo en un solo paso, reduciendo la carga total de la operación. Tenga en cuenta que este proceso puede realizarse también con PHQL, con la siguiente solución alternativa:

```php
<?php

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function initialize()
    {
        // Agregar relaciones e iniciar otras cosas
    }

    protected static function _createKey($conditions, $params)
    {
        // ... Creamos una clave de cache basada en los parámetros
    }

    public function getInvoicesCustomers($conditions, $params = null)
    {
        $phql = 'SELECT Invoices.*, Customers.* FROM Invoices JOIN Customers WHERE ' . $conditions;

        $query = $this->getModelsManager()->executeQuery($phql);

        $query->cache(
            [
                'key'      => self::_createKey($conditions, $params),
                'lifetime' => 300,
            ]
        );

        return $query->execute($params);
    }

}
```

<a name='caching-based-on-conditions'></a>

## Cache basado en condiciones

En este escenario, la caché se implementa dependiendo de diferentes condiciones. Nosotros podríamos decidir que tipo de cache backend debe implementarse dependiendo de la clave primaria:

| Tipo          | Cache Backend |
| ------------- | ------------- |
| 1 - 10000     | mongo1        |
| 10000 - 20000 | mongo2        |
| > 20000       | mongo3        |

La forma más sencilla de lograr esto es agregando un método estático para el modelo que elige el caché adecuado para ser utilizado:

```php
<?php

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public static function queryCache($initial, $final)
    {
        if ($initial >= 1 && $final < 10000) {
            $service = 'mongo1';
        } elseif ($initial >= 10000 && $final <= 20000) {
            $service = 'mongo2';
        } elseif ($initial > 20000) {
            $service = 'mongo3';
        }

        return self::find(
            [
                'id >= ' . $initial . ' AND id <= ' . $final,
                'cache' => [
                    'service' => $service,
                ],
            ]
        );
    }
}
```

Este planteamiento resuelve el problema, sin embargo, si queremos añadir otros parámetros tales como ordenamiento o condiciones, tendríamos que crear un método más complejo. Además, este método no funciona si los datos se obtuvieron mediante registros relacionados o un `find()`/`findFirst()`:

```php
<?php

$robots = Robots::find('id < 1000');
$robots = Robots::find("id > 100 AND type = 'A'");
$robots = Robots::find("(id > 100 AND type = 'A') AND id < 2000");

$robots = Robots::find(
    [
        "(id > ?0 AND type = 'A') AND id < ?1",
        'bind'  => [100, 2000],
        'order' => 'type',
    ]
);
```

Para lograr esto tenemos que interceptar la intermediate representation (IR) generada por el analizador PHQL y así personalizar el cache todo lo posible:

La primera es crear un builder personalizado, entonces podremos generar una consulta totalmente personalizada:

```php
<?php

use Phalcon\Mvc\Model\Query\Builder as QueryBuilder;

class CustomQueryBuilder extends QueryBuilder
{
    public function getQuery()
    {
        $query = new CustomQuery($this->getPhql());

        $query->setDI($this->getDI());

        if ( is_array($this->_bindParams) ) {
            $query->setBindParams($this->_bindParams);
        }

        if ( is_array($this->_bindTypes) ) {
            $query->setBindTypes($this->_bindTypes);
        }

        if ( is_array($this->_sharedLock) ) {
            $query->setSharedLock($this->_sharedLock);
        }

        return $query;
    }
}
```

En lugar de regresar directamente un `Phalcon\Mvc\Model\Query`, nuestro constructor personalizado devuelve una instancia de CustomQuery, que se parece a esta clase:

```php
<?php

use Phalcon\Mvc\Model\Query as ModelQuery;

class CustomQuery extends ModelQuery
{
    /**
     * El método execute es sobre cargado
     */
    public function execute($params = null, $types = null)
    {
        // Analizar la representación intermedia para el SELECT
        $ir = $this->parse();

        if ( is_array($this->_bindParams) ) {
            $params = array_merge($this->_bindParams, (array)$params);
        }

        if ( is_array($this->_bindTypes) ) {
            $types = array_merge($this->_bindTypes, (array)$types);
        }

        // Comprobar si la consulta tiene condiciones
        if (isset($ir['where'])) {
            // Los campos en las condiciones pueden tener cualquier orden
            // Necesitamos comprobar recursivamente el árbol de condiciones
            // para encontrar la información que buscamos
            $visitor = new CustomNodeVisitor();

            // Visitar los nodos recursivamente
            $visitor->visit($ir['where']);

            $initial = $visitor->getInitial();
            $final   = $visitor->getFinal();

            // Seleccionar el cache de acuerdo al rango
            // ...

            // Chequeamos si el cache tiene datos
            // ...
        }

        // Ejecutamos la consulta
        $result = $this->_executeSelect($ir, $params, $types);
        $result = $this->_uniqueRow ? $result->getFirst() : $result;

        // Cachear el resultado
        // ...

        return $result;
    }
}
```

Implementando un ayudante (`CustomNodeVisitor`) que comprueba recursivamente las condiciones de los campos que nos dicen el rango posible para ser utilizado en el cache:

```php
<?php

class CustomNodeVisitor
{
    protected $_initial = 0;

    protected $_final = 25000;

    public function visit($node)
    {
        switch ($node['type']) {
            case 'binary-op':
                $left  = $this->visit($node['left']);
                $right = $this->visit($node['right']);

                if (!$left || !$right) {
                    return false;
                }

                if ($left === 'id') {
                    if ($node['op'] === '>') {
                        $this->_initial = $right;
                    }

                    if ($node['op'] === '=') {
                        $this->_initial = $right;
                    }

                    if ($node['op'] === '>=') {
                        $this->_initial = $right;
                    }

                    if ($node['op'] === '<') {
                        $this->_final = $right;
                    }

                    if ($node['op'] === '<=') {
                        $this->_final = $right;
                    }
                }

                break;

            case 'qualified':
                if ($node['name'] === 'id') {
                    return 'id';
                }

                break;

            case 'literal':
                return $node['value'];

            default:
                return false;
        }
    }

    public function getInitial()
    {
        return $this->_initial;
    }

    public function getFinal()
    {
        return $this->_final;
    }
}
```

Por último, podemos reemplazar el método `find()` del modelo Robots para utilizar las clases personalizadas que hemos creado:

```php
<?php

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public static function find($parameters = null)
    {
        if (!is_array($parameters)) {
            $parameters = [$parameters];
        }

        $builder = new CustomQueryBuilder($parameters);

        $builder->from(get_called_class());

        $query = $builder->getQuery();

        if (isset($parameters['bind'])) {
            return $query->execute($parameters['bind']);
        } else {
            return $query->execute();
        }
    }
}
```

<a name='caching-phql-execution-plan'></a>

## Plan de ejecución para cacheo de PHQL

Como en la mayoría de los sistemas de bases de datos modernos, PHQL internamente almacena en caché el plan de ejecución, si la misma sentencia se ejecuta varias veces, PHQL reutiliza el plan previamente generado mejorando el rendimiento, para que un desarrollador aproveche mejor esta opción es altamente recomendado armar todas las consultas SQL con parámetros enlazados:

```php
<?php

for ($i = 1; $i <= 10; $i++) {
    $phql = 'SELECT * FROM Store\Robots WHERE id = ' . $i;

    $robots = $this->modelsManager->executeQuery($phql);

    // ...
}
```

En el ejemplo anterior, se generaron diez planes aumentando el uso de memoria y procesamiento en la aplicación. Reescribir el código para aprovechar las ventajas de los parámetros enlazados reduce el procesamiento por el sistema ORM y la base de datos:

```php
<?php

$phql = 'SELECT * FROM Store\Robots WHERE id = ?0';

for ($i = 1; $i <= 10; $i++) {
    $robots = $this->modelsManager->executeQuery(
        $phql,
        [
            $i,
        ]
    );

    // ...
}
```

El rendimiento puede mejorarse más aún reutilizando la consulta PHQL:

```php
<?php

$phql = 'SELECT * FROM Store\Robots WHERE id = ?0';

$query = $this->modelsManager->createQuery($phql);

for ($i = 1; $i <= 10; $i++) {
    $robots = $query->execute(
        $phql,
        [
            $i,
        ]
    );

    // ...
}
```

Los planes de ejecución para consultas que implican [sentencias preparadas](http://en.wikipedia.org/wiki/Prepared_statement) también son almacenadas en caché en la mayoría sistemas de bases de datos, reduciendo el tiempo total de ejecución, también protegen su aplicación contra las [inyecciones de SQL (SQL Injections)](http://en.wikipedia.org/wiki/SQL_injection).