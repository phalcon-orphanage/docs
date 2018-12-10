<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">数据库抽象层</a> <ul>
        <li>
          <a href="#adapters">数据库适配器</a> <ul>
            <li>
              <a href="#adapters-custom">实现自己的适配器</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#dialects">数据库语言</a> <ul>
            <li>
              <a href="#dialects-custom">执行您自己的DI注入器</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#connection">连接到数据库</a> <ul>
            <li>
              <a href="#connection-factory">Connecting using Factory</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#options">PDO 的附加选项设置</a>
        </li>
        <li>
          <a href="#finding-rows">Finding Rows</a>
        </li>
        <li>
          <a href="#binding-parameters">绑定参数</a>
        </li>
        <li>
          <a href="#crud">插入/更新/删除行</a>
        </li>
        <li>
          <a href="#transactions">事务和嵌套的事务</a>
        </li>
        <li>
          <a href="#events">数据库事件</a>
        </li>
        <li>
          <a href="#profiling">分析 SQL 语句</a>
        </li>
        <li>
          <a href="#logging-statements">日志记录的 SQL 语句</a>
        </li>
        <li>
          <a href="#logger-custom">执行您自己的记录器</a>
        </li>
        <li>
          <a href="#describing-tables">描述表/视图</a>
        </li>
        <li>
          <a href="#tables">[创建/更改/删除]表</a> <ul>
            <li>
              <a href="#tables-create">创建表</a>
            </li>
            <li>
              <a href="#tables-altering">变更表</a>
            </li>
            <li>
              <a href="#tables-dropping">删除表</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# 数据库抽象层

在框架中，`Phalcon\Db` 是 `Phalcon\Mvc\Model` 模型层后面的一个组件。 它是由数据库系统完全用 C 编写的一个独立的高级别抽象层

此组件允许比使用传统模式更低的级别的数据库操作。

<a name='adapters'></a>

## 数据库适配器

此组件使用适配器来封装特定的数据库系统的详细信息。尔康使用 PDO_ 连接到数据库。支持以下数据库引擎：

| 类                                   | 描述                                                                               |
| ----------------------------------- | -------------------------------------------------------------------------------- |
| `Phalcon\Db\Adapter\Pdo\Mysql`  | 是世界上使用最多的关系数据库管理系统 (RDBMS)，作为提供多用户访问数量的数据库服务器运行                                  |
| `Phalcon\Db\Adapter\Pdo\Mysql`  | PostgreSQL 是一个功能强大的开源关系型数据库系统。 它有超过 15 年的积极发展和行之有效的体系结构，它赢得了良好声誉的可靠性、 数据完整性和正确性。 |
| `Phalcon\Db\Adapter\Pdo\Sqlite` | SQLite 是一个软件库，实现了一个自包含、 无服务器、 零配置、 事务性的 SQL 数据库引擎                                |

<a name='adapters-custom'></a>

### Implementing your own adapters

以创建您自己的数据库适配器或扩展现有的必须实现 `Phalcon\Db\AdapterInterface` 接口。

<a name='dialects'></a>

## 数据库语言

Phalcon封装在方言中每个数据库引擎的具体细节。那些向适配器提供常见的函数和 SQL 生成器。

| 类                                  | 描述                        |
| ---------------------------------- | ------------------------- |
| `Phalcon\Db\Dialect\Mysql`      | SQL 特定方言为 MySQL 数据库系统的    |
| `Phalcon\Db\Dialect\Postgresql` | SQL 特定方言 PostgreSQL 数据库系统 |
| `Phalcon\Db\Dialect\Sqlite`     | SQLite 数据库系统的 SQL 特定方言    |

<a name='dialects-custom'></a>

### 执行您自己的DI注入器

以创建您自己的数据库方言或扩展现有的必须实现 `Phalcon\Db\DialectInterface` 接口。 您还可以通过添加 PHQL 将了解的更多命令/方法来增强当前语言。

