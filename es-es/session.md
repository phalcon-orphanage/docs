---
layout: default
language: 'es-es'
version: '4.0'
title: 'Session'
keywords: 'sesión, gestor de sesiones, adaptadores de sesión, redis, libmemcached, none, stream'
---

# Session

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

Las sesiones se usan en PHP para persistir datos entre peticiones. Esto permite a los desarrolladores construir mejores aplicaciones y aumentar la experiencia de usuario. Un uso muy común de las sesiones es mantener si un usuario está conectado o no. [Phalcon\Session\Manager](api/Phalcon_Session#session-manager) es un enfoque orientado a objetos para gestionar sesiones usando Phalcon. Hay varias razones para usar este componentes en lugar de las sesiones originales o acceder al superglobal `$_SESSION`:

- Aislar fácilmente datos de sesión en las aplicaciones en el mismo dominio
- Interceptar donde se establecen los datos de la sesión en su aplicación
- Cambiar el adaptador de la sesión según las necesidades de aplicación

## Manager

[Phalcon\Session\Manager](api/Phalcon_Session#session-manager) es un componente que le permite manipular sesiones en su aplicación. Este gestor acepta un adaptador que es la forma en que los datos se comunicarán a un almacén particular.

> **NOTA**: PHP usa el término `manejador` para el componente que será responsable de almacenar y recuperar los datos. En `Phalcon\Session\Manager` usamos el término `adaptador`. Así que para establecer un *manejador* en su sesión, para `Phalcon\Session\Manager` necesitará llamar a `setAdapter()`. La funcionalidad es la misma.
{: .alert .alert-warning }


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

Primero necesitamos crear un objeto adaptador. El objeto puede ser uno de los adaptadores distribuidos con Phalcon (ver abajo) también puede ser un objeto que implemente [SessionHandlerInterface](https://www.php.net/manual/en/class.sessionhandlerinterface.php). Una vez que instanciamos el nuevo objeto [Phalcon\Session\Manager](api/Phalcon_Session#session-manager) y le pasamos el adaptador. Después de esto puede empezar a trabajar con la sesión.

### Constructor

```php
public function __construct(array $options = [])
```

El constructor acepta un vector de opciones relacionadas con la sesión. Puede establecer un id único para su sesión usando `uniqueId` como clave y su cadena id elegida. Esto le permite crear más de uno de estos objetos, cada uno con su propia id única, si es necesario. Este parámetro es opcional, pero es recomendable establecerlo siempre. Hacerlo le ayudará con posibles fugas de sesión.

### Iniciar

Para poder trabajar con la sesión, necesita iniciarla. `start()` realiza esta tarea. Normalmente esta llamada se hace cuando se registra el componente o en la parte superior del flujo de trabajo de su aplicación. `start()` devuelve un valor booleano que indica éxito o fallo.

> **NOTA**: - Si la sesión ya se ha iniciado, la llamada devolverá `true`. - Si ya se ha enviado alguna cabecera, devolverá `false` - Si el adaptador no está definido, lanzará una excepción - Devolverá el resultado de `session_start()`
{: .alert .alert-info } 

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

[Phalcon\Session\Manager](api/Phalcon_Session#session-manager) soporta la regeneración del id de sesión. Esto le permite reemplazar el id de sesión actual con uno nuevo y mantener intacta la información de la sesión actual. Para lograr esto puede llamar a `regenerateId()`. Este método también acepta un parámetro `bool`, que es `true` indicará al componente que elimine el fichero de sesión anterior.

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

Puede usar `get()` para obtener los contenidos almacenados en la sesión para un elemento particular pasado como un parámetro cadena. El componente también soporta el *getter* mágico para que pueda recuperarlo como una propiedad del gestor.

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

### Tiene

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

También puede configurar el id de sesión. El id de sesión se establece en una cookie HTTP. Puede establecer el nombre llamando a `setId()`. `getId()` se usa para recuperar el id de sesión.

> **NOTA**: Necesita llamar a este método antes de llamar a `start()` para que el id tenga efecto
{: .alert .alert-info }

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

Cada sesión puede tener un nombre. El nombre de sesión se establece en una cookie HTTP. Si no está configurado, se usa el ajuste `session.name` de `php.ini`. Puede configurar el nombre llamando a `setName()`. `getName()` se usa para recuperar el nombre de la sesión.

> **NOTA**: Necesita llamar a este método antes de llamar a `start()` para que el nombre tenga efecto
{: .alert .alert-info }

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

Puede establecer opciones para el gestor usando `setOptions()`. El método acepta un vector y en él puede establecer el `uniqueId` para la sesión. Para obtener las opciones puede llamar a `getOptions()` que devolverá el vector de opciones almacenadas en el gestor.

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

Puede usar `set()` para almacenar contenidos en su sesión. El método acepta una `cadena` como nombre del elemento y el valor a ser almacenado. El componente también soporta el *setter* mágico para que pueda establecerlo como propiedad del gestor.

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

[Phalcon\Session\Adapter\Libmemcached](api/Phalcon_Session#session-adapter-libmemcached) usa [Phalcon\Storage\Adapter\Libmemcached](api/Phalcon_Storage#storage-adapter-libmemcached) internamente para almacenar datos en Memcached. Para poder usar este adaptador necesita los ajustes de Memcached y un objeto [Phalcon\Storage\AdapterFactory](api/Phalcon_Storage#storage-adapterfactory) para que el adaptador se cree internamente.

Las opciones disponibles para Memcached son: - `client` - ajustes de cliente - `servers` - vector de datos del servidor - `host` - el servidor - `port` - el puerto - `weight` - el peso del servidor

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

[Phalcon\Session\Adapter\Noop](api/Phalcon_Session#session-adapter-noop) es un adaptador "vacío" o `null`. Se puede usar para testeo, una broma para tus colegas o cualquier otro propósito que no necesite invocar ninguna sesión.

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

[Phalcon\Session\Adapter\Redis](api/Phalcon_Session#session-adapter-redis) usa [Phalcon\Storage\Adapter\Redis](api/Phalcon_Storage#storage-adapter-redis) internamente para almacenar datos en Redis. Para poder usar este adaptador necesita los ajustes de Redis y un objeto [Phalcon\Storage\AdapterFactory](api/Phalcon_Storage#storage-adapterfactory) para que el adaptador se cree internamente.

Las opciones disponibles para Redis son: - `host` - el servidor - `port` - el puerto - `index` - el índice - `persistent` - si persistir las conexiones o no - `auth` - parámetros de autenticación - `socket` - conexión del socket

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

### Stream (flujo)

Este adaptador es el más común, almacenando ficheros de sesión en el sistema de ficheros. Necesita crear un adaptador [Phalcon\Session\Adapter\Stream](api/Phalcon_Session#session-adapter-stream) con el `savePath` definido en las opciones. La ruta necesita ser escribible por el servidor web, de otro modo sus sesiones no funcionarán.

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

Los adaptadores implementan [SessionHandlerInterface](https://www.php.net/manual/en/class.sessionhandlerinterface.php) de PHP. Como resultado, puede crear cualquier adaptador que necesite extendiendo este interfaz. También puede usar cualquier adaptador que implemente este interfaz y establecer el adaptador en [Phalcon\Session\Manager](api/Phalcon_Session#session-manager). Hay más adaptadores disponibles para este componente en [Phalcon Incubator](https://github.com/phalcon/incubator/).

```php
<?php

namespace MyApp\Session\Adapter;

use SessionHandlerInterface;

class Custom extends SessionHandlerInterface
{
    /**
     * Close
     */
    public function close() -> bool;

    /**
     * Destroy
     */
    public function destroy($sessionId) -> bool;

    /**
     * Garbage Collector
     */
    public function gc($maxlifetime) -> bool;

    /**
     * Read
     */
    public function read($sessionId) -> string;

    /**
     * Open
     */
    public function open($savePath, $sessionName) -> bool;

    /**
     * Write
     */
    public function write($sessionId, $data) -> bool;
}
```

## Excepciones

Cualquier excepción lanzada en el componente `Session` será del tipo [Phalcon\Session\Exception](api/Phalcon_Session#session-exception). Se lanza si alguna operación de sesión no se completa correctamente. Puede usar estas excepciones para capturar selectivamente sólo las excepciones lanzadas desde este componente.

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

[Phalcon\Session\Bag](api/Phalcon_Session#session-bag) es un componente que ayuda a separar datos de sesión en `espacios de nombres`. De esta forma puede crear grupos de variables de sesión para su aplicación. Configurar datos en la bolsa los almacena automáticamente en la sesión:

```php
<?php

use Phalcon\Di;
use Phalcon\Session\Manager;
use Phalcon\Session\Adapter\Stream;
use Phalcon\Session\Bag as SessionBag;

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

$user = new SessionBag('user');

$user->setDI($container);

$user->name     = 'Dark Helmet';
$user->password = 12345;
```

## Inyección de Dependencias

Si usa el contenedor [Phalcon\Di\FactoryDefault](api/Phalcon_Di#di-factorydefault) puede registrar su gestor de sesión. A continuación, un ejemplo de registro del servicio así como de acceso a él:

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

Después de registrar el gestor puede acceder a su sesión desde controladores, vistas o cualquier otro componente que extienda [Phalcon\Di\Injectable](api/Phalcon_Di#di-injectable) de la siguiente manera:

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

También puede inyectar el componente [Phalcon\Session\Bag](api/Phalcon_Session#session-bag). Hacerlo le ayudará a aislar variables para cada clase sin contaminar la sesión. Este componente se registra automáticamente usando el nombre de propiedad `persistent`.

> NOTE: A `session` service must be present for the `persistent` service to work and persist the data
{: .alert .alert-warning }

In your providers/services setup:

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
