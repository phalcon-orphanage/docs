Working with Models
===================
A model represents the information (data) of the application and the rules to manipulate that data. Models are primarily used for managing the rules of interaction with a corresponding database table. In most cases, each table in your database will correspond to one model in your application. The bulk of your applicationâs business logic will be concentrated in the models. is the base for the modelsin a Phalcon application. It provides database independence, basic CRUD functionality, advanced finding capabilities, and the ability to relate models to one another, among other services.

Phalcon_Model avoids the need of having to use SQL statements because it translates dynamically to the respective database engine. Models are intended to work on a database high layer of abstraction.If you need to work with databases at a lower level check out the  component documentation.

Creating Models
---------------
A model is a class that extends from Phalcon_Model_Base. It must be placed in the models directory.A model file must contain a single class; its class name should be in camel case notation: 

.. code-block:: php

    <?php
    
    class Robots extends Phalcon_Model_Base
    {
    
    }

The above example showed us how to implement model "Robots".There isnât much to this file â but note that the class Robots inherits from Phalcon_Model_Base -. Phalcon_Model supplies a great deal of functionality to your models for free, including basic database CRUD (Create, Read, Update, Destroy) operations, data validation, as well as sophisticated search support and the ability to relate multiple models to one another. By default model "Robots" will refer to table "robots". If you want to manually specify another namefor the mapping table, you can use the setSource method: 

.. code-block:: php

    <?php
    
    class Robots extends Phalcon_Model_Base
    {
    
      function initialize(){
         $this->setSource("the_robots");
      }
    
    }

The model Robots now maps to "the_birds" table. The "initialize" method helps us to set up the model with custom behavior.This method is only called once during the request. 

Understanding Record To Objects
-------------------------------
Every instance of a model represents a row in the table. You can easily access record data by reading objects properties.For example, for a table "robots" with the next records: 

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
Phalcon_Model provide you several methods for doing the querying of records. The next examples will show youhow to query one or more records from a model: 

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

Both "find" and "findFirst" can accept an associative array specifying the find options.The following example shows how it works: 

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

The available query options are:

+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+--------------------------------------------------------------+
| Parameter   | Description                                                                                                                                                                                  | Example                                                      | 
+=============+==============================================================================================================================================================================================+==============================================================+
| conditions  | Search conditions for the find operation. Is used to extract only those records that fulfill a specified criterion. By default Phalcon_model assumes the first parameter are the conditions. | "conditions" => "name LIKE 'steve%'"                         | 
+-------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+--------------------------------------------------------------+
| bind        | Bind is used together with options by replacing placeholders, espacing values increasing the security                                                                                        | "bind" => array("status" => "A", "type" => "some-time")      | 
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
^^^^^^^^^^^^^^^^
While "findFirst" returns directly and instance of the called class in case of match some records, "find"method returns a  . This is a special objectthat encapsulates all the resultset functionality like traversing, seek to a specific record, counting, etc. These objects are more powerful than standard arrays. One of its greatest features is that it only have once record in memory at the same time. This greatly helps reduce the amount of memory used by the application when working with large amounts of data. 

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

Note that resultsets can be serialized to store it to a cache or some backend you want. But also note thatthis forces to Phalcon_Model to unroll each row in the resultset into a big array consuming more memory, at least for one moment. 

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
^^^^^^^^^^^^^^^^^^
Binding parameters is also supported in Phalcon_Model. The binding process impact the performance minimallybut reduce the possibility to be attacked using SQL injection techniques. Both string and integer placeholders are supported. Binding parameters can simply be achieved as follows: 

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

When use numeric placeholders define it as integers, by example: 1 or 2.In this case "1" or "2" are considered strings and not numbers, so the placeholder could not be sucessfully replaced. With the MySQL adapter strings are automatically escaped using `mysqli_real_escape_string <http://php.net/manual/en/mysqli.real-escape-string.php>`_ .That function takes into account the connection charset, so its recommended define it in the connection parameters or in the MySQL server configuration. Binding parameters is available for all the query methods (like find and findFirst) alsothe calculations methods (count, sum, average, etc). 

