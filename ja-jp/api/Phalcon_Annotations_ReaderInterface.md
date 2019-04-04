---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'Phalcon\Annotations\ReaderInterface'
---
# Interface **Phalcon\Annotations\ReaderInterface**

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/readerinterface.zep)

## メソッド

abstract public **parse** (*mixed* $className)

クラスのdockblock、そのメソッドまたはプロパティの注釈を読み込みます。

abstract public static **parseDocBlock** (*mixed* $docBlock, [*mixed* $file], [*mixed* $line])

見つかったアノテーションが返す doc blockをそのままパースします。