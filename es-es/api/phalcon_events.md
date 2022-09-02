---
layout: default
language: 'es-es'
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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Events/Event.zep)

| Namespace | Phalcon\Events | | Implements | EventInterface |

Phalcon\Events\Event

Esta clase ofrece información contextual de un evento disparado en el `EventsManager`

```php
Phalcon\Events\Event;

$event = new Event("db:afterQuery", $this, ["data" => "mydata"], true);
if ($event->isCancelable()) {
    $event->stop();
}
```

## Propiedades

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

## Métodos

```php
public function __construct( string $type, object $source, mixed $data = null, bool $cancelable = bool );
```

Constructor Phalcon\Events\Event

```php
public function getData(): mixed
```

```php
public function getSource(): object
```

```php
public function getType(): string
```

```php
public function isCancelable(): bool;
```

Comprueba si el evento es cancelable.

```php
if ($event->isCancelable()) {
    $event->stop();
}
```

```php
public function isStopped(): bool;
```

Comprueba si el evento esta parado actualmente.

```php
public function setData( mixed $data = null ): EventInterface;
```

Establece datos del evento.

```php
public function setType( string $type ): EventInterface;
```

Establece el tipo de evento.

```php
public function stop(): EventInterface;
```

Detiene el evento evitando la propagación.

```php
if ($event->isCancelable()) {
    $event->stop();
}
```

<h1 id="events-eventinterface">Interface Phalcon\Events\EventInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Events/EventInterface.zep)

| Namespace | Phalcon\Events |

Phalcon\Events\EventInterface

Interfaz para la clase Phalcon\Events\Event

## Métodos

```php
public function getData(): mixed;
```

Obtiene los datos del evento

```php
public function getType(): mixed;
```

Obtiene el tipo de evento

```php
public function isCancelable(): bool;
```

Comprueba si el evento es cancelable

```php
public function isStopped(): bool;
```

Comprueba si el evento está parado actualmente

```php
public function setData( mixed $data = null ): EventInterface;
```

Establece los datos del evento

```php
public function setType( string $type ): EventInterface;
```

Establece el tipo de evento

```php
public function stop(): EventInterface;
```

Detiene el evento evitando la propagación

<h1 id="events-eventsawareinterface">Interface Phalcon\Events\EventsAwareInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Events/EventsAwareInterface.zep)

| Namespace | Phalcon\Events |

Phalcon\Events\EventsAwareInterface

Este interfaz debe ser para aquellas clases que acepten un EventsManager y despachan eventos

## Métodos

```php
public function getEventsManager(): ManagerInterface | null;
```

Devuelve el administrador de eventos interno

```php
public function setEventsManager( ManagerInterface $eventsManager ): void;
```

Establece el administrador de eventos

<h1 id="events-exception">Class Phalcon\Events\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Events/Exception.zep)

| Namespace | Phalcon\Events | | Extends | \Phalcon\Exception |

Phalcon\Events\Exception

Las excepciones lanzadas en Phalcon\Events usarán esta clase

<h1 id="events-manager">Class Phalcon\Events\Manager</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Events/Manager.zep)

| Namespace | Phalcon\Events | | Uses | Closure, SplPriorityQueue | | Implements | ManagerInterface |

Phalcon\Events\Manager

El Gestor de Eventos de Phalcon, ofrece una forma fácil de interceptar y manipular, si es necesario, el flujo normal de operación. Con el `EventsManager`, el desarrollador puede crear anclajes o plugins que ofrecerán monitorización de datos, manipulación, ejecución condicional y mucho más.

## Constantes

```php
const DEFAULT_PRIORITY = 100;
```

## Propiedades

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

## Métodos

```php
public function arePrioritiesEnabled(): bool;
```

Devuelve si las prioridades están habilitadas

```php
public function attach( string $eventType, mixed $handler, int $priority = static-constant-access ): void;
```

Adjunta un oyente al gestor de eventos

```php
public function collectResponses( bool $collect ): void;
```

Le dice al gestor de eventos si necesita recopilar todas las respuestas devueltas por cada oyente registrado en un único disparo

```php
public function detach( string $eventType, mixed $handler ): void;
```

Separa el oyente del gestor de eventos

```php
public function detachAll( string $type = null ): void;
```

Elimina todos los eventos del `EventsManager`

```php
public function enablePriorities( bool $enablePriorities ): void;
```

Establece si las prioridades están habilitadas en el `EventsManager`.

Una cola de prioridad de eventos es una estructura de datos similar a las colas regulares de eventos: también podemos añadir y sacar elementos de ella. La diferencia está en que cada elemento de una cola de prioridad está asociado a un valor llamado prioridad. Este valor se usa para ordenar los elementos de una cola: elementos con una prioridad mayor se sacan antes que los elementos con una prioridad menor.

```php
public function fire( string $eventType, object $source, mixed $data = null, bool $cancelable = bool );
```

Dispara un evento en el gestor de eventos que causa que los oyentes activos sean notificados al respecto

```php
$eventsManager->fire("db", $connection);
```

```php
final public function fireQueue( SplPriorityQueue $queue, EventInterface $event );
```

Gestor interno para llamar a una cola de eventos

```php
public function getListeners( string $type ): array;
```

Devuelve todos los oyentes adjuntos de cierto tipo

```php
public function getResponses(): array;
```

Devuelve todas las respuestas devueltas por cada manejador ejecutado por el último 'disparo' ejecutado

```php
public function hasListeners( string $type ): bool;
```

Comprueba si cierto tipo de evento tiene oyentes

```php
public function isCollecting(): bool;
```

Comprueba si el gestor de eventos está recopilando todas las respuestas devueltas por cada oyente registrado en un único disparo

```php
public function isValidHandler( mixed $handler ): bool;
```

<h1 id="events-managerinterface">Interface Phalcon\Events\ManagerInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Events/ManagerInterface.zep)

| Namespace | Phalcon\Events |

Phalcon\Events\ManagerInterface

Interfaz para gestores de Phalcon\Events.

## Métodos

```php
public function attach( string $eventType, mixed $handler ): void;
```

Adjunta un oyente al gestor de eventos

```php
public function detach( string $eventType, mixed $handler ): void;
```

Separa el oyente del gestor de eventos

```php
public function detachAll( string $type = null ): void;
```

Elimina todos los eventos del `EventsManager`

```php
public function fire( string $eventType, object $source, mixed $data = null, bool $cancelable = bool );
```

Dispara un evento en el gestor de eventos que causa que los oyentes activos sean notificados al respecto

```php
public function getListeners( string $type ): array;
```

Devuelve todos los oyentes adjuntos de cierto tipo

```php
public function hasListeners( string $type ): bool;
```

Comprueba si cierto tipo de evento tiene oyentes
