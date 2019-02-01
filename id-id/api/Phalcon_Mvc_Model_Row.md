---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\Row'
---
# Class **Phalcon\Mvc\Model\Row**

*implements* [Phalcon\Mvc\EntityInterface](Phalcon_Mvc_EntityInterface), [Phalcon\Mvc\Model\ResultInterface](Phalcon_Mvc_Model_ResultInterface), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php), [JsonSerializable](https://php.net/manual/en/class.jsonserializable.php)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/row.zep)

This component allows Phalcon\Mvc\Model to return rows without an associated entity. This objects implements the ArrayAccess interface to allow access the object as object->x or array[x].

## Metode

public **setDirtyState** (*mixed* $dirtyState)

Tetapkan keadaan objek saat ini

public *boolean* **offsetExists** (*string* | *int* $index)

Memeriksa apakah ada offset pada baris

public *string* | [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) **offsetGet** (*string* | *int* $index)

Mendapat catatan di posisi baris tertentu

public **offsetSet** (*string* | *int* $index, [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $value)

Rows cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface

public **offsetUnset** (*string* | *int* $offset)

Rows cannot be changed. It has only been implemented to meet the definition of the ArrayAccess interface

public *mixed* **readAttribute** (*string* $attribute)

Membaca nilai atribut dengan nama

```php
<? php echo $robot -> readAttribute("name");

```

public **writeAttribute** (*string* $attribute, *mixed* $value)

Menulis nilai atribut dengan nama

```php
<? php $robot -> writeAttribute ("nama", "Rosey");

```

public *array* **toArray** ()

Mengembalikan instance sebagai representasi array

public *array* **jsonSerialize** ()

Serializes the object for json_encode