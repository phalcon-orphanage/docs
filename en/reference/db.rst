Database Abstraction Layer
==========================
:doc:`Phalcon_Db <../api/Phalcon_Db>` is the component behind :doc:`Phalcon_Model <../api/Phalcon_Model_Base>` that powers the model layer in the framework. It consists of an independent high-level abstraction layer for database systems completely written in C. 

This component allows for a lower level database manipulation than using traditional models. 

.. highlights::
    This guide is not intended to be a complete documentation of available methods and their arguments. Please visit the API_ for a complete reference.

Database Adapters
-----------------
This component makes use of adapters to encapsulate specific database system details. The following database engines are supported: 

+------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-----------------------------------------------------------------------------+
| Name       | Description                                                                                                                                                                                                                          | API                                                                         | 
+============+======================================================================================================================================================================================================================================+=============================================================================+
| MySQL      | Is the world's most used relational database management system (RDBMS) that runs as a server providing multi-user access to a number of databases                                                                                    | :doc:`Phalcon_Db_Adapter_Mysql <../api/Phalcon_Db_Adapter_Mysql>`           | 
+------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-----------------------------------------------------------------------------+
| PostgreSQL | PostgreSQL is a powerful, open source relational database system. It has more than 15 years of active development and a proven architecture that has earned it a strong reputation for reliability, data integrity, and correctness. | :doc:`Phalcon_Db_Adapter_Postgresql <../api/Phalcon_Db_Adapter_Postgresql>` | 
+------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-----------------------------------------------------------------------------+

Database Dialects
-----------------
For some database engines, PHP provides several ways to connect to it. From PDO to native drivers, Phalcon encapsulates the specific details of each database engine in dialects. Those provide common functions and SQL generator to the adapters. 

+------------+-----------------------------------------------------+-----------------------------------------------------------------------------+-----------------+
| Name       | Description                                         | API                                                                         | Internal Driver | 
+============+=====================================================+=============================================================================+=================+
| MySQL      | SQL specific dialect for MySQL database system      | :doc:`Phalcon_Db_Dialect_Mysql <../api/Phalcon_Db_Dialect_Mysql>`           | mysqli          | 
+------------+-----------------------------------------------------+-----------------------------------------------------------------------------+-----------------+
| PostgreSQL | SQL specific dialect for PostgreSQL database system | :doc:`Phalcon_Db_Dialect_Postgresql <../api/Phalcon_Db_Dialect_Postgresql>` | pgsql           | 
+------------+-----------------------------------------------------+-----------------------------------------------------------------------------+-----------------+

Connecting to Databases
-----------------------
All the connections created by the component are factored in a single method: Phalcon_Db::factory. Its first parameter is a supported adapter, the second is a standard PHP object with the connection settings, the third parameter tells if a `persistent connection`_ should be created or not. The example below shows how to create a connection passing both required and optional parameters: 

.. code-block:: php

    <?php
    
    // Required
    $config           = new stdClass();
    $config->host     = "127.0.0.1";
    $config->username = "mike";
    $config->password = "sigma";
    $config->name     = "test_db";
    
    // Optional
    $config->persistent  = false;
    $config->charset     = "utf8";
    $config->collation   = "utf8_unicode_ci";
    $config->compression = true;
    
    // Create a connection
    $connection = Phalcon_Db::factory("Mysql", $config, true);

.. code-block:: php

    <?php
    
    // Required
    $config           = new stdClass();
    $config->host     = "localhost";
    $config->username = "postgres";
    $config->password = "secret";
    $config->name     = "template1";
    
    // Optional
    $config->persistent = false;
    $config->charset    = "UNICODE";
    
    // Create a connection
    $connection = Phalcon_Db::factory("Postgresql", $config, true);

Connection Pooling
------------------
To control the creation of database connections through applications, a `connection pool`_ has been implemented in the framework. It caches each connection created to avoid making multiple connections to the same adapter/host/username. 

