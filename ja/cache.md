<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">キャッシュによるパフォーマンスの向上</a> <ul>
        <li>
          <a href="#implementation">いつキャッシュを実装する？</a>
        </li>
        <li>
          <a href="#caching-behavior">キャッシュの振る舞い</a>
        </li>
        <li>
          <a href="#factory">Factory</a>
        </li>
        <li>
          <a href="#output-fragments">出力フラグメントのキャッシュ</a>
        </li>
        <li>
          <a href="#arbitrary-data">任意データのキャッシュ</a> <ul>
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
          <a href="#adapters-frontend">フロントエンド アダプター</a> <ul>
            <li>
              <a href="#adapters-frontend-custom">独自フロントエンドアダプターの実装</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#adapters-backend">バックエンドアダプター</a> <ul>
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

- 毎回同じ結果 (変更頻度の低い) を返す複雑な計算をしている
- 多くのヘルパを利用し、生成される出力がほとんど同じである
- 常にデータベースのデータにアクセスしており、これらのデータはほとんど変わらない

<h5 class='alert alert-warning'><em>メモ</em> キャッシュを実装した後でも、一定の期間でキャッシュのヒット率を確認するようにしましょう。 特にMemcacheやApcの場合、バックエンドが提供する関連ツールを使用すると、これを簡単に行うことができます。</h5>

<a name='caching-behavior'></a>

## キャッシュの振る舞い

キャッシュ処理は、2 つの部分に分かれています。

- **フロントエンド**: この部分は、キーが期限切れになっていないかどうかをチェックし、保存する前にデータに追加の変換を実行します。
- **バックエンド**: この部分は、フロントエンドが必要とするデータの通信、書き込み、読み取りを行います。

<a name='factory'></a>

## ファクトリー

フロントエンドまたはバックエンドのアダプタをインスタンス化するには、次の2つの方法があります。

- 従来の方法

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

または、次のようにFactoryオブジェクトを使用します:

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

もしこのオプションがある場合。

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

<h5 class='alert alert-warning'><em>注意</em>上記の例では、コードは以前と同じように出力されます。 キャッシュコンポーネントは透過的にその出力をキャプチャし、キャッシュファイルに保存します（キャッシュが生成されたとき）。または、前回の呼び出しで事前にコンパイルされたものをユーザーにレスポンスすることで、コストの高い処理を回避します。</h5>

<a name='arbitrary-data'></a>

## 任意データのキャッシュ

データだけをキャッシュすることは、アプリケーションにとっても同様に重要です。 キャッシュは、一般的に使用されている（更新されていない）データを再利用することでデータベースの負荷を軽減することができ、アプリケーションの処理速度が向上します。

<a name='backend-file-example'></a>

### ファイルバックエンドの例

キャッシュのアダプターの1つは、'File'です。 このアダプターの唯一重要なところは、そのキャッシュファイルを保存する場所です。 これは、`cacheDir` オプションで制御できます。このディレクトリは、最後が バックスラッシュで*終らなければなりません。*

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

<h5 class='alert alert-warning'><em>注意</em> <code>save()</code>を呼び、論理値を返します。これは成功 (<code>true</code>) または失敗 (<code>false</code>) を示します。 使用しているバックエンドに応じて、関連するログを調べて障害を特定する必要があります。</h5>

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

