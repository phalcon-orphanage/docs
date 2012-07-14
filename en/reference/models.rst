
Working with Models
===================
A model represents the information (data) of the application and the rules to manipulate that data. Models are primarily used for managing the rules of interaction with a corresponding database table. In most cases, each table in your database will correspond to one model in your application. The bulk of your application’s business logic will be concentrated in the models.

Phalcon_Model is the base for the models in a Phalcon application. It provides database independence, basic CRUD functionality, advanced finding capabilities, and the ability to relate models to one another, among other services. Phalcon_Model avoids the need of having to use SQL statements because it translates dynamically to the respective database engine. 

.. highlights::
   Models are intended to work on a database high layer of abstraction. If you need to work with databases at a lower level check out the Phalcon_Db component documentation. 

Creating Models
---------------
A model is a class that extends from Phalcon_Model_Base. It must be placed in the models directory. A model file must contain a single class; its class name should be in camel case notation:

.. code-block:: php

    <?php

    class Robots extends Phalcon_Model_Base
    {

    }

The above example showed us how to implement model "Robots". There isn’t much to this file – but note that the class Robots inherits from Phalcon_Model_Base -. Phalcon_Model supplies a great deal of functionality to your models for free, including basic database CRUD (Create, Read, Update, Destroy) operations, data validation, as well as sophisticated search support and the ability to relate multiple models to one another.

By default model "Robots" will refer to table "robots". If you want to manually specify another name for the mapping table, you can use the setSource method:

.. code-block:: php

    <?php

    class Robots extends Phalcon_Model_Base
    {

      function initialize(){
         $this->setSource("the_robots");
      }

    }

The model Robots now maps to "the_birds" table. The "initialize" method helps us to set up the model with custom behavior. This method is only called once during the request.
 
Understanding Record To Objects
-------------------------------
Every instance of a model represents a row in the table. You can easily access record data by reading objects properties. For example, for a table "robots" with the next records:    

.. code-block:: sql

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

    //Find record with id=3
    $robot = Robots::findFirst(3);

    //Prints "Terminator"
    echo $robot->name;

Once the record is in memory, you can make modifications to it and then save changes:

.. code-block:: php

    <?php

    $robot = Robots::findFirst(3);
    $robot->name = "RoboCop";
    $robot->save();

As you can see, there is not need of use SQL statements or similar. Phalcon_Model provides high database abstraction for web applications.     

Finding Records
---------------
Phalcon_Model provide you several methods for doing the querying of records. The next examples will show you how to query one or more records from a model: 

.. code-block:: php

    <?php

    //How many robots are there?
    $robots = Robots::find();
    echo "There are ", count($robots), "\n";

    //How many mechanical robots are there?
    $robots = Robots::find("type='mechanical'");
    echo "There are ", count($robots), "\n";

    //Get and print virtual robots ordered by name
    $robots = Robots::find(array("type='virtual'", "order" => "name"));
    foreach ($robots as $robot) {
       echo $robot->name, "\n";
    }

    //Get first 100 virtual robots ordered by name
    $robots = Robots::find(array("type='virtual'", "order" => "name", "limit" => 100));
    foreach ($robots as $robot) {
       echo $robot->name, "\n";
    }

You could also use the findFirst method to get only the first record matching the given conditions: 

.. code-block:: php

    <?php

    //What's the first robot in robots table?
    $robot = Robots::findFirst();
    echo "The robot name is ", $robot->name, "\n";

    //What's the first mechanical robot in robots table?
    $robot = Robots::findFirst("type='mechanical'");
    echo "The first mechanical robot name is ", $robot->name, "\n";

    //Get first virtual robot ordered by name
    $robot = Robots::findFirst(array("type='virtual'", "order" => "name"));
    echo "The first virtual robot name is ", $robot->name, "\n";

Both "find" and "findFirst" may accept an associative array specifying the find options. The following example shows how it works:

.. code-block:: php 

    <?php

    $robot = Robots::findFirst(array(
        "type='virtual'",
        "order" => "name DESC",
        "limit" => 30
    ));

    $robots = Robots::find(array(
       "conditions" => "type=?1",
       "bind" => array(1 => "virtual")
    ));

+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+--------------------------------------------------------------+
| Parameter   | Description                                                                                                                                                                                  | Example                                                      |
+=============+==============================================================================================================================================================================================+==============================================================+
| conditions  | Search conditions for the find operation. Is used to extract only those records that fulfill a specified criterion. By default Phalcon_model assumes the first parameter is the conditions.  | "conditions" => "name LIKE 'steve%'"                         |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+--------------------------------------------------------------+
| bind        | Bind is used together with options by replacing placeholders, espacing values increasing the security                                                                                        | "bind" => array("status" => "A", "type" => "some-time")      |     
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+--------------------------------------------------------------+
| order       | Is used to sort the result-set. Use one or more fields separated by commas.                                                                                                                  | "order" => "name DESC, status"                               |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+--------------------------------------------------------------+
| limit       | Limit the results of the query to results between a certain number range                                                                                                                     | "limit" => 10                                                |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+--------------------------------------------------------------+
| columns     | Specific columns we need to query. Use this ONLY on read-only resultsets.                                                                                                                    | "columns" => "id, name"                                      |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+--------------------------------------------------------------+
| group       | Allows to collect data across multiple records and group the results by one or more columns                                                                                                  | "group" => "name, status"                                    |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+--------------------------------------------------------------+
| for_update  | With this option, Phalcon_Model reads the latest available data, setting exclusive locks on each row it reads                                                                                | "for_update" => true                                         |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+--------------------------------------------------------------+
| shared_lock | With this option, Phalcon_Model reads the latest available data, setting shared locks on each row it reads                                                                                   | "shared_lock" => true                                        |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+--------------------------------------------------------------+
| cache       | Cache the resulset, reducing the continuous access to the relational system                                                                                                                  | "cache" => array("lifetime" => 3600, "key" => "my-find-key") |
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+--------------------------------------------------------------+

Model Resultsets
----------------
While "findFirst" returns directly and instance of the called class in case of match some records, "find" method returns a Phalcon_Model_Resultset. This is a special object that encapsulates all the resultset functionality like traversing, seek to a specific record, counting, etc. These objects are more powerful than standard arrays. One of its greatest features is that it only have once record in memory at the same time. This greatly helps reduce the amount of memory used by the application when working with large amounts of data. 

