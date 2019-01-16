* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Cache\Frontend\Base64'

* * *

# Class **Phalcon\Cache\Frontend\Base64**

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/cache/frontend/base64.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

base64形式でエンコード/デコードしたデータをキャッシュできる。

このアダプタは base64_encode/base64_decode のPHP関数を使用します。

```php
<?php

<?php

// Base64 フロントエンドを使ってファイルを2日間キャッシュ。
$frontCache = new \Phalcon\Cache\Frontend\Base64(
    [
        "lifetime" => 172800,
    ]
);

// MongoDBキャッシュを作成
$cache = new \Phalcon\Cache\Backend\Mongo(
    $frontCache,
    [
        "server"     => "mongodb://localhost",
        "db"         => "caches",
        "collection" => "images",
    ]
);

$cacheKey = "some-image.jpg.cache";

// キャッシュされたイメージの取得を試みる
$image = $cache->get($cacheKey);

if ($image === null) {
    // キャッシュ内にイメージを保存する
    $cache->save(
        $cacheKey,
        file_get_contents("tmp-dir/some-image.jpg")
    );
}

header("Content-Type: image/jpeg");

echo $image;

```

## メソッド

public **__construct** ([*array* $frontendOptions])

Phalcon\Cache\Frontend\Base64 constructor

public **getLifetime** ()

キャッシュの有効期間を返します。

public **isBuffering** ()

フロントエンドが出力をバッファリングするかどうかチェックします。

public **start** ()

フロントエンドの出力を開始します。実際には、このアダプターでは何もしません。

public *string* **getContent** ()

キャッシュしたコンテンツを返します。

public **stop** ()

フロントエンドの出力を停止します。

public **beforeStore** (*mixed* $data)

保存する前にデータをシリアライズします。

public **afterRetrieve** (*mixed* $data)

取得後にデータのシリアライズ化を戻します。