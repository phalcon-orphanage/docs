Использование контроллеров
==========================
Контроллеры содержат в себе ряд методов, называемых действиями (actions). Действия контроллеров занимаются непосредственно обработкой запросов.
По умолчанию все публичные методы контролеров доступны для доступа по URL. Действия отвечают за разбор запросов (request) и создание ответов (response).
Как правило, результаты работы действий используются для представлений, но так же возможно их иное использование.

Например, при обращении по ссылке: http://localhost/blog/posts/show/2012/the-post-title Phalcon разберёт её и получит следующие части:

+----------------------------+----------------+
| **Подкаталог Phalcon**     | blog           |
+----------------------------+----------------+
| **Контроллер/Controller**  | posts          |
+----------------------------+----------------+
| **Действие/Action**        | show           |
+----------------------------+----------------+
| **Параметр**               | 2012           |
+----------------------------+----------------+
| **Параметр**               | the-post-title |
+----------------------------+----------------+

Для этого случая запрос будет отправлен для обработки в контроллер PostsController. Для контроллеров не существует специального места, в приложениях
они загружаются с помощью :doc:`автозагрузки <loader>`, поэтому вы можете организовывать их в любую удобную структуру.

Контроллеры должны иметь суффикс "Controller", а действия, соответственно, "Action". Пример контроллера:

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function showAction($year, $postTitle)
        {

        }

    }

Параметры, определённые в ссылках (URI) передаются в качестве параметров действий, и легко могут быть доступны для локального использования.
Контроллеры могут наследоваться от :doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>`, в таком случае в них можно использовать
лёгкий способ получения сервисов приложения.

Параметры без значений по умолчанию обрабатываются по мере необходимости. Установка дополнительных значений производится по PHP стандартам:

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function showAction($year=2012, $postTitle='другой заголовок по умолчанию')
        {

        }

    }

Параметры поступают в порядке указанном в правиле маршрутизации (route). Получить доступ к произвольному параметру можно следующим образом:

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function showAction()
        {
            $year = $this->dispatcher->getParam('year');
            $postTitle = $this->dispatcher->getParam('postTitle');
        }

    }


Цикл работы
-----------
Цикл работы диспетчера выполняться пока не будет явно остановлен. В примере выше выполняется лишь одно действие. Пример ниже показывает как
с использованием метода "forward" можно обеспечить более сложный процесс диспетчеризации, путём перенаправления потока на другой контроллер/действие.

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function showAction($year, $postTitle)
        {
            $this->flash->error("У вас недостаточно прав для выполнения этого действия");

            // Перенаправление на другое действие
            $this->dispatcher->forward(array(
                "controller" => "users",
                "action" => "signin"
            ));
        }

    }

Если у пользователя недостаточно прав, он будет перенаправлен в контроллер пользователей для выполнения авторизации.

.. code-block:: php

    <?php

    class UsersController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function signinAction()
        {

        }

    }

Метод "forwards" может быть вызван неограниченное количество раз, приложение будет выполняться, пока не появится явный сигнал для завершения.
Если действия, которые должны быть выполнены, в цикле диспетчера завершены, то диспетчер автоматически вызовет MVC слой отображения (View),
управляемый компонентом :doc:`Phalcon\\Mvc\\View <../api/Phalcon_Mvc_View>`.

Инициализация контроллеров
--------------------------
Сервис :doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>` предполагает наличие метода инициализации "initialize", автоматически выполняемого
первым, перед любым другим действием контроллера. Использование метода "__construct" не рекомендуется.

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public $settings;

        public function initialize()
        {
            $this->settings = array(
                "mySetting" => "value"
            );
        }

        public function saveAction()
        {
            if ($this->settings["mySetting"] == "value") {
                //...
            }
        }

    }

.. highlights::

    Метод 'initialize' вызывается только в том случаи, если событие 'beforeExecuteRoute' было успешно выполнено. 
    Это позволяет избежать выполнения логики приложения без авторизации.

Если вы хотите выполнить инициализацию логики сразу после создания объекта контроллера, то можно реализовать 
метод 'onConstruct':

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function onConstruct()
        {
            //...
        }
    }

.. highlights::

    Знайте, что метод 'onConstruct' выполняется, даже если Action, который будет выполняться, не существует 
    в контроллере или пользователь не имеет к нему доступа (контроль доступа обеспечивает разработчик).

