---
layout: default
title: 'Events Manager'
upgrade: '#events'
keywords: 'events, events manager, hooks'
---

# Events Manager
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## 개요
The purpose of this component is to intercept the execution of components in the framework by creating _hooks_. These hooks allow developers to obtain status information, manipulate data or change the flow of execution during the process of a component. The component consists of a [Phalcon\Events\Manager][events-manager] that handles event propagation and execution of events. The manager contains various [Phalcon\Events\Event][events-event] objects, which contain information about each hook/event.

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
Phalcon events use namespaces to avoid naming collisions. Each component in Phalcon occupies a different event namespace, and you are free to create your own as you see fit. Event names are formatted as `component:event`. For example, as [Phalcon\Db][db] occupies the `db` namespace, its `afterQuery` event's full name is `db:afterQuery`.

When attaching event listeners to the events manager, you can use `component` to catch all events from that component (e.g. `db` to catch all the [Phalcon\Db][db] events) or `component:event` to target a specific event (eg. `db:afterQuery`).

## Manager
The [Phalcon\Events\Manager][events-manager] is the main component that handles all the events in Phalcon. Different implementations in other frameworks refer to this component as _a handler_. Regardless of the name, the functionality and purpose are the same.

The component wraps a queue of objects using [SplPriorityQueue][splpriorityqueue] internally. It registers those objects with a priority (default `100`) and then when the time comes, executes them.

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
```
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
Check if the events manager is collecting all the responses returned  by every registered listener in a single `fire`

```php
public function isValidHandler(object | callable handler): bool
```
Check if the handler is an object or a callable

## 사용
If you are using the [Phalcon\Di\FactoryDefault][di-factorydefaul] DI container, the [Phalcon\Events\Manager][events-manager] is already registered for you with the name `eventsManager`. This is a _global_ events manager. However, you are not restricted to use only that one. You can always create a separate manager to handle events for any component that you require.

The following example shows how you can create a query logging mechanism using the _global_ events manager:

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

In the above example, we are using the events manager to listen to the `afterQuery` event produced by the `db` service, in this case MySQL. We use the `attach` method to attach our event to the manager and use the `db:afterQuery` event. We add an anonymous function as the handler for this event, which accepts a [Phalcon\Events\Event][events-event] as the first parameter. This object contains contextual information regarding the event that has been fired. The database connection object as the second. Using the connection variable we print out the SQL statement. You can always pass a third parameter with arbitrary data specific to the event, or even a logger object in the anonymous function so that you can log your queries in a separate log file.

> **NOTE**: You must explicitly set the Events Manager to a component using the `setEventsManager()` method in order for that component to trigger events. You can create a new Events Manager instance for each component, or you can set the same Events Manager to multiple components as the naming convention will avoid conflicts 
> 
> {: .alert .alert-warning }

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

You can also create a _listener_ class, which offers more flexibility. In a listener, you can listen to multiple events and even extend \[Phalcon\Di\Injectable\]\[di-injectable\] which will give you fill access to the services of the Di container. The example above can be enhanced by implementing the following listener:

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

The resulting behavior will be that if the `app.logLevel` configuration variable is set to greater than `1` (representing that we are in development mode), all queries will be logged along with the actual parameters that were bound to each query. Additionally, we will log every time we have a rollback in a transaction.

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

The `beforeException` function accepts the `$event` as the first parameter, the `$dispatcher` as the second and the `$ex` exception thrown from the dispatcher component. Using those, we can then figure out if a handler (or controller) or an action were not found. If that is the case, we forward the user to a specific module, controller and action. If our user is not logged in, then we send them to the login page. Alternatively, we just log the exception message in our logger.

The example demonstrates clearly the power of the events manager, and how you can alter the flow of the application using listeners.

## Events: Trigger
You can create components in your application that trigger events to an events manager. Listeners attached to those events will be invoked when the events are fired. In order to create a component that triggers events, we need to implement the [Phalcon\Events\EventsAwareInterface][events-eventsawareinterface].

### Custom Component
Let's consider the following example:

```php
<?php

namespace MyApp\Components;

use Phalcon\Di\Injectable;
use Phalcon\Events\EventsAwareInterface;
use Phalcon\Events\ManagerInterface;

/**
 * @property ManagerInterface $eventsManager
 * @property Logger           $logger
 */
class NotificationsAware extends Injectable implements EventsAwareInterface
{
    protected $eventsManager;

