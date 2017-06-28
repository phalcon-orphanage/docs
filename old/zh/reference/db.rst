数据库抽象层（Database Abstraction Layer）
==========================================

:doc:`Phalcon\\Db <../api/Phalcon_Db>` 是 :doc:`Phalcon\\Mvc\\Model <../api/Phalcon_Mvc_Model>` 背后的一个组件，它为框架提供了强大的model层。它是一个完全由C语言写的独立的高级抽象层的数据库系统。

这个组件提供了比传统模式的更容易上手的数据库操作。

.. highlights::

    这个指引不是一个完整的包含所有方法和它们的参数的文档。
    查看完整的文档参考，请访问 :doc:`API <../api/index>`

数据库适配器（Database Adapters）
---------------------------------
这个组件利用了这些适配器去封装特定的数据库的详细操作。Phalcon使用 PDO_ 去连接这些数据库。下面这些是我们支持的数据库引擎：

+-----------------------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------------------------------------+
| Class                                                                                   | 描述                                                                                                                                       |
+=========================================================================================+============================================================================================================================================+
| :doc:`Phalcon\\Db\\Adapter\\Pdo\\Mysql <../api/Phalcon_Db_Adapter_Pdo_Mysql>`           | MySQL是这个世界上最多人使用的关系数据库，它作为服务器运行为多用户提供了访问多个数据库的功能。                                              |
+-----------------------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Db\\Adapter\\Pdo\\Postgresql <../api/Phalcon_Db_Adapter_Pdo_Postgresql>` | PostgreSQL是一个强大，开源的关系数据库。它拥有超过15年的积极发展和经过验证的架构，这些已经为它赢得了可靠性、数据完整性、正确性的良好的声誉 |
+-----------------------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Db\\Adapter\\Pdo\\Sqlite <../api/Phalcon_Db_Adapter_Pdo_Sqlite>`         | SQLite是一个实现一个自包含的，无服务器，零配置，支持事务的SQL数据库引擎的软件库                                                            |
+-----------------------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------------------------------------------+

自定义适配器（Implementing your own adapters）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
如果你想创建自己的适配器或者扩展现有的适配器，这个 :doc:`Phalcon\\Db\\AdapterInterface <../api/Phalcon_Db_AdapterInterface>` 接口必须被实现。

数据库“方言”
------------
Phalcon把每个数据库引擎的具体操作封装成“方言”，这些“方言”提供了提供通用的功能和SQL生成的适配器。
(译者注：这里的“方言”是指Phalcon把一些常用的数据库操作封装成类的方法，例如检查数据库中表是否存在，不再需要麻烦的手动写SQL，可以把调用tableExists方法去查询)

+--------------------------------------------------------------------------------+-----------------------------------------------------+
| 名称                                                                           | 描述                                                |
+================================================================================+=====================================================+
| :doc:`Phalcon\\Db\\Dialect\\Mysql <../api/Phalcon_Db_Dialect_Mysql>`           | MySQL的具体“方言”                                   |
+--------------------------------------------------------------------------------+-----------------------------------------------------+
| :doc:`Phalcon\\Db\\Dialect\\Postgresql <../api/Phalcon_Db_Dialect_Postgresql>` | PostgreSQL的具体“方言”                              |
+--------------------------------------------------------------------------------+-----------------------------------------------------+
| :doc:`Phalcon\\Db\\Dialect\\Sqlite <../api/Phalcon_Db_Dialect_Sqlite>`         | SQLite的具体“方言”                                  |
+--------------------------------------------------------------------------------+-----------------------------------------------------+

自定义“方言”（Implementing your own dialects）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
如果你想创建自己的“方言”或者扩展现有的“方言”，你需要实现这个接口： :doc:`Phalcon\\Db\\DialectInterface <../api/Phalcon_Db_DialectInterface>`

连接数据库（Connecting to Databases）
-------------------------------------
为了建立连接，实例化适配器类是必须的。它只接收一个包含连接参数的数组。
下面的例子展示了，传递必要参数和可选项的参数去连接数据库：

.. code-block:: php

    <?php

    // 必要参数
    $config = [
        "host"     => "127.0.0.1",
        "username" => "mike",
        "password" => "sigma",
        "dbname"   => "test_db",
    ];

    // 可选参数
    $config["persistent"] = false;

    // 创建连接
    $connection = new \Phalcon\Db\Adapter\Pdo\Mysql($config);

.. code-block:: php

    <?php

    // 必要参数
    $config = [
        "host"     => "localhost",
        "username" => "postgres",
        "password" => "secret1",
        "dbname"   => "template",
    ];

    // 可选参数
    $config["schema"] = "public";

    // 创建连接
    $connection = new \Phalcon\Db\Adapter\Pdo\Postgresql($config);

