---
layout: default
language: 'tr-tr'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Access Control Lists Component

* * *

## ACL Sorgulama

Once the list has been defined, we can query it to check if a particular role has access to a particular component and action. To do so, we need to use the `isAllowed()` method.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new AclList();

/**
 * Setup the ACL
 */
$acl->addRole('manager');                   
$acl->addRole('accounting');                   
$acl->addRole('guest');                       


$acl->addComponent('admin', ['dashboard', 'users', 'view']);
$acl->addComponent('reports', ['list', 'add', 'view']);
$acl->addComponent('session', ['login', 'logout']);

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