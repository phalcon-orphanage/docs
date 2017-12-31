<div class='article-menu' markdown='1'>

- [Validation](#overview)
    - [Initializing Validation](#initializing)
    - [Validators](#validators)
    - [Callback Validator](#callback)
    - [Validation Messages](#messages)
    - [Filtering of Data](#filtering)
    - [Validation Events](#events)
    - [Cancelling Validations](#cancelling)
    - [Avoid validating empty values](#empty-values)
    - [Recursive Validation](#recursive)

</div>

<a name='overview'></a>
# Validation
`Phalcon\Validation` is an independent validation component that validates an arbitrary set of data. This component can be used to implement validation rules on data objects that do not belong to a model or collection.

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

<a name='initializing'></a>
## Initializing Validation
Validation chains can be initialized in a direct manner by just adding validators to the `Phalcon\Validation` object. You can put your validations in a separate file for better re-use code and organization:

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

<a name='validators'></a>
## Validators
Phalcon exposes a set of built-in validators for this component:

| Class                                       | Explanation                                                       |
|---------------------------------------------|-------------------------------------------------------------------|
| `Phalcon\Validation\Validator\Alnum`        | Validates that a field's value is only alphanumeric character(s). |
| `Phalcon\Validation\Validator\Alpha`        | Validates that a field's value is only alphabetic character(s).   |
| `Phalcon\Validation\Validator\Date`         | Validates that a field's value is a valid date.                   |
| `Phalcon\Validation\Validator\Digit`        | Validates that a field's value is only numeric character(s).      |
| `Phalcon\Validation\Validator\File`         | Validates that a field's value is a correct file.                 |
| `Phalcon\Validation\Validator\Uniqueness`   | Validates that a field's value is unique in the related model.    |
| `Phalcon\Validation\Validator\Numericality` | Validates that a field's value is a valid numeric value.          |
| `Phalcon\Validation\Validator\PresenceOf`   | Validates that a field's value is not null or empty string.       |
| `Phalcon\Validation\Validator\Identical`    | Validates that a field's value is the same as a specified value   |
| `Phalcon\Validation\Validator\Email`        | Validates that field contains a valid email format                |
| `Phalcon\Validation\Validator\ExclusionIn`  | Validates that a value is not within a list of possible values    |
| `Phalcon\Validation\Validator\InclusionIn`  | Validates that a value is within a list of possible values        |
| `Phalcon\Validation\Validator\Regex`        | Validates that the value of a field matches a regular expression  |
| `Phalcon\Validation\Validator\StringLength` | Validates the length of a string                                  |
| `Phalcon\Validation\Validator\Between`      | Validates that a value is between two values                      |
| `Phalcon\Validation\Validator\Confirmation` | Validates that a value is the same as another present in the data |
| `Phalcon\Validation\Validator\Url`          | Validates that field contains a valid URL                         |
| `Phalcon\Validation\Validator\CreditCard`   | Validates a credit card number                                    |
| `Phalcon\Validation\Validator\Callback`     | Validates using callback function                                 |

The following example explains how to create additional validators for this component:

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Message;
use Phalcon\Validation\Validator;

class IpValidator extends Validator
{
    /**
     * Executes the validation
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

It is important that validators return a valid boolean value indicating if the validation was successful or not.

<a name='callback'></a>
## Callback Validator
By using `Phalcon\Validation\Validator\Callback` you can execute custom function which must return boolean or new validator class which will be used to validate the same field. By returning `true` validation will be successful, returning `false` will mean validation failed. When executing this validator Phalcon will pass data depending what it is - if it's an entity then entity will be passed, otherwise data. There is example:

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
            'message'  => 'Only even number of products are accepted'
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
            'message' => "You can't buy 2 products"
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
                            'message' => 'You must write why you need so big amount.'
                        ]
                    );
                }

                return true;
            }
        ]
    )
);

$messages = $validation->validate(['amount' => 1]);  // will return message from first validator
$messages = $validation->validate(['amount' => 2]);  // will return message from second validator
$messages = $validation->validate(['amount' => 10]); // will return message from validator returned by third validator
```

<a name='messages'></a>
## Validation Messages
`Phalcon\Validation` has a messaging subsystem that provides a flexible way to output or store the validation messages generated during the validation processes.

Each message consists of an instance of the class `Phalcon\Validation\Message`. The set of messages generated can be retrieved with the `getMessages()` method. Each message provides extended information like the attribute that generated the message or the message type:

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

You can pass a 'message' parameter to change/translate the default message in each validator:

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
    // Filter only the messages generated for the field 'name'
    $filteredMessages = $messages->filter('name');

    foreach ($filteredMessages as $message) {
        echo $message;
    }
}
```

<a name='filtering'></a>
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

// Filter any extra space
$validation->setFilters('name', 'trim');
$validation->setFilters('email', 'trim');
```

Filtering and sanitizing is performed using the [filter](/[[language]]/[[version]]/filter) component. You can add more filters to this component or use the built-in ones.

<a name='events'></a>
## Validation Events
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
     * Executed before validation
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
                new Message('Only users can log on in the administration domain')
            );

            return false;
        }

        return true;
    }

    /**
     * Executed after validation
     *
     * @param array $data
     * @param object $entity
     * @param Phalcon\Validation\Message\Group $messages
     */
    public function afterValidation($data, $entity, $messages)
    {
        // ... Add additional messages or perform more validations
    }
}
```

<a name='cancelling'></a>
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

The first validator has the option `cancelOnFail` with a value of true, therefore if that validator fails the remaining validators in the chain are not executed.

If you are creating custom validators you can dynamically stop the validation chain by setting the `cancelOnFail` option:

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Message;
use Phalcon\Validation\Validator;

class MyValidator extends Validator
{
    /**
     * Executes the validation
     *
     * @param Phalcon\Validation $validator
     * @param string $attribute
     * @return boolean
     */
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

<a name='empty-values'></a>
## Avoid validating empty values
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
            'message'    => 'The telephone is required',
            'pattern'    => '/\+44 [0-9]+/',
            'allowEmpty' => true,
        ]
    )
);
```

<a name='recursive'></a>
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