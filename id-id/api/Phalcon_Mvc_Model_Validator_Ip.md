---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\Validator\Ip'
---
# Class **Phalcon\Mvc\Model\Validator\Ip**

*extends* abstract class [Phalcon\Mvc\Model\Validator](Phalcon_Mvc_Model_Validator)

*implements* [Phalcon\Mvc\Model\ValidatorInterface](Phalcon_Mvc_Model_ValidatorInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/validator/ip.zep)

Phalcon\Mvc\Model\Validator\IP

Validasi bahwa nilainya itu alamat ipv4 dalam rentang yang valid

This validator is only for use with Phalcon\Mvc\Collection. If you are using Phalcon\Mvc\Model, please use the validators provided by Phalcon\Validation.

```php
<?php

use Phalcon\Mvc\Model\Validator\Ip;

class Data extends \Phalcon\Mvc\Collection
{
    public function validation()
    {
        // Any pubic IP
        $this->validate(
            new IP(
                [
                    "field"         => "server_ip",
                    "version"       => IP::VERSION_4 | IP::VERSION_6, // v6 and v4. The same if not specified
                    "allowReserved" => false,   // False if not specified. Ignored for v6
                    "allowPrivate"  => false,   // False if not specified
                    "message"       => "IP address has to be correct",
                ]
            )
        );

        // Any public v4 address
        $this->validate(
            new IP(
                [
                    "field"   => "ip_4",
                    "version" => IP::VERSION_4,
                    "message" => "IP address has to be correct",
                ]
            )
        );

        // Any v6 address
        $this->validate(
            new IP(
                [
                    "field"        => "ip6",
                    "version"      => IP::VERSION_6,
                    "allowPrivate" => true,
                    "message"      => "IP address has to be correct",
                ]
            )
        );

        if ($this->validationHasFailed() === true) {
            return false;
        }
    }
}

```

## Constants

*integer* **VERSION_4**

*integer* **VERSION_6**

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