.. code-block:: php

    <?php
    
    $config = array(
        "adapter"  => "Mysql",
        "host"     => "127.0.0.1",
        "username" => "mike",
        "password" => "sigma",
        "name"     => "test_db"
    );
    
    // Set default connection settings
    Phalcon_Db_Pool::setDefaultDescriptor($config);
    
    // Create a connection
    $connection = Phalcon_Db_Pool::getConnection();
    
    // This is the same as the previous connection
    $connection = Phalcon_Db_Pool::getConnection();
    
    // Passing true as parameter will renew the pooled connection
    $connection2 = Phalcon_Db_Pool::getConnection(true);

Finding Rows
------------
:doc:`Phalcon_Db <../api/Phalcon_Db>` provides several methods to query rows from tables. The specific SQL syntax of the target database engine is required in this case: 

.. code-block:: php

    <?php

    $sql = "SELECT id, name FROM robots ORDER BY name";
    
    // Send a SQL statement to the database system
    $result = $connection->query($sql);
    
    // Print each robot name
    while ($robot = $result->fetchArray()) {
       echo $robot["name"];
    }
    
    // Get all rows in an array
    $robots = $connection->fetchAll($sql);
    foreach ($robots as $robot) {
       echo $robot["name"];
    }
    
    // Get only the first row
    $robot = $connection->fetchOne($sql);

By default these calls create arrays with both associative and numeric indexes. You can change this behavior by using Phalcon_Db_Result::setFetchMode(). This method receives a constant, defining which kind of index is required. 

+----------------------+-----------------------------------------------------------+
| Constant             | Description                                               | 
+======================+===========================================================+
| Phalcon_Db::DB_NUM   | Return an array with numeric indexes                      | 
+----------------------+-----------------------------------------------------------+
| Phalcon_Db::DB_ASSOC | Return an array with associative indexes                  | 
+----------------------+-----------------------------------------------------------+
| Phalcon_Db::DB_BOTH  | Return an array with both associative and numeric indexes | 
+----------------------+-----------------------------------------------------------+

.. code-block:: php

    <?php

    $sql = "SELECT id, name FROM robots ORDER BY name";
    $result = $connection->query($sql);
    
    $result->setFetchMode(Phalcon_Db::DB_NUM);
    while ($robot = $result->fetchArray()) {
       echo $robot[0];
    }

The Phalcon_Db::query() returns a special object depending on the database adapter you're using. In MySQL that object is an instance of :doc:`Phalcon_Db_Result_Mysql <../api/Phalcon_Db_Result_Mysql>`, while for PostgreSQL is an instance of :doc:`Phalcon_Db_Result_Postgresql <../api/Phalcon_Db_Result_Postgresql>`. These objects encapsulate all the functionality related to the returned resultset i.e. traversing, seeking specific records, count etc.

.. code-block:: php

    <?php

    $sql = "SELECT id, name FROM robots";
    $result = $connection->query($sql);
    
    // Traverse the resultset
    while ($robot = $result->fetchArray()) {
       echo $robot["name"];
    }
    
    // Seek to the third row
    $result->seek(2);
    $robot = $result->fetchArray();
    
    // Count the resultset
    echo $result->numRows();


Binding Parameters
------------------
Bound parameters is also supported in :doc:`Phalcon_Db <../api/Phalcon_Db>`. Although there is a minimal performance impact by using bound parameters, you are encouraged to use this methodology so as to eliminate the possibility of your code being subject to SQL injection attacks. Both string and integer placeholders are supported. Binding parameters can simply be achieved as follows: 

.. code-block:: php

    <?php
    
    // Binding with numeric placeholders
    $sql = "SELECT * FROM robots WHERE name = ?1 ORDER BY name";
    $sql = $connection->bindParams($sql, array(1 => "Wall-E"));
    $result = $connection->query($sql);
    
    // Binding with named placeholders
    $sql = "INSERT INTO `robots`(name`, year) VALUES (:name:, :year:)";
    $sql = $connection->bindParams($sql, array("name" => "Astro Boy", "year" => 1952));
    $success = $connection->query($sql);