例如, 当使用 MySQL 适配器时, 您可能希望允许 PHQL 识别 ` MATCH ... AGAINST ...`语法。我们将该语法与 ` MATCH_AGAINST ` 相关联

我们实例化方言。 我们添加自定义函数, 以便 PHQL 了解在分析过程中找到它时应执行的操作。 在下面的示例中, 我们注册了一个名为 ` MATCH_AGAINST ` 的新自定义函数。 之后, 我们要做的就是添加自定义的语言解析器对象到我们的连接。

```php
<?php

use Phalcon\Db\Dialect\MySQL as SqlDialect;
use Phalcon\Db\Adapter\Pdo\MySQL as Connection;

$dialect = new SqlDialect();

$dialect->registerCustomFunction(
    'MATCH_AGAINST',
    function($dialect, $expression) {
        $arguments = $expression['arguments'];
        return sprintf(
            " MATCH (%s) AGAINST (%)",
            $dialect->getSqlExpression($arguments[0]),
            $dialect->getSqlExpression($arguments[1])
         );
    }
);

$connection = new Connection(
    [
        "host"          => "localhost",
        "username"      => "root",
        "password"      => "",
        "dbname"        => "test",
        "dialectClass"  => $dialect
    ]
);
```

我们现在可以在PHQL中使用这个新函数，而后者又将其转换为正确的SQL语法：

```php
$phql = "
  SELECT *
  FROM   Posts
  WHERE  MATCH_AGAINST(title, :pattern:)";

$posts = $modelsManager->executeQuery($phql, ['pattern' => $pattern]);
```

<a name='connection'></a>

## 连接到数据库

要创建连接，必须实例化适配器类。 它只需要一个连接参数的数组。 下面的示例演示如何创建连接传递必需和可选的参数：

##### MySQL 必须的参数

```php
<?php

$config = [
    'host'     => '127.0.0.1',
    'username' => 'mike',
    'password' => 'sigma',
    'dbname'   => 'test_db',
];
```

##### MySQL 参数

```php
$config['persistent'] = false;
```

##### 创建一个MySQL 连接

```php
$connection = new \Phalcon\Db\Adapter\Pdo\Mysql($config);
```

##### PostgreSQL 必须的参数

```php
<?php

$config = [
    'host'     => 'localhost',
    'username' => 'postgres',
    'password' => 'secret1',
    'dbname'   => 'template',
];
```

##### PostgreSQL 参数

```php
$config['schema'] = 'public';
```

##### 创建一个PostgreSQL 连接

```php
$connection = new \Phalcon\Db\Adapter\Pdo\Postgresql($config);
```

##### SQLite 必须的参数

```php
<?php

$config = [
    'dbname' => '/path/to/database.db',
];
```

##### 创建一个SQLite 连接

```php
$connection = new \Phalcon\Db\Adapter\Pdo\Sqlite($config);
```

<a name='options'></a>

## PDO 的附加选项设置

通过传递参数 `options`，可以设置在连接时的 PDO 选项：

```php
<?php

$connection = new \Phalcon\Db\Adapter\Pdo\Mysql(
    [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'sigma',
        'dbname'   => 'test_db',
        'options'  => [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
            PDO::ATTR_CASE               => PDO::CASE_LOWER,
        ]
    ]
);
```

<a name='connection-factory'></a>

## Connecting using Factory

You can also use a simple `ini` file to configure/connect your `db` service to your database.

```ini
[database]
host = TEST_DB_MYSQL_HOST
username = TEST_DB_MYSQL_USER
password = TEST_DB_MYSQL_PASSWD
dbname = TEST_DB_MYSQL_NAME
port = TEST_DB_MYSQL_PORT
charset = TEST_DB_MYSQL_CHARSET
adapter = mysql
```

```php
<?php

use Phalcon\Config\Adapter\Ini;
use Phalcon\Di;
use Phalcon\Db\Adapter\Pdo\Factory;

$di = new Di();
$config = new Ini('config.ini');

$di->set('config', $config);

$di->set(
    'db', 
    function () {
        return Factory::load($this->config->database);
    }
);
```

