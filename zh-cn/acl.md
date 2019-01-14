* * *

layout: default language: 'en' version: '4.0'

* * *

<a name='overview'></a>

# 访问控制列表 (ACL)

[Phalcon\Acl](api/Phalcon_Acl) provides an easy and lightweight management of ACLs as well as the permissions attached to them. [Access Control Lists](https://en.wikipedia.org/wiki/Access_control_list) (ACL) allow an application to control access to its areas and the underlying objects from requests.
[Phalcon\Acl](api/Phalcon_Acl) provides an easy and lightweight management of ACLs as well as the permissions attached to them. [访问控制列表](http://en.wikipedia.org/wiki/Access_control_list)(ACL) 允许应用程序对其领域与基础对象的访问请求进行控制。 我们鼓励您阅读更多关于 ACL 的方法，以更熟悉它的概念。
In short, ACLs have two objects: The object that needs access, and the object that we need access to. In the programming world, these are usually referred to as Roles and Resources. In the Phalcon world, we use the terminology [Operation](api/Phalcon_Acl_Operation) and [Subject](api/Phalcon_Acl_Subject).

<div class="alert alert-info">
  <p>
    <strong>Use Case</strong>
  </p>
  
  <p>
    An accounting application needs to have different groups of users have access to various areas of the application.
  </p>
  
  <p>
    <strong>Operation</strong> * Administrator Access * Accounting Department Access * Manager Access * Guest Access
  </p>
  
  <p>
    <strong>Subject</strong> * Login page * Admin page * Invoices page * Reports page
  </p>
</div>
总之，Acl 有角色和资源。 资源是通过ACLs定义的权限对象。 角色是通过ACL机制确定访问资源的请求是否被拒绝或允许的对象。
As seen above in the use case, an [Operation](api/Phalcon_Acl_Operation) is defined as who needs to access a particular [Subject](api/Phalcon_Acl_Subject) i.e. an area of the application. A [Subject](api/Phalcon_Acl_Subject) is defined as the area of the application that needs to be accessed.

Using the [Phalcon\Acl](api/Phalcon_Acl) component, we can tie those two together, and strengthen the security of our application, allowing only specific operations to be bound to specific subjects.

<a name='setup'></a>

## 创建 ACL

[Phalcon\Acl](api/Phalcon_Acl) uses adapters to store and work with operations and subjects. The only adapter available right now is [Phalcon\Acl\Adapter\Memory](api/Phalcon_Acl_Adapter_Memory). Having the adapter use the memory, significantly increases the speed that the ACL is accessed but also comes with drawbacks. The main drawback is that memory is not persistent, so the developer will need to implement a storing strategy for the ACL data, so that the ACL is not generated at every request. This could easily lead to delays and unnecessary processing, especially if the ACL is quite big and/or stored in a database or file system.
此组件最初被设计工作在内存中。 这提供了易用性和快速的访问列表中的每个方面。 The [Phalcon\Acl](api/Phalcon_Acl) constructor takes as its first parameter an adapter used to retrieve the information related to the control list. 下面是使用内存适配器示例︰
Phalcon also offers an easy way for developers to build their own adapters by implementing the [Phalcon\Acl\AdapterInterface](api/Phalcon_Acl_AdapterInterface) interface.

### In action

The [Phalcon\Acl](api/Phalcon_Acl) constructor takes as its first parameter an adapter used to retrieve the information related to the control list.

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;

$acl = new AclList();
```

There are two self explanatory actions that the [Phalcon\Acl](api/Phalcon_Acl) provides: - `Phalcon\Acl::ALLOW` - `Phalcon\Acl::DENY`
By default [Phalcon\Acl](api/Phalcon_Acl) allows access to action on resources that have not yet been defined. 为了提高访问列表中的安全级别，我们可以定义 `deny` 级别，作为默认访问级别。
The default action is **`Phalcon\Acl::DENY`** for any [Operation](api/Phalcon_Acl_Operation) or [Subject](api/Phalcon_Acl_Subject). This is on purpose to ensure that only the developer or application allows access to specific subjects and not the ACL component itself.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;

$acl = new AclList();

// Default action is deny access

// Change it to allow
$acl->setDefaultAction(
    Acl::DENY
);
```

<a name='adding-roles'></a>

## Adding Operations
## 将角色添加到 ACL
As mentioned above, a [Phalcon\Acl\Operation](api/Phalcon_Acl_Operation) is an object that can or cannot access a set of [Subject](api/Phalcon_Acl_Subject) in the access list.

There are two ways of adding operations to our list. * by using a [Phalcon\Acl\Operation](api/Phalcon_Acl_Operation) object or * using a string, representing the name of the operation
角色是能或不能访问控制列表里面的某些资源的对象。 举例说明，我们将定义一个公司一组人员的的角色。 The [Phalcon\Acl\Role](api/Phalcon_Acl_Role) class is available to create roles in a more structured way. 让我们添加一些角色到我们最近创建的列表︰
To see this in action, using the example outlined above, we will add the relevant [Phalcon\Acl\Operation](api/Phalcon_Acl_Operation) objects in our list:

```php
<?php

use Phalcon\Acl\Role;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Operation;

$acl = new AclList();
// 创建一些角色.
/**
 * Create some Operations.
 * 
 * The first parameter is the name of the operation, 
 * the second is an optional description
 */
// 第一个参数是名称，第二个参数是可选的说明。
$roleAdmins = new Role('Administrators', 'Super-User role');
$operationAccounting = new Operation('accounting', 'Accounting Department Access'); 
$roleGuests = new Role('Guests');

// Add 'Guests' role to ACL
 */
$acl->addRole($roleGuests);

// Add 'Designers' role to ACL without a Phalcon\Acl\Role
/**
 * Add operations without creating an object first 
 */
$acl->addOperation('manager');
$acl->addRole('Designers');
```

<a name='adding-subjects'></a>
正如你所看到的不使用实例的情况下直接定义角色。

<a name='adding-resources'></a>

## 添加资源

资源是的对象的访问控制。 通常在 MVC 应用程序中的资源引用到控制器。 Although this is not mandatory, the [Phalcon\Acl\Resource](api/Phalcon_Acl_Resource) class can be used in defining resources. 它是重要的是将相关的操作添加到资源以便 ACL 可以理解它应控制。
Similar to the `addOperation`, `addSubject` requires a name for the subject and an optional description.

```php
<?php

use Phalcon\Acl\Resource;

use Phalcon\Acl\Subject;
// Define the 'Customers' resource
$acl = new AclList();
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
$acl->addResource($reports, ['list', 'add']);
        'update',
    ]
 * Add subjects without creating an object first 
);
$acl->addResource('admin', ['dashboard', 'users']);
$acl->addResource('reports', ['list', 'add']);
```

<a name='access-controls'></a>

## 定义访问控制

After both the `Operations` and `Subjects` have been defined, we need to tie them together so that the access list can be created. This is the most important step in the operation since a small mistake here can provide access for subjects to operations that the developer does not intend to. As mentioned earlier, the default access action for [Phalcon\Acl](api/Phalcon_Acl) is `Acl::DENY`, following the [whitelist](https://en.wikipedia.org/wiki/Whitelisting) approach.
现在我们有角色和资源，是时候定义ACL（即哪些角色可以访问哪些资源）。 这部分是很重要，尤其考虑到您的默认访问级别 `allow` 或 `deny`。
To tie `Operations` and `Subjects` together we use the `allow()` and `deny()` methods that the [Phalcon\Acl\Memory](api/Phalcon_Acl_Memory) exposes.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Operation;
use Phalcon\Acl\Subject;
// Set access level for roles into resources
$acl = new AclList();

/**
 * Add the operations
 */
$acl->addOperation('manager');
$acl->addOperation('accounting');
$acl->addOperation('guest');


/**
 * Add the Subjects
 */
$acl->addResource('admin', ['dashboard', 'users', 'view']);
$acl->addResource('reports', ['list', 'add', 'view']);
$acl->addResource('session', ['login', 'logout']);

/**
 * Now tie them all together 
 */
$acl->allow('Guests', 'Customers', 'search');
$acl->allow('manager', 'reports', ['list', 'add']);
$acl->allow('*', 'session', '*');
$acl->allow('*', '*', 'view');

$acl->deny('guest', '*', 'view');
```

What the above lines tell us:

```php
$acl->allow('Guests', 'Customers', 'create');
```

For the `manager` operation, allow access to the `admin` subject and `users` action. To bring this into perspective with a MVC application, the above line says that the group `manager` is allowed to access the `admin` controller and `users` action.

```php
$acl->allow('manager', 'reports', ['list', 'add']);
```

You can also pass an array as the `action` parameter when invoking the `allow()` command. The above means that for the `manager` operation, allow access to the `reports` subject and `list` and `add` actions. Again to bring this into perspective with a MVC application, the above line says that the group `manager` is allowed to access the `reports` controller and `list` and `add` actions.

```php
$acl->allow('*', 'session', '*');
```

Wildcards can also be used to do mass matching for operations, subjects or actions. In the above example, we allow every operation to access every action in the `session` subject. This command will give access to the `manager`, `accounting` and `guest` operations, access to the `session` subject and to the `login` and `logout` actions.

```php
$acl->allow('*', '*', 'view');
```

Similarly the above gives access to any operation, any subject that has the `view` action. In a MVC application, the above is the equivalent of allowing any group to access any controller that exposes a `viewAction`.

<div class="alert alert-danger">
  <p>
    Please be <strong>VERY</strong> careful when using the <code>*</code> wildcard. It is very easy for a mistake to happen and the wildcard, although it seems convenient for certain instances, allowing users to access areas of your application that they are not supposed to. The best way to be 100% sure is to write tests specifically to test the permissions and the ACL. These can be done in the <code>unit</code> test suite by instantiating the component and then checking the <code>isAllowed()</code> if it is <code>true</code> or <code>false</code>.
  </p>
  
  <p>
    <a href="https://codeception.com">Codeception</a> is the chosen testing framework for Phalcon and there are plenty of tests in our github repository (<code>tests</code> folder) to offer guidance and ideas.
  </p>
</div>

```php
$acl->deny('Guests', 'Customers', 'update');
```

For the `guest` operation, we deny access to all subjects with the `view` action. Despite the fact that the default access level is `Acl::DENY` in our example above, we specifically allowed the `view` action to all operations and subjects. This includes the `guest` operation. We want to allow the `guest` operation access only to the `session` subject and the `login` and `logout` actions, since `guests` are not logged into our application.
`Allow()` 方法选定一个特定的角色已授予对特定资源的访问。`Deny()` 方法则相反。
```php
$acl->allow('*', '*', 'view');
```

This gives access to the `view` access to everyone, but we want the `guest` operation to be excluded from that so the following line does what we need.

```php
$acl->deny('guest', '*', 'view');
```

<a name='querying'></a>

## 查询ACL

一旦完全定义列表。我们可以查询它来检查是否角色具有给定的权限或不。

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Operation;
use Phalcon\Acl\Subject;
// Check whether role has access to the operations
$acl = new AclList();

/**
 * Setup the ACL
 */
$acl->addOperation('manager');                   
$acl->addOperation('accounting');                   
$acl->addOperation('guest');                       
// Returns 0

$acl->addResource('admin', ['dashboard', 'users', 'view']);
$acl->addResource('reports', ['list', 'add', 'view']);
$acl->isAllowed('Guests', 'Customers', 'edit');

$acl->allow('manager', 'admin', 'users');
$acl->allow('manager', 'reports', ['list', 'add']);
$acl->allow('*', 'session', '*');
$acl->allow('*', '*', 'view');
// Returns 1
$acl->deny('guest', '*', 'view');

// ....


// true - defined explicitly
$acl->isAllowed('manager', 'admin', 'dashboard');

// true - defiled with wildcard
$acl->isAllowed('manager', 'session', 'login');

// true - defined with wildcard
$acl->isAllowed('Guests', 'Customers', 'search');

// false - defined explicitly
$acl->isAllowed('guest', 'reports', 'view');
// Returns 1
// false - default access level
$acl->isAllowed('Guests', 'Customers', 'create');
```

** WIP BELOW **
<a name='function-based-access'></a>

## 基于访问控制的自定义函数

Also you can add as 4th parameter your custom function which must return boolean value. It will be called when you use `isAllowed()` method. You can pass parameters as associative array to `isAllowed()` method as 4th argument where key is parameter name in our defined function.
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
```
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

您可以将对象作为 `角色名` 和 `资源名称` 传递。 Your classes must implement [Phalcon\Acl\RoleAware](api/Phalcon_Acl_RoleAware) for `roleName` and [Phalcon\Acl\ResourceAware](api/Phalcon_Acl_ResourceAware) for `resourceName`.

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

## 角色继承

You can build complex role structures using the inheritance that [Phalcon\Acl\Role](api/Phalcon_Acl_Role) provides. 角色可以继承其他角色，从而允许用户访问超集或资源的子集。 To use role inheritance, you need to pass the inherited role as the second parameter of the method call, when adding that role in the list.

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

To improve performance [Phalcon\Acl](api/Phalcon_Acl) instances can be serialized and stored in APC, session, text files or a database table so that they can be loaded at will without having to redefine the whole list. 你能这样做，如下所示︰

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

[Phalcon\Acl](api/Phalcon_Acl) is able to send events to an `EventsManager` if it's present. 事件被触发，使用类型 'acl'。 一些事件可以停止操作，当返回布尔值 false 时。 以下事件被支持︰

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

The [Phalcon\Acl\AdapterInterface](api/Phalcon_Acl_AdapterInterface) interface must be implemented in order to create your own ACL adapters or extend the existing ones.