---
layout: default
language: 'es-es'
version: '4.0'
title: 'Validación'
keywords: 'validación, validar formularios, validar modelos, validar datos'
---

# Componente Validation

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

[Phalcon\Validation](api/phalcon_validation#validation) es un componente de validación independiente que valida un conjunto arbitrario de datos. Este componente se puede usar para implementar reglas de validación sobre objetos de datos que no pertenecen a un modelo o colección.

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

El diseño bajamente acoplado de este componente le permite crear sus propios validadores junto con los proporcionados por el framework.

## Métodos

```php
public function __construct(
    array $validators = []
)
```

```php
public function add(
    mixed $field, 
    ValidatorInterface $validator
): ValidationInterface
```

Añade un validador a un campo

```php
public function appendMessage(
    MessageInterface $message
): ValidationInterface
```

Añade un mensaje a la lista de mensajes

```php
public function bind(
    object $entity, 
    array | object $$data
): ValidationInterface
```

Asigna los datos a una entidad. La entidad se usa para obtener la clase de validación

```php
public function getEntity(): object
```

Devuelve la entidad enlazada

```php
public function getFilters(
    string $field = null
): mixed | null
```

Devuelve todos los filtros o uno específico

```php
public function getLabel(
    string $field
): string
```

Obtiene la etiqueta de un campo

```php
public function getMessages(): Messages
```

Devuelve los validadores registrados

```php
public function getValidators(): array
```

Devuelve los validadores añadidos a la validación

```php
public function getValue(
    string $field
): mixed | null
```

Obtiene un valor a validar en la fuente de datos vector/objeto

```php
public function rule(
    mixed $field, 
    ValidatorInterface $validator
): ValidationInterface
```

Alias del método `add`

```php
public function rules(
    mixed $field, 
    array $validators
): ValidationInterface
```

Añade los validadores a un campo

```php
public function setEntity(
    object $entity
): void
```

Establece la entidad enlazada

```php
public function setFilters(
    string $field, 
    array | string $filters
): ValidationInterface
```

Añade filtros al campo

```php
public function setLabels(
    array $labels
): void
```

Añade etiquetas a los campos

```php
public function validate(
    array | object $data = null, 
    object $entity = null
): Messages
```

Valida un conjunto de datos según un conjunto de reglas

## Activación

Las cadenas de validación se pueden inicializar de una manera directa simplemente añadiendo validadores al objeto [Phalcon\Validation](api/phalcon_validation#validation). Puede poner sus validaciones en un fichero separado para una mejor reutilización y organización del código.

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
                    'message' => 'The name is required',
                ]
            )
        );

        $this->add(
            'email',
            new PresenceOf(
                [
                    'message' => 'The e-mail is required',
                ]
            )
        );

        $this->add(
            'email',
            new Email(
                [
                    'message' => 'The e-mail is not valid',
                ]
            )
        );
    }
}
```

Luego inicialice y use su propio validador:

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

## Validadores

Phalcon ofrece un conjunto de validadores integrados para este componente:

| Clase                                                                                                                        | Valida                          |
| ---------------------------------------------------------------------------------------------------------------------------- | ------------------------------- |
| [Phalcon\Validation\Validator\Alnum](api/phalcon_validation#validation-validator-alnum)                                   | Caracter(es) alfanumérico(s)    |
| [Phalcon\Validation\Validator\Alpha](api/phalcon_validation#validation-validator-alpha)                                   | Caracter(es) del alfabeto.      |
| [Phalcon\Validation\Validator\Between](api/phalcon_validation#validation-validator-between)                               | Entre dos valores               |
| [Phalcon\Validation\Validator\Callback](api/phalcon_validation#validation-validator-callback)                             | Función de retorno              |
| [Phalcon\Validation\Validator\Confirmation](api/phalcon_validation#validation-validator-confirmation)                     | Valores de campo idénticos      |
| [Phalcon\Validation\Validator\CreditCard](api/phalcon_validation#validation-validator-creditcard)                         | Número de tarjeta de crédito    |
| [Phalcon\Validation\Validator\Date](api/phalcon_validation#validation-validator-date)                                     | Fecha.                          |
| [Phalcon\Validation\Validator\Digit](api/phalcon_validation#validation-validator-digit)                                   | Caracter(es) numérico(s).       |
| [Phalcon\Validation\Validator\Email](api/phalcon_validation#validation-validator-email)                                   | Email                           |
| [Phalcon\Validation\Validator\ExclusionIn](api/phalcon_validation#validation-validator-exclusionin)                       | No dentro del valor establecido |
| [Phalcon\Validation\Validator\File](api/phalcon_validation#validation-validator-file)                                     | Archivo                         |
| [Phalcon\Validation\Validator\File\MimeType](api/phalcon_validation#validation-validator-file-mimetype)                  | Tipo de medio del fichero       |
| [Phalcon\Validation\Validator\File\Resolution\Equal](api/phalcon_validation#validation-validator-file-resolution-equal) | Igual resolución del Fichero    |
| [Phalcon\Validation\Validator\File\Resolution\Max](api/phalcon_validation#validation-validator-file-resolution-max)     | Resolución máxima del Fichero   |
| [Phalcon\Validation\Validator\File\Resolution\Min](api/phalcon_validation#validation-validator-file-resolution-min)     | Resolución mínima del Fichero   |
| [Phalcon\Validation\Validator\File\Size\Equal](api/phalcon_validation#validation-validator-file-size-equal)             | Tamaño de Fichero Igual         |
| [Phalcon\Validation\Validator\File\Size\Max](api/phalcon_validation#validation-validator-file-size-max)                 | Máximo Tamaño de Fichero        |
| [Phalcon\Validation\Validator\File\Size\Min](api/phalcon_validation#validation-validator-file-size-min)                 | Mínimo Tamaño de Fichero        |
| [Phalcon\Validation\Validator\Identical](api/phalcon_validation#validation-validator-identical)                           | Valor específico igual          |
| [Phalcon\Validation\Validator\InclusionIn](api/phalcon_validation#validation-validator-inclusionin)                       | Dentro del valor establecido    |
| [Phalcon\Validation\Validator\Ip](api/phalcon_validation#validation-validator-ip)                                         | IP                              |
| [Phalcon\Validation\Validator\Numericality](api/phalcon_validation#validation-validator-numericality)                     | Valor Numérico                  |
| [Phalcon\Validation\Validator\PresenceOf](api/phalcon_validation#validation-validator-presenceof)                         | No `null` o vacío               |
| [Phalcon\Validation\Validator\Regex](api/phalcon_validation#validation-validator-regex)                                   | Expresión Regular               |
| [Phalcon\Validation\Validator\StringLength](api/phalcon_validation#validation-validator-stringlength)                     | Tamaño                          |
| [Phalcon\Validation\Validator\StringLength\Max](api/phalcon_validation#validation-validator-stringlength-max)            | Tamaño Máximo                   |
| [Phalcon\Validation\Validator\StringLength\Min](api/phalcon_validation#validation-validator-stringlength-min)            | Tamaño Mínimo                   |
| [Phalcon\Validation\Validator\Uniqueness](api/phalcon_validation#validation-validator-uniqueness)                         | Único en el Modelo              |
| [Phalcon\Validation\Validator\Url](api/phalcon_validation#validation-validator-url)                                       | URL                             |

### Alnum

Comprobar caracter(es) alfanumérico(s)

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Alnum;

$validator = new Validation();

$validator->add(
    "username",
    new Alnum(
        [
            "message" => ":field must contain only alphanumeric characters",
        ]
    )
);

$validator->add(
    [
        "username",
        "name",
    ],
    new Alnum(
        [
            "message" => [
                "username" => "username must contain only alphanumeric characters",
                "name"     => "name must contain only alphanumeric characters",
            ],
        ]
    )
);
```

