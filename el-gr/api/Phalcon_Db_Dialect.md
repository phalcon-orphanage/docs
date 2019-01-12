* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Db\Dialect'

* * *

# Abstract class **Phalcon\Db\Dialect**

*implements* [Phalcon\Db\DialectInterface](/4.0/en/api/Phalcon_Db_DialectInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/db/dialect.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This is the base class to each database dialect. This implements common methods to transform intermediate code into its RDBMS related syntax

## Methods

public **registerCustomFunction** (*mixed* $name, *mixed* $customFunction)

Registers custom SQL functions

public **getCustomFunctions** ()

Returns registered functions

final public **escapeSchema** (*mixed* $str, [*mixed* $escapeChar])

Escape Schema

final public **escape** (*mixed* $str, [*mixed* $escapeChar])

Escape identifiers

public **limit** (*mixed* $sqlQuery, *mixed* $number)

Generates the SQL for LIMIT clause

```php
<?php

$sql = $dialect->limit("SELECT * FROM robots", 10);
echo $sql; // SELECT * FROM robots LIMIT 10

$sql = $dialect->limit("SELECT * FROM robots", [10, 50]);
echo $sql; // SELECT * FROM robots LIMIT 10 OFFSET 50

```

public **forUpdate** (*mixed* $sqlQuery)

Returns a SQL modified with a FOR UPDATE clause

```php
<?php

$sql = $dialect->forUpdate("SELECT * FROM robots");
echo $sql; // SELECT * FROM robots FOR UPDATE

```

public **sharedLock** (*mixed* $sqlQuery)

Returns a SQL modified with a LOCK IN SHARE MODE clause

```php
<?php

$sql = $dialect->sharedLock("SELECT * FROM robots");
echo $sql; // SELECT * FROM robots LOCK IN SHARE MODE

```

final public **getColumnList** (*array* $columnList, [*mixed* $escapeChar], [*mixed* $bindCounts])

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

final public **getSqlColumn** (*mixed* $column, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resolve Column expressions

public **getSqlExpression** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Transforms an intermediate representation for an expression into a database system valid expression

final public **getSqlTable** (*mixed* $table, [*mixed* $escapeChar])

Transform an intermediate representation of a schema/table into a database system valid expression

public **select** (*array* $definition)

Builds a SELECT statement

public **supportsSavepoints** ()

Checks whether the platform supports savepoints

public **supportsReleaseSavepoints** ()

Checks whether the platform supports releasing savepoints.

public **createSavepoint** (*mixed* $name)

Generate SQL to create a new savepoint

public **releaseSavepoint** (*mixed* $name)

Generate SQL to release a savepoint

public **rollbackSavepoint** (*mixed* $name)

Generate SQL to rollback a savepoint

final protected **getSqlExpressionScalar** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resolve Column expressions

final protected **getSqlExpressionObject** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resolve object expressions

final protected **getSqlExpressionQualified** (*array* $expression, [*mixed* $escapeChar])

Resolve qualified expressions

final protected **getSqlExpressionBinaryOperations** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resolve binary operations expressions

final protected **getSqlExpressionUnaryOperations** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resolve unary operations expressions

final protected **getSqlExpressionFunctionCall** (*array* $expression, *mixed* $escapeChar, [*mixed* $bindCounts])

Resolve function calls

final protected **getSqlExpressionList** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resolve Lists

final protected **getSqlExpressionAll** (*array* $expression, [*mixed* $escapeChar])

Resolve *

final protected **getSqlExpressionCastValue** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resolve CAST of values

final protected **getSqlExpressionConvertValue** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resolve CONVERT of values encodings

final protected **getSqlExpressionCase** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resolve CASE expressions

final protected **getSqlExpressionFrom** (*mixed* $expression, [*mixed* $escapeChar])

Resolve a FROM clause

final protected **getSqlExpressionJoins** (*mixed* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resolve a JOINs clause

final protected **getSqlExpressionWhere** (*mixed* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resolve a WHERE clause

final protected **getSqlExpressionGroupBy** (*mixed* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resolve a GROUP BY clause

final protected **getSqlExpressionHaving** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resolve a HAVING clause

final protected **getSqlExpressionOrderBy** (*mixed* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resolve an ORDER BY clause

final protected **getSqlExpressionLimit** (*mixed* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resolve a LIMIT clause

protected **prepareColumnAlias** (*mixed* $qualified, [*mixed* $alias], [*mixed* $escapeChar])

Prepares column for this RDBMS

protected **prepareTable** (*mixed* $table, [*mixed* $schema], [*mixed* $alias], [*mixed* $escapeChar])

Prepares table for this RDBMS

protected **prepareQualified** (*mixed* $column, [*mixed* $domain], [*mixed* $escapeChar])

Prepares qualified for this RDBMS

abstract public **getColumnDefinition** ([Phalcon\Db\ColumnInterface](/4.0/en/api/Phalcon_Db_ColumnInterface) $column) inherited from [Phalcon\Db\DialectInterface](/4.0/en/api/Phalcon_Db_DialectInterface)

...

abstract public **addColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](/4.0/en/api/Phalcon_Db_ColumnInterface) $column) inherited from [Phalcon\Db\DialectInterface](/4.0/en/api/Phalcon_Db_DialectInterface)

...

abstract public **modifyColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](/4.0/en/api/Phalcon_Db_ColumnInterface) $column, [[Phalcon\Db\ColumnInterface](/4.0/en/api/Phalcon_Db_ColumnInterface) $currentColumn]) inherited from [Phalcon\Db\DialectInterface](/4.0/en/api/Phalcon_Db_DialectInterface)

...

abstract public **dropColumn** (*mixed* $tableName, *mixed* $schemaName, *mixed* $columnName) inherited from [Phalcon\Db\DialectInterface](/4.0/en/api/Phalcon_Db_DialectInterface)

...

abstract public **addIndex** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](/4.0/en/api/Phalcon_Db_IndexInterface) $index) inherited from [Phalcon\Db\DialectInterface](/4.0/en/api/Phalcon_Db_DialectInterface)

...

abstract public **dropIndex** (*mixed* $tableName, *mixed* $schemaName, *mixed* $indexName) inherited from [Phalcon\Db\DialectInterface](/4.0/en/api/Phalcon_Db_DialectInterface)

...

abstract public **addPrimaryKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](/4.0/en/api/Phalcon_Db_IndexInterface) $index) inherited from [Phalcon\Db\DialectInterface](/4.0/en/api/Phalcon_Db_DialectInterface)