The above will return the correct database instance and also has the advantage that you can change the connection credentials or even the database adapter without changing a single line of code in your application.

<a name='finding-rows'></a>

## Finding Rows

`Phalcon\Db` 提供几个方法查询行从表。在这种情况下的具体的 SQL 语法的目标数据库引擎是必需的：

```php
<?php

$sql = 'SELECT id, name FROM robots ORDER BY name';

// Send a SQL statement to the database system
$result = $connection->query($sql);

// Print each robot name
while ($robot = $result->fetch()) {
   echo $robot['name'];
}

// Get all rows in an array
$robots = $connection->fetchAll($sql);
foreach ($robots as $robot) {
   echo $robot['name'];
}

// Get only the first row
$robot = $connection->fetchOne($sql);
```

By default these calls create arrays with both associative and numeric indexes. 通过使用 `Phalcon\Db\Result::setFetchMode()`，您可以更改此行为。 此方法接收一个常数，确定哪种类型的索引所需。

| 常量：                        | 描述            |
| -------------------------- | ------------- |
| `Phalcon\Db::FETCH_NUM`   | 返回一个数字索引的数组   |
| `Phalcon\Db::FETCH_ASSOC` | 返回一个数组具有关联的索引 |
| `Phalcon\Db::FETCH_BOTH`  | 返回与关联和数字索引数组  |
| `Phalcon\Db::FETCH_OBJ`   | 返回一个对象而不是数组   |

```php
<?php

$sql = 'SELECT id, name FROM robots ORDER BY name';
$result = $connection->query($sql);

$result->setFetchMode(Phalcon\Db::FETCH_NUM);
while ($robot = $result->fetch()) {
   echo $robot[0];
}
```

`Phalcon\Db::query()` 将返回 `Phalcon\Db\Result\Pdo` 的一个实例。 这些对象封装了所有与返回的结果集有关的功能函数，例如遍历、查找特定记录、计数等等。

```php
<?php

$sql = 'SELECT id, name FROM robots';
$result = $connection->query($sql);

// Traverse the resultset
while ($robot = $result->fetch()) {
   echo $robot['name'];
}

// Seek to the third row
$result->seek(2);
$robot = $result->fetch();

// Count the resultset
echo $result->numRows();
```

<a name='binding-parameters'></a>

## Binding Parameters

在 `Phalcon\Db` 也支持绑定的参数。 虽然通过使用绑定的参数的最小的性能影响，你被鼓励使用此方法，以消除您的代码受到 SQL 注入式攻击的可能性。 支持字符串和位置的占位符。 绑定参数可以简单地实现，如下所示：

```php
<?php

// Binding with numeric placeholders
$sql    = 'SELECT * FROM robots WHERE name = ? ORDER BY name';
$result = $connection->query(
    $sql,
    [
        'Wall-E',
    ]
);

// Binding with named placeholders
$sql     = 'INSERT INTO `robots`(name`, year) VALUES (:name, :year)';
$success = $connection->query(
    $sql,
    [
        'name' => 'Astro Boy',
        'year' => 1952,
    ]
);
```

当使用数字占位符，您将需要将它们定义为即 1 或 2 的整数。 在这种情况下 '1' 或 '2' 是字符串而不是数字，所以该占位符不能被成功替换。 与任何适配器数据自动转义使用 [PDO Quota](http://www.php.net/manual/en/pdo.quote.php)。

此函数还考虑连接字符集，它建议要在连接参数中或在您的数据库服务器配置，作为错误的字符集中定义正确的字符集将产生意外的影响，在存储或检索数据时。

另外，你可以直接传递参数给执行/查询方法。在这种情况下， 绑定的参数将直接传递给 PDO：

```php
<?php

// 使用 PDO 占位符绑定
$sql    = 'SELECT * FROM robots WHERE name = ? ORDER BY name';
$result = $connection->query(
    $sql,
    [
        1 => 'Wall-E',
    ]
);
```

<a name='crud'></a>

## Inserting/Updating/Deleting Rows

插入、 更新或删除行的你可以使用原始 SQL 或使用类所提供的预设的函数：

```php
<?php

