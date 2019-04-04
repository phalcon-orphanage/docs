---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'Phalcon\Annotations\AdapterInterface'
---
# Interface **Phalcon\Annotations\AdapterInterface**

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/adapterinterface.zep)

このインターフェースは、Phalcon\Annotationsのアダプターで実装されなければなりません。

## メソッド

abstract public **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader)

アノテーションパーサーを設定します。

abstract public **getReader** ()

アノテーションリーダーを返します。

abstract public **get** (*string|object* $className)

クラス内で見つかったすべてのアノテーションをパースまたは取得します。

abstract public **getMethods** (*string* $className)

そのクラスのすべてのメソッドで見つかったアノテーションを返します。

abstract public **getMethod** (*string* $className, *string* $methodName)

そのメソッドで見つかったアノテーションを返します。

abstract public **getProperties** (*string* $className)

そのクラスのすべてのメソッドで見つかったアノテーションを返します。

abstract public **getProperty** (*string* $className, *string* $propertyName)

そのプロパティで見つかったアノテーションを返します。