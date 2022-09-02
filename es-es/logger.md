---
layout: default
upgrade: '#logger'
title: 'Logger'
keywords: 'psr-3, logger, adaptadores, noop, flujo, syslog'
---

# Logger
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen
[Phalcon\Logger\Logger][logger-logger] is a component providing logging services for applications. Ofrece registro para diferentes *back-ends* usando diferentes adaptadores. También ofrece registro de transacciones, opciones de configuración y diferentes formatos de registro. You can use the [Phalcon\Logger\Logger][logger-logger] for any logging need your application has, from debugging processes to tracing application flow.

The [Phalcon\Logger\Logger][logger-logger] implements methods that are inline with [PSR-3][psr-3], but does not implement the particular interface. A package that implements [PSR-3][psr-3] is available, that uses [Phalcon\Logger\Logger][logger-logger]. The package is located [here][proxy-psr3]. To use it, you will need to have Phalcon installed and then using composer you can install the proxy package.

```sh
composer require phalcon/proxy-psr3
```

Using the proxy classes allows you to follow [PSR-3][psr-3] and use it with any other package that needs that interface.

The [Phalcon\Logger\Logger][logger-logger] implements only the logging functionality and accepts one or more adapters that would be responsible for doing the work of logging. This implementation separates the responsibilities of the component and offers an easy way to attach more than one adapter to the logging component so that logging to multiple adapters can be achieved.

## Adaptadores
El componente registro hace uso de diversos adaptadores para guardar los mensajes. El uso de adaptadores permite una interfaz común de registro de mensajes y proporciona la capacidad de cambiar fácilmente de backend o utilizar múltiples adaptadores en caso de ser necesario. Los adaptadores disponibles son:

| Adaptador                                                 | Descripción                                  |
| --------------------------------------------------------- | -------------------------------------------- |
| [Phalcon\Logger\Adapter\Noop][logger-adapter-noop]     | Black hole adapter (used for testing mostly) |
| [Phalcon\Logger\Adapter\Stream][logger-adapter-stream] | Registra mensajes en un flujo de fichero     |
| [Phalcon\Logger\Adapter\Syslog][logger-adapter-syslog] | Registra mensajes en el *Syslog*             |

### Flujo (Stream)
Se usa para registrar mensajes en un archivo de flujo. Combina los adaptadores de v3 `Stream` y `File`. Es el de uso más extendido: llevar el registro en un archivo del sistema de archivos.

### Syslog (Registro del sistema)
Se usa para guardar los mensajes en el registro del sistema (*Syslog*). El comportamiento del *syslog* puede variar de un sistema operativo a otro.

### Noop (No operación)
Este adaptador es un agujero negro: It sends messages to *infinity and beyond*! Se usa especialmente para pruebas --o para hacerle una broma a un colega.

## Fábrica (Factory)
You can use the [Phalcon\Logger\LoggerFactory][logger-loggerfactory] component to create a logger. For the [Phalcon\Logger\LoggerFactory][logger-loggerfactory] to work, it needs to be instantiated with a [Phalcon\Logger\AdapterFactory][logger-adapterfactory]:

```php
<?php

use Phalcon\Logger\LoggerFactory;
use Phalcon\Logger\AdapterFactory;

$adapterFactory = new AdapterFactory();
$loggerFactory  = new LoggerFactory($adapterFactory);
```

### `load()`
[Phalcon\Logger\LoggerFactory][logger-loggerfactory] offers the `load` method, that constructs a logger based on supplied configuration. La configuración puede ser un vector o un objeto [Phalcon\Config](config).

> **NOTE**: Use Case: Create a Logger with two Stream adapters. One adapter will be called `main` for logging all messages, while the second one will be called `admin`, logging only messages generated in the admin area of our application 
> 
> {: .alert .alert-info}

```php
<?php

use Phalcon\Logger\AdapterFactory;
use Phalcon\Logger\LoggerFactory;
use Phalcon\Storage\SerializerFactory;

$config = [
    "name"     => "prod-logger",
    "adapters" => [
        "main"  => [
            "adapter" => "stream",
            "name"    => "/storage/logs/main.log",
            "options" => []
        ],
        "admin" => [
            "adapter" => "stream",
            "name"    => "/storage/logs/admin.log",
            "options" => []
        ],
    ],
];

$serializerFactory = new SerializerFactory();
$adapterFactory    = new AdapterFactory();
$loggerFactory     = new LoggerFactory($adapterFactory);

$logger = $loggerFactory->load($config);
```

