---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Db\Index'
---
# Class **Phalcon\Db\Index**

*implements* [Phalcon\Db\IndexInterface](Phalcon_Db_IndexInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/index.zep)

Permite definir indices para ser usados en las tablas. Los indices son una manera común para mejorar el rendimiento de la base de datos. Un indice permite al servidor de base de datos encontrar y recuperar filas especificas mucho mas rápido de lo que podría hacer sin un indice

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

## Métodos

public **getName** ()

Nombre de Indice

public **getColumns** ()

Columnas de Indice

public **getType** ()

Tipo de Indice

public **__construct** (*mixed* $name, *array* $columns, [*mixed* $type])

Phalcon\Db\Index constructor

public static **__set_state** (*array* $data)

Restore a Phalcon\Db\Index object from export