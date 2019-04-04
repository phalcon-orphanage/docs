---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'Phalcon\Annotations\Collection'
---
# Class **Phalcon\Annotations\Collection**

*implements* [Iterator](https://php.net/manual/en/class.iterator.php), [Traversable](https://php.net/manual/en/class.traversable.php), [Countable](https://php.net/manual/en/class.countable.php)

[GitHub上のソース](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/collection.zep)

Represents a collection of annotations. This class allows to traverse a group of annotations easily

```php
<?php

// アノテーションを走査する
foreach ($classAnnotations as $annotation) {
    echo "Name=", $annotation->getName(), PHP_EOL;
}

// そのアノテーションが特定のものを持っているかチェック
var_dump($classAnnotations->has("Cacheable"));

// コレクション中に指定のアノテーションを取得
$annotation = $classAnnotations->get("Cacheable");

```

## メソッド

public **__construct** ([*array* $reflectionData])

Phalcon\Annotations\Collection constructor

public **count** ()

コレクション中のアノテーションの数を返します。

public **rewind** ()

内部のイテレータを巻き戻します。

public [Phalcon\Annotations\Annotation](Phalcon_Annotations_Annotation) **current** ()

イテレータ中の現在のアノテーションを返します。

public **key** ()

イテレータ中の現在の位置/キーを返します。

public **next** ()

内部のイテレータの位置を次の位置に移動します。

public **valid** ()

イテレータ中の現在のアノテーションが妥当かどうかチェックします。

public **getAnnotations** ()

内部のアノテーションを配列として返します。

public **get** (*string* $name)

名前にマッチした最初のアノテーションを返します。

public **getAll** (*string* $name)

名前にマッチした全てのアノテーションを返します。

public **has** (*string* $name)

コレクション中にアノテーションが存在するかをチェックします。