---
layout: default
language: 'es-es'
version: '5.0'
title: 'Gestor de Eventos'
upgrade: '#events'
keywords: 'eventos, gestor de eventos, hooks'
---

# Gestor de Eventos
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
The purpose of this component is to intercept the execution of components in the framework by creating _hooks_. Estos *hooks* permiten a los desarrolladores obtener información de estado, manipular datos o cambiar el flujo de ejecución durante el proceso de un componente. The component consists of a [Phalcon\Events\Manager][events-manager] that handles event propagation and execution of events. The manager contains various [Phalcon\Events\Event][events-event] objects, which contain information about each hook/event.

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

## Convención de Nombres
Los eventos Phalcon usan espacios de nombres para evitar colisiones de nombres. Each component in Phalcon occupies a different event namespace, and you are free to create your own as you see fit. Los nombre de evento son formateados como `component:event`. For example, as [Phalcon\Db][db] occupies the `db` namespace, its `afterQuery` event's full name is `db:afterQuery`.

When attaching event listeners to the events manager, you can use `component` to catch all events from that component (e.g. `db` to catch all the [Phalcon\Db][db] events) or `component:event` to target a specific event (eg. `db:afterQuery`).

## Manager
The [Phalcon\Events\Manager][events-manager] is the main component that handles all the events in Phalcon. Different implementations in other frameworks refer to this component as _a handler_. Independientemente del nombre, la funcionalidad y el propósito son los mismos.

The component wraps a queue of objects using [SplPriorityQueue][splpriorityqueue] internally. Registra esos objetos con una prioridad (por defecto `100`) y cuando llega el momento, los ejecuta.

Los métodos expuestos por el gestor son:

```php
public function attach(
    string $eventType, 
    mixed $handler, 
    int $priority = self::DEFAULT_PRIORITY
)
```
Adjunta un oyente al gestor de eventos. El `manejador` es un objeto o `invocable`.

```php
public function arePrioritiesEnabled(): bool
```
Devuelve si las prioridades están habilitadas

```php
public function collectResponses(bool $collect)
```
Indica al gestor de eventos si hay que recoger todas las respuestas devueltas por cada oyente registrado en una única llamada `de disparo`

```php
public function detach(string $eventType, mixed $handler)
```
Separa el oyente del gestor de eventos

```php
public function detachAll(string $type = null)
```
Elimina todos los eventos del `EventsManager`

```php
public function enablePriorities(bool $enablePriorities)
```
Establece si las prioridades están activadas en el gestor de eventos (por defecto `false`).

```php
public function fire(string $eventType, mixed $source, mixed $data = null, bool $cancelable = true)
```
Dispara un evento en el gestor de eventos causando que los oyentes activos sean notificados al respecto

```php
final public function fireQueue(SplPriorityQueue $queue, EventInterface $event): mixed
 ```
Gestor interno para llamar a una cola de eventos

```php
public function getListeners(string $type): array
```
Devuelve todos los oyentes adjuntos de cierto tipo

```php
public function getResponses(): array
```
Devuelve todas las respuestas devueltas por cada manejador ejecutado por el último `disparo` ejecutado

```php
public function hasListeners(string $type): bool
```
Comprueba si cierto tipo de evento tiene oyentes

```php
public function isCollecting(): bool
```
Check if the events manager is collecting all the responses returned  by every registered listener in a single `fire`

```php
public function isValidHandler(object | callable handler): bool
```
Check if the handler is an object or a callable

## Uso
If you are using the [Phalcon\Di\FactoryDefault][di-factorydefaul] DI container, the [Phalcon\Events\Manager][events-manager] is already registered for you with the name `eventsManager`. This is a _global_ events manager. However, you are not restricted to use only that one. Siempre puede crear un gestor separado para gestionar los eventos para cualquier componente que lo requiera.

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

o si quiere un gestor de eventos separado:

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

