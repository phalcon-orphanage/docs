<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">キャッシュによるパフォーマンスの向上</a> 
      <ul>
        <li>
          <a href="#implementation">いつキャッシュを実装する？</a>
        </li>
        <li>
          <a href="#caching-behavior">キャッシュの振る舞い</a>
        </li>
        <li>
          <a href="#factory">ファクトリー</a>
        </li>
        <li>
          <a href="#output-fragments">出力フラグメントのキャッシュ</a>
        </li>
        <li>
          <a href="#arbitrary-data">任意データのキャッシュ</a> 
          <ul>
            <li>
              <a href="#backend-file-example">ファイルバックエンドの例</a>
            </li>
            <li>
              <a href="#backend-memcached-example">Memcached バックエンドの例</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#read">キャッシュの確認</a>
        </li>
        <li>
          <a href="#delete">キャッシュからのデータ削除</a>
        </li>
        <li>
          <a href="#exists">キャッシュ有無の確認</a>
        </li>
        <li>
          <a href="#lifetime">有効期間</a>
        </li>
        <li>
          <a href="#multi-level">マルチレベルキャッシュ</a>
        </li>
        <li>
          <a href="#adapters-frontend">フロントエンド アダプター</a> 
          <ul>
            <li>
              <a href="#adapters-frontend-custom">独自フロントエンドアダプターの実装</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#adapters-backend">バックエンドアダプター</a> 
          <ul>
            <li>
              <a href="#adapters-backend-factory">ファクトリー</a>
            </li>
            <li>
              <a href="#adapters-backend-custom">独自のバックエンドアダプターを実装</a>
            </li>
            <li>
              <a href="#adapters-backend-file">ファイルバックエンドのオプション</a>
            </li>
            <li>
              <a href="#adapters-backend-libmemcached">Libmemcachedバックエンドのオプション</a>
            </li>
            <li>
              <a href="#adapters-backend-memcache">Memcacheバックエンドのオプション</a>
            </li>
            <li>
              <a href="#adapters-backend-apc">APCバックエンドのオプション</a>
            </li>
            <li>
              <a href="#adapters-backend-apcu">APCUバックエンドのオプション</a>
            </li>
            <li>
              <a href="#adapters-backend-mongo">Mongoバックエンドのオプション</a>
            </li>
            <li>
              <a href="#adapters-backend-xcache">XCacheバックエンドのオプション</a>
            </li>
            <li>
              <a href="#adapters-backend-redis">Redisバックエンドのオプション</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# キャッシュによるパフォーマンスの向上

Phalcon は、頻繁に使用される、またはすでに処理されたデータに、高速なアクセスを行う `Phalcon\Cache` クラスを提供しています。 `Phalcon\Cache` は C で実装され、バックエンドからアイテムを取得する際にオーバーヘッドを減らし、高いパフォーマンスで動作します。 このクラスでは、フロントエンドとバックエンドのコンポーネントの内部構造を使用します。 フロントエンドコンポーネントは、バックエンドコンポーネントクラスにストレージオプションを提供しながら入力ソースまたはインターフェイスとして機能します。

<a name='implementation'></a>

## いつキャッシュを実装する？

このコンポーネントは非常に高速ですが、必要でないケースで実装すると、利用することで得られるメリットよりも、パフォーマンスの低下によるデメリットの方が大きくなる可能性があります。キャッシュを利用する前に、次のケースについて確認する事をお勧めします。

* 毎回同じ結果 (変更頻度の低い) を返す複雑な計算をしている
* 多くのヘルパを利用し、生成される出力がほとんど同じである
* 常にデータベースのデータにアクセスしており、これらのデータはほとんど変わらない

<div class='alert alert-warning'>
    <p>
        <strong>メモ</strong> キャッシュを実装した後でも、一定の期間でキャッシュのヒット率を確認するようにしましょう。 特にMemcacheやApcの場合、バックエンドが提供する関連ツールを使用すると、これを簡単に行うことができます。
    </p>
</div>

<a name='caching-behavior'></a>

## キャッシュの振る舞い

キャッシュ処理は、2 つの部分に分かれています:

