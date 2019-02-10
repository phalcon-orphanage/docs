---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Componente de Listas de Control de Acceso

* * *

## Adding Components

A [Component](api/Phalcon_Acl_Component) is the area of the application where access is controlled. En una aplicación MVC, esto sería un controlador. Although not mandatory, the [Phalcon\Acl\Component](api/Phalcon_Acl_Component) class can be used to define components in the application. Also it is important to add related actions to a component so that the ACL can understand what it should control.

There are two ways of adding components to our list. * by using a [Phalcon\Acl\Component](api/Phalcon_Acl_Component) object or * using a string, representing the name of the role

Similar to the `addRole`, `addComponent` requires a name for the component and an optional description.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Component;

$acl = new AclList();

/**
 * Create some Components and add their respective actions in the ACL
 */
$admin   = new Component('admin', 'Administration Pages');
$reports = new Component('reports', 'Reports Pages');

/**
 * Add the components to the ACL and attach them to relevant actions 
 */
$acl->addComponent($admin, ['dashboard', 'users']);
$acl->addComponent($reports, ['list', 'add']);

/**
 * Add components without creating an object first 
 */
$acl->addComponent('admin', ['dashboard', 'users']);
$acl->addComponent('reports', ['list', 'add']);
```