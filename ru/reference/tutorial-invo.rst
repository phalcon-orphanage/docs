Урок 2: Приложение для создания счетов INVO
===========================
Во втором уроке мы создадим более сложное приложение с помощью Phalcon. INVO это одно из приложений, которое мы создали в качестве примера. INVO это небольшой сайт, который позволяет своим пользователям создавать счета и выполнять другие задачи для управления своими клиентами и продуктами. Полный код проекта можно клонировать из Github_.

INVO использует `Twitter Bootstrap`_ в качестве фронтенд-фреймворка. Кроме того, приложение не будет генерировать счета, оно служит для понимая того, как работает фреймворк.

Структура проекта
-----------------
После того как вы склонируете проект в корневой каталог вы увидите следующую структуру:

.. code-block:: bash

    invo/
        app/
            app/config/
            app/controllers/
            app/library/
            app/models/
            app/plugins/
            app/views/
        public/
            public/bootstrap/
            public/css/
            public/js/
        schemas/

Как вы уже знаете, Phalcon не навязывает определенную структуру файлов и каталогов для разработки приложений. Этот проект обеспечивает простую стуктуру MVC и корневой каталог public.

После того, как вы откроете приложение в браузере http://localhost/invo вы увидите что-то вроде этого:

.. figure:: ../_static/img/invo-1.png
   :align: center

Приложение состоит из двух частей, фронтенд - внешняя часть, где поситители могут получить информацию о INVO и запросить контактные данные. И бэкенд - административную панель, где зарегистрированный пользователь может управлять своими продуктами и клиентами.

Маршрутизация
-------
INVO использует стандартный маршрутизатор основанный на встроенном компоненте Route. Эти маршруты соответствуют следующим шаблонам: /:controller/:action/:params. Первая часть URI является контроллером, вторая имя действия и остальные параметры.

Маршрут /session/register выполняет контроллер SessionController и его действие registerAction.

Конфигурация
-------------
INVO имеет конфигурационный файл, который устанавливает общие параметры приложения. Этот файл загружается в самом начале
загрузочного файла (public/index.php):

.. code-block:: php

    <?php

    //Read the configuration
    $config = new Phalcon\Config\Adapter\Ini('../app/config/config.ini');

:doc:'Phalcon\\Config <config>' позволяет нам манипулировать файлами в объектно-ориентированного подхода. Файл конфигурации
содержит следующие настройки:

.. code-block:: ini

    [database]
    host     = localhost
    username = root
    password = secret
    name     = invo

    [application]
    controllersDir = /../app/controllers/
    modelsDir      = /../app/models/
    viewsDir       = /../app/views/
    pluginsDir     = /../app/plugins/
    libraryDir     = /../app/library/
    baseUri        = /invo/

    ;[metadata]
    ;adapter = "Apc"
    ;suffix = my-suffix
    ;lifetime = 3600

Phalcon не имеет каких-либо предопределенных соглашений о конфигурациях. Разделы помогут нам организовать необходимые параметры. В этом файле три секции, которые мы будем использовать позже.

Автозагрузчики
-----------
Второе, что видно в в загрузочном файле (public/index.php) это автозагрузчик. Автозагрузчик регистрирует набор
каталогов, где приложение будет искать необходимые классы.

.. code-block:: php

    <?php

    $loader = new \Phalcon\Loader();

    $loader->registerDirs(
        array(
            $config->application->controllersDir,
            $config->application->pluginsDir,
            $config->application->libraryDir,
            $config->application->modelsDir,
        )
    )->register();

Обратите внимание на регистрацию каталогов в файле конфигураций.
Единтсвенная директория которая не была зарегистрирована с помощью автозагрузчика это viewsDir, потому что она не содержит классов, только html + php файлы.

Обработка запроса
--------------------
Пойдем дальше, в конце файла, запрос окончательно обрабатывается с помощью Phalcon\\Mvc\\Application,
этот класс инициализирует и выполняет все что нужно для работы приложения:

.. code-block:: php

    <?php

    $app = new \Phalcon\Mvc\Application($di);

    echo $app->handle()->getContent();

