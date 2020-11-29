---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'Model Validation'
keywords: 'models, validation, uniqueness, inclusionin'
---

# Model Validation

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## 概要

[Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) provides several events to validate data and implement business rules.

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;

class Customers extends Model
{
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'cst_email',
            new Uniqueness(
                [
                    'message' => 'The customer email must be unique',
                ]
            )
        );

        return $this->validate($validator);
    }
}
```

## Data Integrity

Data integrity is essential in every application. You can implement validators in your models to introduce another layer of validation so that you can ensure that data is stored in your database that enforce your business rules.

The special `validation` event allows us to call built-in validators on the record. Phalcon exposes additional built-in validators that can be used at this stage of validation. All validators available are under the [Phalcon\Validation](validation) namespace.

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Validation\Validator\InclusionIn;

class Invoices extends Model
{
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'inv_status_flag',
            new InclusionIn(
                [
                    'domain'  => [
                        'Paid',
                        'Unpaid',
                    ],
                    'message' => 'The invoice must be ' .
                                 'either paid or unpaid',
                ]
            )
        );

        $validator->add(
            'inv_number',
            new Uniqueness(
                [
                    'message' => 'The invoice number must be unique',
                ]
            )
        );

        return $this->validate($validator);
    }
}
```

The above example performs a validation using the built-in validator [Phalcon\Validation\Validator\InclusionIn](api/phalcon_validation#validation-validator-inclusionin). It checks the value of the field `inv_status_flag` in a domain list. If the value is not included in the method then the validator will fail and return `false`.

> **NOTE**: For more information on validators, see the [Validation documentation](validation)
{: .alert .alert-warning }

## Messages

[Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) utilizes the [Phalcon\Messages\Messages](api/phalcon_messages#messages-messages) collection to store any validation messages that have been generated during the validation process.

Each message is an instance of [Phalcon\Messages\Message](api/phalcon_messages#messages-message) and the set of messages generated can be retrieved with the `getMessages()` method. Each message provides additional information such as the field name that generated the message or the message type:

```php
<?php

if (false === $invoice->save()) {
    $messages = $invoice->getMessages();

    foreach ($messages as $message) {
        echo 'Message: ', $message->getMessage();
        echo 'Field: ', $message->getField();
        echo 'Type: ', $message->getType();
    }
}
```

[Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) can generate the following types of validation messages:

| Type                   | Generated when                                                                                                         |
| ---------------------- | ---------------------------------------------------------------------------------------------------------------------- |
| `ConstraintViolation`  | A field, part of a virtual foreign key, is trying to insert/update a value that does not exist in the referenced model |
| `InvalidCreateAttempt` | Trying to create a record that already exists                                                                          |
| `InvalidUpdateAttempt` | Trying to update a record that does not exist                                                                          |
| `InvalidValue`         | A validator failed because of an invalid value                                                                         |
| `PresenceOf`           | A field with a non `null` attribute on the database is trying to insert/update a `null` value                          |

The `getMessages()` method can be overridden in a model to replace/translate the default messages generated automatically by the ORM:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

class Invoices extends Model
{
    public function getMessages()
    {
        $messages = [];

        foreach (parent::getMessages() as $message) {
            switch ($message->getType()) {
                case 'InvalidCreateAttempt':
                    $messages[] = 'The record cannot be created '
                                . 'because it already exists';
                    break;

                case 'InvalidUpdateAttempt':
                    $messages[] = "The record cannot be updated '
                                . 'because it doesn't exist";
                    break;

                case 'PresenceOf':
                    $messages[] = 'The field ' 
                                . $message->getField() 
                                . ' is mandatory';
                    break;
            }
        }

        return $messages;
    }
}
```

## Failed Events

Additional events are available when the data validation process finds any inconsistencies:

| Operation                | Name                | Explanation                                                            |
| ------------------------ | ------------------- | ---------------------------------------------------------------------- |
| Insert or Update         | `notSaved`          | Triggered when the `INSERT` or `UPDATE` operation fails for any reason |
| Insert, Delete or Update | `onValidationFails` | Triggered when any data manipulation operation fails                   |

## Custom

The <validation> document explains in detail how you can create your own validators. You can use such validators and reuse them among several models. A validator also can be as simple as:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;

class Invoices extends Model
{
    public function validation()
    {
        if ('Unpaid' === $this->inv_type_flag) {
            $message = new Message(
                'Unpaid invoices are not allowed',
                'inv_type_flag',
                'UnpaidInvoiceType'
            );

            $this->appendMessage($message);

            return false;
        }

        return true;
    }
}
```