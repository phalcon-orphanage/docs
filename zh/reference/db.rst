数据库抽象层（Database Abstraction Layer）
==========================
:doc:`Phalcon\\Db <../api/Phalcon_Db>` 是 :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 背后的一个组件，它为框架提供了强大的model层。它是一个完全由C语言写的独立的高级抽象层的数据库系统。

这个组件提供了比传统模式的更容易上手的数据库操作。

.. highlights::
    这个指引不是一个完整的包含所有方法和它们的参数的文档。
    查看完整的文档参考，请访问 :doc:`API <../api/index>`

数据库适配器（Database Adapters）
-----------------
这个组件利用了这些适配器去封装特定的数据库的详细操作。Phalcon使用 PDO_ 去连接这些数据库。下面这些是我们支持的数据库引擎：

+------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-----------------------------------------------------------------------------------------+
| 名称       | 描述                                                                                                                                                                                                                                 | API                                                                                     |
+============+======================================================================================================================================================================================================================================+=========================================================================================+
| MySQL      | MySQL是这个世界上最多人使用的关系数据库，它作为服务器运行为多用户提供了访问多个数据库的功能。                                                                                                                                        | :doc:`Phalcon\\Db\\Adapter\\Pdo\\Mysql <../api/Phalcon_Db_Adapter_Pdo_Mysql>`           |
+------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-----------------------------------------------------------------------------------------+
| PostgreSQL | PostgreSQL是一个强大，开源的关系数据库。它拥有超过15年的积极发展和经过验证的架构，这些已经为它赢得了可靠性、数据完整性、正确性的良好的声誉                                                                                           | :doc:`Phalcon\\Db\\Adapter\\Pdo\\Postgresql <../api/Phalcon_Db_Adapter_Pdo_Postgresql>` |
+------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-----------------------------------------------------------------------------------------+
| SQLite     | SQLite是一个实现一个自包含的，无服务器，零配置，支持事务的SQL数据库引擎的软件库                                                                                                                                                      | :doc:`Phalcon\\Db\\Adapter\\Pdo\\Sqlite <../api/Phalcon_Db_Adapter_Pdo_Sqlite>`         |
+------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-----------------------------------------------------------------------------------------+
| Oracle     | Oracle是一个对象-关系数据库，由甲骨文公司生产和销售。                                                                                                                                                                                | :doc:`Phalcon\\Db\\Adapter\\Pdo\\Oracle <../api/Phalcon_Db_Adapter_Pdo_Oracle>`         |
+------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+-----------------------------------------------------------------------------------------+

自定义适配器（Implementing your own adapters）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
为了建立你自己的适配器或者继承一个已存在的适配器，这个:doc:`Phalcon\\Db\\AdapterInterface <../api/Phalcon_Db_AdapterInterface>`接口必须被实现，

数据库“方言”
-----------------
Phalcon把每个数据库引擎的具体操作封装成“方言”，这些“方言”提供了提供通用的功能和SQL生成的适配器。
(译者注：这里的“方言”是指Phalcon把一些常用的数据库操作封装成类的方法，例如检查数据库中表是否存在，不再需要麻烦的手动写SQL，可以把调用tableExists方法去查询)

+------------+-----------------------------------------------------+--------------------------------------------------------------------------------+
| 名称       | 描述                                                | API                                                                            |
+============+=====================================================+================================================================================+
| MySQL      | MySQL的具体“方言”                                   | :doc:`Phalcon\\Db\\Dialect\\Mysql <../api/Phalcon_Db_Dialect_Mysql>`           |
+------------+-----------------------------------------------------+--------------------------------------------------------------------------------+
| PostgreSQL | PostgreSQL的具体“方言”                              | :doc:`Phalcon\\Db\\Dialect\\Postgresql <../api/Phalcon_Db_Dialect_Postgresql>` |
+------------+-----------------------------------------------------+--------------------------------------------------------------------------------+
| SQLite     | SQLite的具体“方言”                                  | :doc:`Phalcon\\Db\\Dialect\\Sqlite <../api/Phalcon_Db_Dialect_Sqlite>`         |
+------------+-----------------------------------------------------+--------------------------------------------------------------------------------+
| Oracle     | Oracle的具体“方言”                                  | :doc:`Phalcon\\Db\\Dialect\\Oracle <../api/Phalcon_Db_Dialect_Oracle>`         |
+------------+-----------------------------------------------------+--------------------------------------------------------------------------------+