When using numeric placeholders, you will need to define them as integers i.e. 1 or 2. In this case "1" or "2" are considered strings and not numbers, so the placeholder could not be successfully replaced. With the MySQL adapter strings are automatically escaped using mysqli_real_escape_string_. This function takes into account the connection charset, so its recommended to define the correct charset in the connection parameters or in the MySQL server configuration, as a wrong charset will produce undesired effects when storing or retrieving data. 

Inserting/Updating/Deleting Rows
--------------------------------
To insert, update or delete rows, you can use raw SQL or use the preset functions provided by the class: 

.. code-block:: php

    <?php
    
    // Inserting data with a raw SQL statement
    $sql = "INSERT INTO `robots`(`name`, `year`) VALUES ('Astro Boy', 1952)";
    $success = $connection->query($sql);
    
    // Generating dynamically the necessary SQL
    $success = $connection->insert(
       "robots",
       array("Astro Boy", 1952),
       array("name", "year")
    );
    
    // Updating data with a raw SQL statement
    $sql = "UPDATE `robots` SET `name` = 'Astro boy' WHERE `id` = 101";
    $success = $connection->query($sql);
    
    // Generating dynamically the necessary SQL
    $success = $connection->update(
       "robots",
       array("name")
       array("New Astro Boy"),
       "id = 101"
    );
    
    // Deleting data with a raw SQL statement
    $sql = "DELETE `robots` WHERE `id` = 101";
    $success = $connection->query($sql);
    
    // Generating dynamically the necessary SQL
    $success = $connection->delete("robots", "id = 101");


Profiling SQL Statements
------------------------
:doc:`Phalcon_Db <../api/Phalcon_Db>` includes a profiling component called :doc:`Phalcon_Db_Profiler <../api/Phalcon_Db_Profiler>`, that is used to analyze the performance of database operations so as to diagnose performance problems and discover bottlenecks.

Database profiling is really easy With :doc:`Phalcon_Db_Profiler <../api/Phalcon_Db_Profiler>`:

.. code-block:: php

    <?php
    
    $profiler = new Phalcon_Db_Profiler();
    
    // Set the connection profiler
    $connection->setProfiler($profiler);
    
    $sql = "SELECT buyer_name, quantity, product_name "
         . "FROM buyers "
         . "LEFT JOIN products ON buyers.pid = products.id";
    
    // Execute a SQL statement
    $connection->query($sql);
    
    // Get the last profile in the profiler
    $profile = $profiler->getLastProfile();
    
    echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
    echo "Start Time: ", $profile->getInitialTime(), "\n";
    echo "Final Time: ", $profile->getFinalTime(), "\n";
    echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";

You can also create your own profile class based on :doc:`Phalcon_Db_Profiler <../api/Phalcon_Db_Profiler>` to record real time statistics of the statements sent to the database system: 

.. code-block:: php

    <?php
    
    class DbProfiler extends Phalcon_Db_Profiler 
    {
    
        /**
        * Executed before the SQL statement is sent to the db server
        */
        public function beforeStartProfile(Phalcon_Db_Profiler_Item $profile) 
        {
            echo $profile->getSQLStatement();
        }

        /**
        * Executed after the SQL statement is sent to the db server
        */
        public function afterEndProfile(Phalcon_Db_Profiler_Item $profile)
        {
            echo $profile->getTotalElapsedSeconds();
        }

    }


Logging SQL Statements
----------------------
Using high-level abstraction components such as :doc:`Phalcon_Db <../api/Phalcon_Db>` to access a database, it is difficult to understand which statements are sent to the database system. :doc:`Phalcon_Logger <../api/Phalcon_Logger>` interacts with :doc:`Phalcon_Db <../api/Phalcon_Db>`, providing logging capabilities on the database abstraction layer.

