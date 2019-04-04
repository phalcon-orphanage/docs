---
layout: default
language: 'tr-tr'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Access Control Lists Component

* * *

## ACL Oluşturma

[Phalcon\Acl](api/Phalcon_Acl) uses adapters to store and work with roles and components. The only adapter available right now is [Phalcon\Acl\Adapter\Memory](api/Phalcon_Acl_Adapter_Memory). Having the adapter use the memory, significantly increases the speed that the ACL is accessed but also comes with drawbacks. The main drawback is that memory is not persistent, so the developer will need to implement a storing strategy for the ACL data, so that the ACL is not generated at every request. This could easily lead to delays and unnecessary processing, especially if the ACL is quite big and/or stored in a database or file system.

Phalcon also offers an easy way for developers to build their own adapters by implementing the [Phalcon\Acl\AdapterInterface](api/Phalcon_Acl_AdapterInterface) interface.

### In action

The [Phalcon\Acl](api/Phalcon_Acl) constructor takes as its first parameter an adapter used to retrieve the information related to the control list.

```php
<?php

use Phalcon\Acl\Adapter\Memory as AclList;

$acl = new AclList();
```

There are two self explanatory actions that the [Phalcon\Acl](api/Phalcon_Acl) provides: - `Phalcon\Acl::ALLOW` - `Phalcon\Acl::DENY`

The default action is **`Phalcon\Acl::DENY`** for any [Role](api/Phalcon_Acl_Role) or [Component](api/Phalcon_Acl_Component). This is on purpose to ensure that only the developer or application allows access to specific components and not the ACL component itself.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;

$acl = new AclList();

// Default action is deny access

// Change it to allow
$acl->setDefaultAction(Acl::ALLOW);
```