---
layout: article
language: 'zh-cn'
version: '4.0'
---
##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# 模型中验证数据

<a name='data-integrity'></a>

## 验证数据完整性

[Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) provides several events to validate data and implement business rules. 特别 `validation` 事件允许我们打电话内置验证器的记录。 Phalcon公开几个内置的验证器，可以用在这一阶段的验证。

下面的示例演示如何使用它：

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
                    'message' => 'The robot name must be unique',
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

## 验证消息

[Phalcon\Mvc\Model](api/Phalcon_Mvc_Model) has a messaging subsystem that provides a flexible way to output or store the validation messages generated during the insert/update processes.

Each message is an instance of [Phalcon\Mvc\Model\Message](api/Phalcon_Mvc_Model_Message) and the set of messages generated can be retrieved with the `getMessages()` method. 每个消息提供扩展的信息，如生成消息或消息类型的字段名称：

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

| 类型                     | 描述                                       |
| ---------------------- | ---------------------------------------- |
| `PresenceOf`           | 当字段在数据库上的非 null 属性与正试图插入/更新一个 null 值时，生成 |
| `ConstraintViolation`  | 生成一个虚拟的外键字段部分试图插入/更新引用模型中并不存在一个值时        |
| `InvalidValue`         | 当验证失败，因为一个无效的值时，生成                       |
| `InvalidCreateAttempt` | 如果记录试图创建，但它已经存在，生成                       |
| `InvalidUpdateAttempt` | 生产时记录试图更新，但它并不存在                         |

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

## 验证失败的事件

Another type of events are available when the data validation process finds any inconsistency:

| 操作               | 名称                  | 注解                                 |
| ---------------- | ------------------- | ---------------------------------- |
| Insert or Update | `notSaved`          | 触发时，`INSERT` 或 `UPDATE` 操作因任何原因而失败 |
| 插入、 删除或更新        | `onValidationFails` | 当任何数据操作操作失败时触发                     |