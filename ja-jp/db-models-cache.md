---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'Model Caching'
keywords: 'models, caching, phql, resultsets, reuse'
---

# Model Caching

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## 概要

In most applications, there is data that changes infrequently. One of the most common bottlenecks in terms of performance is accessing data from a database. We first have a layer of complexity that allows PHP to communicate with the database and then we have the layer of complexity and potentially bottleneck within the database itself, when trying to analyze the query sent and return the data back (especially when the query contains multiple joins and group statements).

Implementing some layers of caching, reduces the number of connections and lookups to your database. This will ensure that data is queried from the database only when absolutely necessary. This article showcases some areas that caching could increase performance.

## Resultsets

A well established technique to avoid querying the database in every request, is to cache resultsets that do not change frequently, using a system with faster access (usually memory).

When [Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) requires a service to cache resultsets, it will request it from the Dependency Injection Container. The service name is called `modelsCache`. Phalcon offers a <cache> component that can store any kind of data. Integrating this service with your code requires a [Cache](cache) object.

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

> **NOTE**: It is imperative to use a serializer that can properly serialize and unserialize objects without changing their state. `Php` and `Igbinary` are such serializers. `Json` will convert objects to `stdClass` and `Simple`/`Complex` resultsets will become arrays. Choosing a serializer that cannot store objects properly will produce errors when the cache is restored for your models.
{: .alert .alert-warning }


You have complete control in how you create and customize the cache component before registering it. You can check the <cache> document for various options and customizations available when creating the cache component.

Once the cache component is properly set up, resultsets can be cached by using the `cache` element in the query commands for models such as `find`, `findFirst` etc.

```php
$invoices = Invoices::find();
```

Do not use cache

```php
$invoices = Invoices::find(
    [
        'cache' => [
            'key' => 'my-cache',
        ],
    ]
);
```

Cache this resultset using `my-cache` as the key. The results will expire in 7200 seconds, as set when setting the cache service

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

Cache the resultset using `my-cache` as the key for 5 minutes.

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

Cache the resultset using `my-cache` as the key but now use the service `cache` from the DI container instead of the `modelsCache`

## リレーション

You can also cache resultsets that are returned by relationships.

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

In the above example we call the `getRelated` method on a `Customer` model to retrieve the invoices from the `invoices` relationship. We also pass the array with the necessary options to cache the resultset for 5 minutes, using `my-key` as the key.

We can also use the magic method `getInvoices` which is `get` with the name of the relationship, in this case `invoices`.

When a cached resultset needs to be invalidated, you can simply delete it from the cache using the key specified as seen above.

What resultsets to cache and for how long will depend on the needs of your application. Resultsets that change frequently should not be cached, since the cache results will be invalidated quickly with subsequent changes to the underlying records that represent these resultsets.

> **NOTE**: Caching data comes with the cost of compiling and storing that data in the cache. You should always leverage that processing cost when formulating your caching strategy. What data is cached and for how long depends on the needs of your application.
{: .alert .alert-info }

## Forcing Cache

Earlier we saw how [Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) integrates with the caching component provided by the framework. To make a record/resultset cacheable we pass the key `cache` in the array of parameters:

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

This gives us the freedom to cache specific queries, however if we want to cache globally every query performed over the model, we can override the `find()`/`findFirst()` methods to force every query to be cached:

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

Accessing the database is several times slower than calculating a cache key. You're free to implement any key generation strategy you find to better for your needs. Note that a good key avoids collisions as much as possible - meaning that different keys should return unrelated records.

This gives you full control on how the cache should be implemented for each model. If this strategy is common to several models you can create a base class that can be extended by your models or not:

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

Then you can use this abstract class to models that you need them to be cachable and the Phalcon model to the ones you do not.

```php
<?php

namespace MyApp\Models;

use MyApp\Models\AbstractCachable;

class Invoices extends AbstractCachable
{

}
```

## PHQL Queries

Regardless of the syntax we used to create them, all queries in the ORM are handled internally using [PHQL](db-phql). This language gives you much more freedom to create all kinds of queries. Of course these queries can be cached:

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

## Reusable Relationships

Some models may have relationships with other models. This allows us to easily check the records that relate to instances in memory:

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

The above example is very simple. It finds the invoice with `inv_id = 1` and then uses the relationship `customer` to retrieve the related record in the `Customers` model. After that, we print the name of the customer.

This also applies if we retrieve a customer and want to show the invoices that they have:

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

