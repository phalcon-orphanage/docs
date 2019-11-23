---
layout: default
language: 'es-es'
version: '4.0'
---

# Model Caching

* * *

![](/assets/images/document-status-under-review-red.svg)

## Caching

Every application is different. In most applications though, there is data that changes infrequently. One of the most common bottlenecks in terms of performance, is accessing a database. This is due to the complex connection/communication processes that PHP perform with each request to obtain data from the database. Therefore, if we want to achieve good performance, we need to add some layers of caching where the application requires it.

This chapter explains the potential areas where it is possible to implement caching to improve performance. Phalcon gives developers the tools they need to implement cashing where their application needs it.

## Caching Resultsets

A well established technique to avoid continuously accessing the database, is to cache resultsets that don't change frequently, using a system with faster access (usually memory).

When [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) requires a service to cache resultsets, it will request it from the Dependency Injection Container. The service name is called `modelsCache`. Phalcon offers a <cache> component that can store any kind of data. We will now see how we can integrate it with our Models.

First, we will need to register the cache component as a service in the DI container.

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

Phalcon offers complete control in creating and customizing the cache component before registering it as a service in the DI container. Once the cache component is properly set up, resultsets can be cached as follows:

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

Caching could also be applied to resultsets generated using relationships:

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

When a cached resultset needs to be invalidated, you can simply delete it from the cache using the key specified as seen above.

Which resultset to cache and for how long is up to the developer, after having evaluated the needs of the application. Resultsets that change frequently should not be cached, since the cache results will be invalidated quickly. Additionally caching resultsets consumes processing cycles, therefore the cache that was intended to speed up the application actually slows it down. Resultsets that do not change frequently should be cached to minimize the database interactions. The decision on where to use caching and for how long is dictated by the application needs.

## Forcing Cache

Earlier we saw how [Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) integrates with the caching component provided by the framework. To make a record/resultset cacheable we pass the key `cache` in the array of parameters:

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

This gives us the freedom to cache specific queries, however if we want to cache globally every query performed over the model, we can override the `find()`/`findFirst()` methods to force every query to be cached:

```php
<?php

use Phalcon\Mvc\Model;

class Robots extends Model
{
    /**
     * Implement a method that returns a string key based
     * on the query parameters
     */
    protected static function _createKey(array $parameters)
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

Accessing the database is several times slower than calculating a cache key. You're free to implement any key generation strategy you find to better for your needs. Note that a good key avoids collisions as much as possible - meaning that different keys should return unrelated records.

This gives you full control on how the cache should be implemented for each model. If this strategy is common to several models you can create a base class for all of them:

```php
<?php

use Phalcon\Mvc\Model;

class CacheableModel extends Model
{
    protected static function _createKey(array $parameters)
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

Then use this class as base class for each `Cacheable` model:

```php
<?php

class Robots extends CacheableModel
{

}
```

## Caching PHQL Queries

Regardless of the syntax we used to create them, all queries in the ORM are handled internally using PHQL. This language gives you much more freedom to create all kinds of queries. Of course these queries can be cached:

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

## Reusable Related Records

Some models may have relationships with other models. This allows us to easily check the records that relate to instances in memory:

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

## Caching Related Records

When a related record is queried, the ORM internally builds the appropriate condition and gets the required records using `find()`/`findFirst()` in the target model according to the following table:

| Tipo       | Descripción                                                                    | Método implícito |
| ---------- | ------------------------------------------------------------------------------ | ---------------- |
| Belongs-To | Devuelve una instancia del modelo relacionado directamente                     | `findFirst()`    |
| Has-One    | Devuelve una instancia del modelo relacionado directamente                     | `findFirst()`    |
| Has-Many   | Devuelve una colección de instancias del modelo, según el modelo de referencia | `find()`         |

This means that when you get a related record you could intercept how the data is obtained by implementing the corresponding method:

```php
<?php

// Obtener la primer factura
$invoice = Invoices::findFirst();

// Obtiene el cliente relacionado a la factura
$customer = $invoice->customer; // Invoices::findFirst('...');

// El mismo resultado que la linea anterior
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
        // ... Estrategia de cacheo personalizada
    }
}
```

## Caching Related Records Recursively

In this scenario, we assume that every time we query a result we also retrieve their associated records. If we store the records found together with their related entities perhaps we could reduce a bit the overhead required to obtain all entities:

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

Getting the invoices from the cache already obtains the customer data in just one hit, reducing the overall overhead of the operation. Note that this process can also be performed with PHQL following an alternative solution:

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

## Caching based on Conditions

In this scenario, the cache is implemented differently depending on the conditions received. We might decide that the cache backend should be determined by the primary key:

| Tipo          | Cache Backend |
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
        $query = new CustomQuery(
            $this->getPhql()
        );

        $query->setDI(
            $this->getDI()
        );

        if (is_array($this->_bindParams)) {
            $query->setBindParams(
                $this->_bindParams
            );
        }

        if (is_array($this->_bindTypes)) {
            $query->setBindTypes(
                $this->_bindTypes
            );
        }

        if (is_array($this->_sharedLock)) {
            $query->setSharedLock(
                $this->_sharedLock
            );
        }

        return $query;
    }
}
```

Instead of directly returning a [Phalcon\Mvc\Model\Query](api/Phalcon_Mvc_Model_Query), our custom builder returns a CustomQuery instance, this class looks like:

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

        if (is_array($this->_bindParams)) {
            $params = array_merge(
                $this->_bindParams,
                (array) $params
            );
        }

        if (is_array($this->_bindTypes)) {
            $types = array_merge(
                $this->_bindTypes,
                (array) $types
            );
        }

        // Check if the query has conditions
        if (isset($ir['where'])) {
            // The fields in the conditions can have any order
            // We need to recursively check the conditions tree
            // to find the info we're looking for
            $visitor = new CustomNodeVisitor();

            // Recursively visits the nodes
            $visitor->visit(
                $ir['where']
            );

            $initial = $visitor->getInitial();
            $final   = $visitor->getFinal();

            // Select the cache according to the range
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

Execution plans for queries involving [prepared statements](https://en.wikipedia.org/wiki/Prepared_statement) are also cached by most database systems reducing the overall execution time, also protecting your application against [SQL Injections](https://en.wikipedia.org/wiki/SQL_injection).