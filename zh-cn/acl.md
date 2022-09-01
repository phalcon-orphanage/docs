---
layout: default
language: 'zh-cn'
version: '5.0'
upgrade: '#acl'
title: '访问控制列表 (ACL)'
keywords: 'acl, access control list, permissions'
---

# 访问控制列表 (ACL)
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview
[Phalcon\Acl][acl-acl] provides an easy and lightweight management of ACLs as well as the permissions attached to them. [Access Control Lists][acl] (ACL) allow an application to control access to its areas and the underlying objects from requests.

In short, ACLs have two objects: The object that needs access, and the object that we need access to. In the programming world, these are usually referred to as Roles and Resources. In the Phalcon world, we use the terminology [Role][acl-role] and [Component][acl-component].

> **Use Case**
> 
> An accounting application needs to have different groups of users have access to various areas of the application.
> 
> **Role** - Administrator Access - Accounting Department Access - Manager Access - Guest Access
> 
> **Component** - Login page - Admin page - Invoices page - Reports page 
> 
> {: .alert .alert-info }

As seen above in the use case, a [Role][acl-role] is defined as who needs to access a particular [Component][acl-component] i.e. an area of the application. A [Component][acl-component] is defined as the area of the application that needs to be accessed.

Using the [Phalcon\Acl][acl-acl] component, we can tie those two together, and strengthen the security of our application, allowing only specific roles to be bound to specific components.

## Activation
[Phalcon\Acl][acl-acl] uses adapters to store and work with roles and components. The only adapter available right now is [Phalcon\Acl\Adapter\Memory][acl-adapter-memory]. Having the adapter use the memory, significantly increases the speed that the ACL is accessed but also comes with drawbacks. The main drawback is that memory is not persistent, so the developer will need to implement a storing strategy for the ACL data, so that the ACL is not generated at every request. This could easily lead to delays and unnecessary processing, especially if the ACL is quite big and/or stored in a database or file system.

The [Phalcon\Acl][acl-acl] constructor takes as its first parameter an adapter used to retrieve the information related to the control list.

```php
<?php

use Phalcon\Acl\Adapter\Memory;

$acl = new Memory();
```
The default action is **`Phalcon\Acl\Enum::DENY`** for any [Role][acl-role] or [Component][acl-component]. This is on purpose to ensure that only the developer or application allows access to specific components and not the ACL component itself.

```php
<?php

use Phalcon\Acl\Enum;
use Phalcon\Acl\Adapter\Memory;

$acl = new Memory();

$acl->setDefaultAction(Enum::ALLOW);
```

## 常量
The [Phalcon\Acl\Enum][acl-enum] class offers two constants that can be used when defining access levels.

- `Phalcon\Acl\Enum::ALLOW` (`1`)
- `Phalcon\Acl\Enum::DENY` (`0` - default)

You can use these constants to define access levels for your ACL.

## Adding Roles
As mentioned above, a [Phalcon\Acl\Role][acl-role] is an object that can or cannot access a set of [Component][acl-component] in the access list.

There are two ways of adding roles to our list.
* by using a [Phalcon\Acl\Role][acl-role] object or
* using a string, representing the name of the role

To see this in action, using the example outlined above, we will add the relevant [Phalcon\Acl\Role][acl-role] objects in our list.

Role objects. The first parameter is the name of the role, the second the description

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;

$acl = new Memory();

$roleAdmins     = new Role('admins', 'Administrator Access');
$roleAccounting = new Role('accounting', 'Accounting Department Access'); 

$acl->addRole($roleAdmins);
$acl->addRole($roleAccounting);
```

Strings. Add the role with just the name directly to the ACL:

```php
<?php

use Phalcon\Acl\Adapter\Memory;

$acl = new Memory();

$acl->addRole('manager');
$acl->addRole('guest');
```

## Adding Components
A [Component][acl-component] is the area of the application where access is controlled. In an MVC application, this would be a Controller. Although not mandatory, the [Phalcon\Acl\Component][acl-component] class can be used to define components in the application. Also, it is important to add related actions to a component so that the ACL can understand what it should control.

There are two ways of adding components to our list.
* by using a [Phalcon\Acl\Component][acl-component] object or
* using a string, representing the name of the role

Similar to the `addRole`, `addComponent` requires a name for the component and an optional description.

Component objects. The first parameter is the name of the component, the second the description

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Component;

$acl = new Memory();

$admin   = new Component('admin', 'Administration Pages');
$reports = new Component('reports', 'Reports Pages');

$acl->addComponent(
    $admin,
    [
        'dashboard',
        'users',
    ]
);

$acl->addComponent(
    $reports,
    [
        'list',
        'add',
    ]
);
```

