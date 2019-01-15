* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Validación

[Phalcon\Validation](api/Phalcon_Validation) is an independent validation component that validates an arbitrary set of data. Este componente puede utilizarse para implementar reglas de validación a objetos de datos que no pertenecen a una colección o un modelo.

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

El diseño flexible de este componente te permite crear tus propios validadores junto con los proporcionados por el framework.

<a name='initializing'></a>

## Iniciando la Validación

Validation chains can be initialized in a direct manner by just adding validators to the [Phalcon\Validation](api/Phalcon_Validation) object. Puedes poner tus validaciones en un archivo independiente para mejorar la organización y la re-utilización del código:

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

Luego inicializar y utilizar su propio validador:

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

Phalcon cuenta con un conjunto de validadores incorporados para este componente:

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

El siguiente ejemplo explica como crear validadores adicionales para este componente:

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

Es importante que los validadores retornen un valor booleano indicando si la validación fue exitosa o no.

<a name='callback'></a>

## Validador de Devolución de Llamada

By using [Phalcon\Validation\Validator\Callback](api/Phalcon_Validation_Validator_Callback) you can execute custom function which must return boolean or new validator class which will be used to validate the same field. Al retornar `true` la validación fue exitosa, retornando `false` significa que la misma falló. When executing this validator Phalcon will pass data depending what it is - if it's an entity (i.e. a model, a `stdClass` etc.) then entity will be passed, otherwise data (i.e an array like `$_POST`). Aquí un ejemplo:

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

Each message consists of an instance of the class [Phalcon\Validation\Message](api/Phalcon_Validation_Message). El conjunto de mensajes generados se puede recuperar con el método `getMessages()`. Cada mensaje proporciona información ampliada como el atributo que genera el mensaje o el tipo de mensaje:

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

Es posible pasar un parámetro `message` para cambiar o traducir el mensaje por defecto en cada validador, incluso es posible utilizar en el mensaje el comodín `:field` para ser reemplazado por el nombre del campo:

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

Por defecto, el método `getMessages()` devuelve todos los mensajes generados durante la validación. Usted puede filtrar los mensajes para un campo específico usando el método `filter()`:

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

Es posible filtrar datos antes de validarlos, garantizando que los datos maliciosos o incorrectos no sean validados.

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

Los validaciones se organizan en clases, es posible implementar los métodos `beforeValidation()` y `afterValidation()` para llevar a cabo más controles, filtros, limpieza, etcétera. If the `beforeValidation()` method returns false the validation is automatically cancelled:

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

Por defecto, todos los validadores asignados a un campo se prueban independientemente si uno de ellos falló o no. Es posible cambiar este comportamiento diciéndole al componente de validación qué validador puede detener la validación:

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

El primero validador tiene la opción `cancelOnFail` con el valor `true`, por lo tanto, si el validador falla los validadores restantes no se ejecutarán.

Si esta creando validadores personalizados, es posible detener la validación en cadena estableciendo la opción `cancelOnFail` como vemos a continuación:

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

Es posible pasar la opción `allowEmpty` a todos los validadores incorportados para evitar la validación a realizarse si el valor pasado esta vacío:

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

También puede ejecutar instancias de validación dentro de otra, mediante el método `afterValidation()`. En este ejemplo, al validar la instancia `CompanyValidation` también comprobaremos la instancia `PhoneValidation`:

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