Caching Resultsets
^^^^^^^^^^^^^^^^^^
Access to database systems is often one of the most common bottlenecks that reducesthe performance of web applications. This is because of the complex connection procedures, among other things, that PHP must do in each request to obtain data from a database system. A well known technique to avoid the continuos access to databases is cache the resultsets obtained from the database in an intermediate and less crowded medium. Phalcon_Model is integrated with the componentto provide a fancy syntax caching resultsets. The first step to cache a resulset is define a default cache backend in the model manager: 

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

The above example gives you full control over the cache definition and customization.But it could be very verbose for most cases. If you are using models with  you could setup the cache configuration as part of the bootstrap configuration:

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

This will define the default cache options for all the caches in the application.Moreover, if you are using ini configuration files you need to add the following section to setup the cache settings: 

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

By default, Phalcon_Model will create a unique key to store the resultsetusing a md5 hash of the SQL select statement generated internally. This is very practical because it generate a new key in case of some of the condition's parameters have been changed. If you want to control your own cache keys you could use the "key" parameter as seen above. For automatic generation of MD5 keys, could be useful to retrieve the generated key,you may use it to remove the cached data from the cache bucket: 

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

Automatic keys generated by Phalcon_Model are always prefixed with "phc".This helps you to easily query the cache's items related to Phalcon_Model: 

.. code-block:: php

    <?php
    
    //Set the cache to the models manager
    $cache = Phalcon_Model_Manager::getDefault()->getCache();
    
    //Get keys created by Phalcon_Model
    foreach($cache->queryKeys("phc") as $key){
         echo $key, "\n";
    }

Note that not all resultsets must be cached. Results that change very frequentlyshould not be cached because of the records presented do not represent the reality. By the same way, those with a lot of records should not be cached as this may be counterproductive in terms of performance. Caching could be also applied to resultsets generated using relationships:

.. code-block:: php

    <?php

    //Query some post
    $post = Post::findFirst();
    
    //Get comments related to a post, also cache it
    $comments = $post->getComments(array("cache" => true));
    
    //Get comments related to a post, setting lifetime
    $comments = $post->getComments(array("cache" => true, "lifetime" => 3600));

On the other hand, when you have knowledge that a resultset has been changedyou might require force a cache refresh. This could be done by deleting it using the generated key. 

Relationships between Models
----------------------------
There are four types of multiple relationships: one-on-one, one-to-many, many-to-one and many-to-many.The relationship may be unidirectional or bidirectional, and each can be simple or by a combination of models. Normally the model manager manages foreign key constraints for these relationships, the definition of these helps the reliable data integrity and the easy finding of related records to a model. Through the implementation of relations is possible to access records relating to each record in a uniform way. 

Unidirectional relationships
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Unidirectional relations are those that are generated in relation to one another but not vice versa.Using the methods belongsTo, hasOne or hasMany states that one or more fields refer to equivalents in another model. 

Bidirectional relations
^^^^^^^^^^^^^^^^^^^^^^^
The bidirectional relations build relationships in which each has a complementary and vice versa.

Defining relationships
^^^^^^^^^^^^^^^^^^^^^^
In Phalcon, relationships must be defined in the "initialize" method of a model. There are 3 methods todefine relationships, all of them requires 3 parameters, local fields, referenced model, referenced fields, these methods are: 

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

The model "Robots" has many "RobotsParts". Similar case for model "Parts" that has many "RobotsParts".On the other hand "RobotsParts" belongs to "Robots" and "Parts" models as a one-to-many relation. The models with their relations could be implemented as follows:

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

The first parameter indicates the field of the local model that is making the association;the second indicates the name of the referenced model and the third field name in the referenced field. You could also use arrays to define multiple fields in the relationship. 

Taking advantage of relationships
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
When explicitly define the relationships between models,is easy to find records relating to a previously consulted. 

