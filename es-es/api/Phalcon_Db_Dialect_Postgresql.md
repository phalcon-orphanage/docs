---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Db\Dialect\Postgresql'
---
# Class **Phalcon\Db\Dialect\Postgresql**

*extends* abstract class [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

*implements* [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/dialect/postgresql.zep)

Genera el SQL específico de base de datos para el PostgreSQL RDBMS

## Métodos

public **getColumnDefinition** ([Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

Obtiene el nombre de la columna en PostgreSQL

public **addColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

Genera SQL para agregar una columna a una tabla

public **modifyColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column, [[Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $currentColumn])

Genera SQL para modificar una columna a una tabla

public **dropColumn** (*mixed* $tableName, *mixed* $schemaName, *mixed* $columnName)

Genera SQL para borrar una columna de una tabla

public **addIndex** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index)

Genera SQL para agregar un índice a una tabla

public **dropIndex** (*mixed* $tableName, *mixed* $schemaName, *mixed* $indexName)

Generates SQL to delete an index from a table

public **addPrimaryKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index)

Genera SQL para agregar la clave principal a una tabla

public **dropPrimaryKey** (*mixed* $tableName, *mixed* $schemaName)

Genera SQL para agregar la clave principal a una tabla

public **addForeignKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ReferenceInterface](Phalcon_Db_ReferenceInterface) $reference)

Genera SQL para agregar un índice a una tabla

public **dropForeignKey** (*mixed* $tableName, *mixed* $schemaName, *mixed* $referenceName)

Genera SQL para eliminar una clave externa de una tabla

public **createTable** (*mixed* $tableName, *mixed* $schemaName, *array* $definition)

Genera SQL para crear una tabla

public **truncateTable** (*mixed* $tableName, *mixed* $schemaName)

Genera SQL para truncar una tabla

public **dropTable** (*mixed* $tableName, [*mixed* $schemaName], [*mixed* $ifExists])

Genera SQL para colocar una tabla

public **createView** (*mixed* $viewName, *array* $definition, [*mixed* $schemaName])

Genera SQL para crear una vista

public **dropView** (*mixed* $viewName, [*mixed* $schemaName], [*mixed* $ifExists])

Genera SQL para colocar una vista

public **tableExists** (*mixed* $tableName, [*mixed* $schemaName])

Genera SQL comprobando la existencia de un cuadro.esquema

```php
<?php

echo $dialect->tableExists("posts", "blog");

echo $dialect->tableExists("posts");

```

public **viewExists** (*mixed* $viewName, [*mixed* $schemaName])

Genera SQL comprobando la existencia de una vista.esquema

public **describeColumns** (*mixed* $table, [*mixed* $schema])

Genera SQL para describir una tabla

```php
<?php

print_r(
    $dialect->describeColumns("posts")
);

```

public **listTables** ([*mixed* $schemaName])

Hace una lista de todas las tablas en la base de datos

```php
<?php

print_r(
    $dialect->listTables("blog")
);

```

public *string* **listViews** ([*string* $schemaName])

Genera SQL para hacer una lista de todas las vistas de un esquema o usuario

public **describeIndexes** (*mixed* $table, [*mixed* $schema])

Genera SQL para consultar índices en una tabla

public **describeReferences** (*mixed* $table, [*mixed* $schema])

Genera SQL para consultar claves externas en una tabla

public **tableOptions** (*mixed* $table, [*mixed* $schema])

Genera el SQL para describir las opciones de creación de la tabla

