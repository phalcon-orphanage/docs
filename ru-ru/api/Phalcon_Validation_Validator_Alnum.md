* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Validation\Validator\Alnum'

* * *

# Class **Phalcon\Validation\Validator\Alnum**

*extends* abstract class [Phalcon\Validation\Validator](/4.0/en/api/Phalcon_Validation_Validator)

*implements* [Phalcon\Validation\ValidatorInterface](/4.0/en/api/Phalcon_Validation_ValidatorInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/validation/validator/alnum.zep" class="btn btn-default btn-sm">Исходный код на GitHub</a>

Check for alphanumeric character(s)

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Alnum as AlnumValidator;

$validator = new Validation();

$validator->add(
    "username",
    new AlnumValidator(
        [
            "message" => ":field must contain only alphanumeric characters",
        ]
    )
);

$validator->add(
    [
        "username",
        "name",
    ],
    new AlnumValidator(
        [
            "message" => [
                "username" => "username must contain only alphanumeric characters",
                "name"     => "name must contain only alphanumeric characters",
            ],
        ]
    )
);

```

## Methods

public **validate** ([Phalcon\Validation](/4.0/en/api/Phalcon_Validation) $validation, *mixed* $field)

Executes the validation

public **__construct** ([*array* $options]) inherited from [Phalcon\Validation\Validator](/4.0/en/api/Phalcon_Validation_Validator)

Phalcon\Validation\Validator constructor

public **isSetOption** (*mixed* $key) inherited from [Phalcon\Validation\Validator](/4.0/en/api/Phalcon_Validation_Validator)

Checks if an option has been defined

public **hasOption** (*mixed* $key) inherited from [Phalcon\Validation\Validator](/4.0/en/api/Phalcon_Validation_Validator)

Checks if an option is defined

public **getOption** (*mixed* $key, [*mixed* $defaultValue]) inherited from [Phalcon\Validation\Validator](/4.0/en/api/Phalcon_Validation_Validator)

Returns an option in the validator's options Returns null if the option hasn't set

public **setOption** (*mixed* $key, *mixed* $value) inherited from [Phalcon\Validation\Validator](/4.0/en/api/Phalcon_Validation_Validator)

Sets an option in the validator

protected **prepareLabel** ([Phalcon\Validation](/4.0/en/api/Phalcon_Validation) $validation, *mixed* $field) inherited from [Phalcon\Validation\Validator](/4.0/en/api/Phalcon_Validation_Validator)

Prepares a label for the field.

protected **prepareMessage** ([Phalcon\Validation](/4.0/en/api/Phalcon_Validation) $validation, *mixed* $field, *mixed* $type, [*mixed* $option]) inherited from [Phalcon\Validation\Validator](/4.0/en/api/Phalcon_Validation_Validator)

Prepares a validation message.

protected **prepareCode** (*mixed* $field) inherited from [Phalcon\Validation\Validator](/4.0/en/api/Phalcon_Validation_Validator)

Prepares a validation code.