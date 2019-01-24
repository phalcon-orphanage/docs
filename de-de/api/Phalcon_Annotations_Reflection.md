---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Annotations\Reflection'
---
# Class **Phalcon\Annotations\Reflection**

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/reflection.zep)

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

## Methoden

public **__construct** ([*array* $reflectionData])

Phalcon\Annotations\Reflection constructor

public **getClassAnnotations** ()

Gibt die Anmerkungen, welche im docblock der Klassen gefunden wurden, zurück

public **getMethodsAnnotations** ()

Gibt die Anmerkungen, welche im docblock der Methode gefunden wurden, zurück

public **getPropertiesAnnotations** ()

Gibt die Anmerkungen, welche im docblock der Eigenschaften gefunden wurden, zurück

public *array* **getReflectionData** ()

Returns the raw parsing intermediate definitions used to construct the reflection

public static *array data* **__set_state** (*mixed* $data)

Restores the state of a Phalcon\Annotations\Reflection variable export