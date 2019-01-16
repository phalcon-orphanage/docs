* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Db\Adapter\Pdo'

* * *

# Abstract class **Phalcon\Db\Adapter\Pdo**

*extends* abstract class [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/db/adapter/pdo.zep" class="btn btn-default btn-sm">源码在GitHub</a>

Phalcon\Db\Adapter\Pdo is the Phalcon\Db that internally uses PDO to connect to a database

```php
<?php

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

## 方法

public **__construct** (*array* $descriptor)

Constructor for Phalcon\Db\Adapter\Pdo

public **connect** ([*array* $descriptor])

This method is automatically called in \Phalcon\Db\Adapter\Pdo constructor. Call it when you need to restore a database connection.

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql;

// 建立连接
$connection = new Mysql(
    [
        "host"     => "localhost",
        "username" => "sigma",
        "password" => "secret",
        "dbname"   => "blog",
        "port"     => 3306,
    ]
);

// 重新连接
$connection->connect();

```

public **prepare** (*mixed* $sqlStatement)

返回一个将以 'executePrepared' 执行的PDO预执行语句

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

public [PDOStatement](https://php.net/manual/en/class.pdostatement.php) **executePrepared** ([PDOStatement](https://php.net/manual/en/class.pdostatement.php) $statement, *array* $placeholders, *array* $dataTypes)

执行一个预执行语句。该方法使用以0起始的整数索引。

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

public **query** (*mixed* $sqlStatement, [*mixed* $bindParams], [*mixed* $bindTypes])

将SQL语句发送到数据库服务器并返回成功状态。仅在SQL语句有返回数据行的情况下使用此方法。

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

public **execute** (*mixed* $sqlStatement, [*mixed* $bindParams], [*mixed* $bindTypes])

将SQL语句发送到返回成功状态的数据库服务器。 只有当发送到服务器的SQL语句不会返回任何行时，才使用此方法

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

public **affectedRows** ()

返回数据库系统中执行的最新插入/更新/删除返回受影响行的数目

```php
<?php

$connection->execute(
    "DELETE FROM robots"
);

echo $connection->affectedRows(), " were deleted";

```

public **close** ()

关闭活动连接返回成功。Phalcon自动关闭和破坏请求结束时的活动连接

public **escapeString** (*mixed* $str)

根据连接中的活动字符集逃避值以避免SQL注入

```php
<?php

$escapedStr = $connection->escapeString("some dangerous value");

```

public **convertBoundParams** (*mixed* $sql, [*array* $params])

转换绑定参数，例如：:name: 或 ?1 到PDO绑定参数？

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

public *int* | *boolean* **lastInsertId** ([*string* $sequenceName])

返回插入在最近执行的SQL语句中的 自增/连续 列的插入ID

```php
<?php

// 插入一条新的机器人数据
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

// 获取ID
$id = $connection->lastInsertId();

```

public **begin** ([*mixed* $nesting])

在当前连接中启动事务

public **rollback** ([*mixed* $nesting])

回滚当前连接中的事务

public **commit** ([*mixed* $nesting])

提交当前连接中的事务

public **getTransactionLevel** ()

返回当前事务嵌套级别

public **isUnderTransaction** ()

检查连接是否在事务

```php
<?php

$connection->begin();

// true
var_dump(
    $connection->isUnderTransaction()
);

```

public **getInternalHandler** ()

Return internal PDO handler

public *array* **getErrorInfo** ()

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

返回内部事件管理器

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

public [Phalcon\Db\Index](Phalcon_Db_Index) **describeIndexes** (*string* $table, [*string* $schema]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Lists table indexes

```php
<?php

print_r(
    $connection->describeIndexes("robots_parts")
);

```

public **describeReferences** (*mixed* $table, [*mixed* $schema]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Lists table references

```php
<?php

print_r(
    $connection->describeReferences("robots_parts")
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

public **getDefaultValue** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

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

public **supportSequences** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Check whether the database system requires a sequence to produce auto-numeric values

public **useExplicitIdValue** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Check whether the database system requires an explicit value for identity columns

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

abstract public **describeColumns** (*mixed* $table, [*mixed* $schema]) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...