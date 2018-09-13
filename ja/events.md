<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Events Manager</a> 
      <ul>
        <li>
          <a href="#naming-convention">Naming Convention</a>
        </li>
        <li>
          <a href="#usage">Usage Example</a>
        </li>
        <li>
          <a href="#components-that-trigger-events">Creating components that trigger Events</a>
        </li>
        <li>
          <a href="#using-services">Using Services From The DI</a>
        </li>
        <li>
          <a href="#propagation-cancellation">Event Propagation/Cancellation</a>
        </li>
        <li>
          <a href="#listener-priorities">Listener Priorities</a>
        </li>
        <li>
          <a href="#collecting-responses">Collecting Responses</a>
        </li>
        <li>
          <a href="#custom">Implementing your own EventsManager</a>
        </li>
        <li>
          <a href="#list">List of events</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Events Manager

The purpose of this component is to intercept the execution of most of the other components of the framework by creating 'hook points'. These hook points allow the developer to obtain status information, manipulate data or change the flow of execution during the process of a component.

<a name='naming-convention'></a>

## Naming Convention

Phalcon events use namespaces to avoid naming collisions. Each component in Phalcon occupies a different event namespace and you are free to create your own as you see fit. Event names are formatted as `component:event`. For example, as `Phalcon\Db` occupies the `db` namespace, its `afterQuery` event's full name is `db:afterQuery`.

When attaching event listeners to the events manager, you can use `component` to catch all events from that component (eg. `db` to catch all of the `Phalcon\Db` events) or `component:event` to target a specific event (eg. `db:afterQuery`).

<a name='usage'></a>

## Usage Example

In the following example, we will use the EventsManager to listen for the `afterQuery` event produced in a MySQL connection managed by `Phalcon\Db`:

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

// Assign the eventsManager to the db adapter instance
$connection->setEventsManager($eventsManager);

// Send a SQL command to the database server
$connection->query(
    'SELECT * FROM products p WHERE p.status = 1'
);
```

Now every time a query is executed, the SQL statement will be echoed out. The first parameter passed to the lambda function contains contextual information about the event that is running, the second is the source of the event (in this case the connection itself). A third parameter may also be specified which will contain arbitrary data specific to the event.

<div class="alert alert-warning">
    <p>
        You must explicitly set the Events Manager to a component using the <code>setEventsManager()</code> method in order for that component to trigger events. You can create a new Events Manager instance for each component or you can set the same Events Manager to multiple components as the naming convention will avoid conflicts.
    </p>
</div>

Instead of using lambda functions, you can use event listener classes instead. Event listeners also allow you to listen to multiple events. In this example, we will implement the `Phalcon\Db\Profiler` to detect the SQL statements that are taking longer to execute than expected:

```php
<?php

use Phalcon\Db\Profiler;
use Phalcon\Events\Event;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\File;

class MyDbListener
{
    protected $profiler;

    protected $logger;

    /**
     * Creates the profiler and starts the logging
     */
    public function __construct()
    {
        $this->profiler = new Profiler();
        $this->logger   = new Logger('../apps/logs/db.log');
    }

    /**
     * This is executed if the event triggered is 'beforeQuery'
     */
    public function beforeQuery(Event $event, $connection)
    {
        $this->profiler->startProfile(
            $connection->getSQLStatement()
        );
    }

    /**
     * This is executed if the event triggered is 'afterQuery'
     */
    public function afterQuery(Event $event, $connection)
    {
        $this->logger->log(
            $connection->getSQLStatement(),
            Logger::INFO
        );

        $this->profiler->stopProfile();
    }

    public function getProfiler()
    {
        return $this->profiler;
    }
}
```

Attaching an event listener to the events manager is as simple as:

```php
<?php

// Create a database listener
$dbListener = new MyDbListener();

// Listen all the database events
$eventsManager->attach(
    'db',
    $dbListener
);
```

The resulting profile data can be obtained from the listener:

```php
<?php

// Send a SQL command to the database server
$connection->execute(
    'SELECT * FROM products p WHERE p.status = 1'
);

foreach ($dbListener->getProfiler()->getProfiles() as $profile) {
    echo 'SQL Statement: ', $profile->getSQLStatement(), '\n';
    echo 'Start Time: ', $profile->getInitialTime(), '\n';
    echo 'Final Time: ', $profile->getFinalTime(), '\n';
    echo 'Total Elapsed Time: ', $profile->getTotalElapsedSeconds(), '\n';
}
```

<a name='components-that-trigger-events'></a>

## Creating components that trigger Events

You can create components in your application that trigger events to an EventsManager. As a consequence, there may exist listeners that react to these events when generated. In the following example we're creating a component called `MyComponent`. This component is EventsManager aware (it implements `Phalcon\Events\EventsAwareInterface`); when its `someTask()` method is executed it triggers two events to any listener in the EventsManager:

```php
<?php

use Phalcon\Events\EventsAwareInterface;
use Phalcon\Events\ManagerInterface;

class MyComponent implements EventsAwareInterface
{
    protected $eventsManager;

