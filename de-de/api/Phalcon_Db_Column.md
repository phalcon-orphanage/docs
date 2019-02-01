---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Db\Column'
---
# Class **Phalcon\Db\Column**

*implements* [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/column.zep)

Erlaubt die Definition von Spalten, welche zum Erstellen oder ändern von Tabellene-Operationen verwendet werden

```php
<?php

use Phalcon\Db\Column as Column;

// Spaltendefinition
$column = new Column(
    "id",
    [
        "type"          => Column::TYPE_INTEGER,
        "size"          => 10,
        "unsigned"      => true,
        "notNull"       => true,
        "autoIncrement" => true,
        "first"         => true,
    ]
);

// Diese Spalte einer bereits vorhandenen Tabellen hinzufügen
$connection->addColumn("robots", null, $column);

```

## Konstanten

*integer* **TYPE_INTEGER**

*integer* **TYPE_DATE**

*integer* **TYPE_VARCHAR**

*integer* **TYPE_DECIMAL**

*integer* **TYPE_DATETIME**

*integer* **TYPE_CHAR**

*integer* **TYPE_TEXT**

*integer* **TYPE_FLOAT**

*integer* **TYPE_BOOLEAN**

*integer* **TYPE_DOUBLE**

*integer* **TYPE_TINYBLOB**

*integer* **TYPE_BLOB**

*integer* **TYPE_MEDIUMBLOB**

*integer* **TYPE_LONGBLOB**

*integer* **TYPE_BIGINTEGER**

*integer* **TYPE_JSON**

*integer* **TYPE_JSONB**

*integer* **TYPE_TIMESTAMP**

*integer* **BIND_PARAM_NULL**

*integer* **BIND_PARAM_INT**

*integer* **BIND_PARAM_STR**

*integer* **BIND_PARAM_BLOB**

*integer* **BIND_PARAM_BOOL**

*integer* **BIND_PARAM_DECIMAL**

*integer* **BIND_SKIP**

## Methoden

public **getName** ()

Spaltenname

public **getSchemaName** ()

Schema, das mit der Tabelle verknüpft ist

public **getType** ()

Spaltendatentyp

public **getTypeReference** ()

Spalte Datentyp Referenz

public **getTypeValues** ()

Spalte Datentyp Werte

public **getSize** ()

Ganzzahl Spaltengröße

public **getScale** ()

Ganzzahl Spalte Anzahl Skalierung

public **getDefault** ()

Standard-Spalte

public **__construct** (*mixed* $name, *array* $definition)

Phalcon\Db\Column constructor

public **isUnsigned** ()

Gibt true zurück, wenn Spalte nicht signiert ist

public **isNotNull** ()

Nicht Null

public **isPrimary** ()

Spalte ist Teil des Primärschlüssels?

public **isAutoIncrement** ()

Automatische Erhöhung

public **isNumeric** ()

Überprüft, ob Spalte einen numerischen Typ hat

public **isFirst** ()

Überprüft, ob die Spalte die erste Position in der Tabelle ist

public *string* **getAfterPosition** ()

Check whether field absolute to position in table

public **getBindType** ()

Returns the type of bind handling

public static **__set_state** (*array* $data)

Restores the internal state of a Phalcon\Db\Column object

public **hasDefault** ()

Überprüft, ob die Spalte einen Standardwert besitzt