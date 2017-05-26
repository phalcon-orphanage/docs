Использование контроллеров
==========================

Контроллеры содержат в себе ряд методов, называемых действиями (actions). Действия контроллеров занимаются непосредственно обработкой запросов. По умолчанию все
публичные методы контролеров доступны для доступа по URL. Действия отвечают за разбор запросов (request) и создание
ответов (response). Как правило, результаты работы действий используются для представлений, но так же возможно их иное использование.

Например, при обращении по ссылке: http://localhost/blog/posts/show/2015/the-post-title Phalcon разберёт её и получит
следующие части:

+-----------------------+----------------+
| **Каталог Phalcon**   | blog           |
+-----------------------+----------------+
| **Контроллер**        | posts          |
+-----------------------+----------------+
| **Действие**          | show           |
+-----------------------+----------------+
| **Параметр**          | 2015           |
+-----------------------+----------------+
| **Параметр**          | the-post-title |
+-----------------------+----------------+

Для этого случая запрос будет отправлен для обработки в контроллер PostsController. Для контроллеров нет какого-то специального места в приложении, они
загружаются с помощью :doc:`автозагрузки <loader>`, поэтому вы можете организовать их так, как вам необходимо.

Контроллеры должны иметь суффикс "Controller", а действия, соответственно, "Action". Пример контроллера:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function showAction($year, $postTitle)
        {

        }
    }

Дополнительные параметры в ссылке передаются в качестве параметров действия, таким образом, они легко могут быть получены как локальные переменные. Контроллер может
наследоваться от :doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>`. В таком случае он получает доступ к
сервисам приложения.

Параметры без значений по умолчанию являются обязательными. Установка значений по умолчанию производится по PHP стандартам:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function showAction($year = 2015, $postTitle = "другой заголовок по умолчанию")
        {

        }
    }

Параметры присваиваются в том же порядке, в каком и были переданы. Получить доступ к произвольному параметру можно следующим образом:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function showAction()
        {
            $year      = $this->dispatcher->getParam("year");
            $postTitle = $this->dispatcher->getParam("postTitle");
        }
    }

Цикл работы
-----------
Цикл работы диспетчера выполняется до тех пор, пока не останется действий для обработки. В примере выше выполняется лишь одно
действие. Пример ниже показывает, как с использованием метода :code:`forward()` можно обеспечить более сложный процесс диспетчеризации путём перенаправления
потока выполнения на другой контроллер/действие.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function showAction($year, $postTitle)
        {
            $this->flash->error(
                "У вас недостаточно прав для выполнения этого действия"
            );

            // Перенаправляем на другое действие
            $this->dispatcher->forward(
                [
                    "controller" => "users",
                    "action"     => "signin",
                ]
            );
        }
    }

Если у пользователя недостаточно прав, он будет перенаправлен в контроллер Users для выполнения авторизации.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class UsersController extends Controller
    {
        public function indexAction()
        {

        }

        public function signinAction()
        {

        }
    }

Метод "forward" может быть вызван неограниченное количество раз, приложение будет выполняться, пока не появится явный сигнал для завершения.
Если действия, которые должны быть выполнены, в цикле диспетчера завершены, то диспетчер автоматически вызовет
MVC слой отображения (View), управляемый компонентом :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`.

Инициализация контроллеров
--------------------------
:doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>` предлагает метод :code:`initialize()`, который автоматически выполняется первым, перед любым другим
действием контроллера. Использование метода :code:`__construct()` не рекомендуется.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public $settings;

        public function initialize()
        {
            $this->settings = [
                "mySetting" => "value",
            ];
        }

        public function saveAction()
        {
            if ($this->settings["mySetting"] === "value") {
                // ...
            }
        }
    }

.. highlights::

    Метод :code:`initialize()` вызывается только в том случае, если событие 'beforeExecuteRoute' было успешно выполнено. Это позволяет избежать
    выполнения логики приложения без авторизации.

Если вы все же хотите выполнить некоторую инициализацию после создания объекта контроллера, то можете реализовать
метод :code:`onConstruct()`:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function onConstruct()
        {
            // ...
        }
    }

.. highlights::

    Знайте, что метод :code:`onConstruct()` выполняется, даже если действие, которое должно быть выполнено, не существует
    в контроллере, или пользователь не имеет к нему доступа (контроль доступа
    обеспечивает разработчик).

Внедрение сервисов
------------------
Если контроллер наследует :doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>`, то он автоматически получает доступ к
контейнеру сервисов приложения. Например, в приложении имеется зарегистрированный сервис с именем "storage":

