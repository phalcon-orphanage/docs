---
layout: default
language: 'es-es'
version: '4.0'
upgrade: '#logger'
category: 'logger'
---
# Componente Registro

* * *

## Logging

[Phalcon\Logger](api/Phalcon_Logger) es el componente que provee servicios de registro (logging) para aplicaciones con backends y adaptadores diversos. Ofrece también registro de transacciones, opciones de configuración, diferentes formatos y filtros. [Phalcon\Logger](api/Phalcon_Logger) es el componente ideal para cubrir todas las necesidades de registro de la aplicación, desde la depuración de procesos hasta el seguimiento de flujo de la misma.

![](/assets/images/implements-psr--3-orange.svg)

[Phalcon\Logger](api/Phalcon_Logger) ha sido reescrito para cumplir con [PSR-3](https://www.php-fig.org/psr/psr-3/), de tal manera que se puede utilizar con cualquier aplicación que necesite un componente de registro compatible con [PSR-3](https://www.php-fig.org/psr/psr-3/) --incluso sin estar basada en Phalcon.

En Phalcon v3.x el componente trae incorporado el adaptador. Esto en esencia significa que cuando se inicia el objeto de registro, el desarrollador está en realidad creando un adaptador (de archivo, flujo, etc.) con capacidad de registro.

En Phalcon v4 el componente se reescribió de tal manera que se dedica a la función de registro y acepta uno o más adaptadores que serán los responsables de las tareas de registro. Así se logra la compatibilidad con [PSR-3](https://www.php-fig.org/psr/psr-3/), se separan las responsabilidades del componente y se logra la funcionalidad de registro múltiple: fácilmente se puede agregar más de un adaptador al componente, cada uno realizando su propio registro. Con esta implementación se redujo el código del registro y se supimió el componente `Logger\Multiple`.

## Adaptadores

El componente registro hace uso de diversos adaptadores para guardar los mensajes. El uso de adaptadores permite una interfaz común de registro de mensajes y proporciona la capacidad de cambiar fácilmente de backend o utilizar múltiples adaptadores en caso de ser necesario. Los adaptadores disponibles son:

- [Phalcon\Logger\Adapter\Stream](api/Phalcon_Logger_Adapter_Stream)
- [Phalcon\Logger\Adapter\Syslog](api/Phalcon_Logger_Adapter_Syslog)
- [Phalcon\Logger\Adapter\Noop](api/Phalcon_Logger_Adapter_Noop)

### Stream (flujo)

Se usa para registrar mensajes en un archivo de flujo. Combina los adaptadores de v3 `Stream` y `File`. Es el de uso más extendido: llevar el registro en un archivo del sistema de archivos.

### Syslog (Registro del sistema)

Se usa para guardar los mensajes en el registro del sistema (*Syslog*). El comportamiento del *syslog* puede variar de un sistema operativo a otro.

### Noop (No operación)

Este adaptador es un agujero negro: ¡Envía mensajes al *infinito y más allá!* Se usa especialmente para pruebas --o para hacerle una broma a un colega.

## Factory

*Este adaptador no está funcionando como se espera todavía*: Está en proceso de refactorización de tal manera que pueda integrarse a la nueva implementación. Ver caso [#13672](https://github.com/phalcon/cphalcon/issues/13672)

## Crear un registro

La creación de un registro se hace en varios pasos. Primero, se crea un objeto de registro y, segundo, se incluye un adaptador. Cumplidos estos pasos, se pueden empezar a registar mensajes según las necesidades de la aplicación.

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter = new Stream('/logs/application.log');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Algo falló');
```

En este ejemplo se crea un adaptador [Stream](api/Phalcon_Logger_Adapter_Stream). Luego se crea un objeto de registro y se le adjunta el adaptador. Cada adaptador debe tener un nombre único, de tal manera que el registro sepa dónde guardar los mensajes. Cuando se llama el método `error` en el objeto de registro, el mensaje será almacenado en `/logs/application.log`.

Dado que el componente de registro implementa PSR-3, los siguientes métodos están disponibles:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter = new Stream('/logs/application.log');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->alert("Este es un mensaje de alerta");
$logger->critical("Este es un mensaje de alerta crítica");
$logger->debug("Este es un mensaje de depuración");
$logger->error("Este es un mensaje de error");
$logger->emergency("Este es un mensaje de emergencia");
$logger->info("Este es un mensaje de información");
$logger->log(Logger::CRITICAL, "Este es un mensaje de registro");
$logger->notice("Este es un mensaje informativo");
$logger->warning("Este es un mensaje de advertencia");

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

[Phalcon\Logger](api/Phalcon_Logger) can send messages to multiple adapters with a just single call:

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
```

The messages are sent to the handlers in the order they were registered using the [first in first out](https://en.wikipedia.org/wiki/FIFO_(computing_and_electronics)) principle.

### Excluding adapters

[Phalcon\Logger](api/Phalcon_Logger) also offers the ability to exclude logging to one or more adapters when logging a message. This is particularly useful when in need to log a `manager` related message in the `manager` log but not in the `local` log without having to instantiate a new logger.

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

- [Phalcon\Logger\Formatter\Line](api/Phalcon_Logger_Formatter_Line)
- [Phalcon\Logger\Formatter\Json](api/Phalcon_Logger_Formatter_Json)
- [Phalcon\Logger\Formatter\Syslog](api/Phalcon_Logger_Formatter_Syslog)

### Line Formatter

Formats the messages using a one-line string. The default logging format is:

```bash
[%date%][%type%] %message%
```

#### Message Format

If the default format of the message does not fit the needs of your application you can change it using the `setFormat()` method. The log format variables allowed are:

| Variable  | Descripción                        |
| --------- | ---------------------------------- |
| %message% | El mensaje que se espera registrar |
| %date%    | Fecha que del mensaje fue agregado |
| %type%    | Tipo de mensaje en mayúsculas      |

The following example demonstrates how to change the message format:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Formatter\Line;

$formatter = new Line('[%type%] - [%date%] - %message%');
$adapter   = new Stream('/logs/application.log');
$adapter->setFormatter($formatter);

$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

which produces:

```bash
[ALERT] - [Tue, 25 Dec 18 12:13:14 -0400] - Something went wrong
```

If you do not want to use the constructor to change the message, you can always use the `setFormat()` on the formatter:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Formatter\Line;

$formatter = new Line();
$formatter->setFormat('[%type%] - [%date%] - %message%');

$adapter = new Stream('/logs/application.log');
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

The default date format is:

```bash
"D, d M y H:i:s O"
```

If the default format of the message does not fit the needs of your application you can change it using the `setDateFormat()` method. The method accepts a string with characters that correspond to date formats. For all available formats, please consult [this page](https://secure.php.net/manual/en/function.date.php).

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Formatter\Line;

$formatter = new Line();
$formatter->setDateFormat('Ymd-His');

$adapter = new Stream('/logs/application.log');
$adapter->setFormatter($formatter);

$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
```

### JSON Formatter

Formats the messages returning a JSON string:

```json
{
    "type"      : "Type of the message",
    "message"   : "The message",
    "timestamp" : "The date as defined in the date format"
}
```

#### Date Format

The default date format is:

```bash
"D, d M y H:i:s O"
```

If the default format of the message does not fit the needs of your application you can change it using the `setDateFormat()` method. The method accepts a string with characters that correspond to date formats. For all available formats, please consult [this page](https://secure.php.net/manual/en/function.date.php).

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Formatter\Line;

$formatter = new Line();
$formatter->setDateFormat('Ymd-His');

$adapter = new Stream('/logs/application.log');
$adapter->setFormatter($formatter);

$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$logger->error('Something went wrong');
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

La interfaz [Phalcon\Logger\FormatterInterface ](api/Phalcon_Logger_Formatter_FormatterInterface) debe implementarse para crear su propio formateador o extender los existentes.

## Interpolation

The logger also supports interpolation. There are times that you might need to inject additional text in your logging messages; text that is dynamically created by your application. This can be easily achieved by sending an array as the second parameter of the logging method (i.e. `error`, `info`, `alert` etc.). The array holds keys and values, where the key is the placeholder in the message and the value is what will be injected in the message.

The following example demonstrates interpolation by injecting in the message the parameter "framework" and "secs".

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter = new Stream('/logs/application.log');
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

## Examples

### Stream (flujo)

Logging to a file:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter = new Stream('/logs/application.log');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

// Log to all adapters
$logger->error('Something went wrong');
```

The stream logger writes messages to a valid registered stream in PHP. A list of streams is available [here](https://php.net/manual/en/wrappers.php). Logging to a stream

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

$logger->error('Something went wrong');
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

$logger->error('Something went wrong');
```

### Implementando sus propios adaptadores

The [Phalcon\Logger\AdapterInterface](api/Phalcon_Logger_AdapterInterface) interface must be implemented in order to create your own logger adapters or extend the existing ones.