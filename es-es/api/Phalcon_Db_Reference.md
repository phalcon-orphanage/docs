---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Db\Reference'
---
# Class **Phalcon\Db\Reference**

*implements* [Phalcon\Db\ReferenceInterface](Phalcon_Db_ReferenceInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/reference.zep)

Permite definir restricciones de referencia en las tablas

```php
<?php

$reference = new \Phalcon\Db\Reference(
    "field_fk",
    [
        "referencedSchema"  => "invoicing",
        "referencedTable"   => "products",
        "columns"           => [
            "product_type",
            "product_code",
        ],
        "referencedColumns" => [
            "type",
            "code",
        ],
    ]
);

```

## Métodos

public **getName** ()

Nombre de la restricción

public **getSchemaName** ()

...

public **getReferencedSchema** ()

...

public **getReferencedTable** ()

Tabla referenciada

public **getColumns** ()

Columnas de referencia local

public **getReferencedColumns** ()

Columnas referenciadas

public **getOnDelete** ()

ON DELETE

public **getOnUpdate** ()

ON UPDATE

public **__construct** (*mixed* $name, *array* $definition)

Phalcon\Db\Reference constructor

public static **__set_state** (*array* $data)

Restore a Phalcon\Db\Reference object from export