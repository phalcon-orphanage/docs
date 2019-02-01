---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Db\Adapter'
---
# Abstract class **Phalcon\Db\Adapter**

*implements* [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/adapter.zep)

Base class for Phalcon\Db adapters

## Methoden

public **getDialectType** ()

Name des verwendeten Dialekts

public **getType** ()

Typ des Datenbanksystems für den der Adapter dient

public **getSqlVariables** ()

Aktive SQL gebunden Parametervariablen

public **__construct** (*array* $descriptor)

Phalcon\Db\Adapter constructor

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Legt den Event-manager fest

public **getEventsManager** ()

Gibt den internen Eventmanager zurück

public **setDialect** ([Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface) $dialect)

Legt den Dialekt fest, welcher verwendet wird, um die SQL-Anweisung zu produzieren

public **getDialect** ()

Gibt interne Dialekt-Instanz zurück

public **fetchOne** (*mixed* $sqlQuery, [*mixed* $fetchMode], [*mixed* $bindParams], [*mixed* $bindTypes])

Gibt die erste Zeile aus einem SQL-Abfrage-Ergebnis zurück

```php
<?php

// Den ersten robot holen
$robot = $connection->fetchOne("SELECT * FROM robots");
print_r($robot);

// Den ersten robot nur mit associativen indices holen
$robot = $connection->fetchOne("SELECT * FROM robots", \Phalcon\Db::FETCH_ASSOC);
print_r($robot);

```

public *array* **fetchAll** (*string* $sqlQuery, [*int* $fetchMode], [*array* $bindParams], [*array* $bindTypes])

Sichert das komplette Ergebnis einer Abfrage in ein array

```php
<?php

// Alle robots nur mit associativen indices ermitteln
$robots = $connection->fetchAll(
    "SELECT * FROM robots",
    \Phalcon\Db::FETCH_ASSOC
);

foreach ($robots as $robot) {
    print_r($robot);
}

 // Alle robots ermitteln, welche das wort "robot" im Namen enthalten
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

Gibt das n-te Feld der ersten Zeile aus einem SQL-Abfrage-Ergebnis zurück

```php
<?php

// Ermittlelt die Anzahl von robots
$robotsCount = $connection->fetchColumn("SELECT count(*) FROM robots");
print_r($robotsCount);

// Den Namen des zuletzt geänderten robots ermitteln
$robot = $connection->fetchColumn(
    "SELECT id, name FROM robots order by modified desc",
    1
);
print_r($robot);

```

public *boolean* **insert** (*string* | *array* $table, *array* $values, [*array* $fields], [*array* $dataTypes])

Daten in eine Tabelle einfügen mithilfe von benutzerdefinierter RDBMS SQL-Syntax

```php
<?php

// Einen neuen robot hinzufügen
$success = $connection->insert(
    "robots",
    ["Astro Boy", 1952],
    ["name", "year"]
);

// Die folgende SQL Anweisung wird zum Datenbanmk Systen gesendet
INSERT INTO `robots` (`name`, `year`) VALUES ("Astro boy", 1952);

```

public *boolean* **insertAsDict** (*string* $table, *array* $data, [*array* $dataTypes])

Daten in eine Tabelle einfügen mithilfe von benutzerdefinierter RDBMS SQL-Syntax

```php
<?php

// Einen neuen robot hinzufügen
$success = $connection->insertAsDict(
    "robots",
    [
        "name" => "Astro Boy",
        "year" => 1952,
    ]
);

// Die folgende SQL Anweisung wird an das Datenbanksystem gesendet
INSERT INTO `robots` (`name`, `year`) VALUES ("Astro boy", 1952);

```

public *boolean* **update** (*string* | *array* $table, *array* $fields, *array* $values, [*string* | *array* $whereCondition], [*array* $dataTypes])

Daten in eine Tabelle ändern mithilfe von benutzerdefinierter RDBMS SQL-Syntax

```php
<?php

// Vorhandenen robot ändern
$success = $connection->update(
    "robots",
    ["name"],
    ["New Astro Boy"],
    "id = 101"
);

// Die folgende SQL Anweisung wird an das Datenbanksystem gesendet
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

Aktualisiert die Daten in einer Tabelle mit benutzerdefinierter RBDM SQL-Syntax Eine weitere, sehr komfortable Syntax

```php
<?php

// Vorhandenen robot ändern
$success = $connection->updateAsDict(
    "robots",
    [
        "name" => "New Astro Boy",
    ],
    "id = 101"
);

// Die folgende SQL Anweisung wird an das Datenbanksystem gesendet
UPDATE `robots` SET `name` = "Astro boy" WHERE id = 101

```

public *boolean* **delete** (*string* | *array* $table, [*string* $whereCondition], [*array* $placeholders], [*array* $dataTypes])

Daten in eine Tabelle löschen mithilfe von benutzerdefinierter RDBMS SQL-Syntax

```php
<?php

// Vorhandenen robot löschen
$success = $connection->delete(
    "robots",
    "id = 101"
);

// Die folgende SQL Anweisung wird generiert
DELETE FROM `robots` WHERE `id` = 101

```

public **escapeIdentifier** (*array* | *string* $identifier)

Maskiert einen Spalten/Tabellen/Schema Namen

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

Gibt eine Liste der Spalten zurück