### Alpha

Verifica uno o varios caracteres alfabéticos

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Alpha;

$validator = new Validation();

$validator->add(
    "username",
    new Alpha(
        [
            "message" => ":field must contain only letters",
        ]
    )
);

$validator->add(
    [
        "username",
        "name",
    ],
    new Alpha(
        [
            "message" => [
                "username" => "username must contain only letters",
                "name"     => "name must contain only letters",
            ],
        ]
    )
);
```

### Between

Valida que un valor está entre un rango inclusivo de dos valores. La validación pasa si para un valor `L`, el mínimo es menor o igual que `L` y `L` es menor o igual que el máximo. Los límites están incluidos en esta validación. La fórmula es:

    mínimo <= valor <= máximo
    

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Between;

$validator = new Validation();

$validator->add(
    "price",
    new Between(
        [
            "minimum" => 0,
            "maximum" => 100,
            "message" => "The price must be between 0 and 100",
        ]
    )
);

$validator->add(
    [
        "price",
        "amount",
    ],
    new Between(
        [
            "minimum" => [
                "price"  => 0,
                "amount" => 0,
            ],
            "maximum" => [
                "price"  => 100,
                "amount" => 50,
            ],
            "message" => [
                "price"  => "The price must be between 0 and 100",
                "amount" => "The amount must be between 0 and 50",
            ],
        ]
    )
);
```

### Callback

