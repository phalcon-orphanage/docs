%{db_9aa0bb0b13e498761331dad3fb71c147}%
==========================
%{db_c56879b8ed347ed1ba9bd4090926fe2a}%

%{db_57a3a9bee3091b994011058761abea1e}%

.. highlights::
    This guide is not intended to be a complete documentation of available methods and their arguments. Please visit the :doc:`API <../api/index>`
    for a complete reference.


%{db_16b634f6806e7bef1eb15a9c2d7e5fef}%
-----------------
%{db_7152b235e4d2ec36da8551669390c6f5}%

+------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-----------------------------------------------------------------------------------------+
| Name       | Description                                                                                                                                                                                                                          | API                                                                                     |
+============+======================================================================================================================================================================================================================================+=========================================================================================+
| MySQL      | Is the world's most used relational database management system (RDBMS) that runs as a server providing multi-user access to a number of databases                                                                                    | :doc:`Phalcon\\Db\\Adapter\\Pdo\\Mysql <../api/Phalcon_Db_Adapter_Pdo_Mysql>`           |
+------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-----------------------------------------------------------------------------------------+
| PostgreSQL | PostgreSQL is a powerful, open source relational database system. It has more than 15 years of active development and a proven architecture that has earned it a strong reputation for reliability, data integrity, and correctness. | :doc:`Phalcon\\Db\\Adapter\\Pdo\\Postgresql <../api/Phalcon_Db_Adapter_Pdo_Postgresql>` |
+------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-----------------------------------------------------------------------------------------+
| SQLite     | SQLite is a software library that implements a self-contained, serverless, zero-configuration, transactional SQL database engine                                                                                                     | :doc:`Phalcon\\Db\\Adapter\\Pdo\\Sqlite <../api/Phalcon_Db_Adapter_Pdo_Sqlite>`         |
+------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-----------------------------------------------------------------------------------------+
| Oracle     | Oracle is an object-relational database management system produced and marketed by Oracle Corporation.                                                                                                                               | :doc:`Phalcon\\Db\\Adapter\\Pdo\\Oracle <../api/Phalcon_Db_Adapter_Pdo_Oracle>`         |
+------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-----------------------------------------------------------------------------------------+

%{db_206bd6266ccc781d8844f3db2de5d557}%
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{db_cd9e7a9ee60d9ba1a2514d90d735c5e2}%

%{db_1c404351c1ded3af7104b1367eca2298}%
-----------------
%{db_e39afb69212957a158e65726002b28ea}%

+------------+-----------------------------------------------------+--------------------------------------------------------------------------------+
| Name       | Description                                         | API                                                                            |
+============+=====================================================+================================================================================+
| MySQL      | SQL specific dialect for MySQL database system      | :doc:`Phalcon\\Db\\Dialect\\Mysql <../api/Phalcon_Db_Dialect_Mysql>`           |
+------------+-----------------------------------------------------+--------------------------------------------------------------------------------+
| PostgreSQL | SQL specific dialect for PostgreSQL database system | :doc:`Phalcon\\Db\\Dialect\\Postgresql <../api/Phalcon_Db_Dialect_Postgresql>` |
+------------+-----------------------------------------------------+--------------------------------------------------------------------------------+
| SQLite     | SQL specific dialect for SQLite database system     | :doc:`Phalcon\\Db\\Dialect\\Sqlite <../api/Phalcon_Db_Dialect_Sqlite>`         |
+------------+-----------------------------------------------------+--------------------------------------------------------------------------------+
| Oracle     | SQL specific dialect for Oracle database system     | :doc:`Phalcon\\Db\\Dialect\\Oracle <../api/Phalcon_Db_Dialect_Oracle>`         |
+------------+-----------------------------------------------------+--------------------------------------------------------------------------------+

%{db_4cab8540827f652e67fdeca3664ad02d}%
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{db_4c59c53a42f9ff7526ba048854fd8666}%

%{db_1e84f34a1540652f1d97e6e1b494eaba}%
-----------------------
%{db_324740fa028cb8a427a50099a1748b93}%

.. code-block:: php

    <?php

    // {%db_b651efdb98a5d6bd2b3935d0c3f4a5e2%}
    $config = array(
        "host" => "127.0.0.1",
        "username" => "mike",
        "password" => "sigma",
        "dbname" => "test_db"
    );

    // {%db_ebb061953c0454b2c8ee7b0ac615ebcd%}
    $config["persistent"] = false;

    // {%db_90a4e8d1f7195a0627f7cb0d3e84e07d%}
    $connection = new \Phalcon\Db\Adapter\Pdo\Mysql($config);

