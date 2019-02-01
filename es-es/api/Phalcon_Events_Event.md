---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Events\Event'
---
# Class **Phalcon\Events\Event**

*implements* [Phalcon\Events\EventInterface](Phalcon_Events_EventInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/events/event.zep)

Esta clase ofrece información contextual de un evento activado en el EventsManager

## Métodos

public **getType** ()

Tipo de evento

public **getSource** ()

Fuente del evento

public **getData** ()

Información del evento

public **__construct** (*string* $type, *object* $source, [*mixed* $data], [*boolean* $cancelable])

Phalcon\Events\Event constructor

public **setData** ([*mixed* $data])

Configura la información del evento.

public **setType** (*mixed* $type)

Configura el tipo de evento.

public **stop** ()

Detiene el evento que evita la propagación.

```php
<?php

if ($event->isCancelable()) {
    $event->stop();
}

```

public **isStopped** ()

Comprueba si el evento está actualmente detenido.

public **isCancelable** ()

Comprueba si el evento se puede cancelar.

```php
<?php

if ($event->isCancelable()) {
    $event->stop();
}

```