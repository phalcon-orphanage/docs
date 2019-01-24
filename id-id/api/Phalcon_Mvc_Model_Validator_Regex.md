---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\Validator\Regex'
---
# Class **Phalcon\Mvc\Model\Validator\Regex**

*extends* abstract class [Phalcon\Mvc\Model\Validator](Phalcon_Mvc_Model_Validator)

*implements* [Phalcon\Mvc\Model\ValidatorInterface](Phalcon_Mvc_Model_ValidatorInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/validator/regex.zep)

Memvalidasi apakah nilai bidang sesuai dengan ekspresi regular

This validator is only for use with Phalcon\Mvc\Collection. If you are using Phalcon\Mvc\Model, please use the validators provided by Phalcon\Validation.

```php
<?php

use Phalcon\Mvc\Model\Validator\Regex as RegexValidator;

class Subscriptors extends \Phalcon\Mvc\Collection
{
    public function validation()
    {
        $this->validate(
            new RegexValidator(
                [
                    "field"   => "created_at",
                    "pattern" => "/^[0-9]{4}[-\/](0[1-9]|1[12])[-\/](0[1-9]|[12][0-9]|3[01])/",
                ]
            )
        );

        if ($this->validationHasFailed() == true) {
            return false;
        }
    }
}
 
Text
Xpath: /pre/code

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