    public function setEventsManager(ManagerInterface $eventsManager)
    {
        $this->eventsManager = $eventsManager;
    }

    public function getEventsManager()
    {
        return $this->eventsManager;
    }

    public function someTask()
    {
        $this->eventsManager->fire('my-component:beforeSomeTask', $this);

        // Do some task
        echo 'Here, someTask\n';

        $this->eventsManager->fire('my-component:afterSomeTask', $this);
    }
}
```

Notice that in this example, we're using the `my-component` event namespace. Now we need to create an event listener for this component:

```php
<?php

use Phalcon\Events\Event;

class SomeListener
{
    public function beforeSomeTask(Event $event, $myComponent)
    {
        echo "Here, beforeSomeTask\n";
    }

    public function afterSomeTask(Event $event, $myComponent)
    {
        echo "Here, afterSomeTask\n";
    }
}
```

Now let's make everything work together:

```php
<?php

use Phalcon\Events\Manager as EventsManager;

// Create an Events Manager
$eventsManager = new EventsManager();

// Create the MyComponent instance
$myComponent = new MyComponent();

// Bind the eventsManager to the instance
$myComponent->setEventsManager($eventsManager);

// Attach the listener to the EventsManager
$eventsManager->attach(
    'my-component',
    new SomeListener()
);

// Execute methods in the component
$myComponent->someTask();
```

As `someTask()` is executed, the two methods in the listener will be executed, producing the following output:

```bash
Here, beforeSomeTask
Here, someTask
Here, afterSomeTask
```

Additional data may also be passed when triggering an event using the third parameter of `fire()`:

```php
<?php

$eventsManager->fire('my-component:afterSomeTask', $this, $extraData);
```

In a listener the third parameter also receives this data:

```php
<?php

use Phalcon\Events\Event;

// Receiving the data in the third parameter
$eventsManager->attach(
    'my-component',
    function (Event $event, $component, $data) {
        print_r($data);
    }
);

// Receiving the data from the event context
$eventsManager->attach(
    'my-component',
    function (Event $event, $component) {
        print_r($event->getData());
    }
);
```

<a name='using-services'></a>

## Using Services From The DI

By extending `Phalcon\Mvc\User\Plugin`, you can access services from the DI, just like you would in a controller:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;

class SomeListener extends Plugin
{
    public function beforeSomeTask(Event $event, $myComponent)
    {
        echo 'Here, beforeSomeTask\n';

        $this->logger->debug(
            'beforeSomeTask has been triggered'
        );
    }

    public function afterSomeTask(Event $event, $myComponent)
    {
        echo 'Here, afterSomeTask\n';

        $this->logger->debug(
            'afterSomeTask has been triggered'
        );
    }
}
```

<a name='propagation-cancellation'></a>

## Event Propagation/Cancellation

Many listeners may be added to the same event manager. This means that for the same type of event, many listeners can be notified. The listeners are notified in the order they were registered in the EventsManager. Some events are cancelable, indicating that these may be stopped preventing other listeners from being notified about the event:

```php
<?php

use Phalcon\Events\Event;

$eventsManager->attach(
    'db',
    function (Event $event, $connection) {
        // We stop the event if it is cancelable
        if ($event->isCancelable()) {
            // Stop the event, so other listeners will not be notified about this
            $event->stop();
        }

        // ...
    }
);
```

By default, events are cancelable - even most of the events produced by the framework are cancelables. You can fire a not-cancelable event by passing `false` in the fourth parameter of `fire()`:

```php
<?php

$eventsManager->fire('my-component:afterSomeTask', $this, $extraData, false);
```

<a name='listener-priorities'></a>

## Listener Priorities

When attaching listeners you can set a specific priority. With this feature you can attach listeners indicating the order in which they must be called:

```php
<?php

$eventsManager->enablePriorities(true);

$eventsManager->attach('db', new DbListener(), 150); // More priority
$eventsManager->attach('db', new DbListener(), 100); // Normal priority
$eventsManager->attach('db', new DbListener(), 50);  // Less priority
```

<a name='collecting-responses'></a>

## Collecting Responses

The events manager can collect every response returned by every notified listener. This example explains how it works:

```php
<?php

use Phalcon\Events\Manager as EventsManager;

$eventsManager = new EventsManager();

// Set up the events manager to collect responses
$eventsManager->collectResponses(true);

// Attach a listener
$eventsManager->attach(
    'custom:custom',
    function () {
        return 'first response';
    }
);

// Attach a listener
$eventsManager->attach(
    'custom:custom',
    function () {
        return 'second response';
    }
);

// Fire the event
$eventsManager->fire('custom:custom', null);

// Get all the collected responses
print_r($eventsManager->getResponses());
```

The above example produces:

```php
    Array ( [0] => first response [1] => second response )
```

<a name='custom'></a>

## Implementing your own EventsManager

The `Phalcon\Events\ManagerInterface` interface must be implemented to create your own EventsManager replacing the one provided by Phalcon.

<a name='list'></a>

## List of Events

The events available in Phalcon are:

| Component          | Event                               |
| ------------------ | ----------------------------------- |
| ACL                | `acl:afterCheckAccess`              |
| ACL                | `acl:beforeCheckAccess`             |
| Application        | `application:afterHandleRequest`    |
| Application        | `application:afterStartModule`      |
| Application        | `application:beforeHandleRequest`   |
| Application        | `application:beforeSendResponse`    |
| Application        | `application:beforeStartModule`     |
| Application        | `application:boot`                  |
| Application        | `application:viewRender`            |
| CLI                | `dispatch:beforeException`          |
| Collection         | `afterCreate`                       |
| Collection         | `afterSave`                         |
| Collection         | `afterUpdate`                       |
| Collection         | `afterValidation`                   |
| Collection         | `afterValidationOnCreate`           |
| Collection         | `afterValidationOnUpdate`           |
| Collection         | `beforeCreate`                      |
| Collection         | `beforeSave`                        |
| Collection         | `beforeUpdate`                      |
| Collection         | `beforeValidation`                  |
| Collection         | `beforeValidationOnCreate`          |
| Collection         | `beforeValidationOnUpdate`          |
| Collection         | `notDeleted`                        |
| Collection         | `notSave`                           |
| Collection         | `notSaved`                          |
| Collection         | `onValidationFails`                 |
| Collection         | `validation`                        |
| Collection Manager | `collectionManager:afterInitialize` |
| Console            | `console:afterHandleTask`           |
| Console            | `console:afterStartModule`          |
| Console            | `console:beforeHandleTask`          |
| Console            | `console:beforeStartModule`         |
| Db                 | `db:afterQuery`                     |
| Db                 | `db:beforeQuery`                    |
| Db                 | `db:beginTransaction`               |
| Db                 | `db:createSavepoint`                |
| Db                 | `db:commitTransaction`              |
| Db                 | `db:releaseSavepoint`               |
| Db                 | `db:rollbackTransaction`            |
| Db                 | `db:rollbackSavepoint`              |
| Dispatcher         | `dispatch:afterExecuteRoute`        |
| Dispatcher         | `dispatch:afterDispatch`            |
| Dispatcher         | `dispatch:afterDispatchLoop`        |
| Dispatcher         | `dispatch:afterInitialize`          |
| Dispatcher         | `dispatch:beforeException`          |
| Dispatcher         | `dispatch:beforeExecuteRoute`       |
| Dispatcher         | `dispatch:beforeDispatch`           |
| Dispatcher         | `dispatch:beforeDispatchLoop`       |
| Dispatcher         | `dispatch:beforeForward`            |
| Dispatcher         | `dispatch:beforeNotFoundAction`     |
| Loader             | `loader:afterCheckClass`            |
| Loader             | `loader:beforeCheckClass`           |
| Loader             | `loader:beforeCheckPath`            |
| Loader             | `loader:pathFound`                  |
| Micro              | `micro:afterHandleRoute`            |
| Micro              | `micro:afterExecuteRoute`           |
| Micro              | `micro:beforeExecuteRoute`          |
| Micro              | `micro:beforeHandleRoute`           |
| Micro              | `micro:beforeNotFound`              |
| Middleware         | `afterBinding`                      |
| Middleware         | `afterExecuteRoute`                 |
| Middleware         | `afterHandleRoute`                  |
| Middleware         | `beforeExecuteRoute`                |
| Middleware         | `beforeHandleRoute`                 |
| Middleware         | `beforeNotFound`                    |
| Model              | `afterCreate`                       |
| Model              | `afterDelete`                       |
| Model              | `afterSave`                         |
| Model              | `afterUpdate`                       |
| Model              | `afterValidation`                   |
| Model              | `afterValidationOnCreate`           |
| Model              | `afterValidationOnUpdate`           |
| Model              | `beforeDelete`                      |
| Model              | `notDeleted`                        |
| Model              | `beforeCreate`                      |
| Model              | `beforeDelete`                      |
| Model              | `beforeSave`                        |
| Model              | `beforeUpdate`                      |
| Model              | `beforeValidation`                  |
| Model              | `beforeValidationOnCreate`          |
| Model              | `beforeValidationOnUpdate`          |
| Model              | `notSave`                           |
| Model              | `notSaved`                          |
| Model              | `onValidationFails`                 |
| Model              | `prepareSave`                       |
| Models Manager     | `modelsManager:afterInitialize`     |
| Router             | `router:beforeCheckRoutes`          |
| Router             | `router:beforeCheckRoute`           |
| Router             | `router:matchedRoute`               |
| Router             | `router:notMatchedRoute`            |
| Router             | `router:afterCheckRoutes`           |
| Router             | `router:beforeMount`                |
| View               | `view:afterRender`                  |
| View               | `view:afterRenderView`              |
| View               | `view:beforeRender`                 |
| View               | `view:beforeRenderView`             |
| View               | `view:notFoundView`                 |
| Volt               | `compileFilter`                     |
| Volt               | `compileFunction`                   |
| Volt               | `compileStatement`                  |
| Volt               | `resolveExpression`                 |