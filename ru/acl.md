<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Контроль доступа</a> <ul>
        <li>
          <a href="#setup">Создание списков контроля доступа</a>
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

## Создание списков контроля доступа

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

// Добавляем 'Guests' в список ACL
$acl->addRole($roleGuests);

// Добавляем 'Designers' без класса Phalcon\Acl\Role
$acl->addRole('Designers');
```

Как вы можете видеть, роли могут определяются непосредственно, без использования экземпляра класса.

<a name='adding-resources'></a>

## Добавление ресурсов

Ресурсами являются объекты, доступ к которым контролируется. Обычно в MVC приложениях ресурсы относятся к контроллерам. Хотя это не является обязательным, класс `Phalcon\Acl\Resource` может быть использован при определении любых ресурсов. Важно добавить связующие действия или операции над ресурсами, чтобы ACL мог понимать, что ему нужно контролировать.

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

Метод `allow()` определяет, что данная роль имеет доступ к действию над ресурсом. Метод `deny()` делает обратное.

<a name='querying'></a>

## Запросы к ACL

После того, как список был полностью составлен, мы можем запрашивать проверку на права той или иной роли.

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

Вы можете использовать свои классы в качестве объектов роли или ресурса и передавать экземпляры объектов в аргументах `roleName` и `resourceName`. Ваши классы должны реализовывать интерфейс `Phalcon\Acl\RoleAware` для `roleName` и `Phalcon\Acl\ResourceAware` для `resourceName`.

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

Если вы используете пользовательскую функцию в методах `allow()` или `deny()`, то вы можете внутри функции получить доступ к этим объектам — они автоматически связываются на основе типов в определении функции.

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

Вы по-прежнему можете использовать любые параметры в определении пользовательской функции и передавать ассоциативный массив в метод `isAllowed()`, порядок ключей не имеет значения.

<a name='roles-inheritance'></a>

## Наследование ролей

Вы можете строить сложные структуры ролей используя наследование, которое предоставляет класс `Phalcon\Acl\Role`. Роли могут наследовать доступ других ролей, таким образом предоставляя доступ к надмножествам или подмножествам ресурсов. There are two ways to use role inheritance:

1. You can pass the inherited role as the second parameter of the method call, when adding that role in the list.

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

1. You can setup the relationships after roles are added

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
$acl->addInherit($rollAdmins, $roleGuests);
```

<a name='serialization'></a>

## Сериализация ACL списков

Чтобы увеличить производительность, объект `Phalcon\Acl` можно сериализовать для хранения в APC, сессии, текстовых файлах или в базе данных. Таким образом, список доступа возможно повторно использовать, без необходимости переобъявлять его каждый раз. Вы можете сделать это следующим образом:

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

`Phalcon\Acl` может отправлять события в `EventsManager` если он существует. События срабатывают используя тип 'acl'. Некоторые события могут возвращать false, чтобы прервать текущую операцию. Поддерживаются следующие типы событий:

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

Для создания своего адаптера необходимо реализовать интерфейс `Phalcon\Acl\AdapterInterface`, или использовать наследование от существующего адаптера.