Working with Models
===================
A model represents the information (data) of the application and the rules to manipulate that data. Models are primarily used for managing
the rules of interaction with a corresponding database table. In most cases, each table in your database will correspond to one model in
your application. The bulk of your application's business logic will be concentrated in the models.

:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` is the base for all models in a Phalcon application. It provides database independence, basic
CRUD functionality, advanced finding capabilities, and the ability to relate models to one another, among other services.
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` avoids the need of having to use SQL statements because it translates methods dynamically
to the respective database engine operations.

.. highlights::

    Models are intended to work on a database high layer of abstraction. If you need to work with databases at a lower level check out the
    :doc:`Phalcon\\Db <../api/Phalcon_Db>` component documentation.

Creating Models
---------------
A model is a class that extends from :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`. It must be placed in the models directory. A model
file must contain a single class; its class name should be in camel case notation:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

    }

The above example shows the implementation of the "Robots" model. Note that the class Robots inherits from :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`.
This component provides a great deal of functionality to models that inherit it, including basic database
CRUD (Create, Read, Update, Destroy) operations, data validation, as well as sophisticated search support and the ability to relate multiple models
with each other.

.. highlights::

    If you're using PHP 5.4 is recommended declare each column that makes part of the model in order to save
    memory and reduce the memory allocation.

By default model "Robots" will refer to the table "robots". If you want to manually specify another name for the mapping table,
you can use the getSource() method:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function getSource()
        {
            return "the_robots";
        }

    }

The model Robots now maps to "the_robots" table. The initialize() method aids in setting up the model with a custom behavior i.e. a different table.
The initialize() method is only called once during the request.

Models in Namespaces
--------------------
Namespaces can be used to avoid class name collision. In this case it is necessary to indicate the name of the related table using getSource:

.. code-block:: php

    <?php

    namespace Store\Toys;

    class Robots extends \Phalcon\Mvc\Model
    {

        public function getSource()
        {
            return "robots";
        }

    }

Understanding Records To Objects
--------------------------------
Every instance of a model represents a row in the table. You can easily access record data by reading object properties. For example,
for a table "robots" with the records:

.. code-block:: bash

    mysql> select * from robots;
    +----+------------+------------+------+
    | id | name       | type       | year |
    +----+------------+------------+------+
    |  1 | Robotina   | mechanical | 1972 |
    |  2 | Astro Boy  | mechanical | 1952 |
    |  3 | Terminator | cyborg     | 2029 |
    +----+------------+------------+------+
    3 rows in set (0.00 sec)

You could find a certain record by its primary key and then print its name:

.. code-block:: php

    <?php

    // Find record with id = 3
    $robot = Robots::findFirst(3);

    // Prints "Terminator"
    echo $robot->name;

Once the record is in memory, you can make modifications to its data and then save changes:

.. code-block:: php

    <?php

    $robot = Robots::findFirst(3);
    $robot->name = "RoboCop";
    $robot->save();

As you can see, there is no need to use raw SQL statements. :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` provides high database
abstraction for web applications.

Finding Records
---------------
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` also offers several methods for querying records. The following examples will show you
how to query one or more records from a model:

.. code-block:: php

    <?php

    // How many robots are there?
    $robots = Robots::find();
    echo "There are ", count($robots), "\n";

    // How many mechanical robots are there?
    $robots = Robots::find("type = 'mechanical'");
    echo "There are ", count($robots), "\n";

    // Get and print virtual robots ordered by name
    $robots = Robots::find(array("type = 'virtual'", "order" => "name"));
    foreach ($robots as $robot) {
        echo $robot->name, "\n";
    }

    // Get first 100 virtual robots ordered by name
    $robots = Robots::find(array("type = 'virtual'", "order" => "name", "limit" => 100));
    foreach ($robots as $robot) {
       echo $robot->name, "\n";
    }

You could also use the findFirst() method to get only the first record matching the given criteria:

.. code-block:: php

    <?php

    // What's the first robot in robots table?
    $robot = Robots::findFirst();
    echo "The robot name is ", $robot->name, "\n";

    // What's the first mechanical robot in robots table?
    $robot = Robots::findFirst("type = 'mechanical'");
    echo "The first mechanical robot name is ", $robot->name, "\n";

    // Get first virtual robot ordered by name
    $robot = Robots::findFirst(array("type = 'virtual'", "order" => "name"));
    echo "The first virtual robot name is ", $robot->name, "\n";

Both find() and findFirst() methods accept an associative array specifying the search criteria:

.. code-block:: php

    <?php

    $robot = Robots::findFirst(
        array(
            "type = 'virtual'",
            "order" => "name DESC",
            "limit" => 30
        )
    );

    $robots = Robots::find(
        array(
            "conditions" => "type = ?1",
            "bind"       => array(1 => "virtual")
        )
    );

The available query options are:

+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| Parameter   | Description                                                                                                                                                                                  | Example                                                                 |
+=============+==============================================================================================================================================================================================+=========================================================================+
| conditions  | Search conditions for the find operation. Is used to extract only those records that fulfill a specified criterion. By default Phalcon_model assumes the first parameter are the conditions. | "conditions" => "name LIKE 'steve%'"                                    |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| bind        | Bind is used together with options, by replacing placeholders and escaping values thus increasing security                                                                                   | "bind" => array("status" => "A", "type" => "some-time")                 |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| bindTypes   | When binding parameters, you can use this parameter to define additional casting to the bound parameters increasing even more the security                                                   | "bindTypes" => array(Column::BIND_TYPE_STR, Column::BIND_TYPE_INT)      |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| order       | Is used to sort the resultset. Use one or more fields separated by commas.                                                                                                                   | "order" => "name DESC, status"                                          |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| limit       | Limit the results of the query to results to certain range                                                                                                                                   | "limit" => 10                                                           |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| group       | Allows to collect data across multiple records and group the results by one or more columns                                                                                                  | "group" => "name, status"                                               |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| for_update  | With this option, :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` reads the latest available data, setting exclusive locks on each row it reads                                        | "for_update" => true                                                    |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| shared_lock | With this option, :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` reads the latest available data, setting shared locks on each row it reads                                           | "shared_lock" => true                                                   |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+
| cache       | Cache the resulset, reducing the continuous access to the relational system                                                                                                                  | "cache" => array("lifetime" => 3600, "key" => "my-find-key")            |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------+

If you prefer, there is also available a way to create queries in an object oriented way, instead of using an array of parameters:

.. code-block:: php

    <?php

    $robots = Robots::query()
        ->where("type = :type:")
        ->bind(array("type" => "mechanical"))
        ->order("name")
        ->execute();

The static method query() returns a :doc:`Phalcon\\Mvc\\Model\\Criteria <../api/Phalcon_Mvc_Model_Criteria>` object that is friendly with IDE autocompleters.

