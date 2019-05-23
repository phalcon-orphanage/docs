---
layout: default
language: 'en'
version: '4.0'
title: 'Phalcon\Acl\Adapter\Memory'
---

# Class **Phalcon\Acl\Adapter\Memory**

**extends** [Phalcon\Acl\Adapter](Phalcon_Acl_Adapter) **implements** [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Acl\AdapterInterface](Phalcon_Acl_AdapterInterface)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/acl/adapter/memory.zep)

### Description

Manages ACL lists in memory

### Example

```php
<?php

namespace Phalcon\Acl\Adapter;

use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new Memory();

$acl->setDefaultAction(
    \Phalcon\Acl::DENY
);

// Register roles
$roles = [
    "users"  => new Role("Users"),
    "guests" => new Role("Guests"),
];
foreach ($roles as $role) {
    $acl->addRole($role);
}

// Private area components
$privateComponents = [
    "companies" => ["index", "search", "new", "edit", "save", "create", "delete"],
    "products"  => ["index", "search", "new", "edit", "save", "create", "delete"],
    "invoices"  => ["index", "profile"],
];

foreach ($privateComponents as $componentName => $actions) {
    $acl->addComponent(new Component($componentName), $actions);
}

// Public area components
$publicComponents = [
    "index"   => ["index"],
    "about"   => ["index"],
    "session" => ["index", "register", "start", "end"],
    "contact" => ["index", "send"],
];

foreach ($publicComponents as $componentName => $actions) {
    $acl->addComponent(new Component($componentName), $actions);
}

// Grant access to public areas to both users and guests
foreach ($roles as $role){
    foreach ($publicComponents as $component => $actions) {
        $acl->allow($role->getName(), $component, "");
    }
}

// Grant access to private area to role Users
foreach ($privateComponents as $component => $actions) {
    foreach ($actions as $action) {
        $acl->allow("Users", $component, $action);
    }
}
```

### Properties

```php
protected mixed $access         
```

Access

```php
protected mixed $accessList
```

Access List

```php
protected mixed $activeFunction
```

Returns latest function used to acquire access

```php
protected int $activeFunctionCustomArgumentsCount = 0
```

`Returns number of additional arguments(excluding role and resource) for active function

```php
protected string|null $activeKey  
```

Returns latest key used to acquire access

```php
protected mixed $func         
```

Function List

```php
protected mixed $noArgumentsDefaultAction = Acl::DENY         
```

Default action for no arguments is allow

```php
protected mixed $roles         
```

Roles

```php
protected mixed $roleInherits         
```

Role Inherits

```php
protected mixed $rolesNames         
```

Roles Names

```php
protected mixed $components         
```

Components

```php
protected mixed $componentsNames         
```

Component Names

### Methods

Returns latest function used to acquire access

```php
public function getActiveFunction(): mixed
```

* * *

Returns number of additional arguments(excluding role and resource) for active function

```php
public function getActiveFunctionCustomArgumentsCount(): int
```

* * *

Returns latest key used to acquire access

```php
public function getActiveKey():? string
```

* * *

Inherit from an existing role

```php
public function addInherit(string $roleName, mixed $roleToInherits): bool
```

```php
$acl->addRole("administrator", "consultant");
$acl->addRole("administrator", ["consultant", "consultant2"]);
```

* * *

Adds a role to the ACL list. Second parameter allows inheriting access data from other existing role

```php
public function addRole(
    Phalcon\Acl\RoleInterface|string|array $role, 
    string $accessInherits = null
): bool
```

```php $acl->addRole( new Phalcon\Acl\Role("administrator"), "consultant" );

$acl->addRole("administrator", "consultant"); $acl->addRole("administrator", ["consultant", "consultant2"]);

    <hr/>
    
    
    Adds a component to the ACL list
    
    ```php
    public function addComponent(
        Phalcon\Acl\ComponentInterface|string $componentValue, 
        array|string $accessList
    ): bool
    

```php
// Add a component to the the list allowing access to an action
$acl->addComponent(
    new Phalcon\Acl\Component("customers"),
    "search"
);

$acl->addComponent("customers", "search");

// Add a component  with an access list
$acl->addComponent(
    new Phalcon\Acl\Component("customers"),
    [
        "create",
        "search",
    ]
);

$acl->addComponent(
    "customers",
    [
        "create",
        "search",
    ]
);
```

* * *

Adds access to components

```php
public function addComponentAccess(string $componentName, array|string $accessList): bool
```

* * *

Allow access to a role on a component

```php
public function allow( string $roleName, string $componentName, mixed $access [, mixed $func = null] )
```

```php
// Allow access to guests to search on customers
$acl->allow("guests", "customers", "search");

// Allow access to guests to search or create on customers
$acl->allow("guests", "customers", ["search", "create"]);

// Allow access to any role to browse on products
$acl->allow("", "products", "browse");

// Allow access to any role to browse on any component
$acl->allow("", "", "browse");
```

* * *

Deny access to a role on a component

```php
public function deny( string $roleName, string $componentName, mixed $access [, mixed $func = null] )
```

```php
// Deny access to guests to search on customers
$acl->deny("guests", "customers", "search");

// Deny access to guests to search or create on customers
$acl->deny("guests", "customers", ["search", "create"]);

// Deny access to any role to browse on products
$acl->deny("", "products", "browse");

// Deny access to any role to browse on any component
$acl->deny("", "", "browse");
```

* * *

Removes an access from a component

```php
public function dropComponentAccess( string $componentName, array|string $accessList )
```

* * *

Returns the default ACL access level for no arguments provided in `isAllowed()` action if there exists func for accessKey

```php
public function getNoArgumentsDefaultAction(): int {}
```

* * *

Return an array with every role registered in the list

```php
public function getRoles(): Phalcon\Acl\RoleInterface[]
```

* * *

Return an array with every component registered in the list

```php
public function getComponents(): [Phalcon\Acl\ComponentInterface](Phalcon_Acl_ComponentInterface)[]
```

* * *

Check whether a role is allowed to access an action from a component

```php
public function isAllowed(
    Phalcon\Acl\RoleInterface|Phalcon\Acl\RoleAware|string $roleName, 
    Phalcon\Acl\ComponentInterface|Phalcon\Acl\ComponentAware|string $componentName, 
    string $access, 
    array $parameters = null
): bool
```

```php
// Does andres have access to the customers component to create?
$acl->isAllowed("andres", "Products", "create");

// Do guests have access to any component to edit?
$acl->isAllowed("guests", "", "edit");
```

* * *

Check whether role exist in the roles list

```php
public function isRole(string $roleName): bool 
```

* * *

Check whether component exist in the components list

```php
public function isComponent(string $componentName): bool
```

* * *

Sets the default access level (`Phalcon\Acl::ALLOW` or `Phalcon\Acl::DENY`) for no arguments provided in `isAllowed()` action if a `func` exists for `accessKey`

```php
public function setNoArgumentsDefaultAction(int $defaultAccess)
```

* * *