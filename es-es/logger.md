---
layout: default
language: 'es-es'
version: '4.0'
upgrade: '#logger'
title: 'Logger'
keywords: 'psr-3, logger, adaptadores, noop, flujo, syslog'
---

# Logger

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

[Phalcon\Logger](api/phalcon_logger#logger-logger) es un componente que provee servicios de registro (logging) para aplicaciones. Ofrece registro para diferentes *back-ends* usando diferentes adaptadores. También ofrece registro de transacciones, opciones de configuración y diferentes formatos de registro. Puede usar [Phalcon\Logger](api/phalcon_logger#logger-logger) para cualquier registro que necesite su aplicación, desde procesos de depuración hasta rastreo del flujo de la aplicación.

![](/assets/images/implements-psr--3-blue.svg)

[Phalcon\Logger](api/phalcon_logger#logger-logger) se ha reescrito para cumplir con [PSR-3](https://www.php-fig.org/psr/psr-3/). Esto le permite usar [Phalcon\Logger](api/phalcon_logger#logger-logger) en cualquier aplicación que use un *logger* [PSR-3](https://www.php-fig.org/psr/psr-3/), no sólo el basado en Phalcon.

En v3, el *logger* incorporó el adaptador en el mismo componente. Esto en esencia significa que cuando se inicia el objeto de registro, el desarrollador está en realidad creando un adaptador (de archivo, flujo, etc.) con capacidad de registro.

En Phalcon v4 el componente se reescribió de tal manera que se dedica a la función de registro y acepta uno o más adaptadores que serán los responsables de las tareas de registro. Así se logra la compatibilidad con [PSR-3](https://www.php-fig.org/psr/psr-3/), se separan las responsabilidades del componente. También ofrece una forma fácil de adjuntar más de un adaptador al componente de registro para que se pueda realizar el registro en múltiples adaptadores. Con esta implementación se redujo el código necesario para este componente y se suprimió el componente antiguo `Logger\Multiple`.

## Adaptadores

El componente registro hace uso de diversos adaptadores para guardar los mensajes. El uso de adaptadores permite una interfaz común de registro de mensajes y proporciona la capacidad de cambiar fácilmente de backend o utilizar múltiples adaptadores en caso de ser necesario. Los adaptadores disponibles son:

| Adaptador                                                                    | Descripción                                                     |
| ---------------------------------------------------------------------------- | --------------------------------------------------------------- |
| [Phalcon\Logger\Adapter\Noop](api/phalcon_logger#logger-adapter-noop)     | Adaptador de agujero negro (usado mayoritariamente para testeo) |
| [Phalcon\Logger\Adapter\Stream](api/phalcon_logger#logger-adapter-stream) | Registra mensajes en un flujo de fichero                        |
| [Phalcon\Logger\Adapter\Syslog](api/phalcon_logger#logger-adapter-syslog) | Registra mensajes en el *Syslog*                                |

### Flujo (Stream)

Se usa para registrar mensajes en un archivo de flujo. Combina los adaptadores de v3 `Stream` y `File`. Es el de uso más extendido: llevar el registro en un archivo del sistema de archivos.

### Syslog (Registro del sistema)

Se usa para guardar los mensajes en el registro del sistema (*Syslog*). El comportamiento del *syslog* puede variar de un sistema operativo a otro.

### Noop (No operación)

Este adaptador es un agujero negro: ¡Envía mensajes al *infinito y más allá!* Se usa especialmente para pruebas --o para hacerle una broma a un colega.

## Fábrica (Factory)

Puede usar el componente [Phalcon\Logger\LoggerFactory](api/phalcon_logger#logger-loggerfactory) para crear un registrador. Para que funcione [Phalcon\Logger\LoggerFactory](api/phalcon_logger#logger-loggerfactory), necesita ser instanciado con [Phalcon\Logger\AdapterFactory](api/phalcon_logger#logger-adapterfactory):

```php
<?php

use Phalcon\Logger\LoggerFactory;
use Phalcon\Logger\AdapterFactory;

$adapterFactory = new AdapterFactory();
$loggerFactory  = new LoggerFactory($adapterFactory);
```

### `load()`

[Phalcon\Logger\LoggerFactory](api/phalcon_logger#logger-loggerfactory) ofrece el método `load`, que construye un registrador basado en la configuración suministrada. La configuración puede ser un vector o un objeto [Phalcon\Config](config).

> **NOTA**: Caso de Uso: Crear un *Logger* con dos adaptadores de Flujo. Un adaptador se llamará `main` para registrar todos los mensajes, mientras que el segundo se llamará `admin`, que registrará sólo mensajes generados en el área de administración de nuestra aplicación 
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

$adapterFactory = new AdapterFactory();
$loggerFactory  = new LoggerFactory($adapterFactory);

$logger = $loggerFactory->load($config);
```

### `newInstance()`

[Phalcon\Logger\LoggerFactory](api/phalcon_logger#logger-loggerfactory) también ofrece el método `newInstance()`, que construye un registrador basado en el nombre suministrado y el vector de adaptadores relevantes. Usando el caso de uso anterior:

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

## Creando un Registro

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

El ejemplo anterior crea un adaptador [Flujo](api/phalcon_logger#logger-adapter-stream). Luego se crea un objeto de registro y se le adjunta el adaptador. Cada adaptador debe tener un nombre único, de tal manera que el registro sepa dónde guardar los mensajes. Cuando se llama al método `error()` del objeto *logger*, el mensaje se almacenará en `/storage/logs/main.log`.

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

## Múltiples Adaptadores

[Phalcon\Logger](api/phalcon_logger#logger-logger) puede enviar mensajes a múltiples adaptadores con una sola llamada:

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

### Exclusión de Adaptadores

[Phalcon\Logger](api/phalcon_logger#logger-logger) también ofrece la posibilidad de excluir el registro de uno o más adaptadores cunado se registra un mensaje. En especial, por ejemplo, cuando es necesario registrar un mensaje en el adaptador `manager` pero no en el adaptador `local` sin necesidad de instanciar un nuevo registro:

Con la siguiente configuración:

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

> **NOTA** Internamente, el componente itera a través de los adaptadores registrados y llama al método de registro relevante para lograr el registro en múltiples adaptadores. Si uno de ellos falla, el bucle se romperá y los adaptadores restantes (del bucle) no registrarán el mensaje. En futuras versiones de Phalcon se introducirá el registro asíncrono para mitigar este problema.
{: .alert .alert-warning }

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

[Phalcon\Logger](api/phalcon_logger#logger-logger) permite configurar el nivel mínimo de registro para el/los registrador(es). Si configura este valor entero, cualquier nivel superior en número que el configurado no será registrado. Compruebe los valores de las constantes en la sección previa para ver el orden en que se establecieron los niveles.

En el siguiente ejemplo, establecemos el nivel de registro a `ALERT`. Solo veremos mensajes `EMERGENCY`, `CRITICAL` **y** `ALERT`.

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

$logger->alert("Esto es un mensaje de alerta");
$logger->critical("Esto es un mensaje crítico");
$logger->debug("Esto es un mensaje de depuración");
$logger->error("Esto es un mensaje de error");
$logger->emergency("Esto es un mensaje de emergencia");
$logger->info("Esto es un mensaje informativo");
$logger->log(Logger::CRITICAL, "Esto es un mensaje de registro");
$logger->notice("Este es un mensaje de aviso");
$logger->warning("Este es un mensaje de advertencia");

```

El resultado de los anteriores mensajes registrados es:

```bash
[Tue, 25 Dec 18 12:13:14 -0400][ALERT] Esto es un mensaje de alerta
[Tue, 25 Dec 18 12:13:14 -0400][CRITICAL] Esto es un mensaje crítico
[Tue, 25 Dec 18 12:13:14 -0400][EMERGENCY] Esto es un mensaje de emergencia
[Tue, 25 Dec 18 12:13:14 -0400][CRITICAL] Esto es un mensaje de registro
```

Se puede usar lo anterior en situaciones en las que quiere registrar mensajes de una cierta gravedad basados en condiciones de su aplicación como modo desarrollo vs. producción.

> **NOTA**: El nivel de registro configurado se incluye en el registro. Cualquiera **debajo** de ese nivel (es decir, número más alto) no se registrará
{: .alert .alert-info }

> 
> **NOTA**: **Nunca** es una buena idea eliminar niveles de registro en su aplicación, ya que incluso los errores de advertencia requieren ciclos de CPU para procesarse y descuidar estos errores podría potencialmente provocar circunstancias no deseadas 
{: .alert .alert-danger }

## Transacciones

[Phalcon\Logger](api/phalcon_logger#logger-logger) también ofrece la posibilidad de encolar los mensajes en su registrador, y luego *confirmarlos* todos juntos en el fichero de registro. Esto es similar a una transacción de base de datos con `begin` y `commit`. Cada adaptador expone los siguientes métodos: - `begin` - Inicia la transacción de registro - `inTransaction` - `bool` si está en una transacción o no - `commit` - escribe todos los mensajes encolados en el fichero de registro

Ya que la funcionalidad está disponible en el nivel de adaptador, puede programar su registro para que use transacciones como base por adaptador.

```php
<?php

use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter1 = new Stream('/logs/primer-registro.log');
$adapter2 = new Stream('/remote/segundo-registro.log');
$adapter3 = new Stream('/manager/tercer-registro.log');

$logger = new Logger(
    'messages',
    [
        'local'   => $adapter1,
        'remote'  => $adapter2,
        'manager' => $adapter3,
    ]
);

$logger->getAdapter('manager')->begin();

$logger->error('Ha ocurrido algo');

$logger->getAdapter('manager')->commit();
```

En el ejemplo anterior, registramos tres adaptadores. Hemos establecido el registro `manager` para estar en modo transacción. Tan pronto como llamamos:

```php
$logger->error('Ha ocurrido algo');
```

el mensaje se registrará en ambos adaptadores `local` y `remote`. Se encolará para el adaptador `manager` y no se registrará hasta que llamemos al método `commit` en el adaptador `manager`.

> **NOTA**: si configura uno o más adaptadores en modo transacción (es decir, llamar a `begin`) y olvidamos llamar a `commit`, el adaptador llamará a `commit` por usted justo antes de ser destruido.
{: .alert .alert-info }
## Formato de mensaje

Este componente utiliza `formatters` para formatear mensajes antes de enviarlos al backend. Los formateadores disponibles son:

| Adaptador                                                                    | Descripción                                    |
| ---------------------------------------------------------------------------- | ---------------------------------------------- |
| [Phalcon\Logger\Formatter\Line](api/phalcon_logger#logger-formatter-line) | Formatea el mensaje en una sola línea de texto |
| [Phalcon\Logger\Formatter\Json](api/phalcon_logger#logger-formatter-json) | Formatea el mensaje en una cadena JSON         |

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

$logger->error('Algo falló');
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

$logger->error('Algo falló');
```

#### Formato de fecha

El formato predeterminado es:

```bash
"D, d M y H:i:s O"
```

En caso de que el formato predeterminado no se ajuste a las necesidades de la aplicación, se puede personalizar mediante el método `setFormat()`. El método acepta una cadena de caracteres que corresponden a formatos de fecha. Para todos los formatos disponibles, por favor consulte [esta página](https://www.php.net/manual/en/function.date.php).

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

$logger->error('Algo falló'); 
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

#### Formato de fecha

El formato predeterminado es:

```bash
"D, d M y H:i:s O"
```

En caso de que el formato predeterminado no se ajuste a las necesidades de la aplicación, se puede personalizar mediante el método `setFormat()`. El método acepta una cadena de caracteres que corresponden a formatos de fecha. Para todos los formatos disponibles, por favor consulte [esta página](https://www.php.net/manual/en/function.date.php).

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

$logger->error('Algo falló');
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

Se debe implementar la interfaz [Phalcon\Logger\Formatter\FormatterInterface](api/phalcon_logger#logger-formatter-formatterinterface) para poder crear su propio formateador o extender los existentes. Adicionalmente, puede reutilizar la clase abstracta [Phalcon\Logger\Formatter\AbstractFormatter](api/phalcon_logger#logger-formatter-abstractformatter).

## Interpolación

Con el componente registro también se puede usar interpolación. Hay casos en los que es necesario agregar texto adicional a los mensajes de registro, por ejemplo, texto que ha sido creado dinámicamente por la aplicación. Para lograrlo solo se necesita enviar una matriz como segundo parámetro del método de registro (p.e. `error`, `info`, `alert`, etc.). El vector mantiene claves y valores, donde la clave es el marcador de posición en el mensaje y el valor el contenido que será inyectado en el mensaje.

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

$message = '{framework} ejecuta el test "Hello World" en {secs} segundo(s)';
$context = [
    'framework' => 'Phalcon',
    'secs'      => 1,
];

$logger->info($message, $context);
```

## Item

Las clases formateadoras anteriores aceptan un objeto [Phalcon\Logger\Item](api/phalcon_logger#logger-item). El objeto contiene todo los datos necesarios para proceso de registro. Se usa como transporte de datos desde el registrador hasta el formateador.

## Excepciones

Cualquier excepción lanzada en el componente `Logger` será del tipo [Phalcon\Logger\Exception](api/phalcon_logger#logger-exception). Puede usar esta excepción para capturar selectivamente sólo las excepciones lanzadas desde este componente.

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
    $logger->error('Algo falló');
} catch (Exception $ex) {
    echo $ex->getMessage();
}
```

## Ejemplos

### Flujo (Stream)

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
$logger->error('Algo falló');
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

### Registro de Sistema (Syslog)

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

$logger->error('Algo falló');
```

### No operación (Noop)

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

### Adaptadores Personalizados

Se debe implementar la interfaz [Phalcon\Logger\AdapterInterface](api/phalcon_logger#logger-adapter-adapterinterface) para poder crear su propio adaptador de registro o extender los existentes. También puede aprovechar la funcionalidad en la clase abstracta [Phalcon\Logger\Adapter\AbstractAdapter](api/phalcon_logger#logger-adapter-abstractadapter).

### Clases Abstractas

Hay dos clases abstractas que ofrecen funcionalidad útil al crear adaptadores personalizados: [Phalcon\Logger\Adapter\AbstractAdapter](api/phalcon_logger#logger-adapter-abstractadapter) y [Phalcon\Logger\Formatter\AbstractFormatter](api/phalcon_logger#logger-formatter-abstractformatter).

## Inyección de Dependencias

Puede registrar tantos registradores como quiera en el contenedor \[Phalcon\Di\FactoryDefault\]\[factorydefault\]. A continuación, un ejemplo de registro del servicio así como de acceso a él:

```php
<?php

use Phalcon\Di;
use Phalcon\Logger;
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

// accederemos a él más tarde:
$logger = $container->getShared('logger');

```
