* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Cache\Backend\File'

* * *

# Class **Phalcon\Cache\Backend\File**

*extends* abstract class [Phalcon\Cache\Backend](Phalcon_Cache_Backend)

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/cache/backend/file.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

ファイルのバックエンドを使用して出力フラグメントをキャッシュすることができます。

```php
<?php

use Phalcon\Cache\Backend\File;
use Phalcon\Cache\Frontend\Output as FrontOutput;

// 2日間ファイルをキャッシュ
$frontendOptions = [
    "lifetime" => 172800,
];

// 出力キャッシュを作成
$frontCache = FrontOutput($frontOptions);

// キャッシュディレクトリを設定
$backendOptions = [
    "cacheDir" => "../app/cache/",
];

// ファイルバックエンドの作成
$cache = new File($frontCache, $backendOptions);

$content = $cache->start("my-cache");

if ($content === null) {
    echo "<h1>", time(), "</h1>";

    $cache->save();
} else {
    echo $content;
}

```

## メソッド

public **__construct** ([Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface) $frontend, *array* $options)

Phalcon\Cache\Backend\File constructor

public **get** (*mixed* $keyName, [*mixed* $lifetime])

キャッシュしたコンテンツを返します。

public **save** ([*int* | *string* $keyName], [*string* $content], [*int* $lifetime], [*boolean* $stopBuffer])

ファイルバックエンドにキャッシュしたコンテンツを保管し、フロントエンドを停止します。

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

public **exists** ([*string* | *int* $keyName], [*int* $lifetime])

キャッシュが存在しそれが期限切れでないことをチェックします。

public **increment** ([*string* | *int* $keyName], [*mixed* $value])

与えられたキーを $value だけインクリメント

public **decrement** ([*string* | *int* $keyName], [*mixed* $value])

与えられたキーを $value だけデクリメント

public **flush** ()

ただちに、すべての既存のアイテムを無効にします。

public **getKey** (*mixed* $key)

与えられたキーのファイルシステム安全なIDを返します。

public **useSafeKey** (*mixed* $useSafeKey)

安全なキーを使用するかどうかを設定します。

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