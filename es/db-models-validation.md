<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Validación de modelos</a> 
      <ul>
        <li>
          <a href="#data-integrity">Validar la integridad de los datos</a>
        </li>
        <li>
          <a href="#messages">Mensajes de validación</a>
        </li>
        <li>
          <a href="#failed-events">Eventos de validación fallidos</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Validación de modelos

<a name='data-integrity'></a>

## Validar la integridad de los datos

`Phalcon\Mvc\Model` ofrece varios eventos para validar los datos e implementar reglas de negocio. El evento especial `validation` nos permite llamar a validadores incorporados en el registro. Phalcon expone algunos validadores incorporados que pueden utilizarse en esta etapa de validación.

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

En el ejemplo anterior se realiza una validación utilizando el validador integrado 'InclusionIn'. Comprueba el valor del campo `type` en una lista de dominios. Si el valor no está incluido en el método entonces el validador fallará y devolverá false.

<div class='alert alert-warning'>
    <p>
        Para más información sobre validadores, consulte la [documentación de validación](/[[language]]/[[version]]/validation)
    </p>
</div>

La idea de crear validadores es hacerlos reutilizables entre varios modelos. Un validador puede también ser tan simple como:

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

`Phalcon\Mvc\Model` cuenta con un subsistema de mensajería que proporciona una forma flexible de salida o almacenamiento de mensajes de validación generados durante los procesos de insertar/actualizar.

Cada mensaje es una instancia de `Phalcon\Mvc\Model\Message` y el conjunto de mensajes generados puede ser obtenido con el método `getMessages()`. Each message provides extended information like the field name that generated the message or the message type:

```php
<?php

if ($robot->save() === false) {
    $messages = $robot->getMessages();

    foreach ($messages as $message) {
        echo 'Message: ', $message->getMessage();
        echo 'Field: ', $message->getField();
        echo 'Type: ', $message->getType();
    }
}
```

`Phalcon\Mvc\Model` can generate the following types of validation messages:

| Type                   | Description                                                                                                                        |
| ---------------------- | ---------------------------------------------------------------------------------------------------------------------------------- |
| `PresenceOf`           | Generated when a field with a non-null attribute on the database is trying to insert/update a null value                           |
| `ConstraintViolation`  | Generated when a field part of a virtual foreign key is trying to insert/update a value that doesn't exist in the referenced model |
| `InvalidValue`         | Generated when a validator failed because of an invalid value                                                                      |
| `InvalidCreateAttempt` | Produced when a record is attempted to be created but it already exists                                                            |
| `InvalidUpdateAttempt` | Produced when a record is attempted to be updated but it doesn't exist                                                             |

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
                    $messages[] = 'The record cannot be created because it already exists';
                    break;

                case 'InvalidUpdateAttempt':
                    $messages[] = "The record cannot be updated because it doesn't exist";
                    break;

                case 'PresenceOf':
                    $messages[] = 'The field ' . $message->getField() . ' is mandatory';
                    break;
            }
        }

        return $messages;
    }
}
```

<a name='failed-events'></a>

## Validation Failed Events

Another type of events are available when the data validation process finds any inconsistency:

| Operation                | Name                | Explanation                                                            |
| ------------------------ | ------------------- | ---------------------------------------------------------------------- |
| Insert or Update         | `notSaved`          | Triggered when the `INSERT` or `UPDATE` operation fails for any reason |
| Insert, Delete or Update | `onValidationFails` | Triggered when any data manipulation operation fails                   |