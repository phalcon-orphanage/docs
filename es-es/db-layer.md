---
layout: default
language: 'es-es'
version: '4.0'
title: 'Capa de abstracción de base de datos'
keywords: 'db, dbal, phql, base de datos, mysql, postgresql, sqlite'
---

# Capa de Abstracción de Base de Datos

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

Los componente debajo del espacio de nombres `Phalcon\Db` son los responsables de potenciar la clase [Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) - el `Modelo` en MVC para el *framework*. Consiste en una capa de abstracción independiente de alto nivel para sistemas de base de datos escrita completamente en C.

Este componente permite una manipulación de base de datos de más bajo nivel que usando modelos tradicionales.

## Adaptadores

Este componente hace uso de adaptadores para encapsular los detalles específicos del sistema de base de datos. Phalcon usa PDO para conectar a bases de datos. Se soportan los siguientes motores de base de datos:

| Clase                                                                             | Descripción                                                                                                                                                                                                                                                |
| --------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| [Phalcon\Db\Adapter\Pdo\Mysql](api/phalcon_db#db-adapter-pdo-mysql)           | Es el sistema de gestión de bases de datos relacionales (RDBMS) más utilizado en el mundo que se ejecuta como un servidor que provee acceso multiusuario a un número de bases de datos                                                                     |
| [Phalcon\Db\Adapter\Pdo\Postgresql](api/phalcon_db#db-adapter-pdo-postgresql) | PostgreSQL es un sistema de base de datos relacional de código abierto muy potente. Tiene más de 15 años de desarrollo activo y una arquitectura probada que se ha ganado una sólida reputación por la fiabilidad, la integridad y exactitud de los datos. |
| [Phalcon\Db\Adapter\Pdo\Sqlite](api/phalcon_db#db-adapter-pdo-sqlite)         | SQLite es una biblioteca de software que implementa un motor de base de datos SQL transaccional independiente, sin servidor, sin configuración                                                                                                             |

### Constantes

La clase [Phalcon\Db\Enum](api/phalcon_db#db-enum) expone un número de constantes que se pueden usar en la capa BD. - `FETCH_ASSOC` = `\Pdo::FETCH_ASSOC` - `FETCH_BOTH` = `\Pdo::FETCH_BOTH` - `FETCH_BOUND` = `\Pdo::FETCH_BOUND` - `FETCH_CLASS` = `\Pdo::FETCH_CLASS` - `FETCH_CLASSTYPE` = `\Pdo::FETCH_CLASSTYPE` - `FETCH_COLUMN` = `\Pdo::FETCH_COLUMN` - `FETCH_FUNC` = `\Pdo::FETCH_FUNC` - `FETCH_GROUP` = `\Pdo::FETCH_GROUP` - `FETCH_INTO` = `\Pdo::FETCH_INTO` - `FETCH_KEY_PAIR` = `\Pdo::FETCH_KEY_PAIR` - `FETCH_LAZY` = `\Pdo::FETCH_LAZY` - `FETCH_NAMED` = `\Pdo::FETCH_NAMED` - `FETCH_NUM` = `\Pdo::FETCH_NUM` - `FETCH_OBJ` = `\Pdo::FETCH_OBJ` - `FETCH_PROPS_LATE` = `\Pdo::FETCH_PROPS_LATE` - `FETCH_SERIALIZE` = `\Pdo::FETCH_SERIALIZE` - `FETCH_UNIQUE` = `\Pdo::FETCH_UNIQUE`

Hay disponibles constantes adicionales en el objeto [Phalcon\Db\Column](api/phalcon_db#db-column). Este objeto se usa para describir una columna (o campo) en una tabla de base de datos. Estas constantes también definen qué tipos soporta el ORM.

**Tipos de Enlace**

* `BIND_PARAM_BLOB` - Blob
* `BIND_PARAM_BOOL` - Bool
* `BIND_PARAM_DECIMAL` - Decimal
* `BIND_PARAM_INT` - Entero
* `BIND_PARAM_NULL` - Null
* `BIND_PARAM_STR` - Cadena
* `BIND_SKIP` - Omitir enlace

**Tipos de Columna**

* `TYPE_BIGINTEGER` - Entero grande
* `TYPE_BIT` - Bit
* `TYPE_BLOB` - Blob
* `TYPE_BOOLEAN` - Booleano
* `TYPE_CHAR` - Carácter
* `TYPE_DATE` - Fecha
* `TYPE_DATETIME` - Fecha y hora
* `TYPE_DECIMAL` - Decimal
* `TYPE_DOUBLE` - Real de doble precisión
* `TYPE_ENUM` - Enum
* `TYPE_FLOAT` - Real
* `TYPE_INTEGER` - Entero
* `TYPE_JSON` - JSON
* `TYPE_JSONB` - JSONB
* `TYPE_LONGBLOB` - Blob grande
* `TYPE_LONGTEXT` - Texto grande
* `TYPE_MEDIUMBLOB` - Blob medio
* `TYPE_MEDIUMINTEGER` - Entero medio
* `TYPE_MEDIUMTEXT` - Texto medio
* `TYPE_SMALLINTEGER` - Entero pequeño
* `TYPE_TEXT` - Texto
* `TYPE_TIME` - Tiempo
* `TYPE_TIMESTAMP` - Timestamp
* `TYPE_TINYBLOB` - Blob diminuto
* `TYPE_TINYINTEGER` - Entero diminuto
* `TYPE_TINYTEXT` - Texto diminuto
* `TYPE_VARCHAR` - Varchar

> **NOTA**: Dependiendo de su RDBMS, ciertos tipos podrían no estar disponibles (ej. `JSON` no se soporta en Sqlite).
{: .alert .alert-info }

### Métodos

```php
public function addColumn(
    string $tableName, 
    string $schemaName, 
    ColumnInterface $column
): bool
```

Añade una columna a una tabla

```php
public function addIndex(
    string $tableName, 
    string $schemaName,
    IndexInterface $index
): bool
```

Añade un índice a una tabla

```php
public function addForeignKey(
    string $tableName, 
    string $schemaName, 
    ReferenceInterface $reference
): bool
```

Añade una clave ajena a una tabla

```php
public function addPrimaryKey(
    string $tableName, 
    string $schemaName, 
    IndexInterface $index
): bool
```

Añade una clave primaria a una tabla

```php
public function affectedRows(): int
```

Devuelve el número de filas afectadas por el último `INSERT`/`UPDATE`/`DELETE` informado por el sistema de base de datos

```php
public function begin(
    bool $nesting = true
): bool
```

Inicia una transacción en la conexión

```php
public function close(): bool
```

Cierra la conexión activa devolviendo éxito. Phalcon automáticamente cierra y destruye las conexiones activas

```php
public function commit(
    bool $nesting = true
): bool
```

Confirma la transacción activa en la conexión

```php
public function connect(
    array $descriptor = null
): bool
```

Este método se llama automáticamente en el constructor [Phalcon\Db\Adapter\Pdo\AbstractPdo](api/phalcon_db#db-adapter-pdo-abstractpdo). Llámelo cuando necesite restaurar una conexión de base de datos

```php
public function createSavepoint(
    string $name
): bool
```

Crea un nuevo punto de guardado

public function createTable( string $tableName, string $schemaName, array $definition ): bool

    Crea una tabla
    
    ```php
    public function createView(
        string $viewName, 
        array $definition, 
        string $schemaName = null
    ): bool
    

Crea una vista

```php
public function delete(
    mixed $table, 
    mixed $whereCondition = null, 
    mixed $placeholders = null, 
    mixed $dataTypes = null
): bool
```

Borra datos de una tabla usando sintaxis SQL del RBDMS personalizada

```php
public function describeColumns(
    string $table, 
    string $schema = null
): ColumnInterface[]
```

Devuelve un vector de objetos Phalcon\Db\Column que describen una tabla

```php
public function describeIndexes(
    string $table, 
        string $schema = null
): IndexInterface[]
```

Lista los índices de la tabla

```php
public function describeReferences(
    string $table, 
    string $schema = null
): ReferenceInterface[]
```

Lista las referencias de la tabla

```php
public function dropColumn(
    string $tableName, 
    string $schemaName, 
    string $columnName
): bool
```

Elimina una columna de una tabla

```php
public function dropForeignKey(
    string $tableName, 
    string $schemaName, 
    string $referenceName
): bool
```

Elimina una clave ajena de una tabla

```php
public function dropIndex(
    string $tableName, 
    string $schemaName, 
    string $indexName
): bool
```

Elimina un índice de una tabla

```php
public function dropPrimaryKey(
    string $tableName, 
    string $schemaName
): bool
```

Elimina una clave primaria de una tabla

```php
public function dropTable(
    string $tableName, 
    string $schemaName = null, 
    bool $ifExists = true
): bool
```

Elimina una tabla de un esquema/base de datos

```php
public function dropView(
    string $viewName, 
    string $schemaName = null, 
    bool $ifExists = true
): bool
```

Elimina una vista

```php
public function escapeIdentifier(
    mixed identifier
): string
```

Escapa un nombre de columna/tabla/esquema.

```php
public function escapeString(string $str): string
```php
Escapa un valor para evitar inyecciones SQL

```php
public function execute(
    string $sqlStatement, 
    mixed $placeholders = null, 
    mixed $dataTypes = null
): bool
```

Envía sentencias SQL al servidor de base de datos devolviendo el estado de éxito. Use este método sólo cuando las sentencias SQL enviadas al servidor no devuelvan ninguna fila

```php
public function fetchAll(
    string $sqlQuery, 
    int $fetchMode = 2, 
    mixed $placeholders = null
): array
```

Vuelca el resultado completo de una consulta en un vector

```php
public function fetchColumn(
    string $sqlQuery, 
    array $placeholders = [], 
    mixed $column = 0
): string | bool
```

Devuelve el n-ésimo campo de la primera fila en un resultado de consulta SQL

```php
$invoicesCount = $connection
    ->fetchColumn('SELECT count(*) FROM co_invoices')
print_r($invoicesCount)

$invoice = $connection->fetchColumn(
    'SELECT inv_id, inv_title 
    FROM co_invoices
    ORDER BY inv_created_at DESC',
    1
)
print_r($invoice)
```

```php
public function fetchOne(
    string $sqlQuery, 
    int $fetchMode = 2, 
    mixed $placeholders = null
): array
```

Devuelve la primera fila en un resultado de consulta SQL

```php
public function forUpdate(
    string $sqlQuery
): string
```

Devuelve un SQL modificado con una cláusula *FOR UPDATE*

```php
public function getColumnDefinition(
    ColumnInterface $column
): string
```

Devuelve la definición de columna SQL para una columna

```php
public function getColumnList(
    mixed $columnList
): string
```

Obtiene una lista de columnas

```php
public function getConnectionId(): string
```

Obtiene el identificador único de conexión activo

```php
public function getDescriptor(): array
```

Devuelve el descriptor usado para conectar a la base de datos activa

```php
public function getDialect(): DialectInterface
```

Devuelve la instancia interna del dialecto

```php
public function getDialectType(): string
```

Devuelve el nombre del dialecto usado

```php
public function getDefaultIdValue(): RawValue
```

Devuelve el valor de la identidad predeterminado para insertar en una columna de identidad

```php
public function getInternalHandler(): \PDO
```

Devuelve el manejador PDO interno

```php
public function getNestedTransactionSavepointName(): string
```

Devuelve el nombre del punto de guardado a usar en transacciones anidadas

```php
public function getRealSQLStatement(): string
```

Sentencia SQL activa en el objeto sin reemplazar parámetros enlazados

```php
public function getSQLStatement(): string
```

Sentencia SQL activa en el objeto

```php
public function getSQLBindTypes(): array
```

Sentencia SQL activa en el objeto

```php
public function getSQLVariables(): array
```

Sentencia SQL activa en el objeto

```php
public function getType(): string
```

Devuelve el tipo de sistema de base de datos para el que se usa el adaptador

```php
public function insert(
    string $table, 
    array $values, 
    mixed $fields = null, 
    mixed $dataTypes = null
): bool
```

Inserta datos en una tabla usando sintaxis SQL personalizada del RDBMS

```php
public function insertAsDict(
    string $table, 
    mixed $data, 
    mixed $dataTypes = null
): bool
```

Inserta datos en una tabla usando sintaxis SQL personalizada del RBDM

```php
// Inserting a new invoice
$success = $connection->insertAsDict(
    'co_invoices',
    [
        'inv_cst_id' => 1,
        'inv_title'  => 'Invoice for ACME Inc.',
    ]
)

// Next SQL sentence is sent to the database system
INSERT INTO `co_invoices` 
    ( `inv_cst_id`, `inv_title` ) 
VALUES 
    ( 1, 'Invoice for ACME Inc.' )
```

```php
public function isNestedTransactionsWithSavepoints(): bool
```

Devuelve si las transacciones anidadas deberían usar puntos de guardado

```php
public function isUnderTransaction(): bool
```

Comprueba si la conexión está bajo una transacción de base de datos

```php
public function lastInsertId(
    mixed $sequenceName = null
)
```

Devuelve el id insertado en una columna auto_increment en la última sentencia SQL

```php
public function limit(
    string $sqlQuery, 
    int $number
): string
```

Añade una cláusula LIMIT al argumento sqlQuery

```php
public function listTables(
    string $schemaName = null
): array
```

Lista todas las tablas de una base de datos

```php
public function listViews(
    string $schemaName = null
): array
```

Lista todas las vistas de una base de datos

```php
public function modifyColumn(
    string $tableName, 
    string $schemaName, 
    ColumnInterface $column, 
    ColumnInterface $currentColumn = null
): bool
```

Modifica una columna de base de datos basada en una definición

```php
public function query(
    string $sqlStatement, 
    mixed $placeholders = null, 
    mixed $dataTypes = null
): ResultInterface | bool
```

Envía sentencias SQL al servidor de base de datos devolviendo el estado de éxito. Use este método sólo cuando las sentencias SQL enviadas al servidor devuelvan filas

```php
public function releaseSavepoint(
    string $name
): bool
```

Lanza el punto de guardado dado

```php
public function rollback(
    bool $nesting = true
): bool
```

Deshace la transacción activa en la conexión

```php
public function rollbackSavepoint(
    string $name
): bool
```

Deshace el punto de guardado dado

```php
public function sharedLock(
    string $sqlQuery
): string
```

Devuelve un SQL modificado con la cláusula LOCK IN SHARE MODE

```php
public function setNestedTransactionsWithSavepoints(
    bool $nestedTransactionsWithSavepoints
): AdapterInterface
```

Establece si las transacciones anidadas deberían usar puntos de guardado

```php
public function supportSequences(): bool
```

Comprueba si el sistema de base de datos necesita una secuencia para producir valores autonuméricos

```php
public function tableExists(
    string $tableName, 
    string $schemaName = null
): bool
```

Genera SQL que comprueba la existencia de esquema.tabla

```php
public function tableOptions(
    string $tableName, 
    string $schemaName = null
): array
```

Obtiene las opciones de creación de una tabla

```php
public function update(
    string $table, 
    mixed $fields, 
    mixed $values, 
    mixed $whereCondition = null, 
    mixed $dataTypes = null
): bool
```

Actualiza datos en una tabla usando sintaxis SQL personalizada del RDBMS

```php
public function updateAsDict(
    string $table, 
    mixed $data, 
    mixed $whereCondition = null, 
    mixed $dataTypes = null
): bool
```

Actualiza datos en una tabla usando sintaxis SQL personalizada del RBDM. Otra sintaxis más conveniente

```php
// Updating existing invoice
$success = $connection->updateAsDict(
    'co_invoices',
    [
        'inv_title' => 'Invoice for ACME Inc.',
    ],
    'inv_id = 1'
)

// Next SQL sentence is sent to the database system
UPDATE `co_invoices` 
SET    `inv_title` = 'Invoice for ACME Inc.' 
WHERE   inv_id = 1
```

```php
public function useExplicitIdValue(): bool
```

Comprueba si el sistema de base de datos necesita un valor explícito para columnas identidad

```php
public function viewExists(
    string $viewName, 
    string $schemaName = null
): bool
```

Genera SQL que comprueba la existencia de un esquema vista

### Personalizado

Debe implementar el interfaz [Phalcon\Db\AdapterInterface](api/phalcon_db#db-adapter-adapterinterface) para poder crear sus propios adaptadores de base de datos o extender los existentes. Además, puede extender [Phalcon\Db\AbstractAdapter](api/phalcon_db#db-adapter-abstractadapter) que ya tiene alguna implementación para su adaptador personalizado.

### Escape

El escapado de identificadores está habilitado por defecto. Sin embargo, si necesita deshabilitar esta característica, puede hacerlo usando el método `setup()`:

```php
<?php

\Phalcon\Db::setup(
    [
        'escapeIdentifiers' => false,
    ]
);
```

## Fábrica (Factory)

### `newInstance()`

Aunque todas las clases de adaptador se pueden instanciar usando la palabra clave `new`, Phalcon ofrece la clase [Phalcon\Db\Adapter\PdoFactory](api/phalcon_db#db-adapter-pdofactory), para que pueda instanciar fácilmente instancias de adaptadores PDO. Todos los adaptadores de arriba están registrados en la fábrica y son cargados perezosamente cuando se llaman. La fábrica le permite registrar clases de adaptadores (personalizados) adicionales. Lo único a considerar es elegir el nombre del adaptador en comparación con los existentes. Si define el mismo nombre, sobreescribirá el integrado. Los objetos son cacheados en la fábrica, así que si llama al método `newInstance()` con los mismos parámetros durante la misma petición, recibirá el mismo objeto de vuelta.

Los nombres reservados son: - `mysql` - [Phalcon\Db\Adapter\Pdo\Mysql](api/phalcon_db#db-adapter-pdo-mysql) - `postgresql` - [Phalcon\Db\Adapter\Pdo\Postgresql](api/phalcon_db#db-adapter-pdo-postgresql) - `sqlite` - [Phalcon\Db\Adapter\Pdo\Sqlite](api/phalcon_db#db-adapter-pdo-sqlite)

El siguiente ejemplo muestra como puede crear un adaptador MySQL con la palabra clave `new` o la fábrica:

```php
<?php

use Phalcon\Db\Adapter\Pdo\MySQL;

$connection = new MySQL(
    [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => '',
        'dbname'   => 'test',
    ]
);
```

```php
<?php

use Phalcon\Db\Adapter\PdoFactory;

$factory    = new PdoFactory();
$connection = $factory
    ->newInstance(
        'mysql',
        [
            'host'     => 'localhost',
            'username' => 'root',
            'password' => '',
            'dbname'   => 'test',
        ]
    )
;
```

### `load()`

También puede usar el método `load()` para crear un adaptador usando un objeto de configuración o un vector. El siguiente ejemplo usa un fichero `ini` para instanciar la conexión de base de datos usando `load()`.

    [database]
    host = TEST_DB_MYSQL_HOST
    username = TEST_DB_MYSQL_USER
    password = TEST_DB_MYSQL_PASSWD
    dbname = TEST_DB_MYSQL_NAME
    port = TEST_DB_MYSQL_PORT
    charset = TEST_DB_MYSQL_CHARSET
    adapter = mysql
    

```php
<?php

use Phalcon\Config\Adapter\Ini;
use Phalcon\Di;
use Phalcon\Db\Adapter\PdoFactory;

$container = new Di();

$config = new Ini('config.ini');

$container->set('config', $config);

$container->set(
    'db', 
    function () {
        return (new PdoFactory())->load($this->config->database);
    }
);
```

## Dialectos

### Integrado

Phalcon encapsula los detalles específicos de cada motor de base de datos en dialectos. [Phalcon\Db\Dialect](api/phalcon_db#db-dialect) proporciona funciones comunes y generador SQL a los adaptadores.

| Clase                                                                    | Descripción                                           |
| ------------------------------------------------------------------------ | ----------------------------------------------------- |
| [Phalcon\Db\Dialect\Mysql](api/phalcon_db#db-dialect-mysql)           | Dialecto específico SQL para base de datos MySQL      |
| [Phalcon\Db\Dialect\Postgresql](api/phalcon_db#db-dialect-postgresql) | Dialecto específico SQL para base de datos PostgreSQL |
| [Phalcon\Db\Dialect\Sqlite](api/phalcon_db#db-dialect-sqlite)         | Dialecto específico SQL para base de datos de SQLite  |

### Personalizado

Se debe implementar el interfaz [Phalcon\Db\DialectInterface](api/phalcon_db#db-dialectinterface) para poder crear su propio dialecto de base de datos o extender los existentes. También puede mejorar su dialecto actual añadiendo más comandos/métodos que PHQL entenderá. Por ejemplo cuando usa el adaptador MySQL, podría querer permitir que PHQL reconozca la sintaxis `MATCH ... AGAINST ...`. Asociamos esa sintaxis con `MATCH_AGAINST`

Instanciamos el dialecto. Añadimos la función personalizada para que PHQL sepa que hacer cuando la encuentra durante el proceso de análisis. En el siguiente ejemplo, registramos una nueva función personalizada llamada `MATCH_AGAINST`. Después de esto, todo lo que tenemos que hacer es añadir el objeto de dialecto personalizado a nuestra conexión.

```php
<?php

use Phalcon\Db\Dialect\MySQL as SqlDialect;
use Phalcon\Db\Adapter\Pdo\MySQL as Connection;

$dialect = new SqlDialect();

$dialect->registerCustomFunction(
    'MATCH_AGAINST',
    function ($dialect, $expression) {
        $arguments = $expression['arguments'];
        return sprintf(
            ' MATCH (%s) AGAINST (%s)',
            $dialect->getSqlExpression($arguments[0]),
            $dialect->getSqlExpression($arguments[1])
         );
    }
);

$connection = new Connection(
    [
        'host'          => 'localhost',
        'username'      => 'root',
        'password'      => '',
        'dbname'        => 'test',
        'dialectClass'  => $dialect,
    ]
);
```

Ahora podemos usar esta nueva función en PHQL, que a su vez la traducirá a la sintaxis SQL apropiada:

```php
<?php

$phql = '
  SELECT *
  FROM   Invoices
  WHERE  MATCH_AGAINST(title, :pattern:)';

$posts = $modelsManager->executeQuery(
    $phql,
    [
        'pattern' => $pattern,
    ]
);
```

> **NOTA**: Hay más ejemplos de como extender PHQL en el documento [PHQL](db-phql).
{: .alert .alert-info }

## Conectar

Para crear una conexión es necesario instanciar la clase adaptador. Sólo necesita un vector con los parámetros de conexión. El siguiente ejemplo muestra como crear una conexión pasando tanto parámetros obligatorios como opcionales:

| Adaptador    | Parámetro    | Estado      |
| ------------ | ------------ | ----------- |
| `MySQL`      | `host`       | obligatorio |
|              | `username`   | obligatorio |
|              | `password`   | obligatorio |
|              | `dbname`     | obligatorio |
|              | `persistent` | opcional    |
| `PostgreSQL` | `host`       | obligatorio |
|              | `username`   | obligatorio |
|              | `password`   | obligatorio |
|              | `dbname`     | obligatorio |
|              | `schema`     | opcional    |
| `Sqlite`     | `dbname`     | obligatorio |

Conectar a cada adaptador se puede lograr mediante la fábrica como se ha demostrado anteriormente o pasando las opciones relevantes al constructor de cada clase.

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Db\Adapter\Pdo\Postgresql;
use Phalcon\Db\Adapter\Pdo\Sqlite;

$config = [
    'host'     => '127.0.0.1',
    'username' => 'mike',
    'password' => 'sigma',
    'dbname'   => 'test_db',
];

$connection = new Mysql($config);

$config = [
    'host'     => 'localhost',
    'username' => 'postgres',
    'password' => 'secret1',
    'dbname'   => 'template',
];

$connection = new Postgresql($config);

$config = [
    'dbname' => '/path/to/database.db',
];
$connection = new Sqlite($config);
```

**Opciones PDO adicionales**

Puede establecer opciones PDO en tiempo de conexión pasando el parámetro `options`:

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql;

$connection = new Mysql(
    [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'sigma',
        'dbname'   => 'test_db',
        'options'  => [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
            PDO::ATTR_CASE               => PDO::CASE_LOWER,
        ]
    ]
);
```

## Crear

Para insertar una fila en la base de datos, puede usar SQL bruto o usar métodos presentes en el adaptador:

```php
<?php

$sql     = "
INSERT INTO `co_invoices` 
    ( `inv_cst_id`, `inv_title` ) 
VALUES 
    ( 1, 'Invoice for ACME Inc.' )
";
$success = $connection->execute($sql);
```

SQL Bruto

```php
<?php

$sql     = '
INSERT INTO `co_invoices` 
    ( `inv_cst_id`, `inv_title` ) 
VALUES 
    ( ?, ? )
';
$success = $connection->execute(
    $sql,
    [
        1,
        'Invoice for ACME Inc.',
    ]
);
```

Marcadores de posición

```php
<?php

$success = $connection->insert(
    'co_invoices',
    [
        1,
        'Invoice for ACME Inc.',
    ],
    [
        'inv_cst_id',
        'inv_title', 
    ]
);
```

Generación dinámica

```php
<?php

$success = $connection->insertAsDict(
    'co_invoices',
    [
        'inv_cst_id' => 1,
        'inv_title'  => 'Invoice for ACME Inc.',
    ]
);
```

Generación dinámica (sintaxis alternativa)

## Actualizar

Para actualizar una fila en la base de datos, puede usar SQL bruto o usar los métodos presentes en el adaptador:

```php
<?php

$sql     = "
UPDATE 
    `co_invoices` 
SET 
    `inv_cst_id`= 1, 
    `inv_title` = 'Invoice for ACME Inc.'
WHERE
    `inv_id` = 4
";
$success = $connection->execute($sql);
```

SQL Bruto

```php
<?php

$sql     = "
UPDATE 
    `co_invoices` 
SET 
    `inv_cst_id`= ?, 
    `inv_title` = ?
WHERE
    `inv_id` = ?
";
$success = $connection->execute(
    $sql,
    [
        1,
        'Invoice for ACME Inc.',
        4,
    ]
);
```

Marcadores de posición

```php
<?php

$success = $connection->update(
    'co_invoices',
    [
        'inv_cst_id',
        'inv_title',
    ],
    [
        1,
        'Invoice for ACME Inc.',
    ],
    'inv_id = 4'
);
```

Generación dinámica

> **NOTA**: Con la sintaxis anterior, las variables para la parte del `where` del `update` (`inv_id = 4`) no se escapan!
{: .alert .alert-danger }

```php
<?php

$success = $connection->updateAsDict(
    'co_invoices',
    [
        'inv_cst_id' => 1,
        'inv_title'  => 'Invoice for ACME Inc.',
    ],
    'inv_id = 4'
);
```

Generación dinámica (sintaxis alternativa)

> **NOTA**: Con la sintaxis anterior, las variables para la parte del `where` del `update` (`inv_id = 4`) no se escapan!
{: .alert .alert-danger }

```php
<?php

$success = $connection->update(
    'co_invoices',
    [
        'inv_cst_id',
        'inv_title',
    ],
    [
        1,
        'Invoice for ACME Inc.',
    ],
    [
        'conditions' => 'id = ?',
        'bind'       => [
            4
        ],
        'bindTypes'  => [
            \PDO::PARAM_INT
        ],
    ]
);
```

Con condicionales escapados

```php
<?php

$success = $connection->updateAsDict(
    'co_invoices',
    [
        'inv_cst_id' => 1,
        'inv_title'  => 'Invoice for ACME Inc.',
    ],
    [
        'conditions' => 'id = ?',
        'bind'       => [
            4
        ],
        'bindTypes'  => [
            \PDO::PARAM_INT
        ],
    ]
);
```

Con condicionales escapados (sintaxis alternativa)

## Eliminar

```php
<?php

$sql     = '
DELETE 
   `co_invoices` 
WHERE
   `inv_id` = 4
';
$success = $connection->execute($sql);
```

SQL Bruto

```php
<?php

$sql     = '
DELETE 
   `co_invoices` 
WHERE
   `inv_id` = ?
';
$success = $connection->execute(
    $sql, 
    [
        4
    ]
);
```

Marcadores de posición

```php
<?php

$success = $connection->delete(
    'co_invoices',
    'inv_id = ?',
    [
        4,
    ]
);
```

Generación dinámica

## Parámetros

Los adaptadores `Phalcon\Db` proporcionan varios métodos para consultar filas desde tablas. En este caso se necesita la sintaxis SQL especifica para el motor de base de datos destino:

```php
<?php

$sql = '
SELECT 
    inv_id,
    inv_title
FROM 
    co_invoices
ORDER BY 
    inv_created_at
';
$result = $connection->query($sql);
while ($invoice = $result->fetch()) {
   echo $invoice['inv_title'];
}

$invoices = $connection->fetchAll($sql);
foreach ($invoices as $invoice) {
   echo $invoice['inv_title'];
}

$invoice = $connection->fetchOne($sql);
```

Por defecto estas llamadas crean vectores tanto con índices asociativos como numéricos. Puede cambiar este comportamiento usando `Phalcon\Db\Result::setFetchMode()`. Este método recibe una constante, que define qué tipo de índice se necesita.

| Constante                        | Descripción                                                  |
| -------------------------------- | ------------------------------------------------------------ |
| `Phalcon\Db\Enum::FETCH_NUM`   | Devuelve un vector con índices numéricos                     |
| `Phalcon\Db\Enum::FETCH_ASSOC` | Devuelve un vector con índices asociativos                   |
| `Phalcon\Db\Enum::FETCH_BOTH`  | Devuelve un vector con ambos índices asociativos y numéricos |
| `Phalcon\Db\Enum::FETCH_OBJ`   | Devuelve un objeto en vez de un vector                       |

```php
<?php

$sql = '
SELECT 
    inv_id,
    inv_title
FROM 
    co_invoices
ORDER BY 
    inv_created_at
';
$result = $connection->query($sql);

$result->setFetchMode(
    Phalcon\Db\Enum::FETCH_NUM
);

while ($invoice = $result->fetch()) {
   echo $invoice[0];
}
```

El método `query()` devuelve una instancia de [Phalcon\Db\Result\Pdo](api/phalcon_db#db-result-pdo). Estos objetos encapsulan toda la funcionalidad relativa a el conjunto de resultados devuelto, ej. recorrer, buscar registros específicos, contar, etc.

```php
<?php

$sql = '
SELECT 
    inv_id,
    inv_title
FROM 
    co_invoices
ORDER BY 
    inv_created_at
';
$result = $connection->query($sql);

while ($invoice = $result->fetch()) {
   echo $invoice['name'];
}

$result->seek(2);

$invoice = $result->fetch();

echo $result->numRows();
```

### Enlazar

Los parámetros enlazados también se soportan. Aunque hay un impacto mínimo en el rendimiento al usar parámetros enlazados, se recomienda encarecidamente usar esta metodología para eliminar la posibilidad de que su código sea sujeto de ataques de inyección SQL. Se soportan tanto cadenas como marcadores de posición.

```php
<?php

$sql = '
SELECT 
    inv_id,
    inv_title
FROM 
    co_invoices
WHERE
    inv_cst_id = ?
ORDER BY 
    inv_created_at
';

$result = $connection->query(
    $sql,
    [
        4,
    ]
);
```

Enlazando con marcadores de posición numéricos

```php
<?php

$sql     = "
UPDATE 
    `co_invoices` 
SET 
    `inv_cst_id`= :cstId, 
    `inv_title` = :title
WHERE
    `inv_id` = :id
";
$success = $connection->query(
    $sql,
    [
        'cstId' => 1,
        'title' => 'Invoice for ACME Inc.',
        'id'    => 4,
    ]
);
```

Enlazando con marcadores de posición nombrados

Cuando se usan marcadores de posición numéricos, necesitará definirlos como enteros, ej. `1` o `2`. En este caso `'1'` o `'2'` se consideran cadenas y no números, con lo que el marcador de posición no se podría reemplazar correctamente. Con cualquier adaptador, los datos se escapan automáticamente usando [PDO Quote](https://www.php.net/manual/en/pdo.quote.php). Esta función tiene en cuenta el conjunto de caracteres de la conexión, por lo que se recomienda definir el conjunto de caracteres correcto en los parámetros de conexión o en su configuración del servidor de base de datos, ya que un conjunto de caracteres incorrecto producirá efectos no deseados al almacenar o recuperar datos.

Además, puede pasar sus parámetros directamente a los métodos `execute` o `query`. En este caso los parámetros enlazados se pasan directamente a PDO:

```php
<?php

$sql = '
SELECT 
    inv_id,
    inv_title
FROM 
    co_invoices
WHERE
    inv_cst_id = ?
ORDER BY 
    inv_created_at
';

$result = $connection->query(
    $sql,
    [
        1 => 4,
    ]
);
```

Enlazando con marcadores de posición PDO

### Tipado

Los marcadores de posición le permiten enlazar parámetros para evitar inyecciones SQL:

```php
<?php

$phql = '
SELECT 
    inv_id,
    inv_title
FROM 
    Invoices
WHERE
    inv_cst_id = :customerId:
ORDER BY 
    inv_created_at
';

$invoices = $this
    ->modelsManager
    ->executeQuery(
        $phql,
        [
            'customerId' => 4,
        ]
    )
;
```

Sin embargo, algunos sistemas de base de datos requieren acciones adicionales cuando se usan marcadores de posición como especificar el tipo del parámetro enlazado:

```php
<?php

use Phalcon\Db\Column;

// ...

$phql = '
SELECT 
    inv_id,
    inv_title
FROM 
    Invoices
WHERE
    inv_cst_id = :customerId:
ORDER BY 
    inv_created_at
';

$invoices = $this
    ->modelsManager
    ->executeQuery(
        $phql,
        [
            'customerId' => 4,
        ],
        Column::BIND_PARAM_INT
    )
;
```

Puede usar marcadores de posición tipados en sus parámetros, en vez de especificar el tipo de enlace en `executeQuery()`:

```php
<?php

$phql = '
SELECT 
    inv_id,
    inv_title
FROM 
    Invoices
WHERE
    inv_cst_id = {customerId:int}
ORDER BY 
    inv_created_at
';

$invoices = $this
    ->modelsManager
    ->executeQuery(
        $phql,
        [
            'customerId' => 4,
        ],
    )
;

$phql = '
SELECT 
    inv_id,
    inv_title
FROM 
    Invoices
WHERE
    inv_title <> {title:str}
ORDER BY 
    inv_created_at
';

$invoices = $this
    ->modelsManager
    ->executeQuery(
        $phql,
        [
            'title' => 'Invoice for ACME Inc',
        ],
    )
;
```

También puede omitir el tipo si no necesita especificarlo:

```php
<?php

$phql = '
SELECT 
    inv_id,
    inv_title
FROM 
    Invoices
WHERE
    inv_cst_id = {customerId}
ORDER BY 
    inv_created_at
';

$invoices = $this
    ->modelsManager
    ->executeQuery(
        $phql,
        [
            'customerId' => 4,
        ],
    )
;
```

Los marcadores de posición tipados también son más poderosos, ya que ahora podemos enlazar un vector estático sin tener que pasar cada elemento independientemente como marcador de posición:

```php
<?php

$phql = '
SELECT 
    inv_id,
    inv_title
FROM 
    Invoices
WHERE
    inv_cst_id IN ({ids:array})
ORDER BY 
    inv_created_at
';

$invoices = $this
    ->modelsManager
    ->executeQuery(
        $phql,
        [
            'ids' => [1, 3, 5],
        ],
    )
;
```

Están disponibles los siguientes tipos:

| Tipo de enlace | Constante de Tipo de Enlace        | Ejemplo             |
| -------------- | ---------------------------------- | ------------------- |
| str            | `Column::BIND_PARAM_STR`           | `{name:str}`        |
| int            | `Column::BIND_PARAM_INT`           | `{number:int}`      |
| double         | `Column::BIND_PARAM_DECIMAL`       | `{price:double}`    |
| bool           | `Column::BIND_PARAM_BOOL`          | `{enabled:bool}`    |
| blob           | `Column::BIND_PARAM_BLOB`          | `{image:blob}`      |
| null           | `Column::BIND_PARAM_NULL`          | `{exists:null}`     |
| array          | Vector de `Column::BIND_PARAM_STR` | `{codes:array}`     |
| array-str      | Vector de `Column::BIND_PARAM_STR` | `{names:array-str}` |
| array-int      | Vector de `Column::BIND_PARAM_INT` | `{flags:array-int}` |

### Cambio de Tipo

Por defecto, los parámetros enlazados no se convierten en el área de usuario de PHP a los tipos de enlace especificados. Esta opción le permite hacer que Phalcon convierta los valores antes de enlazarlos con PDO. Un escenario común es pasar una cadena en un marcador de posición `LIMIT`/`OFFSET`:

```php
<?php

$number = '100';
$phql   = '
SELECT 
    inv_id,
    inv_title
FROM 
    Invoices
LIMIT 
    {number:int}
';

$invoices = $modelsManager->executeQuery(
    $phql,
    [
        'number' => $number,
    ]
);
```

Esto causa la siguiente excepción:

    Fatal error: Uncaught exception 'PDOException' with message 
    'SQLSTATE[42000]: Syntax error or access violation: 1064. 
    You have an error in your SQL syntax; check the manual that 
    corresponds to your MySQL server version for the right
    syntax to use near ''100'' at line 1' in ....
    

Esto ocurre porque `'100'` es una variable cadena. Es fácil de arreglar al convertir primero el valor a entero:

```php
<?php

$number = '100';
$phql   = '
SELECT 
    inv_id,
    inv_title
FROM 
    Invoices
LIMIT 
    {number:int}
';

$invoices = $modelsManager->executeQuery(
    $phql,
    [
        'number' => (int) $number,
    ]
);
```

Sin embargo, esta solución requiere que el desarrollador ponga especial atención sobre cómo se pasan los parámetros enlazados y sus tipos. Para facilitar la tarea y evitar excepciones inesperadas puede instruir a Phalcon para que haga la conversión de tipos por usted:

```php
<?php

\Phalcon\Db::setup(
    [
        'forceCasting' => true,
    ]
);
```

Las siguientes acciones se realizan de acuerdo al tipo de enlace especificado:

| Tipo de enlace               | Acción                                                          |
| ---------------------------- | --------------------------------------------------------------- |
| `Column::BIND_PARAM_STR`     | Convierte el valor como una cadena PHP nativa                   |
| `Column::BIND_PARAM_INT`     | Convierte el valor como un entero PHP nativo                    |
| `Column::BIND_PARAM_BOOL`    | Convierte el valor como un booleano PHP nativo                  |
| `Column::BIND_PARAM_DECIMAL` | Convertir el valor como un número de doble precisión PHP nativo |

### Hidración

Los valores devueltos del sistema de base de datos siempre se representan como valores cadena por el PDO, no importa si el valor pertenece a una columna de tipo `numérico` o `booleano`. Esto ocurre porque algunos tipos de columna no se pueden representar con sus correspondientes tipos nativos de PHP debido a sus limitaciones de tamaño. Por ejemplo, un `BIGINT` en MySQL puede almacenar números enteros que no se pueden representar como un entero de 32bit en PHP. Por eso, PDO y ORM por defecto, toman la decisión segura de dejar todos los valores como cadenas.

Puede configurar el ORM para que automáticamente convierta aquellos tipos a sus correspondientes tipos nativos de PHP:

```php
<?php

use Phalcon\Mvc\Model;

Model::setup(
    [
        'castOnHydrate' => true,
    ]
);
```

De esta forma puede usar operaciones estrictas o hacer suposiciones sobre el tipo de las variables:

```php
<?php

$invoice = Invoices::findFirst();
if (11 === $invoice->inv_id) {
    echo $invoice->inv_title;
}
```

> **NOTA**: Si desea devolver la clave primaria cuando use `lastInsertId` como un `integer`, puede usar la característica `castLastInsertIdToInt => true` en el modelo.
{: .alert .alert-info }

## Transacciones

Se soporta trabajar con transacciones de la misma manera que como con PDO. Usar transacciones incrementa el rendimiento en la mayoría de sistemas de base de datos y también asegura la integridad de los datos:

```php
<?php

try {
    $connection->begin();

    $connection->execute('DELETE `co_invoices` WHERE `inv_id` = 1');
    $connection->execute('DELETE `co_invoices` WHERE `inv_id` = 2');
    $connection->execute('DELETE `co_invoices` WHERE `inv_id` = 3');

    $connection->commit();
} catch (Exception $e) {
    $connection->rollback();
}
```

Además de las transacciones estándar, los adaptadores ofrecen soporte integrado para [transactiones anidadas](https://en.wikipedia.org/wiki/Nested_transaction), si el sistema de base de datos usado las soporta. Cuando llama `begin()` por segunda vez se crea una transacción anidada:

```php
<?php

try {
    $connection->begin();

    $connection->execute('DELETE `co_invoices` WHERE `inv_id` = 1');

    try {
        $connection->begin();

        $connection->execute('DELETE `co_invoices` WHERE `inv_id` = 2');
        $connection->execute('DELETE `co_invoices` WHERE `inv_id` = 3');

        $connection->commit();
    } catch (Exception $e) {
        $connection->rollback();
    }

    $connection->execute('DELETE `co_invoices` WHERE `inv_id` = 4');

    $connection->commit();
} catch (Exception $e) {
    // An exception has occurred rollback the transaction
    $connection->rollback();
}
```

## Eventos

Los adaptadores también envían eventos a un [Gestor de Eventos](events) si está presente. Si un evento devuelve `false` puede detener la operación actual. Se soportan los siguientes eventos:

| Nombre de Evento      | Disparado                              | Puede detenerse |
| --------------------- | -------------------------------------- |:---------------:|
| `afterQuery`          | Después de ejecutar una consulta       |       No        |
| `beforeQuery`         | Antes de ejecutar una consulta         |       Si        |
| `beginTransaction`    | Antes de iniciar una transacción       |       No        |
| `createSavepoint`     | Antes de crear un punto de guardado    |       No        |
| `commitTransaction`   | Antes de confirmar una transacción     |       No        |
| `releaseSavepoint`    | Antes de lanzar un punto de guardado   |       No        |
| `rollbackTransaction` | Antes de deshacer una transacción      |       No        |
| `rollbackSavepoint`   | Antes de deshacer un punto de guardado |       No        |

Si enlaza un [Gestor de Eventos](events) a la conexión de base de datos, se activarán y dispararán todos los eventos con el tipo `db` para los oyentes relevantes.

```php
<?php

use Phalcon\Events\Manager;
use Phalcon\Db\Adapter\Pdo\Mysql;

$manager = new Manager();

$manager->attach('db', $listener);

$connection = new Mysql(
    [
        'host'     => 'localhost',
        'username' => 'root',
        'password' => 'secret',
        'dbname'   => 'tutorial',
    ]
);

$connection->setEventsManager($manager);
```

Puede usar el poder de estos eventos para proteger su aplicación de operaciones SQL peligrosas.

```php
<?php

use Phalcon\Events\Event;

$manager->attach(
    'db:beforeQuery',
    function (Event $event, $connection) {
        $sql = $connection->getSQLStatement();

        if (true === preg_match('/DROP|ALTER/i', $sql)) {
            return false;
        }

        return true;
    }
);
```

## Perfilado

El adaptador incluye el componente [Phalcon\Db\Profiler](api/phalcon_db#db-profiler), que se usa para analizar el rendimiento de operaciones de base de datos para diagnosticar problemas de rendimiento y descubrir cuellos de botella.

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager;
use Phalcon\Db\Profiler;

$manager  = new Manager();
$profiler = new Profiler();

$manager->attach(
    'db',
    function (Event $event, $connection) use ($profiler) {
        if ($event->getType() === 'beforeQuery') {
            $sql = $connection->getSQLStatement();
            $profiler->startProfile($sql);
        }

        if ($event->getType() === 'afterQuery') {
            $profiler->stopProfile();
        }
    }
);

$connection->setEventsManager($manager);

$sql = '
SELECT 
    inv_id,
    inv_title
FROM 
    co_invoices
';
$connection->query($sql);

$profile = $profiler->getLastProfile();

echo 'SQL Statement: ', $profile->getSQLStatement(), PHP_EOL,
     'Start Time: ', $profile->getInitialTime(), PHP_EOL,
     'Final Time: ', $profile->getFinalTime(), PHP_EOL,
     'Total Elapsed Time: ', $profile->getTotalElapsedSeconds(), PHP_EOL;
```

También puede crear su propia clase de perfil basada en la clase [Phalcon\Db\Profiler](api/phalcon_db#db-profiler) para grabar estadísticas en tiempo real de las sentencias que se envían a la base de datos:

```php
<?php

use Phalcon\Events\Manager;
use Phalcon\Db\Profiler;
use Phalcon\Db\Profiler\Item;

class DbProfiler extends Profiler
{
    public function beforeStartProfile(Item $profile)
    {
        echo $profile->getSQLStatement();
    }

    public function afterEndProfile(Item $profile)
    {
        echo $profile->getTotalElapsedSeconds();
    }
}

$manager  = new Manager();
$listener = new DbProfiler();

$manager->attach('db', $listener);
```

## Registro

Usar componentes de abstracción de alto nivel como los adaptadores `Phalcon\Db` para acceder a la base de datos, hace difícil entender qué sentencias se envían al sistema de base de datos. El componente [Phalcon\Logger](logger) interactúa con los adaptadores `Phalcon\Db` ofreciendo capacidades de registro en el nivel de abstracción de base de datos.

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Events\Manager;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;

$adapter = new Stream('/storage/logs/queries.log');
$logger  = new Logger(
    'messages',
    [
        'main' => $adapter,
    ]
);

$manager = new Manager();

$manager->attach(
    'db:beforeQuery',
    function (Event $event, $connection) use ($logger) {
        $sql = $connection->getSQLStatement();

        $logger->info(
            sprintf(
                '%s - [%s]',
                $connection->getSQLStatement(),
                json_encode($connection->getSQLVariables())
            )
        );
    }
);

$connection->setEventsManager($manager);

$connection->insert(
    'products',
    [
        'Hot pepper',
        3.50,
    ],
    [
        'name',
        'price',
    ]
);
$connection->insert(
    'co_invoices',
    [
        1,
        'Invoice for ACME Inc.',
    ],
    [
        'inv_cst_id',
        'inv_title', 
    ]
);
```

Como en el ejemplo anterior, el fichero `/storage/logs/queries.log` contendrá algo similar a:

    [2019-12-25 01:02:03][INFO] INSERT INTO `co_invoices` 
        SET (`inv_cst_id`, `inv_title`) 
        VALUES (1, 'Invoice for ACME Inc.')
    

El oyente también trabajará con modelos y sus operaciones. También incluirá todos los parámetros enlazados que use la consulta al final de la sentencia registrada.

    [2019-12-25 01:02:03][INFO] SELECT `co_customers`.`cst_id`, 
        ...,
        FROM `co_customers` 
        WHERE LOWER(`co_customers`.`cst_email`) = :cst_email 
        LIMIT :APL0 - [{"emp_email":"team@phalcon.ld","APL0":1}]
    

## Tablas

### Describir

Los adaptadores `Phalcon\Db` también proporcionan métodos para obtener información detallada sobre tablas y vistas:

```php
<?php

$tables = $connection->listTables('gonano');
```

Obtiene las tablas de la base de datos `gonano`

```php
<?php

$exists = $connection->tableExists('co_invoices');
```

¿Comprueba si hay una tabla llamada `co_invoices` en la base de datos?

```php
<?php

$fields = $connection->describeColumns('co_invoices');
foreach ($fields as $field) {
    echo 'Column Type: ', $field['Type'];
}
```

Imprime el nombre y los tipos de datos de la tabla `co_invoices`

```php
<?php

$indexes = $connection->describeIndexes('co_invoices');
foreach ($indexes as $index) {
    print_r(
        $index->getColumns()
    );
}
```

Imprime los índices de la tabla `co_invoices`

```php
<?php

$references = $connection->describeReferences('co_invoices');
foreach ($references as $reference) {
    print_r(
        $reference->getReferencedColumns()
    );
}
```

Imprime las claves ajenas en la tabla `co_invoices`

Una descripción de tabla es muy similar al comando de MySQL `DESCRIBE`, contiene la siguiente información:

| Campo            | Tipo            | Clave                                                   | Null                               |
| ---------------- | --------------- | ------------------------------------------------------- | ---------------------------------- |
| Nombre del campo | Tipo de Columna | ¿La columna forma parte de una clave primaria o índice? | ¿Permite la columna valores nulos? |

También se han implementado métodos para obtener información sobre vistas para cada sistema de base de datos soportado:

```php
<?php

$tables = $connection->listViews('gonano');
```

Obtiene vistas en la base de datos `gonano`

```php
<?php

$exists = $connection->viewExists('vw_invoices');
```

Comprueba si hay una vista `vw_invoices` en la base de datos

### Crear

Diferentes sistemas de base de datos (MySQL, Postgresql etc.) ofrecen la capacidad de crear, alterar o eliminar tablas cuando se usan comandos como `CREATE`, `ALTER` o `DROP`. La sintaxis SQL difiere en base al sistema de base de datos usado. Los adaptadores `Phalcon\Db` ofrecen un interfaz unificado para alterar tablas, sin necesidad de diferenciar la sintaxis SQL basada en el sistema de almacenamiento de destino.

A continuación se muestra un ejemplo de como crear una tabla:

```php
<?php

use \Phalcon\Db\Column as Column;

$connection->createTable(
    'co_invoices',
    null,
    [
       'columns' => [
            new Column(
                'inv_id',
                [
                    'type'          => Column::TYPE_INTEGER,
                    'size'          => 10,
                    'notNull'       => true,
                    'autoIncrement' => true,
                    'primary'       => true,
                ]
            ),
            new Column(
                'inv_cst_id',
                [
                    'type'    => Column::TYPE_INTEGER,
                    'size'    => 11,
                    'notNull' => true,
                ]
            ),
            new Column(
                'inv_title',
                [
                    'type'    => Column::TYPE_VARCHAR,
                    'size'    => 100,
                    'notNull' => true,
                ]
            ),
        ]
    ]
);
```

El método `createTable` acepta un vector asociativo que describe la tabla. Las columnas se definen con la clase [Phalcon\Db\Column](api/phalcon_db#db-column). La tabla siguiente muestra las opciones disponibles para definir una columna:

| Opción          | Descripción                                                                                                                | Opcional |
| --------------- | -------------------------------------------------------------------------------------------------------------------------- |:--------:|
| `after`         | La columna debe colocarse después de la columna indicada                                                                   |    Si    |
| `autoIncrement` | Indica si esta columna será autoincrementada por la base de datos. Sólo una columna en la tabla puede tener este atributo. |    Si    |
| `bind`          | Una de las constantes `BIND_TYPE_*` indica como se debe enlazar la columna antes de guardarla                              |    Si    |
| `default`       | Valor predeterminado (cuando se usa con `'notNull' => true`).                                                           |    Si    |
| `first`         | La columna se debe colocar en la primera posición en el orden de columna                                                   |    Si    |
| `notNull`       | La columna puede almacenar valores nulos                                                                                   |    Si    |
| `primary`       | `true` si la columna forma parte de la clave primaria de la tabla                                                          |    Si    |
| `scale`         | Columnas `DECIMAL` o `NUMBER` pueden tener una escala para especificar cuántos decimales deben almacenar                   |    Si    |
| `size`          | Algunos tipos de columnas como `VARCHAR` o `INTEGER` pueden tener un tamaño específico                                     |    Si    |
| `type`          | Tipo de columna. Debe ser una constante [Phalcon\Db\Column](api/phalcon_db#db-column) (ver lista de abajo)               |    No    |
| `unsigned`      | Las columnas `INTEGER` pueden ser `signed` o `unsigned`. Esta opción no se aplica a otros tipos de columnas                |    Si    |

Se soportan por los adaptadores los siguientes tipos de columnas de base de datos:

* `Phalcon\Db\Column::TYPE_INTEGER`
* `Phalcon\Db\Column::TYPE_DATE`
* `Phalcon\Db\Column::TYPE_VARCHAR`
* `Phalcon\Db\Column::TYPE_DECIMAL`
* `Phalcon\Db\Column::TYPE_DATETIME`
* `Phalcon\Db\Column::TYPE_CHAR`
* `Phalcon\Db\Column::TYPE_TEXT`

El vector asociativo pasado en `createTable()` puede tener las siguientes claves:

| Índice       | Descripción                                                                                                   | Opcional |
| ------------ | ------------------------------------------------------------------------------------------------------------- |:--------:|
| `columns`    | Un vector con columnas definidas con [Phalcon\Db\Column](api/phalcon_db#db-column)                          |    No    |
| `indexes`    | Un vector con índices definidos con [Phalcon\Db\Index](api/phalcon_db#db-index)                             |    Si    |
| `references` | Un vector con referencias (claves ajenas) definidas con [Phalcon\Db\Reference](api/phalcon_db#db-reference) |    Si    |
| `options`    | Un vector con opciones de creación. (específicas al sistema de base de datos)                                 |    Si    |

### Alterar

A medida que su aplicación crece, podría necesitar alterar su base de datos, como parte de una refactorización o añadido de nuevas características. No todos los sistemas de base de datos permiten modificar columnas existentes o añadir columnas entre dos de las existentes. [Phalcon\Db](api/phalcon_db#db-column) está limitado por estas restricciones.

```php
<?php

use Phalcon\Db\Column as Column;

$connection->addColumn(
    'co_invoices',
    null,
    new Column(
        'inv_status_flag',
        [
            'type'    => Column::TYPE_INTEGER,
            'size'    => 1,
            'notNull' => true,
            'default' => 0,
            'after'   => 'inv_cst_id',
        ]
    )
);


$connection->modifyColumn(
    'co_invoices',
    null,
    new Column(
        'inv_status_flag',
        [
            'type'    => Column::TYPE_INTEGER,
            'size'    => 2,
            'notNull' => true,
        ]
    )
);

$connection->dropColumn(
    'co_invoices',
    null,
    'inv_status_flag'
);
```

### Eliminar

Para eliminar una tabla existente de la base de datos actual, use el método `dropTable`. Para eliminar una tabla de una base de datos personalizada, puede usar el segundo parámetro para establecer el nombre de base de datos.

```php
<?php

$connection->dropTable('co_invoices');
```

Elimina la tabla `co_invoices` de la base de datos activa

```php
<?php

$connection->dropTable('co_invoices', 'gonano');
```

Elimina la tabla `co_invoices` de la base de datos `gonano`
