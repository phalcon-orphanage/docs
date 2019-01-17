---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Annotations\Reflection'
---
# Class **Phalcon\Annotations\Reflection**

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/reflection.zep)

Allows to manipulate the annotations reflection in an OO manner

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

Returns the annotations found in the class docblock

public **getMethodsAnnotations** ()

Returns the annotations found in the methods' docblocks

public **getPropertiesAnnotations** ()

Returns the annotations found in the properties' docblocks

public *array* **getReflectionData** ()

Returns the raw parsing intermediate definitions used to construct the reflection

public static *array data* **__set_state** (*mixed* $data)

Restores the state of a Phalcon\Annotations\Reflection variable export