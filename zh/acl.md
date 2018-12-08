<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">访问控制列表 (ACL)</a>
      <ul>
        <li>
          <a href="#setup">创建 ACL</a>
        </li>
        <li>
          <a href="#adding-roles">将角色添加到 ACL</a>
        </li>
        <li>
          <a href="#adding-resources">添加资源</a>
        </li>
        <li>
          <a href="#access-controls">定义访问控制</a>
        </li>
        <li>
          <a href="#querying">查询ACL</a>
        </li>
        <li>
          <a href="#function-based-access">基于访问控制的自定义函数</a>
        </li>
        <li>
          <a href="#objects">对象作为角色名称和资源名称</a>
        </li>
        <li>
          <a href="#roles-inheritance">角色继承</a>
        </li>
        <li>
          <a href="#serialization">序列化 ACL 列表</a>
        </li>
        <li>
          <a href="#events">事件</a>
        </li>
        <li>
          <a href="#custom-adapters">实现自己的适配器</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# 访问控制列表 (ACL)

`Phalcon\Acl` 提供了简单、 轻量级的 Acl，以及附属于他们的权限管理。 [访问控制列表](http://en.wikipedia.org/wiki/Access_control_list)(ACL) 允许应用程序对其领域与基础对象的访问请求进行控制。 我们鼓励您阅读更多关于 ACL 的方法，以更熟悉它的概念。

总之，Acl 有角色和资源。 资源是通过ACLs定义的权限对象。 角色是通过ACL机制确定访问资源的请求是否被拒绝或允许的对象。

<a name='setup'></a>

## 创建 ACL

此组件最初被设计工作在内存中。 这提供了易用性和快速的访问列表中的每个方面。 `Phalcon\Acl` 构造函数作为适配器的第一个参数用于检索控制列表中信息。 下面是使用内存适配器示例︰

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;

$acl = new AclList();
```

默认情况下 `Phalcon\Acl` 允许访问尚未定义的资源。 为了提高访问列表中的安全级别，我们可以定义 `deny` 级别，作为默认访问级别。

```php
<?php

use Phalcon\Acl;

// Default action is deny access
$acl->setDefaultAction(
    Acl::DENY
);
```

<a name='adding-roles'></a>

## 将角色添加到 ACL

角色是能或不能访问控制列表里面的某些资源的对象。 举例说明，我们将定义一个公司一组人员的的角色。 `Phalcon\Acl\Role` 类是可用于创建角色更结构化的方式。 让我们添加一些角色到我们最近创建的列表︰

```php
<?php

use Phalcon\Acl\Role;

// 创建一些角色.
// 第一个参数是名称，第二个参数是可选的说明。
$roleAdmins = new Role('Administrators', 'Super-User role');
$roleGuests = new Role('Guests');

// Add 'Guests' role to ACL
$acl->addRole($roleGuests);

// Add 'Designers' role to ACL without a Phalcon\Acl\Role
$acl->addRole('Designers');
```

正如你所看到的不使用实例的情况下直接定义角色。

<a name='adding-resources'></a>

## 添加资源

资源是的对象的访问控制。 通常在 MVC 应用程序中的资源引用到控制器。 虽然这不是强制性的 `Phalcon\Acl\Resource` 类可以用于定义资源。 它是重要的是将相关的操作添加到资源以便 ACL 可以理解它应控制。

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

## 定义访问控制

现在我们有角色和资源，是时候定义ACL（即哪些角色可以访问哪些资源）。 这部分是很重要，尤其考虑到您的默认访问级别 `allow` 或 `deny`。

```php
<?php

// Set access level for roles into resources

$acl->allow('Guests', 'Customers', 'search');

$acl->allow('Guests', 'Customers', 'create');

$acl->deny('Guests', 'Customers', 'update');
```

`allow()`方法指定特定角色已授予对特定资源的访问权。 `deny()`方法的作用正好相反。

<a name='querying'></a>

## 查询的 ACL

一旦列表被完全定义。 我们可以查询它来检查角色是否具有给定的权限。

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

## 基于访问控制的自定义函数

此外可以添加 4 参数作为您自定义的函数必须返回布尔值。 当您使用 `isAllowed()` 方法时，它将被调用。 您可以将参数作为关联数组传递给` isAllowed（）</ 0>方法作为第4个参数，其中key是我们定义的函数中的参数名称。</p>

<pre><code class="php"><?php
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
`</pre> 

此外，如果您未在` isAllowed()</ 0>方法中提供任何参数，则默认行为将为<code> Acl::ALLOW </ 0>。 您可以更改它的使用方法 <code>setNoArgumentsDefaultAction()`。

```php
<?php

use Phalcon\Acl;

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

## 对象作为角色名称和资源名称

您可以将对象作为 `角色名` 和 `资源名称` 传递。 您的类必须实现 `Phalcon\Acl\RoleAware` `roleName` 和 `Phalcon\Acl\ResourceAware`，为 `资源名称`。

我们的 `UserRole` 类

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

和我们的 `ModelResource` 类

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

然后你可以在 `isAllowed()` 方法中使用它们。

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

您还可以在`allow()`或`deny()`的自定义函数中访问这些对象。 它们根据函数类型自动绑定到参数。

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

您仍然可以向函数中添加任何自定义参数，并在`isAllowed()`方法中传递关联数组。 而且顺序也不重要。

<a name='roles-inheritance'></a>

## 角色继承

您可以使用 `Phalcon\Acl\Role` 提供的继承，构建复杂的角色结构。 角色可以继承其他角色，从而允许用户访问超集或资源的子集。 有两种使用角色继承的方法:

### Setup relationships as roles are added.

在将继承的角色添加到列表中时，可以将其作为方法调用的第二个参数传递。

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

## 序列化 ACL 列表

若要提高性能 `Phalcon\Acl` 实例，可以序列化并存储在 APC、 会话、 文本文件或数据库表，以便他们加载时无需重新定义整个列表。 你能这样做，如下所示︰

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

它被建议在开发期间使用内存适配器，并在生产中使用其他适配器之一。

<a name='events'></a>

## 事件

`Phalcon\Acl` 是能够将事件发送到 `EventsManager`，如果它是存在的。 事件被触发，使用类型 'acl'。 一些事件可以停止操作，当返回布尔值 false 时。 以下事件被支持︰

| 事件名称              | 触发器                 | 可以停止操作吗？ |
| ----------------- | ------------------- |:--------:|
| beforeCheckAccess | 检查规则/资源是否具有访问权限之前触发 |    是的    |
| afterCheckAccess  | 检查规则/资源是否具有访问权限之后触发 |    否     |

下面的示例演示如何将侦听器附加到此组件︰

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

// ...

// Create an event manager
$eventsManager = new EventsManager();

// Attach a listener for type 'acl'
$eventsManager->attach(
    'acl:beforeCheckAccess',
    function (Event $event, $acl) {
        echo $acl->getActiveRole();

        echo $acl->getActiveResource();

        echo $acl->getActiveAccess();
    }
);

$acl = new AclList();

// Setup the $acl
// ...

// Bind the eventsManager to the ACL component
$acl->setEventsManager($eventsManager);
```

<a name='custom-adapters'></a>

## 实现自己的适配器

当创建您自己的 ACL 适配器或扩展已经存在的ACL时，必须实现 `Phalcon\Acl\AdapterInterface` 接口。