* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Validation\Validator\Uniqueness'

* * *

# Class **Phalcon\Validation\Validator\Uniqueness**

*extends* abstract class [Phalcon\Validation\CombinedFieldsValidator](/4.0/en/api/Phalcon_Validation_CombinedFieldsValidator)

*implements* [Phalcon\Validation\ValidatorInterface](/4.0/en/api/Phalcon_Validation_ValidatorInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/validation/validator/uniqueness.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Check that a field is unique in the related table

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;

$validator = new Validation();

$validator->add(
    "username",
    new UniquenessValidator(
        [
            "model"   => new Users(),
            "message" => ":field must be unique",
        ]
    )
);

```

Different attribute from the field:

```php
<?php

$validator->add(
    "username",
    new UniquenessValidator(
        [
            "model"     => new Users(),
            "attribute" => "nick",
        ]
    )
);

```

In model:

```php
<?php

$validator->add(
    "username",
    new UniquenessValidator()
);

```

Combination of fields in model:

```php
<?php

$validator->add(
    [
        "firstName",
        "lastName",
    ],
    new UniquenessValidator()
);

```

It is possible to convert values before validation. This is useful in situations where values need to be converted to do the database lookup:

```php
<?php

$validator->add(
    "username",
    new UniquenessValidator(
        [
            "convert" => function (array $values) {
                $values["username"] = strtolower($values["username"]);

                return $values;
            }
        ]
    )
);

```

## Methods

public **validate** ([Phalcon\Validation](/4.0/en/api/Phalcon_Validation) $validation, *mixed* $field)

Executes the validation

protected **isUniqueness** ([Phalcon\Validation](/4.0/en/api/Phalcon_Validation) $validation, *mixed* $field)

...

protected **getColumnNameReal** (*mixed* $record, *mixed* $field)

The column map is used in the case to get real column name

protected **isUniquenessModel** (*mixed* $record, *array* $field, *array* $values)

Uniqueness method used for model

protected **isUniquenessCollection** (*mixed* $record, *array* $field, *array* $values)

Uniqueness method used for collection

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