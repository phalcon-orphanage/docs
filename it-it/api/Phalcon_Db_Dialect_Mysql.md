* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Db\Dialect\Mysql'

* * *

# Class **Phalcon\Db\Dialect\Mysql**

*extends* abstract class [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

*implements* [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/db/dialect/mysql.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Generates database specific SQL for the MySQL RDBMS

## Methods

public **getColumnDefinition** ([Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

Gets the column name in MySQL

public **addColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

Generates SQL to add a column to a table

public **modifyColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column, [[Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $currentColumn])

Generates SQL to modify a column in a table

public **dropColumn** (*mixed* $tableName, *mixed* $schemaName, *mixed* $columnName)

Generates SQL to delete a column from a table

public **addIndex** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index)

Generates SQL to add an index to a table

public **dropIndex** (*mixed* $tableName, *mixed* $schemaName, *mixed* $indexName)

Generates SQL to delete an index from a table

public **addPrimaryKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index)

Generates SQL to add the primary key to a table

public **dropPrimaryKey** (*mixed* $tableName, *mixed* $schemaName)

Generates SQL to delete primary key from a table

public **addForeignKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ReferenceInterface](Phalcon_Db_ReferenceInterface) $reference)

Generates SQL to add an index to a table

public **dropForeignKey** (*mixed* $tableName, *mixed* $schemaName, *mixed* $referenceName)

Generates SQL to delete a foreign key from a table

public **createTable** (*mixed* $tableName, *mixed* $schemaName, *array* $definition)

Generates SQL to create a table

public **truncateTable** (*mixed* $tableName, *mixed* $schemaName)

Generates SQL to truncate a table

public **dropTable** (*mixed* $tableName, [*mixed* $schemaName], [*mixed* $ifExists])

Generates SQL to drop a table

public **createView** (*mixed* $viewName, *array* $definition, [*mixed* $schemaName])

Generates SQL to create a view

public **dropView** (*mixed* $viewName, [*mixed* $schemaName], [*mixed* $ifExists])

Generates SQL to drop a view

public **tableExists** (*mixed* $tableName, [*mixed* $schemaName])

Generates SQL checking for the existence of a schema.table

```php
<?php

echo $dialect->tableExists("posts", "blog");

echo $dialect->tableExists("posts");

```

public **viewExists** (*mixed* $viewName, [*mixed* $schemaName])

Generates SQL checking for the existence of a schema.view

public **describeColumns** (*mixed* $table, [*mixed* $schema])

Generates SQL describing a table

```php
<?php

print_r(
    $dialect->describeColumns("posts")
);

```

public **listTables** ([*mixed* $schemaName])

List all tables in database

```php
<?php

print_r(
    $dialect->listTables("blog")
);

```

public **listViews** ([*mixed* $schemaName])

Generates the SQL to list all views of a schema or user

public **describeIndexes** (*mixed* $table, [*mixed* $schema])

Generates SQL to query indexes on a table

public **describeReferences** (*mixed* $table, [*mixed* $schema])

Generates SQL to query foreign keys on a table

public **tableOptions** (*mixed* $table, [*mixed* $schema])

Generates the SQL to describe the table creation options

protected **_getTableOptions** (*array* $definition)

Generates SQL to add the table creation options

public **registerCustomFunction** (*mixed* $name, *mixed* $customFunction) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Registers custom SQL functions

public **getCustomFunctions** () inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Returns registered functions

final public **escapeSchema** (*mixed* $str, [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Escape Schema

final public **escape** (*mixed* $str, [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Escape identifiers

public **limit** (*mixed* $sqlQuery, *mixed* $number) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Generates the SQL for LIMIT clause

```php
<?php

$sql = $dialect->limit("SELECT * FROM robots", 10);
echo $sql; // SELECT * FROM robots LIMIT 10

$sql = $dialect->limit("SELECT * FROM robots", [10, 50]);
echo $sql; // SELECT * FROM robots LIMIT 10 OFFSET 50

```

public **forUpdate** (*mixed* $sqlQuery) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Returns a SQL modified with a FOR UPDATE clause

```php
<?php

$sql = $dialect->forUpdate("SELECT * FROM robots");
echo $sql; // SELECT * FROM robots FOR UPDATE

```

public **sharedLock** (*mixed* $sqlQuery) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Returns a SQL modified with a LOCK IN SHARE MODE clause

```php
<?php

$sql = $dialect->sharedLock("SELECT * FROM robots");
echo $sql; // SELECT * FROM robots LOCK IN SHARE MODE

```

final public **getColumnList** (*array* $columnList, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Gets a list of columns with escaped identifiers

```php
<?php

echo $dialect->getColumnList(
    [
        "column1",
        "column",
    ]
);

```

final public **getSqlColumn** (*mixed* $column, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resolve Column expressions

public **getSqlExpression** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Transforms an intermediate representation for an expression into a database system valid expression

final public **getSqlTable** (*mixed* $table, [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Transform an intermediate representation of a schema/table into a database system valid expression

public **select** (*array* $definition) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Builds a SELECT statement

public **supportsSavepoints** () inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Checks whether the platform supports savepoints

public **supportsReleaseSavepoints** () inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Checks whether the platform supports releasing savepoints.

public **createSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Generate SQL to create a new savepoint

public **releaseSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Generate SQL to release a savepoint

public **rollbackSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Generate SQL to rollback a savepoint

final protected **getSqlExpressionScalar** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resolve Column expressions

final protected **getSqlExpressionObject** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resolve object expressions

final protected **getSqlExpressionQualified** (*array* $expression, [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resolve qualified expressions

final protected **getSqlExpressionBinaryOperations** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resolve binary operations expressions

final protected **getSqlExpressionUnaryOperations** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resolve unary operations expressions

final protected **getSqlExpressionFunctionCall** (*array* $expression, *mixed* $escapeChar, [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resolve function calls

final protected **getSqlExpressionList** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resolve Lists

final protected **getSqlExpressionAll** (*array* $expression, [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resolve *

final protected **getSqlExpressionCastValue** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resolve CAST of values

final protected **getSqlExpressionConvertValue** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resolve CONVERT of values encodings

final protected **getSqlExpressionCase** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resolve CASE expressions

final protected **getSqlExpressionFrom** (*mixed* $expression, [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resolve a FROM clause

final protected **getSqlExpressionJoins** (*mixed* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resolve a JOINs clause

final protected **getSqlExpressionWhere** (*mixed* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resolve a WHERE clause

final protected **getSqlExpressionGroupBy** (*mixed* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resolve a GROUP BY clause

final protected **getSqlExpressionHaving** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resolve a HAVING clause

final protected **getSqlExpressionOrderBy** (*mixed* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resolve an ORDER BY clause

final protected **getSqlExpressionLimit** (*mixed* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resolve a LIMIT clause

protected **prepareColumnAlias** (*mixed* $qualified, [*mixed* $alias], [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Prepares column for this RDBMS

protected **prepareTable** (*mixed* $table, [*mixed* $schema], [*mixed* $alias], [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Prepares table for this RDBMS

protected **prepareQualified** (*mixed* $column, [*mixed* $domain], [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Prepares qualified for this RDBMS