---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Annotations\Collection'
---
# Class **Phalcon\Annotations\Collection**

*implements* [Iterator](https://php.net/manual/en/class.iterator.php), [Traversable](https://php.net/manual/en/class.traversable.php), [Countable](https://php.net/manual/en/class.countable.php)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/collection.zep)

Represents a collection of annotations. This class allows to traverse a group of annotations easily

```php
<?php

//Traverse annotations
foreach ($classAnnotations as $annotation) {
    echo "Name=", $annotation->getName(), PHP_EOL;
}

//Check if the annotations has a specific
var_dump($classAnnotations->has("Cacheable"));

//Get an specific annotation in the collection
$annotation = $classAnnotations->get("Cacheable");

```

## 方法

public **__construct** ([*array* $reflectionData])

Phalcon\Annotations\Collection constructor

public **count** ()

返回集合中的批注

public **rewind** ()

倒带内部迭代器

public [Phalcon\Annotations\Annotation](Phalcon_Annotations_Annotation) **current** ()

在迭代器返回当前注释

public **key** ()

在迭代器中返回每个该项当前的位置

public **next** ()

将内部迭代指针移动到下一个位置

public **valid** ()

检查当前注释在迭代器是否有效

public **getAnnotations** ()

以数组形式返回内部注释

public **get** (*string* $name)

返回的名称匹配的第一个注释

public **getAll** (*string* $name)

返回的名称匹配的所有注释

public **has** (*string* $name)

检查集合中是否存在注释