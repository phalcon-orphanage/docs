---
layout: article
language: 'ja-jp'
version: '4.0'
title: 'Phalcon\Annotations\Reader'
---
# Class **Phalcon\Annotations\Reader**

*implements* [Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface)

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/reader.zep)

見つかったアノテーションの配列が返す docblockをパースします。

## メソッド

public **parse** (*mixed* $className)

クラスのdockblock、そのメソッドまたはプロパティの注釈を読み込みます。

public static **parseDocBlock** (*mixed* $docBlock, [*mixed* $file], [*mixed* $line])

見つかったアノテーションが返す doc blockをそのままパースします。