.. code-block:: php

    <?php
    
    $robot = Robots::findFirst(2);
    foreach ($robot->getRobotsParts() as $robotPart) {
    	echo $robotPart->getParts()->name, "\n";
    }

Phalcon uses the magic method __call to take advantage of relationships in an easier way.If the called method has a "get" prefix Phalcon_Model will return a findFirst/find result. The following example compares the use of magic method and its respective code doing it manually: Prefix "get" is used to find/findFirst related records. You can also use "count" to return an integer valueresult of count the related records: 

.. code-block:: php

    <?php
    
    $robot = Robots::findFirst(2);
    echo "The robot have ", $robot->countRobotsParts(), " parts\n";



Virtual Foreign Keys
^^^^^^^^^^^^^^^^^^^^
By default, relationships does not act like database foreign keys, that is,if you try to insert/update a value not having a valid value on its referenced model, Phalcon will not throw a validation message or anything. You can modify this behavior by adding a fourth parameter when defining a relationship. Let's change the RobotsPart model to use its relationships as foreign keys:

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

If you alter a belongsTo relationship to act as foreign key, it will validatethat values inserted/updated on those fields have a valid value on the referenced model. On the other hand, if a hasMany/hasOne is altered it will validate that records cannot be deleted if that record is used on any referenced model. 

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
Calculations are helpers for the well known functions of database systems such as COUNT, SUM, MAX, MIN or AVG.Phalcon_Model allow to use this functions in an easier way: Count examples:

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

Sumatories examples:

.. code-block:: php

    <?php
    
    //How much are the salaries of all employees?
    $total = Employees::sum(array("column" => "salary"));
    
    //How much are the salaries of all employees in the Sales area?
    $total = Employees::sum(array("column" => "salary", "conditions" => "area='Sales'"));
    
    //Generate a grouping of the salaries of each area
    $group = Employees::sum(array("column" => "salary", "group" => "area"));
    foreach($group as $row){
       echo "The sumatory of salaries of the ", $group->area, " is ", $group->sumatory;
    }
    
    //Generate a grouping of the salaries of each area ordering salaries from higher to lower
    $group = Employees::sum(array("column" => "salary", "group" => "area", "order" => "sumatory DESC"));

Averages examples:

.. code-block:: php

    <?php
    
    //What is the average salary for all employees?
    $average = Employees::average(array("column" => "salary"));
    
    //What is the average salary for the Sales's area employees?
    $average = Employees::average(array("column" => "salary", "conditions" => "area='Sales'"));

Maximum/Minimum examples:

.. code-block:: php

    <?php
    
    //What is the oldest age of all employees?
    $age = Employees::maximum(array("column" => "age"));
    
    //What is the oldest of employees from the Sales area?
    $age = Employees::maximum(array("column" => "age", "conditions" => "area='Sales'"));
    
    //What is the lowest salary of all employees?
    $salary = Employees::minimum(array("column" => "salary"));



Creating Updating/Records
-------------------------
The method Phalcon_Model_Base::save() allows you to create/update records according to whether they already exist in the table associated with a model.The save method is called out internally by create and update methods of Phalcon_Model. For this to work as expected it is necessary to have properly defined a primary key in the entity to determine whether a record should be updated or created. Also the method executes associated validators, virtual foreign keys and events that are defined in the model.

.. code-block:: php

    <?php

    $robot = new Robots();
    $robot->type = "mechanical";
    $robot->name = "Astro Boy";
    $robot->year = 1952;
    if($robot->save() == false){
       echo "Umh, We can't store robots right now: \n";
       foreach ($robot->getMessages() as $message) {
          echo $message, "\n";
       }
    } else {
       echo "Great, a new robot was saved successfully!";
    }



Auto-generated identity columns
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Some models may have identity columns. These columns usually are the primary key of the mapped table.Phalcon_Model can recognize the identity column and will omit it from the internal SQL INSERT, so the database system could generate an auto-generated value for it. 

