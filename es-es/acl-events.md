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

[Phalcon\Acl](api/Phalcon_Acl) puede trabajar junto con el [EventsManager](events) si está presente, para disparar eventos a tu aplicación. Los eventos se desencadenan mediante el tipo `acl`. Events that return `false` can stop the active role. Los siguientes eventos están disponibles:

| Nombre de evento    | Disparado                                                | Can stop role? |
| ------------------- | -------------------------------------------------------- |:--------------:|
| `afterCheckAccess`  | Triggered after checking if a role/component has access  |       No       |
| `beforeCheckAccess` | Triggered before checking if a role/component has access |       Si       |

En el ejemplo siguiente se muestra cómo adjuntar oyentes al ACL:

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

// ...

// Create an event manager
$eventsManager = new EventsManager();

// Attach a listener for type 'acl'
$eventsManager->attach(
    'acl:beforeCheckAccess',
    function (Event $event, $acl) {
        echo $acl->getActiveRole() . PHP_EOL;

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