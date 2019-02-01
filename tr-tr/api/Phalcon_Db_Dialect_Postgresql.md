---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Db\Dialect\Postgresql'
---
# Class **Phalcon\Db\Dialect\Postgresql**

*extends* abstract class [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

*implements* [Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/dialect/postgresql.zep)

PostgreSQL RDBMS için veritabanına özgü SQL üretir

## Metodlar

public **getColumnDefinition** ([Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

PostgreSQL'de sütun adını döndürür

public **addColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

Bir tabloya bir sütun eklemek için SQL oluşturur

public **modifyColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column, [[Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $currentColumn])

Bir tablodaki bir sütunda değişlik yapmak için SQL oluşturur

public **dropColumn** (*mixed* $tableName, *mixed* $schemaName, *mixed* $columnName)

Bir tablodaki bir sütunu silmek için SQL oluşturur

public **addIndex** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index)

Bir tabloya bir işaret eklemek için SQL oluşturur

public **dropIndex** (*mixed* $tableName, *mixed* $schemaName, *mixed* $indexName)

Generates SQL to delete an index from a table

public **addPrimaryKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index)

Bir tabloya temel anahtarı eklemek için SQL oluşturur

public **dropPrimaryKey** (*mixed* $tableName, *mixed* $schemaName)

Bir tablodan temel anahtarı silmek için SQL oluşturur

public **addForeignKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ReferenceInterface](Phalcon_Db_ReferenceInterface) $reference)

Bir tabloya bir işaret eklemek için SQL oluşturur

public **dropForeignKey** (*mixed* $tableName, *mixed* $schemaName, *mixed* $referenceName)

Bir tablodan yabancı bir anahtar silmek için SQL oluşturur

public **createTable** (*mixed* $tableName, *mixed* $schemaName, *array* $definition)

Bir tablo oluşturmak için SQL oluşturur

public **truncateTable** (*mixed* $tableName, *mixed* $schemaName)

Bir tabloyu kesmek için SQL oluşturur

public **dropTable** (*mixed* $tableName, [*mixed* $schemaName], [*mixed* $ifExists])

Bir tablo düşürmek için SQL oluşturur

public **createView** (*mixed* $viewName, *array* $definition, [*mixed* $schemaName])

Bir görünüm yaratmak için SQL oluşturur

public **dropView** (*mixed* $viewName, [*mixed* $schemaName], [*mixed* $ifExists])

Bir görünüm bırakmak için SQL üretir

public **tableExists** (*mixed* $tableName, [*mixed* $schemaName])

Bir schema.table varlığı için SQL denetimi üretir

```php
<?php

echo $dialect->tableExists("posts", "blog");

echo $dialect->tableExists("posts");

```

public **viewExists** (*mixed* $viewName, [*mixed* $schemaName])

Bir schema.view varlığı için SQL denetimi üretir

public **describeColumns** (*mixed* $table, [*mixed* $schema])

Bir tabloyu tanımlayan SQL üretir

```php
<?php

print_r(
    $dialect->describeColumns("posts")
);

```

public **listTables** ([*mixed* $schemaName])

Veritabanındaki tüm tabloları listele

```php
<?php

print_r(
    $dialect->listTables("blog")
);

```

public *string* **listViews** ([*string* $schemaName])

Bir şemanın veya kullanıcının tüm görünümlerini listelemek için SQL oluşturur

public **describeIndexes** (*mixed* $table, [*mixed* $schema])

Bir tabloda dizinleri sorgulamak için SQL oluşturur

public **describeReferences** (*mixed* $table, [*mixed* $schema])

Bir tabloda yabancı anahtarları sorgulamak için SQL oluşturur

public **tableOptions** (*mixed* $table, [*mixed* $schema])

Tablo oluşturma seçeneklerini açıklamak için SQL oluşturur

protected **_castDefault** ([Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

...

protected **_getTableOptions** (*array* $definition)

...

public **registerCustomFunction** (*mixed* $name, *mixed* $customFunction) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Özel SQL işlevlerini kaydeder

public **getCustomFunctions** () inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Kayıtlı işlevleri döndürür

final public **escapeSchema** (*mixed* $str, [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Escape Schema

final public **escape** (*mixed* $str, [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Escapar de identificadores

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

Bir FOR UPDATE yan tümcesiyle değiştirilmiş bir SQL döndürür

```php
<?php

$sql = $dialect->forUpdate("SELECT * FROM robots");
echo $sql; // SELECT * FROM robots FOR UPDATE

```

public **sharedLock** (*mixed* $sqlQuery) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Bir LOCK IN SHARE MODE yan tümcesiyle değiştirilmiş bir SQL döndürür

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

Sütun ifadelerini çözümle

public **getSqlExpression** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Bir ifade için bir ara temsilini bir veritabanı sistemi geçerli ifadesine dönüştürür

final public **getSqlTable** (*mixed* $table, [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Transform an intermediate representation of a schema/table into a database system valid expression

public **select** (*array* $definition) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Builds a SELECT statement

public **supportsSavepoints** () inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Checks whether the platform supports savepoints

public **supportsReleaseSavepoints** () inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Platformun kayıt noktalarını serbest bırakmayı destekleyip desteklemediğini kontrol eder.

public **createSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Generate SQL to create a new savepoint

public **releaseSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Generate SQL to release a savepoint

public **rollbackSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Generate SQL to rollback a savepoint

final protected **getSqlExpressionScalar** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Sütun ifadelerini çözümle

final protected **getSqlExpressionObject** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Nesne ifadelerini çözümle

final protected **getSqlExpressionQualified** (*array* $expression, [*mixed* $escapeChar]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Nitelikli ifadeleri çözümle

final protected **getSqlExpressionBinaryOperations** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

İkili işlem ifadelerini çöz

final protected **getSqlExpressionUnaryOperations** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Tekli işlem ifadelerini çöz

final protected **getSqlExpressionFunctionCall** (*array* $expression, *mixed* $escapeChar, [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

İşlev çağrılarını çözümle

final protected **getSqlExpressionList** (*array* $expression, [*mixed* $escapeChar], [*mixed* $bindCounts]) inherited from [Phalcon\Db\Dialect](Phalcon_Db_Dialect)

Listeleri Çözümle

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