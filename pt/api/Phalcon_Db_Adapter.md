# Abstract class **Phalcon\\Db\\Adapter**

*implements* [Phalcon\Db\AdapterInterface](/en/3.2/api/Phalcon_Db_AdapterInterface), [Phalcon\Events\EventsAwareInterface](/en/3.2/api/Phalcon_Events_EventsAwareInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/db/adapter.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Base class for Phalcon\\Db adapters

## Methods

public **getDialectType** ()

Name of the dialect used

public **getType** ()

Type of database system the adapter is used for

public **getSqlVariables** ()

Active SQL bound parameter variables

public **__construct** (*array* $descriptor)

Phalcon\\Db\\Adapter constructor

public **setEventsManager** ([Phalcon\Events\ManagerInterface](/en/3.2/api/Phalcon_Events_ManagerInterface) $eventsManager)

Sets the event manager

public **getEventsManager** ()

Returns the internal event manager

public **setDialect** ([Phalcon\Db\DialectInterface](/en/3.2/api/Phalcon_Db_DialectInterface) $dialect)

Sets the dialect used to produce the SQL

public **getDialect** ()

Returns internal dialect instance

public **fetchOne** (*mixed* $sqlQuery, [*mixed* $fetchMode], [*mixed* $bindParams], [*mixed* $bindTypes])

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

public *array* **fetchAll** (*string* $sqlQuery, [*int* $fetchMode], [*array* $bindParams], [*array* $bindTypes])

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

public *string* | ** **fetchColumn** (*string* $sqlQuery, [*array* $placeholders], [*int* | *string* $column])

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

public *boolean* **insert** (*string* | *array* $table, *array* $values, [*array* $fields], [*array* $dataTypes])

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

public *boolean* **insertAsDict** (*string* $table, *array* $data, [*array* $dataTypes])

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

public *boolean* **update** (*string* | *array* $table, *array* $fields, *array* $values, [*string* | *array* $whereCondition], [*array* $dataTypes])

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

public *boolean* **updateAsDict** (*string* $table, *array* $data, [*string* $whereCondition], [*array* $dataTypes])

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

public *boolean* **delete** (*string* | *array* $table, [*string* $whereCondition], [*array* $placeholders], [*array* $dataTypes])

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

public **escapeIdentifier** (*array* | *string* $identifier)

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

public *string* **getColumnList** (*array* $columnList)

Gets a list of columns

public **limit** (*mixed* $sqlQuery, *mixed* $number)

Appends a LIMIT clause to $sqlQuery argument

```php
<?php

echo $connection->limit("SELECT * FROM robots", 5);

```

public **tableExists** (*mixed* $tableName, [*mixed* $schemaName])

Generates SQL checking for the existence of a schema.table

```php
<?php

var_dump(
    $connection->tableExists("blog", "posts")
);

```

public **viewExists** (*mixed* $viewName, [*mixed* $schemaName])

Generates SQL checking for the existence of a schema.view

```php
<?php

var_dump(
    $connection->viewExists("active_users", "posts")
);

```

public **forUpdate** (*mixed* $sqlQuery)

Returns a SQL modified with a FOR UPDATE clause

public **sharedLock** (*mixed* $sqlQuery)

Returns a SQL modified with a LOCK IN SHARE MODE clause

public **createTable** (*mixed* $tableName, *mixed* $schemaName, *array* $definition)

Creates a table

public **dropTable** (*mixed* $tableName, [*mixed* $schemaName], [*mixed* $ifExists])

Drops a table from a schema/database

public **createView** (*mixed* $viewName, *array* $definition, [*mixed* $schemaName])

Creates a view

public **dropView** (*mixed* $viewName, [*mixed* $schemaName], [*mixed* $ifExists])

Drops a view

public **addColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](/en/3.2/api/Phalcon_Db_ColumnInterface) $column)

Adds a column to a table

public **modifyColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](/en/3.2/api/Phalcon_Db_ColumnInterface) $column, [[Phalcon\Db\ColumnInterface](/en/3.2/api/Phalcon_Db_ColumnInterface) $currentColumn])

Modifies a table column based on a definition

public **dropColumn** (*mixed* $tableName, *mixed* $schemaName, *mixed* $columnName)

Drops a column from a table

public **addIndex** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](/en/3.2/api/Phalcon_Db_IndexInterface) $index)

Adds an index to a table

public **dropIndex** (*mixed* $tableName, *mixed* $schemaName, *mixed* $indexName)

Drop an index from a table

public **addPrimaryKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](/en/3.2/api/Phalcon_Db_IndexInterface) $index)

Adds a primary key to a table

public **dropPrimaryKey** (*mixed* $tableName, *mixed* $schemaName)

Drops a table's primary key

public **addForeignKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ReferenceInterface](/en/3.2/api/Phalcon_Db_ReferenceInterface) $reference)

Adds a foreign key to a table