Al usar [Phalcon\Validation\Validator\Callback](api/Phalcon_Validation_Validator_Callback) puede ejecutar funciones personalizadas que deben devolver un booleano o una nueva clase validador que será usada para validar el mismo campo. Al devolver `true` la validación será exitosa, al devolver `false` significará que la validación ha fallado. Cuando se ejecuta este validador, Phalcon pasará datos dependiendo de lo que sean - si es una entidad (ej. un modelo, una `stdClass`, etc.) entonces la entidad será pasada, de lo contrario los datos (ej. un vector como `$_POST`). Aquí un ejemplo:

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
            'callback' => function ($data) {
                return $data['amount'] % 2 == 0;
            },
            'message'  => 'Only even number of products are accepted'
        ]
    )
);
$validation->add(
    'amount',
    new Callback(
        [
            'callback' => function ($data) {
                if ($data['amount'] % 2 == 0) {
                    return $data['amount'] != 2;
                }

                return true;
            },
            'message' => "You cannot buy 2 products"
        ]
    )
);
$validation->add(
    'description',
    new Callback(
        [
            'callback' => function ($data) {
                if ($data['amount'] >= 10) {
                    return new PresenceOf(
                        [
                            'message' => 'You must write why you need so big amount.'
                        ]
                    );
                }

                return true;
            }
        ]
    )
);

// Validator #1
$messages = $validation->validate(['amount' => 1]);
// Validator #2
$messages = $validation->validate(['amount' => 2]);
// Validator #3
$messages = $validation->validate(['amount' => 10]);
```

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Callback;
use Phalcon\Validation\Validator\Numericality;

$validator = new Validation();

$validator->add(
    ["user", "admin"],
    new Callback(
        [
            "message" => "User cannot belong to two groups",
            "callback" => function($data) {
                if (!empty($data->getUser()) && 
                    !empty($data->getAdmin())) {
                    return false;
                }

                return true;
            }
        ]
    )
);

$validator->add(
    "amount",
    new Callback(
        [
            "callback" => function($data) {
                if (!empty($data->getProduct())) {
                    return new Numericality(
                        [
                            "message" => "Amount must be a number."
                        ]
                    );
                }
            }
        ]
    )
);
```

### Confirmation

Comprueba si dos valores tienen el mismo valor

```php
<?php 

use Phalcon\Validation;
use Phalcon\Validation\Validator\Confirmation;

$validator = new Validation();

$validator->add(
    "password",
    new Confirmation(
        [
            "message" => "Password doesn't match confirmation",
            "with"    => "confirmPassword",
        ]
    )
);

$validator->add(
    [
        "password",
        "email",
    ],
    new Confirmation(
        [
            "message" => [
                "password" => "Password doesn't match confirmation",
                "email"    => "Email doesn't match confirmation",
            ],
            "with" => [
                "password" => "confirmPassword",
                "email"    => "confirmEmail",
            ],
        ]
    )
);
```

### CreditCard

Comprueba si un valor tiene un número de tarjeta de crédito válido

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\CreditCard;

$validator = new Validation();

$validator->add(
    "creditCard",
    new CreditCard(
        [
            "message" => "The credit card number is not valid",
        ]
    )
);

$validator->add(
    [
        "creditCard",
        "secondCreditCard",
    ],
    new CreditCard(
        [
            "message" => [
                "creditCard"       => "The credit card number is not valid",
                "secondCreditCard" => "The second credit card number is not valid",
            ],
        ]
    )
);
```

### Date

Verifica si un valor es una fecha válida

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Date as DateValidator;

$validator = new Validation();

$validator->add(
    "date",
    new DateValidator(
        [
            "format"  => "d-m-Y",
            "message" => "The date is invalid",
        ]
    )
);

$validator->add(
    [
        "date",
        "anotherDate",
    ],
    new DateValidator(
        [
            "format" => [
                "date"        => "d-m-Y",
                "anotherDate" => "Y-m-d",
            ],
            "message" => [
                "date"        => "The date is invalid",
                "anotherDate" => "The another date is invalid",
            ],
        ]
    )
);
```

### Digit

Comprueba caracter(es) numérico(s)

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Digit;

$validator = new Validation();

$validator->add(
    "height",
    new Digit(
        [
            "message" => ":field must be numeric",
        ]
    )
);

$validator->add(
    [
        "height",
        "width",
    ],
    new Digit(
        [
            "message" => [
                "height" => "height must be numeric",
                "width"  => "width must be numeric",
            ],
        ]
    )
);
```

### Email

Verifica si un valor tiene un formato de correo electrónico correcto

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;

$validator = new Validation();

$validator->add(
    "email",
    new Email(
        [
            "message" => "The e-mail is not valid",
        ]
    )
);

$validator->add(
    [
        "email",
        "anotherEmail",
    ],
    new Email(
        [
            "message" => [
                "email"        => "The e-mail is not valid",
                "anotherEmail" => "The another e-mail is not valid",
            ],
        ]
    )
);
```

### ExclusionIn

Comprueba si un valor no está incluido en una lista de valores

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\ExclusionIn;

$validator = new Validation();

$validator->add(
    "status",
    new ExclusionIn(
        [
            "message" => "The status must not be A or B",
            "domain"  => [
                "A",
                "B",
            ],
        ]
    )
);

