---
layout: article
language: 'el-gr'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Access Control Lists Component

* * *

## Adding Subjects

Σαν [θέμα](api/Phalcon_Acl_Subject) ορίζουμε την περιοχή της εφαρμογής που πρέπει να ελεχθεί. In a MVC application, this would be a Controller. Although not mandatory, the [Phalcon\Acl\Subject](api/Phalcon_Acl_Subject) class can be used to define subjects in the application. Επίσης είναι σημαντικό να προσθέσετε σχετικές ενέργειες σε έναν θέμα, έτσι ώστε η ACL να καταλάβει τι πρέπει να ελένξει.

There are two ways of adding subjects to our list. * by using a [Phalcon\Acl\Subject](api/Phalcon_Acl_Subject) object or * using a string, representing the name of the operation

Similar to the `addOperation`, `addSubject` requires a name for the subject and an optional description.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Subject;

$acl = new AclList();

/**
 * Create some Subjects and add their respective actions in the ACL
 */
$admin   = new Subject('admin', 'Administration Pages');
$reports = new Subject('reports', 'Reports Pages');

/**
 * Add the subjects to the ACL and attach them to relevant actions 
 */
$acl->addSubject($admin, ['dashboard', 'users']);
$acl->addSubject($reports, ['list', 'add']);

/**
 * Add subjects without creating an object first 
 */
$acl->addSubject('admin', ['dashboard', 'users']);
$acl->addSubject('reports', ['list', 'add']);
```