# Class **Phalcon\\Db\\Adapter\\Pdo\\Mysql**

*extends* abstract class [Phalcon\Db\Adapter\Pdo](/[[language]]/[[version]]/api/Phalcon_Db_Adapter_Pdo)

*implements* [Phalcon\Db\AdapterInterface](/[[language]]/[[version]]/api/Phalcon_Db_AdapterInterface), [Phalcon\Events\EventsAwareInterface](/[[language]]/[[version]]/api/Phalcon_Events_EventsAwareInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/db/adapter/pdo/mysql.zep" class="btn btn-default btn-sm">源码在 GitHub</a>

Mysql数据库系统的特定参数

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

## 方法列表

public **describeColumns** (*mixed* $table, [*mixed* $schema])

Returns an array of Phalcon\\Db\\Column objects describing a table

```php
<?php

print_r(
    $connection->describeColumns("posts")
);

```

public [Phalcon\Db\IndexInterface](/[[language]]/[[version]]/api/Phalcon_Db_IndexInterface) **describeIndexes** (*string* $table, [*string* $schema])

列出表的索引

```php
<?php

print_r(
    $connection->describeIndexes("robots_parts")
);

```

public **describeReferences** (*mixed* $table, [*mixed* $schema])

列出表引用

```php
<?php

print_r(
    $connection->describeReferences("robots_parts")
);

```

public **__construct** (*array* $descriptor) inherited from [Phalcon\Db\Adapter\Pdo](/[[language]]/[[version]]/api/Phalcon_Db_Adapter_Pdo)

Phalcon\\Db\\Adapter\\Pdo 构造方法

public **connect** ([*array* $descriptor]) inherited from [Phalcon\Db\Adapter\Pdo](/[[language]]/[[version]]/api/Phalcon_Db_Adapter_Pdo)

该方法在 \\Phalcon\\Db\\Adapter\\Pdo 构造器中自动调用。 你可以在需要重置数据连接时调用它。

```php
<?php

use Phalcon\Db\Adapter\Pdo\Mysql;

// 设置一个数据库连接
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

public **prepare** (*mixed* $sqlStatement) inherited from [Phalcon\Db\Adapter\Pdo](/[[language]]/[[version]]/api/Phalcon_Db_Adapter_Pdo)

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

public [PDOStatement](http://php.net/manual/en/class.pdostatement.php) **executePrepared** ([PDOStatement](http://php.net/manual/en/class.pdostatement.php) $statement, *array* $placeholders, *array* $dataTypes) inherited from [Phalcon\Db\Adapter\Pdo](/[[language]]/[[version]]/api/Phalcon_Db_Adapter_Pdo)

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

public **query** (*mixed* $sqlStatement, [*mixed* $bindParams], [*mixed* $bindTypes]) inherited from [Phalcon\Db\Adapter\Pdo](/[[language]]/[[version]]/api/Phalcon_Db_Adapter_Pdo)

将SQL语句发送到数据库服务器并返回成功状态。仅在SQL语句有返回数据行的情况下使用此方法。

```php
<?php

// 查询数据
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

public **execute** (*mixed* $sqlStatement, [*mixed* $bindParams], [*mixed* $bindTypes]) inherited from [Phalcon\Db\Adapter\Pdo](/[[language]]/[[version]]/api/Phalcon_Db_Adapter_Pdo)

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

public **affectedRows** () inherited from [Phalcon\Db\Adapter\Pdo](/[[language]]/[[version]]/api/Phalcon_Db_Adapter_Pdo)

返回数据库系统中执行的最新插入/更新/删除返回受影响行的数目

```php
<?php

$connection->execute(
    "DELETE FROM robots"
);

echo $connection->affectedRows(), " were deleted";

```

public **close** () inherited from [Phalcon\Db\Adapter\Pdo](/[[language]]/[[version]]/api/Phalcon_Db_Adapter_Pdo)

关闭活动连接返回成功。Phalcon会自动关闭并摧毁 请求结束时的活动连接

public **escapeString** (*mixed* $str) inherited from [Phalcon\Db\Adapter\Pdo](/[[language]]/[[version]]/api/Phalcon_Db_Adapter_Pdo)

根据连接中的活动字符集逃避值以避免SQL注入

```php
<?php

$escapedStr = $connection->escapeString("some dangerous value");

```

public **convertBoundParams** (*mixed* $sql, [*array* $params]) inherited from [Phalcon\Db\Adapter\Pdo](/[[language]]/[[version]]/api/Phalcon_Db_Adapter_Pdo)

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

public *int* | *boolean* **lastInsertId** ([*string* $sequenceName]) inherited from [Phalcon\Db\Adapter\Pdo](/[[language]]/[[version]]/api/Phalcon_Db_Adapter_Pdo)

返回插入在最近执行的SQL语句中的自增ID

```php
<?php

// 插入一条新数据
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

public **begin** ([*mixed* $nesting]) inherited from [Phalcon\Db\Adapter\Pdo](/[[language]]/[[version]]/api/Phalcon_Db_Adapter_Pdo)

在当前连接中启动事务

public **rollback** ([*mixed* $nesting]) inherited from [Phalcon\Db\Adapter\Pdo](/[[language]]/[[version]]/api/Phalcon_Db_Adapter_Pdo)

回滚当前连接中的事务

public **commit** ([*mixed* $nesting]) inherited from [Phalcon\Db\Adapter\Pdo](/[[language]]/[[version]]/api/Phalcon_Db_Adapter_Pdo)

提交当前连接中的事务

public **getTransactionLevel** () inherited from [Phalcon\Db\Adapter\Pdo](/[[language]]/[[version]]/api/Phalcon_Db_Adapter_Pdo)

返回当前事务嵌套级别

public **isUnderTransaction** () inherited from [Phalcon\Db\Adapter\Pdo](/[[language]]/[[version]]/api/Phalcon_Db_Adapter_Pdo)

检查连接是否在事务

```php
<?php

$connection->begin();

// true
var_dump(
    $connection->isUnderTransaction()
);

```

public **getInternalHandler** () inherited from [Phalcon\Db\Adapter\Pdo](/[[language]]/[[version]]/api/Phalcon_Db_Adapter_Pdo)

返回内部 PDO 处理程序

public *array* **getErrorInfo** () inherited from [Phalcon\Db\Adapter\Pdo](/[[language]]/[[version]]/api/Phalcon_Db_Adapter_Pdo)

返回错误信息 (如果有)

public **getDialectType** () inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

所使用的数据库方言, 可以参考: http://blog. csdn. net/jialinqiang/article/details/8679171

public **getType** () inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

获取数据库系统的类型

public **getSqlVariables** () inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

获取当前SQL语句绑定的参数列表

public **setEventsManager** ([Phalcon\Events\ManagerInterface](/[[language]]/[[version]]/api/Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

设置事件管理器

public **getEventsManager** () inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

返回内部事件管理器

public **setDialect** ([Phalcon\Db\DialectInterface](/[[language]]/[[version]]/api/Phalcon_Db_DialectInterface) $dialect) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

设置用于生成 SQL 的方言

public **getDialect** () inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

返回内部方言实例

public **fetchOne** (*mixed* $sqlQuery, [*mixed* $fetchMode], [*mixed* $bindParams], [*mixed* $bindTypes]) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

返回 SQL 查询结果中的第一行

```php
<?php

// 获取第一个机器人数据
$robot = $connection->fetchOne("SELECT * FROM robots");
print_r($robot);

// 获取第一个机器人数据仅通过索引
$robot = $connection->fetchOne("SELECT * FROM robots", \Phalcon\Db::FETCH_ASSOC);
print_r($robot);

```

public *array* **fetchAll** (*string* $sqlQuery, [*int* $fetchMode], [*array* $bindParams], [*array* $bindTypes]) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

将查询的完整结果转储到数组中

```php
<?php

/获取所有的机器人数据仅通过索引形式
$robots = $connection->fetchAll(
    "SELECT * FROM robots",
    \Phalcon\Db::FETCH_ASSOC
);

foreach ($robots as $robot) {
    print_r($robot);
}

 //  获取所有的名字中包含'robot'的机器人数据 
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

public *string* | ** **fetchColumn** (*string* $sqlQuery, [*array* $placeholders], [*int* | *string* $column]) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

返回查询结果的第一行的第N个字段

```php
<?php

// 统计机器人数据 
$robotsCount = $connection->fetchColumn("SELECT count(*) FROM robots");
print_r($robotsCount);

// 获取最后一个人编辑的机器人 
$robot = $connection->fetchColumn(
    "SELECT id, name FROM robots order by modified desc",
    1
);
print_r($robot);

```

public *boolean* **insert** (*string* | *array* $table, *array* $values, [*array* $fields], [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

使用自定义的RDBMS SQL语句向数据表中插入数据

```php
<?php

// 插入一条新数据 
$success = $connection->insert(
    "robots",
    ["Astro Boy", 1952],
    ["name", "year"]
);

// 下面的SQL语句将会在数据库中执行 
INSERT INTO `robots` (`name`, `year`) VALUES ("Astro boy", 1952);

```

public *boolean* **insertAsDict** (*string* $table, *array* $data, [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

使用自定义的RDBMS SQL语句向数据表中插入数据

```php
<?php

//插入一个新的机器人
$success = $connection->insertAsDict(
    "robots",
    [
        "name" => "Astro Boy",
        "year" => 1952,
    ]
);

//下面SQL语句被发送到数据库系统
INSERT INTO `robots` (`name`, `year`) VALUES ("Astro boy", 1952);

```

public *boolean* **update** (*string* | *array* $table, *array* $fields, *array* $values, [*string* | *array* $whereCondition], [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

使用自定义的RDBMS SQL语句向数据表中更新数据

```php
<?php

// 更新现有的机器人
$success = $connection->update(
    "robots",
    ["name"],
    ["New Astro Boy"],
    "id = 101"
);

// 这是在数据库系统中实际执行的语句
UPDATE `robots` SET `name` = "Astro boy" WHERE id = 101

// 使用数组条件和 $dataTypes 更新现有的robot数据  
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

警告! 如果$whereCondition 是字符串它将不会被转义.

public *boolean* **updateAsDict** (*string* $table, *array* $data, [*string* $whereCondition], [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

另一种更方便的语法, 使用定制的RBDM SQL语法更新表上的数据.

```php
<?php

// 更新现有的机器人
$success = $connection->updateAsDict(
    "robots",
    [
        "name" => "New Astro Boy",
    ],
    "id = 101"
);

// 这是在数据库系统中执行的语句
UPDATE `robots` SET `name` = "Astro boy" WHERE id = 101

```

public *boolean* **delete** (*string* | *array* $table, [*string* $whereCondition], [*array* $placeholders], [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

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

public **escapeIdentifier** (*array* | *string* $identifier) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

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

public *string* **getColumnList** (*array* $columnList) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Gets a list of columns

public **limit** (*mixed* $sqlQuery, *mixed* $number) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Appends a LIMIT clause to $sqlQuery argument

```php
<?php

echo $connection->limit("SELECT * FROM robots", 5);

```

public **tableExists** (*mixed* $tableName, [*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Generates SQL checking for the existence of a schema.table

```php
<?php

var_dump(
    $connection->tableExists("blog", "posts")
);

```

public **viewExists** (*mixed* $viewName, [*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Generates SQL checking for the existence of a schema.view

```php
<?php

var_dump(
    $connection->viewExists("active_users", "posts")
);

```

public **forUpdate** (*mixed* $sqlQuery) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Returns a SQL modified with a FOR UPDATE clause

public **sharedLock** (*mixed* $sqlQuery) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Returns a SQL modified with a LOCK IN SHARE MODE clause

public **createTable** (*mixed* $tableName, *mixed* $schemaName, *array* $definition) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Creates a table

public **dropTable** (*mixed* $tableName, [*mixed* $schemaName], [*mixed* $ifExists]) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Drops a table from a schema/database

public **createView** (*mixed* $viewName, *array* $definition, [*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Creates a view

public **dropView** (*mixed* $viewName, [*mixed* $schemaName], [*mixed* $ifExists]) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Drops a view

public **addColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](/[[language]]/[[version]]/api/Phalcon_Db_ColumnInterface) $column) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Adds a column to a table

public **modifyColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](/[[language]]/[[version]]/api/Phalcon_Db_ColumnInterface) $column, [[Phalcon\Db\ColumnInterface](/[[language]]/[[version]]/api/Phalcon_Db_ColumnInterface) $currentColumn]) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Modifies a table column based on a definition

public **dropColumn** (*mixed* $tableName, *mixed* $schemaName, *mixed* $columnName) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Drops a column from a table

public **addIndex** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](/[[language]]/[[version]]/api/Phalcon_Db_IndexInterface) $index) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Adds an index to a table

public **dropIndex** (*mixed* $tableName, *mixed* $schemaName, *mixed* $indexName) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Drop an index from a table

public **addPrimaryKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](/[[language]]/[[version]]/api/Phalcon_Db_IndexInterface) $index) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Adds a primary key to a table

public **dropPrimaryKey** (*mixed* $tableName, *mixed* $schemaName) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Drops a table's primary key

public **addForeignKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ReferenceInterface](/[[language]]/[[version]]/api/Phalcon_Db_ReferenceInterface) $reference) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Adds a foreign key to a table

public **dropForeignKey** (*mixed* $tableName, *mixed* $schemaName, *mixed* $referenceName) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Drops a foreign key from a table

public **getColumnDefinition** ([Phalcon\Db\ColumnInterface](/[[language]]/[[version]]/api/Phalcon_Db_ColumnInterface) $column) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

返回SQL列定义

public **listTables** ([*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

List all tables on a database

```php
<?php

print_r(
    $connection->listTables("blog")
);

```

public **listViews** ([*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

List all views on a database

```php
<?php

print_r(
    $connection->listViews("blog")
);

```

public **tableOptions** (*mixed* $tableName, [*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Gets creation options from a table

```php
<?php

print_r(
    $connection->tableOptions("robots")
);

```

public **createSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Creates a new savepoint

public **releaseSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Releases given savepoint

public **rollbackSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

回滚给定的事务保存点

public **setNestedTransactionsWithSavepoints** (*mixed* $nestedTransactionsWithSavepoints) inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Set if nested transactions should use savepoints

public **isNestedTransactionsWithSavepoints** () inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Returns if nested transactions should use savepoints

public **getNestedTransactionSavepointName** () inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Returns the savepoint name to use for nested transactions

public **getDefaultIdValue** () inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

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

public **getDefaultValue** () inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

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

public **supportSequences** () inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Check whether the database system requires a sequence to produce auto-numeric values

public **useExplicitIdValue** () inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Check whether the database system requires an explicit value for identity columns

public **getDescriptor** () inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Return descriptor used to connect to the active database

public *string* **getConnectionId** () inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Gets the active connection unique identifier

public **getSQLStatement** () inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Active SQL statement in the object

public **getRealSQLStatement** () inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Active SQL statement in the object without replace bound parameters

public *array* **getSQLBindTypes** () inherited from [Phalcon\Db\Adapter](/[[language]]/[[version]]/api/Phalcon_Db_Adapter)

Active SQL statement in the object