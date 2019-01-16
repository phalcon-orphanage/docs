* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Db\Adapter\Pdo\Sqlite'

* * *

# Class **Phalcon\Db\Adapter\Pdo\Sqlite**

*extends* abstract class [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

*implements* [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/db/adapter/pdo/sqlite.zep" class="btn btn-default btn-sm">Исходный код на GitHub</a>

Specific functions for the Sqlite database system

```php
<?php

use Phalcon\Db\Adapter\Pdo\Sqlite;

$connection = new Sqlite(
    [
        "dbname" => "/tmp/test.sqlite",
    ]
);

```

## Methods

public **connect** ([*array* $descriptor])

This method is automatically called in Phalcon\Db\Adapter\Pdo constructor. Call it when you need to restore a database connection.

public **describeColumns** (*mixed* $table, [*mixed* $schema])

Returns an array of Phalcon\Db\Column objects describing a table

```php
<?php

print_r(
    $connection->describeColumns("posts")
);

```

public [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) **describeIndexes** (*string* $table, [*string* $schema])

Lists table indexes

```php
<?php

print_r(
    $connection->describeIndexes("robots_parts")
);

```

public [Phalcon\Db\ReferenceInterface](Phalcon_Db_ReferenceInterface) **describeReferences** (*string* $table, [*string* $schema])

Lists table references

public **useExplicitIdValue** ()

Check whether the database system requires an explicit value for identity columns

public **getDefaultValue** ()

Returns the default value to make the RBDM use the default value declared in the table definition

```php
<?php

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

public **__construct** (*array* $descriptor) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Constructor for Phalcon\Db\Adapter\Pdo

public **prepare** (*mixed* $sqlStatement) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Returns a PDO prepared statement to be executed with 'executePrepared'

```php
<?php

use Phalcon\Db\Column;

$statement = $db->prepare(
    "SELECT * FROM robots WHERE name = :name"
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

public [PDOStatement](https://php.net/manual/en/class.pdostatement.php) **executePrepared** ([PDOStatement](https://php.net/manual/en/class.pdostatement.php) $statement, *array* $placeholders, *array* $dataTypes) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Executes a prepared statement binding. This function uses integer indexes starting from zero

```php
<?php

use Phalcon\Db\Column;

$statement = $db->prepare(
    "SELECT * FROM robots WHERE name = :name"
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

public **query** (*mixed* $sqlStatement, [*mixed* $bindParams], [*mixed* $bindTypes]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Sends SQL statements to the database server returning the success state. Use this method only when the SQL statement sent to the server is returning rows

```php
<?php

// Querying data
$resultset = $connection->query(
    "SELECT * FROM robots WHERE type = 'mechanical'"
);

$resultset = $connection->query(
    "SELECT * FROM robots WHERE type = ?",
    [
        "mechanical",
    ]
);

```

public **execute** (*mixed* $sqlStatement, [*mixed* $bindParams], [*mixed* $bindTypes]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Sends SQL statements to the database server returning the success state. Use this method only when the SQL statement sent to the server doesn't return any rows

```php
<?php

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

public **affectedRows** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Returns the number of affected rows by the latest INSERT/UPDATE/DELETE executed in the database system

```php
<?php

$connection->execute(
    "DELETE FROM robots"
);

echo $connection->affectedRows(), " were deleted";

```

public **close** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Closes the active connection returning success. Phalcon automatically closes and destroys active connections when the request ends

public **escapeString** (*mixed* $str) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Escapes a value to avoid SQL injections according to the active charset in the connection

```php
<?php

$escapedStr = $connection->escapeString("some dangerous value");

```

public **convertBoundParams** (*mixed* $sql, [*array* $params]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Converts bound parameters such as :name: or ?1 into PDO bind params ?

```php
<?php

print_r(
    $connection->convertBoundParams(
        "SELECT * FROM robots WHERE name = :name:",
        [
            "Bender",
        ]
    )
);

```

public *int* | *boolean* **lastInsertId** ([*string* $sequenceName]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Returns the insert id for the auto_increment/serial column inserted in the latest executed SQL statement

```php
<?php

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

public **begin** ([*mixed* $nesting]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Starts a transaction in the connection

public **rollback** ([*mixed* $nesting]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Rollbacks the active transaction in the connection

public **commit** ([*mixed* $nesting]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Commits the active transaction in the connection

public **getTransactionLevel** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Returns the current transaction nesting level

public **isUnderTransaction** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Checks whether the connection is under a transaction

```php
<?php

$connection->begin();

// true
var_dump(
    $connection->isUnderTransaction()
);

```

public **getInternalHandler** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Return internal PDO handler

public *array* **getErrorInfo** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Return the error info, if any

public **getDialectType** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Name of the dialect used

public **getType** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Type of database system the adapter is used for

public **getSqlVariables** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Active SQL bound parameter variables

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Sets the event manager

public **getEventsManager** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Returns the internal event manager

public **setDialect** ([Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface) $dialect) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Sets the dialect used to produce the SQL

public **getDialect** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Returns internal dialect instance

public **fetchOne** (*mixed* $sqlQuery, [*mixed* $fetchMode], [*mixed* $bindParams], [*mixed* $bindTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Returns the first row in a SQL query result

```php
<?php

// Getting first robot
$robot = $connection->fetchOne("SELECT * FROM robots");
print_r($robot);

// Getting first robot with associative indexes only
$robot = $connection->fetchOne("SELECT * FROM robots", \Phalcon\Db::FETCH_ASSOC);
print_r($robot);

```

public *array* **fetchAll** (*string* $sqlQuery, [*int* $fetchMode], [*array* $bindParams], [*array* $bindTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Dumps the complete result of a query into an array

```php
<?php

// Getting all robots with associative indexes only
$robots = $connection->fetchAll(
    "SELECT * FROM robots",
    \Phalcon\Db::FETCH_ASSOC
);

foreach ($robots as $robot) {
    print_r($robot);
}

 // Getting all robots that contains word "robot" withing the name
$robots = $connection->fetchAll(
    "SELECT * FROM robots WHERE name LIKE :name",
    \Phalcon\Db::FETCH_ASSOC,
    [
        "name" => "%robot%",
    ]
);
foreach($robots as $robot) {
    print_r($robot);
}

```

public *string* | ** **fetchColumn** (*string* $sqlQuery, [*array* $placeholders], [*int* | *string* $column]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Returns the n'th field of first row in a SQL query result

```php
<?php

// Getting count of robots
$robotsCount = $connection->fetchColumn("SELECT count(*) FROM robots");
print_r($robotsCount);

// Getting name of last edited robot
$robot = $connection->fetchColumn(
    "SELECT id, name FROM robots order by modified desc",
    1
);
print_r($robot);

```

public *boolean* **insert** (*string* | *array* $table, *array* $values, [*array* $fields], [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Inserts data into a table using custom RDBMS SQL syntax

```php
<?php

// Inserting a new robot
$success = $connection->insert(
    "robots",
    ["Astro Boy", 1952],
    ["name", "year"]
);

// Next SQL sentence is sent to the database system
INSERT INTO `robots` (`name`, `year`) VALUES ("Astro boy", 1952);

```

public *boolean* **insertAsDict** (*string* $table, *array* $data, [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Inserts data into a table using custom RBDM SQL syntax

```php
<?php

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

public *boolean* **update** (*string* | *array* $table, *array* $fields, *array* $values, [*string* | *array* $whereCondition], [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Updates data on a table using custom RBDM SQL syntax

```php
<?php

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

Warning! If $whereCondition is string it not escaped.

public *boolean* **updateAsDict** (*string* $table, *array* $data, [*string* $whereCondition], [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Updates data on a table using custom RBDM SQL syntax Another, more convenient syntax

```php
<?php

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

public *boolean* **delete** (*string* | *array* $table, [*string* $whereCondition], [*array* $placeholders], [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Deletes data from a table using custom RBDM SQL syntax

```php
<?php

// Deleting existing robot
$success = $connection->delete(
    "robots",
    "id = 101"
);

// Next SQL sentence is generated
DELETE FROM `robots` WHERE `id` = 101

```

public **escapeIdentifier** (*array* | *string* $identifier) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Escapes a column/table/schema name

```php
<?php

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

public *string* **getColumnList** (*array* $columnList) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Gets a list of columns

public **limit** (*mixed* $sqlQuery, *mixed* $number) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Appends a LIMIT clause to $sqlQuery argument

```php
<?php

echo $connection->limit("SELECT * FROM robots", 5);

```

public **tableExists** (*mixed* $tableName, [*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Generates SQL checking for the existence of a schema.table

```php
<?php

var_dump(
    $connection->tableExists("blog", "posts")
);

```

public **viewExists** (*mixed* $viewName, [*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Generates SQL checking for the existence of a schema.view

```php
<?php

var_dump(
    $connection->viewExists("active_users", "posts")
);

```

public **forUpdate** (*mixed* $sqlQuery) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Returns a SQL modified with a FOR UPDATE clause

public **sharedLock** (*mixed* $sqlQuery) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Returns a SQL modified with a LOCK IN SHARE MODE clause

public **createTable** (*mixed* $tableName, *mixed* $schemaName, *array* $definition) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Creates a table

public **dropTable** (*mixed* $tableName, [*mixed* $schemaName], [*mixed* $ifExists]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Drops a table from a schema/database

public **createView** (*mixed* $viewName, *array* $definition, [*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Creates a view

public **dropView** (*mixed* $viewName, [*mixed* $schemaName], [*mixed* $ifExists]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Drops a view

public **addColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Adds a column to a table

public **modifyColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column, [[Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $currentColumn]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Modifies a table column based on a definition

public **dropColumn** (*mixed* $tableName, *mixed* $schemaName, *mixed* $columnName) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Drops a column from a table

public **addIndex** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Adds an index to a table

public **dropIndex** (*mixed* $tableName, *mixed* $schemaName, *mixed* $indexName) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Drop an index from a table

public **addPrimaryKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Adds a primary key to a table

public **dropPrimaryKey** (*mixed* $tableName, *mixed* $schemaName) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Drops a table's primary key

public **addForeignKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ReferenceInterface](Phalcon_Db_ReferenceInterface) $reference) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Adds a foreign key to a table

public **dropForeignKey** (*mixed* $tableName, *mixed* $schemaName, *mixed* $referenceName) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Drops a foreign key from a table

public **getColumnDefinition** ([Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Returns the SQL column definition from a column

public **listTables** ([*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

List all tables on a database

```php
<?php

print_r(
    $connection->listTables("blog")
);

```

public **listViews** ([*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

List all views on a database

```php
<?php

print_r(
    $connection->listViews("blog")
);

```

public **tableOptions** (*mixed* $tableName, [*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Gets creation options from a table

```php
<?php

print_r(
    $connection->tableOptions("robots")
);

```

public **createSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Creates a new savepoint

public **releaseSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Releases given savepoint

public **rollbackSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Rollbacks given savepoint

public **setNestedTransactionsWithSavepoints** (*mixed* $nestedTransactionsWithSavepoints) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Set if nested transactions should use savepoints

public **isNestedTransactionsWithSavepoints** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Returns if nested transactions should use savepoints

public **getNestedTransactionSavepointName** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Returns the savepoint name to use for nested transactions

public **getDefaultIdValue** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Returns the default identity value to be inserted in an identity column

```php
<?php

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

public **supportSequences** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Check whether the database system requires a sequence to produce auto-numeric values

public **getDescriptor** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Return descriptor used to connect to the active database

public *string* **getConnectionId** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Gets the active connection unique identifier

public **getSQLStatement** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Active SQL statement in the object

public **getRealSQLStatement** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Active SQL statement in the object without replace bound parameters

public *array* **getSQLBindTypes** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Active SQL statement in the object