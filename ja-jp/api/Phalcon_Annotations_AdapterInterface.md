* * *

layout: default language: 'en' version: '3.4' title: 'Phalcon\Annotations\AdapterInterface'

* * *

# Interface **Phalcon\Annotations\AdapterInterface**

<a href="https://github.com/phalcon/cphalcon/tree/v3.4.0/phalcon/annotations/adapterinterface.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

このインターフェースは、Phalcon\Annotationsのアダプターで実装されなければなりません。

## メソッド

abstract public **setReader** ([Phalcon\Annotations\ReaderInterface](/3.4/en/api/Phalcon_Annotations_ReaderInterface) $reader)

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