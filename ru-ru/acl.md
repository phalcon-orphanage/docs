* * *

layout: default language: 'en' version: '3.4'

* * *

<a name='overview'></a>

# Списки управления доступом (ACL)

[Phalcon\Acl](api/Phalcon_Acl) provides an easy and lightweight management of ACLs as well as the permissions attached to them. [Списки управления доступом](http://en.wikipedia.org/wiki/Access_control_list) (ACL) позволяют приложению управлять доступом к различным своим частям и запрошенным объектам. Рекомендуется ознакомится с ACL подробнее, чтобы понимать принцип работы и основные понятия.

В целом, ACL основано на таких понятиях как роли и ресурсы. Ресурсами являются объекты, на которые накладываются определенные разрешения с помощью ACL. Роли — это объекты, которые запрашивают доступ к ресурсам, который может быть разрешен или запрещен ACL механизмом.

<a name='setup'></a>

## Создание списков контроля доступа

Этот компонент изначально сделан так, чтобы работать непосредственно в памяти. Это предоставляет простое использование и скорость в обращении к любому аспекту ACL. The [Phalcon\Acl](api/Phalcon_Acl) constructor takes as its first parameter an adapter used to retrieve the information related to the control list. Ниже приведен пример использования адаптера работающего в памяти:

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;

$acl = new AclList();
```

By default [Phalcon\Acl](api/Phalcon_Acl) allows access to action on resources that have not yet been defined. Для повышения уровня безопасности списка доступа к мы можем определить уровень `deny` как уровень доступа по умолчанию.

```php
<?php

use Phalcon\Acl;

// Действие по умолчанию: запретить доступ
$acl->setDefaultAction(
    Acl::DENY
);
```

<a name='adding-roles'></a>

## Добавление ролей к ACL

Ролью является объект, который имеет или не имеет доступа к определенному ресурсу в списке доступа. Для примера, мы определим роли людей в организации. The [Phalcon\Acl\Role](api/Phalcon_Acl_Role) class is available to create roles in a more structured way. Давайте добавим несколько ролей в наш недавно созданный список:

```php
<?php

use Phalcon\Acl\Role;

// Создаем роли.
// Первый параметр это название роли, второй параметр необязателен - это описание роли.
$roleAdmins = new Role('Administrators', 'Super-User role');
$roleGuests = new Role('Guests');

// Добавляем 'Guests' в список ACL
$acl->addRole($roleGuests);

// Добавляем 'Designers' без класса Phalcon\Acl\Role
$acl->addRole('Designers');
```

Как вы можете видеть, роли могут определяются непосредственно, без использования экземпляра класса.

<a name='adding-resources'></a>

## Добавление ресурсов

Ресурсами являются объекты, доступ к которым контролируется. Обычно в MVC приложениях ресурсы относятся к контроллерам. Although this is not mandatory, the [Phalcon\Acl\Resource](api/Phalcon_Acl_Resource) class can be used in defining resources. Важно добавить связующие действия или операции над ресурсами, чтобы ACL мог понимать, что ему нужно контролировать.

```php
<?php

use Phalcon\Acl\Resource;

// Определяем ресурс 'Customers'
$customersResource = new Resource('Customers');

// Добавим ресурс 'Customers' с несколькими операциями

$acl->addResource(
    $customersResource,
    'search'
);

$acl->addResource(
    $customersResource,
    [
        'create',
        'update',
    ]
);
```

<a name='access-controls'></a>

## Определение контроля доступа

Теперь у нас есть роли и ресурсы. Настало время указать для ACL, какие роли имеют разрешения доступа к ресурсам. Этот этап очень важен, особенно принимая во внимание используемый по умолчанию уровень `allow` или `deny`.

```php
<?php

// Указываем уровень доступа для ролей на определенный ресурс

$acl->allow('Guests', 'Customers', 'search');

$acl->allow('Guests', 'Customers', 'create');

$acl->deny('Guests', 'Customers', 'update');
```

The `allow()` method designates that a particular role has granted access to a particular resource. The `deny()` method does the opposite.

<a name='querying'></a>

## Запросы к ACL

Once the list has been completely defined. We can query it to check if a role has a given permission or not.

```php
<?php

// Проверяем, имеет ли роль доступ к операциям

// Вернёт 0
$acl->isAllowed('Guests', 'Customers', 'edit');

// Вернёт 1
$acl->isAllowed('Guests', 'Customers', 'search');

// Вернёт 1
$acl->isAllowed('Guests', 'Customers', 'create');
```

<a name='function-based-access'></a>

## Доступ на основе функций

Также, вы можете добавить четвертым параметром, вашу собственную функцию, которая должна возвращать булево значение. Она будет вызвана каждый раз при использовании метода `isAllowed()`. Если ваша функция должна принимать значения — передайте в качестве 4-го агрумента ассоциативный массив в метод `isAllowed()`, где ключом является название параметра в пользовательской функции.

```php
<?php

// Установим уровень доступа к ресурсу для роли, используя пользовательскую функцию
$acl->allow(
    'Guests',
    'Customers',
    'search',
    function ($a) {
        return $a % 2 === 0;
    }
);

// Теперь проверим, есть ли у роли доступ к операции

// Вернёт true
$acl->isAllowed(
    'Guests',
    'Customers',
    'search',
    [
        'a' => 4,
    ]
);

// Вернёт false
$acl->isAllowed(
    'Guests',
    'Customers',
    'search',
    [
        'a' => 3,
    ]
);
```

Следует понимать, если ваша функция принимает аргументы и вы не передаёте какие-либо параметры в метод `isAllowed()`, то поведением по умолчанию является `Acl::ALLOW`. Вы можете изменить это поведение с помощью метода `setNoArgumentsDefaultAction()`.

```php
<?php

use Phalcon\Acl;

// Установим уровень доступа к ресурсу для роли, используя пользовательскую функцию
$acl->allow(
    'Guests',
    'Customers',
    'search',
    function ($a) {
        return $a % 2 === 0;
    }
);

// Теперь проверим, есть ли у роли доступ к операции

// Вернёт true
$acl->isAllowed(
    'Guests',
    'Customers',
    'search'
);

// Изменим значение по умолчанию если не переданы аргументы
$acl->setNoArgumentsDefaultAction(
    Acl::DENY
);

// Вернёт false
$acl->isAllowed(
    'Guests',
    'Customers',
    'search'
);
```

<a name='objects'></a>

## Объекты в качестве названия роли и ресурса

Вы можете использовать свои классы в качестве объектов роли или ресурса и передавать экземпляры объектов в аргументах `roleName` и `resourceName`. Your classes must implement [Phalcon\Acl\RoleAware](api/Phalcon_Acl_RoleAware) for `roleName` and [Phalcon\Acl\ResourceAware](api/Phalcon_Acl_ResourceAware) for `resourceName`.

Пример пользовательского класса `UserRole`:

```php
<?php

use Phalcon\Acl\RoleAware;

// Создадим класс, который будет использоваться как roleName
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

    // Реализуем интерфейс Phalcon\Acl\RoleAware
    public function getRoleName()
    {
        return $this->roleName;
    }
}
```

Реализуем ещё один наш класс `ModelResource`:

```php
<?php

