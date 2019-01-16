---
layout: article
language: 'ja-jp'
version: '4.0'
title: 'Phalcon\Annotations\ReaderInterface'
---
# Interface **Phalcon\Annotations\ReaderInterface**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/annotations/readerinterface.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

## メソッド

abstract public **parse** (*mixed* $className)

クラスのdockblock、そのメソッドまたはプロパティの注釈を読み込みます。

abstract public static **parseDocBlock** (*mixed* $docBlock, [*mixed* $file], [*mixed* $line])

見つかったアノテーションが返す doc blockをそのままパースします。