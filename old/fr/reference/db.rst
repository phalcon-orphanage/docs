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

+-----------------------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Class                                                                                   | Description                                                                                                                                                                                                                          |
+=========================================================================================+======================================================================================================================================================================================================================================+
| :doc:`Phalcon\\Db\\Adapter\\Pdo\\Mysql <../api/Phalcon_Db_Adapter_Pdo_Mysql>`           | Is the world's most used relational database management system (RDBMS) that runs as a server providing multi-user access to a number of databases                                                                                    |
+-----------------------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Db\\Adapter\\Pdo\\Postgresql <../api/Phalcon_Db_Adapter_Pdo_Postgresql>` | PostgreSQL is a powerful, open source relational database system. It has more than 15 years of active development and a proven architecture that has earned it a strong reputation for reliability, data integrity, and correctness. |
+-----------------------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Db\\Adapter\\Pdo\\Sqlite <../api/Phalcon_Db_Adapter_Pdo_Sqlite>`         | SQLite is a software library that implements a self-contained, serverless, zero-configuration, transactional SQL database engine                                                                                                     |
+-----------------------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

Implementing your own adapters
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
The :doc:`Phalcon\\Db\\AdapterInterface <../api/Phalcon_Db_AdapterInterface>` interface must be implemented in order to create your own
database adapters or extend the existing ones.

Database Dialects
-----------------
Phalcon encapsulates the specific details of each database engine in dialects. Those provide common functions and SQL generator to the adapters.

+--------------------------------------------------------------------------------+-----------------------------------------------------+
| Class                                                                          | Description                                         |
+================================================================================+=====================================================+
| :doc:`Phalcon\\Db\\Dialect\\Mysql <../api/Phalcon_Db_Dialect_Mysql>`           | SQL specific dialect for MySQL database system      |
+------------------------------------------------------------------+-------------+-----------------------------------------------------+
| :doc:`Phalcon\\Db\\Dialect\\Postgresql <../api/Phalcon_Db_Dialect_Postgresql>` | SQL specific dialect for PostgreSQL database system |
+------------------------------------------------------------------+-------------+-----------------------------------------------------+
| :doc:`Phalcon\\Db\\Dialect\\Sqlite <../api/Phalcon_Db_Dialect_Sqlite>`         | SQL specific dialect for SQLite database system     |
+------------------------------------------------------------------+-------------+-----------------------------------------------------+

Implementing your own dialects
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
The :doc:`Phalcon\\Db\\DialectInterface <../api/Phalcon_Db_DialectInterface>` interface must be implemented in order to create your own database dialects or extend the existing ones.

Connecting to Databases
-----------------------
To create a connection it's necessary instantiate the adapter class. It only requires an array with the connection parameters. The example
below shows how to create a connection passing both required and optional parameters:

.. code-block:: php

    <?php

    // Required
    $config = [
        "host"     => "127.0.0.1",
        "username" => "mike",
        "password" => "sigma",
        "dbname"   => "test_db",
    ];

    // Optional
    $config["persistent"] = false;

    // Create a connection
    $connection = new \Phalcon\Db\Adapter\Pdo\Mysql($config);

.. code-block:: php

    <?php

    // Required
    $config = [
        "host"     => "localhost",
        "username" => "postgres",
        "password" => "secret1",
        "dbname"   => "template",
    ];

    // Optional
    $config["schema"] = "public";

    // Create a connection
    $connection = new \Phalcon\Db\Adapter\Pdo\Postgresql($config);

.. code-block:: php

    <?php

    // Required
    $config = [
        "dbname" => "/path/to/database.db",
    ];

    // Create a connection
    $connection = new \Phalcon\Db\Adapter\Pdo\Sqlite($config);

Setting up additional PDO options
---------------------------------
You can set PDO options at connection time by passing the parameters 'options':