.. code-block:: php

    <?php

    // 必要参数
    $config = [
        "dbname" => "/path/to/database.db",
    ];

    // 创建连接
    $connection = new \Phalcon\Db\Adapter\Pdo\Sqlite($config);

设置额外的 PDO 选项（Setting up additional PDO options）
--------------------------------------------------------
你可以在连接的时候，通过传递'options'参数，设置PDO选项：

.. code-block:: php

    <?php

    // 带PDO options参数的创建连接
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

查找行（Finding Rows）
----------------------
文档 :doc:`Phalcon\\Db <../api/Phalcon_Db>` 提供了几种方法去查询行。在这个例子中，SQL语句是必须符合数据库的SQL语法的：

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

默认情况下，这些调用会建立一个数组，数组中包含以字段名和以数字下标为key的值。你可以改变这种行为通过使用 :code:`Phalcon\Db\Result::setFetchMode()` 。这个方法接受一个常量值，确定哪些类型的指标是被要求的。

+---------------------------------+-----------------------------------------------------------+
| 常量                            | 描述                                                      |
+=================================+===========================================================+
| :code:`Phalcon\Db::FETCH_NUM`   | 返回一个包含数字下标的数组                                |
+---------------------------------+-----------------------------------------------------------+
| :code:`Phalcon\Db::FETCH_ASSOC` | 返回一个包含字段名的数组                                  |
+---------------------------------+-----------------------------------------------------------+
| :code:`Phalcon\Db::FETCH_BOTH`  | 返回一个包含字段名和数字下标的数组                        |
+---------------------------------+-----------------------------------------------------------+
| :code:`Phalcon\Db::FETCH_OBJ`   | 返回一个对象而不是一个数组                                |
+---------------------------------+-----------------------------------------------------------+

.. code-block:: php

    <?php

    $sql = "SELECT id, name FROM robots ORDER BY name";
    $result = $connection->query($sql);

    $result->setFetchMode(Phalcon\Db::FETCH_NUM);
    while ($robot = $result->fetch()) {
       echo $robot[0];
    }

这个 :code:`Phalcon\Db::query()` 方法返回一个 :doc:`Phalcon\\Db\\Result\\Pdo <../api/Phalcon_Db_Result_Pdo>` 实例。这些对象封装了凡是涉及到返回的结果集的功能，例如遍历，寻找特定行，计算总行数等等

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
------------------------------
在 :doc:`Phalcon\\Db <../api/Phalcon_Db>` 中支持绑定参数。虽然使用绑定参数会有很少性能的损失，但是我们鼓励你使用这个方法
去消除(译者注：是消除，不是减少，因为使用参数绑定可以彻底解决SQL注入问题)SQL注入攻击的可能性。
字符串和占位符都支持，就像下面展示的那样，绑定参数可以简单地实现：

.. code-block:: php

    <?php

    // 用数字占位符绑定参数
    $sql    = "SELECT * FROM robots WHERE name = ? ORDER BY name";
    $result = $connection->query(
        $sql,
        [
            "Wall-E",
        ]
    );

    // 用指定的占位符绑定参数
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

插入、更新、删除行（Inserting/Updating/Deleting Rows）
------------------------------------------------------
去插入，更新或者删除行，你可以使用原生SQL操作，或者使用类中预设的方法

.. code-block:: php

    <?php

    // 使用原生SQL插入行
    $sql     = "INSERT INTO `robots`(`name`, `year`) VALUES ('Astro Boy', 1952)";
    $success = $connection->execute($sql);

    // 使用带占位符的SQL插入行
    $sql     = "INSERT INTO `robots`(`name`, `year`) VALUES (?, ?)";
    $success = $connection->execute(
        $sql,
        [
            "Astro Boy",
            1952,
        ]
    );

    // 使用类中预设的方法插入行
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

    // 插入数据的另外一种方法
    $success = $connection->insertAsDict(
        "robots",
        [
            "name" => "Astro Boy",
            "year" => 1952,
        ]
    );

    // 使用原生SQL更新行
    $sql     = "UPDATE `robots` SET `name` = 'Astro boy' WHERE `id` = 101";
    $success = $connection->execute($sql);

    // 使用带占位符的SQL更新行
    $sql     = "UPDATE `robots` SET `name` = ? WHERE `id` = ?";
    $success = $connection->execute(
        $sql,
        [
            "Astro Boy",
            101,
        ]
    );

    // 使用类中预设的方法更新行
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

    // 更新数据的另外一种方法
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

    // 使用原生SQL删除数据
    $sql     = "DELETE `robots` WHERE `id` = 101";
    $success = $connection->execute($sql);

    // 使用带占位符的SQL删除行
    $sql     = "DELETE `robots` WHERE `id` = ?";
    $success = $connection->execute($sql, [101]);

    // 使用类中预设的方法删除行
    $success = $connection->delete(
        "robots",
        "id = ?",
        [
            101,
        ]
    );

