Caching in the ORM
==================

Every application is different, we could have models whose data change frequently and others that rarely change.
Accessing database systems is often one of the most common bottlenecks in terms of performance. This is due to
the complex connection/communication processes that PHP must do in each request to obtain data from the database.
Therefore, if we want to achieve good performance we need to add some layers of caching where the
application requires it.

This chapter explains the possible points where it is possible to implement caching to improve performance.
The framework gives you the tools to implement the cache where you demand of it according to the architecture
of your application.

Caching Resultsets
------------------
A well established technique to avoid continuously accessing to the database is to cache resultsets that don't change
frequently using a system with faster access (usually memory).

When :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` requires a service to cache resultsets, it will
request it to the Dependency Injector Container with the convention name "modelsCache".

As Phalcon provides a component to :doc:`cache <cache>` any kind of data, we'll explain how to integrate it with Models.
First, you must register it as a service in the services container:

.. code-block:: php

    <?php

    use Phalcon\Cache\Frontend\Data as FrontendData;
    use Phalcon\Cache\Backend\Memcache as BackendMemcache;

    // Set the models cache service
    $di->set(
        "modelsCache",
        function () {
            // Cache data for one day by default
            $frontCache = new FrontendData(
                [
                    "lifetime" => 86400,
                ]
            );

            // Memcached connection settings
            $cache = new BackendMemcache(
                $frontCache,
                [
                    "host" => "localhost",
                    "port" => "11211",
                ]
            );

            return $cache;
        }
    );

You have complete control in creating and customizing the cache before being used by registering the service
as an anonymous function. Once the cache setup is properly defined you could cache resultsets as follows:

.. code-block:: php

    <?php

    // Get products without caching
    $products = Products::find();

    // Just cache the resultset. The cache will expire in 1 hour (3600 seconds)
    $products = Products::find(
        [
            "cache" => [
                "key" => "my-cache",
            ],
        ]
    );

    // Cache the resultset for only for 5 minutes
    $products = Products::find(
        [
            "cache" => [
                "key"      => "my-cache",
                "lifetime" => 300,
            ],
        ]
    );

    // Use the 'cache' service from the DI instead of 'modelsCache'
    $products = Products::find(
        [
            "cache" => [
                "key"     => "my-cache",
                "service" => "cache",
            ],
        ]
    );

Caching could be also applied to resultsets generated using relationships:

.. code-block:: php

    <?php

    // Query some post
    $post = Post::findFirst();

    // Get comments related to a post, also cache it
    $comments = $post->getComments(
        [
            "cache" => [
                "key" => "my-key",
            ],
        ]
    );

    // Get comments related to a post, setting lifetime
    $comments = $post->getComments(
        [
            "cache" => [
                "key"      => "my-key",
                "lifetime" => 3600,
            ],
        ]
    );

When a cached resultset needs to be invalidated, you can simply delete it from the cache using the previously specified key.

Note that not all resultsets should be cached. Results that change very frequently should not be cached since they
are invalidated very quickly and caching in that case impacts performance. Additionally, large datasets that
do not change frequently could be cached, but that is a decision that the developer has to make based on the
available caching mechanism and whether the performance impact to simply retrieve that data in the
first place is acceptable.

Forcing Cache
-------------
Earlier we saw how :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` integrates with the caching component provided by the framework. To make a record/resultset
cacheable we pass the key 'cache' in the array of parameters:

.. code-block:: php

    <?php

    // Cache the resultset for only for 5 minutes
    $products = Products::find(
        [
            "cache" => [
                "key"      => "my-cache",
                "lifetime" => 300,
            ],
        ]
    );