// Inserting data with a raw SQL statement
$sql     = 'INSERT INTO `robots`(`name`, `year`) VALUES ('Astro Boy', 1952)';
$success = $connection->execute($sql);

// With placeholders
$sql     = 'INSERT INTO `robots`(`name`, `year`) VALUES (?, ?)';
$success = $connection->execute(
    $sql,
    [
        'Astro Boy',
        1952,
    ]
);

// Generating dynamically the necessary SQL
$success = $connection->insert(
    'robots',
    [
        'Astro Boy',
        1952,
    ],
    [
        'name',
        'year',
    ],
);

// Generating dynamically the necessary SQL (another syntax)
$success = $connection->insertAsDict(
    'robots',
    [
        'name' => 'Astro Boy',
        'year' => 1952,
    ]
);

// Updating data with a raw SQL statement
$sql     = 'UPDATE `robots` SET `name` = 'Astro boy' WHERE `id` = 101';
$success = $connection->execute($sql);

// With placeholders
$sql     = 'UPDATE `robots` SET `name` = ? WHERE `id` = ?';
$success = $connection->execute(
    $sql,
    [
        'Astro Boy',
        101,
    ]
);

// Generating dynamically the necessary SQL
$success = $connection->update(
    'robots',
    [
        'name',
    ],
    [
        'New Astro Boy',
    ],
    'id = 101' // Warning! In this case values are not escaped
);

// Generating dynamically the necessary SQL (another syntax)
$success = $connection->updateAsDict(
    'robots',
    [
        'name' => 'New Astro Boy',
    ],
    'id = 101' // Warning! In this case values are not escaped
);

// With escaping conditions
$success = $connection->update(
    'robots',
    [
        'name',
    ],
    [
        'New Astro Boy',
    ],
    [
        'conditions' => 'id = ?',
        'bind'       => [101],
        'bindTypes'  => [PDO::PARAM_INT], // Optional parameter
    ]
);
$success = $connection->updateAsDict(
    'robots',
    [
        'name' => 'New Astro Boy',
    ],
    [
        'conditions' => 'id = ?',
        'bind'       => [101],
        'bindTypes'  => [PDO::PARAM_INT], // Optional parameter
    ]
);

// Deleting data with a raw SQL statement
$sql     = 'DELETE `robots` WHERE `id` = 101';
$success = $connection->execute($sql);

// With placeholders
$sql     = 'DELETE `robots` WHERE `id` = ?';
$success = $connection->execute($sql, [101]);

// Generating dynamically the necessary SQL
$success = $connection->delete(
    'robots',
    'id = ?',
    [
        101,
    ]
);
```

<a name='transactions'></a>

## Transactions and Nested Transactions

它是与 PDO 支持与交易工作。在大多数数据库系统上执行数据操作在事务内部经常增加的性能：

```php
<?php

try {
    // Start a transaction
    $connection->begin();

    // Execute some SQL statements
    $connection->execute('DELETE `robots` WHERE `id` = 101');
    $connection->execute('DELETE `robots` WHERE `id` = 102');
    $connection->execute('DELETE `robots` WHERE `id` = 103');

    // Commit if everything goes well
    $connection->commit();
} catch (Exception $e) {
    // An exception has occurred rollback the transaction
    $connection->rollback();
}
```

除了标准的交易，`Phalcon\Db` 提供内置支持 [嵌套](http://en.wikipedia.org/wiki/Nested_transaction) 事务 （如果使用的数据库系统支持它们）。 当第二次调用链表你嵌套的事务创建：

```php
<?php

