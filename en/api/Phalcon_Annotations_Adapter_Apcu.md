---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Annotations\Adapter\Apcu'
---
# Class **Phalcon\Annotations\Adapter\Apcu**

*extends* abstract class [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

*implements* [Phalcon\Annotations\AdapterInterface](Phalcon_Annotations_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/annotations/adapter/apcu.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Stores the parsed annotations in APCu. This adapter is suitable for production

```php
<?php

use Phalcon\Annotations\Adapter\Apcu;

$annotations = new Apcu();

```


## Methods
public  **__construct** ([*array* $options])

Phalcon\Annotations\Adapter\Apcu constructor



public  **read** (*mixed* $key)

Reads parsed annotations from APCu



public  **write** (*mixed* $key, [Phalcon\Annotations\Reflection](Phalcon_Annotations_Reflection) $data)

Writes parsed annotations to APCu



public  **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Sets the annotations parser



public  **getReader** () inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Returns the annotation reader



public  **get** (*string* | *object* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Parses or retrieves all the annotations found in a class



public  **getMethods** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Returns the annotations found in all the class' methods



public  **getMethod** (*mixed* $className, *mixed* $methodName) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Returns the annotations found in a specific method



public  **getProperties** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Returns the annotations found in all the class' methods



public  **getProperty** (*mixed* $className, *mixed* $propertyName) inherited from [Phalcon\Annotations\Adapter](Phalcon_Annotations_Adapter)

Returns the annotations found in a specific property



