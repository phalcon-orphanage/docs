<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">验证</a> <ul>
        <li>
          <a href="#initializing">初始化验证</a>
        </li>
        <li>
          <a href="#validators">验证程序</a>
        </li>
        <li>
          <a href="#callback">回调验证程序</a>
        </li>
        <li>
          <a href="#messages">验证消息</a>
        </li>
        <li>
          <a href="#filtering">数据过滤</a>
        </li>
        <li>
          <a href="#events">验证事件</a>
        </li>
        <li>
          <a href="#cancelling">取消验证</a>
        </li>
        <li>
          <a href="#空值">避免验证空值</a>
        </li>
        <li>
          <a href="#recursive">递归验证</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# 验证

`Phalcon\Validation` 是一个独立的验证组件，验证任意一组数据。 此组件可以用于不属于模型或集合的数据的对象上进行验证。

下面的示例演示如何使用它：

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

此组件的松散耦合设计允许您创建自己的验证器以及使用框架提供的验证器。

<a name='initializing'></a>

## 初始化验证

验证链可通过只将验证添加到 `Phalcon\Validation` 对象进行初始化。 为了更好得重用或者管理您的代码，您可以把你的验证器放在独立的文件：

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

然后初始化并使用您自己的验证器：

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

## 验证程序

Phalcon公开一组内置的验证组件：

| 类                                              | 注解                                                             |
| ---------------------------------------------- | -------------------------------------------------------------- |
| `Phalcon\Validation\Validator\Alnum`        | 验证字段值只能是字母和数字字符                                                |
| `Phalcon\Validation\Validator\Alpha`        | 验证字段值只能是字母字符                                                   |
| `Phalcon\Validation\Validator\Date`         | 验证字段值是一个有效的日期。                                                 |
| `Phalcon\Validation\Validator\Digit`        | 验证字段值只能是数字字符。                                                  |
| `Phalcon\Validation\Validator\File`         | 验证字段的值是正确的文件。                                                  |
| `Phalcon\Validation\Validator\Uniqueness`   | Validates that a field's value is unique in the related model. |
| `Phalcon\Validation\Validator\Numericality` | 验证字段值是一个有效的数值                                                  |
| `Phalcon\Validation\Validator\PresenceOf`   | 验证字段的值不是 null 或空字符串                                            |
| `Phalcon\Validation\Validator\Identical`    | 验证字段值是否于指定的值相同                                                 |
| `Phalcon\Validation\Validator\Email`        | 验证字段包含一个有效的电子邮件格式                                              |
| `Phalcon\Validation\Validator\ExclusionIn`  | 验证的值不在列表中                                                      |
| `Phalcon\Validation\Validator\InclusionIn`  | 验证值存在列表中                                                       |
| `Phalcon\Validation\Validator\Regex`        | 验证字段的值匹配的正则表达式                                                 |
| `Phalcon\Validation\Validator\StringLength` | 验证一个字符串的长度                                                     |
| `Phalcon\Validation\Validator\Between`      | 验证值是两个值之间                                                      |
| `Phalcon\Validation\Validator\Confirmation` | 验证值是相同的数据中的字段                                                  |
| `Phalcon\Validation\Validator\Url`          | 验证字段包含一个有效的 URL                                                |
| `Phalcon\Validation\Validator\CreditCard`   | 验证的信用卡卡号                                                       |
| `Phalcon\Validation\Validator\Callback`     | 验证时使用回调函数                                                      |

下面的示例说明如何创建此组件附加验证程序：

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Message;
use Phalcon\Validation\Validator;

class IpValidator extends Validator
{
    /**
     * 执行以下验证
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

重要的是验证器必须返回一个布尔类型的值来判断验证是否通过。

<a name='callback'></a>

## 回调验证程序

通过使用 `Phalcon\Validation\Validator\Callback`您可以继续使用一个返回布尔值的自定义方法来对同一个字段进行验证。 通过返回 `true` 验证将成功，返回 `false` 将意味着验证失败。 When executing this validator Phalcon will pass data depending what it is - if it's an entity (i.e. a model, a `stdClass` etc.) then entity will be passed, otherwise data (i.e an array like `$_POST`). 这是示例：

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

## 验证消息

`Phalcon\Validation`拥有一种灵活方式输出或存储验证过程中生成的信息的消息子系统。

每个消息由`Phalcon\Validation\Message`类的实例组成。 `getMessages()` 方法，即可检索到消息生成的集。 每个消息会提供扩展信息像消息和消息类型等属性：

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

你可以给么一个验证器传递一个‘消息’作为参数来改变／翻译默认的消息：

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

默认情况下，`getMessages()` 方法会返回在验证过程中生成的所有消息。您可以通过`filter()`方法来进行过滤以此获取某个特定字段的所有信息：

```php
<?php

$messages = $validation->validate();

if (count($messages)) {
    // 过滤为只含有'name'字段的信息
    $filteredMessages = $messages->filter('name');

    foreach ($filteredMessages as $message) {
        echo $message;
    }
}
```

<a name='filtering'></a>

## 数据过滤

数据可以在验证之前进行过滤，以确保恶意或不正确的数据未被验证。

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

// 过滤掉两端的不可见字符
$validation->setFilters('name', 'trim');
$validation->setFilters('email', 'trim');
```

过滤和处理是使用 [filter](/[[language]]/[[version]]/filter) 组件来执行的。您可以将多个筛选器添加到此组件或使用内置的。

<a name='events'></a>

## 验证事件

当所有的验证器都被初始化在类中，你可以实现`beforeValidation()`和`afterValidation()`方法做额外的检查、过滤、清理等。 如果在`beforeValidation()`返回false那么验证会自动取消：

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
     * 在验证之前执行
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
     * 验证之后执行
     *
     * @param array $data
     * @param object $entity
     * @param Phalcon\Validation\Message\Group $messages
     */
    public function afterValidation($data, $entity, $messages)
    {
        // ... 添加其他的信息或者执行更多的验证
    }
}
```

<a name='cancelling'></a>

## 取消验证

默认情况下所有在该字段的验证器都会一一测试，无论其中一个或者多个验证器是否通过。 你可以通过当验证器不通过时停止验证过程来告诉验证组件改变此行为。

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

第一个验证程器的选项`cancelOnFail`的值为 true，该验证器如果验证不通过，那么剩下的验证链将不执行。

如果您正在创建自定义验证器，您可以通过设置`cancelOnFail`选项动态停止验证链：

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Message;
use Phalcon\Validation\Validator;

class MyValidator extends Validator
{
    /**
     * 执行验证
     *
     * @param Phalcon\Validation $validator
     * @param string $attribute
     * @return boolean
     */
    public function validate(Validation $validator, $attribute)
    {
        // 如果验证的属性名为'name'那么设置自动停下验证链
        if ($attribute === 'name') {
            $validator->setOption('cancelOnFail', true);
        }

        // ...
    }
}
```

<a name='empty-values'></a>

## 避免验证空值

您可以在为所有内置的验证器传递`allowEmpty`选项以避免给验证器传递一个空值：

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

## 递归验证

您也能实现`afterValidation()`方法在内部进行另一种验证实例。 在此示例中，在使用验证`CompanyValidation`的情况下还会使用`PhoneValidation`进行验证。

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