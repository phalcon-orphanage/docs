---
layout: article
language: 'nl-nl'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Access Control Lists Component

* * *

## Creating an ACL

[Phalcon\Acl](api/Phalcon_Acl) gebruikt een adapters om operations en subjects op te slaan en ermee te werken. De enige beschikbare adapter op dit moment is [Phalcon\Acl\Adapter\Memory](api/Phalcon_Acl_Adapter_Memory). Een memory adapter zorg voor een aanzienlijke verhoging in de snelheid wanneer de ACL wordt benaderd, maar heeft ook nadelen. Het grootste nadeel is dat het geheugen niet persistent is, dus de ontwikkelaar moet een opslagstrategie voor de ACL-gegevens implementeren, zodat de ACL niet op elk verzoek wordt gegenereerd. Dit kan gemakkelijk leiden tot vertragingen en onnodige verwerking, vooral als de ACL vrij groot en/of opgeslagen is in een database of bestand systeem.

Phalcon biedt ook een gemakkelijke manier voor ontwikkelaars om hun eigen adapters te bouwen door de [Phalcon\Acl\AdapterInterface](api/Phalcon_Acl_AdapterInterface) interface te implementeren.

### In actie

De [Phalcon\Acl](api/Phalcon_Acl) constructor neemt als eerste parameter een adapter die wordt gebruikt om de gegevens op te halen die nodig zijn voor de toegangscontrolelijst.

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;

$acl = new AclList();
```

Er zijn twee voor zichzelf sprekende acties die de [Phalcon\Acl](api/Phalcon_Acl) heeft: - `Phalcon\Acl::ALLOW` - `Phalcon\Acl::DENY`

**`Phalcon\Acl::DENY`** Is de standaardactie voor elke [operatie](api/Phalcon_Acl_Operation) of [onderwerp](api/Phalcon_Acl_Subject). Dit is met opzet om ervoor te zorgen dat alleen de ontwikkelaar of de toepassing toegang tot specifieke onderwerpen verleent en niet in het de ACL-component zelf.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;

$acl = new AclList();

// Standaard actie is geen toegang

// Verander de standaard naar toegang/allow
$acl->setDefaultAction(Acl::ALLOW);
```