.. code-block:: php 

    <?php

    //Get all robots
    $robots = Robots::find();

    //Traversing with a foreach
    foreach($robots as $robot){
      echo $robot->name, "\n";
    }

    //Traversing with a while
    $robots->rewind();
    while($robots->valid()){
      $robot = $robots->current();
      echo $robot->name, "\n";
      $robots->next();
    }

    //Count the resultset
    echo count($robots);

    //Alternative way to count the resultset
    echo $robots->count();

    //Move the internal cursor to the third robot
    $robots->seek(2);
    $robot = $robots->current()

    //Access a robot by its position in the resultset
    $robot = $robots[5];

    //Check if there is a record in certain position
    if (isset($robots[3]) {
       $robot = $robots[3];
    }

    //Get the first record in the resultset
    $robot = robots->getFirst();

    //Get the last record
    $robot = robots->getLast();

Note that resultsets can be serialized to store it to a cache or some backend you want. But also note that this forces to Phalcon_Model to unroll each row in the resultset into a big array consuming more memory, at least for one moment. 

.. code-block:: php 

    <?php

    //Query all records from model parts
    $parts = Parts::find();

    //Store the resultset into a file
    file_put_contents("cache.txt", serialize($parts));

    //Get parts from file
    $parts = unserialize(file_get_contents("cache.txt"));

    //Traverse the parts
    foreach ($parts as $part) {
       echo $part->id;
    }

Binding Parameters
------------------
Binding parameters is also supported in Phalcon_Model. The binding process impact the performance minimally but reduce the possibility to be attacked using SQL injection techniques. Both string and integer placeholders are supported. Binding parameters can simply be achieved as follows:

.. code-block:: php

    <?php

    //Query robots binding parameters with string placeholders
    $conditions = "name = :name: AND type = :type:";
    $parameters = array("name" => "Robotina", "type" => "maid");
    $robots = Robots::find(array($conditions, "bind" => $parameters));

    //Query robots binding parameters with integer placeholders
    $conditions = "name = ?1 AND type = ?2";
    $parameters = array(1 => "Robotina", 2 => "maid");
    $robots = Robots::find(array($conditions, "bind" => $parameters));

    //Query robots binding parameters with both string and integer placeholders
    $conditions = "name = :name: AND type = ?1";
    $parameters = array("name" => "Robotina", 1 => "maid");
    $robots = Robots::find(array($conditions, "bind" => $parameters));

When use numeric placeholders define it as integers, by example: 1 or 2. In this case "1" or "2" are considered strings and not numbers, so the placeholder could not be sucessfully replaced.

With the MySQL adapter strings are automatically escaped using mysqli_real_escape_string. That function takes into account the connection charset, so its recommended define it in the connection parameters or in the MySQL server configuration.

Binding parameters is available for all the query methods (like find and findFirst) also the calculations methods (count, sum, average, etc). 

Caching Resultsets
------------------
Access to database systems is often one of the most common bottlenecks that reduces the performance of web applications. This is because of the complex connection procedures, among other things, that PHP must do in each request to obtain data from a database system. A well known technique to avoid the continuos access to databases is cache the resultsets obtained from the database in an intermediate and less crowded medium.

Phalcon_Model is integrated with the Phalcon_Cache component to provide a fancy syntax caching resultsets. The first step to cache a resulset is define a default cache backend in the model manager: 

.. code-block:: php

    <?php

    //Cache data for one day by default
    $frontendOptions = array(
      "lifetime" => 86400
    );

    //Memcached connection settings
    $backendOptions = array(
      "host" => "localhost",
      "port" => "11211"
    );

    //Create a memcached cache
    $cache = Phalcon_Cache::factory("Data", "Memcached", $frontendOptions, $backendOptions);

    //Set the cache to the models manager
    Phalcon_Model_Manager::getDefault()->setCache($cache);

The above example gives you full control over the cache definition and customization. But it could be very verbose for most cases. If you are using models with Phalcon_Controller_Front you could setup the cache configuration as part of the bootstrap configuration: 

.. code-block:: php

    <?php

    $front = Phalcon_Controller_Front::getInstance();

    //Setting up framework config
    $config = new Phalcon_Config(array(
       "database" => array(
          "adapter" => "Mysql",
          "host" => "localhost",
          "username" => "scott",
          "password" => "cheetah",
          "name" => "test_db"
       ),
       "models" => array(
          "cache" => array(
            "adapter" => "File",
            "cacheDir" => "../app/cache/",
            "lifetime" => 3600
          )
       ),
       "phalcon" => array(
          "controllersDir" => "../app/controllers/",
          "modelsDir" => "../app/models/",
          "viewsDir" => "../app/views/"
       )
    ));

    //Set the configuration
    $front->setConfig($config);

This will define the default cache options for all the caches in the application. Moreover, if you are using ini configuration files you need to add the following section to setup the cache settings: 

.. code-block:: ini

    [models]
    cache.adapter = "Memcached"
    cache.host = "localhost"
    cache.port = 11211
    cache.lifetime = 3600

Once the cache setup is properly defined you could cache resultsets as follows: 

.. code-block:: php

    <?php

    //Get products without caching
    $products = Products::find();

    //Just cache the resultset. The cache will expire in 1 hour (3600 seconds)
    $products = Products::find(array("cache" => true));

    //Cache the resultset only for 5 minutes
    $products = Products::find(array("cache" => 300));

    //Cache the resultset with a key pre-defined
    $products = Products::find(array("cache" => array("key" => "my-products-key")));

    //Cache the resultset with a key pre-defined and for 2 minutes
    $products = Products::find(array(
       "cache" => array(
          "key" => "my-products-key",
          "lifetime" => 120
       )
    ));

    //Using a custom cache
    $products = Products::find(array("cache" => $myCache));

By default, Phalcon_Model will create a unique key to store the resultset using a md5 hash of the SQL select statement generated internally. This is very practical because it generate a new key in case of some of the condition's parameters have been changed. If you want to control your own cache keys you could use the "key" parameter as seen above.

For automatic generation of MD5 keys, could be useful to retrieve the generated key, you may use it to remove the cached data from the cache bucket:     

.. code-block:: php

    <?php

    //Cache the resultset using an automatic key
    $products = Products::find(array("cache" => 3600));

    //Get last generated key
    $automaticKey = $products->getCache()->getLastKey();

    //Use resultset as normal
    foreach($products as $product){
      //...
    }

Automatic keys generated by Phalcon_Model are always prefixed with "phc". This helps you to easily query the cache's items related to Phalcon_Model:

.. code-block:: php

    <?php

    //Set the cache to the models manager
    $cache = Phalcon_Model_Manager::getDefault()->getCache();

    //Get keys created by Phalcon_Model
    foreach($cache->queryKeys("phc") as $key){
         echo $key, "\n";
    }

Note that not all resultsets must be cached. Results that change very frequently should not be cached because of the records presented do not represent the reality. By the same way, those with a lot of records should not be cached as this may be counterproductive in terms of performance.

Caching could be also applied to resultsets generated using relationships: 

.. code-block:: php

    <?php

    //Query some post
    $post = Post::findFirst();

    //Get comments related to a post, also cache it
    $comments = $post->getComments(array("cache" => true));

    //Get comments related to a post, setting lifetime
    $comments = $post->getComments(array("cache" => true, "lifetime" => 3600));

On the other hand, when you have knowledge that a resultset has been changed you might require force a cache refresh. This could be done by deleting it using the generated key.

Relationships between Models
----------------------------

There are four types of multiple relationships: one-on-one, one-to-many, many-to-one and many-to-many. The relationship may be unidirectional or bidirectional, and each can be simple or by a combination of models. Normally the model manager manages foreign key constraints for these relationships, the definition of these helps the reliable data integrity and the easy finding of related records to a model. Through the implementation of relations is possible to access records relating to each record in a uniform way.

Unidirectional relationships
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Unidirectional relations are those that are generated in relation to one another but not vice versa. Using the methods belongsTo, hasOne or hasMany states that one or more fields refer to equivalents in another model.

Bidirectional relations
^^^^^^^^^^^^^^^^^^^^^^^
The bidirectional relations build relationships in which each has a complementary and vice versa.

Defining relationships
^^^^^^^^^^^^^^^^^^^^^^
In Phalcon, relationships must be defined in the "initialize" method of a model. There are 3 methods to define relationships, all of them requires 3 parameters, local fields, referenced model, referenced fields, these methods are: 

+-----------+----------------------------+
| Method    | Description                |
+===========+============================+
| hasMany   | Defines a 1-n relationship |
+-----------+----------------------------+
| hasOne    | Defines a 1-1 relationship |
+-----------+----------------------------+
| belongsTo | Defines a n-1 relationship |
+-----------+----------------------------+

The following schema shows 3 tables whose relations will serve us as an example to explain the relationships: 

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

The model "Robots" has many "RobotsParts". Similar case for model "Parts" that has many "RobotsParts". On the other hand "RobotsParts" belongs to "Robots" and "Parts" models as a one-to-many relation.

The models with their relations could be implemented as follows: 

.. code-block:: php

    <?php

    class Robots extends Phalcon_Model_Base
    {

      function initialize()
      {
         $this->hasMany("id", "RobotsParts", "robots_id");
      }

    }

.. code-block:: php    

    <?php

    class Parts extends Phalcon_Model_Base
    {

      function initialize(){
         $this->hasMany("id", "RobotsParts", "parts_id");
      }

    }

.. code-block:: php    

    <?php

    class RobotsParts extends Phalcon_Model_Base
    {

      function initialize(){
         $this->belongsTo("robots_id", "Robots", "id");
         $this->belongsTo("parts_id", "Parts", "id");
      }

    }

The first parameter indicates the field of the local model that is making the association; the second indicates the name of the referenced model and the third field name in the referenced field. You could also use arrays to define multiple fields in the relationship.

Taking advantage of relationships
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
When explicitly define the relationships between models, is easy to find records relating to a previously consulted.

.. code-block:: php

    <?php

    $robot = Robots::findFirst(2);
    foreach ($robot->getRobotsParts() as $robotPart) {
    	echo $robotPart->getParts()->name, "\n";
    }         

Phalcon uses the magic method __call to take advantage of relationships in an easier way. If the called method has a "get" prefix Phalcon_Model will return a findFirst/find result. The following example compares the use of magic method and its respective code doing it manually: 

*With Relations:*

.. code-block:: php

    <?php

    $robot = Robots::findFirst(2);

    //Robots model has a 1-n (hasMany)
    //relationship to RobotsParts then
    $robotsParts = $robot->getRobotsParts();

    //Only parts that match conditions
    $robotsParts = $robot->getRobotsParts("created_at='2012-03-15'");

    $robotPart = RobotsParts::findFirst(1);

    //RobotsParts model has a n-1 (belongsTo)
    //relationship to RobotsParts then
    $robot = $robotPart->getRobots();

*Without Relations:*

.. code-block:: php    

    <?php

    $robot = Robots::findFirst(2);

    //Robots model has a 1-n (hasMany)
    //relationship to RobotsParts then
    $robotsParts = RobotsParts::find("robots_id='".$robot->id."'");

    //Only parts that match conditions
    $robotsParts = RobotsParts::find("robots_id='".$robot->id."' AND created_at='2012-03-15'");

    $robotPart = RobotsParts::findFirst(1);

    //RobotsParts model has a n-1 (belongsTo)
    //relationship to RobotsParts then
    $robot = Robots::findFirst("id='".$robotPart->robots_id."'");

Prefix "get" is used to find/findFirst related records. You can also use "count" to return an integer value result of count the related records:

.. code-block:: php

    <?php

    $robot = Robots::findFirst(2);
    echo "The robot have ", $robot->countRobotsParts(), " parts\n";


Virtual Foreign Keys
--------------------
By default, relationships does not act like database foreign keys, that is, if you try to insert/update a value not having a valid value on its referenced model, Phalcon will not throw a validation message or anything. You can modify this behavior by adding a fourth parameter when defining a relationship.

Let's change the RobotsPart model to use its relationships as foreign keys: 

.. code-block:: php

    <?php

    class RobotsParts extends Phalcon_Model_Base
    {

      function initialize()
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

If you alter a belongsTo relationship to act as foreign key, it will validate that values inserted/updated on those fields have a valid value on the referenced model. On the other hand, if a hasMany/hasOne is altered it will validate that records cannot be deleted if that record is used on any referenced model. 

.. code-block:: php

    <?php

    class Parts extends Phalcon_Model_Base
    {

      function initialize()
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
Calculations are helpers for the well known functions of database systems such as COUNT, SUM, MAX, MIN or AVG. Phalcon_Model allow to use this functions in an easier way:

**Count examples:**

.. code-block:: php

    <?php

    //How many employees are?
    $rowcount = Employees::count();

    //How many different areas are assigned to employees?
    $rowcount = Employees::count(array("distinct" => "area"));

    //How many employees are in the Testing area?
    $rowcount = Employees::count("area='Testing'");

    //Count employees grouping results by their area
    $group = Employees::count(array("group" => "area"));
    foreach($group as $row){
       echo "There are ", $group->rowcount, " in ", $group->area;
    }

    //Count employees grouping by their area and ordering the result by count
    $group = Employees::count(array("group" => "area", "order" => "rowcount"));     