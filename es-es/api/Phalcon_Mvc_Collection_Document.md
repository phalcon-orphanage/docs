---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Mvc\Collection\Document'
---
# Class **Phalcon\Mvc\Collection\Document**

*implements* [Phalcon\Mvc\EntityInterface](Phalcon_Mvc_EntityInterface), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/collection/document.zep)

This component allows Phalcon\Mvc\Collection to return rows without an associated entity. This objects implements the ArrayAccess interface to allow access the object as object->x or array[x].

## Métodos

public *boolean* **offsetExists** (*int* $index)

Comprueba si un offset existe en el documento

public **offsetGet** (*mixed* $index)

Devuelve el valor de un campo utilizando la interfaz ArrayAccess

public **offsetSet** (*mixed* $index, *mixed* $value)

Cambia un valor utilizando la interfaz ArrayAccess

public **offsetUnset** (*string* $offset)

Rows cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface

public *mixed* **readAttribute** (*string* $attribute)

Lee un valor de atributo por su nombre

```php
<?php

 echo $robot->readAttribute("name");

```

public **writeAttribute** (*string* $attribute, *mixed* $value)

Escribe un valor atributo por su nombre

```php
<?php

 $robot->writeAttribute("name", "Rosey");

```

public *array* **toArray** ()

Devuelve la instancia como una representación de arreglo