$validator->add(
    [
        "status",
        "type",
    ],
    new ExclusionIn(
        [
            "message" => [
                "status" => "The status must not be A or B",
                "type"   => "The type must not be 1 or "
            ],
            "domain" => [
                "status" => [
                    "A",
                    "B",
                ],
                "type"   => [1, 2],
            ],
        ]
    )
);
```

### File

Verifica si un valor tiene un archivo correcto

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\File;

$validator = new Validation();

$validator->add(
    "file",
    new File(
        [
            "maxSize"              => "2M",
            "messageSize"          => ":field exceeds the max size (:size)",
            "allowedTypes"         => [
                "image/jpeg",
                "image/png",
            ],
            "messageType"          => "Allowed file types are :types",
            "maxResolution"        => "800x600",
            "messageMaxResolution" => "Max resolution of :field is :resolution",
        ]
    )
);

$validator->add(
    [
        "file",
        "anotherFile",
    ],
    new File(
        [
            "maxSize" => [
                "file"        => "2M",
                "anotherFile" => "4M",
            ],
            "messageSize" => [
                "file"        => "file exceeds the max size 2M",
                "anotherFile" => "anotherFile exceeds the max size 4M",
            "allowedTypes" => [
                "file"        => [
                    "image/jpeg",
                    "image/png",
                ],
                "anotherFile" => [
                    "image/gif",
                    "image/bmp",
                ],
            ],
            "messageType" => [
                "file"        => "Allowed file types are image/jpeg and image/png",
                "anotherFile" => "Allowed file types are image/gif and image/bmp",
            ],
            "maxResolution" => [
                "file"        => "800x600",
                "anotherFile" => "1024x768",
            ],
            "messageMaxResolution" => [
                "file"        => "Max resolution of file is 800x600",
                "anotherFile" => "Max resolution of file is 1024x768",
            ],
        ]
    )
);
```

### File MimeType

Comprueba si un valor tiene un tipo de medio de fichero correcto

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\File\MimeType;

$validator = new Validation();

$validator->add(
    "file",
    new MimeType(
        [
            "types" => [
                "image/jpeg",
                "image/png",
            ],
            "message" => "Allowed file types are :types"
        ]
    )
);

$validator->add(
    [
        "file",
        "anotherFile",
    ],
    new MimeType(
        [
            "types" => [
                "file"        => [
                    "image/jpeg",
                    "image/png",
                ],
                "anotherFile" => [
                    "image/gif",
                    "image/bmp",
                ],
            ],
            "message" => [
                "file"        => "Allowed file types are image/jpeg and image/png",
                "anotherFile" => "Allowed file types are image/gif and image/bmp",
            ]
        ]
    )
);
```

### File Resolution Equal

Comprueba si un fichero tiene una resolución correcta

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\File\Resolution\Equal;

$validator = new Validation();

$validator->add(
    "file",
    new Equal(
        [
            "resolution" => "800x600",
            "message"    => "The resolution of the field :field has to be equal :resolution",
        ]
    )
);

$validator->add(
    [
        "file",
        "anotherFile",
    ],
    new Equal(
        [
            "resolution" => [
                "file"        => "800x600",
                "anotherFile" => "1024x768",
            ],
            "message" => [
                "file"        => "Equal resolution of file has to be 800x600",
                "anotherFile" => "Equal resolution of file has to be 1024x768",
            ],
        ]
    )
);
```

### File Resolution Max

Comprueba si un fichero tiene una resolución correcta

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\File\Resolution\Max;

$validator = new Validation();

$validator->add(
    "file",
    new Max(
        [
            "resolution"      => "800x600",
            "message"  => "Max resolution of :field is :resolution",
            "included" => true,
        ]
    )
);

$validator->add(
    [
        "file",
        "anotherFile",
    ],
    new Max(
        [
            "resolution" => [
                "file"        => "800x600",
                "anotherFile" => "1024x768",
            ],
            "included" => [
                "file"        => false,
                "anotherFile" => true,
            ],
            "message" => [
                "file"        => "Max resolution of file is 800x600",
                "anotherFile" => "Max resolution of file is 1024x768",
            ],
        ]
    )
);
```

### File Resolution Min

Comprueba si un fichero tiene una resolución correcta

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\File\Resolution\Min;

$validator = new Validation();

$validator->add(
    "file",
    new Min(
        [
            "resolution" => "800x600",
            "message"    => "Min resolution of :field is :resolution",
            "included"   => true,
        ]
    )
);

$validator->add(
    [
        "file",
        "anotherFile",
    ],
    new Min(
        [
            "resolution" => [
                "file"        => "800x600",
                "anotherFile" => "1024x768",
            ],
            "included" => [
                "file"        => false,
                "anotherFile" => true,
            ],
            "message" => [
                "file"        => "Min resolution of file is 800x600",
                "anotherFile" => "Min resolution of file is 1024x768",
            ],
        ]
    )
);
```

### File Size Equal

