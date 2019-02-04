---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Componente de Listas de Control de Acceso

* * *

## Agregando Asuntos

Un [Subject](api/Phalcon_Acl_Subject) o Asunto es el área de la aplicación donde se controla el acceso. En una aplicación MVC, esto sería un controlador. Aunque no es obligatorio, la clase [Phalcon\Acl\Subject](api/Phalcon_Acl_Subject) puede utilizarse para definir asuntos en la aplicación. También es importante añadir acciones relacionadas a un tema para que la ACL pueda entender lo que debe controlar.

Hay dos maneras de agregar asuntos a nuestra lista. * Usando un objecto [Phalcon\Acl\Subject](api/Phalcon_Acl_Subject) * Usando una cadena, representando el nombre de la operación

Similar a la `addOperation`, `addSubject` requiere un nombre para el tema y una descripción opcional.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Subject;

$acl = new AclList();

/**
 * Crear algunos Subjects y sus respectivas acciones en la ACL
 */
$admin   = new Subject('admin', 'Administration Pages');
$reports = new Subject('reports', 'Reports Pages');

/**
 * Agregar asuntos a la ACL y adjuntarlos a las acciones relevantes
 */
$acl->addSubject($admin, ['dashboard', 'users']);
$acl->addSubject($reports, ['list', 'add']);

/**
 * Agregar asuntos sin crear un objecto
 */
$acl->addSubject('admin', ['dashboard', 'users']);
$acl->addSubject('reports', ['list', 'add']);
```