Strings. Add the component with just the name directly to the ACL:

```php
<?php

use Phalcon\Acl\Adapter\Memory;

$acl = new Memory();

$acl->addComponent(
    'admin',
    [
        'dashboard',
        'users',
    ]
);

$acl->addComponent(
    'reports',
    [
        'list',
        'add',
    ]
);
```

## 定义访问控制
After both the `Roles` and `Components` have been defined, we need to tie them together so that the access list can be created. This is the most important step in the role since a small mistake here can allow access to roles for components that the developer does not intend to. As mentioned earlier, the default access action for [Phalcon\Acl][acl-acl] is `Phalcon\Acl\Enum::DENY`, following the [white list][whitelist] approach.

To tie `Roles` and `Components` together we use the `allow()` and `deny()` methods exposed by the [Phalcon\Acl\Memory][acl-adapter-memory] class.

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new Memory();

$acl->addRole('manager');
$acl->addRole('accounting');
$acl->addRole('guest');


$acl->addComponent(
    'admin',
    [
        'dashboard',
        'users',
        'view',
    ]
);

$acl->addComponent(
    'reports',
    [
        'list',
        'add',
        'view',
    ]
);

$acl->addComponent(
    'session',
    [
        'login',
        'logout',
    ]
);

$acl->allow('manager', 'admin', 'users');
$acl->allow('manager', 'reports', ['list', 'add']);
$acl->allow('*', 'session', '*');
$acl->allow('*', '*', 'view');

$acl->deny('guest', '*', 'view');
```

What the above lines tell us:

```php
$acl->allow('manager', 'admin', 'users');
```

For the `manager` role, allow access to the `admin` component and `users` action. To bring this into perspective with an MVC application, the above line says that the group `manager` is allowed to access the `admin` controller and `users` action.

```php
$acl->allow('manager', 'reports', ['list', 'add']);
```

You can also pass an array as the `action` parameter when invoking the `allow()` command. The above means that for the `manager` role, allow access to the `reports` component and `list` and `add` actions. Again to bring this into perspective with an MVC application, the above line says that the group `manager` is allowed to access the `reports` controller and `list` and `add` actions.

```php
$acl->allow('*', 'session', '*');
```

Wildcards can also be used to do mass matching for roles, components or actions. In the above example, we allow every role to access every action in the `session` component. This command will give access to the `manager`, `accounting` and `guest` roles, access to the `session` component and to the `login` and `logout` actions.

```php
$acl->allow('*', '*', 'view');
```

Similarly, the above gives access to any role, any component that has the `view` action. In an MVC application, the above is the equivalent of allowing any group to access any controller that exposes a `viewAction`.

> **NOTE**: Please be **VERY** careful when using the `*` wildcard. It is very easy to make a mistake and the wildcard, although it seems convenient, it may allow users to access areas of your application that they are not supposed to. The best way to be 100% sure is to write tests specifically to test the permissions and the ACL. These can be done in the `unit` test suite by instantiating the component and then checking the `isAllowed()` if it is `true` or `false`.
> 
> [Codeception][codeception] is the chosen testing framework for Phalcon and there are plenty of tests in our GitHub repository (`tests` folder) to offer guidance and ideas. 
> 
> {:.alert .alert-danger}

```php
$acl->deny('guest', '*', 'view');
```

For the `guest` role, we deny access to all components with the `view` action. Despite the fact that the default access level is `Acl\Enum::DENY` in our example above, we specifically allowed the `view` action to all roles and components. This includes the `guest` role. We want to allow the `guest` role access only to the `session` component and the `login` and `logout` actions, since `guests` are not logged into our application.

```php
$acl->allow('*', '*', 'view');
```

This gives access to the `view` access to everyone, but we want the `guest` role to be excluded from that so the following line does what we need.

```php
$acl->deny('guest', '*', 'view');
```

## Querying
Once the list has been defined, we can query it to check if a particular role has access to a particular component and action. To do so, we need to use the `isAllowed()` method.

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new Memory();

// #01
$acl->addRole('manager');
$acl->addRole('accounting');
$acl->addRole('guest');

// #02
$acl->addComponent(
    'admin',
    [
        'dashboard',
        'users',
        'view',
    ]
);

$acl->addComponent(
    'reports',
    [
        'list',
        'add',
        'view',
    ]
);

$acl->addComponent(
    'session',
    [
        'login',
        'logout',
    ]
);

// #03
$acl->allow('manager', 'admin', 'users');
$acl->allow('manager', 'reports', ['list', 'add']);
$acl->allow('*', 'session', '*');
$acl->allow('*', '*', 'view');

// #04
$acl->deny('guest', '*', 'view');

// ....

// #05
$acl->isAllowed('manager', 'admin', 'dashboard');

// #06
$acl->isAllowed('manager', 'session', 'login');

// #07
$acl->isAllowed('accounting', 'reports', 'view');

// #08
$acl->isAllowed('guest', 'reports', 'view');

// #09
$acl->isAllowed('guest', 'reports', 'add');
```