Verifica si un valor tiene un archivo correcto

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\File\Size\Equal;

$validator = new Validation();

$validator->add(
    "file",
    new Equal(
        [
            "size"     => "2M",
            "included" => true,
            "message"  => ":field exceeds the size (:size)",
        ]
    )
);

$validator->add(
    [
        "file",
        "anotherFile",
    ],
    new Equal(
        [
            "size" => [
                "file"        => "2M",
                "anotherFile" => "4M",
            ],
            "included" => [
                "file"        => false,
                "anotherFile" => true,
            ],
            "message" => [
                "file"        => "file does not have the correct size",
                "anotherFile" => "anotherFile wrong size (4MB)",
            ],
        ]
    )
);
```

### File Size Max

Verifica si un valor tiene un archivo correcto

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\File\Size\Max;

$validator = new Validation();

$validator->add(
    "file",
    new Max(
        [
            "size"     => "2M",
            "included" => true,
            "message"  => ":field exceeds the max size (:size)",
        ]
    )
);

$validator->add(
    [
        "file",
        "anotherFile",
    ],
    new Max(
        [
            "size" => [
                "file"        => "2M",
                "anotherFile" => "4M",
            ],
            "included" => [
                "file"        => false,
                "anotherFile" => true,
            ],
            "message" => [
                "file"        => "file exceeds the max size 2M",
                "anotherFile" => "anotherFile exceeds the max size 4M",
            ],
        ]
    )
);
```

### File Size Min

Verifica si un valor tiene un archivo correcto

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\File\Size\Min;

$validator = new Validation();

$validator->add(
    "file",
    new Min(
        [
            "size"     => "2M",
            "included" => true,
            "message"  => ":field exceeds the min size (:size)",
        ]
    )
);

$validator->add(
    [
        "file",
        "anotherFile",
    ],
    new Min(
        [
            "size" => [
                "file"        => "2M",
                "anotherFile" => "4M",
            ],
            "included" => [
                "file"        => false,
                "anotherFile" => true,
            ],
            "message" => [
                "file"        => "file exceeds the min size 2M",
                "anotherFile" => "anotherFile exceeds the min size 4M",
            ],
        ]
    )
);
```

### Identical

Verifica si un valor es idéntico a otro

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Identical;

$validator = new Validation();

$validator->add(
    "terms",
    new Identical(
        [
            "accepted" => "yes",
            "message" => "Terms and conditions must be accepted",
        ]
    )
);

$validator->add(
    [
        "terms",
        "anotherTerms",
    ],
    new Identical(
        [
            "accepted" => [
                "terms"        => "yes",
                "anotherTerms" => "yes",
            ],
            "message" => [
                "terms"        => "Terms and conditions must be accepted",
                "anotherTerms" => "Another terms  must be accepted",
            ],
        ]
    )
);
```

### InclusionIn

Comprueba si un valor está incluido en una lista de valores

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\InclusionIn;

$validator = new Validation();

$validator->add(
    "status",
    new InclusionIn(
        [
            "message" => "The status must be A or B",
            "domain"  => ["A", "B"],
        ]
    )
);

$validator->add(
    [
        "status",
        "type",
    ],
    new InclusionIn(
        [
            "message" => [
                "status" => "The status must be A or B",
                "type"   => "The status must be 1 or 2",
            ],
            "domain" => [
                "status" => ["A", "B"],
                "type"   => [1, 2],
            ]
        ]
    )
);
```

### Ip

Comprueba direcciones IP

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Ip;

$validator = new Validation();

$validator->add(
    "ip_address",
    new Ip(
        [
            "message"       => ":field must contain only ip addresses",
            // v6 and v4. The same if not specified
            "version"       => IP::VERSION_4 | Ip::VERSION_6, 
            // False if not specified. Ignored for v6
            "allowReserved" => false,
            // False if not specified
            "allowPrivate"  => false,
            "allowEmpty"    => false,
        ]
    )
);

$validator->add(
    [
        "source_address",
        "destination_address",
    ],
    new Ip(
        [
            "message" => [
                "source_address"      => "source_address must be a valid IP address",
                "destination_address" => "destination_address must be a valid IP address",
            ],
            "version" => [
                 "source_address"      => Ip::VERSION_4 | Ip::VERSION_6,
                 "destination_address" => Ip::VERSION_4,
            ],
            "allowReserved" => [
                 "source_address"      => false,
                 "destination_address" => true,
            ],
            "allowPrivate" => [
                 "source_address"      => false,
                 "destination_address" => true,
            ],
            "allowEmpty" => [
                 "source_address"      => false,
                 "destination_address" => true,
            ],
        ]
    )
);
```

### Numericality

Comprueba que haya un valor numérico válido

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Numericality;

$validator = new Validation();

$validator->add(
    "price",
    new Numericality(
        [
            "message" => ":field is not numeric",
        ]
    )
);

