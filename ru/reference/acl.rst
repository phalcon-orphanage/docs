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
    // The first parameter is the name, the second parameter is an optional description.
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

Function based access
---------------------
Also you can add as 4th parameter your custom function which must return boolean value. It will be called when you use :code:`isAllowed()` method. You can pass parameters as associative array to :code:`isAllowed()` method as 4th argument where key is parameter name in our defined function.

.. code-block:: php

    <?php
    // Set access level for role into resources with custom function
    $acl->allow(
        "Guests",
        "Customers",
        "search",
        function ($a) {
            return $a % 2 == 0;
        }
    );

    // Check whether role has access to the operation with custom function

    // Returns true
    $acl->isAllowed(
        "Guests",
        "Customers",
        "search",
        [
            "a" => 4,
        ]
    );

    // Returns false
    $acl->isAllowed(
        "Guests",
        "Customers",
        "search",
        [
            "a" => 3,
        ]
    );

Also if you don't provide any parameters in :code:`isAllowed()` method then default behaviour will be :code:`Acl::ALLOW`. You can change it by using method :code:`setNoArgumentsDefaultAction()`.

.. code-block:: php

    use Phalcon\Acl;

    <?php
    // Set access level for role into resources with custom function
    $acl->allow(
        "Guests",
        "Customers",
        "search",
        function ($a) {
            return $a % 2 == 0;
        }
    );

    // Check whether role has access to the operation with custom function

    // Returns true
    $acl->isAllowed(
        "Guests",
        "Customers",
        "search"
    );

    // Change no arguments default action
    $acl->setNoArgumentsDefaultAction(
        Acl::DENY
    );

    // Returns false
    $acl->isAllowed(
        "Guests",
        "Customers",
        "search"
    );

Objects as role name and resource name
--------------------------------------
You can pass objects as :code:`roleName` and :code:`resourceName`. Your classes must implement :doc:`Phalcon\\Acl\\RoleAware <../api/Phalcon_Acl_RoleAware>` for :code:`roleName` and :doc:`Phalcon\\Acl\\ResourceAware <../api/Phalcon_Acl_ResourceAware>` for :code:`resourceName`.

Our :code:`UserRole` class

.. code-block:: php

    <?php

    use Phalcon\Acl\RoleAware;

    // Create our class which will be used as roleName
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

        // Implemented function from RoleAware Interface
        public function getRoleName()
        {
            return $this->roleName;
        }
    }

And our :code:`ModelResource` class

.. code-block:: php

    <?php

    use Phalcon\Acl\ResourceAware;

    // Create our class which will be used as resourceName
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

        // Implemented function from ResourceAware Interface
        public function getResourceName()
        {
            return $this->resourceName;
        }
    }

Then you can use them in :code:`isAllowed()` method.

.. code-block:: php

    <?php

    use UserRole;
    use ModelResource;

    // Set access level for role into resources
    $acl->allow("Guests", "Customers", "search");
    $acl->allow("Guests", "Customers", "create");
    $acl->deny("Guests", "Customers", "update");

    // Create our objects providing roleName and resourceName

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

    // Check whether our user objects have access to the operation on model object

    // Returns false
    $acl->isAllowed(
        $designer,
        $customer,
        "search"
    );

    // Returns true
    $acl->isAllowed(
        $guest,
        $customer,
        "search"
    );

    // Returns true
    $acl->isAllowed(
        $anotherGuest,
        $customer,
        "search"
    );

Also you can access those objects in your custom function in :code:`allow()` or :code:`deny()`. They are automatically bind to parameters by type in function.

.. code-block:: php

    <?php

    use UserRole;
    use ModelResource;

    // Set access level for role into resources with custom function
    $acl->allow(
        "Guests",
        "Customers",
        "search",
        function (UserRole $user, ModelResource $model) { // User and Model classes are necessary
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

    // Create our objects providing roleName and resourceName

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

    // Check whether our user objects have access to the operation on model object

    // Returns false
    $acl->isAllowed(
        $designer,
        $customer,
        "search"
    );

    // Returns true
    $acl->isAllowed(
        $guest,
        $customer,
        "search"
    );

    // Returns false
    $acl->isAllowed(
        $anotherGuest,
        $customer,
        "search"
    );

You can still add any custom parameters to function and pass associative array in :code:`isAllowed()` method. Also order doesn't matter.

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

It's recommended to use the Memory adapter during development and use one of the other adapters in production.

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
    $acl->setEventsManager($eventManagers);

Реализация собственных адаптеров
--------------------------------
Для создания своего адаптера необходимо реализовать интерфейс :doc:`Phalcon\\Acl\\AdapterInterface <../api/Phalcon_Acl_AdapterInterface>`,
или использовать наследование от существующего адаптера.

.. _Список контроля доступа: http://ru.wikipedia.org/wiki/ACL
