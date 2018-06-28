# Class **Phalcon\\Validation\\Validator\\InclusionIn**

*extends* abstract class [Phalcon\Validation\Validator](/en/3.2/api/Phalcon_Validation_Validator)

*implements* [Phalcon\Validation\ValidatorInterface](/en/3.2/api/Phalcon_Validation_ValidatorInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/validation/validator/inclusionin.zep" class="btn btn-default btn-sm">GitHub üzerindeki kaynak</a>

Değerlerin bir değer listesine eklenip eklenmediğini kontrol edin

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\InclusionIn;

$validator = new Validation();

$validator->add(
    "status",
    new InclusionIn(
        [
            "message" => "The status must be A or B",
            "domain"  => ["A", "B"],
        ]
    )
);

$validator->add(
    [
        "status",
        "type",
    ],
    new InclusionIn(
        [
            "message" => [
                "status" => "The status must be A or B",
                "type"   => "The status must be 1 or 2",
            ],
            "domain" => [
                "status" => ["A", "B"],
                "type"   => [1, 2],
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

Checks if an option has been defined

public **hasOption** (*mixed* $key) inherited from [Phalcon\Validation\Validator](/en/3.2/api/Phalcon_Validation_Validator)

Bir seçeneği tanımlanıp tanımlanmadığını kontrol eder

public **getOption** (*mixed* $key, [*mixed* $defaultValue]) inherited from [Phalcon\Validation\Validator](/en/3.2/api/Phalcon_Validation_Validator)

Doğrulayıcı seçeneklerindeki bir seçeneği döndürür. Eğer seçenek ayarlanmadıysa döndürme geçersizdir

public **setOption** (*mixed* $key, *mixed* $value) inherited from [Phalcon\Validation\Validator](/en/3.2/api/Phalcon_Validation_Validator)

Doğrulayıcıda bir seçeneği ayarlar

protected **prepareLabel** ([Phalcon\Validation](/en/3.2/api/Phalcon_Validation) $validation, *mixed* $field) inherited from [Phalcon\Validation\Validator](/en/3.2/api/Phalcon_Validation_Validator)

Bu alana yönelik bir etiket hazırlar.

protected **prepareMessage** ([Phalcon\Validation](/en/3.2/api/Phalcon_Validation) $validation, *mixed* $field, *mixed* $type, [*mixed* $option]) inherited from [Phalcon\Validation\Validator](/en/3.2/api/Phalcon_Validation_Validator)

Bir doğrulama mesajı hazırlar.

protected **prepareCode** (*mixed* $field) inherited from [Phalcon\Validation\Validator](/en/3.2/api/Phalcon_Validation_Validator)

Bir doğrulama kodu hazırlar.