---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Events\Manager'
---
# Class **Phalcon\Events\Manager**

*implements* [Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/events/manager.zep)

El Administrador de Eventos Phalcon ofrece una manera fácil de interceptar y manipular, si es necesario, el flujo normal de operación. Con el EventsManager el desarrollador puede crear enlaces o plugins que ofrecerán monitoreo de la información, manipulación, ejecución condicional y mucho más.

## Métodos

public **attach** (*string* $eventType, *object* | *callable* $handler, [*int* $priority])

Adjunta un escucha al administrador de eventos

public **detach** (*string* $eventType, *object* $handler)

Separa el escucha del administrador de eventos

public **enablePriorities** (*mixed* $enablePriorities)

Establece si las prioridades están habilitadas en el EventsManager

public **arePrioritiesEnabled** ()

Devuelve si están habilitadas las propiedades

public **collectResponses** (*mixed* $collect)

Le indica al administrador de eventos si necesita recoger todas las respuestas devueltas por cada escucha registrado en una única activación

public **isCollecting** ()

Comprueba si el administrador de eventos está recogiendo todas las respuestas devueltas por cada escucha registrado en una única activación

public *array* **getResponses** ()

Devuelve todas las respuestas por cada controlador ejecutado por la activación ejecutada más reciente

public **detachAll** ([*mixed* $type])

Elimina todos los eventos del EventsManager

final public *mixed* **fireQueue** ([SplPriorityQueue](https://php.net/manual/en/class.splpriorityqueue.php) | *array* $queue, [Phalcon\Events\Event](Phalcon_Events_Event) $event)

El controlador interno para llamar una cola de eventos

public *mixed* **fire** (*string* $eventType, *object* $source, [*mixed* $data], [*boolean* $cancelable])

Activa un evento en el administrador de eventos, lo cual notifica a los escucha activos

```php
<?php

$eventsManager->fire("db", $connection);

```

public **hasListeners** (*mixed* $type)

Comprueba si un cierto tipo de evento tiene escuchas

public *array* **getListeners** (*string* $type)

Devuelve todos los escuchas adjuntos a un cierto tipo