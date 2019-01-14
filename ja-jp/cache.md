* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

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

キャッシュ処理は、2 つの部分に分かれています。

* **フロントエンド**: この部分は、キーが期限切れになっていないかどうかをチェックし、保存する前にデータに追加の変換を実行します。
* **バックエンド**: この部分は、フロントエンドが必要とするデータの通信、書き込み、読み取りを行います。

<a name='factory'></a>

## Factory

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

出力フラグメントは、そのままの状態でキャッシュされ、HTML またはテキストの一部で、そのまま返されます。 出力は、`ob_*`関数またはPHP出力から自動的にキャプチャされ、キャッシュに保存されます。 次の例は、このような使用法を示しています。 PHPが生成した出力を受け取り、ファイルに格納します。 ファイルの内容は172,800秒（2日）ごとに更新されます。

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

// Dataフロントエンドを使用して2日間ファイルをキャッシュする
$frontCache = new FrontData(
    [
        'lifetime' => 172800,
    ]
);

// 'Data'を'File'バックエンドにキャッシュするコンポーネントを作成する
// キャッシュファイルディレクトリを設定する - フォルダの値の最後に `/`を置くことが重要
$cache = new BackFile(
    $frontCache,
    [
        'cacheDir' => '../app/cache/',
    ]
);

$cacheKey = 'robots_order_id.cache';

// キャッシュされたレコードを取得してみる
$robots = $cache->get($cacheKey);

if ($robots === null) {
    // $robotsはキャッシュの有効期限が切れているか、データが存在しないためnull
    // データベースを呼び出して変数に代入
    $robots = Robots::find(
        [
            'order' => 'id',
        ]
    );

    // キャッシュに保存
    $cache->save($cacheKey, $robots);
}

// $robotsを使う:)
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

// データを1時間キャッシュする
$frontCache = new FrontData(
    [
        'lifetime' => 3600,
    ]
);

// 'Memcached'バックエンドに'データ'をキャッシュするコンポーネントを作成する
// Memcached接続設定
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

// キャッシュされたレコードを取得してみる
$robots = $cache->get($cacheKey);

if ($robots === null) {
    // $robotsはキャッシュの有効期限が切れているか、データが存在しないためnull
    // データベースを呼び出して変数に代入
    $robots = Robots::find(
        [
            'order' => 'id',
        ]
    );

    // キャッシュに保存
    $cache->save($cacheKey, $robots);
}

// $robotsを使う :)
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

// キー'myProducts'で製品を取得する
$products = $cache->get('myProducts');
```

もしあなたがどのようなキーがそのキャッシュに保存されているのかが知りたい場合、`queryKeys` メソッドを呼びだすことができます。

```php
<?php

// キャッシュで使用されているすべてのキーを照会する
$keys = $cache->queryKeys();

foreach ($keys as $key) {
    $data = $cache->get($key);

    echo 'Key=', $key, ' Data=', $data;
}

// 'my-prefix'で始まるキャッシュ内のクエリキー
$keys = $cache->queryKeys('my-prefix');
```

<a name='delete'></a>

## キャッシュからのデータ削除

強制的にキャッシュの書込みを無効にしなければならない場合があります（キャッシュされたデータが更新されるため）。 唯一の要件は、データが格納されているキーを知ることです。

```php
<?php

// 対象のキーを持つアイテムを削除する
$cache->delete('someKey');

$keys = $cache->queryKeys();

// キャッシュからすべてのアイテムを削除する
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

| アダプター                                                                     | Description                                                                                      |
| ------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------ |
| [Phalcon\Cache\Frontend\Output](api/Phalcon_Cache_Frontend_Output)     | 標準のPHP出力から入力データを読み込みます。                                                                          |
| [Phalcon\Cache\Frontend\Data](api/Phalcon_Cache_Frontend_Data)         | あらゆる種類のPHPデータ（大きな配列、オブジェクト、テキストなど）をキャッシュするために使用されます。 データは、バックエンドに格納される前にシリアル化されます。               |
| [Phalcon\Cache\Frontend\Base64](api/Phalcon_Cache_Frontend_Base64)     | バイナリデータをキャッシュするために使用されます。 データは、バックエンドに格納される前に`base64_encode`を使用してシリアル化されます。                      |
| [Phalcon\Cache\Frontend\Json](api/Phalcon_Cache_Frontend_Json)         | データはバックエンドに格納される前にJSONでエンコードされます。 検索後にデコードされます。 このフロントエンドは、他の言語やフレームワークとデータを共有するのに便利です。          |
| [Phalcon\Cache\Frontend\Igbinary](api/Phalcon_Cache_Frontend_Igbinary) | あらゆる種類のPHPデータ（大きな配列、オブジェクト、テキストなど）をキャッシュするために使用されます。 データはバックエンドに格納される前に`Igbinary`を使用してシリアル化されます。 |
| [Phalcon\Cache\Frontend\None](api/Phalcon_Cache_Frontend_None)         | あらゆる種類のPHPデータをシリアル化せずにキャッシュするために使用されます。                                                          |

