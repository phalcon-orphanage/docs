<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">データベース抽象化レイヤー</a> <ul>
        <li>
          <a href="#adapters">データベースアダプター</a> <ul>
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
          <a href="#connection">データベースへの接続</a> <ul>
            <li>
              <a href="#connection-factory">Factoryを使用した接続</a>
            </li>
          </ul>
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
          <a href="#crud">ロウの挿入、更新、および削除</a>
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
          <a href="#describing-tables">テーブル/ビューの定義取得</a>
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

`Phalcon\Db` は、フレームワークのモデル層で動作する`Phalcon\Mvc\Model`の背後にあるコンポーネントです。 これは、C言語で完全に書かれたデータベースシステムのための独立した高レベルの抽象化レイヤーで構成されています。

このコンポーネントは従来のモデルを使用するよりも、データベースを低レベルで操作することができます。

<a name='adapters'></a>

## データベースアダプター

このコンポーネントはアダプターを使用して、特定のデータベースシステムの詳細をカプセル化します。ファルコンでは、PDO_ を使用してデータベースに接続します。次のデータベースエンジンがサポートされます。

| クラス                                     | 説明                                                                                                             |
| --------------------------------------- | -------------------------------------------------------------------------------------------------------------- |
| `Phalcon\Db\Adapter\Pdo\Mysql`      | 世界で最も使用されているリレーショナルデータベース管理システム (RDBMS) です。サーバーで動作し、多数のユーザーがいくつかのデータベースにアクセスできます。                              |
| `Phalcon\Db\Adapter\Pdo\Postgresql` | PostgreSQL は、強力なオープンソースのリレーショナルデータベースシステムです。 これは15年以上の積極的な開発と実績のあるアーキテクチャを備えており、信頼性、データの完全性、正確性について高い評価を得ています。 |
| `Phalcon\Db\Adapter\Pdo\Sqlite`     | SQLiteは、自己完結型でサーバレスでゼロ設定のトランザクション型SQLデータベースエンジンを実装したソフトウェアライブラリです                                              |

<a name='adapters-custom'></a>

### 独自のアダプターを実装

独自のデータベースアダプターを作成したり、既存のデータベースアダプターを拡張するには、`Phalcon\Db\AdapterInterface`インターフェースを実装する必要があります。

<a name='dialects'></a>

## データベースの方言

Phalcon は、各データベース エンジンの特定の詳細を方言でカプセル化します。それらはアダプターに共通の機能と SQL ジェネレーターを提供します。

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

<a name='connection-factory'></a>

## Factoryを使用した接続

単純に`ini` ファイルを使ってあなたの `データベース`サービスをデータベースに設定/接続できます。

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

上記は適切なデータベース インスタンスを返ます。また、アプリケーションのコードを1 行も変更することがなく、接続資格情報を変更したり、データベース アダプターを変更したりできる利点があります。

<a name='finding-rows'></a>

## 行の検索

`Phalcon\Db` は、テーブルから行を照会するいくつかのメソッドを提供します。この場合、対象のデータベースエンジン固有のSQL構文が必要です:

```php
<?php

$sql = 'SELECT id, name FROM robots ORDER BY name';

// データベースシステムへSQLステートメントを送信
$result = $connection->query($sql);

// 各robotの名前を表示
while ($robot = $result->fetch()) {
   echo $robot['name'];
}

// 配列内のすべての行を取得する
$robots = $connection->fetchAll($sql);
foreach ($robots as $robot) {
   echo $robot['name'];
}

// 最初の行だけを取得する
$robot = $connection->fetchOne($sql);
```

デフォルトで、これらの呼び出しは連想配列と数値インデックスを持つ配列を両方とも作成します。 `Phalcon\Db\Result::setFetchMode()` を使用してこの動作を変更できます。 このメソッドは、どの種類のインデックスの種類が必要なのかを定義する、定数を受け取ります。

