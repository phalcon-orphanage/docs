---
layout: default
language: 'es-es'
version: '4.0'
upgrade: '#logger'
title: 'Registrador'
---

# Componente Registro

* * *

## Logging

[Phalcon\Logger](api/Phalcon_Logger#logger-logger) is a component providing logging services for applications. con backends y adaptadores diversos. It also offers transaction logging, configuration options and different logging formats. You can use the [Phalcon\Logger](api/Phalcon_Logger#logger-logger) for any logging need your application has, from debugging processes to tracing application flow.

![](/assets/images/implements-psr--3-blue.svg)

The [Phalcon\Logger](api/Phalcon_Logger#logger-logger) has been rewritten to comply with [PSR-3](https://www.php-fig.org/psr/psr-3/). This allows you to use the [Phalcon\Logger](api/Phalcon_Logger#logger-logger) to any application that utilizes a [PSR-3](https://www.php-fig.org/psr/psr-3/) logger, not just Phalcon based ones.

En Phalcon v3.x el componente trae incorporado el adaptador. Esto en esencia significa que cuando se inicia el objeto de registro, el desarrollador está en realidad creando un adaptador (de archivo, flujo, etc.) con capacidad de registro.

En Phalcon v4 el componente se reescribió de tal manera que se dedica a la función de registro y acepta uno o más adaptadores que serán los responsables de las tareas de registro. Así se logra la compatibilidad con [PSR-3](https://www.php-fig.org/psr/psr-3/), se separan las responsabilidades del componente y se logra la funcionalidad de registro múltiple: fácilmente se puede agregar más de un adaptador al componente, cada uno realizando su propio registro. Con esta implementación se redujo el código del registro y se supimió el componente `Logger\Multiple`.

## Adaptadores

El componente registro hace uso de diversos adaptadores para guardar los mensajes. El uso de adaptadores permite una interfaz común de registro de mensajes y proporciona la capacidad de cambiar fácilmente de backend o utilizar múltiples adaptadores en caso de ser necesario. Los adaptadores disponibles son:

- [Phalcon\Logger\Adapter\Noop](api/Phalcon_Logger#logger-adapter-noop)
- [Phalcon\Logger\Adapter\Stream](api/Phalcon_Logger#logger-adapter-stream)
- [Phalcon\Logger\Adapter\Syslog](api/Phalcon_Logger#logger-adapter-syslog)

### Stream (flujo)

Se usa para registrar mensajes en un archivo de flujo. Combina los adaptadores de v3 `Stream` y `File`. Es el de uso más extendido: llevar el registro en un archivo del sistema de archivos.

### Syslog (Registro del sistema)

Se usa para guardar los mensajes en el registro del sistema (*Syslog*). El comportamiento del *syslog* puede variar de un sistema operativo a otro.

### Noop (No operación)

Este adaptador es un agujero negro: ¡Envía mensajes al *infinito y más allá!* Se usa especialmente para pruebas --o para hacerle una broma a un colega.

## Logger Factory

You can use the [Phalcon\Logger\LoggerFactory](api/Phalcon_Logger#logger-loggerfactory) component to create a logger. For the [Phalcon\Logger\LoggerFactory](api/Phalcon_Logger#logger-loggerfactory) to work, it needs to be instantiated with an [Phalcon\Logger\AdapterFactory](api/Phalcon_Logger#logger-adapterfactory):

```php
<?php

use Phalcon\Logger\LoggerFactory;
use Phalcon\Logger\AdapterFactory;

$adapterFactory = new AdapterFactory();
$loggerFactory  = new LoggerFactory($adapterFactory);
```

### load

[Phalcon\Logger\LoggerFactory](api/Phalcon_Logger#logger-loggerfactory) offers the `load` method, that constructs a logger based on supplied configuration. The configuration can be an array or a [Phalcon\Config](config) object.

> Use Case: Create a Logger with two Stream adapters. One adapter will be called `main` for logging all messages, while the second one will be called `admin`, logging only messages generated in the admin area of our application 
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

### newInstance

The [Phalcon\Logger\LoggerFactory](api/Phalcon_Logger#logger-loggerfactory) also offers the `newInstance()` method, that constructs a logger based on the supplied name and array of relevant adapters. Using the use case above:

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

## Crear un registro

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

The above example creates a [Stream](api/Phalcon_Logger#logger-adapter-stream) adapter. Luego se crea un objeto de registro y se le adjunta el adaptador. Cada adaptador debe tener un nombre único, de tal manera que el registro sepa dónde guardar los mensajes. When calling the `error()` method on the logger object, the message is going to be stored in the `/storage/logs/main.log`.

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

## Logging to Multiple Adapters

[Phalcon\Logger](api/Phalcon_Logger#logger-logger) can send messages to multiple adapters with a just single call:

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

### Exclusión de adaptadores

[Phalcon\Logger](api/Phalcon_Logger#logger-logger) also offers the ability to exclude logging to one or more adapters when logging a message. En especial, por ejemplo, cuando es necesario registrar un mensaje en el adaptador `manager` pero no en el adaptador `local` sin necesidad de instanciar un nuevo registro:

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
$logger->error('Something went wrong');

// Log only to remote and manager
$logger
    ->excludeAdapters(['local'])
    ->info('This does not go to the "local" logger');
```

## Formato de mensaje

Este componente utiliza `formatters` para formatear mensajes antes de enviarlos al backend. Los formateadores disponibles son:

- [Phalcon\Logger\Formatter\Line](api/Phalcon_Logger#logger-formatter-line)
- [Phalcon\Logger\Formatter\Json](api/Phalcon_Logger#logger-formatter-json)
- [Phalcon\Logger\Formatter\Syslog](api/Phalcon_Logger#logger-formatter-syslog)

### Formateador de línea

Formatea los mensajes utilizando una cadena de una línea. El formato por defecto de los mensajes es:

```bash
[%date%][%type%] %message%
```

#### Message Format

En caso de que el formato predeterminado no se ajuste a las necesidades de la aplicación, se puede personalizar mediante el método `setFormat()`. Las variables de formato de registro permitidas son:

| Variable    | Description                              |
| ----------- | ---------------------------------------- |
| `%message%` | The message itself expected to be logged |
| `%date%`    | Date the message was added               |
| `%type%`    | Uppercase string with message type       |

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

### Formateador Syslog

Formatea los mensajes que devuelven una matriz con el tipo y el mensaje como elementos:

```bash
[
    "type",
    "message",
]
```

### Formateador personalizado

The [Phalcon\Logger\Formatter\FormatterInterface](api/Phalcon_Logger#logger-formatter-formatterinterface) interface must be implemented in order to create your own formatter or extend the existing ones. Additionally you can reuse the [Phalcon\Logger\Formatter\AbstractFormatter](api/Phalcon_Logger#logger-formatter-abstractformatter) abstract class.

## Interpolation

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

The formatter classes above accept a [Phalcon\Logger\Item](api/Phalcon_Logger#logger-item) object. The object contains all the necessary data required for the logging process. It is used as a transport of data from the logger to the formatter.

## Exception

Any exceptions thrown in the Logger component will be of type [Phalcon\Logger\Exception](api/Phalcon_Logger#logger-exception). You can use this exception to selectively catch exceptions thrown only from this component.

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

// Setting ident/mode/facility
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

$logger->error('Algo falló');
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

### Implementando sus propios adaptadores

The [Phalcon\Logger\AdapterInterface](api/Phalcon_Logger#logger-adapter-adapterinterface) interface must be implemented in order to create your own logger adapters or extend the existing ones. You can also take advantage of the functionality in [Phalcon\Logger\Adapter\AbstractAdapter](api/Phalcon_Logger#logger-adapter-abstractadapter) abstract class.

#### Abstract Classes

There are two abstract classes that offer useful functionality when creating custom adapters