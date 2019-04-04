---
layout: default
language: 'tr-tr'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Access Control Lists Component

* * *

## Roles Inheritance

To remove duplication and increase efficiency in your application, the ACL offers inheritance in roles. This means that you can define one [Phalcon\Acl\Role](api/Phalcon_Acl_Role) as a base and after that inherit from it offering access to supersets or subsets of components. To use role inheritance, you need, you need to pass the inherited role as the second parameter of the method call, when adding that role in the list.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Role;

$acl = new AclList();

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

Whatever access `guests` have will be propagated to `accounting` and in turn `accounting` will be propagated to `manager`

### Setup relationships after adding roles

Based on the application design, you might prefer to add first all the roles and then define the relationship between them.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Role;

$acl = new AclList();

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