---
layout: article
language: 'nl-nl'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Access Control Lists Component

* * *

- [Toegangscontrolelijst (ACL)](acl-overview)
- [Creating an ACL](acl-setup)
- [Adding Operations](acl-adding-operations)
- [Adding Subjects](acl-adding-subjects)
- [Defining Access Controls](acl-access-controls)
- [Querying an ACL](acl-querying)
- [Function based access](acl-function-based-access)
- [Objects as operation name and subject name](acl-objects)
- [Operations Inheritance](acl-operations-inheritance)
- [Serializing ACL lists](acl-serialization)
- [Events](acl-events)
- [Implementing your own adapters](acl-custom-adapters)

* * *

## Toegangscontrolelijst (ACL)

[Phalcon\Acl](api/Phalcon_Acl) biedt een eenvoudige en lichtgewicht beheer van toegangscontrole en machtigingen. [Toegangscontrolelijsten](https://en.wikipedia.org/wiki/Access_control_list) (ACL) geven een applicatie toegang tot de gebieden en de onderliggende objecten van aanvragen.

Kortom, ACL's heeft twee objecten: Het object dat toegang nodig heeft, en het object we toegang tot willen. In de programmering wereld, worden deze meestal aangeduid als Operations en Subjects (operaties en onderwerpen). In Phalcon gebruiken we deze terminologie ook [ Operation](api/Phalcon_Acl_Operation) en [ Subject ](api/Phalcon_Acl_Subject).

> **Use Case**
> 
> Een boekhoudkundige toepassing moet verschillende groepen gebruikers toegang geven tot verschillende gebieden van de toepassing.
> 
> ** Operation** - beheerder toegang - boekhoudafdeling toegang - manager Toegang - gasten toegang
> 
> **Subject** - Login pagina - Beheerder pagina - facturatie pagina - rapporten pagina {:.alert .alert-info}

Zoals hierboven is te zien in het voorbeeld, een [Operation](api/Phalcon_Acl_Operation) wordt gedefinieerd als die het nodig heeft voor toegang tot een bepaalde [Subject](api/Phalcon_Acl_Subject) oftewel en gebied van de toepassing. Een [Subject](api/Phalcon_Acl_Subject) wordt gedefinieerd als het gebied van de toepassing die moet worden geopend.

Met behulp van het component [Phalcon\Acl](api/Phalcon_Acl), kunnen wij die twee verbinden, en gebruiken voor het beveiligen van onze applicatie, zodat alleen bepaalde bewerkingen kunnen worden gebonden aan specifieke onderwerpen.