Инъекция зависимостей
---------------------
Посмотрите на первую строку кода на предыдущем блоке, переменная $app получает еще одну переменную $di в своем конструкторе.
Каков смысл этой переменной? Phalcon - слабо связанный фрэймворк, так что нам нужен компонент, который действует как клей, чтобы все работало вместе.
Этот компонент - Phalcon\\DI. Это контейнер, обеспечивающий все связи между частями необходимыми в приложении.

Есть много способов регистрации сервисов в контейнере. В INVO большинство услуг были зарегистрированы с использованием скрытых функций.  Благодаря этому, объекты создаются простейшим образом, уменьшеая ресурсы необходимые для приложения.

Например, в следующем фрагменте, регистрации сессии, анонимная функция будет вызвана только когда приложение требует доступа к данным сессии:

.. code-block:: php

    <?php

    //Начать сессию в первый раз, когда какой нибудь компонент запросит сервис сессий.
    $di->set('session', function() {
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    });

Здесь мы можем менять адаптер, выполнить дополнительную инициализацию и многое другое. Обратите внимание, метод был зарегистрирован с помощью имени  "session". Это соглашение позволит фрэймворку идентифицировать активный метод в контейнере.

Запрос имеет множество методов, регистрация каждого метода может быть трудоемкой задачей. По этой причине,
фрэймворк обеспечивает вариант Phalcon\\DI вызывая Phalcon\\DI\\FactoryDefault задачей которого является регистрация
всех методов необходимых фрэймворку.

.. code-block:: php

    <?php

    // FactoryDefault Обеспечивает автоматическую регистрацию
    // полного набора методов необходимых фреймворку
    $di = new \Phalcon\DI\FactoryDefault();

Он регистрирует большинство методов, предусмотренных фрэймворком как стандартные. Если нам надо переопределить
какой либо из методов, мы можем просто определить его снова, как мы делали выше с методом "session". Это причина существования переменной $di.

Авторизация в приложении
------------------------
Авторизация позволяет работать с контроллерами бакенда. Различие между контроллерами бакенда и фронтенда является
только логическим. Все контроллеры находятся в одной и той же директории (app/controllers/).

Для входа в систему мы должны иметь правильные логин и пароль. Пользователи хранятся в таблице "users" базы данных "invo".

Перед стартом сессии мы должны сконфигурировать в приложении коннект к базе данных. В контейнере сервисов создадим сервис
с названием "db" указав необходимую информацию. Как и в случае автозагрузчика мы возьмем нужные параметры из файла
конфигурации с помощью сервиса конфигурации:

.. code-block:: php

    <?php

    // Коннект к базе данных создается соответственно параметрам в конфигурационном файле
    $di->set('db', function() use ($config) {
        return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => $config->database->host,
            "username" => $config->database->username,
            "password" => $config->database->password,
            "dbname" => $config->database->name
        ));
    });

Здесь мы вернули экземпляр адаптера соединения с MySQL. Если это необходимо, вы можете реализовать дополнительные действия,
такие как логирование и профилирование запросов, изменить адаптер, сконфигурировав его как вам угодно.

Теперь создадим следующую простую форму (app/views/session/index.phtml) для отправки информации для авторизации.
Мы удалили из нее некоторый код HTML, чтобы сделать пример более простым:

.. code-block:: html+php

    <?php echo $this->tag->form('session/start') ?>

        <label for="email">Логин/Email</label>
        <?php echo $this->tag->textField(array("email", "size" => "30")) ?>

        <label for="password">Пароль</label>
        <?php echo $this->tag->passwordField(array("password", "size" => "30")) ?>

        <?php echo $this->tag->submitButton(array('Войти')) ?>

    </form>

SessionController::startAction (app/controllers/SessionController.phtml) будет проверять полученные данные на соответствие
хранимым в базе данных:

.. code-block:: php

    <?php

    class SessionController extends ControllerBase
    {

        // ...

        private function _registerSession($user)
        {
            $this->session->set('auth', array(
                'id' => $user->id,
                'name' => $user->name
            ));
        }

        public function startAction()
        {
            if ($this->request->isPost()) {

                // Получение переменных методом POST
                $email = $this->request->getPost('email', 'email');
                $password = $this->request->getPost('password');

                $password = sha1($password);

                // Поиск пользователя в базе данных
                $user = Users::findFirst(array(
                    "email = :email: AND password = :password: AND active = 'Y'",
                    "bind" => array('email' => $email, 'password' => $password)
                ));
                if ($user != false) {

                    $this->_registerSession($user);

                    $this->flash->success('Welcome ' . $user->name);

                    // Выдаем контроллер 'invoices', если пользователь существует
                    return $this->dispatcher->forward(array(
                        'controller' => 'invoices',
                        'action' => 'index'
                    ));
                }

                $this->flash->error('Wrong email/password');
            }

            // Снова выдаем форму авторизации
            return $this->dispatcher->forward(array(
                'controller' => 'session',
                'action' => 'index'
            ));

        }

    }

Для простоты мы будем использовать "sha1_" для сохранения хэшей паролей в базе данных. Однако, этот алгоритм не
рекомендуется в реальных приложениях. Используйте вместо него " :doc:`bcrypt <security>`".

Заметим, что в контролере доступны несколько публичных свойств, таких как $this->flash, $this->request и $this->session.
Они являются сервисами, определенными ранее в контейнере сервисов. При первом их использовании они инъецируются
в качестве части контроллера.

Эти сервисы являются разделяемыми, то есть они всегда нам доступны в тех же самых экземплярах и в любом месте,
где мы к ним обращаемся.

Здесь, например, мы обращаемся к сервису "session" чтобы сохранить пользовательские данные в переменной "auth":

.. code-block:: php

    <?php

    $this->session->set('auth', array(
        'id' => $user->id,
        'name' => $user->name
    ));

Безопасность бакенда
--------------------
Бакенд является приватной зоной, куда имеют доступ только зарегистрированные пользователи. Поэтому нужно проверять,
то только зарегистрированные пользователи имеют доступ к соответствующим контроллерам. Езли вы не авторизованы в
приложении и пытаетесь получить доступ, например, к контроллеру продуктов (который приватен), то увидите экран вроде
следующего:

.. figure:: ../_static/img/invo-2.png
   :align: center

Каждый раз, когда кто-то пытается получить доступ к контроллеру или его действию, приложение проверяет, что текущая роль
для данной сессии) имеет к нему доступ. В противном случае выводится сообщение как выше и управление переадресуется
лавной странице.

Давайте теперь разберем, как это сделано в приложении. Во-первых, узнаем о существовании компонента под названием
:doc:`Dispatcher <dispatching>`. Он информируется о маршруте, найденном компонентом :doc:`Routing <routing>`,
а затем решает, загрузить ли соответствующий контроллер и выполнить ли соответствующее действие.

Обычно фреймворк создает диспетчер автоматически. В нашем случае мы хотим выполнять некоторую проверку
перед выполнением нужного действия, а именно, проверять, имеет ли пользователь право его выполнять, или нет.
Для тостижения этого мы заменим диспетчер с помощью функции в загрузчике:

.. code-block:: php

    <?php

    $di->set('dispatcher', function() use ($di) {
        $dispatcher = new Phalcon\Mvc\Dispatcher();
        return $dispatcher;
    });

Теперь мы имеем полный контроль над используемым в приложении диспетчере. Многие компоненты фреймворка инициируют
события, которые позволяют нам изменять их внутренний поток операций. А компонент инъекции зависимости, играющий для
компонентов роль клея, предоставит нам еще один компонент - :doc:`EventsManager <events>`, позволяющий нам перехватывать
события и назначать их слушателям.

Управление событиями
^^^^^^^^^^^^^^^^^^^^
Назначать слушателей определенным типам событий нам позволяет :doc:`EventsManager <events>`.
Интересующий нас сейчас тип - это "dispatch". Следующий код фильтрует все события, инициированные диспетчером:

.. code-block:: php

    <?php

    $di->set('dispatcher', function() use ($di) {

        // Получаем стандартный менеджер событий с помощью DI
        $eventsManager = $di->getShared('eventsManager');

        // Инстанцируем плагин безопасности
        $security = new Security($di);

        // Плагин безопасности слушает события, инициированные диспетчером
        $eventsManager->attach('dispatch', $security);

        $dispatcher = new Phalcon\Mvc\Dispatcher();

        // Связываем менеджер событий с диспетчером
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    });

Плагин безопасности - это класс, описанный в app/plugins/Security.php. Этот класс реализует метод "beforeExecuteRoute"
(хук события). Его название совпадает с именем одного из событий, инициируемых диспетчером:

.. code-block:: php

    <?php

    use Phalcon\Events\Event,
        Phalcon\Mvc\Dispatcher,
        Phalcon\Mvc\User\Plugin;

    class Security extends Plugin
    {

        // ...

        public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
        {
            // ...
        }

    }

В качестве первого параметра хуки событий всегда получают информацию о контексте, в котором произошло событие, ($event),
а второй параметр - это объект, который инициировал само событие ($dispatcher). В общем случае необязательно,
чтобы плагины расширяли класс Phalcon\\Mvc\\User\\Plugin, но если они это делают, то упрощается доступ к сервисам приложения.

Теперь с помощью списка ACL мы можем проверить роль для текущей сессии на предмет наличия доступа у пользователя.
Если он/она не имеет доступа, мы будем перенаправлять его/её на главный экран, как показано ниже:

.. code-block:: php

    <?php

    use Phalcon\Events\Event,
        Phalcon\Mvc\Dispatcher,
        Phalcon\Mvc\User\Plugin;

    class Security extends Plugin
    {

        // ...

        public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
        {

            // Проверяем, установлена ли в сессии переменная "auth" для определения активной роли.
            $auth = $this->session->get('auth');
            if (!$auth) {
                $role = 'Guests';
            } else {
                $role = 'Users';
            }

            // Получаем активные контроллер и действие от диспетчера
            $controller = $dispatcher->getControllerName();
            $action = $dispatcher->getActionName();

            // Получаем список ACL
            $acl = $this->_getAcl();

            // Проверяем, имеет ли данная роль доступ к контроллеру (ресурсу)
            $allowed = $acl->isAllowed($role, $controller, $action);
            if ($allowed != Phalcon\Acl::ALLOW) {

                // Если доступа нет, перенаправляем его на контроллер "index".
                $this->flash->error("You don't have access to this module");
                $dispatcher->forward(
                    array(
                        'controller' => 'index',
                        'action' => 'index'
                    )
                );

                // Возвращая "false" мы приказываем диспетчеру прекратить текущую операцию
                return false;
            }

        }

    }

Создание списка ACL
^^^^^^^^^^^^^^^^^^^
В предыдущем примере мы получили ACL с помощью метода $this->_getAcl(). Этот метод реализуется в плагине.
Теперь мы шаг за шагом будем объяснять, как создать список контроля доступа (ACL):

.. code-block:: php

    <?php

    // Создаем ACL
    $acl = new Phalcon\Acl\Adapter\Memory();

    // Действием по умолчанию будет запрет
    $acl->setDefaultAction(Phalcon\Acl::DENY);

    // Регистрируем две роли. Users - это зарегистрированные пользователи,
    // а Guests - неидентифициорованные посетители.
    $roles = array(
        'users' => new Phalcon\Acl\Role('Users'),
        'guests' => new Phalcon\Acl\Role('Guests')
    );
    foreach ($roles as $role) {
        $acl->addRole($role);
    }

Теперь создадим ресурсы двух видов. Этими ресурсами будут являться имена контроллеров, а их действия примем за
доступы к этим ресурсам:

.. code-block:: php

    <?php

    // Приватные ресурсы (бакенд)
    $privateResources = array(
      'companies' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
      'products' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
      'producttypes' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
      'invoices' => array('index', 'profile')
    );
    foreach ($privateResources as $resource => $actions) {
        $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
    }

    // Публичные ресурсы (фронтенд)
    $publicResources = array(
      'index' => array('index'),
      'about' => array('index'),
      'session' => array('index', 'register', 'start', 'end'),
      'contact' => array('index', 'send')
    );
    foreach ($publicResources as $resource => $actions) {
        $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
    }

Теперь ACL знает о существующих контроллерах и связанных с ними действиях. Роли "Users" дадим доступ ко всем ресурсам
фронтенда и бакенда. А роли "Guests" дадим доступ только к публичным ресурсам:

.. code-block:: php

    <?php

    // Предоставляем пользователям и гостям доступ к публичным ресурсам
    foreach ($roles as $role) {
        foreach ($publicResources as $resource => $actions) {
            $acl->allow($role->getName(), $resource, '*');
        }
    }

    // Доступ к приватным ресурсам предоставляем только пользователям
    foreach ($privateResources as $resource => $actions) {
        foreach ($actions as $action) {
            $acl->allow('Users', $resource, $action);
        }
    }

Ура! Наш ACL готов.

Пользовательские компоненты
---------------------------
Все элементы UI и стили визуализации приложения в основном задаются с помощью `Twitter Bootstrap`_.
Некоторые элементы, такие как панель навигации, меняются соответственно состоянию приложения. Например,
в верхнем правом углу ссылка "Войти / Зарегистрироваться" при авторизации пользователя меняется на "Выйти".

Эта часть приложения реализуется в компоненте "Elements" (app/library/Elements.php).

.. code-block:: php

    <?php

    use Phalcon\Mvc\User\Component;

    class Elements extends Component
    {

        public function getMenu()
        {
            //...
        }

        public function getTabs()
        {
            //...
        }

    }

Этот класс расширяет Phalcon\\Mvc\\User\\Component. Это, в общем, необязательно, но помогает быстро получать
доступ к сервисам приложения. Теперь мы зарегистрируем этот класс в контейнере сервисов:

.. code-block:: php

    <?php

    // Регистрируем пользовательский компонент
    $di->set('elements', function(){
        return new Elements();
    });

Как и контроллеры, плагины и компоненты в представлениях, этот компонент также получит доступ к сервисам,
зарегистрированным в контейнере, и сам будет доступен как атрибут с тем именем, с каким мы его зарегистрировали:

.. code-block:: html+php

    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a class="brand" href="#">INVO</a>
                <?php echo $this->elements->getMenu() ?>
            </div>
        </div>
    </div>

    <div class="container">
        <?php echo $this->getContent() ?>
        <hr>
        <footer>
            <p>&copy; Company 2012</p>
        </footer>
    </div>

Обратите внимание на важную часть:

.. code-block:: html+php

    <?php echo $this->elements->getMenu() ?>

Working with the CRUD
---------------------
Most options that manipulate data (companies, products and types of products), were developed using a basic and
common CRUD_ (Create, Read, Update and Delete). Each CRUD contains the following files:

.. code-block:: bash

    invo/
        app/
            app/controllers/
                ProductsController.php
            app/models/
                Products.php
            app/views/
                products/
                    edit.phtml
                    index.phtml
                    new.phtml
                    search.phtml

Each controller has the following actions:

.. code-block:: php

    <?php

    class ProductsController extends ControllerBase
    {

        /**
         * The start action, it shows the "search" view
         */
        public function indexAction()
        {
            //...
        }

        /**
         * Execute the "search" based on the criteria sent from the "index"
         * Returning a paginator for the results
         */
        public function searchAction()
        {
            //...
        }

        /**
         * Shows the view to create a "new" product
         */
        public function newAction()
        {
            //...
        }

        /**
         * Shows the view to "edit" an existing product
         */
        public function editAction()
        {
            //...
        }

        /**
         * Creates a product based on the data entered in the "new" action
         */
        public function createAction()
        {
            //...
        }

        /**
         * Updates a product based on the data entered in the "edit" action
         */
        public function saveAction()
        {
            //...
        }

        /**
         * Deletes an existing product
         */
        public function deleteAction($id)
        {
            //...
        }

    }

