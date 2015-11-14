Диспетчер контроллеров
======================

Компонент :doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>`  отвечает за инициализацию контроллеров и выполнения в них действий, для MVC
приложения. Понимание его работы и его возможностей помогает нам получить больше возможностей предоставляемых фреймворком.

Цикл работы диспетчера
----------------------
Это важнейший процесс, который имеет много общего с работой MVC, особенно в части работы контроллеров. Работа контроллера вызывается диспетчером.
Файлы контроллера считываются, загружаются, инициализируются, чтобы затем выполнить необходимые действия. Если действие направляет поток на другой
котроллер/действие (action), диспетчер контроллера стартует снова. Для лучшей иллюстрации в примере ниже показан приблизительный процесс происходящий
внутри :doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>`:

.. code-block:: php

    <?php

    // Цикл диспетчера
    while (!$finished) {

        $finished = true;

        $controllerClass = $controllerName . "Controller";

        // Создание экземпляра класса контроллера, с помощью автозагрузчика
        $controller = new $controllerClass();

        // Выполнение действия
        call_user_func_array(array($controller, $actionName . "Action"), $params);

        // Значение переменной должно быть изменено при необходимости запуска другого контроллера
        $finished = true;
    }

Этот код, безусловно, нуждается в дополнительных проверках и доработке, но здесь наглядно показана типичная последовательность операций в диспетчере.

События при работе диспетчера
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
:doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>` может отправлять события :doc:`EventsManager <events>` если это необходимо. События вызываются с помощью типа "dispatch". Некоторые события, при возвращении false, могут остановить активную операцию. Поддерживаются следующие события:

+----------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| Название события     | Время срабатывания                                                                                                                                                                                           | Прерывает операцию? | Triggered to          |
+======================+==============================================================================================================================================================================================================+=====================+=======================+
| beforeDispatchLoop   | До запуска цикла диспетчера. В этот момент диспетчер не знает, существуют ли контроллеры или действия, которые должны быть выполнены. Диспетчер владеет только информацией поступившей из маршрутизатора     | Да                  | Listeners             |
+----------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| beforeDispatch       | До выполнения цикла диспетчера. В этот момент диспетчер не знает, существуют ли контроллеры или действия, которые должны быть выполнены. Диспетчер знает только информацию, поступившую из маршрутизатора    | Да                  | Listeners             |
+----------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| beforeExecuteRoute   | До выполнения действия в контроллере. В этой точке контроллер инициализирован и знает о существовании действия (action)                                                                                      | Да                  | Listeners/Controllers |
+----------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| initialize           | Allow to globally initialize the controller in the request                                                                                                                                                   | No                  | Controllers           |
+----------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| afterExecuteRoute    | После выполнения действия в контроллере. Не останавливает текущую операцию, используйте это событие только для завершения/очистки после выполненного действия                                                | Нет                 | Controllers           |
+----------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| beforeNotFoundAction | Когда действие не найдено в контроллере                                                                                                                                                                      | Нет                 | Listeners/Controllers |
+----------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| beforeException      | До вызова диспетчером любого исключения                                                                                                                                                                      | Да                  | Listeners             |
+----------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| afterDispatch        | После выполнения цикла диспетчера. Не останавливает текущую операцию, используйте это событие только для завершения/очистки после выполненного действия                                                      | Да                  | Listeners             |
+----------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+
| afterDispatchLoop    | После завершения цикла диспетчера                                                                                                                                                                            | Нет                 | Listeners             |
+----------------------+--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+-----------------------+

В обучающем материале :doc:`INVO <tutorial-invo>` показано, как воспользоваться диспетчером событий для реализации фильтра безопасности :doc:`Acl <acl>`.

В примере ниже показано как прикрепить слушателей (listeners) к событиям контроллера:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Dispatcher as MvcDispatcher;
    use Phalcon\Events\Manager as EventsManager;

    $di->set('dispatcher', function () {

        // Создание менеджера событий
        $eventsManager = new EventsManager();

        // Прикрепление функции-слушателя для событий типа "dispatch"
        $eventsManager->attach("dispatch", function ($event, $dispatcher) {
            // ...
        });

        $dispatcher = new MvcDispatcher();

        // Связывание менеджера событий с диспетчером
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;

    }, true);

Экземпляр контроллера автоматически выступает в качестве слушателя для событий, так что вы можете реализовать методы в самом контроллере:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;
    use Phalcon\Mvc\Controller;
    use Phalcon\Mvc\Dispatcher;

    class PostsController extends Controller
    {
        public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
        {
            // Выполняется перед каждым найденным действием
        }

        public function afterExecuteRoute(Event $event, Dispatcher $dispatcher)
        {
            // Выполняется после каждого выполненного действия
        }
    }

Переадресация на другое действие
--------------------------------
Цикл диспетчера позволяет перенаправить поток на другой контроллер/действие. Это очень полезно, для проверки может ли пользователь иметь
доступ к определенным функциям, перенаправления пользователя на другую страницу или просто для повторного использования кода.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function saveAction($year, $postTitle)
        {
            // ... сохраняем данные и перенаправляем пользователя

            // Перенаправляем на действие index
            $this->dispatcher->forward(
                array(
                    "controller" => "post",
                    "action"     => "index"
                )
            );
        }
    }

Имейте ввиду, использование метода "forward" - это не то же самое что редирект в HTTP. Хотя внешне результат будет таким же.
Метод "forward" не перезагружает текущую страницу, все перенаправления выполняются в одном запросе, тогда как HTTP редирект требует два
запроса для завершения процесса.

Пример перенаправлений:

.. code-block:: php

    <?php

    // Направляем поток на другое действие текущего контроллера
    $this->dispatcher->forward(
        array(
            "action" => "search"
        )
    );

    // Направляем поток на другое действие текущего контроллера с передачей параметров
    $this->dispatcher->forward(
        array(
            "action" => "search",
            "params" => array(1, 2, 3)
        )
    );

Метод forward принимает следующие параметры:

+----------------+--------------------------------------------------------+
| Параметр       | Описание                                               |
+================+========================================================+
| controller     | Правильное имя контроллера для вызова                  |
+----------------+--------------------------------------------------------+
| action         | Правильное название действия для вызова                |
+----------------+--------------------------------------------------------+
| params         | Массив параметров для действия (action)                |
+----------------+--------------------------------------------------------+
| namespace      | Пространство имён, которому принадлежит контроллер     |
+----------------+--------------------------------------------------------+

Preparing параметров
--------------------
Thanks to the hooks points provided by :doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>` you can easily
adapt your application to any URL schema:

For example, you want your URLs look like: http://example.com/controller/key1/value1/key2/value

Parameters by default are passed as they come in the URL to actions, you can transform them to the desired schema:

.. code-block:: php

    <?php

    use Phalcon\Dispatcher;
    use Phalcon\Mvc\Dispatcher as MvcDispatcher;
    use Phalcon\Events\Manager as EventsManager;

    $di->set('dispatcher', function () {

        // Create an EventsManager
        $eventsManager = new EventsManager();

        // Attach a listener
        $eventsManager->attach("dispatch:beforeDispatchLoop", function ($event, $dispatcher) {

            $keyParams = array();
            $params    = $dispatcher->getParams();

            // Use odd parameters as keys and even as values
            foreach ($params as $number => $value) {
                if ($number & 1) {
                    $keyParams[$params[$number - 1]] = $value;
                }
            }

            // Override parameters
            $dispatcher->setParams($keyParams);
        });

        $dispatcher = new MvcDispatcher();
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    });

If the desired schema is: http://example.com/controller/key1:value1/key2:value, the following code is required:

.. code-block:: php

    <?php

    use Phalcon\Dispatcher;
    use Phalcon\Mvc\Dispatcher as MvcDispatcher;
    use Phalcon\Events\Manager as EventsManager;

    $di->set('dispatcher', function () {

        // Create an EventsManager
        $eventsManager = new EventsManager();

        // Attach a listener
        $eventsManager->attach("dispatch:beforeDispatchLoop", function ($event, $dispatcher) {

            $keyParams = array();
            $params    = $dispatcher->getParams();

            // Explode each parameter as key,value pairs
            foreach ($params as $number => $value) {
                $parts                = explode(':', $value);
                $keyParams[$parts[0]] = $parts[1];
            }

            // Override parameters
            $dispatcher->setParams($keyParams);
        });

        $dispatcher = new MvcDispatcher();
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    });

Получение параметров
--------------------
Если текущий маршрут содержит именованные параметры, вы можете получить их в контроллере, представлении или любом другом компоненте,
расширяющим :doc:`Phalcon\\Di\\Injectable <../api/Phalcon_Di_Injectable>`.

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
            // Получение параметра title, находящимся в параметрах URL
            $title = $this->dispatcher->getParam("title");

            // Получение параметра year, пришедшего из URL и отфильтрованного как число
            $year = $this->dispatcher->getParam("year", "int");

            // ...
        }
    }

Preparing actions
-----------------
You can also define an arbitrary schema for actions before be dispatched.

Camelize action names
^^^^^^^^^^^^^^^^^^^^^
If the original URL is: http://example.com/admin/products/show-latest-products,
and for example you want to camelize 'show-latest-products' to 'ShowLatestProducts',
the following code is required:

.. code-block:: php

    <?php

    use Phalcon\Text;
    use Phalcon\Mvc\Dispatcher as MvcDispatcher;
    use Phalcon\Events\Manager as EventsManager;

    $di->set('dispatcher', function () {

        // Create an EventsManager
        $eventsManager = new EventsManager();

        // Camelize actions
        $eventsManager->attach("dispatch:beforeDispatchLoop", function ($event, $dispatcher) {
            $dispatcher->setActionName(Text::camelize($dispatcher->getActionName()));
        });

        $dispatcher = new MvcDispatcher();
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    });

Remove legacy extensions
^^^^^^^^^^^^^^^^^^^^^^^^
If the original URL always contains a '.php' extension:

