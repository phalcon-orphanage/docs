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

This example is very simple, a customer is queried and can be used as required, for example, to show its name. This also applies if we retrieve a set of invoices to show customers that correspond to these invoices:

```php
<?php

// Get a set of invoices
// SELECT * FROM invoices;
$invoices = Invoices::find();

foreach ($invoices as $invoice) {
    // Get the customer related to the invoice
    // SELECT * FROM customers WHERE id = ?;
    $customer = $invoice->customer;

    // Print his/her name
    echo $customer->name, "\n";
}
```

A customer may have one or more bills so, in this example, the same customer record may be unnecessarily queried several times. To avoid this, we could mark the relationship as reusable; by doing so, we tell the ORM to automatically reuse the records from memory instead of re-querying them again and again:

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

Note that this type of cache works in memory only, this means that cached data are released when the request is terminated.

<a name='caching-related-records'></a>

## Caching Related Records

When a related record is queried, the ORM internally builds the appropriate condition and gets the required records using `find()`/`findFirst()` in the target model according to the following table:

| Type       | Description                                                     | Implicit Method |
| ---------- | --------------------------------------------------------------- | --------------- |
| Belongs-To | Returns a model instance of the related record directly         | `findFirst()`   |
| Has-One    | Returns a model instance of the related record directly         | `findFirst()`   |
| Has-Many   | Returns a collection of model instances of the referenced model | `find()`        |

This means that when you get a related record you could intercept how the data is obtained by implementing the corresponding method:

```php
<?php

// Get some invoice
$invoice = Invoices::findFirst();

// Get the customer related to the invoice
$customer = $invoice->customer; // Invoices::findFirst('...');

// Same as above
$customer = $invoice->getCustomer(); // Invoices::findFirst('...');
```

Accordingly, we could replace the `findFirst()` method in the Invoices model and implement the cache we consider most appropriate:

```php
<?php

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public static function findFirst($parameters = null)
    {
        // ... Custom caching strategy
    }
}
```

<a name='caching-related-records-recursively'></a>

## Caching Related Records Recursively

In this scenario, we assume that every time we query a result we also retrieve their associated records. If we store the records found together with their related entities perhaps we could reduce a bit the overhead required to obtain all entities:

```php
<?php

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    protected static function _createKey($parameters)
    {
        // ... Create a cache key based on the parameters
    }

    protected static function _getCache($key)
    {
        // Returns data from a cache
    }

    protected static function _setCache($key, $results)
    {
        // Stores data in the cache
    }

    public static function find($parameters = null)
    {
        // Create a unique key
        $key = self::_createKey($parameters);

        // Check if there are data in the cache
        $results = self::_getCache($key);

        // Valid data is an object
        if (is_object($results)) {
            return $results;
        }

        $results = [];

        $invoices = parent::find($parameters);

        foreach ($invoices as $invoice) {
            // Query the related customer
            $customer = $invoice->customer;

            // Assign it to the record
            $invoice->customer = $customer;

            $results[] = $invoice;
        }

        // Store the invoices in the cache + their customers
        self::_setCache($key, $results);

        return $results;
    }

    public function initialize()
    {
        // Add relations and initialize other stuff
    }
}
```

Getting the invoices from the cache already obtains the customer data in just one hit, reducing the overall overhead of the operation. Note that this process can also be performed with PHQL following an alternative solution:

```php
<?php

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function initialize()
    {
        // Add relations and initialize other stuff
    }

    protected static function _createKey($conditions, $params)
    {
        // ... Create a cache key based on the parameters
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

## Caching based on Conditions

In this scenario, the cache is implemented differently depending on the conditions received. We might decide that the cache backend should be determined by the primary key:

| Type          | Cache Backend |
| ------------- | ------------- |
| 1 - 10000     | mongo1        |
| 10000 - 20000 | mongo2        |
| > 20000       | mongo3        |

The easiest way to achieve this is by adding a static method to the model that chooses the right cache to be used:

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

This approach solves the problem, however, if we want to add other parameters such orders or conditions we would have to create a more complicated method. Additionally, this method does not work if the data is obtained using related records or a `find()`/`findFirst()`:

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

To achieve this we need to intercept the intermediate representation (IR) generated by the PHQL parser and thus customize the cache everything possible:

The first is create a custom builder, so we can generate a totally customized query:

```php
<?php

use Phalcon\Mvc\Model\Query\Builder as QueryBuilder;

class CustomQueryBuilder extends QueryBuilder
{
    public function getQuery()
    {
        $query = new CustomQuery($this->getPhql());

        $query->setDI($this->getDI());

        return $query;
    }
}
```

Instead of directly returning a `Phalcon\Mvc\Model\Query`, our custom builder returns a CustomQuery instance, this class looks like:

```php
<?php

use Phalcon\Mvc\Model\Query as ModelQuery;

class CustomQuery extends ModelQuery
{
    /**
     * The execute method is overridden
     */
    public function execute($params = null, $types = null)
    {
        // Parse the intermediate representation for the SELECT
        $ir = $this->parse();

        // Check if the query has conditions
        if (isset($ir['where'])) {
            // The fields in the conditions can have any order
            // We need to recursively check the conditions tree
            // to find the info we're looking for
            $visitor = new CustomNodeVisitor();

            // Recursively visits the nodes
            $visitor->visit($ir['where']);

            $initial = $visitor->getInitial();
            $final   = $visitor->getFinal();

            // Select the cache according to the range
            // ...

            // Check if the cache has data
            // ...
        }

        // Execute the query
        $result = $this->_executeSelect($ir, $params, $types);

        // Cache the result
        // ...

        return $result;
    }
}
```

Implementing a helper (`CustomNodeVisitor`) that recursively checks the conditions looking for fields that tell us the possible range to be used in the cache:

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

Finally, we can replace the find method in the Robots model to use the custom classes we've created:

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

## Caching PHQL execution plan

As well as most moderns database systems PHQL internally caches the execution plan, if the same statement is executed several times PHQL reuses the previously generated plan improving performance, for a developer to take better advantage of this is highly recommended build all your SQL statements passing variable parameters as bound parameters:

```php
<?php

for ($i = 1; $i <= 10; $i++) {
    $phql = 'SELECT * FROM Store\Robots WHERE id = ' . $i;

    $robots = $this->modelsManager->executeQuery($phql);

    // ...
}
```

In the above example, ten plans were generated increasing the memory usage and processing in the application. Rewriting the code to take advantage of bound parameters reduces the processing by both ORM and database system:

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

Performance can be also improved reusing the PHQL query:

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

Execution plans for queries involving [prepared statements](http://en.wikipedia.org/wiki/Prepared_statement) are also cached by most database systems reducing the overall execution time, also protecting your application against [SQL Injections](http://en.wikipedia.org/wiki/SQL_injection).