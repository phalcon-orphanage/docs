验证（Validation）
==================

:doc:`Phalcon\\Validation <../api/Phalcon_Validation>` 对Phalcon来说是一个相对独立的组件，它可以对任意的数据进行验证。
当然也可以用来对非模型内的数据进行验证。

下面的例子展示了一些基本的使用方法：

.. code-block:: php

    <?php

    use Phalcon\Validation;
    use Phalcon\Validation\Validator\Email;
    use Phalcon\Validation\Validator\PresenceOf;

    $validation = new Validation();

    $validation->add(
        'name',
        new PresenceOf(
            array(
                'message' => 'The name is required'
            )
        )
    );

    $validation->add(
        'email',
        new PresenceOf(
            array(
                'message' => 'The e-mail is required'
            )
        )
    );

    $validation->add(
        'email',
        new Email(
            array(
                'message' => 'The e-mail is not valid'
            )
        )
    );

    $messages = $validation->validate($_POST);
    if (count($messages)) {
        foreach ($messages as $message) {
            echo $message, '<br>';
        }
    }

由于此模型是松耦合设计的，故此我们也可以使用自己书写的验证工具：

初始化验证（Initializing Validation）
-------------------------------------
我们可以直接在 :doc:`Phalcon\\Validation <../api/Phalcon_Validation>` 初始化时添加验证链。我们可以把验证器放在一个单独的文件中以提高代码的重用率及可组织性：

.. code-block:: php

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
                    array(
                        'message' => 'The name is required'
                    )
                )
            );

            $this->add(
                'email',
                new PresenceOf(
                    array(
                        'message' => 'The e-mail is required'
                    )
                )
            );

            $this->add(
                'email',
                new Email(
                    array(
                        'message' => 'The e-mail is not valid'
                    )
                )
            );
        }
    }

Then initialize and use your own validator:

.. code-block:: php

    <?php

    $validation = new MyValidation();

    $messages = $validation->validate($_POST);
    if (count($messages)) {
        foreach ($messages as $message) {
            echo $message, '<br>';
        }
    }

验证器（Validators）
--------------------
Phalcon的验证组件中内置了一些验证器：

+--------------+-------------------------------------------+-------------------------------------------------------------------+
| 名称         | 解释                                      |  示例                                                             |
+==============+===========================================+===================================================================+
| PresenceOf   |  检测字段的值是否为非空                   | :doc:`Example <../api/Phalcon_Validation_Validator_PresenceOf>`   |
+--------------+-------------------------------------------+-------------------------------------------------------------------+
| Identical    |  检测字段的值是否和指定的相同             | :doc:`Example <../api/Phalcon_Validation_Validator_Identical>`    |
+--------------+-------------------------------------------+-------------------------------------------------------------------+
| Email        |  检测值是否为合法的email地址              | :doc:`Example <../api/Phalcon_Validation_Validator_Email>`        |
+--------------+-------------------------------------------+-------------------------------------------------------------------+
| ExclusionIn  |  检测值是否不在列举的范围内               | :doc:`Example <../api/Phalcon_Validation_Validator_ExclusionIn>`  |
+--------------+-------------------------------------------+-------------------------------------------------------------------+
| InclusionIn  |  检测值是否在列举的范围内                 | :doc:`Example <../api/Phalcon_Validation_Validator_InclusionIn>`  |
+--------------+-------------------------------------------+-------------------------------------------------------------------+
| Regex        |  检测值是否匹配正则表达式                 | :doc:`Example <../api/Phalcon_Validation_Validator_Regex>`        |
+--------------+-------------------------------------------+-------------------------------------------------------------------+
| StringLength |  检测值的字符串长度                       | :doc:`Example <../api/Phalcon_Validation_Validator_StringLength>` |
+--------------+-------------------------------------------+-------------------------------------------------------------------+
| Between      |  检测值是否位于两个值之间                 | :doc:`Example <../api/Phalcon_Validation_Validator_Between>`      |
+--------------+-------------------------------------------+-------------------------------------------------------------------+
| Confirmation |  检测两个值是否相等                       | :doc:`Example <../api/Phalcon_Validation_Validator_Confirmation>` |
+--------------+-------------------------------------------+-------------------------------------------------------------------+
| Url          | Validates that field contains a valid URL | :doc:`Example <../api/Phalcon_Validation_Validator_Url>`          |
+--------------+-------------------------------------------+-------------------------------------------------------------------+

下面的例子中展示了如何创建自定义的验证器：

.. code-block:: php

    <?php

    use Phalcon\Validation\Message;
    use Phalcon\Validation\Validator;
    use Phalcon\Validation\ValidatorInterface;

    class IpValidator extends Validator implements ValidatorInterface
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
            $value = $validator->getValue($attribute);

            if (!filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6)) {

                $message = $this->getOption('message');
                if (!$message) {
                    $message = 'The IP is not valid';
                }

                $validator->appendMessage(new Message($message, $attribute, 'Ip'));

                return false;
            }

            return true;
        }
    }

最重要的一点即是难证器要返回一个布尔值以标识验证是否成功：

验证信息（Validation Messages）
-------------------------------
:doc:`Phalcon\\Validation <../api/Phalcon_Validation>` 内置了一个消息子系统，这提供了一个非常好的验证消息回传机制，以便在验证结束后取得验证信息，比如失败原因等。

