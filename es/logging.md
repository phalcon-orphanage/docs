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

// Hay diferentes niveles de registo disponibles:

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

// Puedes usar el método log() con una constante Logger:
$logger->log(
    'This is another error message',
    Logger::ERROR
);

// Si no se proporciona una constante, se asume el valor DEBUG.
$logger->log(
    'This is a message'
);

// Puedes pasar parámetros de contexto, por ejemplo
$logger->log(
    'This is a {message}', 
    [ 
        'message' => 'parameter' 
    ]
);
```

El registro generado está abajo:

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

También puede establecer un nivel de registro utilizando el método `setLogLevel()`. Este método toma una constante Logger y solo guardará los mensajes de registro que son tan importantes o más importantes que la constante:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\File as FileAdapter;

$logger = new FileAdapter('app/logs/test.log');

$logger->setLogLevel(
    Logger::CRITICAL
);
```

En el ejemplo anterior, solo los mensajes críticos y de emergencia se guardarán en el registro. Por defecto, todo está guardado.

<a name='transactions'></a>

## Transacciones

Registrar datos en un adaptador, es decir, el archivo (sistema de archivos) es siempre una operación costosa en términos de rendimiento. Para combatir eso, puede aprovechar las transacciones de registro. Las transacciones almacenan datos de registro temporalmente en la memoria y luego escriben los datos en el adaptador relevante (Archivo en este caso) en una sola operación atómica.

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

`Phalcon\Logger` puede enviar mensajes a múltiples controladores con una sola y única llamada:

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

Los mensajes se envían a los controladores en el orden en que se registraron.

<a name='message-formatting'></a>

## Formato de mensaje

Este componente utiliza `formatters` para formatear los mensajes antes de enviarlos al back-end. Los formatters disponibles son:

| Adaptador                             | Descripción                                                     |
| ------------------------------------- | --------------------------------------------------------------- |
| `Phalcon\Logger\Formatter\Line`    | Formato de mensajes utilizando una cadena de texto de una línea |
| `Phalcon\Logger\Formatter\Firephp` | Formato de mensajes que pueden ser enviados a FirePHP           |
| `Phalcon\Logger\Formatter\Json`    | Prepara un mensaje para ser codificados con JSON                |
| `Phalcon\Logger\Formatter\Syslog`  | Se prepara un mensaje para enviarse al syslog                   |

<a name='message-formatting-line'></a>

### Formateador de línea

Formatea los mensajes usando una cadena de una línea. El formato de registro predeterminado es:

```bash
[%date%][%type%] %message%
```

Puede cambiar el formato predeterminado usando `setFormat()`, esto le permite cambiar el formato de los mensajes registrados definiendo el suyo. Las variables de formato de registro permitidas son:

| Variable  | Descripción                        |
| --------- | ---------------------------------- |
| %message% | El mensaje que se espera registrar |
| %date%    | Fecha que del mensaje fue agregado |
| %type%    | Tipo de mensaje en mayúsculas      |

El siguiente ejemplo muestra cómo cambiar el formato de registro:

```php
<?php

use Phalcon\Logger\Formatter\Line as LineFormatter;

$formatter = new LineFormatter('%date% - %message%');

// Changing the logger format
$logger->setFormatter($formatter);
```

<a name='message-formatting-custom'></a>

### Implementar tus propios formateadores

La interfaz `Phalcon\Logger\FormatterInterface ` debe implementarse para crear su propio formateador de registro o ampliar los existentes.

<a name='usage'></a>

## Adaptadores

Los siguientes ejemplos muestran el uso básico de cada adaptador:

<a name='usage-stream'></a>

### Stream Logger

El Stream Logger escribe mensajes en una secuencia registrada válida en PHP. Una lista de streams [aquí](http://php.net/manual/en/wrappers.php):

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

Este registrador usa archivos simples para registrar cualquier tipo de dato. Por defecto, todos los archivos del registrador se abren usando el modo de adición que abre los archivos para escritura solamente; colocando el puntero del archivo al final del archivo. Si el archivo no existe, se intentará crearlo. Puede cambiar este modo pasando opciones adicionales al constructor:

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

Este registrador envía mensajes al registrador del sistema. El comportamiento de syslog puede variar de un sistema operativo a otro.

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

Este registrador envía mensajes en encabezados de respuesta HTTP que se muestran por [FirePHP](http://www.firephp.org/), una [Firebug](http://getfirebug.com/) extensión para Firefox.

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

La interfaz `Phalcon\Logger\Adapterinterface` debe implementarse para crear sus propios adaptadores de registradores o ampliar los existentes.