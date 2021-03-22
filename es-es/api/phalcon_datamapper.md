---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\DataMapper'
---

* [Phalcon\DataMapper\Pdo\Connection](#datamapper-pdo-connection)
* [Phalcon\DataMapper\Pdo\Connection\AbstractConnection](#datamapper-pdo-connection-abstractconnection)
* [Phalcon\DataMapper\Pdo\Connection\ConnectionInterface](#datamapper-pdo-connection-connectioninterface)
* [Phalcon\DataMapper\Pdo\Connection\Decorated](#datamapper-pdo-connection-decorated)
* [Phalcon\DataMapper\Pdo\Connection\PdoInterface](#datamapper-pdo-connection-pdointerface)
* [Phalcon\DataMapper\Pdo\ConnectionLocator](#datamapper-pdo-connectionlocator)
* [Phalcon\DataMapper\Pdo\ConnectionLocatorInterface](#datamapper-pdo-connectionlocatorinterface)
* [Phalcon\DataMapper\Pdo\Exception\CannotDisconnect](#datamapper-pdo-exception-cannotdisconnect)
* [Phalcon\DataMapper\Pdo\Exception\ConnectionNotFound](#datamapper-pdo-exception-connectionnotfound)
* [Phalcon\DataMapper\Pdo\Exception\Exception](#datamapper-pdo-exception-exception)
* [Phalcon\DataMapper\Pdo\Profiler\MemoryLogger](#datamapper-pdo-profiler-memorylogger)
* [Phalcon\DataMapper\Pdo\Profiler\Profiler](#datamapper-pdo-profiler-profiler)
* [Phalcon\DataMapper\Pdo\Profiler\ProfilerInterface](#datamapper-pdo-profiler-profilerinterface)
* [Phalcon\DataMapper\Query\AbstractConditions](#datamapper-query-abstractconditions)
* [Phalcon\DataMapper\Query\AbstractQuery](#datamapper-query-abstractquery)
* [Phalcon\DataMapper\Query\Bind](#datamapper-query-bind)
* [Phalcon\DataMapper\Query\Delete](#datamapper-query-delete)
* [Phalcon\DataMapper\Query\Insert](#datamapper-query-insert)
* [Phalcon\DataMapper\Query\QueryFactory](#datamapper-query-queryfactory)
* [Phalcon\DataMapper\Query\Select](#datamapper-query-select)
* [Phalcon\DataMapper\Query\Update](#datamapper-query-update)


<h1 id="datamapper-pdo-connection">Class Phalcon\DataMapper\Pdo\Connection</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/DataMapper/Pdo/Connection.zep)

![](/assets/images/version-4.1.svg)

| Namespace  | Phalcon\DataMapper\Pdo | | Uses       | InvalidArgumentException, Phalcon\DataMapper\Pdo\Connection\AbstractConnection, Phalcon\DataMapper\Pdo\Profiler\Profiler, Phalcon\DataMapper\Pdo\Profiler\ProfilerInterface | | Extends    | AbstractConnection |

Proporciona citas de vector, creación de perfiles, un nuevo método `perform()`, nuevos métodos `fetch*()`

@property array             $arguments @property PDO               $pdo @property ProfilerInterface $profiler


## Propiedades
```php
/**
 * @var array
 */
protected arguments;

```

## Métodos

```php
public function __construct( string $dsn, string $username = null, string $password = null, array $options = [], array $queries = [], ProfilerInterface $profiler = null );
```
Constructor.

Esto anula al padre así pues puede tomar atributos de conexión como parámetro del constructor, y establecerlos después de la conexión.


```php
public function __debugInfo(): array;
```
El propósito de este método es ocultar datos sensibles de la pila de seguimiento.


```php
public function connect(): void;
```
Conecta a la base de datos.


```php
public function disconnect(): void;
```
Desconecta de la base de datos.




<h1 id="datamapper-pdo-connection-abstractconnection">Abstract Class Phalcon\DataMapper\Pdo\Connection\AbstractConnection</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/DataMapper/Pdo/Connection/AbstractConnection.zep)

| Namespace  | Phalcon\DataMapper\Pdo\Connection | | Uses       | BadMethodCallException, Phalcon\DataMapper\Pdo\Exception\CannotBindValue, Phalcon\DataMapper\Pdo\Profiler\ProfilerInterface | | Implements | ConnectionInterface |

Proporciona citas de vector, creación de perfiles, un nuevo método `perform()`, nuevos métodos `fetch*()`

@property PDO               $pdo @property ProfilerInterface $profiler


## Propiedades
```php
/**
 * @var PDO
 */
protected pdo;

/**
 * @var ProfilerInterface
 */
protected profiler;

```

## Métodos

```php
public function __call( mixed $name, array $arguments );
```
Proxies para métodos PDO creados para drivers específicos; en particular, `sqlite` y `pgsql`.


```php
public function beginTransaction(): bool;
```
Inicia una transacción. Si el perfilador está habilitado, se grabará la operación.


```php
public function commit(): bool;
```
Confirma la transacción existente. Si el perfilador está habilitado, se grabará la operación.


```php
abstract public function connect(): void;
```
Conecta a la base de datos.


```php
abstract public function disconnect(): void;
```
Desconecta de la base de datos.


```php
public function errorCode(): string | null;
```
Obtiene el código de error más reciente.


```php
public function errorInfo(): array;
```
Obtiene la información del error más reciente.


```php
public function exec( string $statement ): int;
```
Ejecuta una sentencia SQL y devuelve el número de filas afectadas. Si el perfilador está habilitado, se grabará la operación.


```php
public function fetchAffected( string $statement, array $values = [] ): int;
```
Ejecuta una sentencia y devuelve el número de filas afectadas.


```php
public function fetchAll( string $statement, array $values = [] ): array;
```
Obtiene un vector secuencial de filas desde la base de datos; las filas se devuelven como vectores asociativos.


```php
public function fetchAssoc( string $statement, array $values = [] ): array;
```
Obtiene un vector asociativo de filas desde la base de datos; las filas son devuelvas como vectores asociativos, y el vector de filas se mete en la primera columna de cada fila.

Si hay múltiples filas que tengan el mismo valor de primera columna, la última fila con ese valor sobreescribirá las filas anteriores. Este método es más intensivo en recursos y debería evitarse si es posible.


```php
public function fetchColumn( string $statement, array $values = [], int $column = int ): array;
```
Obtiene una columna de filas como vector secuencial (por defecto la primera).


```php
public function fetchGroup( string $statement, array $values = [], int $flags = static-constant-access ): array;
```
Obtiene múltiples desde la base de datos como vector asociativo. La primera columna será la clave del índice. Las banderas predeterminadas son PDO::FETCH_ASSOC | PDO::FETCH_GROUP


```php
public function fetchObject( string $statement, array $values = [], string $className = string, array $arguments = [] ): object;
```
Obtiene una fila de la base de datos como un objeto donde los valores de las columnas están mapeados como propiedades del objeto.

Ya que PDO inyecta los valores de las propiedades antes de invocar al constructor, cualquier inicialización de valores predeterminados que potencialmente tenga en el constructor de su objeto, anulará los valores que se hayan inyectado por `fetchObject`. El objeto predeterminado devuelto es `\stdClass`


```php
public function fetchObjects( string $statement, array $values = [], string $className = string, array $arguments = [] ): array;
```
Obtiene un vector secuencial de filas desde la base de datos, las filas son devueltas como objetos donde los valores de las columnas están mapeadas a propiedades del objeto.

Ya que PDO inyecta los valores de las propiedades antes de invocar al constructor, cualquier inicialización de valores predeterminados que potencialmente tenga en el constructor de su objeto, anulará los valores que se hayan inyectado por `fetchObject`. El objeto predeterminado devuelto es `\stdClass`


```php
public function fetchOne( string $statement, array $values = [] ): array;
```
Obtiene una fila desde la base de datos como un vector asociativo.


```php
public function fetchPairs( string $statement, array $values = [] ): array;
```
Obtiene un vector asociativo de filas como pares clave-valor (primera columna es la clave, la segunda columna es el valor).


```php
public function fetchValue( string $statement, array $values = [] );
```
Obtiene el primer valor (por ejemplo, primera columna de la primera fila).


```php
public function getAdapter(): \PDO;
```
Devuelve el PDO interno (si existe)


```php
public function getAttribute( int $attribute ): mixed;
```
Recupera un atributo de conexión de base de datos


```php
public static function getAvailableDrivers(): array;
```
Devuelve un vector de drivers PDO disponibles (vector vacío si no hay ninguno)


```php
public function getDriverName(): string;
```
Devuelve el nombre del driver


```php
public function getProfiler(): ProfilerInterface;
```
Devuelve la instancia del Perfilador.


```php
public function getQuoteNames( string $driver = string ): array;
```
Obtiene los parámetros de entrecomillado basado en el constructor


```php
public function inTransaction(): bool;
```
¿Hay activa actualmente alguna transacción? Si el perfilador está habilitado, se grabará la operación. Si el perfilador está habilitado, se grabará la operación.


```php
public function isConnected(): bool;
```
¿Está activa la conexión PDO?


```php
public function lastInsertId( string $name = null ): string;
```
Devuelve el último valor insertado de la secuencia de autoincremento. Si el perfilador está habilitado, se grabará la operación.


```php
public function perform( string $statement, array $values = [] ): \PDOStatement;
```
Ejecuta una consulta con parámetros enlazados y devuelve el PDOStatement resultante; los valores del vector serán pasados a través de `quote()` y sus respectivos marcadores de posición serán reemplazados en la cadena de consulta. Si el perfilador está habilitado, se grabará la operación.


```php
public function prepare( string $statement, array $options = [] ): \PDOStatement | bool;
```
Prepara una sentencia SQL para la ejecución.


```php
public function query( string $statement ): \PDOStatement | bool;
```
Consulta la base de datos y devuelve un PDOStatement. Si el perfilador está habilitado, se grabará la operación.


```php
public function quote( mixed $value, int $type = static-constant-access ): string;
```
Entrecomilla un valor para usarlo en una sentencia SQL. Esto difiere de `PDO::quote()` en que convertirá un vector en una cadena de valores entrecomillados separados por coma. El tipo predeterminado es `PDO::PARAM_STR`


```php
public function rollBack(): bool;
```
Deshace la transacción actual, y restaura el modo de autoconfirmación. Si el perfilador está habilitado, se grabará la operación.


```php
public function setAttribute( int $attribute, mixed $value ): bool;
```
Establece un atributo de conexión de base de datos


```php
public function setProfiler( ProfilerInterface $profiler );
```
Establece una instancia Perfilador.


```php
protected function fetchData( string $method, array $arguments, string $statement, array $values = [] ): array;
```
Método de ayuda para obtener datos de PDO basado en el método pasado


```php
protected function performBind( \PDOStatement $statement, mixed $name, mixed $arguments ): void;
```
Vincula un valor usando el tipo PDO::PARAM_* apropiado.




<h1 id="datamapper-pdo-connection-connectioninterface">Interface Phalcon\DataMapper\Pdo\Connection\ConnectionInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/DataMapper/Pdo/Connection/ConnectionInterface.zep)

| Namespace  | Phalcon\DataMapper\Pdo\Connection | | Uses       | Phalcon\DataMapper\Pdo\Exception\CannotBindValue, Phalcon\DataMapper\Pdo\Parser\ParserInterface, Phalcon\DataMapper\Pdo\Profiler\ProfilerInterface | | Extends    | PdoInterface |

Proporciona citas de vector, creación de perfiles, un nuevo método `perform()`, nuevos métodos `fetch*()`

@property array             $args @property PDO               $pdo @property ProfilerInterface $profiler @property array             $quote


## Métodos

```php
public function connect(): void;
```
Conecta a la base de datos.


```php
public function disconnect(): void;
```
Desconecta de la base de datos.


```php
public function fetchAffected( string $statement, array $values = [] ): int;
```
Ejecuta una sentencia y devuelve el número de filas afectadas.


```php
public function fetchAll( string $statement, array $values = [] ): array;
```
Obtiene un vector secuencial de filas desde la base de datos; las filas se devuelven como vectores asociativos.


```php
public function fetchAssoc( string $statement, array $values = [] ): array;
```
Obtiene un vector asociativo de filas desde la base de datos; las filas son devuelvas como vectores asociativos, y el vector de filas se mete en la primera columna de cada fila.

Si hay múltiples filas que tengan el mismo valor de primera columna, la última fila con ese valor sobreescribirá las filas anteriores. Este método es más intensivo en recursos y debería evitarse si es posible.


```php
public function fetchColumn( string $statement, array $values = [], int $column = int ): array;
```
Obtiene una columna de filas como vector secuencial (por defecto la primera).


```php
public function fetchGroup( string $statement, array $values = [], int $flags = static-constant-access ): array;
```
Obtiene múltiples desde la base de datos como vector asociativo. La primera columna será la clave del índice. Las banderas predeterminadas son PDO::FETCH_ASSOC | PDO::FETCH_GROUP


```php
public function fetchObject( string $statement, array $values = [], string $className = string, array $arguments = [] ): object;
```
Obtiene una fila de la base de datos como un objeto donde los valores de las columnas están mapeados como propiedades del objeto.

Ya que PDO inyecta los valores de las propiedades antes de invocar al constructor, cualquier inicialización de valores predeterminados que potencialmente tenga en el constructor de su objeto, anulará los valores que se hayan inyectado por `fetchObject`. El objeto predeterminado devuelto es `\stdClass`


```php
public function fetchObjects( string $statement, array $values = [], string $className = string, array $arguments = [] ): array;
```
Obtiene un vector secuencial de filas desde la base de datos, las filas son devueltas como objetos donde los valores de las columnas están mapeadas a propiedades del objeto.

Ya que PDO inyecta los valores de las propiedades antes de invocar al constructor, cualquier inicialización de valores predeterminados que potencialmente tenga en el constructor de su objeto, anulará los valores que se hayan inyectado por `fetchObject`. El objeto predeterminado devuelto es `\stdClass`


```php
public function fetchOne( string $statement, array $values = [] ): array;
```
Obtiene una fila desde la base de datos como un vector asociativo.


```php
public function fetchPairs( string $statement, array $values = [] ): array;
```
Obtiene un vector asociativo de filas como pares clave-valor (primera columna es la clave, la segunda columna es el valor).


```php
public function fetchValue( string $statement, array $values = [] ): mixed;
```
Obtiene el primer valor (por ejemplo, primera columna de la primera fila).


```php
public function getAdapter(): \PDO;
```
Devuelve el PDO interno (si existe)


```php
public function getProfiler(): ProfilerInterface;
```
Devuelve la instancia del Perfilador.


```php
public function isConnected(): bool;
```
¿Está activa la conexión PDO?


```php
public function perform( string $statement, array $values = [] ): \PDOStatement;
```
Ejecuta una consulta con parámetros enlazados y devuelve el PDOStatement resultante; los valores del vector serán pasados a través de `quote()` y sus respectivos marcadores de posición serán reemplazados en la cadena de consulta. Si el perfilador está habilitado, se grabará la operación.


```php
public function setProfiler( ProfilerInterface $profiler );
```
Establece una instancia Perfilador.




<h1 id="datamapper-pdo-connection-decorated">Class Phalcon\DataMapper\Pdo\Connection\Decorated</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/DataMapper/Pdo/Connection/Decorated.zep)

| Namespace  | Phalcon\DataMapper\Pdo\Connection | | Uses       | Phalcon\DataMapper\Pdo\Exception\CannotDisconnect, Phalcon\DataMapper\Pdo\Profiler\Profiler, Phalcon\DataMapper\Pdo\Profiler\ProfilerInterface | | Extends    | AbstractConnection |

Decora una instancia PDO existente con los métodos extendidos.


## Métodos

```php
public function __construct( \PDO $pdo, ProfilerInterface $profiler = null );
```
Constructor.

Esto anula el padre así pues puede tomar una instancia PDO existente y decorarla con los métodos extendidos.


```php
public function connect(): void;
```
Conecta a la base de datos.


```php
public function disconnect(): void;
```
Desconecta de la base de datos, no permitido con conexiones PDO decoradas.

@throws CannotDisconnect




<h1 id="datamapper-pdo-connection-pdointerface">Interface Phalcon\DataMapper\Pdo\Connection\PdoInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/DataMapper/Pdo/Connection/PdoInterface.zep)

| Namespace  | Phalcon\DataMapper\Pdo\Connection |

Un interfaz al objeto PDO nativo.


## Métodos

```php
public function beginTransaction(): bool;
```
Inicia una transacción. Si el perfilador está habilitado, se grabará la operación.


```php
public function commit(): bool;
```
Confirma la transacción existente. Si el perfilador está habilitado, se grabará la operación.


```php
public function errorCode(): null | string;
```
Obtiene el código de error más reciente.


```php
public function errorInfo(): array;
```
Obtiene la información del error más reciente.


```php
public function exec( string $statement ): int;
```
Ejecuta una sentencia SQL y devuelve el número de filas afectadas. Si el perfilador está habilitado, se grabará la operación.


```php
public function getAttribute( int $attribute ): mixed;
```
Recupera un atributo de conexión de base de datos


```php
public static function getAvailableDrivers(): array;
```
Devuelve un vector de drivers PDO disponibles (vector vacío si no hay ninguno)


```php
public function inTransaction(): bool;
```
¿Hay activa actualmente alguna transacción? Si el perfilador está habilitado, se grabará la operación. Si el perfilador está habilitado, se grabará la operación.


```php
public function lastInsertId( string $name = null ): string;
```
Devuelve el último valor insertado de la secuencia de autoincremento. Si el perfilador está habilitado, se grabará la operación.


```php
public function prepare( string $statement, array $options = [] ): \PDOStatement | bool;
```
Prepara una sentencia SQL para la ejecución.


```php
public function query( string $statement ): \PDOStatement | bool;
```
Consulta la base de datos y devuelve un PDOStatement. Si el perfilador está habilitado, se grabará la operación.


```php
public function quote( mixed $value, int $type = static-constant-access ): string;
```
Entrecomilla un valor para usarlo en una sentencia SQL. Esto difiere de `PDO::quote()` en que convertirá un vector en una cadena de valores entrecomillados separados por coma. El tipo predeterminado es `PDO::PARAM_STR`


```php
public function rollBack(): bool;
```
Deshace la transacción actual, y restaura el modo de autoconfirmación. Si el perfilador está habilitado, se grabará la operación.


```php
public function setAttribute( int $attribute, mixed $value ): bool;
```
Establece un atributo de conexión de base de datos




<h1 id="datamapper-pdo-connectionlocator">Class Phalcon\DataMapper\Pdo\ConnectionLocator</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/DataMapper/Pdo/ConnectionLocator.zep)

| Namespace  | Phalcon\DataMapper\Pdo | | Uses       | Phalcon\DataMapper\Pdo\Connection\ConnectionInterface, Phalcon\DataMapper\Pdo\Exception\ConnectionNotFound | | Implements | ConnectionLocatorInterface |

Gestiona instancias de conexión predeterminadas, de lectura y escritura.

@property callable $master @property array    $read @property array    $write


## Propiedades
```php
/**
 * A default Connection connection factory/instance.
 *
 * @var ConnectionInterface
 */
protected master;

/**
 * A registry of Connection "read" factories/instances.
 *
 * @var array
 */
protected read;

/**
 * A registry of Connection "write" factories/instances.
 *
 * @var array
 */
protected write;

/**
 * A collection of resolved instances
 *
 * @var array
 */
private instances;

```

## Métodos

```php
public function __construct( ConnectionInterface $master, array $read = [], array $write = [] );
```
Constructor.


```php
public function getMaster(): ConnectionInterface;
```
Devuelve el objeto de conexión predeterminado.


```php
public function getRead( string $name = string ): ConnectionInterface;
```
Devuelve una conexión de lectura por nombre; si no se da un nombre, se coge una conexión aleatoria; si no hay conexiones de lectura presentes, se devuelve la conexión por defecto.


```php
public function getWrite( string $name = string ): ConnectionInterface;
```
Devuelve una conexión de escritura por nombre; si no se da un nombre, se coge una conexión aleatoria; si no hay conexiones de escritura presentes, se devuelve la conexión por defecto.


```php
public function setMaster( ConnectionInterface $callableObject ): ConnectionLocatorInterface;
```
Establece la fábrica de conexión predeterminada.


```php
public function setRead( string $name, callable $callableObject ): ConnectionLocatorInterface;
```
Establece una fábrica de conexión de lectura por nombre.


```php
public function setWrite( string $name, callable $callableObject ): ConnectionLocatorInterface;
```
Establece una fábrica de conexión de escritura por nombre.


```php
protected function getConnection( string $type, string $name = string ): ConnectionInterface;
```
Devuelve una conexión por nombre.




<h1 id="datamapper-pdo-connectionlocatorinterface">Interface Phalcon\DataMapper\Pdo\ConnectionLocatorInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/DataMapper/Pdo/ConnectionLocatorInterface.zep)

| Namespace  | Phalcon\DataMapper\Pdo | | Uses       | Phalcon\DataMapper\Pdo\Connection\ConnectionInterface |

Localiza conexiones de bases de datos PDO predeterminadas, de lectura, y escritura.


## Métodos

```php
public function getMaster(): ConnectionInterface;
```
Devuelve el objeto de conexión predeterminado.


```php
public function getRead( string $name = string ): ConnectionInterface;
```
Devuelve una conexión de lectura por nombre; si no se da un nombre, se coge una conexión aleatoria; si no hay conexiones de lectura presentes, se devuelve la conexión por defecto.


```php
public function getWrite( string $name = string ): ConnectionInterface;
```
Devuelve una conexión de escritura por nombre; si no se da un nombre, se coge una conexión aleatoria; si no hay conexiones de escritura presentes, se devuelve la conexión por defecto.


```php
public function setMaster( ConnectionInterface $callableObject ): ConnectionLocatorInterface;
```
Establece la entrada de registro de conexión por defecto.


```php
public function setRead( string $name, callable $callableObject ): ConnectionLocatorInterface;
```
Establece la entrada de registro de conexión de lectura por nombre.


```php
public function setWrite( string $name, callable $callableObject ): ConnectionLocatorInterface;
```
Establece la entrada de registro de conexión de escritura por nombre.




<h1 id="datamapper-pdo-exception-cannotdisconnect">Class Phalcon\DataMapper\Pdo\Exception\CannotDisconnect</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/DataMapper/Pdo/Exception/CannotDisconnect.zep)

| Namespace  | Phalcon\DataMapper\Pdo\Exception | | Extends    | Exception |

No se puede desconectar ExtendedPdo; por ejemplo, porque su conexión PDO fue creada externamente e inyectada posteriormente.



<h1 id="datamapper-pdo-exception-connectionnotfound">Class Phalcon\DataMapper\Pdo\Exception\ConnectionNotFound</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/DataMapper/Pdo/Exception/ConnectionNotFound.zep)

| Namespace  | Phalcon\DataMapper\Pdo\Exception | | Extends    | Exception |

El localizador no puede encontrar una conexión nombrada.



<h1 id="datamapper-pdo-exception-exception">Class Phalcon\DataMapper\Pdo\Exception\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/DataMapper/Pdo/Exception/Exception.zep)

| Namespace  | Phalcon\DataMapper\Pdo\Exception | | Extends    | \Exception |

Clase de Excepción Base



<h1 id="datamapper-pdo-profiler-memorylogger">Class Phalcon\DataMapper\Pdo\Profiler\MemoryLogger</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/DataMapper/Pdo/Profiler/MemoryLogger.zep)

| Namespace  | Phalcon\DataMapper\Pdo\Profiler | | Uses       | Psr\Log\AbstractLogger | | Extends    | AbstractLogger |

Un registrador ingenuo basado en memoria.

@property array $messages


## Propiedades
```php
/**
 * @var array
 */
protected messages;

```

## Métodos

```php
public function getMessages();
```
Devuelve los mensajes registrados.


```php
public function log( mixed $level, mixed $message, array $context = [] );
```
Registra un mensaje.




<h1 id="datamapper-pdo-profiler-profiler">Class Phalcon\DataMapper\Pdo\Profiler\Profiler</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/DataMapper/Pdo/Profiler/Profiler.zep)

| Namespace  | Phalcon\DataMapper\Pdo\Profiler | | Uses       | Phalcon\DataMapper\Pdo\Exception\Exception, Phalcon\Helper\Json, Psr\Log\LoggerInterface, Psr\Log\LogLevel | | Implements | ProfilerInterface |

Envía los perfiles de consulta a un registrador.

@property bool            $active @property array           $context @property string          $logFormat @property string          $logLevel @property LoggerInterface $logger


## Propiedades
```php
/**
 * @var bool
 */
protected active = false;

/**
 * @var array
 */
protected context;

/**
 * @var string
 */
protected logFormat = ;

/**
 * @var int
 */
protected logLevel = 0;

/**
 * @var LoggerInterface
 */
protected logger;

```

## Métodos

```php
public function __construct( LoggerInterface $logger = null );
```
Constructor.


```php
public function finish( string $statement = null, array $values = [] ): void;
```
Finaliza y registra una entrada de perfil.


```php
public function getLogFormat(): string;
```
Devuelve la cadena de formato de mensaje de registro, con marcadores de posición.


```php
public function getLogLevel(): string;
```
Devuelve el nivel al que registrar mensajes de perfil.


```php
public function getLogger(): LoggerInterface;
```
Devuelve la instancia del registrador subyacente.


```php
public function isActive(): bool;
```
Devuelve `true` si el registrador está activo.


```php
public function setActive( bool $active ): ProfilerInterface;
```
Habilita o deshabilita el registro del perfilador.


```php
public function setLogFormat( string $logFormat ): ProfilerInterface;
```
Establece la cadena de formato de mensaje del registrador, con marcadores de posición.


```php
public function setLogLevel( string $logLevel ): ProfilerInterface;
```
Nivel al que registrar los mensajes del perfilador.


```php
public function start( string $method ): void;
```
Inicia una entrada de perfil.




<h1 id="datamapper-pdo-profiler-profilerinterface">Interface Phalcon\DataMapper\Pdo\Profiler\ProfilerInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/DataMapper/Pdo/Profiler/ProfilerInterface.zep)

| Namespace  | Phalcon\DataMapper\Pdo\Profiler | | Uses       | Psr\Log\LoggerInterface |

Interfaz para enviar perfiles de consultas a un registrador.


## Métodos

```php
public function finish( string $statement = null, array $values = [] ): void;
```
Finaliza y registra una entrada de perfil.


```php
public function getLogFormat(): string;
```
Devuelve la cadena de formato de mensaje de registro, con marcadores de posición.


```php
public function getLogLevel(): string;
```
Devuelve el nivel al que registrar mensajes de perfil.


```php
public function getLogger(): LoggerInterface;
```
Devuelve la instancia del registrador subyacente.


```php
public function isActive(): bool;
```
Devuelve `true` si el registrador está activo.


```php
public function setActive( bool $active ): ProfilerInterface;
```
Habilita o deshabilita el registro del perfilador.


```php
public function setLogFormat( string $logFormat ): ProfilerInterface;
```
Establece la cadena de formato de mensaje del registrador, con marcadores de posición.


```php
public function setLogLevel( string $logLevel ): ProfilerInterface;
```
Nivel al que registrar los mensajes del perfilador.


```php
public function start( string $method ): void;
```
Inicia una entrada de perfil.




<h1 id="datamapper-query-abstractconditions">Abstract Class Phalcon\DataMapper\Query\AbstractConditions</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/DataMapper/Query/AbstractConditions.zep)

| Namespace  | Phalcon\DataMapper\Query | | Uses       | Phalcon\Helper\Arr | | Extends    | AbstractQuery |

Class AbstractConditions


## Métodos

```php
public function andWhere( string $condition, mixed $value = null, int $type = int ): AbstractConditions;
```
Sets a `AND` for a `WHERE` condition


```php
public function appendWhere( string $condition, mixed $value = null, int $type = int ): AbstractConditions;
```
Concatenates to the most recent `WHERE` clause


```php
public function limit( int $limit ): AbstractConditions;
```
Sets the `LIMIT` clause


```php
public function offset( int $offset ): AbstractConditions;
```
Sets the `OFFSET` clause


```php
public function orWhere( string $condition, mixed $value = null, int $type = int ): AbstractConditions;
```
Sets a `OR` for a `WHERE` condition


```php
public function orderBy( mixed $orderBy ): AbstractConditions;
```
Sets the `ORDER BY`


```php
public function where( string $condition, mixed $value = null, int $type = int ): AbstractConditions;
```
Sets a `WHERE` condition


```php
public function whereEquals( array $columnsValues ): AbstractConditions;
```

```php
protected function addCondition( string $store, string $andor, string $condition, mixed $value = null, int $type = int ): void;
```
Appends a conditional


```php
protected function appendCondition( string $store, string $condition, mixed $value = null, int $type = int ): void;
```
Concatenates a conditional


```php
protected function buildBy( string $type ): string;
```
Builds a `BY` list


```php
protected function buildCondition( string $type ): string;
```
Builds the conditional string


```php
protected function buildLimit(): string;
```
Builds the `LIMIT` clause


```php
protected function buildLimitCommon(): string;
```
Builds the `LIMIT` clause for all drivers


```php
protected function buildLimitEarly(): string;
```
Builds the early `LIMIT` clause - MS SQLServer


```php
protected function buildLimitSqlsrv(): string;
```
Builds the `LIMIT` clause for MSSQLServer


```php
protected function processValue( string $store, mixed $data ): void;
```
Processes a value (array or string) and merges it with the store




<h1 id="datamapper-query-abstractquery">Abstract Class Phalcon\DataMapper\Query\AbstractQuery</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/DataMapper/Query/AbstractQuery.zep)

| Namespace  | Phalcon\DataMapper\Query | | Uses       | Phalcon\DataMapper\Pdo\Connection |

Class AbstractQuery

@property Bind       $bind @property Connection $connection @property array      $store


## Propiedades
```php
/**
 * @var Bind
 */
protected bind;

/**
 * @var Connection
 */
protected connection;

/**
 * @var array
 */
protected store;

```

## Métodos

```php
public function __construct( Connection $connection, Bind $bind );
```
AbstractQuery constructor.


```php
public function bindInline( mixed $value, int $type = int ): string;
```
Binds a value inline


```php
public function bindValue( string $key, mixed $value, int $type = int ): AbstractQuery;
```
Binds a value - auto-detects the type if necessary


```php
public function bindValues( array $values ): AbstractQuery;
```
Binds an array of values


```php
public function getBindValues(): array;
```
Returns all the bound values


```php
abstract public function getStatement(): string;
```
Return the generated statement


```php
public function perform();
```
Performs a statement in the connection


```php
public function quoteIdentifier( string $name, int $type = static-constant-access ): string;
```
Quotes the identifier


```php
public function reset();
```
Resets the internal array


```php
public function setFlag( string $flag, bool $enable = bool ): void;
```
Sets a flag for the query such as "DISTINCT"


```php
protected function buildFlags();
```
Builds the flags statement(s)


```php
protected function buildReturning(): string;
```
Builds the `RETURNING` clause


```php
protected function indent( array $collection, string $glue = string ): string;
```
Indents a collection




<h1 id="datamapper-query-bind">Class Phalcon\DataMapper\Query\Bind</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/DataMapper/Query/Bind.zep)

| Namespace  | Phalcon\DataMapper\Query |

Class Bind

@property int   $inlineCount @property array $store


## Propiedades
```php
/**
 * @var int
 */
protected inlineCount = 0;

/**
 * @var array
 */
protected store;

```

## Métodos

```php
public function bindInline( mixed $value, int $type = int ): string;
```

```php
public function remove( string $key ): void;
```
Removes a value from the store


```php
public function setValue( string $key, mixed $value, int $type = int ): void;
```
Sets a value


```php
public function setValues( array $values, int $type = int ): void;
```
Sets values from an array


```php
public function toArray(): array;
```
Returns the internal collection


```php
protected function getType( mixed $value ): int;
```
Auto detects the PDO type


```php
protected function inlineArray( array $data, int $type ): string;
```
Processes an array - if passed as an `inline` parameter




<h1 id="datamapper-query-delete">Class Phalcon\DataMapper\Query\Delete</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/DataMapper/Query/Delete.zep)

| Namespace  | Phalcon\DataMapper\Query | | Uses       | Phalcon\DataMapper\Pdo\Connection | | Extends    | AbstractConditions |

This file is part of the Phalcon Framework.

(c) Phalcon Team <team@phalcon.io>

For the full copyright and license information, please view the LICENSE.txt file that was distributed with this source code.

Implementation of this file has been influenced by AtlasPHP

@link    https://github.com/atlasphp/Atlas.Query @license https://github.com/atlasphp/Atlas.Qyert/blob/1.x/LICENSE.md


## Métodos

```php
public function __construct( Connection $connection, Bind $bind );
```
Delete constructor.


```php
public function from( string $table ): Delete;
```
Adds table(s) in the query


```php
public function getStatement(): string;
```

```php
public function reset(): void;
```
Resets the internal store


```php
public function returning( array $columns ): Delete;
```
Adds the `RETURNING` clause




<h1 id="datamapper-query-insert">Class Phalcon\DataMapper\Query\Insert</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/DataMapper/Query/Insert.zep)

| Namespace  | Phalcon\DataMapper\Query | | Uses       | Phalcon\DataMapper\Pdo\Connection | | Extends    | AbstractQuery |

Class Insert


## Métodos

```php
public function __construct( Connection $connection, Bind $bind );
```
Insert constructor.


```php
public function column( string $column, mixed $value = null, int $type = int ): Insert;
```
Sets a column for the `INSERT` query


```php
public function columns( array $columns ): Insert;
```
Mass sets columns and values for the `INSERT`


```php
public function getLastInsertId( string $name = null ): string;
```
Returns the id of the last inserted record


```php
public function getStatement(): string;
```

```php
public function into( string $table ): Insert;
```
Adds table(s) in the query


```php
public function reset(): void;
```
Resets the internal store


```php
public function returning( array $columns ): Insert;
```
Adds the `RETURNING` clause


```php
public function set( string $column, mixed $value = null ): Insert;
```
Sets a column = value condition




<h1 id="datamapper-query-queryfactory">Class Phalcon\DataMapper\Query\QueryFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/DataMapper/Query/QueryFactory.zep)

| Namespace  | Phalcon\DataMapper\Query | | Uses       | Phalcon\DataMapper\Pdo\Connection |

Class QueryFactory

@property string $class


## Propiedades
```php
/**
 * @var string
 */
protected selectClass = ;

```

## Métodos

```php
public function __construct( string $selectClass = string );
```
QueryFactory constructor.


```php
public function newBind(): Bind;
```
Create a new Bind object


```php
public function newDelete( Connection $connection ): Delete;
```
Create a new Delete object


```php
public function newInsert( Connection $connection ): Insert;
```
Create a new Insert object


```php
public function newSelect( Connection $connection ): Select;
```
Create a new Select object


```php
public function newUpdate( Connection $connection ): Update;
```
Create a new Update object




<h1 id="datamapper-query-select">Class Phalcon\DataMapper\Query\Select</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/DataMapper/Query/Select.zep)

| Namespace  | Phalcon\DataMapper\Query | | Uses       | BadMethodCallException, Phalcon\Helper\Arr | | Extends    | AbstractConditions |

Class Select

@property string $asAlias @property bool   $forUpdate

@method int    fetchAffected() @method array  fetchAll() @method array  fetchAssoc() @method array  fetchColumn(int $column = 0) @method array  fetchGroup(int $flags = PDO::FETCH_ASSOC) @method object fetchObject(string $class = 'stdClass', array $arguments = []) @method array  fetchObjects(string $class = 'stdClass', array $arguments = []) @method array  fetchOne() @method array  fetchPairs() @method mixed  fetchValue()


## Constantes
```php
const JOIN_INNER = INNER;
const JOIN_LEFT = LEFT;
const JOIN_NATURAL = NATURAL;
const JOIN_RIGHT = RIGHT;
```

## Propiedades
```php
/**
 * @var string
 */
protected asAlias = ;

/**
 * @var bool
 */
protected forUpdate = false;

```

## Métodos

```php
public function __call( string $method, array $params );
```
Proxied methods to the connection


```php
public function andHaving( string $condition, mixed $value = null, int $type = int ): Select;
```
Sets a `AND` for a `HAVING` condition


```php
public function appendHaving( string $condition, mixed $value = null, int $type = int ): Select;
```
Concatenates to the most recent `HAVING` clause


```php
public function appendJoin( string $condition, mixed $value = null, int $type = int ): Select;
```
Concatenates to the most recent `JOIN` clause


```php
public function asAlias( string $asAlias ): Select;
```
The `AS` statement for the query - useful in sub-queries


```php
public function columns(): Select;
```
The columns to select from. If a key is set in an array element, the key will be used as the alias


```php
public function distinct( bool $enable = bool ): Select;
```

```php
public function forUpdate( bool $enable = bool ): Select;
```
Enable the `FOR UPDATE` for the query


```php
public function from( string $table ): Select;
```
Adds table(s) in the query


```php
public function getStatement(): string;
```
Returns the compiled SQL statement


```php
public function groupBy( mixed $groupBy ): Select;
```
Sets the `GROUP BY`


```php
public function hasColumns(): bool;
```
Whether the query has columns or not


```php
public function having( string $condition, mixed $value = null, int $type = int ): Select;
```
Sets a `HAVING` condition


```php
public function join( string $join, string $table, string $condition, mixed $value = null, int $type = int ): Select;
```
Sets a 'JOIN' condition


```php
public function orHaving( string $condition, mixed $value = null, int $type = int ): Select;
```
Sets a `OR` for a `HAVING` condition


```php
public function reset(): Select;
```
Resets the internal collections


```php
public function subSelect(): Select;
```
Start a sub-select


```php
public function union(): Select;
```
Start a `UNION`


```php
public function unionAll(): Select;
```
Start a `UNION ALL`


```php
protected function getCurrentStatement( string $suffix = string ): string;
```
Statement builder




<h1 id="datamapper-query-update">Class Phalcon\DataMapper\Query\Update</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ page.version }}.0/phalcon/DataMapper/Query/Update.zep)

| Namespace  | Phalcon\DataMapper\Query | | Uses       | Phalcon\DataMapper\Pdo\Connection | | Extends    | AbstractConditions |

Class Update


## Métodos

```php
public function __construct( Connection $connection, Bind $bind );
```
Update constructor.


```php
public function column( string $column, mixed $value = null, int $type = int ): Update;
```
Sets a column for the `UPDATE` query


```php
public function columns( array $columns ): Update;
```
Mass sets columns and values for the `UPDATE`


```php
public function from( string $table ): Update;
```
Adds table(s) in the query


```php
public function getStatement(): string;
```

```php
public function hasColumns(): bool;
```
Whether the query has columns or not


```php
public function reset(): void;
```
Resets the internal store


```php
public function returning( array $columns ): Update;
```
Adds the `RETURNING` clause


```php
public function set( string $column, mixed $value = null ): Update;
```
Sets a column = value condition


