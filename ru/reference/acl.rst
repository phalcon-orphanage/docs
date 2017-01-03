Списки Контроля Доступа (ACL)
=============================

:doc:`Phalcon\\Acl <../api/Phalcon_Acl>` предоставляет простое и легкое управление контролем доступа и прикрепленными
разрешениями. `Список контроля доступа`_ (ACL) позволяет приложению управлять доступом к своим областям и основным
запрошенным объектам.
Необходимо понимать основные методологии ACL, чтобы понимать принцип работы.

И в заключении: ACL состоит из ролей и ресурсов. Ресурсами являются объекты, на которые накладываются определенные
разрешения с помощью ACL. Ролями являются объекты, которые запрашивают доступ к ресурсам и получаются ответ от ACL: разрешено/запрещено.

Создание ACL
------------
Этот компонент изначально сделан так, чтобы работать непосредственно в памяти, предоставляя программисту простое использование и скорость в обращении к любому элементу ACL (ресурсу или роли). Конструктор :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` принимает в качестве
первого параметра адаптер, который будет использоваться для получения информации связанной с контролируемым списком.
Пример использования адаптера памяти:

.. code-block:: php

    <?php

    use Phalcon\Acl\Adapter\Memory as AclList;

    $acl = new AclList();

По умолчанию :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` предоставляет доступ к действию над ресурсом, которое еще не было
определенно в ACL. Чтобы увеличить уровень безопасности мы можем указать уровень "запрещено", как уровень по умолчанию.

.. code-block:: php

    <?php

    use Phalcon\Acl;

    // Указываем "запрещено" по умолчанию для тех объектов, которые не были занесены в список контроля доступа
    $acl->setDefaultAction(
        Acl::DENY
    );

Добавление ролей
----------------
Ролью является объект, который имеет или не имеет доступа к определенному ресурсу в списке доступа. Для примера,
мы определим роли людей из организации. Класс :doc:`Phalcon\\Acl\\Role <../api/Phalcon_Acl_Role>`  позволяет создать
роли в более структурированной форме. Давайте добавим несколько ролей в наш недавно созданный список:

.. code-block:: php

    <?php

    use Phalcon\Acl\Role;

    // Создаем роли.
    // Первый параметр это название роли, второй параметр необязателен - это описание роли.
    $roleAdmins = new Role("Administrators", "Super-User role");
    $roleGuests = new Role("Guests");

    // Добавляем "Guests" в список ACL
    $acl->addRole($roleGuests);

    // Добавляем "Designers" без класса Phalcon\Acl\Role
    $acl->addRole("Designers");

Как вы можете видеть, роли определяются непосредственно, без использования экземпляра.

Добавление ресурсов
-------------------
Ресурсами являются объекты, доступ к которым контролируется. Обычно в MVC приложениях ресурсы относятся к контроллерам.
Хотя это не является обязательным, класс :doc:`Phalcon\\Acl\\Resource <../api/Phalcon_Acl_Resource>` может быть использован
при определении любых ресурсов. Важно добавить связующие действия или операции над ресурсами, чтобы ACL мог понимать, что ему
нужно контролировать.

.. code-block:: php

    <?php

    use Phalcon\Acl\Resource;

    // Определяем ресурс "Customers"
    $customersResource = new Resource("Customers");

    // Добавим ресурс "Customers" с несколькими операциями

    $acl->addResource(
        $customersResource,
        "search"
    );

    $acl->addResource(
        $customersResource,
        [
            "create",
            "update",
        ]
    );

Определение контроля доступа
----------------------------
Теперь у нас есть роли и ресурсы. Настало время указать для ACL, какие разрешения имеют роли при доступе к ресурсам.
Данная часть очень важна, особенно принимая во внимание используемый по умолчанию уровень "разрешить" или "запретить".

.. code-block:: php

    <?php

    // Задаем уровень доступа для ролей на определенный ресурс

    $acl->allow("Guests", "Customers", "search");

    $acl->allow("Guests", "Customers", "create");

    $acl->deny("Guests", "Customers", "update");

Метод "allow" определяет, что данная роль имеет доступ к действию над ресурсом. Метод "deny" делает обратное.

Запросы к ACL
-------------
После того, как список был полностью составлен, мы можем запрашивать проверку на права той или иной роли.

.. code-block:: php

    <?php

    // Проверяем, имеет ли роль "Guests" доступ к разным операциям по отношению к ресурсу "Customers"

    // Возвращает 0
    $acl->isAllowed("Guests", "Customers", "edit");

    // Возвращает 1
    $acl->isAllowed("Guests", "Customers", "search");

    // Возвращает 1
    $acl->isAllowed("Guests", "Customers", "create");

Доступ на основе пользовательских функций
-----------------------------------------
Вы также можете использовать 4-м параметром вашу пользовательскую функцию, которая должна возвращать логическое значение и будет вызвана каждый раз при использовании метода :code:`isAllowed()`.
Если ваша функция должна принимать значения - передайте в качестве 4-го агрумента ассоциативный массив в метод :code:`isAllowed()`, где ключи (Важно!) должны соответствовать именам параметров в определении функции.

