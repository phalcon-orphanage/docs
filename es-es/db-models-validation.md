---
layout: default
language: 'es-es'
version: '4.0'
title: 'Validación del Modelo'
keywords: 'modelos, validación, unicidad, inclusión'
---

# Validación del Modelo

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

[Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) proporciona varios eventos para validar datos e implementar reglas de negocio.

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;

class Customers extends Model
{
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'cst_email',
            new Uniqueness(
                [
                    'message' => 'The customer email must be unique',
                ]
            )
        );

        return $this->validate($validator);
    }
}
```

## Integridad de Datos

La integridad de datos es esencial en cada aplicación. Puede implementar validadores en sus modelos para introducir otra capa de validación, de modo que se pueda asegurar que los datos que se almacenan en su base de datos cumplen sus reglas de negocio.

El eventos especial `validation` nos permite llamar validadores integrados sobre el registro. Phalcon expone validadores integrados adicionales que se pueden usar en esta fase de validación. Todos los validadores disponibles están bajo el espacio de nombres [Phalcon\Validation](validation).

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Validation\Validator\InclusionIn;

class Invoices extends Model
{
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'inv_status_flag',
            new InclusionIn(
                [
                    'domain'  => [
                        'Paid',
                        'Unpaid',
                    ],
                    'message' => 'The invoice must be ' .
                                 'either paid or unpaid',
                ]
            )
        );

        $validator->add(
            'inv_number',
            new Uniqueness(
                [
                    'message' => 'The invoice number must be unique',
                ]
            )
        );

        return $this->validate($validator);
    }
}
```

El ejemplo anterior realiza una validación usando el validador integrado [Phalcon\Validation\Validator\InclusionIn](api/phalcon_validation#validation-validator-inclusionin). Comprueba el valor del campo `inv_status_flag` en una lista de dominios. Si el valor no está incluido en el método entonces el validador fallará y devolverá `false`.

> **NOTA**: Para más información sobre validadores, ver la [documentación de Validación](validation)
{: .alert .alert-warning }

## Mensajes

[Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) usa la colección [Phalcon\Messages\Messages](api/phalcon_messages#messages-messages) para almacenar cualquier mensaje de validación que se haya generado durante el proceso de validación.

Cada mensaje es una instancia de [Phalcon\Messages\Message](api/phalcon_messages#messages-message) y el conjunto de mensajes generado se puede recuperar con el método `getMessages()`. Cada mensaje proporciona información adicional como el nombre del campo que ha generado el mensaje o el tipo de mensaje:

```php
<?php

if (false === $invoice->save()) {
    $messages = $invoice->getMessages();

    foreach ($messages as $message) {
        echo 'Message: ', $message->getMessage();
        echo 'Field: ', $message->getField();
        echo 'Type: ', $message->getType();
    }
}
```

[Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) puede generar los siguientes tipos de mensajes de validación:

| Tipo                   | Generado cuando                                                                                                                  |
| ---------------------- | -------------------------------------------------------------------------------------------------------------------------------- |
| `ConstraintViolation`  | Un campo, parte de una clave ajena virtual, está intentando insertar/actualizar un valor que no existe en el modelo referenciado |
| `InvalidCreateAttempt` | Se Intenta crear un registro que ya existe                                                                                       |
| `InvalidUpdateAttempt` | Se intenta actualizar un registro que no existe                                                                                  |
| `InvalidValue`         | Un validador falla a causa de un valor inválido                                                                                  |
| `PresenceOf`           | Un campo con un atributo no `nulo` en la base de datos está intentando insertar/actualizar un valor `nulo`                       |

El método `getMessages()` se puede anular en un modelo para reemplazar/traducir los mensajes por defecto generados automáticamente por el ORM:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function getMessages()
    {
        $messages = [];

        foreach (parent::getMessages() as $message) {
            switch ($message->getType()) {
                case 'InvalidCreateAttempt':
                    $messages[] = 'The record cannot be created '
                                . 'because it already exists';
                    break;

                case 'InvalidUpdateAttempt':
                    $messages[] = "The record cannot be updated '
                                . 'because it doesn't exist";
                    break;

                case 'PresenceOf':
                    $messages[] = 'The field ' 
                                . $message->getField() 
                                . ' is mandatory';
                    break;
            }
        }

        return $messages;
    }
}
```

## Eventos Fallidos

Hay disponibles eventos adicionales cuando el proceso de validación de datos encuentra cualquier inconsistencia:

| Operación                     | Nombre              | Explicación                                                                  |
| ----------------------------- | ------------------- | ---------------------------------------------------------------------------- |
| Insertar o actualizar         | `notSaved`          | Se dispara cuando la operación de `INSERT` o `UPDATE` falla por alguna razón |
| Insertar, borrar o actualizar | `onValidationFails` | Se dispara cuando cualquier operación de manipulación de datos falla         |

## Personalizado

El documento de [validación](validation) explica en detalle cómo puede crear sus propios validadores. Puede usar dichos validadores y reutilizarlos entre varios modelos. Un validador también puede ser tan simple como:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;

class Invoices extends Model
{
    public function validation()
    {
        if ('Unpaid' === $this->inv_type_flag) {
            $message = new Message(
                'Unpaid invoices are not allowed',
                'inv_type_flag',
                'UnpaidInvoiceType'
            );

            $this->appendMessage($message);

            return false;
        }

        return true;
    }
}
```
