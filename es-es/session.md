---
layout: default
language: 'es-es'
version: '5.0'
title: 'Session'
upgrade: '#session'
keywords: 'sesión, gestor de sesiones, adaptadores de sesión, redis, libmemcached, none, stream'
---

# Session
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
Las sesiones se usan en PHP para persistir datos entre peticiones. Esto permite a los desarrolladores construir mejores aplicaciones y aumentar la experiencia de usuario. Un uso muy común de las sesiones es mantener si un usuario está conectado o no. [Phalcon\Session\Manager][session-manager] is an object-oriented approach to handle sessions using Phalcon. Hay varias razones para usar este componentes en lugar de las sesiones originales o acceder al superglobal `$_SESSION`:

- Aislar fácilmente datos de sesión en las aplicaciones en el mismo dominio
- Interceptar donde se establecen los datos de la sesión en su aplicación
- Cambiar el adaptador de la sesión según las necesidades de aplicación

## Manager
[Phalcon\Session\Manager][session-manager] is a component that allows you to manipulate sessions in your application. Este gestor acepta un adaptador que es la forma en que los datos se comunicarán a un almacén particular.

> **NOTE**: PHP uses the term `handler` for the component that will be responsible for storing and retrieving the data. En `Phalcon\Session\Manager` usamos el término `adaptador`. So in order to set a _handler_ in your session, for `Phalcon\Session\Manager` you need to call `setAdapter()`. La funcionalidad es la misma. 
> 
> {: .alert .alert-warning }


```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$session = new Manager();
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);
$session->setAdapter($files);
```

Primero necesitamos crear un objeto adaptador. The object can be one of the adapters distributed with Phalcon (see below) but it can also be an object that implements [SessionHandlerInterface][sessionhandlerinterface]. Once we instantiate the new [Phalcon\Session\Manager][session-manager] object and pass the adapter in it. Después de esto puede empezar a trabajar con la sesión.

### Constructor
```php
public function __construct(array $options = [])
```
El constructor acepta un vector de opciones relacionadas con la sesión. Puede establecer un id único para su sesión usando `uniqueId` como clave y su cadena id elegida. Esto le permite crear más de uno de estos objetos, cada uno con su propia id única, si es necesario. Este parámetro es opcional, pero es recomendable establecerlo siempre. Hacerlo le ayudará con posibles fugas de sesión.

### Iniciar
Para poder trabajar con la sesión, necesita iniciarla. `start()` realiza esta tarea. Normalmente esta llamada se hace cuando se registra el componente o en la parte superior del flujo de trabajo de su aplicación. `start()` devuelve un valor booleano que indica éxito o fallo.

> **NOTE**: - If the session has already started, the call will return `true`. - If any headers have been sent, it will return `false` - If the adapter is not set, it will throw an exception - It will return the result of `session_start()` 
> 
> {: .alert .alert-info }

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$session = new Manager();
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);
$session->setAdapter($files);

$session->start();
```

### Destruir
De manera similar, puede llamar a `destroy()` para matar la sesión. Normalmente esto ocurre cuando un usuario se desconecta.

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$session = new Manager();
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);
$session
    ->setAdapter($files)
    ->start();

// ....

$session->destroy();
```

### Existe
Para comprobar si su sesión ha comenzado, puede usar `exists()`

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$session = new Manager();
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);

var_dump(
    $session->exists()
);
// `false`

$session
    ->setAdapter($files)
    ->start();

var_dump(
    $session->exists()
);
// `true`
```

### Regenerar Id
[Phalcon\Session\Manager][session-manager] supports regenerating the session id. Esto le permite reemplazar el id de sesión actual con uno nuevo y mantener intacta la información de la sesión actual. Para lograr esto puede llamar a `regenerateId()`. Este método también acepta un parámetro `bool`, que es `true` indicará al componente que elimine el fichero de sesión anterior.

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$session = new Manager();
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);

$session
    ->setAdapter($files)
    ->start();

$session->regenerateId();
```

