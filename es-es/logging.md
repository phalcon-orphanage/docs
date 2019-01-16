* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# Logging

[Phalcon\Logger](api/Phalcon_Logger) is a component whose purpose is to provide logging services for applications. It offers logging to different backends using different adapters. It also offers transaction logging, configuration options, different formats and filters. You can use the [Phalcon\Logger](api/Phalcon_Logger) for every logging need your application has, from debugging processes to tracing application flow.

<a name='adapters'></a>

## Adaptadores

This component makes use of adapters to store the logged messages. The use of adapters allows for a common logging interface which provides the ability to easily switch backends if necessary. The adapters supported are:

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

## Creación de un Log

The example below shows how to create a log and add messages to it:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\File as FileAdapter;

$logger = new FileAdapter('app/logs/test.log');

// Hay diferentes niveles de registo disponibles:

$logger->critical(
    'Este es un mensaje critico'
);

$logger->emergency(
    'Este es un mensaje de emergencia'
);

$logger->debug(
    'Este es un mensaje de depuración'
);

$logger->error(
    'Este es un mensaje de error'
);

$logger->info(
    'Este es un mensaje informativo'
);

$logger->notice(
    'Este es un mensaje de noticia'
);

$logger->warning(
    'Este es un mensaje de advertencia'
);

$logger->alert(
    'Este es un mensaje de alerta'
);

// Puedes usar el método log() con una constante Logger:
$logger->log(
    'ESte es otro mensaje de error',
    Logger::ERROR
);

// Si no se proporciona una constante, por defecto, se asume el valor DEBUG.
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

## Registro de múltiples gestores

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

## Formato de mensaje

This component makes use of `formatters` to format messages before sending them to the backend. The formatters available are:

| Adaptador                                                                   | Descripción                                                     |
| --------------------------------------------------------------------------- | --------------------------------------------------------------- |
| [Phalcon\Logger\Formatter\Line](api/Phalcon_Logger_Formatter_Line)       | Formato de mensajes utilizando una cadena de texto de una línea |
| [Phalcon\Logger\Formatter\Firephp](api/Phalcon_Logger_Formatter_Firephp) | Formato de mensajes que pueden ser enviados a FirePHP           |
| [Phalcon\Logger\Formatter\Json](api/Phalcon_Logger_Formatter_Json)       | Prepara un mensaje para ser codificados con JSON                |
| [Phalcon\Logger\Formatter\Syslog](api/Phalcon_Logger_Formatter_Syslog)   | Se prepara un mensaje para enviarse al syslog                   |

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

// Cambiando el formato de registro
$logger->setFormatter($formatter);
```

<a name='message-formatting-custom'></a>

### Implementar tus propios formateadores

The [Phalcon\Logger\FormatterInterface](api/Phalcon_Logger_FormatterInterface) interface must be implemented in order to create your own logger formatter or extend the existing ones.

<a name='usage'></a>

## Adaptadores

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

### Implementando sus propios adaptadores

The [Phalcon\Logger\AdapterInterface](api/Phalcon_Logger_AdapterInterface) interface must be implemented in order to create your own logger adapters or extend the existing ones.