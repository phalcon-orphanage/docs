---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Logger'
---

* [Phalcon\Logger](#logger)
* [Phalcon\Logger\Adapter\AbstractAdapter](#logger-adapter-abstractadapter)
* [Phalcon\Logger\Adapter\AdapterInterface](#logger-adapter-adapterinterface)
* [Phalcon\Logger\Adapter\Noop](#logger-adapter-noop)
* [Phalcon\Logger\Adapter\Stream](#logger-adapter-stream)
* [Phalcon\Logger\Adapter\Syslog](#logger-adapter-syslog)
* [Phalcon\Logger\AdapterFactory](#logger-adapterfactory)
* [Phalcon\Logger\Exception](#logger-exception)
* [Phalcon\Logger\Formatter\AbstractFormatter](#logger-formatter-abstractformatter)
* [Phalcon\Logger\Formatter\FormatterInterface](#logger-formatter-formatterinterface)
* [Phalcon\Logger\Formatter\Json](#logger-formatter-json)
* [Phalcon\Logger\Formatter\Line](#logger-formatter-line)
* [Phalcon\Logger\Item](#logger-item)
* [Phalcon\Logger\LoggerFactory](#logger-loggerfactory)

<h1 id="logger">Class Phalcon\Logger</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Logger.zep)

| Namespace | Phalcon | | Uses | Psr\Log\LoggerInterface, Phalcon\Logger\Adapter\AdapterInterface, Phalcon\Logger\Item, Phalcon\Logger\Exception | | Implements | LoggerInterface |

Phalcon\Logger

Este componente ofrece capacidades de registro para su aplicación. El componente acepta múltiples adaptadores, trabajando también como un registrador múltiple. Phalcon\Logger implementa PSR-3.

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
```

## Constantes

```php
const ALERT = 2;
const CRITICAL = 1;
const CUSTOM = 8;
const DEBUG = 7;
const EMERGENCY = 0;
const ERROR = 3;
const INFO = 6;
const NOTICE = 5;
const WARNING = 4;
```

## Propiedades

```php
/**
 * The adapter stack
 *
 * @var AdapterInterface[]
 */
protected adapters;

/**
 * Minimum log level for the logger
 *
 * @var int
 */
protected logLevel = 8;

/**
 * @var string
 */
protected name = ;

/**
 * The excluded adapters for this log process
 *
 * @var AdapterInterface[]
 */
protected excluded;

```

## Métodos

```php
public function __construct( string $name, array $adapters = [] );
```

Constructor.

```php
public function addAdapter( string $name, AdapterInterface $adapter ): Logger;
```

Añade un adaptador a la pila. Para el procesamiento usamos FIFO

```php
public function alert( mixed $message, array $context = [] ): void;
```

Se deben tomar medidas de inmediato.

Ejemplo: Sitio web completo, base de datos no disponible, etc. Esto debería activar las alertas de SMS y despertarte.

```php
public function critical( mixed $message, array $context = [] ): void;
```

Condiciones críticas.

Ejemplo: Componente de aplicación no disponible, excepción inesperada.

```php
public function debug( mixed $message, array $context = [] ): void;
```

Información detallada de depuración.

```php
public function emergency( mixed $message, array $context = [] ): void;
```

El sistema está inutilizable.

```php
public function error( mixed $message, array $context = [] ): void;
```

Errores en tiempo de ejecución que no requieren una acción inmediata, pero normalmente deberían ser registrados y monitoreados.

```php
public function excludeAdapters( array $adapters = [] ): Logger;
```

Excluye ciertos adaptadores.

```php
public function getAdapter( string $name ): AdapterInterface;
```

Devuelve un adaptador de la pila

```php
public function getAdapters(): array;
```

Devuelve el vector de la pila de adaptadores

```php
public function getLogLevel(): int
```

```php
public function getName(): string;
```

Devuelve el nombre del registrador

```php
public function info( mixed $message, array $context = [] ): void;
```

Eventos interesantes.

Ejemplo: Inicio de sesión de usuario, registros SQL.

```php
public function log( mixed $level, mixed $message, array $context = [] ): void;
```

Registros con un nivel arbitrario.

```php
public function notice( mixed $message, array $context = [] ): void;
```

Eventos normales pero significativos.

```php
public function removeAdapter( string $name ): Logger;
```

Elimina un adaptador de la pila

```php
public function setAdapters( array $adapters ): Logger;
```

Establece la pila de adaptadores sobreescribiendo lo que ya existe

```php
public function setLogLevel( int $level ): Logger;
```

Establece el nivel de registro por encima del cual podemos registrar

```php
public function warning( mixed $message, array $context = [] ): void;
```

Ocurrencias excepcionales que no son errores.

Ejemplo: Uso de APIs obsoletas, mal uso de una API, cosas indeseables que no necesariamente son erróneas.

```php
protected function addMessage( int $level, string $message, array $context = [] ): bool;
```

Añade un mensaje a cada manejador para procesar

```php
protected function getLevels(): array;
```

Devuelve un vector de niveles de registro con conversión de entero a cadena

<h1 id="logger-adapter-abstractadapter">Abstract Class Phalcon\Logger\Adapter\AbstractAdapter</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Logger/Adapter/AbstractAdapter.zep)

| Namespace | Phalcon\Logger\Adapter | | Uses | Phalcon\Logger, Phalcon\Logger\Exception, Phalcon\Logger\Formatter\FormatterInterface, Phalcon\Logger\Item | | Implements | AdapterInterface |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team [&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;](&#x6d;&#97;&#x69;&#x6c;&#116;&#x6f;&#58;&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;)

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.

## Propiedades

```php
/**
 * Name of the default formatter class
 *
 * @var string
 */
protected defaultFormatter = Line;

/**
 * Formatter
 *
 * @var FormatterInterface
 */
protected formatter;

/**
 * Tells if there is an active transaction or not
 *
 * @var bool
 */
protected inTransaction = false;

/**
 * Array with messages queued in the transaction
 *
 * @var array
 */
protected queue;

```

## Métodos

```php
public function __destruct();
```

Limpieza del destructor

```php
public function add( Item $item ): AdapterInterface;
```

Añade un mensaje a la cola

```php
public function begin(): AdapterInterface;
```

Inicia una transacción

```php
public function commit(): AdapterInterface;
```

Confirma la transacción interna

```php
public function getFormatter(): FormatterInterface;
```

```php
public function inTransaction(): bool;
```

Devuelve si el registrador está actualmente en una transacción activa o no

```php
abstract public function process( Item $item ): void;
```

Procesa el mensaje en el adaptador

```php
public function rollback(): AdapterInterface;
```

Deshace la transacción interna

```php
public function setFormatter( FormatterInterface $formatter ): AdapterInterface;
```

Establece el formateador de mensajes

<h1 id="logger-adapter-adapterinterface">Interface Phalcon\Logger\Adapter\AdapterInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Logger/Adapter/AdapterInterface.zep)

| Namespace | Phalcon\Logger\Adapter | | Uses | Phalcon\Logger\Formatter\FormatterInterface, Phalcon\Logger\Item |

Phalcon\Logger\AdapterInterface

Interfaz para adaptadores Phalcon\Logger

## Métodos

```php
public function add( Item $item ): AdapterInterface;
```

Añade un mensaje en la cola

```php
public function begin(): AdapterInterface;
```

Inicia una transacción

```php
public function close(): bool;
```

Cierra el registrador

```php
public function commit(): AdapterInterface;
```

Confirma la transacción interna

```php
public function getFormatter(): FormatterInterface;
```

Devuelve el formateador interno

```php
public function inTransaction(): bool;
```

Devuelve si el registrador está actualmente en una transacción activa o no

```php
public function process( Item $item ): void;
```

Procesa el mensaje en el adaptador

```php
public function rollback(): AdapterInterface;
```

Deshace la transacción interna

```php
public function setFormatter( FormatterInterface $formatter ): AdapterInterface;
```

Establece el formateador de mensajes

<h1 id="logger-adapter-noop">Class Phalcon\Logger\Adapter\Noop</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Logger/Adapter/Noop.zep)

| Namespace | Phalcon\Logger\Adapter | | Uses | Phalcon\Logger\Item | | Extends | AbstractAdapter |

Phalcon\Logger\Adapter\Noop

Adaptador para almacenar registros en archivos de texto simple

```php
$logger = new \Phalcon\Logger\Adapter\Noop();

$logger->log(\Phalcon\Logger::ERROR, "This is an error");
$logger->error("This is another error");

$logger->close();
```

## Métodos

```php
public function close(): bool;
```

Cierra el flujo

```php
public function process( Item $item ): void;
```

Procesa el mensaje, es decir, lo escribe en el fichero

<h1 id="logger-adapter-stream">Class Phalcon\Logger\Adapter\Stream</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Logger/Adapter/Stream.zep)

| Namespace | Phalcon\Logger\Adapter | | Uses | Phalcon\Logger\Adapter, Phalcon\Logger\Exception, Phalcon\Logger\Formatter\FormatterInterface, Phalcon\Logger\Item, UnexpectedValueException | | Extends | AbstractAdapter |

Phalcon\Logger\Adapter\Stream

Adaptador para almacenar registros en fichero de texto simple

```php
$logger = new \Phalcon\Logger\Adapter\Stream("app/logs/test.log");

$logger->log("This is a message");
$logger->log(\Phalcon\Logger::ERROR, "This is an error");
$logger->error("This is another error");

$logger->close();
```

## Propiedades

```php
/**
 * Stream handler resource
 *
 * @var resource|null
 */
protected handler;

/**
 * The file open mode. Defaults to "ab"
 *
 * @var string
 */
protected mode = ab;

/**
 * Stream name
 *
 * @var string
 */
protected name;

/**
 * Path options
 *
 * @var array
 */
protected options;

```

## Métodos

```php
public function __construct( string $name, array $options = [] );
```

Constructor. Acepta el nombre y algunas opciones

```php
public function close(): bool;
```

Cierra el flujo

```php
public function getName(): string
```

```php
public function process( Item $item ): void;
```

Procesa el mensaje, es decir, lo escribe en el fichero

<h1 id="logger-adapter-syslog">Class Phalcon\Logger\Adapter\Syslog</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Logger/Adapter/Syslog.zep)

| Namespace | Phalcon\Logger\Adapter | | Uses | LogicException, Phalcon\Helper\Arr, Phalcon\Logger, Phalcon\Logger\Adapter, Phalcon\Logger\Exception, Phalcon\Logger\Formatter\FormatterInterface, Phalcon\Logger\Item | | Extends | AbstractAdapter |

Phalcon\Logger\Adapter\Syslog

Envía registros al registrador del sistema

```php
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Syslog;

// LOG_USER is the only valid log type under Windows operating systems
$logger = new Syslog(
    "ident",
    [
        "option"   => LOG_CONS | LOG_NDELAY | LOG_PID,
        "facility" => LOG_USER,
    ]
);

$logger->log("This is a message");
$logger->log(Logger::ERROR, "This is an error");
$logger->error("This is another error");
```

## Propiedades

```php
/**
 * Name of the default formatter class
 *
 * @var string
 */
protected defaultFormatter = Line;

/**
 * @var int
 */
protected facility = 0;

/**
 * @var string
 */
protected name = ;

/**
 * @var bool
 */
protected opened = false;

/**
 * @var int
 */
protected option = 0;

```

## Métodos

```php
public function __construct( string $name, array $options = [] );
```

Phalcon\Logger\Adapter\Syslog constructor

```php
public function close(): bool;
```

Cierra el registrador

```php
public function process( Item $item ): void;
```

Procesa el mensaje, es decir, lo escribe en el `syslog`

<h1 id="logger-adapterfactory">Class Phalcon\Logger\AdapterFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Logger/AdapterFactory.zep)

| Namespace | Phalcon\Logger | | Uses | Phalcon\Factory\AbstractFactory, Phalcon\Logger\Adapter\AdapterInterface | | Extends | AbstractFactory |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team [&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;](&#x6d;&#97;&#x69;&#x6c;&#116;&#x6f;&#58;&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;)

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.

## Métodos

```php
public function __construct( array $services = [] );
```

Constructor AdapterFactory.

```php
public function newInstance( string $name, string $fileName, array $options = [] ): AdapterInterface;
```

Crea una nueva instancia del adaptador

```php
protected function getAdapters(): array;
```

<h1 id="logger-exception">Class Phalcon\Logger\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Logger/Exception.zep)

| Namespace | Phalcon\Logger | | Extends | \Phalcon\Exception |

Phalcon\Logger\Exception

Las excepciones lanzadas en Phalcon\Logger usarán esta clase

<h1 id="logger-formatter-abstractformatter">Abstract Class Phalcon\Logger\Formatter\AbstractFormatter</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Logger/Formatter/AbstractFormatter.zep)

| Namespace | Phalcon\Logger\Formatter | | Uses | DateTimeImmutable, DateTimeZone, Phalcon\Logger, Phalcon\Logger\Item | | Implements | FormatterInterface |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team [&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;](&#x6d;&#97;&#x69;&#x6c;&#116;&#x6f;&#58;&#116;&#x65;&#97;&#109;&#x40;&#112;&#104;&#x61;&#108;c&#x6f;&#110;&#x2e;&#x69;&#111;)

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.

## Propiedades

```php
/**
 * Default date format
 *
 * @var string
 */
protected dateFormat;

```

## Métodos

```php
public function getDateFormat(): string
```

```php
public function interpolate( string $message, mixed $context = null );
```

Interpola los valores de contexto dentro de los marcadores de posición del mensaje

@see http://www.php-fig.org/psr/psr-3/ Section 1.2 Message

```php
public function setDateFormat( string $dateFormat )
```

```php
protected function getFormattedDate(): string;
```

Devuelve la fecha formateada para el registrador. @todo No se usa el tiempo establecido del objeto ya que tenemos una alineación incorrecta de interfaz que romperá el semver. Esto cambiará en el futuro

<h1 id="logger-formatter-formatterinterface">Interface Phalcon\Logger\Formatter\FormatterInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Logger/Formatter/FormatterInterface.zep)

| Namespace | Phalcon\Logger\Formatter | | Uses | Phalcon\Logger\Item |

Phalcon\Logger\FormatterInterface

Se debe implementar esta interfaz por los formateadores en Phalcon\Logger

## Métodos

```php
public function format( Item $item ): string | array;
```

Aplica un formato a un elemento

<h1 id="logger-formatter-json">Class Phalcon\Logger\Formatter\Json</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Logger/Formatter/Json.zep)

| Namespace | Phalcon\Logger\Formatter | | Uses | Phalcon\Helper\Json, Phalcon\Logger\Item | | Extends | AbstractFormatter |

Phalcon\Logger\Formatter\Json

Formatea mensajes utilizando la codificación JSON

## Métodos

```php
public function __construct( string $dateFormat = string );
```

Constructor Phalcon\Logger\Formatter\Json

```php
public function format( Item $item ): string;
```

Aplica un formato a un mensaje antes de enviarlo al registro interno

<h1 id="logger-formatter-line">Class Phalcon\Logger\Formatter\Line</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Logger/Formatter/Line.zep)

| Namespace | Phalcon\Logger\Formatter | | Uses | DateTime, Phalcon\Logger\Item | | Extends | AbstractFormatter |

Phalcon\Logger\Formatter\Line

Formatea mensajes utilizando una cadena de una línea

## Propiedades

```php
/**
 * Format applied to each message
 *
 * @var string
 */
protected format;

```

## Métodos

```php
public function __construct( string $format = string, string $dateFormat = string );
```

Constructor Phalcon\Logger\Formatter\Line

```php
public function format( Item $item ): string;
```

Aplica un formato a un mensaje antes de enviarlo al registro interno

```php
public function getFormat(): string
```

```php
public function setFormat( string $format )
```

<h1 id="logger-item">Class Phalcon\Logger\Item</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Logger/Item.zep)

| Namespace | Phalcon\Logger |

Phalcon\Logger\Item

Representa cada objeto en una transacción de registro

## Propiedades

```php
/**
 * Log Context
 *      
 * @var mixed
 */
protected context;

/**
 * Log message
 *
 * @var string
 */
protected message;

/**
 * Log message
 *
 * @var string
 */
protected name;

/**
 * Log timestamp
 *
 * @var integer
 */
protected time;

/**
 * Log type
 *
 * @var integer
 */
protected type;

```

## Métodos

```php
public function __construct( string $message, string $name, int $type, int $time = int, mixed $context = [] );
```

Constructor Phalcon\Logger\Item @todo Eliminar el tiempo o cambiar la firma a un vector

```php
public function getContext(): mixed
```

```php
public function getMessage(): string
```

```php
public function getName(): string
```

```php
public function getTime(): integer
```

```php
public function getType(): integer
```

<h1 id="logger-loggerfactory">Class Phalcon\Logger\LoggerFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Logger/LoggerFactory.zep)

| Namespace | Phalcon\Logger | | Uses | Phalcon\Config, Phalcon\Config\ConfigInterface, Phalcon\Helper\Arr, Phalcon\Logger |

Phalcon\Logger\LoggerFactory

Factoría de Registrador

## Propiedades

```php
/**
 * @var AdapterFactory
 */
private adapterFactory;

```

## Métodos

```php
public function __construct( AdapterFactory $factory );
```

```php
public function load( mixed $config ): Logger;
```

Factoría para crear una instancia desde un objeto Config

```php
public function newInstance( string $name, array $adapters = [] ): Logger;
```

Devuelve un objeto Logger
