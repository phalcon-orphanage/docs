---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Validation\CombinedFieldsValidator'
---
# Abstract class **Phalcon\Validation\CombinedFieldsValidator**

*extends* abstract class [Phalcon\Validation\Validator](Phalcon_Validation_Validator)

*implements* [Phalcon\Validation\ValidatorInterface](Phalcon_Validation_ValidatorInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/validation/combinedfieldsvalidator.zep)

## Metode

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

abstract public **validate** ([Phalcon\Validation](Phalcon_Validation) $validation, *mixed* $attribute) inherited from [Phalcon\Validation\Validator](Phalcon_Validation_Validator)

Menjalankan validasi

protected **prepareLabel** ([Phalcon\Validation](Phalcon_Validation) $validation, *mixed* $field) inherited from [Phalcon\Validation\Validator](Phalcon_Validation_Validator)

Mempersiapkan label untuk bidang.

protected **prepareMessage** ([Phalcon\Validation](Phalcon_Validation) $validation, *mixed* $field, *mixed* $type, [*mixed* $option]) inherited from [Phalcon\Validation\Validator](Phalcon_Validation_Validator)

Menyiapkan pesan validasi.

protected **prepareCode** (*mixed* $field) inherited from [Phalcon\Validation\Validator](Phalcon_Validation_Validator)

Menyiapkan kode validasi.