---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Componente de Listas de Control de Acceso

* * *

## Herencia de roles

Para eliminar la duplicación y aumentar la eficiencia en su aplicación, ACL ofrece herencia en roles. Esto significa que puedes definir un [Phalcon\Acl\Role](api/Phalcon_Acl_Role) como base y después que hereden de él, ofreciendo acceso a superconjuntos o subconjuntos de componentes. Para utilizar la herencia de roles, necesita pasar el rol heredado como el segundo parámetro de la llamada del método, al añadir ese rol en la lista.

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

Sea cual sea el acceso que tenga `guests`, se propagará a `acoounting` y a su vez `accounting` se propagará a `manager`

### Configurar relaciones después que se agregan los roles

Basado en el diseño de aplicaciones, podría preferir añadir primero todos los roles y luego definir la relación entre ellos.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Role;

$acl = new AclList();

/**
 * Crear los roles
 */
$manager    = new Role('Managers');
$accounting = new Role('Accounting Department');
$guest      = new Role('Guests');

/**
 * Agregar todos los roles
 */
$acl->addRole($manager);
$acl->addRole($accounting);
$acl->addRole($guest);

/**
 * Agregar las herencias
 */
$acl->addInherit($manager, $accounting);
$acl->addInherit($accounting, $guest);

```