.. code-block:: php

    <?php
    
    $logger = new Phalcon_Logger("File", "app/logs/db.log");
    
    $connection->setLogger($logger);
    
    $connection->insert(
        "products",
        array("Hot pepper", 3.50),
        array("name", "price")
    );

As above, the file *app/logs/db.log* will contain something like this:

.. code-block:: php

    [Sun, 29 Apr 12 22:35:26 -0500][DEBUG][Resource Id #77] INSERT INTO products (name, price) VALUES ('Hot pepper', 3.50)


Implementing your own Logger
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
You can implement your own logger class for database queries, by creating a class that implements a single method called "log". The method needs to accept a string as the first argument. You can then pass your logging object to Phalcon_Db::setLogger(), and from then on any SQL statement executed will call that method to log the results.

Describing Tables and Databases
-------------------------------
:doc:`Phalcon_Db <../api/Phalcon_Db>` also provides methods to retrieve detailed information about tables and databases.

.. code-block:: php

    <?php
    
    // Get tables on the test_db database
    $tables = $connection->listTables("test_db");
    
    // Is there a table robots in the database?
    $exists = $connection->tableExists("robots");
    
    // Get name, data types and special features of robots fields
    $fields = $connection->describeTable("robots");
    foreach ($fields as $field) {
       echo "Column Type: ", $field["Type"];
    }
    
    // Get indexes on the robots table
    $indexes = $connection->describeIndexes("robots");
    foreach ($indexes as $index) {
      print_r($index->getColumns());
    }
    
    // Get foreign keys on the robots table
    $references = $connection->describeReferences("robots");
    foreach ($references as $reference) {
      // Print referenced columns
      print_r($reference->getReferencedColumns());
    }

A table description is very similar to the MySQL describe command, it contains the following information:

+-------+----------------------------------------------------+
| Index | Description                                        | 
+=======+====================================================+
| Field | Field's name                                       | 
+-------+----------------------------------------------------+
| Type  | Column Type                                        | 
+-------+----------------------------------------------------+
| Key   | Is the column part of the primary key or an index? | 
+-------+----------------------------------------------------+
| Null  | Does the column allow null values?                 | 
+-------+----------------------------------------------------+


Creating/Altering/Dropping Tables
---------------------------------
Different database systems (MySQL, Postgresql etc.) offer the ability to create, alter or drop tables with the use of commands such as CREATE, ALTER or DROP. The SQL syntax differs based on which database system is used. :doc:`Phalcon_Db <../api/Phalcon_Db>` offers a unified interface to alter tables, without the need to differentiate the SQL syntax based on the target storage system. 

Creating Tables
^^^^^^^^^^^^^^^

The following example shows how to create a table:

.. code-block:: php

    <?php
    
    use Phalcon_Db_Column as Column;
    
    $connection->createTable(
        "robots", 
        null, 
        array(
           "columns" => array(
                new Column(
                    "id", 
                    array(
                        "type"          => Column::TYPE_INTEGER,
                        "size"          => 10,
                        "notNull"       => true,
                        "autoIncrement" => true,
                    )
                ),
                new Column(
                    "name", 
                    array(
                        "type"    => Column::TYPE_VARCHAR,
                        "size"    => 70,
                        "notNull" => true,
                    )
                ),
                new Column(
                    "year", 
                    array(
                        "type"    => Column::TYPE_INTEGER,
                        "size"    => 11,
                        "notNull" => true,
                    )
                )
            )
        )
    );

Phalcon_Db::createTable() accepts an associative array describing the table. Columns are defined with the class :doc:`Phalcon_Db_Column <../api/Phalcon_Db_Column>`. The table below shows the options available to define a column: 

+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| Option          | Description                                                                                                                                | Optional | 
+=================+============================================================================================================================================+==========+
| "type"          | Column type. Must be a Phalcon_Db_Column constant (see below for a list)                                                                   | No       | 
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "size"          | Some type of columns like VARCHAR or INTEGER may have a specific size                                                                      | Yes      | 
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "scale"         | DECIMAL or NUMBER columns may be have a scale to specify how many decimals should be stored                                                | Yes      | 
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "unsigned"      | INTEGER columns may be signed or unsigned. This option does not apply to other types of columns                                            | Yes      | 
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "notNull"       | Column can store null values?                                                                                                              | Yes      | 
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "autoIncrement" | With this attribute column will filled automatically with an auto-increment integer. Only one column in the table can have this attribute. | Yes      | 
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "first"         | Column must be placed at first position in the column order                                                                                | Yes      | 
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "after"         | Column must be placed after indicated column                                                                                               | Yes      | 
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+

Phalcon_Db supports the following database column types:

* Phalcon_Db_Column::TYPE_INTEGER
* Phalcon_Db_Column::TYPE_DATE
* Phalcon_Db_Column::TYPE_VARCHAR
* Phalcon_Db_Column::TYPE_DECIMAL
* Phalcon_Db_Column::TYPE_DATETIME
* Phalcon_Db_Column::TYPE_CHAR
* Phalcon_Db_Column::TYPE_TEXT

The associative array passed in Phalcon_Db::createTable() can have the possible keys:

+--------------+----------------------------------------------------------------------------------------------------------------------------------------+----------+
| Index        | Description                                                                                                                            | Optional | 
+==============+========================================================================================================================================+==========+
| "columns"    | An array with a set of table columns defined with :doc:`Phalcon_Db_Column <../api/Phalcon_Db_Column>`                                  | No       | 
+--------------+----------------------------------------------------------------------------------------------------------------------------------------+----------+
| "indexes"    | An array with a set of table indexes defined with :doc:`Phalcon_Db_Index <../api/Phalcon_Db_Index>`                                    | Yes      | 
+--------------+----------------------------------------------------------------------------------------------------------------------------------------+----------+
| "references" | An array with a set of table references (foreign keys) defined with :doc:`Phalcon_Db_Reference <../api/Phalcon_Db_Reference>`          | Yes      | 
+--------------+----------------------------------------------------------------------------------------------------------------------------------------+----------+
| "options"    | An array with a set of table creation options. These options often relate to the database system in which the migration was generated. | Yes      | 
+--------------+----------------------------------------------------------------------------------------------------------------------------------------+----------+


Altering Tables
^^^^^^^^^^^^^^^
As your application grows, you might need to alter your database, as part of a refactoring or adding new features. Not all database systems allow to modify existing columns or add columns between two existing ones. :doc:`Phalcon_Db <../api/Phalcon_Db>` is limited by these constraints.

.. code-block:: php

    <?php
    
    use Phalcon_Db_Column as Column;
    
    // Adding a new column
    $connection->addColumn(
        "robots", 
        null, 
        new Column(
            "robot_type", 
            array(
                "type"    => Column::TYPE_VARCHAR,
                "size"    => 32,
                "notNull" => true,
                "after"   => "name",
            )
        )
    );
    
    // Modifying an existing column
    $connection->modifyColumn(
        "robots", 
        null, 
        new Column(
            "name", 
            array(
                "type" => Column::TYPE_VARCHAR,
                "size" => 40,
                "notNull" => true,
            )
        )
    );
    
    // Deleting the column "name"
    $connection->deleteColumn("robots", null, "name");


Dropping Tables
^^^^^^^^^^^^^^^

Examples on dropping tables:

.. code-block:: php

    <?php
    
    // Drop table robot from active database
    $connection->dropTable("robots");
    
    //Drop table robot from database "machines"
    $connection->dropTable("robots", "machines");

.. _API: ../api/index
.. _mysqli_real_escape_string: http://php.net/manual/en/mysqli.real-escape-string.php
.. _persistent connection: http://php.net/manual/en/features.persistent-connections.php
.. _connection pool: http://en.wikipedia.org/wiki/Connection_pool