$validator->add(
    [
        "price",
        "amount",
    ],
    new Numericality(
        [
            "message" => [
                "price"  => "price is not numeric",
                "amount" => "amount is not numeric",
            ]
        ]
    )
);
```

### PresenceOf

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;

$validation = new Validation();

$validation->add(
    'name',
    new PresenceOf(
        [
            'message' => 'The name is required',
        ]
    )
);
);
```

### Regex

Valida un campo basado en un patrón de expresión regular.

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Regex;

$validation = new Validation();

$validation->add(
    'telephone',
    new Regex(
        [
            'message' => 'The telephone is required',
            'pattern' => '/\+1 [0-9]+/',
        ]
    )
);
```

### StringLength

Valida que una cadena tenga las restricciones máximas y mínimas especificadas. La validación pasa si para un tamaño de cadena `L`, el mínimo es menor o igual que `L` y `L` es menor o igual que el máximo. Los límites están incluidos en esta validación. La fórmula es:

    mínimo <= tamaño de cadena <= máximo
    

Este validador funciona como un contenedor.

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\StringLength;

$validator = new Validation();

$validation->add(
    "name_last",
    new StringLength(
        [
            "max"             => 50,
            "min"             => 2,
            "messageMaximum"  => "Name too long",
            "messageMinimum"  => "Only initials please",
            "includedMaximum" => true,
            "includedMinimum" => false,
        ]
    )
);

$validation->add(
    [
        "name_last",
        "name_first",
    ],
    new StringLength(
        [
            "max" => [
                "name_last"  => 50,
                "name_first" => 40,
            ],
            "min" => [
                "name_last"  => 2,
                "name_first" => 4,
            ],
            "messageMaximum" => [
                "name_last"  => "Last name too short",
                "name_first" => "First name too short",
            ],
            "messageMinimum" => [
                "name_last"  => "Last name too long",
                "name_first" => "First name too long",
            ],
            "includedMaximum" => [
                "name_last"  => false,
                "name_first" => true,
            ],
            "includedMinimum" => [
                "name_last"  => false,
                "name_first" => true,
            ]
        ]
    )
);
```

### StringLength Max

Valida que una cadena tiene la restricción máxima especificada. La validación pasa si para un tamaño de cadena `L` es menor o igual que el máximo. La fórmula es:

    tamaño de cadena <= máximo
    

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\StringLength\Max;

$validator = new Validation();

$validation->add(
    "name_last",
    new Max(
        [
            "max"      => 50,
            "message"  => "Last name too long",
            "included" => true
        ]
    )
);

$validation->add(
    [
        "name_last",
        "name_first",
    ],
    new Max(
        [
            "max" => [
                "name_last"  => 50,
                "name_first" => 40,
            ],
            "message" => [
                "name_last"  => "Last name too long",
                "name_first" => "First name too long",
            ],
            "included" => [
                "name_last"  => false,
                "name_first" => true,
            ]
        ]
    )
);
```

### StringLength Min

Valida que una cadena tenga la restricción mínima especificada. La validación pasa si para un tamaño de cadena `L` es mayor o igual que el mínimo. La fórmula es:

    mínimo <= tamaño de cadena 
    

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\StringLength\Min;

$validator = new Validation();

$validation->add(
    "name_last",
    new Min(
        [
            "min"     => 2,
            "message" => "Only initials please",
            "included" => true
        ]
    )
);

$validation->add(
    [
        "name_last",
        "name_first",
    ],
    new Min(
        [
            "min" => [
                "name_last"  => 2,
                "name_first" => 4,
            ],
            "message" => [
                "name_last"  => "Last name too short",
                "name_first" => "First name too short",
            ],
            "included" => [
                "name_last"  => false,
                "name_first" => true,
            ]
        ]
    )
);
```

### Uniqueness

Comprueba que un campo sea único en la tabla relacionada

```php
<?php

use MyApp\Models\Customers;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;

$validator = new Validation();

$validator->add(
    "cst_email",
    new Uniqueness(
        [
            "model"   => new Customers(),
            "message" => ":field must be unique",
        ]
    )
);
```

Atributo diferente del campo:

```php
<?php

$validator->add(
    "cst_email",
    new Uniqueness(
        [
            "model"     => new Invoices(),
            "attribute" => "nick",
        ]
    )
);
```

En el modelo:

```php
<?php

$validator->add(
    "cst_email",
    new Uniqueness()
);
```

Combinación de campos en el modelo:

```php
<?php

$validator->add(
    [
        "cst_name_last",
        "cst_name_first",
    ],
    new Uniqueness()
);
```

Es posible convertir valores antes de la validación. Esto es útil en situaciones donde los valores necesitan ser convertidos para la búsqueda de base de datos:

```php
<?php

$validator->add(
    "cst_email",
    new Uniqueness(
        [
            "convert" => function (array $values) {
                $values["cst_email"] = trim($values["cst_email"]);

                return $values;
            }
        ]
    )
);
```