...

abstract public **dropPrimaryKey** (*mixed* $tableName, *mixed* $schemaName) inherited from [Phalcon\Db\DialectInterface](/4.0/en/api/Phalcon_Db_DialectInterface)

...

abstract public **addForeignKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ReferenceInterface](/4.0/en/api/Phalcon_Db_ReferenceInterface) $reference) inherited from [Phalcon\Db\DialectInterface](/4.0/en/api/Phalcon_Db_DialectInterface)

...

abstract public **dropForeignKey** (*mixed* $tableName, *mixed* $schemaName, *mixed* $referenceName) inherited from [Phalcon\Db\DialectInterface](/4.0/en/api/Phalcon_Db_DialectInterface)

...

abstract public **createTable** (*mixed* $tableName, *mixed* $schemaName, *array* $definition) inherited from [Phalcon\Db\DialectInterface](/4.0/en/api/Phalcon_Db_DialectInterface)

...

abstract public **createView** (*mixed* $viewName, *array* $definition, [*mixed* $schemaName]) inherited from [Phalcon\Db\DialectInterface](/4.0/en/api/Phalcon_Db_DialectInterface)

...

abstract public **dropTable** (*mixed* $tableName, *mixed* $schemaName) inherited from [Phalcon\Db\DialectInterface](/4.0/en/api/Phalcon_Db_DialectInterface)

...

abstract public **dropView** (*mixed* $viewName, [*mixed* $schemaName], [*mixed* $ifExists]) inherited from [Phalcon\Db\DialectInterface](/4.0/en/api/Phalcon_Db_DialectInterface)

...

abstract public **tableExists** (*mixed* $tableName, [*mixed* $schemaName]) inherited from [Phalcon\Db\DialectInterface](/4.0/en/api/Phalcon_Db_DialectInterface)

...

abstract public **viewExists** (*mixed* $viewName, [*mixed* $schemaName]) inherited from [Phalcon\Db\DialectInterface](/4.0/en/api/Phalcon_Db_DialectInterface)

...

abstract public **describeColumns** (*mixed* $table, [*mixed* $schema]) inherited from [Phalcon\Db\DialectInterface](/4.0/en/api/Phalcon_Db_DialectInterface)

...

abstract public **listTables** ([*mixed* $schemaName]) inherited from [Phalcon\Db\DialectInterface](/4.0/en/api/Phalcon_Db_DialectInterface)

...

abstract public **describeIndexes** (*mixed* $table, [*mixed* $schema]) inherited from [Phalcon\Db\DialectInterface](/4.0/en/api/Phalcon_Db_DialectInterface)

...

abstract public **describeReferences** (*mixed* $table, [*mixed* $schema]) inherited from [Phalcon\Db\DialectInterface](/4.0/en/api/Phalcon_Db_DialectInterface)

...

abstract public **tableOptions** (*mixed* $table, [*mixed* $schema]) inherited from [Phalcon\Db\DialectInterface](/4.0/en/api/Phalcon_Db_DialectInterface)

...