.. code-block:: php

    <?php

    // {%db_b651efdb98a5d6bd2b3935d0c3f4a5e2%}
    $config = array(
        "host" => "localhost",
        "username" => "postgres",
        "password" => "secret1",
        "dbname" => "template"
    );

    // {%db_ebb061953c0454b2c8ee7b0ac615ebcd%}
    $config["schema"] = "public";

    // {%db_90a4e8d1f7195a0627f7cb0d3e84e07d%}
    $connection = new \Phalcon\Db\Adapter\Pdo\Postgresql($config);

.. code-block:: php

    <?php

    // {%db_b651efdb98a5d6bd2b3935d0c3f4a5e2%}
    $config = array(
        "dbname" => "/path/to/database.db"
    );

    // {%db_90a4e8d1f7195a0627f7cb0d3e84e07d%}
    $connection = new \Phalcon\Db\Adapter\Pdo\Sqlite($config);

.. code-block:: php

    <?php

    // {%db_416206518e27ed2ec8b8e0876078af35%}
    $config = array(
        'username' => 'scott',
        'password' => 'tiger',
        'dbname' => '192.168.10.145/orcl',
    );

    // {%db_119dd5a342e981b13bf0024d5c6a6933%}
    $config = array(
        'dbname' => '(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(HOST=localhost)(PORT=1521)))(CONNECT_DATA=(SERVICE_NAME=xe)(FAILOVER_MODE=(TYPE=SELECT)(METHOD=BASIC)(RETRIES=20)(DELAY=5))))',
        'username' => 'scott',
        'password' => 'tiger',
        'charset' => 'AL32UTF8',
    );

    // {%db_90a4e8d1f7195a0627f7cb0d3e84e07d%}
    $connection = new \Phalcon\Db\Adapter\Pdo\Oracle($config);

%{db_85263fa8f55a37fb6480fae562eb5aea}%
---------------------------------
%{db_9e0763da7d3608a50dff7cd06c825ea1}%

.. code-block:: php

    <?php

    // {%db_9f33abf7dcaa4e905ce41ecacf2c7a29%}
    $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
        "host" => "localhost",
        "username" => "root",
        "password" => "sigma",
        "dbname" => "test_db",
        "options" => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES \'UTF8\'",
            PDO::ATTR_CASE => PDO::CASE_LOWER
        )
    ));

%{db_9e5e34140a91e9ba6f06e56f6ed231fc}%
------------
%{db_bf772b6dc335f562852b638549526151}%

.. code-block:: php

    <?php

    $sql = "SELECT id, name FROM robots ORDER BY name";

    // {%db_7c889393a45250b4a18cc765867592a2%}
    $result = $connection->query($sql);

    // {%db_e7a99d8dacb8802c4ac0d05fa390d4e6%}
    while ($robot = $result->fetch()) {
       echo $robot["name"];
    }

    // {%db_171109a2bee03ae4b02ac4e497ad9f0f%}
    $robots = $connection->fetchAll($sql);
    foreach ($robots as $robot) {
       echo $robot["name"];
    }

    // {%db_37eda58e4837344d3c8d9df286369018%}
    $robot = $connection->fetchOne($sql);

%{db_606a77912ac91d380adb17023e52c0b5}%

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

    $result->setFetchMode(Phalcon\Db::FETCH_NUM);
    while ($robot = $result->fetch()) {
       echo $robot[0];
    }

%{db_7c13e5e14c2516b4682395562588620f}%

.. code-block:: php

    <?php

    $sql = "SELECT id, name FROM robots";
    $result = $connection->query($sql);

    // {%db_7163cbb0d7cbeb83bc60daf2a5d87930%}
    while ($robot = $result->fetch()) {
       echo $robot["name"];
    }

    // {%db_4c37f51054e57a9531894d6f4898346d%}
    $result->seek(2);
    $robot = $result->fetch();

    // {%db_2c4f0d3e50ef2ca74fe3702595b073ba%}
    echo $result->numRows();

%{db_822e9e4f30d1487b43dff638b7288be9}%
------------------
%{db_20fba1c0ff797b4571fcf2e266e43c1e}%

.. code-block:: php

    <?php

    // {%db_cb1410d1919176851f1aaab1e732cd03%}
    $sql    = "SELECT * FROM robots WHERE name = ? ORDER BY name";
    $result = $connection->query($sql, array("Wall-E"));

    // {%db_273054477dbe7d2473f58eafd0b12342%}
    $sql     = "INSERT INTO `robots`(name`, year) VALUES (:name, :year)";
    $success = $connection->query($sql, array("name" => "Astro Boy", "year" => 1952));

