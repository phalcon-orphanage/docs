* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# Validación

[Phalcon\Validation](api/Phalcon_Validation) is an independent validation component that validates an arbitrary set of data. This component can be used to implement validation rules on data objects that do not belong to a model or collection.

En el ejemplo siguiente se muestra su uso básico:

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;

$validation = new Validation();

$validation->add(
    'name',
    new PresenceOf(
        [
            'message' => 'El nombre es requerido',
        ]
    )
);

$validation->add(
    'email',
    new PresenceOf(
        [
            'message' => 'El e-mail es requerido',
        ]
    )
);

$validation->add(
    'email',
    new Email(
        [
            'message' => 'El e-mail no es válido',
        ]
    )
);

$messages = $validation->validate($_POST);

if (count($messages)) {
    foreach ($messages as $message) {
        echo $message, '<br>';
    }
}
```

The loosely-coupled design of this component allows you to create your own validators along with the ones provided by the framework.

<a name='initializing'></a>

## Iniciando la Validación

Validation chains can be initialized in a direct manner by just adding validators to the [Phalcon\Validation](api/Phalcon_Validation) object. You can put your validations in a separate file for better re-use code and organization:

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;

class MyValidation extends Validation
{
    public function initialize()
    {
        $this->add(
            'name',
            new PresenceOf(
                [
                    'message' => 'El nombre es requerido',
                ]
            )
        );

        $this->add(
            'email',
            new PresenceOf(
                [
                    'message' => 'El e-mail es requerido',
                ]
            )
        );

        $this->add(
            'email',
            new Email(
                [
                    'message' => 'El e-mail no es válido',
                ]
            )
        );
    }
}
```

Then initialize and use your own validator:

```php
<?php

$validation = new MyValidation();

$messages = $validation->validate($_POST);

if (count($messages)) {
    foreach ($messages as $message) {
        echo $message, '<br>';
    }
}
```

<a name='validators'></a>

## Validadores

Phalcon exposes a set of built-in validators for this component:

| Clase                                                                                         | Explicación                                                            |
| --------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------- |
| [Phalcon\Validation\Validator\Alnum](api/Phalcon_Validation_Validator_Alnum)               | Valida que el valor de un campo tenga solo caracteres alfanuméricos.   |
| [Phalcon\Validation\Validator\Alpha](api/Phalcon_Validation_Validator_Alpha)               | Valida que el valor de un campo tenga solo caracteres alfabéticos.     |
| [Phalcon\Validation\Validator\Date](api/Phalcon_Validation_Validator_Date)                 | Valida que el valor de un campo sea una fecha válida.                  |
| [Phalcon\Validation\Validator\Digit](api/Phalcon_Validation_Validator_Digit)               | Valida que el valor de un campo tenga solo caracteres numéricos.       |
| [Phalcon\Validation\Validator\File](api/Phalcon_Validation_Validator_File)                 | Valida que el valor de un campo sea un archivo correcto.               |
| [Phalcon\Validation\Validator\Uniqueness](api/Phalcon_Validation_Validator_Uniqueness)     | Valida que el valor de un campo sea único en el modelo relacionado.    |
| [Phalcon\Validation\Validator\Numericality](api/Phalcon_Validation_Validator_Numericality) | Valida que el valor de un campo sea un valor numérico.                 |
| [Phalcon\Validation\Validator\PresenceOf](api/Phalcon_Validation_Validator_PresenceOf)     | Valida que el valor de un campo no sea nulo o una cadena vacía.        |
| [Phalcon\Validation\Validator\Identical](api/Phalcon_Validation_Validator_Identical)       | Valida que el valor de un campo sea el mismo que el valor especificado |
| [Phalcon\Validation\Validator\Email](api/Phalcon_Validation_Validator_Email)               | Valida que un campo contenga un email con formato válido               |
| [Phalcon\Validation\Validator\ExclusionIn](api/Phalcon_Validation_Validator_ExclusionIn)   | Valida que un valor no este incluido en una lista de posibles valores  |
| [Phalcon\Validation\Validator\InclusionIn](api/Phalcon_Validation_Validator_InclusionIn)   | Valida que un valor este incluido en una lista de posibles valores     |
| [Phalcon\Validation\Validator\Regex](api/Phalcon_Validation_Validator_Regex)               | Valida que el valor del campo coincida con una expresión regular       |
| [Phalcon\Validation\Validator\StringLength](api/Phalcon_Validation_Validator_StringLength) | Valida el largo de una cadena                                          |
| [Phalcon\Validation\Validator\Between](api/Phalcon_Validation_Validator_Between)           | Valida que un valor este entre dos valores                             |
| [Phalcon\Validation\Validator\Confirmation](api/Phalcon_Validation_Validator_Confirmation) | Valida que un valor sea igual a otro presente en los datos             |
| [Phalcon\Validation\Validator\Url](api/Phalcon_Validation_Validator_Url)                   | Valida que el campo contenga una URL válida                            |
| [Phalcon\Validation\Validator\CreditCard](api/Phalcon_Validation_Validator_CreditCard)     | Valida un número de tarjeta de crédito                                 |
| [Phalcon\Validation\Validator\Callback](api/Phalcon_Validation_Validator_Callback)         | Valida utilizando una función de retorno de llamada                    |