* **フロントエンド**: この部分は、キーが期限切れになっていないかどうかをチェックし、保存する前にデータに追加の変換を実行します。
* **バックエンド**: この部分は、フロントエンドが必要とするデータの通信、書き込み、読み取りを行います。

<a name='factory'></a>

## ファクトリー

フロントエンドまたはバックエンドのアダプタをインスタンス化するには、次の2つの方法があります。

従来の方法

```php
<?php

use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Frontend\Data as FrontData;

// 出力フロントエンドの作成。 ファイルを2日間キャッシュ。
$frontCache = new FrontData(
    [
        'lifetime' => 172800,
    ]
);

// 'Output'から'File'バックエンドにキャッシュするコンポーネントを作成する
// キャッシュファイルディレクトリを設定する - フォルダの値の最後に '/'を置くことが重要
$cache = new BackFile(
    $frontCache,
    [
        'cacheDir' => '../app/cache/',
    ]
);
```

次のようにFactoryオブジェクトを使用します:

```php
<?php

use Phalcon\Cache\Frontend\Factory as FFactory;
use Phalcon\Cache\Backend\Factory as BFactory;

 $options = [
     'lifetime' => 172800,
     'adapter'  => 'data',
 ];
 $frontendCache = FFactory::load($options);


$options = [
    'cacheDir' => '../app/cache/',
    'prefix'   => 'app-data',
    'frontend' => $frontendCache,
    'adapter'  => 'file',
];

$backendCache = BFactory::load($options);
```

<a name='output-fragments'></a>

## 出力フラグメントのキャッシュ

出力フラグメントは、そのままキャッシュされてそのまま返される、HTMLまたはテキストの一部です。 出力は、`ob_*`関数またはPHP出力から自動的にキャプチャされ、キャッシュに保存されます。 次の例は、このような使用法を示しています。 PHPが生成した出力を受け取り、ファイルに格納します。 ファイルの内容は172,800秒（2日）ごとに更新されます。

このキャッシュ機構の実装では、コードの該当部分を呼び出すたびに、ヘルパー `Phalcon\Tag::linkTo()`を呼び出さないので、パフォーマンスが向上します。

```php
<?php

use Phalcon\Tag;
use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Frontend\Output as FrontOutput;

// 出力フロントエンドの作成。 ファイルを2日間キャッシュ。
$frontCache = new FrontOutput(
    [
        'lifetime' => 172800,
    ]
);

// 'Output'から'File'バックエンドにキャッシュするコンポーネントを作成する
// キャッシュファイルディレクトリを設定する - フォルダの値の最後に '/'を置いておくことが重要です
$cache = new BackFile(
    $frontCache,
    [
        'cacheDir' => '../app/cache/',
    ]
);

// キャッシュファイルを ../app/cache/my-cache.html で取得/設定する
$content = $cache->start('my-cache.html');

// $contentがnullの場合、コンテンツはキャッシュ用に生成されます。
if ($content === null) {
    // 日付と時刻を表示する
    echo date('r');

    // サインアップアクションへのリンクを生成する
    echo Tag::linkTo(
        [
            'user/signup',
            'Sign Up',
            'class' => 'signup-button',
        ]
    );

    // 出力をキャッシュファイルに保存する
    $cache->save();
} else {
    // キャッシュされた出力をechoする
    echo $content;
}
```

<div class='alert alert-warning'>
    <p>
        <strong>注意</strong>上記の例では、コードは以前と同じように出力されます。 キャッシュコンポーネントは透過的にその出力をキャプチャし、キャッシュファイルに保存します（キャッシュが生成されたとき）。または、前回の呼び出しで事前にコンパイルされたものをユーザーにレスポンスすることで、コストの高い処理を回避します。
    </p>
</div>

<a name='arbitrary-data'></a>

## 任意データのキャッシュ

データだけをキャッシュすることは、アプリケーションにとっても同様に重要です。 キャッシュは、一般的に使用されている（更新されていない）データを再利用することでデータベースの負荷を軽減することができ、アプリケーションの処理速度が向上します。

<a name='backend-file-example'></a>

### ファイルバックエンドの例

