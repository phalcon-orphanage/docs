---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Db\Dialect'
---
# Abstract class **Phalcon\Db\Dialect**

*implements* [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/dialect.zep)

This is the base class to each database dialect. This implements common methods to transform intermediate code into its RDBMS related syntax

## Métodos

public **registerCustomFunction** (*mixed* $name, *mixed* $customFunction)

Registra funciones personalizadas SQL

public **getCustomFunctions** ()

Devuelve funciones registradas

final public **escapeSchema** (*mixed* $str, [*mixed* $escapeChar])

Esquema de escape

final public **escape** (*mixed* $str, [*mixed* $escapeChar])

Identificadores de escape

public **limit** (*mixed* $sqlQuery, *mixed* $number)

Genera el SQL para la cláusula LIMIT

```php
<?php

$sql = $dialect->limit("SELECT * FROM robots", 10);
echo $sql; // SELECT * FROM robots LIMIT 10

$sql = $dialect->limit("SELECT * FROM robots", [10, 50]);
echo $sql; // SELECT * FROM robots LIMIT 10 OFFSET 50

```

public **forUpdate** (*mixed* $sqlQuery)

Devuelve un SQL con una cláusula DE ACTUALIZACIÓN

```php
<?php

$sql = $dialect->forUpdate("SELECT * FROM robots");
echo $sql; // SELECT * FROM robots FOR UPDATE

```

public **sharedLock** (*mixed* $sqlQuery)

Devuelve un SQL modificado con una cláusula de BLOQUEAR EN MODO COMPARTIR

```php
<?php

$sql = $dialect->sharedLock("SELECT * FROM robots");
echo $sql; // SELECT * FROM robots LOCK IN SHARE MODE

```

final public **getColumnList** (*array* $columnList, [*mixed* $escapeChar], [*mixed* $bindCounts])

Obtiene una lista de columnas con identificadores escapados

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

Resolver expresiones de columna

public **getSqlExpression** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Transforma una representación intermedia para una expresión en una expresión válida del sistema de base de datos

final public **getSqlTable** (*mixed* $table, [*mixed* $escapeChar])

Transforma una representación intermedia para una tabla/esquema en una expresión válida del sistema de base de datos

public **select** (*array* $definition)

Crea un estatus SELECT

public **supportsSavepoints** ()

Comprueba si la plataforma admite puntos de recuperación

public **supportsReleaseSavepoints** ()

Comprueba si la plataforma admite la liberación de puntos de recuperación.

public **createSavepoint** (*mixed* $name)

Genera un SQL para crear un nuevo punto de recuperación

public **releaseSavepoint** (*mixed* $name)

Generar SQL para liberar un punto de recuperación

public **rollbackSavepoint** (*mixed* $name)

Generar SQL para revertir un punto de recuperación

final protected **getSqlExpressionScalar** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resolver expresiones de columna

final protected **getSqlExpressionObject** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resolver expresiones de objetos

final protected **getSqlExpressionQualified** (*array* $expression, [*mixed* $escapeChar])

Resolver expresiones calificadas

final protected **getSqlExpressionBinaryOperations** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resolver expresiones de operaciones binarias

final protected **getSqlExpressionUnaryOperations** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resolver expresiones de operaciones unarias

final protected **getSqlExpressionFunctionCall** (*array* $expression, *mixed* $escapeChar, [*mixed* $bindCounts])

Resolver llamadas a funciones

final protected **getSqlExpressionList** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resolver listas

final protected **getSqlExpressionAll** (*array* $expression, [*mixed* $escapeChar])

Resuelve *

final protected **getSqlExpressionCastValue** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resuelve CAST de valores

final protected **getSqlExpressionConvertValue** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resuelve CONVERT de codificaciones de valores

final protected **getSqlExpressionCase** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resuelve expresiones CASE

final protected **getSqlExpressionFrom** (*mixed* $expression, [*mixed* $escapeChar])

Resuelve una cláusula FROM

final protected **getSqlExpressionJoins** (*mixed* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resuelve una cláusula JOINs

final protected **getSqlExpressionWhere** (*mixed* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resuelve una cláusula WHERE

final protected **getSqlExpressionGroupBy** (*mixed* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resuelve una cláusula GROUP BY

final protected **getSqlExpressionHaving** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resuelve una cláusula HAVING

final protected **getSqlExpressionOrderBy** (*mixed* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resuelve una cláusula ORDER BY

final protected **getSqlExpressionLimit** (*mixed* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts])

Resuelve una cláusula LIMIT

protected **prepareColumnAlias** (*mixed* $qualified, [*mixed* $alias], [*mixed* $escapeChar])

Prepara una columna para este RDBMS

protected **prepareTable** (*mixed* $table, [*mixed* $schema], [*mixed* $alias], [*mixed* $escapeChar])

Prepara una tabla para este RDBMS

protected **prepareQualified** (*mixed* $column, [*mixed* $domain], [*mixed* $escapeChar])

Prepara calificado para este RDBMS

abstract public **getColumnDefinition** ([Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **addColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **modifyColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column, [[Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $currentColumn]) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **dropColumn** (*mixed* $tableName, *mixed* $schemaName, *mixed* $columnName) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **addIndex** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **dropIndex** (*mixed* $tableName, *mixed* $schemaName, *mixed* $indexName) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **addPrimaryKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **dropPrimaryKey** (*mixed* $tableName, *mixed* $schemaName) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **addForeignKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ReferenceInterface](Phalcon_Db_ReferenceInterface) $reference) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **dropForeignKey** (*mixed* $tableName, *mixed* $schemaName, *mixed* $referenceName) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **createTable** (*mixed* $tableName, *mixed* $schemaName, *array* $definition) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **createView** (*mixed* $viewName, *array* $definition, [*mixed* $schemaName]) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **dropTable** (*mixed* $tableName, *mixed* $schemaName) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **dropView** (*mixed* $viewName, [*mixed* $schemaName], [*mixed* $ifExists]) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **tableExists** (*mixed* $tableName, [*mixed* $schemaName]) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **viewExists** (*mixed* $viewName, [*mixed* $schemaName]) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **describeColumns** (*mixed* $table, [*mixed* $schema]) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **listTables** ([*mixed* $schemaName]) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **describeIndexes** (*mixed* $table, [*mixed* $schema]) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **describeReferences** (*mixed* $table, [*mixed* $schema]) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...

abstract public **tableOptions** (*mixed* $table, [*mixed* $schema]) inherited from [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

...