.. code-block:: php

    <?php

    use Phalcon\Di;

    $di = new Di();

    $di->set(
        "storage",
        function () {
            return new Storage(
                "/some/directory"
            );
        },
        true
    );

Доступ к этому сервису можно получить несколькими способами:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class FilesController extends Controller
    {
        public function saveAction()
        {
            // Прямой доступ по имени, используя его как свойство
            $this->storage->save("/some/file");

            // С использованием сервиса DI
            $this->di->get("storage")->save("/some/file");

            // Используя магический метод
            $this->di->getStorage()->save("/some/file");

            // Еще больше магических методов для получения всей цепочки
            $this->getDi()->getStorage()->save("/some/file");

            // Используя синтаксис работы с массивами
            $this->di["storage"]->save("/some/file");
        }
    }

Если вы используете все возможности Phalcon, прочитайте о сервисах :doc:`используемых по умолчанию <di>`.

Запрос и ответ
--------------
Давайте предположим, что фреймворк предоставляет набор предварительно зарегистрированных сервисов. В этом примере будет показано как работать с параметрами HTTP.
Сервис "request" содержит экземпляр :doc:`Phalcon\\Http\\Request <../api/Phalcon_Http_Request>`, а "response" -
экземпляр :doc:`Phalcon\\Http\\Response <../api/Phalcon_Http_Response>`, являющийся тем, что должно быть отправлено клиенту.

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
            // Проверяем, что данные пришли методом POST
            if ($this->request->isPost()) {
                // Получаем POST данные
                $customerName = $this->request->getPost("name");
                $customerBorn = $this->request->getPost("born");
            }
        }
    }

Объект ответа обычно не используется напрямую и создается до выполнения действия, но иногда, например, в
событии afterDispatch может быть полезно работать с ответом напрямую:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function notFoundAction()
        {
            // Отправляем статус HTTP 404
            $this->response->setStatusCode(404, "Not Found");
        }
    }

Получить подробности о работе с HTTP можно в соответствующих статьях :doc:`request <request>` и :doc:`response <response>`.

Данные сессий
-------------
Сессии позволяют сохранять данные между запросами. Вы можете получить доступ к :doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>`
из любого контроллера, чтобы сохранить данные, которые должны быть постоянными.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class UserController extends Controller
    {
        public function indexAction()
        {
            $this->persistent->name = "Михаил";
        }

        public function welcomeAction()
        {
            echo "Привет, ", $this->persistent->name;
        }
    }

Использование сервисов как контроллеров
---------------------------------------
Сервисы могут работать в качестве контроллеров, классы контроллеров первым делом запрашиваются у сервиса контейнеров. Соответственно
любой класс, зарегистрированный под именем контроллера, легко может его заменить:

.. code-block:: php

    <?php

    // Регистрируем контроллер как сервис
    $di->set(
        "IndexController",
        function () {
            $component = new Component();

            return $component;
        }
    );

    // Регистрируем контроллер из пространства имен в качестве сервиса
    $di->set(
        "Backend\\Controllers\\IndexController",
        function () {
            $component = new Component();

            return $component;
        }
    );

События контроллеров
--------------------
Контроллеры автоматически выступают в роли слушателей событий :doc:`диспетчера <dispatching>`, реализация методов с названиями событий позволяет
выполнять какой-либо код до или после выполнения действия:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function beforeExecuteRoute($dispatcher)
        {
            // Выполняется до запуска любого найденного действия
            if ($dispatcher->getActionName() === "save") {
                $this->flash->error(
                    "У вас недостаточно прав для сохранения записей"
                );

                $this->dispatcher->forward(
                    [
                        "controller" => "home",
                        "action"     => "index",
                    ]
                );

                return false;
            }
        }

        public function afterExecuteRoute($dispatcher)
        {
            // Выполняется после каждого выполненного действия
        }
    }

.. _DRY: https://ru.wikipedia.org/wiki/Don%E2%80%99t_repeat_yourself