每个消息由一个 :doc:`Phalcon\\Validation\\Message <../api/Phalcon_Mvc_Model_Message>` 类的实例构成。 验证过程产生的消息可以使用getMessages()方法取得。
每条消息都有一些扩展的信息组成比如产生错误的属性或消息的类型等：

.. code-block:: php

    <?php

    $messages = $validation->validate();
    if (count($messages)) {
        foreach ($validation->getMessages() as $message) {
            echo "Message: ", $message->getMessage(), "\n";
            echo "Field: ", $message->getField(), "\n";
            echo "Type: ", $message->getType(), "\n";
        }
    }

当然这里我们也可以对getMessages()方法进行重写， 以取得我们想要的信息：

.. code-block:: php

    <?php

    use Phalcon\Validation;

    class MyValidation extends Validation
    {
        public function initialize()
        {
            // ...
        }

        public function getMessages()
        {
            $messages = array();
            foreach (parent::getMessages() as $message) {
                switch ($message->getType()) {
                    case 'PresenceOf':
                        $messages[] = 'The field ' . $message->getField() . ' is mandatory';
                        break;
                }
            }

            return $messages;
        }
    }

或我们也可以传送一个message参数以覆盖验证器中默认的信息：

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\Email;

    $validation->add(
        'email',
        new Email(
            array(
                'message' => 'The e-mail is not valid'
            )
        )
    );

默认，getMessages()方法会返回在验证过程中所产生的信息。 我们可以使用filter()方法来过滤我们感兴趣的消息：

.. code-block:: php

    <?php

    $messages = $validation->validate();
    if (count($messages)) {
        // Filter only the messages generated for the field 'name'
        foreach ($validation->getMessages()->filter('name') as $message) {
            echo $message;
        }
    }

过滤数据（Filtering of Data）
-----------------------------
我们可以在数据被验证之前对其先进行过滤，以确保那些恶意的或不正确的数据不被验证。

.. code-block:: php

    <?php

    use Phalcon\Validation;

    $validation = new Validation();

    $validation
        ->add('name', new PresenceOf(array(
            'message' => 'The name is required'
        )))
        ->add('email', new PresenceOf(array(
            'message' => 'The email is required'
        )));

    // Filter any extra space
    $validation->setFilters('name', 'trim');
    $validation->setFilters('email', 'trim');

这里我们使用 :doc:`filter <filter>`: 组件进行过滤。 我们还可以使用自定义的或内置的过滤器。

验证事件（Validation Events）
-----------------------------
当在类中执行验证时， 我们可以在beforeValidation或afterValidation方法（事件）中执行额外的检查，过滤，清理等工作。 如果beforeValidation方法返回了false
则验证会被中止：

.. code-block:: php

    <?php

    use Phalcon\Validation;

    class LoginValidation extends Validation
    {
        public function initialize()
        {
            // ...
        }

        /**
         * 验证执行之前执行
         *
         * @param array $data
         * @param object $entity
         * @param Phalcon\Validation\Message\Group $messages
         * @return bool
         */
        public function beforeValidation($data, $entity, $messages)
        {
            if ($this->request->getHttpHost() != 'admin.mydomain.com') {
                $messages->appendMessage(new Message('Only users can log on in the administration domain'));

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
            // ... Add additional messages or perform more validations
        }
    }

取消验证（Cancelling Validations）
----------------------------------
默认所有的验证器都会被执行，不管验证成功与否。 我们可以通过设置 cancelOnFail 参数为 true 来指定某个验证器验证失败时中止以后的所有验证：

.. code-block:: php

    <?php

    use Phalcon\Validation;
    use Phalcon\Validation\Validator\Regex;
    use Phalcon\Validation\Validator\PresenceOf;

    $validation = new Validation();

    $validation
        ->add('telephone', new PresenceOf(array(
            'message'      => 'The telephone is required',
            'cancelOnFail' => true
        )))
        ->add('telephone', new Regex(array(
            'message' => 'The telephone is required',
            'pattern' => '/\+44 [0-9]+/'
        )))
        ->add('telephone', new StringLength(array(
            'messageMinimum' => 'The telephone is too short',
            'min'            => 2
        )));

第一个验证器中 cancelOnFail 参数设置为 true 则表示如果此验证器验证失败则验证链中接下的验证不会被执行。

我们可以在自定义的验证器中设置 cancelOnFail 为 true 来停止验证链：

.. code-block:: php

    <?php

    use Phalcon\Validation;
    use Phalcon\Validation\Message;
    use Phalcon\Validation\Validator;
    use Phalcon\Validation\ValidatorInterface;

    class MyValidator extends Validator implements ValidatorInterface
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
            // If the attribute value is name we must stop the chain
            if ($attribute == 'name') {
                $validator->setOption('cancelOnFail', true);
            }

            // ...
        }
    }

Avoid validate empty values
---------------------------
You can pass the option 'allowEmpty' to all the built-in validators to avoid the validation to be performed if an empty value is passed:

.. code-block:: php

    <?php

    use Phalcon\Validation;
    use Phalcon\Validation\Validator\Regex;

    $validation = new Validation();

    $validation
        ->add('telephone', new Regex(array(
            'message'    => 'The telephone is required',
            'pattern'    => '/\+44 [0-9]+/',
            'allowEmpty' => true
        )));
