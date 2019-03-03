---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Componente de Listas de Control de Acceso

* * *

## Agregando Roles

Como se ha mencionado anteriormente, un [Phalcon\Acl\Role](api/Phalcon_Acl_Role) es un objeto que puede o no puede acceder a un conjunto de [Component](api/Phalcon_Acl_Component) en la lista de acceso.

Hay dos maneras de agregar roles a nuestra lista. * Usando un objecto [Phalcon\Acl\Role](api/Phalcon_Acl_Role) * Usando una cadena, representando el nombre del rol

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