#### Usando `except` para campos (Operación SQL "value NOT IN (except)")

Campo simple

```php
<?php

$validator->add(
    "cst_email",
    new Uniqueness(
        [
            "except" => "name@email.com"
        ]
    )
);
```

Campos múltiples con claves (cada `except` se aplicará al valor que define por clave)

```php
<?php

$validator->add(
    ["cst_email", "cst_phone"],
    new Uniqueness(
        [
            "except" => [
                "cst_email" => "name@email.com",
                "cst_phone" => "82918304-3843",
            ]
        ]
    )
);
```

Campos múltiples sin claves (cada `except` se aplicará a todos los valores recursivamente)

```php
<?php

$validator->add(
    ["cst_email", "cmp_email"],
    new Uniqueness(
        [
            "except" => [
                "name@email.com",
                "company@email.com",
            ],
        ]
    )
);
```

Campos múltiples con `except` simple (`except` se aplicará a todos los valores recursivamente)

```php
<?php

$validator->add(
    ["cst_email", "cmp_email"],
    new Uniqueness(
        [
            "except" => "name@email.com",
        ]
    )
);
```

### Url

Comprueba si un valor tiene un formato de url

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Url;

$validator = new Validation();

$validator->add(
    "url",
    new Url(
        [
            "message" => ":field must be a url",
        ]
    )
);

$validator->add(
    [
        "url",
        "homepage",
    ],
    new Url(
        [
            "message" => [
                "url"      => "url must be a url",
                "homepage" => "homepage must be a url",
            ]
        ]
    )
);
```

También puede pasar la opción `flags` en el vector, definiendo `FILTER_FLAG_PATH_REQUIRED` o `FILTER_FLAG_QUERY_REQUIRED` si es necesario.

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Url;

$validation = new Validation();

$validation->add(
    'url',
    new Url(
        [
            'options' => FILTER_FLAG_PATH_REQUIRED
        ]
    )
);

$messages = $validation->validate(
    [
        'url' => 'phalcon.io',
    ]
);

$validation->add(
    'url',
    new Url(
        [
            'options' => FILTER_FLAG_QUERY_REQUIRED
        ]
    )
);

$messages = $validation->validate(
    [
        'url' => 'https://',
    ]
);

$validation->add(
    'url',
    new Url(
        [
            'options' => [
                'flags' => [
                    FILTER_FLAG_PATH_REQUIRED,
                    FILTER_FLAG_QUERY_REQUIRED,
                ],
            ],
        ]
    )
);

$messages = $validation->validate(
    [
        'url' => 'phalcon',
    ]
);
```

### Validadores Personalizados

