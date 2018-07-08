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

La idea de crear validadores es hacerlos reutilizables entre muchos modelos. Un validador puede ser tan simple como:

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

Cada mensaje es una instancia de `Phalcon\Mvc\Model\Message` y el conjunto de mensajes generados puede ser obtenido con el método `getMessages()`. Cada mensaje proporciona información ampliada como el nombre del campo que genera el mensaje o el tipo de mensaje:

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

`Phalcon\Mvc\Model` puede generar los siguientes tipos de mensajes de validación:

| Tipo                   | Descripción                                                                                                                                 |
| ---------------------- | ------------------------------------------------------------------------------------------------------------------------------------------- |
| `PresenceOf`           | Generado cuando se trata de un campo que no admite el valor null en la base de datos y se intenta insertar o actualizar a un valor nulo     |
| `ConstraintViolation`  | Generado cuando una parte del campo de clave externa virtual intenta insertar o actualizar un valor que no existe en el modelo referenciado |
| `InvalidValue`         | Generado cuando un validador falló debido a un valor no válido                                                                              |
| `InvalidCreateAttempt` | Se produce cuando un registro que intenta crearse ya existe                                                                                 |
| `InvalidUpdateAttempt` | Se produce cuando un registro que se intenta actualizar no existe                                                                           |

El método `getMessages()` puede ser reemplazado en un modelo para reemplazar/traducir los mensajes generados automáticamente por el ORM:

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

Otro tipo de eventos están disponibles cuando el proceso de validación de datos encuentra cualquier inconsistencia:

| Operación                     | Nombre              | Explicación                                                                  |
| ----------------------------- | ------------------- | ---------------------------------------------------------------------------- |
| Insertar o actualizar         | `notSaved`          | Se dispara cuando la operación de `INSERT` o `UPDATE` falla por alguna razón |
| Insertar, borrar o actualizar | `onValidationFails` | Se dispara cuando cualquier operación de manipulación de datos falla         |