En el ejemplo anterior, estamos usando el gestor de eventos para escuchar el evento `afterQuery` producido por el servicio `db`, en este caso MySQL. Usamos el método `attach` para adjuntar nuestro evento al gestor y usar el evento `db:afterQuery`. We add an anonymous function as the handler for this event, which accepts a [Phalcon\Events\Event][events-event] as the first parameter. Este objeto contiene información contextual sobre el evento que ha sido disparado. El objeto de conexión a la base de datos como segundo. Usando la variable de conexión imprimimos la sentencia SQL. Puede pasar un tercer parámetro con datos arbitrarios específicos del evento, o incluso un objeto *logger* en la función anónima que permita registrar tus consultas en un fichero de registro separado.

> **NOTE**: You must explicitly set the Events Manager to a component using the `setEventsManager()` method in order for that component to trigger events. You can create a new Events Manager instance for each component, or you can set the same Events Manager to multiple components as the naming convention will avoid conflicts 
> 
> {: .alert .alert-warning }

## Gestores
El gestor de eventos conecta un manejador a un evento. Un manejador es una pieza de código que hará algo cuando se dispare el evento. Como se ve en el ejemplo anterior, puede usar una función anónima como manejador:

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

You can also create a _listener_ class, which offers more flexibility. En un oyente, puede escuchar múltiples eventos e incluso extender \[Phalcon\Di\Injectable\]\[di-injectable\] lo que le dará acceso completo a los servicios del contenedor Di. El ejemplo anterior se puede mejorar implementando el siguiente oyente:

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

Adjuntar el oyente a nuestro gestor de eventos es muy simple:

```php
<?php

$eventsManager->attach(
    'db',
    new QueryListener()
);
```

El comportamiento resultante será que si la variable de configuración `app.logLevel` es mayor que `1` (que representa que estamos en modo desarrollo), todas las consultas serán registradas junto con los parámetros actuales vinculados a cada consulta. Additionally, we will log every time we have a rollback in a transaction.

Otro oyente útil es el `404`:

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

y adjuntarlo al gestor de eventos:

```php
<?php

$eventsManager->attach(
    'dispatch:beforeException',
    new NotFoundListener(),
    200
);
```

Primero conectamos el oyente al componente `dispatcher` y el evento `beforeException`. Esto significa que el gestor de eventos sólo se disparará para ese evento llamando a nuestro oyente. Podríamos haber cambiado el punto de enganche al `dispatcher` para poder añadir en el futuro más eventos del disparador al mismo oyente.

La función `beforeException` acepta `$event` como primer parámetro, `$dispatcher` como segundo y la excepción `$ex` lanzada desde el componente `dispatcher`. Usándolos, podemos averiguar si un manejador (o controlador) o una acción no fueron encontrados. En este caso, redirigimos al usuario a un módulo, controlador y acción específicos. Si el usuario no está conectado, entonces lo enviaremos a la página de inicio de sesión. Alternativamente, podemos registrar el mensaje de la excepción en nuestro `logger`.

Este ejemplo demuestra claramente el poder del gestor de eventos, y como puede alterar el flujo de la aplicación usando oyentes.

## Eventos: Disparador
Puede crear componentes en su aplicación que lance eventos a un gestor de eventos. Los oyentes adjuntos a esos eventos se invocarán cuando los eventos se disparen. In order to create a component that triggers events, we need to implement the [Phalcon\Events\EventsAwareInterface][events-eventsawareinterface].

### Componente Personalizado
Consideremos el siguiente ejemplo:

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

The above component implements the [Phalcon\Events\EventsAwareInterface][events-eventsawareinterface] and as a result it uses the `getEventsManager` and `setEventsManager`. El último método es el que hace el trabajo. En este ejemplo queremos enviar algunas notificaciones a usuarios y queremos disparar un evento antes y después de que se envíe la notificación.

Elegimos nombrar al componente `notification` y los eventos se llaman `beforeSend` y `afterSend`. En el método `process`, puede añadir cualquier código que necesite entre las llamadas para disparar los eventos relevantes. Adicionalmente, puede inyectar más datos en este componente que ayudarán con su implementación y procesado de las notificaciones.

### Oyente Personalizado
Ahora necesitamos crear un oyente para este componente:

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

Poniendo todo junto

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

Cuando se ejecuta `process`, se ejecutarán los dos métodos del oyente. Su registro tendrá entonces las siguientes entradas:

