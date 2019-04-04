---
layout: default
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Collection\Document'
---
# Class **Phalcon\Mvc\Collection\Document**

*implements* [Phalcon\Mvc\EntityInterface](Phalcon_Mvc_EntityInterface), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/collection/document.zep)

This component allows Phalcon\Mvc\Collection to return rows without an associated entity. This objects implements the ArrayAccess interface to allow access the object as object->x or array[x].

## Methods

public *boolean* **offsetExists** (*int* $index)

Checks whether an offset exists in the document

public **offsetGet** (*mixed* $index)

Returns the value of a field using the ArrayAccess interfase

public **offsetSet** (*mixed* $index, *mixed* $value)

Change a value using the ArrayAccess interface

public **offsetUnset** (*string* $offset)

Rows cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface

public *mixed* **readAttribute** (*string* $attribute)

Reads an attribute value by its name

```php
<?php

 echo $robot->readAttribute("name");

```

public **writeAttribute** (*string* $attribute, *mixed* $value)

Writes an attribute value by its name

```php
<?php

 $robot->writeAttribute("name", "Rosey");

```

public *array* **toArray** ()

Returns the instance as an array representation