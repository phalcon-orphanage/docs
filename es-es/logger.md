---
layout: article
language: 'es-es'
version: '4.0'
upgrade: '#logger'
category: 'logger'
---


<a name='overview'></a>

# Logging

[Phalcon\Logger](api/Phalcon_Logger) is a component whose purpose is to provide logging services for applications. It offers logging to different back-ends using different adapters. It also offers transaction logging, configuration options, different formats and filters. You can use the [Phalcon\Logger](api/Phalcon_Logger) for any logging need your application has, from debugging processes to tracing application flow.

![](/assets/images/implements-psr--3-orange.svg)

The [Phalcon\Logger](api/Phalcon_Logger) has been rewritten to comply with [PSR-3](https://www.php-fig.org/psr/psr-3/). This allows you to use the [Phalcon\Logger](api/Phalcon_Logger) to any application that expects a [PSR-3](https://www.php-fig.org/psr/psr-3/) logger, not just Phalcon based ones.

In v3, the logger was incorporating the adapter in the same component. So in essence when creating a logger object, the developer was creating an adapter (file, stream etc.) with logger functionality.

For v4, we rewrote the component to implement only the logging functionality and to accept one or more adapters that would be responsible for doing the work of logging. This immediately offers compatibility with PSR-3 and separates the responsibilities of the component. It also offers the developer an easy way to attach more than one adapter to the logging component so that logging to multiple adapters can be achieved. By using this implementation we have reduced the code necessary for this component and removed the old `Logger\Multiple` component.

** WIP below **

<a name='adapters'></a>

## Adapters

This component makes use of adapters to store the logged messages. The use of adapters allows for a common logging interface which provides the ability to easily switch backends if necessary. The adapters supported are:

noop.zep stream.zep syslog.zep

| Adaptador                                                             | Descripción                                             |
| --------------------------------------------------------------------- | ------------------------------------------------------- |
| [Phalcon\Logger\Adapter\File](api/Phalcon_Logger_Adapter_File)     | Registros son almacenados en un archivo de texto        |
| [Phalcon\Logger\Adapter\Stream](api/Phalcon_Logger_Adapter_Stream) | Registros enviados al PHP Stream                        |
| [Phalcon\Logger\Adapter\Syslog](api/Phalcon_Logger_Adapter_Syslog) | Registros se almacenan en el sistema de log del sistema |
| `Phalcon\Logger\Adapter\FirePHP`                                   | Registros se envían a la extensión FirePHP              |

<a name='adapters-factory'></a>

### Factory

Loads Logger Adapter class using `adapter` option

```php
<?php

use Phalcon\Logger\Factory;

$options = [
    'name'    => 'log.txt',
    'adapter' => 'file',
];

$logger = Factory::load($options);
```

<a name='creating'></a>

## Creating a Log

The example below shows how to create a log and add messages to it:

```php
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

// Log to specific adapters
$logger
    ->excludeAdapters(['manager'])
    ->info('This does not go to the "manager" logger);

// These are the different log levels available:

$logger->critical(
    'This is a critical message'
);

$logger->emergency(
    'This is an emergency message'
);

$logger->debug(
    'This is a debug message'
);

$logger->error(
    'This is an error message'
);

$logger->info(
    'This is an info message'
);

$logger->notice(
    'This is a notice message'
);

$logger->warning(
    'This is a warning message'
);

$logger->alert(
    'This is an alert message'
);

// You can also use the log() method with a Logger constant:
$logger->log(
    'This is another error message',
    Logger::ERROR
);

// If no constant is given, DEBUG is assumed.
$logger->log(
    'Este es un mensaje'
);

// Puedes pasar parámetros de contexto, por ejemplo
$logger->log(
    'Este es un {mensaje}', 
    [ 
        'mensaje' => 'parámetro' 
    ]
);
```

The log generated is below:

```bash
[Tue, 28 Jul 15 22:09:02 -0500][CRITICAL] Este es un mensaje critico
[Tue, 28 Jul 15 22:09:02 -0500][EMERGENCY] Este es un mensaje de emergencia
[Tue, 28 Jul 15 22:09:02 -0500][DEBUG] Este es un mensaje de depuración
[Tue, 28 Jul 15 22:09:02 -0500][ERROR] Este es un mensaje de error
[Tue, 28 Jul 15 22:09:02 -0500][INFO] Este es un mensaje informativo
[Tue, 28 Jul 15 22:09:02 -0500][NOTICE] Este es un mensaje de noticia
[Tue, 28 Jul 15 22:09:02 -0500][WARNING] Este es un mensaje de advertencia
[Tue, 28 Jul 15 22:09:02 -0500][ALERT] Este es un mensaje de alerta
[Tue, 28 Jul 15 22:09:02 -0500][ERROR] Este es otro mensaje
[Tue, 28 Jul 15 22:09:02 -0500][DEBUG] Este es un mensaje
[Tue, 28 Jul 15 22:09:02 -0500][DEBUG] Este es un parámetro
```

You can also set a log level using the `setLogLevel()` method. This method takes a Logger constant and will only save log messages that are as important or more important than the constant:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\File as FileAdapter;

$logger = new FileAdapter('app/logs/test.log');

$logger->setLogLevel(
    Logger::CRITICAL
);
```

In the example above, only critical and emergency messages will get saved to the log. By default, everything is saved.

<a name='transactions'></a>

## Transacciones

Logging data to an adapter i.e. File (file system) is always an expensive operation in terms of performance. To combat that, you can take advantage of logging transactions. Transactions store log data temporarily in memory and later on write the data to the relevant adapter (File in this case) in a single atomic operation.

```php
<?php

use Phalcon\Logger\Adapter\File as FileAdapter;

// Crear el logger
$logger = new FileAdapter('app/logs/test.log');

// Comenzar una transacción
$logger->begin();

// Agregar mensajes
$logger->alert(
    'Esta es una alerta'
);

$logger->error(
    'Este es otro error'
);

// Confirmar los mensajes en el archivo
$logger->commit();
```

<a name='multiple-handlers'></a>

## Logging to Multiple Handlers

[Phalcon\Logger](api/Phalcon_Logger) can send messages to multiple handlers with a just single call:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Multiple as MultipleStream;
use Phalcon\Logger\Adapter\File as FileAdapter;
use Phalcon\Logger\Adapter\Stream as StreamAdapter;

$logger = new MultipleStream();

$logger->push(
    new FileAdapter('test.log')
);

$logger->push(
    new StreamAdapter('php://stdout')
);

$logger->log(
    'Este es un mensaje'
);

$logger->log(
    'Este es un error',
    Logger::ERROR
);

$logger->error(
    'Este es otro error'
);
```

The messages are sent to the handlers in the order they were registered.

<a name='message-formatting'></a>

## Message Formatting

This component makes use of `formatters` to format messages before sending them to the backend. The formatters available are:

| Adaptador                                                                   | Descripción                                                     |
| --------------------------------------------------------------------------- | --------------------------------------------------------------- |
| [Phalcon\Logger\Formatter\Line](api/Phalcon_Logger_Formatter_Line)       | Formato de mensajes utilizando una cadena de texto de una línea |
| [Phalcon\Logger\Formatter\Firephp](api/Phalcon_Logger_Formatter_Firephp) | Formato de mensajes que pueden ser enviados a FirePHP           |
| [Phalcon\Logger\Formatter\Json](api/Phalcon_Logger_Formatter_Json)       | Prepara un mensaje para ser codificados con JSON                |
| [Phalcon\Logger\Formatter\Syslog](api/Phalcon_Logger_Formatter_Syslog)   | Se prepara un mensaje para enviarse al syslog                   |

<a name='message-formatting-line'></a>

### Line Formatter

Formats the messages using a one-line string. The default logging format is:

```bash
[%date%][%type%] %message%
```

You can change the default format using `setFormat()`, this allows you to change the format of the logged messages by defining your own. The log format variables allowed are:

| Variable  | Descripción                        |
| --------- | ---------------------------------- |
| %message% | El mensaje que se espera registrar |
| %date%    | Fecha que del mensaje fue agregado |
| %type%    | Tipo de mensaje en mayúsculas      |

The example below shows how to change the log format:

```php
<?php

use Phalcon\Logger\Formatter\Line as LineFormatter;

$formatter = new LineFormatter('%date% - %message%');

// Cambiando el formato de registro
$logger->setFormatter($formatter);
```

<a name='message-formatting-custom'></a>

### Implementing your own formatters

The [Phalcon\Logger\FormatterInterface](api/Phalcon_Logger_FormatterInterface) interface must be implemented in order to create your own logger formatter or extend the existing ones.

<a name='usage'></a>

## Adapters

The following examples show the basic use of each adapter:

<a name='usage-stream'></a>

### Stream Logger

The stream logger writes messages to a valid registered stream in PHP. A list of streams is available [here](https://php.net/manual/en/wrappers.php):

```php
<?php

use Phalcon\Logger\Adapter\Stream as StreamAdapter;

// Abrir el stream utilizando compresión zlib
$logger = new StreamAdapter('compress.zlib://week.log.gz');

// Escribir registros en stderr
$logger = new StreamAdapter('php://stderr');
```

<a name='usage-file'></a>

### File Logger

This logger uses plain files to log any kind of data. By default all logger files are opened using append mode which opens the files for writing only; placing the file pointer at the end of the file. If the file does not exist, an attempt will be made to create it. You can change this mode by passing additional options to the constructor:

```php
<?php

use Phalcon\Logger\Adapter\File as FileAdapter;

// Crear un archivo de registro en modo 'w'
$logger = new FileAdapter(
    'app/logs/test.log',
    [
        'mode' => 'w',
    ]
);
```

<a name='usage-syslog'></a>

### Syslog Logger

This logger sends messages to the system logger. The syslog behavior may vary from one operating system to another.

```php
<?php

use Phalcon\Logger\Adapter\Syslog as SyslogAdapter;

// Uso básico
$logger = new SyslogAdapter(null);

// Configurando ident/mode/facility
$logger = new SyslogAdapter(
    'ident-name',
    [
        'option'   => LOG_NDELAY,
        'facility' => LOG_MAIL,
    ]
);
```

<a name='usage-firephp'></a>

### FirePHP Logger

This logger sends messages in HTTP response headers that are displayed by [FirePHP](https://www.firephp.org/), a [Firebug](https://getfirebug.com/) extension for Firefox.

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Firephp as Firephp;

$logger = new Firephp('');

$logger->log(
    'Este es un mensaje'
);

$logger->log(
    'Este es un error',
    Logger::ERROR
);

$logger->error(
    'Este es otro error'
);
```

<a name='usage-custom'></a>

### Implementing your own adapters

The [Phalcon\Logger\AdapterInterface](api/Phalcon_Logger_AdapterInterface) interface must be implemented in order to create your own logger adapters or extend the existing ones.