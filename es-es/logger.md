---
layout: default
language: 'es-es'
version: '4.0'
upgrade: '#logger'
title: 'Logger'
keywords: 'psr-3, logger, adapters, noop, stream, syslog'
---

# Logger

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Controladores

[Phalcon\Logger](api/phalcon_logger#logger-logger) is a component providing logging services for applications. It offers logging to different back-ends using different adapters. It also offers transaction logging, configuration options and different logging formats. You can use the [Phalcon\Logger](api/phalcon_logger#logger-logger) for any logging need your application has, from debugging processes to tracing application flow.

![](/assets/images/implements-psr--3-blue.svg)

The [Phalcon\Logger](api/phalcon_logger#logger-logger) has been rewritten to comply with [PSR-3](https://www.php-fig.org/psr/psr-3/). This allows you to use the [Phalcon\Logger](api/phalcon_logger#logger-logger) to any application that utilizes a [PSR-3](https://www.php-fig.org/psr/psr-3/) logger, not just Phalcon based ones.

En Phalcon v3.x el componente trae incorporado el adaptador. Esto en esencia significa que cuando se inicia el objeto de registro, el desarrollador está en realidad creando un adaptador (de archivo, flujo, etc.) con capacidad de registro.

En Phalcon v4 el componente se reescribió de tal manera que se dedica a la función de registro y acepta uno o más adaptadores que serán los responsables de las tareas de registro. Así se logra la compatibilidad con [PSR-3](https://www.php-fig.org/psr/psr-3/), se separan las responsabilidades del componente y se logra la funcionalidad de registro múltiple: fácilmente se puede agregar más de un adaptador al componente, cada uno realizando su propio registro. Con esta implementación se redujo el código del registro y se supimió el componente `Logger\Multiple`.

## Adaptadores

El componente registro hace uso de diversos adaptadores para guardar los mensajes. El uso de adaptadores permite una interfaz común de registro de mensajes y proporciona la capacidad de cambiar fácilmente de backend o utilizar múltiples adaptadores en caso de ser necesario. Los adaptadores disponibles son:

| Adaptador                                                                    | Descripción                                 |
| ---------------------------------------------------------------------------- | ------------------------------------------- |
| [Phalcon\Logger\Adapter\Noop](api/phalcon_logger#logger-adapter-noop)     | Blackhole adapter (used for testing mostly) |
| [Phalcon\Logger\Adapter\Stream](api/phalcon_logger#logger-adapter-stream) | Logs messages on a file stream              |
| [Phalcon\Logger\Adapter\Syslog](api/phalcon_logger#logger-adapter-syslog) | Logs messages to the Syslog                 |

### Stream (flujo)

Se usa para registrar mensajes en un archivo de flujo. Combina los adaptadores de v3 `Stream` y `File`. Es el de uso más extendido: llevar el registro en un archivo del sistema de archivos.

### Syslog (Registro del sistema)

Se usa para guardar los mensajes en el registro del sistema (*Syslog*). El comportamiento del *syslog* puede variar de un sistema operativo a otro.

### Noop (No operación)

Este adaptador es un agujero negro: ¡Envía mensajes al *infinito y más allá!* Se usa especialmente para pruebas --o para hacerle una broma a un colega.

## Factory

You can use the [Phalcon\Logger\LoggerFactory](api/phalcon_logger#logger-loggerfactory) component to create a logger. For the [Phalcon\Logger\LoggerFactory](api/phalcon_logger#logger-loggerfactory) to work, it needs to be instantiated with an [Phalcon\Logger\AdapterFactory](api/phalcon_logger#logger-adapterfactory):

```php
<?php

use Phalcon\Logger\LoggerFactory;
use Phalcon\Logger\AdapterFactory;

$adapterFactory = new AdapterFactory();
$loggerFactory  = new LoggerFactory($adapterFactory);
```

### `load()`

[Phalcon\Logger\LoggerFactory](api/phalcon_logger#logger-loggerfactory) offers the `load` method, that constructs a logger based on supplied configuration. The configuration can be an array or a [Phalcon\Config](config) object.

> **NOTE**: Use Case: Create a Logger with two Stream adapters. One adapter will be called `main` for logging all messages, while the second one will be called `admin`, logging only messages generated in the admin area of our application 
{: .alert .alert-info}

```php
<?php

use Phalcon\Logger\AdapterFactory;
use Phalcon\Logger\LoggerFactory;

$config = [
    "name"     => "prod-logger",
    "adapters" => [
        "main"  => [
            "adapter" => "stream",
            "file"    => "/storage/logs/main.log",
            "options" => []
        ],
        "admin" => [
            "adapter" => "stream",
            "file"    => "/storage/logs/admin.log",
            "options" => []
        ],
    ],
];

$adapterFactory = new AdapterFactory();
$loggerFactory  = new LoggerFactory($adapterFactory);

$logger = $loggerFactory->load($config);
```

### `newInstance()`

The [Phalcon\Logger\LoggerFactory](api/phalcon_logger#logger-loggerfactory) also offers the `newInstance()` method, that constructs a logger based on the supplied name and array of relevant adapters. Using the use case above:

```php
<?php

use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\AdapterFactory;
use Phalcon\Logger\LoggerFactory;

$adapters = [
    "main"  => new Stream("/storage/logs/main.log"),
    "admin" => new Stream("/storage/logs/admin.log"),
];

$adapterFactory = new AdapterFactory();
$loggerFactory  = new LoggerFactory($adapterFactory);

$logger = $loggerFactory->newInstance('prod-logger', $adapters);
```

## Creating a Logger

La creación de un registro se hace en varios pasos. Primero, se crea un objeto de registro y, segundo, se incluye un adaptador. Cumplidos estos pasos, se pueden empezar a registar mensajes según las necesidades de la aplicación.

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter = new Stream('/storage/logs/main.log');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

The above example creates a [Stream](api/phalcon_logger#logger-adapter-stream) adapter. Luego se crea un objeto de registro y se le adjunta el adaptador. Cada adaptador debe tener un nombre único, de tal manera que el registro sepa dónde guardar los mensajes. When calling the `error()` method on the logger object, the message is going to be stored in the `/storage/logs/main.log`.

Dado que el componente de registro implementa PSR-3, los siguientes métodos están disponibles:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter = new Stream('/storage/logs/main.log');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->alert("This is an alert message");
$logger->critical("This is a critical message");
$logger->debug("This is a debug message");
$logger->error("This is an error message");
$logger->emergency("This is an emergency message");
$logger->info("This is an info message");
$logger->log(Logger::CRITICAL, "This is a log message");
$logger->notice("This is a notice message");
$logger->warning("This is a warning message");

```

El resultado de los anteriores mensajes registrados es:

```bash
[Tue, 25 Dec 18 12:13:14 -0400][ALERT] Este es un mensaje de alerta
[Tue, 25 Dec 18 12:13:14 -0400][CRITICAL] Este es un mensaje de alerta crítica
[Tue, 25 Dec 18 12:13:14 -0400][DEBUG] Este es un mensaje de depuración
[Tue, 25 Dec 18 12:13:14 -0400][ERROR] Este es un mensaje de error
[Tue, 25 Dec 18 12:13:14 -0400][EMERGENCY] Este es un mensaje de emergencia
[Tue, 25 Dec 18 12:13:14 -0400][INFO] Este es un mensaje de información
[Tue, 25 Dec 18 12:13:14 -0400][CRITICAL] Este es un mensaje de registro
[Tue, 25 Dec 18 12:13:14 -0400][NOTICE] Este es un mensaje informativo
[Tue, 25 Dec 18 12:13:14 -0400][WARNING] Este es un mensaje de advertencia
```

## Multiple Adapters

[Phalcon\Logger](api/phalcon_logger#logger-logger) can send messages to multiple adapters with a just single call:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter1 = new Stream('/logs/first-log.log');
$adapter2 = new Stream('/remote/second-log.log');
$adapter3 = new Stream('/manager/third-log.log');

$logger = new Logger(
    'messages',
    [
        'local'   => $adapter1,
        'remote'  => $adapter2,
        'manager' => $adapter3,
    ]
);

// Log to all adapters
$logger->error('Algo falló');
```

Los mensajes se envían a los gestores en el orden en que fueron registrados según el principio [Primero en entrar, primero en salir](https://en.wikipedia.org/wiki/FIFO_(computing_and_electronics)).

### Excluding Adapters

[Phalcon\Logger](api/phalcon_logger#logger-logger) also offers the ability to exclude logging to one or more adapters when logging a message. En especial, por ejemplo, cuando es necesario registrar un mensaje en el adaptador `manager` pero no en el adaptador `local` sin necesidad de instanciar un nuevo registro:

With the following setup:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter1 = new Stream('/logs/first-log.log');
$adapter2 = new Stream('/remote/second-log.log');
$adapter3 = new Stream('/manager/third-log.log');

$logger = new Logger(
    'messages',
    [
        'local'   => $adapter1,
        'remote'  => $adapter2,
        'manager' => $adapter3,
    ]
);
```

we have the following:

```php
<?php

$logger->error('Something went wrong');
```

Log to all adapters

```php
<?php

$logger
    ->excludeAdapters(['local'])
    ->info('This does not go to the "local" logger');
```

Log only to remote and manager

> **NOTE** Internally, the component loops through the registered adapters and calls the relevant logging method to achieve logging to multiple adapters. If one of them fails, the loop will break and the remaining adapters (from the loop) will not log the message. In future versions of Phalcon we will be introducing asynchronous logging to alleviate this problem.
{: .alert .alert-warning }

## Constantes

The class offers a number of constants that can be used to distinguish between log levels. These constants can also be used as the first parameter in the `log()` method.

| Constante   | Value |
| ----------- |:-----:|
| `EMERGENCY` |   0   |
| `CRITICAL`  |   1   |
| `ALERT`     |   2   |
| `ERROR`     |   3   |
| `WARNING`   |   4   |
| `NOTICE`    |   5   |
| `INFO`      |   6   |
| `DEBUG`     |   7   |
| `CUSTOM`    |   8   |

## Log Levels

[Phalcon\Logger](api/phalcon_logger#logger-logger) allows you to set the minimum log level for the logger(s) to log. If you set this integer value, any level higher in number than the one set will not be logged. Check the values of the constants in the previous section for the order that the levels are being set.

In the following example, we set the log level to `ALERT`. We will only see `EMERGENCY`, `CRITICAL` **and** `ALERT` messages.

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter = new Stream('/storage/logs/main.log');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->setLogLevel(Logger::ALERT);

$logger->alert("This is an alert message");
$logger->critical("This is a critical message");
$logger->debug("This is a debug message");
$logger->error("This is an error message");
$logger->emergency("This is an emergency message");
$logger->info("This is an info message");
$logger->log(Logger::CRITICAL, "This is a log message");
$logger->notice("This is a notice message");
$logger->warning("This is a warning message");

```

El resultado de los anteriores mensajes registrados es:

```bash
[Tue, 25 Dec 18 12:13:14 -0400][ALERT] This is an alert message
[Tue, 25 Dec 18 12:13:14 -0400][CRITICAL] This is a critical message
[Tue, 25 Dec 18 12:13:14 -0400][EMERGENCY] This is an emergency message
[Tue, 25 Dec 18 12:13:14 -0400][CRITICAL] This is a log message
```

The above can be used in situations where you want to log messages above a certain severity based on conditions in your application such as development mode vs. production.

> **NOTE**: The log level set is included in the logging. Anything **below** that level (i.e. higher number) will not be logged
{: .alert .alert-info }

> 
> **NOTE**: It is **never** a good idea to suppress logging levels in your application, since even warning errors do require CPU cycles to be processed and neglecting these errors could potentially lead to unintended circumstances 
{: .alert .alert-danger }

## Transacciones

[Phalcon\Logger](api/phalcon_logger#logger-logger) also offers the ability to queue the messages in your logger, and then *commit* them all together in the log file. This is similar to a database transaction with `begin` and `commit`. Each adapter exposes the following methods: - `begin` - begins the logging transaction - `inTransaction` - `bool` if you are in a transaction or not - `commit` - writes all the queued messages in the log file

Since the functionality is available at the adapter level, you can program your logger to use transactions on a per adapter basis.

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter1 = new Stream('/logs/first-log.log');
$adapter2 = new Stream('/remote/second-log.log');
$adapter3 = new Stream('/manager/third-log.log');

$logger = new Logger(
    'messages',
    [
        'local'   => $adapter1,
        'remote'  => $adapter2,
        'manager' => $adapter3,
    ]
);

$logger->getAdapter('manager')->begin();

$logger->error('Something happened');

$logger->getAdapter('manager')->commit();
```

In the example above, we register three adapters. We set the `manager` logger to be in transaction mode. As soon as we call:

```php
$logger->error('Something happened');
```

the message will be logged in both `local` and `remote` adapters. It will be queued for the `manager` adapter and not logged until we call the `commit` method in the `manager` adapter.

> **NOTE**: If you set one or more adapters to be in transaction mode (i.e. call `begin`) and forget to call `commit`, The adapter will call `commit` for you right before it is destroyed.
{: .alert .alert-info }
## Formato de mensaje

Este componente utiliza `formatters` para formatear mensajes antes de enviarlos al backend. Los formateadores disponibles son:

| Adaptador                                                                    | Descripción                                  |
| ---------------------------------------------------------------------------- | -------------------------------------------- |
| [Phalcon\Logger\Formatter\Line](api/phalcon_logger#logger-formatter-line) | Formats the message on a single line of text |
| [Phalcon\Logger\Formatter\Json](api/phalcon_logger#logger-formatter-json) | Formats the message in a JSON string         |

### Formateador de línea

Formatea los mensajes utilizando una cadena de una línea. El formato por defecto de los mensajes es:

```bash
[%date%][%type%] %message%
```

#### Message Format

En caso de que el formato predeterminado no se ajuste a las necesidades de la aplicación, se puede personalizar mediante el método `setFormat()`. Las variables de formato de registro permitidas son:

| Variable    | Descripción                        |
| ----------- | ---------------------------------- |
| `%message%` | El mensaje que se espera registrar |
| `%date%`    | Fecha que del mensaje fue agregado |
| `%type%`    | Tipo de mensaje en mayúsculas      |

Ejemplo de cómo modificar el formato del mensaje:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Formatter\Line;

$formatter = new Line('[%type%] - [%date%] - %message%');
$adapter   = new Stream('/storage/logs/main.log');

$adapter->setFormatter($formatter);

$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

Resultado:

```bash
[ALERT] - [Tue, 25 Dec 18 12:13:14 -0400] - Algo falló
```

Ahora bien, para evitar el uso del constructor para modificar el mensaje, es posible utilizar siempre `setFormat()` para formatearlo:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Formatter\Line;

$formatter = new Line();
$formatter->setFormat('[%type%] - [%date%] - %message%');

$adapter = new Stream('/storage/logs/main.log');

$adapter->setFormatter($formatter);

$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

#### Date Format

El formato predeterminado es:

```bash
"D, d M y H:i:s O"
```

En caso de que el formato predeterminado no se ajuste a las necesidades de la aplicación, se puede personalizar mediante el método `setFormat()`. El método acepta una cadena de caracteres que corresponden a formatos de fecha. Para ver todos los formatos disponibles siga este [enlace](https://secure.php.net/manual/es/function.date.php).

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Formatter\Line;

$formatter = new Line();
$formatter->setDateFormat('Ymd-His');

$adapter = new Stream('/storage/logs/main.log');

$adapter->setFormatter($formatter);

$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong'); 
```

Resultado:

```bash
[ERROR] - [20181225-121314] - Something went wrong
```

### Formato JSON

Formatea los mensajes y devuelve una cadena en JSON:

```json
{
    "type"      : "Tipo de mensaje",
    "message"   : "El mensaje",
    "timestamp" : "Fecha del mensaje según el formato definido"
}
```

#### Date Format

El formato predeterminado es:

```bash
"D, d M y H:i:s O"
```

En caso de que el formato predeterminado no se ajuste a las necesidades de la aplicación, se puede personalizar mediante el método `setFormat()`. El método acepta una cadena de caracteres que corresponden a formatos de fecha. Para ver todos los formatos disponibles siga este [enlace](https://secure.php.net/manual/es/function.date.php).

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Formatter\Line;

$formatter = new Line();
$formatter->setDateFormat('Ymd-His');

$adapter = new Stream('/storage/logs/main.log');
$adapter->setFormatter($formatter);

$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

Resultado:

```json
{
    "type"      : "error",
    "message"   : "Something went wrong",
    "timestamp" : "20181225-121314"
}
```

### Formateador personalizado

The [Phalcon\Logger\Formatter\FormatterInterface](api/phalcon_logger#logger-formatter-formatterinterface) interface must be implemented in order to create your own formatter or extend the existing ones. Additionally you can reuse the [Phalcon\Logger\Formatter\AbstractFormatter](api/phalcon_logger#logger-formatter-abstractformatter) abstract class.

## Interpolación

Con el componente registro también se puede usar interpolación. Hay casos en los que es necesario agregar texto adicional a los mensajes de registro, por ejemplo, texto que ha sido creado dinámicamente por la aplicación. Para lograrlo solo se necesita enviar una matriz como segundo parámetro del método de registro (p.e. `error`, `info`, `alert`, etc.). La matrix está conformada por llaves y valores; la llave es el índice del mensaje y el valor el contenido que será agregado al mensaje.

En el siguiente ejemplo se puede observar cómo se emplea la interpolación para agregar en el mensaje el parámetro "framework" y "secs":

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter = new Stream('/storage/logs/main.log');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$message = '{framework} executed the "Hello World" test in {secs} second(s)';
$context = [
    'framework' => 'Phalcon',
    'secs'      => 1,
];

$logger->info($message, $context);
```

## Item

The formatter classes above accept a [Phalcon\Logger\Item](api/phalcon_logger#logger-item) object. The object contains all the necessary data required for the logging process. It is used as a transport of data from the logger to the formatter.

## Exceptions

Any exceptions thrown in the Logger component will be of type [Phalcon\Logger\Exception](api/phalcon_logger#logger-exception). You can use this exception to selectively catch exceptions thrown only from this component.

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Exception;

try {
    $adapter = new Stream('/storage/logs/main.log');
    $logger  = new Logger(
        'messages',
        [
            'main' => $adapter,
        ]
    );

    // Log to all adapters
    $logger->error('Something went wrong');
} catch (Exception $ex) {
    echo $ex->getMessage();
}
```

## Ejemplos

### Stream (flujo)

Para registrar en un archivo:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter = new Stream('/storage/logs/main.log');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

// Log to all adapters
$logger->error('Something went wrong');
```

El registro de flujo escribirá mensajes a un archivo debidamente registrado en PHP. Una lista de protocoles de flujo se encuentra disponible [aquí](https://www.php.net/manual/es/wrappers.php). Para registrar en un archivo:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter = new Stream('php://stderr');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Algo falló');
```

### Syslog (Registro del sistema)

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Syslog;

// Setting identity/mode/facility
$adapter = new Syslog(
    'ident-name',
    [
        'option'   => LOG_NDELAY,
        'facility' => LOG_MAIL,
    ]
);

$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

### Noop (No operación)

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Noop;

$adapter = new Noop('nothing');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Algo falló');
```

### Custom Adapters

The [Phalcon\Logger\AdapterInterface](api/phalcon_logger#logger-adapter-adapterinterface) interface must be implemented in order to create your own logger adapters or extend the existing ones. You can also take advantage of the functionality in [Phalcon\Logger\Adapter\AbstractAdapter](api/phalcon_logger#logger-adapter-abstractadapter) abstract class.

### Abstract Classes

There are two abstract classes that offer useful functionality when creating custom adapters: [Phalcon\Logger\Adapter\AbstractAdapter](api/phalcon_logger#logger-adapter-abstractadapter) and [Phalcon\Logger\Formatter\AbstractFormatter](api/phalcon_logger#logger-formatter-abstractformatter).

## Inyección de Dependencias

You can register as many loggers as you want in the \[Phalcon\Di\FactoryDefault\]\[factorydefault\] container. An example of the registration of the service as well as accessing it is below:

```php
<?php

use Phalcon\Di;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$container = new Di();

$container->set(
    'logger',
    function () use () {
        $adapter = new Stream('/storage/logs/main.log');
        $logger  = new Logger(
            'messages',
            [
                'main' => $adapter,
            ]
        );

        return new $logger;
    }
);
```