Phalcon also offers you the possibility to query records using a high level, object oriented, SQL-like language called :doc:`PHQL <phql>`.

Model Resultsets
^^^^^^^^^^^^^^^^
While findFirst() returns directly an instance of the called class (when there is data to be returned), the find() method returns a
:doc:`Phalcon\\Mvc\\Model\\Resultset\\Simple <../api/Phalcon_Mvc_Model_Resultset_Simple>`. This is an object that encapsulates all the functionality
a resultset has like traversing, seeking specific records, counting, etc.

These objects are more powerful than standard arrays. One of the greatest features of the :doc:`Phalcon\\Mvc\\Model\\Resultset <../api/Phalcon_Mvc_Model_Resultset>`
is that at any time there is only one record in memory. This greatly helps in memory management especially when working with large amounts of data.

.. code-block:: php

    <?php

    // Get all robots
    $robots = Robots::find();

    // Traversing with a foreach
    foreach ($robots as $robot) {
        echo $robot->name, "\n";
    }

    // Traversing with a while
    $robots->rewind();
    while ($robots->valid()) {
        $robot = $robots->current();
        echo $robot->name, "\n";
        $robots->next();
    }

    // Count the resultset
    echo count($robots);

    // Alternative way to count the resultset
    echo $robots->count();

    // Move the internal cursor to the third robot
    $robots->seek(2);
    $robot = $robots->current()

    // Access a robot by its position in the resultset
    $robot = $robots[5];

    // Check if there is a record in certain position
    if (isset($robots[3]) {
       $robot = $robots[3];
    }

    // Get the first record in the resultset
    $robot = robots->getFirst();

    // Get the last record
    $robot = robots->getLast();

Phalcon resulsets emulates scrollable cursors, you can get any row just by accessing its position, or seeking the internal pointer to a certain position.
Note that some database systems don't support scrollable cursors, this forces to re-execute the query in order to rewind the cursor to the beginning
and obtain the record at the requested position. Similarly, if a resultset is traversed several times, the query must be executed the same number of times.

Some database systems drivers like SQLite doesn't support scrollable cursors, additionally, store large query results in memory can
consume many resources, due to this resultsets are obtained from the database in chunks of 32 rows reducing the need to
re-execute the request in several cases.

Note that resultsets can be serialized and stored in a a cache backend. :doc:`Phalcon\\Cache <cache>` can help with that task. However,
serializing data causes :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` to retrieve all the data from the database in an array,
thus consuming more memory while this process takes place.

.. code-block:: php

    <?php

    // Query all records from model parts
    $parts = Parts::find();

    // Store the resultset into a file
    file_put_contents("cache.txt", serialize($parts));

    // Get parts from file
    $parts = unserialize(file_get_contents("cache.txt"));

    // Traverse the parts
    foreach ($parts as $part) {
       echo $part->id;
    }

Binding Parameters
^^^^^^^^^^^^^^^^^^
Bound parameters are also supported in :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`. Although there is a minimal performance
impact by using bound parameters, you are encouraged to use this methodology so as to eliminate the possibility of your code being subject
to SQL injection attacks. Both string and integer placeholders are supported. Binding parameters can simply be achieved as follows:

.. code-block:: php

    <?php

    // Query robots binding parameters with string placeholders
    $conditions = "name = :name: AND type = :type:";
    $parameters = array("name" => "Robotina", "type" => "maid");
    $robots     = Robots::find(array($conditions, "bind" => $parameters));

    // Query robots binding parameters with integer placeholders
    $conditions = "name = ?1 AND type = ?2";
    $parameters = array(1 => "Robotina", 2 => "maid");
    $robots     = Robots::find(array($conditions, "bind" => $parameters));

    // Query robots binding parameters with both string and integer placeholders
    $conditions = "name = :name: AND type = ?1";
    $parameters = array("name" => "Robotina", 1 => "maid");
    $robots     = Robots::find(array($conditions, "bind" => $parameters));

When using numeric placeholders, you will need to define them as integers i.e. 1 or 2. In this case "1" or "2" are considered strings
and not numbers, so the placeholder could not be successfully replaced.

Strings are automatically escaped using PDO_. This function takes into account the connection charset, so its recommended to define
the correct charset in the connection parameters or in the database configuration, as a wrong charset will produce undesired effects
when storing or retrieving data.

Additionally you can set the parameter "bindTypes", this allows to define how the parameters should be binded according to its data type:

.. code-block:: php

    <?php

    // Query robots binding parameters with string placeholders
    $conditions = "name = :name: AND year = :year:";
    $parameters = array("name" => "Robotina", "year" => 2008);
    $types = array(Phalcon\Db\Column::BIND_TYPE_STR, Phalcon\Db\Column::BIND_TYPE_INT);
    $robots = Robots::find(array(
        $conditions,
        "bind" => $parameters,
        "bindTypes" => $types
    ));


Bound parameters are available for all query methods such as find() and findFirst() but also the calculation methods like count(), sum(), average() etc.

Relationships between Models
----------------------------
There are four types of relationships: one-on-one, one-to-many, many-to-one and many-to-many. The relationship may be unidirectional
or bidirectional, and each can be simple (a one to one model) or more complex (a combination of models). The model manager manages
foreign key constraints for these relationships, the definition of these helps referential integrity as well as easy and fast access
of related records to a model. Through the implementation of relations, it is easy to access data in related models from each record
in a uniform way.

Unidirectional relationships
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Unidirectional relations are those that are generated in relation to one another but not vice versa.

Bidirectional relations
^^^^^^^^^^^^^^^^^^^^^^^
The bidirectional relations build relationships in both models and each model defines the inverse relationship of the other.

Defining relationships
^^^^^^^^^^^^^^^^^^^^^^
In Phalcon, relationships must be defined in the initialize() method of a model. The methods belongsTo(), hasOne() or hasMany() define
the relationship between one or more fields from the current model to fields in another model. Each of these methods requires 3
parameters: local fields, referenced model, referenced fields.

+-----------+----------------------------+
| Method    | Description                |
+===========+============================+
| hasMany   | Defines a 1-n relationship |
+-----------+----------------------------+
| hasOne    | Defines a 1-1 relationship |
+-----------+----------------------------+
| belongsTo | Defines a n-1 relationship |
+-----------+----------------------------+

The following schema shows 3 tables whose relations will serve us as an example regarding relationships:

.. code-block:: sql

    CREATE TABLE `robots` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(70) NOT NULL,
        `type` varchar(32) NOT NULL,
        `year` int(11) NOT NULL,
        PRIMARY KEY (`id`)
    );

    CREATE TABLE `robots_parts` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `robots_id` int(10) NOT NULL,
        `parts_id` int(10) NOT NULL,
        `created_at` DATE NOT NULL,
        PRIMARY KEY (`id`),
        KEY `robots_id` (`robots_id`),
        KEY `parts_id` (`parts_id`)
    );

    CREATE TABLE `parts` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(70) NOT NULL,
        PRIMARY KEY (`id`)
    );

