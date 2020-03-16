---
layout: default
language: 'ja-jp'
version: '4.0'
upgrade: '#acl'
title: 'アクセス制御リスト - Access Control Lists (ACL)'
keywords: 'アクセス制御リスト, アクセス権, 権限, パーミッション, acl, access control list, permissions'
---

# アクセス制御リスト - Access Control Lists (ACL)

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## 概要

[Phalcon\Acl](api/Phalcon_Acl) は、ファイルパーミッションの付与同様に、簡単で軽量なアクセス制御の管理機能を提供します。[Access Control Lists](https://ja.wikipedia.org/wiki/%E3%82%A2%E3%82%AF%E3%82%BB%E3%82%B9%E5%88%B6%E5%BE%A1%E3%83%AA%E3%82%B9%E3%83%88) (ACLs) を使用すると、アプリケーションはAPIのリクエストからそれらのデータ領域と基本となるオブジェクトへアクセスできます。

簡単に言えば、ACLsには2つのオブジェクトがあります: アクセスの際に必要な要素を格納したオブジェクトと、我々がアクセスしたいと思うオブジェクトです。プログラミングの世界では、一般的にRoleとComponentと呼ばれています。Phalconでは [Role](api/Phalcon_Acl#acl-role) と [Component](api/Phalcon_Acl#acl-component) という用語を使用します。

> **使用例**
> 
> 例えば、会計アプリケーションは、アプリケーションのさまざまな領域にアクセスできる様々なユーザーグループを持つ必要があります。
> 
> **Role** - Administrator Access - Accounting Department Access - Manager Access - Guest Access
> 
> **Component** - Login page - Admin page - Invoices page - Reports page
{:.alert .alert-info}

上記の使用例では、 １つの [Role](api/Phalcon_Acl#acl-role) は、アプリケーションの特定の部分である [Component](api/Phalcon_Acl#acl-component) にアクセスする必要があるユーザーとして定義されます。 [Component](api/Phalcon_Acl#acl-component) は、アクセスする必要があるアプリケーションの領域として定義されます。

[Phalcon\Acl](api/Phalcon_Acl) を使用すると、これら2つを結び付けることができます。そうすれば、アプリケーションのセキュリティを強化して特定のロールのみを特定のコンポーネントにバインドできるようになるのです。

## 機能の有効化

[Phalcon\Acl](api/Phalcon_Acl) は、Adapterを使用してRoleとComponentの保管や操作を行います。 

現在利用できる唯一のアダプターは  [Phalcon\Acl\Adapter\Memory](api/Phalcon_Acl#acl-adapter-memory) です。 しかし、Adapterにメモリを使用させると、ACLへのアクセス速度が大幅に向上しますが、欠点もあります。主な欠点はメモリが永続的ではないことです。
そのため、開発者はACLデータの保存を実装する必要があります。つまり、ACLはリクエストごとに生成されないということです。
これは特に、ACLが非常に大きい場合、さらにデータベースまたはファイルシステムに格納されている場合はなおさら、
遅延と不要な処理を容易に引き起こす可能性があります。

[Phalcon\Acl](api/Phalcon_Acl) コンストラクターの1つめの引数はアクセス制御リストの情報を取得するために使用するアダプターです。

```php
<?php

use Phalcon\Acl\Adapter\Memory;

$acl = new Memory();
```

既定のアクションは、 [Role](api/Phalcon_Acl#acl-role) または [Component](api/Phalcon_Acl#acl-component) の **`Phalcon\Acl\Enum::DENY`** です。これは、開発者またはアプリケーションのみが特定のコンポーネントへのアクセスを許可し、ACLコンポーネント自体へのアクセスを許可しないようにするためです。

```php
<?php

use Phalcon\Acl\Enum;
use Phalcon\Acl\Adapter\Memory;

$acl = new Memory();

$acl->setDefaultAction(Enum::ALLOW);
```

## 定数

[Phalcon\Acl\Enum](api/Phalcon_Acl#acl-enum) classは、アクセスレベルを定義するときに使用できる2つの定数を提供します。

* `Phalcon\Acl\Enum::ALLOW` (`1`)
* `Phalcon\Acl\Enum::DENY` (`0` - default)

これらの定数を使用して、ACLのアクセスレベルを定義できます。

## Roleの追加

上記で説明した通り、 [Phalcon\Acl\Role](api/Phalcon_Acl#acl-role) は、アクセス制御リストの [Component](api/Phalcon_Acl#acl-component) にアクセスできる、またはアクセスできないオブジェクトの組み合わせです。

アクセス制御リストにroleを追加するには2つの方法があります。
* by using a [Phalcon\Acl\Role](api/Phalcon_Acl#acl-role) オブジェクトを使用する。
* ロールの名前を表す文字列を使用する。

To see this in action, using the example outlined above, we will add the relevant [Phalcon\Acl\Role](api/Phalcon_Acl#acl-role) objects in our list.
実例として上記の定義を使用し、関連する [Phalcon\Acl\Role](api/Phalcon_Acl#acl-role) オブジェクトをリストに追加します。

下記はオブジェクトを使用して追加する場合です。
Roleオブジェクトの1つ目の引数はRoleの名称、2つ目の引数は説明文です。

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

下記は文字列を使用して追加する場合です。名前だけのRoleを直接ACLに追加します。

```php
<?php

use Phalcon\Acl\Adapter\Memory;

$acl = new Memory();

$acl->addRole('manager');
$acl->addRole('guest');
```

## Componentの追加

A [Component](api/Phalcon_Acl#acl-component) はアクセス制限をしたいアプリケーションの領域です。 MVCアプリケーションでは、これはControllerになります。必須ではありませんが、 [Phalcon\Acl\Component](api/Phalcon_Acl#acl-component) classをアプリケーションでコンポーネントを定義する際に使用することもできます。そして、ACLが制御対象を理解できるように、関連ActionをComponentに追加することが重要です。

リストにコンポーネントを追加するには2つの方法があります。
* [Phalcon\Acl\Component](api/Phalcon_Acl#acl-component) オブジェクトを使用するか、
* 文字列を使用します。Roleの名前を示すものを。

`addRole` と同様に、`addComponent`にはコンポーネントの名前とオプションの説明が必要です。

下記はオブジェクトを使用して追加する場合です。
Component オブジェクトの1つ目の引数はComponentの名称、2つ目の引数は説明文です。

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

下記は文字列を使用して追加する場合です。名前だけのComponentを直接ACLに追加します。

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

## Defining Access Controls

After both the `Roles` and `Components` have been defined, we need to tie them together so that the access list can be created. This is the most important step in the role since a small mistake here can allow access to roles for components that the developer does not intend to. As mentioned earlier, the default access action for [Phalcon\Acl](api/Phalcon_Acl) is `Phalcon\Acl\Enum::DENY`, following the [white list](https://en.wikipedia.org/wiki/Whitelisting) approach.

To tie `Roles` and `Components` together we use the `allow()` and `deny()` methods exposed by the [Phalcon\Acl\Memory](api/Phalcon_Acl#acl-adapter-memory) class.

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new Memory();

/**
 * Add the roles
 */
$acl->addRole('manager');
$acl->addRole('accounting');
$acl->addRole('guest');


/**
 * Add the Components
 */

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

/**
 * Now tie them all together 
 */
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

For the `manager` role, allow access to the `admin` component and `users` action. To bring this into perspective with a MVC application, the above line says that the group `manager` is allowed to access the `admin` controller and `users` action.

```php
$acl->allow('manager', 'reports', ['list', 'add']);
```

You can also pass an array as the `action` parameter when invoking the `allow()` command. The above means that for the `manager` role, allow access to the `reports` component and `list` and `add` actions. Again to bring this into perspective with a MVC application, the above line says that the group `manager` is allowed to access the `reports` controller and `list` and `add` actions.

```php
$acl->allow('*', 'session', '*');
```

Wildcards can also be used to do mass matching for roles, components or actions. In the above example, we allow every role to access every action in the `session` component. This command will give access to the `manager`, `accounting` and `guest` roles, access to the `session` component and to the `login` and `logout` actions.

```php
$acl->allow('*', '*', 'view');
```

Similarly the above gives access to any role, any component that has the `view` action. In a MVC application, the above is the equivalent of allowing any group to access any controller that exposes a `viewAction`.

> **NOTE**: Please be **VERY** careful when using the `*` wildcard. It is very easy to make a mistake and the wildcard, although it seems convenient, it may allow users to access areas of your application that they are not supposed to. The best way to be 100% sure is to write tests specifically to test the permissions and the ACL. These can be done in the `unit` test suite by instantiating the component and then checking the `isAllowed()` if it is `true` or `false`.
> 
> [Codeception](https://codeception.com) is the chosen testing framework for Phalcon and there are plenty of tests in our GitHub repository (`tests` folder) to offer guidance and ideas.
{:.alert .alert-danger}

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

/**
 * Setup the ACL
 */
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

// ....



// true - defined explicitly
$acl->isAllowed('manager', 'admin', 'dashboard');

// true - defined with wildcard
$acl->isAllowed('manager', 'session', 'login');

// true - defined with wildcard
$acl->isAllowed('accounting', 'reports', 'view');

// false - defined explicitly
$acl->isAllowed('guest', 'reports', 'view');

// false - default access level
$acl->isAllowed('guest', 'reports', 'add');
```

## Function Based Access

Depending on the needs of your application, you might need another layer of calculations to allow or deny access to users through the ACL. The method `isAllowed()` accepts a 4th parameter which is a callable such as an anonymous function.

To take advantage of this functionality, you will need to define your function when calling the `allow()` method for the role and component you need. Assume that we need to allow access to all `manager` roles to the `admin` component except if their name is 'Bob' (Poor Bob!). To achieve this we will register an anonymous function that will check this condition.

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new Memory();

/**
 * Setup the ACL
 */
$acl->addRole('manager');

$acl->addComponent(
    'admin',
    [
        'dashboard',
        'users',
        'view',
    ]
);

// Set access level for role into components with custom function
$acl->allow(
    'manager',
    'admin',
    'dashboard',
    function ($name) {
        return boolval('Bob' !== $name);
    }
);
```

Now that the callable is defined in the ACL, we will need to call the `isAllowed()` method with an array as the fourth parameter:

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new Memory();

/**
 * Setup the ACL
 */
$acl->addRole('manager');

$acl->addComponent(
    'admin',
    [
        'dashboard',
        'users',
        'view',
    ]
);

// Set access level for role into components with custom function
$acl->allow(
    'manager',
    'admin',
    'dashboard',
    function ($name) {
        return boolval('Bob' !== $name);
    }
);

// Returns true
$acl->isAllowed(
    'manager',
    'admin',
    'dashboard',
    [
        'name' => 'John',
    ]
);

// Returns false
$acl->isAllowed(
    'manager',
    'admin',
    'dashboard',
    [
        'name' => 'Bob',
    ]
);
```

> **NOTE**:The fourth parameter must be an array. Each array element represents a parameter that your anonymous function accepts. The key of the element is the name of the parameter, while the value is what will be passed as the value of that the parameter of to the function.
{:.alert .alert-info}

You can also omit to pass the fourth parameter to `isAllowed()` if you wish. The default action for a call to `isAllowed()` without the last parameter is `Acl\Enum::DENY`. To change this behavior, you can make a call to `setNoArgumentsDefaultAction()`:

```php
<?php

use Phalcon\Acl\Enum;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new Memory();

/**
 * Setup the ACL
 */
$acl->addRole('manager');

$acl->addComponent(
    'admin',
    [
        'dashboard',
        'users',
        'view',
    ]
);

// Set access level for role into components with custom function
$acl->allow(
    'manager',
    'admin',
    'dashboard',
    function ($name) {
        return boolval('Bob' !== $name);
    }
);

// Returns false
$acl->isAllowed('manager', 'admin', 'dashboard');

$acl->setNoArgumentsDefaultAction(
    Enum::ALLOW
);

// Returns true
$acl->isAllowed('manager', 'admin', 'dashboard');
```

## Custom Objects

Phalcon allows developers to define their own role and component objects. These objects must implement the supplied interfaces:

* [Phalcon\Acl\RoleAware](api/Phalcon_Acl#acl-roleaware) for Role
* [Phalcon\Acl\ComponentAware](api/Phalcon_Acl#acl-componentaware) for Component

### Role

We can implement the [Phalcon\Acl\RoleAware](api/Phalcon_Acl#acl-roleaware) in our custom class with its own logic. The example below shows a new role object called `ManagerRole`:

```php
<?php

use Phalcon\Acl\RoleAware;

// Create our class which will be used as roleName
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

    // Implemented function from RoleAware Interface
    public function getRoleName()
    {
        return $this->roleName;
    }
}
```

### Component

We can implement the [Phalcon\Acl\ComponentAware](api/Phalcon_Acl#acl-componentaware) in our custom class with its own logic. The example below shows a new role object called `ReportsComponent`:

```php
<?php

use Phalcon\Acl\ComponentAware;

// Create our class which will be used as componentName
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

    // Implemented function from ComponentAware Interface
    public function getComponentName()
    {
        return $this->componentName;
    }
}
```

### ACL

These objects can now be used in our ACL.

```php
<?php

use ManagerRole;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;
use ReportsComponent;

$acl = new Memory();

/**
 * Add the roles
 */
$acl->addRole('manager');

/**
 * Add the Components
 */
$acl->addComponent(
    'reports',
    [
        'list',
        'add',
        'view',
    ]
);

/**
 * Now tie them all together with a custom function. The ManagerRole and
 * ModelSbject parameters are necessary for the custom function to work 
 */
$acl->allow(
    'manager', 
    'reports', 
    'list',
    function (ManagerRole $manager, ModelComponent $model) {
        return boolval($manager->getId() === $model->getUserId());
    }
);

// Create the custom objects
$levelOne = new ManagerRole(1, 'manager-1');
$levelTwo = new ManagerRole(2, 'manager');
$admin    = new ManagerRole(3, 'manager');

// id - name - userId
$reports  = new ModelComponent(2, 'reports', 2);

// Check whether our user objects have access 
// Returns false
$acl->isAllowed($levelOne, $reports, 'list');

// Returns true
$acl->isAllowed($levelTwo, $reports, 'list');

// Returns false
$acl->isAllowed($admin, $reports, 'list');
```

The second call for `$levelTwo` evaluates `true` since the `getUserId()` returns `2` which in turn is evaluated in our custom function. Also note that in the custom function for `allow()` the objects are automatically bound, providing all the data necessary for the custom function to work. The custom function can accept any number of additional parameters. The order of the parameters defined in the `function()` constructor does not matter, because the objects will be automatically discovered and bound.

## Roles Inheritance

To remove duplication and increase efficiency in your application, the ACL offers inheritance in roles. This means that you can define one [Phalcon\Acl\Role](api/Phalcon_Acl#acl-role) as a base and after that inherit from it offering access to supersets or subsets of components. To use role inheritance, you need, you need to pass the inherited role as the second parameter of the method call, when adding that role in the list.

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;

$acl = new Memory();

/**
 * Create the roles
 */
$manager    = new Role('Managers');
$accounting = new Role('Accounting Department');
$guest      = new Role('Guests');

/**
 * Add the `guest` role to the ACL 
 */
$acl->addRole($guest);

/**
 * Add the `accounting` inheriting from `guest` 
 */
$acl->addRole($accounting, $guest);

/**
 * Add the `manager` inheriting from `accounting` 
 */
$acl->addRole($manager, $accounting);
```

Whatever access `guests` have will be propagated to `accounting` and in turn `accounting` will be propagated to `manager`. You can also pass an array of roles as the second parameter of `addRole` offering more flexibility.

## Roles Relationships

Based on the application design, you might prefer to add first all the roles and then define the relationship between them.

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;

$acl = new Memory();

/**
 * Create the roles
 */
$manager    = new Role('Managers');
$accounting = new Role('Accounting Department');
$guest      = new Role('Guests');

/**
 * Add all the roles
 */
$acl->addRole($manager);
$acl->addRole($accounting);
$acl->addRole($guest);

/**
 * Add the inheritance 
 */
$acl->addInherit($manager, $accounting);
$acl->addInherit($accounting, $guest);

```

## Serialization

[Phalcon\Acl](api/Phalcon_Acl) can be serialized and stored in a cache system to improve efficiency. You can store the serialized object in APC, session, file system, database, Redis etc. This way you can retrieve the ACL quickly without having to read the underlying data that create the ACL nor will you have to compute the ACL in every request.

```php
<?php

use Phalcon\Acl\Adapter\Memory;

$aclFile = 'app/security/acl.cache';
// Check whether ACL data already exist
if (true !== is_file($aclFile)) {

    // The ACL does not exist - build it
    $acl = new Memory();

    // ... Define roles, components, access, etc

    // Store serialized list into plain file
    file_put_contents(
        $aclFile,
        serialize($acl)
    );
} else {
    // Restore ACL object from serialized file
    $acl = unserialize(
        file_get_contents($aclFile)
    );
}

// Use ACL list as needed
if (true === $acl->isAllowed('manager', 'admin', 'dashboard')) {
    echo 'Access granted!';
} else {
    echo 'Access denied :(';
}
```

It is a good practice to not use serialization of the ACL during development, to ensure that your ACL is rebuilt with every request, while other adapters or means of serializing and storing the ACL in production.

## Events

[Phalcon\Acl](api/Phalcon_Acl) can work in conjunction with the [Events Manager](events) if present, to fire events to your application. Events are triggered using the type `acl`. Events that return `false` can stop the active role. The following events are available:

| Event Name          | Triggered                                                | Can stop role? |
| ------------------- | -------------------------------------------------------- |:--------------:|
| `afterCheckAccess`  | Triggered after checking if a role/component has access  |       No       |
| `beforeCheckAccess` | Triggered before checking if a role/component has access |      Yes       |

The following example demonstrates how to attach listeners to the ACL:

```php
<?php

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Events\Event;
use Phalcon\Events\Manager;

// ...

// Create an event manager
$eventsManager = new Manager();

// Attach a listener for type 'acl'
$eventsManager->attach(
    'acl:beforeCheckAccess',
    function (Event $event, $acl) {
        echo $acl->getActiveRole() . PHP_EOL;

        echo $acl->getActiveComponent() . PHP_EOL;

        echo $acl->getActiveAccess() . PHP_EOL;
    }
);

$acl = new Memory();

// Setup the $acl
// ...

// Bind the eventsManager to the ACL component
$acl->setEventsManager($eventsManager);
```

## Exceptions

Any exceptions thrown in the `Phalcon\Acl` namespace will be of type [Phalcon\Acl\Exception](api/Phalcon_Acl#acl-exception). You can use this exception to selectively catch exceptions thrown only from this component.

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

The [Phalcon\Acl\AdapterInterface](api/Phalcon_Acl#acl-adapter-adapterinterface) interface must be implemented in order to create your own ACL adapters or extend the existing ones.
