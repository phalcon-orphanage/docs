---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Db\Reference'
---
# Class **Phalcon\Db\Reference**

*implements* [Phalcon\Db\ReferenceInterface](Phalcon_Db_ReferenceInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/reference.zep)

Tablolara referans kısıtlamaları tanımlamaya izin verir

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

## Metodlar

herkese açık ** isim al** ()

Kısıtlama adı

public **getSchemaName** ()

...

public **getReferencedSchema** ()

...

public **getReferencedTable** ()

Referans Tablosu

public **getColumns** ()

Yerel referans sütunları

public **getReferencedColumns** ()

Referenced Columns

public **getOnDelete** ()

ON DELETE

public **getOnUpdate** ()

ON UPDATE

public **__construct** (*mixed* $name, *array* $definition)

Phalcon\Db\Reference constructor

public static **__set_state** (*array* $data)

Restore a Phalcon\Db\Reference object from export