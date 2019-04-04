---
layout: default
language: 'tr-tr'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Access Control Lists Component

* * *

## Adding Roles

As mentioned above, a [Phalcon\Acl\Role](api/Phalcon_Acl_Role) is an object that can or cannot access a set of [Component](api/Phalcon_Acl_Component) in the access list.

There are two ways of adding roles to our list. * by using a [Phalcon\Acl\Role](api/Phalcon_Acl_Role) object or * using a string, representing the name of the role

To see this in action, using the example outlined above, we will add the relevant [Phalcon\Acl\Role](api/Phalcon_Acl_Role) objects in our list:

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Role;

$acl = new AclList();

/**
 * Create some Roles.
 * 
 * The first parameter is the name of the role, 
 * the second is an optional description
 */

$roleAdmins     = new Role('admins', 'Administrator Access');
$roleAccounting = new Role('accounting', 'Accounting Department Access'); 

/**
 * Add these roles in the list 
 */
$acl->addRole($roleAdmins);
$acl->addRole($roleAccounting);

/**
 * Add roles without creating an object first 
 */
$acl->addRole('manager');
$acl->addRole('guest');
```