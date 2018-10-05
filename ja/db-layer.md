<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">データベース抽象化レイヤー</a> <ul>
        <li>
          <a href="#adapters">データベースアダプター</a> <ul>
            <li>
              <a href="#adapters-factory">ファクトリー</a>
            </li>
            <li>
              <a href="#adapters-custom">独自のアダプターを実装</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#dialects">データベースの方言</a> <ul>
            <li>
              <a href="#dialects-custom">独自の方言を実装します</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#connection">データベースへの接続</a>
        </li>
        <li>
          <a href="#options">PDO の追加オプションを設定</a>
        </li>
        <li>
          <a href="#finding-rows">行の検索</a>
        </li>
        <li>
          <a href="#binding-parameters">パラメーターのバインド</a>
        </li>
        <li>
          <a href="#crud">行の挿入、更新、および削除</a>
        </li>
        <li>
          <a href="#transactions">トランザクションとネストしたトランザクション</a>
        </li>
        <li>
          <a href="#events">データベースのイベント</a>
        </li>
        <li>
          <a href="#profiling">SQL ステートメントのプロファイリング</a>
        </li>
        <li>
          <a href="#logging-statements">SQL ステートメントのロギング</a>
        </li>
        <li>
          <a href="#logger-custom">独自のロガーを実装</a>
        </li>
        <li>
          <a href="#describing-tables">Describing Tables/Views</a>
        </li>
        <li>
          <a href="#tables">テーブルの作成/変更/削除</a> <ul>
            <li>
              <a href="#tables-create">テーブルの作成</a>
            </li>
            <li>
              <a href="#tables-altering">テーブルの変更</a>
            </li>
            <li>
              <a href="#tables-dropping">テーブルの削除</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# データベース抽象化レイヤー

`Phalcon\Db` は、フレームワークのモデル層で動作する`Phalcon\Mvc\Model`の背後にあるコンポーネントです。 完全にC言語で書かれた、データベースシステムでのための、独立した高度な抽象化レイヤーで構成されています。

このコンポーネントは従来のモデルを使用するよりも、データベースを低レベルで操作することができます。

<a name='adapters'></a>

## データベースアダプター

このコンポーネントはアダプターを使用して、特定のデータベースシステムの詳細をカプセル化します。Phalconでは、PDO_ を使用してデータベースに接続します。次のデータベースエンジンがサポートされます:

| クラス                                     | 説明                                                                                                             |
| --------------------------------------- | -------------------------------------------------------------------------------------------------------------- |
| `Phalcon\Db\Adapter\Pdo\Mysql`      | 世界で最も使用されているリレーショナルデータベース管理システム（RDBMS）は、多数のデータベースへのマルチユーザーアクセスを提供するサーバーとして動作します                                |
| `Phalcon\Db\Adapter\Pdo\Postgresql` | PostgreSQL は、強力なオープンソースのリレーショナルデータベースシステムです。 これは15年以上の積極的な開発と実績のあるアーキテクチャを備えており、信頼性、データの完全性、正確性について高い評価を得ています。 |
| `Phalcon\Db\Adapter\Pdo\Sqlite`     | SQLiteは、自己完結型でサーバレスでゼロ設定のトランザクション型SQLデータベースエンジンを実装したソフトウェアライブラリです                                              |

<a name='adapters-factory'></a>

### ファクトリー

<a name='factory'></a>

`adaper`オプションを使用してPDO Adapterクラスをロードします

```php
<?php

use Phalcon\Db\Adapter\Pdo\Factory;

$options = [
    'host'     => 'localhost',
    'dbname'   => 'blog',
    'port'     => 3306,
    'username' => 'sigma',
    'password' => 'secret',
    'adapter'  => 'mysql',
];

$db = Factory::load($options);
```

<a name='adapters-custom'></a>

### 独自のアダプターを実装

独自のデータベースアダプターを作成したり、既存のデータベースアダプターを拡張するには、`Phalcon\Db\AdapterInterface`インターフェースを実装する必要があります。

<a name='dialects'></a>

## データベースの方言

Phalconは、各データベースエンジンの特定の詳細を方言にカプセル化します。 これらは共通の機能とSQLジェネレータをアダプタに提供します。

| クラス                                | 説明                           |
| ---------------------------------- | ---------------------------- |
| `Phalcon\Db\Dialect\Mysql`      | MySQL データベースシステム向けのSQL方言     |
| `Phalcon\Db\Dialect\Postgresql` | PostgreSQLデータベースシステム向けのSQL方言 |
| `Phalcon\Db\Dialect\Sqlite`     | SQLiteデータベースシステム向けのSQL方言     |

<a name='dialects-custom'></a>

### 独自の方言を実装します

独自のデータベース方言を作成したり既存のデータベース方言を拡張するには、`Phalcon\Db\DialectInterface`インタフェースを実装する必要があります。 PHQLが理解するより多くのコマンドやメソッドを追加して、現在の方言を強化できます。

例えば MySQL アダプターを使用する場合は、PHQL が認識できるように`MATCH... AGAINST...`構文を使うことできます。私達は、この構文を`MATCH_AGAINST` と関連付けます。

