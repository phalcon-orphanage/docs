<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">バリデーション</a> <ul>
        <li>
          <a href="#initializing">バリデーションの初期化</a>
        </li>
        <li>
          <a href="#validators">バリデーター</a>
        </li>
        <li>
          <a href="#callback">Callbackバリデーター</a>
        </li>
        <li>
          <a href="#messages">バリデーションメッセージ</a>
        </li>
        <li>
          <a href="#filtering">データのフィルタリング</a>
        </li>
        <li>
          <a href="#events">バリデーションイベント</a>
        </li>
        <li>
          <a href="#cancelling">バリデーションのキャンセル</a>
        </li>
        <li>
          <a href="#empty-values">空の値のバリデーションを避ける</a>
        </li>
        <li>
          <a href="#recursive">再起的バリデーション</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# バリデーション

`Phalcon\Validation`は、任意のデータセットをバリデーションする独立したバリデーションコンポーネントです。 このコンポーネントを使用して、モデルまたはコレクションに属していないデータオブジェクトに対するバリデーションルールを実装できます。

次の例は、その基本的な使い方を示しています:

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

このコンポーネントは疎結合に設計されているため、フレームワークが提供するバリデータとともに独自のバリデータを作成することができます。

<a name='initializing'></a>

## バリデーションの初期化

バリデーションチェインは、`Phalcon\Validation`オブジェクトにバリデータを追加するだけで、直接的に初期化できます。 コードと構成を再利用しやすくするために、バリデーションを別々のファイルに入れることができます:

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

次に、独自のバリデータを初期化して使用します:

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

## バリデーター

Phalconは下記のような組み込みバリデーター一式をコンポーネントとして公開しています:

| クラス                                            | 説明                                  |
| ---------------------------------------------- | ----------------------------------- |
| `Phalcon\Validation\Validator\Alnum`        | フィールドの値が英数字のみであることを検証します。           |
| `Phalcon\Validation\Validator\Alpha`        | フィールドの値がアルファベットのみであることを検証します。       |
| `Phalcon\Validation\Validator\Date`         | フィールドの値が有効な日付であることを検証します。           |
| `Phalcon\Validation\Validator\Digit`        | フィールドの値が数値のみであることを検証します。            |
| `Phalcon\Validation\Validator\File`         | フィールドの値が正しいファイルであることを検証します。         |
| `Phalcon\Validation\Validator\Uniqueness`   | フィールドの値が関連するモデルでユニークであることを検証します。    |
| `Phalcon\Validation\Validator\Numericality` | フィールドの値が有効な数値であることを検証します。           |
| `Phalcon\Validation\Validator\PresenceOf`   | フィールドの値が null または空の文字列ではないことを検証します。 |
| `Phalcon\Validation\Validator\Identical`    | フィールドの値が指定された値と同じであることを検証します。       |
| `Phalcon\Validation\Validator\Email`        | そのフィールドに有効な電子メール形式が含まれていることを検証します。  |
| `Phalcon\Validation\Validator\ExclusionIn`  | 値が可能な値のリスト内にないことを検証します。             |
| `Phalcon\Validation\Validator\InclusionIn`  | 値が可能な値のリスト内にあることを検証します。             |
| `Phalcon\Validation\Validator\Regex`        | フィールドの値が正規表現に一致することを検証します。          |
| `Phalcon\Validation\Validator\StringLength` | 文字列の長さを検証します。                       |
| `Phalcon\Validation\Validator\Between`      | 値が2つの値の間にあることを検証します。                |
| `Phalcon\Validation\Validator\Confirmation` | 値がもう片方のデータと同じであることを検証します。           |
| `Phalcon\Validation\Validator\Url`          | そのフィールドに有効なURLが含まれていることを検証します。      |
| `Phalcon\Validation\Validator\CreditCard`   | クレジットカード番号を検証します。                   |
| `Phalcon\Validation\Validator\Callback`     | コールバック関数を使用して検証します。                 |

次の例では、コンポーネントにどうやってバリデーターを作成するかを説明します。

