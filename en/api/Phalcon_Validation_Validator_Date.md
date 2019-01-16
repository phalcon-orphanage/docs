---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Validation\Validator\Date'
---
# Class **Phalcon\Validation\Validator\Date**

*extends* abstract class [Phalcon\Validation\Validator](Phalcon_Validation_Validator)

*implements* [Phalcon\Validation\ValidatorInterface](Phalcon_Validation_ValidatorInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/validation/validator/date.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Checks if a value is a valid date

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Date as DateValidator;

$validator = new Validation();

$validator->add(
    "date",
    new DateValidator(
        [
            "format"  => "d-m-Y",
            "message" => "The date is invalid",
        ]
    )
);

$validator->add(
    [
        "date",
        "anotherDate",
    ],
    new DateValidator(
        [
            "format" => [
                "date"        => "d-m-Y",
                "anotherDate" => "Y-m-d",
            ],
            "message" => [
                "date"        => "The date is invalid",
                "anotherDate" => "The another date is invalid",
            ],
        ]
    )
);

```


## Methods
public  **validate** ([Phalcon\Validation](Phalcon_Validation) $validation, *mixed* $field)

Executes the validation



private  **checkDate** (*mixed* $value, *mixed* $format)

...


public  **__construct** ([*array* $options]) inherited from [Phalcon\Validation\Validator](Phalcon_Validation_Validator)

Phalcon\Validation\Validator constructor



public  **isSetOption** (*mixed* $key) inherited from [Phalcon\Validation\Validator](Phalcon_Validation_Validator)

Checks if an option has been defined



public  **hasOption** (*mixed* $key) inherited from [Phalcon\Validation\Validator](Phalcon_Validation_Validator)

Checks if an option is defined



public  **getOption** (*mixed* $key, [*mixed* $defaultValue]) inherited from [Phalcon\Validation\Validator](Phalcon_Validation_Validator)

Returns an option in the validator's options
Returns null if the option hasn't set



public  **setOption** (*mixed* $key, *mixed* $value) inherited from [Phalcon\Validation\Validator](Phalcon_Validation_Validator)

Sets an option in the validator



protected  **prepareLabel** ([Phalcon\Validation](Phalcon_Validation) $validation, *mixed* $field) inherited from [Phalcon\Validation\Validator](Phalcon_Validation_Validator)

Prepares a label for the field.



protected  **prepareMessage** ([Phalcon\Validation](Phalcon_Validation) $validation, *mixed* $field, *mixed* $type, [*mixed* $option]) inherited from [Phalcon\Validation\Validator](Phalcon_Validation_Validator)

Prepares a validation message.



protected  **prepareCode** (*mixed* $field) inherited from [Phalcon\Validation\Validator](Phalcon_Validation_Validator)

Prepares a validation code.