.. code-block:: php

    <?php
    // Установим уровень доступа с пользовательской функцией для роли "Guests" ресурса "Customers".
    $acl->allow(
        "Guests",
        "Customers",
        "search",
        function ($a) {
            return $a % 2 === 0;
        }
    );

    // Проверить с помощью пользовательской функции, есть ли у роли "Guests" доступ к операции "search".

    // Вернёт true
    $acl->isAllowed(
        "Guests",
        "Customers",
        "search",
        [
            "a" => 4,
        ]
    );

    // Вернёт false
    $acl->isAllowed(
        "Guests",
        "Customers",
        "search",
        [
            "a" => 3,
        ]
    );

Следует понимать, если ваша функция принимает аргументы и вы не передаёте какие-либо параметры в метод :code:`isAllowed()`, то поведением по умолчанию является :code:`Acl::ALLOW`.
Вы можете изменить это поведение с помощью метода :code:`setNoArgumentsDefaultAction()`.

.. code-block:: php

    use Phalcon\Acl;

    <?php
    // Установим уровень доступа с пользовательской функцией.
    $acl->allow(
        "Guests",
        "Customers",
        "search",
        function ($a) {
            return $a % 2 === 0;
        }
    );

    // Проверим с помощью ранее установленной функции, есть ли у роли доступ к операции.

    // Вернёт true
    $acl->isAllowed(
        "Guests",
        "Customers",
        "search"
    );

    // Изменим значение по умолчанию если не переданы аргументы.
    $acl->setNoArgumentsDefaultAction(
        Acl::DENY
    );

    // Вернёт false
    $acl->isAllowed(
        "Guests",
        "Customers",
        "search"
    );

Пользовательские классы ролей/ресурсов
--------------------------------------
Вы можете использовать свои классы в качестве объектов роли или ресурса и передавать экземпляры объектов в аргументах :code:`roleName` и :code:`resourceName`.
Ваши классы должны реализовывать интерфейс :doc:`Phalcon\\Acl\\RoleAware <../api/Phalcon_Acl_RoleAware>` для :code:`roleName` и :doc:`Phalcon\\Acl\\ResourceAware <../api/Phalcon_Acl_ResourceAware>` для :code:`resourceName`.

Пример пользовательского класса :code:`UserRole`

.. code-block:: php

    <?php

    use Phalcon\Acl\RoleAware;

    // Создадим свой класс, который будет использоваться как roleName.
    class UserRole implements RoleAware
    {
        protected $id;

        protected $roleName;

        public function __construct($id, $roleName)
        {
            $this->id       = $id;
            $this->roleName = $roleName;
        }

        public function getId()
        {
            return $this->id;
        }

        // Реализуем интерфейс RoleAware
        public function getRoleName()
        {
            return $this->roleName;
        }
    }

Реализуем ещё один наш класс :code:`ModelResource`

.. code-block:: php

    <?php

    use Phalcon\Acl\ResourceAware;

    // Создадим класс, который будет использоваться в качестве имени ресурса (resourceName).
    class ModelResource implements ResourceAware
    {
        protected $id;

        protected $resourceName;

        protected $userId;

        public function __construct($id, $resourceName, $userId)
        {
            $this->id           = $id;
            $this->resourceName = $resourceName;
            $this->userId       = $userId;
        }

        public function getId()
        {
            return $this->id;
        }

        public function getUserId()
        {
            return $this->userId;
        }

        // Реализуем интерфейс ResourceAware
        public function getResourceName()
        {
            return $this->resourceName;
        }
    }

Теперь вы можете использовать эти классы в методе :code:`isAllowed()`.

.. code-block:: php

    <?php

    use UserRole;
    use ModelResource;

    // Задаем уровень доступа для ролей на определенный ресурс
    $acl->allow("Guests", "Customers", "search");
    $acl->allow("Guests", "Customers", "create");
    $acl->deny("Guests", "Customers", "update");

    // Создадим экземпляры наших классов для roleName и resourceName

    $customer = new ModelResource(
        1,
        "Customers",
        2
    );

    $designer = new UserRole(
        1,
        "Designers"
    );

    $guest = new UserRole(
        2,
        "Guests"
    );

    $anotherGuest = new UserRole(
        3,
        "Guests"
    );

    // Проверяем, имеют ли наши объекты ролей доступ к разным операциям по отношению к ресурсу $customer.

    // Вернёт false
    $acl->isAllowed(
        $designer,
        $customer,
        "search"
    );

    // Вернёт true
    $acl->isAllowed(
        $guest,
        $customer,
        "search"
    );

    // Вернёт true
    $acl->isAllowed(
        $anotherGuest,
        $customer,
        "search"
    );

Если вы используете пользовательскую функцию в методах :code:`allow()` или :code:`deny()`, то вы можете внутри функции получить доступ к этим объектам - они автоматически связываются на основе типов в определении функции.

