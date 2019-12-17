---
layout: default
language: 'ko-kr'
version: '4.0'
title: '유효성 검사'
keywords: 'validation, validating forms, validating models, validating data'
---

# Validation Component

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## 개요

[Phalcon\Validation](api/phalcon_validation#validation) is an independent validation component that validates an arbitrary set of data. This component can be used to implement validation rules on data objects that do not belong to a model or collection.

The following example shows its basic usage:

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

The loosely-coupled design of this component allows you to create your own validators along with the ones provided by the framework.

## Methods

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

Adds a validator to a field

```php
public function appendMessage(
    MessageInterface $message
): ValidationInterface
```

Appends a message to the messages list

```php
public function bind(
    object $entity, 
    array | object $$data
): ValidationInterface
```

Assigns the data to an entity. The entity is used to obtain the validation values

```php
public function getEntity(): object
```

Returns the bound entity

```php
public function getFilters(
    string $field = null
): mixed | null
```

Returns all the filters or a specific one

```php
public function getLabel(
    string $field
): string
```

Get label for field

```php
public function getMessages(): Messages
```

Returns the registered validators

```php
public function getValidators(): array
```

Returns the validators added to the validation

```php
public function getValue(
    string $field
): mixed | null
```

Gets the a value to validate in the array/object data source

```php
public function rule(
    mixed $field, 
    ValidatorInterface $validator
): ValidationInterface
```

Alias of `add` method

```php
public function rules(
    mixed $field, 
    array $validators
): ValidationInterface
```

Adds the validators to a field

```php
public function setEntity(
    object $entity
): void
```

Sets the bound entity

```php
public function setFilters(
    string $field, 
    array | string $filters
): ValidationInterface
```

Adds filters to the field

```php
public function setLabels(
    array $labels
): void
```

Adds labels for fields

```php
public function validate(
    array | object $data = null, 
    object $entity = null
): Messages
```

Validate a set of data according to a set of rules

## Activation

Validation chains can be initialized in a direct manner by just adding validators to the [Phalcon\Validation](api/phalcon_validation#validation) object. You can put your validations in a separate file for better code reuse and organization.

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

## 검사기

Phalcon offers a set of built-in validators for this component:

| Class                                                                                                                        | Validates                  |
| ---------------------------------------------------------------------------------------------------------------------------- | -------------------------- |
| [Phalcon\Validation\Validator\Alnum](api/phalcon_validation#validation-validator-alnum)                                   | Alphanumeric character(s)  |
| [Phalcon\Validation\Validator\Alpha](api/phalcon_validation#validation-validator-alpha)                                   | Alphabet character(s).     |
| [Phalcon\Validation\Validator\Between](api/phalcon_validation#validation-validator-between)                               | Between two values         |
| [Phalcon\Validation\Validator\Callback](api/phalcon_validation#validation-validator-callback)                             | Callback function          |
| [Phalcon\Validation\Validator\Confirmation](api/phalcon_validation#validation-validator-confirmation)                     | Identical field values     |
| [Phalcon\Validation\Validator\CreditCard](api/phalcon_validation#validation-validator-creditcard)                         | Credit card number         |
| [Phalcon\Validation\Validator\Date](api/phalcon_validation#validation-validator-date)                                     | Date.                      |
| [Phalcon\Validation\Validator\Digit](api/phalcon_validation#validation-validator-digit)                                   | Numeric character(s).      |
| [Phalcon\Validation\Validator\Email](api/phalcon_validation#validation-validator-email)                                   | Email                      |
| [Phalcon\Validation\Validator\ExclusionIn](api/phalcon_validation#validation-validator-exclusionin)                       | Not within value set       |
| [Phalcon\Validation\Validator\File](api/phalcon_validation#validation-validator-file)                                     | File                       |
| [Phalcon\Validation\Validator\File\MimeType](api/phalcon_validation#validation-validator-file-mimetype)                  | Mimetype File              |
| [Phalcon\Validation\Validator\File\Resolution\Equal](api/phalcon_validation#validation-validator-file-resolution-equal) | Equal resolution of File   |
| [Phalcon\Validation\Validator\File\Resolution\Max](api/phalcon_validation#validation-validator-file-resolution-max)     | Minimum resolution of File |
| [Phalcon\Validation\Validator\File\Resolution\Min](api/phalcon_validation#validation-validator-file-resolution-min)     | Maximum resolution of File |
| [Phalcon\Validation\Validator\File\Size\Equal](api/phalcon_validation#validation-validator-file-size-equal)             | Equal File Size            |
| [Phalcon\Validation\Validator\File\Size\Max](api/phalcon_validation#validation-validator-file-size-max)                 | Maximum File Size          |
| [Phalcon\Validation\Validator\File\Size\Min](api/phalcon_validation#validation-validator-file-size-min)                 | Minimum File Size          |
| [Phalcon\Validation\Validator\Identical](api/phalcon_validation#validation-validator-identical)                           | Equal specific value       |
| [Phalcon\Validation\Validator\InclusionIn](api/phalcon_validation#validation-validator-inclusionin)                       | Within value set           |
| [Phalcon\Validation\Validator\Ip](api/phalcon_validation#validation-validator-ip)                                         | IP                         |
| [Phalcon\Validation\Validator\Numericality](api/phalcon_validation#validation-validator-numericality)                     | Numeric Value              |
| [Phalcon\Validation\Validator\PresenceOf](api/phalcon_validation#validation-validator-presenceof)                         | Not `null` or empty        |
| [Phalcon\Validation\Validator\Regex](api/phalcon_validation#validation-validator-regex)                                   | Regex                      |
| [Phalcon\Validation\Validator\StringLength](api/phalcon_validation#validation-validator-stringlength)                     | Length                     |
| [Phalcon\Validation\Validator\StringLength\Max](api/phalcon_validation#validation-validator-stringlength-max)            | Maximum Length             |
| [Phalcon\Validation\Validator\StringLength\Min](api/phalcon_validation#validation-validator-stringlength-min)            | Minimum Length             |
| [Phalcon\Validation\Validator\Uniqueness](api/phalcon_validation#validation-validator-uniqueness)                         | Unique in Model            |
| [Phalcon\Validation\Validator\Url](api/phalcon_validation#validation-validator-url)                                       | URL                        |

### Alnum

Check for alphanumeric character(s)

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

Check for alphabetic character(s)

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

Validates that a value is between an inclusive range of two values. The validation passes if for a value `L`, minimum is less or equal than `L` and `L` less than equal than the maximum. The boundaries are included in this validation. The formula is:

    minimum <= value <= maximum
    

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

Checks that two values have the same value

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

Checks if a value has a valid credit card number

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

Checks if a value is a valid date

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

Check for numeric character(s)

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

Checks if a value has a correct e-mail format

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

Check if a value is not included into a list of values

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

Checks if a value has a correct file

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

Checks if a value has a correct file mime type

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

Checks if a file has the right resolution

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

Checks if a file has the rigth resolution

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

Checks if a file has the rigth resolution

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

Checks if a value has a correct file

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\File\Size;

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

Checks if a value has a correct file

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\File\Size;

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

Checks if a value has a correct file

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\File\Size;

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

Checks if a value is identical to other

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

Check if a value is included into a list of values

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

Check for IP addresses

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

Check for a valid numeric value

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

Validates a field based on a regex pattern.

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

Validates that a string has the specified maximum and minimum constraints. The validation passes if for a string length `L`, minimum is less or equal than `L` and `L` is less or equal than the maximum. The boundaries are included in this validation. The formula is:

    minimum <= string length <= maximum
    

This validator works like a container.

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

Validates that a string has the specified maximum constraints. The validation passes if for a string length `L` it is less or equal than the maximum. The formula is:

    string length <= maximum
    

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

Validates that a string has the specified minimum constraints. The validation passes if for a string length `L` it is more or equal than the minimum. The formula is:

    minimum <= string length 
    

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

Check that a field is unique in the related table

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

Different attribute from the field:

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

In the model:

```php
<?php

$validator->add(
    "cst_email",
    new Uniqueness()
);
```

Combination of fields in model:

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

It is possible to convert values before validation. This is useful in situations where values need to be converted for the database lookup:

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

### Url

Checks if a value has a url format

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

You can also pass the `flags` option in the array, defining `FILTER_FLAG_PATH_REQUIRED` or `FILTER_FLAG_QUERY_REQUIRED` if necessary.

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

### Custom Validators

You can create your own validators by implementing the [Phalcon\Validation\ValidatorInterface](api/phalcon_validation#validation-validatorinterface) or [Phalcon\Validation\Validator\CompositeInterface](api/phalcon_validation#validation-validatorcompositeinterface). You can also extend the [Phalcon\Validation\AbstractCombinedFieldsValidator](api/phalcon_validation#validation-abstractcombinedfieldsvalidator), [Phalcon\Validation\AbstractValidator](api/phalcon_validation#validation-abstractvalidator) or [Phalcon\Validation\AbstractValidatorComposite](api/phalcon_validation#validation-abstractvalidatorcomposite).

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

It is important that validators return a valid `boolean` value indicating if the validation was successful or not.

## Messages

[Phalcon\Validation](api/phalcon_validation#validation) utilizes the [Phalcon\Messages\Messages](api/phalcon_messages#messages-messages) collection, providing a flexible way to output or store the validation messages generated during the validation processes.

Each message consists of an instance of the class [Phalcon\Messages\Message](api/phalcon_messages#messages-message). The set of messages generated can be retrieved with the `getMessages()` method. Each message provides extended information such as the field that generated the message or the message type:

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

You can pass a `message` parameter to change/translate the default message in each validator. You can also use the placeholder `:field` in the message to be replaced by the label of the field:

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

By default, the `getMessages()` method returns all the messages generated during validation. You can filter messages for a specific field using the `filter()` method:

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

## Filtering of Data

Data can be filtered prior to the validation ensuring that malicious or incorrect data is not validated.

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

Filtering and sanitizing is performed using the <filter> component. You can add more filters to this component or use the built-in ones.

## 이벤트

When validations are organized in classes, you can implement the `beforeValidation()` and `afterValidation()` methods to perform additional checks, filters, clean-up, etc. If the `beforeValidation()` method returns false the validation is automatically cancelled:

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

## Cancelling Validations

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

The first validator has the option `cancelOnFail` with a value of `true`, therefore if that validator fails the remaining validators in the chain are not executed.

If you are creating custom validators you can dynamically stop the validation chain by setting the `cancelOnFail` option:

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

## Empty Values

You can pass the option `allowEmpty` to any of the built-in validators to ignore empty values.

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

## Recursive Validation

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

## Exceptions

Any exceptions thrown in the `Phalcon\Validator` namespace will be of type [Phalcon\Validation\Exception](api/phalcon_validation#validation-exception) or [Phalcon\Validation\Validator\Exception](api/phalcon_validation#validation-validator-exception). You can use this exception to selectively catch exceptions thrown only from this component.

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