* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Cache\Frontend\Igbinary'

* * *

# Class **Phalcon\Cache\Frontend\Igbinary**

*extends* class [Phalcon\Cache\Frontend\Data](Phalcon_Cache_Frontend_Data)

*implements* [Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/cache/frontend/igbinary.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

igbinary拡張モジュールを使用して、シリアライズしたフォームにネイティブのPHPデータをキャッシュできます。

```php
<?php

// Igbinaryフロントエンドで二日間、ファイルをキャッシュ
$frontCache = new \Phalcon\Cache\Frontend\Igbinary(
    [
        "lifetime" => 172800,
    ]
);

// "Igbinary"を "File"バックエンドにキャッシュするコンポーネントの作成
// キャッシュファイルディレクトリの設定 このフォルダの値の最後が "/" 
// になるように注意
$cache = new \Phalcon\Cache\Backend\File(
    $frontCache,
    [
        "cacheDir" => "../app/cache/",
    ]
);

$cacheKey = "robots_order_id.cache";

// キャッシュされたレコードを取得
$robots = $cache->get($cacheKey);

if ($robots === null) {
    // キャッシュ期限切れかデータがない場合 $robots は nullになる。
    // データベースを呼び出してこの変数に値を設定
    $robots = Robots::find(
        [
            "order" => "id",
        ]
    );

    // これをキャッシュに保存
    $cache->save($cacheKey, $robots);
}

// $robots を使用 (^_^)
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

フロントエンドの出力を開始します。実際には、何もしません。

public *string* **getContent** ()

キャッシュしたコンテンツを返します。

public **stop** ()

フロントエンドの出力を停止します。

public **beforeStore** (*mixed* $data)

保存する前にデータをシリアライズします。

public **afterRetrieve** (*mixed* $data)

取得後にデータのシリアライズ化を戻します。