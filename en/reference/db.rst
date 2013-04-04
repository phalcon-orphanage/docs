Database Abstraction Layer
==========================
:doc:`Phalcon\\Db <../api/Phalcon_Db>` is the component behind :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` that powers the model layer
in the framework. It consists of an independent high-level abstraction layer for database systems completely written in C.

This component allows for a lower level database manipulation than using traditional models.

.. highlights::
    This guide is not intended to be a complete documentation of available methods and their arguments. Please visit the :doc:`API <../api/index>`
    for a complete reference.

Database Adapters
-----------------
This component makes use of adapters to encapsulate specific database system details. Phalcon uses PDO_ to connect to databases. The following
database engines are supported:

+------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-----------------------------------------------------------------------------------------+
| Name       | Description                                                                                                                                                                                                                          | API                                                                                     |
+============+======================================================================================================================================================================================================================================+=========================================================================================+
| MySQL      | Is the world's most used relational database management system (RDBMS) that runs as a server providing multi-user access to a number of databases                                                                                    | :doc:`Phalcon\\Db\\Adapter\\Pdo\\Mysql <../api/Phalcon_Db_Adapter_Pdo_Mysql>`           |
+------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-----------------------------------------------------------------------------------------+
| PostgreSQL | PostgreSQL is a powerful, open source relational database system. It has more than 15 years of active development and a proven architecture that has earned it a strong reputation for reliability, data integrity, and correctness. | :doc:`Phalcon\\Db\\Adapter\\Pdo\\Postgresql <../api/Phalcon_Db_Adapter_Pdo_Postgresql>` |
+------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-----------------------------------------------------------------------------------------+
| SQLite     | SQLite is a software library that implements a self-contained, serverless, zero-configuration, transactional SQL database engine                                                                                                     | :doc:`Phalcon\\Db\\Adapter\\Pdo\\Sqlite <../api/Phalcon_Db_Adapter_Pdo_Sqlite>`         |
+------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-----------------------------------------------------------------------------------------+

Implementing your own adapters
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
The :doc:`Phalcon\\Db\\AdapterInterface <../api/Phalcon_Db_AdapterInterface>` interface must be implemented in order to create your own
database adapters or extend the existing ones.

Database Dialects
-----------------
Phalcon encapsulates the specific details of each database engine in dialects. Those provide common functions and SQL generator to the adapters.

+------------+-----------------------------------------------------+--------------------------------------------------------------------------------+
| Name       | Description                                         | API                                                                            |
+============+=====================================================+================================================================================+
| MySQL      | SQL specific dialect for MySQL database system      | :doc:`Phalcon\\Db\\Dialect\\Mysql <../api/Phalcon_Db_Dialect_Mysql>`           |
+------------+-----------------------------------------------------+--------------------------------------------------------------------------------+
| PostgreSQL | SQL specific dialect for PostgreSQL database system | :doc:`Phalcon\\Db\\Dialect\\Postgresql <../api/Phalcon_Db_Dialect_Postgresql>` |
+------------+-----------------------------------------------------+--------------------------------------------------------------------------------+
| SQLite     | SQL specific dialect for SQLite database system     | :doc:`Phalcon\\Db\\Dialect\\Sqlite <../api/Phalcon_Db_Dialect_Sqlite>`         |
+------------+-----------------------------------------------------+--------------------------------------------------------------------------------+

Connecting to Databases
-----------------------
To create a connection it's neccesary instantiate the adapter class. It only requires an array with the connection parameters. The example
below shows how to create a connection passing both required and optional parameters:

Implementing your own dialects
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
The :doc:`Phalcon\\Db\\DialectInterface <../api/Phalcon_Db_DialectInterface>` interface must be implemented in order to create your own database dialects or extend the existing ones.

.. code-block:: php

    <?php

    // Required
    $config = array(
        "host" => "127.0.0.1",
        "username" => "mike",
        "password" => "sigma",
        "dbname" => "test_db"
    );

    // Optional
    $config["persistent"] = false;

    // Create a connection
    $connection = new \Phalcon\Db\Adapter\Pdo\Mysql($config);

.. code-block:: php

    <?php

    // Required
    $config = array(
        "host" => "localhost",
        "username" => "postgres",
        "password" => "secret1",
        "dbname" => "template"
    );

    // Optional
    $config["schema"] = "public";

    // Create a connection
    $connection = new \Phalcon\Db\Adapter\Pdo\Postgresql($config);

.. code-block:: php

    <?php

    // Required
    $config = array(
        "dbname" => "/path/to/database.db"
    );

    // Create a connection
    $connection = new \Phalcon\Db\Adapter\Pdo\Sqlite($config);

Finding Rows
------------
:doc:`Phalcon\\Db <../api/Phalcon_Db>` provides several methods to query rows from tables. The specific SQL syntax of the target database engine is required in this case:

.. code-block:: php

    <?php

    $sql = "SELECT id, name FROM robots ORDER BY name";

    // Send a SQL statement to the database system
    $result = $connection->query($sql);

    // Print each robot name
    while ($robot = $result->fetch()) {
       echo $robot["name"];
    }

    // Get all rows in an array
    $robots = $connection->fetchAll($sql);
    foreach ($robots as $robot) {
       echo $robot["name"];
    }

    // Get only the first row
    $robot = $connection->fetchOne($sql);

By default these calls create arrays with both associative and numeric indexes. You can change this behavior by using Phalcon\\Db\\Result::setFetchMode(). This method receives a constant, defining which kind of index is required.

+--------------------------+-----------------------------------------------------------+
| Constant                 | Description                                               |
+==========================+===========================================================+
| Phalcon\\Db::FETCH_NUM   | Return an array with numeric indexes                      |
+--------------------------+-----------------------------------------------------------+
| Phalcon\\Db::FETCH_ASSOC | Return an array with associative indexes                  |
+--------------------------+-----------------------------------------------------------+
| Phalcon\\Db::FETCH_BOTH  | Return an array with both associative and numeric indexes |
+--------------------------+-----------------------------------------------------------+
| Phalcon\\Db::FETCH_OBJ   | Return an object instead of an array                      |
+--------------------------+-----------------------------------------------------------+

.. code-block:: php

    <?php

    $sql = "SELECT id, name FROM robots ORDER BY name";
    $result = $connection->query($sql);

    $result->setFetchMode(Phalcon\Db::DB_NUM);
    while ($robot = $result->fetch()) {
       echo $robot[0];
    }

The Phalcon\\Db::query() returns an instance of :doc:`Phalcon\\Db\\Result\\Pdo <../api/Phalcon_Db_Result_Pdo>`. These objects encapsulate all the functionality related to the returned resultset i.e. traversing, seeking specific records, count etc.

.. code-block:: php

    <?php

    $sql = "SELECT id, name FROM robots";
    $result = $connection->query($sql);

    // Traverse the resultset
    while ($robot = $result->fetch()) {
       echo $robot["name"];
    }

    // Seek to the third row
    $result->seek(2);
    $robot = $result->fetch();

    // Count the resultset
    echo $result->numRows();

Binding Parameters
------------------
Bound parameters is also supported in :doc:`Phalcon\\Db <../api/Phalcon_Db>`. Although there is a minimal performance impact by using
bound parameters, you are encouraged to use this methodology so as to eliminate the possibility of your code being subject to SQL
injection attacks. Both string and integer placeholders are supported. Binding parameters can simply be achieved as follows:

.. code-block:: php

    <?php

    // Binding with numeric placeholders
    $sql    = "SELECT * FROM robots WHERE name = ?1 ORDER BY name";
    $sql    = $connection->bindParams($sql, array(1 => "Wall-E"));
    $result = $connection->query($sql);

    // Binding with named placeholders
    $sql     = "INSERT INTO `robots`(name`, year) VALUES (:name:, :year:)";
    $sql     = $connection->bindParams($sql, array("name" => "Astro Boy", "year" => 1952));
    $success = $connection->query($sql);

