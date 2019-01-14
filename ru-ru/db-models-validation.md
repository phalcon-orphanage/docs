* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Валидация моделей

<a name='data-integrity'></a>

## Проверка целостности данных

[Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) provides several events to validate data and implement business rules. Специальное событие `validation` позволяет нам вызывать встроенные валидаторы для проверки записи. Phalcon имеет несколько встроенных валидаторов, которые можно использовать на этой стадии.

Следующий пример показывает, как это можно использовать:

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
                    'message' => 'Имя робота должно быть уникальным.',
                ]
            )
        );

        return $this->validate($validator);
    }
}
```

The above example performs a validation using the built-in validator 'InclusionIn'. It checks the value of the field `type` in a domain list. If the value is not included in the method then the validator will fail and return false.

<h5 class='alert alert-warning'>For more information on validators, see the <a href="/4.0/en/validation">Validation documentation</a></h5>

The idea of creating validators is make them reusable between several models. A validator can also be as simple as:

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
                'Sorry, old robots are not allowed anymore',
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

## Собщения об ошибках

[Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) has a messaging subsystem that provides a flexible way to output or store the validation messages generated during the insert/update processes.

Each message is an instance of [Phalcon\Mvc\Model\Message](api/Phalcon_Mvc_Model_Message) and the set of messages generated can be retrieved with the `getMessages()` method. Each message provides extended information like the field name that generated the message or the message type:

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

[Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) can generate the following types of validation messages:

| Тип                    | Описание                                                                                                                                         |
| ---------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------ |
| `PresenceOf`           | Генерируется, когда поле с атрибутом non-null в базе данных пытается вставить/обновить null значение                                             |
| `ConstraintViolation`  | Генерируется, когда поле, являющееся частью виртуального внешнего ключа, пытается вставить/обновить значение, не существующее в указанной модели |
| `InvalidValue`         | Генерируется, когда валидация не удалась из-за недопустимого значения                                                                            |
| `InvalidCreateAttempt` | Генерируется, когда была предпринята попытка создать запись, которая уже существует                                                              |
| `InvalidUpdateAttempt` | Генерируется, когда была предпринята попытка обновить запись, которая еще не существует                                                          |

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

## События при ошибках валидации

Другой доступный тип событий - когда в процессе проверки данных выявляются какие-либо несоответствия:

| Операция                         | Название            | Пояснение                                                                              |
| -------------------------------- | ------------------- | -------------------------------------------------------------------------------------- |
| Вставка или обновление           | `notSaved`          | Срабатывает, когда операция `INSERT` или `UPDATE` не выполняется по какой-либо причине |
| Вставка, удаление или обновление | `onValidationFails` | Срабатывает, когда не выполняется какая-либо операция обработки данных                 |