> **Legend**
> 
> 01: Add roles
> 
> 02: Add components
> 
> 03: Set up the `allow` list
> 
> 04: Set up the `deny` list
> 
> 05: `true` - defined explicitly
> 
> 06: `true` - defined with wildcard
> 
> 07: `true` - defined with wildcard
> 
> 08: `false` - defined explicitly
> 
> 09: `false` - default access level 
> 
> {: .alert .alert-info }

## Function Based Access
Depending on the needs of your application, you might need another layer of calculations to allow or deny access to users through the ACL. The method `isAllowed()` accepts a 4th parameter which is a callable such as an anonymous function.

To take advantage of this functionality, you will need to define your function when calling the `allow()` method for the role and component you need. Assume that we need to allow access to all `manager` roles to the `admin` component except if their name is 'Bob' (Poor Bob!). To achieve this we will register an anonymous function that will check this condition.

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new Memory();

// #01
$acl->addRole('manager');

// #02
$acl->addComponent(
    'admin',
    [
        'dashboard',
        'users',
        'view',
    ]
);

// #03
$acl->allow(
    'manager',
    'admin',
    'dashboard',
    function ($name) {
        return boolval('Bob' !== $name);
    }
);
```

> **Legend**
> 
> 01: Add roles
> 
> 02: Add components
> 
> 03: Set access level for role into components with custom function 
> 
> {: .alert .alert-info }

Now that the callable is defined in the ACL, we will need to call the `isAllowed()` method with an array as the fourth parameter:

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new Memory();

// #01
$acl->addRole('manager');

// #02
$acl->addComponent(
    'admin',
    [
        'dashboard',
        'users',
        'view',
    ]
);

// #03
$acl->allow(
    'manager',
    'admin',
    'dashboard',
    function ($name) {
        return boolval('Bob' !== $name);
    }
);

// #04
$acl->isAllowed(
    'manager',
    'admin',
    'dashboard',
    [
        'name' => 'John',
    ]
);

// #05
$acl->isAllowed(
    'manager',
    'admin',
    'dashboard',
    [
        'name' => 'Bob',
    ]
);
```

> **Legend**
> 
> 01: Add roles
> 
> 02: Add components
> 
> 03: Set access level for role into components with custom function
> 
> 04: Returns `true`
> 
> 05: Returns `false` 
> 
> {: .alert .alert-info }

> **NOTE**:The fourth parameter must be an array. Each array element represents a parameter that your anonymous function accepts. The key of the element is the name of the parameter, while the value is what will be passed as the value of that the parameter of to the function. 
> 
> {: .alert .alert-info }

You can also omit to pass the fourth parameter to `isAllowed()` if you wish. The default action for a call to `isAllowed()` without the last parameter is `Acl\Enum::DENY`. To change this behavior, you can make a call to `setNoArgumentsDefaultAction()`:

```php
<?php

use Phalcon\Acl\Enum;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new Memory();

// #01
$acl->addRole('manager');

// #02
$acl->addComponent(
    'admin',
    [
        'dashboard',
        'users',
        'view',
    ]
);

// #03
$acl->allow(
    'manager',
    'admin',
    'dashboard',
    function ($name) {
        return boolval('Bob' !== $name);
    }
);

// #04
$acl->isAllowed('manager', 'admin', 'dashboard');

$acl->setNoArgumentsDefaultAction(
    Enum::ALLOW
);

// #05
$acl->isAllowed('manager', 'admin', 'dashboard');
```

> **Legend**
> 
> 01: Add roles
> 
> 02: Add components
> 
> 03: Set access level for role into components with custom function
> 
> 04: Returns `false`
> 
> 05: Returns `true` 
> 
> {: .alert .alert-info }

## Custom Objects
Phalcon allows developers to define their own role and component objects. These objects must implement the supplied interfaces:

* [Phalcon\Acl\RoleAware][acl-roleaware] for Role
* [Phalcon\Acl\ComponentAware][acl-componentaware] for Component

