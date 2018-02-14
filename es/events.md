<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Gestor de Eventos</a> <ul>
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

<h5 class='alert alert-warning'>Debe configurar explícitamente el administrador de eventos de un componente mediante el método <code>setEventsManager()</code> de tal forma que el componente disparare los eventos. Usted puede crear una nueva instancia del gestor de eventos para cada componente o puede establecer el mismo gestor de eventos para varios componentes, ya que la convención de nombres evitará conflictos </h5>

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

Adjuntar un detector de eventos al administrador de eventos es tan simple como:

```php
<?php

// Crear un oyente de base de datos
$dbListener = new MyDbListener();

// Escuchar todos los evento de la base de datos
$eventsManager->attach(
    'db',
    $dbListener
);
```

Los datos de perfil resultantes se pueden obtener del oyente:

```php
<?php

// Enviar un comando SQL al servidor de base de datos
$connection->execute(
    'SELECT * FROM products p WHERE p.status = 1'
);

foreach ($dbListener->getProfiler()->getProfiles() as $profile) {
    echo 'Declaración SQL: ', $profile->getSQLStatement(), '\n';
    echo 'Tiempo de inicio: ', $profile->getInitialTime(), '\n';
    echo 'Tiempo final: ', $profile->getFinalTime(), '\n';
    echo 'Tiempo total: ', $profile->getTotalElapsedSeconds(), '\n';
}
```

<a name='components-that-trigger-events'></a>

## Creando Componentes que Desencadenan Eventos

Es posible crear componentes en su aplicación que activen eventos de un EventsManager. Como consecuencia, pueden existir oyentes que reaccionan a estos eventos cuando se generan. En el siguiente ejemplo estamos creando un componente llamado `MyComponent`. Este componente es consciente de EventsManager (implementa `Phalcon\Events\EventsAwareInterface`); Cuando se ejecuta el método `someTask()` dispara dos eventos a cualquier oyente en el EventsManager:

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

        // Hacer algunas tareas
        echo 'Aquí, someTask\n';

        $this->eventsManager->fire('my-component:afterSomeTask', $this);
    }
}
```

Observe que en este ejemplo, estamos utilizando el espacio de nombres de eventos de `my-component`. Ahora necesitamos crear un detector de eventos para este componente:

```php
<?php

use Phalcon\Events\Event;

class SomeListener
{
    public function beforeSomeTask(Event $event, $myComponent)
    {
        echo "Aquí, beforeSomeTask\n";
    }

    public function afterSomeTask(Event $event, $myComponent)
    {
        echo "Aquí, afterSomeTask\n";
    }
}
```

Ahora vamos a hacer que todo trabaje junto:

```php
<?php

use Phalcon\Events\Manager as EventsManager;

// Crear un gestor de eventos
$eventsManager = new EventsManager();

// Crear una instancia de MyComponent
$myComponent = new MyComponent();

// Vincular el eventsManager con la instancia
$myComponent->setEventsManager($eventsManager);

// Adjuntar el oyente al the EventsManager
$eventsManager->attach(
    'my-component',
    new SomeListener()
);

// Ejecutar métodos en el componente
$myComponent->someTask();
```

Como `someTask()` es ejecutado, se ejecutarán los dos métodos en el oyente, produciendo la siguiente salida:

```bash
Aquí, beforeSomeTask
Aquí, someTask
Aquí, afterSomeTask
```

Datos adicionales también se pueden pasar al desencadenar un evento usando el tercer parámetro del método `fire()`:

```php
<?php

$eventsManager->fire('my-component:afterSomeTask', $this, $extraData);
```

En el oyente, el tercer parámetro también recibe estos datos:

```php
<?php

use Phalcon\Events\Event;

// Recibiendo los datos en el tercer parámetro
$eventsManager->attach(
    'my-component',
    function (Event $event, $component, $data) {
        print_r($data);
    }
);

