---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Validation\Validator'
---
# Abstract class **Phalcon\Validation\Validator**

*implements* [Phalcon\Validation\ValidatorInterface](Phalcon_Validation_ValidatorInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/validation/validator.zep)

Ini adalah kelas dasar untuk validator

## Metode

umum **__membangun** ([*array* $options])

Phalcon\Validation\Validator constructor

umum **pilihanYangDiterapkan** (*campuran* $key)

Memeriksa jika pilihan telah ditetapkan

public **hasOption** (*mixed* $key)

Memeriksa jika pilihan didefinisikan

public **getOption** (*mixed* $key, [*mixed* $defaultValue])

Kembali pilihan dalam pilihan validator mengembalikan null jika opsi belum menetapkan

public **setOption** (*mixed* $key, *mixed* $value)

Menetapkan pilihan di validator

abstract public **validate** ([Phalcon\Validation](Phalcon_Validation) $validation, *mixed* $attribute)

Menjalankan validasi

protected **prepareLabel** ([Phalcon\Validation](Phalcon_Validation) $validation, *mixed* $field)

Mempersiapkan label untuk bidang.

protected **prepareMessage** ([Phalcon\Validation](Phalcon_Validation) $validation, *mixed* $field, *mixed* $type, [*mixed* $option])

Menyiapkan pesan validasi.

dilindungi **siapkan kpde** (*campur*$field)

Menyiapkan kode validasi.