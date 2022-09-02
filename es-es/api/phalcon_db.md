---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Db'
---

* [Phalcon\Db\AbstractDb](#db-abstractdb)
* [Phalcon\Db\Adapter\AbstractAdapter](#db-adapter-abstractadapter)
* [Phalcon\Db\Adapter\AdapterInterface](#db-adapter-adapterinterface)
* [Phalcon\Db\Adapter\Pdo\AbstractPdo](#db-adapter-pdo-abstractpdo)
* [Phalcon\Db\Adapter\Pdo\Mysql](#db-adapter-pdo-mysql)
* [Phalcon\Db\Adapter\Pdo\Postgresql](#db-adapter-pdo-postgresql)
* [Phalcon\Db\Adapter\Pdo\Sqlite](#db-adapter-pdo-sqlite)
* [Phalcon\Db\Adapter\PdoFactory](#db-adapter-pdofactory)
* [Phalcon\Db\Column](#db-column)
* [Phalcon\Db\ColumnInterface](#db-columninterface)
* [Phalcon\Db\Dialect](#db-dialect)
* [Phalcon\Db\Dialect\Mysql](#db-dialect-mysql)
* [Phalcon\Db\Dialect\Postgresql](#db-dialect-postgresql)
* [Phalcon\Db\Dialect\Sqlite](#db-dialect-sqlite)
* [Phalcon\Db\DialectInterface](#db-dialectinterface)
* [Phalcon\Db\Enum](#db-enum)
* [Phalcon\Db\Exception](#db-exception)
* [Phalcon\Db\Index](#db-index)
* [Phalcon\Db\IndexInterface](#db-indexinterface)
* [Phalcon\Db\Profiler](#db-profiler)
* [Phalcon\Db\Profiler\Item](#db-profiler-item)
* [Phalcon\Db\RawValue](#db-rawvalue)
* [Phalcon\Db\Reference](#db-reference)
* [Phalcon\Db\ReferenceInterface](#db-referenceinterface)
* [Phalcon\Db\Result\Pdo](#db-result-pdo)
* [Phalcon\Db\ResultInterface](#db-resultinterface)

<h1 id="db-abstractdb">Abstract Class Phalcon\Db\AbstractDb</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Db/AbstractDb.zep)

| Namespace | Phalcon\Db | | Uses | \PDO |

Phalcon\Db y sus clases relacionadas proporcional un interfaz simple de base de datos SQL para el *Framework* Phalcon. Phalcon\Db es la clase básica que usa para conectar su aplicación PHP a un RDBMS. Hay una clase de adaptador diferente para cada marca de RDBMS.

Este componente está destinado a operaciones de base de datos de más bajo nivel. Si quiere interactuar con bases de datos usando un mayor nivel de abstracción use Phalcon\Mvc\Model.

Phalcon\Db\AbstractDb es una clase abstracta. Sólo puede usarla con un adaptador de base de datos como Phalcon\Db\Adapter\Pdo

```php
use Phalcon\Db;
use Phalcon\Db\Exception;
use Phalcon\Db\Adapter\Pdo\Mysql as MysqlConnection;

try {
    $connection = new MysqlConnection(
        [
            "host"     => "192.168.0.11",
            "username" => "sigma",
            "password" => "secret",
            "dbname"   => "blog",
            "port"     => "3306",
        ]
    );

    $result = $connection->query(
        "SELECTFROM robots LIMIT 5"
    );

    $result->setFetchMode(Enum::FETCH_NUM);

    while ($robot = $result->fetch()) {
        print_r($robot);
    }
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}
```

## Métodos

```php
public static function setup( array $options ): void;
```

Habilita/deshabilita opciones en el componente Base de Datos

<h1 id="db-adapter-abstractadapter">Abstract Class Phalcon\Db\Adapter\AbstractAdapter</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Db/Adapter/AbstractAdapter.zep)

| Namespace | Phalcon\Db\Adapter | | Uses | Phalcon\Db\DialectInterface, Phalcon\Db\ColumnInterface, Phalcon\Db\Enum, Phalcon\Db\Exception, Phalcon\Db\Index, Phalcon\Db\IndexInterface, Phalcon\Db\Reference, Phalcon\Db\ReferenceInterface, Phalcon\Db\RawValue, Phalcon\Events\EventsAwareInterface, Phalcon\Events\ManagerInterface | | Implements | AdapterInterface, EventsAwareInterface |

Clase base para adaptadores Phalcon\Db\Adapter

## Propiedades

```php
/**
 * Connection ID
 */
protected static connectionConsecutive = 0;

/**
 * Active connection ID
 *
 * @var long
 */
protected connectionId;

/**
 * Descriptor used to connect to a database
 */
protected descriptor;

/**
 * Dialect instance
 */
protected dialect;

/**
 * Name of the dialect used
 *
 * @var string
 */
protected dialectType;

/**
 * Event Manager
 *
 * @var ManagerInterface
 */
protected eventsManager;

/**
 * The real SQL statement - what was executed
 *
 * @var string
 */
protected realSqlStatement;

/**
 * Active SQL Bind Types
 *
 * @var array
 */
protected sqlBindTypes;

/**
 * Active SQL Statement
 *
 * @var string
 */
protected sqlStatement;

/**
 * Active SQL bound parameter variables
 *
 * @var array
 */
protected sqlVariables;

/**
 * Current transaction level
 */
protected transactionLevel = 0;

/**
 * Whether the database supports transactions with save points
 */
protected transactionsWithSavepoints = false;

/**
 * Type of database system the adapter is used for
 *
 * @var string
 */
protected type;

```

## Métodos

```php
public function __construct( array $descriptor );
```

Constructor Phalcon\Db\Adapter

```php
public function addColumn( string $tableName, string $schemaName, ColumnInterface $column ): bool;
```

Añade una columna a una tabla

```php
public function addForeignKey( string $tableName, string $schemaName, ReferenceInterface $reference ): bool;
```

Añade una clave ajena a una tabla

```php
public function addIndex( string $tableName, string $schemaName, IndexInterface $index ): bool;
```

Añade un índice a una tabla

```php
public function addPrimaryKey( string $tableName, string $schemaName, IndexInterface $index ): bool;
```

Añade una clave primaria a una tabla

```php
public function createSavepoint( string $name ): bool;
```

Crea un nuevo punto de guardado

```php
public function createTable( string $tableName, string $schemaName, array $definition ): bool;
```

Crea una tabla

```php
public function createView( string $viewName, array $definition, string $schemaName = null ): bool;
```

Crea una vista

```php
public function delete( mixed $table, mixed $whereCondition = null, mixed $placeholders = null, mixed $dataTypes = null ): bool;
```

Borra datos de una tabla usando sintaxis SQL del RBDM personalizada

```php
// Deleting existing robot
$success = $connection->delete(
    "robots",
    "id = 101"
);

// Next SQL sentence is generated
DELETE FROM `robots` WHERE `id` = 101
```

```php
public function describeIndexes( string $table, string $schema = null ): IndexInterface[];
```

Lista los índices de la tabla

```php
print_r(
    $connection->describeIndexes("robots_parts")
);
```

```php
public function describeReferences( string $table, string $schema = null ): ReferenceInterface[];
```

Lista las referencias de la tabla

```php
print_r(
    $connection->describeReferences("robots_parts")
);
```

```php
public function dropColumn( string $tableName, string $schemaName, string $columnName ): bool;
```

Elimina una columna de una tabla

```php
public function dropForeignKey( string $tableName, string $schemaName, string $referenceName ): bool;
```

Elimina una clave ajena de una tabla

```php
public function dropIndex( string $tableName, string $schemaName, mixed $indexName ): bool;
```

Elimina un índice de una tabla

```php
public function dropPrimaryKey( string $tableName, string $schemaName ): bool;
```

Elimina una clave primaria de una tabla

```php
public function dropTable( string $tableName, string $schemaName = null, bool $ifExists = bool ): bool;
```

Elimina una tabla de un esquema/base de datos

```php
public function dropView( string $viewName, string $schemaName = null, bool $ifExists = bool ): bool;
```

Elimina una vista

```php
public function escapeIdentifier( mixed $identifier ): string;
```

Escapa un nombre de columna/tabla/esquema

```php
$escapedTable = $connection->escapeIdentifier(
    "robots"
);

$escapedTable = $connection->escapeIdentifier(
    [
        "store",
        "robots",
    ]
);
```

```php
public function fetchAll( string $sqlQuery, int $fetchMode = static-constant-access, mixed $bindParams = null, mixed $bindTypes = null ): array;
```

Vuelca el resultado completo de una consulta en un vector

```php
// Getting all robots with associative indexes only
$robots = $connection->fetchAll(
    "SELECTFROM robots",
    \Phalcon\Db\Enum::FETCH_ASSOC
);

foreach ($robots as $robot) {
    print_r($robot);
}

 // Getting all robots that contains word "robot" withing the name
$robots = $connection->fetchAll(
    "SELECTFROM robots WHERE name LIKE :name",
    \Phalcon\Db\Enum::FETCH_ASSOC,
    [
        "name" => "%robot%",
    ]
);
foreach($robots as $robot) {
    print_r($robot);
}
```

```php
public function fetchColumn( string $sqlQuery, array $placeholders = [], mixed $column = int ): string | bool;
```

Devuelve el n-ésimo campo de la primera fila en un resultado de consulta SQL

```php
// Getting count of robots
$robotsCount = $connection->fetchColumn("SELECT count(*) FROM robots");
print_r($robotsCount);

// Getting name of last edited robot
$robot = $connection->fetchColumn(
    "SELECT id, name FROM robots ORDER BY modified DESC",
    1
);
print_r($robot);
```

```php
public function fetchOne( string $sqlQuery, mixed $fetchMode = static-constant-access, mixed $bindParams = null, mixed $bindTypes = null ): array;
```

Devuelve la primera fila en un resultado de consulta SQL

```php
// Getting first robot
$robot = $connection->fetchOne("SELECTFROM robots");
print_r($robot);

// Getting first robot with associative indexes only
$robot = $connection->fetchOne(
    "SELECTFROM robots",
    \Phalcon\Db\Enum::FETCH_ASSOC
);
print_r($robot);
```

```php
public function forUpdate( string $sqlQuery ): string;
```

Devuelve un SQL modificado con una cláusula *FOR UPDATE*

```php
public function getColumnDefinition( ColumnInterface $column ): string;
```

Devuelve la definición de columna SQL para una columna

```php
public function getColumnList( mixed $columnList ): string;
```

Obtiene una lista de columnas

```php
public function getConnectionId(): string;
```

Obtiene el identificador único de conexión activo

```php
public function getDefaultIdValue(): RawValue;
```

Devuelve el valor de la identidad predeterminado a ser insertado en una columna identidad

```php
// Inserting a new robot with a valid default value for the column 'id'
$success = $connection->insert(
    "robots",
    [
        $connection->getDefaultIdValue(),
        "Astro Boy",
        1952,
    ],
    [
        "id",
        "name",
        "year",
    ]
);
```

```php
public function getDefaultValue(): RawValue;
```

Devuelve el valor por defecto para hacer que el RBDM use el valor predeterminado declarado en la definición de la tabla

```php
// Inserting a new robot with a valid default value for the column 'year'
$success = $connection->insert(
    "robots",
    [
        "Astro Boy",
        $connection->getDefaultValue()
    ],
    [
        "name",
        "year",
    ]
);
```

@todo Devuelve NULL si no se soporta por el adaptador

```php
public function getDescriptor(): array;
```

Descriptor de retorno usado para conectar a la base de datos activa

```php
public function getDialect(): DialectInterface;
```

Devuelve la instancia interna del dialecto

```php
public function getDialectType(): string
```

```php
public function getEventsManager(): ManagerInterface;
```

Devuelve el administrador de eventos interno

```php
public function getNestedTransactionSavepointName(): string;
```

Devuelve el nombre del punto de guardado para usar en transacciones anidadas

```php
public function getRealSQLStatement(): string;
```

Sentencia SQL activa en el objeto sin reemplazar los parámetros enlazados

```php
public function getSQLBindTypes(): array;
```

Sentencia SQL activa en el objeto

```php
public function getSQLStatement(): string;
```

Sentencia SQL activa en el objeto

```php
public function getSqlVariables(): array
```

```php
public function getType(): string
```

```php
public function insert( string $table, array $values, mixed $fields = null, mixed $dataTypes = null ): bool;
```

Inserta datos en una tabla usando sintaxis SQL RDBMS personalizada

```php
// Inserting a new robot
$success = $connection->insert(
    "robots",
    ["Astro Boy", 1952],
    ["name", "year"]
);

// Next SQL sentence is sent to the database system
INSERT INTO `robots` (`name`, `year`) VALUES ("Astro boy", 1952);
```

```php
public function insertAsDict( string $table, mixed $data, mixed $dataTypes = null ): bool;
```

Inserta datos en una tabla usando sintaxis SQL RBDM personalizada

```php
// Inserting a new robot
$success = $connection->insertAsDict(
    "robots",
    [
        "name" => "Astro Boy",
        "year" => 1952,
    ]
);

// Next SQL sentence is sent to the database system
INSERT INTO `robots` (`name`, `year`) VALUES ("Astro boy", 1952);
```

```php
public function isNestedTransactionsWithSavepoints(): bool;
```

Devuelve si las transacciones anidadas deberían usar puntos de guardado

```php
public function limit( string $sqlQuery, int $number ): string;
```

Añade una cláusula *LIMIT* al argumento $sqlQuery

```php
echo $connection->limit("SELECTFROM robots", 5);
```

```php
public function listTables( string $schemaName = null ): array;
```

Lista todas las tablas de una base de datos

```php
print_r(
    $connection->listTables("blog")
);
```

```php
public function listViews( string $schemaName = null ): array;
```

Lista todas las vistas de una base de datos

```php
print_r(
    $connection->listViews("blog")
);
```

```php
public function modifyColumn( string $tableName, string $schemaName, ColumnInterface $column, ColumnInterface $currentColumn = null ): bool;
```

Modifica una columna de la base de datos basándose en una definición

```php
public function releaseSavepoint( string $name ): bool;
```

Lanza los puntos de guardado dados

```php
public function rollbackSavepoint( string $name ): bool;
```

Deshace los puntos de guardado dados

```php
public function setDialect( DialectInterface $dialect );
```

Establece el dialecto usado para producir el SQL

```php
public function setEventsManager( ManagerInterface $eventsManager ): void;
```

Establece el gestor de eventos

```php
public function setNestedTransactionsWithSavepoints( bool $nestedTransactionsWithSavepoints ): AdapterInterface;
```

Establece si las transacciones anidadas deberían usar puntos de guardado

```php
public function sharedLock( string $sqlQuery ): string;
```

Devuelve un SQL modificado con una cláusula *LOCK IN SHARE MODE*

```php
public function supportSequences(): bool;
```

Comprueba si el sistema de base de datos necesita una secuencia para producir valores autonuméricos

```php
public function supportsDefaultValue(): bool;
```

Comprueba si el sistema de base de datos soporta la palabra clave *DEFAULT* (SQLite no la soporta)

@deprecated Será eliminado en la siguiente versión

```php
public function tableExists( string $tableName, string $schemaName = null ): bool;
```

Genera SQL comprobando la existencia de un esquema.tabla

```php
var_dump(
    $connection->tableExists("blog", "posts")
);
```

```php
public function tableOptions( string $tableName, string $schemaName = null ): array;
```

Obtiene las opciones de creación de una tabla

```php
print_r(
    $connection->tableOptions("robots")
);
```

```php
public function update( string $table, mixed $fields, mixed $values, mixed $whereCondition = null, mixed $dataTypes = null ): bool;
```

Actualiza datos en una tabla usando sintaxis SQL RBDM personalizada

```php
// Updating existing robot
$success = $connection->update(
    "robots",
    ["name"],
    ["New Astro Boy"],
    "id = 101"
);

// Next SQL sentence is sent to the database system
UPDATE `robots` SET `name` = "Astro boy" WHERE id = 101

// Updating existing robot with array condition and $dataTypes
$success = $connection->update(
    "robots",
    ["name"],
    ["New Astro Boy"],
    [
        "conditions" => "id = ?",
        "bind"       => [$some_unsafe_id],
        "bindTypes"  => [PDO::PARAM_INT], // use only if you use $dataTypes param
    ],
    [
        PDO::PARAM_STR
    ]
);

```

¡Atención! Si $whereCondition es cadena sin escapar.

```php
public function updateAsDict( string $table, mixed $data, mixed $whereCondition = null, mixed $dataTypes = null ): bool;
```

Actualiza datos en una tabla usando sintaxis SQL RBDM personalizada. Otra sintaxis más conveniente

```php
// Updating existing robot
$success = $connection->updateAsDict(
    "robots",
    [
        "name" => "New Astro Boy",
    ],
    "id = 101"
);

// Next SQL sentence is sent to the database system
UPDATE `robots` SET `name` = "Astro boy" WHERE id = 101
```

```php
public function useExplicitIdValue(): bool;
```

Comprueba si el sistema de base de datos necesita un valor explícito para columnas identidad

```php
public function viewExists( string $viewName, string $schemaName = null ): bool;
```

Genera SQL comprobando la existencia de un esquema.vista

```php
var_dump(
    $connection->viewExists("active_users", "posts")
);
```

<h1 id="db-adapter-adapterinterface">Interface Phalcon\Db\Adapter\AdapterInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Db/Adapter/AdapterInterface.zep)

| Namespace | Phalcon\Db\Adapter | | Uses | Phalcon\Db\DialectInterface, Phalcon\Db\ResultInterface, Phalcon\Db\ColumnInterface, Phalcon\Db\IndexInterface, Phalcon\Db\RawValue, Phalcon\Db\ReferenceInterface |

Interfaz para adaptadores Phalcon\Db

## Métodos

```php
public function addColumn( string $tableName, string $schemaName, ColumnInterface $column ): bool;
```

Añade una columna a una tabla

```php
public function addForeignKey( string $tableName, string $schemaName, ReferenceInterface $reference ): bool;
```

Añade una clave ajena a una tabla

```php
public function addIndex( string $tableName, string $schemaName, IndexInterface $index ): bool;
```

Añade un índice a una tabla

```php
public function addPrimaryKey( string $tableName, string $schemaName, IndexInterface $index ): bool;
```

Añade una clave primaria a una tabla

```php
public function affectedRows(): int;
```

Devuelve el número de filas afectadas por el último INSERT/UPDATE/DELETE informado por el sistema de base de datos

```php
public function begin( bool $nesting = bool ): bool;
```

Inicia una transacción en la conexión

```php
public function close(): bool;
```

Cierra la conexión activa devolviendo éxito. Phalcon automáticamente cierra y destruye las conexiones activas dentro de Phalcon\Db\Pool

```php
public function commit( bool $nesting = bool ): bool;
```

Confirma la transacción activa en la conexión

```php
public function connect( array $descriptor = null ): bool;
```

Este método se llama automáticamente en el constructor \Phalcon\Db\Adapter\Pdo. Llámelo cuando necesite restaurar una conexión de base de datos

```php
public function createSavepoint( string $name ): bool;
```

Crea un nuevo punto de guardado

```php
public function createTable( string $tableName, string $schemaName, array $definition ): bool;
```

Crea una tabla

```php
public function createView( string $viewName, array $definition, string $schemaName = null ): bool;
```

Crea una vista

```php
public function delete( mixed $table, mixed $whereCondition = null, mixed $placeholders = null, mixed $dataTypes = null ): bool;
```

Borra datos de una tabla usando sintaxis SQL RDBMS personalizada

```php
public function describeColumns( string $table, string $schema = null ): ColumnInterface[];
```

Devuelve un vector de objetos Phalcon\Db\Column que describen una tabla

```php
public function describeIndexes( string $table, string $schema = null ): IndexInterface[];
```

Lista los índices de la tabla

```php
public function describeReferences( string $table, string $schema = null ): ReferenceInterface[];
```

Lista las referencias de la tabla

```php
public function dropColumn( string $tableName, string $schemaName, string $columnName ): bool;
```

Elimina una columna de una tabla

```php
public function dropForeignKey( string $tableName, string $schemaName, string $referenceName ): bool;
```

Elimina una clave ajena de una tabla

```php
public function dropIndex( string $tableName, string $schemaName, string $indexName ): bool;
```

Elimina un índice de una tabla

```php
public function dropPrimaryKey( string $tableName, string $schemaName ): bool;
```

Elimina una clave primaria de una tabla

```php
public function dropTable( string $tableName, string $schemaName = null, bool $ifExists = bool ): bool;
```

Elimina una tabla de un esquema/base de datos

```php
public function dropView( string $viewName, string $schemaName = null, bool $ifExists = bool ): bool;
```

Elimina una vista

```php
public function escapeIdentifier( mixed $identifier ): string;
```

Escapa un nombre de columna/tabla/esquema

```php
public function escapeString( string $str ): string;
```

Escapa un valor para evitar inyecciones SQL

```php
public function execute( string $sqlStatement, mixed $placeholders = null, mixed $dataTypes = null ): bool;
```

Envía sentencias SQL al servidor de base de datos devolviendo el estado de éxito. Use este método sólo cuando las sentencias SQL enviadas al servidor no devuelvan ninguna fila

```php
public function fetchAll( string $sqlQuery, int $fetchMode = int, mixed $placeholders = null ): array;
```

Vuelca el resultado completo de una consulta en un vector

```php
public function fetchColumn( string $sqlQuery, array $placeholders = [], mixed $column = int ): string | bool;
```

Devuelve el n-ésimo campo de la primera fila en un resultado de consulta SQL

```php
// Getting count of robots
$robotsCount = $connection->fetchColumn("SELECT COUNT(*) FROM robots");
print_r($robotsCount);

// Getting name of last edited robot
$robot = $connection->fetchColumn(
    "SELECT id, name FROM robots ORDER BY modified DESC",
    1
);
print_r($robot);
```

```php
public function fetchOne( string $sqlQuery, int $fetchMode = int, mixed $placeholders = null ): array;
```

Devuelve la primera fila en un resultado de consulta SQL

```php
public function forUpdate( string $sqlQuery ): string;
```

Devuelve un SQL modificado con una cláusula *FOR UPDATE*

```php
public function getColumnDefinition( ColumnInterface $column ): string;
```

Devuelve la definición de columna SQL para una columna

```php
public function getColumnList( mixed $columnList ): string;
```

Obtiene una lista de columnas

```php
public function getConnectionId(): string;
```

Obtiene el identificador único de conexión activo

```php
public function getDefaultIdValue(): RawValue;
```

Devuelve el valor de identidad predeterminado para insertar en una columna identidad

```php
public function getDefaultValue(): RawValue;
```

Devuelve el valor por defecto para hacer que el RBDM use el valor predeterminado declarado en la definición de la tabla

```php
// Inserting a new robot with a valid default value for the column 'year'
$success = $connection->insert(
    "robots",
    [
        "Astro Boy",
        $connection->getDefaultValue()
    ],
    [
        "name",
        "year",
    ]
);
```

@todo Devuelve NULL si no se soporta por el adaptador

```php
public function getDescriptor(): array;
```

Descriptor de retorno usado para conectar a la base de datos activa

```php
public function getDialect(): DialectInterface;
```

Devuelve la instancia interna del dialecto

```php
public function getDialectType(): string;
```

Devuelve el nombre del dialecto usado

```php
public function getInternalHandler(): \PDO;
```

Devuelve el manejador PDO interno

```php
public function getNestedTransactionSavepointName(): string;
```

Devuelve el nombre del punto de guardado a usar en transacciones anidadas

```php
public function getRealSQLStatement(): string;
```

Sentencia SQL activa en el objeto sin reemplazar parámetros enlazados

```php
public function getSQLBindTypes(): array;
```

Sentencia SQL activa en el objeto

```php
public function getSQLStatement(): string;
```

Sentencia SQL activa en el objeto

```php
public function getSQLVariables(): array;
```

Sentencia SQL activa en el objeto

```php
public function getType(): string;
```

Devuelve el tipo de sistema de base de datos para el que se usa el adaptador

```php
public function insert( string $table, array $values, mixed $fields = null, mixed $dataTypes = null ): bool;
```

Inserta datos en la tabla usando sintaxis SQL RDBMS personalizada

```php
public function insertAsDict( string $table, mixed $data, mixed $dataTypes = null ): bool;
```

Inserta datos en una tabla usando sintaxis SQL RBDM personalizada

```php
// Inserting a new robot
$success = $connection->insertAsDict(
    "robots",
    [
        "name" => "Astro Boy",
        "year" => 1952,
    ]
);

// Next SQL sentence is sent to the database system
INSERT INTO `robots` (`name`, `year`) VALUES ("Astro boy", 1952);
```

```php
public function isNestedTransactionsWithSavepoints(): bool;
```

Returns if nested transactions should use savepoints

```php
public function isUnderTransaction(): bool;
```

Comprueba si la conexión está bajo una transacción de base de datos

```php
public function lastInsertId( mixed $sequenceName = null );
```

Devuelve el id de inserción para una columna auto_increment insertada en la última sentencia SQL

```php
public function limit( string $sqlQuery, int $number ): string;
```

Añade una cláusula *LIMIT* al argumento sqlQuery

```php
public function listTables( string $schemaName = null ): array;
```

Lista todas las tablas de una base de datos

```php
public function listViews( string $schemaName = null ): array;
```

Lista todas las vistas de una base de datos

```php
public function modifyColumn( string $tableName, string $schemaName, ColumnInterface $column, ColumnInterface $currentColumn = null ): bool;
```

Modifica una columna de la tabla basada en una definición

```php
public function query( string $sqlStatement, mixed $placeholders = null, mixed $dataTypes = null ): ResultInterface | bool;
```

Envía sentencias SQL al servidor de base de datos devolviendo el estado de éxito. Use este método sólo cuando las sentencias SQL enviadas al servidor devuelvan filas

```php
public function releaseSavepoint( string $name ): bool;
```

Lanza un punto de guardado dado

```php
public function rollback( bool $nesting = bool ): bool;
```

Deshace la transacción activa en la conexión

```php
public function rollbackSavepoint( string $name ): bool;
```

Deshace el punto de guardado dado

```php
public function setNestedTransactionsWithSavepoints( bool $nestedTransactionsWithSavepoints ): AdapterInterface;
```

Establece si las transacciones anidadas deberían usar puntos de guardado

```php
public function sharedLock( string $sqlQuery ): string;
```

Devuelve un SQL modificado con la cláusula *LOCK IN SHARE MODE*

```php
public function supportSequences(): bool;
```

Comprueba si el sistema de base de datos necesita una secuencia para producir valores autonuméricos

```php
public function supportsDefaultValue(): bool;
```

SQLite no soporta la palabra clave *DEFAULT*

@deprecated Será eliminado en la siguiente versión

```php
public function tableExists( string $tableName, string $schemaName = null ): bool;
```

Genera SQL comprobando la existencia de un esquema.tabla

```php
public function tableOptions( string $tableName, string $schemaName = null ): array;
```

Obtiene la opciones de creación de una tabla

```php
public function update( string $table, mixed $fields, mixed $values, mixed $whereCondition = null, mixed $dataTypes = null ): bool;
```

Actualiza datos en una tabla usando sintaxis SQL RDBMS personalizada

```php
public function updateAsDict( string $table, mixed $data, mixed $whereCondition = null, mixed $dataTypes = null ): bool;
```

Actualiza datos en una tabla usando sintaxis SQL RBDM personalizada. Otra sintaxis más conveniente

```php
// Updating existing robot
$success = $connection->updateAsDict(
    "robots",
    [
        "name" => "New Astro Boy",
    ],
    "id = 101"
);

// Next SQL sentence is sent to the database system
UPDATE `robots` SET `name` = "Astro boy" WHERE id = 101
```

```php
public function useExplicitIdValue(): bool;
```

Comprueba si el sistema de base de datos necesita un valor explícito para columnas identidad

```php
public function viewExists( string $viewName, string $schemaName = null ): bool;
```

Genera SQL comprobando la existencia de un esquema.vista

<h1 id="db-adapter-pdo-abstractpdo">Abstract Class Phalcon\Db\Adapter\Pdo\AbstractPdo</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Db/Adapter/Pdo/AbstractPdo.zep)

| Namespace | Phalcon\Db\Adapter\Pdo | | Uses | Phalcon\Db\Adapter\AbstractAdapter, Phalcon\Db\Column, Phalcon\Db\Exception, Phalcon\Db\Result\Pdo, Phalcon\Db\ResultInterface, Phalcon\Events\ManagerInterface | | Extends | AbstractAdapter |

Phalcon\Db\Adapter\Pdo es el Phalcon\Db que internamente usa PDO para conectar a la base de datos

```php
use Phalcon\Db\Adapter\Pdo\Mysql;

$config = [
    "host"     => "localhost",
    "dbname"   => "blog",
    "port"     => 3306,
    "username" => "sigma",
    "password" => "secret",
];

$connection = new Mysql($config);
```

## Propiedades

```php
/**
 * Last affected rows
 */
protected affectedRows;

/**
 * PDO Handler
 *
 * @var \PDO
 */
protected pdo;

```

## Métodos

```php
public function __construct( array $descriptor );
```

Constructor de Phalcon\Db\Adapter\Pdo

```php
public function affectedRows(): int;
```

Devuelve el número de filas afectadas por el último INSERT/UPDATE/DELETE ejecutado en el sistema de base de datos

```php
$connection->execute(
    "DELETE FROM robots"
);

echo $connection->affectedRows(), " were deleted";
```

```php
public function begin( bool $nesting = bool ): bool;
```

Inicia una transacción en la conexión

```php
public function close(): bool;
```

Cierra la conexión activa devolviendo éxito. Phalcon automáticamente cierra y destruye las conexiones activas cuando la petición termina

```php
public function commit( bool $nesting = bool ): bool;
```

Confirma la transacción activa en la conexión

```php
public function connect( array $descriptor = null ): bool;
```

Este método se llama automáticamente en el constructor \Phalcon\Db\Adapter\Pdo.

Llámelo cuando necesite restaurar una conexión de base de datos.

```php
use Phalcon\Db\Adapter\Pdo\Mysql;

// Make a connection
$connection = new Mysql(
    [
        "host"     => "localhost",
        "username" => "sigma",
        "password" => "secret",
        "dbname"   => "blog",
        "port"     => 3306,
    ]
);

// Reconnect
$connection->connect();
```

```php
public function convertBoundParams( string $sql, array $params = [] ): array;
```

Convierte parámetros enlazados como :name: o ?1 en parámetros enlace PDO ?

```php
print_r(
    $connection->convertBoundParams(
        "SELECTFROM robots WHERE name = :name:",
        [
            "Bender",
        ]
    )
);
```

```php
public function escapeString( string $str ): string;
```

Escapa un valor para evitar inyecciones SQL de acuerdo al conjunto de caracteres activo en la conexión

```php
$escapedStr = $connection->escapeString("some dangerous value");
```

```php
public function execute( string $sqlStatement, mixed $bindParams = null, mixed $bindTypes = null ): bool;
```

Envía sentencias SQL al servidor de base de datos devolviendo el estado de éxito. Use este método sólo cuando las sentencias SQL enviadas al servidor no devuelvan ninguna fila

```php
// Inserting data
$success = $connection->execute(
    "INSERT INTO robots VALUES (1, 'Astro Boy')"
);

$success = $connection->execute(
    "INSERT INTO robots VALUES (?, ?)",
    [
        1,
        "Astro Boy",
    ]
);
```

```php
public function executePrepared( \PDOStatement $statement, array $placeholders, mixed $dataTypes ): \PDOStatement;
```

Ejecuta un enlazado de sentencia preparada. Esta función usa índices enteros empezando por cero

```php
use Phalcon\Db\Column;

$statement = $db->prepare(
    "SELECTFROM robots WHERE name = :name"
);

$result = $connection->executePrepared(
    $statement,
    [
        "name" => "Voltron",
    ],
    [
        "name" => Column::BIND_PARAM_STR,
    ]
);
```

```php
public function getErrorInfo();
```

Devuelve la información del error, si lo hay

```php
public function getInternalHandler(): \PDO;
```

Devuelve el manejador de PDO interno

```php
public function getTransactionLevel(): int;
```

Devuelve el nivel de anidación de transacción actual

```php
public function isUnderTransaction(): bool;
```

Comprueba si la conexión está bajo una transacción

```php
$connection->begin();

// true
var_dump(
    $connection->isUnderTransaction()
);
```

```php
public function lastInsertId( mixed $sequenceName = null ): int | bool;
```

Devuelve el ID de la inserción para una columna auto_increment/serial insertada en la última sentencia SQL ejecutada

```php
// Inserting a new robot
$success = $connection->insert(
    "robots",
    [
        "Astro Boy",
        1952,
    ],
    [
        "name",
        "year",
    ]
);

// Getting the generated id
$id = $connection->lastInsertId();
```

```php
public function prepare( string $sqlStatement ): \PDOStatement;
```

Devuelve la sentencia preparada PDO que se ejecutará con 'executePrepared'

```php
use Phalcon\Db\Column;

$statement = $db->prepare(
    "SELECTFROM robots WHERE name = :name"
);

$result = $connection->executePrepared(
    $statement,
    [
        "name" => "Voltron",
    ],
    [
        "name" => Column::BIND_PARAM_INT,
    ]
);
```

```php
public function query( string $sqlStatement, mixed $bindParams = null, mixed $bindTypes = null ): ResultInterface | bool;
```

Envía sentencias SQL al servidor de base de datos devolviendo el estado de éxito. Use este método sólo cuando la sentencia SQL enviada al servidor devuelve filas

```php
// Querying data
$resultset = $connection->query(
    "SELECTFROM robots WHERE type = 'mechanical'"
);

$resultset = $connection->query(
    "SELECTFROM robots WHERE type = ?",
    [
        "mechanical",
    ]
);
```

```php
public function rollback( bool $nesting = bool ): bool;
```

Deshace la transacción activa en la conexión

```php
abstract protected function getDsnDefaults(): array;
```

Devuelve el DSN predeterminado del adaptador PDO como mapa clave-valor.

```php
protected function prepareRealSql( string $statement, array $parameters ): void;
```

Construye la sentencia SQL (con parámetros)

@see https://stackoverflow.com/a/8403150

<h1 id="db-adapter-pdo-mysql">Class Phalcon\Db\Adapter\Pdo\Mysql</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Db/Adapter/Pdo/Mysql.zep)

| Namespace | Phalcon\Db\Adapter\Pdo | | Uses | Phalcon\Db\Adapter\Pdo\AbstractPdo, Phalcon\Db\Column, Phalcon\Db\ColumnInterface, Phalcon\Db\Enum, Phalcon\Db\Exception, Phalcon\Db\Index, Phalcon\Db\IndexInterface, Phalcon\Db\Reference, Phalcon\Db\ReferenceInterface | | Extends | PdoAdapter |

Funciones específicas para el sistema de base de datos MySQL

```php
use Phalcon\Db\Adapter\Pdo\Mysql;

$config = [
    "host"     => "localhost",
    "dbname"   => "blog",
    "port"     => 3306,
    "username" => "sigma",
    "password" => "secret",
];

$connection = new Mysql($config);
```

## Propiedades

```php
/**
 * @var string
 */
protected dialectType = mysql;

/**
 * @var string
 */
protected type = mysql;

```

## Métodos

```php
public function addForeignKey( string $tableName, string $schemaName, ReferenceInterface $reference ): bool;
```

Añade una clave ajena a una tabla

```php
public function describeColumns( string $table, string $schema = null ): ColumnInterface[];
```

Devuelve un vector de objetos Phalcon\Db\Column que describen una tabla

```php
print_r(
    $connection->describeColumns("posts")
);
```

```php
public function describeIndexes( string $table, string $schema = null ): IndexInterface[];
```

Lista los índices de la tabla

```php
print_r(
    $connection->describeIndexes("robots_parts")
);
```

```php
public function describeReferences( string $table, string $schema = null ): ReferenceInterface[];
```

Lista las referencias de la tabla

```php
print_r(
    $connection->describeReferences("robots_parts")
);
```

```php
protected function getDsnDefaults(): array;
```

Devuelve el DSN predeterminado del adaptador PDO como mapa clave-valor.

<h1 id="db-adapter-pdo-postgresql">Class Phalcon\Db\Adapter\Pdo\Postgresql</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Db/Adapter/Pdo/Postgresql.zep)

| Namespace | Phalcon\Db\Adapter\Pdo | | Uses | Phalcon\Db\Adapter\Pdo\AbstractPdo, Phalcon\Db\Column, Phalcon\Db\ColumnInterface, Phalcon\Db\Enum, Phalcon\Db\Exception, Phalcon\Db\RawValue, Phalcon\Db\Reference, Phalcon\Db\ReferenceInterface, Throwable | | Extends | PdoAdapter |

Funciones específicas para el sistema de base de datos PostgreSQL

```php
use Phalcon\Db\Adapter\Pdo\Postgresql;

$config = [
    "host"     => "localhost",
    "dbname"   => "blog",
    "port"     => 5432,
    "username" => "postgres",
    "password" => "secret",
];

$connection = new Postgresql($config);
```

## Propiedades

```php
/**
 * @var string
 */
protected dialectType = postgresql;

/**
 * @var string
 */
protected type = pgsql;

```

## Métodos

```php
public function __construct( array $descriptor );
```

Constructor para Phalcon\Db\Adapter\Pdo\Postgresql

```php
public function connect( array $descriptor = null ): bool;
```

A este método se llama automáticamente en el constructor Phalcon\Db\Adapter\Pdo. Llámelo cuando necesite restaurar una conexión de base de datos.

```php
public function createTable( string $tableName, string $schemaName, array $definition ): bool;
```

Crea una tabla

```php
public function describeColumns( string $table, string $schema = null ): ColumnInterface[];
```

Devuelve un vector de objetos Phalcon\Db\Column que describen una tabla

```php
print_r(
    $connection->describeColumns("posts")
);
```

```php
public function describeReferences( string $table, string $schema = null ): ReferenceInterface[];
```

Lista las referencias de la tabla

```php
print_r(
    $connection->describeReferences("robots_parts")
);
```

```php
public function getDefaultIdValue(): RawValue;
```

Devuelve el valor de la identidad predeterminado a ser insertado en una columna identidad

```php
// Inserting a new robot with a valid default value for the column 'id'
$success = $connection->insert(
    "robots",
    [
        $connection->getDefaultIdValue(),
        "Astro Boy",
        1952,
    ],
    [
        "id",
        "name",
        "year",
    ]
);
```

```php
public function modifyColumn( string $tableName, string $schemaName, ColumnInterface $column, ColumnInterface $currentColumn = null ): bool;
```

Modifica una columna de una tabla basada en una definición

```php
public function supportSequences(): bool;
```

Comprueba si el sistema de base de datos necesita una secuencia para producir valores autonuméricos

```php
public function useExplicitIdValue(): bool;
```

Comprueba si el sistema de base de datos necesita un valor explícito para columnas identidad

```php
protected function getDsnDefaults(): array;
```

Devuelve el DSN predeterminado del adaptador PDO como mapa clave-valor.

<h1 id="db-adapter-pdo-sqlite">Class Phalcon\Db\Adapter\Pdo\Sqlite</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Db/Adapter/Pdo/Sqlite.zep)

| Namespace | Phalcon\Db\Adapter\Pdo | | Uses | Phalcon\Db\Adapter\Pdo\AbstractPdo, Phalcon\Db\Column, Phalcon\Db\ColumnInterface, Phalcon\Db\Enum, Phalcon\Db\Exception, Phalcon\Db\Index, Phalcon\Db\IndexInterface, Phalcon\Db\RawValue, Phalcon\Db\Reference, Phalcon\Db\ReferenceInterface | | Extends | PdoAdapter |

Funciones específicas para el sistema de base de datos SQLite

```php
use Phalcon\Db\Adapter\Pdo\Sqlite;

$connection = new Sqlite(
    [
        "dbname" => "/tmp/test.sqlite",
    ]
);
```

## Propiedades

```php
/**
 * @var string
 */
protected dialectType = sqlite;

/**
 * @var string
 */
protected type = sqlite;

```

## Métodos

```php
public function __construct( array $descriptor );
```

Constructor para Phalcon\Db\Adapter\Pdo\Sqlite

```php
public function connect( array $descriptor = null ): bool;
```

A este método se llama automáticamente en el constructor Phalcon\Db\Adapter\Pdo. Llámelo cuando necesite restaurar una conexión de base de datos.

```php
public function describeColumns( string $table, string $schema = null ): ColumnInterface[];
```

Devuelve un vector de objetos Phalcon\Db\Column que describen una tabla

```php
print_r(
    $connection->describeColumns("posts")
);
```

```php
public function describeIndexes( string $table, string $schema = null ): IndexInterface[];
```

Lista los índices de la tabla

```php
print_r(
    $connection->describeIndexes("robots_parts")
);
```

```php
public function describeReferences( string $table, string $schema = null ): ReferenceInterface[];
```

Lista las referencias de la tabla

```php
public function getDefaultValue(): RawValue;
```

Devuelve el valor por defecto para hacer que el RBDM use el valor predeterminado declarado en la definición de la tabla

```php
// Inserting a new robot with a valid default value for the column 'year'
$success = $connection->insert(
    "robots",
    [
        "Astro Boy",
        $connection->getDefaultValue(),
    ],
    [
        "name",
        "year",
    ]
);
```

```php
public function supportsDefaultValue(): bool;
```

SQLite no soporta la palabra clave *DEFAULT*

@deprecated Será eliminado en la siguiente versión

```php
public function useExplicitIdValue(): bool;
```

Comprueba si el sistema de base de datos necesita un valor explícito para columnas identidad

```php
protected function getDsnDefaults(): array;
```

Devuelve el DSN predeterminado del adaptador PDO como mapa clave-valor.

<h1 id="db-adapter-pdofactory">Class Phalcon\Db\Adapter\PdoFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Db/Adapter/PdoFactory.zep)

| Namespace | Phalcon\Db\Adapter | | Uses | Phalcon\Factory\AbstractFactory, Phalcon\Helper\Arr | | Extends | AbstractFactory |

Este fichero es parte del *Framework* Phalcon.

(c) Phalcon Team <team@phalcon.io>

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.

## Métodos

```php
public function __construct( array $services = [] );
```

Constructor

```php
public function load( mixed $config ): AdapterInterface;
```

Fábrica para crear una instancia desde un objeto Config

```php
public function newInstance( string $name, array $options = [] ): AdapterInterface;
```

Crea una nueva instancia del adaptador

```php
protected function getAdapters(): array;
```

Devuelve los adaptadores disponibles

<h1 id="db-column">Class Phalcon\Db\Column</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Db/Column.zep)

| Namespace | Phalcon\Db | | Implements | ColumnInterface |

Permite definir columnas que se usarán en operaciones para crear o alterar una tabla

```php
use Phalcon\Db\Column as Column;

// Column definition
$column = new Column(
    "id",
    [
        "type"          => Column::TYPE_INTEGER,
        "size"          => 10,
        "unsigned"      => true,
        "notNull"       => true,
        "autoIncrement" => true,
        "first"         => true,
        "comment"       => "",
    ]
);

// Add column to existing table
$connection->addColumn("robots", null, $column);
```

## Constantes

```php
const BIND_PARAM_BLOB = 3;
const BIND_PARAM_BOOL = 5;
const BIND_PARAM_DECIMAL = 32;
const BIND_PARAM_INT = 1;
const BIND_PARAM_NULL = 0;
const BIND_PARAM_STR = 2;
const BIND_SKIP = 1024;
const TYPE_BIGINTEGER = 14;
const TYPE_BIT = 19;
const TYPE_BLOB = 11;
const TYPE_BOOLEAN = 8;
const TYPE_CHAR = 5;
const TYPE_DATE = 1;
const TYPE_DATETIME = 4;
const TYPE_DECIMAL = 3;
const TYPE_DOUBLE = 9;
const TYPE_ENUM = 18;
const TYPE_FLOAT = 7;
const TYPE_INTEGER = 0;
const TYPE_JSON = 15;
const TYPE_JSONB = 16;
const TYPE_LONGBLOB = 13;
const TYPE_LONGTEXT = 24;
const TYPE_MEDIUMBLOB = 12;
const TYPE_MEDIUMINTEGER = 21;
const TYPE_MEDIUMTEXT = 23;
const TYPE_SMALLINTEGER = 22;
const TYPE_TEXT = 6;
const TYPE_TIME = 20;
const TYPE_TIMESTAMP = 17;
const TYPE_TINYBLOB = 10;
const TYPE_TINYINTEGER = 26;
const TYPE_TINYTEXT = 25;
const TYPE_VARCHAR = 2;
```

## Propiedades

```php
/**
 * Column Position
 *
 * @var string|null
 */
protected after;

/**
 * Column is autoIncrement?
 *
 * @var bool
 */
protected autoIncrement = false;

/**
 * Bind Type
 */
protected bindType = 2;

/**
 * Default column value
 */
protected _default;

/**
 * Position is first
 *
 * @var bool
 */
protected first = false;

/**
 * The column have some numeric type?
 */
protected isNumeric = false;

/**
 * Column's name
 *
 * @var string
 */
protected name;

/**
 * Column's comment
 *
 * @var string
 */
protected comment;

/**
 * Column not nullable?
 *
 * Default SQL definition is NOT NULL.
 *
 * @var bool
 */
protected notNull = true;

/**
 * Column is part of the primary key?
 */
protected primary = false;

/**
 * Integer column number scale
 *
 * @var int
 */
protected scale = 0;

/**
 * Integer column size
 *
 * @var int | string
 */
protected size = 0;

/**
 * Column data type
 *
 * @var int
 */
protected type;

/**
 * Column data type reference
 *
 * @var int
 */
protected typeReference = -1;

/**
 * Column data type values
 *
 * @var array|string
 */
protected typeValues;

/**
 * Integer column unsigned?
 *
 * @var bool
 */
protected unsigned = false;

```

## Métodos

```php
public function __construct( string $name, array $definition );
```

Constructor Phalcon\Db\Column

```php
public function getAfterPosition(): string | null;
```

Comprueba si el campo es absoluto para la posición en la tabla

```php
public function getBindType(): int;
```

Devuelve el tipo de manejador de enlaces

```php
public function getComment(): string
```

```php
public function getName(): string
```

```php
public function getScale(): int
```

```php
public function getSize(): int | string
```

```php
public function getType(): int
```

```php
public function getTypeReference(): int
```

```php
public function getTypeValues(): array|string
```

```php
public function get_default()
```

```php
public function hasDefault(): bool;
```

Comprueba si una columna tiene valor predeterminado

```php
public function isAutoIncrement(): bool;
```

Auto-Increment

```php
public function isFirst(): bool;
```

Comprueba si una columna tiene la primera posición en la tabla

```php
public function isNotNull(): bool;
```

Not null

```php
public function isNumeric(): bool;
```

Comprueba si una columna tiene un tipo numérico

```php
public function isPrimary(): bool;
```

¿La columna es parte de la clave primaria?

```php
public function isUnsigned(): bool;
```

Devuelve *true* si la columna numérica es sin signo

<h1 id="db-columninterface">Interface Phalcon\Db\ColumnInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Db/ColumnInterface.zep)

| Namespace | Phalcon\Db |

Interfaz para Phalcon\Db\Column

## Métodos

```php
public function getAfterPosition(): string | null;
```

Comprueba si el campo es absoluto para la posición en la tabla

```php
public function getBindType(): int;
```

Devuelve el tipo de manejador de enlaces

```php
public function getDefault(): mixed;
```

Devuelve el valor predeterminado de una columna

```php
public function getName(): string;
```

Devuelve el nombre de la columna

```php
public function getScale(): int;
```

Devuelve la escala de la columna

```php
public function getSize(): int | string;
```

Devuelve el tamaño de la columna

```php
public function getType(): int;
```

Devuelve el tipo de la columna

```php
public function getTypeReference(): int;
```

Devuelve la referencia del tipo de columna

```php
public function getTypeValues(): array | string;
```

Devuelve los valores del tipo de columna

```php
public function hasDefault(): bool;
```

Comprueba si una columna tiene valor predeterminado

```php
public function isAutoIncrement(): bool;
```

Auto-Increment

```php
public function isFirst(): bool;
```

Comprueba si una columna tiene la primera posición en la tabla

```php
public function isNotNull(): bool;
```

Not null

```php
public function isNumeric(): bool;
```

Comprueba si una columna tiene un tipo numérico

```php
public function isPrimary(): bool;
```

¿La columna es parte de la clave primaria?

```php
public function isUnsigned(): bool;
```

Devuelve *true* si la columna numérica es sin signo

<h1 id="db-dialect">Abstract Class Phalcon\Db\Dialect</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Db/Dialect.zep)

| Namespace | Phalcon\Db | | Implements | DialectInterface |

Esta es la clase base para cada dialecto de base de datos. Implementa métodos comunes para transformar código intermedio en su sintaxis relacionada RDBMS

## Propiedades

```php
//
protected escapeChar;

//
protected customFunctions;

```

## Métodos

```php
public function createSavepoint( string $name ): string;
```

Genera el SQL para crear un nuevo punto de guardado

```php
final public function escape( string $str, string $escapeChar = null ): string;
```

Escapa identificadores

```php
final public function escapeSchema( string $str, string $escapeChar = null ): string;
```

Escapa el Esquema

```php
public function forUpdate( string $sqlQuery ): string;
```

Devuelve un SQL modificado con una cláusula *FOR UPDATE*

```php
$sql = $dialect->forUpdate("SELECTFROM robots");

echo $sql; // SELECTFROM robots FOR UPDATE
```

```php
final public function getColumnList( array $columnList, string $escapeChar = null, mixed $bindCounts = null ): string;
```

Devuelve una lista de columnas con los identificadores escapados

```php
echo $dialect->getColumnList(
    [
        "column1",
        "column",
    ]
);
```

```php
public function getCustomFunctions(): array;
```

Devuelve las funciones registradas

```php
final public function getSqlColumn( mixed $column, string $escapeChar = null, mixed $bindCounts = null ): string;
```

Resuelve expresiones de Columna

```php
public function getSqlExpression( array $expression, string $escapeChar = null, mixed $bindCounts = null ): string;
```

Transforma una representación intermedia de una expresión en una expresión válida para el sistema de base de datos

```php
final public function getSqlTable( mixed $table, string $escapeChar = null ): string;
```

Transforma una representación intermedia de un esquema/tabla en una expresión válida del sistema de base de datos

```php
public function limit( string $sqlQuery, mixed $number ): string;
```

Genera el SQL para la cláusula LIMIT

```php
// SELECTFROM robots LIMIT 10
echo $dialect->limit(
    "SELECTFROM robots",
    10
);

// SELECTFROM robots LIMIT 10 OFFSET 50
echo $dialect->limit(
    "SELECTFROM robots",
    [10, 50]
);
```

```php
public function registerCustomFunction( string $name, callable $customFunction ): Dialect;
```

Registra funciones SQL personalizadas

```php
public function releaseSavepoint( string $name ): string;
```

Genera el SQL para lanzar un punto de guardado

```php
public function rollbackSavepoint( string $name ): string;
```

Genera el SQL para deshacer un punto de guardado

```php
public function select( array $definition ): string;
```

Construye una sentencia SELECT

```php
public function supportsReleaseSavepoints(): bool;
```

Comprueba si la plataforma soporta el lanzamiento de puntos de guardado.

```php
public function supportsSavepoints(): bool;
```

Comprueba si la plataforma soporta puntos de guardado

```php
protected function checkColumnType( ColumnInterface $column ): string;
```

Comprueba el tipo de columna y si no es cadena devuelve la referencia del tipo

```php
protected function checkColumnTypeSql( ColumnInterface $column ): string;
```

Comprueba el tipo de columna y devuelve la sentencia SQL actualizada

```php
protected function getColumnSize( ColumnInterface $column ): string;
```

Devuelve el tamaño de la columna encerrado entre paréntesis

```php
protected function getColumnSizeAndScale( ColumnInterface $column ): string;
```

Devuelve el tamaño y escala de la columna encerrados entre paréntesis

```php
final protected function getSqlExpressionAll( array $expression, string $escapeChar = null ): string;
```

Resuelve

```php
final protected function getSqlExpressionBinaryOperations( array $expression, string $escapeChar = null, mixed $bindCounts = null ): string;
```

Resuelve expresiones de operaciones binarias

```php
final protected function getSqlExpressionCase( array $expression, string $escapeChar = null, mixed $bindCounts = null ): string;
```

Resuelve expresiones CASE

```php
final protected function getSqlExpressionCastValue( array $expression, string $escapeChar = null, mixed $bindCounts = null ): string;
```

Resuelve CAST de valores

```php
final protected function getSqlExpressionConvertValue( array $expression, string $escapeChar = null, mixed $bindCounts = null ): string;
```

Resuelve CONVERT de codificación de valores

```php
final protected function getSqlExpressionFrom( mixed $expression, string $escapeChar = null ): string;
```

Resuelve una cláusula FROM

```php
final protected function getSqlExpressionFunctionCall( array $expression, string $escapeChar = null, mixed $bindCounts ): string;
```

Resuelve llamadas a funciones

```php
final protected function getSqlExpressionGroupBy( mixed $expression, string $escapeChar = null, mixed $bindCounts = null ): string;
```

Resuelve una cláusula GROUP BY

```php
final protected function getSqlExpressionHaving( array $expression, string $escapeChar = null, mixed $bindCounts = null ): string;
```

Resuelve una cláusula HAVING

```php
final protected function getSqlExpressionJoins( mixed $expression, string $escapeChar = null, mixed $bindCounts = null ): string;
```

Resuelve una cláusula JOIN

```php
final protected function getSqlExpressionLimit( mixed $expression, string $escapeChar = null, mixed $bindCounts = null ): string;
```

Resuelve una cláusula LIMIT

```php
final protected function getSqlExpressionList( array $expression, string $escapeChar = null, mixed $bindCounts = null ): string;
```

Resuelve Listas

```php
final protected function getSqlExpressionObject( array $expression, string $escapeChar = null, mixed $bindCounts = null ): string;
```

Resuelve expresiones de objeto

```php
final protected function getSqlExpressionOrderBy( mixed $expression, string $escapeChar = null, mixed $bindCounts = null ): string;
```

Resuelve una cláusula ORDER BY

```php
final protected function getSqlExpressionQualified( array $expression, string $escapeChar = null ): string;
```

Resuelve expresiones cualitativas

```php
final protected function getSqlExpressionScalar( array $expression, string $escapeChar = null, mixed $bindCounts = null ): string;
```

Resuelve expresiones de Columna

```php
final protected function getSqlExpressionUnaryOperations( array $expression, string $escapeChar = null, mixed $bindCounts = null ): string;
```

Resuelve expresiones de operaciones unitarias

```php
final protected function getSqlExpressionWhere( mixed $expression, string $escapeChar = null, mixed $bindCounts = null ): string;
```

Resuelve una cláusula WHERE

```php
protected function prepareColumnAlias( string $qualified, string $alias = null, string $escapeChar = null ): string;
```

Prepara la columna para este RDBMS

```php
protected function prepareQualified( string $column, string $domain = null, string $escapeChar = null ): string;
```

Prepara el calificado para este RDBMS

```php
protected function prepareTable( string $table, string $schema = null, string $alias = null, string $escapeChar = null ): string;
```

Prepara tabla para este RDBMS

<h1 id="db-dialect-mysql">Class Phalcon\Db\Dialect\Mysql</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Db/Dialect/Mysql.zep)

| Namespace | Phalcon\Db\Dialect | | Uses | Phalcon\Db\Dialect, Phalcon\Db\Column, Phalcon\Db\Exception, Phalcon\Db\IndexInterface, Phalcon\Db\ColumnInterface, Phalcon\Db\ReferenceInterface, Phalcon\Db\DialectInterface | | Extends | Dialect |

Genera SQL específico de base de datos para el RDBMS MySQL

## Propiedades

```php
/**
 * @var string
 */
protected escapeChar = `;

```

## Métodos

```php
public function addColumn( string $tableName, string $schemaName, ColumnInterface $column ): string;
```

Genera SQL para añadir una columna a una tabla

```php
public function addForeignKey( string $tableName, string $schemaName, ReferenceInterface $reference ): string;
```

Genera SQL para añadir un índice a una tabla

```php
public function addIndex( string $tableName, string $schemaName, IndexInterface $index ): string;
```

Genera SQL para añadir un índice a una tabla

```php
public function addPrimaryKey( string $tableName, string $schemaName, IndexInterface $index ): string;
```

Genera SQL para añadir la clave primaria a una tabla

```php
public function createTable( string $tableName, string $schemaName, array $definition ): string;
```

Genera SQL para crear una tabla

```php
public function createView( string $viewName, array $definition, string $schemaName = null ): string;
```

Genera SQL para crear una vista

```php
public function describeColumns( string $table, string $schema = null ): string;
```

Genera SQL que describe una tabla

```php
print_r(
    $dialect->describeColumns("posts")
);
```

```php
public function describeIndexes( string $table, string $schema = null ): string;
```

Genera SQL para consultar índices de una tabla

```php
public function describeReferences( string $table, string $schema = null ): string;
```

Genera SQL para consultar claves ajenas de una tabla

```php
public function dropColumn( string $tableName, string $schemaName, string $columnName ): string;
```

Genera SQL para eliminar una columna de una tabla

```php
public function dropForeignKey( string $tableName, string $schemaName, string $referenceName ): string;
```

Genera SQL para eliminar una clave ajena de una tabla

```php
public function dropIndex( string $tableName, string $schemaName, string $indexName ): string;
```

Genera SQL para eliminar un índice de una tabla

```php
public function dropPrimaryKey( string $tableName, string $schemaName ): string;
```

Genera SQL para eliminar la clave primaria de una tabla

```php
public function dropTable( string $tableName, string $schemaName = null, bool $ifExists = bool ): string;
```

Genera SQL para eliminar una tabla

```php
public function dropView( string $viewName, string $schemaName = null, bool $ifExists = bool ): string;
```

Genera SQL para eliminar una vista

```php
public function getColumnDefinition( ColumnInterface $column ): string;
```

Obtiene el nombre de columna en MySQL

```php
public function getForeignKeyChecks(): string;
```

Genera SQL para comprobar el parámetro de base de datos FOREIGN_KEY_CHECKS.

```php
public function listTables( string $schemaName = null ): string;
```

Lista todas las tablas de la base de datos

```php
print_r(
    $dialect->listTables("blog")
);
```

```php
public function listViews( string $schemaName = null ): string;
```

Genera el SQL para listar todas las vistas de un esquema o usuario

```php
public function modifyColumn( string $tableName, string $schemaName, ColumnInterface $column, ColumnInterface $currentColumn = null ): string;
```

Genera SQL para modificar una columna de una tabla

```php
public function sharedLock( string $sqlQuery ): string;
```

Devuelve un SQL modificado con la cláusula LOCK IN SHARE MODE

```php
$sql = $dialect->sharedLock("SELECTFROM robots");

echo $sql; // SELECTFROM robots LOCK IN SHARE MODE
```

```php
public function tableExists( string $tableName, string $schemaName = null ): string;
```

Genera SQL que comprueba la existencia de un esquema.tabla

```php
echo $dialect->tableExists("posts", "blog");

echo $dialect->tableExists("posts");
```

```php
public function tableOptions( string $table, string $schema = null ): string;
```

Genera el SQL que describe las opciones de creación de una tabla

```php
public function truncateTable( string $tableName, string $schemaName ): string;
```

Genera SQL para truncar una tabla

```php
public function viewExists( string $viewName, string $schemaName = null ): string;
```

Genera SQL comprobando la existencia de un esquema.vista

```php
protected function getTableOptions( array $definition ): string;
```

Genera SQL para añadir las opciones de creación de una tabla

<h1 id="db-dialect-postgresql">Class Phalcon\Db\Dialect\Postgresql</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Db/Dialect/Postgresql.zep)

| Namespace | Phalcon\Db\Dialect | | Uses | Phalcon\Db\Dialect, Phalcon\Db\Column, Phalcon\Db\Exception, Phalcon\Db\IndexInterface, Phalcon\Db\ColumnInterface, Phalcon\Db\ReferenceInterface, Phalcon\Db\DialectInterface | | Extends | Dialect |

Genera SQL específico de la base de datos para el RDBMS PostgreSQL

## Propiedades

```php
/**
 * @var string
 */
protected escapeChar = \";

```

## Métodos

```php
public function addColumn( string $tableName, string $schemaName, ColumnInterface $column ): string;
```

Genera SQL para añadir una columna a una tabla

```php
public function addForeignKey( string $tableName, string $schemaName, ReferenceInterface $reference ): string;
```

Genera SQL para añadir un índice a una tabla

```php
public function addIndex( string $tableName, string $schemaName, IndexInterface $index ): string;
```

Genera SQL para añadir un índice a una tabla

```php
public function addPrimaryKey( string $tableName, string $schemaName, IndexInterface $index ): string;
```

Genera SQL para añadir la clave primaria a una tabla

```php
public function createTable( string $tableName, string $schemaName, array $definition ): string;
```

Genera SQL para crear una tabla

```php
public function createView( string $viewName, array $definition, string $schemaName = null ): string;
```

Genera SQL para crear una vista

```php
public function describeColumns( string $table, string $schema = null ): string;
```

Genera SQL que describe una tabla

```php
print_r(
    $dialect->describeColumns("posts")
);
```

```php
public function describeIndexes( string $table, string $schema = null ): string;
```

Genera SQL para consultar índices de una tabla

```php
public function describeReferences( string $table, string $schema = null ): string;
```

Genera SQL para consultar claves ajenas de una tabla

```php
public function dropColumn( string $tableName, string $schemaName, string $columnName ): string;
```

Genera SQL para eliminar una columna de una tabla

```php
public function dropForeignKey( string $tableName, string $schemaName, string $referenceName ): string;
```

Genera SQL para eliminar una clave ajena de una tabla

```php
public function dropIndex( string $tableName, string $schemaName, string $indexName ): string;
```

Genera SQL para eliminar un índice de una tabla

```php
public function dropPrimaryKey( string $tableName, string $schemaName ): string;
```

Genera SQL para eliminar la clave primaria de una tabla

```php
public function dropTable( string $tableName, string $schemaName = null, bool $ifExists = bool ): string;
```

Genera SQL para eliminar una tabla

```php
public function dropView( string $viewName, string $schemaName = null, bool $ifExists = bool ): string;
```

Genera SQL para eliminar una vista

```php
public function getColumnDefinition( ColumnInterface $column ): string;
```

Obtiene el nombre de columna en PostgreSQL

```php
public function listTables( string $schemaName = null ): string;
```

Lista todas las tablas de la base de datos

```php
print_r(
    $dialect->listTables("blog")
);
```

```php
public function listViews( string $schemaName = null ): string;
```

Genera el SQL para listar todas las vistas de un esquema o usuario

```php
public function modifyColumn( string $tableName, string $schemaName, ColumnInterface $column, ColumnInterface $currentColumn = null ): string;
```

Genera SQL para modificar una columna de una tabla

```php
public function sharedLock( string $sqlQuery ): string;
```

Devuelve un SQL modificado con una sentencia de bloque compartido. Por ahora este método devuelve la consulta original

```php
public function tableExists( string $tableName, string $schemaName = null ): string;
```

Genera SQL que comprueba la existencia de esquema.tabla

```php
echo $dialect->tableExists("posts", "blog");

echo $dialect->tableExists("posts");
```

```php
public function tableOptions( string $table, string $schema = null ): string;
```

Genera el SQL que describe las opciones de creación de una tabla

```php
public function truncateTable( string $tableName, string $schemaName ): string;
```

Genera SQL para truncar una tabla

```php
public function viewExists( string $viewName, string $schemaName = null ): string;
```

Genera SQL comprobando la existencia de un esquema.vista

```php
protected function castDefault( ColumnInterface $column ): string;
```

```php
protected function getTableOptions( array $definition ): string;
```

<h1 id="db-dialect-sqlite">Class Phalcon\Db\Dialect\Sqlite</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Db/Dialect/Sqlite.zep)

| Namespace | Phalcon\Db\Dialect | | Uses | Phalcon\Db\Column, Phalcon\Db\Exception, Phalcon\Db\IndexInterface, Phalcon\Db\Dialect, Phalcon\Db\DialectInterface, Phalcon\Db\ColumnInterface, Phalcon\Db\ReferenceInterface | | Extends | Dialect |

Genera SQL específico de la base de datos para el RDBMS SQLite

## Propiedades

```php
/**
 * @var string
 */
protected escapeChar = \";

```

## Métodos

```php
public function addColumn( string $tableName, string $schemaName, ColumnInterface $column ): string;
```

Genera SQL para añadir una columna a una tabla

```php
public function addForeignKey( string $tableName, string $schemaName, ReferenceInterface $reference ): string;
```

Genera SQL para añadir un índice a una tabla

```php
public function addIndex( string $tableName, string $schemaName, IndexInterface $index ): string;
```

Genera SQL para añadir un índice a una tabla

```php
public function addPrimaryKey( string $tableName, string $schemaName, IndexInterface $index ): string;
```

Genera SQL para añadir la clave primaria a una tabla

```php
public function createTable( string $tableName, string $schemaName, array $definition ): string;
```

Genera SQL para crear una tabla

```php
public function createView( string $viewName, array $definition, string $schemaName = null ): string;
```

Genera SQL para crear una vista

```php
public function describeColumns( string $table, string $schema = null ): string;
```

Genera SQL que describe una tabla

```php
print_r(
    $dialect->describeColumns("posts")
);
```

```php
public function describeIndex( string $index ): string;
```

Genera SQL para consultar el detalle de los índices en una tabla

```php
public function describeIndexes( string $table, string $schema = null ): string;
```

Genera SQL para consultar índices de una tabla

```php
public function describeReferences( string $table, string $schema = null ): string;
```

Genera SQL para consultar claves ajenas de una tabla

```php
public function dropColumn( string $tableName, string $schemaName, string $columnName ): string;
```

Genera SQL para eliminar una columna de una tabla

```php
public function dropForeignKey( string $tableName, string $schemaName, string $referenceName ): string;
```

Genera SQL para eliminar una clave ajena de una tabla

```php
public function dropIndex( string $tableName, string $schemaName, string $indexName ): string;
```

Genera SQL para eliminar un índice de una tabla

```php
public function dropPrimaryKey( string $tableName, string $schemaName ): string;
```

Genera SQL para eliminar la clave primaria de una tabla

```php
public function dropTable( string $tableName, string $schemaName = null, bool $ifExists = bool ): string;
```

Genera SQL para eliminar una tabla

```php
public function dropView( string $viewName, string $schemaName = null, bool $ifExists = bool ): string;
```

Genera SQL para eliminar una vista

```php
public function forUpdate( string $sqlQuery ): string;
```

Devuelve un SQL modificado con una cláusula FOR UPDATE. Para SQLite devuelve la consulta original

```php
public function getColumnDefinition( ColumnInterface $column ): string;
```

Devuelve el nombre de columna en SQLite

```php
public function listIndexesSql( string $table, string $schema = null, string $keyName = null ): string;
```

Genera el SQL para obtener la consulta de la lista de índices

```php
print_r(
    $dialect->listIndexesSql("blog")
);
```

```php
public function listTables( string $schemaName = null ): string;
```

Lista todas las tablas de la base de datos

```php
print_r(
    $dialect->listTables("blog")
);
```

```php
public function listViews( string $schemaName = null ): string;
```

Genera el SQL para listar todas las vistas de un esquema o usuario

```php
public function modifyColumn( string $tableName, string $schemaName, ColumnInterface $column, ColumnInterface $currentColumn = null ): string;
```

Genera SQL para modificar una columna de una tabla

```php
public function sharedLock( string $sqlQuery ): string;
```

Devuelve un SQL modificado con una sentencia de bloque compartido. Por ahora este método devuelve la consulta original

```php
public function tableExists( string $tableName, string $schemaName = null ): string;
```

Genera SQL que comprueba la existencia de un esquema.tabla

```php
echo $dialect->tableExists("posts", "blog");

echo $dialect->tableExists("posts");
```

```php
public function tableOptions( string $table, string $schema = null ): string;
```

Genera el SQL que describe las opciones de creación de una tabla

```php
public function truncateTable( string $tableName, string $schemaName ): string;
```

Genera SQL para truncar una tabla

```php
public function viewExists( string $viewName, string $schemaName = null ): string;
```

Genera SQL comprobando la existencia de un esquema.vista

<h1 id="db-dialectinterface">Interface Phalcon\Db\DialectInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Db/DialectInterface.zep)

| Namespace | Phalcon\Db |

Interfaz para dialectos Phalcon\Db

## Métodos

```php
public function addColumn( string $tableName, string $schemaName, ColumnInterface $column ): string;
```

Genera SQL para añadir una columna a una tabla

```php
public function addForeignKey( string $tableName, string $schemaName, ReferenceInterface $reference ): string;
```

Genera SQL para añadir un índice a una tabla

```php
public function addIndex( string $tableName, string $schemaName, IndexInterface $index ): string;
```

Genera SQL para añadir un índice a una tabla

```php
public function addPrimaryKey( string $tableName, string $schemaName, IndexInterface $index ): string;
```

Genera SQL para añadir la clave primaria a una tabla

```php
public function createSavepoint( string $name ): string;
```

Genera el SQL para crear un nuevo punto de guardado

```php
public function createTable( string $tableName, string $schemaName, array $definition ): string;
```

Genera SQL para crear una tabla

```php
public function createView( string $viewName, array $definition, string $schemaName = null ): string;
```

Genera SQL para crear una vista

```php
public function describeColumns( string $table, string $schema = null ): string;
```

Genera SQL para describir una tabla

```php
public function describeIndexes( string $table, string $schema = null ): string;
```

Genera SQL para consultar índices de una tabla

```php
public function describeReferences( string $table, string $schema = null ): string;
```

Genera SQL para consultar claves ajenas de una tabla

```php
public function dropColumn( string $tableName, string $schemaName, string $columnName ): string;
```

Genera SQL para eliminar una columna de una tabla

```php
public function dropForeignKey( string $tableName, string $schemaName, string $referenceName ): string;
```

Genera SQL para eliminar una clave ajena de una tabla

```php
public function dropIndex( string $tableName, string $schemaName, string $indexName ): string;
```

Genera SQL para eliminar un índice de una tabla

```php
public function dropPrimaryKey( string $tableName, string $schemaName ): string;
```

Genera SQL para eliminar la clave primaria de una tabla

```php
public function dropTable( string $tableName, string $schemaName ): string;
```

Genera SQL para eliminar una tabla

```php
public function dropView( string $viewName, string $schemaName = null, bool $ifExists = bool ): string;
```

Genera SQL para eliminar una vista

```php
public function forUpdate( string $sqlQuery ): string;
```

Devuelve un SQL modificado con una cláusula *FOR UPDATE*

```php
public function getColumnDefinition( ColumnInterface $column ): string;
```

Obtiene el nombre de columna en el RDBMS

```php
public function getColumnList( array $columnList ): string;
```

Obtiene una lista de columnas

```php
public function getCustomFunctions(): array;
```

Devuelve las funciones registradas

```php
public function getSqlExpression( array $expression, string $escapeChar = null, mixed $bindCounts = null ): string;
```

Transforma una representación intermedia para una expresión en una expresión válida para el sistema de base de datos

```php
public function limit( string $sqlQuery, mixed $number ): string;
```

Genera el SQL para la cláusula LIMIT

```php
public function listTables( string $schemaName = null ): string;
```

Lista todas las tablas de la base de datos

```php
public function modifyColumn( string $tableName, string $schemaName, ColumnInterface $column, ColumnInterface $currentColumn = null ): string;
```

Genera SQL para modificar una columna de una tabla

```php
public function registerCustomFunction( string $name, callable $customFunction ): Dialect;
```

Registra funciones SQL personalizadas

```php
public function releaseSavepoint( string $name ): string;
```

Genera el SQL para lanzar un punto de guardado

```php
public function rollbackSavepoint( string $name ): string;
```

Genera el SQL para deshacer un punto de guardado

```php
public function select( array $definition ): string;
```

Construye una sentencia SELECT

```php
public function sharedLock( string $sqlQuery ): string;
```

Devuelve un SQL modificado con la cláusula LOCK IN SHARE MODE

```php
public function supportsReleaseSavepoints(): bool;
```

Comprueba si la plataforma soporta el lanzamiento de puntos de guardado.

```php
public function supportsSavepoints(): bool;
```

Comprueba si la plataforma soporta puntos de guardado

```php
public function tableExists( string $tableName, string $schemaName = null ): string;
```

Genera SQL que comprueba la existencia de esquema.tabla

```php
public function tableOptions( string $table, string $schema = null ): string;
```

Genera el SQL que describe las opciones de creación de una tabla

```php
public function viewExists( string $viewName, string $schemaName = null ): string;
```

Genera SQL comprobando la existencia de un esquema.vista

<h1 id="db-enum">Class Phalcon\Db\Enum</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Db/Enum.zep)

| Namespace | Phalcon\Db |

Constantes para Phalcon\Db

## Constantes

```php
const FETCH_ASSOC;
const FETCH_BOTH;
const FETCH_BOUND;
const FETCH_CLASS;
const FETCH_CLASSTYPE;
const FETCH_COLUMN;
const FETCH_FUNC;
const FETCH_GROUP;
const FETCH_INTO;
const FETCH_KEY_PAIR;
const FETCH_LAZY;
const FETCH_NAMED;
const FETCH_NUM;
const FETCH_OBJ;
const FETCH_PROPS_LATE;
const FETCH_SERIALIZE;
const FETCH_UNIQUE;
```

<h1 id="db-exception">Class Phalcon\Db\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Db/Exception.zep)

| Namespace | Phalcon\Db | | Extends | \Phalcon\Exception |

Las excepciones lanzadas en Phalcon\Db usarán esta clase

<h1 id="db-index">Class Phalcon\Db\Index</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Db/Index.zep)

| Namespace | Phalcon\Db | | Implements | IndexInterface |

Permite definir índices a usar en las tablas. Los índices son una manera común de mejorar el rendimiento de una base de datos. Un índice permite al servidor de base de datos encontrar y obtener filas específicas mucho más rápido que si lo tuviese que hacer sin ningún índice

```php
// Define new unique index
$index_unique = new \Phalcon\Db\Index(
    'column_UNIQUE',
    [
        'column',
        'column',
    ],
    'UNIQUE'
);

// Define new primary index
$index_primary = new \Phalcon\Db\Index(
    'PRIMARY',
    [
        'column',
    ]
);

// Add index to existing table
$connection->addIndex("robots", null, $index_unique);
$connection->addIndex("robots", null, $index_primary);
```

## Propiedades

```php
/**
 * Index columns
 *
 * @var array
 */
protected columns;

/**
 * Index name
 *
 * @var string
 */
protected name;

/**
 * Index type
 *
 * @var string
 */
protected type;

```

## Métodos

```php
public function __construct( string $name, array $columns, string $type = string );
```

Constructor Phalcon\Db\Index

```php
public function getColumns(): array
```

```php
public function getName(): string
```

```php
public function getType(): string
```

<h1 id="db-indexinterface">Interface Phalcon\Db\IndexInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Db/IndexInterface.zep)

| Namespace | Phalcon\Db |

Interfaz para Phalcon\Db\Index

## Métodos

```php
public function getColumns(): array;
```

Obtiene las columnas que corresponden al índice

```php
public function getName(): string;
```

Obtiene el nombre del índice

```php
public function getType(): string;
```

Obtiene el tipo de índice

<h1 id="db-profiler">Class Phalcon\Db\Profiler</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Db/Profiler.zep)

| Namespace | Phalcon\Db | | Uses | Phalcon\Db\Profiler\Item |

Las instancias de Phalcon\Db pueden generar perfiles de ejecución en sentencias SQL enviadas a la base de datos relacional. La información perfilada incluye el tiempo de ejecución en milisegundos. Esto le ayuda a identificar cuellos de botella en sus aplicaciones.

```php
use Phalcon\Db\Profiler;
use Phalcon\Events\Event;
use Phalcon\Events\Manager;

$profiler = new Profiler();
$eventsManager = new Manager();

$eventsManager->attach(
    "db",
    function (Event $event, $connection) use ($profiler) {
        if ($event->getType() === "beforeQuery") {
            $sql = $connection->getSQLStatement();

            // Start a profile with the active connection
            $profiler->startProfile($sql);
        }

        if ($event->getType() === "afterQuery") {
            // Stop the active profile
            $profiler->stopProfile();
        }
    }
);

// Set the event manager on the connection
$connection->setEventsManager($eventsManager);


$sql = "SELECT buyer_name, quantity, product_name
FROM buyers LEFT JOIN products ON
buyers.pid=products.id";

// Execute a SQL statement
$connection->query($sql);

// Get the last profile in the profiler
$profile = $profiler->getLastProfile();

echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
echo "Start Time: ", $profile->getInitialTime(), "\n";
echo "Final Time: ", $profile->getFinalTime(), "\n";
echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";
```

## Propiedades

```php
/**
 * Active Phalcon\Db\Profiler\Item
 *
 * @var Phalcon\Db\Profiler\Item
 */
protected activeProfile;

/**
 * All the Phalcon\Db\Profiler\Item in the active profile
 *
 * @var \Phalcon\Db\Profiler\Item[]
 */
protected allProfiles;

/**
 * Total time spent by all profiles to complete
 *
 * @var float
 */
protected totalSeconds = 0;

```

## Métodos

```php
public function getLastProfile(): Item;
```

Devuelve el último perfil ejecutado en el perfilador

```php
public function getNumberTotalStatements(): int;
```

Devuelve el número total de sentencias SQL procesadas

```php
public function getProfiles(): Item[];
```

Obtiene todos los perfiles procesados

```php
public function getTotalElapsedSeconds(): double;
```

Devuelve el tiempo total empleado por los perfiladores en segundos

```php
public function reset(): Profiler;
```

Restablece el perfilador, limpiando todos los perfiladores

```php
public function startProfile( string $sqlStatement, mixed $sqlVariables = null, mixed $sqlBindTypes = null ): Profiler;
```

Inicia el perfil de una sentencia SQL

```php
public function stopProfile(): Profiler;
```

Detiene el perfil activo

<h1 id="db-profiler-item">Class Phalcon\Db\Profiler\Item</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Db/Profiler/Item.zep)

| Namespace | Phalcon\Db\Profiler |

Esta clase identifica cada perfil de un Phalcon\Db\Profiler

## Propiedades

```php
/**
 * Timestamp when the profile ended
 *
 * @var double
 */
protected finalTime;

/**
 * Timestamp when the profile started
 *
 * @var double
 */
protected initialTime;

/**
 * SQL bind types related to the profile
 *
 * @var array
 */
protected sqlBindTypes;

/**
 * SQL statement related to the profile
 *
 * @var string
 */
protected sqlStatement;

/**
 * SQL variables related to the profile
 *
 * @var array
 */
protected sqlVariables;

```

## Métodos

```php
public function getFinalTime(): double
```

```php
public function getInitialTime(): double
```

```php
public function getSqlBindTypes(): array
```

```php
public function getSqlStatement(): string
```

```php
public function getSqlVariables(): array
```

```php
public function getTotalElapsedSeconds(): double;
```

Devuelve el tiempo total gastado por el perfil en segundos

```php
public function setFinalTime( double $finalTime )
```

```php
public function setInitialTime( double $initialTime )
```

```php
public function setSqlBindTypes( array $sqlBindTypes )
```

```php
public function setSqlStatement( string $sqlStatement )
```

```php
public function setSqlVariables( array $sqlVariables )
```

<h1 id="db-rawvalue">Class Phalcon\Db\RawValue</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Db/RawValue.zep)

| Namespace | Phalcon\Db |

Esta clase permite insertar/actualizar datos brutos sin comillas ni formatos.

El ejemplo siguiente muestra como usar la función MySQL now() como valor de un campo.

```php
$subscriber = new Subscribers();

$subscriber->email     = "andres@phalcon.io";
$subscriber->createdAt = new \Phalcon\Db\RawValue("now()");

$subscriber->save();
```

## Propiedades

```php
/**
 * Raw value without quoting or formatting
 *
 * @var string
 */
protected value;

```

## Métodos

```php
public function __construct( mixed $value );
```

Constructor Phalcon\Db\RawValue

```php
public function __toString(): string
```

```php
public function getValue(): string
```

<h1 id="db-reference">Class Phalcon\Db\Reference</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Db/Reference.zep)

| Namespace | Phalcon\Db | | Implements | ReferenceInterface |

Permite definir restricciones de referencia en tablas

```php
$reference = new \Phalcon\Db\Reference(
    "field_fk",
    [
        "referencedSchema"  => "invoicing",
        "referencedTable"   => "products",
        "columns"           => [
            "producttype",
            "product_code",
        ],
        "referencedColumns" => [
            "type",
            "code",
        ],
    ]
);
```

## Propiedades

```php
/**
 * Local reference columns
 *
 * @var array
 */
protected columns;

/**
 * Constraint name
 *
 * @var string
 */
protected name;

/**
 * Referenced Columns
 *
 * @var array
 */
protected referencedColumns;

/**
 * Referenced Schema
 *
 * @var string
 */
protected referencedSchema;

/**
 * Referenced Table
 *
 * @var string
 */
protected referencedTable;

/**
 * Schema name
 *
 * @var string
 */
protected schemaName;

/**
 * ON DELETE
 *
 * @var string
 */
protected onDelete;

/**
 * ON UPDATE
 *
 * @var string
 */
protected onUpdate;

```

## Métodos

```php
public function __construct( string $name, array $definition );
```

Constructor Phalcon\Db\Reference

```php
public function getColumns(): array
```

```php
public function getName(): string
```

```php
public function getOnDelete(): string
```

```php
public function getOnUpdate(): string
```

```php
public function getReferencedColumns(): array
```

```php
public function getReferencedSchema(): string
```

```php
public function getReferencedTable(): string
```

```php
public function getSchemaName(): string
```

<h1 id="db-referenceinterface">Interface Phalcon\Db\ReferenceInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Db/ReferenceInterface.zep)

| Namespace | Phalcon\Db |

Interfaz para Phalcon\Db\Reference

## Métodos

```php
public function getColumns(): array;
```

Obtiene las columnas locales en las que se basa la referencia

```php
public function getName(): string;
```

Obtiene el nombre del índice

```php
public function getOnDelete(): string;
```

Obtiene la referencia al eliminar

```php
public function getOnUpdate(): string;
```

Obtiene la referencia al actualizar

```php
public function getReferencedColumns(): array;
```

Obtiene las columnas referenciadas

```php
public function getReferencedSchema(): string;
```

Obtiene el esquema donde está la tabla referenciada

```php
public function getReferencedTable(): string;
```

Obtiene la tabla referenciada

```php
public function getSchemaName(): string;
```

Obtiene el esquema donde está la tabla referenciada

<h1 id="db-result-pdo">Class Phalcon\Db\Result\Pdo</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Db/Result/Pdo.zep)

| Namespace | Phalcon\Db\Result | | Uses | Phalcon\Db\Enum, Phalcon\Db\ResultInterface, Phalcon\Db\Adapter\AdapterInterface | | Implements | ResultInterface |

Encapsula el conjunto de resultados interno

```php
$result = $connection->query("SELECTFROM robots ORDER BY name");

$result->setFetchMode(
    \Phalcon\Db\Enum::FETCH_NUM
);

while ($robot = $result->fetchArray()) {
    print_r($robot);
}
```

## Propiedades

```php
//
protected bindParams;

//
protected bindTypes;

//
protected connection;

/**
 * Active fetch mode
 */
protected fetchMode;

/**
 * Internal resultset
 *
 * @var \PDOStatement
 */
protected pdoStatement;

//
protected result;

//
protected rowCount = false;

//
protected sqlStatement;

```

## Métodos

```php
public function __construct( AdapterInterface $connection, \PDOStatement $result, mixed $sqlStatement = null, mixed $bindParams = null, mixed $bindTypes = null );
```

Constructor Phalcon\Db\Result\Pdo

```php
public function dataSeek( long $number ): void;
```

Mueve el cursor del conjunto de resultados interno a otra posición permitiéndonos obtener una fila determinada

```php
$result = $connection->query(
    "SELECTFROM robots ORDER BY name"
);

// Move to third row on result
$result->dataSeek(2);

// Fetch third row
$row = $result->fetch();
```

```php
public function execute(): bool;
```

Permite ejecutar la sentencia otra vez. Algunos sistemas de base de datos no soportan cursores desplazables. Por lo tanto, como los cursores sólo son hacia delante, necesitamos ejecutar el cursos otra vez para obtener filas desde el principio

```php
public function fetch( mixed $fetchStyle = null, mixed $cursorOrientation = null, mixed $cursorOffset = null );
```

Obtiene un vector/objeto de cadenas que corresponden a las filas obtenidas, o FALSE si no hay más filas. Este método se ve afectado por el indicador de obtención activo configurado usando `Phalcon\Db\Result\Pdo::setFetchMode()`

```php
$result = $connection->query("SELECTFROM robots ORDER BY name");

$result->setFetchMode(
    \Phalcon\Enum::FETCH_OBJ
);

while ($robot = $result->fetch()) {
    echo $robot->name;
}
```

```php
public function fetchAll( mixed $fetchStyle = null, mixed $fetchArgument = null, mixed $ctorArgs = null ): array;
```

Devuelve un vector de vectores que contiene todos los registros del resultado Este método se ve afectado por el indicador de obtención activo configurado usando `Phalcon\Db\Result\Pdo::setFetchMode()`

```php
$result = $connection->query(
    "SELECTFROM robots ORDER BY name"
);

$robots = $result->fetchAll();
```

```php
public function fetchArray();
```

Devuelve un vector de cadenas que corresponden a la fila obtenida, o FALSE si no hay más filas. Este método se ve afectado por el indicador de obtención activo configurado usando `Phalcon\Db\Result\Pdo::setFetchMode()`

```php
$result = $connection->query("SELECTFROM robots ORDER BY name");

$result->setFetchMode(
    \Phalcon\Enum::FETCH_NUM
);

while ($robot = result->fetchArray()) {
    print_r($robot);
}
```

```php
public function getInternalResult(): \PDOStatement;
```

Obtiene el objeto de resultado PDO interno

```php
public function numRows(): int;
```

Obtiene el número de filas devueltas por un conjunto de resultados

```php
$result = $connection->query(
    "SELECTFROM robots ORDER BY name"
);

echo "There are ", $result->numRows(), " rows in the resultset";
```

```php
public function setFetchMode( int $fetchMode, mixed $colNoOrClassNameOrObject = null, mixed $ctorargs = null ): bool;
```

Cambia el modo de obtención que afecta a Phalcon\Db\Result\Pdo::fetch()

```php
// Return array with integer indexes
$result->setFetchMode(
    \Phalcon\Enum::FETCH_NUM
);

// Return associative array without integer indexes
$result->setFetchMode(
    \Phalcon\Enum::FETCH_ASSOC
);

// Return associative array together with integer indexes
$result->setFetchMode(
    \Phalcon\Enum::FETCH_BOTH
);

// Return an object
$result->setFetchMode(
    \Phalcon\Enum::FETCH_OBJ
);
```

<h1 id="db-resultinterface">Interface Phalcon\Db\ResultInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Db/ResultInterface.zep)

| Namespace | Phalcon\Db |

Interfaz para objetos Phalcon\Db\Result

## Métodos

```php
public function dataSeek( long $number );
```

Mueve el cursor del conjunto de resultados interno a otra posición permitiéndonos obtener una fila determinada

```php
public function execute(): bool;
```

Permite ejecutar la sentencia otra vez. Algunos sistemas de base de datos no soportan cursores desplazables. Por lo tanto, como los cursores sólo son hacia delante, necesitamos ejecutar el cursos otra vez para obtener filas desde el principio

```php
public function fetch(): mixed;
```

Obtiene un vector/objeto de cadenas que corresponden a las filas obtenidas, o FALSE si no hay más filas. Este método se ve afectado por el indicador de obtención activo configurado usando `Phalcon\Db\Result\Pdo::setFetchMode()`

```php
public function fetchAll(): array;
```

Devuelve un vector de vectores que contienen todos los registros de un resultado. Este método se ve afectado por el indicador de obtención activo configurado usando `Phalcon\Db\Result\Pdo::setFetchMode()`

```php
public function fetchArray(): mixed;
```

Devuelve un vector de cadenas que corresponden a la fila obtenida, o FALSE si no hay más filas. Este método se ve afectado por el indicador de obtención activo configurado usando `Phalcon\Db\Result\Pdo::setFetchMode()`

```php
public function getInternalResult(): \PDOStatement;
```

Obtiene el objeto de resultado PDO interno

```php
public function numRows(): int;
```

Obtiene el número de filas devueltas por un conjunto de resultados

```php
public function setFetchMode( int $fetchMode ): bool;
```

Cambia el modo de obtención que afecta a Phalcon\Db\Result\Pdo::fetch()
