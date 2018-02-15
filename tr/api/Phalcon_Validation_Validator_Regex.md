# Class **Phalcon\\Validation\\Validator\\Regex**

*extends* abstract class [Phalcon\Validation\Validator](/en/3.2/api/Phalcon_Validation_Validator)

*implements* [Phalcon\Validation\ValidatorInterface](/en/3.2/api/Phalcon_Validation_ValidatorInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/validator/regex.zep" class="btn btn-default btn-sm">GitHub üzerindeki kaynak</a>

Allows validate if the value of a field matches a regular expression

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Regex as RegexValidator;

$validator = new Validation();

$validator->add(
    "created_at",
    new RegexValidator(
        [
            "pattern" => "/^[0-9]{4}[-\/](0[1-9]|1[12])[-\/](0[1-9]|[12][0-9]|3[01])$/",
            "message" => "The creation date is invalid",
        ]
    )
);

$validator->add(
    [
        "created_at",
        "name",
    ],
    new RegexValidator(
        [
            "pattern" => [
                "created_at" => "/^[0-9]{4}[-\/](0[1-9]|1[12])[-\/](0[1-9]|[12][0-9]|3[01])$/",
                "name"       => "/^[a-z]$/",
            ],
            "message" => [
                "created_at" => "The creation date is invalid",
                "name"       => "The name is invalid",
            ]
        ]
    )
);

```

## Yöntemler

public **validate** ([Phalcon\Validation](/en/3.2/api/Phalcon_Validation) $validation, *mixed* $field)

Doğrulayıcıyı uygular

public **__construct** ([*array* $options]) inherited from [Phalcon\Validation\Validator](/en/3.2/api/Phalcon_Validation_Validator)

Phalcon\\Validation\\Validator constructor

public **isSetOption** (*mixed* $key) inherited from [Phalcon\Validation\Validator](/en/3.2/api/Phalcon_Validation_Validator)

Bir seçeneğin tanımlanmış olup olmadığını kontrol eder

public **hasOption** (*mixed* $key) inherited from [Phalcon\Validation\Validator](/en/3.2/api/Phalcon_Validation_Validator)

Bir seçeneğin tanımlı olup olmadığını kontrol eder

public **getOption** (*mixed* $key, [*mixed* $defaultValue]) inherited from [Phalcon\Validation\Validator](/en/3.2/api/Phalcon_Validation_Validator)

Doğrulayıcı seçeneklerindeki bir seçeneği döndürür. Eğer seçenek ayarlanmadıysa döndürme geçersizdir

public **setOption** (*mixed* $key, *mixed* $value) inherited from [Phalcon\Validation\Validator](/en/3.2/api/Phalcon_Validation_Validator)

Doğrulayıcıda bir seçeneği ayarlar

protected **prepareLabel** ([Phalcon\Validation](/en/3.2/api/Phalcon_Validation) $validation, *mixed* $field) inherited from [Phalcon\Validation\Validator](/en/3.2/api/Phalcon_Validation_Validator)

Bu alana yönelik bir etiket hazırlar.

protected **prepareMessage** ([Phalcon\Validation](/en/3.2/api/Phalcon_Validation) $validation, *mixed* $field, *mixed* $type, [*mixed* $option]) inherited from [Phalcon\Validation\Validator](/en/3.2/api/Phalcon_Validation_Validator)

Bir doğrulama mesajı hazırlar.

protected **prepareCode** (*mixed* $field) inherited from [Phalcon\Validation\Validator](/en/3.2/api/Phalcon_Validation_Validator)

Prepares a validation code.