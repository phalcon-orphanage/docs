Урок 3: Защита INVO
===================

В этой главе мы продолжим объяснение структуры INVO. Мы поговорим
о реализации аутентификации, авторизации, используя события и плагины, а также
список контроля доступа (ACL), управляемый Phalcon.

Авторизация в приложении
------------------------
Авторизация позволит нам поработать с контроллерами бэкенда. Различие между контроллерами бэкенда и фронтенда является
только логическим. Все контроллеры находятся в одной и той же директории (app/controllers/).

Для входа в систему мы должны иметь правильные логин и пароль. Пользователи хранятся в таблице "users" базы данных "invo".

Перед стартом сессии мы должны сконфигурировать в приложении соединение с базой данных. В контейнере сервисов создадим сервис
с названием "db" указав необходимую информацию. Как и в случае автозагрузчика мы возьмем нужные параметры из файла
конфигурации с помощью сервиса конфигурации:

.. code-block:: php

    <?php

    use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

    // ...

    // Соединение с базой данных создается соответственно параметрам в конфигурационном файле
    $di->set('db', function () use ($config) {
        return new DbAdapter(
            array(
                "host"     => $config->database->host,
                "username" => $config->database->username,
                "password" => $config->database->password,
                "dbname"   => $config->database->name
            )
        );
    });

Здесь мы вернули экземпляр адаптера соединения с MySQL. Если это необходимо, вы можете реализовать дополнительные действия,
такие как логирование и профилирование запросов, изменить адаптер, сконфигурировав его как вам угодно.

Теперь создадим следующую простую форму (app/views/session/index.phtml) для отправки информации для авторизации.
Мы удалили из нее некоторый код HTML, чтобы сделать пример более простым:

.. code-block:: html+jinja

    {{ form('session/start') }}
        <fieldset>
            <div>
                <label for="email">Логин/Email</label>
                <div>
                    {{ text_field('email') }}
                </div>
            </div>
            <div>
                <label for="password">Пароль</label>
                <div>
                    {{ password_field('password') }}
                </div>
            </div>
            <div>
                {{ submit_button('Войти') }}
            </div>
        </fieldset>
    </form>

Вместо использования обычного PHP (как в предыдущем уроке), мы воспользовались :doc:`Volt <volt>`. Это встроенный
шаблонизатор, вдохновленный Jinja_, предоставляющий простой и удобный синтаксис создания шаблонов.
Знакомство с Volt не займет много времени.

SessionController::startAction (app/controllers/SessionController.phtml) будет проверять полученные данные на соответствие
хранимым в базе данных:

.. code-block:: php

    <?php

    class SessionController extends ControllerBase
    {
        // ...

        private function _registerSession($user)
        {
            $this->session->set(
                'auth',
                array(
                    'id'   => $user->id,
                    'name' => $user->name
                )
            );
        }

        /**
         * Это действие авторизует пользователя в приложении
         */
        public function startAction()
        {
            if ($this->request->isPost()) {

                // Получение переменных методом POST
                $email    = $this->request->getPost('email');
                $password = $this->request->getPost('password');

                // Поиск пользователя в базе данных
                $user = Users::findFirst(
                    array(
                        "(email = :email: OR username = :email:) AND password = :password: AND active = 'Y'",
                        'bind' => array(
                            'email'    => $email,
                            'password' => sha1($password)
                        )
                    )
                );

                if ($user != false) {

                    $this->_registerSession($user);

                    $this->flash->success('Welcome ' . $user->name);

                    // Выдаем контроллер 'invoices', если пользователь существует
                    return $this->dispatcher->forward(
                        array(
                            'controller' => 'invoices',
                            'action'     => 'index'
                        )
                    );
                }

                $this->flash->error('Неверный email/password');
            }

            // Снова выдаем форму авторизации
            return $this->dispatcher->forward(
                array(
                    'controller' => 'session',
                    'action'     => 'index'
                )
            );
        }
    }

Для простоты мы будем использовать "sha1_" для сохранения хэшей паролей в базе данных. Однако, этот алгоритм не
рекомендуется в реальных приложениях. Используйте вместо него ":doc:`bcrypt <security>`".

Заметим, что в контролере доступны несколько публичных свойств, таких как $this->flash, $this->request и $this->session.
Они являются сервисами, определенными ранее в контейнере сервисов. При первом их использовании они инъецируются
в качестве части контроллера.

Эти сервисы являются разделяемыми, то есть они всегда нам доступны в тех же самых экземплярах и в любом месте,
где мы к ним обращаемся.