    public function getEventsManager()
    {
        return $this->eventsManager;
    }

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

The above component implements the [Phalcon\Events\EventsAwareInterface][events-eventsawareinterface] and as a result it uses the `getEventsManager` and `setEventsManager`. The last method is what does the work. In this example we want to send some notifications to users and want to fire an event before and after the notification is sent.

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
By default, all events are cancelable. However, you might want to set a particular event to not be cancelable, allowing the particular event to fire on all available listeners that implement it.

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

In the above example, if the event is cancelable, we will stop propagation. You can set a particular event to **not** be cancelable by utilizing the fourth parameter of `fire()`:

```php
<?php

$eventsManager->fire('notifications:afterSend', $this, $data, false);
```

The `afterSend` event will no longer be cancelable and will execute on all listeners that implement it.

> **NOTE**: You can stop the execution by returning `false` in your event (but not always). For instance, if you attach an event to `dispatch:beforeDispatchLoop` and your listener returns `false` the dispatch process will be halted. This is true if you only have **one listener** listening to the `dispatch:beforeDispatchLoop` event which returns `false`. If two listeners are attached to the event and the second one that executes returns `true` then the process will continue. If you wish to stop any subsequent events from firing, you will have to issue a `stop()` in your listener on the Event object. 
> 
> {: .alert .alert-warning }

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

> **NOTE**: In order for the priorities to work `enablePriorities()` has to be called with `true` to enable them. Priorities are disabled by default 
> 
> {: .alert .alert-info }

> **NOTE**: A high priority number means that the listener will be processed before those with lower priorities 
> 
> {: .alert .alert-warning }

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

$eventsManager->fire('custom:custom', $eventsManager, null);

print_r($eventsManager->getResponses());
```

The above example produces:

```bash
[
    0 => 'first response',
    1 => 'second response',
]
```

> **NOTE**: In order for the priorities to work `collectResponses()` has to be called with `true` to enable collecting them. 
> 
> {: .alert .alert-info }

## Exceptions
Any exceptions thrown in the Paginator component will be of type [Phalcon\Events\Exception][events-exception]. You can use this exception to selectively catch exceptions thrown only from this component.

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

## 컨트롤러
Controllers act as listeners already registered in the events manager. As a result, you only need to create a method with the same name as a registered event, and it will be fired.

For instance if we want to send a user to the `/login` page if they are not logged in, we can add the following code in our master controller:

```php
<?php

namespace MyApp\Controller;

use Phalcon\Logger;
use Phalcon\Dispatcher;
use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;
use MyApp\Auth\Adapters\AbstractAdapter;

/**
 * Class BaseController
 *
 * @property AbstractAdapter $auth
 * @property Logger          $logger
 * @property Response        $response
 */
class BaseController extends Controller
{
    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        /**
         * Send them to the login page if no identity exists
         */
        if (true !== $this->auth->isLoggedIn()) {
            $this->response->redirect(
                '/login',
                true
            );

            return false;
        }

        return true;
    }
}
```
Execute the code before the router, so we can determine if the user is logged in or not. If not, forward them to the login page.

## 모델
Similar to Controllers, Models also act as listeners already registered in the events manager. As a result, you only need to create a method with the same name as a registered event, and it will be fired.

In the following example, we are use the `beforeCreate` event, to automatically calculate an invoice number:

```php
<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;

use function str_pad;

/**
 * Class Invoices
 *
 * @property string $inv_created_at
 * @property int    $inv_cst_id
 * @property int    $inv_id
 * @property string $inv_number
 * @property string $inv_title
 * @property float  $inv_total
 */
class Invoices extends Model
{
    /**
     * @var int
     */
    public $inv_cst_id;

    /**
     * @var string
     */
    public $inv_created_at;

    /**
     * @var int
     */
    public $inv_id;

    /**
     * @var string
     */
    public $inv_number;

    /**
     * @var string
     */
    public $inv_title;

    /**
     * @var float
     */
    public $inv_total;

    public function beforeCreate()
    {
        $date     = date('YmdHis');
        $customer = substr(
            str_pad(
                $this->inv_cst_id, 6, '0', STR_PAD_LEFT
            ),
            -6
        );

        $this->inv_number = 'INV-' . $customer . '-' . $date;
    }
}
```

## Custom
The [Phalcon\Events\ManagerInterface][events-managerinterface] interface must be implemented to create your own events manager replacing the one provided by Phalcon.

```php
<?php

namespace MyApp\Events;

use Phalcon\Events\ManagerInterface;

class EventsManager implements ManagerInterface
{
    /**
     * @param string          $eventType
     * @param object|callable $handler
     */
    public function attach(string $eventType, $handler);

