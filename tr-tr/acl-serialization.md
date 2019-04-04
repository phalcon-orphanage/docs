---
layout: default
language: 'tr-tr'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Access Control Lists Component

* * *

## ACL Listelerini Seri Hale Getirme

[Phalcon\Acl](api/Phalcon_Acl) can be serialized and stored in a cache system to improve efficiency. You can store the serialized object in APC, session, file system, database, Redis etc. This way you can retrieve the ACL quickly without having to read the underlying data that create the ACL nor will you have to compute the ACL in every request.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;

$aclFile = 'app/security/acl.cache';
// Check whether ACL data already exist
if (true !== is_file($aclFile)) {

    // The ACL does not exist - build it
    $acl = new AclList();

    // ... Define roles, components, access, etc

    // Store serialized list into plain file
    file_put_contents($aclFile, serialize($acl));
} else {
    // Restore ACL object from serialized file
    $acl = unserialize(file_get_contents($aclFile));
}

// Use ACL list as needed
if (true === $acl->isAllowed('manager', 'admin', 'dashboard');) {
    echo 'Access granted!';
} else {
    echo 'Access denied :(';
}
```

It is a good practice to not use serialization of the ACL during development, to ensure that your ACL is built in every request, while other adapters or means of serializing and storing the ACL in production.