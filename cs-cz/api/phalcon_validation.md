---
layout: default
language: 'cs-cz'
version: '4.0'
title: 'Phalcon\Validation'
---

* [Phalcon\Validation](#validation)
* [Phalcon\Validation\AbstractCombinedFieldsValidator](#validation-abstractcombinedfieldsvalidator)
* [Phalcon\Validation\AbstractValidator](#validation-abstractvalidator)
* [Phalcon\Validation\AbstractValidatorComposite](#validation-abstractvalidatorcomposite)
* [Phalcon\Validation\Exception](#validation-exception)
* [Phalcon\Validation\ValidationInterface](#validation-validationinterface)
* [Phalcon\Validation\Validator\Alnum](#validation-validator-alnum)
* [Phalcon\Validation\Validator\Alpha](#validation-validator-alpha)
* [Phalcon\Validation\Validator\Between](#validation-validator-between)
* [Phalcon\Validation\Validator\Callback](#validation-validator-callback)
* [Phalcon\Validation\Validator\Confirmation](#validation-validator-confirmation)
* [Phalcon\Validation\Validator\CreditCard](#validation-validator-creditcard)
* [Phalcon\Validation\Validator\Date](#validation-validator-date)
* [Phalcon\Validation\Validator\Digit](#validation-validator-digit)
* [Phalcon\Validation\Validator\Email](#validation-validator-email)
* [Phalcon\Validation\Validator\Exception](#validation-validator-exception)
* [Phalcon\Validation\Validator\ExclusionIn](#validation-validator-exclusionin)
* [Phalcon\Validation\Validator\File](#validation-validator-file)
* [Phalcon\Validation\Validator\File\AbstractFile](#validation-validator-file-abstractfile)
* [Phalcon\Validation\Validator\File\MimeType](#validation-validator-file-mimetype)
* [Phalcon\Validation\Validator\File\Resolution\Equal](#validation-validator-file-resolution-equal)
* [Phalcon\Validation\Validator\File\Resolution\Max](#validation-validator-file-resolution-max)
* [Phalcon\Validation\Validator\File\Resolution\Min](#validation-validator-file-resolution-min)
* [Phalcon\Validation\Validator\File\Size\Equal](#validation-validator-file-size-equal)
* [Phalcon\Validation\Validator\File\Size\Max](#validation-validator-file-size-max)
* [Phalcon\Validation\Validator\File\Size\Min](#validation-validator-file-size-min)
* [Phalcon\Validation\Validator\Identical](#validation-validator-identical)
* [Phalcon\Validation\Validator\InclusionIn](#validation-validator-inclusionin)
* [Phalcon\Validation\Validator\Ip](#validation-validator-ip)
* [Phalcon\Validation\Validator\Numericality](#validation-validator-numericality)
* [Phalcon\Validation\Validator\PresenceOf](#validation-validator-presenceof)
* [Phalcon\Validation\Validator\Regex](#validation-validator-regex)
* [Phalcon\Validation\Validator\StringLength](#validation-validator-stringlength)
* [Phalcon\Validation\Validator\StringLength\Max](#validation-validator-stringlength-max)
* [Phalcon\Validation\Validator\StringLength\Min](#validation-validator-stringlength-min)
* [Phalcon\Validation\Validator\Uniqueness](#validation-validator-uniqueness)
* [Phalcon\Validation\Validator\Url](#validation-validator-url)
* [Phalcon\Validation\ValidatorCompositeInterface](#validation-validatorcompositeinterface)
* [Phalcon\Validation\ValidatorFactory](#validation-validatorfactory)
* [Phalcon\Validation\ValidatorInterface](#validation-validatorinterface)

<h1 id="validation">Class Phalcon\Validation</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation.zep)

| Namespace | Phalcon | | Uses | Phalcon\Di\DiInterface, Phalcon\Di\Injectable, Phalcon\Filter\FilterInterface, Phalcon\Messages\MessageInterface, Phalcon\Messages\Messages, Phalcon\Validation\ValidationInterface, Phalcon\Validation\Exception, Phalcon\Validation\ValidatorInterface, Phalcon\Validation\AbstractCombinedFieldsValidator | | Extends | Injectable | | Implements | ValidationInterface |

Allows to validate data using custom or built-in validators

## Properties

```php
//
protected combinedFieldsValidators;

//
protected data;

//
protected entity;

//
protected filters;

//
protected labels;

//
protected messages;

//
protected validators;

//
protected values;

```

## Methods

Phalcon\Validation constructor

```php
public function __construct( array $validators = [] );
```

Adds a validator to a field

```php
public function add( mixed $field, ValidatorInterface $validator ): ValidationInterface;
```

Appends a message to the messages list

```php
public function appendMessage( MessageInterface $message ): ValidationInterface;
```

Assigns the data to an entity The entity is used to obtain the validation values

```php
public function bind( mixed $entity, mixed $data ): ValidationInterface;
```

```php
public function getData()
```

Returns the bound entity

```php
public function getEntity(): object;
```

Returns all the filters or a specific one

```php
public function getFilters( string $field = null ): mixed | null;
```

Get label for field

```php
public function getLabel( mixed $field ): string;
```

Returns the registered validators

```php
public function getMessages(): Messages;
```

Returns the validators added to the validation

```php
public function getValidators(): array;
```

Gets the a value to validate in the array/object data source

```php
public function getValue( string $field ): mixed | null;
```

Alias of `add` method

```php
public function rule( mixed $field, ValidatorInterface $validator ): ValidationInterface;
```

Adds the validators to a field

```php
public function rules( mixed $field, array $validators ): ValidationInterface;
```

Sets the bound entity

```php
public function setEntity( mixed $entity ): void;
```

Adds filters to the field

```php
public function setFilters( mixed $field, mixed $filters ): ValidationInterface;
```

Adds labels for fields

```php
public function setLabels( array $labels ): void;
```

```php
public function setValidators( $validators )
```

Validate a set of data according to a set of rules

```php
public function validate( mixed $data = null, mixed $entity = null ): Messages;
```

Internal validations, if it returns true, then skip the current validator

```php
protected function preChecking( mixed $field, ValidatorInterface $validator ): bool;
```

<h1 id="validation-abstractcombinedfieldsvalidator">Abstract Class Phalcon\Validation\AbstractCombinedFieldsValidator</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/AbstractCombinedFieldsValidator.zep)

| Namespace | Phalcon\Validation | | Extends | AbstractValidator |

This is a base class for combined fields validators

<h1 id="validation-abstractvalidator">Abstract Class Phalcon\Validation\AbstractValidator</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/AbstractValidator.zep)

| Namespace | Phalcon\Validation | | Uses | Phalcon\Collection, Phalcon\Helper\Arr, Phalcon\Messages\Message, Phalcon\Validation | | Implements | ValidatorInterface |

This is a base class for validators

## Properties

```php
/**
    * Message template
    *
    * @var string|null
    */
protected template;

/**
    * Message templates
    *
    * @var array
    */
protected templates;

//
protected options;

```

## Methods

Phalcon\Validation\Validator constructor

```php
public function __construct( array $options = [] );
```

Returns an option in the validator's options Returns null if the option hasn't set

```php
public function getOption( string $key, mixed $defaultValue = null ): mixed;
```

Get the template message

```php
public function getTemplate( string $field = null ): string;
```

Get templates collection object

```php
public function getTemplates(): array;
```

Checks if an option is defined

```php
public function hasOption( string $key ): bool;
```

Create a default message by factory

```php
public function messageFactory( Validation $validation, mixed $field, array $replacements = [] ): Message;
```

Sets an option in the validator

```php
public function setOption( string $key, mixed $value ): void;
```

Set a new template message

```php
public function setTemplate( string $template ): ValidatorInterface;
```

Clear current templates and set new from an array,

```php
public function setTemplates( array $templates ): ValidatorInterface;
```

Executes the validation

```php
abstract public function validate( Validation $validation, mixed $field ): bool;
```

Prepares a validation code.

```php
protected function prepareCode( string $field ): int | null;
```

Prepares a label for the field.

```php
protected function prepareLabel( Validation $validation, string $field ): mixed;
```

<h1 id="validation-abstractvalidatorcomposite">Abstract Class Phalcon\Validation\AbstractValidatorComposite</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/AbstractValidatorComposite.zep)

| Namespace | Phalcon\Validation | | Uses | Phalcon\Validation | | Extends | AbstractValidator | | Implements | ValidatorCompositeInterface |

This is a base class for combined fields validators

## Properties

```php
/**
 * @var array
 */
protected validators;

```

## Methods

```php
public function getValidators(): array
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

<h1 id="validation-exception">Class Phalcon\Validation\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Exception.zep)

| Namespace | Phalcon\Validation | | Extends | \Phalcon\Exception |

Exceptions thrown in Phalcon\Validation\* classes will use this class

<h1 id="validation-validationinterface">Interface Phalcon\Validation\ValidationInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/ValidationInterface.zep)

| Namespace | Phalcon\Validation | | Uses | Phalcon\Di\Injectable, Phalcon\Messages\MessageInterface, Phalcon\Messages\Messages |

Interface for the Phalcon\Validation component

## Methods

Adds a validator to a field

```php
public function add( string $field, ValidatorInterface $validator ): ValidationInterface;
```

Appends a message to the messages list

```php
public function appendMessage( MessageInterface $message ): ValidationInterface;
```

Assigns the data to an entity The entity is used to obtain the validation values

```php
public function bind( mixed $entity, mixed $data ): ValidationInterface;
```

Returns the bound entity

```php
public function getEntity(): object;
```

Returns all the filters or a specific one

```php
public function getFilters( string $field = null ): mixed | null;
```

Get label for field

```php
public function getLabel( string $field ): string;
```

Returns the registered validators

```php
public function getMessages(): Messages;
```

Returns the validators added to the validation

```php
public function getValidators(): array;
```

Gets the a value to validate in the array/object data source

```php
public function getValue( string $field ): mixed | null;
```

Alias of `add` method

```php
public function rule( string $field, ValidatorInterface $validator ): ValidationInterface;
```

Adds the validators to a field

```php
public function rules( string $field, array $validators ): ValidationInterface;
```

Adds filters to the field

```php
public function setFilters( string $field, mixed $filters ): ValidationInterface;
```

Adds labels for fields

```php
public function setLabels( array $labels ): void;
```

Validate a set of data according to a set of rules

```php
public function validate( mixed $data = null, mixed $entity = null ): Messages;
```

<h1 id="validation-validator-alnum">Class Phalcon\Validation\Validator\Alnum</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/Alnum.zep)

| Namespace | Phalcon\Validation\Validator | | Uses | Phalcon\Validation, Phalcon\Validation\AbstractValidator | | Extends | AbstractValidator |

Check for alphanumeric character(s)

```php
use Phalcon\Validation;
use Phalcon\Validation\Validator\Alnum as AlnumValidator;

$validator = new Validation();

$validator->add(
    "username",
    new AlnumValidator(
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
    new AlnumValidator(
        [
            "message" => [
                "username" => "username must contain only alphanumeric characters",
                "name"     => "name must contain only alphanumeric characters",
            ],
        ]
    )
);
```

## Properties

```php
//
protected template = Field :field must contain only letters and numbers;

```

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

<h1 id="validation-validator-alpha">Class Phalcon\Validation\Validator\Alpha</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/Alpha.zep)

| Namespace | Phalcon\Validation\Validator | | Uses | Phalcon\Messages\Message, Phalcon\Validation, Phalcon\Validation\AbstractValidator | | Extends | AbstractValidator |

Check for alphabetic character(s)

```php
use Phalcon\Validation;
use Phalcon\Validation\Validator\Alpha as AlphaValidator;

$validator = new Validation();

$validator->add(
    "username",
    new AlphaValidator(
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
    new AlphaValidator(
        [
            "message" => [
                "username" => "username must contain only letters",
                "name"     => "name must contain only letters",
            ],
        ]
    )
);
```

## Properties

```php
//
protected template = Field :field must contain only letters;

```

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

<h1 id="validation-validator-between">Class Phalcon\Validation\Validator\Between</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/Between.zep)

| Namespace | Phalcon\Validation\Validator | | Uses | Phalcon\Messages\Message, Phalcon\Validation, Phalcon\Validation\AbstractValidator | | Extends | AbstractValidator |

Validates that a value is between an inclusive range of two values. For a value x, the test is passed if minimum<=x<=maximum.

```php
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

## Properties

```php
//
protected template = Field :field must be within the range of :min to :max;

```

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

<h1 id="validation-validator-callback">Class Phalcon\Validation\Validator\Callback</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/Callback.zep)

| Namespace | Phalcon\Validation\Validator | | Uses | Phalcon\Messages\Message, Phalcon\Validation, Phalcon\Validation\ValidatorInterface, Phalcon\Validation\AbstractValidator | | Extends | AbstractValidator |

Calls user function for validation

```php
use Phalcon\Validation;
use Phalcon\Validation\Validator\Callback as CallbackValidator;
use Phalcon\Validation\Validator\Numericality as NumericalityValidator;

$validator = new Validation();

$validator->add(
    ["user", "admin"],
    new CallbackValidator(
        [
            "message" => "There must be only an user or admin set",
            "callback" => function($data) {
                if (!empty($data->getUser()) && !empty($data->getAdmin())) {
                    return false;
                }

                return true;
            }
        ]
    )
);

$validator->add(
    "amount",
    new CallbackValidator(
        [
            "callback" => function($data) {
                if (!empty($data->getProduct())) {
                    return new NumericalityValidator(
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

## Properties

```php
//
protected template = Field :field must match the callback function;

```

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

<h1 id="validation-validator-confirmation">Class Phalcon\Validation\Validator\Confirmation</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/Confirmation.zep)

| Namespace | Phalcon\Validation\Validator | | Uses | Phalcon\Messages\Message, Phalcon\Validation, Phalcon\Validation\Exception, Phalcon\Validation\AbstractValidator | | Extends | AbstractValidator |

Checks that two values have the same value

```php
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

## Properties

```php
//
protected template = Field :field must be the same as :with;

```

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

Compare strings

```php
final protected function compare( string $a, string $b ): bool;
```

<h1 id="validation-validator-creditcard">Class Phalcon\Validation\Validator\CreditCard</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/CreditCard.zep)

| Namespace | Phalcon\Validation\Validator | | Uses | Phalcon\Messages\Message, Phalcon\Validation, Phalcon\Validation\AbstractValidator | | Extends | AbstractValidator |

Checks if a value has a valid credit card number

```php
use Phalcon\Validation;
use Phalcon\Validation\Validator\CreditCard as CreditCardValidator;

$validator = new Validation();

$validator->add(
    "creditCard",
    new CreditCardValidator(
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
    new CreditCardValidator(
        [
            "message" => [
                "creditCard"       => "The credit card number is not valid",
                "secondCreditCard" => "The second credit card number is not valid",
            ],
        ]
    )
);
```

## Properties

```php
//
protected template = Field :field is not valid for a credit card number;

```

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

<h1 id="validation-validator-date">Class Phalcon\Validation\Validator\Date</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/Date.zep)

| Namespace | Phalcon\Validation\Validator | | Uses | DateTime, Phalcon\Messages\Message, Phalcon\Validation, Phalcon\Validation\AbstractValidator | | Extends | AbstractValidator |

Checks if a value is a valid date

```php
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

## Properties

```php
//
protected template = Field :field is not a valid date;

```

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

<h1 id="validation-validator-digit">Class Phalcon\Validation\Validator\Digit</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/Digit.zep)

| Namespace | Phalcon\Validation\Validator | | Uses | Phalcon\Messages\Message, Phalcon\Validation, Phalcon\Validation\AbstractValidator | | Extends | AbstractValidator |

Check for numeric character(s)

```php
use Phalcon\Validation;
use Phalcon\Validation\Validator\Digit as DigitValidator;

$validator = new Validation();

$validator->add(
    "height",
    new DigitValidator(
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
    new DigitValidator(
        [
            "message" => [
                "height" => "height must be numeric",
                "width"  => "width must be numeric",
            ],
        ]
    )
);
```

## Properties

```php
//
protected template = Field :field must be numeric;

```

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

<h1 id="validation-validator-email">Class Phalcon\Validation\Validator\Email</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/Email.zep)

| Namespace | Phalcon\Validation\Validator | | Uses | Phalcon\Messages\Message, Phalcon\Validation, Phalcon\Validation\AbstractValidator | | Extends | AbstractValidator |

Checks if a value has a correct e-mail format

```php
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;

$validator = new Validation();

$validator->add(
    "email",
    new EmailValidator(
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
    new EmailValidator(
        [
            "message" => [
                "email"        => "The e-mail is not valid",
                "anotherEmail" => "The another e-mail is not valid",
            ],
        ]
    )
);
```

## Properties

```php
//
protected template = Field :field must be an email address;

```

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

<h1 id="validation-validator-exception">Class Phalcon\Validation\Validator\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/Exception.zep)

| Namespace | Phalcon\Validation\Validator | | Extends | \Phalcon\Exception |

Exceptions thrown in Phalcon\Validation\Validator\* classes will use this class

<h1 id="validation-validator-exclusionin">Class Phalcon\Validation\Validator\ExclusionIn</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/ExclusionIn.zep)

| Namespace | Phalcon\Validation\Validator | | Uses | Phalcon\Messages\Message, Phalcon\Validation, Phalcon\Validation\AbstractValidator, Phalcon\Validation\Exception | | Extends | AbstractValidator |

Check if a value is not included into a list of values

```php
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

## Properties

```php
//
protected template = Field :field must not be a part of list: :domain;

```

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

<h1 id="validation-validator-file">Class Phalcon\Validation\Validator\File</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/File.zep)

| Namespace | Phalcon\Validation\Validator | | Uses | Phalcon\Helper\Arr, Phalcon\Messages\Message, Phalcon\Validation, Phalcon\Validation\AbstractValidatorComposite, Phalcon\Validation\Validator\File\MimeType, Phalcon\Validation\Validator\File\Resolution\Equal, Phalcon\Validation\Validator\File\Resolution\Max, Phalcon\Validation\Validator\File\Resolution\Min, Phalcon\Validation\Validator\File\Size\Equal, Phalcon\Validation\Validator\File\Size\Max, Phalcon\Validation\Validator\File\Size\Min | | Extends | AbstractValidatorComposite |

Checks if a value has a correct file

```php
use Phalcon\Validation;
use Phalcon\Validation\Validator\File as FileValidator;

$validator = new Validation();

$validator->add(
    "file",
    new FileValidator(
        [
            "maxSize"              => "2M",
            "messageSize"          => ":field exceeds the max file size (:size)",
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
    new FileValidator(
        [
            "maxSize" => [
                "file"        => "2M",
                "anotherFile" => "4M",
            ],
            "messageSize" => [
                "file"        => "file exceeds the max file size 2M",
                "anotherFile" => "anotherFile exceeds the max file size 4M",
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

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

<h1 id="validation-validator-file-abstractfile">Abstract Class Phalcon\Validation\Validator\File\AbstractFile</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/File/AbstractFile.zep)

| Namespace | Phalcon\Validation\Validator\File | | Uses | Phalcon\Messages\Message, Phalcon\Validation, Phalcon\Validation\AbstractValidator | | Extends | AbstractValidator |

Checks if a value has a correct file

```php
use Phalcon\Validation;
use Phalcon\Validation\Validator\File\Size;

$validator = new Validation();

$validator->add(
    "file",
    new Size(
        [
            "maxSize"              => "2M",
            "messageSize"          => ":field exceeds the max file size (:size)",
        ]
    )
);

$validator->add(
    [
        "file",
        "anotherFile",
    ],
    new FileValidator(
        [
            "maxSize" => [
                "file"        => "2M",
                "anotherFile" => "4M",
            ],
            "messageSize" => [
                "file"        => "file exceeds the max file size 2M",
                "anotherFile" => "anotherFile exceeds the max file size 4M",
            ],
        ]
    )
);
```

## Properties

```php
/**
    * Empty is empty
    */
protected messageFileEmpty = Field :field must not be empty;

/**
    * File exceeds the file size set in PHP configuration
    */
protected messageIniSize = File :field exceeds the maximum file size;

/**
    * File is not valid
    */
protected messageValid = Field :field is not valid;

```

## Methods

Check upload

```php
public function checkUpload( Validation $validation, mixed $field ): bool;
```

Check if upload is empty

```php
public function checkUploadIsEmpty( Validation $validation, mixed $field ): bool;
```

Check if upload is valid

```php
public function checkUploadIsValid( Validation $validation, mixed $field ): bool;
```

Check if uploaded file is larger than PHP allowed size

```php
public function checkUploadMaxSize( Validation $validation, mixed $field ): bool;
```

Convert a string like "2.5MB" in bytes

```php
public function getFileSizeInBytes( string $size ): double;
```

```php
public function getMessageFileEmpty()
```

```php
public function getMessageIniSize()
```

```php
public function getMessageValid()
```

Check on empty

```php
public function isAllowEmpty( Validation $validation, string $field ): bool;
```

```php
public function setMessageFileEmpty( $messageFileEmpty )
```

```php
public function setMessageIniSize( $messageIniSize )
```

```php
public function setMessageValid( $messageValid )
```

<h1 id="validation-validator-file-mimetype">Class Phalcon\Validation\Validator\File\MimeType</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/File/MimeType.zep)

| Namespace | Phalcon\Validation\Validator\File | | Uses | Phalcon\Messages\Message, Phalcon\Validation, Phalcon\Validation\Exception | | Extends | AbstractFile |

Checks if a value has a correct file mime type

```php
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

## Properties

```php
//
protected template = File :field must be of type: :types;

```

## Methods

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

<h1 id="validation-validator-file-resolution-equal">Class Phalcon\Validation\Validator\File\Resolution\Equal</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/File/Resolution/Equal.zep)

| Namespace | Phalcon\Validation\Validator\File\Resolution | | Uses | Phalcon\Messages\Message, Phalcon\Validation, Phalcon\Validation\Validator\File\AbstractFile | | Extends | AbstractFile |

Checks if a file has the right resolution

```php
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

## Properties

```php
//
protected template = The resolution of the field :field has to be equal :resolution;

```

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

<h1 id="validation-validator-file-resolution-max">Class Phalcon\Validation\Validator\File\Resolution\Max</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/File/Resolution/Max.zep)

| Namespace | Phalcon\Validation\Validator\File\Resolution | | Uses | Phalcon\Messages\Message, Phalcon\Validation, Phalcon\Validation\Validator\File\AbstractFile | | Extends | AbstractFile |

Checks if a file has the right resolution

```php
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

## Properties

```php
//
protected template = File :field exceeds the maximum resolution of :resolution;

```

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

<h1 id="validation-validator-file-resolution-min">Class Phalcon\Validation\Validator\File\Resolution\Min</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/File/Resolution/Min.zep)

| Namespace | Phalcon\Validation\Validator\File\Resolution | | Uses | Phalcon\Messages\Message, Phalcon\Validation, Phalcon\Validation\Validator\File\AbstractFile | | Extends | AbstractFile |

Checks if a file has the right resolution

```php
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

## Properties

```php
//
protected template = File :field can not have the minimum resolution of :resolution;

```

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

<h1 id="validation-validator-file-size-equal">Class Phalcon\Validation\Validator\File\Size\Equal</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/File/Size/Equal.zep)

| Namespace | Phalcon\Validation\Validator\File\Size | | Uses | Phalcon\Messages\Message, Phalcon\Validation, Phalcon\Validation\Validator\File\AbstractFile | | Extends | AbstractFile |

Checks if a value has a correct file

```php
use Phalcon\Validation;
use Phalcon\Validation\Validator\File\Size;

$validator = new Validation();

$validator->add(
    "file",
    new Equal(
        [
            "size"     => "2M",
            "included" => true,
            "message"  => ":field exceeds the equal file size (:size)",
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
                "file"        => "file does not have the right file size",
                "anotherFile" => "anotherFile wrong file size (4MB)",
            ],
        ]
    )
);
```

## Properties

```php
//
protected template = File :field does not have the exact :size file size;

```

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

<h1 id="validation-validator-file-size-max">Class Phalcon\Validation\Validator\File\Size\Max</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/File/Size/Max.zep)

| Namespace | Phalcon\Validation\Validator\File\Size | | Uses | Phalcon\Messages\Message, Phalcon\Validation, Phalcon\Validation\Validator\File\AbstractFile | | Extends | AbstractFile |

Checks if a value has a correct file

```php
use Phalcon\Validation;
use Phalcon\Validation\Validator\File\Size;

$validator = new Validation();

$validator->add(
    "file",
    new Max(
        [
            "size"     => "2M",
            "included" => true,
            "message"  => ":field exceeds the max file size (:size)",
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
                "file"        => "file exceeds the max file size 2M",
                "anotherFile" => "anotherFile exceeds the max file size 4M",
            ],
        ]
    )
);
```

## Properties

```php
//
protected template = File :field exceeds the size of :size;

```

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

<h1 id="validation-validator-file-size-min">Class Phalcon\Validation\Validator\File\Size\Min</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/File/Size/Min.zep)

| Namespace | Phalcon\Validation\Validator\File\Size | | Uses | Phalcon\Messages\Message, Phalcon\Validation, Phalcon\Validation\Validator\File\AbstractFile | | Extends | AbstractFile |

Checks if a value has a correct file

```php
use Phalcon\Validation;
use Phalcon\Validation\Validator\File\Size;

$validator = new Validation();

$validator->add(
    "file",
    new Min(
        [
            "size"     => "2M",
            "included" => true,
            "message"  => ":field exceeds the min file size (:size)",
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
                "file"        => "file exceeds the min file size 2M",
                "anotherFile" => "anotherFile exceeds the min file size 4M",
            ],
        ]
    )
);
```

## Properties

```php
//
protected template = File :field can not have the minimum size of :size;

```

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

<h1 id="validation-validator-identical">Class Phalcon\Validation\Validator\Identical</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/Identical.zep)

| Namespace | Phalcon\Validation\Validator | | Uses | Phalcon\Messages\Message, Phalcon\Validation, Phalcon\Validation\AbstractValidator | | Extends | AbstractValidator |

Checks if a value is identical to other

```php
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

## Properties

```php
//
protected template = Field :field does not have the expected value;

```

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

<h1 id="validation-validator-inclusionin">Class Phalcon\Validation\Validator\InclusionIn</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/InclusionIn.zep)

| Namespace | Phalcon\Validation\Validator | | Uses | Phalcon\Messages\Message, Phalcon\Validation, Phalcon\Validation\AbstractValidator, Phalcon\Validation\Exception | | Extends | AbstractValidator |

Check if a value is included into a list of values

```php
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

## Properties

```php
//
protected template = Field :field must be a part of list: :domain;

```

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

<h1 id="validation-validator-ip">Class Phalcon\Validation\Validator\Ip</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/Ip.zep)

| Namespace | Phalcon\Validation\Validator | | Uses | Phalcon\Validation, Phalcon\Validation\AbstractValidator, Phalcon\Messages\Message | | Extends | AbstractValidator |

Check for IP addresses

```php
use Phalcon\Validation\Validator\Ip as IpValidator;

$validator->add(
    "ip_address",
    new IpValidator(
        [
            "message"       => ":field must contain only ip addresses",
            "version"       => IP::VERSION_4 | IP::VERSION_6, // v6 and v4. The same if not specified
            "allowReserved" => false,   // False if not specified. Ignored for v6
            "allowPrivate"  => false,   // False if not specified
            "allowEmpty"    => false,
        ]
    )
);

$validator->add(
    [
        "source_address",
        "destination_address",
    ],
    new IpValidator(
        [
            "message" => [
                "source_address"      => "source_address must be a valid IP address",
                "destination_address" => "destination_address must be a valid IP address",
            ],
            "version" => [
                 "source_address"      => Ip::VERSION_4 | IP::VERSION_6,
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

## Constants

```php
const VERSION_4 = FILTER_FLAG_IPV4;
const VERSION_6 = FILTER_FLAG_IPV6;
```

## Properties

```php
//
protected template = Field :field must be a valid IP address;

```

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

<h1 id="validation-validator-numericality">Class Phalcon\Validation\Validator\Numericality</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/Numericality.zep)

| Namespace | Phalcon\Validation\Validator | | Uses | Phalcon\Messages\Message, Phalcon\Validation, Phalcon\Validation\AbstractValidator | | Extends | AbstractValidator |

Check for a valid numeric value

```php
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

## Properties

```php
//
protected template = Field :field does not have a valid numeric format;

```

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

<h1 id="validation-validator-presenceof">Class Phalcon\Validation\Validator\PresenceOf</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/PresenceOf.zep)

| Namespace | Phalcon\Validation\Validator | | Uses | Phalcon\Messages\Message, Phalcon\Validation, Phalcon\Validation\AbstractValidator | | Extends | AbstractValidator |

Validates that a value is not null or empty string

```php
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;

$validator = new Validation();

$validator->add(
    "name",
    new PresenceOf(
        [
            "message" => "The name is required",
        ]
    )
);

$validator->add(
    [
        "name",
        "email",
    ],
    new PresenceOf(
        [
            "message" => [
                "name"  => "The name is required",
                "email" => "The email is required",
            ],
        ]
    )
);
```

## Properties

```php
//
protected template = Field :field is required;

```

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

<h1 id="validation-validator-regex">Class Phalcon\Validation\Validator\Regex</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/Regex.zep)

| Namespace | Phalcon\Validation\Validator | | Uses | Phalcon\Messages\Message, Phalcon\Validation, Phalcon\Validation\AbstractValidator | | Extends | AbstractValidator |

Allows validate if the value of a field matches a regular expression

```php
use Phalcon\Validation;
use Phalcon\Validation\Validator\Regex as RegexValidator;

$validator = new Validation();

$validator->add(
    "created_at",
    new RegexValidator(
        [
            "pattern" => "/^[0-9]{4}[-\/](0[1-9]|1[12])[-\/](0[1-9]|[12][0-9]|3[01])$/",
            "message" => "The creation date is invalid",
        ]
    )
);

$validator->add(
    [
        "created_at",
        "name",
    ],
    new RegexValidator(
        [
            "pattern" => [
                "created_at" => "/^[0-9]{4}[-\/](0[1-9]|1[12])[-\/](0[1-9]|[12][0-9]|3[01])$/",
                "name"       => "/^[a-z]$/",
            ],
            "message" => [
                "created_at" => "The creation date is invalid",
                "name"       => "The name is invalid",
            ]
        ]
    )
);
```

## Properties

```php
//
protected template = Field :field does not match the required format;

```

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

<h1 id="validation-validator-stringlength">Class Phalcon\Validation\Validator\StringLength</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/StringLength.zep)

| Namespace | Phalcon\Validation\Validator | | Uses | Phalcon\Messages\Message, Phalcon\Validation\AbstractValidator, Phalcon\Validation\AbstractValidatorComposite, Phalcon\Validation\Validator\StringLength\Max, Phalcon\Validation\Validator\StringLength\Min, Phalcon\Validation\Exception | | Extends | AbstractValidatorComposite |

Validates that a string has the specified maximum and minimum constraints The test is passed if for a string's length L, min<=L<=max, i.e. L must be at least min, and at most max. Since Phalcon v4.0 this validator works like a container

```php
use Phalcon\Validation;
use Phalcon\Validation\Validator\StringLength as StringLength;

$validator = new Validation();

$validation->add(
    "name_last",
    new StringLength(
        [
            "max"             => 50,
            "min"             => 2,
            "messageMaximum"  => "We don't like really long names",
            "messageMinimum"  => "We want more than just their initials",
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
                "name_last"  => "We don't like really long last names",
                "name_first" => "We don't like really long first names",
            ],
            "messageMinimum" => [
                "name_last"  => "We don't like too short last names",
                "name_first" => "We don't like too short first names",
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

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

<h1 id="validation-validator-stringlength-max">Class Phalcon\Validation\Validator\StringLength\Max</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/StringLength/Max.zep)

| Namespace | Phalcon\Validation\Validator\StringLength | | Uses | Phalcon\Messages\Message, Phalcon\Validation, Phalcon\Validation\AbstractValidator, Phalcon\Validation\Exception | | Extends | AbstractValidator |

Validates that a string has the specified maximum constraints The test is passed if for a string's length L, L<=max, i.e. L must be at most max.

```php
use Phalcon\Validation;
use Phalcon\Validation\Validator\StringLength\Max;

$validator = new Validation();

$validation->add(
    "name_last",
    new Max(
        [
            "max"      => 50,
            "message"  => "We don't like really long names",
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
                "name_last"  => "We don't like really long last names",
                "name_first" => "We don't like really long first names",
            ],
            "included" => [
                "name_last"  => false,
                "name_first" => true,
            ]
        ]
    )
);
```

## Properties

```php
//
protected template = Field :field must not exceed :max characters long;

```

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

<h1 id="validation-validator-stringlength-min">Class Phalcon\Validation\Validator\StringLength\Min</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/StringLength/Min.zep)

| Namespace | Phalcon\Validation\Validator\StringLength | | Uses | Phalcon\Messages\Message, Phalcon\Validation, Phalcon\Validation\AbstractValidator, Phalcon\Validation\Exception | | Extends | AbstractValidator |

Validates that a string has the specified minimum constraints The test is passed if for a string's length L, min<=L, i.e. L must be at least min.

```php
use Phalcon\Validation;
use Phalcon\Validation\Validator\StringLength\Min;

$validator = new Validation();

$validation->add(
    "name_last",
    new Min(
        [
            "min"     => 2,
            "message" => "We want more than just their initials",
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
                "name_last"  => "We don't like too short last names",
                "name_first" => "We don't like too short first names",
            ],
            "included" => [
                "name_last"  => false,
                "name_first" => true,
            ]
        ]
    )
);
```

## Properties

```php
//
protected template = Field :field must be at least :min characters long;

```

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

<h1 id="validation-validator-uniqueness">Class Phalcon\Validation\Validator\Uniqueness</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/Uniqueness.zep)

| Namespace | Phalcon\Validation\Validator | | Uses | Phalcon\Messages\Message, Phalcon\Mvc\Model, Phalcon\Mvc\ModelInterface, Phalcon\Validation, Phalcon\Validation\AbstractCombinedFieldsValidator, Phalcon\Validation\Exception | | Extends | AbstractCombinedFieldsValidator |

Check that a field is unique in the related table

```php
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;

$validator = new Validation();

$validator->add(
    "username",
    new UniquenessValidator(
        [
            "model"   => new Users(),
            "message" => ":field must be unique",
        ]
    )
);
```

Different attribute from the field:

```php
$validator->add(
    "username",
    new UniquenessValidator(
        [
            "model"     => new Users(),
            "attribute" => "nick",
        ]
    )
);
```

In model:

```php
$validator->add(
    "username",
    new UniquenessValidator()
);
```

Combination of fields in model:

```php
$validator->add(
    [
        "firstName",
        "lastName",
    ],
    new UniquenessValidator()
);
```

It is possible to convert values before validation. This is useful in situations where values need to be converted to do the database lookup:

```php
$validator->add(
    "username",
    new UniquenessValidator(
        [
            "convert" => function (array $values) {
                $values["username"] = strtolower($values["username"]);

                return $values;
            }
        ]
    )
);
```

## Properties

```php
//
protected template = Field :field must be unique;

//
private columnMap;

```

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

The column map is used in the case to get real column name

```php
protected function getColumnNameReal( mixed $record, string $field ): string;
```

```php
protected function isUniqueness( Validation $validation, mixed $field ): bool;
```

Uniqueness method used for model

```php
protected function isUniquenessModel( mixed $record, array $field, array $values );
```

<h1 id="validation-validator-url">Class Phalcon\Validation\Validator\Url</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/Validator/Url.zep)

| Namespace | Phalcon\Validation\Validator | | Uses | Phalcon\Messages\Message, Phalcon\Validation, Phalcon\Validation\AbstractValidator | | Extends | AbstractValidator |

Checks if a value has a url format

```php
use Phalcon\Validation;
use Phalcon\Validation\Validator\Url as UrlValidator;

$validator = new Validation();

$validator->add(
    "url",
    new UrlValidator(
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
    new UrlValidator(
        [
            "message" => [
                "url"      => "url must be a url",
                "homepage" => "homepage must be a url",
            ]
        ]
    )
);
```

## Properties

```php
//
protected template = Field :field must be a url;

```

## Methods

Constructor

```php
public function __construct( array $options = [] );
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

<h1 id="validation-validatorcompositeinterface">Interface Phalcon\Validation\ValidatorCompositeInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/ValidatorCompositeInterface.zep)

| Namespace | Phalcon\Validation | | Uses | Phalcon\Validation |

This is a base class for combined fields validators

## Methods

Executes the validation

```php
public function getValidators(): array;
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```

<h1 id="validation-validatorfactory">Class Phalcon\Validation\ValidatorFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/ValidatorFactory.zep)

| Namespace | Phalcon\Validation | | Uses | Phalcon\Factory\AbstractFactory, Phalcon\Helper\Arr | | Extends | AbstractFactory |

This file is part of the Phalcon Framework.

(c) Phalcon Team [&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;](&#x6d;&#97;&#x69;&#x6c;&#116;&#x6f;&#58;&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;)

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.

## Methods

TagFactory constructor.

```php
public function __construct( array $services = [] );
```

Creates a new instance

```php
public function newInstance( string $name ): ValidatorInterface;
```

```php
protected function getAdapters(): array;
```

<h1 id="validation-validatorinterface">Interface Phalcon\Validation\ValidatorInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Validation/ValidatorInterface.zep)

| Namespace | Phalcon\Validation | | Uses | Phalcon\Collection, Phalcon\Validation |

Interface for Phalcon\Validation\AbstractValidator

## Methods

Returns an option in the validator's options Returns null if the option hasn't set

```php
public function getOption( string $key, mixed $defaultValue = null ): mixed;
```

Get the template message

```php
public function getTemplate( string $field ): string;
```

Get message templates

```php
public function getTemplates(): array;
```

Checks if an option is defined

```php
public function hasOption( string $key ): bool;
```

Set a new template message

```php
public function setTemplate( string $template ): ValidatorInterface;
```

Clear current template and set new from an array,

```php
public function setTemplates( array $templates ): ValidatorInterface;
```

Executes the validation

```php
public function validate( Validation $validation, mixed $field ): bool;
```