public **dropForeignKey** (*mixed* $tableName, *mixed* $schemaName, *mixed* $referenceName)

Drops a foreign key from a table

public **getColumnDefinition** ([Phalcon\Db\ColumnInterface](/en/3.2/api/Phalcon_Db_ColumnInterface) $column)

Returns the SQL column definition from a column

public **listTables** ([*mixed* $schemaName])

List all tables on a database

```php
<?php

print_r(
    $connection->listTables("blog")
);

```

public **listViews** ([*mixed* $schemaName])

List all views on a database

```php
<?php

print_r(
    $connection->listViews("blog")
);

```

public [Phalcon\Db\Index](/en/3.2/api/Phalcon_Db_Index) **describeIndexes** (*string* $table, [*string* $schema])

Lists table indexes

```php
<?php

print_r(
    $connection->describeIndexes("robots_parts")
);

```

public **describeReferences** (*mixed* $table, [*mixed* $schema])

Lists table references

```php
<?php

print_r(
    $connection->describeReferences("robots_parts")
);

```

public **tableOptions** (*mixed* $tableName, [*mixed* $schemaName])

Gets creation options from a table

```php
<?php

print_r(
    $connection->tableOptions("robots")
);

```

public **createSavepoint** (*mixed* $name)

Creates a new savepoint

public **releaseSavepoint** (*mixed* $name)

Releases given savepoint

public **rollbackSavepoint** (*mixed* $name)

Rollbacks given savepoint

public **setNestedTransactionsWithSavepoints** (*mixed* $nestedTransactionsWithSavepoints)

Set if nested transactions should use savepoints

public **isNestedTransactionsWithSavepoints** ()

Returns if nested transactions should use savepoints

public **getNestedTransactionSavepointName** ()

Returns the savepoint name to use for nested transactions

public **getDefaultIdValue** ()

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

public **getDefaultValue** ()

Returns the default value to make the RBDM use the default value declared in the table definition

```php
<?php

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

public **supportSequences** ()

Check whether the database system requires a sequence to produce auto-numeric values

public **useExplicitIdValue** ()

Check whether the database system requires an explicit value for identity columns

public **getDescriptor** ()

Return descriptor used to connect to the active database

public *string* **getConnectionId** ()

Gets the active connection unique identifier

public **getSQLStatement** ()

Active SQL statement in the object

public **getRealSQLStatement** ()

Active SQL statement in the object without replace bound parameters

public *array* **getSQLBindTypes** ()

Active SQL statement in the object

abstract public **connect** ([*array* $descriptor]) inherited from [Phalcon\Db\AdapterInterface](/en/3.2/api/Phalcon_Db_AdapterInterface)

...

abstract public **query** (*mixed* $sqlStatement, [*mixed* $placeholders], [*mixed* $dataTypes]) inherited from [Phalcon\Db\AdapterInterface](/en/3.2/api/Phalcon_Db_AdapterInterface)

...

abstract public **execute** (*mixed* $sqlStatement, [*mixed* $placeholders], [*mixed* $dataTypes]) inherited from [Phalcon\Db\AdapterInterface](/en/3.2/api/Phalcon_Db_AdapterInterface)

...

abstract public **affectedRows** () inherited from [Phalcon\Db\AdapterInterface](/en/3.2/api/Phalcon_Db_AdapterInterface)

...

abstract public **close** () inherited from [Phalcon\Db\AdapterInterface](/en/3.2/api/Phalcon_Db_AdapterInterface)

...

abstract public **escapeString** (*mixed* $str) inherited from [Phalcon\Db\AdapterInterface](/en/3.2/api/Phalcon_Db_AdapterInterface)

...

abstract public **lastInsertId** ([*mixed* $sequenceName]) inherited from [Phalcon\Db\AdapterInterface](/en/3.2/api/Phalcon_Db_AdapterInterface)

...

abstract public **begin** ([*mixed* $nesting]) inherited from [Phalcon\Db\AdapterInterface](/en/3.2/api/Phalcon_Db_AdapterInterface)

...

abstract public **rollback** ([*mixed* $nesting]) inherited from [Phalcon\Db\AdapterInterface](/en/3.2/api/Phalcon_Db_AdapterInterface)

...

abstract public **commit** ([*mixed* $nesting]) inherited from [Phalcon\Db\AdapterInterface](/en/3.2/api/Phalcon_Db_AdapterInterface)

...

abstract public **isUnderTransaction** () inherited from [Phalcon\Db\AdapterInterface](/en/3.2/api/Phalcon_Db_AdapterInterface)

...

abstract public **getInternalHandler** () inherited from [Phalcon\Db\AdapterInterface](/en/3.2/api/Phalcon_Db_AdapterInterface)

...

abstract public **describeColumns** (*mixed* $table, [*mixed* $schema]) inherited from [Phalcon\Db\AdapterInterface](/en/3.2/api/Phalcon_Db_AdapterInterface)

...