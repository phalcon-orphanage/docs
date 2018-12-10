# Abstract class **Phalcon\\Annotations\\Adapter**

*implements* [Phalcon\Annotations\AdapterInterface](/en/3.2/api/Phalcon_Annotations_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/annotations/adapter.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

これは Phalcon\\Annotations アダプターの基本クラスです。

## メソッド

public **setReader** ([Phalcon\Annotations\ReaderInterface](/en/3.2/api/Phalcon_Annotations_ReaderInterface) $reader)

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