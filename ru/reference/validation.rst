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

Валидаторы
----------
Базовый компонент валидации Phalcon предоставляет следующие правила проверки:

+--------------+-----------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------------------+
| Название     | Описание                                                                                                                                | Пример                                                           |
+==============+=========================================================================================================================================+==================================================================+
| PresenceOf   | Проверяет, что значение поля не равно null или пустой строке.                                                                           | :doc:`Пример <../api/Phalcon_Validation_Validator_PresenceOf>`   |
+--------------+-----------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------------------+
| Identical    | Проверяет, что значение поля соответствует какому-то конкретному значению                                                               | :doc:`Пример <../api/Phalcon_Validation_Validator_Identical>`    |
+--------------+-----------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------------------+
| Email        | Проверяет соответствие формату электронной почты                                                                                        | :doc:`Пример <../api/Phalcon_Validation_Validator_Email>`        |
+--------------+-----------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------------------+
| ExclusionIn  | Проверяет, что значение не входит в список возможных значений                                                                           | :doc:`Пример <../api/Phalcon_Validation_Validator_ExclusionIn>`  |
+--------------+-----------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------------------+
| InclusionIn  | Проверяет, что значение находится в списке возможных значений                                                                           | :doc:`Пример <../api/Phalcon_Validation_Validator_InclusionIn>`  |
+--------------+-----------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------------------+
| Regex        | Проверяет, что значение поля соответствует регулярному выражению                                                                        | :doc:`Пример <../api/Phalcon_Validation_Validator_Regex>`        |
+--------------+-----------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------------------+
| StringLength | Проверяет длину строки                                                                                                                  | :doc:`Пример <../api/Phalcon_Validation_Validator_StringLength>` |
+--------------+-----------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------------------+
| Between      | Проверяет, что значение находится между двумя другими значениями                                                                        | :doc:`Пример <../api/Phalcon_Validation_Validator_Between>`      |
+--------------+-----------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------------------+
| Confirmation | Проверяет, что значение соответствует другому значению                                                                                  | :doc:`Пример <../api/Phalcon_Validation_Validator_Confirmation>` |
+--------------+-----------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------------------+
| Url          | Validates that field contains a valid URL                                                                                               | :doc:`Example <../api/Phalcon_Validation_Validator_Url>`         |
+--------------+-----------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------------------+

Дополнительные проверки могут быть реализованы самостоятельно. Следующий класс объясняет, как создать правило валидации для этого компонента:

.. code-block:: php

    <?php

    use Phalcon\Validation\Message;
    use Phalcon\Validation\Validator;
    use Phalcon\Validation\ValidatorInterface;

    class IpValidator extends Validator implements ValidatorInterface
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

                $message = $this->getOption('message');
                if (!$message) {
                    $message = 'IP адрес не правилен';
                }

                $validator->appendMessage(new Message($message, $attribute, 'Ip'));

                return false;
            }

            return true;
        }
    }

Важно помнить, что валидаторы возвращают булево значение, показывающее, прошла валидация успешно, либо нет.

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
        foreach ($validation->getMessages() as $message) {
            echo "Сообщение: ", $message->getMessage(), "\n";
            echo "Поле: ", $message->getField(), "\n";
            echo "Тип: ", $message->getType(), "\n";
        }
    }

Метод getMessages() может быть переопределен в наследующем классе для замены/перевода текста сообщения по умолчанию, это особенно актуально для автоматически создаваемых валидаторов:

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
                        $messages[] = 'Заполнение поля ' . $message->getField() . ' обязательно';
                        break;
                }
            }

            return $messages;
        }
    }

Или вы можете передать сообщение параметром по умолчанию в каждый валидатор:

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

По умолчанию метод 'getMessages' возвращает все сообщения сгенерированные валидатором. Вы можете отфильтровать
сообщения используя 'filter':

.. code-block:: php

    <?php

    $messages = $validation->validate();
    if (count($messages)) {
        // Отфильтровать только те сообщения, которые были сгенерированы для поля 'name'
        foreach ($validation->getMessages()->filter('name') as $message) {
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

    $validation
        ->add('name', new PresenceOf(array(
            'message' => 'The name is required'
        )))
        ->add('email', new PresenceOf(array(
            'message' => 'The email is required'
        )));

    // Избавимся от лишних пробелов
    $validation->setFilters('name', 'trim');
    $validation->setFilters('email', 'trim');

Фильтрация и очистка производятся с помощью компонента :doc:`filter <filter>`. Вы можете добавлять в него свои фильтры,
либо пользоваться встроенными.

События валидации
-----------------
Когда в классах определена валидация, вы также можете реализовать методы 'beforeValidation' и 'afterValidation', чтобы
добавить дополнительные проверки, очистку и т.п. Если 'beforeValidation' возвращает 'false', валидация не будет пройдена:

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
            if ($this->request->getHttpHost() != 'admin.mydomain.com') {
                $messages->appendMessage(new Message('Only users can log on in the administration domain'));

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

Первый валидатор имеет свойство 'cancelOnFail' => true, поэтому если валидация не пройдёт эту проверку, то
дальнейшие проверки в цепочке не будут выполнены.

Если вы создаёте собственные валидаторы, то можете динамически останавливать их используя свойство 'cancelOnFail':

.. code-block:: php

    <?php

    use Phalcon\Validation;
    use Phalcon\Validation\Message;
    use Phalcon\Validation\Validator;
    use Phalcon\Validation\ValidatorInterface;

    class MyValidator extends Validator implements ValidatorInterface
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