自定义“方言”（Implementing your own dialects）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
为了建立你自己的“方言”或者继承一个已存在的，你需要实现这个接口：:doc:`Phalcon\\Db\\DialectInterface <../api/Phalcon_Db_DialectInterface>`

连接数据库（Connecting to Databases）
-----------------------
为了建立连接，实例化适配器类是有必要的。它只接收一个包含连接参数的数组。
下面的例子展示通过必要参数和可选项的参数去连接数据库：

.. code-block:: php

    <?php

    // 必要参数
    $config = array(
        "host" => "127.0.0.1",
        "username" => "mike",
        "password" => "sigma",
        "dbname" => "test_db"
    );

    // 可选参数
    $config["persistent"] = false;

    // 创建连接
    $connection = new \Phalcon\Db\Adapter\Pdo\Mysql($config);

.. code-block:: php

    <?php

    // 必要参数
    $config = array(
        "host" => "localhost",
        "username" => "postgres",
        "password" => "secret1",
        "dbname" => "template"
    );

    // 可选参数
    $config["schema"] = "public";

    // 创建连接
    $connection = new \Phalcon\Db\Adapter\Pdo\Postgresql($config);

.. code-block:: php

    <?php

    // 必要参数
    $config = array(
        "dbname" => "/path/to/database.db"
    );

    // 创建连接
    $connection = new \Phalcon\Db\Adapter\Pdo\Sqlite($config);

.. code-block:: php

    <?php

    // 基本配置信息
    $config = array(
        'username' => 'scott',
        'password' => 'tiger',
        'dbname' => '192.168.10.145/orcl',
    );

    // 高级配置信息
    $config = array(
        'dbname' => '(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(HOST=localhost)(PORT=1521)))(CONNECT_DATA=(SERVICE_NAME=xe)(FAILOVER_MODE=(TYPE=SELECT)(METHOD=BASIC)(RETRIES=20)(DELAY=5))))',
        'username' => 'scott',
        'password' => 'tiger',
        'charset' => 'AL32UTF8',
    );

    // 创建连接
    $connection = new \Phalcon\Db\Adapter\Pdo\Oracle($config);

设置额外的 PDO 选项（Setting up additional PDO options）
---------------------------------
你可以在连接的时候，通过传递'options'参数，设置PDO选项：

.. code-block:: php

    <?php

    // 带PDO options参数的创建连接
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

查找行（Finding Rows）
------------
文档:doc:`Phalcon\\Db <../api/Phalcon_Db>` 提供了几种方法去查询行。目标数据库引擎的特定SQL语法是必须的，在这个例子中：

.. code-block:: php

    <?php

    $sql = "SELECT id, name FROM robots ORDER BY name";

    // 发送SQL语句到数据库
    $result = $connection->query($sql);

    // 打印每个robot名称
    while ($robot = $result->fetch()) {
       echo $robot["name"];
    }

    // 返回一个包含返回结果的数组
    $robots = $connection->fetchAll($sql);
    foreach ($robots as $robot) {
       echo $robot["name"];
    }

    // 只返回查询结果的第一条数据
    $robot = $connection->fetchOne($sql);

默认情况下，这些调用会建立一个数组，数组中包含以字段名和以数字下标为key的值。你可以改变这种行为通过使用 Phalcon\\Db\\Result::setFetchMode() 。这个方法接受一个常量值，确定哪些类型的指标是被要求的。

+--------------------------+-----------------------------------------------------------+
| 常量                     | 描述                                                      |
+==========================+===========================================================+
| Phalcon\\Db::FETCH_NUM   | 返回一个包含数字下标的数组                                |
+--------------------------+-----------------------------------------------------------+
| Phalcon\\Db::FETCH_ASSOC | 返回一个包含字段名的数组                                  |
+--------------------------+-----------------------------------------------------------+
| Phalcon\\Db::FETCH_BOTH  | 返回一个包含字段名和数字下标的数组                        |
+--------------------------+-----------------------------------------------------------+
| Phalcon\\Db::FETCH_OBJ   | 返回一个对象而不是一个数组                                |
+--------------------------+-----------------------------------------------------------+

