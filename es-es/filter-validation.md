---
layout: default
title: 'Validación'
upgrade: '#validation'
keywords: 'validación, validar formularios, validar modelos, validar datos'
---

# Componente Validation
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen
[Phalcon\Filter\Validation][validation] is an independent validation component that validates an arbitrary set of data. Este componente se puede usar para implementar reglas de validación sobre objetos de datos que no pertenecen a un modelo o colección.

En el ejemplo siguiente se muestra su uso básico:

```php
<?php

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Email;
use Phalcon\Filter\Validation\Validator\PresenceOf;

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
            'message' => 'The e-mail is required',
        ]
    )
);

$validation->add(
    'email',
    new Email(
        [
            'message' => 'The e-mail is not valid',
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
public function getValueByEntity(mixed $entity, string $field): mixed | null
```
Gets the value to validate in the object entity source

```php
public function getValueByData(mixed $data, string $field): mixed | null
```
Gets the value to validate in the array/object data source

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
Add filters to the field

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
Validation chains can be initialized in a direct manner by just adding validators to the [Phalcon\Filter\Validation][validation] object. Puede poner sus validaciones en un fichero separado para una mejor reutilización y organización del código.

```php
<?php

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Email;
use Phalcon\Filter\Validation\Validator\PresenceOf;

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

| Clase                                                                                                         | Valida                          |
| ------------------------------------------------------------------------------------------------------------- | ------------------------------- |
| [Phalcon\Filter\Validation\Validator\Alnum][validation-validator-alnum]                                   | Caracter(es) alfanumérico(s)    |
| [Phalcon\Filter\Validation\Validator\Alpha][validation-validator-alpha]                                   | Caracter(es) del alfabeto.      |
| [Phalcon\Filter\Validation\Validator\Between][validation-validator-between]                               | Entre dos valores               |
| [Phalcon\Filter\Validation\Validator\Callback][validation-validator-callback]                             | Función de retorno              |
| [Phalcon\Filter\Validation\Validator\Confirmation][validation-validator-confirmation]                     | Valores de campo idénticos      |
| [Phalcon\Filter\Validation\Validator\CreditCard][validation-validator-creditcard]                         | Número de tarjeta de crédito    |
| [Phalcon\Filter\Validation\Validator\Date][validation-validator-date]                                     | Fecha.                          |
| [Phalcon\Filter\Validation\Validator\Digit][validation-validator-digit]                                   | Caracter(es) numérico(s).       |
| [Phalcon\Filter\Validation\Validator\Email][validation-validator-email]                                   | Email                           |
| [Phalcon\Filter\Validation\Validator\ExclusionIn][validation-validator-exclusionin]                       | No dentro del valor establecido |
| [Phalcon\Filter\Validation\Validator\File][validation-validator-file]                                     | Archivo                         |
| [Phalcon\Filter\Validation\Validator\File\MimeType][validation-validator-file-mimetype]                  | Tipo de medio del fichero       |
| [Phalcon\Filter\Validation\Validator\File\Resolution\Equal][validation-validator-file-resolution-equal] | Igual resolución del Fichero    |
| [Phalcon\Filter\Validation\Validator\File\Resolution\Max][validation-validator-file-resolution-max]     | Resolución máxima del Fichero   |
| [Phalcon\Filter\Validation\Validator\File\Resolution\Min][validation-validator-file-resolution-min]     | Resolución mínima del Fichero   |
| [Phalcon\Filter\Validation\Validator\File\Size\Equal][validation-validator-file-size-equal]             | Tamaño de Fichero Igual         |
| [Phalcon\Filter\Validation\Validator\File\Size\Max][validation-validator-file-size-max]                 | Máximo Tamaño de Fichero        |
| [Phalcon\Filter\Validation\Validator\File\Size\Min][validation-validator-file-size-min]                 | Mínimo Tamaño de Fichero        |
| [Phalcon\Filter\Validation\Validator\Identical][validation-validator-identical]                           | Valor específico igual          |
| [Phalcon\Filter\Validation\Validator\InclusionIn][validation-validator-inclusionin]                       | Dentro del valor establecido    |
| [Phalcon\Filter\Validation\Validator\Ip][validation-validator-ip]                                         | IP                              |
| [Phalcon\Filter\Validation\Validator\Numericality][validation-validator-numericality]                     | Valor Numérico                  |
| [Phalcon\Filter\Validation\Validator\PresenceOf][validation-validator-presenceof]                         | No `null` o vacío               |
| [Phalcon\Filter\Validation\Validator\Regex][validation-validator-regex]                                   | Expresión Regular               |
| [Phalcon\Filter\Validation\Validator\StringLength][validation-validator-stringlength]                     | Tamaño                          |
| [Phalcon\Filter\Validation\Validator\StringLength\Max][validation-validator-stringlength-max]            | Tamaño Máximo                   |
| [Phalcon\Filter\Validation\Validator\StringLength\Min][validation-validator-stringlength-min]            | Tamaño Mínimo                   |
| [Phalcon\Filter\Validation\Validator\Uniqueness][validation-validator-uniqueness]                         | Único en el Modelo              |
| [Phalcon\Filter\Validation\Validator\Url][validation-validator-url]                                       | URL                             |

### Alnum
Comprobar caracter(es) alfanumérico(s)

```php
<?php

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Alnum;

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

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Alpha;

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

