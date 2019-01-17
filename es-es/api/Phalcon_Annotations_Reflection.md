---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Annotations\Reflection'
---
# Class **Phalcon\Annotations\Reflection**

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/reflection.zep)

Permite manipular la reflexión de las anotaciones en una forma Orientada a Objectos

```php
<?php

use Phalcon\Annotations\Reader;
use Phalcon\Annotations\Reflection;

// Analizar las anotaciones en una clase
$reader = new Reader();
$parsing = $reader->parse("MyComponent");

// Crear la Reflexión 
$reflection = new Reflection($parsing);

// Obtener las anotaciones en la clase docblock
$classAnnotations = $reflection->getClassAnnotations();

```

## Métodos

public **__construct** ([*array* $reflectionData])

Phalcon\Annotations\Reflection constructor

public **getClassAnnotations** ()

Devuelve las anotaciones encontradas en la clase docblock

public **getMethodsAnnotations** ()

Devuelve las anotaciones encontradas en los métodos de docblocks

public **getPropertiesAnnotations** ()

Devuelve las anotaciones encontradas en las propiedades de docblocks

public *array* **getReflectionData** ()

Devuelve las definiciones intermedias usadas en el análisis para construir la reflexión

public static *array data* **__set_state** (*mixed* $data)

Restores the state of a Phalcon\Annotations\Reflection variable export