### `newInstance()`
The [Phalcon\Logger\LoggerFactory][logger-loggerfactory] also offers the `newInstance()` method, that constructs a logger based on the supplied name and array of relevant adapters. Usando el caso de uso anterior:

```php
<?php

use Phalcon\Logger\Logger\Logger\Adapter\Stream;
use Phalcon\Logger\AdapterFactory;
use Phalcon\Logger\LoggerFactory;
use Phalcon\Storage\SerializerFactory;

$adapters = [
    "main"  => new Stream("/storage/logs/main.log"),
    "admin" => new Stream("/storage/logs/admin.log"),
];

$serializerFactory = new SerializerFactory();
$adapterFactory    = new AdapterFactory($serializerFactory);
$loggerFactory     = new LoggerFactory($adapterFactory);

$logger = $loggerFactory->newInstance('prod-logger', $adapters);
```

## Creando un Registro
Creating a logger is a multistep process. First you create the logger object, and then you attach an adapter to it. Cumplidos estos pasos, se pueden empezar a registar mensajes según las necesidades de la aplicación.

```php
<?php

use Phalcon\Logger\Logger;
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

The above example creates a [Stream][logger-adapter-stream] adapter. Luego se crea un objeto de registro y se le adjunta el adaptador. Cada adaptador debe tener un nombre único, de tal manera que el registro sepa dónde guardar los mensajes. Cuando se llama al método `error()` del objeto *logger*, el mensaje se almacenará en `/storage/logs/main.log`.

Dado que el componente de registro implementa PSR-3, los siguientes métodos están disponibles:

```php
<?php

use Phalcon\Logger\Logger\Logger;
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

## Múltiples Adaptadores
[Phalcon\Logger\Logger][logger-logger] can send messages to multiple adapters with a just single call:

```php
<?php

use Phalcon\Logger\Logger\Logger;
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

$logger->error('Something went wrong');
```

The messages are sent to the handlers in the order they were registered using the [first in first out][fifo] principle.

### Exclusión de Adaptadores
[Phalcon\Logger\Logger][logger-logger] also offers the ability to exclude logging to one or more adapters when logging a message. En especial, por ejemplo, cuando es necesario registrar un mensaje en el adaptador `manager` pero no en el adaptador `local` sin necesidad de instanciar un nuevo registro:

Con la siguiente configuración:

```php
<?php

use Phalcon\Logger\Logger;
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

tenemos lo siguiente:

```php
<?php

$logger->error('Algo salió mal');
```
Registrar en todos los adaptadores

```php
<?php

$logger
    ->excludeAdapters(['local'])
    ->info('Esto no va a al registro "local"');
```
Registrar solo a remoto y administrador

> **NOTE** Internally, the component loops through the registered adapters and calls the relevant logging method to achieve logging to multiple adapters. Si uno de ellos falla, el bucle se romperá y los adaptadores restantes (del bucle) no registrarán el mensaje. En futuras versiones de Phalcon se introducirá el registro asíncrono para mitigar este problema. 
> 
> {: .alert .alert-warning }

## Constantes
La clase ofrece un número de constantes que se pueden usar para distinguir entre los niveles de registro. Estas constantes también se pueden usar como primer parámetro del método `log()`.

| Constante   | Valor |
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


## Niveles de Registro
[Phalcon\Logger\Logger][logger-logger] allows you to set the minimum log level for the logger(s) to log. If you set this integer value, any level higher than the one set will not be logged. Compruebe los valores de las constantes en la sección previa para ver el orden en que se establecieron los niveles.

En el siguiente ejemplo, establecemos el nivel de registro a `ALERT`. We will only see `EMERGENCY`, `CRITICAL` **and** `ALERT` messages.

```php
<?php

use Phalcon\Logger\Logger;
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
[Tue, 25 Dec 18 12:13:14 -0400][ALERT] Esto es un mensaje de alerta
[Tue, 25 Dec 18 12:13:14 -0400][CRITICAL] Esto es un mensaje crítico
[Tue, 25 Dec 18 12:13:14 -0400][EMERGENCY] Esto es un mensaje de emergencia
[Tue, 25 Dec 18 12:13:14 -0400][CRITICAL] Esto es un mensaje de registro
```

The above can be used in situations where you want to log messages above a certain severity based on conditions in your application such as development mode vs. production.

> **NOTE**: The log level set is included in the logging. Anything **below** that level (i.e. higher number) will not be logged 
> 
> {: .alert .alert-info }

> **NOTE**: It is **never** a good idea to suppress logging levels in your application, since even warning errors do require CPU cycles to be processed and neglecting these errors could potentially lead to unintended circumstances 
> 
> {: .alert .alert-danger }

## Transacciones
[Phalcon\Logger\Logger][logger-logger] also offers the ability to queue the messages in your logger, and then _commit_ them all together in the log file. Esto es similar a una transacción de base de datos con `begin` y `commit`. Each adapter exposes the following methods:

| Nombre                  | Descripción                                    |
| ----------------------- | ---------------------------------------------- |
| `begin(): void`         | begins the logging transaction                 |
| `inTransaction(): bool` | if you are in a transaction or not             |
| `commit(): void`        | writes all the queued messages in the log file |

Since the functionality is available at the adapter level, you can program your logger to use transactions on a per-adapter basis.

```php
<?php

