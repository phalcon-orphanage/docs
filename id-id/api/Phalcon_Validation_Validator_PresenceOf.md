---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Validation\Validator\PresenceOf'
---
# Class **Phalcon\Validation\Validator\PresenceOf**

*extends* abstract class [Phalcon\Validation\Validator](Phalcon_Validation_Validator)

*implements* [Phalcon\Validation\ValidatorInterface](Phalcon_Validation_ValidatorInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/validation/validator/presenceof.zep)

Pengesahaan bahwa nilai tidak batal atau string kosong

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;

$validator = new Validation();

$validator->add(
    "name",
    new PresenceOf(
        [
            "message" => "The name is required",
        ]
    )
);

$validator->add(
    [
        "name",
        "email",
    ],
    new PresenceOf(
        [
            "message" => [
                "name"  => "The name is required",
                "email" => "The email is required",
            ],
        ]
    )
);

```

## Metode

public **validate** ([Phalcon\Validation](Phalcon_Validation) $validation, *mixed* $field)

Menjalankan validasi

public **__construct** ([*array* $options]) inherited from [Phalcon\Validation\Validator](Phalcon_Validation_Validator)

Phalcon\Validation\Validator constructor

public **isSetOption** (*mixed* $key) inherited from [Phalcon\Validation\Validator](Phalcon_Validation_Validator)

Memeriksa jika pilihan telah ditetapkan

public **hasOption** (*mixed* $key) inherited from [Phalcon\Validation\Validator](Phalcon_Validation_Validator)

Memeriksa jika pilihan didefinisikan

public **getOption** (*mixed* $key, [*mixed* $defaultValue]) inherited from [Phalcon\Validation\Validator](Phalcon_Validation_Validator)

Kembali pilihan dalam pilihan validator mengembalikan null jika opsi belum menetapkan

public **setOption** (*mixed* $key, *mixed* $value) inherited from [Phalcon\Validation\Validator](Phalcon_Validation_Validator)

Menetapkan pilihan di validator

protected **prepareLabel** ([Phalcon\Validation](Phalcon_Validation) $validation, *mixed* $field) inherited from [Phalcon\Validation\Validator](Phalcon_Validation_Validator)

Mempersiapkan label untuk bidang.

protected **prepareMessage** ([Phalcon\Validation](Phalcon_Validation) $validation, *mixed* $field, *mixed* $type, [*mixed* $option]) inherited from [Phalcon\Validation\Validator](Phalcon_Validation_Validator)

Menyiapkan pesan validasi.

protected **prepareCode** (*mixed* $field) inherited from [Phalcon\Validation\Validator](Phalcon_Validation_Validator)

Menyiapkan kode validasi.