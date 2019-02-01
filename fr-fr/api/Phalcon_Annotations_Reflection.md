---
layout: article
language: 'fr-fr'
version: '4.0'
title: 'Phalcon\Annotations\Reflection'
---
# Class **Phalcon\Annotations\Reflection**

[Source sur GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/reflection.zep)

Permet de manipuler les annotations réflexion dans une manière OO

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

## Méthodes

public **__construct** ([*array* $reflectionData])

Phalcon\Annotations\Reflection constructor

public **getClassAnnotations** ()

Retourne les annotations dans la classe docblock

public **getMethodsAnnotations** ()

Retourne les annotations trouvées dans les méthodes " docblocks

public **getPropertiesAnnotations** ()

Returns the annotations found in the properties' docblocks

public *array* **getReflectionData** ()

Retourne le raw de l'analyse intermédiaire des définitions utilisées pour construire la réflexion

public static *array data* **__set_state** (*mixed* $data)

Restores the state of a Phalcon\Annotations\Reflection variable export