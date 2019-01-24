---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\Validator\StringLength'
---
# Class **Phalcon\Mvc\Model\Validator\StringLength**

*extends* abstract class [Phalcon\Mvc\Model\Validator](Phalcon_Mvc_Model_Validator)

*implements* [Phalcon\Mvc\Model\ValidatorInterface](Phalcon_Mvc_Model_ValidatorInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/validator/stringlength.zep)

Cukup sederhana dengan membatasi panjang batasan String yang ditentukan

This validator is only for use with Phalcon\Mvc\Collection. If you are using Phalcon\Mvc\Model, please use the validators provided by Phalcon\Validation.

```php
<?php

menggunakan Phalcon\Mvc\Model\Validator\panjangstring seperti panjangstring validator;

Memperluas kelas langganan \Phalcon\Mvc\Koleksi
{
publik fungsi validasi()
{
$this->validasi(
baru panjangstringvalidator(
[
"field" =>"name_last",
"max" =>50,
"min" =>2,
"Maksimumpesan" =>"kami tidak menyukai nama yang terlalu panjang",
"Minimunpesan" =>"kami mengiginkan lebih dari inisial mereka",
]
)
);
if($this->validasitelahgagal()=== benar){
kembali salah;
}
}
}

```

## Metode

public **validate** ([Phalcon\Mvc\EntityInterface](Phalcon_Mvc_EntityInterface) $record)

Menjalankan validator

public **__construct** (*array* $options) inherited from [Phalcon\Mvc\Model\Validator](Phalcon_Mvc_Model_Validator)

Phalcon\Mvc\Model\Validator constructor

protected **appendMessage** (*string* $message, [*string* | *array* $field], [*string* $type]) inherited from [Phalcon\Mvc\Model\Validator](Phalcon_Mvc_Model_Validator)

Menambahkan pesan ke validator

public **getMessages** () inherited from [Phalcon\Mvc\Model\Validator](Phalcon_Mvc_Model_Validator)

Mengembalikan pesan yang dihasilkan oleh validator

public *array* **getOptions** () inherited from [Phalcon\Mvc\Model\Validator](Phalcon_Mvc_Model_Validator)

Mengembalikan semua pilihan dari validator

public **getOption** (*mixed* $option, [*mixed* $defaultValue]) inherited from [Phalcon\Mvc\Model\Validator](Phalcon_Mvc_Model_Validator)

Mengembalikan sebuah pilihan

public **isSetOption** (*mixed* $option) inherited from [Phalcon\Mvc\Model\Validator](Phalcon_Mvc_Model_Validator)

Periksa apakah opsi telah didefinisikan dalam opsi validator