The Search Form
^^^^^^^^^^^^^^^
Every CRUD starts with a search form. This form shows each field that has the table (products), allowing the user
creating a search criteria from any field. Table "products" has a relationship to the table "products_types".
In this case, we previously queried the records in this table in order to facilitate the search by that field:

.. code-block:: php

    <?php

    /**
     * The start action, it shows the "search" view
     */
    public function indexAction()
    {
        $this->persistent->searchParams = null;
        $this->view->productTypes = ProductTypes::find();
    }

All the "product types" are queried and passed to the view as a local variable "productTypes". Then, in the view
(app/views/index.phtml) we show a "select" tag filled with those results:

.. code-block:: html+php

    <div>
        <label for="product_types_id">Product Type</label>
        <?php echo $this->tag->select(array(
            "product_types_id",
            $productTypes,
            "using" => array("id", "name"),
            "useDummy" => true
        )) ?>
    </div>

Note that $productTypes contains the data necessary to fill the SELECT tag using Phalcon\\Tag::select. Once the form
is submitted, the action "search" is executed in the controller performing the search based on the data entered by
the user.

Performing a Search
^^^^^^^^^^^^^^^^^^^
The action "search" has a dual behavior. When accessed via POST, it performs a search based on the data sent from the
form. But when accessed via GET it moves the current page in the paginator. To differentiate one from another HTTP method,
we check it using the :doc:`Request <request>` component:

.. code-block:: php

    <?php

    /**
     * Execute the "search" based on the criteria sent from the "index"
     * Returning a paginator for the results
     */
    public function searchAction()
    {

        if ($this->request->isPost()) {
            //create the query conditions
        } else {
            //paginate using the existing conditions
        }

        //...

    }

With the help of :doc:`Phalcon\\Mvc\\Model\\Criteria <../api/Phalcon_Mvc_Model_Criteria>`, we can create the search
conditions intelligently based on the data types and values sent from the form:

.. code-block:: php

    <?php

    $query = Criteria::fromInput($this->di, "Products", $_POST);

This method verifies which values are different from "" (empty string) and null and takes them into account to create
the search criteria:

* If the field data type is text or similar (char, varchar, text, etc.) It uses an SQL "like" operator to filter the results.
* If the data type is not text or similar, it'll use the operator "=".

Additionally, "Criteria" ignores all the $_POST variables that do not match any field in the table.
Values are automatically escaped using "bound parameters".

Now, we store the produced parameters in the controller's session bag:

.. code-block:: php

    <?php

    $this->persistent->searchParams = $query->getParams();