### Obtener
Puede usar `get()` para obtener los contenidos almacenados en la sesión para un elemento particular pasado como un parámetro cadena. The component also supports the magic getter, so you can retrieve it as a property of the manager.

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$session = new Manager();
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);

$session
    ->setAdapter($files)
    ->start();

echo $session->get('userId');
echo $session->userId;
```

### Has
Puede usar `has()` para comprobar si un elemento particular está almacenado en su sesión. Este componente también soporta el `__isset` mágico, lo que le permite usar el método `isset()` de PHP si lo desea.

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$session = new Manager();
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);

$session
    ->setAdapter($files)
    ->start();

echo $session->has('userId');
var_dump(
    isset($session->userId)
);
```

### Id
También puede configurar el id de sesión. The session id is set in an HTTP cookie. Puede establecer el nombre llamando a `setId()`. `getId()` se usa para recuperar el id de sesión.

> **NOTE**: You need call this method before calling `start()` for the id to take effect 
> 
> {: .alert .alert-info }

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$session = new Manager();
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);
$session
    ->setAdapter($files)
    ->setId('phalcon-id')
    ->start();

echo $session->getId(); // 'phalcon-id'
```

### Nombre
Cada sesión puede tener un nombre. The session name is set in an HTTP cookie. Si no está configurado, se usa el ajuste `session.name` de `php.ini`. Puede configurar el nombre llamando a `setName()`. `getName()` se usa para recuperar el nombre de la sesión.

> **NOTE**: You need to call this method before calling `start()` for the name to take effect 
> 
> {: .alert .alert-info }

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$session = new Manager();
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);
$session
    ->setAdapter($files)
    ->setName('phalcon-app')
    ->start();

echo $session->getName(); // 'phalcon-app'
```

### Opciones
Puede establecer opciones para el gestor usando `setOptions()`. The method accepts an array and in it, you can set the `uniqueId` for the session. Para obtener las opciones puede llamar a `getOptions()` que devolverá el vector de opciones almacenadas en el gestor.

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$session = new Manager('id-1');
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);
$session
    ->setAdapter($files)
    ->start();

$session->setOptions(
    [
        'uniqueId' => 'id-2'
    ]   
);
```

En el ejemplo anterior, después de llamar a `setOptions()` con un nuevo `uniqueId`, los datos se almacenarán usando `id-2` ahora y cualquier cosa almacenada antes no será accesible hasta que cambie la clave de vuelta a `id-1`.

### Establecer
Puede usar `set()` para almacenar contenidos en su sesión. El método acepta una `cadena` como nombre del elemento y el valor a ser almacenado. The component also supports the magic setter, so you can set it as a property of the manager.

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$session = new Manager();
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);

$session
    ->setAdapter($files)
    ->start();

$session->set('userId', 12345);
$session->userId = 12345;
```

### Eliminar
Para eliminar un elemento almacenado en la sesión, necesita llamar a `remove()` con el nombre del elemento. El componente también soporta el mágico `__unset` por lo que puede usar el método `unset()` de PHP si lo desea.

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$session = new Manager();
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);

$session
    ->setAdapter($files)
    ->start();

$session->remove('userId');
unset($session->userId);
```

## Adaptadores
### Libmemcached
[Phalcon\Session\Adapter\Libmemcached][session-adapter-libmemcached] uses the [Phalcon\Storage\Adapter\Libmemcached][storage-adapter-libmemcached] internally to store data in Memcached. In order to use this adapter you need the settings for Memcached and a [Phalcon\Storage\AdapterFactory][storage-adapter] object in order for the adapter to be created internally.

The available options for Memcached are:

| Nombre    | Descripción          |
| --------- | -------------------- |
| `client`  | client settings      |
| `servers` | array of server data |

The `servers` option is an array that contains the following options:

| Nombre   | Descripción               |
| -------- | ------------------------- |
| `host`   | the host                  |
| `port`   | the port                  |
| `weight` | the weight for the server |

```php
<?php