キャッシュのアダプターの1つは、`File`です。 このアダプターの唯一重要なところは、そのキャッシュファイルを保存する場所です。 これは、`cacheDir` オプションで制御できます。このディレクトリは、最後が バックスラッシュで*終らなければなりません。*

```php
<?php

use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Frontend\Data as FrontData;

// Cache the files for 2 days using a Data frontend
$frontCache = new FrontData(
    [
        'lifetime' => 172800,
    ]
);

// Create the component that will cache 'Data' to a 'File' backend
// Set the cache file directory - important to keep the `/` at the end of
// the value for the folder
$cache = new BackFile(
    $frontCache,
    [
        'cacheDir' => '../app/cache/',
    ]
);

$cacheKey = 'robots_order_id.cache';

// Try to get cached records
$robots = $cache->get($cacheKey);

if ($robots === null) {
    // $robots is null because of cache expiration or data does not exist
    // Make the database call and populate the variable
    $robots = Robots::find(
        [
            'order' => 'id',
        ]
    );

    // Store it in the cache
    $cache->save($cacheKey, $robots);
}

// Use $robots :)
foreach ($robots as $robot) {
   echo $robot->name, '\n';
}
```

<a name='backend-memcached-example'></a>

### Memcached バックエンドの例

Memcachedバックエンドを使用するとき、上の例を少しだけ変更します(特に設定項目のあたり)。

```php
<?php

use Phalcon\Cache\Frontend\Data as FrontData;
use Phalcon\Cache\Backend\Libmemcached as BackMemCached;

// Cache data for one hour
$frontCache = new FrontData(
    [
        'lifetime' => 3600,
    ]
);

// Create the component that will cache 'Data' to a 'Memcached' backend
// Memcached connection settings
$cache = new BackMemCached(
    $frontCache,
    [
        'servers' => [
            [
                'host'   => '127.0.0.1',
                'port'   => '11211',
                'weight' => '1',
            ]
        ]
    ]
);

$cacheKey = 'robots_order_id.cache';

// Try to get cached records
$robots = $cache->get($cacheKey);

if ($robots === null) {
    // $robots is null because of cache expiration or data does not exist
    // Make the database call and populate the variable
    $robots = Robots::find(
        [
            'order' => 'id',
        ]
    );

    // Store it in the cache
    $cache->save($cacheKey, $robots);
}

// Use $robots :)
foreach ($robots as $robot) {
   echo $robot->name, '\n';
}
```

<div class='alert alert-warning'>
    <p>
        <strong>注意</strong> <code>save()</code>を呼び、論理値を返します。これは成功 (<code>true</code>) または失敗 (<code>false</code>) を示します。 使用しているバックエンドに応じて、関連するログを調べて障害を特定する必要があります。
    </p>
</div>

<a name='read'></a>

## キャッシュの確認

このキャッシュに加えられた要素はキーによって一意に特定できます。 ファイルバックエンドの場合、キーは実際のファイル名です。 キャッシュからデータを取得するため、一意のキーを使って呼び出さなければなりません。 もしキーが存在しない場合、getメソッドはnullを返します。

```php
<?php

// Retrieve products by key 'myProducts'
$products = $cache->get('myProducts');
```

もしあなたがどのようなキーがそのキャッシュに保存されているのかが知りたい場合、`queryKeys` メソッドを呼びだすことができます。

```php
<?php

// Query all keys used in the cache
$keys = $cache->queryKeys();

foreach ($keys as $key) {
    $data = $cache->get($key);

    echo 'Key=', $key, ' Data=', $data;
}

// Query keys in the cache that begins with 'my-prefix'
$keys = $cache->queryKeys('my-prefix');
```

<a name='delete'></a>

## キャッシュからのデータ削除

強制的にキャッシュの書込みを無効にしなければならない場合があります（キャッシュされたデータが更新されるため）。 唯一の要件は、データが格納されているキーを知ることです。

```php
<?php

// Delete an item with a specific key
$cache->delete('someKey');

$keys = $cache->queryKeys();

// Delete all items from the cache
foreach ($keys as $key) {
    $cache->delete($key);
}
```

<a name='exists'></a>

## キャッシュ有無の確認