use Phalcon\Acl\ResourceAware;

// Создадим класс, который будет использоваться в качестве как resourceName
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

    // Реализуем интерфейс Phalcon\Acl\ResourceAware
    public function getResourceName()
    {
        return $this->resourceName;
    }
}
```

Теперь мы можем использовать эти классы в методе `isAllowed()`.

```php
<?php

use UserRole;
use ModelResource;

// Задаем уровень доступа для ролей на определенный ресурс
$acl->allow('Guests', 'Customers', 'search');
$acl->allow('Guests', 'Customers', 'create');
$acl->deny('Guests', 'Customers', 'update');

// Создадим экземпляры наших классов для roleName и resourceName

$customer = new ModelResource(
    1,
    'Customers',
    2
);

$designer = new UserRole(
    1,
    'Designers'
);

$guest = new UserRole(
    2,
    'Guests'
);

$anotherGuest = new UserRole(
    3,
    'Guests'
);

// Проверяем, имеют ли наши объекты ролей доступ к разным операциям
// по отношению к ресурсу

// Вернёт false
$acl->isAllowed(
    $designer,
    $customer,
    'search'
);

// Вернёт true
$acl->isAllowed(
    $guest,
    $customer,
    'search'
);

// Вернёт true
$acl->isAllowed(
    $anotherGuest,
    $customer,
    'search'
);
```

Also you can access those objects in your custom function in `allow()` or `deny()`. They are automatically bind to parameters by type in function.

```php
<?php

use UserRole;
use ModelResource;

// Установим уровень доступа с пользовательской функцией
$acl->allow(
    'Guests',
    'Customers',
    'search',
    // Необходимые классы User и Model
    function (UserRole $user, ModelResource $model) {
        return $user->getId == $model->getUserId();
    }
);

$acl->allow(
    'Guests',
    'Customers',
    'create'
);

$acl->deny(
    'Guests',
    'Customers',
    'update'
);

// Создадим экземпляры наших классов для roleName и resourceName

$customer = new ModelResource(
    1,
    'Customers',
    2
);