use Phalcon\Session\Adapter\Libmemcached;
use Phalcon\Session\Manager;
use Phalcon\Storage\AdapterFactory;
use Phalcon\Storage\SerializerFactory;

$options = [
    'client'  => [],
    'servers' => [
        [
            'host'   => '127.0.0.1',
            'port'   => 11211,
            'weight' => 0,
        ],
    ],
];

$session           = new Manager();
$serializerFactory = new SerializerFactory();
$factory           = new AdapterFactory($serializerFactory);
$libmemcached      = new Libmemcached($factory, $options);

$session
    ->setAdapter($libmemcached)
    ->start();
```

### Noop (No operación)
[Phalcon\Session\Adapter\Noop][session-adapter-noop] is an "empty" or `null` adapter. Se puede usar para testeo, una broma para tus colegas o cualquier otro propósito que no necesite invocar ninguna sesión.

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Noop;

$session = new Manager();
$session
    ->setAdapter(new Noop())
    ->start();
```

### Redis
[Phalcon\Session\Adapter\Redis][session-adapter-redis] uses the [Phalcon\Storage\Adapter\Redis][storage-adapter-redis] internally to store data in Redis. In order to use this adapter you need the settings for Redis and a [Phalcon\Storage\AdapterFactory][storage-adapter] object in order for the adapter to be created internally.

The available options for Redis are:

| Nombre       | Descripción                           |
| ------------ | ------------------------------------- |
| `host`       | the host                              |
| `port`       | the port                              |
| `index`      | the index                             |
| `persistent` | whether to persist connections or not |
| `auth`       | authentication parameters             |
| `socket`     | socket connection                     |

```php
<?php

use Phalcon\Session\Adapter\Redis;
use Phalcon\Session\Manager;
use Phalcon\Storage\AdapterFactory;
use Phalcon\Storage\SerializerFactory;

$options = [
    'host'  => '127.0.0.1',
    'port'  => 6379,
    'index' => '1',
];

$session           = new Manager();
$serializerFactory = new SerializerFactory();
$factory           = new AdapterFactory($serializerFactory);
$redis             = new Redis($factory, $options);

$session
    ->setAdapter($redis)
    ->start();
```

### Flujo (Stream)
Este adaptador es el más común, almacenando ficheros de sesión en el sistema de ficheros. You need to create a [Phalcon\Session\Adapter\Stream][session-adapter-stream] adapter with the `savePath` defined in the options. La ruta necesita ser escribible por el servidor web, de otro modo sus sesiones no funcionarán.

```php
<?php

use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$session = new Manager();
$files = new Stream(
    [
        'savePath' => '/tmp',
    ]
);

$session
    ->setAdapter($files)
    ->start();
```

### Personalizado
The adapters implement PHP's [SessionHandlerInterface][sessionhandlerinterface]. Como resultado, puede crear cualquier adaptador que necesite extendiendo este interfaz. You can also use any adapter that implements this interface and set the adapter to [Phalcon\Session\Manager][session-manager]. There are more adapters available for this component in the [Phalcon Incubator][incubator].

```php
<?php

namespace MyApp\Session\Adapter;

use SessionHandlerInterface;

class Custom extends SessionHandlerInterface
{
    public function close() -> bool;

    public function destroy($sessionId) -> bool;

    public function gc(int $maxlifetime) -> bool;

    public function read($sessionId) -> string;

    public function open($savePath, $sessionName) -> bool;

    public function write($sessionId, $data) -> bool;
}
```

## Excepciones
Any exceptions thrown in the Session component will be of type [Phalcon\Session\Exception][session-exception]. Se lanza si alguna operación de sesión no se completa correctamente. Puede usar estas excepciones para capturar selectivamente sólo las excepciones lanzadas desde este componente.

