---
layout: article
language: 'ja-jp'
version: '4.0'
title: 'Phalcon\Annotations\Reflection'
---
# Class **Phalcon\Annotations\Reflection**

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/reflection.zep)

オブジェクト指向の方法で、アノテーションのリフレクションを操作できます。

```php
<?php

use Phalcon\Annotations\Reader;
use Phalcon\Annotations\Reflection;

// クラスのアノテーションのパース
$reader = new Reader();
$parsing = $reader->parse("MyComponent");

// リフレクションの作成
$reflection = new Reflection($parsing);

// クラスのdocblockのアノテーションを取得
$classAnnotations = $reflection->getClassAnnotations();

```

## メソッド

public **__construct** ([*array* $reflectionData])

Phalcon\Annotations\Reflection constructor

public **getClassAnnotations** ()

そのクラスのdocblockで見つかったアノテーションを返します。

public **getMethodsAnnotations** ()

そのメソッドのdocblockで見つかったアノテーションを返します。

public **getPropertiesAnnotations** ()

そのプロパティのdocblockで見つかったアノテーションを返します。

public *array* **getReflectionData** ()

リフレクションを構成する際に使用する中間定義をそのままパースして返します。

public static *array data* **__set_state** (*mixed* $data)

Restores the state of a Phalcon\Annotations\Reflection variable export