$designer = new UserRole(
    1,
    'Designers'
);

$guest = new UserRole(
    2,
    'Guests'
);

$anotherGuest = new UserRole(
    3,
    'Guests'
);

// Проверяем, имеют ли наши объекты ролей доступ к разным операциям
// по отношению к ресурсу

// Вернёт false
$acl->isAllowed(
    $designer,
    $customer,
    'search'
);

// Вернёт true
$acl->isAllowed(
    $guest,
    $customer,
    'search'
);

// Вернёт false
$acl->isAllowed(
    $anotherGuest,
    $customer,
    'search'
);
```

You can still add any custom parameters to function and pass associative array in `isAllowed()` method. Also order doesn't matter.

<a name='roles-inheritance'></a>

## Наследование ролей

You can build complex role structures using the inheritance that [Phalcon\Acl\Role](api/Phalcon_Acl_Role) provides. Роли могут наследовать доступ других ролей, таким образом предоставляя доступ к надмножествам или подмножествам ресурсов. Чтобы использовать наследование ролей вам необходимо передать в качестве второго параметра другую роль при определении роли.

```php
<?php

use Phalcon\Acl\Role;

// ...

// Создаём некоторые роли

$roleAdmins = new Role('Administrators', 'Super-User role');

$roleGuests = new Role('Guests');

// Добавляем роль 'Guests' в ACL
$acl->addRole($roleGuests);

// Добавляем роль 'Administrators' наследуемую от роли 'Guests'
$acl->addRole($roleAdmins, $roleGuests);
```

### Setup relationships after adding roles

Or you may prefer to add all of your roles together and then define the inheritance relationships afterwards.

```php
<?php

use Phalcon\Acl\Role;

// Create some roles
$roleAdmins = new Role('Administrators', 'Super-User role');
$roleGuests = new Role('Guests');

// Add Roles to ACL
$acl->addRole($roleGuests);
$acl->addRole($roleAdmins);

// Have 'Administrators' role inherit from 'Guests' its accesses
$acl->addInherit($roleAdmins, $roleGuests);
```

<a name='serialization'></a>

## Сериализация ACL списков

To improve performance [Phalcon\Acl](api/Phalcon_Acl) instances can be serialized and stored in APC, session, text files or a database table so that they can be loaded at will without having to redefine the whole list. Вы можете сделать это следующим образом:

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;

// ...

// Проверяем, существуют ли ACL данные
if (!is_file('app/security/acl.data')) {
    $acl = new AclList();

    // ... Определяем роли, ресурсы, доступ и т.д.

    // Сохраняем сериализованный объект в файл
    file_put_contents(
        'app/security/acl.data',
        serialize($acl)
    );
} else {
    // Восстанавливаем ACL объект из текстового файла
    $acl = unserialize(
        file_get_contents('app/security/acl.data')
    );
}

// Используем ACL
if ($acl->isAllowed('Guests', 'Customers', 'edit')) {
    echo 'Доступ разрешен!';
} else {
    echo 'Доступ запрещен :(';
}
```

Рекомендуется использовать адаптер Memory в процессе разработки, но использовать любой другой адаптер в процессе эксплуатации вашего приложения.

<a name='events'></a>

## События

[Phalcon\Acl](api/Phalcon_Acl) is able to send events to an `EventsManager` if it's present. События срабатывают используя тип 'acl'. Некоторые события могут возвращать false, чтобы прервать текущую операцию. Поддерживаются следующие типы событий:

| Название события  | Срабатывает                                      | Можно остановить операцию? |
| ----------------- | ------------------------------------------------ |:--------------------------:|
| beforeCheckAccess | Срабатывает перед проверкой доступа роли/ресурса |             Да             |
| afterCheckAccess  | Срабатывает после проверки доступа роли/ресурса  |            Нет             |

В следующем примере показано, как назначить слушателей к компоненту:

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

// ...

// Создаем менеджер событий
$eventsManager = new EventsManager();

// Назначаем слушателя к типу 'acl'
$eventsManager->attach(
    'acl:beforeCheckAccess',
    function (Event $event, $acl) {
        echo $acl->getActiveRole();

        echo $acl->getActiveResource();

        echo $acl->getActiveAccess();
    }
);

$acl = new AclList();

// Настраиваем $acl
// ...

// Присваиваем менеджер событий компоненту ACL
$acl->setEventsManager($eventsManager);
```

<a name='custom-adapters'></a>

## Реализация собственных адаптеров

The [Phalcon\Acl\AdapterInterface](api/Phalcon_Acl_AdapterInterface) interface must be implemented in order to create your own ACL adapters or extend the existing ones.