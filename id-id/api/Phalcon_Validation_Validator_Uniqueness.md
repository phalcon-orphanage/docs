---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Validation\Validator\Uniqueness'
---
# Class **Phalcon\Validation\Validator\Uniqueness**

*extends* abstract class [Phalcon\Validation\CombinedFieldsValidator](Phalcon_Validation_CombinedFieldsValidator)

*implements* [Phalcon\Validation\ValidatorInterface](Phalcon_Validation_ValidatorInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/validation/validator/uniqueness.zep)

Periksa apakah bidang itu unik di tabel terkait

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

Atribut yang berbeda dari lapangan:

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

Dalam model:

```php
<?php

$validator->add(
    "username",
    new UniquenessValidator()
);

```

Kombinasi bidang dalam model:

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

## Metode

public **validate** ([Phalcon\Validation](Phalcon_Validation) $validation, *mixed* $field)

Menjalankan validasi

protected **isUniqueness** ([Phalcon\Validation](Phalcon_Validation) $validation, *mixed* $field)

...

protected **getColumnNameReal** (*mixed* $record, *mixed* $field)

Peta kolom digunakan untuk mengumpulkan nama kolom sebenarnya

protected **isUniquenessModel** (*mixed* $record, *array* $field, *array* $values)

Keunikan metode yang digunakan untuk model

protected **isUniquenessCollection** (*mixed* $record, *array* $field, *array* $values)

Keunikan metode yang digunakan untuk koleksi

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