---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Mvc\Model\Validator\Numericality'
---
# Class **Phalcon\Mvc\Model\Validator\Numericality**

*extends* abstract class [Phalcon\Mvc\Model\Validator](Phalcon_Mvc_Model_Validator)

*implements* [Phalcon\Mvc\Model\ValidatorInterface](Phalcon_Mvc_Model_ValidatorInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/validator/numericality.zep)

Allows to validate if a field has a valid numeric format

This validator is only for use with Phalcon\Mvc\Collection. If you are using Phalcon\Mvc\Model, please use the validators provided by Phalcon\Validation.

```php
<?php

use Phalcon\Mvc\Model\Validator\Numericality as NumericalityValidator;

class Products extends \Phalcon\Mvc\Collection
{
    public function validation()
    {
        $this->validate(
            new NumericalityValidator(
                [
                    "field" => "price",
                ]
            )
        );

        if ($this->validationHasFailed() === true) {
            return false;
        }
    }
}

```

## Methoden

public **validate** ([Phalcon\Mvc\EntityInterface](Phalcon_Mvc_EntityInterface) $record)

Executes the validator

public **__construct** (*array* $options) inherited from [Phalcon\Mvc\Model\Validator](Phalcon_Mvc_Model_Validator)

Phalcon\Mvc\Model\Validator constructor

protected **appendMessage** (*string* $message, [*string* | *array* $field], [*string* $type]) inherited from [Phalcon\Mvc\Model\Validator](Phalcon_Mvc_Model_Validator)

Fügt eine Nachricht an den validator

public **getMessages** () inherited from [Phalcon\Mvc\Model\Validator](Phalcon_Mvc_Model_Validator)

Gibt vom Validator generierte Meldungen zurück

public *array* **getOptions** () inherited from [Phalcon\Mvc\Model\Validator](Phalcon_Mvc_Model_Validator)

Gibt alle Optionen aus dem Validator zurück

public **getOption** (*mixed* $option, [*mixed* $defaultValue]) inherited from [Phalcon\Mvc\Model\Validator](Phalcon_Mvc_Model_Validator)

Gibt eine option zurück

public **isSetOption** (*mixed* $option) inherited from [Phalcon\Mvc\Model\Validator](Phalcon_Mvc_Model_Validator)

Prüft, ob eine Option in den Validator-Optionen definiert wurde