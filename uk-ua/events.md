---
layout: default
language: 'uk-ua'
version: '4.0'
title: 'Events Manager'
keywords: 'events, events manager, hooks'
---

# Events Manager

* * *

![](/assets/images/document-status-stable-success.svg)

## Overview

The purpose of this component is to intercept the execution of components in the framework by creating *hooks*. These hooks allow developers to obtain status information, manipulate data or change the flow of execution during the process of a component. The component consists of a [Phalcon\Events\Manager](Phalcon_Events#events-manager) that handles event propagation and execution of events. The manager contains various [Phalcon\Events\Event](Phalcon_Events#events-event) objects, which contain information about each hook/event.

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

$eventsManager = new EventsManager();

$eventsManager->attach(
    'db:afterQuery',
    function (Event $event, $connection) {
        echo $connection->getSQLStatement();
    }
);

$connection = new DbAdapter(
    [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'secret',
        'dbname'   => 'invo',
    ]
);

$connection->setEventsManager($eventsManager);
$connection->query(
    'SELECT * FROM products p WHERE p.status = 1'
);
```

## Naming Convention

Phalcon events use namespaces to avoid naming collisions. Each component in Phalcon occupies a different event namespace and you are free to create your own as you see fit. Event names are formatted as `component:event`. For example, as [Phalcon\Db](api/Phalcon_Db) occupies the `db` namespace, its `afterQuery` event's full name is `db:afterQuery`.

When attaching event listeners to the events manager, you can use `component` to catch all events from that component (eg. `db` to catch all of the [Phalcon\Db](api/Phalcon_Db) events) or `component:event` to target a specific event (eg. `db:afterQuery`).

## Manager

The [Phalcon\Events\Manager](Phalcon_Events#events-manager) is the main component that handles all the events in Phalcon. Different implementations in other frameworks refer to this component as *a handler*. Regardless of the name, the functionality and purpose are the same.

The component wraps a queue of objects using [SplPriorityQueue](https://www.php.net/manual/en/class.splpriorityqueue.php) internally. It registers those objects with a priority (default `100`) and then when the time comes, executes them.

The methods exposed by the manager are:

```php
public function attach(
    string $eventType, 
    mixed $handler, 
    int $priority = self::DEFAULT_PRIORITY
)
```

Attaches a listener to the events manager. The `handler` is an object or a `callable`.

```php
public function arePrioritiesEnabled(): bool
```

Returns if priorities are enabled

```php
public function collectResponses(bool $collect)
```

Tells the event manager if it needs to collect all the responses returned by every registered listener in a single `fire` call

```php
public function detach(string $eventType, mixed $handler)
```php
Detach the listener from the events manager

```php
public function detachAll(string $type = null)
```

Removes all events from the EventsManager

```php
public function enablePriorities(bool $enablePriorities)
```

Set if priorities are enabled in the events manager (default `false`).

```php
public function fire(string $eventType, mixed $source, mixed $data = null, bool $cancelable = true)
```

Fires an event in the events manager causing the active listeners to be notified about it

```php
final public function fireQueue(SplPriorityQueue $queue, EventInterface $event): mixed
 ```
Internal handler to call a queue of events

```php
public function getListeners(string $type): array
```

Returns all the attached listeners of a certain type

```php
public function getResponses(): array
```

Returns all the responses returned by every handler executed by the last `fire` executed

```php
public function hasListeners(string $type): bool
```

Check whether certain type of event has listeners

```php
public function isCollecting(): bool
```

Check if the events manager is collecting all all the responses returned by every registered listener in a single `fire`

## Usage

If you are using the [Phalcon\Di\FactoryDefault](api/Phalcon_Di#di-factorydefault) DI container, the [Phalcon\Events\Manager](Phalcon_Events#events-manager) is already registered for you with the name `eventsManager`. This is a *global* events manager. However you are not restricted to use only that one. You can always create a separate manager to handle events for any component that you require.

The following example shows how you can create a query logging mechanism using the *global* events manager:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Events\Event;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

$container     = Di::getDefault();
$eventsManager = $container->get('eventsManager');

$eventsManager->attach(
    'db:afterQuery',
    function (Event $event, $connection) {
        echo $connection->getSQLStatement();
    }
);

$connection = new DbAdapter(
    [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'secret',
        'dbname'   => 'invo',
    ]
);

$connection->setEventsManager($eventsManager);
$connection->query(
    'SELECT * FROM products p WHERE p.status = 1'
);
```

or if you want a separate events manager:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

$eventsManager = new EventsManager();
$eventsManager->attach(
    'db:afterQuery',
    function (Event $event, $connection) {
        echo $connection->getSQLStatement();
    }
);

$connection = new DbAdapter(
    [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'secret',
        'dbname'   => 'invo',
    ]
);

$connection->setEventsManager($eventsManager);
$connection->query(
    'SELECT * FROM products p WHERE p.status = 1'
);
```

In the above example, we are using the events manager to listen to the `afterQuery` event produced by the `db` service, in this case MySQL. We use the `attach` method to attach our event to the manager and use the `db:afterQuery` event. We add an anonymous function as the handler for this event, which accepts a [Phalcon\Events\Event](Phalcon_Events#events-event) as the first parameter. This object contains contextual information regarding the event that has been fired. The database connection object as the second. Using the connection variable we print out the SQL statement. You can always pass a third parameter with arbitrary data specific to the event, or even a logger object in the anonymous function so that you can log your queries in a separate log file.

> You must explicitly set the Events Manager to a component using the `setEventsManager()` method in order for that component to trigger events. You can create a new Events Manager instance for each component or you can set the same Events Manager to multiple components as the naming convention will avoid conflicts
{: .alert .alert-warning }
  
## Handlers

The events manager wires a handler to an event. A handler is a piece of code that will do something when the event fires. As seen in the above example, you can use an anonymous function as your handler:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

$eventsManager = new EventsManager();
$eventsManager->attach(
    'db:afterQuery',
    function (Event $event, $connection) {
        echo $connection->getSQLStatement();
    }
);

$connection = new DbAdapter(
    [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'secret',
        'dbname'   => 'invo',
    ]
);

$connection->setEventsManager($eventsManager);
$connection->query(
    'SELECT * FROM products p WHERE p.status = 1'
);
```

You can also create a *listener* class, which offers more flexibility. In a listener, you can listen to multiple events and even extend \[Phalcon\Di\Injectable\]\[di-injectable\] which will give you fill access to the services of the Di container. The example above can be enhanced by implementing the following listener:

```php
<?php

namespace MyApp\Listeners;

use Phalcon\Logger;
use Phalcon\Config;
use Phalcon\Db\AdapterInterface;
use Phalcon\Di\Injectable;
use Phalcon\Events\Event;

/**
 * Class QueryListener
 *
 * @property Config $config
 * @property Logger $logger
 */
class QueryListener extends Injectable
{
    /**
     * Fires before a query is executed
     *
     * @param Event $event
     * @param AdapterInterface $connection
     */
    public function beforeQuery(Event $event, AdapterInterface $connection)
    {
        if ($this->config->path('app.logLevel') > 1) {
            $this->logger->info(
                sprintf(
                    '%s - [%s]',
                    $connection->getSQLStatement(),
                    json_encode($connection->getSQLVariables())
                )
            );
        }
    }

    /**
     * Fires when we have a rollback
     *
     * @param Event $event
     */
    public function rollbackTransaction(Event $event)
    {
        if ($this->config->path('app.logLevel') > 1) {
            $this->logger->warning($event->getType());
        }
    }
}
```

Attaching the listener to our events manager is very simple:

```php
<?php

$eventsManager->attach(
    'db',
    new QueryListener()
);
```

The resulting behavior will be that if the `app.logLevel` configuration variable is set to greater than `1` (representing that we are in development mode), all queries will be logged along with the actual parameters that were bound to each query. Additionally we will log every time we have a rollback in a transaction.

Another handy listener is the `404` one:

```php
<?php

namespace MyApp\Listeners\Dispatcher;

use Phalcon\Logger;
use Phalcon\Di\Injectable;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use MyApp\Auth\Adapters\AbstractAdapter;

/**
 * Class NotFoundListener
 *
 * @property AbstractAdapter $auth
 * @property Logger          $logger
 */
class NotFoundListener extends Injectable
{
    /**
     * This action is executed before execute any action in the application
     *
     * @param Event      $event
     * @param Dispatcher $disp
     * @param \Exception $ex
     *
     * @return bool
     */
    public function beforeException(
        Event $event, 
        Dispatcher $dispatcher, 
        \Exception $ex
    ) {
        switch ($ex->getCode()) {
            case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
            case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                $dispatcher->setModuleName('main');
                $params = [
                    'namespace'  => 'MyApp\Controllers',
                    'controller' => 'session',
                    'action'     => 'fourohfour',
                ];

                /**
                 * 404 not logged in
                 */
                if (true !== $this->auth->isLoggedIn()) {
                    $params['action'] = 'login';
                }

                $dispatcher->forward($params);

                return false;
            default:
                $this->logger->error($ex->getMessage());
                $this->logger->error($ex->getTraceAsString());

                return false;
        }
    }
}
```

and attaching it to the events manager:

```php
<?php

$eventsManager->attach(
    'dispatch:beforeException',
    new NotFoundListener(),
    200
);
```

First we attach the listener to the `dispatcher` component and the `beforeException` event. This means that the events manager will fire only for that event calling our listener. We could have just changed the hook point to `dispatcher` so that we are able in the future to add more dispatcher events in the same listener.

The `beforeException` function accepts the `$event` as the first parameter, the `$dispatcher` as the second and the `$ex` exception thrown from the dispatcher component. Using those, we can then figure out if a handler (or controller) or an action were not found. If that is the case, we forward the user to a specific modle, controller and action. If our user is not logged in, then we send them to the login page. Alternatively, we just log the exception message in our logger.

The example demonstrates clearly the power of the events manager, and how you can alter the flow of the application using listeners.

## Events: Trigger

You can create components in your application that trigger events to an events manager. Listeners attached to those events will be invoked when the events are fired. In order to create a component that triggers events, we need to implement the [Phalcon\Events\EventsAwareInterface](Phalcon_Events#events-eventsawareinterface).

### Custom Component

Let's consider the following example:

```php
<?php

namespace MyApp\Components;

use Phalcon\Di\Injectable;
use Phalcon\Events\EventsAwareInterface;
use Phalcon\Events\ManagerInterface;

/**
 * @property Logger $logger
 */
class NotificationsAware extends Injectable implements EventsAwareInterface
{
    protected $eventsManager;

    /**
     * Returns the events manager
     */
    public function getEventsManager()
    {
        return $this->eventsManager;
    }

    /**
     * Sets the events manager
     *
     * @property ManagerInterface\ $eventsManager
     */
    public function setEventsManager(ManagerInterface $eventsManager)
    {
        $this->eventsManager = $eventsManager;
    }


    public function process()
    {
        $this->eventsManager->fire('notifications:beforeSend', $this);

        $this->logger->info('Processing.... ');

        $this->eventsManager->fire('notifications:afterSend', $this);
    }
}
```

The above component implements the [Phalcon\Events\EventsAwareInterface](Phalcon_Events#events-eventsawareinterface) and as a result it uses the `getEventsManager` and `setEventsManager`. The last method is what does the work. In this example we want to send some notifications to users and want to fire an event before and after the notification is sent.

We chose to name the component `notification` and the events are called `beforeSend` and `afterSend`. In the `process` method, you can add any code you need in between the calls to fire the relevant events. Additionally, you can inject more data in this component that would help with your implementation and processing of the notifications.

### Custom Listener

Now we need to create a listener for this component:

```php
<?php

namespace MyApp\Listeners;

use Phalcon\Events\Event;
use Phalcon\Logger;

/**
 * @property Logger $logger
 */
class MotificationsListener
{
    /**
     * @var Logger
     */
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function afterSend(
        Event $event, 
        NotificationsAware $component
    ) {
        $this->logger->info('After Notification');
    }

    public function beforeSend(
        Event $event, 
        NotificationsAware $component
    ) {
        $this->logger->info('Before Notification');
    }
}
```

Putting it all together

```php
<?php

use MyApp\Components\NotificationAware;
use MyApp\Listeners\MotificationsListener;
use Phalcon\Events\Manager as EventsManager;

$eventsManager = new EventsManager();
$component     = new NotificationAware();

$component->setEventsManager($eventsManager);

$eventsManager->attach(
    'notifications',
    new NotificationsListener()
);

$component->process();
```

When `process` is executed, the two methods in the listener will be executed. Your log will then have the following entries:

```txt
[2019-12-25 01:02:03][INFO] Before Notification
[2019-12-25 01:02:03][INFO] Processing...
[2019-12-25 01:02:03][INFO] After Notification
```

### Custom Data

Additional data may also be passed when triggering an event using the third parameter of `fire()`:

```php
<?php

$data = [
    'name'     => 'Darth Vader',
    'password' => '12345',
];

$eventsManager->fire('notifications:afterSend', $this, $data);
```

In a listener the third parameter also receives data:

```php
<?php

use Phalcon\Events\Event;

$data = [
    'name'     => 'Darth Vader',
    'password' => '12345',
];

$eventsManager->attach(
    'notifications',
    function (Event $event, $component, $data) {
        print_r($data);
    }
);

$eventsManager->attach(
    'notifications',
    function (Event $event, $component) {
        print_r($event->getData());
    }
);
```

## Propagation

An events manager can have multiple listeners attached to it. Once an event fires, all listeners that can be notified for the particular event will be notified. This is the default behavior but can be altered if need be by stopping the propagation early:

```php
<?php

use Phalcon\Events\Event;

$eventsManager->attach(
    'db',
    function (Event $event, $connection) {
        if ('2019-01-01' < date('Y-m-d')) {
            $event->stop();
        }
    }
);
```

In the above simple example, we stop all events if today is earlier than `2019-01-01`.

## Cancellation

By default all events are cancellable. However you might want to set a particular event to not be cancellable, allowing the particular event to fire on all available listeners that implement it.

```php
<?php

use Phalcon\Events\Event;

$eventsManager->attach(
    'db',
    function (Event $event, $connection) {
        if ($event->isCancelable()) {
            $event->stop();
        }
    }
);
```

In the above example, if the event is cancellable, we will stop propagation. You can set a particular event to **not** be cancellable by utilizing the fourth parameter of `fire()`:

```php
<?php

$eventsManager->fire('notifications:afterSend', $this, $data, false);
```

The `afterSend` event will no longer be cancellable and will execute on all listeners that implement it.

## Priorities

When attaching listeners you can set a specific priority. Setting up priorities when attaching listeners to your events manager defines the order in which they are called:

```php
<?php

use Phalcon\Events\Manager as EventsManager;

$eventsManager = new EventsManager();

$eventsManager->enablePriorities(true);

$eventsManager->attach(
    'db', 
    new QueryListener(), 
    150
);
$eventsManager->attach(
    'db', 
    new QueryListener(), 
    100
);
$eventsManager->attach(
    'db', 
    new QueryListener(), 
    50
); 
```

> In order for the priorities to work `enablePriorities()` has to be called with `true` so as to enable them. Priorities are disabled by default
{: .alert .alert-info }

> 
> A high priority number means that the listener will be processed before those with lower priorities
{: .alert .alert-warning }

## Responses

The events manager can also collect any responses returned by each event and return them back using the `getResponses()` method. The method returns an array with the responses:

```php
<?php

use Phalcon\Events\Manager as EventsManager;

$eventsManager = new EventsManager();

$eventsManager->collectResponses(true);

$eventsManager->attach(
    'custom:custom',
    function () {
        return 'first response';
    }
);

$eventsManager->attach(
    'custom:custom',
    function () {
        return 'second response';
    }
);

$eventsManager->fire('custom:custom', null);

print_r($eventsManager->getResponses());
```

The above example produces:

```bash
[
    0 => 'first response',
    1 => 'second response',
]
```

> In order for the priorities to work `collectResponses()` has to be called with `true` so as to enable collecting them.
{: .alert .alert-info }

## Exception

Any exceptions thrown in the Paginator component will be of type [Phalcon\Events\Exception](Phalcon_Events#events-exception). You can use this exception to selectively catch exceptions thrown only from this component.

```php
<?php

use Phalcon\Events\EventsManager;
use Phalcon\Events\Exception;

try {

    $eventsManager = new EventsManager();

    $eventsManager->attach('custom:custom', true);
} catch (Exception $ex) {
    echo $ex->getMessage();
}
```

## Custom

The [Phalcon\Events\ManagerInterface](Phalcon_Events#events-managerinterface) interface must be implemented to create your own events manager replacing the one provided by Phalcon.

```php
<?php

namespace MyApp\Events;

use Phalcon\Events\ManagerInterface;

class EventsManager implements ManagerInterface
{
    /**
     * Attach a listener to the events manager
     *
     * @param string          $eventType
     * @param object|callable $handler
     */
    public function attach(string $eventType, $handler);

    /**
     * Detach the listener from the events manager
     *
     * @param string          $eventType
     * @param object|callable $handler
     */
    public function detach(string $eventType, $handler;

    /**
     * Removes all events from the EventsManager
     * 
     * @param string $type
     */
    public function detachAll(string $type = null);

    /**
     * Fires an event in the events manager causing the active 
     * listeners to be notified about it
     *
     * @param string $eventType
     * @param object $source
     * @param mixed  $data
     * @param mixed  $cancelable
     * 
     * @return mixed
     */
    public function fire(
        string $eventType, 
        $source, 
        $data = null, 
        bool $cancelable = false
    );

    /**
     * Returns all the attached listeners of a certain type
     *
     * @param string $type
     *
     * @return array
     */
    public function getListeners(string $type): array;

    /**
     * Check whether certain type of event has listeners
     *
     * @param string $type
     *
     * @return bool
     */
    public function hasListeners(string $type): bool;
}
```

## List of Events

The events available in Phalcon are:

| Component                       | Event                                |
| ------------------------------- | ------------------------------------ |
| [ACL](acl)                      | `acl:afterCheckAccess`               |
| [ACL](acl)                      | `acl:beforeCheckAccess`              |
| [Application](application)      | `application:afterHandleRequest`     |
| [Application](application)      | `application:afterStartModule`       |
| [Application](application)      | `application:beforeHandleRequest`    |
| [Application](application)      | `application:beforeSendResponse`     |
| [Application](application)      | `application:beforeStartModule`      |
| [Application](application)      | `application:boot`                   |
| [Application](application)      | `application:viewRender`             |
| [CLI](application-cli)          | `dispatch:beforeException`           |
| [Console](application-cli)      | `console:afterHandleTask`            |
| [Console](application-cli)      | `console:afterStartModule`           |
| [Console](application-cli)      | `console:beforeHandleTask`           |
| [Console](application-cli)      | `console:beforeStartModule`          |
| [Console](application-cli)      | `console:boot`                       |
| [Db](db-layer)                  | `db:afterQuery`                      |
| [Db](db-layer)                  | `db:beforeQuery`                     |
| [Db](db-layer)                  | `db:beginTransaction`                |
| [Db](db-layer)                  | `db:createSavepoint`                 |
| [Db](db-layer)                  | `db:commitTransaction`               |
| [Db](db-layer)                  | `db:releaseSavepoint`                |
| [Db](db-layer)                  | `db:rollbackTransaction`             |
| [Db](db-layer)                  | `db:rollbackSavepoint`               |
| [Dispatcher](dispatcher)        | `dispatch:afterExecuteRoute`         |
| [Dispatcher](dispatcher)        | `dispatch:afterDispatch`             |
| [Dispatcher](dispatcher)        | `dispatch:afterDispatchLoop`         |
| [Dispatcher](dispatcher)        | `dispatch:afterInitialize`           |
| [Dispatcher](dispatcher)        | `dispatch:beforeException`           |
| [Dispatcher](dispatcher)        | `dispatch:beforeExecuteRoute`        |
| [Dispatcher](dispatcher)        | `dispatch:beforeDispatch`            |
| [Dispatcher](dispatcher)        | `dispatch:beforeDispatchLoop`        |
| [Dispatcher](dispatcher)        | `dispatch:beforeForward`             |
| [Dispatcher](dispatcher)        | `dispatch:beforeNotFoundAction`      |
| [Loader](loader)                | `loader:afterCheckClass`             |
| [Loader](loader)                | `loader:beforeCheckClass`            |
| [Loader](loader)                | `loader:beforeCheckPath`             |
| [Loader](loader)                | `loader:pathFound`                   |
| [Micro](application-micro)      | `micro:afterHandleRoute`             |
| [Micro](application-micro)      | `micro:afterExecuteRoute`            |
| [Micro](application-micro)      | `micro:beforeExecuteRoute`           |
| [Micro](application-micro)      | `micro:beforeHandleRoute`            |
| [Micro](application-micro)      | `micro:beforeNotFound`               |
| [Middleware](application-micro) | `micro::afterBinding`                |
| [Middleware](application-micro) | `micro::afterExecuteRoute`           |
| [Middleware](application-micro) | `micro::afterHandleRoute`            |
| [Middleware](application-micro) | `micro::beforeExecuteRoute`          |
| [Middleware](application-micro) | `micro::beforeHandleRoute`           |
| [Middleware](application-micro) | `micro::beforeNotFound`              |
| [Model](db-models)              | `model:afterCreate`                  |
| [Model](db-models)              | `model:afterDelete`                  |
| [Model](db-models)              | `model:afterSave`                    |
| [Model](db-models)              | `model:afterUpdate`                  |
| [Model](db-models)              | `model:afterValidation`              |
| [Model](db-models)              | `model:afterValidationOnCreate`      |
| [Model](db-models)              | `model:afterValidationOnUpdate`      |
| [Model](db-models)              | `model:beforeDelete`                 |
| [Model](db-models)              | `model:notDeleted`                   |
| [Model](db-models)              | `model:beforeCreate`                 |
| [Model](db-models)              | `model:beforeDelete`                 |
| [Model](db-models)              | `model:beforeSave`                   |
| [Model](db-models)              | `model:beforeUpdate`                 |
| [Model](db-models)              | `model:beforeValidation`             |
| [Model](db-models)              | `model:beforeValidationOnCreate`     |
| [Model](db-models)              | `model:beforeValidationOnUpdate`     |
| [Model](db-models)              | `model:notSave`                      |
| [Model](db-models)              | `model:notSaved`                     |
| [Model](db-models)              | `model:onValidationFails`            |
| [Model](db-models)              | `model:prepareSave`                  |
| [Models Manager](db-models)     | `modelsManager:afterInitialize`      |
| [Request](request)              | `request:afterAuthorizationResolve`  |
| [Request](request)              | `request:beforeAuthorizationResolve` |
| [Response](response)            | `response:afterSendHeaders`          |
| [Response](response)            | `response:beforeSendHeaders`         |
| [Router](routing)               | `router:beforeCheckRoutes`           |
| [Router](routing)               | `router:beforeCheckRoute`            |
| [Router](routing)               | `router:matchedRoute`                |
| [Router](routing)               | `router:notMatchedRoute`             |
| [Router](routing)               | `router:afterCheckRoutes`            |
| [Router](routing)               | `router:beforeMount`                 |
| [View](view)                    | `view:afterRender`                   |
| [View](view)                    | `view:afterRenderView`               |
| [View](view)                    | `view:beforeRender`                  |
| [View](view)                    | `view:beforeRenderView`              |
| [View](view)                    | `view:notFoundView`                  |
| [Volt](volt)                    | `compileFilter`                      |
| [Volt](volt)                    | `compileFunction`                    |
| [Volt](volt)                    | `compileStatement`                   |
| [Volt](volt)                    | `resolveExpression`                  |