* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Db\Reference'

* * *

# Class **Phalcon\Db\Reference**

*implements* [Phalcon\Db\ReferenceInterface](Phalcon_Db_ReferenceInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/db/reference.zep" class="btn btn-default btn-sm">源码在GitHub</a>

Allows to define reference constraints on tables

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

## 方法

public **getName** ()

Constraint name

public **getSchemaName** ()

...

public **getReferencedSchema** ()

...

public **getReferencedTable** ()

Referenced Table

public **getColumns** ()

Local reference columns

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