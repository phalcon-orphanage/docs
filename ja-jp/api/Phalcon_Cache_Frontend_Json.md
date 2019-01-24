---
layout: article
language: 'ja-jp'
version: '4.0'
title: 'Phalcon\Cache\Frontend\Json'
---
# Class **Phalcon\Cache\Frontend\Json**

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/json.zep)

JSON形式でエンコード/デコードしたデータをキャッシュできる。

このアダプタは json_encode/json_decode のPHP関数を使用します。

As the data is encoded in JSON other systems accessing the same backend could process them

```php
<?php

<?php

// データを二日間キャッシュ
$frontCache = new \Phalcon\Cache\Frontend\Json(
    [
        "lifetime" => 172800,
    ]
);

// memcachedの接続オプションを設定するキャッシュを作成する
$cache = new \Phalcon\Cache\Backend\Memcache(
    $frontCache,
    [
        "host"       => "localhost",
        "port"       => 11211,
        "persistent" => false,
    ]
);

// 任意データをキャッシュ
$cache->save("my-data", [1, 2, 3, 4, 5]);

// データ取得
$data = $cache->get("my-data");

```

## メソッド

public **__construct** ([*array* $frontendOptions])

Phalcon\Cache\Frontend\Base64 constructor

public **getLifetime** ()

キャッシュの有効期間を返します。

public **isBuffering** ()

フロントエンドが出力をバッファリングするかどうかチェックします。

public **start** ()

Starts output frontend. Actually, does nothing

public *string* **getContent** ()

キャッシュしたコンテンツを返します。

public **stop** ()

フロントエンドの出力を停止します。

public **beforeStore** (*mixed* $data)

保存する前にデータをシリアライズします。

public **afterRetrieve** (*mixed* $data)

取得後にデータのシリアライズ化を戻します。