try {
    // Start a transaction
    $connection->begin();

    // Execute some SQL statements
    $connection->execute('DELETE `robots` WHERE `id` = 101');

    try {
        // Start a nested transaction
        $connection->begin();

        // Execute these SQL statements into the nested transaction
        $connection->execute('DELETE `robots` WHERE `id` = 102');
        $connection->execute('DELETE `robots` WHERE `id` = 103');

        // Create a save point
        $connection->commit();
    } catch (Exception $e) {
        // An error has occurred, release the nested transaction
        $connection->rollback();
    }

    // Continue, executing more SQL statements
    $connection->execute('DELETE `robots` WHERE `id` = 104');

    // Commit if everything goes well
    $connection->commit();
} catch (Exception $e) {
    // An exception has occurred rollback the transaction
    $connection->rollback();
}
```

<a name='events'></a>

## Database Events

`Phalcon\Db` 是能够将事件发送到 [EventsManager](/[[language]]/[[version]]/events)，如果它是存在的。 一些事件可以通过返回false来停止当前操作。 The following events are supported:

| Event Name            | Triggered          | Can stop operation? |
| --------------------- | ------------------ |:-------------------:|
| `afterConnect`        | 后成功连接到数据库系统        |         No          |
| `beforeQuery`         | 之前将 SQL 语句发送到数据库系统 |         Yes         |
| `afterQuery`          | 后将 SQL 语句发送到数据库系统  |         No          |
| `beforeDisconnect`    | 之前关闭时态数据库连接        |         No          |
| `beginTransaction`    | 启动事务之前             |         No          |
| `rollbackTransaction` | 在事务回滚之前            |         No          |
| `commitTransaction`   | 在一个事务被提交之前         |         No          |

绑定 EventsManager 到数据库连接就是这么简单，`Phalcon\Db` 将触发事件与 `db` 类型:

```php
<?php

use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Adapter\Pdo\Mysql as Connection;

$eventsManager = new EventsManager();

// Listen all the database events
$eventsManager->attach('db', $dbListener);

$connection = new Connection(
    [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'secret',
        'dbname'   => 'invo',
    ]
);

// Assign the eventsManager to the db adapter instance
$connection->setEventsManager($eventsManager);
```

Stop SQL operations are very useful if for example you want to implement some last-resource SQL injector checker:

```php
<?php

use Phalcon\Events\Event;

$eventsManager->attach(
    'db:beforeQuery',
    function (Event $event, $connection) {
        $sql = $connection->getSQLStatement();

        // Check for malicious words in SQL statements
        if (preg_match('/DROP|ALTER/i', $sql)) {
            // DROP/ALTER operations aren't allowed in the application,
            // this must be a SQL injection!
            return false;
        }

        // It's OK
        return true;
    }
);
```

<a name='profiling'></a>

## Profiling SQL Statements

`Phalcon\Db` includes a profiling component called `Phalcon\Db\Profiler`, that is used to analyze the performance of database operations so as to diagnose performance problems and discover bottlenecks.

Database profiling is really easy With `Phalcon\Db\Profiler`:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Profiler as DbProfiler;

$eventsManager = new EventsManager();

$profiler = new DbProfiler();

// Listen all the database events
$eventsManager->attach(
    'db',
    function (Event $event, $connection) use ($profiler) {
        if ($event->getType() === 'beforeQuery') {
            $sql = $connection->getSQLStatement();

            // Start a profile with the active connection
            $profiler->startProfile($sql);
        }

        if ($event->getType() === 'afterQuery') {
            // Stop the active profile
            $profiler->stopProfile();
        }
    }
);

// Assign the events manager to the connection
$connection->setEventsManager($eventsManager);

$sql = 'SELECT buyer_name, quantity, product_name '
     . 'FROM buyers '
     . 'LEFT JOIN products ON buyers.pid = products.id';

// Execute a SQL statement
$connection->query($sql);

// Get the last profile in the profiler
$profile = $profiler->getLastProfile();

echo 'SQL Statement: ', $profile->getSQLStatement(), "\n";
echo 'Start Time: ', $profile->getInitialTime(), "\n";
echo 'Final Time: ', $profile->getFinalTime(), "\n";
echo 'Total Elapsed Time: ', $profile->getTotalElapsedSeconds(), "\n";
```

You can also create your own profile class based on `Phalcon\Db\Profiler` to record real time statistics of the statements sent to the database system:

