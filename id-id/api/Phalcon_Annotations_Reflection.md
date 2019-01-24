---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Annotations\Reflection'
---
# Class **Phalcon\Annotations\Reflection**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/reflection.zep)

Izinkan untuk manipulasi refleksi annotasi dengan cara OO

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

## Metode

public **__membangun**([*array*$reflectionData)

Phalcon\Annotations\Reflection constructor

public **getClassAnnotations** ()

Mengembalikan anotasi yang ditemukan di docblock kelas

public **getMethodsAnnotations** ()

Mengembalikan anotasi yang ditemukan di metode' dokblocks

public **getPropertiesAnnotations** ()

Mengembalikan anotasi yang ditemukan di properti' dokblocks

public *array* **getReflectionData** ()

Mengembalikan parsing mentah antara definisi yang digunakan untuk membangun refleksi

public static *array data* **__set_state** (*mixed* $data)

Restores the state of a Phalcon\Annotations\Reflection variable export