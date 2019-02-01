---
layout: article
language: 'el-gr'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Access Control Lists Component

* * *

## Προσθήκη Λειτουργιών

Όπως αναφέρθηκε παραπάνω, η [Phalcon\Acl\Operation](api/Phalcon_Acl_Operation) είναι ένα αντικείμενο που μπορεί ή όχι να έχει πρόσβαση σε ένα σύνολο [θέματων](api/Phalcon_Acl_Subject) στη λίστα πρόσβασης.

There are two ways of adding operations to our list. * by using a [Phalcon\Acl\Operation](api/Phalcon_Acl_Operation) object or * using a string, representing the name of the operation

To see this in action, using the example outlined above, we will add the relevant [Phalcon\Acl\Operation](api/Phalcon_Acl_Operation) objects in our list:

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Operation;

$acl = new AclList();

/**
 * Create some Operations.
 * 
 * The first parameter is the name of the operation, 
 * the second is an optional description
 */

$operationAdmins     = new Operation('admins', 'Administrator Access');
$operationAccounting = new Operation('accounting', 'Accounting Department Access'); 

/**
 * Add these operations in the list 
 */
$acl->addOperation($operationAdmins);
$acl->addOperation($operationAccounting);

/**
 * Add operations without creating an object first 
 */
$acl->addOperation('manager');
$acl->addOperation('guest');
```