方言をインスタンス化します。 カスタム関数を追加して、PHQLが、パースプロセス中にこれを検出したときに、理解できるようにします。 次の例では、`MATCH_AGAINST` と呼ばれる新しいカスタム関数を登録します。 その後、カスタマイズされた方言オブジェクトをDBコネクションに追加するだけです。

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

PHQLでこの新しい関数を使用できます。この場合、これは適切なSQL構文に翻訳されます:

```php
$phql = "
  SELECT *
  FROM   Posts
  WHERE  MATCH_AGAINST(title, :pattern:)";

$posts = $modelsManager->executeQuery($phql, ['pattern' => $pattern]);
```

<a name='connection'></a>

## データベースへの接続

接続を作成するためには、アダプター クラスをインスタンス化する必要があります。 接続パラメーターの配列だけが必要です。 次の例は、必須またはオプションのパラメーターを渡す接続を作成する方法を示しています。

##### MySQL 必須要素

```php
<?php

$config = [
    'host'     => '127.0.0.1',
    'username' => 'mike',
    'password' => 'sigma',
    'dbname'   => 'test_db',
];
```

##### MySQL オプション

```php
$config['persistent'] = false;
```

##### MySQLの接続を作成

```php
$connection = new \Phalcon\Db\Adapter\Pdo\Mysql($config);
```

##### PostgreSQL 必須要素

```php
<?php

$config = [
    'host'     => 'localhost',
    'username' => 'postgres',
    'password' => 'secret1',
    'dbname'   => 'template',
];
```

##### PostgreSQL オプション

```php
$config['schema'] = 'public';
```

##### PostgreSQLの接続を作成

```php
$connection = new \Phalcon\Db\Adapter\Pdo\Postgresql($config);
```

##### SQLite 必須要素

```php
<?php

$config = [
    'dbname' => '/path/to/database.db',
];
```

##### SQLite接続を作成

```php
$connection = new \Phalcon\Db\Adapter\Pdo\Sqlite($config);
```

<a name='options'></a>

## PDO の追加オプションを設定

`options`パラメータを渡すことで接続時にPDOオプションを設定できます:

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

<a name='finding-rows'></a>

## 行の検索

`Phalcon\Db` は、テーブルから行を照会するいくつかのメソッドを提供します。この場合、対象のデータベースエンジン固有のSQL構文が必要です:

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

By default these calls create arrays with both associative and numeric indexes. You can change this behavior by using `Phalcon\Db\Result::setFetchMode()`. This method receives a constant, defining which kind of index is required.

| Constant                   | Description                                               |
| -------------------------- | --------------------------------------------------------- |
| `Phalcon\Db::FETCH_NUM`   | Return an array with numeric indexes                      |
| `Phalcon\Db::FETCH_ASSOC` | Return an array with associative indexes                  |
| `Phalcon\Db::FETCH_BOTH`  | Return an array with both associative and numeric indexes |
| `Phalcon\Db::FETCH_OBJ`   | Return an object instead of an array                      |

```php
<?php

$sql = 'SELECT id, name FROM robots ORDER BY name';
$result = $connection->query($sql);

$result->setFetchMode(Phalcon\Db::FETCH_NUM);
while ($robot = $result->fetch()) {
   echo $robot[0];
}
```

The `Phalcon\Db::query()` returns an instance of `Phalcon\Db\Result\Pdo`. These objects encapsulate all the functionality related to the returned resultset i.e. traversing, seeking specific records, count etc.

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

## パラメーターのバインド

Bound parameters is also supported in `Phalcon\Db`. Although there is a minimal performance impact by using bound parameters, you are encouraged to use this methodology so as to eliminate the possibility of your code being subject to SQL injection attacks. Both string and positional placeholders are supported. Binding parameters can simply be achieved as follows:

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

