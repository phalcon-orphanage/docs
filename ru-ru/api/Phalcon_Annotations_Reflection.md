---
layout: article
language: 'ru-ru'
version: '4.0'
title: 'Phalcon\Annotations\Reflection'
---
# Class **Phalcon\Annotations\Reflection**

[Исходный код на GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/reflection.zep)

Позволяет манипулировать отражения аннотации в ОО порядке

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

## Методы

public **__construct** ([*array* $reflectionData])

Phalcon\Annotations\Reflection constructor

общественная **getClassAnnotations** ()

Возвращает аннотации в классе doc-блок

public **getMethodsAnnotations** ()

Returns the annotations found in the methods' docblocks

общественная **getPropertiesAnnotations** ()

Возвращает аннотаций, найденных в установки свойств

public *array* **getReflectionData** ()

Возвращает промежуточные определения необработанного разбора, используемые для построения отражения

public static *array data* **__set_state** (*mixed* $data)

Restores the state of a Phalcon\Annotations\Reflection variable export