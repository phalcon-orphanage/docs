---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Collection\Document'
---
# Class **Phalcon\Mvc\Collection\Document**

*implements* [Phalcon\Mvc\EntityInterface](Phalcon_Mvc_EntityInterface), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/collection/document.zep)

This component allows Phalcon\Mvc\Collection to return rows without an associated entity. This objects implements the ArrayAccess interface to allow access the object as object->x or array[x].

## Metode

public *boolean* **offsetExists** (*int* $index)

Memeriksa apakah ada offset dalam dokumen

public **offsetGet** (*mixed* $index)

Mengembalikan nilai field menggunakan ArrayAccess interfase

public **offsetSet** (*mixed* $index, *mixed* $value)

Ubah nilai menggunakan antarmuka ArrayAccess

public **offsetUnset** (*string* $offset)

Rows cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface

public *mixed* **readAttribute** (*string* $attribute)

Membaca nilai atribut dengan nama

```php
<?php

 echo $robot->readAttribute("name");

```

public **writeAttribute** (*string* $attribute, *mixed* $value)

Menulis nilai atribut dengan nama

```php
<?php

 $robot->writeAttribute("name", "Rosey");

```

public *array* **toArray** ()

Mengembalikan instance sebagai representasi array