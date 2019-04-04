---
layout: default
language: 'cs-cz'
version: '4.0'
title: 'Phalcon\Db\Index'
---
# Class **Phalcon\Db\Index**

*implements* [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/index.zep)

Allows to define indexes to be used on tables. Indexes are a common way to enhance database performance. An index allows the database server to find and retrieve specific rows much faster than it could do without an index

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

## Methods

public **getName** ()

Index name

public **getColumns** ()

Index columns

public **getType** ()

Index type

public **__construct** (*mixed* $name, *array* $columns, [*mixed* $type])

Phalcon\Db\Index constructor

public static **__set_state** (*array* $data)

Restore a Phalcon\Db\Index object from export