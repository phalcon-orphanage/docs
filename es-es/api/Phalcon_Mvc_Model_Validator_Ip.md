* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Mvc\Model\Validator\Ip'

* * *

# Class **Phalcon\Mvc\Model\Validator\Ip**

*extends* abstract class [Phalcon\Mvc\Model\Validator](/4.0/en/api/Phalcon_Mvc_Model_Validator)

*implements* [Phalcon\Mvc\Model\ValidatorInterface](/4.0/en/api/Phalcon_Mvc_Model_ValidatorInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/mvc/model/validator/ip.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Phalcon\Mvc\Model\Validator\IP

Validates that a value is ipv4 address in valid range

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

## Constantes

*integer* **VERSION_4**

*integer* **VERSION_6**

## Métodos

public **validate** ([Phalcon\Mvc\EntityInterface](/4.0/en/api/Phalcon_Mvc_EntityInterface) $record)

Executes the validator

public **__construct** (*array* $options) inherited from [Phalcon\Mvc\Model\Validator](/4.0/en/api/Phalcon_Mvc_Model_Validator)

Phalcon\Mvc\Model\Validator constructor

protected **appendMessage** (*string* $message, [*string* | *array* $field], [*string* $type]) inherited from [Phalcon\Mvc\Model\Validator](/4.0/en/api/Phalcon_Mvc_Model_Validator)

Añade un mensaje para el validador

public **getMessages** () inherited from [Phalcon\Mvc\Model\Validator](/4.0/en/api/Phalcon_Mvc_Model_Validator)

Devuelve mensajes generados por el validador

public *array* **getOptions** () inherited from [Phalcon\Mvc\Model\Validator](/4.0/en/api/Phalcon_Mvc_Model_Validator)

Devuelve todas las opciones dela validador

public **getOption** (*mixed* $option, [*mixed* $defaultValue]) inherited from [Phalcon\Mvc\Model\Validator](/4.0/en/api/Phalcon_Mvc_Model_Validator)

Devuelve una opción

public **isSetOption** (*mixed* $option) inherited from [Phalcon\Mvc\Model\Validator](/4.0/en/api/Phalcon_Mvc_Model_Validator)

Comprobar si una opción se ha definido en las opciones de validación