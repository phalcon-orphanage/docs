---
layout: default
language: 'ko-kr'
version: '4.0'
title: 'Phalcon\Events'
---

* [Phalcon\Events\Event](#events-event)
* [Phalcon\Events\EventInterface](#events-eventinterface)
* [Phalcon\Events\EventsAwareInterface](#events-eventsawareinterface)
* [Phalcon\Events\Exception](#events-exception)
* [Phalcon\Events\Manager](#events-manager)
* [Phalcon\Events\ManagerInterface](#events-managerinterface)

<h1 id="events-event">Class Phalcon\Events\Event</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Events/Event.zep)

| Namespace | Phalcon\Events | | Implements | EventInterface |

Phalcon\Events\Event

This class offers contextual information of a fired event in the EventsManager

```php
Phalcon\Events\Event;

$event = new Event("db:afterQuery", $this, ["data" => "mydata"], true);
if ($event->isCancelable()) {
    $event->stop();
}
```

## Properties

```php
/**
 * Is event cancelable?
 *
 * @var bool
 */
protected cancelable;

/**
 * Event data
 *
 * @var mixed
 */
protected data;

/**
 * Event source
 *
 * @var object
 */
protected source;

/**
 * Is event propagation stopped?
 *
 * @var bool
 */
protected stopped = false;

/**
 * Event type
 *
 * @var string
 */
protected type;

```

## Methods

Phalcon\Events\Event constructor

```php
public function __construct( string $type, object $source, mixed $data = null, bool $cancelable = bool );
```

```php
public function getData(): mixed
```

```php
public function getSource(): object
```

```php
public function getType(): string
```

Check whether the event is cancelable.

```php
if ($event->isCancelable()) {
    $event->stop();
}
```

```php
public function isCancelable(): bool;
```

Check whether the event is currently stopped.

```php
public function isStopped(): bool;
```

Sets event data.

```php
public function setData( mixed $data = null ): EventInterface;
```

Sets event type.

```php
public function setType( string $type ): EventInterface;
```

Stops the event preventing propagation.

```php
if ($event->isCancelable()) {
    $event->stop();
}
```

```php
public function stop(): EventInterface;
```

<h1 id="events-eventinterface">Interface Phalcon\Events\EventInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Events/EventInterface.zep)

| Namespace | Phalcon\Events |

Phalcon\Events\EventInterface

Interface for Phalcon\Events\Event class

## Methods

Gets event data

```php
public function getData(): mixed;
```

Gets event type

```php
public function getType(): mixed;
```

Check whether the event is cancelable

```php
public function isCancelable(): bool;
```

Check whether the event is currently stopped

```php
public function isStopped(): bool;
```

Sets event data

```php
public function setData( mixed $data = null ): EventInterface;
```

Sets event type

```php
public function setType( string $type ): EventInterface;
```

Stops the event preventing propagation

```php
public function stop(): EventInterface;
```

<h1 id="events-eventsawareinterface">Interface Phalcon\Events\EventsAwareInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Events/EventsAwareInterface.zep)

| Namespace | Phalcon\Events |

Phalcon\Events\EventsAwareInterface

This interface must for those classes that accept an EventsManager and dispatch events

## Methods

Returns the internal event manager

```php
public function getEventsManager(): ManagerInterface | null;
```

Sets the events manager

```php
public function setEventsManager( ManagerInterface $eventsManager ): void;
```

<h1 id="events-exception">Class Phalcon\Events\Exception</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Events/Exception.zep)

| Namespace | Phalcon\Events | | Extends | \Phalcon\Exception |

Phalcon\Events\Exception

Exceptions thrown in Phalcon\Events will use this class

<h1 id="events-manager">Class Phalcon\Events\Manager</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Events/Manager.zep)

| Namespace | Phalcon\Events | | Uses | Closure, SplPriorityQueue | | Implements | ManagerInterface |

Phalcon\Events\Manager

Phalcon Events Manager, offers an easy way to intercept and manipulate, if needed, the normal flow of operation. With the EventsManager the developer can create hooks or plugins that will offer monitoring of data, manipulation, conditional execution and much more.

## Constants

```php
const DEFAULT_PRIORITY = 100;
```

## Properties

```php
/**
 * @var bool
 */
protected collect = false;

/**
 * @var bool
 */
protected enablePriorities = false;

//
protected events;

//
protected responses;

```

## Methods

Returns if priorities are enabled

```php
public function arePrioritiesEnabled(): bool;
```

Attach a listener to the events manager

```php
public function attach( string $eventType, mixed $handler, int $priority = static-constant-access ): void;
```

Tells the event manager if it needs to collect all the responses returned by every registered listener in a single fire

```php
public function collectResponses( bool $collect ): void;
```

Detach the listener from the events manager

```php
public function detach( string $eventType, mixed $handler ): void;
```

Removes all events from the EventsManager

```php
public function detachAll( string $type = null ): void;
```

Set if priorities are enabled in the EventsManager

```php
public function enablePriorities( bool $enablePriorities ): void;
```

Fires an event in the events manager causing the active listeners to be notified about it

```php
$eventsManager->fire("db", $connection);
```

```php
public function fire( string $eventType, object $source, mixed $data = null, bool $cancelable = bool );
```

Internal handler to call a queue of events

```php
final public function fireQueue( SplPriorityQueue $queue, EventInterface $event );
```

Returns all the attached listeners of a certain type

```php
public function getListeners( string $type ): array;
```

Returns all the responses returned by every handler executed by the last 'fire' executed

```php
public function getResponses(): array;
```

Check whether certain type of event has listeners

```php
public function hasListeners( string $type ): bool;
```

Check if the events manager is collecting all all the responses returned by every registered listener in a single fire

```php
public function isCollecting(): bool;
```

<h1 id="events-managerinterface">Interface Phalcon\Events\ManagerInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Events/ManagerInterface.zep)

| Namespace | Phalcon\Events |

Phalcon\Events\ManagerInterface

Interface for Phalcon\Events managers.

## Methods

Attach a listener to the events manager

```php
public function attach( string $eventType, mixed $handler ): void;
```

Detach the listener from the events manager

```php
public function detach( string $eventType, mixed $handler ): void;
```

Removes all events from the EventsManager

```php
public function detachAll( string $type = null ): void;
```

Fires an event in the events manager causing the active listeners to be notified about it

```php
public function fire( string $eventType, object $source, mixed $data = null, bool $cancelable = bool );
```

Returns all the attached listeners of a certain type

```php
public function getListeners( string $type ): array;
```

Check whether certain type of event has listeners

```php
public function hasListeners( string $type ): bool;
```