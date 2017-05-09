<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Контроль доступа</a> <ul>
        <li>
          <a href="#setup">Создание списков ACL</a>
        </li>
        <li>
          <a href="#adding-roles">Добавление ролей к ACL</a>
        </li>
        <li>
          <a href="#adding-resources">Добавление ресурсов</a>
        </li>
        <li>
          <a href="#access-controls">Определение контроля доступа</a>
        </li>
        <li>
          <a href="#querying">Запросы к ACL</a>
        </li>
        <li>
          <a href="#function-based-access">Доступ на основе пользовательских функций</a>
        </li>
        <li>
          <a href="#objects">Пользовательские классы ролей/ресурсов</a>
        </li>
        <li>
          <a href="#roles-inheritance">Наследование ролей</a>
        </li>
        <li>
          <a href="#serialization">Сериализация ACL списков</a>
        </li>
        <li>
          <a href="#events">События</a>
        </li>
        <li>
          <a href="#custom-adapters">Реализация собственных адаптеров</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Списки управления доступом (ACL)

`Phalcon\Acl` предоставляет простое и легкое управление списками контроля доступа, а также разрешениями, назначаемыми этим спискам. [Списки управления доступом](http://en.wikipedia.org/wiki/Access_control_list) (ACL) позволяют приложению управлять доступом к различным своим частям и запрошенным объектам. Рекомендуется ознакомится с ACL подробнее, чтобы понимать принцип работы и основные понятия.

В целом, ACL основано на таких понятиях как роли и ресурсы. Ресурсами являются объекты, на которые накладываются определенные разрешения с помощью ACL. Роли — это объекты, которые запрашивают доступ к ресурсам, который может быть разрешен или запрещен ACL механизмом.

<a name='setup'></a>

## Создание списков ACL

Этот компонент изначально сделан так, чтобы работать непосредственно в памяти. Это предоставляет простое использование и скорость в обращении к любому аспекту ACL. Конструктор `Phalcon\Acl` принимает в качестве первого параметра адаптер, который будет использоваться для получения информации связанной с списком доступа. Ниже приведен пример использования адаптера работающего в памяти:

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;

$acl = new AclList();
```

По умолчанию `Phalcon\Acl` разрешает доступ к действию над ресурсом, которое еще не было определенно в ACL. Для повышения уровня безопасности списка доступа к мы можем определить уровень `deny` как уровень доступа по умолчанию.

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

Ролью является объект, который имеет или не имеет доступа к определенному ресурсу в списке доступа. Для примера, мы определим роли людей в организации. Класс `Phalcon\Acl\Role` позволяет создать роли в более структурированной форме. Давайте добавим несколько ролей в наш недавно созданный список:

```php
<?php

use Phalcon\Acl\Role;

// Создаем роли.
// Первый параметр это название роли, второй параметр необязателен - это описание роли.
$roleAdmins = new Role('Administrators', 'Super-User role');
$roleGuests = new Role('Guests');

// Добавляем "Guests" в список ACL
$acl->addRole($roleGuests);

// Добавляем "Designers" без класса Phalcon\Acl\Role
$acl->addRole('Designers');
```

As you can see, roles are defined directly without using an instance.

<a name='adding-resources'></a>

## Добавление ресурсов

Resources are objects where access is controlled. Normally in MVC applications resources refer to controllers. Although this is not mandatory, the `Phalcon\Acl\Resource` class can be used in defining resources. It's important to add related actions or operations to a resource so that the ACL can understand what it should to control.

```php
<?php

use Phalcon\Acl\Resource;

// Define the 'Customers' resource
$customersResource = new Resource('Customers');

// Add 'customers' resource with a couple of operations

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

Now that we have roles and resources, it's time to define the ACL (i.e. which roles can access which resources). This part is very important especially taking into consideration your default access level `allow` or `deny`.

```php
<?php

// Set access level for roles into resources

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

// Check whether role has access to the operations

// Returns 0
$acl->isAllowed('Guests', 'Customers', 'edit');

// Returns 1
$acl->isAllowed('Guests', 'Customers', 'search');

// Returns 1
$acl->isAllowed('Guests', 'Customers', 'create');
```

<a name='function-based-access'></a>

## Доступ на основе пользовательских функций

Also you can add as 4th parameter your custom function which must return boolean value. It will be called when you use `isAllowed()` method. You can pass parameters as associative array to `isAllowed()` method as 4th argument where key is parameter name in our defined function.

```php
<?php
// Set access level for role into resources with custom function
$acl->allow(
    'Guests',
    'Customers',
    'search',
    function ($a) {
        return $a % 2 === 0;
    }
);

// Check whether role has access to the operation with custom function

// Returns true
$acl->isAllowed(
    'Guests',
    'Customers',
    'search',
    [
        'a' => 4,
    ]
);

// Returns false
$acl->isAllowed(
    'Guests',
    'Customers',
    'search',
    [
        'a' => 3,
    ]
);
```

Also if you don't provide any parameters in `isAllowed()` method then default behaviour will be `Acl::ALLOW`. You can change it by using method `setNoArgumentsDefaultAction()`.

```php
use Phalcon\Acl;

<?php
// Set access level for role into resources with custom function
$acl->allow(
    'Guests',
    'Customers',
    'search',
    function ($a) {
        return $a % 2 === 0;
    }
);

// Check whether role has access to the operation with custom function

// Returns true
$acl->isAllowed(
    'Guests',
    'Customers',
    'search'
);

// Change no arguments default action
$acl->setNoArgumentsDefaultAction(
    Acl::DENY
);

// Returns false
$acl->isAllowed(
    'Guests',
    'Customers',
    'search'
);
```

<a name='objects'></a>

## Пользовательские классы ролей/ресурсов

You can pass objects as `roleName` and `resourceName`. Your classes must implement `Phalcon\Acl\RoleAware` for `roleName` and `Phalcon\Acl\ResourceAware` for `resourceName`.

Our `UserRole` class

```php
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
```

And our `ModelResource` class

```php
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
```

Then you can use them in `isAllowed()` method.

```php
<?php

use UserRole;
use ModelResource;

// Set access level for role into resources
$acl->allow('Guests', 'Customers', 'search');
$acl->allow('Guests', 'Customers', 'create');
$acl->deny('Guests', 'Customers', 'update');

// Create our objects providing roleName and resourceName

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

// Check whether our user objects have access to the operation on model object

// Returns false
$acl->isAllowed(
    $designer,
    $customer,
    'search'
);

// Returns true
$acl->isAllowed(
    $guest,
    $customer,
    'search'
);

// Returns true
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

// Set access level for role into resources with custom function
$acl->allow(
    'Guests',
    'Customers',
    'search',
    function (UserRole $user, ModelResource $model) { // User and Model classes are necessary
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

// Create our objects providing roleName and resourceName

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

// Check whether our user objects have access to the operation on model object

// Returns false
$acl->isAllowed(
    $designer,
    $customer,
    'search'
);

// Returns true
$acl->isAllowed(
    $guest,
    $customer,
    'search'
);

// Returns false
$acl->isAllowed(
    $anotherGuest,
    $customer,
    'search'
);
```

You can still add any custom parameters to function and pass associative array in `isAllowed()` method. Also order doesn't matter.

<a name='roles-inheritance'></a>

## Наследование ролей

You can build complex role structures using the inheritance that `Phalcon\Acl\Role` provides. Roles can inherit from other roles, thus allowing access to supersets or subsets of resources. To use role inheritance, you need to pass the inherited role as the second parameter of the method call, when adding that role in the list.

```php
<?php

use Phalcon\Acl\Role;

// ...

// Create some roles

$roleAdmins = new Role('Administrators', 'Super-User role');

$roleGuests = new Role('Guests');

// Add 'Guests' role to ACL
$acl->addRole($roleGuests);

// Add 'Administrators' role inheriting from 'Guests' its accesses
$acl->addRole($roleAdmins, $roleGuests);
```

<a name='serialization'></a>

## Сериализация ACL списков

To improve performance `Phalcon\Acl` instances can be serialized and stored in APC, session, text files or a database table so that they can be loaded at will without having to redefine the whole list. You can do that as follows:

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;

// ...

// Check whether ACL data already exist
if (!is_file('app/security/acl.data')) {
    $acl = new AclList();

    // ... Define roles, resources, access, etc

    // Store serialized list into plain file
    file_put_contents(
        'app/security/acl.data',
        serialize($acl)
    );
} else {
    // Restore ACL object from serialized file
    $acl = unserialize(
        file_get_contents('app/security/acl.data')
    );
}

// Use ACL list as needed
if ($acl->isAllowed('Guests', 'Customers', 'edit')) {
    echo 'Access granted!';
} else {
    echo 'Access denied :(';
}
```

It's recommended to use the Memory adapter during development and use one of the other adapters in production.

<a name='setup'></a>

0## События

`Phalcon\Acl` может отправлять события в `EventsManager` если он существует. События срабатывают используя тип 'acl'. Некоторые события могут возвращать false, чтобы прервать текущую операцию. Поддерживаются следующие типы событий:

| Название события  | Triggered                                        | Can stop operation? |
| ----------------- | ------------------------------------------------ |:-------------------:|
| beforeCheckAccess | Срабатывает перед проверкой доступа роли/ресурса |         Да          |
| afterCheckAccess  | Срабатывает после проверки доступа роли/ресурса  |         Нет         |

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

<a name='setup'></a>

1## Реализация собственных адаптеров

Для создания своего адаптера необходимо реализовать интерфейс `Phalcon\Acl\AdapterInterface`, или использовать наследование от существующего адаптера.