.. code-block:: php

    <?php

    use UserRole;
    use ModelResource;

    // Установим уровень доступа с пользовательской функцией
    $acl->allow(
        "Guests",
        "Customers",
        "search",
        function (UserRole $user, ModelResource $model) { // Необходимые классы User и Model
            return $user->getId == $model->getUserId();
        }
    );

    $acl->allow(
        "Guests",
        "Customers",
        "create"
    );

    $acl->deny(
        "Guests",
        "Customers",
        "update"
    );

    // Создадим экземпляры наших классов для roleName и resourceName

    $customer = new ModelResource(
        1,
        "Customers",
        2
    );

    $designer = new UserRole(
        1,
        "Designers"
    );

    $guest = new UserRole(
        2,
        "Guests"
    );

    $anotherGuest = new UserRole(
        3,
        "Guests"
    );

    // Проверяем, имеют ли наши объекты ролей доступ к разным операциям по отношению к ресурсу $customer.

    // Вернёт false
    $acl->isAllowed(
        $designer,
        $customer,
        "search"
    );

    // Вернёт true
    $acl->isAllowed(
        $guest,
        $customer,
        "search"
    );

    // Вернёт false
    $acl->isAllowed(
        $anotherGuest,
        $customer,
        "search"
    );

Вы по-прежнему можете использовать любые параметры в определении пользовательской функции и передавать ассоциативный массив в метод :code:`isAllowed()`, порядок ключей не имеет значения.

Наследование ролей
------------------
Вы можете строить сложные структуры ролей используя наследование, которое предоставляет класс
:doc:`Phalcon\\Acl\\Role <../api/Phalcon_Acl_Role>`. Роли могут наследовать доступ других ролей. Чтобы использовать
наследование ролей вам необходимо передать в качестве второго параметра другую роль при определении роли.

.. code-block:: php

    <?php

    use Phalcon\Acl\Role;

    // ...

    // Создаем несколько ролей

    $roleAdmins = new Role("Administrators", "Super-User role");

    $roleGuests = new Role("Guests");

    // Добавляем роль "Guests"
    $acl->addRole($roleGuests);

    // Добавляем роль "Administrators" наследуемую от роли "Guests"
    $acl->addRole($roleAdmins, $roleGuests);

Сериализация ACL
----------------
Чтобы увеличить производительность, объект :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` можно сериализовать для хранения
в текстовом формате или в базе данных, и повторно использовать :doc:`Phalcon\\Acl <../api/Phalcon_Acl>` без
переобъявления всего списка каждый раз. Вы можете сделать это следующим образом:

.. code-block:: php

    <?php

    use Phalcon\Acl\Adapter\Memory as AclList;

    // ...

    // Проверяем существует ли сериализованный файл
    if (!is_file("app/security/acl.data")) {
        $acl = new AclList();

        // ... Определяем роли, ресурсы, доступ и т.д.

        // Сохраняем сериализованный объект в файл
        file_put_contents(
            "app/security/acl.data",
            serialize($acl)
        );
    } else {
        // Восстанавливаем ACL объект из текстового файла
        $acl = unserialize(
            file_get_contents("app/security/acl.data")
        );
    }

    // Используем ACL
    if ($acl->isAllowed("Guests", "Customers", "edit")) {
        echo "Доступ разрешен!";
    } else {
        echo "Доступ запрещен :(";
    }

Рекомендуется использовать адаптер Memory в процессе разработки, но использовать любой другой адаптер в процессе эксплуатации вашего приложения.

События ACL
-----------
:doc:`Phalcon\\Acl <../api/Phalcon_Acl>` может отправлять события в :doc:`EventsManager <events>`. События срабатывают
используя тип "acl". Некоторые события могут возвращать boolean значение 'false', чтобы прервать текущую операцию.
Поддерживаются следующие типы событий:

+-------------------+--------------------------------------------------+----------------------------+
| Название события  | Когда срабатывает                                | Может остановить операцию? |
+===================+==================================================+============================+
| beforeCheckAccess | Срабатывает перед проверкой доступа роли/ресурса | Да                         |
+-------------------+--------------------------------------------------+----------------------------+
| afterCheckAccess  | Срабатывает после проверки доступа роли/ресурса  | Нет                        |
+-------------------+--------------------------------------------------+----------------------------+

В следующем примере показано, как прикрепить слушателей (listeners) к компоненту:

.. code-block:: php

    <?php

    use Phalcon\Acl\Adapter\Memory as AclList;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;

    // ...

    // Создаем менеджер событий
    $eventsManager = new EventsManager();

    // Прикрепляем слушателя (функцию/callback) к типу "acl"
    $eventsManager->attach(
        "acl:beforeCheckAccess",
        function (Event $event, $acl) {
            echo $acl->getActiveRole();

            echo $acl->getActiveResource();

            echo $acl->getActiveAccess();
        }
    );

    $acl = new AclList();

    // Настраиваем $acl
    // ...

    // Присваиваем менеджера событий к компоненту ACL
    $acl->setEventsManager($eventsManager);

Реализация собственных адаптеров
--------------------------------
Для создания своего адаптера необходимо реализовать интерфейс :doc:`Phalcon\\Acl\\AdapterInterface <../api/Phalcon_Acl_AdapterInterface>`,
или использовать наследование от существующего адаптера.

.. _Список контроля доступа: http://ru.wikipedia.org/wiki/ACL