A customer can have more than one invoice. Therefore in this example, the same customer record could be unnecessarily queried several times. To avoid this, we can set the relationship as `reusable`. This will instruct Phalcon to cache the related record in memory the first time it is accessed, and subsequent calls to the same record will return the data from the memory cached entity.

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

Note that this type of cache works in memory only, this means that cached data are released when the request is terminated.

> **NOTE** The above example is **for demonstration only** and should not be used in your code because it introduces the [N+1](https://leanpub.com/sn1php) problem
{: .alert .alert-danger }

## Related Records

When a related record is queried, the ORM internally builds the appropriate condition and gets the required records using `find()`/`findFirst()` in the target model according to the following table:

| Type       | メソッド          | Description                                                     |
| ---------- | ------------- | --------------------------------------------------------------- |
| Belongs-To | `findFirst()` | Returns a model instance of the related record directly         |
| Has-One    | `findFirst()` | Returns a model instance of the related record directly         |
| Has-Many   | `find()`      | Returns a collection of model instances of the referenced model |

This means that when you get a related record you could intercept how the data is obtained by implementing the corresponding method:

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

The above calls call the same `findFirst` method in the background. Additionally, we could replace the `findFirst()` method in the `Invoices` model and implement the cache that is most appropriate for our application needs:

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

## Related Records Recursively

In this scenario, we assume that every time we query a resultset, we also retrieve their associated records. Imagine this as a form of eager loading. If we store the records found, together with their related entities, in some instances, we could reduce the overhead required to get all entities:

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

Getting all the invoices will also loop through the resultset and get all related `Customer` records, storing them in the resultset using the `customer` property. Once the operation is completed, the whole resultset is stored in the cache. Any subsequent call to `find` in `Invoices` will use the cached resultset without hitting the database.

> **NOTE**: You need to ensure that you have a strategy to invalidate the cache when the underlying records in the database change so that you always get the correct data with your queries.
{: .alert .alert-warning }

The above can also be performed using PHQL:

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

## Conditions

One of the strategies that we can employ is conditional caching. Since each cache back end has its strengths and weaknesses, we could decide that the cache backend would be determined by the value of the primary key of the model we are accessing:

| Type          | Cache Backend |
| ------------- | ------------- |
| 1 - 10000     | redis1        |
| 10000 - 20000 | redis2        |
| > 20000       | redis3        |

The easiest way to achieve this is by adding a static method to the model that selects the right cache to be used:

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

This approach solves the problem, however, if we want to add other parameters such orders or conditions we would have to create a more complicated method. Additionally, this method does not work if the data is obtained using related records or a `find()`/`findFirst()`:

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

To achieve this we need to intercept the intermediate representation (IR) generated by the PHQL parser and customize the cache accordingly:

The first is create a custom builder, so we can generate a totally customized query:

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

Instead of directly returning a [Phalcon\Mvc\Model\Query](api/phalcon_mvc#mvc-model-query), our custom builder returns a `CustomQuery` instance:

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

In the above code snippet we call the `parse()` method from the [Phalcon\Mvc\Model\Query](api/phalcon_mvc#mvc-model-query) in order to get the intermediate representation of the PHQL query itself. We then ensure that we process all the parameters and types (if passed). Then we check if there are any conditions supplied in the `where` element of the intermediate representation. The fields in the conditions can have an `order` also. We will need to recursively check the conditions tree to find the information that we are looking for.

We are using the `CustomNodeVisitor` helper that recursively checks the conditions looking for fields that will return the range to be used in the cache.

Lastly we will check if the cache has data and return it. Alternatively we will execute the query and then store the results in the cache prior to return it back.

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

The last task is to replace the `find` method in the `Invoices` model to use the classes we just created:

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

## PHQL Execution Plan

As well as most moderns database systems PHQL caches internally the execution plan, so that if the same statement is executed several times, PHQL reuses the previously generated plan improving performance. In order to take advantage of this feature, it is highly recommended to build all your SQL statements passing variable parameters as bound parameters:

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

In the above example, ten plans were generated increasing the memory usage and processing for the application. Rewriting the code above, to take advantage of bound parameters, reduces the processing required on the ORM and the database system:

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

Performance can be also improved reusing the PHQL query:

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

Execution plans for queries involving [prepared statements](https://en.wikipedia.org/wiki/Prepared_statement) are also cached by most database systems reducing the overall execution time, also protecting your application against [SQL Injections](https://en.wikipedia.org/wiki/SQL_injection).