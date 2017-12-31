# Class **Phalcon\\Validation\\Validator\\Alpha**

*extends* abstract class [Phalcon\Validation\Validator](/en/3.1.2/api/Phalcon_Validation_Validator)

*implements* [Phalcon\Validation\ValidatorInterface](/en/3.1.2/api/Phalcon_Validation_ValidatorInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/validator/alpha.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Check for alphabetic character(s)

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Alpha as AlphaValidator;

$validator = new Validation();

$validator->add(
    "username",
    new AlphaValidator(
        [
            "message" => ":field must contain only letters",
        ]
    )
);

$validator->add(
    [
        "username",
        "name",
    ],
    new AlphaValidator(
        [
            "message" => [
                "username" => "username must contain only letters",
                "name"     => "name must contain only letters",
            ],
        ]
    )
);

```

## Methods
public  **validate** ([Phalcon\Validation](/en/3.1.2/api/Phalcon_Validation) $validation, *mixed* $field)

Executes the validation

public  **__construct** ([*array* $options]) inherited from [Phalcon\Validation\Validator](/en/3.1.2/api/Phalcon_Validation_Validator)

Phalcon\\Validation\\Validator constructor

public  **isSetOption** (*mixed* $key) inherited from [Phalcon\Validation\Validator](/en/3.1.2/api/Phalcon_Validation_Validator)

Checks if an option has been defined

public  **hasOption** (*mixed* $key) inherited from [Phalcon\Validation\Validator](/en/3.1.2/api/Phalcon_Validation_Validator)

Checks if an option is defined

public  **getOption** (*mixed* $key, [*mixed* $defaultValue]) inherited from [Phalcon\Validation\Validator](/en/3.1.2/api/Phalcon_Validation_Validator)

Returns an option in the validator's options
Returns null if the option hasn't set

public  **setOption** (*mixed* $key, *mixed* $value) inherited from [Phalcon\Validation\Validator](/en/3.1.2/api/Phalcon_Validation_Validator)

Sets an option in the validator

