---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Events\Event'
---
# Class **Phalcon\Events\Event**

*implements* [Phalcon\Events\EventInterface](Phalcon_Events_EventInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/events/event.zep)

This class offers contextual information of a fired event in the EventsManager

## Methoden

public **getType** ()

Ereignis Typ

public **getSource** ()

Ereignisquelle

public **getData** ()

Ereignisdaten

public **__construct** (*string* $type, *object* $source, [*mixed* $data], [*boolean* $cancelable])

Phalcon\Events\Event constructor

public **setData** ([*mixed* $data])

Legt Ereignisdaten fest.

public **setType** (*mixed* $type)

Legt den Ereignis Typ fest.

public **stop** ()

Stoppt die Ereignis Auslösung.

```php
<?php

if ($event->isCancelable()) {
    $event->stop();
}

```

public **isStopped** ()

Prüft, ob das Ereignis beendet ist.

public **isCancelable** ()

Prüft, ob das Ereignis abgebrochen werden kann.

```php
<?php

if ($event->isCancelable()) {
    $event->stop();
}

```