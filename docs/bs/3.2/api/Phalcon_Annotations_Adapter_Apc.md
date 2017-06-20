# Class **Phalcon\\Annotations\\Adapter\\Apc**

*extends* abstract class [Phalcon\Annotations\Adapter](/en/3.1.2/api/Phalcon_Annotations_Adapter)

*implements* [Phalcon\Annotations\AdapterInterface](/en/3.1.2/api/Phalcon_Annotations_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/annotations/adapter/apc.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Stores the parsed annotations in APC. This adapter is suitable for production

```php
<?php

use Phalcon\Annotations\Adapter\Apc;

$annotations = new Apc();

```

## Methods

public **__construct** ([*array* $options])

Phalcon\\Annotations\\Adapter\\Apc constructor

public **read** (*mixed* $key)

Reads parsed annotations from APC

public **write** (*mixed* $key, [Phalcon\Annotations\Reflection](/en/3.1.2/api/Phalcon_Annotations_Reflection) $data)

Writes parsed annotations to APC

public **setReader** ([Phalcon\Annotations\ReaderInterface](/en/3.1.2/api/Phalcon_Annotations_ReaderInterface) $reader) inherited from [Phalcon\Annotations\Adapter](/en/3.1.2/api/Phalcon_Annotations_Adapter)

Sets the annotations parser

public **getReader** () inherited from [Phalcon\Annotations\Adapter](/en/3.1.2/api/Phalcon_Annotations_Adapter)

Returns the annotation reader

public **get** (*string* | *object* $className) inherited from [Phalcon\Annotations\Adapter](/en/3.1.2/api/Phalcon_Annotations_Adapter)

Parses or retrieves all the annotations found in a class

public **getMethods** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](/en/3.1.2/api/Phalcon_Annotations_Adapter)

Returns the annotations found in all the class' methods

public **getMethod** (*mixed* $className, *mixed* $methodName) inherited from [Phalcon\Annotations\Adapter](/en/3.1.2/api/Phalcon_Annotations_Adapter)

Returns the annotations found in a specific method

public **getProperties** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](/en/3.1.2/api/Phalcon_Annotations_Adapter)

Returns the annotations found in all the class' methods

public **getProperty** (*mixed* $className, *mixed* $propertyName) inherited from [Phalcon\Annotations\Adapter](/en/3.1.2/api/Phalcon_Annotations_Adapter)

Returns the annotations found in a specific property