* The model "Robots" has many "RobotsParts".
* The model "Parts" has many "RobotsParts".
* The model "RobotsParts" belongs to "Robots" and "Parts" models as a one-to-many relation.

The models with their relations could be implemented as follows:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {
        public function initialize()
        {
            $this->hasMany("id", "RobotsParts", "robots_id");
        }

    }

.. code-block:: php

    <?php

    class Parts extends \Phalcon\Mvc\Model
    {

        public function initialize()
        {
            $this->hasMany("id", "RobotsParts", "parts_id");
        }

    }

.. code-block:: php

    <?php

    class RobotsParts extends \Phalcon\Mvc\Model
    {

        public function initialize()
        {
            $this->belongsTo("robots_id", "Robots", "id");
            $this->belongsTo("parts_id", "Parts", "id");
        }

    }

The first parameter indicates the field of the local model used in the relationship; the second indicates the name of the referenced
model and the third the field name in the referenced model. You could also use arrays to define multiple fields in the relationship.

Taking advantage of relationships
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
When explicitly defining the relationships between models, it is easy to find related records for a particular record.

.. code-block:: php

    <?php

    $robot = Robots::findFirst(2);
    foreach ($robot->getRobotsParts() as $robotPart) {
        echo $robotPart->getParts()->name, "\n";
    }

Phalcon uses the magic method __call to retrieve data from a relationship. If the called method has a "get" prefix
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` will return a findFirst()/find() result. The following example compares
retrieving related results with using the magic method and without:

.. code-block:: php

    <?php

    $robot = Robots::findFirst(2);

    // Robots model has a 1-n (hasMany)
    // relationship to RobotsParts then
    $robotsParts = $robot->getRobotsParts();

    // Only parts that match conditions
    $robotsParts = $robot->getRobotsParts("created_at='2012-03-15'");

    // Or using bound parameters
    $robotsParts = $robot->getRobotsParts(array(
        "created_at=:date:",
        "bind" => array("date" => "2012-03-15"
    )));

    $robotPart = RobotsParts::findFirst(1);

    // RobotsParts model has a n-1 (belongsTo)
    // relationship to RobotsParts then
    $robot = $robotPart->getRobots();

Getting related records manually:

.. code-block:: php

    <?php

    $robot = Robots::findFirst(2);

    // Robots model has a 1-n (hasMany)
    // relationship to RobotsParts then
    $robotsParts = RobotsParts::find("robots_id = '" . $robot->id . "'");

    // Only parts that match conditions
    $robotsParts = RobotsParts::find(
        "robots_id = '" . $robot->id . "' AND created_at='2012-03-15'"
    );

    $robotPart = RobotsParts::findFirst(1);

    // RobotsParts model has a n-1 (belongsTo)
    // relationship to RobotsParts then
    $robot = Robots::findFirst("id = '" . $robotPart->robots_id . "'");


The prefix "get" is used to find()/findFirst() related records. You can also use "count" prefix to return an integer denoting the count of the related records:

.. code-block:: php

    <?php

    $robot = Robots::findFirst(2);
    echo "The robot have ", $robot->countRobotsParts(), " parts\n";

Virtual Foreign Keys
^^^^^^^^^^^^^^^^^^^^
By default, relationships do not act like database foreign keys, that is, if you try to insert/update a value without having a valid
value in the referenced model, Phalcon will not produce a validation message. You can modify this behavior by adding a fourth parameter
when defining a relationship.

The RobotsPart model can be changed to demonstrate this feature:

.. code-block:: php

    <?php

    class RobotsParts extends \Phalcon\Mvc\Model
    {

        public function initialize()
        {
            $this->belongsTo("robots_id", "Robots", "id", array(
                "foreignKey" => true
            ));

            $this->belongsTo("parts_id", "Parts", "id", array(
                "foreignKey" => array(
                    "message" => "The part_id does not exist on the parts model"
                )
            ));
        }

    }

If you alter a belongsTo() relationship to act as foreign key, it will validate that the values inserted/updated on those fields have a
valid value on the referenced model. Similarly, if a hasMany()/hasOne() is altered it will validate that the records cannot be deleted
if that record is used on a referenced model.

.. code-block:: php

    <?php

    class Parts extends \Phalcon\Mvc\Model
    {

        public function initialize()
        {
            $this->hasMany("id", "RobotsParts", "parts_id", array(
                "foreignKey" => array(
                    "message" => "The part cannot be deleted because other robots are using it"
                )
            ));
        }

    }

Generating Calculations
-----------------------
Calculations are helpers for commonly used functions of database systems such as COUNT, SUM, MAX, MIN or AVG.
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` allows to use these functions directly from the exposed methods.

Count examples:

.. code-block:: php

    <?php

    // How many employees are?
    $rowcount = Employees::count();

    // How many different areas are assigned to employees?
    $rowcount = Employees::count(array("distinct" => "area"));

    // How many employees are in the Testing area?
    $rowcount = Employees::count("area = 'Testing'");

    //Count employees grouping results by their area
    $group = Employees::count(array("group" => "area"));
    foreach ($group as $row) {
       echo "There are ", $group->rowcount, " in ", $group->area;
    }

    // Count employees grouping by their area and ordering the result by count
    $group = Employees::count(
        array(
            "group" => "area",
            "order" => "rowcount"
        )
    );

Sum examples:

.. code-block:: php

    <?php

    // How much are the salaries of all employees?
    $total = Employees::sum(array("column" => "salary"));

    // How much are the salaries of all employees in the Sales area?
    $total = Employees::sum(
        array(
            "column"     => "salary",
            "conditions" => "area = 'Sales'"
        )
    );

    // Generate a grouping of the salaries of each area
    $group = Employees::sum(
        array(
            "column" => "salary",
            "group"  => "area"
        )
    );
    foreach ($group as $row) {
       echo "The sum of salaries of the ", $group->area, " is ", $group->sumatory;
    }

    // Generate a grouping of the salaries of each area ordering
    // salaries from higher to lower
    $group = Employees::sum(
        array(
            "column" => "salary",
            "group"  => "area",
            "order"  => "sumatory DESC"
        )
    );

Average examples:

.. code-block:: php

    <?php

    // What is the average salary for all employees?
    $average = Employees::average(array("column" => "salary"));

    // What is the average salary for the Sales's area employees?
    $average = Employees::average(
        array(
            "column" => "salary",
            "conditions" => "area = 'Sales'"
        )
    );