.. code-block:: php

    <?php

    // Create a connection with PDO options
    $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(
        [
            "host"     => "localhost",
            "username" => "root",
            "password" => "sigma",
            "dbname"   => "test_db",
            "options"  => [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
                PDO::ATTR_CASE               => PDO::CASE_LOWER,
            ]
        ]
    );

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

By default these calls create arrays with both associative and numeric indexes. You can change this behavior by using :code:`Phalcon\Db\Result::setFetchMode()`. This method receives a constant, defining which kind of index is required.

+---------------------------------+-----------------------------------------------------------+
| Constant                        | Description                                               |
+=================================+===========================================================+
| :code:`Phalcon\Db::FETCH_NUM`   | Return an array with numeric indexes                      |
+---------------------------------+-----------------------------------------------------------+
| :code:`Phalcon\Db::FETCH_ASSOC` | Return an array with associative indexes                  |
+---------------------------------+-----------------------------------------------------------+
| :code:`Phalcon\Db::FETCH_BOTH`  | Return an array with both associative and numeric indexes |
+---------------------------------+-----------------------------------------------------------+
| :code:`Phalcon\Db::FETCH_OBJ`   | Return an object instead of an array                      |
+---------------------------------+-----------------------------------------------------------+

.. code-block:: php

    <?php

    $sql = "SELECT id, name FROM robots ORDER BY name";
    $result = $connection->query($sql);

    $result->setFetchMode(Phalcon\Db::FETCH_NUM);
    while ($robot = $result->fetch()) {
       echo $robot[0];
    }

The :code:`Phalcon\Db::query()` returns an instance of :doc:`Phalcon\\Db\\Result\\Pdo <../api/Phalcon_Db_Result_Pdo>`. These objects encapsulate all the functionality related to the returned resultset i.e. traversing, seeking specific records, count etc.

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
injection attacks. Both string and positional placeholders are supported. Binding parameters can simply be achieved as follows:

.. code-block:: php

    <?php

    // Binding with numeric placeholders
    $sql    = "SELECT * FROM robots WHERE name = ? ORDER BY name";
    $result = $connection->query(
        $sql,
        [
            "Wall-E",
        ]
    );

    // Binding with named placeholders
    $sql     = "INSERT INTO `robots`(name`, year) VALUES (:name, :year)";
    $success = $connection->query(
        $sql,
        [
            "name" => "Astro Boy",
            "year" => 1952,
        ]
    );

When using numeric placeholders, you will need to define them as integers i.e. 1 or 2. In this case "1" or "2"
are considered strings and not numbers, so the placeholder could not be successfully replaced. With any adapter
data are automatically escaped using `PDO Quote <http://www.php.net/manual/en/pdo.quote.php>`_.

This function takes into account the connection charset, so its recommended to define the correct charset
in the connection parameters or in your database server configuration, as a wrong
charset will produce undesired effects when storing or retrieving data.

Also, you can pass your parameters directly to the execute/query methods. In this case
bound parameters are directly passed to PDO:

.. code-block:: php

    <?php

    // Binding with PDO placeholders
    $sql    = "SELECT * FROM robots WHERE name = ? ORDER BY name";
    $result = $connection->query(
        $sql,
        [
            1 => "Wall-E",
        ]
    );

Inserting/Updating/Deleting Rows
--------------------------------
To insert, update or delete rows, you can use raw SQL or use the preset functions provided by the class:

.. code-block:: php

    <?php

    // Inserting data with a raw SQL statement
    $sql     = "INSERT INTO `robots`(`name`, `year`) VALUES ('Astro Boy', 1952)";
    $success = $connection->execute($sql);

    // With placeholders
    $sql     = "INSERT INTO `robots`(`name`, `year`) VALUES (?, ?)";
    $success = $connection->execute(
        $sql,
        [
            "Astro Boy",
            1952,
        ]
    );

    // Generating dynamically the necessary SQL
    $success = $connection->insert(
        "robots",
        [
            "Astro Boy",
            1952,
        ],
        [
            "name",
            "year",
        ],
    );

    // Generating dynamically the necessary SQL (another syntax)
    $success = $connection->insertAsDict(
        "robots",
        [
            "name" => "Astro Boy",
            "year" => 1952,
        ]
    );

    // Updating data with a raw SQL statement
    $sql     = "UPDATE `robots` SET `name` = 'Astro boy' WHERE `id` = 101";
    $success = $connection->execute($sql);

    // With placeholders
    $sql     = "UPDATE `robots` SET `name` = ? WHERE `id` = ?";
    $success = $connection->execute(
        $sql,
        [
            "Astro Boy",
            101,
        ]
    );

    // Generating dynamically the necessary SQL
    $success = $connection->update(
        "robots",
        [
            "name",
        ],
        [
            "New Astro Boy",
        ],
        "id = 101" // Warning! In this case values are not escaped
    );

    // Generating dynamically the necessary SQL (another syntax)
    $success = $connection->updateAsDict(
        "robots",
        [
            "name" => "New Astro Boy",
        ],
        "id = 101" // Warning! In this case values are not escaped
    );

    // With escaping conditions
    $success = $connection->update(
        "robots",
        [
            "name",
        ],
        [
            "New Astro Boy",
        ],
        [
            "conditions" => "id = ?",
            "bind"       => [101],
            "bindTypes"  => [PDO::PARAM_INT], // Optional parameter
        ]
    );
    $success = $connection->updateAsDict(
        "robots",
        [
            "name" => "New Astro Boy",
        ],
        [
            "conditions" => "id = ?",
            "bind"       => [101],
            "bindTypes"  => [PDO::PARAM_INT], // Optional parameter
        ]
    );

    // Deleting data with a raw SQL statement
    $sql     = "DELETE `robots` WHERE `id` = 101";
    $success = $connection->execute($sql);

    // With placeholders
    $sql     = "DELETE `robots` WHERE `id` = ?";
    $success = $connection->execute($sql, [101]);

    // Generating dynamically the necessary SQL
    $success = $connection->delete(
        "robots",
        "id = ?",
        [
            101,
        ]
    );

Transactions and Nested Transactions
------------------------------------
Working with transactions is supported as it is with PDO. Perform data manipulation inside transactions
often increase the performance on most database systems:

.. code-block:: php

    <?php

    try {
        // Start a transaction
        $connection->begin();

        // Execute some SQL statements
        $connection->execute("DELETE `robots` WHERE `id` = 101");
        $connection->execute("DELETE `robots` WHERE `id` = 102");
        $connection->execute("DELETE `robots` WHERE `id` = 103");

        // Commit if everything goes well
        $connection->commit();
    } catch (Exception $e) {
        // An exception has occurred rollback the transaction
        $connection->rollback();
    }

In addition to standard transactions, :doc:`Phalcon\\Db <../api/Phalcon_Db>` provides built-in support for `nested transactions`_
(if the database system used supports them). When you call begin() for a second time a nested transaction
is created:

.. code-block:: php

    <?php

    try {
        // Start a transaction
        $connection->begin();

        // Execute some SQL statements
        $connection->execute("DELETE `robots` WHERE `id` = 101");

        try {
            // Start a nested transaction
            $connection->begin();

            // Execute these SQL statements into the nested transaction
            $connection->execute("DELETE `robots` WHERE `id` = 102");
            $connection->execute("DELETE `robots` WHERE `id` = 103");

            // Create a save point
            $connection->commit();
        } catch (Exception $e) {
            // An error has occurred, release the nested transaction
            $connection->rollback();
        }

        // Continue, executing more SQL statements
        $connection->execute("DELETE `robots` WHERE `id` = 104");

        // Commit if everything goes well
        $connection->commit();
    } catch (Exception $e) {
        // An exception has occurred rollback the transaction
        $connection->rollback();
    }

Database Events
---------------
:doc:`Phalcon\\Db <../api/Phalcon_Db>` is able to send events to a :doc:`EventsManager <events>` if it's present. Some events when returning boolean false could stop the active operation. The following events are supported:

+---------------------+-----------------------------------------------------------+---------------------+
| Nom d'évt           | Triggered                                                 | Opération stoppée ? |
+=====================+===========================================================+=====================+
| afterConnect        | After a successfully connection to a database system      | Non                 |
+---------------------+-----------------------------------------------------------+---------------------+
| beforeQuery         | Before send a SQL statement to the database system        | Oui                 |
+---------------------+-----------------------------------------------------------+---------------------+
| afterQuery          | After send a SQL statement to database system             | Non                 |
+---------------------+-----------------------------------------------------------+---------------------+
| beforeDisconnect    | Before close a temporal database connection               | Non                 |
+---------------------+-----------------------------------------------------------+---------------------+
| beginTransaction    | Before a transaction is going to be started               | Non                 |
+---------------------+-----------------------------------------------------------+---------------------+
| rollbackTransaction | Before a transaction is rollbacked                        | Non                 |
+---------------------+-----------------------------------------------------------+---------------------+
| commitTransaction   | Before a transaction is committed                         | Non                 |
+---------------------+-----------------------------------------------------------+---------------------+

Bind an EventsManager to a connection is simple, :doc:`Phalcon\\Db <../api/Phalcon_Db>` will trigger the events with the type "db":

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager;
    use Phalcon\Db\Adapter\Pdo\Mysql as Connection;

    $eventsManager = new EventsManager();

    // Listen all the database events
    $eventsManager->attach('db', $dbListener);

    $connection = new Connection(
        [
            "host"     => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname"   => "invo",
        ]
    );

    // Assign the eventsManager to the db adapter instance
    $connection->setEventsManager($eventsManager);

Stop SQL operations are very useful if for example you want to implement some last-resource SQL injector checker:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;

    $eventsManager->attach(
        "db:beforeQuery",
        function (Event $event, $connection) {
            $sql = $connection->getSQLStatement();

            // Check for malicious words in SQL statements
            if (preg_match("/DROP|ALTER/i", $sql)) {
                // DROP/ALTER operations aren't allowed in the application,
                // this must be a SQL injection!
                return false;
            }

            // It's OK
            return true;
        }
    );

Profiling SQL Statements
------------------------
:doc:`Phalcon\\Db <../api/Phalcon_Db>` includes a profiling component called :doc:`Phalcon\\Db\\Profiler <../api/Phalcon_Db_Profiler>`, that is used to analyze the performance of database operations so as to diagnose performance problems and discover bottlenecks.

Database profiling is really easy With :doc:`Phalcon\\Db\\Profiler <../api/Phalcon_Db_Profiler>`:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;
    use Phalcon\Db\Profiler as DbProfiler;

    $eventsManager = new EventsManager();

    $profiler = new DbProfiler();

    // Listen all the database events
    $eventsManager->attach(
        "db",
        function (Event $event, $connection) use ($profiler) {
            if ($event->getType() === "beforeQuery") {
                $sql = $connection->getSQLStatement();

                // Start a profile with the active connection
                $profiler->startProfile($sql);
            }

            if ($event->getType() === "afterQuery") {
                // Stop the active profile
                $profiler->stopProfile();
            }
        }
    );

    // Assign the events manager to the connection
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

    use Phalcon\Events\Manager as EventsManager;
    use Phalcon\Db\Profiler as Profiler;
    use Phalcon\Db\Profiler\Item as Item;

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

    // Create an Events Manager
    $eventsManager = new EventsManager();

    // Create a listener
    $dbProfiler = new DbProfiler();

    // Attach the listener listening for all database events
    $eventsManager->attach("db", $dbProfiler);

Logging SQL Statements
----------------------
Using high-level abstraction components such as :doc:`Phalcon\\Db <../api/Phalcon_Db>` to access a database, it is difficult to understand which statements are sent to the database system. :doc:`Phalcon\\Logger <../api/Phalcon_Logger>` interacts with :doc:`Phalcon\\Db <../api/Phalcon_Db>`, providing logging capabilities on the database abstraction layer.

