---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Componente de Listas de Control de Acceso

* * *

## Serializando listas ACL

[Phalcon\Acl](api/Phalcon_Acl) puede ser serializado y almacenado en un sistema de caché para mejorar la eficiencia. Puede almacenar el objeto serializado en APC, sesión, sistema de archivos, base de datos, Redis, etc. De esta manera puede recuperar la ACL rápidamente sin tener que leer los datos subyacentes que crean la ACL ni tendrá que calcular la ACL en cada petición.

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;

$aclFile = 'app/security/acl.cache';
// Comprobar si los datos de la ACL ya existen
if (true !== is_file($aclFile)) {

    // La ACL no existe, crearla
    $acl = new AclList();

    // ... Definir roles, componentes, accesos, etc

    // Almacenar la lista serializada en un archivo plano
    file_put_contents($aclFile, serialize($acl));
} else {
    // Restaurar el objecto ACL desde el archivo serializado
    $acl = unserialize(file_get_contents($aclFile));
}

// Utilice la lista ACL como desee
if (true === $acl->isAllowed('manager', 'admin', 'dashboard');) {
    echo 'Access granted!';
} else {
    echo 'Access denied :(';
}
```

Es una buena práctica no utilizar serialización de la ACL durante el desarrollo, para garantizar que su ACL se construya en cada petición, mientras que otros adaptadores o medios de serialización y almacenamiento de la ACL se pueden utilizar en producción.