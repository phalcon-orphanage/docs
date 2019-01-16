---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Annotations\Annotation'
---
# Class **Phalcon\Annotations\Annotation**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/annotations/annotation.zep" class="btn btn-default btn-sm">GitHub上のソース</a>

アノテーションコレクションの単一のアノテーションを表示します。

## メソッド

public **__construct** (*array* $reflectionData)

Phalcon\Annotations\Annotation constructor

public **getName** ()

アノテーションの名前を返します。

public *mixed* **getExpression** (*array* $expr)

アノテーションの式を解決します。

public *array* **getExprArguments** ()

引数を解釈しないで式を返します。

public *array* **getArguments** ()

式の引数を返します。

public **numberArguments** ()

そのアノテーションが持っている引数の数を返します。

public *mixed* **getArgument** (*int* | *string* $position)

指定位置にある引数を返します。

public *boolean* **hasArgument** (*int* | *string* $position)

指定位置にある引数を返します。

public *mixed* **getNamedArgument** (*mixed* $name)

名前付き引数を返します。

public *mixed* **getNamedParameter** (*mixed* $name)

名前付きパラメーターを返します。