%{db_775f4a7962f7f6a09e70cb9b792ce716}%
--------------------------------
%{db_7f858ef35a717f24acb02ed361b1fa11}%

.. code-block:: php

    <?php

    // {%db_47ce7f6122d68b95ce5fab9371a4b4a7%}
    $sql     = "INSERT INTO `robots`(`name`, `year`) VALUES ('Astro Boy', 1952)";
    $success = $connection->execute($sql);

    //{%db_0ed322ecf9a2b51f516dfe73c3cbd3a1%}
    $sql     = "INSERT INTO `robots`(`name`, `year`) VALUES (?, ?)";
    $success = $connection->execute($sql, array('Astro Boy', 1952));

    // {%db_180c84f251a905b2b85b4d0284f00e37%}
    $success = $connection->insert(
       "robots",
       array("Astro Boy", 1952),
       array("name", "year")
    );

    // {%db_f217522b307007d854a97b06c22e04b4%}
    $sql     = "UPDATE `robots` SET `name` = 'Astro boy' WHERE `id` = 101";
    $success = $connection->execute($sql);

    //{%db_0ed322ecf9a2b51f516dfe73c3cbd3a1%}
    $sql     = "UPDATE `robots` SET `name` = ? WHERE `id` = ?";
    $success = $connection->execute($sql, array('Astro Boy', 101));

    // {%db_180c84f251a905b2b85b4d0284f00e37%}
    $success = $connection->update(
       "robots",
       array("name"),
       array("New Astro Boy"),
       "id = 101"
    );

    // {%db_8f2a0a63995fbd12c166eae55a8afd40%}
    $sql     = "DELETE `robots` WHERE `id` = 101";
    $success = $connection->execute($sql);

    //{%db_0ed322ecf9a2b51f516dfe73c3cbd3a1%}
    $sql     = "DELETE `robots` WHERE `id` = ?";
    $success = $connection->execute($sql, array(101));

    // {%db_180c84f251a905b2b85b4d0284f00e37%}
    $success = $connection->delete("robots", "id = 101");

%{db_51d4553ed9785f47259855221036781b}%
------------------------------------
%{db_34f0e922f688cb71302678a3fe494a24}%

.. code-block:: php

    <?php

    try {

        //{%db_a621366cd5b2907e40d03bd48faf18e5%}
        $connection->begin();

        //{%db_8c75c6f808c534d604cb02396b4edd55%}
        $connection->execute("DELETE `robots` WHERE `id` = 101");
        $connection->execute("DELETE `robots` WHERE `id` = 102");
        $connection->execute("DELETE `robots` WHERE `id` = 103");

        //{%db_d3a6e14ca6fc2d35e9b4be410148fca1%}
        $connection->commit();

    } catch(Exception $e) {
        //{%db_42dd6f60e2943d2018d338f688dc3893%}
        $connection->rollback();
    }

%{db_3b8eafd4e241b95551713b224b483665}%

.. code-block:: php

    <?php

    try {

        //{%db_a621366cd5b2907e40d03bd48faf18e5%}
        $connection->begin();

        //{%db_8c75c6f808c534d604cb02396b4edd55%}
        $connection->execute("DELETE `robots` WHERE `id` = 101");

        try {

            //{%db_7541179d7363e6364fe5952627e41383%}
            $connection->begin();

            //{%db_ab5dd438a9f5b8f0820cfe4652a1e9ad%}
            $connection->execute("DELETE `robots` WHERE `id` = 102");
            $connection->execute("DELETE `robots` WHERE `id` = 103");

            //{%db_c5a4e9142b804454038d6dd0da2f71cc%}
            $connection->commit();

        } catch(Exception $e) {
            //{%db_644ad7bbb7a3ae57fd16f35c4cd6c35d%}
            $connection->rollback();
        }

        //{%db_77ee981b5ddc409abb1c251be1e92335%}
        $connection->execute("DELETE `robots` WHERE `id` = 104");

        //{%db_d3a6e14ca6fc2d35e9b4be410148fca1%}
        $connection->commit();

    } catch(Exception $e) {
        //{%db_42dd6f60e2943d2018d338f688dc3893%}
        $connection->rollback();
    }

%{db_754a52a77d610f44a39532d53dcc379c}%
---------------
%{db_92349b2878385d609e923e4f9828453a}%

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
| rollbackTransaction | Before a transaction is rollbacked                        | No                  |
+---------------------+-----------------------------------------------------------+---------------------+
| commitTransaction   | Before a transaction is committed                         | No                  |
+---------------------+------------------------------------------------------------+--------------------+