事务与嵌套事务（Transactions and Nested Transactions）
------------------------------------------------------
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
    } catch (Exception $e) {
        // 如果发现异常，回滚操作
        $connection->rollback();
    }

除了标准的事务， :doc:`Phalcon\\Db <../api/Phalcon_Db>` 提供了内置支持`嵌套事务`_(如果数据库系统支持的话)。
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
        } catch (Exception $e) {
            // 发生错误，释放嵌套的事务
            $connection->rollback();
        }

        // 继续，执行更多SQL操作
        $connection->execute("DELETE `robots` WHERE `id` = 104");

        // 如果一切正常，提交
        $connection->commit();
    } catch (Exception $e) {
        // 发生错误，回滚操作
        $connection->rollback();
    }

数据库事件（Database Events）
-----------------------------
:doc:`Phalcon\\Db <../api/Phalcon_Db>` 可以发送事件到一个 :doc:`EventsManager <events>` 中，如果它存在的话。
一些事件当返回布尔值false可以停止操作。我们支持下面这些事件：

+---------------------+-----------------------------------------------------------+---------------------+
| 事件名              | 何时触发                                                  | 可以停止操作吗?     |
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

绑定一个EventsManager给一个连接是很简单的， :doc:`Phalcon\\Db <../api/Phalcon_Db>` 将触发这些类型为“db”的事件：

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager;
    use Phalcon\Db\Adapter\Pdo\Mysql as Connection;

    $eventsManager = new EventsManager();

    // 监听所有数据库事件
    $eventsManager->attach('db', $dbListener);

    $connection = new Connection(
        [
            "host"     => "localhost",
            "username" => "root",
            "password" => "secret",
            "dbname"   => "invo",
        ]
    );

    // 把eventsManager分配给适配器实例
    $connection->setEventsManager($eventsManager);

数据库事件中，停止操作是非常有用的，例如：如果你想要实现一个注入检查器，在发送SQL到数据库前触发：

.. code-block:: php

    <?php

    use Phalcon\Events\Event;

    $eventsManager->attach(
        "db:beforeQuery",
        function (Event $event, $connection) {
            $sql = $connection->getSQLStatement();

            // 检查是否有恶意关键词
            if (preg_match("/DROP|ALTER/i", $sql)) {
                // DROP/ALTER 操作是不允许的, 这肯定是一个注入!
                // 返回false中断此操作
                return false;
            }

            // 一切正常
            return true;
        }
    );

分析 SQL 语句（Profiling SQL Statements）
-----------------------------------------
:doc:`Phalcon\\Db <../api/Phalcon_Db>` 包含了一个性能分析组件，叫 :doc:`Phalcon\\Db\\Profiler <../api/Phalcon_Db_Profiler>` ，它被用于分析数据库的操作性能以便诊断性能问题，并发现瓶颈。
使用 :doc:`Phalcon\\Db\\Profiler <../api/Phalcon_Db_Profiler>` 来分析数据库真的很简单:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;
    use Phalcon\Db\Profiler as DbProfiler;

    $eventsManager = new EventsManager();

    $profiler = new DbProfiler();

    // 监听所有数据库的事件
    $eventsManager->attach(
        "db",
        function (Event $event, $connection) use ($profiler) {
            if ($event->getType() === "beforeQuery") {
                $sql = $connection->getSQLStatement();

                // 操作前启动分析
                $profiler->startProfile($sql);
            }

            if ($event->getType() === "afterQuery") {
                // 操作后停止分析
                $profiler->stopProfile();
            }
        }
    );

    // 设置事件管理器
    $connection->setEventsManager($eventsManager);

    $sql = "SELECT buyer_name, quantity, product_name "
         . "FROM buyers "
         . "LEFT JOIN products ON buyers.pid = products.id";

    // 执行SQL
    $connection->query($sql);

    // 获取最后一个分析结果
    $profile = $profiler->getLastProfile();

    echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
    echo "Start Time: ", $profile->getInitialTime(), "\n";
    echo "Final Time: ", $profile->getFinalTime(), "\n";
    echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";

