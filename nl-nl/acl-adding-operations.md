---
layout: article
language: 'nl-nl'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Access Control Lists Component

* * *

## Adding Operations

Zoals hierboven vermeld, is een [Phalcon\Acl\Operation](api/Phalcon_Acl_Operation) een object dat wel of geen toegang geeft tot een verzameling van [Subject](api/Phalcon_Acl_Subject) in de toegangslijst.

Er zijn twee manieren bewerkingen toe te voegen aan onze lijst. * met behulp van een [Phalcon\Acl\Operation](api/Phalcon_Acl_Operation) of * met behulp van een string, die de naam van de bewerking representeert

Om dit in actie te zien, zullen we de relevante [Phalcon\Acl\Operation](api/Phalcon_Acl_Operation) objecten in onze lijst toevoegen, gebruikmakend van bovenstaand voorbeeld:

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Operation;

$acl = new AclList();

/**
 * Definieer een aantal Operations.
 * 
 * De eerste parameter is de naam van de operation, 
 * de tweede is een optionele beschrijving
 */

$operationAdmins     = new Operation('admins', 'Administrator Access');
$operationAccounting = new Operation('accounting', 'Accounting Department Access'); 

/**
 * Voeg deze operations toe aan de lijst
 */
$acl->addOperation($operationAdmins);
$acl->addOperation($operationAccounting);

/**
 * Toevoegen operations zonder een object te maken
 */
$acl->addOperation('manager');
$acl->addOperation('guest');
```