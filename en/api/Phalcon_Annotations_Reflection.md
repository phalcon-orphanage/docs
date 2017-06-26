# Class **Phalcon\\Annotations\\Reflection**

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/annotations/reflection.zep" class="btn btn-default btn-sm">Source on GitHub</a>

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


## Methods
public  **__construct** ([*array* $reflectionData])

Phalcon\\Annotations\\Reflection constructor



public  **getClassAnnotations** ()

Returns the annotations found in the class docblock



public  **getMethodsAnnotations** ()

Returns the annotations found in the methods' docblocks



public  **getPropertiesAnnotations** ()

Returns the annotations found in the properties' docblocks



public *array* **getReflectionData** ()

Returns the raw parsing intermediate definitions used to construct the reflection



public static *array data* **__set_state** (*mixed* $data)

Restores the state of a Phalcon\\Annotations\\Reflection variable export