When using numeric placeholders, you will need to define them as integers i.e. 1 or 2. In this case '1' or '2' are considered strings and not numbers, so the placeholder could not be successfully replaced. With any adapter data are automatically escaped using [PDO Quote](http://www.php.net/manual/en/pdo.quote.php).

This function takes into account the connection charset, so its recommended to define the correct charset in the connection parameters or in your database server configuration, as a wrong charset will produce undesired effects when storing or retrieving data.

Also, you can pass your parameters directly to the execute/query methods. In this case bound parameters are directly passed to PDO:

```php
<?php

// Binding with PDO placeholders
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

To insert, update or delete rows, you can use raw SQL or use the preset functions provided by the class:

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

## トランザクションとネストしたトランザクション

Working with transactions is supported as it is with PDO. Perform data manipulation inside transactions often increase the performance on most database systems:

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

In addition to standard transactions, `Phalcon\Db` provides built-in support for [nested transactions](http://en.wikipedia.org/wiki/Nested_transaction) (if the database system used supports them). When you call begin() for a second time a nested transaction is created:

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

## データベースのイベント

`Phalcon\Db` is able to send events to a [EventsManager](/[[language]]/[[version]]/events) if it's present. Some events when returning boolean false could stop the active operation. The following events are supported:

| Event Name            | Triggered                                            | Can stop operation? |
| --------------------- | ---------------------------------------------------- |:-------------------:|
| `afterConnect`        | After a successfully connection to a database system |         No          |
| `beforeQuery`         | Before send a SQL statement to the database system   |         Yes         |
| `afterQuery`          | After send a SQL statement to database system        |         No          |
| `beforeDisconnect`    | Before close a temporal database connection          |         No          |
| `beginTransaction`    | Before a transaction is going to be started          |         No          |
| `rollbackTransaction` | Before a transaction is rollbacked                   |         No          |
| `commitTransaction`   | Before a transaction is committed                    |         No          |

Bind an EventsManager to a connection is simple, `Phalcon\Db` will trigger the events with the type `db`:

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

## SQL ステートメントのプロファイリング

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

## SQL ステートメントのロギング

Using high-level abstraction components such as `Phalcon\Db` to access a database, it is difficult to understand which statements are sent to the database system. `Phalcon\Logger` interacts with `Phalcon\Db`, providing logging capabilities on the database abstraction layer.

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

As above, the file `app/logs/db.log` will contain something like this:

```bash
[Sun, 29 Apr 12 22:35:26 -0500][DEBUG][Resource Id #77] INSERT INTO products
(name, price) VALUES ('Hot pepper', 3.50)
```

<a name='logger-custom'></a>

## 独自のロガーを実装

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

| Field        | Type        | Key                                                | Null                               |
| ------------ | ----------- | -------------------------------------------------- | ---------------------------------- |
| Field's name | Column Type | Is the column part of the primary key or an index? | Does the column allow null values? |

Methods to get information about views are also implemented for every supported database system:

```php
<?php

// Get views on the test_db database
$tables = $connection->listViews('test_db');

// Is there a view 'robots' in the database?
$exists = $connection->viewExists('robots');
```

<a name='tables'></a>

## テーブルの作成/変更/削除

Different database systems (MySQL, Postgresql etc.) offer the ability to create, alter or drop tables with the use of commands such as CREATE, ALTER or DROP. The SQL syntax differs based on which database system is used. `Phalcon\Db` offers a unified interface to alter tables, without the need to differentiate the SQL syntax based on the target storage system.

<a name='tables-create'></a>

### テーブルの作成

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

| Option          | 説明                                                                                                                                         | Optional |
| --------------- | ------------------------------------------------------------------------------------------------------------------------------------------ |:--------:|
| `type`          | Column type. Must be a `Phalcon\Db\Column` constant (see below for a list)                                                               |    No    |
| `primary`       | True if the column is part of the table's primary key                                                                                      |   Yes    |
| `size`          | Some type of columns like `VARCHAR` or `INTEGER` may have a specific size                                                                  |   Yes    |
| `scale`         | `DECIMAL` or `NUMBER` columns may be have a scale to specify how many decimals should be stored                                            |   Yes    |
| `unsigned`      | `INTEGER` columns may be signed or unsigned. This option does not apply to other types of columns                                          |   Yes    |
| `notNull`       | Column can store null values?                                                                                                              |   Yes    |
| `default`       | Default value (when used with `'notNull' => true`).                                                                                     |   Yes    |
| `autoIncrement` | With this attribute column will filled automatically with an auto-increment integer. Only one column in the table can have this attribute. |   Yes    |
| `bind`          | One of the `BIND_TYPE_*` constants telling how the column must be bound before save it                                                     |   Yes    |
| `first`         | Column must be placed at first position in the column order                                                                                |   Yes    |
| `after`         | Column must be placed after indicated column                                                                                               |   Yes    |

`Phalcon\Db` supports the following database column types:

- `Phalcon\Db\Column::TYPE_INTEGER`
- `Phalcon\Db\Column::TYPE_DATE`
- `Phalcon\Db\Column::TYPE_VARCHAR`
- `Phalcon\Db\Column::TYPE_DECIMAL`
- `Phalcon\Db\Column::TYPE_DATETIME`
- `Phalcon\Db\Column::TYPE_CHAR`
- `Phalcon\Db\Column::TYPE_TEXT`

The associative array passed in `Phalcon\Db::createTable()` can have the possible keys:

| Index        | 説明                                                                                                                                     | Optional |
| ------------ | -------------------------------------------------------------------------------------------------------------------------------------- |:--------:|
| `columns`    | An array with a set of table columns defined with `Phalcon\Db\Column`                                                                |    No    |
| `indexes`    | An array with a set of table indexes defined with `Phalcon\Db\Index`                                                                 |   Yes    |
| `references` | An array with a set of table references (foreign keys) defined with `Phalcon\Db\Reference`                                           |   Yes    |
| `options`    | An array with a set of table creation options. These options often relate to the database system in which the migration was generated. |   Yes    |

<a name='tables-altering'></a>

### テーブルの変更

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

### テーブルの削除

Examples on dropping tables:

```php
<?php

// Drop table robot from active database
$connection->dropTable('robots');

// Drop table robot from database 'machines'
$connection->dropTable('robots', 'machines');
```