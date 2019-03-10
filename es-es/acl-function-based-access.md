---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Componente de Listas de Control de Acceso

* * *

## Acceso basado en una función

Dependiendo de las necesidades de su aplicación, podría necesitar otra capa de cálculos para permitir o no el acceso a los usuarios a través de la ACL. El método `isAllowed()` acepta un cuarto parámetro que es un callable como una función anónima.

Para aprovechar esta funcionalidad, necesitará definir su función al llamar el método `allow()` para el rol y componente que necesita. Supongamos que necesitamos permitir el acceso a todos los roles `manager` al componente `admin` excepto si su nombre es 'Bob' (¡Pobre Bob!). Para lograrlo, registraremos una función anónima que verificará esta condición.

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
$acl->addComponent('admin', ['dashboard', 'users', 'view']);

// Establecer el nivel de acceso para un rol en un componente con una función personalizada
$acl->allow(
    'manager',
    'admin',
    'dashboard',
    function ($name) {
        return boolval('Bob' !== $name);
    }
);
```

Ahora que el callable esta definido en la ACL, necesitaremos llamar al método `isAllowed()` con un array como cuarto parámetro:

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
$acl->addComponent('admin', ['dashboard', 'users', 'view']);

// Establecer el nivel de acceso para un rol en un componente con una función personalizada
$acl->allow(
    'manager',
    'admin',
    'dashboard',
    function ($name) {
        return boolval('Bob' !== $name);
    }
);

// Retornará true
$acl->isAllowed(
    'manager',
    'admin',
    'dashboard',
    [
        'name' => 'John',
    ]
);

// Retornará false
$acl->isAllowed(
    'manager',
    'admin',
    'dashboard',
    [
        'name' => 'Bob',
    ]
);
```

> El cuarto parámetro debe ser un array. Cada elemento del array representa un parámetro que su función anónima aceptará. La clave del elemento es el nombre del parámetro, mientras que el valor es lo que se pasará como valor de ese parámetro en la función.
{:.alert .alert-info}

También puede omitir pasar el cuarto parámetro a `isAllowed()` si lo desea. La acción por defecto para una llamada a `isAllowed()` sin el último parámetro es `Acl::DENY`. Para cambiar este comportamiento, puede hacer una llamada a `setNoArgumentsDefaultAction()`:

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
$acl->addComponent('admin', ['dashboard', 'users', 'view']);

// Establecer el nivel de acceso para un rol en un componente con una función personalizada
$acl->allow(
    'manager',
    'admin',
    'dashboard',
    function ($name) {
        return boolval('Bob' !== $name);
    }
);

// Retornará false
$acl->isAllowed('manager', 'admin', 'dashboard');

$acl->setNoArgumentsDefaultAction(Acl::ALLOW);

// Retornará true
$acl->isAllowed('manager', 'admin', 'dashboard');
```