The following example explains how to create additional validators for this component:

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Message;
use Phalcon\Validation\Validator;

class IpValidator extends Validator
{
    /**
     * Ejecutar la validación
     *
     * @param Validation $validator
     * @param string     $attribute
     * @return boolean
     */
    public function validate(Validation $validator, $attribute)
    {
        $value = $validator->getValue($attribute);

        if (!filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6)) {
            $message = $this->getOption('message');

            if (!$message) {
                $message = 'El IP no es válido';
            }

            $validator->appendMessage(
                new Message($message, $attribute, 'Ip')
            );

            return false;
        }

        return true;
    }
}
```

It is important that validators return a valid boolean value indicating if the validation was successful or not.

<a name='callback'></a>

## Validador de Devolución de Llamada

By using [Phalcon\Validation\Validator\Callback](api/Phalcon_Validation_Validator_Callback) you can execute custom function which must return boolean or new validator class which will be used to validate the same field. By returning `true` validation will be successful, returning `false` will mean validation failed. When executing this validator Phalcon will pass data depending what it is - if it's an entity (i.e. a model, a `stdClass` etc.) then entity will be passed, otherwise data (i.e an array like `$_POST`). There is example:

```php
<?php

use \Phalcon\Validation;
use \Phalcon\Validation\Validator\Callback;
use \Phalcon\Validation\Validator\PresenceOf;

$validation = new Validation();
$validation->add(
    'amount',
    new Callback(
        [
            'callback' => function($data) {
                return $data['amount'] % 2 == 0;
            },
            'message'  => 'Solo números pares de productos son aceptados'
        ]
    )
);
$validation->add(
    'amount',
    new Callback(
        [
            'callback' => function($data) {
                if($data['amount'] % 2 == 0) {
                    return $data['amount'] != 2;
                }

                return true;
            },
            'message' => "No puedes comprar 2 productos"
        ]
    )
);
$validation->add(
    'description',
    new Callback(
        [
            'callback' => function($data) {
                if($data['amount'] >= 10) {
                    return new PresenceOf(
                        [
                            'message' => 'Debe escribir por que necesitas tanta cantidad.'
                        ]
                    );
                }

                return true;
            }
        ]
    )
);

$messages = $validation->validate(['amount' => 1]);  // retornará el mensaje del primer validador
$messages = $validation->validate(['amount' => 2]);  // retornará el mensaje del segundo validador
$messages = $validation->validate(['amount' => 10]); // retornará el mensaje del tercer validador
```

<a name='messages'></a>

## Mensajes de validación

[Phalcon\Validation](api/Phalcon_Validation) has a messaging subsystem that provides a flexible way to output or store the validation messages generated during the validation processes.

Each message consists of an instance of the class [Phalcon\Validation\Message](api/Phalcon_Validation_Message). The set of messages generated can be retrieved with the `getMessages()` method. Each message provides extended information like the attribute that generated the message or the message type:

```php
<?php

$messages = $validation->validate();

if (count($messages)) {
    foreach ($messages as $message) {
        echo 'Mensaje: ', $message->getMessage(), "\n";
        echo 'Campo: ', $message->getField(), "\n";
        echo 'Tipo: ', $message->getType(), "\n";
    }
}
```

You can pass a `message` parameter to change/translate the default message in each validator, even it's possible to use the wildcard `:field` in the message to be replaced by the label of the field:

```php
<?php

use Phalcon\Validation\Validator\Email;

$validation->add(
    'email',
    new Email(
        [
            'message' => 'El email no es válido',
        ]
    )
);
```

By default, the `getMessages()` method returns all the messages generated during validation. You can filter messages for a specific field using the `filter()` method:

```php
<?php

$messages = $validation->validate();