| 定数                         | 説明                        |
| -------------------------- | ------------------------- |
| `Phalcon\Db::FETCH_NUM`   | 数字インデックスのある配列を返す          |
| `Phalcon\Db::FETCH_ASSOC` | 関連インデックスのある配列を返す          |
| `Phalcon\Db::FETCH_BOTH`  | 関連インデックスと数字インデックスのある配列を返す |
| `Phalcon\Db::FETCH_OBJ`   | 配列ではなく、オブジェクトを返す。         |

```php
<?php

$sql = 'SELECT id, name FROM robots ORDER BY name';
$result = $connection->query($sql);

$result->setFetchMode(Phalcon\Db::FETCH_NUM);
while ($robot = $result->fetch()) {
   echo $robot[0];
}
```

`Phalcon\Db::query()` は `Phalcon\Db\Result\Pdo`のインスタンスを返します。 これらのオブジェクトは、返された resultset に関連した機能(トラバース、特定のレコードのシーク、カウント)をカプセル化します。

```php
<?php

$sql = 'SELECT id, name FROM robots';
$result = $connection->query($sql);

// resultset のトラバース
while ($robot = $result->fetch()) {
   echo $robot['name'];
}

// 3番目の row のシーク
$result->seek(2);
$robot = $result->fetch();

// resultset のカウント
echo $result->numRows();
```

<a name='binding-parameters'></a>

## パラメーターのバインド

バインドされたパラメーターは `Phalcon\Db` でもサポートしています。 バインドされたパラメータを使用することで、パフォーマンスの影響は最小限に抑えられますが、コードがSQLインジェクション攻撃の対象になる可能性を排除するために、この方法を使用することをお勧めします。 文字列と位置指定のプレースホルダーの両方をサポートしています。 パラメータのバインドは、以下のように簡単に実施できます:

```php
<?php

// 数値プレースホルダーにバインド
$sql    = 'SELECT * FROM robots WHERE name = ? ORDER BY name';
$result = $connection->query(
    $sql,
    [
        'Wall-E',
    ]
);

// 名前つきプレースホルダーにバインド
$sql     = 'INSERT INTO `robots`(name`, year) VALUES (:name, :year)';
$success = $connection->query(
    $sql,
    [
        'name' => 'Astro Boy',
        'year' => 1952,
    ]
);
```

数値プレースホルダを使用する場合は、整数を1または2として定義する必要があります。 この場合、 '1'または '2'は文字列であり数字ではないため、プレースホルダを正常に置き換えることができません。 アダプターのデータはすべて[PDO Quote](http://www.php.net/manual/en/pdo.quote.php)を使って自動的にエスケープ処理されます。

この関数は接続文字セットを考慮しているため、接続パラメータまたはデータベースサーバー設定で正しい文字セットを定義することをお勧めします。データセットを格納または取得するときに間違った文字セットが望ましくない影響を及ぼすためです。

また、execute/query メソッドに直接パラメータを渡すこともできます。この場合、バインドパラメータは直接 PDO に渡されます:

```php
<?php

// PDOプレースホルダーでのバインド
$sql    = 'SELECT * FROM robots WHERE name = ? ORDER BY name';
$result = $connection->query(
    $sql,
    [
        1 => 'Wall-E',
    ]
);
```

<a name='crud'></a>

## 行の挿入、更新、および削除

行を挿入、更新、または削除するには、生のSQLを使用するか、クラスが提供するプリセット関数を使用します:

```php
<?php

// 生のSQL文を使用したデータの挿入
$sql     = 'INSERT INTO `robots`(`name`, `year`) VALUES ('Astro Boy', 1952)';
$success = $connection->execute($sql);

// プレースホルダー付き
$sql     = 'INSERT INTO `robots`(`name`, `year`) VALUES (?, ?)';
$success = $connection->execute(
    $sql,
    [
        'Astro Boy',
        1952,
    ]
);

// 必要なSQLを動的に生成する
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