use Phalcon\Logger\Logger;
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
En el ejemplo anterior, registramos tres adaptadores. Hemos establecido el registro `manager` para estar en modo transacción. Tan pronto como llamamos:

```php
$logger->error('Ha ocurrido algo');
```
el mensaje se registrará en ambos adaptadores `local` y `remote`. Se encolará para el adaptador `manager` y no se registrará hasta que llamemos al método `commit` en el adaptador `manager`.

> **NOTE**: If you set one or more adapters to be in transaction mode (i.e. call `begin`) and forget to call `commit`, The adapter will call `commit` for you right before it is destroyed. 
> 
> {: .alert .alert-info }
## Formato de mensaje
Este componente utiliza `formatters` para formatear mensajes antes de enviarlos al backend. Los formateadores disponibles son:

| Adaptador                                                 | Descripción                                    |
| --------------------------------------------------------- | ---------------------------------------------- |
| [Phalcon\Logger\Formatter\Line][logger-formatter-line] | Formatea el mensaje en una sola línea de texto |
| [Phalcon\Logger\Formatter\Json][logger-formatter-json] | Formatea el mensaje en una cadena JSON         |

### Formateador de línea
Formatea los mensajes utilizando una cadena de una línea. El formato por defecto de los mensajes es:

```bash
[%date%][%type%] %message%
```

#### Formato del mensaje
En caso de que el formato predeterminado no se ajuste a las necesidades de la aplicación, se puede personalizar mediante el método `setFormat()`. Las variables de formato de registro permitidas son:

| Variable    | Descripción                        |
| ----------- | ---------------------------------- |
| `%message%` | El mensaje que se espera registrar |
| `%date%`    | Fecha que del mensaje fue agregado |
| `%type%`    | Tipo de mensaje en mayúsculas      |

Ejemplo de cómo modificar el formato del mensaje:

```php
<?php

use Phalcon\Logger\Logger;
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

use Phalcon\Logger\Logger;
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

#### Formato de fecha
El formato predeterminado es:

```bash
"D, d M y H:i:s O"
```

En caso de que el formato predeterminado no se ajuste a las necesidades de la aplicación, se puede personalizar mediante el método `setFormat()`. El método acepta una cadena de caracteres que corresponden a formatos de fecha. For all available formats, please consult [this page][date-formats].

```php
<?php

use Phalcon\Logger\Logger;
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
[ERROR] - [20181225-121314] - Algo falló
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

> The `format()` method encodes JSON with the following options by default (79): - `JSON_HEX_TAG` - `JSON_HEX_APOS` - `JSON_HEX_AMP` - `JSON_HEX_QUOT` - `JSON_UNESCAPED_SLASHES` - `JSON_THROW_ON_ERROR` 
> 
> {: .alert .alert-info }

#### Formato de fecha
El formato predeterminado es:

```bash
"D, d M y H:i:s O"
```

En caso de que el formato predeterminado no se ajuste a las necesidades de la aplicación, se puede personalizar mediante el método `setFormat()`. El método acepta una cadena de caracteres que corresponden a formatos de fecha. For all available formats, please consult [this page][date-formats].

```php
<?php

use Phalcon\Logger\Logger;
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
    "message"   : "Algo falló",
    "timestamp" : "20181225-121314"
}
```

### Formateador Personalizado
The [Phalcon\Logger\Formatter\FormatterInterface][logger-formatter-formatterinterface] interface must be implemented in order to create your own formatter or extend the existing ones. Additionally, you can reuse the [Phalcon\Logger\Formatter\AbstractFormatter][logger-formatter-abstractformatter] abstract class.

## Interpolación
Con el componente registro también se puede usar interpolación. Hay casos en los que es necesario agregar texto adicional a los mensajes de registro, por ejemplo, texto que ha sido creado dinámicamente por la aplicación. Para lograrlo solo se necesita enviar una matriz como segundo parámetro del método de registro (p.e. `error`, `info`, `alert`, etc.). El vector mantiene claves y valores, donde la clave es el marcador de posición en el mensaje y el valor el contenido que será inyectado en el mensaje.

