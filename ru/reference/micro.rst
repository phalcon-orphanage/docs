Micro Applications
==================

С помощью Phalcon можно создавать приложения по типу "Микрофреймворк".
Для этого, необходимо написать всего лишь несколько строк кода. Микроприложения подходят для реализации
небольших приложений, различных API и прототипов на практике.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro;

    $app = new Micro();

    $app->get(
        "/say/welcome/{name}",
        function ($name) {
            echo "<h1>Welcome $name!</h1>";
        }
    );

    $app->handle();

Создание микроприложения
------------------------
:doc:`Phalcon\\Mvc\\Micro <../api/Phalcon_Mvc_Micro>` это класс, отвечающий за реализацию микроприложения.

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro;

    $app = new Micro();

Создание путей
--------------
После создания экземпляра класса необходимо добавить некоторые пути. :doc:`Phalcon\\Mvc\\Router <../api/Phalcon_Mvc_Router>`
отвечает за управление путями, которые должны всегда начинаться с  /. При создании путей необходимо указывать, какой метод
HTTP используется, чтобы запросы путей соответствовали методам HTTP. Ниже представлен пример, показывающий как создавать пути,
используя метод GET:

.. code-block:: php

    <?php

    $app->get(
        "/say/hello/{name}",
        function ($name) {
            echo "<h1>Hello! $name</h1>";
        }
    );

Метод "get" показывает, что используется GET-запрос. Путь :code:`/say/hello/{name}` также имеет параметр :code:`{$name}`,
который напрямую передается обработчику пути (анонимная функция). Обработка пути выполняется, когда путь совпадает.
Обработчик может быть любого типа, который возвращает данные в PHP-среде. Следующий пример демонстрирует,
как создавать различные типы обработчиков пути:

.. code-block:: php

    <?php

    // С помощью функции
    function say_hello($name) {
        echo "<h1>Hello! $name</h1>";
    }

    $app->get(
        "/say/hello/{name}",
        "say_hello"
    );

    // С помощью статического метода
    $app->get(
        "/say/hello/{name}",
        "SomeClass::someSayMethod"
    );

    // С помощью метода объекта
    $myController = new MyController();
    $app->get(
        "/say/hello/{name}",
        [
            $myController,
            "someAction"
        ]
    );

    // Анонимная функция (замыкание)
    $app->get(
        "/say/hello/{name}",
        function ($name) {
            echo "<h1>Hello! $name</h1>";
        }
    );

:doc:`Phalcon\\Mvc\\Micro <../api/Phalcon_Mvc_Micro>` предлагает набор инструментов для создания HTTP-метода (или методов),
необходимых для создания пути:

.. code-block:: php

    <?php

    // Совпадет, если HTTP-метод - GET
    $app->get(
        "/api/products",
        "get_products"
    );

    // Совпадет, если HTTP-метод - POST
    $app->post(
        "/api/products/add",
        "add_product"
    );

    // Совпадет, если HTTP-метод - PUT
    $app->put(
        "/api/products/update/{id}",
        "update_product"
    );

    // Совпадет, если HTTP-метод - DELETE
    $app->delete(
        "/api/products/remove/{id}",
        "delete_product"
    );

    // Совпадет, если HTTP-метод - OPTIONS
    $app->options(
        "/api/products/info/{id}",
        "info_product"
    );

    // Совпадет, если HTTP-метод - PATCH
    $app->patch(
        "/api/products/update/{id}",
        "info_product"
    );

    // Совпадет, если HTTP-метод - GET или POST
    $app->map(
        "/repos/store/refs",
        "action_product"
    )->via(
        [
            "GET",
            "POST",
        ]
    );

To access the HTTP method data :code:`$app` needs to be passed into the closure:

.. code-block:: php

    <?php

    // Matches if the HTTP method is POST
    $app->post(
        "/api/products/add",
        function () use ($app) {
            echo $app->request->getPost("productID");
        }
    );

Пути с параметрами
^^^^^^^^^^^^^^^^^^
Создание параметров путей - довольно простая задача, как показывает пример выше.
Имя параметра должно находиться в скобках. Параметры также можно задавать с помощью регулярных выражений для того,
чтобы быть уверенным в наличии данных. Это показано в примере ниже:

