* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Cache\Backend\Redis'

* * *

# Class **Phalcon\Cache\Backend\Redis**

*extends* abstract class [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/cache/backend/redis.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

redisバックエンドを使用して、出力フラグメント、PHPデータ、生のデータをキャッシュできます。

このアダプタは特別な"_PHCR"のredisキーを使用して、このアダプタで内部で使用する全てのキーを保管します。

```php
<?php

use Phalcon\Cache\Backend\Redis;
use Phalcon\Cache\Frontend\Data as FrontData;

// データを2日間キャッシュ
$frontCache = new FrontData(
    [
        "lifetime" => 172800,
    ]
);

// redis接続オプションを設定するキャッシュを作成
$cache = new Redis(
    $frontCache,
    [
        "host"       => "localhost",
        "port"       => 6379,
        "auth"       => "foobared",
        "persistent" => false,
        "index"      => 0,
    ]
);

// 任意のデータをキャッシュ
$cache->save("my-data", [1, 2, 3, 4, 5]);

// データを取得
$data = $cache->get("my-data");

```

## メソッド

public **__construct** ([Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface) $frontend, [*array* $options])

Phalcon\Cache\Backend\Redis constructor

public **_connect** ()

redisへの内部接続を作成する

public **get** (*mixed* $keyName, [*mixed* $lifetime])

キャッシュしたコンテンツを返します。

public **save** ([*int* | *string* $keyName], [*string* $content], [*int* $lifetime], [*boolean* $stopBuffer])

ファイルバックエンドにキャッシュしたコンテンツを保管し、フロントエンドを停止します。

```php
<?php

$cache->save("my-key", $data);

// 無条件にデータを保存
$cache->save("my-key", $data, -1);

```

public **delete** (*int* | *string* $keyName)

キャッシュから そのキーによって値を削除します。

public **queryKeys** ([*mixed* $prefix])

既存のキャッシュされたキーを問合せ

```php
<?php

$cache->save("users-ids", [1, 2, 3]);
$cache->save("projects-ids", [4, 5, 6]);

var_dump($cache->queryKeys("users")); // ["users-ids"]

```

public **exists** ([*string* $keyName], [*int* $lifetime])

キャッシュが存在しそれが期限切れでないことをチェックします。

public **increment** ([*string* $keyName], [*mixed* $value])

与えられた$keyName を $value だけインクリメント

public **decrement** ([*string* $keyName], [*mixed* $value])

$keyName を指定された $value だけデクリメントします。

public **flush** ()

ただちに、すべての既存のアイテムを無効にします。

public **getFrontend** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

...

public **setFrontend** (*mixed* $frontend) inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

...

public **getOptions** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

...

public **setOptions** (*mixed* $options) inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

...

public **getLastKey** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

...

public **setLastKey** (*mixed* $lastKey) inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

...

public *mixed* **start** (*int* | *string* $keyName, [*int* $lifetime]) inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

キャッシュを開始します。このkeynameは作成したフラグメントの特定に使用できます。

public **stop** ([*mixed* $stopBuffer]) inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

キャッシュしたコンテンツを保存しないで、フロントエンドを停止します。

public **isFresh** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

直前のキャッシュが新鮮なものか、それともキャッシュされているかをチェックします。

public **isStarted** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

このキャッシュのバッファリングが開始しているか、そうでないかをチェックします。

public *int* **getLifetime** () inherited from [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

直前のライフタイムのセットを取得します。