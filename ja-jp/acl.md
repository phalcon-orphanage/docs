* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# Access Control Lists (ACL)

[Phalcon\Acl](api/Phalcon_Acl) provides an easy and lightweight management of ACLs as well as the permissions attached to them. [Access Control Lists](https://en.wikipedia.org/wiki/Access_control_list) (ACL) allow an application to control access to its areas and the underlying objects from requests.

In short, ACLs have two objects: The object that needs access, and the object that we need access to. In the programming world, these are usually referred to as Roles and Resources. In the Phalcon world, we use the terminology [Operation](api/Phalcon_Acl_Operation) and [Subject](api/Phalcon_Acl_Subject).

> **Use Case**
> 
> An accounting application needs to have different groups of users have access to various areas of the application.
> 
> **Operation** - Administrator Access - Accounting Department Access - Manager Access - Guest Access
> 
> **Subject** - Login page - Admin page - Invoices page - Reports page {:.alert .alert-info}

As seen above in the use case, an [Operation](api/Phalcon_Acl_Operation) is defined as who needs to access a particular [Subject](api/Phalcon_Acl_Subject) i.e. an area of the application. A [Subject](api/Phalcon_Acl_Subject) is defined as the area of the application that needs to be accessed.

Using the [Phalcon\Acl](api/Phalcon_Acl) component, we can tie those two together, and strengthen the security of our application, allowing only specific operations to be bound to specific subjects.

<a name='setup'></a>

## Creating an ACL

[Phalcon\Acl](api/Phalcon_Acl) uses adapters to store and work with operations and subjects. The only adapter available right now is [Phalcon\Acl\Adapter\Memory](api/Phalcon_Acl_Adapter_Memory). Having the adapter use the memory, significantly increases the speed that the ACL is accessed but also comes with drawbacks. The main drawback is that memory is not persistent, so the developer will need to implement a storing strategy for the ACL data, so that the ACL is not generated at every request. This could easily lead to delays and unnecessary processing, especially if the ACL is quite big and/or stored in a database or file system.

Phalcon also offers an easy way for developers to build their own adapters by implementing the [Phalcon\Acl\AdapterInterface](api/Phalcon_Acl_AdapterInterface) interface.

### In action

The [Phalcon\Acl](api/Phalcon_Acl) constructor takes as its first parameter an adapter used to retrieve the information related to the control list.

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;

$acl = new AclList();
```

There are two self explanatory actions that the [Phalcon\Acl](api/Phalcon_Acl) provides: - `Phalcon\Acl::ALLOW` - `Phalcon\Acl::DENY`

The default action is **`Phalcon\Acl::DENY`** for any [Operation](api/Phalcon_Acl_Operation) or [Subject](api/Phalcon_Acl_Subject). This is on purpose to ensure that only the developer or application allows access to specific subjects and not the ACL component itself.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;

$acl = new AclList();

// Default action is deny access

// Change it to allow
$acl->setDefaultAction(Acl::ALLOW);
```

<a name='adding-operations'></a>

## Adding Operations

As mentioned above, a [Phalcon\Acl\Operation](api/Phalcon_Acl_Operation) is an object that can or cannot access a set of [Subject](api/Phalcon_Acl_Subject) in the access list.

There are two ways of adding operations to our list. * by using a [Phalcon\Acl\Operation](api/Phalcon_Acl_Operation) object or * using a string, representing the name of the operation

To see this in action, using the example outlined above, we will add the relevant [Phalcon\Acl\Operation](api/Phalcon_Acl_Operation) objects in our list:

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Operation;

$acl = new AclList();

/**
 * Create some Operations.
 * 
 * The first parameter is the name of the operation, 
 * the second is an optional description
 */

$operationAdmins     = new Operation('admins', 'Administrator Access');
$operationAccounting = new Operation('accounting', 'Accounting Department Access'); 

/**
 * Add these operations in the list 
 */
$acl->addOperation($operationAdmins);
$acl->addOperation($operationAccounting);

/**
 * Add operations without creating an object first 
 */
$acl->addOperation('manager');
$acl->addOperation('guest');
```

<a name='adding-subjects'></a>

## Adding Subjects

A [Subject](api/Phalcon_Acl_Subject) is the area of the application where access is controlled. In a MVC application, this would be a Controller. Although not mandatory, the [Phalcon\Acl\Subject](api/Phalcon_Acl_Subject) class can be used to define resources in the application. Also it is important to add related actions to a subject so that the ACL can understand what it should control.

There are two ways of adding subjects to our list. * by using a [Phalcon\Acl\Subject](api/Phalcon_Acl_Subject) object or * using a string, representing the name of the operation

Similar to the `addOperation`, `addSubject` requires a name for the subject and an optional description.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Subject;

$acl = new AclList();

/**
 * Create some Subjects and add their respective actions in the ACL
 */
$admin   = new Subject('admin', 'Administration Pages');
$reports = new Subject('reports', 'Reports Pages');

/**
 * Add the subjects to the ACL and attach them to relevant actions 
 */
$acl->addResource($admin, ['dashboard', 'users']);
$acl->addResource($reports, ['list', 'add']);

/**
 * Add subjects without creating an object first 
 */
$acl->addResource('admin', ['dashboard', 'users']);
$acl->addResource('reports', ['list', 'add']);
```

<a name='access-controls'></a>

## Defining Access Controls

After both the `Operations` and `Subjects` have been defined, we need to tie them together so that the access list can be created. This is the most important step in the operation since a small mistake here can provide access for subjects to operations that the developer does not intend to. As mentioned earlier, the default access action for [Phalcon\Acl](api/Phalcon_Acl) is `Acl::DENY`, following the [whitelist](https://en.wikipedia.org/wiki/Whitelisting) approach.

To tie `Operations` and `Subjects` together we use the `allow()` and `deny()` methods that the [Phalcon\Acl\Memory](api/Phalcon_Acl_Memory) exposes.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Operation;
use Phalcon\Acl\Subject;

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
$acl->deny('guest', '*', 'view');
```

For the `guest` operation, we deny access to all subjects with the `view` action. Despite the fact that the default access level is `Acl::DENY` in our example above, we specifically allowed the `view` action to all operations and subjects. This includes the `guest` operation. We want to allow the `guest` operation access only to the `session` subject and the `login` and `logout` actions, since `guests` are not logged into our application.

```php
$acl->allow('*', '*', 'view');
```

This gives access to the `view` access to everyone, but we want the `guest` operation to be excluded from that so the following line does what we need.

```php
$acl->deny('guest', '*', 'view');
```

<a name='querying'></a>

## Querying an ACL

Once the list has been defined, we can query it to check if a particular operation has access to a particular subject and action. To do so, we need to use the `isAllowed()` method.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Operation;
use Phalcon\Acl\Subject;

$acl = new AclList();

/**
 * Setup the ACL
 */
$acl->addOperation('manager');                   
$acl->addOperation('accounting');                   
$acl->addOperation('guest');                       


$acl->addResource('admin', ['dashboard', 'users', 'view']);
$acl->addResource('reports', ['list', 'add', 'view']);
$acl->addResource('session', ['login', 'logout']);

$acl->allow('manager', 'admin', 'users');
$acl->allow('manager', 'reports', ['list', 'add']);
$acl->allow('*', 'session', '*');
$acl->allow('*', '*', 'view');

$acl->deny('guest', '*', 'view');

// ....


// true - defined explicitly
$acl->isAllowed('manager', 'admin', 'dashboard');

// true - defiled with wildcard
$acl->isAllowed('manager', 'session', 'login');

// true - defined with wildcard
$acl->isAllowed('accounting', 'reports', 'view');

// false - defined explicitly
$acl->isAllowed('guest', 'reports', 'view');

// false - default access level
$acl->isAllowed('guest', 'reports', 'add');
```

<a name='function-based-access'></a>

## Function based access

Depending on the needs of your application, you might need another layer of calculations to allow or deny access to users through the ACL. The method `isAllowed()` accepts a 4th parameter which is a callable such as an anonymous function.

To take advantage of this functionality, you will need to define your function when calling the `allow()` method for the operation and subject you need. Assume that we need to allow access to all `manager` operations to the `admin` subject except if their name is 'Bob' (Poor Bob!). To achieve this we will register an anonymous function that will check this condition.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Operation;
use Phalcon\Acl\Subject;

$acl = new AclList();

/**
 * Setup the ACL
 */
$acl->addOperation('manager');                   
$acl->addResource('admin', ['dashboard', 'users', 'view']);

// Set access level for role into resources with custom function
$acl->allow(
    'manager',
    'admin',
    'dashboard',
    function ($name) {
        return boolval('Bob' !== $name);
    }
);
```

Now that the callable is defined in the ACL, we will need to call the `isAllowed()` with an array as the fourth parameter:

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Operation;
use Phalcon\Acl\Subject;

$acl = new AclList();

/**
 * Setup the ACL
 */
$acl->addOperation('manager');                   
$acl->addResource('admin', ['dashboard', 'users', 'view']);

// Set access level for role into resources with custom function
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

> The fourth parameter must be an array. Each array element represents a parameter that your anonymous function accepts. The key of the element is the name of the parameter, while the value is the value that the parameter of the function will accept {:.alert .alert-info}

You can also omit to pass the fourth parameter to `isAllowed()` if you wish. The default action for a call to `isAllowed()` without the last parameter is `Acl::DENY`. To change this behavior, you can make a call to `setNoArgumentsDefaultAction()`:

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Operation;
use Phalcon\Acl\Subject;

$acl = new AclList();

/**
 * Setup the ACL
 */
$acl->addOperation('manager');                   
$acl->addResource('admin', ['dashboard', 'users', 'view']);

// Set access level for role into resources with custom function
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

$acl->setNoArgumentsDefaultAction(Acl::ALLOW);

// Returns true
$acl->isAllowed('manager', 'admin', 'dashboard');
```

** WIP BELOW - NEEDS REWRITING **
<a name='objects'></a>

## Objects as role name and resource name

You can pass objects as `roleName` and `resourceName`. Your classes must implement [Phalcon\Acl\RoleAware](api/Phalcon_Acl_RoleAware) for `roleName` and [Phalcon\Acl\ResourceAware](api/Phalcon_Acl_ResourceAware) for `resourceName`.

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

## Roles Inheritance

You can build complex role structures using the inheritance that [Phalcon\Acl\Role](api/Phalcon_Acl_Role) provides. Roles can inherit from other roles, thus allowing access to supersets or subsets of resources. To use role inheritance, you need to pass the inherited role as the second parameter of the method call, when adding that role in the list.

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

## Serializing ACL lists

To improve performance [Phalcon\Acl](api/Phalcon_Acl) instances can be serialized and stored in APC, session, text files or a database table so that they can be loaded at will without having to redefine the whole list. You can do that as follows:

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

<a name='events'></a>

## Events

[Phalcon\Acl](api/Phalcon_Acl) is able to send events to an `EventsManager` if it's present. Events are triggered using the type 'acl'. Some events when returning boolean false could stop the active operation. The following events are supported:

| Event Name        | Triggered                                               | Can stop operation? |
| ----------------- | ------------------------------------------------------- |:-------------------:|
| beforeCheckAccess | Triggered before checking if a role/resource has access |         Yes         |
| afterCheckAccess  | Triggered after checking if a role/resource has access  |         No          |

The following example demonstrates how to attach listeners to this component:

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

## Implementing your own adapters

The [Phalcon\Acl\AdapterInterface](api/Phalcon_Acl_AdapterInterface) interface must be implemented in order to create your own ACL adapters or extend the existing ones.