// 必要なSQLを動的に生成する（別のシンタックス）
$success = $connection->insertAsDict(
    'robots',
    [
        'name' => 'Astro Boy',
        'year' => 1952,
    ]
);

// 生のSQL文によるデータの更新
$sql     = 'UPDATE `robots` SET `name` = 'Astro boy' WHERE `id` = 101';
$success = $connection->execute($sql);

// プレースホルダー付き
$sql     = 'UPDATE `robots` SET `name` = ? WHERE `id` = ?';
$success = $connection->execute(
    $sql,
    [
        'Astro Boy',
        101,
    ]
);

// 必要なSQLを動的に生成する
$success = $connection->update(
    'robots',
    [
        'name',
    ],
    [
        'New Astro Boy',
    ],
    'id = 101' // 注意！ この場合、値はエスケープされません
);

// 必要なSQLを動的に生成する（別のシンタックス）
$success = $connection->updateAsDict(
    'robots',
    [
        'name' => 'New Astro Boy',
    ],
    'id = 101' // 注意！ この場合、値はエスケープされません
);

// エスケープ条件
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
        'bindTypes'  => [PDO::PARAM_INT], // オプションのパラメータ
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
        'bindTypes'  => [PDO::PARAM_INT], // オプションのパラメータ
    ]
);

// 生のSQL文を使用したデータの削除
$sql     = 'DELETE `robots` WHERE `id` = 101';
$success = $connection->execute($sql);

// プレースホルダー付き
$sql     = 'DELETE `robots` WHERE `id` = ?';
$success = $connection->execute($sql, [101]);

// 必要なSQLを動的に生成する
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

トランザクションの処理は、PDOの場合と同様にサポートされています。トランザクション内でデータ操作を実行すると、たいていのデータベースシステムでパフォーマンスが向上することがあります:

```php
<?php

try {
    // トランザクション開始
    $connection->begin();

    // 複数のSQL文を実行
    $connection->execute('DELETE `robots` WHERE `id` = 101');
    $connection->execute('DELETE `robots` WHERE `id` = 102');
    $connection->execute('DELETE `robots` WHERE `id` = 103');

    // 全てうまくいけばコミット
    $connection->commit();
} catch (Exception $e) {
    // 例外が発生したらトランザクションをロールバック
    $connection->rollback();
}
```

