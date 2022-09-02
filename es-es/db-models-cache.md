---
layout: default
language: 'es-es'
version: '4.0'
title: 'Caché de Modelos'
keywords: 'modelos, caché, phql, conjuntos de resultados, reutilización'
---

# Caché de Modelos

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

En la mayoría de aplicaciones, hay datos que cambian con poca frecuencia. Uno de los cuellos de botella más comunes en términos de rendimiento es el acceso a los datos de una base de datos. Primero tenemos una capa de complejidad que permite a PHP comunicarse con la base de datos y entonces tenemos una capa de complejidad y un potencial cuello de botella en la propia base de datos, cuando intentamos analizar la consulta enviada y devolver los datos de vuelta (especialmente cuando la consulta contiene múltiples uniones y sentencias de agrupación).

Implementando algunas capas de caché, reduce el número de conexiones y búsquedas a la base de datos. Esto asegurará que los datos serán consultados a la base de datos sólo cuando sea absolutamente necesario. Este artículo muestra algunas áreas donde el cache podría incrementar el rendimiento.

## Resultados

Una técnica bien establecida para evitar consultar la base de datos en cada petición, es cachear los conjuntos de resultados que no cambian frecuentemente, usando un sistema con acceso rápido (normalmente memoria).

Cuando [Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) necesite un servicio para cachear conjuntos de resultados, lo solicitará al Contenedor de Inyección de Dependencias. El nombre del servicio se llama `modelsCache`. Phalcon ofrece un componente <cache> que puede almacenar cualquier tipo de dato. Integrar este servicio en su código requiere un objeto [Cache](cache).

```php
<?php

use Phalcon\Cache;
use Phalcon\Cache\AdapterFactory;
use Phalcon\Di\FactoryDefault;
use Phalcon\Storage\SerializerFactory;

$container = new FactoryDefault();

$container->set(
    'modelsCache',
    function () {
        $serializerFactory = new SerializerFactory();
        $adapterFactory    = new AdapterFactory($serializerFactory);

        $options = [
            'defaultSerializer' => 'Php',
            'lifetime'          => 7200
        ];

        $adapter = $adapterFactory->newInstance('apcu', $options);

        return new Cache($adapter);
    }
);
```

> **NOTA**: Es obligatorio usar un serializador que pueda serializar y deserializar apropiadamente objetos sin cambiar su estado. `Php` e `Igbinary` son estos serializadores. `Json` convertirá los objetos a `stdClass` y los conjuntos de resultados `Simples`/`Complejos` se convertirán a vector. Elegir un serializador que no puede almacenar objetos apropiadamente producirá errores cuando se restaure el caché para sus modelos.
{: .alert .alert-warning }


Tiene el control completo de cómo crear y personalizar el componente caché antes de registrarlo. Puede comprobar el documento <cache> para ver varias opciones y personalizaciones disponibles al crear el componente caché.

Una vez que el componente caché está correctamente configurado, los conjuntos de resultados se pueden cachear usando el elemento `cache` en los comandos de consulta para modelos como `find`, `findFirst` etc.

```php
$invoices = Invoices::find();
```

No usa caché

```php
$invoices = Invoices::find(
    [
        'cache' => [
            'key' => 'my-cache',
        ],
    ]
);
```

Cachea este conjunto de resultados usando como clave `my-cache`. Este resultado espirará en 7200 segundos, configurado al establecer el servicio cache

```php
$invoices = Invoices::find(
    [
        'cache' => [
            'key'      => 'my-cache',
            'lifetime' => 300,
        ],
    ]
);
```

Cachea el conjunto de resultados durante 5 minutos usando como clave `my-cache`.

```php
$invoices = Invoices::find(
    [
        'cache' => [
            'key'     => 'my-cache',
            'service' => 'cache',
        ],
    ]
);
```

Cachea el conjunto de resultados usando como clave `my-cache` pero ahora usa el servicio `cache` del contenedor DI en vez del `modelsCache`

## Relaciones

También puede cachear conjuntos de resultados que son devueltos mediante relaciones.

