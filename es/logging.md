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

A continuación se muestra el registro generado por el código anterior:

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

También puede establecer un nivel de registro utilizando el método `setLogLevel()`. Este método toma una constante Logger y solo guardará los mensajes de registro que son tan importantes o más que la constante:

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\File as FileAdapter;

$logger = new FileAdapter('app/logs/test.log');

$logger->setLogLevel(
    Logger::CRITICAL
);
```

En el ejemplo anterior, solo los mensajes críticos y de emergencia se guardarán en el registro. Por defecto, se guardan todos los mensajes.

<a name='transactions'></a>

## Transacciones

Registrando datos en un adaptador, por ejemplo, de archivo (sistema de archivos) es siempre una operación costosa en términos de rendimiento. Para combatir eso, puede tomar ventaja del registro de transacciones. Las transacciones almacenan temporalmente los datos de registro en la memoria y luego escriben los datos en el adaptador correspondiente (archivo en este caso) en una única operación atómica.

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

`Phalcon\Logger` puede enviar mensajes a múltiples gestores con sólo una llamada:

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

Los mensajes son enviados a los gestores en el orden que se registraron.

<a name='message-formatting'></a>

## Formato de mensaje

Este componente utiliza `formatters` para formatear mensajes antes de enviarlos al backend. Los formateadores disponibles son:

| Adaptador                             | Descripción                                                     |
| ------------------------------------- | --------------------------------------------------------------- |
| `Phalcon\Logger\Formatter\Line`    | Formato de mensajes utilizando una cadena de texto de una línea |
| `Phalcon\Logger\Formatter\Firephp` | Formato de mensajes que pueden ser enviados a FirePHP           |
| `Phalcon\Logger\Formatter\Json`    | Prepara un mensaje para ser codificados con JSON                |
| `Phalcon\Logger\Formatter\Syslog`  | Se prepara un mensaje para enviarse al syslog                   |

<a name='message-formatting-line'></a>

### Formateador de línea

Formatea los mensajes utilizando una cadena de una línea. El formato predeterminado de registro es:

```bash
[%date%][%type%] %message%
```

Puede cambiar el formato predeterminado utilizando `setFormat()`, esto le permite cambiar el formato de los mensajes registrados mediante la definición de uno propio. Las variables de formato de registro permitidas son:

| Variable  | Descripción                        |
| --------- | ---------------------------------- |
| %message% | El mensaje que se espera registrar |
| %date%    | Fecha que del mensaje fue agregado |
| %type%    | Tipo de mensaje en mayúsculas      |

El ejemplo siguiente muestra cómo cambiar el formato de registro:

```php
<?php

use Phalcon\Logger\Formatter\Line as LineFormatter;

$formatter = new LineFormatter('%date% - %message%');

// Cambiando el formato de registro
$logger->setFormatter($formatter);
```

<a name='message-formatting-custom'></a>

### Implementar tus propios formateadores

Debe implementar la interfaz `Phalcon\Logger\FormatterInterface` para crear a su propio formateador de registrados o extender los ya existentes.

<a name='usage'></a>

## Adaptadores

Los siguientes ejemplos muestran el uso básico de cada adaptador:

<a name='usage-stream'></a>

### Stream Logger

El Stream Logger escribe mensajes en una secuencia registrada válida en PHP. Una lista de streams [aquí](http://php.net/manual/en/wrappers.php):

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

Este registrador utiliza archivos planos para registrar cualquier tipo de datos. Por defecto, que todos los archivos de registro se abren usando el modo 'append', que abre los archivos para escribir colocando el puntero del archivo al final del mismo. Si el archivo no existe, se hará un intento por crearlo. Ud. puede cambiar este modo pasando opciones adicionales al constructor:

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

Este registrador envía mensajes al sistema de registro del sistema. El comportamiento de registro del sistema puede variar de un sistema operativo a otro.

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

Este registrador envía mensajes en encabezados de respuesta HTTP que se muestran por [FirePHP](http://www.firephp.org/), una extensión de [Firebug](http://getfirebug.com/) para Firefox.

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

### Implementar tus propios adaptadores

Debe implementar la interfaz `Phalcon\Logger\AdapterInterface` para crear sus propios adaptadores de registro o extender los ya existentes.