.. code-block:: php

    <?php

    // Данный путь имеет два параметра, у каждого из которых задан формат
    $app->get(
        "/posts/{year:[0-9]+}/{title:[a-zA-Z\-]+}",
        function ($year, $title) {
            echo "<h1>Title: $title</h1>";
            echo "<h2>Year: $year</h2>";
        }
    );

Маршрут по умолчанию
^^^^^^^^^^^^^^^^^^^^
Как правило, маршрутом по умолчанию в приложении является маршрут /. Чаще всего, обращения будут
идти именно к нему через метод GET. Этот сценарий можно описать следующим образом:

.. code-block:: php

    <?php

    // Это маршрут по умолчанию
    $app->get(
        "/",
        function () {
            echo "<h1>Welcome!</h1>";
        }
    );

Правила перезаписи (Rewrite Rules)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Следующие правила могут быть использованы вместе с Apache для перезаписи URI:

.. code-block:: apacheconf

    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^((?s).*)$ index.php?_url=/$1 [QSA,L]
    </IfModule>

Работа с заголовками ответов (Responses)
----------------------------------------
Вы можете работать с любыми заголовками ответов в обработчике: сразу сделать вывод, использовать шаблонизатор,
подключить шаблонизатор, вернуть JSON и т.д.:

.. code-block:: php

    <?php

    // Прямой вывод
    $app->get(
        "/say/hello",
        function () {
            echo "<h1>Hello! $name</h1>";
        }
    );

    // Подключение внешнего файла
    $app->get(
        "/show/results",
        function () {
            require "views/results.php";
        }
    );

    // Возврат JSON
    $app->get(
        "/get/some-json",
        function () {
            echo json_encode(
                [
                    "some",
                    "important",
                    "data",
                ]
            );
        }
    );

В дополнение к этому, у вас есть доступ к сервису :doc:`"response" <response>`, благодаря которому вы
можете обрабатывать ответы ещё более гибко:

.. code-block:: php

    <?php

    $app->get(
        "/show/data",
        function () use ($app) {
            // Установка заголовка Content-Type
            $app->response->setContentType("text/plain");

            $app->response->sendHeaders();

            // Вывод содержимого файла
            readfile("data.txt");
        }
    );

Или создайте объект класса Response и верните его из обработчика:

.. code-block:: php

    <?php

    $app->get(
        "/show/data",
        function () {
            // Создаем объект для работы с заголовками ответов
            $response = new Phalcon\Http\Response();

            // Установка заголовка Content-Type
            $response->setContentType("text/plain");

            // Передаем содержимое файла
            $response->setContent(file_get_contents("data.txt"));

            // Возвращаем объект Response
            return $response;
        }
    );

Создание перенаправлений (Redirects)
------------------------------------
Перенаправления могут быть использованы для того, чтобы перенаправить поток исполнения на другой маршрут:

.. code-block:: php

    <?php

    // Этот маршрут выполняет перенаправление на другой маршрут
    $app->post("/old/welcome",
        function () use ($app) {
            $app->response->redirect("new/welcome");

            $app->response->sendHeaders();
        }
    );

    $app->post("/new/welcome",
        function () use ($app) {
            echo "This is the new Welcome";
        }
    );

Создание URL-адресов для маршрутов
----------------------------------
Класс :doc:`Phalcon\\Mvc\\Url <url>` может быть использован для получения URL-адреса на основе
определенных маршрутов. Вам нужно создать имя для маршрута; опираясь на него служба "url"
выполнить соответствующий URL:

.. code-block:: php

    <?php

    // Установка маршрута с именем "show-post"
    $app->get(
        "/blog/{year}/{title}",
        function ($year, $title) use ($app) {
            // ... здесь показываем текст статьи
        }
    )->setName("show-post");

    // Где-нибудь используем наш новый адрес
    $app->get(
        "/",
        function () use ($app) {
            echo '<a href="', $app->url->get(
                [
                    "for"   => "show-post",
                    "title" => "php-is-a-great-framework",
                    "year"  => 2015
                ]
            ), '">Show the post</a>';
        }
    );