```php
<?php

use MyApp\Models\Customers;
use MyApp\Models\Invoices;

$customer = Customers::findFirst(
    [
        'conditions' => 'cst_id = :cst_id:',
        'bind'       => [
            'cst_id' => 1,
        ],
    ]
);

$invoices = $customer->getRelated(
    'invoices',
    [
        'cache' => [
            'key'      => 'my-key',
            'lifetime' => 300,
        ]
    ]
);

$invoices = $customer->getInvoices(
    [
        'cache' => [
            'key'      => 'my-key',
            'lifetime' => 300,
        ]
    ]
);
```

En el ejemplo anterior llamamos al método `getRelated` sobre un modelo `Customer` para obtener las facturas mediante la relación `invoices`. También pasamos el vector con las opciones necesarias para cachear el conjunto de resultados durante 5 minutos, usando como clave `my-key`.

También podemos usar el método mágico `getInvoices` que es `get` con el nombre de la relación, en este caso `invoices`.

Cuando se necesita invalidar un conjunto de resultados cacheado, puede simplemente borrarlo del caché usando la clave especificada como se ve arriba.

Qué conjuntos de resultados cachear y durante cuanto tiempo dependerá de las necesidades de su aplicación. Los conjuntos de resultados que cambien frecuentemente no deberían ser cacheados, ya que los resultados de cache se invalidarán rápidamente con cambios posteriores en los registros subyacentes que representan estos conjuntos de resultados.

> **NOTA**: La caché de datos viene con el coste de compilar y almacenar esos datos en caché. Siempre debería aprovechar ese coste de procesamiento cuando formule su estrategia de caché. Qué datos son cacheados y durante cuanto tiempo depende de las necesidades de su aplicación.
{: .alert .alert-info }

## Forzando el caché

Anteriormente vimos como [Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) se integra con el componente de caché provisto por el framework. Para hacer cacheable un registro/conjunto de resultados pasamos la clave `cache` en el vector de parámetros:

```php
<?php

// Cache the resultset for only for 5 minutes
$invoices = Invoices::find(
    [
        'cache' => [
            'key'      => 'my-cache',
            'lifetime' => 300,
        ],
    ]
);
```

Esto nos da la libertad de cachear consultas específicas, sin embargo si queremos cachear globalmente cada consulta ejecutada sobre el modelo, podemos sobreescribir los métodos `find()`/`findFirst()` para forzar el cacheado de cada consulta:

```php
<?php

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public static function find($parameters = null)
    {
        $parameters = self::checkCacheParameters($parameters);

        return parent::find($parameters);
    }

    public static function findFirst($parameters = null)
    {
        $parameters = self::checkCacheParameters($parameters);

        return parent::findFirst($parameters);
    }

    protected static function checkCacheParameters($parameters = null)
    {
        if (null !== $parameters) {
            if (true !== is_array($parameters)) {
                $parameters = [$parameters];
            }

            if (true !== isset($parameters['cache'])) {
                $parameters['cache'] = [
                    'key'      => self::generateCacheKey($parameters),
                    'lifetime' => 300,
                ];
            }
        }

        return $parameters;
    }

    protected static function generateCacheKey(array $parameters)
    {
        $uniqueKey = [];

        foreach ($parameters as $key => $value) {
            if (true === is_scalar($value)) {
                $uniqueKey[] = $key . ':' . $value;
            } elseif (true === is_array($value)) {
                $uniqueKey[] = sprintf(
                    '%s:[%s]',
                    $key,
                    self::generateCacheKey($value)
                );
            }
        }

        return join(',', $uniqueKey);
    }
}
```

Acceder a la base de datos es varias veces más lento que calcular una clave de caché. Es libre de implementar una estrategia de generación de claves que se adapte mejor a sus necesidades. Note que una buena clave evita las colisiones tanto como sea posible, lo que significa que diferentes claves deberían devolver registros no relacionados.

Esto le da el control total de como se debería implementar el caché para cada modelo. Si esta estrategia es común a varios modelos puede crear una clase base que se puede extender por sus modelos o no:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

abstract class AbstractCacheable extends Model
{
    public static function find($parameters = null)
    {
        $parameters = self::checkCacheParameters($parameters);

        return parent::find($parameters);
    }

    public static function findFirst($parameters = null)
    {
        $parameters = self::checkCacheParameters($parameters);

        return parent::findFirst($parameters);
    }

