* * *

layout: default language: 'en' version: '3.4' title: 'Phalcon\Annotations\Reader'

* * *

# Class **Phalcon\Annotations\Reader**

*implements* [Phalcon\Annotations\ReaderInterface](/3.4/en/api/Phalcon_Annotations_ReaderInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v3.4.0/phalcon/annotations/reader.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

見つかったアノテーションの配列が返す docblockをパースします。

## メソッド

public **parse** (*mixed* $className)

クラスのdockblock、そのメソッドまたはプロパティの注釈を読み込みます。

public static **parseDocBlock** (*mixed* $docBlock, [*mixed* $file], [*mixed* $line])

見つかったアノテーションが返す doc blockをそのままパースします。