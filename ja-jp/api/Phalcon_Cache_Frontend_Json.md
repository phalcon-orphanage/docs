* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Cache\Frontend\Json'

* * *

# Class **Phalcon\Cache\Frontend\Json**

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/cache/frontend/json.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

Allows to cache data converting/deconverting them to JSON.

This adapter uses the json_encode/json_decode PHP's functions

As the data is encoded in JSON other systems accessing the same backend could process them

```php
<?php

<?php

// Cache the data for 2 days
$frontCache = new \Phalcon\Cache\Frontend\Json(
    [
        "lifetime" => 172800,
    ]
);

// Create the Cache setting memcached connection options
$cache = new \Phalcon\Cache\Backend\Memcache(
    $frontCache,
    [
        "host"       => "localhost",
        "port"       => 11211,
        "persistent" => false,
    ]
);

// Cache arbitrary data
$cache->save("my-data", [1, 2, 3, 4, 5]);

// Get data
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

フロントエンドの出力を開始します。実際には、何もしません。

public *string* **getContent** ()

キャッシュしたコンテンツを返します。

public **stop** ()

フロントエンドの出力を停止します。

public **beforeStore** (*mixed* $data)

保存する前にデータをシリアライズします。

public **afterRetrieve** (*mixed* $data)

取得後にデータのシリアライズ化を戻します。