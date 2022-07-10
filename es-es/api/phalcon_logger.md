---
layout: default
language: 'es-es'
version: '5.0'
title: 'Phalcon\Logger'
---

* [Phalcon\Logger\AbstractLogger](#logger-abstractlogger)
* [Phalcon\Logger\Adapter\AbstractAdapter](#logger-adapter-abstractadapter)
* [Phalcon\Logger\Adapter\AdapterInterface](#logger-adapter-adapterinterface)
* [Phalcon\Logger\Adapter\Noop](#logger-adapter-noop)
* [Phalcon\Logger\Adapter\Stream](#logger-adapter-stream)
* [Phalcon\Logger\Adapter\Syslog](#logger-adapter-syslog)
* [Phalcon\Logger\AdapterFactory](#logger-adapterfactory)
* [Phalcon\Logger\Enum](#logger-enum)
* [Phalcon\Logger\Exception](#logger-exception)
* [Phalcon\Logger\Formatter\AbstractFormatter](#logger-formatter-abstractformatter)
* [Phalcon\Logger\Formatter\FormatterInterface](#logger-formatter-formatterinterface)
* [Phalcon\Logger\Formatter\Json](#logger-formatter-json)
* [Phalcon\Logger\Formatter\Line](#logger-formatter-line)
* [Phalcon\Logger\Item](#logger-item)
* [Phalcon\Logger\Logger](#logger-logger)
* [Phalcon\Logger\LoggerFactory](#logger-loggerfactory)
* [Phalcon\Logger\LoggerInterface](#logger-loggerinterface)

<h1 id="logger-abstractlogger">Abstract Class Phalcon\Logger\AbstractLogger</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/AbstractLogger.zep)

| Namespace  | Phalcon\Logger | | Uses       | DateTimeImmutable, DateTimeZone, Exception, Phalcon\Logger\Exception, Phalcon\Logger\Adapter\AdapterInterface |

Abstract Logger Class

Abstract logger class, providing common functionality. A formatter interface is available as well as an adapter one. Adapters can be created easily using the built in AdapterFactory. A LoggerFactory is also available that allows developers to create new instances of the Logger or load them from config files (see Phalcon\Config\Config object).

@property AdapterInterface[] $adapters @property array              $excluded @property int                $logLevel @property string             $name @property string             $timezone


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
 * The excluded adapters for this log process
 *
 * @var array
 */
protected excluded;

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
 * @var DateTimeZone
 */
protected timezone;

```

## Métodos

```php
public function __construct( string $name, array $adapters = [], DateTimeZone $timezone = null );
```
Constructor.


```php
public function addAdapter( string $name, AdapterInterface $adapter ): AbstractLogger;
```
Añade un adaptador a la pila. Para el procesamiento usamos FIFO


```php
public function excludeAdapters( array $adapters = [] ): AbstractLogger;
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
public function getLogLevel(): int;
```
Returns the log level


```php
public function getName(): string;
```
Devuelve el nombre del registrador


```php
public function removeAdapter( string $name ): AbstractLogger;
```
Elimina un adaptador de la pila


```php
public function setAdapters( array $adapters ): AbstractLogger;
```
Establece la pila de adaptadores sobreescribiendo lo que ya existe


```php
public function setLogLevel( int $level ): AbstractLogger;
```
Establece la pila de adaptadores sobreescribiendo lo que ya existe


```php
protected function addMessage( int $level, string $message, array $context = [] ): bool;
```
Añade un mensaje a cada manejador para procesar


```php
protected function getLevelNumber( mixed $level ): int;
```
Converts the level from string/word to an integer


```php
protected function getLevels(): array;
```
Devuelve un vector de niveles de registro con conversión de entero a cadena




<h1 id="logger-adapter-abstractadapter">Abstract Class Phalcon\Logger\Adapter\AbstractAdapter</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/Adapter/AbstractAdapter.zep)

| Namespace  | Phalcon\Logger\Adapter | | Uses       | Phalcon\Logger\Exception, Phalcon\Logger\Formatter\FormatterInterface, Phalcon\Logger\Formatter\Line, Phalcon\Logger\Item | | Implements | AdapterInterface |

Class AbstractAdapter

@property string             $defaultFormatter @property FormatterInterface $formatter @property bool               $inTransaction @property array              $queue


## Propiedades
```php
/**
 * Name of the default formatter class
 *
 * @var string
 */
protected defaultFormatter = Phalcon\\Logger\Formatter\\Line;

/**
 * Formatter
 *
 * @var FormatterInterface|null
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

@throws Exception


```php
public function __serialize(): array;
```
Prevent serialization


```php
public function __unserialize( array $data ): void;
```
Prevent unserialization


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


```php
protected function getFormattedItem( Item $item ): string;
```
Returns the formatted item




<h1 id="logger-adapter-adapterinterface">Interface Phalcon\Logger\Adapter\AdapterInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/Adapter/AdapterInterface.zep)

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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/Adapter/Noop.zep)

| Namespace | Phalcon\Logger\Adapter | | Uses | Phalcon\Logger\Item | | Extends | AbstractAdapter |

Class Noop

@package Phalcon\Logger\Adapter


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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/Adapter/Stream.zep)

| Namespace  | Phalcon\Logger\Adapter | | Uses       | LogicException, Phalcon\Logger\Exception, Phalcon\Logger\Item | | Extends    | AbstractAdapter |

Phalcon\Logger\Adapter\Stream

Adaptador para almacenar registros en fichero de texto simple

```php
$logger = new \Phalcon\Logger\Adapter\Stream('app/logs/test.log');

$logger->log('This is a message');
$logger->log(\Phalcon\Logger::ERROR, 'This is an error');
$logger->error('This is another error');

$logger->close();
```

@property resource|null $handler @property string        $mode @property string        $name @property array         $options


## Propiedades
```php
/**
 * Stream handler resource
 *
 * @var resource|null
 */
protected handler;

/**
 * The file open mode. Defaults to 'ab'
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
Constructor Stream.


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


```php
protected function phpFopen( string $filename, string $mode );
```
@todo to be removed when we get traits




<h1 id="logger-adapter-syslog">Class Phalcon\Logger\Adapter\Syslog</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/Adapter/Syslog.zep)

| Namespace  | Phalcon\Logger\Adapter | | Uses       | LogicException, Phalcon\Logger\Item, Phalcon\Logger\Logger | | Extends    | AbstractAdapter |

Class Syslog

@property string $defaultFormatter @property int    $facility @property string $name @property bool   $opened @property int    $option


## Propiedades
```php
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
Syslog constructor.


```php
public function close(): bool;
```
 Cierra el registrador

```php
public function process( Item $item ): void;
```
Procesa el mensaje, es decir, lo escribe en el `syslog`


```php
protected function openlog( string $ident, int $option, int $facility ): bool;
```
Open connection to system logger

@link https://php.net/manual/en/function.openlog.php




<h1 id="logger-adapterfactory">Class Phalcon\Logger\AdapterFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/AdapterFactory.zep)

| Namespace  | Phalcon\Logger | | Uses       | Phalcon\Factory\AbstractFactory, Phalcon\Logger\Adapter\AdapterInterface, Phalcon\Logger\Exception | | Extends    | AbstractFactory |

Factory used to create adapters used for Logging


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
protected function getExceptionClass(): string;
```

```php
protected function getServices(): array;
```
Devuelve los adaptadores disponibles




<h1 id="logger-enum">Class Phalcon\Logger\Enum</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/Enum.zep)

| Namespace | Phalcon\Logger |

Log Level Enum constants


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


<h1 id="logger-exception">Class Phalcon\Logger\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/Exception.zep)

| Namespace  | Phalcon\Logger | | Extends    | \Exception |

Phalcon\Logger\Exception

Las excepciones lanzadas en Phalcon\Logger usarán esta clase



<h1 id="logger-formatter-abstractformatter">Abstract Class Phalcon\Logger\Formatter\AbstractFormatter</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/Formatter/AbstractFormatter.zep)

| Namespace  | Phalcon\Logger\Formatter | | Uses       | Phalcon\Logger\Item, Phalcon\Support\Helper\Str\AbstractStr | | Extends    | AbstractStr | | Implements | FormatterInterface |

Class AbstractFormatter

@property string $dateFormat


## Propiedades
```php
/**
 * Default date format
 *
 * @var string
 */
protected dateFormat = c;

```

## Métodos

```php
public function getDateFormat(): string
```

```php
public function setDateFormat( string $dateFormat )
```

```php
protected function getFormattedDate( Item $item ): string;
```
Devuelve la fecha formateada para el registrador.




<h1 id="logger-formatter-formatterinterface">Interface Phalcon\Logger\Formatter\FormatterInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/Formatter/FormatterInterface.zep)

| Namespace | Phalcon\Logger\Formatter | | Uses | Phalcon\Logger\Item |

Phalcon\Logger\FormatterInterface

Se debe implementar esta interfaz por los formateadores en Phalcon\Logger


## Métodos

```php
public function format( Item $item ): string;
```
Aplica un formato a un elemento




<h1 id="logger-formatter-json">Class Phalcon\Logger\Formatter\Json</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/Formatter/Json.zep)

| Namespace  | Phalcon\Logger\Formatter | | Uses       | JsonException, Phalcon\Logger\Item | | Extends    | AbstractFormatter |

Phalcon\Logger\Formatter\Json

Formatea mensajes utilizando la codificación JSON


## Métodos

```php
public function __construct( string $dateFormat = string );
```
Json constructor.


```php
public function format( Item $item ): string;
```
Aplica un formato a un mensaje antes de enviarlo al registro interno




<h1 id="logger-formatter-line">Class Phalcon\Logger\Formatter\Line</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/Formatter/Line.zep)

| Namespace  | Phalcon\Logger\Formatter | | Uses       | Exception, Phalcon\Logger\Item | | Extends    | AbstractFormatter |

Class Line

@property string $format


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
Line constructor.


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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/Item.zep)

| Namespace  | Phalcon\Logger | | Uses       | DateTimeImmutable |

Phalcon\Logger\Item

Representa cada objeto en una transacción de registro

@property array             $context @property string            $message @property int               $level @property string            $levelName @property DateTimeImmutable $datetime


## Propiedades
```php
/**
 * @var array
 */
protected context;

/**
 * @var string
 */
protected message;

/**
 * @var int
 */
protected level;

/**
 * @var string
 */
protected levelName;

/**
 * @var DateTimeImmutable
 */
protected dateTime;

```

## Métodos

```php
public function __construct( string $message, string $levelName, int $level, DateTimeImmutable $dateTime, array $context = [] );
```
Constructor Item.


```php
public function getContext(): array
```

```php
public function getDateTime(): DateTimeImmutable
```

```php
public function getLevel(): int
```

```php
public function getLevelName(): string
```

```php
public function getMessage(): string
```





<h1 id="logger-logger">Class Phalcon\Logger\Logger</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/Logger.zep)

| Namespace  | Phalcon\Logger | | Uses       | Exception, Phalcon\Logger\Exception | | Extends    | AbstractLogger | | Implements | LoggerInterface |

Phalcon Logger.

A logger, with various adapters and formatters. A formatter interface is available as well as an adapter one. Adapters can be created easily using the built-in AdapterFactory. A LoggerFactory is also available that allows developers to create new instances of the Logger or load them from config files (see Phalcon\Config\Config object).


## Métodos

```php
public function alert( string $message, array $context = [] ): void;
```
Se deben tomar medidas de inmediato.

Ejemplo: Sitio web completo, base de datos no disponible, etc. Esto debería activar las alertas de SMS y despertarte.


```php
public function critical( string $message, array $context = [] ): void;
```
Condiciones críticas.

Ejemplo: Componente de aplicación no disponible, excepción inesperada.


```php
public function debug( string $message, array $context = [] ): void;
```
Información detallada de depuración.


```php
public function emergency( string $message, array $context = [] ): void;
```
El sistema está inutilizable.


```php
public function error( string $message, array $context = [] ): void;
```
Errores en tiempo de ejecución que no requieren una acción inmediata, pero normalmente deberían ser registrados y monitoreados.


```php
public function info( string $message, array $context = [] ): void;
```
Eventos interesantes.

Ejemplo: Inicio de sesión de usuario, registros SQL.


```php
public function log( mixed $level, string $message, array $context = [] ): void;
```
Registros con un nivel arbitrario.


```php
public function notice( string $message, array $context = [] ): void;
```
Eventos normales pero significativos.


```php
public function warning( string $message, array $context = [] ): void;
```
Ocurrencias excepcionales que no son errores.

Ejemplo: Uso de APIs obsoletas, mal uso de una API, cosas indeseables que no necesariamente son erróneas.




<h1 id="logger-loggerfactory">Class Phalcon\Logger\LoggerFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/LoggerFactory.zep)

| Namespace  | Phalcon\Logger | | Uses       | DateTimeZone, Phalcon\Config\ConfigInterface, Phalcon\Factory\AbstractConfigFactory | | Extends    | AbstractConfigFactory |

Factory creating logger objects


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
public function newInstance( string $name, array $adapters = [], DateTimeZone $timezone = null ): Logger;
```
Devuelve un objeto Logger


```php
protected function getArrVal( array $collection, mixed $index, mixed $defaultValue = null ): mixed;
```
@todo Remove this when we get traits


```php
protected function getExceptionClass(): string;
```





<h1 id="logger-loggerinterface">Interface Phalcon\Logger\LoggerInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/Logger/LoggerInterface.zep)

| Namespace  | Phalcon\Logger | | Uses       | Phalcon\Logger\Adapter\AdapterInterface |

Interface for Phalcon based logger objects.


## Métodos

```php
public function alert( string $message, array $context = [] ): void;
```
Se deben tomar medidas de inmediato.

Ejemplo: Sitio web completo, base de datos no disponible, etc. Esto debería activar las alertas de SMS y despertarte.


```php
public function critical( string $message, array $context = [] ): void;
```
Condiciones críticas.

Ejemplo: Componente de aplicación no disponible, excepción inesperada.


```php
public function debug( string $message, array $context = [] ): void;
```
Información detallada de depuración.


```php
public function emergency( string $message, array $context = [] ): void;
```
El sistema está inutilizable.


```php
public function error( string $message, array $context = [] ): void;
```
Errores en tiempo de ejecución que no requieren una acción inmediata, pero normalmente deberían ser registrados y monitoreados.


```php
public function getAdapter( string $name ): AdapterInterface;
```
Devuelve un adaptador de la pila


```php
public function getAdapters(): array;
```
Devuelve el vector de la pila de adaptadores


```php
public function getLogLevel(): int;
```
Returns the log level


```php
public function getName(): string;
```
Devuelve el nombre del registrador


```php
public function info( string $message, array $context = [] ): void;
```
Eventos interesantes.

Ejemplo: Inicio de sesión de usuario, registros SQL.


```php
public function log( mixed $level, string $message, array $context = [] ): void;
```
Registros con un nivel arbitrario.


```php
public function notice( string $message, array $context = [] ): void;
```
Eventos normales pero significativos.


```php
public function warning( string $message, array $context = [] ): void;
```
Eventos normales pero significativos.


