---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Mvc\Model\Validator\StringLength'
---
# Class **Phalcon\Mvc\Model\Validator\StringLength**

*extends* abstract class [Phalcon\Mvc\Model\Validator](Phalcon_Mvc_Model_Validator)

*implements* [Phalcon\Mvc\Model\ValidatorInterface](Phalcon_Mvc_Model_ValidatorInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/validator/stringlength.zep)

Simply validates specified string length constraints

This validator is only for use with Phalcon\Mvc\Collection. If you are using Phalcon\Mvc\Model, please use the validators provided by Phalcon\Validation.

```php
<?php

use Phalcon\Mvc\Model\Validator\StringLength as StringLengthValidator;

class Subscriptors extends \Phalcon\Mvc\Collection
{
    public function validation()
    {
        $this->validate(
            new StringLengthValidator(
                [
                    "field"          => "name_last",
                    "max"            => 50,
                    "min"            => 2,
                    "messageMaximum" => "We don't like really long names",
                    "messageMinimum" => "We want more than just their initials",
                ]
            )
        );

        if ($this->validationHasFailed() === true) {
            return false;
        }
    }
}

```

## Métodos

public **validate** ([Phalcon\Mvc\EntityInterface](Phalcon_Mvc_EntityInterface) $record)

Executes the validator

public **__construct** (*array* $options) inherited from [Phalcon\Mvc\Model\Validator](Phalcon_Mvc_Model_Validator)

Phalcon\Mvc\Model\Validator constructor

protected **appendMessage** (*string* $message, [*string* | *array* $field], [*string* $type]) inherited from [Phalcon\Mvc\Model\Validator](Phalcon_Mvc_Model_Validator)

Añade un mensaje para el validador

public **getMessages** () inherited from [Phalcon\Mvc\Model\Validator](Phalcon_Mvc_Model_Validator)

Devuelve mensajes generados por el validador

public *array* **getOptions** () inherited from [Phalcon\Mvc\Model\Validator](Phalcon_Mvc_Model_Validator)

Devuelve todas las opciones dela validador

public **getOption** (*mixed* $option, [*mixed* $defaultValue]) inherited from [Phalcon\Mvc\Model\Validator](Phalcon_Mvc_Model_Validator)

Devuelve una opción

public **isSetOption** (*mixed* $option) inherited from [Phalcon\Mvc\Model\Validator](Phalcon_Mvc_Model_Validator)

Comprobar si una opción se ha definido en las opciones de validación