```txt
[2019-12-25 01:02:03][INFO] Before Notification
[2019-12-25 01:02:03][INFO] Processing...
[2019-12-25 01:02:03][INFO] After Notification
```

### Datos Personalizados
Se pueden indicar datos adicionales cuando se dispara un evento usando el tercer parámetro de `fire()`:

```php
<?php

$data = [
    'name'     => 'Darth Vader',
    'password' => '12345',
];

$eventsManager->fire('notifications:afterSend', $this, $data);
```

En un oyente, el tercer parámetro también recibe datos:

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

## Propagación
Un gestor de eventos puede tener múltiples oyentes adjuntos a él. Una vez se dispara un evento, todos los oyentes que pueden ser notificados para el evento particular serán notificados. Este es el comportamiento por defecto, pero se puede alterar si se necesita parar la propagación antes de tiempo:

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

En el ejemplo simple anterior, paramos todos los eventos si hoy es anterior a `2019-01-01`.

## Cancelación
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

En el ejemplo anterior, si el evento es cancelable, pararemos la propagación. You can set a particular event to **not** be cancelable by utilizing the fourth parameter of `fire()`:

```php
<?php

$eventsManager->fire('notifications:afterSend', $this, $data, false);
```

El evento `afterSend` ya no será cancelable y se ejecutará en todos los oyentes que lo implementen.

> **NOTE**: You can stop the execution by returning `false` in your event (but not always). Por ejemplo, si adjunta un evento a `dispatch:beforeDispatchLoop` y su oyente devuelve `false` el proceso de entrega será detenido. This is true if you only have **one listener** listening to the `dispatch:beforeDispatchLoop` event which returns `false`. Si hay dos oyentes adjuntos al evento y el segundo que se ejecuta devuelve `true` entonces el proceso continuará. Si desea evitar que cualquiera de los eventos posteriores se disparen, deberá emitir `stop()` en su oyente del objeto `Event`. 
> 
> {: .alert .alert-warning }

## Prioridades
Cuando adjuntamos oyentes puede especificar una prioridad. Al establecer prioridades cuando adjuntamos oyentes a su gestor de eventos define el orden en el que van a ser llamados:

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

## Respuestas
El gestor de eventos puede recopilar también cualquier respuesta devuelta por cada evento y devolverlas usando el método `getResponses()`. El método devuelve un vector con las respuestas:

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

El ejemplo anterior produce:

```bash
[
    0 => 'first response',
    1 => 'second response',
]
```

> **NOTE**: In order for the priorities to work `collectResponses()` has to be called with `true` to enable collecting them. 
> 
> {: .alert .alert-info }

## Excepciones
Any exceptions thrown in the Paginator component will be of type [Phalcon\Events\Exception][events-exception]. Puede usar esta excepción para capturar selectivamente sólo las excepciones lanzadas desde este componente.

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

## Controladores
Los controladores actúan como oyentes ya registrados en el gestor de eventos. As a result, you only need to create a method with the same name as a registered event, and it will be fired.

Por ejemplo, si queremos enviar un usuario a la página `/login` si no está conectado, podemos añadir el siguiente código a nuestro controlador principal:

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
Execute the code before the router, so we can determine if the user is logged in or not. Si no es así, los enviamos a la página de inicio de sesión.

## Modelos
Similar a los Controladores, los Modelos también actúan como oyentes ya registrados en el gestor de eventos. As a result, you only need to create a method with the same name as a registered event, and it will be fired.

En el siguiente ejemplo, usamos el evento `beforeCreate`, para calcular automáticamente un número de factura:

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

## Personalizado
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

## Lista de Eventos
Los eventos disponibles en Phalcon son:

