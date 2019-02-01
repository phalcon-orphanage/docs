---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Db\Column'
---
# Class **Phalcon\Db\Column**

*implements* [Phalcon\Db\ColumnInterface](Phalcon_Db_ColumnInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/column.zep)

Tablo işlemlerini yaratırken ya da değiştirirken kullanılacak sütunları tanımlamaya imkan verir

```php
<?php

use Phalcon\Db\Column as Column;

// Column definition
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

// Add column to existing table
$connection->addColumn("robots", null, $column);

```

## Sabitler

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

## Metodlar

herkese açık ** isim al** ()

Sütunun ismi

public **getSchemaName** ()

Tablo ile ilgili şema nedir

genel **getType** ()

Sütun veri türü

public **getTypeReference** ()

Sütun veri türü başvurusu

public **getTypeValues** ()

Sütun veri türü değerleri

public **getSize** ()

Tamsayı sütun boyutu

public **getScale** ()

Tamsayı sütun sayısı ölçeği

public **getDefault** ()

Varsayılan sütun değeri

public **__construct** (*mixed* $name, *array* $definition)

Phalcon\Db\Column constructor

public **isUnsigned** ()

Eğer sayı sütununda imzalanmamışsa aslına döndürür

public **isNotNull** ()

Boş değil

public **isPrimary** ()

Sütun birincil anahtarın bir bölümü müdür?

public **isAutoIncrement** ()

Otomatik-Artış

public **isNumeric** ()

Sütunun sayısal bir türe sahip olup olmadığını kontrol edin

public **isFirst** ()

Sütunun tabloda ilk konumda olup olmadığını kontrol edin

public *string* **getAfterPosition** ()

Tablo konumun mutlak alanda olup olmadığını kontrol edin

public **getBindType** ()

Bağlama işlemenin türünü döndürür

public static **__set_state** (*array* $data)

Restores the internal state of a Phalcon\Db\Column object

public **hasDefault** ()

Sütununun varsayılan değer olup olmadığını kontrol edin