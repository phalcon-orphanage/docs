* * *

layout: default language: 'en' version: '3.4' title: 'Phalcon\Annotations\Adapter'

* * *

# Abstract class **Phalcon\Annotations\Adapter**

*implements* [Phalcon\Annotations\AdapterInterface](/3.4/en/api/Phalcon_Annotations_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v3.4.0/phalcon/annotations/adapter.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

This is the base class for Phalcon\Annotations adapters

## メソッド

public **setReader** ([Phalcon\Annotations\ReaderInterface](/3.4/en/api/Phalcon_Annotations_ReaderInterface) $reader)

アノテーションパーサーを設定します。

public **getReader** ()

アノテーションリーダーを返します。

public **get** (*string* | *object* $className)

クラス内で見つかったすべてのアノテーションをパースまたは取得します。

public **getMethods** (*mixed* $className)

そのクラスのすべてのメソッドで見つかったアノテーションを返します。

public **getMethod** (*mixed* $className, *mixed* $methodName)

そのメソッドで見つかったアノテーションを返します。

public **getProperties** (*mixed* $className)

そのクラスのすべてのメソッドで見つかったアノテーションを返します。

public **getProperty** (*mixed* $className, *mixed* $propertyName)

そのプロパティで見つかったアノテーションを返します。