你也可以基于 :doc:`Phalcon\\Db\\Profiler <../api/Phalcon_Db_Profiler>` 建立你自己的分析器类，以记录SQL语句发送到数据库的实时统计：

.. code-block:: php

    <?php

    use Phalcon\Events\Manager as EventsManager;
    use Phalcon\Db\Profiler as Profiler;
    use Phalcon\Db\Profiler\Item as Item;

    class DbProfiler extends Profiler
    {
        /**
         * 在SQL语句将要发送给数据库前执行
         */
        public function beforeStartProfile(Item $profile)
        {
            echo $profile->getSQLStatement();
        }

        /**
         * 在SQL语句已经被发送到数据库后执行
         */
        public function afterEndProfile(Item $profile)
        {
            echo $profile->getTotalElapsedSeconds();
        }
    }

    // 创建一个事件管理器
    $eventsManager = new EventsManager();

    // 创建一个监听器
    $dbProfiler = new DbProfiler();

    // 设置监听器监听所有的数据库事件
    $eventsManager->attach("db", $dbProfiler);

记录 SQL 语句（Logging SQL Statements）
---------------------------------------
使用例如 :doc:`Phalcon\\Db <../api/Phalcon_Db>` 的高级抽象组件操作数据库，被发送到数据库中执行的原生SQL语句是难以获知的。使用 :doc:`Phalcon\\Logger <../api/Phalcon_Logger>` 和 :doc:`Phalcon\\Db <../api/Phalcon_Db>` 来配合使用，可以在数据库抽象层上提供记录的功能。

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

    // 设置事件管理器
    $connection->setEventsManager($eventsManager);

    // 执行一些SQL
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

如上操作，文件 *app/logs/db.log* 将包含像下面这样的信息：

