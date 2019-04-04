---
layout: default
language: 'tr-tr'
version: '4.0'
upgrade: '#acl'
category: 'acl'
---
# Access Control Lists Component

* * *

## Olaylar

[Phalcon\Acl](api/Phalcon_Acl) can work in conjunction with the [EventsManager](events) if present, to fire events to your application. Events are triggered using the type `acl`. Events that return `false` can stop the active role. The following events are available:

| Olay Adı            | Tetiklendi                                               | Can stop role? |
| ------------------- | -------------------------------------------------------- |:--------------:|
| `afterCheckAccess`  | Triggered after checking if a role/component has access  |     Hayır      |
| `beforeCheckAccess` | Triggered before checking if a role/component has access |      Evet      |

The following example demonstrates how to attach listeners to the ACL:

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

// Setup the $acl
// ...

// Bind the eventsManager to the ACL component
$acl->setEventsManager($eventsManager);
```