    protected static function checkCacheParameters($parameters = null)
    {
        if (null !== $parameters) {
            if (true !== is_array($parameters)) {
                $parameters = [$parameters];
            }

            if (true !== isset($parameters['cache'])) {
                $parameters['cache'] = [
                    'key'      => self::generateCacheKey($parameters),
                    'lifetime' => 300,
                ];
            }
        }

        return $parameters;
    }

    protected static function generateCacheKey(array $parameters)
    {
        $uniqueKey = [];

        foreach ($parameters as $key => $value) {
            if (true === is_scalar($value)) {
                $uniqueKey[] = $key . ':' . $value;
            } elseif (true === is_array($value)) {
                $uniqueKey[] = sprintf(
                    '%s:[%s]',
                    $key,
                    self::generateCacheKey($value)
                );
            }
        }

        return join(',', $uniqueKey);
    }
}
```

Entonces puede usar esta clase abstracta para modelos que necesiten ser cacheables y el modelo de Phalcon para los que no.

```php
<?php

namespace MyApp\Models;

use MyApp\Models\AbstractCachable;

class Invoices extends AbstractCachable
{

}
```

## Consultas PHQL

Independientemente de la sintaxis usada para crearlas, todas las consultas en el ORM son manejadas internamente usando [PHQL](db-phql). Este lenguaje le da mucha más libertad para crear todo tipo de consultas. Por supuesto, estas consultas pueden ser cacheadas:

```php
<?php

$phql  = 'SELECT * FROM Customers WHERE cst_id = :cst_id:';
$query = $this
    ->modelsManager
    ->createQuery($phql)
;

$query->cache(
    [
        'key'      => 'customers-1',
        'lifetime' => 300,
    ]
);

$invoice = $query->execute(
    [
        'cst_id' => 1,
    ]
);
```

## Relaciones Reutilizables

Algunos modelos pueden tener relaciones con otros modelos. Esto nos permite comprobar fácilmente los registros que se relacionan con las instancias en memoria:

```php
<?php

use MyApp\Models\Invoices;

$invoice = Invoices::findFirst(
    [
        'conditions' => 'inv_id = :inv_id:',
        'bind'       => [
            'inv_id' => 1,
        ],
    ]
);

$customer = $invoice->customer;

echo $customer->cst_name, PHP_EOL;
```

El ejemplo anterior es muy simple. Encuentra la factura con `inv_id = 1` y luego usa la relación `customer` para obtener el registro relacionado en el modelo `Customers`. Después, imprimimos el nombre del cliente.

Esto también se aplica si obtenemos un cliente y queremos mostrar las facturas que tiene:

```php
<?php

use MyApp\Models\Invoices;

$invoices = Invoices::find();

foreach ($invoices as $invoice) {
    // SELECT * FROM co_customers WHERE cst_id = ?;
    $customer = $invoice->customer;

    echo $customer->cst_name, PHP_EOL;
}
```

Un cliente puede tener más de una factura. Por lo tanto en este ejemplo, el mismo registro de cliente podría ser innecesariamente consultado varias veces. Para evitar esto, podemos establecer la relación como `reusable`. Esto indicará a Phalcon que cachee el registro relacionado en memoria la primera vez que se accede, y las llamadas siguientes al mismo registro devolverá los datos de la entidad cacheada desde memoria.

```php
<?php

use MyApp\Models\Customers;
use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function initialize()
    {
        $this->belongsTo(
            'inv_cst_id',
            Customers::class,
            'cst_id',
            [
                'reusable' => true,
            ]
        );
    }
}
```

Tenga en cuenta que este tipo de caché trabaja solo con memoria, lo que significa que los datos cacheados son liberados cuando la solicitud termina.

> **NOTA** El ejemplo anterior es **sólo para demostración** y no se debería usar en su código porque introduce el problema [N+1](https://leanpub.com/sn1php)
{: .alert .alert-danger }

## Registros Relacionados

Cuando un registro relacionado se consulta, el ORM internamente construye la condición apropiada y obtiene los registros requeridos usando `find()`/`findFirst()` en el modelo destino de acuerdo con la siguiente tabla:

| Tipo       | Método        | Descripción                                                                    |
| ---------- | ------------- | ------------------------------------------------------------------------------ |
| Belongs-To | `findFirst()` | Devuelve una instancia del modelo relacionado directamente                     |
| Has-One    | `findFirst()` | Devuelve una instancia del modelo relacionado directamente                     |
| Has-Many   | `find()`      | Devuelve una colección de instancias del modelo, según el modelo de referencia |

Esto significa que cuando obtiene un registro relacionado podría interceptar como se obtienen los datos implementando el método correspondiente:

```php
<?php