### Role
We can implement the [Phalcon\Acl\RoleAware][acl-roleaware] in our custom class with its own logic. The example below shows a new role object called `ManagerRole`:

```php
<?php

use Phalcon\Acl\RoleAware;

// #01
class ManagerRole implements RoleAware
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

    // #02
    public function getRoleName()
    {
        return $this->roleName;
    }
}
```

> **Legend**
> 
> 01: Create our class which will be used as roleName
> 
> 02: Implemented function from RoleAware Interface 
> 
> {: .alert .alert-info }

### Component
We can implement the [Phalcon\Acl\ComponentAware][acl-componentaware] in our custom class with its own logic. The example below shows a new role object called `ReportsComponent`:

```php
<?php

use Phalcon\Acl\ComponentAware;

// #01
class ReportsComponent implements ComponentAware
{
    protected $id;

    protected $componentName;

    protected $userId;

    public function __construct($id, $componentName, $userId)
    {
        $this->id            = $id;
        $this->componentName = $componentName;
        $this->userId        = $userId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    // #02
    public function getComponentName()
    {
        return $this->componentName;
    }
}
```

> **Legend**
> 
> 01: Create our class which will be used as componentName
> 
> 02: Implemented function from ComponentAware Interface 
> 
> {: .alert .alert-info }

### 访问控制列表(ACL)
These objects can now be used in our ACL.

```php
<?php

use ManagerRole;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;
use ReportsComponent;

$acl = new Memory();

// #01
$acl->addRole('manager');

// #02
$acl->addComponent(
    'reports',
    [
        'list',
        'add',
        'view',
    ]
);

// #03
$acl->allow(
    'manager', 
    'reports', 
    'list',
    function (ManagerRole $manager, ModelComponent $model) {
        return boolval($manager->getId() === $model->getUserId());
    }
);

// #04
$levelOne = new ManagerRole(1, 'manager-1');
$levelTwo = new ManagerRole(2, 'manager');
$admin    = new ManagerRole(3, 'manager');

// #05
$reports  = new ModelComponent(2, 'reports', 2);

// #06
$acl->isAllowed($levelOne, $reports, 'list');

// #07
$acl->isAllowed($levelTwo, $reports, 'list');

// #08
$acl->isAllowed($admin, $reports, 'list');
```

> **Legend**
> 
> 01: Add roles
> 
> 02: Add components
> 
> 03: Now tie them all together with a custom function. The `ManagerRole` and `ModelSubject` parameters are necessary for the custom function to work
> 
> 04: Create the custom objects
> 
> 05: id - name - userId
> 
> 06: Check whether our user objects have access. Returns `false`
> 
> 07: Returns `true`
> 
> 08: Returns `false` 
> 
> {: .alert .alert-info }

The second call for `$levelTwo` evaluates `true` since the `getUserId()` returns `2` which in turn is evaluated in our custom function. Also note that in the custom function for `allow()` the objects are automatically bound, providing all the data necessary for the custom function to work. The custom function can accept any number of additional parameters. The order of the parameters defined in the `function()` constructor does not matter, because the objects will be automatically discovered and bound.

## Roles Inheritance
To remove duplication and increase efficiency in your application, the ACL offers inheritance in roles. This means that you can define one [Phalcon\Acl\Role][acl-role] as a base and after that inherit from it offering access to supersets or subsets of components. To use role inheritance, you need, you need to pass the inherited role as the second parameter of the method call, when adding that role in the list.

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;

$acl = new Memory();

// #01
$manager    = new Role('Managers');
$accounting = new Role('Accounting Department');
$guest      = new Role('Guests');

// #02
$acl->addRole($guest);

// #03
$acl->addRole($accounting, $guest);

// #04
$acl->addRole($manager, $accounting);
```

> **Legend**
> 
> 01: Create roles
> 
> 02: Add the `guest` role to the ACL
> 
> 03: Add the `accounting` inheriting from `guest`
> 
> 04: Add the `manager` inheriting from `accounting` 
> 
> {: .alert .alert-info }

Whatever access `guests` have will be propagated to `accounting` and in turn `accounting` will be propagated to `manager`. You can also pass an array of roles as the second parameter of `addRole` offering more flexibility.

## Roles Relationships
Based on the application design, you might prefer to add first all the roles and then define the relationship between them.

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;

$acl = new Memory();

// #01
$manager    = new Role('Managers');
$accounting = new Role('Accounting Department');
$guest      = new Role('Guests');

// #02
$acl->addRole($manager);
$acl->addRole($accounting);
$acl->addRole($guest);

// #03
$acl->addInherit($manager, $accounting);
$acl->addInherit($accounting, $guest);
```

