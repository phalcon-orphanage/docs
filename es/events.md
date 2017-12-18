<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Gestor de Eventos</a> 
      <ul>
        <li>
          <a href="#naming-convention">Convención de Nombres</a>
        </li>
        <li>
          <a href="#usage">Ejemplo de Uso</a>
        </li>
        <li>
          <a href="#components-that-trigger-events">Creando Componentes que Desencadenan Eventos</a>
        </li>
        <li>
          <a href="#using-services">Utilización Servicios del DI</a>
        </li>
        <li>
          <a href="#propagation-cancellation">Propagación y Cancelación de Eventos</a>
        </li>
        <li>
          <a href="#listener-priorities">Prioridades del Oyente</a>
        </li>
        <li>
          <a href="#collecting-responses">Recogiendo Respuestas</a>
        </li>
        <li>
          <a href="#custom">Implementando tu propio EventsManager</a>
        </li>
        <li>
          <a href="#list">Lista de Eventos</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Gestor de Eventos

El propósito de este componente es interceptar la ejecución de la mayoría de los otros componentes del framework mediante la creación de 'puntos de anclaje'. Estos puntos de anclaje o gancho permiten al desarrollador obtener información del estado, manipular los datos o cambiar el flujo de ejecución durante el proceso de un componente.

<a name='naming-convention'></a>

## Convención de Nombres

Los eventos de Phalcon utilizan espacios de nombres para evitar colisiones de nombres. Cada componente de Phalcon ocupa un espacio de nombres de evento diferente y eres libre crear el tuyo propio como mejor te parezca. Los nombres de evento tienen el formato `componente:evento`. Por ejemplo, como `Phalcon\Db` ocupa el espacio de nombres `db`, su nombre completo del evento `afterQuery` es `db:afterQuery`.

Al adjuntar oyentes de eventos en el administrador de eventos, puede utilizar el `componente` para atrapar a todos los eventos de dicho componente (por ejemplo. `db` para capturar todos los eventos de `Phalcon\Db`) o `componente:evento` para un evento específico (por ejemplo `db:afterQuery`).

<a name='usage'></a>

## Ejemplo de Uso

En el siguiente ejemplo, utilizaremos el EventsManager para escuchar el evento `afterQuery` en una conexión de MySQL administrada por `Phalcon\Db`:

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

// Asignar el eventsManager a la instancia del adaptador db
$connection->setEventsManager($eventsManager);

// Enviar un comando SQL al servidor de base de datos
$connection->query(
    'SELECT * FROM products p WHERE p.status = 1'
);
```

Ahora, cada vez que se ejecuta una consulta, la instrucción SQL se repetirá. El primer parámetro a la función lambda contiene información contextual sobre el evento que se ejecuta, el segundo parámetro es la fuente del evento (en este caso la conexión sí misma). También se puede especificar un tercer parámetro que contiene datos arbitrarios específicos para el evento.

<div class="alert alert-warning">
    <p>
        Debe configurar explícitamente el administrador de eventos de un componente mediante el método <code>setEventsManager()</code> de tal forma que el componente dispare los eventos. Usted puede crear una nueva instancia del gestor de eventos para cada componente o puede establecer el mismo gestor de eventos para varios componentes, ya que la convención de nombres evitará conflictos.
    </p>
</div>

En lugar de utilizar funciones anónimas, se puede utilizar las clases oyentes de eventos. Los oyentes o detectores de eventos también permiten escuchar a varios eventos. En este ejemplo, vamos a implementar el `Phalcon\Db\Profiler` para detectar las declaraciones SQL que están tomando más tiempo de lo previsto para su ejecución:

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
     * Creamos el perfilador e iniciamos el registro
     */
    public function __construct()
    {
        $this->profiler = new Profiler();
        $this->logger   = new Logger('../apps/logs/db.log');
    }

    /**
     * Este es ejecutado si el evento disparado es 'beforeQuery'
     */
    public function beforeQuery(Event $event, $connection)
    {
        $this->profiler->startProfile(
            $connection->getSQLStatement()
        );
    }

    /**
     * Este es ejecutado si el evento disparado es 'afterQuery'
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
use Phalcon\Events\Manager as EventsManager;

class MyComponent implements EventsAwareInterface
{
    protected $eventsManager;

    public function setEventsManager(EventsManager $eventsManager)
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
| Models Manager     | `modelsManager:afterInitialize`     |
| View               | `view:afterRender`                  |
| View               | `view:afterRenderView`              |
| View               | `view:beforeRender`                 |
| View               | `view:beforeRenderView`             |
| View               | `view:notFoundView`                 |
| Volt               | `compileFilter`                     |
| Volt               | `compileFunction`                   |
| Volt               | `compileStatement`                  |
| Volt               | `resolveExpression`                 |