.. code-block:: php

    <?php

    use Phalcon\Logger;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;
    use Phalcon\Logger\Adapter\File as FileLogger;

    $eventsManager = new EventsManager();

    $logger = new FileLogger("app/logs/db.log");

    $eventsManager->attach(
        "db:beforeQuery",
        function (Event $event, $connection) use ($logger) {
            $sql = $connection->getSQLStatement();

            $logger->log($sql, Logger::INFO);
        }
    );

    // Assign the eventsManager to the db adapter instance
    $connection->setEventsManager($eventsManager);

    // Execute some SQL statement
    $connection->insert(
        "products",
        [
            "Hot pepper",
            3.50,
        ],
        [
            "name",
            "price",
        ]
    );

As above, the file *app/logs/db.log* will contain something like this:

.. code-block:: php

    [Sun, 29 Apr 12 22:35:26 -0500][DEBUG][Resource Id #77] INSERT INTO products
    (name, price) VALUES ('Hot pepper', 3.50)


Implementing your own Logger
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
You can implement your own logger class for database queries, by creating a class that implements a single method called "log".
The method needs to accept a string as the first argument. You can then pass your logging object to :code:`Phalcon\Db::setLogger()`,
and from then on any SQL statement executed will call that method to log the results.

Describing Tables/Views
-----------------------
:doc:`Phalcon\\Db <../api/Phalcon_Db>` also provides methods to retrieve detailed information about tables and views:

.. code-block:: php

    <?php

    // Get tables on the test_db database
    $tables = $connection->listTables("test_db");

    // Is there a table 'robots' in the database?
    $exists = $connection->tableExists("robots");

    // Get name, data types and special features of 'robots' fields
    $fields = $connection->describeColumns("robots");
    foreach ($fields as $field) {
        echo "Column Type: ", $field["Type"];
    }

    // Get indexes on the 'robots' table
    $indexes = $connection->describeIndexes("robots");
    foreach ($indexes as $index) {
        print_r(
            $index->getColumns()
        );
    }

    // Get foreign keys on the 'robots' table
    $references = $connection->describeReferences("robots");
    foreach ($references as $reference) {
        // Print referenced columns
        print_r(
            $reference->getReferencedColumns()
        );
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

Methods to get information about views are also implemented for every supported database system:

.. code-block:: php

    <?php

    // Get views on the test_db database
    $tables = $connection->listViews("test_db");

    // Is there a view 'robots' in the database?
    $exists = $connection->viewExists("robots");

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
        [
           "columns" => [
                new Column(
                    "id",
                    [
                        "type"          => Column::TYPE_INTEGER,
                        "size"          => 10,
                        "notNull"       => true,
                        "autoIncrement" => true,
                        "primary"       => true,
                    ]
                ),
                new Column(
                    "name",
                    [
                        "type"    => Column::TYPE_VARCHAR,
                        "size"    => 70,
                        "notNull" => true,
                    ]
                ),
                new Column(
                    "year",
                    [
                        "type"    => Column::TYPE_INTEGER,
                        "size"    => 11,
                        "notNull" => true,
                    ]
                ),
            ]
        ]
    );

:code:`Phalcon\Db::createTable()` accepts an associative array describing the table. Columns are defined with the class
:doc:`Phalcon\\Db\\Column <../api/Phalcon_Db_Column>`. The table below shows the options available to define a column:

+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| Option          | Description                                                                                                                                | Optional |
+=================+============================================================================================================================================+==========+
| "type"          | Column type. Must be a :doc:`Phalcon\\Db\\Column <../api/Phalcon_Db_Column>` constant (see below for a list)                               | Non      |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "primary"       | True if the column is part of the table's primary key                                                                                      | Oui      |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "size"          | Some type of columns like VARCHAR or INTEGER may have a specific size                                                                      | Oui      |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "scale"         | DECIMAL or NUMBER columns may be have a scale to specify how many decimals should be stored                                                | Oui      |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "unsigned"      | INTEGER columns may be signed or unsigned. This option does not apply to other types of columns                                            | Oui      |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "notNull"       | Column can store null values?                                                                                                              | Oui      |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "default"       | Default value (when used with :code:`"notNull" => true`).                                                                                  | Oui      |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "autoIncrement" | With this attribute column will filled automatically with an auto-increment integer. Only one column in the table can have this attribute. | Oui      |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "bind"          | One of the BIND_TYPE_* constants telling how the column must be binded before save it                                                      | Oui      |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "first"         | Column must be placed at first position in the column order                                                                                | Oui      |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "after"         | Column must be placed after indicated column                                                                                               | Oui      |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+

:doc:`Phalcon\\Db <../api/Phalcon_Db>` supports the following database column types:

* :code:`Phalcon\Db\Column::TYPE_INTEGER`
* :code:`Phalcon\Db\Column::TYPE_DATE`
* :code:`Phalcon\Db\Column::TYPE_VARCHAR`
* :code:`Phalcon\Db\Column::TYPE_DECIMAL`
* :code:`Phalcon\Db\Column::TYPE_DATETIME`
* :code:`Phalcon\Db\Column::TYPE_CHAR`
* :code:`Phalcon\Db\Column::TYPE_TEXT`

The associative array passed in :code:`Phalcon\Db::createTable()` can have the possible keys:

+--------------+----------------------------------------------------------------------------------------------------------------------------------------+----------+
| Index        | Description                                                                                                                            | Optional |
+==============+========================================================================================================================================+==========+
| "columns"    | An array with a set of table columns defined with :doc:`Phalcon\\Db\\Column <../api/Phalcon_Db_Column>`                                | Non      |
+--------------+----------------------------------------------------------------------------------------------------------------------------------------+----------+
| "indexes"    | An array with a set of table indexes defined with :doc:`Phalcon\\Db\\Index <../api/Phalcon_Db_Index>`                                  | Oui      |
+--------------+----------------------------------------------------------------------------------------------------------------------------------------+----------+
| "references" | An array with a set of table references (foreign keys) defined with :doc:`Phalcon\\Db\\Reference <../api/Phalcon_Db_Reference>`        | Oui      |
+--------------+----------------------------------------------------------------------------------------------------------------------------------------+----------+
| "options"    | An array with a set of table creation options. These options often relate to the database system in which the migration was generated. | Oui      |
+--------------+----------------------------------------------------------------------------------------------------------------------------------------+----------+

Altering Tables
^^^^^^^^^^^^^^^
As your application grows, you might need to alter your database, as part of a refactoring or adding new features.
Not all database systems allow to modify existing columns or add columns between two existing ones. :doc:`Phalcon\\Db <../api/Phalcon_Db>`
is limited by these constraints.

.. code-block:: php

    <?php

    use Phalcon\Db\Column as Column;

    // Adding a new column
    $connection->addColumn(
        "robots",
        null,
        new Column(
            "robot_type",
            [
                "type"    => Column::TYPE_VARCHAR,
                "size"    => 32,
                "notNull" => true,
                "after"   => "name",
            ]
        )
    );

    // Modifying an existing column
    $connection->modifyColumn(
        "robots",
        null,
        new Column(
            "name",
            [
                "type"    => Column::TYPE_VARCHAR,
                "size"    => 40,
                "notNull" => true,
            ]
        )
    );

    // Deleting the column "name"
    $connection->dropColumn(
        "robots",
        null,
        "name"
    );

Dropping Tables
^^^^^^^^^^^^^^^
Examples on dropping tables:

.. code-block:: php

    <?php

    // Drop table robot from active database
    $connection->dropTable("robots");

    // Drop table robot from database "machines"
    $connection->dropTable("robots", "machines");

.. _PDO: http://www.php.net/manual/en/book.pdo.php
.. _`nested transactions`: http://en.wikipedia.org/wiki/Nested_transaction