Работа с Внедрением зависимостей (Dependency Injector)
------------------------------------------------------
В микроприложении сервисы контейнера :doc:`Phalcon\\Di\\FactoryDefault <di>` создаются неявно;
Кроме того, вы можете создать за пределами своего приложения контейнер, который будет
манипулировать этими сервисами:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro;
    use Phalcon\Di\FactoryDefault;
    use Phalcon\Config\Adapter\Ini as IniConfig;

    $di = new FactoryDefault();

    $di->set(
        "config",
        function () {
            return new IniConfig("config.ini");
        }
    );

    $app = new Micro();

    $app->setDI($di);

    $app->get(
        "/",
        function () use ($app) {
            // Читаем свойства нашего конфигурационного файла
            echo $app->config->app_name;
        }
    );

    $app->post(
        "/contact",
        function () use ($app) {
            $app->flash->success("Yes!, the contact was made!");
        }
    );

Синтаксис массивов удобен для установки/получения сервисов из внутреннего контейнера сервисов:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro;
    use Phalcon\Db\Adapter\Pdo\Mysql as MysqlAdapter;

    $app = new Micro();

    // Установка сервиса базы данных
    $app["db"] = function () {
        return new MysqlAdapter(
            [
                "host"     => "localhost",
                "username" => "root",
                "password" => "secret",
                "dbname"   => "test_db"
            ]
        );
    };

    $app->get(
        "/blog",
        function () use ($app) {
            $news = $app["db"]->query("SELECT * FROM news");

            foreach ($news as $new) {
                echo $new->title;
            }
        }
    );

Обработка исключений "Не найдено"
---------------------------------
Когда пользователь пытается получить доступ к маршруту, который не определён, микроприложение
запускает обработчик "Не найдено". Пример:

.. code-block:: php

    <?php

    $app->notFound(
        function () use ($app) {
            $app->response->setStatusCode(404, "Not Found");

            $app->response->sendHeaders();

            echo "This is crazy, but this page was not found!";
        }
    );

Модели в микроприложениях
-------------------------
:doc:`Модели <models>` в микроприложениях работают так же, как и в обычных. Главное - зарегистрировать автозагрузчик:

.. code-block:: php

    <?php

    $loader = new \Phalcon\Loader();

    $loader->registerDirs(
        [
            __DIR__ . "/models/"
        ]
    )->register();

    $app = new \Phalcon\Mvc\Micro();

    $app->get(
        "/products/find",
        function () {
            $products = Products::find();

            foreach ($products as $product) {
                echo $product->name, "<br>";
            }
        }
    );

    $app->handle();

Inject model instances
----------------------
By using class :doc:`Phalcon\\Mvc\\Model\\Binder <../api/Phalcon_Mvc_Model_Binder>` you can inject model instances into your routes:

.. code-block:: php

     <?php

    $loader = new \Phalcon\Loader();

    $loader->registerDirs(
        [
            __DIR__ . "/models/"
        ]
    )->register();

    $app = new \Phalcon\Mvc\Micro();
    $app->setModelBinder(new \Phalcon\Mvc\Model\Binder());

    $app->get(
        "/products/{product:[0-9]+}",
        function (Products $product) {
            // do anything with $product object
        }
    );

    $app->handle();

.. highlights::

    Since Binder object is using internally Reflection Api which can be heavy there is ability to set cache. This can be done by
    using second argument in :code:`setModelBinder()` which can also accept service name or just by passing cache instance to :code:`Binder` constructor.

.. highlights::

    Currently the binder will only use the models primary key to perform a :code:`findFirst()` on.
    An example route for the above would be /products/1

События микроприложения
-----------------------
:doc:`Phalcon\\Mvc\\Micro <../api/Phalcon_Mvc_Micro>` может посылать события в :doc:`EventsManager <events>` (если он присутствует).
События срабатывают с использованием типа "micro". Поддерживаются следующие события:

