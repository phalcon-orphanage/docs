---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Componente de Listas de Control de Acceso

* * *

## Consultando una ACL

Una vez definida la lista, podemos consultarla para comprobar si un rol, en particular, tiene acceso a un componente y una acción. Para hacerlo, necesitamos usar el método `isAllowed()`.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

$acl = new AclList();

/**
 * Establecer el ACL
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


// true - definido explicitamente
$acl->isAllowed('manager', 'admin', 'dashboard');

// true - definido con comodines
$acl->isAllowed('manager', 'session', 'login');

// true - definido con comodines
$acl->isAllowed('accounting', 'reports', 'view');

// false - definido explicitamente
$acl->isAllowed('guest', 'reports', 'view');

// false - nivel de acceso por defecto
$acl->isAllowed('guest', 'reports', 'add');
```