```php
<?php

use Phalcon\Session\Exception;
use Phalcon\Session\Manager;
use Phalcon\Mvc\Controller;

/**
 * @property Manager $session
 */
class IndexController extends Controller
{
    public function index()
    {
        try {
            $this->session->set('key', 'value');
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
```

## Bag
[Phalcon\Session\Bag][session-bag] is a component that helps to separate session data into `namespaces`. De esta forma puede crear grupos de variables de sesión para su aplicación. Configurar datos en la bolsa los almacena automáticamente en la sesión:

```php
<?php

use Phalcon\Di;
use Phalcon\Session\Bag as SessionBag;

$container = new Di();
$user      = new SessionBag('user');

$user->setDI($container);

$user->name     = 'Dark Helmet';
$user->password = 12345;
```

## Inyección de Dependencias
If you use the [Phalcon\Di\FactoryDefault][di-factorydefault] container you can register your session manager. A continuación, un ejemplo de registro del servicio así como de acceso a él:

```php
<?php

use Phalcon\Di;
use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;

$container = new Di();

$container->set(
    'session',
    function () {
        $session = new Manager();
        $files = new Stream(
            [
                'savePath' => '/tmp',
            ]
        );

        $session
            ->setAdapter($files)
            ->start();

        return $session;
    }
);
```

After registering the manager you can access your session from controllers, views or any other components that extend [Phalcon\Di\Injectable][di-injectable] as follows:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Session\Manager;

/**
 * @property Manager $session
 */
class InvoicesController extends Controller
{
    public function indexAction()
    {
        // Set a session variable
        $this->session->set('user-name', 'Dark Helmet');
    }
}
```

## Datos Persistentes
You can also inject the [Phalcon\Session\Bag][session-bag] component. Hacerlo le ayudará a aislar variables para cada clase sin contaminar la sesión. Este componente se registra automáticamente usando el nombre de propiedad `persistent`. Anything set in `$this->persist` will only be available in each class itself, whereas if data is set in the session manager will be available throughout the application.

In a controller:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Session\Bag;
use Phalcon\Session\Manager;

/**
 * @property Bag     $persistent
 * @property Manager $session
 */
class InvoicesController extends Controller
{
    public function indexAction()
    {
        // Set a session variable
        $this->persistent->name = 'Dark Helmet';
        $this->session->name    = 'Princess Vespa';
    }

    public function echoAction()
    {
        // Set a session variable
        echo $this->persistent->name; // 'Dark Helmet';
        echo $this->session->name;    // 'Princess Vespa';
    }
}
```

In a component:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Session\Bag;
use Phalcon\Session\Manager;

/**
 * @property Bag     $persistent
 * @property Manager $session
 */
class InvoicesController extends Controller
{
    public function indexAction()
    {
        // Set a session variable
        $this->persistent->name = 'President Skroob';
    }

    public function echoAction()
    {
        // Set a session variable
        echo $this->persistent->name; // 'President Skroob';
        echo $this->session->name;    // 'Princess Vespa';
    }
}
```

[di-factorydefault]: api/phalcon_di#di-factorydefault
[di-injectable]: api/phalcon_di#di-injectable
[incubator]: https://github.com/phalcon/incubator/
[session-adapter-libmemcached]: api/phalcon_session#session-adapter-libmemcached
[session-adapter-noop]: api/phalcon_session#session-adapter-noop
[session-adapter-redis]: api/phalcon_session#session-adapter-redis
[session-adapter-stream]: api/phalcon_session#session-adapter-stream
[session-bag]: api/phalcon_session#session-bag
[session-exception]: api/phalcon_session#session-exception
[session-manager]: api/phalcon_session#session-manager
[sessionhandlerinterface]: https://www.php.net/manual/en/class.sessionhandlerinterface.php
[storage-adapter]: api/phalcon_storage#storage-adapterfactory
[storage-adapter-libmemcached]: api/phalcon_storage#storage-adapter-libmemcached
[storage-adapter-redis]: api/phalcon_storage#storage-adapter-redis
