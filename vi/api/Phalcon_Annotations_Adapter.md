# Abstract class **Phalcon\\Annotations\\Adapter**

*implements* [Phalcon\Annotations\AdapterInterface](/en/3.1.2/api/Phalcon_Annotations_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/annotations/adapter.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This is the base class for Phalcon\\Annotations adapters

## Methods

public **setReader** ([Phalcon\Annotations\ReaderInterface](/en/3.1.2/api/Phalcon_Annotations_ReaderInterface) $reader)

Sets the annotations parser

public **getReader** ()

Returns the annotation reader

public **get** (*string* | *object* $className)

Parses or retrieves all the annotations found in a class

public **getMethods** (*mixed* $className)

Returns the annotations found in all the class' methods

public **getMethod** (*mixed* $className, *mixed* $methodName)

Returns the annotations found in a specific method

public **getProperties** (*mixed* $className)

Returns the annotations found in all the class' methods

public **getProperty** (*mixed* $className, *mixed* $propertyName)

Returns the annotations found in a specific property