.. code-block:: php

    [Sun, 29 Apr 12 22:35:26 -0500][DEBUG][Resource Id #77] INSERT INTO products
    (name, price) VALUES ('Hot pepper', 3.50)


自定义日志记录器（Implementing your own Logger）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
你可以实现你自己的日志类来记录数据库的所有操作，通过创建一个实现了"log"方法的类。
这个方法需要接受一个字符串作为第一个参数。你可以把日志类的对象传递给 :code:`Phalcon\Db::setLogger()`，
这样执行SQL时将调用这个对象的log方法去记录。

获取数据库表与视图信息（Describing Tables/Views）
-------------------------------------------------
:doc:`Phalcon\\Db <../api/Phalcon_Db>` 也提供了方法去检索详细的表和视图信息：

.. code-block:: php

    <?php

    // 获取test_db数据库的所有表
    $tables = $connection->listTables("test_db");

    // 在数据库中是否存在'robots'这个表
    $exists = $connection->tableExists("robots");

    // 获取'robots'字段名称，数据类型，特殊特征
    $fields = $connection->describeColumns("robots");
    foreach ($fields as $field) {
        echo "Column Type: ", $field["Type"];
    }

    // 获取'robots'表的所有索引
    $indexes = $connection->describeIndexes("robots");
    foreach ($indexes as $index) {
        print_r(
            $index->getColumns()
        );
    }

    // 获取'robots'表的所有外键
    $references = $connection->describeReferences("robots");
    foreach ($references as $reference) {
        // 打印引用的列
        print_r(
            $reference->getReferencedColumns()
        );
    }

一个表的详细描述信息和MYSQL的describe命令返回的信息非常相似，它包含以下信息：

+-------+----------------------------------------------------+
| 下标  | 描述                                               |
+=======+====================================================+
| Field | 字段名称                                           |
+-------+----------------------------------------------------+
| Type  | 字段类型                                           |
+-------+----------------------------------------------------+
| Key   | 是否是主键或者索引                                 |
+-------+----------------------------------------------------+
| Null  | 是否允许为空                                       |
+-------+----------------------------------------------------+

对于被支持的数据库系统，获取视图的信息的方法也被实现了：

.. code-block:: php

    <?php

    // 获取test_db数据库的视图
    $tables = $connection->listViews("test_db");

    // 'robots'视图是否存在数据库中
    $exists = $connection->viewExists("robots");

创建/修改/删除表
----------------
不同的数据库系统（MySQL,Postgresql等）通过了CREATE, ALTER 或 DROP命令提供了用于创建，修改或删除表的功能。但是不同的数据库语法不同。
:doc:`Phalcon\\Db <../api/Phalcon_Db>` 提供了统一的接口来改变表，而不需要区分基于目标存储系统上的SQL语法。

创建数据库表（Creating Tables）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
下面这个例子展示了怎么建立一个表：

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

:code:`Phalcon\Db::createTable()` 接受一个描述数据库表相关的数组。字段被定义成class :doc:`Phalcon\\Db\\Column <../api/Phalcon_Db_Column>` 。
下表列出了可用于定义字段的选项：

+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| 选项            | 描述                                                                                                                                       | 是否可选 |
+=================+============================================================================================================================================+==========+
| "type"          | 字段类型，传入的值必须是 :doc:`Phalcon\\Db\\Column <../api/Phalcon_Db_Column>` 的常量值（看下面的列表）                                    | 不       |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "primary"       | True的话表示列是表主键的一部分                                                                                                             | 是       |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "size"          | 字段的大小，像VARCHAR或者INTEGER类型需要用到                                                                                               | 是       |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "scale"         | 指定字段存放多少位小数，DECIMAL或者NUMBER类型时需要用到                                                                                    | 是       |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "unsigned"      | 是否有符号，INTEGER列可能需要设置是否有符号，该选项不适用于其他类型的列                                                                    | 是       |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "notNull"       | 字段是否可以储存null值（即是否为空）                                                                                                       | 是       |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "default"       | Default value (when used with :code:`"notNull" => true`).                                                                                  | 是       |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "autoIncrement" | 字段是否自增，设置了这个属性将自动填充自增整数，一个表只能设置一个列为自增属性                                                             | 是       |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "bind"          | 字段类型绑定， BIND_TYPE_* 常量告诉数据库在保存数据前怎么绑定数据类型                                                                      | 是       |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "first"         | 把字段设置为表的第一位                                                                                                                     | 是       |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+
| "after"         | 设置字段放在指定字段的后面                                                                                                                 | 是       |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------+----------+

:doc:`Phalcon\\Db <../api/Phalcon_Db>` 支持下面的数据库字段类型:

* :code:`Phalcon\Db\Column::TYPE_INTEGER`
* :code:`Phalcon\Db\Column::TYPE_DATE`
* :code:`Phalcon\Db\Column::TYPE_VARCHAR`
* :code:`Phalcon\Db\Column::TYPE_DECIMAL`
* :code:`Phalcon\Db\Column::TYPE_DATETIME`
* :code:`Phalcon\Db\Column::TYPE_CHAR`
* :code:`Phalcon\Db\Column::TYPE_TEXT`

传入 :code:`Phalcon\Db::createTable()` 的相关数组可能含有的下标：

+--------------+----------------------------------------------------------------------------------------------------------------------------------------+----------+
| 下标         | 描述                                                                                                                                   | 是否可选 |
+==============+========================================================================================================================================+==========+
| "columns"    | 一个数组包含表的所有字段，字段要定义成 :doc:`Phalcon\\Db\\Column <../api/Phalcon_Db_Column>`                                           | 不       |
+--------------+----------------------------------------------------------------------------------------------------------------------------------------+----------+
| "indexes"    | 一个数组包含表的所有索引，索引要定义成 :doc:`Phalcon\\Db\\Index <../api/Phalcon_Db_Index>`                                             | 是       |
+--------------+----------------------------------------------------------------------------------------------------------------------------------------+----------+
| "references" | 一个数组包含表的所有外键，外键要定义成 :doc:`Phalcon\\Db\\Reference <../api/Phalcon_Db_Reference>`                                     | 是       |
+--------------+----------------------------------------------------------------------------------------------------------------------------------------+----------+
| "options"    | 一个表包含所有创建的选项. 这些选项常常和数据库迁移有关.                                                                                | 是       |
+--------------+----------------------------------------------------------------------------------------------------------------------------------------+----------+

修改数据库表（Altering Tables）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
随着你的应用的增长，作为一个重构的一部分，或者增加新功能，你也许需要修改你的数据库。
因为不是所有的数据库允许你修改已存在的字段或者添加字段在2个已存在的字段之间。所以 :doc:`Phalcon\\Db <../api/Phalcon_Db>`
会受到数据库系统的这些限制。

.. code-block:: php

    <?php

    use Phalcon\Db\Column as Column;

    // 添加一个新的字段
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

    // 修改一个已存在的字段
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

    // 删除名为"name"的字段
    $connection->dropColumn(
        "robots",
        null,
        "name"
    );

删除数据库表（Dropping Tables）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
删除数据库表的例子:

.. code-block:: php

    <?php

    // 删除'robots'表
    $connection->dropTable("robots");

    // 删除数据库'machines'中的'robots'表
    $connection->dropTable("robots", "machines");

.. _PDO: http://www.php.net/manual/en/book.pdo.php
.. _`nested transactions`: http://en.wikipedia.org/wiki/Nested_transaction
