---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Componente de Listas de Control de Acceso

* * *

## Agregando Componentes

Un [Component](api/Phalcon_Acl_Component) es el área de la aplicación donde se controla el acceso. En una aplicación MVC, esto sería un controlador. Aunque no es obligatorio, la clase [Phalcon\Acl\Component](api/Phalcon_Acl_Component) puede utilizarse para definir componentes en la aplicación. También es importante añadir acciones relacionadas a un componente para que la ACL pueda entender lo que debe controlar.

Hay dos maneras de agregar componentes a nuestra lista. * Usando un objecto [Phalcon\Acl\Component](api/Phalcon_Acl_Component) * Usando una cadena, representando el nombre del rol

Similar a la `addRole`, `addComponent` requiere un nombre para el tema y una descripción opcional.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Component;

$acl = new AclList();

/**
 * Crear algunos componentes y agregarles sus repectivas acciones a la ACL
 */
$admin   = new Component('admin', 'Administration Pages');
$reports = new Component('reports', 'Reports Pages');

/**
 * Agregar los componentes a la ACL y adjuntarlos a las acciones relacionadas
 */
$acl->addComponent($admin, ['dashboard', 'users']);
$acl->addComponent($reports, ['list', 'add']);

/**
 * Agregar componentes sin crear objectos
 */
$acl->addComponent('admin', ['dashboard', 'users']);
$acl->addComponent('reports', ['list', 'add']);
```