Внедрение сервисов / Injecting Services
---------------------------------------
Если контроллер использует наследование от :doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>`, то в нём можно использовать
лёгкий способ получения любых сервисов приложения. Например, в приложении имеется зарегистрированный сервис с именем "storage":

.. code-block:: php

    <?php

    $di = new Phalcon\DI();

    $di->set('storage', function() {
        return new Storage('/some/directory');
    }, true);

Доступ к зарегистрированным сервисам можно получить несколькими способами:

.. code-block:: php

    <?php

    class FilesController extends \Phalcon\Mvc\Controller
    {

        public function saveAction()
        {

            // Прямой доступ по имени, используя его как свойство
            $this->storage->save('/some/file');

            // С использованием сервиса DI
            $this->di->get('storage')->save('/some/file');

            // Используя магический метод
            $this->di->getStorage()->save('/some/file');

            // Еще больше магических методов для получения всей цепочки
            $this->getDi()->getStorage()->save('/some/file');

            // Используя синтаксис работы с массивами
            $this->di['storage']->save('/some/file');
        }

    }

Если вы используете все возможности Phalcon, прочитайте о провайдере сервисов :doc:`используемый по умолчанию <di>`.

Запросы Request и ответы Response
---------------------------------
Давайте предположим, что фреймворк состоит из набора предварительно зарегистрированных сервисов. В этом примере будет показано как
работать с параметрами HTTP. Сервис работы с запросами "request" содержит экземпляр :doc:`Phalcon\\Http\\Request <../api/Phalcon_Http_Request>`, а
"response" - экземпляр :doc:`Phalcon\\Http\\Response <../api/Phalcon_Http_Response>` и обеспечивает отправку собранных данных клиенту.

.. code-block:: php

    <?php

    class PostsController extends Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function saveAction()
        {
            // Проверка что данные пришли методом POST
            if ($this->request->isPost() == true) {
                // Доступ к POST данным
                $customerName = $this->request->getPost("name");
                $customerBorn = $this->request->getPost("born");
            }
        }

    }

Объект работы с ответами, как правило, не используется напрямую, но создаваясь до выполнения всех действий может быть полезен,
например, в событии afterDispatch - для указания правильного кода ответа:

.. code-block:: php

    <?php

    class PostsController extends Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function notFoundAction()
        {
            // Отправка 404 HTTP статуса
            $this->response->setStatusCode(404, "Not Found");
        }

    }

Получить подробности про работу с HTTP можно в соответствующих статьях :doc:`request <request>` и :doc:`response <response>`.

Данные сессий
-------------
Сессии позволяют сохранять данные между запросами. Вы можете использовать доступ к :doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>`
из любого контроллера для хранения (encapsulate) постоянных данных.

.. code-block:: php

    <?php

    class UserController extends Phalcon\Mvc\Controller
    {

        public function indexAction()
        {
            $this->persistent->name = "Колюня";
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

    // Регистрация контроллера как сервиса
    $di->set('IndexController', function() {
        $component = new Component();
        return $component;
    });

    // Регистрация контроллера из пространства имен в качестве сервиса
    $di->set('Backend\Controllers\IndexController', function() {
        $component = new Component();
        return $component;
    });

Создание базового контроллера (Base Controller)
-----------------------------------------------
Некоторые функции в приложении, такие как контроль доступа, перевод, кэширование или шаблонизация, чаще всего однообразны для
всех контроллеров приложения. В таких случаях рекомендуется использование "базового контроллера", что обеспечит поддержку
кодом логики DRY_ (не повторяйся). Базовый контроллер, это просто класс расширяющий :doc:`Phalcon\\Mvc\\Controller <../api/Phalcon_Mvc_Controller>`
и инкапсулирующий общую функциональность, которую должны иметь все контроллеры. Ваши контроллеры, для получения доступа
к этой функциональности, должны использовать наследование от базового контроллера.

Этот класс может располагаться где угодно, но для поддержания общей практики, мы рекомендуем располагать его в каталоге контроллеров, например,
apps/controllers/ControllerBase.php. Файл может быть напрямую подключен в файле загрузки приложения, но может также загружаться
используя автозагрузку.

.. code-block:: php

    <?php

    require "../app/controllers/ControllerBase.php";

Реализация общих компонентов (действий, методов, свойств и т.д.) находится в этом файле:

.. code-block:: php

    <?php

    class ControllerBase extends \Phalcon\Mvc\Controller
    {

      /**
       * Это действие доступно для всех контроллеров
       */
      public function someAction()
      {

      }

    }

Теперь любой контроллер, наследуемый от базового, автоматически получает доступ к общим компонентам (смотрите выше):

.. code-block:: php

    <?php

    class UsersController extends ControllerBase
    {

    }

События контроллеров
--------------------
Контролеры автоматически выступают в роли слушателей (listeners) событий :doc:`диспетчера <dispatching>`, внедрение методов с определёнными
названиями позволяет выполнять события до и после выполнения основных действий.

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function beforeExecuteRoute($dispatcher)
        {
            // Выполняется до запуска любого найденного действия
            if ($dispatcher->getActionName() == 'save') {

                $this->flash->error("You don't have permission to save posts");

                $this->dispatcher->forward(array(
                    'controller' => 'home',
                    'action' => 'index'
                ));

                return false;
            }
        }

        public function afterExecuteRoute($dispatcher)
        {
            // Выполняется после каждого выполненного действия
        }

    }

.. _DRY: http://ru.wikipedia.org/wiki/Don't_repeat_yourself
