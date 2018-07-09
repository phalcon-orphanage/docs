# Clase **Phalcon\\Validation\\Validator\\StringLength**

*extends* abstract class [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

*implements* [Phalcon\Validation\ValidatorInterface](/[[language]]/[[version]]/api/Phalcon_Validation_ValidatorInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/validator/stringlength.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Valida que una cadena de texto tenga las limitaciones mínimas y máximas especificadas. Si pasa la prueba para la longitud de la cadena L, min <= L <= max, es decir, la longitud L tiene que ser mayor al valor min y menor al valor max.

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\StringLength as StringLength;

$validator = new Validation();

$validation->add(
    "name_last",
    new StringLength(
        [
            "max"            => 50,
            "min"            => 2,
            "messageMaximum" => "No nos gustan los nombres realmente largos",
            "messageMinimum" => "Queremos algo más que tus iniciales",
        ]
    )
);

$validation->add(
    [
        "name_last",
        "name_first",
    ],
    new StringLength(
        [
            "max" => [
                "name_last"  => 50,
                "name_first" => 40,
            ],
            "min" => [
                "name_last"  => 2,
                "name_first" => 4,
            ],
            "messageMaximum" => [
                "name_last"  => "No nos gustan los apellidos largos",
                "name_first" => "No nos gustan los nombres largos",
            ],
            "messageMinimum" => [
                "name_last"  => "No nos gustan los apellidos demasiado cortos",
                "name_first" => "No nos gustan los nombres demasiado cortos",
            ]
        ]
    )
);

```

## Métodos

public **validate** ([Phalcon\Validation](/[[language]]/[[version]]/api/Phalcon_Validation) $validation, *mixed* $field)

Executes the validation

public **__construct** ([*array* $options]) inherited from [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

Phalcon\\Validation\\Validator constructor

public **isSetOption** (*mixed* $key) inherited from [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

Checks if an option has been defined

public **hasOption** (*mixed* $key) inherited from [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

Checks if an option is defined

public **getOption** (*mixed* $key, [*mixed* $defaultValue]) inherited from [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

Returns an option in the validator's options Returns null if the option hasn't set

public **setOption** (*mixed* $key, *mixed* $value) inherited from [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

Sets an option in the validator

protected **prepareLabel** ([Phalcon\Validation](/[[language]]/[[version]]/api/Phalcon_Validation) $validation, *mixed* $field) inherited from [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

Prepares a label for the field.

protected **prepareMessage** ([Phalcon\Validation](/[[language]]/[[version]]/api/Phalcon_Validation) $validation, *mixed* $field, *mixed* $type, [*mixed* $option]) inherited from [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

Prepares a validation message.

protected **prepareCode** (*mixed* $field) inherited from [Phalcon\Validation\Validator](/[[language]]/[[version]]/api/Phalcon_Validation_Validator)

Prepares a validation code.