protected **_castDefault** ([Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

...

protected **_getTableOptions** (*array* $definition)

...

public **registerCustomFunction** (*mixed* $name, *mixed* $customFunction) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Registra funciones personalizadas SQL

public **getCustomFunctions** () inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Devuelve funciones registradas

final public **escapeSchema** (*mixed* $str, [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Esquema de escape

final public **escape** (*mixed* $str, [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Identificadores de escape

public **limit** (*mixed* $sqlQuery, *mixed* $number) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Genera el SQL para la cláusula LIMIT

```php
<?php

$sql = $dialect->limit("SELECT * FROM robots", 10);
echo $sql; // SELECT * FROM robots LIMIT 10

$sql = $dialect->limit("SELECT * FROM robots", [10, 50]);
echo $sql; // SELECT * FROM robots LIMIT 10 OFFSET 50

```

public **forUpdate** (*mixed* $sqlQuery) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Devuelve un SQL con una cláusula DE ACTUALIZACIÓN

```php
<?php

$sql = $dialect->forUpdate("SELECT * FROM robots");
echo $sql; // SELECT * FROM robots FOR UPDATE

```

public **sharedLock** (*mixed* $sqlQuery) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Devuelve un SQL modificado con una cláusula de BLOQUEAR EN MODO COMPARTIR

```php
<?php

$sql = $dialect->sharedLock("SELECT * FROM robots");
echo $sql; // SELECT * FROM robots LOCK IN SHARE MODE

```

final public **getColumnList** (*array* $columnList, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

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

final public **getSqlColumn** (*mixed* $column, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resolver expresiones de columna

public **getSqlExpression** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Transforma una representación intermedia para una expresión en una expresión válida del sistema de base de datos

final public **getSqlTable** (*mixed* $table, [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Transforma una representación intermedia para una tabla/esquema en una expresión válida del sistema de base de datos

public **select** (*array* $definition) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Crea un estatus SELECT

public **supportsSavepoints** () inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Comprueba si la plataforma admite puntos de recuperación

public **supportsReleaseSavepoints** () inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Comprueba si la plataforma admite la liberación de puntos de recuperación.

public **createSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Genera un SQL para crear un nuevo punto de recuperación

public **releaseSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Generar SQL para liberar un punto de recuperación

public **rollbackSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Generar SQL para revertir un punto de recuperación

final protected **getSqlExpressionScalar** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resolver expresiones de columna

final protected **getSqlExpressionObject** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resolver expresiones de objetos

final protected **getSqlExpressionQualified** (*array* $expression, [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resolver expresiones calificadas

final protected **getSqlExpressionBinaryOperations** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resolver expresiones de operaciones binarias

final protected **getSqlExpressionUnaryOperations** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resolver expresiones de operaciones unarias

final protected **getSqlExpressionFunctionCall** (*array* $expression, *mixed* $escapeChar, [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resolver llamadas a funciones

final protected **getSqlExpressionList** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resolver listas

final protected **getSqlExpressionAll** (*array* $expression, [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resuelve *

final protected **getSqlExpressionCastValue** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resuelve CAST de valores

final protected **getSqlExpressionConvertValue** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resuelve CONVERT de codificaciones de valores

final protected **getSqlExpressionCase** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resuelve expresiones CASE

final protected **getSqlExpressionFrom** (*mixed* $expression, [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resuelve una cláusula FROM

final protected **getSqlExpressionJoins** (*mixed* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resuelve una cláusula JOINs

final protected **getSqlExpressionWhere** (*mixed* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resuelve una cláusula WHERE

final protected **getSqlExpressionGroupBy** (*mixed* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resuelve una cláusula GROUP BY

final protected **getSqlExpressionHaving** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resuelve una cláusula HAVING

final protected **getSqlExpressionOrderBy** (*mixed* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resuelve una cláusula ORDER BY

final protected **getSqlExpressionLimit** (*mixed* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Resuelve una cláusula LIMIT

protected **prepareColumnAlias** (*mixed* $qualified, [*mixed* $alias], [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Prepara una columna para este RDBMS

protected **prepareTable** (*mixed* $table, [*mixed* $schema], [*mixed* $alias], [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Prepara una tabla para este RDBMS

protected **prepareQualified** (*mixed* $column, [*mixed* $domain], [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Prepara calificado para este RDBMS