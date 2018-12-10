# Interface **Phalcon\\Annotations\\ReaderInterface**

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/annotations/readerinterface.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

## メソッド

abstract public **parse** (*mixed* $className)

クラスのdockblock、そのメソッドまたはプロパティのアノテーションを読み込みます。

abstract public static **parseDocBlock** (*mixed* $docBlock, [*mixed* $file], [*mixed* $line])

見つかったアノテーションが返す doc blockをそのままパースします。