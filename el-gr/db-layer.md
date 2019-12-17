---
layout: default
language: 'el-gr'
version: '4.0'
title: 'Database Abstraction Layer'
keywords: 'db, dbal, phql, database, mysql, postgresql, sqlite'
---

# Database Abstraction Layer

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Επισκόπηση

The components under the `Phalcon\Db` namespace are the ones responsible for powering the [Phalcon\Mvc\Model](api/phalcon_mvc#mvc-model) class - the `Model` in MVC for the framework. It consists of an independent high-level abstraction layer for database systems completely written in C.

This component allows for a lower level database manipulation than using traditional models.

## Adapters

This component makes use of adapters to encapsulate specific database system details. Phalcon uses PDO to connect to databases. The following database engines are supported:

| Class                                                                             | Περιγραφή                                                                                                                                                                                                                            |
| --------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| [Phalcon\Db\Adapter\Pdo\Mysql](api/phalcon_db#db-adapter-pdo-mysql)           | Is the world's most used relational database management system (RDBMS) that runs as a server providing multi-user access to a number of databases                                                                                    |
| [Phalcon\Db\Adapter\Pdo\Postgresql](api/phalcon_db#db-adapter-pdo-postgresql) | PostgreSQL is a powerful, open source relational database system. It has more than 15 years of active development and a proven architecture that has earned it a strong reputation for reliability, data integrity, and correctness. |
| [Phalcon\Db\Adapter\Pdo\Sqlite](api/phalcon_db#db-adapter-pdo-sqlite)         | SQLite is a software library that implements a self-contained, serverless, zero-configuration, transactional SQL database engine                                                                                                     |

### Constants

The [Phalcon\Db\Enum](api/phalcon_db#db-enum) class exposes a number of constants that can be used on the DB layer. - `FETCH_ASSOC` = `\Pdo::FETCH_ASSOC` - `FETCH_BOTH` = `\Pdo::FETCH_BOTH` - `FETCH_BOUND` = `\Pdo::FETCH_BOUND` - `FETCH_CLASS` = `\Pdo::FETCH_CLASS` - `FETCH_CLASSTYPE` = `\Pdo::FETCH_CLASSTYPE` - `FETCH_COLUMN` = `\Pdo::FETCH_COLUMN` - `FETCH_FUNC` = `\Pdo::FETCH_FUNC` - `FETCH_GROUP` = `\Pdo::FETCH_GROUP` - `FETCH_INTO` = `\Pdo::FETCH_INTO` - `FETCH_KEY_PAIR` = `\Pdo::FETCH_KEY_PAIR` - `FETCH_LAZY` = `\Pdo::FETCH_LAZY` - `FETCH_NAMED` = `\Pdo::FETCH_NAMED` - `FETCH_NUM` = `\Pdo::FETCH_NUM` - `FETCH_OBJ` = `\Pdo::FETCH_OBJ` - `FETCH_PROPS_LATE` = `\Pdo::FETCH_PROPS_LATE` - `FETCH_SERIALIZE` = `\Pdo::FETCH_SERIALIZE` - `FETCH_UNIQUE` = `\Pdo::FETCH_UNIQUE`

Additional constants are available in the [Phalcon\Db\Column](api/phalcon_db#db-column) object. This object is used to describe a column (or field) in a database table. These constants also define which types are supported by the ORM.

**Bind Types**

* `BIND_PARAM_BLOB` - Blob
* `BIND_PARAM_BOOL` - Bool
* `BIND_PARAM_DECIMAL` - Decimal
* `BIND_PARAM_INT` - Integer
* `BIND_PARAM_NULL` - Null
* `BIND_PARAM_STR` - String
* `BIND_SKIP` - Skip binding

**Column Types**

* `TYPE_BIGINTEGER` - Big integer
* `TYPE_BIT` - Bit
* `TYPE_BLOB` - Blob
* `TYPE_BOOLEAN` - Boolean
* `TYPE_CHAR` - Char
* `TYPE_DATE` - Date
* `TYPE_DATETIME` - Datetime
* `TYPE_DECIMAL` - Decimal
* `TYPE_DOUBLE` - Double
* `TYPE_ENUM` - Enum
* `TYPE_FLOAT` - Float
* `TYPE_INTEGER` - Integer
* `TYPE_JSON` - JSON
* `TYPE_JSONB` - JSONB
* `TYPE_LONGBLOB` - Long Blob
* `TYPE_LONGTEXT` - Long Text
* `TYPE_MEDIUMBLOB` - Medium Blob
* `TYPE_MEDIUMINTEGER` - Medium Integer
* `TYPE_MEDIUMTEXT` - Medium Text
* `TYPE_SMALLINTEGER` - Small Integer
* `TYPE_TEXT` - Text
* `TYPE_TIME` - Time
* `TYPE_TIMESTAMP` - Timestamp
* `TYPE_TINYBLOB` - Tiny Blob
* `TYPE_TINYINTEGER` - Tiny Integer
* `TYPE_TINYTEXT` - Tiny Text
* `TYPE_VARCHAR` - Varchar

> **NOTE**: Depending on your RDBMS, certain types will not be available (e.g. `JSON` is not supported for Sqlite).
{: .alert .alert-info }

### Methods

```php
public function addColumn(
    string $tableName, 
    string $schemaName, 
    ColumnInterface $column
): bool
```

Adds a column to a table

```php
public function addIndex(
    string $tableName, 
    string $schemaName,
    IndexInterface $index
): bool
```

Adds an index to a table

```php
public function addForeignKey(
    string $tableName, 
    string $schemaName, 
    ReferenceInterface $reference
): bool
```

Adds a foreign key to a table

```php
public function addPrimaryKey(
    string $tableName, 
    string $schemaName, 
    IndexInterface $index
): bool
```

Adds a primary key to a table

```php
public function affectedRows(): int
```

Returns the number of affected rows by the last `INSERT`/`UPDATE`/`DELETE` reported by the database system

```php
public function begin(
    bool $nesting = true
): bool
```

Starts a transaction in the connection

```php
public function close(): bool
```

Closes active connection returning success. Phalcon automatically closes and destroys active connections

```php
public function commit(
    bool $nesting = true
): bool
```

Commits the active transaction in the connection

```php
public function connect(
    array $descriptor = null
): bool
```

This method is automatically called in [Phalcon\Db\Adapter\Pdo\AbstractPdo](api/phalcon_db#db-adapter-pdo-abstractpdo) constructor. Call it when you need to restore a database connection

```php
public function createSavepoint(
    string $name
): bool
```

Creates a new savepoint

public function createTable( string $tableName, string $schemaName, array $definition ): bool

    Creates a table
    
    ```php
    public function createView(
        string $viewName, 
        array $definition, 
        string $schemaName = null
    ): bool
    

Creates a view

```php
public function delete(
    mixed $table, 
    mixed $whereCondition = null, 
    mixed $placeholders = null, 
    mixed $dataTypes = null
): bool
```

Deletes data from a table using custom RDBMS SQL syntax

```php
public function describeColumns(
    string $table, 
    string $schema = null
): ColumnInterface[]
```

Returns an array of Phalcon\Db\Column objects describing a table

```php
public function describeIndexes(
    string $table, 
        string $schema = null
): IndexInterface[]
```

Lists table indexes

```php
public function describeReferences(
    string $table, 
    string $schema = null
): ReferenceInterface[]
```

Lists table references

```php
public function dropColumn(
    string $tableName, 
    string $schemaName, 
    string $columnName
): bool
```

Drops a column from a table

```php
public function dropForeignKey(
    string $tableName, 
    string $schemaName, 
    string $referenceName
): bool
```

Drops a foreign key from a table

```php
public function dropIndex(
    string $tableName, 
    string $schemaName, 
    string $indexName
): bool
```

Drop an index from a table

```php
public function dropPrimaryKey(
    string $tableName, 
    string $schemaName
): bool
```

Drops primary key from a table

```php
public function dropTable(
    string $tableName, 
    string $schemaName = null, 
    bool $ifExists = true
): bool
```

Drops a table from a schema/database

```php
public function dropView(
    string $viewName, 
    string $schemaName = null, 
    bool $ifExists = true
): bool
```

Drops a view

```php
public function escapeIdentifier(
    mixed identifier
): string
```

Escapes a column/table/schema name

```php
public function escapeString(string $str): string
```php
Escapes a value to avoid SQL injections

```php
public function execute(
    string $sqlStatement, 
    mixed $placeholders = null, 
    mixed $dataTypes = null
): bool
```

Sends SQL statements to the database server returning the success state. Use this method only when the SQL statement sent to the server does not return any rows

```php
public function fetchAll(
    string $sqlQuery, 
    int $fetchMode = 2, 
    mixed $placeholders = null
): array
```

Dumps the complete result of a query into an array

```php
public function fetchColumn(
    string $sqlQuery, 
    array $placeholders = [], 
    mixed $column = 0
): string | bool
```

Returns the n'th field of first row in a SQL query result

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

Returns the first row in a SQL query result

```php
public function forUpdate(
    string $sqlQuery
): string
```

Returns a SQL modified with a FOR UPDATE clause

```php
public function getColumnDefinition(
    ColumnInterface $column
): string
```

Returns the SQL column definition from a column

```php
public function getColumnList(
    mixed $columnList
): string
```

Gets a list of columns

```php
public function getConnectionId(): string
```

Gets the active connection unique identifier

```php
public function getDescriptor(): array
```

Return descriptor used to connect to the active database

```php
public function getDialect(): DialectInterface
```

Returns internal dialect instance

```php
public function getDialectType(): string
```

Returns the name of the dialect used

```php
public function getDefaultIdValue(): RawValue
```

Return the default identity value to insert in an identity column

```php
public function getInternalHandler(): \PDO
```

Return internal PDO handler

```php
public function getNestedTransactionSavepointName(): string
```

Returns the savepoint name to use for nested transactions

```php
public function getRealSQLStatement(): string
```

Active SQL statement in the object without replace bound parameters

```php
public function getSQLStatement(): string
```

Active SQL statement in the object

```php
public function getSQLBindTypes(): array
```

Active SQL statement in the object

```php
public function getSQLVariables(): array
```

Active SQL statement in the object

```php
public function getType(): string
```

Returns type of database system the adapter is used for

```php
public function insert(
    string $table, 
    array $values, 
    mixed $fields = null, 
    mixed $dataTypes = null
): bool
```

Inserts data into a table using custom RDBMS SQL syntax

```php
public function insertAsDict(
    string $table, 
    mixed $data, 
    mixed $dataTypes = null
): bool
```

Inserts data into a table using custom RBDM SQL syntax

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

Returns if nested transactions should use savepoints

```php
public function isUnderTransaction(): bool
```

Checks whether connection is under database transaction

```php
public function lastInsertId(
    mixed $sequenceName = null
)
```

Returns insert id for the auto_increment column inserted in the last SQL statement

```php
public function limit(
    string $sqlQuery, 
    int $number
): string
```

Appends a LIMIT clause to sqlQuery argument

```php
public function listTables(
    string $schemaName = null
): array
```

List all tables on a database

```php
public function listViews(
    string $schemaName = null
): array
```

List all views on a database

```php
public function modifyColumn(
    string $tableName, 
    string $schemaName, 
    ColumnInterface $column, 
    ColumnInterface $currentColumn = null
): bool
```

Modifies a table column based on a definition

```php
public function query(
    string $sqlStatement, 
    mixed $placeholders = null, 
    mixed $dataTypes = null
): ResultInterface | bool
```

Sends SQL statements to the database server returning the success state. Use this method only when the SQL statement sent to the server returns rows

```php
public function releaseSavepoint(
    string $name
): bool
```

Releases given savepoint

```php
public function rollback(
    bool $nesting = true
): bool
```

Rollbacks the active transaction in the connection

```php
public function rollbackSavepoint(
    string $name
): bool
```

Rollbacks given savepoint

```php
public function sharedLock(
    string $sqlQuery
): string
```

Returns a SQL modified with a LOCK IN SHARE MODE clause

```php
public function setNestedTransactionsWithSavepoints(
    bool $nestedTransactionsWithSavepoints
): AdapterInterface
```

Set if nested transactions should use savepoints

```php
public function supportSequences(): bool
```

Check whether the database system requires a sequence to produce auto-numeric values

```php
public function tableExists(
    string $tableName, 
    string $schemaName = null
): bool
```

Generates SQL checking for the existence of a schema.table

```php
public function tableOptions(
    string $tableName, 
    string $schemaName = null
): array
```

Gets creation options from a table

```php
public function update(
    string $table, 
    mixed $fields, 
    mixed $values, 
    mixed $whereCondition = null, 
    mixed $dataTypes = null
): bool
```

Updates data on a table using custom RDBMS SQL syntax

```php
public function updateAsDict(
    string $table, 
    mixed $data, 
    mixed $whereCondition = null, 
    mixed $dataTypes = null
): bool
```

Updates data on a table using custom RBDM SQL syntax. Another, more convenient syntax

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

Check whether the database system requires an explicit value for identity columns

```php
public function viewExists(
    string $viewName, 
    string $schemaName = null
): bool
```

Generates SQL checking for the existence of a schema view

### Custom

The [Phalcon\Db\AdapterInterface](api/phalcon_db#db-adapter-adapterinterface) interface must be implemented in order to create your own database adapters or extend the existing ones. Additionally you can extend the [Phalcon\Db\AbstractAdapter](api/phalcon_db#db-adapter-abstractadapter) that already has some implementation for your custom adapter.

## Εργοστάσιο

### `newInstance()`

Although all adapter classes can be instantiated using the `new` keyword, Phalcon offers the [Phalcon\Db\Adapter\PdoFactory](api/phalcon_db#db-adapter-pdofactory) class, so that you can easily instantiate PDO adapter instances. All the above adapters are registered in the factory and lazy loaded when called. The factory allows you to register additional (custom) adapter classes. The only thing to consider is choosing the name of the adapter in comparison to the existing ones. If you define the same name, you will overwrite the built-in one. The objects are cached in the factory so if you call the `newInstance()` method with the same parameters during the same request, you will get the same object back.

The reserved names are: - `mysql` - [Phalcon\Db\Adapter\Pdo\Mysql](api/phalcon_db#db-adapter-pdo-mysql) - `postgresql` - [Phalcon\Db\Adapter\Pdo\Postgresql](api/phalcon_db#db-adapter-pdo-postgresql) - `sqlite` - [Phalcon\Db\Adapter\Pdo\Sqlite](api/phalcon_db#db-adapter-pdo-sqlite)

The example below shows how you can create a MySQL adapter with the `new` keyword or the factory:

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

use Phalcon\Db\Adapter\Pdo\PdoFactory;

$factory    = PdoFactory();
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

You can also use the `load()` method to create an adapter using a configuration object or an array. The example below uses a `ini` file to instantiate the database connection using `load()`.

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
use Phalcon\Db\Adapter\Pdo\Factory;

$container = new Di();

$config = new Ini('config.ini');

$container->set('config', $config);

$container->set(
    'db', 
    function () {
        return (new Factory())->load($this->config->database);
    }
);
```

## Dialects

### Built In

Phalcon encapsulates the specific details of each database engine in dialects. [Phalcon\Db\Dialect](api/phalcon_db#db-dialect) provides common functions and SQL generator to the adapters.

| Class                                                                    | Περιγραφή                                           |
| ------------------------------------------------------------------------ | --------------------------------------------------- |
| [Phalcon\Db\Dialect\Mysql](api/phalcon_db#db-dialect-mysql)           | SQL specific dialect for MySQL database system      |
| [Phalcon\Db\Dialect\Postgresql](api/phalcon_db#db-dialect-postgresql) | SQL specific dialect for PostgreSQL database system |
| [Phalcon\Db\Dialect\Sqlite](api/phalcon_db#db-dialect-sqlite)         | SQL specific dialect for SQLite database system     |

### Custom

The [Phalcon\Db\DialectInterface](api/phalcon_db#db-dialectinterface) interface must be implemented in order to create your own database dialects or extend the existing ones. You can also enhance your current dialect by adding more commands/methods that PHQL will understand. For instance when using the MySQL adapter, you might want to allow PHQL to recognize the `MATCH ... AGAINST ...` syntax. We associate that syntax with `MATCH_AGAINST`

We instantiate the dialect. We add the custom function so that PHQL understands what to do when it finds it during the parsing process. In the example below, we register a new custom function called `MATCH_AGAINST`. After that all we have to do is add the customized dialect object to our connection.

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
            ' MATCH (%s) AGAINST (%)',
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

We can now use this new function in PHQL, which in turn will translate it to the proper SQL syntax:

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

> **NOTE**: There are more examples on how to extend PHQL in the [PHQL](db-phql) document.
{: .alert .alert-info }

## Connect

To create a connection it's necessary instantiate the adapter class. It only requires an array with the connection parameters. The example below shows how to create a connection passing both required and optional parameters:

| Adapter      | Parameter    | Status   |
| ------------ | ------------ | -------- |
| `MySQL`      | `host`       | required |
|              | `username`   | required |
|              | `password`   | required |
|              | `dbname`     | required |
|              | `persistent` | optional |
| `PostgreSQL` | `host`       | required |
|              | `username`   | required |
|              | `password`   | required |
|              | `dbname`     | required |
|              | `schema`     | optional |
| `Sqlite`     | `dbname`     | required |

Connecting to each adapter can be achieved by either the factory as demonstrated above or by passing the relevant options to the constructor of each class.

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

**Additional PDO options**

You can set PDO options at connection time by passing the parameters `options`:

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

## Create

To insert a row in the database, you can use raw SQL or use the methods present by the adapter:

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

Raw SQL

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

Placeholders

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

Dynamic generation

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

Dynamic generation (alternative syntax)

## Update

To update a row in the database, you can use raw SQL or use the methods present by the adapter:

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

Raw SQL

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

Placeholders

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

Dynamic generation

> **NOTE**: With the syntax above, the variables for the `where` part of the `update` (`inv_id = 4`) is not escaped!
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

Dynamic generation (alternative syntax)

> **NOTE**: With the syntax above, the variables for the `where` part of the `update` (`inv_id = 4`) is not escaped!
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

With conditionals escaped

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

With conditionals escaped (alternative syntax)

## Delete

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

Raw SQL

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

Placeholders

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

Dynamic generation

## Παράμετροι

The `Phalcon\Db` adapters provide several methods to query rows from tables. The specific SQL syntax of the target database engine is required in this case:

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

By default these calls create arrays with both associative and numeric indexes. You can change this behavior by using `Phalcon\Db\Result::setFetchMode()`. This method receives a constant, defining which kind of index is required.

| Constant                         | Περιγραφή                                                 |
| -------------------------------- | --------------------------------------------------------- |
| `Phalcon\Db\Enum::FETCH_NUM`   | Return an array with numeric indexes                      |
| `Phalcon\Db\Enum::FETCH_ASSOC` | Return an array with associative indexes                  |
| `Phalcon\Db\Enum::FETCH_BOTH`  | Return an array with both associative and numeric indexes |
| `Phalcon\Db\Enum::FETCH_OBJ`   | Return an object instead of an array                      |

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

The `query()` method returns an instance of [Phalcon\Db\Result\Pdo](api/phalcon_db#db-result-pdo). These objects encapsulate all the functionality related to the returned resultset i.e. traversing, seeking specific records, count etc.

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

### Binding

Bound parameters are also supported. Although there is a minimal performance impact by using bound parameters, you are highly encouraged to use this methodology so as to eliminate the possibility of your code being subject to SQL injection attacks. Both string and positional placeholders are supported.

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

Binding with numeric placeholders

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

Binding with named placeholders

When using numeric placeholders, you will need to define them as integers i.e. `1` or `2`. In this case `'1'` or `'2'` are considered strings and not numbers, so the placeholder could not be successfully replaced. With any adapter, data are automatically escaped using [PDO Quote](https://secure.php.net/manual/en/pdo.quote.php). This function takes into account the connection charset, so its recommended to define the correct charset in the connection parameters or in your database server configuration, as a wrong charset will produce undesired effects when storing or retrieving data.

Also, you can pass your parameters directly to the `execute` or `query` methods. In this case bound parameters are directly passed to PDO:

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

Binding with PDO placeholders

### Typed

Placeholders allowed you to bind parameters to avoid SQL injections:

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

However, some database systems require additional actions when using placeholders such as specifying the type of the bound parameter:

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

You can use typed placeholders in your parameters, instead of specifying the bind type in `executeQuery()`:

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

You can also omit the type if you do not need to specify it:

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

Typed placeholders are also more powerful, since we can now bind a static array without having to pass each element independently as a placeholder:

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

The following types are available:

| Bind Type | Bind Type Constant                | Example             |
| --------- | --------------------------------- | ------------------- |
| str       | `Column::BIND_PARAM_STR`          | `{name:str}`        |
| int       | `Column::BIND_PARAM_INT`          | `{number:int}`      |
| double    | `Column::BIND_PARAM_DECIMAL`      | `{price:double}`    |
| bool      | `Column::BIND_PARAM_BOOL`         | `{enabled:bool}`    |
| blob      | `Column::BIND_PARAM_BLOB`         | `{image:blob}`      |
| null      | `Column::BIND_PARAM_NULL`         | `{exists:null}`     |
| array     | Array of `Column::BIND_PARAM_STR` | `{codes:array}`     |
| array-str | Array of `Column::BIND_PARAM_STR` | `{names:array-str}` |
| array-int | Array of `Column::BIND_PARAM_INT` | `{flags:array-int}` |

### Cast

By default, bound parameters are not casted in the PHP userland to the specified bind types. This option allows you to make Phalcon cast values before binding them with PDO. A common scenario is when passing a string to a `LIMIT`/`OFFSET` placeholder:

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

This causes the following exception:

    Fatal error: Uncaught exception 'PDOException' with message 
    'SQLSTATE[42000]: Syntax error or access violation: 1064. 
    You have an error in your SQL syntax; check the manual that 
    corresponds to your MySQL server version for the right
    syntax to use near ''100'' at line 1' in ....
    

This happens because `'100'` is a string variable. It is easily fixable by casting the value to integer first:

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

However this solution requires that the developer pays special attention about how bound parameters are passed and their types. To make this task easier and avoid unexpected exceptions you can instruct Phalcon to do this casting for you:

```php
<?php

\Phalcon\Db::setup(
    [
        'forceCasting' => true,
    ]
);
```

The following actions are performed according to the bind type specified:

| Bind Type                    | Action                                 |
| ---------------------------- | -------------------------------------- |
| `Column::BIND_PARAM_STR`     | Cast the value as a native PHP string  |
| `Column::BIND_PARAM_INT`     | Cast the value as a native PHP integer |
| `Column::BIND_PARAM_BOOL`    | Cast the value as a native PHP boolean |
| `Column::BIND_PARAM_DECIMAL` | Cast the value as a native PHP double  |

### Hydration

Values returned from the database system are always represented as string values by PDO, no matter if the value belongs to a `numeric` or `boolean` type column. This happens because some column types cannot be represented with its corresponding PHP native types due to their size limitations. For instance, a `BIGINT` in MySQL can store large integer numbers that cannot be represented as a 32bit integer in PHP. Because of that, PDO and the ORM by default, make the safe decision of leaving all values as strings.

You can set up the ORM to automatically cast those types to their corresponding PHP native types:

```php
<?php

use Phalcon\Mvc\Model;

Model::setup(
    [
        'castOnHydrate' => true,
    ]
);
```

This way you can use strict operators or make assumptions about the type of variables:

```php
<?php

$invoice = Invoices::findFirst();
if (11 === $invoice->inv_id) {
    echo $invoice->inv_title;
}
```

> **NOTE**: If you wish to return the primary key when using the `lastInsertId` as an `integer`, you can use the `castLastInsertIdToInt => true` feature on the model.
{: .alert .alert-info }

## Συναλλαγές

Working with transactions is supported the same way as with with PDO. Using transactions increases performance in most database systems and also ensures data integrity:

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

In addition to standard transactions, the adapters offer provides built-in support for [nested transactions](https://en.wikipedia.org/wiki/Nested_transaction), if the database system used supports them. When you call `begin()` for a second time a nested transaction is created:

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

## Γεγονότα

The adapters also send events to an [Events Manager](events) if it is present. If an event returns `false` it can stop the current operation. The following events are supported:

| Όνομα γεγονότος       | Ενεργοποίηση                        | Can stop |
| --------------------- | ----------------------------------- |:--------:|
| `afterQuery`          | After a query is executed           |   Όχι    |
| `beforeQuery`         | Before a query is executed          |   Ναι    |
| `beginTransaction`    | Before a transaction starts         |   Όχι    |
| `createSavepoint`     | Before a savepoint is created       |   Όχι    |
| `commitTransaction`   | Before a transaction is committed   |   Όχι    |
| `releaseSavepoint`    | Before a savepoint is released      |   Όχι    |
| `rollbackTransaction` | Before a transaction is rolled back |   Όχι    |
| `rollbackSavepoint`   | Before a savepoint is rolled back   |   Όχι    |

If you bind an [Events Manager](events) to the database connection, all the events with the type `db` will be enabled and fired for the relevant listeners.

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

You can use the power of these events to shield your application from dangerous SQL operations.

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

## Profiling

The adapter includes the [Phalcon\Db\Profiler](api/phalcon_db#db-profiler) component, that is used to analyze the performance of database operations so as to diagnose performance problems and discover bottlenecks.

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

You can also create your own profile class based on the [Phalcon\Db\Profiler](api/phalcon_db#db-profiler) class to record real time statistics of the statements that are sent to the database:

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

## Logging

Using high-level abstraction components such as the `Phalcon\Db` adapters to access the database, makes it difficult to understand which statements are sent to the database system. The [Phalcon\Logger](logger) component interacts with the `Phalcon\Db` adapters offering logging capabilities on the database abstraction level.

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

As above, the file `/storage/logs/queries.log` will contain something like this:

    [2019-12-25 01:02:03][INFO] INSERT INTO `co_invoices` 
        SET (`inv_cst_id`, `inv_title`) 
        VALUES (1, 'Invoice for ACME Inc.')
    

The listener will also work with models and their operations. It will also include all bound parameters that the query uses at the end of the logged statement.

    [2019-12-25 01:02:03][INFO] SELECT `co_customers`.`cst_id`, 
        ...,
        FROM `co_customers` 
        WHERE LOWER(`co_customers`.`cst_email`) = :cst_email 
        LIMIT :APL0 - [{"emp_email":"team@phalcon.ld","APL0":1}]
    

## Tables

### Describe

The `Phalcon\Db` adapters also provide methods to retrieve detailed information about tables and views:

```php
<?php

$tables = $connection->listTables('gonano');
```

Get tables on the `gonano` database

```php
<?php

$exists = $connection->tableExists('co_invoices');
```

Check if there is a table called `co_invoices` in the database?

```php
<?php

$fields = $connection->describeColumns('co_invoices');
foreach ($fields as $field) {
    echo 'Column Type: ', $field['Type'];
}
```

Print the name and data types of the `co_invoices` table

```php
<?php

$indexes = $connection->describeIndexes('co_invoices');
foreach ($indexes as $index) {
    print_r(
        $index->getColumns()
    );
}
```

Print the indexes in the `co_invoices` table

```php
<?php

$references = $connection->describeReferences('co_invoices');
foreach ($references as $reference) {
    print_r(
        $reference->getReferencedColumns()
    );
}
```

Print the foreign keys on the 'co_invoices' table

A table description is very similar to the MySQL `DESCRIBE` command, it contains the following information:

| Field        | Type        | Key                                                | Null                               |
| ------------ | ----------- | -------------------------------------------------- | ---------------------------------- |
| Field's name | Column Type | Is the column part of the primary key or an index? | Does the column allow null values? |

Methods to get information about views are also implemented for every supported database system:

```php
<?php

$tables = $connection->listViews('gonano');
```

Get views on the `gonano` database

```php
<?php

$exists = $connection->viewExists('vw_invoices');
```

Check if there is a view `vw_invoices` in the database

### Create

Different database systems (MySQL, Postgresql etc.) offer the ability to create, alter or drop tables with the use of commands such as `CREATE`, `ALTER` or `DROP`. The SQL syntax differs based on which database system is used. `Phalcon\Db` adapters offers a unified interface to alter tables, without the need to differentiate the SQL syntax based on the target storage system.

An example on how to create a table is shown below:

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

The `createTable` method accepts an associative array describing the table. Columns are defined with the class [Phalcon\Db\Column](api/phalcon_db#db-column). The table below shows the options available to define a column:

| Option          | Περιγραφή                                                                                                               | Optional |
| --------------- | ----------------------------------------------------------------------------------------------------------------------- |:--------:|
| `after`         | Column must be placed after indicated column                                                                            |   Ναι    |
| `autoIncrement` | Set whether this column will be auto incremented by the database. Only one column in the table can have this attribute. |   Ναι    |
| `bind`          | One of the `BIND_TYPE_*` constants telling how the column must be bound before save it                                  |   Ναι    |
| `default`       | Default value (when used with `'notNull' => true`).                                                                  |   Ναι    |
| `first`         | Column must be placed at first position in the column order                                                             |   Ναι    |
| `notNull`       | Column can store null values                                                                                            |   Ναι    |
| `primary`       | `true` if the column is part of the table's primary key                                                                 |   Ναι    |
| `scale`         | `DECIMAL` or `NUMBER` columns may be have a scale to specify how many decimals should be stored                         |   Ναι    |
| `size`          | Some type of columns like `VARCHAR` or `INTEGER` may have a specific size                                               |   Ναι    |
| `type`          | Column type. Must be a [Phalcon\Db\Column](api/phalcon_db#db-column) constant (see below for a list)                  |   Όχι    |
| `unsigned`      | `INTEGER` columns may be `signed` or `unsigned`. This option does not apply to other types of columns                   |   Ναι    |

The following database column types are supported by the adapters:

* `Phalcon\Db\Column::TYPE_INTEGER`
* `Phalcon\Db\Column::TYPE_DATE`
* `Phalcon\Db\Column::TYPE_VARCHAR`
* `Phalcon\Db\Column::TYPE_DECIMAL`
* `Phalcon\Db\Column::TYPE_DATETIME`
* `Phalcon\Db\Column::TYPE_CHAR`
* `Phalcon\Db\Column::TYPE_TEXT`

The associative array passed in `createTable()` can have the following keys:

| Index        | Περιγραφή                                                                                                  | Optional |
| ------------ | ---------------------------------------------------------------------------------------------------------- |:--------:|
| `columns`    | An array with columns defined with [Phalcon\Db\Column](api/phalcon_db#db-column)                         |   Όχι    |
| `indexes`    | An array with indexes defined with [Phalcon\Db\Index](api/phalcon_db#db-index)                           |   Ναι    |
| `references` | An array with references (foreign keys) defined with [Phalcon\Db\Reference](api/phalcon_db#db-reference) |   Ναι    |
| `options`    | An array with creation options. (specific to the database system)                                          |   Ναι    |

### Alter

As your application grows, you might need to alter your database, as part of a refactoring or adding new features. Not all database systems allow you to modify existing columns or adding columns between two existing ones. [Phalcon\Db](api/phalcon_db#db-column) is limited by these constraints.

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

### Drop

To drop an existing table from the current database, use the `dropTable` method. To drop an table from a custom database, you can use the second parameter to set the database name.

```php
<?php

$connection->dropTable('co_invoices');
```

Drop the table `co_invoices` from active database

```php
<?php

$connection->dropTable('co_invoices', 'gonano');
```

Drop the table `co_invoices` from the database `gonano`