指定されたキーでキャッシュがすでに存在するかどうかを確認することができます。

```php
<?php

if ($cache->exists('someKey')) {
    echo $cache->get('someKey');
} else {
    echo 'Cache does not exists!';
}
```

<a name='lifetime'></a>

## 有効期間

`有効期間`は、期限が切れるまでキャッシュが存続できる時間（秒）です。 デフォルトでは、作成されたすべてのキャッシュは、フロントエンドの作成時に設定された有効期間を使用します。 キャッシュからのデータの作成または取得では、特定の有効期間を設定できます。

取得時の有効期間の設定:

```php
<?php

$cacheKey = 'my.cache';

// 結果を取得するときにキャッシュを設定
$robots = $cache->get($cacheKey, 3600);

if ($robots === null) {
    $robots = 'some robots';

    // キャッシュに格納
    $cache->save($cacheKey, $robots);
}
```

保存時の有効期間の設定:

```php
<?php

$cacheKey = 'my.cache';

$robots = $cache->get($cacheKey);

if ($robots === null) {
    $robots = 'some robots';

    // データを保存するときにキャッシュを設定
    $cache->save($cacheKey, $robots, 3600);
}
```

<a name='multi-level'></a>

## マルチレベルキャッシュ

キャッシュコンポーネントの機能によって、開発者はマルチレベルキャッシュを実装できます。 この新しい機能は、同じデータを複数のキャッシュに保存することができるため、データの有効期限が切れるまで一番速いアダプタで読み込み、最も遅いもので終了するため、非常に便利です:

```php
<?php

use Phalcon\Cache\Multiple;
use Phalcon\Cache\Backend\Apc as ApcCache;
use Phalcon\Cache\Backend\File as FileCache;
use Phalcon\Cache\Frontend\Data as DataFrontend;
use Phalcon\Cache\Backend\Memcache as MemcacheCache;

$ultraFastFrontend = new DataFrontend(
    [
        'lifetime' => 3600,
    ]
);

$fastFrontend = new DataFrontend(
    [
        'lifetime' => 86400,
    ]
);

$slowFrontend = new DataFrontend(
    [
        'lifetime' => 604800,
    ]
);

// バックエンドは、早いものから遅いものへと順番に登録される
$cache = new Multiple(
    [
        new ApcCache(
            $ultraFastFrontend,
            [
                'prefix' => 'cache',
            ]
        ),
        new MemcacheCache(
            $fastFrontend,
            [
                'prefix' => 'cache',
                'host'   => 'localhost',
                'port'   => '11211',
            ]
        ),
        new FileCache(
            $slowFrontend,
            [
                'prefix'   => 'cache',
                'cacheDir' => '../app/cache/',
            ]
        ),
    ]
);

// すべてのバックエンドに保存
$cache->save('my-key', $data);
```

<a name='adapters-frontend'></a>

## フロントエンド アダプター

インターフェイスとして使用される使用可能なフロントエンドアダプタ、またはキャッシュへの入力ソースは次のとおりです:

| アダプター                                | 説明                                                                                               |
| ------------------------------------ | ------------------------------------------------------------------------------------------------ |
| `Phalcon\Cache\Frontend\Output`   | 標準のPHP出力から入力データを読み込みます。                                                                          |
| `Phalcon\Cache\Frontend\Data`     | あらゆる種類のPHPデータ（大きな配列、オブジェクト、テキストなど）をキャッシュするために使用されます。 データは、バックエンドに格納される前にシリアル化されます。               |
| `Phalcon\Cache\Frontend\Base64`   | バイナリデータをキャッシュするために使用されます。 データは、バックエンドに格納される前に`base64_encode`を使用してシリアル化されます。                      |
| `Phalcon\Cache\Frontend\Json`     | データはバックエンドに格納される前にJSONでエンコードされます。 検索後にデコードされます。 このフロントエンドは、他の言語やフレームワークとデータを共有するのに便利です。          |
| `Phalcon\Cache\Frontend\Igbinary` | あらゆる種類のPHPデータ（大きな配列、オブジェクト、テキストなど）をキャッシュするために使用されます。 データはバックエンドに格納される前に`Igbinary`を使用してシリアル化されます。 |
| `Phalcon\Cache\Frontend\None`     | あらゆる種類のPHPデータをシリアル化せずにキャッシュするために使用されます。                                                          |