+---------------------+----------------------------------------------------------------------------------------------------------------------------+------------------------------+
| Имя события         | Действие                                                                                                                   | Можно ли оставить операцию?  |
+=====================+============================================================================================================================+==============================+
| beforeHandleRoute   | Главный метод вызван, в этот момент приложение не знает, есть ли соответствующий маршрут                                   | Да                           |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+------------------------------+
| beforeExecuteRoute  | Соответствующий маршрут найден и содержит верный обработчик, в этот момент обработчик не будет выполнен                    | Да                           |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+------------------------------+
| afterExecuteRoute   | Запускается после запуска обработчика                                                                                      | Нет                          |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+------------------------------+
| beforeNotFound      | Запускается, когда каждый из определённых маршрутов удовлетворяет URI                                                      | Да                           |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+------------------------------+
| afterHandleRoute    | Запускается после успешного выполнения всего процесса                                                                      | Да                           |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+------------------------------+
| afterBinding        | Triggered after models are bound but before executing the handler                                                          | Да                  |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+

В приведённом примере объясняется, как управлять безопасностью приложения используя события:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    // Создаём менеджер событий
    $eventsManager = new EventsManager();

    $eventsManager->attach(
        "micro:beforeExecuteRoute",
        function (Event $event, $app) {
            if ($app->session->get("auth") === false) {
                $app->flashSession->error("The user isn't authenticated");

                $app->response->redirect("/");

                $app->response->sendHeaders();

                // Возвращаем (false) останов операции
                return false;
            }
        }
    );

    $app = new Micro();

    // Привязываем менеджер событий к приложению
    $app->setEventsManager($eventsManager);

Промежуточные события
---------------------
В дополнение к менеджеру событий, события могут быть добавлены с использованием методов 'before', 'after' и 'finish':

.. code-block:: php

    <?php

    $app = new Phalcon\Mvc\Micro();

    // Выполнится до того, как выполнится любой из маршрутов
    // Возврат false отменит выполнение маршрута
    $app->before(
        function () use ($app) {
            if ($app["session"]->get("auth") === false) {
                $app["flashSession"]->error("The user isn't authenticated");

                $app["response"]->redirect("/error");

                // Return false stops the normal execution
                return false;
            }

            return true;
        }
    );

    $app->map(
        "/api/robots",
        function () {
            return [
                "status" => "OK",
            ];
        }
    );

    $app->after(
        function () use ($app) {
            // Это выполнится после того, как выполнится маршрут
            echo json_encode($app->getReturnedValue());
        }
    );

    $app->finish(
        function () use ($app) {
            // Это выполнится после того, как был обработан запрос
        }
    );

Вы можете вызывать методы несколько раз, чтобы добавлять больше событий того же типа:

.. code-block:: php

    <?php

    $app->finish(
        function () use ($app) {
            // First 'finish' middleware
        }
    );

    $app->finish(
        function () use ($app) {
            // Second 'finish' middleware
        }
    );

Код из связанных событий может быть повторно использован в отдельных классах:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro\MiddlewareInterface;

    /**
     * CacheMiddleware
     *
     * Кэширует страницы для ускорения работы
     */
    class CacheMiddleware implements MiddlewareInterface
    {
        public function call($application)
        {
            $cache  = $application["cache"];
            $router = $application["router"];

            $key = preg_replace("/^[a-zA-Z0-9]/", "", $router->getRewriteUri());

            // Проверяем, закэширован ли запрос
            if ($cache->exists($key)) {
                echo $cache->get($key);

                return false;
            }

            return true;
        }
    }

Далее передаём экземпляр объекта в приложение:

.. code-block:: php

    <?php

    $app->before(new CacheMiddleware());

Доступные следующие промежуточные события:

+---------------------+----------------------------------------------------------------------------------------------------------------------------+------------------------------+
| Имя события         | Действие                                                                                                                   | Можно ли оставить операцию?  |
+=====================+============================================================================================================================+==============================+
| before              | Перед вызовом обработчика. Может быть использован для управления доступом к приложению                                     | Да                           |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+------------------------------+
| after               | Выполняется после вызова обработчика. Может быть использован для подготовки ответа                                         | Нет                          |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+------------------------------+
| finish              | Выполняется после отправки ответа. Может быть использован для очистки                                                      | Нет                          |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+------------------------------+
| afterBinding        | After models are bound and before executing the handler.                                                                   | Да
        |
+---------------------+----------------------------------------------------------------------------------------------------------------------------+----------------------+

