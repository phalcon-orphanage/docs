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

Para ver esto en acción, usando el ejemplo descrito arriba, añadiremos los objetos [Phalcon\Acl\Role](api/Phalcon_Acl_Role) relevantes en nuestra lista:

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Role;

$acl = new AclList();

/**
 * Crear algunos Roles.
 * 
 * El primer parámetro es el nombre del rol, 
 * el segundo, es opcional, es la descripción
 */

$roleAdmins     = new Role('admins', 'Administrator Access');
$roleAccounting = new Role('accounting', 'Accounting Department Access'); 

/**
 * Agregar esos roles a la lista
 */
$acl->addRole($roleAdmins);
$acl->addRole($roleAccounting);

/**
 * Agregar roles sin crear un objecto
 */
$acl->addRole('manager');
$acl->addRole('guest');
```