use MyApp\Models\Invoices;

$invoice = Invoices::findFirst(
    [
        'conditions' => 'inv_id = :inv_id:',
        'bind'       => [
            'inv_id' => 1,
        ],
    ]
);

// Invoices::findFirst('...');
$customer = $invoice->customer;               

// Invoices::findFirst('...');
$customer = $invoice->getCustomer();

// Invoices::findFirst('...');
$customer = $invoice->getRelated('customer');
```

Las llamadas anteriores llaman al mismo método `findFirst` en segundo plano. Adicionalmente, podríamos reemplazar el método `findFirst()` en el modelo `Invoices` e implementar el caché que es más apropiado para las necesidades de nuestra aplicación:

```php
<?php

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public static function findFirst($parameters = null)
    {
        // ...
    }
}
```

## Registros Relacionados Recursivamente

En este escenario, asumimos que cada vez que consultamos un conjunto de resultados, también obtenemos sus registros asociados. Imagine esto como una forma de carga ansiosa. Si almacenamos los registros encontrados, junto con sus entidades relacionadas, en algunas instancias, podríamos reducir la sobrecarga necesaria para obtener todas las entidades:

```php
<?php

use Phalcon\Di;
use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function initialize()
    {
        $this->belongsTo(
            'inv_cst_id',
            Customers::class,
            'cst_id',
            [
                'reusable' => true,
            ]
        );
    }

    public static function find($parameters = null)
    {
        $cacheKey = self::generateCacheKey($parameters);
        $results  = self::cacheGet($cacheKey);

        if (true === is_object($results)) {
            return $results;
        }

        $results = [];

        $invoices = parent::find($parameters);

        foreach ($invoices as $invoice) {
            $customer = $invoice->getRelated('customer');

            $invoice->customer = $customer;

            $results[] = $invoice;
        }

        self::cacheSet($cacheKey, $results);

        return $results;
    }

    protected static function cacheGet($cacheKey)
    {
        $cache = Di::getDefault()->get('cache');

        return $cache->get($cacheKey);
    }

    protected static function cacheSet($cacheKey, $results)
    {
        $cache = Di::getDefault()->get('cache');

        return $cache->save($cacheKey, $results);
    }

    protected static function generateCacheKey(array $parameters)
    {
        $uniqueKey = [];

        foreach ($parameters as $key => $value) {
            if (true === is_scalar($value)) {
                $uniqueKey[] = $key . ':' . $value;
            } elseif (true === is_array($value)) {
                $uniqueKey[] = sprintf(
                    '%s:[%s]',
                    $key,
                    self::generateCacheKey($value)
                );
            }
        }

        return join(',', $uniqueKey);
    }
}
```

Obtener todas las facturas también iterará a través del conjunto de resultados y obtendrá todos los registros relacionados `Customer`, almacenándolos en el conjunto de resultados usando la propiedad `customer`. Una vez que se completa la operación, el conjunto de resultados completo se almacena en caché. Cualquier llamada posterior a `find` en `Invoices` usará el conjunto de resultados cacheado sin tocar la base de datos.

> **NOTA**: Necesita asegurarse que tiene una estrategia para invalidar el caché cuando los registros subyacentes en la base de datos cambian para obtener siempre los datos correctos en sus consultas.
{: .alert .alert-warning }

Lo anterior también se puede ejecutar usando PHQL:

```php
<?php

