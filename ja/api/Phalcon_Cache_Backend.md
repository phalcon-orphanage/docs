# Abstract class **Phalcon\\Cache\\Backend**

*implements* [Phalcon\Cache\BackendInterface](/en/3.2/api/Phalcon_Cache_BackendInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cache/backend.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

このクラスはバックエンドアダプタの共通機能を実装します。バックエンドキャッシュアダプタはこのクラスを拡張できます。

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

public **__construct** ([Phalcon\Cache\FrontendInterface](/en/3.2/api/Phalcon_Cache_FrontendInterface) $frontend, [*array* $options])

Phalcon\\Cache\\Backend コンストラクタ

public *mixed* **start** (*int* | *string* $keyName, [*int* $lifetime])

キャッシュを開始します。このkeynameは作成したフラグメントの特定に使用できます。

public **stop** ([*mixed* $stopBuffer])

キャッシュしたコンテンツを保存しないで、フロントエンドを停止します。

public **isFresh** ()

直前のキャッシュが新鮮なものか、それともキャッシュされているかをチェックします。

public **isStarted** ()

このキャッシュのバッファリングが開始しているか、そうでないかをチェックします。

public *int* **getLifetime** ()

直前のライフタイムのセットを取得します。

abstract public **get** (*mixed* $keyName, [*mixed* $lifetime]) inherited from [Phalcon\Cache\BackendInterface](/en/3.2/api/Phalcon_Cache_BackendInterface)

...

abstract public **save** ([*mixed* $keyName], [*mixed* $content], [*mixed* $lifetime], [*mixed* $stopBuffer]) inherited from [Phalcon\Cache\BackendInterface](/en/3.2/api/Phalcon_Cache_BackendInterface)

...

abstract public **delete** (*mixed* $keyName) inherited from [Phalcon\Cache\BackendInterface](/en/3.2/api/Phalcon_Cache_BackendInterface)

...

abstract public **queryKeys** ([*mixed* $prefix]) inherited from [Phalcon\Cache\BackendInterface](/en/3.2/api/Phalcon_Cache_BackendInterface)

...

abstract public **exists** ([*mixed* $keyName], [*mixed* $lifetime]) inherited from [Phalcon\Cache\BackendInterface](/en/3.2/api/Phalcon_Cache_BackendInterface)

...