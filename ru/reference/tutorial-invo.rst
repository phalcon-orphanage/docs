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

    // Read the configuration
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

    // Начать сессию в первый раз, когда какой нибудь компонент запросит сервис сессий.
    $di->set('session', function () {
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
    $di->set('db', function () use ($config) {
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

    $di->set('dispatcher', function () use ($di) {
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

    $di->set('dispatcher', function () use ($di) {

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
            // ...
        }

        public function getTabs()
        {
            // ...
        }

    }

Этот класс расширяет Phalcon\\Mvc\\User\\Component. Это, в общем, необязательно, но помогает быстро получать
доступ к сервисам приложения. Теперь мы зарегистрируем этот класс в контейнере сервисов:

.. code-block:: php

    <?php

    // Регистрируем пользовательский компонент
    $di->set('elements', function () {
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
            <p>&copy; Company 2015</p>
        </footer>
    </div>

Обратите внимание на важную часть:

.. code-block:: html+php

    <?php echo $this->elements->getMenu() ?>

Работа с CRUD
-------------
Большинство функционала, требующего манипуляции данными (компании, товары и типы товаров), разрабатывается с использованием простого и стандартного CRUD_ (Create, Read, Update и Delete). Каждый CRUD содержит примерно следующие файлы:

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

Каждый контроллер реализует следующие действия:

.. code-block:: php

    <?php

    class ProductsController extends ControllerBase
    {

        /**
         * Начальное действие, которое позволяет отправить запрос к "search".
         */
        public function indexAction()
        {
            // ...
        }

        /**
         * Выполняет "search" на основание критериев, отправленных с "index".
         * Возвращает результаты с пагинацией.
         */
        public function searchAction()
        {
            // ...
        }

        /**
         * Отображает форму создания нового продукта ("new").
         */
        public function newAction()
        {
            // ...
        }

        /**
         * Отображает форму для редактирование существующего продукта
         */
        public function editAction()
        {
            // ...
        }

        /**
         * Создает продукт согласно данным, которые были заданы действием "new".
         */
        public function createAction()
        {
            // ...
        }

        /**
         * Изменяет продукт согласно данным, которые были заданы действием "edit".
         */
        public function saveAction()
        {
            // ...
        }

        /**
         * Удаляет существующий продукт.
         */
        public function deleteAction($id)
        {
            // ...
        }

    }

Форма поиска
^^^^^^^^^^^^
Каждый CRUD начинается с формы поиска. Эта форма показывает все столбцы таблицы (products), позволяющие
пользователю задавать поисковые критерии по любому полю. Таблица "products" связана с таблицей "products_types".
Поэтому мы предварительно запрашиваем записи этой последней таблицы, чтобы предложить их для поиска по
соответствующему полю:

.. code-block:: php

    <?php

    /**
     * Начальное действие, которое отображает представление "search".
     */
    public function indexAction()
    {
        $this->persistent->searchParams = null;
        $this->view->productTypes = ProductTypes::find();
    }

Все "типы продуктов" запрашиваются и выдаются в представление, как локальная переменная "productTypes". Затем,
в самом представлении (app/views/index.phtml) мы выводим тег "select", содержащий эти результаты:

.. code-block:: html+php

    <div>
        <label for="product_types_id">Тип продукта</label>
        <?php echo $this->tag->select(array(
            "product_types_id",
            $productTypes,
            "using" => array("id", "name"),
            "useDummy" => true
        )) ?>
    </div>

Заметим, что $productTypes содержит в себе данные, заполняющие тег SELECT посредством Phalcon\\Tag::select.
При сабмите формы выполняется действие "search" описанного выше контроллера, которое производит поиск на
основании введенных пользователем данных.

Выполнение поиска
^^^^^^^^^^^^^^^^^
Действие "search" имеет двойственное поведение. В случае POST-запроса оно выполняет поиск на основе данных,
полученных с формы. А в случае GET-запроса оно меняет текущую страницу пагинатора. Чтобы различить эти два метода HTTP,
мы используем компонент :doc:`Request <request>`:

.. code-block:: php

    <?php

    /**
     * Выполняет поиск на основе критериев, полученных из "index".
     * Возвращает пагинатор результатов.
     */
    public function searchAction()
    {

        if ($this->request->isPost()) {
            // формируем условия запроса
        } else {
            // создаем страницу соответственно существующим условиям
        }

        // ...

    }

С помощью :doc:`Phalcon\\Mvc\\Model\\Criteria <../api/Phalcon_Mvc_Model_Criteria>` мы можем интеллектульно создать
условия поиска на основе типов данных и значений, полученных с формы:

.. code-block:: php

    <?php

    $query = Criteria::fromInput($this->di, "Products", $_POST);

Этот метод проверяет все значения, отличные от "" (пустой строки) и null, а затем использует их для создания критериев поиска:

* В случае текстового типа данных (char, varchar, text и т.д.), для фильтрации результатов поиска он использует оператор SQL "like".
* В противном случае он будет использовать оператор "=".

Кроме того, "Criteria" игнорирует все переменные $_POST, которые не соответствуют полям таблицы.
Значения автоматически эскейпируются с помощью "биндинга параметров".

Теперь сохраним созданные параметры в разделе сессии, предназначенном нашему контроллеру (сессионная сумка):

.. code-block:: php

    <?php

    $this->persistent->searchParams = $query->getParams();

Сессионная сумка - это специальный атрибут контроллера, значение которого сохраняется между запросами. При обращении к нему,
в него инъецируется сервис :doc:`Phalcon\\Session\\Bag <../api/Phalcon_Session_Bag>`, отдельный для каждого контроллера.

Теперь выполним запрос, основываясь на собранных параметрах:

.. code-block:: php

    <?php

    $products = Products::find($parameters);
    if (count($products) == 0) {
        $this->flash->notice("Поиск не нашел никаких продуктов");
        return $this->forward("products/index");
    }

Если поиск не вернул ни одного продукта, мы снова перенаправляем пользователся на действие index.
Если же поиск что-то находит, то создадим пагинатор для облегчения навигации по ним:

.. code-block:: php

    <?php

    $paginator = new Phalcon\Paginator\Adapter\Model(array(
        "data" => $products,    // Данные для пагинации
        "limit" => 5,           // Число строк на страницу
        "page" => $numberPage   // Активная страница
    ));

    // Получение активной страницы пагинатора
    $page = $paginator->getPaginate();

Передадим, наконец, полученную страницу на вывод:

.. code-block:: php

    <?php

    $this->view->setVar("page", $page);

В представлении (app/views/products/search.phtml) мы выводим результаты, соответствующие текущей странице:

.. code-block:: html+php

    <?php foreach ($page->items as $product) { ?>
        <tr>
            <td><?= $product->id ?></td>
            <td><?= $product->getProductTypes()->name ?></td>
            <td><?= $product->name ?></td>
            <td><?= $product->price ?></td>
            <td><?= $product->active ?></td>
            <td><?= $this->tag->linkTo("products/edit/" . $product->id, 'Редактировать') ?></td>
            <td><?= $this->tag->linkTo("products/delete/" . $product->id, 'Удалить') ?></td>
        </tr>
    <?php } ?>

Создание и изменение записей
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Давайте теперь посмотрим, как создавать и изменять записи в CRUD. Пользователь вводит данные в представлениях
"new" и "edit". Их получают действия "create" и "save", которые выполняют, соответственно, "создание" и "изменение"
продуктов.

В случае создания мы разбираем присланные данные и назначаем их новому экземпляру "products":

.. code-block:: php

    <?php

    /**
     * Создание продукта на основе данных, введенных в действии "new"
     */
    public function createAction()
    {

        $products = new Products();

        $products->id = $this->request->getPost("id", "int");
        $products->product_types_id = $this->request->getPost("product_types_id", "int");
        $products->name = $this->request->getPost("name", "striptags");
        $products->price = $this->request->getPost("price", "double");
        $products->active = $this->request->getPost("active");

        // ...

    }

Перед назначением объекту данные фильтруются, что в общем-то необязательно, так как ORM сам экранирует вводимые данные
и выполняет дополнительные преобразования соответственно типу столбца.

При сохранении мы проверяем, соответствуют ли данные бизнес-правилам и проходят ли проверки,
реализованные в модели Products:

.. code-block:: php

    <?php

    /**
     * Создание продукта на основе данных, введенных в действии "new"
     */
    public function createAction()
    {

        // ...

        if (!$products->create()) {

            // Сохранение не сработало, выводим сообщения о причинах
            foreach ($products->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            return $this->forward("products/new");

        } else {
            $this->flash->success("Продукт был успешно создан");
            return $this->forward("products/index");
        }

    }

Теперь перейдем к случаю изменения. Сначала мы должны предоставить пользователю данные текущей редактируемой записи:

.. code-block:: php

    <?php

    /**
     * Показываем представление "edit" для существующего продукта
     */
    public function editAction($id)
    {

        // ...

        $product = Products::findFirstById($id);

        $this->tag->setDefault("id", $product->id);
        $this->tag->setDefault("product_types_id", $product->product_types_id);
        $this->tag->setDefault("name", $product->name);
        $this->tag->setDefault("price", $product->price);
        $this->tag->setDefault("active", $product->active);

    }

Хелпер "setDefault" устанавливает значения по умолчанию тем полям форм, которые имеют соответствующий атрибут name.
Благодаря ему пользователь может изменить любое значение и отправить его обратно в базу данных через действие "save":

.. code-block:: php

    <?php

    /**
     * Изменение продукта на основе данных, введенных действием "edit"
     */
    public function saveAction()
    {

        // ...

        // Находим изменяемый продукт
        $id = $this->request->getPost("id");
        $product = Products::findFirstById($id);
        if (!$product) {
            $this->flash->error("не существует продукт " . $id);
            return $this->forward("products/index");
        }

        // ... назначаем объекту значения и сохраняем его

    }

Динамическое изменениие заголовка
---------------------------------
По мере того, как вы просматриваете страницы одну за другой, можете заметить, что их заголовоки динамически
меняются и показывают, где вы сейчас находитесь. Это достигается с помощью инициализатора контроллера:

.. code-block:: php

    <?php

    class ProductsController extends ControllerBase
    {

        public function initialize()
        {
            // Устанавливаем заголовок документа
            $this->tag->setTitle('Управление типами ваших продуктов');
            parent::initialize();
        }

        // ...

    }

Заметьте, что метод parent::initialize() также вызывается и может добавить в заголовок дополнительные данные:

.. code-block:: php

    <?php

    class ControllerBase extends Phalcon\Mvc\Controller
    {

        protected function initialize()
        {
            // Дописываем в начало заголовка название приложения
            $this->tag->prependTitle('INVO | ');
        }

        // ...
    }

Вот так этот заголовок выводится в главном представлении (app/views/index.phtml):

.. code-block:: html+php

    <!DOCTYPE html>
    <html>
        <head>
            <?php echo $this->tag->getTitle() ?>
        </head>
        <!-- ... -->
    </html>

Выводы
------
Этот учебник покрывает многие аспекты создания приложений с помощью Phalcon. Надеемся, что вы захотите
узнать об этом фреймворке еще больше.

.. _Github: https://github.com/phalcon/invo
.. _CRUD: http://en.wikipedia.org/wiki/Create,_read,_update_and_delete
.. _Twitter Bootstrap: http://twitter.github.io/bootstrap/
.. _sha1: http://php.net/manual/en/function.sha1.php
.. _bcrypt: http://stackoverflow.com/questions/4795385/how-do-you-use-bcrypt-for-hashing-passwords-in-php