`Phalcon\Db`は標準トランザクションに加えて、（使用しているデータベースシステムがサポートしている場合は）[入れ子トランザクション](http://en.wikipedia.org/wiki/Nested_transaction)の組み込みサポートを提供します。 二回begin()を呼び出すとき、 入れ子になったトランザクションが作成されます:

```php
<?php

try {
    // トランザクション開始
    $connection->begin();

    // 複数のSQL文を実行
    $connection->execute('DELETE `robots` WHERE `id` = 101');

    try {
        // 入れ子トランザクション開始
        $connection->begin();

        // 入れ子トランザクションのSQL文を実行
        $connection->execute('DELETE `robots` WHERE `id` = 102');
        $connection->execute('DELETE `robots` WHERE `id` = 103');

        // セーブポイントを作成
        $connection->commit();
    } catch (Exception $e) {
        // エラー発生、入れ子トランザクションを解放
        $connection->rollback();
    }

    // 継続、他のSQL文を実行
    $connection->execute('DELETE `robots` WHERE `id` = 104');

    // 全てうまくいけばコミット
    $connection->commit();
} catch (Exception $e) {
    // 例外が発生したらトランザクションをロールバック
    $connection->rollback();
}
```

<a name='events'></a>

## データベースのイベント

`Phalcon\Db` はイベントを[EventsManager](/[[language]]/[[version]]/events) に送信することができます。ただし、それが存在する場合に限ります。 ブール値 false を返すいくつかのイベントは、アクティブな操作を停止することがあります。 以下のイベントがサポートされています。

| イベント名                 | トリガー                        | 処理中断が可能 |
| --------------------- | --------------------------- |:-------:|
| `afterConnect`        | データベースシステムへの接続が成功した後        |   いいえ   |
| `beforeQuery`         | データベースシステムへSQLステートメントを送信する前 |   はい    |
| `afterQuery`          | データベースシステムへSQLステートメントを送信した後 |   いいえ   |
| `beforeDisconnect`    | 一時的なデータベース接続を切断する前          |   いいえ   |
| `beginTransaction`    | トランザクションが実行される前             |   いいえ   |
| `rollbackTransaction` | トランザクションがロールバックされる前         |   いいえ   |
| `commitTransaction`   | トランザクションがコミットされる前           |   いいえ   |

EventsManager をconnectionにバインドすることは単純です。`Phalcon\Db` は `db`タイプのイベントを発火します:

```php
<?php

use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Adapter\Pdo\Mysql as Connection;

$eventsManager = new EventsManager();

// 全てのデータベースのイベントをリッスン
$eventsManager->attach('db', $dbListener);

$connection = new Connection(
    [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'secret',
        'dbname'   => 'invo',
    ]
);

// イベントマネージャをそのデータベースアダプタのインスタンスへ割り当て
$connection->setEventsManager($eventsManager);
```

SQL操作の停止が便利なのは、例えば、あなたが最後のリソースのSQLインジェクションのチェッカーなどを実装しようと思っている場合です:

```php
<?php

use Phalcon\Events\Event;

$eventsManager->attach(
    'db:beforeQuery',
    function (Event $event, $connection) {
        $sql = $connection->getSQLStatement();

        // SQL ステートメントに悪意のあるワードがあるか確認
        if (preg_match('/DROP|ALTER/i', $sql)) {
            // このアプリケーションではDROPやALTER操作は許可されていません。
            // これはSQL インジェクションです！
            return false;
        }

        // OK
        return true;
    }
);
```

<a name='profiling'></a>

## SQL ステートメントのプロファイリング

`Phalcon\Db` には`Phalcon\Db\Profiler`というプロファイリングのコンポーネントがあります。これは、データベース操作の性能を分析に使用して、性能上の問題を診断したりボトルネックを発見するのに使用します。

`Phalcon\Db\Profiler`を使うことで、データベースのプロファイリングが簡単に行えます:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Profiler as DbProfiler;

$eventsManager = new EventsManager();

$profiler = new DbProfiler();

// すべてのデータベースイベントをリッスンします。
$eventsManager->attach(
    'db',
    function (Event $event, $connection) use ($profiler) {
        if ($event->getType() === 'beforeQuery') {
            $sql = $connection->getSQLStatement();

            // 接続をしたままプロファイルを開始
            $profiler->startProfile($sql);
        }

        if ($event->getType() === 'afterQuery') {
            // プロファイリングを停止
            $profiler->stopProfile();
        }
    }
);

// イベントマネージャーに接続を割り当て
$connection->setEventsManager($eventsManager);

$sql = 'SELECT buyer_name, quantity, product_name '
     . 'FROM buyers '
     . 'LEFT JOIN products ON buyers.pid = products.id';

// SQLステートメントの実行
$connection->query($sql);

// プロファイラ内の最後のプロファイルを取得
$profile = $profiler->getLastProfile();

echo 'SQL Statement: ', $profile->getSQLStatement(), "\n";
echo 'Start Time: ', $profile->getInitialTime(), "\n";
echo 'Final Time: ', $profile->getFinalTime(), "\n";
echo 'Total Elapsed Time: ', $profile->getTotalElapsedSeconds(), "\n";
```

`Phalcon\Db\Profiler`をベースとしたプロファイルクラスを作成して、データベースシステムに送信したステートメントのリアルタイム統計を記録します:

```php
<?php

use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Profiler as Profiler;
use Phalcon\Db\Profiler\Item as Item;

class DbProfiler extends Profiler
{
    /**
     * DBサーバーへSQLステートメントを送る前に実行
     */
    public function beforeStartProfile(Item $profile)
    {
        echo $profile->getSQLStatement();
    }

    /**
     * DBサーバーへSQLステートメントを送った後に実行
     */
    public function afterEndProfile(Item $profile)
    {
        echo $profile->getTotalElapsedSeconds();
    }
}

// イベントマネージャの作成
$eventsManager = new EventsManager();

// リスナーの作成
$dbProfiler = new DbProfiler();

// 全データベースイベントをリッスンするリスナーにアタッチ
$eventsManager->attach('db', $dbProfiler);
```

<a name='logging-statements'></a>

## SQL ステートメントのロギング

`Phalcon\Db`のようなハイレベルの抽象化コンポーネントを使用してデータベースにアクセスすると、どのステートメントがデータベースシステムに送信されるのかを理解することは困難です。 `Phalcon\Logger` は、`Phalcon\Db`と相互作用し、データベース抽象化レイヤー上でログ機能を提供します。

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

// eventsManagerをdbアダプタインスタンスに割り当てる
$connection->setEventsManager($eventsManager);

// 複数のSQL文を実行
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

上記のように、ファイル`app/logs/db.log`には次のようなものが含まれます:

```bash
[Sun, 29 Apr 12 22:35:26 -0500][DEBUG][Resource Id #77] INSERT INTO products
(name, price) VALUES ('Hot pepper', 3.50)
```

<a name='logger-custom'></a>

## 独自のロガーを実装

データベースのクエリのため、独自のロガー クラスを実装できます。それは`log` と呼ぶ単一のメソッドを実装するクラスを作成することによって行います。 このメソッドは、最初の引数として string を受け入れる必要があります。 ログ オブジェクトを`Phalcon\Db::setLogger()`に渡して、その時から実行されたすべての SQL ステートメントの結果を記録するメソッドを呼び出せます。

<a name='describing-tables'></a>

## テーブル/ビューの定義取得

`Phalcon\Db` は、テーブルとビューについての詳細情報を取得するメソッドも提供します:

```php
<?php

// test_db データベースのテーブルを取得
$tables = $connection->listViews('test_db');

// このデータベースに 'robots' テーブルがあるかどうか
$exists = $connection->tableExists('robots');

// 'robots'フィールドから、名前、データタイプ、特別な機能を取得
$fields = $connection->describeColumns('robots');
foreach ($fields as $field) {
    echo 'Column Type: ', $field['Type'];
}

// 'robots'テーブルのインデックスを取得
$indexes = $connection->describeIndexes('robots');
foreach ($indexes as $index) {
    print_r(
        $index->getColumns()
    );
}

// 'robots'テーブルの外部キーを取得
$references = $connection->describeReferences('robots');
foreach ($references as $reference) {
    // 参照カラムの表示
    print_r(
        $reference->getReferencedColumns()
    );
}
```

テーブルの説明はMySQLのdescribeコマンドとほとんど同じで、次の情報が含まれています。

| フィールド  | タイプ    | キー                        | Null              |
| ------ | ------ | ------------------------- | ----------------- |
| フィールド名 | カラムタイプ | プライマリーキーまたはインデックスのカラムかどうか | カラムがnullを許可するかどうか |

ビューに関する情報を取得するメソッドは、サポートされているすべてのデータベースシステムに対しても実装されています:

```php
<?php

// test_db データベースのviewを取得
$tables = $connection->listViews('test_db');

// このデータベースに 'robots' viewがあるかどうか
$exists = $connection->viewExists('robots');
```

<a name='tables'></a>

## テーブルの作成/変更/削除

(MySQL、Postgresql など) データベースシステム は、CREATE、ALTER または DROP などのコマンドを使ってテーブルを作成、変更、削除する機能を提供します。 SQL のシンタックスは、どのデータベースシステムを使用しているかによって異なります。 `Phalcon\Db` は、テーブルを変更する統一されたインターフェイスを提供しています。ターゲットのストレージシステムに基づいたSQL シンタックスの違いを必要としません。

<a name='tables-create'></a>

### テーブルの作成

テーブルを作成する方法を示します。

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

`Phalcon\Db::createTable()` は、テーブルを表す連想配列を受けつけます。 カラムは、`Phalcon\Db\Column` クラスで定義します。 カラムの定義に使用できるオプションを次の表で示します。

| オプション           | 説明                                                                      | オプション |
| --------------- | ----------------------------------------------------------------------- |:-----:|
| `type`          | カラムのタイプです。`Phalcon\Db\Column` の定数でなければなりません。 (定数リストについては下記を参照してください。) |  いいえ  |
| `primary`       | そのカラムがテーブルのプライマリーキーの部分だった場合は true です。                                   |  はい   |
| `size`          | `VARCHAR` や `INTEGER` のような種類のカラムは指定のサイズになります。                           |  はい   |
| `scale`         | `DECIMAL` または `NUMBER` カラムでサイズを指定します。どのくらい多くの桁を保持すべきかを示します。             |  はい   |
| `unsigned`      | `INTEGER` カラムが符号付きまたは符号なしかを示します。このオプションは他の種類のカラムには適用しません。               |  はい   |
| `notNull`       | カラムが、nullを格納できるかどうか。                                                    |  はい   |
| `default`       | デフォルト値 (`'notNull' => true`の場合に使用する)                                 |  はい   |
| `autoIncrement` | この属性を持つカラムはオートインクリメント値で自動的に決定します。テーブルのカラムのうち、1カラムだけがこの属性を持つことができます。     |  はい   |
| `bind`          | `BIND_TYPE _*`定数の1つで、カラムをバインドしてから保存する必要があります                            |  はい   |
| `first`         | このカラムは、最初の位置に置かれなければなりません。                                              |  はい   |
| `after`         | このカラムは、指定されたカラムの後に置く必要があります。                                            |  はい   |

`Phalcon\Db`は次のDBカラムタイプをサポートしています:

- `Phalcon\Db\Column::TYPE_INTEGER`
- `Phalcon\Db\Column::TYPE_DATE`
- `Phalcon\Db\Column::TYPE_VARCHAR`
- `Phalcon\Db\Column::TYPE_DECIMAL`
- `Phalcon\Db\Column::TYPE_DATETIME`
- `Phalcon\Db\Column::TYPE_CHAR`
- `Phalcon\Db\Column::TYPE_TEXT`

`Phalcon\Db::createTable()` に渡された連想配列は、次のキーを持てます:

| インデックス       | 説明                                                                 | オプション |
| ------------ | ------------------------------------------------------------------ |:-----:|
| `columns`    | `Phalcon\Db\Column`で定義されたテーブルカラムの配列                              |  いいえ  |
| `indexes`    | `Phalcon\Db\Index`で定義されたテーブルインデックスの配列                            |  はい   |
| `references` | `Phalcon\Db\Reference`で定義されたテーブル参照 (外部キー) の配列                    |  はい   |
| `options`    | テーブル作成オプションの配列。これらのオプションはマイグレーションによって生成された、データベースシステムに関連することが多いです。 |  はい   |

<a name='tables-altering'></a>

### テーブルの変更

アプリケーションが大きくなるにつれて、リファクタリングや新しい機能の追加の一環として、データベースを変更する必要が生じる場合があります。 すべてのデータベースシステムで既存のカラムを変更したり、既存のカラムの間にカラムを追加することはできません。 `Phalcon\Db`は、これらの制約によって制限されます。

```php
<?php

use Phalcon\Db\Column as Column;

// 新しいカラムの追加
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

// 既存カラムの修正
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

// 'name' カラムの削除
$connection->dropColumn(
    'robots',
    null,
    'name'
);
```

<a name='tables-dropping'></a>

### テーブルの削除

テーブル削除の例:

```php
<?php

// アクティブなデータベースから 'robots' テーブルを削除
$connection->dropTable('robots');

// 'machines' データベースから 'robots' テーブルを削除 
$connection->dropTable('robots', 'machines');
```