<a name='adapters-frontend-custom'></a>

### 独自フロントエンドアダプターの実装

The [Phalcon\Cache\FrontendInterface](api/Phalcon_Cache_FrontendInterface) interface must be implemented in order to create your own frontend adapters or extend the existing ones.

<a name='adapters-backend'></a>

## バックエンドアダプター

キャッシュデータを格納するために使用できるバックエンドアダプタは次のとおりです:

| アダプター                                                                           | Description                             | 情報                                         | 必須エクステンション                                          |
| ------------------------------------------------------------------------------- | --------------------------------------- | ------------------------------------------ | --------------------------------------------------- |
| [Phalcon\Cache\Backend\Apc](api/Phalcon_Cache_Backend_Apc)                   | Alternative PHP Cache (APC) にデータを格納します。 | [APC](https://php.net/apc)                 | [APC](https://pecl.php.net/package/APC)             |
| `Phalcon\Cache\Backend\Apcu`                                                 | データをAPCuに格納します（オペコードキャッシングなしのAPC）       | [APCu](https://php.net/apcu)               | [APCu](https://pecl.php.net/package/APCu)           |
| [Phalcon\Cache\Backend\File](api/Phalcon_Cache_Backend_File)                 | ローカルのプレーンファイルにデータを格納します。                |                                            |                                                     |
| [Phalcon\Cache\Backend\Libmemcached](api/Phalcon_Cache_Backend_Libmemcached) | memcachedサーバーにデータを格納します。                | [Memcached](https://www.php.net/memcached) | [Memcached](https://pecl.php.net/package/memcached) |
| [Phalcon\Cache\Backend\Memcache](api/Phalcon_Cache_Backend_Memcache)         | memcachedサーバーにデータを格納します。                | [Memcache](https://www.php.net/memcache)   | [Memcache](https://pecl.php.net/package/memcache)   |
| [Phalcon\Cache\Backend\Memory](api/Phalcon_Cache_Backend_Memory)             | Stores data in memory                   |                                            |                                                     |
| [Phalcon\Cache\Backend\Mongo](api/Phalcon_Cache_Backend_Mongo)               | データをMongoデータベースに保存します。                  | [MongoDB](https://mongodb.org/)            | [Mongo](https://mongodb.org/)                       |
| [Phalcon\Cache\Backend\Redis](api/Phalcon_Cache_Backend_Redis)               | Redisにデータを格納します。                        | [Redis](https://redis.io/)                 | [Redis](https://pecl.php.net/package/redis)         |
| [Phalcon\Cache\Backend\Xcache](api/Phalcon_Cache_Backend_Xcache)             | XCacheにデータを格納します。                       | [XCache](https://xcache.lighttpd.net/)     | [XCache](https://pecl.php.net/package/xcache)       |

##### **NOTE** In PHP 7 to use phalcon `apc` based adapter classes you needed to install `apcu` and `apcu_bc` package from pecl. Now in Phalcon 4.0.0 you can switch your `<em>\Apc` classes to `</em>\Apcu` and remove `apcu_bc`. Keep in mind that in Phalcon 4 we will most likely remove all `*\Apc` classes. {.alert.alert-warning}

<a name='adapters-backend-factory'></a>

### Factory

多くのバックエンドアダプタがあります ([バックエンドアダプター](#adapters-backend)を参照)。 The one you use will depend on the needs of your application. 次の例では、`adapter`オプションを使用してBackend Cache Adapterクラスをロードし、フロントエンドが配列として提供される場合はFrontend Cache Factoryが呼ばれます。

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

The [Phalcon\Cache\BackendInterface](api/Phalcon_Cache_BackendInterface) interface must be implemented in order to create your own backend adapters or extend the existing ones.

<a name='adapters-backend-file'></a>

### ファイルバックエンドのオプション

このバックエンドは、キャッシュされたコンテンツをローカルサーバーのファイルに格納します。 このバックエンドで利用できるオプションは次のとおりです:

| オプション      | Description                     |
| ---------- | ------------------------------- |
| `prefix`   | キャッシュキーの前に自動的に付加される接頭辞。         |
| `cacheDir` | キャッシュされたファイルが置かれる書き込み可能なディレクトリ。 |

<a name='adapters-backend-libmemcached'></a>

### Libmemcachedバックエンドのオプション

このバックエンドは、キャッシュされたコンテンツをmemcachedサーバーに格納します。 デフォルトでは、永続的なmemcached接続プールが使用されます。 このバックエンドで利用できるオプションは次のとおりです。

**一般設定**

| オプション           | Description                                                       |
| --------------- | ----------------------------------------------------------------- |
| `statsKey`      | キャッシュされたキーの追跡に使用されます。                                             |
| `prefix`        | キャッシュキーの前に自動的に付加される接頭辞。                                           |
| `persistent_id` | リクエストの間に存続するインスタンスを作成するには、`persistent_id`を使用してインスタンスの一意のIDを指定します。 |

**サーバー設定**

| オプション    | Description                                               |
| -------- | --------------------------------------------------------- |
| `host`   | `memcached`ホスト。                                           |
| `port`   | `memcached`ポート番号。                                         |
| `weight` | weightパラメータは、キーを読み書きするサーバを決定するために使用されるコンシステントハッシュ法に影響します。 |

**クライアント設定**

Used for setting Memcached options. See [Memcached::setOptions](https://php.net/manual/en/memcached.setoptions.php) for more.

**例**

```php
<?php
use Phalcon\Cache\Backend\Libmemcached;
use Phalcon\Cache\Frontend\Data as FrontData;

// データを2日間キャッシュ
$frontCache = new FrontData(
    [
        'lifetime' => 172800,
    ]
);

// memcachedの接続オプションを設定するキャッシュを作成する
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

このバックエンドは、キャッシュされたコンテンツをmemcachedサーバーに格納します。 このバックエンドで利用できるオプションは次のとおりです。

| オプション        | Description                 |
| ------------ | --------------------------- |
| `prefix`     | キャッシュキーの前に自動的に付加される接頭辞。     |
| `host`       | Memcachedホスト。               |
| `port`       | memcachedポート番号。             |
| `persistent` | memcachedへの永続的な接続を作成するかどうか。 |

<a name='adapters-backend-apc'></a>

### APCバックエンドのオプション

This backend will store cached content on Alternative PHP Cache ([APC](https://php.net/apc)). The available options for this backend are:

| オプション    | Description             |
| -------- | ----------------------- |
| `prefix` | キャッシュキーの前に自動的に付加される接頭辞。 |

<a name='adapters-backend-apcu'></a>

### APCUバックエンドのオプション

This backend will store cached content on Alternative PHP Cache ([APCU](https://php.net/apcu)). The available options for this backend are:

| オプション    | Description             |
| -------- | ----------------------- |
| `prefix` | キャッシュキーの前に自動的に付加される接頭辞。 |

<a name='adapters-backend-mongo'></a>

### Mongoバックエンドのオプション

This backend will store cached content on a MongoDB server ([MongoDB](https://mongodb.org/)). The available options for this backend are:

| オプション        | Description             |
| ------------ | ----------------------- |
| `prefix`     | キャッシュキーの前に自動的に付加される接頭辞。 |
| `server`     | MongoDB接続文字列。           |
| `db`         | Mongoデータベース名。           |
| `collection` | データベースのMongoコレクション。     |

<a name='adapters-backend-xcache'></a>

### XCacheバックエンドのオプション

This backend will store cached content on XCache ([XCache](https://xcache.lighttpd.net/)). The available options for this backend are:

| オプション    | Description             |
| -------- | ----------------------- |
| `prefix` | キャッシュキーの前に自動的に付加される接頭辞。 |

<a name='adapters-backend-redis'></a>

### Redisバックエンドのオプション

This backend will store cached content on a Redis server ([Redis](https://redis.io/)). The available options for this backend are:

| オプション        | Description                        |
| ------------ | ---------------------------------- |
| `prefix`     | キャッシュキーの前に自動的に付加される接頭辞。            |
| `host`       | Redisホスト。                          |
| `port`       | Redisポート。                          |
| `auth`       | パスワードで保護されたRedisサーバーに認証するためのパスワード。 |
| `persistent` | Redisへの永続的な接続を作成するかどうか。            |
| `index`      | 使用するRedisデータベースのインデックス。            |

[Phalcon Incubator](https://github.com/phalcon/incubator) には、このコンポーネントを利用するための複数のアダプターが用意されています。