Max/Min examples:

.. code-block:: php

    <?php

    // What is the oldest age of all employees?
    $age = Employees::maximum(array("column" => "age"));

    // What is the oldest of employees from the Sales area?
    $age = Employees::maximum(
        array(
            "column" => "age",
            "conditions" => "area = 'Sales'"
        )
    );

    // What is the lowest salary of all employees?
    $salary = Employees::minimum(array("column" => "salary"));

Caching Resultsets
^^^^^^^^^^^^^^^^^^
Access to database systems is often one of the most common bottlenecks in terms of performance. This is due to the complex connection
process that PHP must do in each request to obtain data from the database. A well established technique to avoid the continuous access
to the database is to cache resultsets that don't change frequently in a system with faster access (usually memory).

When :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` requires a service to cache resultsets, it will request it to the Dependency
Injector Container with the convention name "modelsCache".

As Phalcon provides a component to cache any kind of data, we'll explain how to integrate it with Models. First you need to register
it as a service in the services container:

.. code-block:: php

    <?php

    //Set the models cache service
    $di->set('modelsCache', function(){

        //Cache data for one day by default
        $frontCache = new Phalcon\Cache\Frontend\Data(array(
            "lifetime" => 86400
        ));

        //Memcached connection settings
        $cache = new Phalcon\Cache\Backend\Memcached($frontCache, array(
            "host" => "localhost",
            "port" => "11211"
        ));

        return $cache;
    });

You have complete control in creating and customizing the cache before being used to record the service as an anonymous function.
Once the cache setup is properly defined you could cache resultsets as follows:

.. code-block:: php

    <?php

    // Get products without caching
    $products = Products::find();

    // Just cache the resultset. The cache will expire in 1 hour (3600 seconds)
    $products = Products::find(array("cache" => true));

    // Cache the resultset only for 5 minutes
    $products = Products::find(array("cache" => 300));

    // Cache the resultset with a key pre-defined
    $products = Products::find(array("cache" => array("key" => "my-products-key")));

    // Cache the resultset with a key pre-defined and for 2 minutes
    $products = Products::find(
        array(
            "cache" => array(
                "key"      => "my-products-key",
                "lifetime" => 120
            )
        )
    );

    // Using a custom cache
    $products = Products::find(array("cache" => $myCache));

By default, :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` will create a unique key to store the resultset, using a md5 hash
of the SQL select statement generated internally. This is very practical because it generates a new unique key for every change in
the parameters passed in the object. If you wish to control the cache keys, you could always use the key() parameter as seen in the
example above. The getLastKey() method retrieves the key of the last cached entry so that you can target and retrieve the resultset
later on from the cache.:

.. code-block:: php

    <?php

    // Cache the resultset using an automatic key
    $products = Products::find(array("cache" => 3600));

    // Get last generated key
    $automaticKey = $products->getCache()->getLastKey();

    // Use resultset as normal
    foreach($products as $product){
        //...
    }

Cache keys automatically generated by :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` are always prefixed with "phc". This helps
to easily identify the cached entries related to :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`:

.. code-block:: php

    <?php

    // Set the cache to the models manager
    $cache = $di->getModelsCache();

    // Get keys created by Phalcon\Mvc\Model
    foreach ($cache->queryKeys("phc") as $key) {
         echo $key, "\n";
    }

Note that not all resultsets must be cached. Results that change very frequently should not be cached since they are invalidated very
quickly and caching in that case impacts performance. Additionally, large datasets that do not change frequently could be cached but
that is a decision that the developer has to make based on the available caching mechanism and whether the performance impact to simply
retrieve that data in the first place is acceptable.

Caching could be also applied to resultsets generated using relationships:

.. code-block:: php

    <?php

    // Query some post
    $post = Post::findFirst();

    // Get comments related to a post, also cache it
    $comments = $post->getComments(array("cache" => true));

    // Get comments related to a post, setting lifetime
    $comments = $post->getComments(array("cache" => true, "lifetime" => 3600));

When a cached resultset needs to be invalidated, you can simply delete it from the cache using the generated key.

Creating Updating/Records
-------------------------
The method Phalcon\\Mvc\\Model::save() allows you to create/update records according to whether they already exist in the table
associated with a model. The save method is called internally by the create and update methods of :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`.
For this to work as expected it is necessary to have properly defined a primary key in the entity to determine whether a record
should be updated or created.

Also the method executes associated validators, virtual foreign keys and events that are defined in the model:

.. code-block:: php

    <?php

    $robot       = new Robots();
    $robot->type = "mechanical";
    $robot->name = "Astro Boy";
    $robot->year = 1952;
    if ($robot->save() == false) {
        echo "Umh, We can't store robots right now: \n";
        foreach ($robot->getMessages() as $message) {
            echo $message, "\n";
        }
    } else {
        echo "Great, a new robot was saved successfully!";
    }

Create/Update with Certainty
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
When an application has a lot of competition, maybe we expect to create a record but that is actually updated. This could happen if we use
Phalcon\\Mvc\\Model::save() to persist the records in the database. If we want to be certain that a record will be created or updated
created we can change save by "create" or "update":

.. code-block:: php

    <?php

    $robot       = new Robots();
    $robot->type = "mechanical";
    $robot->name = "Astro Boy";
    $robot->year = 1952;

    //This record only must be created
    if ($robot->create() == false) {
        echo "Umh, We can't store robots right now: \n";
        foreach ($robot->getMessages() as $message) {
            echo $message, "\n";
        }
    } else {
        echo "Great, a new robot was created successfully!";
    }

Auto-generated identity columns
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Some models may have identity columns. These columns usually are the primary key of the mapped table. :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`
can recognize the identity column and will omit it from the internal SQL INSERT, so the database system could generate an auto-generated value for it.
Always after creating a record, the identity field will be registered with the  value generated in the database system for it:

.. code-block:: php

    <?php

    $robot->save();
    echo "The generated id is: ", $robot->id;

:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` is able to recognize the identity column. Depending on the database system, those columns may be
serial columns like in PostgreSQL or auto_increment columns in the case of MySQL.

PostgreSQL uses sequences to generate auto-numeric values, by default, Phalcon tries to obtain the generated value from the sequence "table_field_seq",
for example: robots_id_seq, if that sequence has a different name, the method "getSequenceName" needs to be implemented:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function getSequenceName()
        {
            return "robots_sequence_name";
        }

    }

Validation Messages
^^^^^^^^^^^^^^^^^^^
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` has a messaging subsystem that provides a flexible way to output or store the
validation messages generated during the insert/update processes.

Each message consists of an instance of the class :doc:`Phalcon\\Mvc\\Model\\Message <../api/Phalcon_Mvc_Model_Message>`. The set of
messages generated can be retrieved with the method getMessages(). Each message provides extended information like the field name that
generated the message or the message type:

.. code-block:: php

    <?php

    if ($robot->save() == false) {
        foreach ($robot->getMessages() as $message) {
            echo "Message: ", $message->getMessage();
            echo "Field: ", $message->getField();
            echo "Type: ", $message->getType();
        }
    }

:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` can generate the following types of validation messages:

+---------------------+------------------------------------------------------------------------------------------------------------------------------------+
| Type                | Description                                                                                                                        |
+=====================+====================================================================================================================================+
| PresenceOf          | Generated when a field with a non-null attribute on the database is trying to insert/update a null value                           |
+---------------------+------------------------------------------------------------------------------------------------------------------------------------+
| ConstraintViolation | Generated when a field part of a virtual foreign key is trying to insert/update a value that doesn't exist in the referenced model |
+---------------------+------------------------------------------------------------------------------------------------------------------------------------+
| InvalidValue        | Generated when a validator failed due to an invalid value                                                                          |
+---------------------+------------------------------------------------------------------------------------------------------------------------------------+

Validation Events and Events Manager
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Models allow you to implement events that will be thrown when performing an insert or update. They help to define business rules for a
certain model. The following are the events supported by :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` and their order of execution:

+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Operation          | Name                     | Can stop operation?   | Explanation                                                                                                         |
+====================+==========================+=======================+=====================================================================================================================+
| Inserting/Updating | beforeValidation         | YES                   | Is executed before the fields are validated for not nulls or foreign keys                                           |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Inserting          | beforeValidationOnCreate | YES                   | Is executed before the fields are validated for not nulls or foreign keys when an insertion operation is being made |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Updating           | beforeValidationOnUpdate | YES                   | Is executed before the fields are validated for not nulls or foreign keys when an updating operation is being made  |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Inserting/Updating | onValidationFails        | YES (already stopped) | Is executed after an integrity validator fails                                                                      |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Inserting          | afterValidationOnCreate  | YES                   | Is executed after the fields are validated for not nulls or foreign keys when an insertion operation is being made  |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Updating           | afterValidationOnUpdate  | YES                   | Is executed after the fields are validated for not nulls or foreign keys when an updating operation is being made   |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Inserting/Updating | afterValidation          | YES                   | Is executed after the fields are validated for not nulls or foreign keys                                            |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Inserting/Updating | beforeSave               | YES                   | Runs before the required operation over the database system                                                         |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Updating           | beforeUpdate             | YES                   | Runs before the required operation over the database system only when an updating operation is being made           |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Inserting          | beforeCreate             | YES                   | Runs before the required operation over the database system only when an inserting operation is being made          |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Updating           | afterUpdate              | NO                    | Runs after the required operation over the database system only when an updating operation is being made            |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Inserting          | afterCreate              | NO                    | Runs after the required operation over the database system only when an inserting operation is being made           |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+
| Inserting/Updating | afterSave                | NO                    | Runs after the required operation over the database system                                                          |
+--------------------+--------------------------+-----------------------+---------------------------------------------------------------------------------------------------------------------+

To make a model to react to an event, we must to implement a method with the same name of the event:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function beforeValidationOnCreate()
        {

            echo "This is executed before create a Robot!";
        }

    }

Events can be useful to assign values before perform a operation, for example:

.. code-block:: php

    <?php

    class Products extends \Phalcon\Mvc\Model
    {

        public function beforeCreate()
        {
            //Set the creation date
            $this->created_at = date('Y-m-d H:i:s');
        }

        public function beforeUpdate()
        {
            //Set the modification date
            $this->modified_in = date('Y-m-d H:i:s');
        }

    }

Additionally, this component is integrated with :doc:`Phalcon\\Events\\Manager <../api/Phalcon_Events_Manager>`, this means we can create
listeners that run when an event is triggered.

.. code-block:: php

    <?php

    $eventsManager = new Phalcon\Events\Manager();

    //Attach an anonymous function as a listener for "model" events
    $eventsManager->attach('model', function($event, $robot) {
        if ($event->getType() == 'beforeSave') {
            if ($robot->name == 'Scooby Doo') {
                echo "Scooby Doo isn't a robot!";
                return false;
            }
        }
        return true;
    });

    $robot = new Robots();
    $robot->setEventsManager($eventsManager);
    $robot->name = 'Scooby Doo';
    $robot->year = 1969;
    $robot->save();

In the above example the EventsManager only acted as a bridge between an object and a listener (the anonymous function). If we want all
objects created in our application use the same EventsManager then we need to assign this to the Models Manager:

.. code-block:: php

    <?php

    //Registering the modelsManager service
    $di->set('modelsManager', function() {

        $eventsManager = new Phalcon\Events\Manager();

        //Attach an anonymous function as a listener for "model" events
        $eventsManager->attach('model', function($event, $model){
            if (get_class($model) == 'Robots') {
                if ($event->getType() == 'beforeSave') {
                    if ($modle->name == 'Scooby Doo') {
                        echo "Scooby Doo isn't a robot!";
                        return false;
                    }
                }
            }
            return true;
        });

        //Setting a default EventsManager
        $modelsManager = new Phalcon\Mvc\Models\Manager();
        $modelsManager->setEventsManager($eventsManager);
        return $modelsManager;
    });

Implementing a Business Rule
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
When an insert, update or delete is executed, the model verifies if there are any methods with the names of the events listed in the table above.

We recommend that validation methods are declared protected to prevent that business logic implementation from being exposed publicly.

The following example implements an event that validates the year cannot be smaller than 0 on update or insert:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function beforeSave()
        {
            if ($this->year < 0) {
                echo "Year cannot be smaller than zero!";
                return false;
            }
        }

    }

Some events return false as an indication to stop the current operation. If an event doesn't return anything, :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`
will assume a true value.