When using numeric placeholders, you will need to define them as integers i.e. 1 or 2. In this case "1" or "2"
are considered strings and not numbers, so the placeholder could not be successfully replaced. With any adapter
data are automatically escaped using `PDO Quote <http://www.php.net/manual/en/pdo.quote.php>`_.

This function takes into account the connection charset, so its recommended to define the correct charset
in the connection parameters or in your database server configuration, as a wrong
charset will produce undesired effects when storing or retrieving data.

Also, you can pass your parameterers directly to the execute/query methods. In this case
bound parameters are directly passed to PDO:

.. code-block:: php

    <?php

    // Binding with PDO placeholders
    $sql    = "SELECT * FROM robots WHERE name = ? ORDER BY name";
    $result = $connection->query($sql, array(1 => "Wall-E"));


Inserting/Updating/Deleting Rows
--------------------------------
To insert, update or delete rows, you can use raw SQL or use the preset functions provided by the class:

.. code-block:: php

    <?php

    // Inserting data with a raw SQL statement
    $sql     = "INSERT INTO `robots`(`name`, `year`) VALUES ('Astro Boy', 1952)";
    $success = $connection->execute($sql);

    //With placeholders
    $sql     = "INSERT INTO `robots`(`name`, `year`) VALUES (?, ?)";
    $success = $connection->execute($sql, array('Astroy Boy', 1952));

    // Generating dynamically the necessary SQL
    $success = $connection->insert(
       "robots",
       array("Astro Boy", 1952),
       array("name", "year")
    );

    // Updating data with a raw SQL statement
    $sql     = "UPDATE `robots` SET `name` = 'Astro boy' WHERE `id` = 101";
    $success = $connection->execute($sql);

    //With placeholders
    $sql     = "UPDATE `robots` SET `name` = ? WHERE `id` = ?";
    $success = $connection->execute($sql, array('Astroy Boy', 101));

    // Generating dynamically the necessary SQL
    $success = $connection->update(
       "robots",
       array("name")
       array("New Astro Boy"),
       "id = 101"
    );

    // Deleting data with a raw SQL statement
    $sql     = "DELETE `robots` WHERE `id` = 101";
    $success = $connection->execute($sql);

    //With placeholders
    $sql     = "DELETE `robots` WHERE `id` = ?";
    $success = $connection->execute($sql, array(101));

    // Generating dynamically the necessary SQL
    $success = $connection->delete("robots", "id = 101");

