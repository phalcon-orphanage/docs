# Class **Phalcon\\Validation\\Validator\\Numericality**

*extends* abstract class [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

*implements* [Phalcon\Validation\ValidatorInterface](/[[language]]/[[version]]/api/Phalcon_Validation_ValidatorInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/validator/numericality.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Check for a valid numeric value

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Numericality;

$validator = new Validation();

$validator->add(
    "price",
    new Numericality(
        [
            "message" => ":field is not numeric",
        ]
    )
);

$validator->add(
    [
        "price",
        "amount",
    ],
    new Numericality(
        [
            "message" => [
                "price"  => "price is not numeric",
                "amount" => "amount is not numeric",
            ]
        ]
    )
);

```


## Methods
public  **validate** ([Phalcon\Validation](/[[language]]/[[version]]/api/Phalcon_Validation) $validation, *mixed* $field)

Executes the validation



public  **__construct** ([*array* $options]) inherited from [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

Phalcon\\Validation\\Validator constructor



public  **isSetOption** (*mixed* $key) inherited from [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

Checks if an option has been defined



public  **hasOption** (*mixed* $key) inherited from [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

Checks if an option is defined



public  **getOption** (*mixed* $key, [*mixed* $defaultValue]) inherited from [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

Returns an option in the validator's options
Returns null if the option hasn't set



public  **setOption** (*mixed* $key, *mixed* $value) inherited from [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

Sets an option in the validator



protected  **prepareLabel** ([Phalcon\Validation](/[[language]]/[[version]]/api/Phalcon_Validation) $validation, *mixed* $field) inherited from [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

Prepares a label for the field.



protected  **prepareMessage** ([Phalcon\Validation](/[[language]]/[[version]]/api/Phalcon_Validation) $validation, *mixed* $field, *mixed* $type, [*mixed* $option]) inherited from [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

Prepares a validation message.



protected  **prepareCode** (*mixed* $field) inherited from [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

Prepares a validation code.



