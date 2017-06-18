Forms
=====

Компонент :code:`Phalcon\Forms` позволяет создавать и управлять формами вашего приложения.

Ниже представлен базовый пример работы с формами:

.. code-block:: php

    <?php

    use Phalcon\Forms\Form;
    use Phalcon\Forms\Element\Text;
    use Phalcon\Forms\Element\Select;

    $form = new Form();

    $form->add(
        new Text(
            "name"
        )
    );

    $form->add(
        new Text(
            "telephone"
        )
    );

    $form->add(
        new Select(
            "telephoneType",
            [
                "H" => "Home",
                "C" => "Cell",
            ]
        )
    );

Элементы форм выводятся по указанным при создании именам:

.. code-block:: html+php

    <h1>
        Контакты
    </h1>

    <form method="post">

        <p>
            <label>
                Имя
            </label>

            <?php echo $form->render("name"); ?>
        </p>

        <p>
            <label>
                Телефон
            </label>

            <?php echo $form->render("telephone"); ?>
        </p>

        <p>
            <label>
                Тип телефона
            </label>

            <?php echo $form->render("telephoneType"); ?>
        </p>



        <p>
            <input type="submit" value="Сохранить" />
        </p>

    </form>

Каждый элемент формы может быть настроен по желанию разработчика. Внутри компонент использует возможности
:doc:`Phalcon\\Tag <../api/Phalcon_Tag>` для генерации HTML кода каждого документа, вы можете передавать дополнительные
html-атрибуты вторым параметром:

.. code-block:: html+php

    <p>
        <label>
            Имя
        </label>

        <?php echo $form->render("name", ["maxlength" => 30, "placeholder" => "Введите своё имя"]); ?>
    </p>

Атрибуты HTML могут быть указаны в параметрах при создании элемента:

.. code-block:: php

    <?php

    $form->add(
        new Text(
            "name",
            [
                "maxlength"   => 30,
                "placeholder" => "Введите своё имя",
            ]
        )
    );

Инициализация
-------------
Как уже говорилось ранее, формы могут быть инициализированы вне форм класса путем добавления элементов к нему. Вы можете повторно использовать
код или организовать формы собранные из разных файлов:

.. code-block:: php

    <?php

    use Phalcon\Forms\Form;
    use Phalcon\Forms\Element\Text;
    use Phalcon\Forms\Element\Select;

    class ContactForm extends Form
    {
        public function initialize()
        {
            $this->add(
                new Text(
                    "name"
                )
            );

            $this->add(
                new Text(
                    "telephone"
                )
            );

            $this->add(
                new Select(
                    "telephoneType",
                    TelephoneTypes::find(),
                    [
                        "using" => [
                            "id",
                            "name",
                        ]
                    ]
                )
            );
        }
    }

Формы :doc:`Phalcon\\Forms\\Form <../api/Phalcon_Forms_Form>` наследуются от :doc:`Phalcon\\Di\\Injectable <../api/Phalcon_Di_Injectable>`,
предоставляя доступ к службам приложения, если это необходимо:

.. code-block:: php

    <?php

    use Phalcon\Forms\Form;
    use Phalcon\Forms\Element\Text;
    use Phalcon\Forms\Element\Hidden;

    class ContactForm extends Form
    {
        /**
         * Этот метод возвращает значение по умолчанию для поля 'csrf'
         */
        public function getCsrf()
        {
            return $this->security->getToken();
        }

        public function initialize()
        {
            // Установка сущности
            $this->setEntity($this);

            // Установка поля 'email'
            $this->add(
                new Text(
                    "email"
                )
            );

            // Добавление скрытого поля CSRF
            $this->add(
                new Hidden(
                    "csrf"
                )
            );
        }
    }

При инициализации формы в конструктор передаётся объект пользователя и другие параметры:

.. code-block:: php

    <?php

    use Phalcon\Forms\Form;
    use Phalcon\Forms\Element\Text;
    use Phalcon\Forms\Element\Hidden;

    class UsersForm extends Form
    {
        /**
         * Инициализация формы
         *
         * @param Users $user
         * @param array $options
         */
        public function initialize(Users $user, array $options)
        {
            if ($options["edit"]) {
                $this->add(
                    new Hidden(
                        "id"
                    )
                );
            } else {
                $this->add(
                    new Text(
                        "id"
                    )
                );
            }

            $this->add(
                new Text(
                    "name"
                )
            );
        }
    }

Теперь можно использовать экземпляр формы:

.. code-block:: php

    <?php

    $form = new UsersForm(
        new Users(),
        [
            "edit" => true,
        ]
    );

Валидация
---------
Формы в Phalcon интегрированы с компонентом :doc:`валидации <validation>` для быстрой проверки введённых данных. Для каждого элемента формы можно
устанавливать готовый или настраиваемый валидатор:

.. code-block:: php

    <?php

    use Phalcon\Forms\Element\Text;
    use Phalcon\Validation\Validator\PresenceOf;
    use Phalcon\Validation\Validator\StringLength;

    $name = new Text(
        "name"
    );

    $name->addValidator(
        new PresenceOf(
            [
                "message" => "Поле Name обязательно для заполнения",
            ]
        )
    );

    $name->addValidator(
        new StringLength(
            [
                "min"            => 10,
                "messageMinimum" => "Значение поля Name слишком короткое",
            ]
        )
    );

    $form->add($name);

Затем вы сможете проверить правильность заполнения формы пользователем:

.. code-block:: php

    <?php

    if (!$form->isValid($_POST)) {
        $messages = $form->getMessages();

        foreach ($messages as $message) {
            echo $message, "<br>";
        }
    }

Валидаторы выполняются в порядке регистрации.

По умолчанию, сообщения, генерируемые всеми элементами формы, объединены, чтобы их можно было собрать одним проходом foreach,
вы можете изменить это поведение, чтобы получить сообщения, разделенные по типам:

.. code-block:: php

    <?php

    foreach ($form->getMessages(false) as $attribute => $messages) {
        echo "Messages generated by ", $attribute, ":", "\n";

        foreach ($messages as $message) {
            echo $message, "<br>";
        }
    }

Так же можно получить сообщения конкретного элемента:

.. code-block:: php

    <?php

    $messages = $form->getMessagesFor("name");

    foreach ($messages as $message) {
        echo $message, "<br>";
    }

Фильтрация
----------
Форма может фильтровать данные до валидации, вы можете установить фильтры в каждом из элементов:

.. code-block:: php

    <?php

    use Phalcon\Forms\Element\Text;

    $name = new Text(
        "name"
    );

    // Set multiple filters
    $name->setFilters(
        [
            "string",
            "trim",
        ]
    );

    $form->add($name);



    $email = new Text(
        "email"
    );

    // Set one filter
    $email->setFilters(
        "email"
    );

    $form->add($email);

.. highlights::

    Learn more about filtering in Phalcon by reading the :doc:`Filter documentation <filter>`.

Формы и сущности
----------------
Модели или коллекции являются такими сущностями, которые можно без проблем связать с формами, их значения в таком случае будут использоваться
по умолчанию для соответствующих по именам значений элементов форм. Всё это делается очень легко:

.. code-block:: php

    <?php

    $robot = Robots::findFirst();

    $form = new Form($robot);

    $form->add(
        new Text(
            "name"
        )
    );

    $form->add(
        new Text(
            "year"
        )
    );

При отображении формы, если нет значений по умолчанию для элементов, будут использованы значения из сущностей:

.. code-block:: html+php

    <?php echo $form->render("name"); ?>

Проверить введённые пользователем значения в форму можно следующим образом:

.. code-block:: php

    <?php

    $form->bind($_POST, $robot);

    // Проверка правильности введённых данных формы
    if ($form->isValid()) {
        // Сохранение сущности
        $robot->save();
    }

Установка обычного класса в качестве сущности тоже возможна:

.. code-block:: php

    <?php

    class Preferences
    {
        public $timezone = "Europe/Amsterdam";

        public $receiveEmails = "No";
    }

Использование данного класса в виде сущности позволяет форме брать из него значения по умолчанию:

.. code-block:: php

    <?php

    $form = new Form(
        new Preferences()
    );

    $form->add(
        new Select(
            "timezone",
            [
                "America/New_York"  => "New York",
                "Europe/Amsterdam"  => "Amsterdam",
                "America/Sao_Paulo" => "Sao Paulo",
                "Asia/Tokyo"        => "Tokyo",
            ]
        )
    );

    $form->add(
        new Select(
            "receiveEmails",
            [
                "Yes" => "Yes, please!",
                "No"  => "No, thanks",
            ]
        )
    );

Сущности могут содержать геттеры, приоритет которых выше, чем у публичных свойств. Эти методы
дают вам больше свободы для работы со значениями:

.. code-block:: php

    <?php

    class Preferences
    {
        public $timezone;

        public $receiveEmails;



        public function getTimezone()
        {
            return "Europe/Amsterdam";
        }

        public function getReceiveEmails()
        {
            return "No";
        }
    }

Элементы форм
-------------
Phalcon предоставляет набор элементов для использования в ваших формах:

+----------------------------------------------------------------------------------+--------------------------------------------------+
| Название                                                                         | Описание                                         |
+==================================================================================+==================================================+
| :doc:`Phalcon\\Forms\\Element\\Text <../api/Phalcon_Forms_Element_Text>`         | Генерирует элемент INPUT[type=text]              |
+----------------------------------------------------------------------------------+--------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Password <../api/Phalcon_Forms_Element_Password>` | Генерирует элемент INPUT[type=password]          |
+----------------------------------------------------------------------------------+--------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Select <../api/Phalcon_Forms_Element_Select>`     | Генерирует элемент раскрывающегося списка SELECT |
+----------------------------------------------------------------------------------+--------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Check <../api/Phalcon_Forms_Element_Check>`       | Генерирует элемент INPUT[type=check]             |
+----------------------------------------------------------------------------------+--------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\TextArea <../api/Phalcon_Forms_Element_TextArea>` | Генерирует элемент TEXTAREA                      |
+----------------------------------------------------------------------------------+--------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Hidden <../api/Phalcon_Forms_Element_Hidden>`     | Генерирует элемент INPUT[type=hidden]            |
+----------------------------------------------------------------------------------+--------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\File <../api/Phalcon_Forms_Element_File>`         | Генерирует элемент INPUT[type=file]              |
+----------------------------------------------------------------------------------+--------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Date <../api/Phalcon_Forms_Element_Date>`         | Генерирует элемент INPUT[type=date]              |
+----------------------------------------------------------------------------------+--------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Numeric <../api/Phalcon_Forms_Element_Numeric>`   | Генерирует элемент INPUT[type=number]            |
+----------------------------------------------------------------------------------+--------------------------------------------------+
| :doc:`Phalcon\\Forms\\Element\\Submit <../api/Phalcon_Forms_Element_Submit>`     | Генерирует элемент INPUT[type=submit]            |
+----------------------------------------------------------------------------------+--------------------------------------------------+

Дополнительные условия
----------------------
Когда формы реализованы в виде классов, в них могут быть определены функции обратного вызова:
beforeValidation и afterValidation. Данные методы позволяют осуществлять проверки до и после валидации соответственно:

.. code-block:: html+php

    <?php

    use Phalcon\Forms\Form;

    class ContactForm extends Form
    {
        public function beforeValidation()
        {

        }
    }

Отрисовка форм
--------------
Вы можете гибко отрисовывать формы. Данный пример показывает, как отрисовать каждый элемент, используя стандартную процедуру:

.. code-block:: html+php

    <?php

    <form method="post">
        <?php

            // Проходим через форму
            foreach ($form as $element) {
                // Собираем все сгенерированные сообщения для текущего элемента
                $messages = $form->getMessagesFor(
                    $element->getName()
                );

                if (count($messages)) {
                    // Выводим каждый элемент
                    echo '<div class="messages">';

                    foreach ($messages as $message) {
                        echo $message;
                    }

                    echo "</div>";
                }

                echo "<p>";

                echo '<label for="', $element->getName(), '">', $element->getLabel(), "</label>";

                echo $element;

                echo "</p>";
            }

        ?>

        <input type="submit" value="Send" />
    </form>

Или повторно использовать логику в классе формы:

.. code-block:: php

    <?php

    use Phalcon\Forms\Form;

    class ContactForm extends Form
    {
        public function initialize()
        {
            // ...
        }

        public function renderDecorated($name)
        {
            $element  = $this->get($name);

            // Собираем все сгенерированные сообщения для текущего элемента
            $messages = $this->getMessagesFor(
                $element->getName()
            );

            if (count($messages)) {
                // Выводим каждый элемент
                echo '<div class="messages">';

                foreach ($messages as $message) {
                    echo $this->flash->error($message);
                }

                echo "</div>";
            }

            echo "<p>";

            echo '<label for="', $element->getName(), '">', $element->getLabel(), "</label>";

            echo $element;

            echo "</p>";
        }
    }

В представлении:

.. code-block:: php

    <?php

    echo $element->renderDecorated("name");

    echo $element->renderDecorated("telephone");

Создание элементов форм
-----------------------
В дополнение к элементам форм, которые предоставляет Phalcon, вы можете создавать свои собственные элементы:

.. code-block:: php

    <?php

    use Phalcon\Forms\Element;

    class MyElement extends Element
    {
        public function render($attributes = null)
        {
            $html = // ... немного HTML-кода

            return $html;
        }
    }

Менеджер форм
-------------
Этот компонент предоставляет доступ к менеджеру форм, который может быть использован разработчиком для регистрации форм
и доступа к ним через сервис локатор:

.. code-block:: php

    <?php

    use Phalcon\Forms\Manager as FormsManager;

    $di["forms"] = function () {
        return new FormsManager();
    };

Формы добавляются к менеджеру форм и в дальнейшем могут быть доступны через уникальное имя:

.. code-block:: php

    <?php

    $this->forms->set(
        "login",
        new LoginForm()
    );

С помощью уникального имени формы могут быть доступны в любой части приложения:

.. code-block:: php

    <?php

    $loginForm = $this->forms->get("login");

    echo $loginForm->render();

Внешние источники
-----------------
* `Vökuró <http://vokuro.phalconphp.com>`_, простое приложение, которое использует конструктор форм для создания форм в приложении, [`Github <https://github.com/phalcon/vokuro>`_]