```php
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
$eventsManager->attach('db', $dbProfiler);
```

<a name='logging-statements'></a>

## Logging SQL Statements

Using high-level abstraction components such as `Phalcon\Db` to access a database, it is difficult to understand which statements are sent to the database system. `Phalcon\Logger`与`Phalcon\Db`交互，使数据库抽象层具有日志功能。

```php
<?php

use Phalcon\Logger;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Logger\Adapter\File as FileLogger;

$eventsManager = new EventsManager();

$logger = new FileLogger('app/logs/db.log');

$eventsManager->attach(
    'db:beforeQuery',
    function (Event $event, $connection) use ($logger) {
        $sql = $connection->getSQLStatement();

        $logger->log($sql, Logger::INFO);
    }
);

// Assign the eventsManager to the db adapter instance
$connection->setEventsManager($eventsManager);

// Execute some SQL statement
$connection->insert(
    'products',
    [
        'Hot pepper',
        3.50,
    ],
    [
        'name',
        'price',
    ]
);
```

如上所述，`app/logs/db.log` 文件将包含这样的事情：

```bash
[Sun, 29 Apr 12 22:35:26 -0500][DEBUG][Resource Id #77] INSERT INTO products
(name, price) VALUES ('Hot pepper', 3.50)
```

<a name='logger-custom'></a>

## Implementing your own Logger

You can implement your own logger class for database queries, by creating a class that implements a single method called `log`. The method needs to accept a string as the first argument. You can then pass your logging object to `Phalcon\Db::setLogger()`, and from then on any SQL statement executed will call that method to log the results.

<a name='describing-tables'></a>

## Describing Tables/Views

`Phalcon\Db` also provides methods to retrieve detailed information about tables and views:

```php
<?php

// Get tables on the test_db database
$tables = $connection->listTables('test_db');

// Is there a table 'robots' in the database?
$exists = $connection->tableExists('robots');

// Get name, data types and special features of 'robots' fields
$fields = $connection->describeColumns('robots');
foreach ($fields as $field) {
    echo 'Column Type: ', $field['Type'];
}

// Get indexes on the 'robots' table
$indexes = $connection->describeIndexes('robots');
foreach ($indexes as $index) {
    print_r(
        $index->getColumns()
    );
}

// Get foreign keys on the 'robots' table
$references = $connection->describeReferences('robots');
foreach ($references as $reference) {
    // Print referenced columns
    print_r(
        $reference->getReferencedColumns()
    );
}
```

A table description is very similar to the MySQL describe command, it contains the following information:

| 字段   | 类型  | 关键字           | Null      |
| ---- | --- | ------------- | --------- |
| 字段名称 | 列类型 | 是的主键或索引的列部分吗？ | 该列是否允许空值？ |

Methods to get information about views are also implemented for every supported database system:

```php
<?php

// 获取test_db数据库上的视图
$tables = $connection->listViews('test_db');

// 数据库中是否有“robots”视图?
$exists = $connection->viewExists('robots');
```

<a name='tables'></a>

## Creating/Altering/Dropping Tables

Different database systems (MySQL, Postgresql etc.) offer the ability to create, alter or drop tables with the use of commands such as CREATE, ALTER or DROP. The SQL syntax differs based on which database system is used. `Phalcon\Db` 提供了一个统一的接口来更改表, 而无需根据目标存储系统区分 sql 语法。

<a name='tables-create'></a>

### Creating Tables

The following example shows how to create a table:

```php
<?php

use \Phalcon\Db\Column as Column;

$connection->createTable(
    'robots',
    null,
    [
       'columns' => [
            new Column(
                'id',
                [
                    'type'          => Column::TYPE_INTEGER,
                    'size'          => 10,
                    'notNull'       => true,
                    'autoIncrement' => true,
                    'primary'       => true,
                ]
            ),
            new Column(
                'name',
                [
                    'type'    => Column::TYPE_VARCHAR,
                    'size'    => 70,
                    'notNull' => true,
                ]
            ),
            new Column(
                'year',
                [
                    'type'    => Column::TYPE_INTEGER,
                    'size'    => 11,
                    'notNull' => true,
                ]
            ),
        ]
    ]
);
```

