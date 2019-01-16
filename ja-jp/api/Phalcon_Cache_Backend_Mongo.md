* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Cache\Backend\Mongo'

* * *

# Class **Phalcon\Cache\Backend\Mongo**

*extends* abstract class [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/cache/backend/mongo.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

MongoDb バックエンドを使用して、出力フラグメント、PHPデータ、生のデータをキャッシュできます。

```php
<?php

use Phalcon\Cache\Backend\Mongo;
use Phalcon\Cache\Frontend\Base64;

// データを2日間キャッシュ
$frontCache = new Base64(
    [
        "lifetime" => 172800,
    ]
);

// MongoDBキャッシュを作成
$cache = new Mongo(
    $frontCache,
    [
        "server"     => "mongodb://localhost",
        "db"         => "caches",
        "collection" => "images",
    ]
);

// 任意のデータをキャッシュ
$cache->save(
    "my-data",
    file_get_contents("some-image.jpg")
);

// データを取得
$data = $cache->get("my-data");

```

## メソッド

public **__construct** ([Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface) $frontend, [*array* $options])

Phalcon\Cache\Backend\Mongo constructor

final protected *MongoCollection* **_getCollection** ()

バックエンドパラメータに基づいてMongoDb接続を返します。

public **get** (*mixed* $keyName, [*mixed* $lifetime])

キャッシュしたコンテンツを返します。

public **save** ([*int* | *string* $keyName], [*string* $content], [*int* $lifetime], [*boolean* $stopBuffer])

ファイルバックエンドにキャッシュしたコンテンツを保管し、フロントエンドを停止します。

public *boolean* **delete** (*int* | *string* $keyName)

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

public *collection->remove(...)* **gc** ()

ガーベッジコレクション

public **increment** (*int* | *string* $keyName, [*mixed* $value])

与えられたキーを $value だけインクリメント

public **decrement** (*int* | *string* $keyName, [*mixed* $value])

与えられたキーを $value だけデクリメント

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