| アダプター                                   | 説明                                      | 情報                                        | 必須エクステンション                                         |
| --------------------------------------- | --------------------------------------- | ----------------------------------------- | -------------------------------------------------- |
| `Phalcon\Cache\Backend\Apc`          | Alternative PHP Cache (APC) にデータを格納します。 | [APC](http://php.net/apc)                 | [APC](http://pecl.php.net/package/APC)             |
| `Phalcon\Cache\Backend\Apcu`         | データをAPCuに格納します（オペコードキャッシングなしのAPC）       | [APCu](http://php.net/apcu)               | [APCu](http://pecl.php.net/package/APCu)           |
| `Phalcon\Cache\Backend\File`         | ローカルのプレーンファイルにデータを格納します。                |                                           |                                                    |
| `Phalcon\Cache\Backend\Libmemcached` | memcachedサーバーにデータを格納します。                | [Memcached](http://www.php.net/memcached) | [Memcached](http://pecl.php.net/package/memcached) |
| `Phalcon\Cache\Backend\Memcache`     | memcachedサーバーにデータを格納します。                | [Memcache](http://www.php.net/memcache)   | [Memcache](http://pecl.php.net/package/memcache)   |
| `Phalcon\Cache\Backend\Mongo`        | データをMongoデータベースに保存します。                  | [MongoDB](http://mongodb.org/)            | [Mongo](http://mongodb.org/)                       |
| `Phalcon\Cache\Backend\Redis`        | Redisにデータを格納します。                        | [Redis](http://redis.io/)                 | [Redis](http://pecl.php.net/package/redis)         |
| `Phalcon\Cache\Backend\Xcache`       | XCacheにデータを格納します。                       | [XCache](http://xcache.lighttpd.net/)     | [XCache](http://pecl.php.net/package/xcache)       |

<h5 class='alert alert-warning'><em>注意</em> PHP7で Phalcon <code>apc</code> ベースのアダプター クラスを使用する場合、pecl から <code>apcu</code>と<code>apcu_bc</code> パッケージをインストールする必要があります。 Phalcon 3.2.0 では、あなたは <code>*\Apc</code> クラスを <code>*\Apcu</code> に変更して、<code>apcu_bc</code>を削除できます。 Phalcon 4 では、ほとんどすべての <code>*\Apc</code> クラスを削除したことを覚えていてだください。</h5>

<a name='adapters-backend-custom'></a>

### 独自のバックエンドアダプターを実装

独自のバックエンドアダプタを作成したり既存のバックエンドアダプタを拡張するには、`Phalcon\Cache\BackendInterface`インタフェースを実装する必要があります。

<a name='adapters-backend-file'></a>

### ファイルバックエンドのオプション

このバックエンドは、キャッシュされたコンテンツをローカルサーバーのファイルに格納します。 このバックエンドで利用できるオプションは次のとおりです:

| オプション      | 説明                              |
| ---------- | ------------------------------- |
| `prefix`   | キャッシュキーの前に自動的に付加される接頭辞。         |
| `cacheDir` | キャッシュされたファイルが置かれる書き込み可能なディレクトリ。 |

<a name='adapters-backend-libmemcached'></a>

### Libmemcachedバックエンドのオプション

このバックエンドは、キャッシュされたコンテンツをmemcachedサーバーに格納します。 デフォルトでは、永続的なmemcached接続プールが使用されます。 このバックエンドで利用できるオプションは次のとおりです。

**一般設定**

| オプション           | 説明                                                                |
| --------------- | ----------------------------------------------------------------- |
| `statsKey`      | キャッシュされたキーの追跡に使用されます。                                             |
| `prefix`        | キャッシュキーの前に自動的に付加される接頭辞。                                           |
| `persistent_id` | リクエストの間に存続するインスタンスを作成するには、`persistent_id`を使用してインスタンスの一意のIDを指定します。 |

**サーバー設定**

| オプション    | 説明                                                        |
| -------- | --------------------------------------------------------- |
| `host`   | `memcached`ホスト。                                           |
| `port`   | `memcached`ポート番号。                                         |
| `weight` | weightパラメータは、キーを読み書きするサーバを決定するために使用されるコンシステントハッシュ法に影響します。 |

**クライアント設定**

Memcachedオプションの設定に使用します。 詳細については、[Memcached::setOptions](http://php.net/manual/en/memcached.setoptions.php)を参照してください。

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

| オプション        | 説明                          |
| ------------ | --------------------------- |
| `prefix`     | キャッシュキーの前に自動的に付加される接頭辞。     |
| `host`       | Memcachedホスト。               |
| `port`       | memcachedポート番号。             |
| `persistent` | memcachedへの永続的な接続を作成するかどうか。 |

<a name='adapters-backend-apc'></a>

### APCバックエンドのオプション

このバックエンドは、Alternative PHP Cache ([APC](http://php.net/apc)) にキャッシュされたコンテンツを格納します。 このバックエンドで利用できるオプションは次のとおりです。

| オプション    | 説明                      |
| -------- | ----------------------- |
| `prefix` | キャッシュキーの前に自動的に付加される接頭辞。 |

<a name='adapters-backend-apcu'></a>

### APCUバックエンドのオプション

このバックエンドは、Alternative PHP Cache ([APCU](http://php.net/apcu)) にキャッシュされたコンテンツを格納します。 このバックエンドで利用できるオプションは次のとおりです。

| オプション    | 説明                      |
| -------- | ----------------------- |
| `prefix` | キャッシュキーの前に自動的に付加される接頭辞。 |

<a name='adapters-backend-mongo'></a>

### Mongoバックエンドのオプション

このバックエンドは、キャッシュされたコンテンツをMongoDBサーバー ([MongoDB](http://mongodb.org/)) に格納します。 このバックエンドで利用できるオプションは次のとおりです。

| オプション        | 説明                      |
| ------------ | ----------------------- |
| `prefix`     | キャッシュキーの前に自動的に付加される接頭辞。 |
| `server`     | MongoDB接続文字列。           |
| `db`         | Mongoデータベース名。           |
| `collection` | データベースのMongoコレクション。     |

<a name='adapters-backend-xcache'></a>

### XCacheバックエンドのオプション

このバックエンドはキャッシュされたコンテンツをXCache ([XCache](http://xcache.lighttpd.net/)) に格納します。 このバックエンドで利用できるオプションは次のとおりです。

| オプション    | 説明                      |
| -------- | ----------------------- |
| `prefix` | キャッシュキーの前に自動的に付加される接頭辞。 |

<a name='adapters-backend-redis'></a>

### Redisバックエンドのオプション

このバックエンドは、キャッシュされたコンテンツをRedisサーバー ([ Redis ](http://redis.io/)) に格納します。 このバックエンドで利用できるオプションは次のとおりです。

| オプション        | 説明                                 |
| ------------ | ---------------------------------- |
| `prefix`     | キャッシュキーの前に自動的に付加される接頭辞。            |
| `host`       | Redisホスト。                          |
| `port`       | Redisポート。                          |
| `auth`       | パスワードで保護されたRedisサーバーに認証するためのパスワード。 |
| `persistent` | Redisへの永続的な接続を作成するかどうか。            |
| `index`      | 使用するRedisデータベースのインデックス。            |

[Phalcon Incubator](https://github.com/phalcon/incubator) には、このコンポーネントを利用するための複数のアダプターが用意されています。