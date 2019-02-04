---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Componente de Listas de Control de Acceso

* * *

## Operations Inheritance

To remove duplication and increase efficiency in your application, the ACL offers inheritance in operations. This means that you can define one [Phalcon\Acl\Operation](api/Phalcon_Acl_Operation) as a base and after that inherit from it offering access to supersets or subsets of subjects. To use operation inheritance, you need, you need to pass the inherited operation as the second parameter of the method call, when adding that operation in the list.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Operation;

$acl = new AclList();

/**
 * Create the operations
 */
$manager    = new Operation('Managers');
$accounting = new Operation('Accounting Department');
$guest      = new Operation('Guests');

/**
 * Add the `guest` operation to the ACL 
 */
$acl->addOperation($guest);

/**
 * Add the `accounting` inheriting from `guest` 
 */
$acl->addOperation($accounting, $guest);
/**
 * Add the `manager` inheriting from `accounting` 
 */

$acl->addOperation($manager, $accounting);
```

Whatever access `guests` have will be propagated to `accounting` and in turn `accounting` will be propagated to `manager`

### Setup relationships after adding operations

Based on the application design, you might prefer to add first all the operations and then define the relationship between them.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Operation;

$acl = new AclList();

/**
 * Create the operations
 */
$manager    = new Operation('Managers');
$accounting = new Operation('Accounting Department');
$guest      = new Operation('Guests');

/**
 * Add all the operations
 */
$acl->addOperation($manager);
$acl->addOperation($accounting);
$acl->addOperation($guest);

/**
 * Add the inheritance 
 */
$acl->addInherit($manager, $accounting);
$acl->addInherit($accounting, $guest);

```