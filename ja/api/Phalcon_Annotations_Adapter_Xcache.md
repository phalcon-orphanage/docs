# Class **Phalcon\\Annotations\\Adapter\\Xcache**

*extends* abstract class [Phalcon\Annotations\Adapter](/[[language]]/[[version]]/api/Phalcon_Annotations_Adapter)

*implements* [Phalcon\Annotations\AdapterInterface](/[[language]]/[[version]]/api/Phalcon_Annotations_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/annotations/adapter/xcache.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

パースしたアノテーションをXCacheに保存します。このアダプターはプロダクション向けです。

```php
<?php

$annotations = new \Phalcon\Annotations\Adapter\Xcache();

```

## メソッド

public [Phalcon\Annotations\Reflection](/[[language]]/[[version]]/api/Phalcon_Annotations_Reflection) **read** (*string* $key)

パースしたアノテーションをXCacheから読み込みます。

public **write** (*mixed* $key, [Phalcon\Annotations\Reflection](/[[language]]/[[version]]/api/Phalcon_Annotations_Reflection) $data)

パースしたアノテーションをXCacheに書き込みます。

public **setReader** ([Phalcon\Annotations\ReaderInterface](/[[language]]/[[version]]/api/Phalcon_Annotations_ReaderInterface) $reader) inherited from [Phalcon\Annotations\Adapter](/[[language]]/[[version]]/api/Phalcon_Annotations_Adapter)

アノテーションパーサーを設定します。

public **getReader** () inherited from [Phalcon\Annotations\Adapter](/[[language]]/[[version]]/api/Phalcon_Annotations_Adapter)

アノテーションリーダーを返します。

public **get** (*string* | *object* $className) inherited from [Phalcon\Annotations\Adapter](/[[language]]/[[version]]/api/Phalcon_Annotations_Adapter)

クラス内で見つかったすべてのアノテーションをパースまたは取得します。

public **getMethods** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](/[[language]]/[[version]]/api/Phalcon_Annotations_Adapter)

そのクラスのすべてのメソッドで見つかったアノテーションを返します。

public **getMethod** (*mixed* $className, *mixed* $methodName) inherited from [Phalcon\Annotations\Adapter](/[[language]]/[[version]]/api/Phalcon_Annotations_Adapter)

そのメソッドで見つかったアノテーションを返します。

public **getProperties** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](/[[language]]/[[version]]/api/Phalcon_Annotations_Adapter)

そのクラスのすべてのメソッドで見つかったアノテーションを返します。

public **getProperty** (*mixed* $className, *mixed* $propertyName) inherited from [Phalcon\Annotations\Adapter](/[[language]]/[[version]]/api/Phalcon_Annotations_Adapter)

そのプロパティで見つかったアノテーションを返します。