---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Annotations\Reflection'
---
# Class **Phalcon\Annotations\Reflection**

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/reflection.zep)

允许操作注释反射以面向对象的方式

```php
<?php

use Phalcon\Annotations\Reader;
use Phalcon\Annotations\Reflection;

// Parse the annotations in a class
$reader = new Reader();
$parsing = $reader->parse("MyComponent");

// Create the reflection
$reflection = new Reflection($parsing);

// Get the annotations in the class docblock
$classAnnotations = $reflection->getClassAnnotations();

```

## 方法

public **__construct** ([*array* $reflectionData])

Phalcon\Annotations\Reflection constructor

public **getClassAnnotations** ()

返回在类的文档块中找到的注释

public **getMethodsAnnotations** ()

返回在方法的文档块中找到的注释

public **getPropertiesAnnotations** ()

返回在属性的文档块中找到的注释

public *array* **getReflectionData** ()

Returns the raw parsing intermediate definitions used to construct the reflection

public static *array data* **__set_state** (*mixed* $data)

Restores the state of a Phalcon\Annotations\Reflection variable export