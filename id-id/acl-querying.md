---
layout: article
language: 'id-id'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Access Control Lists Component

* * *

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


$acl->addSubject('admin', ['dashboard', 'users', 'view']);
$acl->addSubject('reports', ['list', 'add', 'view']);
$acl->addSubject('session', ['login', 'logout']);

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