use Phalcon\Di;
use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function initialize()
    {
        $this->belongsTo(
            'inv_cst_id',
            Customers::class,
            'cst_id',
            [
                'reusable' => true,
            ]
        );
    }

    public function getInvoicesCustomers($conditions, $params = null)
    {
        $phql = 'SELECT Invoices.*, Customers.* '
              . 'FROM Invoices '
              . 'JOIN Customers '
              . 'WHERE ' . $conditions;

        $query = $this
            ->getModelsManager()
            ->executeQuery($phql)
        ;

        $query->cache(
            [
                'key'      => self::generateCacheKey(
                    $conditions, 
                    $params
                ),
                'lifetime' => 300,
            ]
        );

        return $query->execute($params);
    }

    protected static function generateCacheKey(array $parameters)
    {
        $uniqueKey = [];

        foreach ($parameters as $key => $value) {
            if (true === is_scalar($value)) {
                $uniqueKey[] = $key . ':' . $value;
            } elseif (true === is_array($value)) {
                $uniqueKey[] = sprintf(
                    '%s:[%s]',
                    $key,
                    self::generateCacheKey($value)
                );
            }
        }

        return join(',', $uniqueKey);
    }
}
```

## Condiciones

Una de las estrategias que podemos emplear es el cacheo condicional. Ya que cada *backend* de caché tiene sus fortalezas y debilidades, podríamos decidir que el *backend* de cache podría ser determinado por el valor de la clave primaria del modelo cuando se accede:

| Tipo          | Cache Backend |
| ------------- | ------------- |
| 1 - 10000     | redis1        |
| 10000 - 20000 | redis2        |
| > 20000       | redis3        |

La forma más fácil de conseguir esto es añadiendo un método estático al modelo que selecciona el caché correcto a utilizar:

```php
<?php

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public static function queryCache(int $initial, int $final)
    {
        if ($initial >= 1 && $final < 10000) {
            $service = 'redis1';
        } elseif ($initial >= 10000 && $final <= 20000) {
            $service = 'redis2';
        } else {
            $service = 'redis3';
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

Este enfoque soluciona el problema, sin embargo, si queremos añadir otros parámetros como el orden o condiciones tendríamos que crear un método más complicado. Adicionalmente, este método no funciona si los datos obtenidos usan registros relacionados o `find()`/`findFirst()`:

```php
<?php

$invoices = Invoices::find('id < 1000');
$invoices = Invoices::find("id > 100 AND type = 'A'");
$invoices = Invoices::find("(id > 100 AND type = 'A') AND id < 2000");
$invoices = Invoices::find(
    [
        "(id > ?0 AND type = 'A') AND id < ?1",
        'bind'  => [100, 2000],
        'order' => 'type',
    ]
);
```

Para lograr esto necesitamos interceptar la representación intermedia (IR) generada por el analizador PHQL y personalizar el caché apropiadamente:

Lo primero es crear un constructor personalizado, así podemos generar una consulta totalmente personalizada:

```php
<?php

namespace MyApp\Components;

use Phalcon\Mvc\Model\Query\Builder as QueryBuilder;

class CustomQueryBuilder extends QueryBuilder
{
    public function getQuery()
    {
        $query = new CustomQuery(
            $this->getPhql()
        );

        $query->setDI(
            $this->getDI()
        );

        if (true === is_array($this->bindParams)) {
            $query->setBindParams(
                $this->bindParams
            );
        }

        if (true === is_array($this->bindTypes)) {
            $query->setBindTypes(
                $this->bindTypes
            );
        }

        if (true === is_array($this->sharedLock)) {
            $query->setSharedLock(
                $this->sharedLock
            );
        }

        return $query;
    }
}
```

En lugar de devolver directamente un [Phalcon\Mvc\Model\Query](api/phalcon_mvc#mvc-model-query), nuestro constructor personalizado devuelve una instancia `CustomQuery`:

```php
<?php

namespace MyApp\Components;

use MyApp\Components\CustomNodeVisitor;
use Phalcon\Mvc\Model\Query as ModelQuery;

class CustomQuery extends ModelQuery
{
    public function execute($params = null, $types = null)
    {
        $ir = $this->parse();

        if (true === is_array($this->bindParams)) {
            $params = array_merge(
                $this->bindParams,
                (array) $params
            );
        }

        if (true === is_array($this->bindTypes)) {
            $types = array_merge(
                $this->bindTypes,
                (array) $types
            );
        }

        // Check if the query has conditions
        if (true === isset($ir['where'])) {
            $visitor = new CustomNodeVisitor();
            $visitor->visit(
                $ir['where']
            );

            $initial = $visitor->getInitial();
            $final   = $visitor->getFinal();
            $key     = $this->queryCache($initial, $final);
            $result  = $this->getDI()->get('cache')->get($key);

            if (true === is_object($result)) {
                return $result;
            }   
        }

        $result   = $this->executeSelect($ir, $params, $types);
        $result   = $this->uniqueRow ? $result->getFirst(): $result;
        $cacheKey = $this->calculateKey();

        $this->getDI()->get('cache')->save($cacheKey, $result);

        return $result;
    }
}
```

En el fragmento de código anterior llamamos al método `parse()` de [Phalcon\Mvc\Model\Query](api/phalcon_mvc#mvc-model-query) para poder obtener la representación intermedia de la propia consulta PHQL. A continuación, nos aseguramos de procesar todos los parámetros y tipos (si se pasan). Entonces, comprobamos si se proporcionan algunas condiciones en el elemento `where` de la representación intermedia. Los campos en las condiciones también pueden tener un `order`. Necesitamos comprobar recursivamente el árbol de condiciones para encontrar la información que estamos buscando.

Estamos usando el ayudante `CustomNodeVisitor` que comprueba recursivamente las condiciones buscando campos que devolverán el rango a ser usado en el caché.

Por último, comprobaremos si el caché tiene datos y los devuelve. Alternativamente, ejecutaremos la consulta y almacenaremos los resultados en caché antes de devolverlos.

```php
<?php

class CustomNodeVisitor
{
    protected $initial = 0;

    protected $final = 25000;

    public function getInitial(): int
    {
        return $this->initial;
    }

    public function getFinal(): int
    {
        return $this->final;
    }

    public function visit(array $node)
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
                        $this->initial = $right;
                    }

                    if ($node['op'] === '=') {
                        $this->initial = $right;
                    }

                    if ($node['op'] === '>=') {
                        $this->initial = $right;
                    }

                    if ($node['op'] === '<') {
                        $this->final = $right;
                    }

                    if ($node['op'] === '<=') {
                        $this->final = $right;
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
}
```

La última tarea es reemplazar el método `find` en el modelo `Invoices` para usar las clases que acabamos de crear:

```php
<?php

use MyApp\Components\CustomQueryBuilder;
use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public static function find($parameters = null)
    {
        if (true !== is_array($parameters)) {
            $parameters = [$parameters];
        }

        $builder = new CustomQueryBuilder($parameters);

        $builder->from(
            get_called_class()
        );

        $query = $builder->getQuery();

        if (isset($parameters['bind'])) {
            return $query->execute(
                $parameters['bind']
            );
        } else {
            return $query->execute();
        }
    }
}
```

## Plan de Ejecución PHQL

Como en la mayoría de sistemas de bases de datos modernas PHQL cachea internamente el plan de ejecución, por lo que si la misma sentencia se ejecuta varias veces, PHQL reutiliza el plan generado previamente mejorando el rendimiento. Para aprovechar esta característica, es altamente recomendado construir todos nuestras sentencias SQL pasando parámetros variables como parámetros enlazados:

```php
<?php

for ($i = 1; $i <= 10; $i++) {
    $phql = 'SELECT * FROM Invoices WHERE inv_id = ' . $i;

    $robots = $this
        ->modelsManager
        ->executeQuery($phql)
    ;

    // ...
}
```

En el ejemplo anterior, se generaron diez planes aumentando el uso y procesamiento de memoria para la aplicación. Reescribiendo el código anterior, para aprovechar la ventaja de los parámetros enlazados, reduce el procesamiento requerido sobre el ORM y el sistema de base de datos:

```php
<?php

$phql = 'SELECT * FROM Invoices WHERE id = ?0';

for ($i = 1; $i <= 10; $i++) {
    $robots = $this
        ->modelsManager
        ->executeQuery(
            $phql,
            [
                $i,
            ]
        )
    ;

    // ...
}
```

El rendimiento también se mejora reutilizando la consulta PHQL:

```php
<?php

$phql  = 'SELECT * FROM Invoices WHERE id = ?0';
$query = $this
    ->modelsManager
    ->createQuery($phql)
;

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

Los planes de ejecución para consultas que implican [sentencias preparadas](https://en.wikipedia.org/wiki/Prepared_statement) también son cacheadas por la mayoría de sistemas de bases de datos, reduciendo el tiempo total de ejecución, también protegiendo su aplicación contra [Inyecciones SQL](https://en.wikipedia.org/wiki/SQL_injection).