A session bag, is a special attribute in a controller that persists between requests. When accessed, this attribute injects
a :doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>` service that is independent in each controller.

Then, based on the built params we perform the query:

.. code-block:: php

    <?php

    $products = Products::find($parameters);
    if (count($products) == 0) {
        $this->flash->notice("The search did not found any products");
        return $this->forward("products/index");
    }

If the search doesn't return any product, we forward the user to the index action again. Let's pretend the
search returned results, then we create a paginator to navigate easily through them:

.. code-block:: php

    <?php

    $paginator = new Phalcon\Paginator\Adapter\Model(array(
        "data" => $products,    //Data to paginate
        "limit" => 5,           //Rows per page
        "page" => $numberPage   //Active page
    ));

    //Get active page in the paginator
    $page = $paginator->getPaginate();

Finally we pass the returned page to view:

.. code-block:: php

    <?php

    $this->view->setVar("page", $page);

In the view (app/views/products/search.phtml), we traverse the results corresponding to the current page:

.. code-block:: html+php

    <?php foreach ($page->items as $product) { ?>
        <tr>
            <td><?= $product->id ?></td>
            <td><?= $product->getProductTypes()->name ?></td>
            <td><?= $product->name ?></td>
            <td><?= $product->price ?></td>
            <td><?= $product->active ?></td>
            <td><?= $this->tag->linkTo("products/edit/" . $product->id, 'Edit') ?></td>
            <td><?= $this->tag->linkTo("products/delete/" . $product->id, 'Delete') ?></td>
        </tr>
    <?php } ?>

Creating and Updating Records
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Now let's see how the CRUD creates and updates records. From the "new" and "edit" views the data entered by the user
are sent to the actions "create" and "save" that perform actions of "creating" and "updating" products respectively.

In the creation case, we recover the data submitted and assign them to a new "products" instance:

.. code-block:: php

    <?php

    /**
     * Creates a product based on the data entered in the "new" action
     */
    public function createAction()
    {

        $products = new Products();

        $products->id = $this->request->getPost("id", "int");
        $products->product_types_id = $this->request->getPost("product_types_id", "int");
        $products->name = $this->request->getPost("name", "striptags");
        $products->price = $this->request->getPost("price", "double");
        $products->active = $this->request->getPost("active");

        //...

    }

Data is filtered before being assigned to the object. This filtering is optional, the ORM escapes the input data and
performs additional casting according to the column types.

When saving we'll know whether the data conforms to the business rules and validations implemented in the model Products:

.. code-block:: php

    <?php

    /**
     * Creates a product based on the data entered in the "new" action
     */
    public function createAction()
    {

        //...

        if (!$products->create()) {

            //The store failed, the following messages were produced
            foreach ($products->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->forward("products/new");

        } else {
            $this->flash->success("Product was created successfully");
            return $this->forward("products/index");
        }

    }

Now, in the case of product updating, first we must present to the user the data that is currently in the edited record:

.. code-block:: php

    <?php

    /**
     * Shows the view to "edit" an existing product
     */
    public function editAction($id)
    {

        //...

        $product = Products::findFirstById($id);

        $this->tag->setDefault("id", $product->id);
        $this->tag->setDefault("product_types_id", $product->product_types_id);
        $this->tag->setDefault("name", $product->name);
        $this->tag->setDefault("price", $product->price);
        $this->tag->setDefault("active", $product->active);

    }

The "setDefault" helper sets a default value in the form on the attribute with the same name. Thanks to this,
the user can change any value and then sent it back to the database through to the "save" action:

.. code-block:: php

    <?php

    /**
     * Updates a product based on the data entered in the "edit" action
     */
    public function saveAction()
    {

        //...

        //Find the product to update
        $id = $this->request->getPost("id");
        $product = Products::findFirstById($id);
        if (!$product) {
            $this->flash->error("products does not exist " . $id);
            return $this->forward("products/index");
        }

        //... assign the values to the object and store it

    }

Changing the Title Dynamically
------------------------------
When you browse between one option and another will see that the title changes dynamically indicating where
we are currently working. This is achieved in each controller initializer:

.. code-block:: php

    <?php

    class ProductsController extends ControllerBase
    {

        public function initialize()
        {
            //Set the document title
            $this->tag->setTitle('Manage your product types');
            parent::initialize();
        }

        //...

    }

Note, that the method parent::initialize() is also called, it adds more data to the title:

.. code-block:: php

    <?php

    class ControllerBase extends Phalcon\Mvc\Controller
    {

        protected function initialize()
        {
            //Prepend the application name to the title
            $this->tag->prependTitle('INVO | ');
        }

        //...
    }

Finally, the title is printed in the main view (app/views/index.phtml):

.. code-block:: html+php

    <!DOCTYPE html>
    <html>
        <head>
            <?php echo $this->tag->getTitle() ?>
        </head>
        <!-- ... -->
    </html>

Conclusion
----------
This tutorial covers many more aspects of building applications with Phalcon, hope you have served to
learn more and get more out of the framework.

.. _Github: https://github.com/phalcon/invo
.. _CRUD: http://en.wikipedia.org/wiki/Create,_read,_update_and_delete
.. _Twitter Bootstrap: http://twitter.github.io/bootstrap/
.. _sha1: http://php.net/manual/en/function.sha1.php
.. _bcrypt: http://stackoverflow.com/questions/4795385/how-do-you-use-bcrypt-for-hashing-passwords-in-php