Validation Messages
^^^^^^^^^^^^^^^^^^^
Phalcon_Model has a message subsystem that allows a flexible way to output or store the validation messages generatedin the insertion/updating processes. Each message consists of an instance of the class Phalcon_Model_Message. The set of messages generated can be gotten with the method getMessages(). Each message provides extended information like the field name that generated the message or the message type:

.. code-block:: php

    <?php

    if ($robot->save() == false) {
       foreach ($robot->getMessages() as $message) {
          echo "Message: ", $message->getMessage();
          echo "Field: ", $message->getField();
          echo "Type: ", $message->getType();
       }
    }

The following types of validation messages can be generated by Phalcon_Model:

+---------------------+------------------------------------------------------------------------------------------------------------------------------------+
| Type                | Description                                                                                                                        | 
+=====================+====================================================================================================================================+
| PresenceOf          | Generated when a field with a not-null attribute on the database is trying to insert/update a null value                           | 
+---------------------+------------------------------------------------------------------------------------------------------------------------------------+
| ConstraintViolation | Generated when a field part of a virtual foreign key is trying to insert/update a value that doesn't exist in the referenced model | 
+---------------------+------------------------------------------------------------------------------------------------------------------------------------+
| InvalidValue        | Generated when a validator failed due to an invalid value                                                                          | 
+---------------------+------------------------------------------------------------------------------------------------------------------------------------+



Validation Events
^^^^^^^^^^^^^^^^^
Models allow you to implement events that will be thrown when performing an insert or update. They help todefine business rules for a certain model. The following are the events supported by Phalcon_Model and their order of execution:

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



Implement a Business Rule
^^^^^^^^^^^^^^^^^^^^^^^^^
When an insert, update or delete is executed, the model verifies if there are any methodswith the names of the events listed in the table above. We recommend that validation methods are declared protected to prevent that business logic implementation are exposed publicly. The following example implements an event that validates the year to update orinsert cannot be smaller than 0: 

.. code-block:: php

    <?php
    
    class Robots extends Phalcon_Model_Base
    {
    
        function beforeSave()
        {
            if ($this->year < 0) {
                echo "Year cannot be smaller than zero!";
                return false;
            }
        }
    
    }

Some events allow returning false as an indication to stop the current operation. If an event doesn't return anything, Phalcon_Model will assume a true value.

Validating Data Integrity
^^^^^^^^^^^^^^^^^^^^^^^^^
Phalcon_Model provides several events to validate data and implement business rules.The special "validation" event allows us to call built-in validators over the record. Phalcon implement a couple of built-in validators that can be used at this stage of validation. The following example shows how to use it: 

.. code-block:: php

    <?php
    
    class Robots extends Phalcon_Model_Base
    {
    
        function validation()
        {
           $this->validate("InclusionIn", array(
              "field" => "type",
              "domain" => array("Mechanical", "Virtual")
           ));
           $this->validate("Uniqueness", array(
              "field" => "name",
              "message" => "The robot name must be unique"
           ));
           if ($this->validationHasFailed() == true) {
              return false;
           }
        }
    
    }

The above example performs a validation using the built-in validator "InclusionIn". It checks the value of the field "type"in a domain list. If the value is not included in the method then will fail returning false. The following built-in validators are available:

+--------------+-----------------------------------------------------------------------------------------------------------------------------------------+---------+
| Name         | Explanation                                                                                                                             | Example | 
+==============+=========================================================================================================================================+=========+
| Email        | Validates that field contains a valid email format                                                                                      | Example | 
+--------------+-----------------------------------------------------------------------------------------------------------------------------------------+---------+
| ExclusionIn  | Validates that a value is not within a list of possible values                                                                          | Example | 
+--------------+-----------------------------------------------------------------------------------------------------------------------------------------+---------+
| InclusionIn  | Validates that a value is within a list of possible values                                                                              | Example | 
+--------------+-----------------------------------------------------------------------------------------------------------------------------------------+---------+
| Numericality | Validates that a field has a numeric format                                                                                             | Example | 
+--------------+-----------------------------------------------------------------------------------------------------------------------------------------+---------+
| Regex        | Validates that the value of a field matches a regular expression                                                                        | Example | 
+--------------+-----------------------------------------------------------------------------------------------------------------------------------------+---------+
| Uniqueness   | Validates that a field or a combination of a set of fields  are not present more than once in the existing records of the related table | Example | 
+--------------+-----------------------------------------------------------------------------------------------------------------------------------------+---------+

