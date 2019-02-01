---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Mvc\Model\Validator'
---
# Abstract class **Phalcon\Mvc\Model\Validator**

*implements* [Phalcon\Mvc\Model\ValidatorInterface](Phalcon_Mvc_Model_ValidatorInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/validator.zep)

This is a base class for Phalcon\Mvc\Model validators

This class is only for backward compatibility reasons to use with Phalcon\Mvc\Collection. Otherwise please use the validators provided by Phalcon\Validation.

## Methoden

public **__construct** (*array* $options)

Phalcon\Mvc\Model\Validator constructor

protected **appendMessage** (*string* $message, [*string* | *array* $field], [*string* $type])

Fügt eine Nachricht an den validator

public **getMessages** ()

Gibt vom Validator generierte Meldungen zurück

public *array* **getOptions** ()

Gibt alle Optionen aus dem Validator zurück

public **getOption** (*mixed* $option, [*mixed* $defaultValue])

Gibt eine option zurück

public **isSetOption** (*mixed* $option)

Prüft, ob eine Option in den Validator-Optionen definiert wurde

abstract public **validate** ([Phalcon\Mvc\EntityInterface](Phalcon_Mvc_EntityInterface) $record) inherited from [Phalcon\Mvc\Model\ValidatorInterface](Phalcon_Mvc_Model_ValidatorInterface)

...