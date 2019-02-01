---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Db\Adapter\Pdo\Postgresql'
---
# Class **Phalcon\Db\Adapter\Pdo\Postgresql**

*extends* abstract class [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

*implements* [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/adapter/pdo/postgresql.zep)

Funciones específicas para el sistema de base de datos Postgresql

```php
<?php

use Phalcon\Db\Adapter\Pdo\Postgresql;

$config = [
    "host"     => "localhost",
    "dbname"   => "blog",
    "port"     => 5432,
    "username" => "postgres",
    "password" => "secret",
];

$connection = new Postgresql($config);

```

## Métodos

public **connect** ([*array* $descriptor])

This method is automatically called in Phalcon\Db\Adapter\Pdo constructor. Call it when you need to restore a database connection.

public **describeColumns** (*mixed* $table, [*mixed* $schema])

Returns an array of Phalcon\Db\Column objects describing a table

```php
<?php

print_r(
    $connection->describeColumns("posts")
);

```

public **createTable** (*mixed* $tableName, *mixed* $schemaName, *array* $definition)

Crea una tabla

public **modifyColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column, [[Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $currentColumn])

Modifica una columna de la tabla basada en una definición

public **useExplicitIdValue** ()

Compruebe si el sistema de bases de datos requiere un valor explícito para las columnas de identidad

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

public **supportSequences** ()

Comprobar si las bases de datos del sistema requieren una secuencia para producir valores auto-numéricos

public **__construct** (*array* $descriptor) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Constructor for Phalcon\Db\Adapter\Pdo

public **prepare** (*mixed* $sqlStatement) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Devuelve una declaración preparada en PDO para ser ejecutada con 'executePrepared'

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

public [PDOStatement](https://php.net/manual/en/class.pdostatement.php) **executePrepared** ([PDOStatement](https://php.net/manual/en/class.pdostatement.php) $statement, *array* $placeholders, *array* $dataTypes) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Executes a prepared statement binding. This function uses integer indexes starting from zero

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

public **query** (*mixed* $sqlStatement, [*mixed* $bindParams], [*mixed* $bindTypes]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Sends SQL statements to the database server returning the success state. Use this method only when the SQL statement sent to the server is returning rows

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

public **execute** (*mixed* $sqlStatement, [*mixed* $bindParams], [*mixed* $bindTypes]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Sends SQL statements to the database server returning the success state. Use this method only when the SQL statement sent to the server doesn't return any rows

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

public **affectedRows** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Devuelve el número de filas afectadas por el último INSERTAR/ACTUALIZAR/BORRAR ejecutado en el sistema de base de datos

```php
<?php

$connection->execute(
    "DELETE FROM robots"
);

echo $connection->affectedRows(), " were deleted";

```

public **close** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Closes the active connection returning success. Phalcon automatically closes and destroys active connections when the request ends

public **escapeString** (*mixed* $str) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Esquiva un valor para evitar las inyecciones SQL de acuerdo con la configuración de caracteres activa en la conexión

```php
<?php

$escapedStr = $connection->escapeString("some dangerous value");

```

public **convertBoundParams** (*mixed* $sql, [*array* $params]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Converts bound parameters such as :name: or ?1 into PDO bind params ?

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

public *int* | *boolean* **lastInsertId** ([*string* $sequenceName]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Devuelve el ID para la columna auto_increment/serial insertada en el último SQL ejecutado

```php
<?php

// Inserting a new robot
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

// Getting the generated id
$id = $connection->lastInsertId();

```

public **begin** ([*mixed* $nesting]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Inicia una transacción en la conexión

public **rollback** ([*mixed* $nesting]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Retrocede la transacción activa en la conexión

public **commit** ([*mixed* $nesting]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Confirma la transacción activa en la conexión

public **getTransactionLevel** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Devuelve el nivel de inserción de la transacción actual

public **isUnderTransaction** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Verifica si la conexión está debajo de una transacción

```php
<?php

$connection->begin();

// true
var_dump(
    $connection->isUnderTransaction()
);

```

public **getInternalHandler** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Devuelve el controlador PDO interno

public *array* **getErrorInfo** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Devuelve la información de error, si la hay

public **getDialectType** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Nombre del dialecto usado

public **getType** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Tipo de la base de datos donde el adaptador es usado

public **getSqlVariables** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Parámetros de cotas activas SQL

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Establece el gestor de eventos

public **getEventsManager** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Devuelve el administrador de eventos interno

public **setDialect** ([Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface) $dialect) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Establece el dialecto usado para producir el SQL

public **getDialect** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Devuelve la instancia de dialecto interno

public **fetchOne** (*mixed* $sqlQuery, [*mixed* $fetchMode], [*mixed* $bindParams], [*mixed* $bindTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

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

public *array* **fetchAll** (*string* $sqlQuery, [*int* $fetchMode], [*array* $bindParams], [*array* $bindTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

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

public *string* | ** **fetchColumn** (*string* $sqlQuery, [*array* $placeholders], [*int* | *string* $column]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

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

public *boolean* **insert** (*string* | *array* $table, *array* $values, [*array* $fields], [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

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

public *boolean* **insertAsDict** (*string* $table, *array* $data, [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

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

public *boolean* **update** (*string* | *array* $table, *array* $fields, *array* $values, [*string* | *array* $whereCondition], [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

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

public *boolean* **updateAsDict** (*string* $table, *array* $data, [*string* $whereCondition], [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

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

public *boolean* **delete** (*string* | *array* $table, [*string* $whereCondition], [*array* $placeholders], [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

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

public **escapeIdentifier** (*array* | *string* $identifier) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

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

public *string* **getColumnList** (*array* $columnList) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Obtener una lista de columnas

public **limit** (*mixed* $sqlQuery, *mixed* $number) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Anexa una clausula LIMIT al argumento $sqlQuery

```php
<?php

echo $connection->limit("SELECT * FROM robots", 5);

```

public **tableExists** (*mixed* $tableName, [*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Genera SQL comprobando la existencia de un cuadro.esquema

```php
<?php

var_dump(
    $connection->tableExists("blog", "posts")
);

```

public **viewExists** (*mixed* $viewName, [*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Genera SQL comprobando la existencia de una vista.esquema

```php
<?php

var_dump(
    $connection->viewExists("active_users", "posts")
);

```

public **forUpdate** (*mixed* $sqlQuery) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Devuelve un SQL con una cláusula DE ACTUALIZACIÓN

public **sharedLock** (*mixed* $sqlQuery) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Devuelve un SQL modificado con una cláusula de BLOQUEAR EN MODO COMPARTIR

public **dropTable** (*mixed* $tableName, [*mixed* $schemaName], [*mixed* $ifExists]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Elimina una tabla del esquema/base de datos

public **createView** (*mixed* $viewName, *array* $definition, [*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Crea una vista

public **dropView** (*mixed* $viewName, [*mixed* $schemaName], [*mixed* $ifExists]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Quita una vista

public **addColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Agrega una columna a la tabla

public **dropColumn** (*mixed* $tableName, *mixed* $schemaName, *mixed* $columnName) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Elimina una columna de una tabla

public **addIndex** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Agrega un índice a la tabla

public **dropIndex** (*mixed* $tableName, *mixed* $schemaName, *mixed* $indexName) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Quita un índice de la tabla

public **addPrimaryKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Agrega una clave primaria a la tabla

public **dropPrimaryKey** (*mixed* $tableName, *mixed* $schemaName) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Quita una clave primaria de la tabla

public **addForeignKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ReferenceInterface](Phalcon_Db_ReferenceInterface) $reference) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Agrega una clave externa a una tabla

public **dropForeignKey** (*mixed* $tableName, *mixed* $schemaName, *mixed* $referenceName) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Elimina una clave externa de la tabla

public **getColumnDefinition** ([Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Devuelve la definición SQL de una columna

public **listTables** ([*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Lista de tablas en una base de datos

```php
<?php

print_r(
    $connection->listTables("blog")
);

```

public **listViews** ([*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Lista todas las vistas en una base de datos

```php
<?php

print_r(
    $connection->listViews("blog")
);

```

public [Phalcon\Db\Index](Phalcon_Db_Index) **describeIndexes** (*string* $table, [*string* $schema]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Lista las tablas de índices

```php
<?php

print_r(
    $connection->describeIndexes("robots_parts")
);

```

public **describeReferences** (*mixed* $table, [*mixed* $schema]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Lista de referencias de tablas

```php
<?php

print_r(
    $connection->describeReferences("robots_parts")
);

```

public **tableOptions** (*mixed* $tableName, [*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Obtiene opciones de creación de tablas

```php
<?php

print_r(
    $connection->tableOptions("robots")
);

```

public **createSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Crea un nuevo punto de guardado

public **releaseSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Publica punto dado de guardado

public **rollbackSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Retrasa un punto guardado dado

public **setNestedTransactionsWithSavepoints** (*mixed* $nestedTransactionsWithSavepoints) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Establecer si las transacciones anidadas deben usar puntos de guardado

public **isNestedTransactionsWithSavepoints** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Devuelve si las transacciones anidadas deben usar puntos de guardado

public **getNestedTransactionSavepointName** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Devuelve el nombre de un punto de guardado para uso con transacciones anidadas

public **getDefaultValue** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

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

public **getDescriptor** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Devuelve el descriptor usado para conectar a la base de datos activa

public *string* **getConnectionId** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Obtener el identificador de conexión activa

public **getSQLStatement** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Active la declaración SQL en el objeto

public **getRealSQLStatement** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Active la declaración SQL en el objeto sin reemplazar los parámetros de enlace

public *array* **getSQLBindTypes** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Active la declaración SQL en el objeto