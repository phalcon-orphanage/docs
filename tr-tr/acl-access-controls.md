---
layout: default
language: 'tr-tr'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Access Control Lists Component

* * *

## Erişim Kontrolleri Tanımlama

After both the `Roles` and `Components` have been defined, we need to tie them together so that the access list can be created. This is the most important step in the role since a small mistake here can allow access to roles for components that the developer does not intend to. As mentioned earlier, the default access action for [Phalcon\Acl](api/Phalcon_Acl) is `Acl::DENY`, following the [whitelist](https://en.wikipedia.org/wiki/Whitelisting) approach.

To tie `Roles` and `Components` together we use the `allow()` and `deny()` methods exposed by the [Phalcon\Acl\Memory](api/Phalcon_Acl_Memory) class.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new AclList();

/**
 * Add the roles
 */
$acl->addRole('manager');
$acl->addRole('accounting');
$acl->addRole('guest');


/**
 * Add the Components
 */
$acl->addComponent('admin', ['dashboard', 'users', 'view']);
$acl->addComponent('reports', ['list', 'add', 'view']);
$acl->addComponent('session', ['login', 'logout']);

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

> Please be **VERY** careful when using the `*` wildcard. It is very easy to make a mistake and the wildcard, although it seems convenient, it may allow users to access areas of your application that they are not supposed to. The best way to be 100% sure is to write tests specifically to test the permissions and the ACL. These can be done in the `unit` test suite by instantiating the component and then checking the `isAllowed()` if it is `true` or `false`.
> 
> [Codeception](https://codeception.com) is the chosen testing framework for Phalcon and there are plenty of tests in our github repository (`tests` folder) to offer guidance and ideas.
{:.alert .alert-danger}

```php
$acl->deny('guest', '*', 'view');
```

For the `guest` role, we deny access to all components with the `view` action. Despite the fact that the default access level is `Acl::DENY` in our example above, we specifically allowed the `view` action to all roles and components. This includes the `guest` role. We want to allow the `guest` role access only to the `session` component and the `login` and `logout` actions, since `guests` are not logged into our application.

```php
$acl->allow('*', '*', 'view');
```

This gives access to the `view` access to everyone, but we want the `guest` role to be excluded from that so the following line does what we need.

```php
$acl->deny('guest', '*', 'view');
```