Database Events
---------------
:doc:`Phalcon\\Db <../api/Phalcon_Db>` is able to send events to a :doc:`EventsManager <events>` if it's present. Some events when returning boolean false could stop the active operation. The following events are supported:

+---------------------+-----------------------------------------------------------+---------------------+
| Event Name          | Triggered                                                 | Can stop operation? |
+=====================+===========================================================+=====================+
| afterConnect        | After a successfully connection to a database system      | No                  |
+---------------------+-----------------------------------------------------------+---------------------+
| beforeQuery         | Before send a SQL statement to the database system        | Yes                 |
+---------------------+-----------------------------------------------------------+---------------------+
| afterQuery          | After send a SQL statement to database system             | No                  |
+---------------------+-----------------------------------------------------------+---------------------+
| beforeDisconnect    | Before close a temporal database connection               | No                  |
+---------------------+-----------------------------------------------------------+---------------------+
| beginTransaction    | Before a transaction is going to be started               | No                  |
+---------------------+-----------------------------------------------------------+---------------------+
| rollbackTransaction | Before a transaction in the transaction                   | No                  |
+---------------------+-----------------------------------------------------------+---------------------+
| commitTransaction   | Before a transaction the transaction is commite           | No                  |
+---------------------+------------------------------------------------------------+--------------------+

Bind an EventsManager to a connection is simple, Phalcon\\Db will trigger the events with the type "db":