Здесь, например, мы обращаемся к сервису "session" чтобы сохранить пользовательские данные в переменной "auth":

.. code-block:: php

    <?php

    $this->session->set(
        'auth',
        array(
            'id'   => $user->id,
            'name' => $user->name
        )
    );

Другой важный аспект этой главы - это то, как сверяются данные пользователя,
сперва мы проверяем, был ли запрос выполнен методом POST:

.. code-block:: php

    <?php

    if ($this->request->isPost()) {

Затем получаем параметры из формы:

.. code-block:: php

    <?php

    $email    = $this->request->getPost('email');
    $password = $this->request->getPost('password');

Теперь мы должны проверить, имеется ли пользователь с таким же именем или почтой и паролем:

.. code-block:: php

    <?php

    $user = Users::findFirst(
        array(
            "(email = :email: OR username = :email:) AND password = :password: AND active = 'Y'",
            'bind' => array(
                'email'    => $email,
                'password' => sha1($password)
            )
        )
    );

Обратите внимание на использование 'связаннных параметров', плейсхолдеры :email: и :password: расположены там, где должны быть значения переменных,
затем сами значения 'связываются' с помощью параметра 'bind'. Таким образом, плейсхолдеры заменяются связанными с ними значениями
без риска SQL инъекции.

Если пользователь валидный, то регистрируем его в сессии и перенаправляем его/ее на панель управления:

.. code-block:: php

    <?php

    if ($user != false) {
        $this->_registerSession($user);
        $this->flash->success('Welcome ' . $user->name);

        return $this->forward('invoices/index');
    }

Если пользователь не существует, то возвращаем его на страницу с формой авторизации:

.. code-block:: php

    <?php

    return $this->forward('session/index');

Безопасность бэкенда
--------------------
Бэкенд является приватной зоной, куда имеют доступ только зарегистрированные пользователи. Поэтому нужно проверять,
что только зарегистрированные пользователи имеют доступ к соответствующим контроллерам. Если вы не авторизованы в
приложении и пытаетесь получить доступ, например, к контроллеру продуктов (который приватен), то увидите экран вроде
следующего:

.. figure:: ../_static/img/invo-2.png
   :align: center

Каждый раз, когда кто-то пытается получить доступ к контроллеру или его действию, приложение проверяет, что текущая роль
(для данной сессии) имеет к нему доступ. В противном случае выводится сообщение как выше и управление переадресуется
главной странице.

Давайте теперь разберем, как это сделано в приложении. Во-первых, узнаем о существовании компонента под названием
:doc:`Dispatcher <dispatching>`. Он информируется о маршруте, найденном компонентом :doc:`Routing <routing>`,
а затем решает, загрузить ли соответствующий контроллер и выполнить ли соответствующее действие.

Обычно фреймворк создает диспетчер автоматически. В нашем случае мы хотим выполнять некоторую проверку
перед выполнением нужного действия, а именно, проверять, имеет ли пользователь право его выполнять или нет.
Для тостижения этого мы заменим диспетчер с помощью функции в загрузчике:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Dispatcher;

    // ...

    /**
     * Диспетчер MVC
     */
    $di->set('dispatcher', function () {

        // ...

        $dispatcher = new Dispatcher();

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

    use Phalcon\Mvc\Dispatcher;
    use Phalcon\Events\Manager as EventsManager;

    $di->set('dispatcher', function () {

        // Получаем стандартный менеджер событий с помощью DI
        $eventsManager = new EventsManager();

        // Плагин безопасности слушает события, инициированные диспетчером
        $eventsManager->attach('dispatch:beforeExecuteRoute', new SecurityPlugin);

        // Отлавливаем исключения и not-found исключения, используя NotFoundPlugin
        $eventsManager->attach('dispatch:beforeException', new NotFoundPlugin);

        $dispatcher = new Dispatcher();

        // Связываем менеджер событий с диспетчером
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    });

При срабатывании события "beforeExecuteRoute" будет оповещен следующий плагин:

.. code-block:: php

    <?php

    /**
     * С помощью SecurityPlugin проверяем, разрешен ли пользователю доступ к определенному действию
     */
    $eventsManager->attach('dispatch:beforeExecuteRoute', new SecurityPlugin);

Когда срабатывает "beforeException", оповещается другой плагин:

.. code-block:: php

    <?php

    /**
     * Отлавливаем исключения и not-found исключения, используя NotFoundPlugin
     */
    $eventsManager->attach('dispatch:beforeException', new NotFoundPlugin);

Плагин безопасности - это класс, описанный в app/plugins/Security.php. Этот класс реализует метод "beforeExecuteRoute"
(хук события). Его название совпадает с именем одного из событий, инициируемых диспетчером:

.. code-block:: php

    <?php

    use Phalcon\Events\Event;
    use Phalcon\Mvc\User\Plugin;
    use Phalcon\Mvc\Dispatcher;

    class SecurityPlugin extends Plugin
    {
        // ...

        public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
        {
            // ...
        }
    }

В качестве первого параметра хуки событий всегда получают информацию о контексте, в котором произошло событие ($event),
а второй параметр - это объект, который инициировал само событие ($dispatcher). В общем случае необязательно,
чтобы плагины расширяли класс Phalcon\\Mvc\\User\\Plugin, но если они это делают, то упрощается доступ к сервисам приложения.

Теперь с помощью списка ACL мы можем проверить роль для текущей сессии на предмет наличия доступа у пользователя.
Если он/она не имеет доступа, мы будем перенаправлять его/её на главный экран, как показано ниже:

.. code-block:: php

    <?php

    use Phalcon\Acl;
    use Phalcon\Events\Event;
    use Phalcon\Mvc\User\Plugin;
    use Phalcon\Mvc\Dispatcher;

    class SecurityPlugin extends Plugin
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
            $acl = $this->getAcl();

            // Проверяем, имеет ли данная роль доступ к контроллеру (ресурсу)
            $allowed = $acl->isAllowed($role, $controller, $action);
            if ($allowed != Acl::ALLOW) {

                // Если доступа нет, перенаправляем его на контроллер "index".
                $this->flash->error("У вас нет доступа к данному модулю");
                $dispatcher->forward(
                    array(
                        'controller' => 'index',
                        'action'     => 'index'
                    )
                );

                // Возвращая "false" мы приказываем диспетчеру прекратить текущую операцию
                return false;
            }
        }
    }

Создание списка ACL
^^^^^^^^^^^^^^^^^^^
В предыдущем примере мы получили ACL с помощью метода $this->getAcl(). Этот метод реализуется в плагине.
Теперь мы шаг за шагом будем объяснять, как создать список контроля доступа (ACL):

.. code-block:: php

    <?php

    use Phalcon\Acl;
    use Phalcon\Acl\Role;
    use Phalcon\Acl\Adapter\Memory as AclList;

    // Создаем ACL
    $acl = new AclList();

    // Действием по умолчанию будет запрет
    $acl->setDefaultAction(Acl::DENY);

    // Регистрируем две роли. Users - это зарегистрированные пользователи,
    // а Guests - неидентифициорованные посетители.
    $roles = array(
        'users'  => new Role('Users'),
        'guests' => new Role('Guests')
    );

    foreach ($roles as $role) {
        $acl->addRole($role);
    }

Теперь создадим ресурсы двух видов. Этими ресурсами будут являться имена контроллеров, а их действия примем за
доступы к этим ресурсам:

.. code-block:: php

    <?php

    use Phalcon\Acl\Resource;

    // ...

    // Приватные ресурсы (бэкенд)
    $privateResources = array(
      'companies'    => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
      'products'     => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
      'producttypes' => array('index', 'search', 'new', 'edit', 'save', 'create', 'delete'),
      'invoices'     => array('index', 'profile')
    );
    foreach ($privateResources as $resource => $actions) {
        $acl->addResource(new Resource($resource), $actions);
    }

    // Публичные ресурсы (фронтенд)
    $publicResources = array(
        'index'    => array('index'),
        'about'    => array('index'),
        'register' => array('index'),
        'errors'   => array('show404', 'show500'),
        'session'  => array('index', 'register', 'start', 'end'),
        'contact'  => array('index', 'send')
    );
    foreach ($publicResources as $resource => $actions) {
        $acl->addResource(new Resource($resource), $actions);
    }

Теперь ACL знает о существующих контроллерах и связанных с ними действиях. Роли "Users" дадим доступ ко всем ресурсам
фронтенда и бэкенда. А роли "Guests" дадим доступ только к публичным ресурсам:

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

Ура! Наш ACL готов. В следующей главе мы увидим, как реализован CRUD в Phalcon, и как вы
можете настроить его.

.. _jinja: http://jinja.pocoo.org/
.. _sha1: http://php.net/manual/ru/function.sha1.php
.. _bcrypt: http://stackoverflow.com/questions/4795385/how-do-you-use-bcrypt-for-hashing-passwords-in-php
