---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Componente de Listas de Control de Acceso

* * *

## Eventos

[Phalcon\Acl](api/Phalcon_Acl) puede trabajar junto con el [EventsManager](events) si está presente, para disparar eventos a tu aplicación. Los eventos se desencadenan mediante el tipo `acl`. Los eventos que devuelven `false` pueden detener el rol activo. Los siguientes eventos están disponibles:

| Nombre de evento    | Disparado                                                        | ¿Puede detener el rol? |
| ------------------- | ---------------------------------------------------------------- |:----------------------:|
| `afterCheckAccess`  | Lanzado después de comprobar si un rol o componente tiene acceso |           No           |
| `beforeCheckAccess` | Lanzado antes de comprobar si un rol o componente tiene acceso   |           Si           |

En el ejemplo siguiente se muestra cómo adjuntar oyentes al ACL:

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

// ...

// Crear un gestor de eventos
$eventsManager = new EventsManager();

// Adjuntar un oyente de tipo 'acl'
$eventsManager->attach(
    'acl:beforeCheckAccess',
    function (Event $event, $acl) {
        echo $acl->getActiveRol() . PHP_EOL;

        echo $acl->getActiveComponent() . PHP_EOL;

        echo $acl->getActiveAccess() . PHP_EOL;
    }
);

$acl = new AclList();

// Configurar el $acl
// ...

// Vincular el eventsManager al componente ACL
$acl->setEventsManager($eventsManager);
```