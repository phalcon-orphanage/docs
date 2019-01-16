* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# Validación de modelos

<a name='data-integrity'></a>

## Validar la integridad de los datos

[Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) provides several events to validate data and implement business rules. El evento especial `validation` nos permite llamar a validadores incorporados en el registro. Phalcon expone algunos validadores incorporados que pueden utilizarse en esta etapa de validación.

En el ejemplo siguiente se muestra cómo se utiliza:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Validation\Validator\InclusionIn;

class Robots extends Model
{
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'type',
            new InclusionIn(
                [
                    'domain' => [
                        'Mechanical',
                        'Virtual',
                    ]
                ]
            )
        );

        $validator->add(
            'name',
            new Uniqueness(
                [
                    'message' => 'El nombre del robot debe ser único',
                ]
            )
        );

        return $this->validate($validator);
    }
}
```

The above example performs a validation using the built-in validator 'InclusionIn'. It checks the value of the field `type` in a domain list. If the value is not included in the method then the validator will fail and return false.

<h5 class='alert alert-warning'>For more information on validators, see the <a href="/4.0/en/validation">Validation documentation</a></h5>

The idea of creating validators is make them reusable between several models. A validator can also be as simple as:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;

class Robots extends Model
{
    public function validation()
    {
        if ($this->type === 'Old') {
            $message = new Message(
                'Perdón, los robots viejos ya no son permitidos',
                'type',
                'MyType'
            );

            $this->appendMessage($message);

            return false;
        }

        return true;
    }
}
```

<a name='messages'></a>

## Mensajes de validación

[Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) has a messaging subsystem that provides a flexible way to output or store the validation messages generated during the insert/update processes.

Each message is an instance of [Phalcon\Mvc\Model\Message](api/Phalcon_Mvc_Model_Message) and the set of messages generated can be retrieved with the `getMessages()` method. Cada mensaje proporciona información ampliada como el nombre del campo que genera el mensaje o el tipo de mensaje:

```php
<?php

if ($robot->save() === false) {
    $messages = $robot->getMessages();

    foreach ($messages as $message) {
        echo 'Mensaje: ', $message->getMessage();
        echo 'Campo: ', $message->getField();
        echo 'Tipo: ', $message->getType();
    }
}
```

[Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) can generate the following types of validation messages:

| Tipo                   | Descripción                                                                                                                                 |
| ---------------------- | ------------------------------------------------------------------------------------------------------------------------------------------- |
| `PresenceOf`           | Generado cuando se trata de un campo que no admite el valor null en la base de datos y se intenta insertar o actualizar a un valor nulo     |
| `ConstraintViolation`  | Generado cuando una parte del campo de clave externa virtual intenta insertar o actualizar un valor que no existe en el modelo referenciado |
| `InvalidValue`         | Generado cuando un validador falló debido a un valor no válido                                                                              |
| `InvalidCreateAttempt` | Se produce cuando un registro que intenta crearse ya existe                                                                                 |
| `InvalidUpdateAttempt` | Se produce cuando un registro que se intenta actualizar no existe                                                                           |

The `getMessages()` method can be overridden in a model to replace/translate the default messages generated automatically by the ORM:

```php
<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;

class Robots extends Model
{
    public function getMessages()
    {
        $messages = [];

        foreach (parent::getMessages() as $message) {
            switch ($message->getType()) {
                case 'InvalidCreateAttempt':
                    $messages[] = 'El registro no puede ser creado porque ya existe';
                    break;

                case 'InvalidUpdateAttempt':
                    $messages[] = "El registro no puede ser actualizado porque no existe";
                    break;

                case 'PresenceOf':
                    $messages[] = 'El campo ' . $message->getField() . ' es obligatorio';
                    break;
            }
        }

        return $messages;
    }
}
```

<a name='failed-events'></a>

## Eventos de validación fallidos

Another type of events are available when the data validation process finds any inconsistency:

| Operación                     | Nombre              | Explicación                                                                  |
| ----------------------------- | ------------------- | ---------------------------------------------------------------------------- |
| Insertar o actualizar         | `notSaved`          | Se dispara cuando la operación de `INSERT` o `UPDATE` falla por alguna razón |
| Insertar, borrar o actualizar | `onValidationFails` | Se dispara cuando cualquier operación de manipulación de datos falla         |