Validating Data Integrity
^^^^^^^^^^^^^^^^^^^^^^^^^
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` provides several events to validate data and implement business rules. The special "validation"
event allows us to call built-in validators over the record. Phalcon exposes a few built-in validators that can be used at this stage of validation.

The following example shows how to use it:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\Validator\InclusionIn;
    use Phalcon\Mvc\Model\Validator\Uniqueness;

    class Robots extends \Phalcon\Mvc\Model
    {

        public function validation()
        {

            $this->validate(new InclusionIn(
                array(
                    "field"  => "type",
                    "domain" => array("Mechanical", "Virtual")
                )
            ));

            $this->validate(new Uniqueness(
                array(
                    "field"   => "name",
                    "message" => "The robot name must be unique"
                )
            ));

            return $this->validationHasFailed() != true;
        }

    }

The above example performs a validation using the built-in validator "InclusionIn". It checks the value of the field "type" in a domain list. If
the value is not included in the method then the validator will fail and return false. The following built-in validators are available:

+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Name         | Explanation                                                                                                                                                      | Example                                                           |
+==============+==================================================================================================================================================================+===================================================================+
| PresenceOf   | Validates that a field's value isn't null or empty string. This validator is automatically added based on the attributes marked as not null on the mapped table  | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_PresenceOf>`    |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Email        | Validates that field contains a valid email format                                                                                                               | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_Email>`         |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| ExclusionIn  | Validates that a value is not within a list of possible values                                                                                                   | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_Exclusionin>`   |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| InclusionIn  | Validates that a value is within a list of possible values                                                                                                       | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_Inclusionin>`   |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Numericality | Validates that a field has a numeric format                                                                                                                      | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_Numericality>`  |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Regex        | Validates that the value of a field matches a regular expression                                                                                                 | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_Regex>`         |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| Uniqueness   | Validates that a field or a combination of a set of fields are not present more than once in the existing records of the related table                           | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_Uniqueness>`    |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| StringLength | Validates the length of a string                                                                                                                                 | :doc:`Example <../api/Phalcon_Mvc_Model_Validator_StringLength>`  |
+--------------+------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+

In addition to the built-in validatiors, you can create your own validators:

.. code-block:: php

    <?php

    class UrlValidator extends \Phalcon\Mvc\Model\Validator
    {

        public function validate($model)
        {
            $field = $this->getOption('field');

            $value = $model->$field;
            $filtered = filter_var($value, FILTER_VALIDATE_URL);
            if (!$filtered) {
                $this->appendMessage("The URL is invalid", $field, "UrlValidator");
                return false;
            }
            return true;
        }

    }

Adding the validator to a model:

.. code-block:: php

    <?php

    class Customers extends \Phalcon\Mvc\Model
    {

        public function validation()
        {
            $this->validate(new UrlValidator(
                array(
                    "field"  => "url",
                )
            ));
            if ($this->validationHasFailed() == true) {
                return false;
            }
        }

    }

The idea of ​​creating validators is make them reusable between several models. A validator can also be as simple as:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function validation()
        {
            if ($this->type == "Old") {
                $message = new Phalcon\Mvc\Model\Message(
                    "Sorry, old robots are not allowed anymore",
                    "type",
                    "MyType"
                );
                $this->appendMessage($message);
                return false;
            }
            return true;
        }

    }

Avoiding SQL injections
^^^^^^^^^^^^^^^^^^^^^^^
Every value assigned to a model attribute is escaped depending of its data type. A developer doesn't need to escape manually
each value before store it on the database. Phalcon uses internally the `bound parameters <http://php.net/manual/en/pdostatement.bindparam.php>`_
capability provided by PDO.

.. code-block:: bash

    mysql> desc products;
    +------------------+------------------+------+-----+---------+----------------+
    | Field            | Type             | Null | Key | Default | Extra          |
    +------------------+------------------+------+-----+---------+----------------+
    | id               | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
    | product_types_id | int(10) unsigned | NO   | MUL | NULL    |                |
    | name             | varchar(70)      | NO   |     | NULL    |                |
    | price            | decimal(16,2)    | NO   |     | NULL    |                |
    | active           | char(1)          | YES  |     | NULL    |                |
    +------------------+------------------+------+-----+---------+----------------+
    5 rows in set (0.00 sec)

If we use just PDO to store a record in a secure way, we need to write the following code:

.. code-block:: php

    <?php

    $productTypesId = 1;
    $name = 'Artichoke';
    $price = 10.5;
    $active = 'Y';

    $sql = 'INSERT INTO products VALUES (null, :productTypesId, :name, :price, :active)';
    $sth = $dbh->prepare($sql);

    $sth->bindParam(':productTypesId', $productTypesId, PDO::PARAM_INT);
    $sth->bindParam(':name', $name, PDO::PARAM_STR, 70);
    $sth->bindParam(':price', doubleval($price));
    $sth->bindParam(':active', $active, PDO::PARAM_STR, 1);

    $sth->execute();

The good news is that Phalcon do this automatically for you:

.. code-block:: php

    <?php

    $product = new Products();
    $product->product_types_id = 1;
    $product->name = 'Artichoke';
    $product->price = 10.5;
    $product->active = 'Y';
    $product->create();

Skipping Columns
----------------
To tell to Phalcon\\Mvc\\Model that omits some fields in the creation and/or update in order to delegate the database
system assigns the value by a trigger or a default:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function initialize()
        {
            //Skips fields/columns on both INSERT/UPDATE operations
            $this->skipAttributes(array('year', 'price'));

            //Skips only when inserting
            $this->skipAttributesOnCreate(array('created_at'));

            //Skips only when updating
            $this->skipAttributesOnUpdate(array('modified_in'));
        }

    }

This will ignore globally these fields on each INSERT/UPDATE operation on the whole application.
Forcing a default value can be done in the following way:

.. code-block:: php

    <?php

    $robot = new Robots();
    $robot->name = 'Bender';
    $robot->year = 1999;
    $robot->created_at = new Phalcon\Db\RawValue('default');
    $robot->create();

Deleting Records
----------------
The method Phalcon\\Mvc\\Model::delete() allows to delete a record. You can use it as follows:

.. code-block:: php

    <?php

    $robot = Robots::findFirst(11);
    if ($robot != false) {
        if ($robot->delete() == false) {
            echo "Sorry, we can't delete the robot right now: \n";
            foreach ($robot->getMessages() as $message) {
                echo $message, "\n";
            }
        } else {
            echo "The robot was deleted successfully!";
        }
    }

You can also delete many records by traversing a resultset with a foreach:

.. code-block:: php

    <?php

    foreach (Robots::find("type='mechanical'") as $robot) {
        if ($robot->delete() == false) {
            echo "Sorry, we can't delete the robot right now: \n";
            foreach ($robot->getMessages() as $message) {
                echo $message, "\n";
            }
        } else {
            echo "The robot was deleted successfully!";
        }
    }

The following events are available to define custom business rules that can be executed when a delete operation is performed:

+-----------+--------------+---------------------+------------------------------------------+
| Operation | Name         | Can stop operation? | Explanation                              |
+===========+==============+=====================+==========================================+
| Deleting  | beforeDelete | YES                 | Runs before the delete operation is made |
+-----------+--------------+---------------------+------------------------------------------+
| Deleting  | afterDelete  | NO                  | Runs after the delete operation was made |
+-----------+--------------+---------------------+------------------------------------------+

Validation Failed Events
------------------------

Another type of events is available when the data validation process finds any inconsistency:

+--------------------------+--------------------+--------------------------------------------------------------------+
| Operation                | Name               | Explanation                                                        |
+==========================+====================+====================================================================+
| Insert or Update         | notSave            | Triggered when the INSERT or UPDATE operation fails for any reason |
+--------------------------+--------------------+--------------------------------------------------------------------+
| Insert, Delete or Update | onValidationFails  | Triggered when any data manipulation operation fails               |
+--------------------------+--------------------+--------------------------------------------------------------------+

Transactions
------------
When a process performs multiple database operations, it is often that each step is completed successfully so that data integrity can
be maintained. Transactions offer the ability to ensure that all database operations have been executed successfully before the data
is committed in the database.

Transactions in Phalcon allow you to commit all operations if they have been executed successfully or rollback all operations if something went wrong.

.. code-block:: php

    <?php

    try {

        //Create a transaction manager
        $manager = new Phalcon\Mvc\Model\Transaction\Manager();

        // Request a transaction
        $transaction = $manager->get();

        $robot = new Robots();
        $robot->setTransaction($transaction);
        $robot->name = "WALLÂ·E";
        $robot->created_at = date("Y-m-d");
        if ($robot->save() == false) {
            $transaction->rollback("Cannot save robot");
        }

        $robotPart = new RobotParts();
        $robotPart->setTransaction($transaction);
        $robotPart->type = "head";
        if ($robotPart->save() == false) {
            $transaction->rollback("Cannot save robot part");
        }

        //Everything goes fine, let's commit the transaction
        $transaction->commit();

    } catch(Phalcon\Mvc\Model\Transaction\Failed $e) {
        echo "Failed, reason: ", $e->getMessage();
    }

Transactions can be used to delete many records in a consistent way:

.. code-block:: php

    <?php

    try {

        //Create a transaction manager
        $manager = new Phalcon\Mvc\Model\Transaction\Manager();

        //Request a transaction
        $transaction = $manager->get();

        //Get the robots will be deleted
        foreach (Robots::find("type='mechanical'") as $robot) {
            $robot->setTransaction($transaction);
            if ($robot->delete() == false) {
                //Something goes wrong, we should to rollback the transaction
                foreach ($robot->getMessages() as $message) {
                    $transaction->rollback($message->getMessage());
                }
            }
        }

        //Everything goes fine, let's commit the transaction
        $transaction->commit();

        echo "Robots were deleted successfully!";

    } catch(Phalcon\Mvc\Model\Transaction\Failed $e) {
        echo "Failed, reason: ", $e->getMessage();
    }

Transactions are reused no matter where the transaction object is retrieved. A new transaction is generated only when a commit() or rollback()
is performed. You can use the service container to create an overall transaction manager for the entire application:

.. code-block:: php

    <?php

    $di->set('transactions', function(){
        return new Phalcon\Mvc\Model\Transaction\Manager();
    });

Then access it from a controller or view:

.. code-block:: php

    <?php

    class ProductsController extends \Phalcon\Mvc\Controller {

        public function saveAction()
        {

            //Obtain the TransactionsManager from the DI container
            $manager = $this->di->getShared('transactions');

            //Request a transaction
            $transaction = $manager->get();

        }

    }

Models Meta-Data
----------------
To speed up development :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` helps you to query fields and constraints from tables
related to models. To achieve this, :doc:`Phalcon\\Mvc\\Model\\MetaData <../api/Phalcon_Mvc_Model_MetaData>` is available to manage
and cache table meta-data.

Sometimes it is necessary to get those attributes when working with models. You can get a meta-data instance as follows:

.. code-block:: php

    <?php

    $robot = new Robots();

    // Get Phalcon\Mvc\Model\Metadata instance
    $metaData = $robot->getDI()->getModelsMetaData();

    // Get robots fields names
    $attributes = $metaData->getAttributes($robot);
    print_r($attributes);

    // Get robots fields data types
    $dataTypes = $metaData->getDataTypes($robot);
    print_r($dataTypes);

Caching Meta-Data
^^^^^^^^^^^^^^^^^
Once the application is in a production stage, it is not necessary to query the meta-data of the table from the database system each
time you use the table. This could be done caching the meta-data using any of the following adapters:

+---------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------------------------+
| Adapter | Description                                                                                                                                                                                                                                                                                                                                   | API                                                                                       |
+=========+===============================================================================================================================================================================================================================================================================================================================================+===========================================================================================+
| Memory  | This adapter is the default. The meta-data is cached only during the request. When the request is completed, the meta-data are released as part of the normal memory of the request. This adapter is perfect when the application is in development so as to refresh the meta-data in each request containing the new and/or modified fields. | :doc:`Phalcon\\Mvc\\Model\\MetaData\\Memory <../api/Phalcon_Mvc_Model_MetaData_Memory>`   |
+---------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------------------------+
| Session | This adapter stores meta-data in the $_SESSION superglobal. This adapter is recommended only when the application is actually using a small number of models. The meta-data are refreshed every time a new session starts. This also requires the use of session_start() to start the session before using any models.                        | :doc:`Phalcon\\Mvc\\Model\\MetaData\\Session <../api/Phalcon_Mvc_Model_MetaData_Session>` |
+---------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------------------------+
| Apc     | The Apc adapter uses the `Alternative PHP Cache (APC)`_ to store the table meta-data. You can specify the lifetime of the meta-data with options. This is the most recommended way to store meta-data when the application is in production stage.                                                                                            | :doc:`Phalcon\\Mvc\\Model\\MetaData\\Apc <../api/Phalcon_Mvc_Model_MetaData_Apc>`         |
+---------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------------------------+
| Files   | This adapter uses plain files to store meta-data. By using this adapter the disk-reading is increased but the database access is reduced                                                                                                                                                                                                      | :doc:`Phalcon\\Mvc\\Model\\MetaData\\Files <../api/Phalcon_Mvc_Model_MetaData_Files>`     |
+---------+-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------------------------------+

As other ORM's dependencies, the metadata manager is requested from the services container:

.. code-block:: php

    <?php

    $di->set('modelsMetadata', function() {

        // Create a meta-data manager with APC
        $metaData = new Phalcon\Mvc\Model\MetaData\Apc(
            array(
                "lifetime" => 86400,
                "suffix"   => "my-suffix"
            )
        );

        return $metaData;
    });

Manual Meta-Data
^^^^^^^^^^^^^^^^
Phalcon can obtain the metadata for each model automatically without the developer must set them manually.
Remember that when defining the metadata manually, new columns added/modified/removed to/from the mapped
table must be added/modified/removed also for everything to work correctly.

The following example shows how to define the meta-data manually:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model\MetaData;
    use Phalcon\Db\Column;

    class Robots extends Phalcon\Mvc\Model
    {

        public function metaData()
        {
            return array(

                //Every column in the mapped table
                MetaData::MODELS_ATTRIBUTES => array(
                    'id', 'name', 'type', 'year'
                ),

                //Every column part of the primary key
                MetaData::MODELS_PRIMARY_KEY => array(
                    'id'
                ),

                //Every column that isn't part of the primary key
                MetaData::MODELS_NON_PRIMARY_KEY => array(
                    'name', 'type', 'year'
                ),

                //Every column that doesn't allows null values
                MetaData::MODELS_NOT_NULL => array(
                    'id', 'name', 'type', 'year'
                ),

                //Every column and their data types
                MetaData::MODELS_DATA_TYPES => array(
                    'id' => Column::TYPE_INTEGER,
                    'name' => Column::TYPE_VARCHAR,
                    'type' => Column::TYPE_VARCHAR,
                    'year' => Column::TYPE_INTEGER
                ),

                //The columns that have numeric data types
                MetaData::MODELS_DATA_TYPES_NUMERIC => array(
                    'id' => true,
                    'year' => true,
                ),

                //The identity column
                MetaData::MODELS_IDENTITY_COLUMN => 'id',

                //How every column must be binded/casted
                MetaData::MODELS_DATA_TYPES_BIND => array(
                    'id' => Column::BIND_PARAM_INT,
                    'name' => Column::BIND_PARAM_STR,
                    'type' => Column::BIND_PARAM_STR,
                    'year' => Column::BIND_PARAM_INT,
                ),

                //Fields that must be ignored from INSERT/UPDATE SQL statements
                MetaData::MODELS_AUTOMATIC_DEFAULT => array('year')

            );
        }

    }

Setting a different schema
--------------------------
Models may are mapped to tables that are in different schemas/databases than the default. You can use the getSchema method to define that:

Then, in the Initialize method, we define the connection service for the model:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function getSchema()
        {
            return "toys";
        }

    }

Setting multiple databases
--------------------------
In Phalcon, all models can belong to the same database connection or have an individual one. Actually, when
:doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` needs to connect to the database it requests the "db" service
in the application's services container. You can overwrite this service setting it in the initialize method:

.. code-block:: php

    <?php

    //This service returns a MySQL database
    $di->set('dbMysql', function() {
         return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname" => "invo"
        ));
    });

    //This service returns a PostgreSQL database
    $di->set('dbPostgres', function() {
         return new \Phalcon\Db\Adapter\Pdo\PostgreSQL(array(
            "host" => "localhost",
            "username" => "postgres",
            "password" => "",
            "dbname" => "invo"
        ));
    });

Then, in the Initialize method, we define the connection service for the model:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function initialize()
        {
            $this->setConnectionService('dbPostgres');
        }

    }

Logging Low-Level SQL Statements
--------------------------------
When using high-level abstraction components such as :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` to access a database, it is
difficult to understand which statements are finally sent to the database system. :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`
is supported internally by :doc:`Phalcon\\Db <../api/Phalcon_Db>`. :doc:`Phalcon\\Logger <../api/Phalcon_Logger>` interacts
with :doc:`Phalcon\\Db <../api/Phalcon_Db>`, providing logging capabilities on the database abstraction layer, thus allowing us to log SQL
statements as they happen.

.. code-block:: php

    <?php

    $di->set('db', function() {

        $eventsManager = new Phalcon\Events\Manager();

        $logger = new Phalcon\Logger\Adapter\File("app/logs/debug.log");

        //Listen all the database events
        $eventsManager->attach('db', function($event, $connection) use ($logger) {
            if ($event->getType() == 'beforeQuery') {
                $logger->log($connection->getSQLStatement(), \Phalcon\Logger::INFO);
            }
        });

        $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname" => "invo"
        ));

        //Assign the eventsManager to the db adapter instance
        $connection->setEventsManager($eventsManager);

        return $connection;
    });

As models access the default database connection, all SQL statements that are sent to the database system will be logged in the file:

.. code-block:: php

    <?php

    $robot = new Robots();
    $robot->name = "Robby the Robot";
    $robot->created_at = "1956-07-21"
    if ($robot->save() == false) {
        echo "Cannot save robot";
    }

As above, the file *app/logs/db.log* will contain something like this:

.. code-block:: irc

    [Mon, 30 Apr 12 13:47:18 -0500][DEBUG][Resource Id #77] INSERT INTO robots
    (name, created_at) VALUES ('Robby the Robot', '1956-07-21')

Profiling SQL Statements
------------------------
Thanks to :doc:`Phalcon\\Db <../api/Phalcon_Db>`, the underlying component of :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>`,
it's possible to profile the SQL statements generated by the ORM in order to analyze the performance of database operations. With
this you can diagnose performance problems and to discover bottlenecks.

.. code-block:: php

    <?php

    $di->set('profiler', function(){
        return new Phalcon\Db\Profiler();
    })

    $di->set('db', function() use($di) {

        $eventsManager = new Phalcon\Events\Manager();

        //Get a shared instance of the DbProfiler
        $profiler = $di->getShared('profiler');

        //Listen all the database events
        $eventsManager->attach('db', function($event, $connection) use ($profiler) {
            if ($event->getType() == 'beforeQuery') {
                $profiler->startProfile($connection->getSQLStatement());
            }
            if ($event->getType() == 'afterQuery') {
                $profiler->stopProfile();
            }
        });

        $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname" => "invo"
        ));

        //Assign the eventsManager to the db adapter instance
        $connection->setEventsManager($eventsManager);

        return $connection;
    });

Profiling some queries:

.. code-block:: php

    <?php

    // Send some SQL statements to the database
    Robots::find();
    Robots::find(array("order" => "name");
    Robots::find(array("limit" => 30);

    //Get the generated profiles from the profiler
    $profiles = $di->getShared('profiler')->getProfiles();

    foreach ($profiles as $profile) {
       echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
       echo "Start Time: ", $profile->getInitialTime(), "\n";
       echo "Final Time: ", $profile->getFinalTime(), "\n";
       echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";
    }

Each generated profile contains the duration in miliseconds that each instruction takes to complete as well as the generated SQL statement.

Injecting services into Models
------------------------------
You may be required to access the application services within a model, the following example explains how to do that:

.. code-block:: php

    <?php

    class Robots extends \Phalcon\Mvc\Model
    {

        public function notSave()
        {
            //Obtain the flash service from the DI container
            $flash = $this->getDI()->getShared('flash');

            //Show validation messages
            foreach($this->getMesages() as $message) {
                $flash->error((string) $message);
            }
        }

    }

The "notSave" event is triggered every time that a "create" or "update" action fails. So we're flashing the validation messages
obtaining the "flash" service from the DI container. By doing this, we don't have to print messages after each save.


.. _Alternative PHP Cache (APC): http://www.php.net/manual/en/book.apc.php
.. _PDO: http://www.php.net/manual/en/pdo.prepared-statements.php