%{db_c5d4c5c6f3320fdd992a9f9b94902b4f}%

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager,
        \Phalcon\Db\Adapter\Pdo\Mysql as Connection;

    $eventsManager = new EventsManager();

    //{%db_d15114be04209e5fae3b603ffbbf13b1%}
    $eventsManager->attach('db', $dbListener);

    $connection = new Connection(array(
        "host" => "localhost",
        "username" => "root",
        "password" => "secret",
        "dbname" => "invo"
    ));

    //{%db_b7efb4940856cd2cf63a1277b1523399%}
    $connection->setEventsManager($eventsManager);

%{db_ab3820428eeff2b86851ff180213b216}%

.. code-block:: php

    <?php

    $eventsManager->attach('db:beforeQuery', function($event, $connection) {

        //{%db_b1e59687f407cc13f1dc50e9867784cc%}
        if (preg_match('/DROP|ALTER/i', $connection->getSQLStatement())) {
            // {%db_859fcc416794bb30a4d0d3374fcb0545%}
            // {%db_96f892897bac78f7d2dfb9923df31886%}
            return false;
        }

        //{%db_4cad94196049561a3ac77c303b7784a7%}
        return true;
    });

%{db_f7dc7675831e283edd54b6e7e3501a7e}%
------------------------
%{db_46e98951d10febc90834515008579195}%

%{db_a3df99eff2894edce98fa52a5fb22368}%

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager,
        Phalcon\Db\Profiler as DbProfiler;

    $eventsManager = new EventsManager();

    $profiler = new DbProfiler();

    //{%db_d15114be04209e5fae3b603ffbbf13b1%}
    $eventsManager->attach('db', function($event, $connection) use ($profiler) {
        if ($event->getType() == 'beforeQuery') {
            //{%db_fd266170f19ec5af140246474a9051c8%}
            $profiler->startProfile($connection->getSQLStatement());
        }
        if ($event->getType() == 'afterQuery') {
            //{%db_14b126c32b3a245e43c622cc25799b45%}
            $profiler->stopProfile();
        }
    });

    //{%db_c0ab6b1fa0211ff19b29a5c704e2104f%}
    $connection->setEventsManager($eventsManager);

    $sql = "SELECT buyer_name, quantity, product_name "
         . "FROM buyers "
         . "LEFT JOIN products ON buyers.pid = products.id";

    // {%db_81e9bd0aa2782b740c867d02541c0325%}
    $connection->query($sql);

    // {%db_82d803f6fb4acc664e98cd0e54612fe1%}
    $profile = $profiler->getLastProfile();

    echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
    echo "Start Time: ", $profile->getInitialTime(), "\n";
    echo "Final Time: ", $profile->getFinalTime(), "\n";
    echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";

%{db_455bb6bd87e31bb960b18a325c1857f9}%

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager,
        Phalcon\Db\Profiler as Profiler,
        Phalcon\Db\Profiler\Item as Item;

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

    //{%db_cc3bf7e319d25db079b9a1ecb4d7d832%}
    $eventsManager = new EventsManager();

    //{%db_082d4b9f7128345ba1fb10ccead89d38%}
    $dbProfiler = new DbProfiler();

    //{%db_eb84e69d88b2666742c4434b5795b5e8%}
    $eventsManager->attach('db', $dbProfiler);

%{db_e88928f2fded39f58528a121fb3de45c}%
----------------------
%{db_a7114da51552b196b64a17bf1631aefd}%

.. code-block:: php

    <?php

    use Phalcon\Logger,
        Phalcon\Events\Manager as EventsManager,
        Phalcon\Logger\Adapter\File as FileLogger;

    $eventsManager = new EventsManager();

    $logger = new FileLogger("app/logs/db.log");

    //{%db_d15114be04209e5fae3b603ffbbf13b1%}
    $eventsManager->attach('db', function($event, $connection) use ($logger) {
        if ($event->getType() == 'beforeQuery') {
            $logger->log($connection->getSQLStatement(), Logger::INFO);
        }
    });

    //{%db_b7efb4940856cd2cf63a1277b1523399%}
    $connection->setEventsManager($eventsManager);

    //{%db_38bc855579b34e310ac96a45fa71af28%}
    $connection->insert(
        "products",
        array("Hot pepper", 3.50),
        array("name", "price")
    );

%{db_0088d92ba0746f6ca32168e18b0acd69}%