```php
<?php

use Phalcon\Validation;
use Phalcon\Validation\Message;
use Phalcon\Validation\Validator;

class IpValidator extends Validator
{
    /**
     * バリデーションの実行
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

バリデーターは、検証が成功したかどうかを示す有効なブール値を返すことが重要です。

<a name='callback'></a>

## Callbackバリデーター

`Phalcon\Validation\Validator\Callback`を使う事で、ブール値を必ず返すようなカスタム関数や、同じ値かどうかを検証するのに使える新しいバリデータークラスを実行する事ができます。 `true`を返すことでバリデーションが成功し、`false`を返すとバリデーションが失敗したことを意味します。 このバリデーターを実行するとき、Phalconはそれが何に関係しているかによてデータを渡します。実体の場合は実体が、それ以外の場合はデータが渡されます。 例を示します:

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

## バリデーションメッセージ

`Phalcon\Validation`は、バリデーション中に生成されたメッセージを出力または格納する、柔軟な方法を提供するメッセージングサブシステムを持っています。

各メッセージは、`Phalcon\Validation\Message` クラスのインスタンスで構成されます。 `getMessages()`メソッドで、生成されたメッセージのセットが取得できます。 各メッセージは、メッセージを生成した属性やメッセージの種類のような拡張情報を提供します。

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

'message' パラメータを渡すと、各バリデーターのデフォルトのメッセージを変更/変換できます。

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

デフォルトでは、`getMessages()`メソッドは、バリデーション中に生成されたすべてのメッセージを返します。`filter()`メソッドを使用して、特定のフィールドのメッセージをフィルタリングできます。

```php
<?php

$messages = $validation->validate();

if (count($messages)) {
    // フィールド 'name'に対して生成されたメッセージだけに絞ります
    $filteredMessages = $messages->filter('name');

    foreach ($filteredMessages as $message) {
        echo $message;
    }
}
```

<a name='filtering'></a>

## データのフィルタリング

バリデーションの前にデータをフィルタリングして、悪意のあるデータまたは不正確なデータが処理されないようにできます。

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

// 余分なスペースを除去
$validation->setFilters('name', 'trim');
$validation->setFilters('email', 'trim');
```

フィルタとサニタイズは、[filter](/[[language]]/[[version]]/filter)コンポーネントを使用して実行されます。 このコンポーネントにフィルタを追加したり、組み込みのフィルタを使用することができます。

<a name='events'></a>

## バリデーションイベント

バリデーションがクラスで構成されている場合、`beforeValidation()`メソッドおよび`afterValidation()`メソッドを実装して、追加のチェック、フィルタ、クリーンアップなどを実行できます。 `beforeValidation()`メソッドがfalseを返す場合、バリデーションは自動的にキャンセルされます。

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
     * バリデーションの前に実行
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
     * バリデーションの後に実行
     *
     * @param array $data
     * @param object $entity
     * @param Phalcon\Validation\Message\Group $messages
     */
    public function afterValidation($data, $entity, $messages)
    {
        // ... メッセージを追加したり、もっとバリデーションを追加したり
    }
}
```

<a name='cancelling'></a>

## バリデーションのキャンセル

デフォルトでは、フィールドに割り当てられたすべてのバリデータは、いずれかが失敗したかどうかに関係なくテストされます。 この動作を変更するには、バリデーションコンポーネントが処理を中止する可能性のあるバリデーションを指定します:

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

最初のバリデータにはtrueの値を持つ`cancelOnFail`オプションがあります。したがって、バリデータが失敗した場合、チェーン内の残りのバリデータは実行されません。

カスタムバリデータを作成している場合は、`cancelOnFail`オプションを設定することでバリデーションチェーンを動的に停止できます。

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

        // ...バリデーションの実行
    }
}
```

<a name='empty-values'></a>

## 空の値のバリデーションを避ける

空の値が渡された場合に検証が実行されないように、すべてのビルトインバリデータにオプション`allowEmpty`を渡すことができます。

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

## 再起的バリデーション

`afterValidation()`メソッドを使用して、別のインスタンス内でValidationインスタンスを実行することもできます。 この例では、`CompanyValidation`インスタンスをバリデーションすると、`PhoneValidation`インスタンスもチェックされます。

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