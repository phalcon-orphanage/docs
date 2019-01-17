---
layout: article
language: 'ja-jp'
version: '4.0'
title: 'Phalcon\Cache\Frontend\Data'
---
# Class **Phalcon\Cache\Frontend\Data**

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cache/frontend/data.zep)

シリアライズした形式でネイティブのPHPデータをキャッシュできます。

```php
<?php

use Phalcon\Cache\Backend\File;
use Phalcon\Cache\Frontend\Data;

// Dataフロントエンドを使用して2日間ファイルをキャッシュする
$frontCache = new Data(
    [
        "lifetime" => 172800,
    ]
);

// "Data" を 'File'バックエンドにキャッシュするコンポーネントを作成します。
// キャッシュファイルのディレクトリを設定します。 重要:フォルダの値の最後に
// '/'を残してください。
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
    // $robots が nullの場合キャッシュが期限切れかデータが無いのどちらか
    // データベースを呼び出して変数に代入
    $robots = Robots::find(
        [
            "order" => "id",
        ]
    );

    // キャッシュに保存
    $cache->save($cacheKey, $robots);
}

// $robots を使用
foreach ($robots as $robot) {
    echo $robot->name, "\n";
}

```

## メソッド

public **__construct** ([*array* $frontendOptions])

Phalcon\Cache\Frontend\Data constructor

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