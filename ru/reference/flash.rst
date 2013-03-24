Всплывающие сообщения
=====================
Всплывающие сообщения используются для уведомления пользователей о состоянии действий, которые он/она сделал или просто
показывает информацию пользователям.
Такой тип сообщений может быть сгенерирован с помощью этого компонента.

Адаптеры
--------
Этот компонент включает в себя несколько адаптеров, чтобы определить поведений сообщений:

+---------+----------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Адаптер | Описание                                                                   | API                                                                        |
+=========+============================================================================+============================================================================+
| Direct  | Выводит сообщение напрямую пользователю                                    | :doc:`Phalcon\\Flash\\Direct <../api/Phalcon_Flash_Direct>`                |
+---------+----------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Session | Времено сохраняет сообщения в сессию для вывода в следующем запросе        | :doc:`Phalcon\\Flash\\Session <../api/Phalcon_Flash_Session>`              |
+---------+----------------------------------------------------------------------------+----------------------------------------------------------------------------+

Использование
-------------
Обычно компонент всплывающих сообщений доступен и контейнера сервисов, если вы используете :doc:`Phalcon\\DI\\FactoryDefault <../api/Phalcon_DI_FactoryDefault>`
то :doc:`Phalcon\\Flash\\Direct <../api/Phalcon_Flash_Direct>` будет автоматически зарегистрирован как "flash" сервис:

.. code-block:: php

    <?php

    // Устанавливаем сервис
    $di->set('flash', function() {
        return new \Phalcon\Flash\Direct();
    });

Таким образом вы можете использовать его в контроллерах или в представлениях (view):

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function saveAction()
        {
            $this->flash->success("The post was correctly saved!");
        }

    }

Существует четыре типа встроенных сообщений:

.. code-block:: php

    <?php

    $this->flash->error("too bad! the form had errors");
    $this->flash->success("yes!, everything went very smoothly");
    $this->flash->notice("this a very important information");
    $this->flash->warning("best check yo self, you're not looking too good.");

Вы можете добавлять сообщения со своими типами:

.. code-block:: php

    <?php

    $this->flash->message("debug", "this is debug message, you don't say");

Вывод сообщений
---------------
Сообщения посланные в компонент автоматически форматируются с html:

.. code-block:: html

    <div class="errorMessage">too bad! the form had errors</div>
    <div class="successMessage">yes!, everything went very smoothly</div>
    <div class="noticeMessage">this a very important information</div>
    <div class="warningMessage">best check yo self, you're not looking too good.</div>

Как видно на примере выше - используются некоторые CSS классы, которые автоматически добавляются в тег 'DIV'. Эти классы позволяют вам
видоизменять вывод сообщений. CSS классы могут быть изменены, например, если вы используете Twitter Bootstrap, то можно указать следующие классы:

.. code-block:: php

    <?php

    // Регистрируем компонент сообщений с CSS классами
    $di->set('flash', function(){
        $flash = new \Phalcon\Flash\Direct(array(
            'error' => 'alert alert-error',
            'success' => 'alert alert-success',
            'notice' => 'alert alert-info',
        ));
        return $flash;
    });

После этого сообщение будут выводится таким образом:

.. code-block:: html

    <div class="alert alert-error">too bad! the form had errors</div>
    <div class="alert alert-success">yes!, everything went very smoothly</div>
    <div class="alert alert-info">this a very important information</div>

Понимание разницы между адаптерами Direct и Session
---------------------------------------------------
В зависимости от адаптера, используемого для отправки сообщений вывод будет производится сразу или временно сохраняться в сессии для дальнейшего вывода.
В каких случаях надо их использовать? Это обычно зависит от типа перенаправления, которое вы делаете после отправки сообщения.
Например, если вы делаете прямой вывод (или внутреннее перенаправление), то сохранять в сессии нет необходимости, но если вы делаете HTTP перенаправление, то
сообщения необходимо сохранить в сессии, чтобы их можно было позже вывести пользователю:

.. code-block:: php

    <?php

    class ContactController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function saveAction()
        {

            // сохраняем объект в бд

            // Выводим прямое сообщение
            $this->flash->success("Your information were stored correctly!");

            // Делаем внутреннее перенапрвляем на другое действие
            return $this->dispatcher->forward(array("action" => "index"));
        }

    }

Или используя HTTP перенаправление:

.. code-block:: php

    <?php

    class ContactController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function saveAction()
        {

            // сохраняем объект в бд

            // Отправляем сообщение в сессию
            $this->flashSession->success("Your information were stored correctly!");

            // Делаем полное HTTP перенаправление
            return $this->response->redirect("contact/index");
        }

    }

В таком случае вам необходимо в ручную вывести сообщение в соответствующем представлении:

.. code-block:: html+php

    <!-- app/views/contact/index.phtml -->

    <p><?php $this->flashSession->output() ?></p>

Атрибут 'flashSession' означает, каким способом изначально был задан компонент в контейнере сервисов.
Вам необходимо запустить :doc:`session <session>`, чтобы успешно использовать сообщения из сессии.
