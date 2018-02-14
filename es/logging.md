<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Escapado contextual</a>
    </li>
    <li>
      <a href="#overview">Logging</a>
      <ul>
        <li>
          <a href="#adapters">Adaptadores</a>
          <ul>
            <li>
              <a href="#adapters-factory">Factory</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#creating">Creación de un Log</a>
        </li>
        <li>
          <a href="#transactions">Transacciones</a>
        </li>
        <li>
          <a href="#multiple-handlers">Registro de múltiples gestores</a>
        </li>
        <li>
          <a href="#message-formatting">Formato de mensaje</a> 
          <ul>
            <li>
              <a href="#message-formatting-line">Formateador de línea</a>
            </li>
            <li>
              <a href="#message-formatting-custom">Implementar tus propios formateadores</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#usage">Adaptadores</a> 
          <ul>
            <li>
              <a href="#usage-stream">Stream Logger</a>
            </li>
            <li>
              <a href="#usage-file">File Logger</a>
            </li>
            <li>
              <a href="#usage-syslog">Syslog Logger</a>
            </li>
            <li>
              <a href="#usage-firephp">FirePHP Logger</a>
            </li>
            <li>
              <a href="#usage-custom">Implementar tus propios adaptadores</a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Logging

`Phalcon\Logger` es un componente cuyo propósito es proporcionar servicios de registro (logging) para aplicaciones. Ofrece diferentes formas de almacenamiento con diversos adaptadores. También ofrece registro de transacciones, opciones de configuración, diferentes formatos y filtros. Puede utilizar el `Phalcon\Logger` para cada necesidad de registrar información que tenga su aplicación, desde depuración de procesos hasta el rastreo del flujo de una aplicación.

<a name='adapters'></a>

## Adaptadores

Este componente hace uso de adaptadores para almacenar los mensajes. El uso de adaptadores permite una interfaz común de registro de mensajes y proporciona la capacidad de cambiar fácilmente el método de almacenamiento (backend) si es necesario. Los adaptadores soportados son:

| Adaptador                           | Descripción                                             |
| ----------------------------------- | ------------------------------------------------------- |
| `Phalcon\Logger\Adapter\File`    | Registros son almacenados en un archivo de texto        |
| `Phalcon\Logger\Adapter\Stream`  | Registros enviados al PHP Stream                        |
| `Phalcon\Logger\Adapter\Syslog`  | Registros se almacenan en el sistema de log del sistema |
| `Phalcon\Logger\Adapter\FirePHP` | Registros se envían a la extensión FirePHP              |

<a name='adapters-factory'></a>

### Factory

Carga la clase adaptador Logger utilizando la opción `adapter`

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

## Creación de un Log

El siguiente ejemplo muestra cómo crear un registro y añadir mensajes a él:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\File as FileAdapter;

$logger = new FileAdapter('app/logs/test.log');

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
    'This is a message'
);

// You can also pass context parameters like this
$logger->log(
    'This is a {message}', 
    [ 
        'message' => 'parameter' 
    ]
);
```

The log generated is below:

```bash
[Tue, 28 Jul 15 22:09:02 -0500][CRITICAL] This is a critical message
[Tue, 28 Jul 15 22:09:02 -0500][EMERGENCY] This is an emergency message
[Tue, 28 Jul 15 22:09:02 -0500][DEBUG] This is a debug message
[Tue, 28 Jul 15 22:09:02 -0500][ERROR] This is an error message
[Tue, 28 Jul 15 22:09:02 -0500][INFO] This is an info message
[Tue, 28 Jul 15 22:09:02 -0500][NOTICE] This is a notice message
[Tue, 28 Jul 15 22:09:02 -0500][WARNING] This is a warning message
[Tue, 28 Jul 15 22:09:02 -0500][ALERT] This is an alert message
[Tue, 28 Jul 15 22:09:02 -0500][ERROR] This is another error message
[Tue, 28 Jul 15 22:09:02 -0500][DEBUG] This is a message
[Tue, 28 Jul 15 22:09:02 -0500][DEBUG] This is a parameter
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

// Create the logger
$logger = new FileAdapter('app/logs/test.log');

// Start a transaction
$logger->begin();

// Add messages

$logger->alert(
    'This is an alert'
);

$logger->error(
    'This is another error'
);

// Commit messages to file
$logger->commit();
```

<a name='multiple-handlers'></a>

## Registro de múltiples gestores

`Phalcon\Logger` can send messages to multiple handlers with a just single call:

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
    'This is a message'
);

$logger->log(
    'This is an error',
    Logger::ERROR
);

$logger->error(
    'This is another error'
);
```

The messages are sent to the handlers in the order they were registered.

<a name='message-formatting'></a>

## Formato de mensaje

This component makes use of `formatters` to format messages before sending them to the backend. The formatters available are:

| Adaptador                             | Descripción                                                     |
| ------------------------------------- | --------------------------------------------------------------- |
| `Phalcon\Logger\Formatter\Line`    | Formato de mensajes utilizando una cadena de texto de una línea |
| `Phalcon\Logger\Formatter\Firephp` | Formato de mensajes que pueden ser enviados a FirePHP           |
| `Phalcon\Logger\Formatter\Json`    | Prepara un mensaje para ser codificados con JSON                |
| `Phalcon\Logger\Formatter\Syslog`  | Se prepara un mensaje para enviarse al syslog                   |

<a name='message-formatting-line'></a>

### Formateador de línea

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

// Changing the logger format
$logger->setFormatter($formatter);
```

<a name='message-formatting-custom'></a>

### Implementar tus propios formateadores

The `Phalcon\Logger\FormatterInterface` interface must be implemented in order to create your own logger formatter or extend the existing ones.

<a name='usage'></a>

## Adaptadores

The following examples show the basic use of each adapter:

<a name='usage-stream'></a>

### Stream Logger

The stream logger writes messages to a valid registered stream in PHP. A list of streams is available [here](http://php.net/manual/en/wrappers.php):

```php
<?php

use Phalcon\Logger\Adapter\Stream as StreamAdapter;

// Opens a stream using zlib compression
$logger = new StreamAdapter('compress.zlib://week.log.gz');

// Writes the logs to stderr
$logger = new StreamAdapter('php://stderr');
```

<a name='usage-file'></a>

### File Logger

This logger uses plain files to log any kind of data. By default all logger files are opened using append mode which opens the files for writing only; placing the file pointer at the end of the file. If the file does not exist, an attempt will be made to create it. You can change this mode by passing additional options to the constructor:

```php
<?php

use Phalcon\Logger\Adapter\File as FileAdapter;

// Create the file logger in 'w' mode
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

// Basic Usage
$logger = new SyslogAdapter(null);

// Setting ident/mode/facility
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

This logger sends messages in HTTP response headers that are displayed by [FirePHP](http://www.firephp.org/), a [Firebug](http://getfirebug.com/) extension for Firefox.

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Firephp as Firephp;

$logger = new Firephp('');

$logger->log(
    'This is a message'
);

$logger->log(
    'This is an error',
    Logger::ERROR
);

$logger->error(
    'This is another error'
);
```

<a name='usage-custom'></a>

### Implementar tus propios adaptadores

The `Phalcon\Logger\AdapterInterface` interface must be implemented in order to create your own logger adapters or extend the existing ones.