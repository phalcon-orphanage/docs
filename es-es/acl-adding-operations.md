---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Componente de Listas de Control de Acceso

* * *

## Agregando Operaciones

Como se ha mencionado anteriormente, un [Phalcon\Acl\Operation](api/Phalcon_Acl_Operation) es un objeto que puede o no puede acceder a un conjunto de [Subject](api/Phalcon_Acl_Subject) en la lista de acceso.

Hay dos maneras de agregar operaciones a nuestra lista. * Usando un objecto [Phalcon\Acl\Operation](api/Phalcon_Acl_Operation) * Usando una cadena, representando el nombre de la operación

Para ver esto en acción, usando el ejemplo descrito arriba, añadiremos los objetos [Phalcon\Acl\Operation](api/Phalcon_Acl_Operation) relevantes en nuestra lista:

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Operation;

$acl = new AclList();

/**
 * Crear algunas Operaciones.
 * 
 * El primer parámetro es el nombre de la operación, 
 * el segundo, opcional, es una descripción
 */

$operationAdmins     = new Operation('admins', 'Administrator Access');
$operationAccounting = new Operation('accounting', 'Accounting Department Access'); 

/**
 * Agregar estas operaciones a la lista
 */
$acl->addOperation($operationAdmins);
$acl->addOperation($operationAccounting);

/**
 * Agregar operaciones sin crear un objecto
 */
$acl->addOperation('manager');
$acl->addOperation('guest');
```