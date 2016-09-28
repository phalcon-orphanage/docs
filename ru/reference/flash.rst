Информационные сообщения
========================

Информационные сообщения используются для уведомления пользователей о состоянии выполненных действий или просто
показывают необходимую информацию.
Такой тип сообщений может быть сгенерирован с помощью этого компонента.

Адаптеры
--------
Этот компонент включает в себя несколько адаптеров, чтобы определить поведение сообщения:

+---------+----------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Адаптер | Описание                                                                   | API                                                                        |
+=========+============================================================================+============================================================================+
| Direct  | Выводит сообщение напрямую пользователю                                    | :doc:`Phalcon\\Flash\\Direct <../api/Phalcon_Flash_Direct>`                |
+---------+----------------------------------------------------------------------------+----------------------------------------------------------------------------+
| Session | Временно сохраняет сообщения в сессию для вывода в следующем запросе       | :doc:`Phalcon\\Flash\\Session <../api/Phalcon_Flash_Session>`              |
+---------+----------------------------------------------------------------------------+----------------------------------------------------------------------------+

Использование
-------------
Обычно компонент всплывающих сообщений доступен из контейнера сервисов.
Если вы используете :doc:`Phalcon\\Di\\FactoryDefault <../api/Phalcon_Di_FactoryDefault>`,
то :doc:`Phalcon\\Flash\\Direct <../api/Phalcon_Flash_Direct>` будет автоматически зарегистрирован как "flash" сервис и
:doc:`Phalcon\\Flash\\Session <../api/Phalcon_Flash_Session>` будет автоматически зарегистрирован как "flashSession" сервис.
You can also manually register it:

.. code-block:: php

    <?php

    use Phalcon\Flash\Direct as FlashDirect;
    use Phalcon\Flash\Session as FlashSession;

    // Устанавливаем сервис
    $di->set(
        "flash",
        function () {
            return new FlashDirect();
        }
    );

    // Set up the flash session service
    $di->set(
        "flashSession",
        function () {
            return new FlashSession();
        }
    );

Таким образом, вы можете использовать его в контроллерах или в представлениях (view):

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
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

Вы также можете добавлять сообщения со своими типами с помощью: код: `сообщение ()` метод:

.. code-block:: php

    <?php

    $this->flash->message("debug", "this is debug message, you don't say");

Вывод сообщений
---------------
Сообщения, посланные в компонент, автоматически форматируются с html:

.. code-block:: html

    <div class="errorMessage">too bad! the form had errors</div>

    <div class="successMessage">yes!, everything went very smoothly</div>

    <div class="noticeMessage">this a very important information</div>

    <div class="warningMessage">best check yo self, you're not looking too good.</div>

Как видно на примере выше - используются некоторые CSS классы, которые автоматически добавляются в тег :code:`<div>`. Эти классы позволяют вам
видоизменять вывод сообщений. CSS классы могут быть изменены, например, если вы используете Twitter Bootstrap, то можно указать следующие классы:

.. code-block:: php

    <?php

    use Phalcon\Flash\Direct as FlashDirect;

    // Регистрируем компонент сообщений с CSS классами
    $di->set(
        "flash",
        function () {
            $flash = new FlashDirect(
                [
                    "error"   => "alert alert-danger",
                    "success" => "alert alert-success",
                    "notice"  => "alert alert-info",
                    "warning" => "alert alert-warning",
                ]
            );

            return $flash;
        }
    );

После этого сообщения будут выводиться таким образом:

.. code-block:: html

    <div class="alert alert-danger">too bad! the form had errors</div>

    <div class="alert alert-success">yes!, everything went very smoothly</div>

    <div class="alert alert-info">this a very important information</div>

    <div class="alert alert-warning">best check yo self, you're not looking too good.</div>

Понимание разницы между адаптерами Direct и Session
---------------------------------------------------
В зависимости от адаптера, используемого для отправки сообщений, вывод будет производиться сразу или временно сохраняться в сессии для дальнейшего вывода.
В каких случаях надо их использовать? Это обычно зависит от типа перенаправления, которое вы делаете после отправки сообщения.
Например, если вы делаете прямой вывод (или внутреннее перенаправление), то сохранять в сессии нет необходимости, но если вы делаете HTTP-перенаправление, то
сообщения необходимо сохранить в сессии, чтобы их можно было позже вывести пользователю:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class ContactController extends Controller
    {
        public function indexAction()
        {

        }

        public function saveAction()
        {
            // Сохраняем объект в БД

            // Выводим прямое сообщение
            $this->flash->success("Your information was stored correctly!");

            // Делаем внутреннее перенаправление на другое действие
            return $this->dispatcher->forward(
                [
                    "action" => "index"
                ]
            );
        }
    }

Или используя HTTP-перенаправление:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class ContactController extends Controller
    {
        public function indexAction()
        {

        }

        public function saveAction()
        {
            // Сохраняем объект в БД

            // Отправляем сообщение в сессию
            $this->flashSession->success("Your information was stored correctly!");

            // Делаем полное HTTP-перенаправление
            return $this->response->redirect("contact/index");
        }
    }

В таком случае вам необходимо вручную вывести сообщение в соответствующем представлении:

.. code-block:: html+php

    <!-- app/views/contact/index.phtml -->

    <p><?php $this->flashSession->output() ?></p>

Атрибут 'flashSession' означает, каким способом изначально был задан компонент в контейнере сервисов.
Вам необходимо запустить :doc:`сессии <session>`, чтобы успешно использовать такой тип сообщений.