This gives us the freedom to cache specific queries, however if we want to cache globally every query performed over the model,
we can override the :code:`find()/:code:`findFirst()` method to force every query to be cached:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        /**
         * Implement a method that returns a string key based
         * on the query parameters
         */
        protected static function _createKey($parameters)
        {
            $uniqueKey = [];

            foreach ($parameters as $key => $value) {
                if (is_scalar($value)) {
                    $uniqueKey[] = $key . ":" . $value;
                } elseif (is_array($value)) {
                    $uniqueKey[] = $key . ":[" . self::_createKey($value) . "]";
                }
            }

            return join(",", $uniqueKey);
        }

        public static function find($parameters = null)
        {
            // Convert the parameters to an array
            if (!is_array($parameters)) {
                $parameters = [$parameters];
            }

            // Check if a cache key wasn't passed
            // and create the cache parameters
            if (!isset($parameters["cache"])) {
                $parameters["cache"] = [
                    "key"      => self::_createKey($parameters),
                    "lifetime" => 300,
                ];
            }

            return parent::find($parameters);
        }

        public static function findFirst($parameters = null)
        {
            // ...
        }
    }

Accessing the database is several times slower than calculating a cache key. You're free to implement any
key generation strategy you find to better for your needs. Note that a good key avoids collisions as much as possible -
meaning that different keys should return unrelated records.

This gives you full control on how the cache should be implemented for each model. If this strategy is common to several models
you can create a base class for all of them:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class CacheableModel extends Model
    {
        protected static function _createKey($parameters)
        {
            // ... Create a cache key based on the parameters
        }

        public static function find($parameters = null)
        {
            // ... Custom caching strategy
        }

        public static function findFirst($parameters = null)
        {
            // ... Custom caching strategy
        }
    }

Then use this class as base class for each 'Cacheable' model:

.. code-block:: php

    <?php

    class Robots extends CacheableModel
    {

    }

Caching PHQL Queries
--------------------
Regardless of the syntax we used to create them, all queries in the ORM are handled internally using PHQL.
This language gives you much more freedom to create all kinds of queries. Of course these queries can be cached:

.. code-block:: php

    <?php

    $phql = "SELECT * FROM Cars WHERE name = :name:";

    $query = $this->modelsManager->createQuery($phql);

    $query->cache(
        [
            "key"      => "cars-by-name",
            "lifetime" => 300,
        ]
    );

    $cars = $query->execute(
        [
            "name" => "Audi",
        ]
    );

Reusable Related Records
------------------------
Some models may have relationships with other models. This allows us to easily check the records that relate to instances in memory:

.. code-block:: php

    <?php

    // Get some invoice
    $invoice = Invoices::findFirst();

    // Get the customer related to the invoice
    $customer = $invoice->customer;

    // Print his/her name
    echo $customer->name, "\n";

This example is very simple, a customer is queried and can be used as required, for example, to show its name.
This also applies if we retrieve a set of invoices to show customers that correspond to these invoices:

.. code-block:: php

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

A customer may have one or more bills so, in this example, the same customer record may be unnecessarily queried several times.
To avoid this, we could mark the relationship as reusable; by doing so, we tell the ORM to automatically reuse
the records from memory instead of re-querying them again and again:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class Invoices extends Model
    {
        public function initialize()
        {
            $this->belongsTo(
                "customers_id",
                "Customer",
                "id",
                [
                    "reusable" => true,
                ]
            );
        }
    }

Note that this type of cache works in memory only, this means that cached data are released when the request is terminated.

Caching Related Records
-----------------------
When a related record is queried, the ORM internally builds the appropriate condition and gets the required records using :code:`find()`/:code:`findFirst()`
in the target model according to the following table:

+------------+-----------------------------------------------------------------+---------------------+
| Type       | Description                                                     | Implicit Method     |
+============+=================================================================+=====================+
| Belongs-To | Returns a model instance of the related record directly         | :code:`findFirst()` |
+------------+-----------------------------------------------------------------+---------------------+
| Has-One    | Returns a model instance of the related record directly         | :code:`findFirst()` |
+------------+-----------------------------------------------------------------+---------------------+
| Has-Many   | Returns a collection of model instances of the referenced model | :code:`find()`      |
+------------+-----------------------------------------------------------------+---------------------+

This means that when you get a related record you could intercept how the data is obtained by implementing the corresponding method:

.. code-block:: php

    <?php

    // Get some invoice
    $invoice = Invoices::findFirst();

    // Get the customer related to the invoice
    $customer = $invoice->customer; // Invoices::findFirst("...");

    // Same as above
    $customer = $invoice->getCustomer(); // Invoices::findFirst("...");

Accordingly, we could replace the :code:`findFirst()` method in the Invoices model and implement the cache we consider most appropriate:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class Invoices extends Model
    {
        public static function findFirst($parameters = null)
        {
            // ... Custom caching strategy
        }
    }

Caching Related Records Recursively
-----------------------------------
In this scenario, we assume that every time we query a result we also retrieve their associated records.
If we store the records found together with their related entities perhaps we could reduce a bit the overhead required
to obtain all entities:

.. code-block:: php

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

Getting the invoices from the cache already obtains the customer data in just one hit, reducing the overall overhead of the operation.
Note that this process can also be performed with PHQL following an alternative solution:

.. code-block:: php

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
            $phql = "SELECT Invoices.*, Customers.* FROM Invoices JOIN Customers WHERE " . $conditions;

            $query = $this->getModelsManager()->executeQuery($phql);

            $query->cache(
                [
                    "key"      => self::_createKey($conditions, $params),
                    "lifetime" => 300,
                ]
            );

            return $query->execute($params);
        }

    }

Caching based on Conditions
---------------------------
In this scenario, the cache is implemented differently depending on the conditions received.
We might decide that the cache backend should be determined by the primary key:

+---------------------+--------------------+
| Type                | Cache Backend      |
+=====================+====================+
| 1 - 10000           | mongo1             |
+---------------------+--------------------+
| 10000 - 20000       | mongo2             |
+---------------------+--------------------+
| > 20000             | mongo3             |
+---------------------+--------------------+

The easiest way to achieve this is by adding a static method to the model that chooses the right cache to be used:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;

    class Robots extends Model
    {
        public static function queryCache($initial, $final)
        {
            if ($initial >= 1 && $final < 10000) {
                $service = "mongo1";
            } elseif ($initial >= 10000 && $final <= 20000) {
                $service = "mongo2";
            } elseif ($initial > 20000) {
                $service = "mongo3";
            }

            return self::find(
                [
                    "id >= " . $initial . " AND id <= " . $final,
                    "cache" => [
                        "service" => $service,
                    ],
                ]
            );
        }
    }

This approach solves the problem, however, if we want to add other parameters such orders or conditions we would have to create
a more complicated method. Additionally, this method does not work if the data is obtained using related records or a :code:`find()`/:code:`findFirst()`:

.. code-block:: php

    <?php

    $robots = Robots::find("id < 1000");
    $robots = Robots::find("id > 100 AND type = 'A'");
    $robots = Robots::find("(id > 100 AND type = 'A') AND id < 2000");

    $robots = Robots::find(
        [
            "(id > ?0 AND type = 'A') AND id < ?1",
            "bind"  => [100, 2000],
            "order" => "type",
        ]
    );

To achieve this we need to intercept the intermediate representation (IR) generated by the PHQL parser and
thus customize the cache everything possible:

The first is create a custom builder, so we can generate a totally customized query:

.. code-block:: php

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

Instead of directly returning a :doc:`Phalcon\\Mvc\\Model\\Query <../api/Phalcon_Mvc_Model_Query>`, our custom builder returns a CustomQuery instance,
this class looks like:

.. code-block:: php

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
            if (isset($ir["where"])) {
                // The fields in the conditions can have any order
                // We need to recursively check the conditions tree
                // to find the info we're looking for
                $visitor = new CustomNodeVisitor();

                // Recursively visits the nodes
                $visitor->visit($ir["where"]);

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

Implementing a helper (CustomNodeVisitor) that recursively checks the conditions looking for fields that
tell us the possible range to be used in the cache:

.. code-block:: php

    <?php

    class CustomNodeVisitor
    {
        protected $_initial = 0;

        protected $_final = 25000;

        public function visit($node)
        {
            switch ($node["type"]) {
                case "binary-op":
                    $left  = $this->visit($node["left"]);
                    $right = $this->visit($node["right"]);

                    if (!$left || !$right) {
                        return false;
                    }

                    if ($left === "id") {
                        if ($node["op"] === ">") {
                            $this->_initial = $right;
                        }

                        if ($node["op"] === "=") {
                            $this->_initial = $right;
                        }

                        if ($node["op"] === ">=") {
                            $this->_initial = $right;
                        }

                        if ($node["op"] === "<") {
                            $this->_final = $right;
                        }

                        if ($node["op"] === "<=") {
                            $this->_final = $right;
                        }
                    }

                    break;

                case "qualified":
                    if ($node["name"] === "id") {
                        return "id";
                    }

                    break;

                case "literal":
                    return $node["value"];

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

Finally, we can replace the find method in the Robots model to use the custom classes we've created:

.. code-block:: php

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

            if (isset($parameters["bind"])) {
                return $query->execute($parameters["bind"]);
            } else {
                return $query->execute();
            }
        }
    }

Caching of PHQL planning
------------------------
As well as most moderns database systems PHQL internally caches the execution plan,
if the same statement is executed several times PHQL reuses the previously generated plan
improving performance, for a developer to take better advantage of this is highly recommended
build all your SQL statements passing variable parameters as bound parameters:

.. code-block:: php

    <?php

    for ($i = 1; $i <= 10; $i++) {
        $phql = "SELECT * FROM Store\Robots WHERE id = " . $i;

        $robots = $this->modelsManager->executeQuery($phql);

        // ...
    }

In the above example, ten plans were generated increasing the memory usage and processing in the application.
Rewriting the code to take advantage of bound parameters reduces the processing by both ORM and database system:

.. code-block:: php

    <?php

    $phql = "SELECT * FROM Store\Robots WHERE id = ?0";

    for ($i = 1; $i <= 10; $i++) {
        $robots = $this->modelsManager->executeQuery(
            $phql,
            [
                $i,
            ]
        );

        // ...
    }

Performance can be also improved reusing the PHQL query:

.. code-block:: php

    <?php

    $phql = "SELECT * FROM Store\Robots WHERE id = ?0";

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

Execution plans for queries involving `prepared statements`_ are also cached by most database systems
reducing the overall execution time, also protecting your application against `SQL Injections`_.

.. _`prepared statements`: http://en.wikipedia.org/wiki/Prepared_statement
.. _`SQL Injections`: http://en.wikipedia.org/wiki/SQL_injection