// Recibiendo los datos desde el contexto del evento
$eventsManager->attach(
    'my-component',
    function (Event $event, $component) {
        print_r($event->getData());
    }
);
```

<a name='using-services'></a>

## Utilización Servicios del DI

Al extender el `Phalcon\Mvc\User\Plugin`, usted puede acceder a los servicios del DI, como haría en un controlador:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;

class SomeListener extends Plugin
{
    public function beforeSomeTask(Event $event, $myComponent)
    {
        echo 'Aquí, beforeSomeTask\n';

        $this->logger->debug(
            'beforeSomeTask ha sido ejecutado'
        );
    }

    public function afterSomeTask(Event $event, $myComponent)
    {
        echo 'Aquí, afterSomeTask\n';

        $this->logger->debug(
            'afterSomeTask ha sido ejecutado'
        );
    }
}
```

<a name='propagation-cancellation'></a>

## Propagación y Cancelación de Eventos

Muchos oyentes pueden ser agregados al mismo gestor de eventos. Esto significa que para el mismo tipo de evento, muchos oyentes pueden ser notificados. Los oyentes son notificados en el mismo orden que fueron registrados en el EventsManager. Algunos eventos son cancelables, indicando que se puede detener para evitar que otros oyentes sean notificados sobre el evento:

```php
<?php

use Phalcon\Events\Event;

$eventsManager->attach(
    'db',
    function (Event $event, $connection) {
        // Detenemos el evento si es cancelable
        if ($event->isCancelable()) {
            // Detenemos el evento, entonces los demás oyentes no serán notificados sobre esto
            $event->stop();
        }

        // ...
    }
);
```

Por defecto, los eventos son cancelables, incluso la mayoria de los eventos producidos por el framework son cancelables. Es posible disparar un evento no cancelable pasando el valor `false` en el cuarto parámetro del evento `fire()`:

```php
<?php

$eventsManager->fire('my-component:afterSomeTask', $this, $extraData, false);
```

<a name='listener-priorities'></a>

## Prioridades del Oyente

Cuando adjuntamos oyentes es posible especificar su prioridad. Con esta característica puede adjuntar oyentes indicando el orden en el que deben ser llamados:

```php
<?php

$eventsManager->enablePriorities(true);

$eventsManager->attach('db', new DbListener(), 150); // Más prioridad
$eventsManager->attach('db', new DbListener(), 100); // Prioridad normal
$eventsManager->attach('db', new DbListener(), 50);  // Menos prioridad
```

<a name='collecting-responses'></a>

## Recogiendo Respuestas

El gestor de eventos puede recoger cada respuesta devuelta por cada oyente notificado. Este ejemplo explica como funciona esto:

```php
<?php

use Phalcon\Events\Manager as EventsManager;

$eventsManager = new EventsManager();

// Establecer el gestor de eventos para recoger respuestas
$eventsManager->collectResponses(true);

// Adjuntar un oyente
$eventsManager->attach(
    'custom:custom',
    function () {
        return 'primer respuesta';
    }
);

// Adjuntar un oyente
$eventsManager->attach(
    'custom:custom',
    function () {
        return 'segunda respuesta';
    }
);

// Ejecutar el evento
$eventsManager->fire('custom:custom', null);

// Obtener todas las respuestas recogidas
print_r($eventsManager->getResponses());
```

El ejemplo anterior produce lo siguiente:

```php
    Array ( [0] => primer respuesta [1] => segunda respuesta )
```

<a name='custom'></a>

## Implementando tu propio EventsManager

Debe implementar la interfaz `Phalcon\Events\ManagerInterface` para crear su propio EventManager reemplazando a uno proporcionado por Phalcon.

<a name='list'></a>

## Lista de Eventos

Los eventos disponibles en Phalcon son:

| Componente         | Evento                              |
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
| Model              | `afterDelete`                       |
| Model              | `afterCreate`                       |
| Model              | `afterSave`                         |
| Model              | `afterUpdate`                       |
| Model              | `afterValidation`                   |
| Model              | `afterValidationOnCreate`           |
| Model              | `afterValidationOnUpdate`           |
| Model              | `beforeDelete`                      |
| Model              | `notDeleted`                        |
| Model              | `beforeCreate`                      |
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