Использование контроллеров и обработчиков
-----------------------------------------
При создании приложений среднего уровня через :code:`Mvc\Micro` может потребоваться определённой организации обработчиков в контроллерах.
Вы можете использовать :doc:`Phalcon\\Mvc\\Micro\\Collection <../api/Phalcon_Mvc_Micro_Collection>`, чтобы группировать обработчики в контроллерах:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro\Collection as MicroCollection;

    $posts = new MicroCollection();

    // Устанавливаем главный обработчик, например, экземпляр объекта контроллера
    $posts->setHandler(
        new PostsController()
    );

    // Устанавливаем общий префикс для всех маршрутов
    $posts->setPrefix("/posts");

    // Используем метод 'index' в контроллере PostsController
    $posts->get("/", "index");

    // Используем метод 'show' в контроллере PostsController
    $posts->get("/show/{slug}", "show");

    $app->mount($posts);

Контроллер 'PostsController' может выглядеть так:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function index()
        {
            // ...
        }

        public function show($slug)
        {
            // ...
        }
    }

Экземпляр драйвера инициализирован, Коллекция так же может загружать драйверы, если совпал маршрут:

.. code-block:: php

    <?php

    $posts->setHandler("PostsController", true);
    $posts->setHandler("Blog\Controllers\PostsController", true);

Возврат заголовков ответов (Responses)
--------------------------------------
Обработчики могут возвращать ответы при помощи :doc:`Phalcon\\Http\\Response <response>`
или компонента, который реализует соответствующий интерфейс:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Micro;
    use Phalcon\Http\Response;

    $app = new Micro();

    // Взвращаем ответ
    $app->get(
        "/welcome/index",
        function () {
            $response = new Response();

            $response->setStatusCode(401, "Unauthorized");

            $response->setContent("Access is not authorized");

            return $response;
        }
    );

Отрисовка представлений
-----------------------
Класс :doc:`Phalcon\\Mvc\\View\\Simple <views>` может быть использован для отрисовки представлений. Следующий
пример показывает как именно:

.. code-block:: php

    <?php

    $app = new Phalcon\Mvc\Micro();

    $app["view"] = function () {
        $view = new \Phalcon\Mvc\View\Simple();

        $view->setViewsDir("app/views/");

        return $view;
    };

    // Возвращаем отрисованное представление
    $app->get(
        "/products/show",
        function () use ($app) {
            // Отрисовываем представление app/views/products/show.phtml с передачей в него некоторых переменных
            echo $app["view"]->render(
                "products/show",
                [
                    "id"   => 100,
                    "name" => "Artichoke"
                ]
            );
        }
    );

Please note that this code block uses :doc:`Phalcon\\Mvc\\View\\Simple <../api/Phalcon_Mvc_View_Simple>` which uses relative paths instead of controllers and actions.
If you would like to use :doc:`Phalcon\\Mvc\\View\\Simple <../api/Phalcon_Mvc_View_Simple>` instead, you will need to change the parameters of the :code:`render()` method:

.. code-block:: php

    <?php

    $app = new Phalcon\Mvc\Micro();

    $app["view"] = function () {
        $view = new \Phalcon\Mvc\View();

        $view->setViewsDir("app/views/");

        return $view;
    };

    // Return a rendered view
    $app->get(
        "/products/show",
        function () use ($app) {
            // Render app/views/products/show.phtml passing some variables
            echo $app["view"]->render(
                "products",
                "show",
                [
                    "id"   => 100,
                    "name" => "Artichoke"
                ]
            );
        }
    );

Error Handling
--------------
A proper response can be generated if an exception is raised in a micro handler:

.. code-block:: php

    <?php

    $app = new Phalcon\Mvc\Micro();

    $app->get(
        "/",
        function () {
            throw new \Exception("An error");
        }
    );

    $app->error(
        function ($exception) {
            echo "An error has occurred";
        }
    );

If the handler returns "false" the exception is stopped.

Внешние источники
-----------------
* :doc:`Создание простейшего REST API <tutorial-rest>` урок, показывающий как создать микроприложение, предоставляющее RESTful API.
* `Магазин наклеек <http://store.phalconphp.com>`_ очень простое микроприложение [`Github <https://github.com/phalcon/store>`_].
