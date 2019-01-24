---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\Validator'
---
# Abstract class **Phalcon\Mvc\Model\Validator**

*implements* [Phalcon\Mvc\Model\ValidatorInterface](Phalcon_Mvc_Model_ValidatorInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/validator.zep)

This is a base class for Phalcon\Mvc\Model validators

This class is only for backward compatibility reasons to use with Phalcon\Mvc\Collection. Otherwise please use the validators provided by Phalcon\Validation.

## Metode

public **__construct** (*array* $options)

Phalcon\Mvc\Model\Validator constructor

protected **appendMessage** (*string* $message, [*string* | *array* $field], [*string* $type])

Menambahkan pesan ke validator

public **getMessages** ()

Mengembalikan pesan yang dihasilkan oleh validator

public *array* **getOptions** ()

Mengembalikan semua pilihan dari validator

public **getOption** (*mixed* $option, [*mixed* $defaultValue])

Mengembalikan sebuah pilihan

public **isSetOption** (*mixed* $option)

Periksa apakah opsi telah didefinisikan dalam opsi validator

abstract public **validate** ([Phalcon\Mvc\EntityInterface](Phalcon_Mvc_EntityInterface) $record) inherited from [Phalcon\Mvc\Model\ValidatorInterface](Phalcon_Mvc_Model_ValidatorInterface)

...