En el siguiente ejemplo se puede observar cómo se emplea la interpolación para agregar en el mensaje el parámetro "framework" y "secs":

```php
<?php

use Phalcon\Logger\Logger;
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
The formatter classes above accept a [Phalcon\Logger\Item][logger-item] object. El objeto contiene todo los datos necesarios para proceso de registro. It is used as transport of data from the logger to the formatter.

> **NOTE**: In v5 the object now accepts a `\DateTimeImmutable` object as the `$dateTime` parameter 
> 
> {: .alert .alert-warning }

## Excepciones
Any exceptions thrown in the Logger component will be of type [Phalcon\Logger\Exception][logger-exception]. Puede usar esta excepción para capturar selectivamente sólo las excepciones lanzadas desde este componente.

```php
<?php

use Phalcon\Logger\Logger;
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

### Flujo (Stream)
Para registrar en un archivo:

```php
<?php

use Phalcon\Logger\Logger;
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

El registro de flujo escribirá mensajes a un archivo debidamente registrado en PHP. A list of streams is available [here][stream-wrappers]. Para registrar en un archivo:

```php
<?php

use Phalcon\Logger\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter = new Stream('php://stderr');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

### Syslog (Registro del sistema)

```php
<?php

use Phalcon\Logger\Logger;
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

use Phalcon\Logger\Logger;
use Phalcon\Logger\Adapter\Noop;

$adapter = new Noop('nothing');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

### Adaptadores Personalizados
The [Phalcon\Logger\AdapterInterface][logger-adapter-adapterinterface] interface must be implemented in order to create your own logger adapters or extend the existing ones. You can also take advantage of the functionality in [Phalcon\Logger\Adapter\AbstractAdapter][logger-adapter-abstractadapter] abstract class.

### Clases Abstractas
There are three abstract classes that offer useful functionality when creating custom objects:
- \[Phalcon\Logger\AbstractLogger\]\[logger-abstractlogger\]
- [Phalcon\Logger\Adapter\AbstractAdapter][logger-adapter-abstractadapter]
- [Phalcon\Logger\Formatter\AbstractFormatter][logger-formatter-abstractformatter].

## Inyección de Dependencias
Puede registrar tantos registradores como quiera en el contenedor \[Phalcon\Di\FactoryDefault\]\[factorydefault\]. A continuación, un ejemplo de registro del servicio así como de acceso a él:

```php
<?php

use Phalcon\Di;
use Phalcon\Logger\Logger;
use Phalcon\Logger\Adapter\Stream;

$container = new Di();

$container->set(
    'logger',
    function () {
        $adapter = new Stream('/storage/logs/main.log');
        $logger  = new Logger(
            'messages',
            [
                'main' => $adapter,
            ]
        );

        return $logger;
    }
);

// accessing it later:
$logger = $container->getShared('logger');

```

[date-formats]: https://www.php.net/manual/en/function.date.php
[fifo]: https://en.wikipedia.org/wiki/FIFO_(computing_and_electronics)
[logger-logger]: api/phalcon_logger#logger-logger
[logger-adapter-noop]: api/phalcon_logger#logger-adapter-noop
[logger-adapter-stream]: api/phalcon_logger#logger-adapter-stream
[logger-adapter-stream]: api/phalcon_logger#logger-adapter-stream
[logger-adapter-syslog]: api/phalcon_logger#logger-adapter-syslog
[logger-loggerfactory]: api/phalcon_logger#logger-loggerfactory
[logger-adapterfactory]: api/phalcon_logger#logger-adapterfactory
[logger-formatter-line]: api/phalcon_logger#logger-formatter-line
[logger-formatter-json]: api/phalcon_logger#logger-formatter-json
[logger-formatter-formatterinterface]: api/phalcon_logger#logger-formatter-formatterinterface
[logger-adapter-adapterinterface]: api/phalcon_logger#logger-adapter-adapterinterface
[logger-formatter-abstractformatter]: api/phalcon_logger#logger-formatter-abstractformatter
[logger-adapter-abstractadapter]: api/phalcon_logger#logger-adapter-abstractadapter
[logger-exception]: api/phalcon_logger#logger-exception
[logger-item]: api/phalcon_logger#logger-item
[proxy-psr3]: https://github.com/phalcon/proxy-psr3
[psr-3]: https://www.php-fig.org/psr/psr-3/
[stream-wrappers]: https://php.net/manual/en/wrappers.php
