---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Db\Adapter'
---
# Abstract class **Phalcon\Db\Adapter**

*implements* [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/adapter.zep)

Base class for Phalcon\Db adapters

## Métodos

public **getDialectType** ()

Nombre del dialecto usado

public **getType** ()

Tipo de la base de datos donde el adaptador es usado

public **getSqlVariables** ()

Parámetros de cotas activas SQL

public **__construct** (*array* $descriptor)

Phalcon\Db\Adapter constructor

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Establece el gestor de eventos

public **getEventsManager** ()

Devuelve el administrador de eventos interno

public **setDialect** ([Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface) $dialect)

Establece el dialecto usado para producir el SQL

public **getDialect** ()

Devuelve la instancia de dialecto interno

public **fetchOne** (*mixed* $sqlQuery, [*mixed* $fetchMode], [*mixed* $bindParams], [*mixed* $bindTypes])

Devuelve la primera fila de un resultado de consulta SQL

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

Vuelca el resultado completo de la consulta en una matriz

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

Devuelve el enésimo campo de la primera fila de un resultado de consulta SQL

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

Inserta datos en una tabla usando la sintaxis de SQL RDBMS personalizado

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

Inserta datos en una tabla usando la sintaxis RBDM SQL personalizado

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

Actualiza datos en una tabla usando la sintaxis RBDM SQL personalizado

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

Actualiza datos en una tabla utilizando la sintaxis RBDM SQL personalizado Otra, sintaxis más conveniente

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

Borra datos de una tabla usando la sintaxis RBDM SQL personalizado

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

Sacar un nombre de columna/tabla/esquema

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

Obtener una lista de columnas

public **limit** (*mixed* $sqlQuery, *mixed* $number)

Anexa una clausula LIMIT al argumento $sqlQuery

```php
<?php

echo $connection->limit("SELECT * FROM robots", 5);

```

public **tableExists** (*mixed* $tableName, [*mixed* $schemaName])

Genera SQL comprobando la existencia de un cuadro.esquema

```php
<?php

var_dump(
    $connection->tableExists("blog", "posts")
);

```

public **viewExists** (*mixed* $viewName, [*mixed* $schemaName])

Genera SQL comprobando la existencia de una vista.esquema

```php
<?php

var_dump(
    $connection->viewExists("active_users", "posts")
);

```

public **forUpdate** (*mixed* $sqlQuery)

Devuelve un SQL con una cláusula DE ACTUALIZACIÓN

public **sharedLock** (*mixed* $sqlQuery)

Devuelve un SQL modificado con una cláusula de BLOQUEAR EN MODO COMPARTIR

public **createTable** (*mixed* $tableName, *mixed* $schemaName, *array* $definition)

Crea una tabla

public **dropTable** (*mixed* $tableName, [*mixed* $schemaName], [*mixed* $ifExists])

Elimina una tabla del esquema/base de datos

public **createView** (*mixed* $viewName, *array* $definition, [*mixed* $schemaName])

Crea una vista

public **dropView** (*mixed* $viewName, [*mixed* $schemaName], [*mixed* $ifExists])

Quita una vista

public **addColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

Agrega una columna a la tabla

public **modifyColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column, [[Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $currentColumn])

Modifica una columna de la tabla basada en una definición

public **dropColumn** (*mixed* $tableName, *mixed* $schemaName, *mixed* $columnName)

Elimina una columna de una tabla

public **addIndex** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index)

Agrega un índice a la tabla

public **dropIndex** (*mixed* $tableName, *mixed* $schemaName, *mixed* $indexName)

Quita un índice de la tabla

public **addPrimaryKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index)

Agrega una clave primaria a la tabla

public **dropPrimaryKey** (*mixed* $tableName, *mixed* $schemaName)

Quita una clave primaria de la tabla

public **addForeignKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ReferenceInterface](Phalcon_Db_ReferenceInterface) $reference)

Agrega una clave externa a una tabla

public **dropForeignKey** (*mixed* $tableName, *mixed* $schemaName, *mixed* $referenceName)

Elimina una clave externa de la tabla

public **getColumnDefinition** ([Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

Devuelve la definición SQL de una columna

public **listTables** ([*mixed* $schemaName])

Lista de tablas en una base de datos

```php
<?php

print_r(
    $connection->listTables("blog")
);

```

public **listViews** ([*mixed* $schemaName])

Lista todas las vistas en una base de datos

```php
<?php

print_r(
    $connection->listViews("blog")
);

```

public [Phalcon\Db\Index](Phalcon_Db_Index) **describeIndexes** (*string* $table, [*string* $schema])

Lista las tablas de índices

```php
<?php

print_r(
    $connection->describeIndexes("robots_parts")
);

```

public **describeReferences** (*mixed* $table, [*mixed* $schema])

Lista de referencias de tablas

```php
<?php

print_r(
    $connection->describeReferences("robots_parts")
);

```

public **tableOptions** (*mixed* $tableName, [*mixed* $schemaName])

Obtiene opciones de creación de tablas

```php
<?php

print_r(
    $connection->tableOptions("robots")
);

```

public **createSavepoint** (*mixed* $name)

Crea un nuevo punto de guardado

public **releaseSavepoint** (*mixed* $name)

Publica punto dado de guardado

public **rollbackSavepoint** (*mixed* $name)

Retrasa un punto guardado dado

public **setNestedTransactionsWithSavepoints** (*mixed* $nestedTransactionsWithSavepoints)

Establecer si las transacciones anidadas deben usar puntos de guardado

public **isNestedTransactionsWithSavepoints** ()

Devuelve si las transacciones anidadas deben usar puntos de guardado

public **getNestedTransactionSavepointName** ()

Devuelve el nombre de un punto de guardado para uso con transacciones anidadas

public **getDefaultIdValue** ()

Devuelve el valor identidad predeterminado a ser insertados en una columna de identidad

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

Devuelve el valor predeterminado para hacer el uso del RBDM el valor predeterminado declarado en la definición de la tabla

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

Comprobar si las bases de datos del sistema requieren una secuencia para producir valores auto-numéricos

public **useExplicitIdValue** ()

Compruebe si el sistema de bases de datos requiere un valor explícito para las columnas de identidad

public **getDescriptor** ()

Devuelve el descriptor usado para conectar a la base de datos activa

public *string* **getConnectionId** ()

Obtener el identificador de conexión activa

public **getSQLStatement** ()

Active la declaración SQL en el objeto

public **getRealSQLStatement** ()

Active la declaración SQL en el objeto sin reemplazar los parámetros de enlace

public *array* **getSQLBindTypes** ()

Active la declaración SQL en el objeto

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