.. code-block:: php

    <?php

    $sql = "SELECT id, name FROM robots ORDER BY name";
    $result = $connection->query($sql);

    $result->setFetchMode(Phalcon\Db::FETCH_NUM);
    while ($robot = $result->fetch()) {
       echo $robot[0];
    }

这个 Phalcon\\Db::query() 方法返回一个:doc:`Phalcon\\Db\\Result\\Pdo <../api/Phalcon_Db_Result_Pdo>`实例。这些对象封装了凡是涉及到返回的结果集的功能，例如遍历，寻找特定行，计算总行数等等

.. code-block:: php

    <?php

    $sql = "SELECT id, name FROM robots";
    $result = $connection->query($sql);

    // 遍历结果集
    while ($robot = $result->fetch()) {
       echo $robot["name"];
    }

    // 获取第三条记录
    $result->seek(2);
    $robot = $result->fetch();

    // 计算结果集的记录数
    echo $result->numRows();

绑定参数（Binding Parameters）
------------------
在:doc:`Phalcon\\Db <../api/Phalcon_Db>`中绑定参数也被支持。虽然使用绑定参数会有很少性能的损失，但是我们鼓励你使用这个方法
去消除你的代码受到SQL注入攻击的可能性。字符串和占位符都支持，绑定参数可以简单地实现：

.. code-block:: php

    <?php

    // 用数字占位符绑定参数
    $sql    = "SELECT * FROM robots WHERE name = ? ORDER BY name";
    $result = $connection->query($sql, array("Wall-E"));

    // 用指定的占位符绑定参数
    $sql     = "INSERT INTO `robots`(name`, year) VALUES (:name, :year)";
    $success = $connection->query($sql, array("name" => "Astro Boy", "year" => 1952));

插入、更新、删除行（Inserting/Updating/Deleting Rows）
--------------------------------
去插入，更新或者删除行，你可以使用原生SQL操作，或者使用类中预设的方法

.. code-block:: php

    <?php

    // 使用原生SQL插入行
    $sql     = "INSERT INTO `robots`(`name`, `year`) VALUES ('Astro Boy', 1952)";
    $success = $connection->execute($sql);

    // 使用带占位符的SQL插入行
    $sql     = "INSERT INTO `robots`(`name`, `year`) VALUES (?, ?)";
    $success = $connection->execute($sql, array('Astro Boy', 1952));

    // 使用类中预设的方法插入行
    $success = $connection->insert(
       "robots",
       array("Astro Boy", 1952),
       array("name", "year")
    );

    // 使用原生SQL更新行
    $sql     = "UPDATE `robots` SET `name` = 'Astro boy' WHERE `id` = 101";
    $success = $connection->execute($sql);

    // 使用带占位符的SQL更新行
    $sql     = "UPDATE `robots` SET `name` = ? WHERE `id` = ?";
    $success = $connection->execute($sql, array('Astro Boy', 101));

    // 使用类中预设的方法更新行
    $success = $connection->update(
       "robots",
       array("name"),
       array("New Astro Boy"),
       "id = 101"
    );

    // 使用原生的SQL删除行
    $sql     = "DELETE `robots` WHERE `id` = 101";
    $success = $connection->execute($sql);

    // 使用带占位符的SQL删除行
    $sql     = "DELETE `robots` WHERE `id` = ?";
    $success = $connection->execute($sql, array(101));

    // 使用类中预设的方法删除行
    $success = $connection->delete("robots", "id = 101");

事务与嵌套事务（Transactions and Nested Transactions）
------------------------------------
PDO支持事务工作。在事务里面执行数据操作, 在大多数数据库系统上, 往往可以提高数据库的性能：