.. code-block:: php

    [Sun, 29 Apr 12 22:35:26 -0500][DEBUG][Resource Id #77] INSERT INTO products
    (name, price) VALUES ('Hot pepper', 3.50)


%{db_3343eea266e593d47673c1c99603e34c}%
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{db_06e4bba9bd86a521f5b444fdb93fe6d2}%

%{db_ecd1c68e16f252c70d68cfe1e6e0dcc1}%
-----------------------
%{db_1f5f5c687a00cec49123314bc85a2042}%

.. code-block:: php

    <?php

    // {%db_52e8a97a6e0b563e4c1997d149c13265%}
    $tables = $connection->listTables("test_db");

    // {%db_b3bc60ae7041df3b70812c18a455b060%}
    $exists = $connection->tableExists("robots");

    // {%db_5edef158abf6024e9f9883ffa43e9567%}
    $fields = $connection->describeColumns("robots");
    foreach ($fields as $field) {
        echo "Column Type: ", $field["Type"];
    }

    // {%db_11eafb2689069f958bc03ecbfc4ba10a%}
    $indexes = $connection->describeIndexes("robots");
    foreach ($indexes as $index) {
        print_r($index->getColumns());
    }

    // {%db_1b88a6c6d62f909680fccc9200463104%}
    $references = $connection->describeReferences("robots");
    foreach ($references as $reference) {
        // {%db_f724f5600166de46ea1be17d62d392a1%}
        print_r($reference->getReferencedColumns());
    }

%{db_fd4e007472fe028d0e927e9cc2f6b21c}%

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

%{db_b281bcb20b9fff76eec329324fc483e6}%

.. code-block:: php

    <?php

    // {%db_5c2f5ac613a52fb73295237c35befb7f%}
    $tables = $connection->listViews("test_db");

    // {%db_487d3b66ae96713415193b9a08169997%}
    $exists = $connection->viewExists("robots");

%{db_42bc1888fdf7c5f77d9ca21f38e0ed72}%
---------------------------------
%{db_3e32a6ea6f8c9617413a066ca88504a3}%

%{db_5a549338622e7f241d71991a1a20c6f2}%
^^^^^^^^^^^^^^^
%{db_aee25ce86c0637f8e093c3ce704e249d}%

.. code-block:: php

    <?php

    use \Phalcon\Db\Column as Column;

    $connection->createTable(
        "robots",
        null,
        array(
           "columns" => array(
                new Column("id",
                    array(
                        "type"          => Column::TYPE_INTEGER,
                        "size"          => 10,
                        "notNull"       => true,
                        "autoIncrement" => true,
                    )
                ),
                new Column("name",
                    array(
                        "type"    => Column::TYPE_VARCHAR,
                        "size"    => 70,
                        "notNull" => true,
                    )
                ),
                new Column("year",
                    array(
                        "type"    => Column::TYPE_INTEGER,
                        "size"    => 11,
                        "notNull" => true,
                    )
                )
            )
        )
    );

%{db_accf3385a06a95bd8f27cae7026a5b33}%

+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| Option          | Description                                                                                                                                | Optional |
+=================+============================================================================================================================================+==========+
| "type"          | Column type. Must be a Phalcon\\Db\\Column constant (see below for a list)                                                                 | No       |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "primary"       | True if the column is part of the table's primary key                                                                                      | Yes      |
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

%{db_dc7a84782c94708e2445f7047dac825c}%

%{db_47d26717150280ad3585faf14f7904aa}%

%{db_6a6f6804cf8c152946cdee5720e2d35f}%

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

%{db_c3ed2bc70e428245f4bdd9edcf4cd667}%
^^^^^^^^^^^^^^^
%{db_7d43aa05cba8f136df19e848497ebcc4}%

.. code-block:: php

    <?php

    use Phalcon\Db\Column as Column;

    // {%db_057c0c5342d6aeacfa7eaa6ac62e1f80%}
    $connection->addColumn("robots", null,
        new Column("robot_type", array(
            "type"    => Column::TYPE_VARCHAR,
            "size"    => 32,
            "notNull" => true,
            "after"   => "name"
        ))
    );

    // {%db_58802b059e068d99af4ae86864fe1ab0%}
    $connection->modifyColumn("robots", null, new Column("name", array(
        "type" => Column::TYPE_VARCHAR,
        "size" => 40,
        "notNull" => true,
    )));

    // {%db_3967756a7a96bc72339f90055c984041%}
    $connection->deleteColumn("robots", null, "name");


%{db_cff3f5c3bc556746e03f54e9d880ab64}%
^^^^^^^^^^^^^^^
%{db_04bbf7dd1154ed612e9ab317a81a7439}%

