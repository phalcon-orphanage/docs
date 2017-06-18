Валидация
=========

Компонент :doc:`Phalcon\\Validation <../api/Phalcon_Validation>` реализует независимую возможность проверки произвольного набора данных.
Компонент можно использовать для проверки данных не относящихся к моделям или коллекциям.

Ниже показан пример использования компонента:

.. code-block:: php

    <?php

    use Phalcon\Validation;
    use Phalcon\Validation\Validator\Email;
    use Phalcon\Validation\Validator\PresenceOf;

    $validation = new Validation();

    $validation->add(
        "name",
        new PresenceOf(
            [
                "message" => "The name is required",
            ]
        )
    );

    $validation->add(
        "email",
        new PresenceOf(
            [
                "message" => "The e-mail is required",
            ]
        )
    );

    $validation->add(
        "email",
        new Email(
            [
                "message" => "The e-mail is not valid",
            ]
        )
    );

    $messages = $validation->validate($_POST);

    if (count($messages)) {
        foreach ($messages as $message) {
            echo $message, "<br>";
        }
    }

Свободная блочная конструкция этого компонента позволяет вам создавать свои собственные валидаторы наряду с теми, что предоставляет фреймворк.

Инициализация валидации
-----------------------
Как вы уже поняли, цепочка проверок может быть инициализирована простым добавлением их в объект :doc:`Phalcon\\Validation <../api/Phalcon_Validation>`.
Вы можете повторно использовать код или лучше организовывать проверки, размещая их в отдельных файлах:

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
                "name",
                new PresenceOf(
                    [
                        "message" => "The name is required",
                    ]
                )
            );

            $this->add(
                "email",
                new PresenceOf(
                    [
                        "message" => "The e-mail is required",
                    ]
                )
            );

            $this->add(
                "email",
                new Email(
                    [
                        "message" => "The e-mail is not valid",
                    ]
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
            echo $message, "<br>";
        }
    }

Валидаторы
----------
Базовый компонент валидации Phalcon предоставляет следующие правила проверки:

+--------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------+
| Class                                                                                                  | Описание                                                                  |
+========================================================================================================+===========================================================================+
| :doc:`Phalcon\\Validation\\Validator\\Alnum <../api/Phalcon_Validation_Validator_Alnum>`               | Validates that a field's value is only alphanumeric character(s). |
+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Alpha <../api/Phalcon_Validation_Validator_Alpha>`               | Validates that a field's value is only alphabetic character(s).   |
+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Date <../api/Phalcon_Validation_Validator_Date>`                 | Validates that a field's value is a valid date.                   |
+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Digit <../api/Phalcon_Validation_Validator_Digit>`               | Validates that a field's value is only numeric character(s).      |
+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\File <../api/Phalcon_Validation_Validator_File>`                 | Validates that a field's value is a correct file.                 |
+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Uniqueness <../api/Phalcon_Validation_Validator_Uniqueness>`     | Validates that a field's value is unique in the related model.    |
+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Numericality <../api/Phalcon_Validation_Validator_Numericality>` | Validates that a field's value is a valid numeric value.          |
+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\PresenceOf <../api/Phalcon_Validation_Validator_PresenceOf>`     | Проверяет, что значение поля не равно null или пустой строке.             |
+--------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Identical <../api/Phalcon_Validation_Validator_Identical>`       | Проверяет, что значение поля соответствует какому-то конкретному значению |
+--------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Email <../api/Phalcon_Validation_Validator_Email>`               | Проверяет соответствие формату электронной почты                          |
+--------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\ExclusionIn <../api/Phalcon_Validation_Validator_ExclusionIn>`   | Проверяет, что значение не входит в список возможных значений             |
+--------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\InclusionIn <../api/Phalcon_Validation_Validator_InclusionIn>`   | Проверяет, что значение находится в списке возможных значений             |
+--------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Regex <../api/Phalcon_Validation_Validator_Regex>`               | Проверяет, что значение поля соответствует регулярному выражению          |
+--------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\StringLength <../api/Phalcon_Validation_Validator_StringLength>` | Проверяет длину строки                                                    |
+--------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Between <../api/Phalcon_Validation_Validator_Between>`           | Проверяет, что значение находится между двумя другими значениями          |
+--------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Confirmation <../api/Phalcon_Validation_Validator_Confirmation>` | Проверяет, что значение соответствует другому значению                    |
+--------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Url <../api/Phalcon_Validation_Validator_Url>`                   | Validates that field contains a valid URL                                 |
+--------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\CreditCard <../api/Phalcon_Validation_Validator_CreditCard>`     | Validates a credit card number                                            |
+--------------------------------------------------------------------------------------------------------+---------------------------------------------------------------------------+
| :doc:`Phalcon\\Validation\\Validator\\Callback <../api/Phalcon_Validation_Validator_Callback>`         | Validates using callback function                                  |
+--------------------------------------------------------------------------------------------------------+-------------------------------------------------------------------+

Дополнительные проверки могут быть реализованы самостоятельно. Следующий класс объясняет, как создать правило валидации для этого компонента:

.. code-block:: php

    <?php

    use Phalcon\Validation;
    use Phalcon\Validation\Message;
    use Phalcon\Validation\Validator;

    class IpValidator extends Validator
    {
        /**
         * Выполнение валидации
         *
         * @param Phalcon\Validation $validator
         * @param string $attribute
         * @return boolean
         */
        public function validate(Validation $validator, $attribute)
        {
            $value = $validator->getValue($attribute);

            if (!filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6)) {
                $message = $this->getOption("message");

                if (!$message) {
                    $message = "IP адрес не правилен";
                }

                $validator->appendMessage(
                    new Message($message, $attribute, "Ip")
                );

                return false;
            }

            return true;
        }
    }

Важно помнить, что валидаторы возвращают булево значение, показывающее, прошла валидация успешно, либо нет.

Callback Validator
------------------
By using :doc:`Phalcon\\Validation\\Validator\\Callback <../api/Phalcon_Validation_Validator_Callback>` you can execute custom
function which must return boolean or new validator class which will be used to validate the same field. By returning :code:`true`
validation will be successful, returning :code:`false` will mean validation failed. When executing this validator Phalcon will pass
data depending what it is - if it's an entity then entity will be passed, otherwise data. There is example:

.. code-block:: php

    <?php

    use \Phalcon\Validation;
    use \Phalcon\Validation\Validator\Callback;
    use \Phalcon\Validation\Validator\PresenceOf;

    $validation = new Validation();
    $validation->add(
        "amount",
        new Callback(
            [
                "callback" => function($data) {
                    return $data["amount"] % 2 == 0;
                },
                "message" => "Only even number of products are accepted"
            ]
        )
    );
    $validation->add(
        "amount",
        new Callback(
            [
                "callback" => function($data) {
                    if($data["amount"] % 2 == 0) {
                        return $data["amount"] != 2;
                    }

                    return true;
                },
                "message" => "You can't buy 2 products"
            ]
        )
    );
    $validation->add(
        "description",
        new Callback(
            [
                "callback" => function($data) {
                    if($data["amount"] >= 10) {
                        return new PresenceOf(
                            [
                                "message" => "You must write why you need so big amount."
                            ]
                        );
                    }

                    return true;
                }
            ]
        )
    );

    $messages = $validation->validate(["amount" => 1]); // will return message from first validator
    $messages = $validation->validate(["amount" => 2]); // will return message from second validator
    $messages = $validation->validate(["amount" => 10]); // will return message from validator returned by third validator

Сообщения валидации
-------------------
Компонент :doc:`Phalcon\\Validation <../api/Phalcon_Validation>` имеет внутреннюю подсистему работы с сообщениями.
Она обеспечивает гибкую работу с хранением и выводом проверочных сообщений, генерируемых в ходе проверки.

Каждое сообщение состоит из экземпляра класса :doc:`Phalcon\\Validation\\Message <../api/Phalcon_Mvc_Model_Message>`. Набор
сгенерированных сообщений может быть получен с помощью метода getMessages(). Каждое сообщение содержит расширенную информацию - атрибут,
текст и тип сообщения:

.. code-block:: php

    <?php

    $messages = $validation->validate();

    if (count($messages)) {
        foreach ($messages as $message) {
            echo "Сообщение: ", $message->getMessage(), "\n";
            echo "Поле: ", $message->getField(), "\n";
            echo "Тип: ", $message->getType(), "\n";
        }
    }

Вы можете передать сообщение параметром по умолчанию в каждый валидатор:

.. code-block:: php

    <?php

    use Phalcon\Validation\Validator\Email;

    $validation->add(
        "email",
        new Email(
            [
                "message" => "The e-mail is not valid",
            ]
        )
    );

По умолчанию метод :code:`getMessages()` возвращает все сообщения сгенерированные валидатором. Вы можете отфильтровать
сообщения используя :code:`filter()`:

.. code-block:: php

    <?php

    $messages = $validation->validate();

    if (count($messages)) {
        // Отфильтровать только те сообщения, которые были сгенерированы для поля 'name'
        $filteredMessages = $messages->filter("name");

        foreach ($filteredMessages as $message) {
            echo $message;
        }
    }

Фильтрация данных
-----------------
Данные фильтруются для того, чтобы быть уверенным, что вредоносные или неверные данные не будут пропущены приложением.

.. code-block:: php

    <?php

    use Phalcon\Validation;

    $validation = new Validation();

    $validation->add(
        "name",
        new PresenceOf(
            [
                "message" => "The name is required",
            ]
        )
    );

    $validation->add(
        "email",
        new PresenceOf(
            [
                "message" => "The email is required",
            ]
        )
    );

    // Избавимся от лишних пробелов
    $validation->setFilters("name", "trim");
    $validation->setFilters("email", "trim");

Фильтрация и очистка производятся с помощью компонента :doc:`filter <filter>`. Вы можете добавлять в него свои фильтры,
либо пользоваться встроенными.

События валидации
-----------------
Когда в классах определена валидация, вы также можете реализовать методы :code:`beforeValidation()` и :code:`afterValidation()`, чтобы
добавить дополнительные проверки, очистку и т.п. Если :code:`beforeValidation()` возвращает 'false', валидация не будет пройдена:

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
         * Выполняется перед валидацией
         *
         * @param array $data
         * @param object $entity
         * @param Phalcon\Validation\Message\Group $messages
         * @return bool
         */
        public function beforeValidation($data, $entity, $messages)
        {
            if ($this->request->getHttpHost() !== "admin.mydomain.com") {
                $messages->appendMessage(
                    new Message("Only users can log on in the administration domain")
                );

                return false;
            }

            return true;
        }

        /**
         * Выполняется после валидации
         *
         * @param array $data
         * @param object $entity
         * @param Phalcon\Validation\Message\Group $messages
         */
        public function afterValidation($data, $entity, $messages)
        {
            // ... добавляем дополнительные сообщения или валидацию
        }
    }

Отмена валидации
----------------
По умолчанию проверяются все валидаторы, присвоенные полю, независимо от того, успешно ли прошла валидация одного из них или нет.
Вы можете изменить такое поведение, если укажете валидатору на каком из правил ему следует остановить дальнейшую проверку:

.. code-block:: php

    <?php

    use Phalcon\Validation;
    use Phalcon\Validation\Validator\Regex;
    use Phalcon\Validation\Validator\PresenceOf;

    $validation = new Validation();

    $validation->add(
        "telephone",
        new PresenceOf(
            [
                "message"      => "The telephone is required",
                "cancelOnFail" => true,
            ]
        )
    );

    $validation->add(
        "telephone",
        new Regex(
            [
                "message" => "The telephone is required",
                "pattern" => "/\+44 [0-9]+/",
            ]
        )
    );

    $validation->add(
        "telephone",
        new StringLength(
            [
                "messageMinimum" => "The telephone is too short",
                "min"            => 2,
            ]
        )
    );

Первый валидатор имеет свойство 'cancelOnFail' => true, поэтому если валидация не пройдёт эту проверку, то
дальнейшие проверки в цепочке не будут выполнены.

Если вы создаёте собственные валидаторы, то можете динамически останавливать их используя свойство 'cancelOnFail':

.. code-block:: php

    <?php

    use Phalcon\Validation;
    use Phalcon\Validation\Message;
    use Phalcon\Validation\Validator;

    class MyValidator extends Validator
    {
        /**
         * Выполняем проверку
         *
         * @param Phalcon\Validation $validator
         * @param string $attribute
         * @return boolean
         */
        public function validate(Validation $validator, $attribute)
        {
            // Если имя атрибута 'name' - останавливаем дальнейшие проверки
            if ($attribute === "name") {
                $validator->setOption("cancelOnFail", true);
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

    $validation->add(
        "telephone",
        new Regex(
            [
                "message"    => "The telephone is required",
                "pattern"    => "/\+44 [0-9]+/",
                "allowEmpty" => true,
            ]
        )
    );

Recursive Validation
--------------------
You can also run Validation instances within another via the :code:`afterValidation()` method. In this example, validating the CompanyValidation instance will also check the PhoneValidation instance:

.. code-block:: php

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
                $data["phone"]
            );

            $messages->appendMessages(
                $phoneValidationMessages
            );
        }
    }