`Phalcon\Db::createTable()` accepts an associative array describing the table. Columns are defined with the class `Phalcon\Db\Column`. The table below shows the options available to define a column:

| Option     | 描述                                                                                                | 可选  |
| ---------- | ------------------------------------------------------------------------------------------------- |:---:|
| `type`     | 列类型。必须是一个 `Phalcon\Db\Column` 常量 （见下面列表）                                                        | No  |
| `primary`  | 如果列是表的主键的一部分                                                                                      | Yes |
| `size`     | Some type of columns like `VARCHAR` or `INTEGER` may have a specific size                         | Yes |
| `scale`    | `DECIMAL` or `NUMBER` columns may be have a scale to specify how many decimals should be stored   | Yes |
| `unsigned` | `INTEGER` columns may be signed or unsigned. This option does not apply to other types of columns | Yes |
| `notNull`  | 列可以存储 null 值吗？                                                                                    | Yes |
| `default`  | Default value (when used with `'notNull' => true`).                                            | Yes |
| `自动增量`     | 用此属性列将自动填充与自动递增的整数。表中的只有一列可以具有此属性。                                                                | Yes |
| `bind`     | `BIND_TYPE_ *` 常量告诉如何列必须绑定之前之一保存它                                                                 | Yes |
| `first`    | 列必须放置在第一个位置中的列顺序                                                                                  | Yes |
| `after`    | 列必须置于之后指定列                                                                                        | Yes |

`Phalcon\Db` supports the following database column types:

- `Phalcon\Db\Column::TYPE_INTEGER`
- `Phalcon\Db\Column::TYPE_DATE`
- `Phalcon\Db\Column::TYPE_VARCHAR`
- `Phalcon\Db\Column::TYPE_DECIMAL`
- `Phalcon\Db\Column::TYPE_DATETIME`
- `Phalcon\Db\Column::TYPE_CHAR`
- `Phalcon\Db\Column::TYPE_TEXT`

The associative array passed in `Phalcon\Db::createTable()` can have the possible keys:

| 索引           | 描述                                                                                                                                     | Optional |
| ------------ | -------------------------------------------------------------------------------------------------------------------------------------- |:--------:|
| `columns`    | An array with a set of table columns defined with `Phalcon\Db\Column`                                                                |    No    |
| `indexes`    | An array with a set of table indexes defined with `Phalcon\Db\Index`                                                                 |   Yes    |
| `references` | An array with a set of table references (foreign keys) defined with `Phalcon\Db\Reference`                                           |   Yes    |
| `options`    | An array with a set of table creation options. These options often relate to the database system in which the migration was generated. |   Yes    |

<a name='tables-altering'></a>

### Altering Tables

As your application grows, you might need to alter your database, as part of a refactoring or adding new features. Not all database systems allow to modify existing columns or add columns between two existing ones. `Phalcon\Db` is limited by these constraints.

```php
<?php

use Phalcon\Db\Column as Column;

// Adding a new column
$connection->addColumn(
    'robots',
    null,
    new Column(
        'robot_type',
        [
            'type'    => Column::TYPE_VARCHAR,
            'size'    => 32,
            'notNull' => true,
            'after'   => 'name',
        ]
    )
);

// Modifying an existing column
$connection->modifyColumn(
    'robots',
    null,
    new Column(
        'name',
        [
            'type'    => Column::TYPE_VARCHAR,
            'size'    => 40,
            'notNull' => true,
        ]
    )
);

// Deleting the column 'name'
$connection->dropColumn(
    'robots',
    null,
    'name'
);
```

<a name='tables-dropping'></a>

### Dropping Tables

在删除表的例子：

```php
<?php

// Drop table robot from active database
$connection->dropTable('robots');

// Drop table robot from database 'machines'
$connection->dropTable('robots', 'machines');
```