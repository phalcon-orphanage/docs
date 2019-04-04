---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'Phalcon\Annotations\Adapter\Apcu'
---
# Class **Phalcon\Annotations\Adapter\Apcu**

*extends* abstract class [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

*implements* [Phalcon\Annotations\AdapterInterface](Phalcon_Annotations_AdapterInterface)

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/adapter/apcu.zep)

パースしたアノテーションをAPCuに保存します。 このアダプタはプロダクション向けです。

```php
<?php

use Phalcon\Annotations\Adapter\Apcu;

$annotations = new Apcu();

```

## メソッド

public **__construct** ([*array* $options])

Phalcon\Annotations\Adapter\Apcu constructor

public **read** (*mixed* $key)

パースしたアノテーションをAPCuから読み込みます。

public **write** (*mixed* $key, [Phalcon\Annotations\Reflection](Phalcon_Annotations_Reflection) $data)

パースしたアノテーションをAPCuに書き込みます。

public **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

アノテーションパーサーを設定します。

public **getReader** () inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

アノテーションリーダーを返します。

public **get** (*string* | *object* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

クラス内で見つかったすべてのアノテーションをパースまたは取得します。

public **getMethods** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

そのクラスのすべてのメソッドで見つかったアノテーションを返します。

public **getMethod** (*mixed* $className, *mixed* $methodName) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

そのメソッドで見つかったアノテーションを返します。

public **getProperties** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

そのクラスのすべてのメソッドで見つかったアノテーションを返します。

public **getProperty** (*mixed* $className, *mixed* $propertyName) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

そのプロパティで見つかったアノテーションを返します。