In addition to the built-in validatiors, you can define your own validations using model events:

.. code-block:: php

    <?php
    
    class Robots extends Phalcon_Model_Base
    {
    
       function beforeSave()
       {
           if ($this->type == "Old") {
              $message = new Phalcon_Model_Message("Sorry, old robots are not allowed anymore", "type", "MyType");
              $this->appendMessage($message);
              return false;
           }
           return true;
       }
    
    }



Deleting Records
----------------
The method Phalcon_Model_Base::delete allows to delete a record in memory. You can use it as follows:

.. code-block:: php

    <?php

    $robot = Robots::findFirst(11);
    if ($robot != false){
       if ($robot->delete() == false) {
          echo "Sorry, we can't delete the robot right now: \n";
          foreach ($robot->getMessages() as $message) {
             echo $message, "\n";
          }
       } else {
         echo "The robot was deleted successfully!";
       }
    }

Also you can delete many records traversing a resultset by using a foreach:

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

The next events are available to define custom business rules that should to beexecuted when a delete operation is being made. 

+-----------+--------------+---------------------+------------------------------------------+
| Operation | Name         | Can stop operation? | Explanation                              | 
+===========+==============+=====================+==========================================+
| Deleting  | beforeDelete | YES                 | Runs before the delete operation is made | 
+-----------+--------------+---------------------+------------------------------------------+
| Deleting  | afterDelete  | NO                  | Runs after the delete operation was made | 
+-----------+--------------+---------------------+------------------------------------------+


Transactions
------------
When a process performs multiple operations on a database, sometimes is requiredthat each run in a complete and satisfactory way. Data integrity is lost when operations are interrupted and not completed successfully. Transactions in software just try to avoid these situations. Transactions in Phalcon basically let to separate the objects belonging to a transactionso that all operations carried out by them can maintain a consistent state and could be rolled back if required. 

.. code-block:: php

    <?php

    try {
    
     //Request a transaction
     $transaction = Phalcon_Transaction_Manager::get();
    
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
    
    } catch(Phalcon_Transaction_Failed $e) {
     echo "Failed, reason: ", $e->getMessage();
    }

Transactions can be used to delete many records in a consistent way:

.. code-block:: php

    <?php

    try {
    
      //Request a transaction
      $transaction = Phalcon_Transaction_Manager::get();
    
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
    
    } catch(Phalcon_Transaction_Failed $e){
      echo "Failed, reason: ", $e->getMessage();
    }

Transactions are reused no matter from which part of the application is obtained the transaction object.Only when performing a commit or rollback the transaction will generate a new one. 

Models Meta-Data
----------------
To speed up development Phalcon_Model helps you to query fields and constraints from tables relatedto models. In this task,  , plays an important role.A global instance of that class is created to manage and cache table meta-data. Sometimes it is necessary to get those attributes when working with models. You can get a meta-data instanceby this way: 

.. code-block:: php

    <?php

    $robot = new Robots();
    
    //Get Phalcon_Model_Metadata instance
    $metaData = $robot->getManager()->getMetaData();
    
    //Get robots fields names
    $attributes = $metaData->getAttributes($robot);
    print_r($attributes);
    
    //Get robots fields data types
    $dataTypes = $metaData->getDataTypes($robot);
    print_r($dataTypes);



