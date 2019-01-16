---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Events\Event'
---
# Class **Phalcon\Events\Event**

*implements* [Phalcon\Events\EventInterface](Phalcon_Events_EventInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/events/event.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This class offers contextual information of a fired event in the EventsManager


## Methods
public  **getType** ()

Event type



public  **getSource** ()

Event source



public  **getData** ()

Event data



public  **__construct** (*string* $type, *object* $source, [*mixed* $data], [*boolean* $cancelable])

Phalcon\Events\Event constructor



public  **setData** ([*mixed* $data])

Sets event data.



public  **setType** (*mixed* $type)

Sets event type.



public  **stop** ()

Stops the event preventing propagation.

```php
<?php

if ($event->isCancelable()) {
    $event->stop();
}

```



public  **isStopped** ()

Check whether the event is currently stopped.



public  **isCancelable** ()

Check whether the event is cancelable.

```php
<?php

if ($event->isCancelable()) {
    $event->stop();
}

```