.. code-block:: php

    <?php

    try {

        // 开始一个事务
        $connection->begin();

        // 执行一些操作
        $connection->execute("DELETE `robots` WHERE `id` = 101");
        $connection->execute("DELETE `robots` WHERE `id` = 102");
        $connection->execute("DELETE `robots` WHERE `id` = 103");

        // 提交操作，如果一切正常
        $connection->commit();

    } catch(Exception $e) {
        // 如果发现异常，回滚操作
        $connection->rollback();
    }

除了标准的事务，Phalcon\\Db提供了内置支持`嵌套事务`_(如果数据库系统支持的话)。
当你第二次调用begin()方法，一个嵌套的事务就被创建了：

.. code-block:: php

    <?php

    try {

        // 开始一个事务
        $connection->begin();

        // 执行某些SQL操作
        $connection->execute("DELETE `robots` WHERE `id` = 101");

        try {

            // 开始一个嵌套事务
            $connection->begin();

            // 在嵌套事务中执行这些SQL
            $connection->execute("DELETE `robots` WHERE `id` = 102");
            $connection->execute("DELETE `robots` WHERE `id` = 103");

            // 创建一个保存的点
            $connection->commit();

        } catch(Exception $e) {
            // 发生错误，释放嵌套的事务
            $connection->rollback();
        }

        // 继续，执行更多SQL操作
        $connection->execute("DELETE `robots` WHERE `id` = 104");

        // 如果一切正常，提交
        $connection->commit();

    } catch(Exception $e) {
        // 发生错误，回滚操作
        $connection->rollback();
    }

数据库事件（Database Events）
---------------
:doc:`Phalcon\\Db <../api/Phalcon_Db>`可以发送事件到一个:doc:`EventsManager <events>`中，如果它存在的话。
一些事件当返回布尔值false可以停止操作。我们支持下面这些事件：

+---------------------+-----------------------------------------------------------+---------------------+
| 事件名              | 何时触发                                                  | 可以停止操作吗? |
+=====================+===========================================================+=====================+
| afterConnect        | 当成功连接数据库之后触发                                  | No                  |
+---------------------+-----------------------------------------------------------+---------------------+
| beforeQuery         | 在发送SQL到数据库前触发                                   | Yes                 |
+---------------------+-----------------------------------------------------------+---------------------+
| afterQuery          | 在发送SQL到数据库执行后触发                               | No                  |
+---------------------+-----------------------------------------------------------+---------------------+
| beforeDisconnect    | 在关闭一个暂存的数据库连接前触发                          | No                  |
+---------------------+-----------------------------------------------------------+---------------------+
| beginTransaction    | 事务启动前触发                                            | No                  |
+---------------------+-----------------------------------------------------------+---------------------+
| rollbackTransaction | 事务回滚前触发                                            | No                  |
+---------------------+-----------------------------------------------------------+---------------------+
| commitTransaction   | 事务提交前触发                                            | No                  |
+---------------------+-----------------------------------------------------------+---------------------+

绑定一个EventsManager给一个连接是很简单的，Phalcon\\Db将触发这些类型为“db”的事件：

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager,
        \Phalcon\Db\Adapter\Pdo\Mysql as Connection;

    $eventsManager = new EventsManager();

    // 监听所有数据库事件
    $eventsManager->attach('db', $dbListener);

    $connection = new Connection(array(
        "host" => "localhost",
        "username" => "root",
        "password" => "secret",
        "dbname" => "invo"
    ));

    // 把eventsManager分配给适配器实例
    $connection->setEventsManager($eventsManager);

停止SQL操作是非常有用的，例如：如果你想要实现一些注入检查器在最后的SQL资源中：

.. code-block:: php

    <?php

    $eventsManager->attach('db:beforeQuery', function($event, $connection) {

        // 检查是否有恶意关键词
        if (preg_match('/DROP|ALTER/i', $connection->getSQLStatement())) {
            // DROP/ALTER 操作是不允许的,
            // 这肯定是一个注入!
            return false;
        }

        // 一切正常
        return true;
    });

分析 SQL 语句（Profiling SQL Statements）
------------------------
:doc:`Phalcon\\Db <../api/Phalcon_Db>` includes a profiling component called :doc:`Phalcon\\Db\\Profiler <../api/Phalcon_Db_Profiler>`, that is used to analyze the performance of database operations so as to diagnose performance problems and discover bottlenecks.