    /**
     * @param string          $eventType
     * @param object|callable $handler
     */
    public function detach(string $eventType, $handler);

    /**
     * @param string $type
     */
    public function detachAll(string $type = null);

    /**
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
     * @param string $type
     *
     * @return array
     */
    public function getListeners(string $type): array;

    /**
     * @param string $type
     *
     * @return bool
     */
    public function hasListeners(string $type): bool;
}
```

## List of Events
The events available in Phalcon are:

| Component                   | Event                                | Parameters                                              |
| --------------------------- | ------------------------------------ | ------------------------------------------------------- |
| [ACL](acl)                  | `acl:afterCheckAccess`               | Acl                                                     |
| [ACL](acl)                  | `acl:beforeCheckAccess`              | Acl                                                     |
| [어플리케이션](application)       | `application:afterHandleRequest`     | Application, Controller                                 |
| [어플리케이션](application)       | `application:afterStartModule`       | Application, Module                                     |
| [어플리케이션](application)       | `application:beforeHandleRequest`    | Application, Dispatcher                                 |
| [어플리케이션](application)       | `application:beforeSendResponse`     | Application, Response                                   |
| [어플리케이션](application)       | `application:beforeStartModule`      | Application, Module                                     |
| [어플리케이션](application)       | `application:boot`                   | 어플리케이션                                                  |
| [어플리케이션](application)       | `application:viewRender`             | Application, View                                       |
| [CLI](application-cli)      | `dispatch:beforeException`           | Console, Exception                                      |
| [Console](application-cli)  | `console:afterHandleTask`            | Console, Task                                           |
| [Console](application-cli)  | `console:afterStartModule`           | Console, Module                                         |
| [Console](application-cli)  | `console:beforeHandleTask`           | Console, Dispatcher                                     |
| [Console](application-cli)  | `console:beforeStartModule`          | Console, Module                                         |
| [Console](application-cli)  | `console:boot`                       | Console                                                 |
| [Db](db-layer)              | `db:afterQuery`                      | Db                                                      |
| [Db](db-layer)              | `db:beforeQuery`                     | Db                                                      |
| [Db](db-layer)              | `db:beginTransaction`                | Db                                                      |
| [Db](db-layer)              | `db:createSavepoint`                 | Db, Savepoint Name                                      |
| [Db](db-layer)              | `db:commitTransaction`               | Db                                                      |
| [Db](db-layer)              | `db:releaseSavepoint`                | Db, Savepoint Name                                      |
| [Db](db-layer)              | `db:rollbackTransaction`             | Db                                                      |
| [Db](db-layer)              | `db:rollbackSavepoint`               | Db, Savepoint Name                                      |
| [디스패쳐](dispatcher)          | `dispatch:afterBinding`              | 디스패쳐                                                    |
| [디스패쳐](dispatcher)          | `dispatch:afterDispatch`             | 디스패쳐                                                    |
| [디스패쳐](dispatcher)          | `dispatch:afterDispatchLoop`         | 디스패쳐                                                    |
| [디스패쳐](dispatcher)          | `dispatch:afterExecuteRoute`         | 디스패쳐                                                    |
| [디스패쳐](dispatcher)          | `dispatch:afterInitialize`           | 디스패쳐                                                    |
| [디스패쳐](dispatcher)          | `dispatch:beforeDispatch`            | 디스패쳐                                                    |
| [디스패쳐](dispatcher)          | `dispatch:beforeDispatchLoop`        | 디스패쳐                                                    |
| [디스패쳐](dispatcher)          | `dispatch:beforeException`           | Dispatcher, Exception                                   |
| [디스패쳐](dispatcher)          | `dispatch:beforeExecuteRoute`        | 디스패쳐                                                    |
| [디스패쳐](dispatcher)          | `dispatch:beforeForward`             | Dispatcher, array  (MVC Dispatcher)                     |
| [디스패쳐](dispatcher)          | `dispatch:beforeNotFoundAction`      | 디스패쳐                                                    |
| [로더](autoload)              | `loader:afterCheckClass`             | Loader, Class Name                                      |
| [로더](autoload)              | `loader:beforeCheckClass`            | Loader, Class Name                                      |
| [로더](autoload)              | `loader:beforeCheckPath`             | 로더                                                      |
| [로더](autoload)              | `loader:pathFound`                   | Loader, File Path                                       |
| [마이크로](application-micro)   | `micro:afterBinding`                 | 마이크로                                                    |
| [마이크로](application-micro)   | `micro:afterHandleRoute`             | Micro, return value mixed                               |
| [마이크로](application-micro)   | `micro:afterExecuteRoute`            | 마이크로                                                    |
| [마이크로](application-micro)   | `micro:beforeException`              | Micro, Exception                                        |
| [마이크로](application-micro)   | `micro:beforeExecuteRoute`           | 마이크로                                                    |
| [마이크로](application-micro)   | `micro:beforeHandleRoute`            | 마이크로                                                    |
| [마이크로](application-micro)   | `micro:beforeNotFound`               | 마이크로                                                    |
| [Model](db-models)          | `model:afterCreate`                  | Model                                                   |
| [Model](db-models)          | `model:afterDelete`                  | Model                                                   |
| [Model](db-models)          | `model:afterFetch`                   | Model                                                   |
| [Model](db-models)          | `model:afterSave`                    | Model                                                   |
| [Model](db-models)          | `model:afterUpdate`                  | Model                                                   |
| [Model](db-models)          | `model:afterValidation`              | Model                                                   |
| [Model](db-models)          | `model:afterValidationOnCreate`      | Model                                                   |
| [Model](db-models)          | `model:afterValidationOnUpdate`      | Model                                                   |
| [Model](db-models)          | `model:beforeDelete`                 | Model                                                   |
| [Model](db-models)          | `model:beforeCreate`                 | Model                                                   |
| [Model](db-models)          | `model:beforeSave`                   | Model                                                   |
| [Model](db-models)          | `model:beforeUpdate`                 | Model                                                   |
| [Model](db-models)          | `model:beforeValidation`             | Model                                                   |
| [Model](db-models)          | `model:beforeValidationOnCreate`     | Model                                                   |
| [Model](db-models)          | `model:beforeValidationOnUpdate`     | Model                                                   |
| [Model](db-models)          | `model:notDeleted`                   | Model                                                   |
| [Model](db-models)          | `model:notSaved`                     | Model                                                   |
| [Model](db-models)          | `model:onValidationFails`            | Model                                                   |
| [Model](db-models)          | `model:prepareSave`                  | Model                                                   |
| [Model](db-models)          | `model:validation`                   | Model                                                   |
| [Models Manager](db-models) | `modelsManager:afterInitialize`      | Manager, Model                                          |
| [요청](request)               | `request:afterAuthorizationResolve`  | Request, ['server' => Server array]                     |
| [요청](request)               | `request:beforeAuthorizationResolve` | Request, ['headers' => [Headers], 'server' => [Server]] |
| [응답](response)              | `response:afterSendHeaders`          | 응답                                                      |
| [응답](response)              | `response:beforeSendHeaders`         | 응답                                                      |
| [Router](routing)           | `router:afterCheckRoutes`            | Router                                                  |
| [Router](routing)           | `router:beforeCheckRoutes`           | Router                                                  |
| [Router](routing)           | `router:beforeCheckRoute`            | Router, Route                                           |
| [Router](routing)           | `router:beforeMount`                 | Router, Group                                           |
| [Router](routing)           | `router:matchedRoute`                | Router, Route                                           |
| [Router](routing)           | `router:notMatchedRoute`             | Router, Route                                           |
| [뷰](views)                  | `view:afterCompile`                  | Volt                                                    |
| [뷰](views)                  | `view:afterRender`                   | 뷰                                                       |
| [뷰](views)                  | `view:afterRenderView`               | 뷰                                                       |
| [뷰](views)                  | `view:beforeCompile`                 | Volt                                                    |
| [뷰](views)                  | `view:beforeRender`                  | 뷰                                                       |
| [뷰](views)                  | `view:beforeRenderView`              | View, View Engine Path                                  |
| [뷰](views)                  | `view:notFoundView`                  | View, View Engine Path                                  |
| [Volt](volt)                | `compileFilter`                      | Volt, [name, arguments, function arguments]             |
| [Volt](volt)                | `compileFunction`                    | Volt, [name, arguments, function arguments]             |
| [Volt](volt)                | `compileStatement`                   | Volt, [statement]                                       |
| [Volt](volt)                | `resolveExpression`                  | Volt, [expression]                                      |

[db]: api/phalcon_db
[di-factorydefaul]: api/phalcon_di#di-factorydefault
[events-event]: api/phalcon_events#events-event
[events-eventsawareinterface]: api/phalcon_events#events-eventsawareinterface
[events-exception]: api/phalcon_events#events-exception
[events-manager]: api/phalcon_events#events-manager
[events-managerinterface]: api/phalcon_events#events-managerinterface
[splpriorityqueue]: https://www.php.net/manual/en/class.splpriorityqueue.php