Puede crear sus propios validadores implementando [Phalcon\Validation\ValidatorInterface](api/phalcon_validation#validation-validatorinterface) o [Phalcon\Validation\Validator\CompositeInterface](api/phalcon_validation#validation-validatorcompositeinterface). También puede extender [Phalcon\Validation\AbstractCombinedFieldsValidator](api/phalcon_validation#validation-abstractcombinedfieldsvalidator), [Phalcon\Validation\AbstractValidator](api/phalcon_validation#validation-abstractvalidator) o [Phalcon\Validation\AbstractValidatorComposite](api/phalcon_validation#validation-abstractvalidatorcomposite).

```php
<?php

use Phalcon\Messages\Message;
use Phalcon\Validation;
use Phalcon\Validation\AbstractValidator;

class IpValidator extends AbstractValidator
{
    /**
     * Executes the validation
     *
     * @param Validation $validator
     * @param string     $attribute
     *
     * @return boolean
     */
    public function validate(Validation $validator, $attribute)
    {
        $value = $validator->getValue($attribute);

        if (!filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6)) {
            $message = $this->getOption('message');

            if (!$message) {
                $message = 'The IP is not valid';
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

Es importante que los validadores devuelvan un valor `booleano` válido que indique si la validación es correcta o no.

## Messages

[Phalcon\Validation](api/phalcon_validation#validation) utiliza la colección [Phalcon\Messages\Messages](api/phalcon_messages#messages-messages), que proporciona una manera flexible de mostrar o almacenar los mensajes de validación generados durante el proceso de validación.

Cada mensaje consiste en una instancia de la clase [Phalcon\Messages\Message](api/phalcon_messages#messages-message). El conjunto de mensajes generados se puede recuperar con el método `getMessages()`. Cada mensaje proporciona información detallada como el campo que ha generado el mensaje o el tipo de mensaje:

```php
<?php

$messages = $validation->validate();

if (count($messages)) {
    foreach ($messages as $message) {
        echo 'Message: ', $message->getMessage(), "\n";
        echo 'Field: ', $message->getField(), "\n";
        echo 'Type: ', $message->getType(), "\n";
    }
}
```

Puede pasar un parámetro `message` para cambiar/traducir el mensaje predeterminado en cada validador. También puede usar el marcador de posición `:field` en el mensaje que será reemplazado por la etiqueta del campo:

```php
<?php

use Phalcon\Validation\Validator\Email;

$validation->add(
    'email',
    new Email(
        [
            'message' => 'The e-mail is not valid',
        ]
    )
);
```

Por defecto, el método `getMessages()` devuelve todos los mensajes generados durante la validación. Puede filtrar los mensajes para un campo específico usando el método `filter()`:

```php
<?php

$messages = $validation->validate();

if (count($messages)) {
    $filteredMessages = $messages->filter('name');

    foreach ($filteredMessages as $message) {
        echo $message;
    }
}
```

## Filtrado de datos

Los datos se pueden filtrar antes de la validación, garantizando que datos maliciosos o incorrectos no sean validados.

```php
<?php

use Phalcon\Validation;

$validation = new Validation();

$validation->add(
    'name',
    new PresenceOf(
        [
            'message' => 'The name is required',
        ]
    )
);

$validation->add(
    'email',
    new PresenceOf(
        [
            'message' => 'The email is required',
        ]
    )
);

$validation->setFilters('name', 'trim');
$validation->setFilters('email', 'trim');
```

El filtrado y saneado se realizan usando el componente <filter>. Puede añadir más filtros a este componente o usar los ya integrados.

## Eventos

Cuando los validadores se organizan en clases, puede implementar los métodos `beforeValidation()` y `afterValidation()` para realizar comprobaciones adicionales, filtros, limpieza, etc. Si el método `beforeValidation()` devuelve `false` la validación se cancela automáticamente:

```php
<?php

use Phalcon\Http\Request;
use Phalcon\Messages\Message;
use Phalcon\Validation;

/**
 * @property Request $request
 */
class LoginValidation extends Validation
{
    public function initialize()
    {
        // ...
    }

    public function beforeValidation($data, $entity, $messages)
    {
        if ($this->request->getHttpHost() !== 'admin.mydomain.com') {
            $messages->appendMessage(
                new Message(
                    'Only users can log on in the admin domain'
                )
            );

            return false;
        }

        return true;
    }

    public function afterValidation($data, $entity, $messages)
    {
        // ... Add additional messages or perform more validations
    }
}
```

## Cancelando Validaciones

Por defecto todos los validadores asignados a un campo se prueban independientemente de si uno de ellos ha fallado o no. Puede cambiar este comportamiento indicando al componente de validación qué validador puede parar la validación:

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
            'message'      => 'The telephone is required',
            'cancelOnFail' => true,
        ]
    )
);

$validation->add(
    'telephone',
    new Regex(
        [
            'message' => 'The telephone is required',
            'pattern' => '/\+44 [0-9]+/',
        ]
    )
);

$validation->add(
    'telephone',
    new StringLength(
        [
            'messageMinimum' => 'The telephone is too short',
            'min'            => 2,
        ]
    )
);
```

El primer validador tiene la opción `cancelOnFail` con un valor `true`, por lo tanto, si ese validador falla los validadores restantes en la cadena no se ejecutarán.

Si está creando validadores personalizados, puede parar la cadena de validación dinámicamente, estableciendo la opción `cancelOnFail`:

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Message;
use Phalcon\Validation\Validator;

class MyValidator extends Validator
{
    public function validate(Validation $validator, $attribute)
    {
        // If the attribute value is name we must stop the chain
        if ($attribute === 'name') {
            $validator->setOption('cancelOnFail', true);
        }

        // ...
    }
}
```

## Valores Vacíos

Puede pasar la opción `allowEmpty` a cualquiera de los validadores integrados para ignorar valores vacíos.

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Regex;

$validation = new Validation();

$validation->add(
    'telephone',
    new Regex(
        [
            'message'    => 'The telephone is required',
            'pattern'    => '/\+1 [0-9]+/',
            'allowEmpty' => true,
        ]
    )
);
```

## Validación Recursiva

También puede ejecutar instancias de validación de otra forma mediante el método `afterValidation()`. En este ejemplo, validar la instancia `CompanyValidation` también comprobará la instancia `PhoneValidation`:

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

## Excepciones

Cualquier excepción lanzada en el espacio de nombres `Phalcon\Validator` será del tipo [Phalcon\Validation\Exception](api/phalcon_validation#validation-exception) o [Phalcon\Validation\Validator\Exception](api/phalcon_validation#validation-validator-exception). Puede usar esta excepción para capturar selectivamente sólo las excepciones lanzadas desde este componente.

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Exception;
use Phalcon\Validation\Validator\InclusionIn;

try {
    $validator = new Validation();

    $validator->add(
        "status",
        new InclusionIn(
            [
                "message" => "The status must be A or B",
                "domain"  => false,
            ]
        )
    );
} catch (Exception $ex) {
    echo $ex->getMessage();
}
```
