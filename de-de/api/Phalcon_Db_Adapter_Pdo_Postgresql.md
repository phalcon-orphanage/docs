---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Db\Adapter\Pdo\Postgresql'
---
# Class **Phalcon\Db\Adapter\Pdo\Postgresql**

*extends* abstract class [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

*implements* [Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/adapter/pdo/postgresql.zep)

Spezielle Funktionen für das Postgresql-Datenbank-System

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

## Methoden

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

Erstellt eine Tabelle

public **modifyColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column, [[Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $currentColumn])

Ändert eine Spalte einer Tabelle auf der Grundlage einer definition

public **useExplicitIdValue** ()

Check whether the database system requires an explicit value for identity columns

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

public **supportSequences** ()

Prüft, ob das Datenbanksystem eine Sequenz benötigt um automatisch numerische Werte zu erzeugen

public **__construct** (*array* $descriptor) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Constructor for Phalcon\Db\Adapter\Pdo

public **prepare** (*mixed* $sqlStatement) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Gibt ein PDO prepared statement zurück, welches mit 'executePrepared' ausgeführt werden soll

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

// Daten anfragen
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

// Daten einfügen
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

Liefert die Anzahl der betroffenen Zeilen welche vom letzten INSERT/UPDATE/DELETE im Datenbanksystem ausgeführt wurde

```php
<?php

$connection->execute(
    "DELETE FROM robots"
);

echo $connection->affectedRows(), " wurden gelöscht";

```

public **close** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Closes the active connection returning success. Phalcon automatically closes and destroys active connections when the request ends

public **escapeString** (*mixed* $str) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Maskiert einen Wert gemäß dem aktiven Zeichensatz der Verbindung, um SQL-Injektionen zu vermeiden

```php
<?php

$escapedStr = $connection->escapeString("irgendein gefährlicher Wert");

```

public **convertBoundParams** (*mixed* $sql, [*array* $params]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Konvertiert gebundene Parameter wie :name: oder ?1 in PDO bind Parameter?

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

Gibt die erzeugte id des neuen Datensatzes für die increment/seriell-Spalte zurück, welche in der zuletzt ausgeführte SQL-Anweisung eingefügt wurde

```php
<?php

// Einen neuen Roboter einfügen
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

// Die generierte Id holen
$id = $connection->lastInsertId();

```

public **begin** ([*mixed* $nesting]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Startet eine Transaktion in der Verbindung

public **rollback** ([*mixed* $nesting]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Rollt die aktive Transaktion in der Verbindung zurück

public **commit** ([*mixed* $nesting]) inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Bestätigt die aktive Transaktion in der Verbindung

public **getTransactionLevel** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Gibt die aktuelle Transaktion Schachtelungsebene zurück

public **isUnderTransaction** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Prüft, ob die Verbindung unter einer Transaktion läuft

```php
<?php

$connection->begin();

// true
var_dump(
    $connection->isUnderTransaction()
);

```

public **getInternalHandler** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Gibt den internen PDO-Handler zurück

public *array* **getErrorInfo** () inherited from [Phalcon\Db\Adapter\Pdo](Phalcon_Db_Adapter_Pdo)

Gibt die Fehlerinformationen, falls vorhanden, zurück

public **getDialectType** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Name des verwendeten Dialekts

public **getType** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Typ des Datenbanksystems für den der Adapter dient

public **getSqlVariables** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Aktive SQL gebunden Parametervariablen

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Legt den Event-manager fest

public **getEventsManager** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Gibt den internen Eventmanager zurück

public **setDialect** ([Phalcon\Db\DialectInterface](Phalcon_Db_DialectInterface) $dialect) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Legt den Dialekt fest, welcher verwendet wird, um die SQL-Anweisung zu produzieren

public **getDialect** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Gibt interne Dialekt-Instanz zurück

public **fetchOne** (*mixed* $sqlQuery, [*mixed* $fetchMode], [*mixed* $bindParams], [*mixed* $bindTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

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

public *array* **fetchAll** (*string* $sqlQuery, [*int* $fetchMode], [*array* $bindParams], [*array* $bindTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

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

public *string* | ** **fetchColumn** (*string* $sqlQuery, [*array* $placeholders], [*int* | *string* $column]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

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

public *boolean* **insert** (*string* | *array* $table, *array* $values, [*array* $fields], [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

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

public *boolean* **insertAsDict** (*string* $table, *array* $data, [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

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

public *boolean* **update** (*string* | *array* $table, *array* $fields, *array* $values, [*string* | *array* $whereCondition], [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

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

public *boolean* **updateAsDict** (*string* $table, *array* $data, [*string* $whereCondition], [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

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

public *boolean* **delete** (*string* | *array* $table, [*string* $whereCondition], [*array* $placeholders], [*array* $dataTypes]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

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

public **escapeIdentifier** (*array* | *string* $identifier) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

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

public *string* **getColumnList** (*array* $columnList) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Gibt eine Liste der Spalten zurück

public **limit** (*mixed* $sqlQuery, *mixed* $number) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Fügt eine LIMIT-Klausel zum $sqlQuery argument hinzu

```php
<?php

echo $connection->limit("SELECT * FROM robots", 5);

```

public **tableExists** (*mixed* $tableName, [*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Generates SQL checking for the existence of a schema.table

```php
<?php

var_dump(
    $connection->tableExists("blog", "posts")
);

```

public **viewExists** (*mixed* $viewName, [*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Generates SQL checking for the existence of a schema.view

```php
<?php

var_dump(
    $connection->viewExists("active_users", "posts")
);

```

public **forUpdate** (*mixed* $sqlQuery) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Liefert ein SQL, welches mit der FOR UPDATE-Klausel angepasst wurde

public **sharedLock** (*mixed* $sqlQuery) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Returns a SQL modified with a LOCK IN SHARE MODE clause

public **dropTable** (*mixed* $tableName, [*mixed* $schemaName], [*mixed* $ifExists]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Löscht eine Tabelle aus einem Schema/Datenbank

public **createView** (*mixed* $viewName, *array* $definition, [*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Erstellen eine View

public **dropView** (*mixed* $viewName, [*mixed* $schemaName], [*mixed* $ifExists]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Löscht eine View

public **addColumn** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Fügt eine Spalte zu einer Tabelle hinzu

public **dropColumn** (*mixed* $tableName, *mixed* $schemaName, *mixed* $columnName) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Löscht eine Spalte aus einer Tabelle

public **addIndex** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Fügt einen Index zu einer Tabelle hinzu

public **dropIndex** (*mixed* $tableName, *mixed* $schemaName, *mixed* $indexName) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Löscht einen Index aus einer Tabelle

public **addPrimaryKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface) $index) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Fügt einen Primärschlüssel einer Tabelle hinzu

public **dropPrimaryKey** (*mixed* $tableName, *mixed* $schemaName) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Löscht den Primärschlüssel einer Tabelle

public **addForeignKey** (*mixed* $tableName, *mixed* $schemaName, [Phalcon\Db\ReferenceInterface](Phalcon_Db_ReferenceInterface) $reference) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Fügt einen Fremdschlüssel einer Tabelle hinzu

public **dropForeignKey** (*mixed* $tableName, *mixed* $schemaName, *mixed* $referenceName) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Löscht einen Fremdschlüssel aus einer Tabelle

public **getColumnDefinition** ([Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface) $column) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Liefert die SQL Spaltendefinition einer Spalte

public **listTables** ([*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Listet alle Tabellen in einer Datenbank

```php
<?php

print_r(
    $connection->listTables("blog")
);

```

public **listViews** ([*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Listet alle Views in einer Datenbank

```php
<?php

print_r(
    $connection->listViews("blog")
);

```

public [Phalcon\Db\Index](Phalcon_Db_Index) **describeIndexes** (*string* $table, [*string* $schema]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Listet die Tabellenindices

```php
<?php

print_r(
    $connection->describeIndexes("robots_parts")
);

```

public **describeReferences** (*mixed* $table, [*mixed* $schema]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Listet Tabellenverweise

```php
<?php

print_r(
    $connection->describeReferences("robots_parts")
);

```

public **tableOptions** (*mixed* $tableName, [*mixed* $schemaName]) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Gets creation options from a table

```php
<?php

print_r(
    $connection->tableOptions("robots")
);

```

public **createSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Erstellt einen neuen Speicherpunkt

public **releaseSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Gibt einen Speicherpunkt frei

public **rollbackSavepoint** (*mixed* $name) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Rollbacks given savepoint

public **setNestedTransactionsWithSavepoints** (*mixed* $nestedTransactionsWithSavepoints) inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Wenn geschachtelte Transaktionen Speicherpunkte verwenden sollen

public **isNestedTransactionsWithSavepoints** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Gibt zurück, ob geschachtelte Transaktionen Speicherpunkte verwenden sollen

public **getNestedTransactionSavepointName** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Returns the savepoint name to use for nested transactions

public **getDefaultValue** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

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

public **getDescriptor** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Return descriptor used to connect to the active database

public *string* **getConnectionId** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Gets the active connection unique identifier

public **getSQLStatement** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Active SQL statement in the object

public **getRealSQLStatement** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Active SQL statement in the object without replace bound parameters

public *array* **getSQLBindTypes** () inherited from [Phalcon\Db\Adapter](Phalcon_Db_Adapter)

Active SQL statement in the object