| Componente                     | Evento                               | Parámetros                                              |
| ------------------------------ | ------------------------------------ | ------------------------------------------------------- |
| [ACL](acl)                     | `acl:afterCheckAccess`               | Acl                                                     |
| [ACL](acl)                     | `acl:beforeCheckAccess`              | Acl                                                     |
| [Application](application)     | `application:afterHandleRequest`     | Application, Controller                                 |
| [Application](application)     | `application:afterStartModule`       | Application, Module                                     |
| [Application](application)     | `application:beforeHandleRequest`    | Application, Dispatcher                                 |
| [Application](application)     | `application:beforeSendResponse`     | Application, Response                                   |
| [Application](application)     | `application:beforeStartModule`      | Application, Module                                     |
| [Application](application)     | `application:boot`                   | Application                                             |
| [Application](application)     | `application:viewRender`             | Application, View                                       |
| [CLI](application-cli)         | `dispatch:beforeException`           | Console, Exception                                      |
| [Console](application-cli)     | `console:afterHandleTask`            | Console, Task                                           |
| [Console](application-cli)     | `console:afterStartModule`           | Console, Module                                         |
| [Console](application-cli)     | `console:beforeHandleTask`           | Console, Dispatcher                                     |
| [Console](application-cli)     | `console:beforeStartModule`          | Console, Module                                         |
| [Console](application-cli)     | `console:boot`                       | Console                                                 |
| [Db](db-layer)                 | `db:afterQuery`                      | Db                                                      |
| [Db](db-layer)                 | `db:beforeQuery`                     | Db                                                      |
| [Db](db-layer)                 | `db:beginTransaction`                | Db                                                      |
| [Db](db-layer)                 | `db:createSavepoint`                 | Db, Savepoint Name                                      |
| [Db](db-layer)                 | `db:commitTransaction`               | Db                                                      |
| [Db](db-layer)                 | `db:releaseSavepoint`                | Db, Savepoint Name                                      |
| [Db](db-layer)                 | `db:rollbackTransaction`             | Db                                                      |
| [Db](db-layer)                 | `db:rollbackSavepoint`               | Db, Savepoint Name                                      |
| [Dispatcher](dispatcher)       | `dispatch:afterBinding`              | Dispatcher                                              |
| [Dispatcher](dispatcher)       | `dispatch:afterDispatch`             | Dispatcher                                              |
| [Dispatcher](dispatcher)       | `dispatch:afterDispatchLoop`         | Dispatcher                                              |
| [Dispatcher](dispatcher)       | `dispatch:afterExecuteRoute`         | Dispatcher                                              |
| [Dispatcher](dispatcher)       | `dispatch:afterInitialize`           | Dispatcher                                              |
| [Dispatcher](dispatcher)       | `dispatch:beforeDispatch`            | Dispatcher                                              |
| [Dispatcher](dispatcher)       | `dispatch:beforeDispatchLoop`        | Dispatcher                                              |
| [Dispatcher](dispatcher)       | `dispatch:beforeException`           | Dispatcher, Exception                                   |
| [Dispatcher](dispatcher)       | `dispatch:beforeExecuteRoute`        | Dispatcher                                              |
| [Dispatcher](dispatcher)       | `dispatch:beforeForward`             | Dispatcher, array (MVC Dispatcher)                      |
| [Dispatcher](dispatcher)       | `dispatch:beforeNotFoundAction`      | Dispatcher                                              |
| [Loader](autoload)             | `loader:afterCheckClass`             | Loader, Class Name                                      |
| [Loader](autoload)             | `loader:beforeCheckClass`            | Loader, Class Name                                      |
| [Loader](autoload)             | `loader:beforeCheckPath`             | Loader                                                  |
| [Loader](autoload)             | `loader:pathFound`                   | Loader, File Path                                       |
| [Micro](application-micro)     | `micro:afterBinding`                 | Micro                                                   |
| [Micro](application-micro)     | `micro:afterHandleRoute`             | Micro, return value mixed                               |
| [Micro](application-micro)     | `micro:afterExecuteRoute`            | Micro                                                   |
| [Micro](application-micro)     | `micro:beforeException`              | Micro, Exception                                        |
| [Micro](application-micro)     | `micro:beforeExecuteRoute`           | Micro                                                   |
| [Micro](application-micro)     | `micro:beforeHandleRoute`            | Micro                                                   |
| [Micro](application-micro)     | `micro:beforeNotFound`               | Micro                                                   |
| [Modelo](db-models)            | `model:afterCreate`                  | Modelo                                                  |
| [Modelo](db-models)            | `model:afterDelete`                  | Modelo                                                  |
| [Modelo](db-models)            | `model:afterFetch`                   | Modelo                                                  |
| [Modelo](db-models)            | `model:afterSave`                    | Modelo                                                  |
| [Modelo](db-models)            | `model:afterUpdate`                  | Modelo                                                  |
| [Modelo](db-models)            | `model:afterValidation`              | Modelo                                                  |
| [Modelo](db-models)            | `model:afterValidationOnCreate`      | Modelo                                                  |
| [Modelo](db-models)            | `model:afterValidationOnUpdate`      | Modelo                                                  |
| [Modelo](db-models)            | `model:beforeDelete`                 | Modelo                                                  |
| [Modelo](db-models)            | `model:beforeCreate`                 | Modelo                                                  |
| [Modelo](db-models)            | `model:beforeSave`                   | Modelo                                                  |
| [Modelo](db-models)            | `model:beforeUpdate`                 | Modelo                                                  |
| [Modelo](db-models)            | `model:beforeValidation`             | Modelo                                                  |
| [Modelo](db-models)            | `model:beforeValidationOnCreate`     | Modelo                                                  |
| [Modelo](db-models)            | `model:beforeValidationOnUpdate`     | Modelo                                                  |
| [Modelo](db-models)            | `model:notDeleted`                   | Modelo                                                  |
| [Modelo](db-models)            | `model:notSaved`                     | Modelo                                                  |
| [Modelo](db-models)            | `model:onValidationFails`            | Modelo                                                  |
| [Modelo](db-models)            | `model:prepareSave`                  | Modelo                                                  |
| [Modelo](db-models)            | `model:validation`                   | Modelo                                                  |
| [Gestor de Modelos](db-models) | `modelsManager:afterInitialize`      | Manager, Model                                          |
| [Consulta](request)            | `request:afterAuthorizationResolve`  | Request, ['server' => Server array]                     |
| [Consulta](request)            | `request:beforeAuthorizationResolve` | Request, ['headers' => [Headers], 'server' => [Server]] |
| [Respuesta](response)          | `response:afterSendHeaders`          | Respuesta                                               |
| [Respuesta](response)          | `response:beforeSendHeaders`         | Respuesta                                               |
| [Router](routing)              | `router:afterCheckRoutes`            | Router                                                  |
| [Router](routing)              | `router:beforeCheckRoutes`           | Router                                                  |
| [Router](routing)              | `router:beforeCheckRoute`            | Router, Route                                           |
| [Router](routing)              | `router:beforeMount`                 | Router, Group                                           |
| [Router](routing)              | `router:matchedRoute`                | Router, Route                                           |
| [Router](routing)              | `router:notMatchedRoute`             | Router, Route                                           |
| [Vistas](view)                 | `view:afterCompile`                  | Volt                                                    |
| [Vistas](view)                 | `view:afterRender`                   | Vistas                                                  |
| [Vistas](view)                 | `view:afterRenderView`               | Vistas                                                  |
| [Vistas](view)                 | `view:beforeCompile`                 | Volt                                                    |
| [Vistas](view)                 | `view:beforeRender`                  | Vistas                                                  |
| [Vistas](view)                 | `view:beforeRenderView`              | View, View Engine Path                                  |
| [Vistas](view)                 | `view:notFoundView`                  | View, View Engine Path                                  |
| [Volt](volt)                   | `compileFilter`                      | Volt, [name, arguments, function arguments]             |
| [Volt](volt)                   | `compileFunction`                    | Volt, [name, arguments, function arguments]             |
| [Volt](volt)                   | `compileStatement`                   | Volt, [statement]                                       |
| [Volt](volt)                   | `resolveExpression`                  | Volt, [expression]                                      |

[db]: api/phalcon_db
[di-factorydefaul]: api/phalcon_di#di-factorydefault
[events-event]: api/phalcon_events#events-event
[events-eventsawareinterface]: api/phalcon_events#events-eventsawareinterface
[events-exception]: api/phalcon_events#events-exception
[events-manager]: api/phalcon_events#events-manager
[events-managerinterface]: api/phalcon_events#events-managerinterface
[splpriorityqueue]: https://www.php.net/manual/en/class.splpriorityqueue.php