Caching Meta-Data
^^^^^^^^^^^^^^^^^
Once the application is in a production stage, it is not necessary to query the metadata ofthe table from the database system each time you use the table. This could be done caching the meta-data using any of the following adapters: 

+---------+------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+--------------------------------+
| Adapter | Description                                                                                                                                                                                                                                                                                                                                                      | API                            | 
+=========+==================================================================================================================================================================================================================================================================================================================================================================+================================+
| Memory  | This adapter is used by default in Phalcon. The meta-data is cached only during the request. When it finishes, the meta-data are released as part of the normal memory of the request. This adapter is perfect when the application is in development so as to refresh the metadata in each request updating new fields added or modifications to existing ones. | Phalcon_Model_MetaData_Memory  | 
+---------+------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+--------------------------------+
| Session | This adapter stores meta-data in the $_SESSION superglobal. This adapter is recommended only when the application is actually using a few number of models. The meta-data are refreshed everytime a new session starts. This also requires to start the session with session_start before use any of models.                                                     | Phalcon_Model_MetaData_Session | 
+---------+------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+--------------------------------+
| Apc     | The Apc adapter uses the  Alternative PHP Cache (APC) to store the table meta-data. You can specify the lifetime of the data with options. This is the most recommended way to store meta-data when the application is in production stage.                                                                                                                      | Phalcon_Model_MetaData_Apc     | 
+---------+------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+--------------------------------+

If you want to have full control over the meta-data caching process.You could replace the active meta-data manager as follows: 

.. code-block:: php

    <?php

    //Create a meta-data manager with APC
    $metaData = new Phalcon_Model_MetaData("Apc", array(
       "lifetime" => 86400,
       "suffix" => "my-suffix"
    ));
    
    //Replace the active meta-data manager
    Phalcon_Model_Manager::getDefault()->setMetaData($metaData);

If your application is using a ini configuration file togetherwith  , add the following sectionto it: 

.. code-block:: ini

    [models]
    metadata.adapter = "Apc"
    metadata.suffix = "my-suffix"
    metadata.lifetime = 86400

Logging Low-Level SQL Statements
--------------------------------
When we use high-level abstraction components to access databases (like this ORM),we could find difficulties to understand which statements are finally sent to the database system. Phalcon_Model is supported internally on another component called Phalcon_Db that provides logging capabilities to track all the SQL statements sent to the database. 

.. code-block:: php

    <?php

    $robot = new Robots();
    
    $logger = new Phalcon_Logger("File", "app/logs/debug.log");
    
    //Set the logger to the internal connection
    $robot->getConnection()->setLogger($logger);
    
    $robot->name = "Robby the Robot";
    $robot->created_at = "1956-07-21"
    if ($robot->save() == false) {
        echo "Cannot save robot";
    }
    
    $logger->close();

As above, the file *app/logs/debug.log* might contain the following:

.. code-block:: irc

    [Mon, 30 Apr 12 13:47:18 -0500][DEBUG][Resource Id #77] INSERT INTO robots (name, created_at) VALUES ('Robby the Robot', '1956-07-21')

Profiling SQL Statements
------------------------
Thanks to the underlying component Phalcon_Model called ,it's possible to profile the SQL statements generated by the ORM in order to analyze the performance of database operations. With this you can diagnose performance problems and to discover bottlenecks. 

.. code-block:: php

    <?php
    
    //Create a profiler
    $profiler = new Phalcon_Db_Profiler();
    
    //Set the connection profiler
    Phalcon_Db_Pool::getConnection()->setProfiler($profiler);
    
    //Send some SQL statements to the database
    Robots::find();
    Robots::find(array("order" => "name");
    Robots::find(array("limit" => 30);
    
    foreach($profiler->getProfiles() as $profile){
       echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
       echo "Start Time: ", $profile->getInitialTime(), "\n";
       echo "Final Time: ", $profile->getFinalTime(), "\n";
       echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";
    }

Each generated profile contains the duration in miliseconds that takeseach instruction to be completed, and the SQL generated as well. 
