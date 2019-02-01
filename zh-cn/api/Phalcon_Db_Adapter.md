---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Db\Adapter'
---
# Abstract class **Phalcon\Db\Adapter**

*implements* [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/adapter.zep)

Base class for Phalcon\Db adapters

## 方法

public **getDialectType** ()

所使用的数据库方言, 可以参考: http://blog.csdn.net/jialinqiang/article/details/8679171

public **getType** ()

获取数据库系统的类型

public **getSqlVariables** ()

获取当前SQL语句绑定的参数列表

public **__construct** (*array* $descriptor)

Phalcon\Db\Adapter constructor

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

设置事件管理器

public **getEventsManager** ()

返回内部事件管理器

public **setDialect** ([Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface) $dialect)

设置用于生成 SQL 的方言

public **getDialect** ()

返回内部方言实例

public **fetchOne** (*mixed* $sqlQuery, [*mixed* $fetchMode], [*mixed* $bindParams], [*mixed* $bindTypes])

返回 SQL 查询结果中的第一行

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

将查询的完整结果转储到数组中

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

返回查询结果的第一行的第N个字段

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

使用自定义的RDBMS SQL语句向数据表中插入数据

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

public *boolean* **update** (*string* | *array* $table, *array* $fields, *array* $values, [*string* | *array* $whereCondition], [*array* $dataTypes])

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

Warning! If $whereCondition is string it not escaped.

public *boolean* **updateAsDict** (*string* $table, *array* $data, [*string* $whereCondition], [*array* $dataTypes])

另一种更方便的语法,使用定制的RBDM SQL语法更新表上的数据.

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

public *boolean* **delete** (*string* | *array* $table, [*string* $whereCondition], [*array* $placeholders], [*array* $dataTypes])

使用自定义的RDBMS SQL语句在数据表中删除数据

```php
<?php

// 删除现有的机器人
$success = $connection->delete(
    "robots",
    "id = 101"
);

// 这是执行的语句
DELETE FROM `robots` WHERE `id` = 101

```

public **escapeIdentifier** (*array* | *string* $identifier)

转义 行/表/列 的名字

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

获取一个列名列表

public **limit** (*mixed* $sqlQuery, *mixed* $number)

最佳一个 LIMIT 子句到 $sqlQuery 的参数中

```php
<?php

echo $connection->limit("SELECT * FROM robots", 5);

```

public **tableExists** (*mixed* $tableName, [*mixed* $schemaName])

判断表是否存在

```php
<?php

var_dump(
    $connection->tableExists("blog", "posts")
);

```

public **viewExists** (*mixed* $viewName, [*mixed* $schemaName])

判断视图是否存在

```php
<?php

var_dump(
    $connection->viewExists("active_users", "posts")
);

```

public **forUpdate** (*mixed* $sqlQuery)

返回使用FOR UPDATE子句修改的SQL

public **sharedLock** (*mixed* $sqlQuery)

返回使用LOCK IN SHARE MODE子句修改的SQL

public **createTable** (*mixed* $tableName, *mixed* $schemaName, *array* $definition)

创建一个表

public **dropTable** (*mixed* $tableName, [*mixed* $schemaName], [*mixed* $ifExists])

删除一个表从数据库或结构？

public **createView** (*mixed* $viewName, *array* $definition, [*mixed* $schemaName])

创建1个视图

public **dropView** (*mixed* $viewName, [*mixed* $schemaName], [*mixed* $ifExists])

删除一个视图

public **addColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

向表中添加一列

public **modifyColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column, [[Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $currentColumn])

根据定义修改表格列

public **dropColumn** (*mixed* $tableName, *mixed* $schemaName, *mixed* $columnName)

从表中删除一列

public **addIndex** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index)

表中增加一个索引

public **dropIndex** (*mixed* $tableName, *mixed* $schemaName, *mixed* $indexName)

从表中清楚一个索引

public **addPrimaryKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index)

将主键加到表中

public **dropPrimaryKey** (*mixed* $tableName, *mixed* $schemaName)

从表中删除一个主键

public **addForeignKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ReferenceInterface](Phalcon_Db_ReferenceInterface) $reference)

向表中添加一个外键

public **dropForeignKey** (*mixed* $tableName, *mixed* $schemaName, *mixed* $referenceName)

从表中删除一个外键

public **getColumnDefinition** ([Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

从列返回 SQL 列定义

public **listTables** ([*mixed* $schemaName])

列出数据库中的所有表

```php
<?php

print_r(
    $connection->listTables("blog")
);

```

public **listViews** ([*mixed* $schemaName])

列出数据库中的所有视图

```php
<?php

print_r(
    $connection->listViews("blog")
);

```

public [Phalcon\Db\Index](Phalcon_Db_Index) **describeIndexes** (*string* $table, [*string* $schema])

列出表索引

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

public **tableOptions** (*mixed* $tableName, [*mixed* $schemaName])

获取表的选项

```php
<?php

print_r(
    $connection->tableOptions("robots")
);

```

public **createSavepoint** (*mixed* $name)

创建一个新的保存点

public **releaseSavepoint** (*mixed* $name)

释放给定的事务保存点

public **rollbackSavepoint** (*mixed* $name)

给定的事务保存点回滚

public **setNestedTransactionsWithSavepoints** (*mixed* $nestedTransactionsWithSavepoints)

设置嵌套事务是否应使用保存点

public **isNestedTransactionsWithSavepoints** ()

返回嵌套事务是否应使用保存点

public **getNestedTransactionSavepointName** ()

返回用于嵌套事务的保存点名称

public **getDefaultIdValue** ()

返回要插入到标识列中的默认标识值

```php
<?php

//为列'id'插入一个有效的默认值，创建新robots
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

返回默认值, 使 RBDM 使用表定义中声明的默认值

```php
<?php

//为列'year'插入一个有效的默认值的新机器人

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

检查数据库系统是否需要序列来生成自动数值

public **useExplicitIdValue** ()

检查数据库系统是否需要标识列的显式值

public **getDescriptor** ()

用于连接到活动数据库的返回描述符

public *string* **getConnectionId** ()

获取活动连接唯一标识符

public **getSQLStatement** ()

对象中的活动 SQL 语句

public **getRealSQLStatement** ()

不替换绑定参数的对象中的活动SQL语句

public *array* **getSQLBindTypes** ()

对象中的活动 SQL 语句

abstract public **connect** ([*array* $descriptor]) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **query** (*mixed* $sqlStatement, [*mixed* $placeholders], [*mixed* $dataTypes]) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **execute** (*mixed* $sqlStatement, [*mixed* $placeholders], [*mixed* $dataTypes]) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **affectedRows** () inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **close** () inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **escapeString** (*mixed* $str) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **lastInsertId** ([*mixed* $sequenceName]) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **begin** ([*mixed* $nesting]) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **rollback** ([*mixed* $nesting]) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **commit** ([*mixed* $nesting]) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **isUnderTransaction** () inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **getInternalHandler** () inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...

abstract public **describeColumns** (*mixed* $table, [*mixed* $schema]) inherited from [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface)

...