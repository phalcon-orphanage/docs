---
layout: article
language: 'ja-jp'
version: '4.0'
title: 'Phalcon\Cache\Frontend\Msgpack'
---
# Class **Phalcon\Cache\Frontend\Msgpack**

*extends* class [Phalcon\Cache\Frontend\Data](Phalcon_Cache_Frontend_Data)

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/msgpack.zep)

Allows to cache native PHP data in a serialized form using msgpack extension This adapter uses a Msgpack frontend to store the cached content and requires msgpack extension.

```php
<?php

use Phalcon\Cache\Backend\File;
use Phalcon\Cache\Frontend\Msgpack;

// Msgpack フロントエンドを使用してファイルを2日間キャッシュ。
$frontCache = new Msgpack(
    [
        "lifetime" => 172800,
    ]
);

// "Msgpack" を "File" バックエンドをキャッシュするコンポーネントを作成
// キャッシュファイルディレクトリを設定する - フォルダのためにこの値の
// 末尾を"/"にしなければなりません。
$cache = new File(
    $frontCache,
    [
        "cacheDir" => "../app/cache/",
    ]
);

$cacheKey = "robots_order_id.cache";

// キャッシュされたレコードを取得してみる
$robots = $cache->get($cacheKey);

if ($robots === null) {
    // キャッシュの期限切れやデータがない場合、$robots は null です。
    // データベースを呼び出して変数に代入
    $robots = Robots::find(
        [
            "order" => "id",
        ]
    );

    // キャッシュに保存
    $cache->save($cacheKey, $robots);
}

// $robots の使用
foreach ($robots as $robot) {
    echo $robot->name, "\n";
}

```

## メソッド

public **__construct** ([*array* $frontendOptions])

Phalcon\Cache\Frontend\Msgpack constructor

public **getLifetime** ()

キャッシュの有効期間を返します。

public **isBuffering** ()

フロントエンドが出力をバッファリングするかどうかチェックします。

public **start** ()

Starts output frontend. Actually, does nothing

public **getContent** ()

キャッシュしたコンテンツを返します。

public **stop** ()

フロントエンドの出力を停止します。

public **beforeStore** (*mixed* $data)

保存する前にデータをシリアライズします。

public **afterRetrieve** (*mixed* $data)

取得後にデータのシリアライズ化を戻します。