<a name='adapters-frontend-custom'></a>

### 独自フロントエンドアダプターの実装

独自のフロントエンドアダプタを作成するか、既存のフロントエンドアダプタを拡張するには、`Phalcon\Cache\FrontendInterface`インタフェースを実装する必要があります。

<a name='adapters-backend'></a>

## バックエンドアダプター

キャッシュデータを格納するために使用できるバックエンドアダプタは次のとおりです:

| アダプター                                   | 説明                                      | 情報                                        | 必須の拡張機能                                            |
| --------------------------------------- | --------------------------------------- | ----------------------------------------- | -------------------------------------------------- |
| `Phalcon\Cache\Backend\Apc`          | Alternative PHP Cache (APC) にデータを格納します。 | [APC](http://php.net/apc)                 | [APC](http://pecl.php.net/package/APC)             |
| `Phalcon\Cache\Backend\Apcu`         | データをAPCuに格納します（オペコードキャッシングなしのAPC）       | [APCu](http://php.net/apcu)               | [APCu](http://pecl.php.net/package/APCu)           |
| `Phalcon\Cache\Backend\File`         | ローカルのプレーンファイルにデータを格納します。                |                                           |                                                    |
| `Phalcon\Cache\Backend\Libmemcached` | memcachedサーバーにデータを格納します。                | [Memcached](http://www.php.net/memcached) | [Memcached](http://pecl.php.net/package/memcached) |
| `Phalcon\Cache\Backend\Memcache`     | memcachedサーバーにデータを格納します。                | [Memcache](http://www.php.net/memcache)   | [Memcache](http://pecl.php.net/package/memcache)   |
| `Phalcon\Cache\Backend\Memory`       | メモリ中にデータを保存                             |                                           |                                                    |
| `Phalcon\Cache\Backend\Mongo`        | データをMongoデータベースに保存します。                  | [MongoDB](http://mongodb.org/)            | [Mongo](http://mongodb.org/)                       |
| `Phalcon\Cache\Backend\Redis`        | Redisにデータを格納します。                        | [Redis](http://redis.io/)                 | [Redis](http://pecl.php.net/package/redis)         |
| `Phalcon\Cache\Backend\Xcache`       | XCacheにデータを格納します。                       | [XCache](http://xcache.lighttpd.net/)     | [XCache](http://pecl.php.net/package/xcache)       |
<a name='adapters-backend-factory'></a>

### ファクトリー

There are many backend adapters (see [Backend Adapters](#adapters-backend)). The one you use will depend on the needs of your application. The following example loads the Backend Cache Adapter class using `adapter` option, if frontend will be provided as array it will call Frontend Cache Factory

```php
<?php

use Phalcon\Cache\Backend\Factory;
use Phalcon\Cache\Frontend\Data;

$options = [
    'prefix'   => 'app-data',
    'frontend' => new Data(),
    'adapter'  => 'apc',
];
$backendCache = Factory::load($options);
```

<a name='adapters-backend-custom'></a>

### 独自のバックエンドアダプターを実装

The `Phalcon\Cache\BackendInterface` interface must be implemented in order to create your own backend adapters or extend the existing ones.

<a name='adapters-backend-file'></a>

### ファイルバックエンドのオプション

This backend will store cached content into files in the local server. The available options for this backend are:

| オプション      | 説明                                                          |
| ---------- | ----------------------------------------------------------- |
| `prefix`   | A prefix that is automatically prepended to the cache keys. |
| `cacheDir` | A writable directory on which cached files will be placed.  |

<a name='adapters-backend-libmemcached'></a>

### Libmemcachedバックエンドのオプション

This backend will store cached content on a memcached server. Per default persistent memcached connection pools are used. The available options for this backend are:

**General options**

| オプション           | 説明                                                                                                                 |
| --------------- | ------------------------------------------------------------------------------------------------------------------ |
| `statsKey`      | Used to tracking of cached keys.                                                                                   |
| `prefix`        | A prefix that is automatically prepended to the cache keys.                                                        |
| `persistent_id` | To create an instance that persists between requests, use `persistent_id` to specify a unique ID for the instance. |

**サーバー設定**

| オプション    | 説明                                                                                                          |
| -------- | ----------------------------------------------------------------------------------------------------------- |
| `host`   | The `memcached` host.                                                                                       |
| `port`   | The `memcached` port.                                                                                       |
| `weight` | The weight parameter effects the consistent hashing used to determine which server to read/write keys from. |

**クライアント設定**

Used for setting Memcached options. See [Memcached::setOptions](http://php.net/manual/en/memcached.setoptions.php) for more.

**Example**

```php
<?php
use Phalcon\Cache\Backend\Libmemcached;
use Phalcon\Cache\Frontend\Data as FrontData;

// Cache data for 2 days
$frontCache = new FrontData(
    [
        'lifetime' => 172800,
    ]
);

// Create the Cache setting memcached connection options
$cache = new Libmemcached(
    $frontCache,
    [
        'servers' => [
            [
                'host'   => '127.0.0.1',
                'port'   => 11211,
                'weight' => 1,
            ],
        ],
        'client' => [
            \Memcached::OPT_HASH       => \Memcached::HASH_MD5,
            \Memcached::OPT_PREFIX_KEY => 'prefix.',
        ],
        'persistent_id' => 'my_app_cache',
    ]
);
```

<a name='adapters-backend-memcache'></a>

### Memcacheバックエンドのオプション

This backend will store cached content on a memcached server. The available options for this backend are:

| オプション        | 説明                                                          |
| ------------ | ----------------------------------------------------------- |
| `prefix`     | A prefix that is automatically prepended to the cache keys. |
| `host`       | The memcached host.                                         |
| `port`       | The memcached port.                                         |
| `persistent` | Create a persistent connection to memcached?                |

<a name='adapters-backend-apc'></a>

### APCバックエンドのオプション

This backend will store cached content on Alternative PHP Cache ([APC](http://php.net/apc)). The available options for this backend are:

| オプション    | 説明                                                          |
| -------- | ----------------------------------------------------------- |
| `prefix` | A prefix that is automatically prepended to the cache keys. |

<a name='adapters-backend-apcu'></a>

### APCUバックエンドのオプション

This backend will store cached content on Alternative PHP Cache ([APCU](http://php.net/apcu)). The available options for this backend are:

| オプション    | 説明                                                          |
| -------- | ----------------------------------------------------------- |
| `prefix` | A prefix that is automatically prepended to the cache keys. |

<a name='adapters-backend-mongo'></a>

### Mongoバックエンドのオプション

This backend will store cached content on a MongoDB server ([MongoDB](http://mongodb.org/)). The available options for this backend are:

| オプション        | 説明                                                          |
| ------------ | ----------------------------------------------------------- |
| `prefix`     | A prefix that is automatically prepended to the cache keys. |
| `server`     | A MongoDB connection string.                                |
| `db`         | Mongo database name.                                        |
| `collection` | Mongo collection in the database.                           |

<a name='adapters-backend-xcache'></a>

### XCacheバックエンドのオプション

This backend will store cached content on XCache ([XCache](http://xcache.lighttpd.net/)). The available options for this backend are:

| オプション    | 説明                                                          |
| -------- | ----------------------------------------------------------- |
| `prefix` | A prefix that is automatically prepended to the cache keys. |

<a name='adapters-backend-redis'></a>

### Redisバックエンドのオプション

This backend will store cached content on a Redis server ([Redis](http://redis.io/)). The available options for this backend are:

| オプション        | 説明                                                             |
| ------------ | -------------------------------------------------------------- |
| `prefix`     | A prefix that is automatically prepended to the cache keys.    |
| `host`       | Redis host.                                                    |
| `port`       | Redis port.                                                    |
| `auth`       | Password to authenticate to a password-protected Redis server. |
| `persistent` | Create a persistent connection to Redis.                       |
| `index`      | The index of the Redis database to use.                        |

[Phalcon Incubator](https://github.com/phalcon/incubator) には、このコンポーネントを利用するための複数のアダプターが用意されています。