if (count($messages)) {
    // Filtrar solo los mensajes generados para el campo 'name'
    $filteredMessages = $messages->filter('name');

    foreach ($filteredMessages as $message) {
        echo $message;
    }
}
```

<a name='filtering'></a>

## Filtrando de Datos

Data can be filtered prior to the validation ensuring that malicious or incorrect data is not validated.

```php
<?php

use Phalcon\Validation;

$validation = new Validation();

$validation->add(
    'name',
    new PresenceOf(
        [
            'message' => 'El nombre es requerido',
        ]
    )
);

$validation->add(
    'email',
    new PresenceOf(
        [
            'message' => 'El email es requerido',
        ]
    )
);

// Filtrar cualquier espacio extra
$validation->setFilters('name', 'trim');
$validation->setFilters('email', 'trim');
```

Filtering and sanitizing is performed using the [filter](/4.0/en/filter) component. You can add more filters to this component or use the built-in ones.

<a name='events'></a>

## Eventos de Validación

When validations are organized in classes, you can implement the `beforeValidation()` and `afterValidation()` methods to perform additional checks, filters, clean-up, etc. If the `beforeValidation()` method returns false the validation is automatically cancelled:

```php
<?php

use Phalcon\Validation;

class LoginValidation extends Validation
{
    public function initialize()
    {
        // ...
    }

    /**
     * Ejecutado antes de la validación
     *
     * @param array $data
     * @param object $entity
     * @param Phalcon\Validation\Message\Group $messages
     * @return bool
     */
    public function beforeValidation($data, $entity, $messages)
    {
        if ($this->request->getHttpHost() !== 'admin.mydomain.com') {
            $messages->appendMessage(
                new Message('Solo los usuarios pueden ingresar a la administración del dominio')
            );

            return false;
        }

        return true;
    }

    /**
     * Ejecutado después de la validación
     *
     * @param array $data
     * @param object $entity
     * @param Phalcon\Validation\Message\Group $messages
     */
    public function afterValidation($data, $entity, $messages)
    {
        // ... Agregar mensajes de validación o realizar más validaciones
    }
}
```

<a name='cancelling'></a>

## Cancelando Validaciones

By default all validators assigned to a field are tested regardless if one of them have failed or not. You can change this behavior by telling the validation component which validator may stop the validation:

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\PresenceOf;

$validation = new Validation();

$validation->add(
    'telephone',
    new PresenceOf(
        [
            'message'      => 'El teléfono es requerido',
            'cancelOnFail' => true,
        ]
    )
);

$validation->add(
    'telephone',
    new Regex(
        [
            'message' => 'El teléfono es requerido',
            'pattern' => '/\+44 [0-9]+/',
        ]
    )
);

$validation->add(
    'telephone',
    new StringLength(
        [
            'messageMinimum' => 'El teléfono es demasiado corto',
            'min'            => 2,
        ]
    )
);
```

The first validator has the option `cancelOnFail` with a value of `true`, therefore if that validator fails the remaining validators in the chain are not executed.

If you are creating custom validators you can dynamically stop the validation chain by setting the `cancelOnFail` option:

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Message;
use Phalcon\Validation\Validator;

class MyValidator extends Validator
{
    /**
     * Ejecuta la validación
     *
     * @param Phalcon\Validation $validator
     * @param string $attribute
     * @return boolean
     */
    public function validate(Validation $validator, $attribute)
    {
        // Si el nombre del atributo es 'name' debemos detener la cadena
        if ($attribute === 'name') {
            $validator->setOption('cancelOnFail', true);
        }

        // ...
    }
}
```

<a name='empty-values'></a>

## Evitar Validar Valores Vacíos

You can pass the option `allowEmpty` to all the built-in validators to avoid the validation to be performed if an empty value is passed:

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Regex;

$validation = new Validation();

$validation->add(
    'telephone',
    new Regex(
        [
            'message'    => 'El teléfono es requerido',
            'pattern'    => '/\+44 [0-9]+/',
            'allowEmpty' => true,
        ]
    )
);
```

<a name='recursive'></a>

## Validación Recursiva

You can also run Validation instances within another via the `afterValidation()` method. In this example, validating the `CompanyValidation` instance will also check the `PhoneValidation` instance:

```php
<?php

use Phalcon\Validation;

class CompanyValidation extends Validation
{
    /**
     * @var PhoneValidation
     */
    protected $phoneValidation;

    public function initialize()
    {
        $this->phoneValidation = new PhoneValidation();
    }

    public function afterValidation($data, $entity, $messages)
    {
        $phoneValidationMessages = $this->phoneValidation->validate(
            $data['phone']
        );

        $messages->appendMessages(
            $phoneValidationMessages
        );
    }
}
```