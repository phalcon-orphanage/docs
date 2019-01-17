---
layout: article
language: 'ja-jp'
version: '4.0'
title: 'Phalcon\Cache\Backend'
---
# Abstract class **Phalcon\Cache\Backend**

*implements* [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/cache/backend.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

This class implements common functionality for backend adapters. A backend cache adapter may extend this class

## メソッド

public **getFrontend** ()

...

public **setFrontend** (*mixed* $frontend)

...

public **getOptions** ()

...

public **setOptions** (*mixed* $options)

...

public **getLastKey** ()

...

public **setLastKey** (*mixed* $lastKey)

...

public **__construct** ([Phalcon\Cache\FrontendInterface](Phalcon_Cache_FrontendInterface) $frontend, [*array* $options])

Phalcon\Cache\Backend constructor

public *mixed* **start** (*int* | *string* $keyName, [*int* $lifetime])

キャッシュを開始します。 このkeynameは作成したフラグメントの特定に使用できます。

public **stop** ([*mixed* $stopBuffer])

キャッシュしたコンテンツを保存しないで、フロントエンドを停止します。

public **isFresh** ()

直前のキャッシュが新鮮なものか、それともキャッシュされているかをチェックします。

public **isStarted** ()

このキャッシュのバッファリングが開始しているか、そうでないかをチェックします。

public *int* **getLifetime** ()

直前のライフタイムのセットを取得します。

abstract public **get** (*mixed* $keyName, [*mixed* $lifetime]) inherited from [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

...

abstract public **save** ([*mixed* $keyName], [*mixed* $content], [*mixed* $lifetime], [*mixed* $stopBuffer]) inherited from [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

...

abstract public **delete** (*mixed* $keyName) inherited from [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

...

abstract public **queryKeys** ([*mixed* $prefix]) inherited from [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

...

abstract public **exists** ([*mixed* $keyName], [*mixed* $lifetime]) inherited from [Phalcon\Cache\BackendInterface](Phalcon_Cache_BackendInterface)

...