> **Legend**
> 
> 01: Create roles
> 
> 02: Add all the roles
> 
> 03: Add the inheritance 
> 
> {: .alert .alert-info }

## Serialization
[Phalcon\Acl][acl-acl] can be serialized and stored in a cache system to improve efficiency. You can store the serialized object in APC, session, file system, database, Redis etc. This way you can retrieve the ACL quickly without having to read the underlying data that create the ACL nor will you have to compute the ACL in every request.

```php
<?php

use Phalcon\Acl\Adapter\Memory;

$aclFile = 'app/security/acl.cache';
// #01
if (true !== is_file($aclFile)) {

    // #02
    $acl = new Memory();

    // #03
    // ...

    // #04
    file_put_contents(
        $aclFile,
        serialize($acl)
    );
} else {
    // #05
    $acl = unserialize(
        file_get_contents($aclFile)
    );
}

// #06
if (true === $acl->isAllowed('manager', 'admin', 'dashboard')) {
    echo 'Access granted!';
} else {
    echo 'Access denied :(';
}
```

> **Legend**
> 
> 01: Check whether ACL data already exist
> 
> 02: The ACL does not exist - build it
> 
> 03: Define roles, components, access, etc.
> 
> 04: Store serialized list into a plain file
> 
> 05: Restore the ACL object from the serialized file
> 
> 06: Use the ACL list as needed 
> 
> {: .alert .alert-info }

It is a good practice to not use serialization of the ACL during development, to ensure that your ACL is rebuilt with every request, while other adapters or means of serializing and storing the ACL in production.

## Events
[Phalcon\Acl][acl-acl] can work in conjunction with the [Events Manager](events) if present, to fire events to your application. Events are triggered using the type `acl`. Events that return `false` can stop the active role. The following events are available:

| 事件名称                | 触发器                                                      | Can stop role? |
| ------------------- | -------------------------------------------------------- |:--------------:|
| `afterCheckAccess`  | Triggered after checking if a role/component has access  |       否        |
| `beforeCheckAccess` | Triggered before checking if a role/component has access |       是的       |

The following example demonstrates how to attach listeners to the ACL:

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Events\Event;
use Phalcon\Events\Manager;

// ...

// #01
$eventsManager = new Manager();

// #02
$eventsManager->attach(
    'acl:beforeCheckAccess',
    function (Event $event, $acl) {
        echo $acl->getActiveRole() . PHP_EOL;

        echo $acl->getActiveComponent() . PHP_EOL;

        echo $acl->getActiveAccess() . PHP_EOL;
    }
);

$acl = new Memory();

// #03
// ...

// #04
$acl->setEventsManager($eventsManager);
```

> **Legend**
> 
> 01: Create an event manager
> 
> 02: Attach a listener for type `acl`
> 
> 03: Setup the `$acl`
> 
> 04: Bind the eventsManager to the ACL component 
> 
> {: .alert .alert-info }

## Exceptions
Any exceptions thrown in the `Phalcon\Acl` namespace will be of type [Phalcon\Acl\Exception][acl-exception]. You can use this exception to selectively catch exceptions thrown only from this component.

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Component;
use Phalcon\Acl\Exception;

try {
    $acl   = new Memory();
    $admin = new Component('*');
} catch (Exception $ex) {
    echo $ex->getMessage();
}
```

## Custom
The [Phalcon\Acl\AdapterInterface][acl-adapter-adapterinterface] interface must be implemented in order to create your own ACL adapters or extend the existing ones.

[acl]: https://en.wikipedia.org/wiki/Access_control_list
[acl-acl]: api/phalcon_acl
[acl-adapter-adapterinterface]: api/phalcon_acl#acl-adapter-adapterinterface
[acl-adapter-memory]: api/phalcon_acl#acl-adapter-memory
[acl-adapter-memory]: api/phalcon_acl#acl-adapter-memory
[acl-component]: api/phalcon_acl#acl-component
[acl-component]: api/phalcon_acl#acl-component
[acl-componentaware]: api/phalcon_acl#acl-componentaware
[acl-enum]: api/phalcon_acl#acl-enum
[acl-exception]: api/phalcon_acl#acl-exception
[acl-role]: api/phalcon_acl#acl-role
[acl-role]: api/phalcon_acl#acl-role
[acl-roleaware]: api/phalcon_acl#acl-roleaware
[codeception]: https://codeception.com
[whitelist]: https://en.wikipedia.org/wiki/Whitelisting
