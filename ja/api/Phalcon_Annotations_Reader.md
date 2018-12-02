# Class **Phalcon\\Annotations\\Reader**

*implements* [Phalcon\Annotations\ReaderInterface](/en/3.2/api/Phalcon_Annotations_ReaderInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/annotations/reader.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

見つかったアノテーションの配列が返す docblockをパースします。

## メソッド

public **parse** (*mixed* $className)

クラスのdockblock、そのメソッドまたはプロパティの注釈を読み込みます。

public static **parseDocBlock** (*mixed* $docBlock, [*mixed* $file], [*mixed* $line])

見つかったアノテーションが返す doc blockをそのままパースします。