```
mínimo <= valor <= máximo
```

```php
<?php

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Between;

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
By using [Phalcon\Filter\Validation\Validator\Callback](api/Phalcon_Validation_Validator_Callback) you can execute custom function which must return boolean or new validator class which will be used to validate the same field. Al devolver `true` la validación será exitosa, al devolver `false` significará que la validación ha fallado. When executing this validator Phalcon will pass data depending on what it is - if it's an entity (i.e. a model, a `stdClass` etc.) then entity will be passed, otherwise data (i.e an array like `$_POST`). Aquí un ejemplo:

```php
<?php

use \Phalcon\Filter\Validation;
use \Phalcon\Filter\Validation\Validator\Callback;
use \Phalcon\Filter\Validation\Validator\PresenceOf;

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

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Callback;
use Phalcon\Filter\Validation\Validator\Numericality;

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

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Confirmation;

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

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\CreditCard;

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

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Date as DateValidator;

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

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Digit;

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

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Email;

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

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\ExclusionIn;

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

### Archivo
Verifica si un valor tiene un archivo correcto

```php
<?php

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\File;

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

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\File\MimeType;

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

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\File\Resolution\Equal;

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

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\File\Resolution\Max;

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

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\File\Resolution\Min;

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

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\File\Size;

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

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\File\Size;

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

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\File\Size;

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

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Identical;

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

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\InclusionIn;

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

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Ip;

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

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Numericality;

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
Validates whether a field is present

```php
<?php

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\PresenceOf;

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

### Expresión Regular
Valida un campo basado en un patrón de expresión regular.

```php
<?php

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Regex;

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

```
mínimo <= tamaño de cadena <= máximo
```

Este validador funciona como un contenedor.

```php
<?php

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\StringLength;

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

```
tamaño de cadena <= máximo
```

```php
<?php

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\StringLength\Max;

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

```
mínimo <= tamaño de cadena 
```

```php
<?php

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\StringLength\Min;

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
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Uniqueness;

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
Checks if a value has an url format

```php
<?php

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Url;

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

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Url;

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
You can create your own validators by implementing the [Phalcon\Filter\Validation\ValidatorInterface][validation-validatorinterface] or [Phalcon\Filter\Validation\Validator\CompositeInterface][validation-validatorcompositeinterface]. You can also extend the [Phalcon\Filter\Validation\AbstractCombinedFieldsValidator][validation-abstractcombinedfieldsvalidator], [Phalcon\Filter\Validation\AbstractValidator][validation-abstractvalidator] or [Phalcon\Filter\Validation\AbstractValidatorComposite][validation-abstractvalidatorcomposite].

```php
<?php

use Phalcon\Messages\Message;
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\AbstractValidator;

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
[Phalcon\Filter\Validation][validation] utilizes the [Phalcon\Messages\Messages][messages-messages] collection, providing a flexible way to output or store the validation messages generated during the validation processes.

Each message consists of an instance of the class [Phalcon\Messages\Message][messages-message]. El conjunto de mensajes generados se puede recuperar con el método `getMessages()`. Cada mensaje proporciona información detallada como el campo que ha generado el mensaje o el tipo de mensaje:

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

use Phalcon\Filter\Validation\Validator\Email;

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

use Phalcon\Filter\Validation;

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

Filtering and sanitizing is performed using the [filter](filter-filter) component. Puede añadir más filtros a este componente o usar los ya integrados.

## Eventos
Cuando los validadores se organizan en clases, puede implementar los métodos `beforeValidation()` y `afterValidation()` para realizar comprobaciones adicionales, filtros, limpieza, etc. Si el método `beforeValidation()` devuelve `false` la validación se cancela automáticamente:

```php
<?php

use Phalcon\Http\Request;
use Phalcon\Messages\Message;
use Phalcon\Filter\Validation;

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
By default, all validators assigned to a field are tested regardless if one of them have failed or not. Puede cambiar este comportamiento indicando al componente de validación qué validador puede parar la validación:

```php
<?php

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Regex;
use Phalcon\Filter\Validation\Validator\PresenceOf;

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

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Message;
use Phalcon\Filter\Validation\Validator;

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

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Regex;

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

use Phalcon\Filter\Validation;

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
Any exceptions thrown in the `Phalcon\Filter\Validation` namespace will be of type [Phalcon\Filter\Validation\Exception][validation-exception] or [Phalcon\Filter\Validation\Validator\Exception][validation-validator-exception]. Puede usar esta excepción para capturar selectivamente sólo las excepciones lanzadas desde este componente.

```php
<?php

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Exception;
use Phalcon\Filter\Validation\Validator\InclusionIn;

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


[messages-message]: api/phalcon_messages#messages-message
[messages-messages]: api/phalcon_messages#messages-messages
[validation]: api/phalcon_filter#filter-validation
[validation-abstractcombinedfieldsvalidator]: api/phalcon_filter#filter-validation-abstractcombinedfieldsvalidator
[validation-abstractvalidator]: api/phalcon_filter#filter-validation-abstractvalidator
[validation-abstractvalidatorcomposite]: api/phalcon_filter#filter-validation-abstractvalidatorcomposite
[validation-exception]: api/phalcon_filter#filter-validation-exception
[validation-validator-alnum]: api/phalcon_filter#filter-validation-validator-alnum
[validation-validator-alpha]: api/phalcon_filter#filter-validation-validator-alpha
[validation-validator-between]: api/phalcon_filter#filter-validation-validator-between
[validation-validator-callback]: api/phalcon_filter#filter-validation-validator-callback
[validation-validator-confirmation]: api/phalcon_filter#filter-validation-validator-confirmation
[validation-validator-creditcard]: api/phalcon_filter#filter-validation-validator-creditcard
[validation-validator-date]: api/phalcon_filter#filter-validation-validator-date
[validation-validator-digit]: api/phalcon_filter#filter-validation-validator-digit
[validation-validator-email]: api/phalcon_filter#filter-validation-validator-email
[validation-validator-exception]: api/phalcon_filter#filter-validation-validator-exception
[validation-validator-exclusionin]: api/phalcon_filter#filter-validation-validator-exclusionin
[validation-validator-file]: api/phalcon_filter#filter-validation-validator-file
[validation-validator-file-mimetype]: api/phalcon_filter#filter-validation-validator-file-mimetype
[validation-validator-file-resolution-equal]: api/phalcon_filter#filter-validation-validator-file-resolution-equal
[validation-validator-file-resolution-max]: api/phalcon_filter#filter-validation-validator-file-resolution-max
[validation-validator-file-resolution-min]: api/phalcon_filter#filter-validation-validator-file-resolution-min
[validation-validator-file-size-equal]: api/phalcon_filter#filter-validation-validator-file-size-equal
[validation-validator-file-size-max]: api/phalcon_filter#filter-validation-validator-file-size-max
[validation-validator-file-size-min]: api/phalcon_filter#filter-validation-validator-file-size-min
[validation-validator-identical]: api/phalcon_filter#filter-validation-validator-identical
[validation-validator-inclusionin]: api/phalcon_filter#filter-validation-validator-inclusionin
[validation-validator-ip]: api/phalcon_filter#filter-validation-validator-ip
[validation-validator-numericality]: api/phalcon_filter#filter-validation-validator-numericality
[validation-validator-presenceof]: api/phalcon_filter#filter-validation-validator-presenceof
[validation-validator-regex]: api/phalcon_filter#filter-validation-validator-regex
[validation-validator-stringlength]: api/phalcon_filter#filter-validation-validator-stringlength
[validation-validator-stringlength-max]: api/phalcon_filter#filter-validation-validator-stringlength-max
[validation-validator-stringlength-min]: api/phalcon_filter#filter-validation-validator-stringlength-min
[validation-validator-uniqueness]: api/phalcon_filter#filter-validation-validator-uniqueness
[validation-validator-url]: api/phalcon_filter#filter-validation-validator-url
[validation-validatorcompositeinterface]: api/phalcon_filter#filter-validation-validatorcompositeinterface
[validation-validatorinterface]: api/phalcon_filter#filter-validation-validatorinterface