.. code-block:: php

    <?php

    $eventsManager = new Phalcon\Events\Manager();

    //Listen all the database events
    $eventsManager->attach('db', $dbListener);

    $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
        "host" => "localhost",
        "username" => "root",
        "password" => "secret",
        "dbname" => "invo"
    ));

    //Assign the eventsManager to the db adapter instance
    $connection->setEventsManager($eventsManager);

Profiling SQL Statements
------------------------
:doc:`Phalcon\\Db <../api/Phalcon_Db>` includes a profiling component called :doc:`Phalcon\\Db\\Profiler <../api/Phalcon_Db_Profiler>`, that is used to analyze the performance of database operations so as to diagnose performance problems and discover bottlenecks.

Database profiling is really easy With :doc:`Phalcon\\Db\\Profiler <../api/Phalcon_Db_Profiler>`:

.. code-block:: php

    <?php

    $eventsManager = new \Phalcon\Events\Manager();

    $profiler = new \Phalcon\Db\Profiler();

    //Listen all the database events
    $eventsManager->attach('db', function($event, $connection) use ($profiler) {
        if ($event->getType() == 'beforeQuery') {
            //Start a profile with the active connection
            $profiler->startProfile($connection->getSQLStatement());
        }
        if ($event->getType() == 'afterQuery') {
            //Stop the active profile
            $profiler->stopProfile();
        }
    });

    //Assign the events manager to the connection
    $connection->setEventsManager($eventsManager);

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

You can also create your own profile class based on :doc:`Phalcon\\Db\\Profiler <../api/Phalcon_Db_Profiler>` to record real time statistics of the statements sent to the database system:

.. code-block:: php

    <?php

    use \Phalcon\Db\Profiler as Profiler;
    use \Phalcon\Db\Profiler\Item as Item;

    class DbProfiler extends Profiler
    {

        /**
         * Executed before the SQL statement will sent to the db server
         */
        public function beforeStartProfile(Item $profile)
        {
            echo $profile->getSQLStatement();
        }

        /**
         * Executed after the SQL statement was sent to the db server
         */
        public function afterEndProfile(Item $profile)
        {
            echo $profile->getTotalElapsedSeconds();
        }

    }

    //Create an EventsManager
    $eventsManager = new Phalcon\Events\Manager();

    //Create a listener
    $dbProfiler = new DbProfiler();

    //Attach the listener listening for all database events
    $eventsManager->attach('db', $dbProfiler);


Logging SQL Statements
----------------------
Using high-level abstraction components such as :doc:`Phalcon\\Db <../api/Phalcon_Db>` to access a database, it is difficult to understand which statements are sent to the database system. :doc:`Phalcon\\Logger <../api/Phalcon_Logger>` interacts with :doc:`Phalcon\\Db <../api/Phalcon_Db>`, providing logging capabilities on the database abstraction layer.

.. code-block:: php

    <?php

    $eventsManager = new Phalcon\Events\Manager();

    $logger = new \Phalcon\Logger\Adapter\File("app/logs/db.log");

    //Listen all the database events
    $eventsManager->attach('db', function($event, $connection) use ($logger) {
        if ($event->getType() == 'beforeQuery') {
            $logger->log($connection->getSQLStatement(), \Phalcon\Logger::INFO);
        }
    });

    //Assign the eventsManager to the db adapter instance
    $connection->setEventsManager($eventsManager);

    //Execute some SQL statement
    $connection->insert(
        "products",
        array("Hot pepper", 3.50),
        array("name", "price")
    );

As above, the file *app/logs/db.log* will contain something like this:

.. code-block:: php

    [Sun, 29 Apr 12 22:35:26 -0500][DEBUG][Resource Id #77] INSERT INTO products
    (name, price) VALUES ('Hot pepper', 3.50)


Implementing your own Logger
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
You can implement your own logger class for database queries, by creating a class that implements a single method called "log".
The method needs to accept a string as the first argument. You can then pass your logging object to Phalcon\\Db::setLogger(),
and from then on any SQL statement executed will call that method to log the results.

Describing Tables and Databases
-------------------------------
:doc:`Phalcon\\Db <../api/Phalcon_Db>` also provides methods to retrieve detailed information about tables and databases.

.. code-block:: php

    <?php

    // Get tables on the test_db database
    $tables = $connection->listTables("test_db");

    // Is there a table robots in the database?
    $exists = $connection->tableExists("robots");

    // Get name, data types and special features of robots fields
    $fields = $connection->describeColumns("robots");
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
Different database systems (MySQL, Postgresql etc.) offer the ability to create, alter or drop tables with the use of
commands such as CREATE, ALTER or DROP. The SQL syntax differs based on which database system is used.
:doc:`Phalcon\\Db <../api/Phalcon_Db>` offers a unified interface to alter tables, without the need to
differentiate the SQL syntax based on the target storage system.

Creating Tables
^^^^^^^^^^^^^^^

The following example shows how to create a table:

.. code-block:: php

    <?php

    use \Phalcon\Db\Column as Column;

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

Phalcon\\Db::createTable() accepts an associative array describing the table. Columns are defined with the class
:doc:`Phalcon\\Db\\Column <../api/Phalcon_Db_Column>`. The table below shows the options available to define a column:

+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| Option          | Description                                                                                                                                | Optional |
+=================+============================================================================================================================================+==========+
| "type"          | Column type. Must be a Phalcon\\Db\\Column constant (see below for a list)                                                                 | No       |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "primary"       | True if the table is part of the table's primary key                                                                                       | Yes      |
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
| "bind"          | One of the BIND_TYPE_* constants telling how the column must be binded before save it                                                      | Yes      |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "first"         | Column must be placed at first position in the column order                                                                                | Yes      |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "after"         | Column must be placed after indicated column                                                                                               | Yes      |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+

Phalcon\\Db supports the following database column types:

* Phalcon\\Db\Column::TYPE_INTEGER
* Phalcon\\Db\Column::TYPE_DATE
* Phalcon\\Db\\Column::TYPE_VARCHAR
* Phalcon\\Db\\Column::TYPE_DECIMAL
* Phalcon\\Db\\Column::TYPE_DATETIME
* Phalcon\\Db\\Column::TYPE_CHAR
* Phalcon\\Db\\Column::TYPE_TEXT

The associative array passed in Phalcon\\Db::createTable() can have the possible keys:

+--------------+----------------------------------------------------------------------------------------------------------------------------------------+----------+
| Index        | Description                                                                                                                            | Optional |
+==============+========================================================================================================================================+==========+
| "columns"    | An array with a set of table columns defined with :doc:`Phalcon\\Db\\Column <../api/Phalcon_Db_Column>`                                | No       |
+--------------+----------------------------------------------------------------------------------------------------------------------------------------+----------+
| "indexes"    | An array with a set of table indexes defined with :doc:`Phalcon\\Db\\Index <../api/Phalcon_Db_Index>`                                  | Yes      |
+--------------+----------------------------------------------------------------------------------------------------------------------------------------+----------+
| "references" | An array with a set of table references (foreign keys) defined with :doc:`Phalcon\\Db\\Reference <../api/Phalcon_Db_Reference>`        | Yes      |
+--------------+----------------------------------------------------------------------------------------------------------------------------------------+----------+
| "options"    | An array with a set of table creation options. These options often relate to the database system in which the migration was generated. | Yes      |
+--------------+----------------------------------------------------------------------------------------------------------------------------------------+----------+

Altering Tables
^^^^^^^^^^^^^^^
As your application grows, you might need to alter your database, as part of a refactoring or adding new features.
Not all database systems allow to modify existing columns or add columns between two existing ones. :doc:`Phalcon\\Db <../api/Phalcon_Db>`
is limited by these constraints.

.. code-block:: php

    <?php

    use \Phalcon\Db\Column as Column;

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

.. _PDO: http://www.php.net/manual/en/book.pdo.php