public **limit** (*mixed* $sqlQuery, *mixed* $number)

Fügt eine LIMIT-Klausel zum $sqlQuery argument hinzu

```php
<?php

echo $connection->limit("SELECT * FROM robots", 5);

```

public **tableExists** (*mixed* $tableName, [*mixed* $schemaName])

Generates SQL checking for the existence of a schema.table

```php
<?php

var_dump(
    $connection->tableExists("blog", "posts")
);

```

public **viewExists** (*mixed* $viewName, [*mixed* $schemaName])

Generates SQL checking for the existence of a schema.view

```php
<?php

var_dump(
    $connection->viewExists("active_users", "posts")
);

```

public **forUpdate** (*mixed* $sqlQuery)

Liefert ein SQL, welches mit der FOR UPDATE-Klausel angepasst wurde

public **sharedLock** (*mixed* $sqlQuery)

Returns a SQL modified with a LOCK IN SHARE MODE clause

public **createTable** (*mixed* $tableName, *mixed* $schemaName, *array* $definition)

Erstellt eine Tabelle

public **dropTable** (*mixed* $tableName, [*mixed* $schemaName], [*mixed* $ifExists])

Löscht eine Tabelle aus einem Schema/Datenbank

public **createView** (*mixed* $viewName, *array* $definition, [*mixed* $schemaName])

Erstellen eine View

public **dropView** (*mixed* $viewName, [*mixed* $schemaName], [*mixed* $ifExists])

Löscht eine View

public **addColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

Fügt eine Spalte zu einer Tabelle hinzu

public **modifyColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column, [[Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $currentColumn])

Ändert eine Spalte einer Tabelle auf der Grundlage einer definition

public **dropColumn** (*mixed* $tableName, *mixed* $schemaName, *mixed* $columnName)

Löscht eine Spalte aus einer Tabelle

public **addIndex** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index)

Fügt einen Index zu einer Tabelle hinzu

public **dropIndex** (*mixed* $tableName, *mixed* $schemaName, *mixed* $indexName)

Löscht einen Index aus einer Tabelle

public **addPrimaryKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index)

Fügt einen Primärschlüssel einer Tabelle hinzu

public **dropPrimaryKey** (*mixed* $tableName, *mixed* $schemaName)

Löscht den Primärschlüssel einer Tabelle

public **addForeignKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ReferenceInterface](Phalcon_Db_ReferenceInterface) $reference)

Fügt einen Fremdschlüssel einer Tabelle hinzu

public **dropForeignKey** (*mixed* $tableName, *mixed* $schemaName, *mixed* $referenceName)

Löscht einen Fremdschlüssel aus einer Tabelle

public **getColumnDefinition** ([Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column)

Liefert die SQL Spaltendefinition einer Spalte

public **listTables** ([*mixed* $schemaName])

Listet alle Tabellen in einer Datenbank

```php
<?php

print_r(
    $connection->listTables("blog")
);

```

public **listViews** ([*mixed* $schemaName])

Listet alle Views in einer Datenbank

```php
<?php

print_r(
    $connection->listViews("blog")
);

```

public [Phalcon\Db\Index](Phalcon_Db_Index) **describeIndexes** (*string* $table, [*string* $schema])

Listet die Tabellenindices

```php
<?php

print_r(
    $connection->describeIndexes("robots_parts")
);

```

public **describeReferences** (*mixed* $table, [*mixed* $schema])

Listet Tabellenverweise

```php
<?php

print_r(
    $connection->describeReferences("robots_parts")
);

```

public **tableOptions** (*mixed* $tableName, [*mixed* $schemaName])

Gets creation options from a table

```php
<?php

print_r(
    $connection->tableOptions("robots")
);

```

public **createSavepoint** (*mixed* $name)

Erstellt einen neuen Speicherpunkt

public **releaseSavepoint** (*mixed* $name)

Gibt einen Speicherpunkt frei

public **rollbackSavepoint** (*mixed* $name)

Rollbacks given savepoint

public **setNestedTransactionsWithSavepoints** (*mixed* $nestedTransactionsWithSavepoints)

Wenn geschachtelte Transaktionen Speicherpunkte verwenden sollen

public **isNestedTransactionsWithSavepoints** ()

Gibt zurück, ob geschachtelte Transaktionen Speicherpunkte verwenden sollen

public **getNestedTransactionSavepointName** ()

Returns the savepoint name to use for nested transactions

public **getDefaultIdValue** ()

Returns the default identity value to be inserted in an identity column

```php
<?php

//Legt einen neuen robot mit gültigen Standardwert für die Spalte 'id' an
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

Returns the default value to make the RBDM use the default value declared in the table definition

```php
<?php

// legt einen neuen robot mit Standardwert für die Spalte 'year' an
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

Prüft, ob das Datenbanksystem eine Sequenz benötigt um automatisch numerische Werte zu erzeugen

public **useExplicitIdValue** ()

Check whether the database system requires an explicit value for identity columns

public **getDescriptor** ()

Return descriptor used to connect to the active database

public *string* **getConnectionId** ()

Gets the active connection unique identifier

public **getSQLStatement** ()

Active SQL statement in the object

public **getRealSQLStatement** ()

Active SQL statement in the object without replace bound parameters

public *array* **getSQLBindTypes** ()

Active SQL statement in the object

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