http://example.com/admin/products/show-latest-products.php
http://example.com/admin/products/index.php

You can remove it before dispatch the controller/action combination:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Dispatcher as MvcDispatcher;
    use Phalcon\Events\Manager as EventsManager;

    $di->set('dispatcher', function () {

        // Create an EventsManager
        $eventsManager = new EventsManager();

        // Remove extension before dispatch
        $eventsManager->attach("dispatch:beforeDispatchLoop", function ($event, $dispatcher) {

            // Remove extension
            $action = preg_replace('/\.php$/', '', $dispatcher->getActionName());

            // Override action
            $dispatcher->setActionName($action);
        });

        $dispatcher = new MvcDispatcher();
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    });

Inject model instances
^^^^^^^^^^^^^^^^^^^^^^
In this example, the developer wants to inspect the parameters that an action will receive in order to dynamically
inject model instances.

The controller looks like:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        /**
         * Shows posts
         *
         * @param \Posts $post
         */
        public function showAction(Posts $post)
        {
            $this->view->post = $post;
        }
    }

Method 'showAction' receives an instance of the model \Posts, the developer could inspect this
before dispatch the action preparing the parameter accordingly:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Model;
    use Phalcon\Mvc\Dispatcher as MvcDispatcher;
    use Phalcon\Events\Manager as EventsManager;

    $di->set('dispatcher', function () {

        // Create an EventsManager
        $eventsManager = new EventsManager();

        $eventsManager->attach("dispatch:beforeDispatchLoop", function ($event, $dispatcher) {

            // Possible controller class name
            $controllerName = $dispatcher->getControllerClass();

            // Possible method name
            $actionName = $dispatcher->getActiveMethod();

            try {

                // Get the reflection for the method to be executed
                $reflection = new \ReflectionMethod($controllerName, $actionName);

                // Check parameters
                foreach ($reflection->getParameters() as $parameter) {

                    // Get the expected model name
                    $className = $parameter->getClass()->name;

                    // Check if the parameter expects a model instance
                    if (is_subclass_of($className, Model::class)) {

                        $model = $className::findFirstById($dispatcher->getParams()[0]);

                        // Override the parameters by the model instance
                        $dispatcher->setParams(array($model));
                    }
                }

            } catch (\Exception $e) {
                // An exception has occurred, maybe the class or action does not exist?
            }

        });

        $dispatcher = new MvcDispatcher();
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    });

The above example has been simplified for academic purposes.
A developer can improve it to inject any kind of dependency or model in actions before be executed.

Обработка исключений "Не найдено"
---------------------------------
Используйте возможности :doc:`EventsManager <events>` для установки событий, выполняемых при отсутствии требуемого контроллера/действия.

.. code-block:: php

    <?php

    use Phalcon\Dispatcher;
    use Phalcon\Mvc\Dispatcher as MvcDispatcher;
    use Phalcon\Events\Manager as EventsManager;
    use Phalcon\Mvc\Dispatcher\Exception as DispatchException;

    $di->setShared('dispatcher', function () {

        // Создаем менеджер событий
        $eventsManager = new EventsManager();

        // Прикрепляем слушателя
        $eventsManager->attach("dispatch:beforeException", function ($event, $dispatcher, $exception) {

            // Handle 404 exceptions
            if ($exception instanceof DispatchException) {
                $dispatcher->forward(
                    array(
                        'controller' => 'index',
                        'action'     => 'show404'
                    )
                );

                return false;
            }

            // Alternative way, controller or action doesn't exist
            switch ($exception->getCode()) {
                case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                    $dispatcher->forward(
                        array(
                            'controller' => 'index',
                            'action'     => 'show404'
                        )
                    );

                    return false;
            }
        });

        $dispatcher = new MvcDispatcher();

        // Прикрепляем менеджер событий к диспетчеру
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;

    }, true);

Of course, this method can be moved onto independent plugin classes, allowing more than one class
take actions when an exception is produced in the dispatch loop:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;
    use Phalcon\Mvc\Dispatcher;
    use Phalcon\Mvc\Dispatcher\Exception as DispatchException;

    class ExceptionsPlugin
    {
        public function beforeException(Event $event, Dispatcher $dispatcher, $exception)
        {
            // Handle 404 exceptions
            if ($exception instanceof DispatchException) {
                $dispatcher->forward(array(
                    'controller' => 'index',
                    'action'     => 'show404'
                ));
                return false;
            }

            // Handle other exceptions
            $dispatcher->forward(array(
                'controller' => 'index',
                'action'     => 'show503'
            ));

            return false;
        }
    }

.. highlights::

    Only exceptions produced by the dispatcher and exceptions produced in the executed action
    are notified in the 'beforeException' events. Exceptions produced in listeners or
    controller events are redirected to the latest try/catch.

Реализация собственных диспетчеров
----------------------------------
Для создания диспетчеров необходимо реализовать интерфейс :doc:`Phalcon\\Mvc\\DispatcherInterface <../api/Phalcon_Mvc_DispatcherInterface>` и подменить
диспетчер Phalcon.
