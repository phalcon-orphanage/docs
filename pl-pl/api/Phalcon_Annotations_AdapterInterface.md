---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Annotations\AdapterInterface'
---
# Interface **Phalcon\Annotations\AdapterInterface**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/annotations/adapterinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This interface must be implemented by adapters in Phalcon\Annotations

## Metody

abstract public **setReader** ([Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface) $reader)

Sets the annotations parser

abstract public **getReader** ()

Returns the annotation reader

abstract public **get** (*string|object* $className)

Parses or retrieves all the annotations found in a class

abstract public **getMethods** (*string* $className)

Returns the annotations found in all the class methods

abstract public **getMethod** (*string* $className, *string* $methodName)

Returns the annotations found in a specific method

abstract public **getProperties** (*string* $className)

Returns the annotations found in all the class methods

abstract public **getProperty** (*string* $className, *string* $propertyName)

Returns the annotations found in a specific property