Database profiling is really easy With :doc:`Phalcon\\Db\\Profiler <../api/Phalcon_Db_Profiler>`:

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager,
        Phalcon\Db\Profiler as DbProfiler;

    $eventsManager = new EventsManager();

    $profiler = new DbProfiler();

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

    //Create an EventsManager
    $eventsManager = new EventsManager();

    //Create a listener
    $dbProfiler = new DbProfiler();

    //Attach the listener listening for all database events
    $eventsManager->attach('db', $dbProfiler);

记录 SQL 语句（Logging SQL Statements）
----------------------
Using high-level abstraction components such as :doc:`Phalcon\\Db <../api/Phalcon_Db>` to access a database, it is difficult to understand which statements are sent to the database system. :doc:`Phalcon\\Logger <../api/Phalcon_Logger>` interacts with :doc:`Phalcon\\Db <../api/Phalcon_Db>`, providing logging capabilities on the database abstraction layer.

.. code-block:: php

    <?php

    use Phalcon\Logger,
        Phalcon\Events\Manager as EventsManager,
        Phalcon\Logger\Adapter\File as FileLogger;

    $eventsManager = new EventsManager();

    $logger = new FileLogger("app/logs/db.log");

    //Listen all the database events
    $eventsManager->attach('db', function($event, $connection) use ($logger) {
        if ($event->getType() == 'beforeQuery') {
            $logger->log($connection->getSQLStatement(), Logger::INFO);
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


自定义日志记录器（Implementing your own Logger）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
You can implement your own logger class for database queries, by creating a class that implements a single method called "log".
The method needs to accept a string as the first argument. You can then pass your logging object to Phalcon\\Db::setLogger(),
and from then on any SQL statement executed will call that method to log the results.

获取数据库表与视图信息（Describing Tables/Views）
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
        print_r($index->getColumns());
    }

    // Get foreign keys on the 'robots' table
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

创建数据库表（Creating Tables）
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

Phalcon\\Db::createTable() accepts an associative array describing the table. Columns are defined with the class
:doc:`Phalcon\\Db\\Column <../api/Phalcon_Db_Column>`. The table below shows the options available to define a column:

+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| Option          | Description                                                                                                                                | Optional |
+=================+============================================================================================================================================+==========+
| "type"          | Column type. Must be a Phalcon\\Db\\Column constant (see below for a list)                                                                 | No       |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "primary"       | True if the column is part of the table's primary
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

* Phalcon\\Db\\Column::TYPE_INTEGER
* Phalcon\\Db\\Column::TYPE_DATE
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

修改数据库表（Altering Tables）
^^^^^^^^^^^^^^^
As your application grows, you might need to alter your database, as part of a refactoring or adding new features.
Not all database systems allow to modify existing columns or add columns between two existing ones. :doc:`Phalcon\\Db <../api/Phalcon_Db>`
is limited by these constraints.

.. code-block:: php

    <?php

    use Phalcon\Db\Column as Column;

    // Adding a new column
    $connection->addColumn("robots", null,
        new Column("robot_type", array(
            "type"    => Column::TYPE_VARCHAR,
            "size"    => 32,
            "notNull" => true,
            "after"   => "name"
        ))
    );

    // Modifying an existing column
    $connection->modifyColumn("robots", null, new Column("name", array(
        "type" => Column::TYPE_VARCHAR,
        "size" => 40,
        "notNull" => true,
    )));

    // Deleting the column "name"
    $connection->deleteColumn("robots", null, "name");


删除数据库表（Dropping Tables）
^^^^^^^^^^^^^^^
Examples on dropping tables:

.. code-block:: php

    <?php

    // Drop table robot from active database
    $connection->dropTable("robots");

    //Drop table robot from database "machines"
    $connection->dropTable("robots", "machines");

.. _PDO: http://www.php.net/manual/en/book.pdo.php
.. _`nested transactions`: http://en.wikipedia.org/wiki/Nested_transaction
