---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Db\Index'
---
# Class **Phalcon\Db\Index**

*implements* [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/index.zep)

Tablolarda kullanılacak dizinleri tanımlamaya izin verir. Indexes are a common way to enhance database performance. Bir dizin, veritabanı sunucusunun belirli satırları bir dizin olmadan yapabileceğinden çok daha hızlı bulmasını ve almasını sağlar

```php
<?php

// Define new unique index
$index_unique = new \Phalcon\Db\Index(
    'column_UNIQUE',
    [
        'column',
        'column'
    ],
    'UNIQUE'
);

// Define new primary index
$index_primary = new \Phalcon\Db\Index(
    'PRIMARY',
    [
        'column'
    ]
);

// Add index to existing table
$connection->addIndex("robots", null, $index_unique);
$connection->addIndex("robots", null, $index_primary);

```

## Metodlar

herkese açık ** isim al** ()

Dizin ismi

public **getColumns** ()

Dizin sütunları

genel **getType** ()

Dizin türü

public **__construct** (*mixed* $name, *array* $columns, [*mixed* $type])

Phalcon\Db\Index constructor

public static **__set_state** (*array* $data)

Restore a Phalcon\Db\Index object from export