---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\Query\Builder'
---
# Class **Phalcon\Mvc\Model\Query\Builder**

*implements* [Phalcon\Mvc\Model\Query\BuilderInterface](Phalcon_Mvc_Model_Query_BuilderInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/query/builder.zep)

Bantuan untuk membuat PHQL pertanyaan memakai OO antarmuka

```php
<?php

$params = [
    "models"     => ["Users"],
    "columns"    => ["id", "name", "status"],
    "conditions" => [
        [
            "created > :min: AND created < :max:",
            [
                "min" => "2013-01-01",
                "max" => "2014-01-01",
            ],
            [
                "min" => PDO::PARAM_STR,
                "max" => PDO::PARAM_STR,
            ],
        ],
    ],
    // or "conditions" => "created > '2013-01-01' AND created < '2014-01-01'",
    "group"      => ["id", "name"],
    "having"     => "name = 'Kamil'",
    "order"      => ["name", "id"],
    "limit"      => 20,
    "offset"     => 20,
    // or "limit" => [20, 20],
];

$queryBuilder = new \Phalcon\Mvc\Model\Query\Builder($params);

```

## Constants

*string* **OPERATOR_OR**

*string* **OPERATOR_AND**

## Metode

public **__construct** ([*mixed* $params], [[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector])

Phalcon\Mvc\Model\Query\Builder constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Menetapkan kontainer Injector Ketergantungan

publik **mendapatkanDI** ()

Mengembalikan kontainer DependencyInjector

public **distinct** (*mixed* $distinct)

Set PILIH DISTINCT / PILIH SEMUA bendera

```php
<?php

$builder->distinct("status");
$builder->distinct(null);

```

public **getDistinct** ()

Kembali PILIH TERPISAH / PILIH SEMUA bendera

public **columns** (*mixed* $columns)

Menetapkan kolom yang akan ditanyakan

```php
<?php

$builder->columns("id, name");

$builder->columns(
    [
        "id",
        "name",
    ]
);

$builder->columns(
    [
        "name",
        "number" => "COUNT(*)",
    ]
);

```

public *string* | *array* **getColumns** ()

Mengembalikan kolom yang akan ditanyakan

public **from** (*mixed* $models)

Pilih model yang membuat bagian dari pertanyaan

```php
<?php

$builder->from("Robots");

$builder->from(
    [
        "Robots",
        "RobotsParts",
    ]
);

$builder->from(
    [
        "r"  => "Robots",
        "rp" => "RobotsParts",
    ]
);

```

public **addFrom** (*mixed* $model, [*mixed* $alias], [*mixed* $with])

Tambahkan model untuk mengambil bagian dari pertanyaan

```php
<?php

// Load data from models Robots
$builder->addFrom("Robots");

// Load data from model 'Robots' using 'r' as alias in PHQL
$builder->addFrom("Robots", "r");

// Load data from model 'Robots' using 'r' as alias in PHQL
// and eager load model 'RobotsParts'
$builder->addFrom("Robots", "r", "RobotsParts");

// Load data from model 'Robots' using 'r' as alias in PHQL
// and eager load models 'RobotsParts' and 'Parts'
$builder->addFrom(
    "Robots",
    "r",
    [
        "RobotsParts",
        "Parts",
    ]
);

```

public *string* | *array* **getFrom** ()

Kembali model-model yang membuat bagian dari query

public [Phalcon\Mvc\Model\Query\Builder](Phalcon_Mvc_Model_Query_Builder) **join** (*string* $model, [*string* $conditions], [*string* $alias], [*string* $type])

Adds an :type: join (by default type - INNER) to the query

```php
<?php

// Inner Join model 'Robots' with automatic conditions and alias
$builder->join("Robots");

// Inner Join model 'Robots' specifying conditions
$builder->join("Robots", "Robots.id = RobotsParts.robots_id");

// Inner Join model 'Robots' specifying conditions and alias
$builder->join("Robots", "r.id = RobotsParts.robots_id", "r");

// Left Join model 'Robots' specifying conditions, alias and type of join
$builder->join("Robots", "r.id = RobotsParts.robots_id", "r", "LEFT");

```

public [Phalcon\Mvc\Model\Query\Builder](Phalcon_Mvc_Model_Query_Builder) **innerJoin** (*string* $model, [*string* $conditions], [*string* $alias])

Menambahkan INNER bergabung ke kueri

```php
<?php

// Inner Join model 'Robots' with automatic conditions and alias
$builder->innerJoin("Robots");

// Inner Join model 'Robots' specifying conditions
$builder->innerJoin("Robots", "Robots.id = RobotsParts.robots_id");

// Inner Join model 'Robots' specifying conditions and alias
$builder->innerJoin("Robots", "r.id = RobotsParts.robots_id", "r");

```

public [Phalcon\Mvc\Model\Query\Builder](Phalcon_Mvc_Model_Query_Builder) **leftJoin** (*string* $model, [*string* $conditions], [*string* $alias])

Menambahkan KIRI bergabung ke kueri

```php
<?php

$builder->leftJoin("Robots", "r.id = RobotsParts.robots_id", "r");

```

public [Phalcon\Mvc\Model\Query\Builder](Phalcon_Mvc_Model_Query_Builder) **rightJoin** (*string* $model, [*string* $conditions], [*string* $alias])

Menambahkan RIGHT bergabung ke kueri

```php
<?php

$builder->rightJoin("Robots", "r.id = RobotsParts.robots_id", "r");

```

public *array* **getJoins** ()

Kembali bergabung bagian dari query

public [Phalcon\Mvc\Model\Query\Builder](Phalcon_Mvc_Model_Query_Builder) **where** (*mixed* $conditions, [*array* $bindParams], [*array* $bindTypes])

Menetapkan permintaan kondisi WHERE

```php
<?php

$builder->where(100);

$builder->where("name = 'Peter'");

$builder->where(
    "name = :name: AND id > :id:",
    [
        "name" => "Peter",
        "id"   => 100,
    ]
);

```

public [Phalcon\Mvc\Model\Query\Builder](Phalcon_Mvc_Model_Query_Builder) **andWhere** (*string* $conditions, [*array* $bindParams], [*array* $bindTypes])

Menambahkan kondisi saat ini di MANA kondisi dengan menggunakan operator AND

```php
<?php

$builder->andWhere("name = 'Peter'");

$builder->andWhere(
    "name = :name: AND id > :id:",
    [
        "name" => "Peter",
        "id"   => 100,
    ]
);

```

public [Phalcon\Mvc\Model\Query\Builder](Phalcon_Mvc_Model_Query_Builder) **orWhere** (*string* $conditions, [*array* $bindParams], [*array* $bindTypes])

Menambahkan kondisi ke kondisi saat ini dengan menggunakan operator OR

```php
<?php

$builder->orWhere("name = 'Peter'");

$builder->orWhere(
    "name = :name: AND id > :id:",
    [
        "name" => "Peter",
        "id"   => 100,
    ]
);

```

public **betweenWhere** (*mixed* $expr, *mixed* $minimum, *mixed* $maximum, [*mixed* $operator])

Menambahkan ANTARA kondisi saat ini di MANA kondisi

```php
<?php

$builder->betweenWhere("price", 100.25, 200.50);

```

public **notBetweenWhere** (*mixed* $expr, *mixed* $minimum, *mixed* $maximum, [*mixed* $operator])

Menambahkan TIDAK ANTARA kondisi saat ini di MANA kondisi

```php
<?php

$builder->notBetweenWhere("price", 100.25, 200.50);

```

public **inWhere** (*mixed* $expr, *array* $values, [*mixed* $operator])

Menambahkan DALAM kondisi saat ini di MANA kondisi

```php
<?php

$builder->inWhere("id", [1, 2, 3]);

```

public **notInWhere** (*mixed* $expr, *array* $values, [*mixed* $operator])

Menambahkan TIDAK DALAM kondisi saat ini di MANA kondisi

```php
<?php

$builder->notInWhere("id", [1, 2, 3]);

```

public *string* | *array* **getWhere** ()

Pengembalian kondisi untuk query

public [Phalcon\Mvc\Model\Query\Builder](Phalcon_Mvc_Model_Query_Builder) **orderBy** (*string* | *array* $orderBy)

Sets an ORDER BY condition clause

```php
<?php

$builder->orderBy("Robots.name");
$builder->orderBy(["1", "Robots.name"]);

```

public *string* | *array* **getOrderBy** ()

Returns the set ORDER BY clause

public [Phalcon\Mvc\Model\Query\Builder](Phalcon_Mvc_Model_Query_Builder) **having** (*mixed* $conditions, [*array* $bindParams], [*array* $bindTypes])

Sets the HAVING condition clause

```php
<?php

$builder->having("SUM(Robots.price) > 0");

$builder->having(
        "SUM(Robots.price) > :sum:",
    [
        "sum" => 100,
     ]
);

```

public [Phalcon\Mvc\Model\Query\Builder](Phalcon_Mvc_Model_Query_Builder) **andHaving** (*string* $conditions, [*array* $bindParams], [*array* $bindTypes])

Menambahkan kondisi ke klausa kondisi HAVING saat ini dengan menggunakan operator AND

```php
<?php

$builder->andHaving("SUM(Robots.price) > 0");

$builder->andHaving(
        "SUM(Robots.price) > :sum:",
    [
        "sum" => 100,
     ]
);

```

public [Phalcon\Mvc\Model\Query\Builder](Phalcon_Mvc_Model_Query_Builder) **orHaving** (*string* $conditions, [*array* $bindParams], [*array* $bindTypes])

Menambahkan kondisi saat ini MENGALAMI kondisi klausul menggunakan ATAU operator

```php
<?php

$builder->orHaving("SUM(Robots.price) > 0");

$builder->orHaving(
        "SUM(Robots.price) > :sum:",
    [
        "sum" => 100,
     ]
);

```

public **betweenHaving** (*mixed* $expr, *mixed* $minimum, *mixed* $maximum, [*mixed* $operator])

Tambahkan kondisi BETWEEN ke klausa kondisi HAVING saat ini

```php
<?php

$builder->betweenHaving("SUM(Robots.price)", 100.25, 200.50);

```

public **notBetweenHaving** (*mixed* $expr, *mixed* $minimum, *mixed* $maximum, [*mixed* $operator])

Menambahkan kondisi NOT BETWEEN ke klausa kondisi HAVING saat ini

```php
<?php

$builder->notBetweenHaving("SUM(Robots.price)", 100.25, 200.50);

```

public **inHaving** (*mixed* $expr, *array* $values, [*mixed* $operator])

Menambahkan DALAM kondisi saat ini MENGALAMI kondisi klausa

```php
<?php

$builder->inHaving("SUM(Robots.price)", [100, 200]);

```

public **notInHaving** (*mixed* $expr, *array* $values, [*mixed* $operator])

Menambahkan TIDAK DALAM kondisi untuk saat ini MEMILIKI kondisi klausa

```php
<?php

$builder->notInHaving("SUM(Robots.price)", [100, 200]);

```

public *string* **getHaving** ()

Kembalikan arus yang memiliki klausa

public **forUpdate** (*mixed* $forUpdate)

Mengatur UNTUK MEMPERBARUI klausa

```php
<?php

$builder->forUpdate(true);

```

public **limit** (*mixed* $limit, [*mixed* $offset])

Menetapkan BATAS ketentuan, opsional mengimbangi sebuah ketentuan

```php
<?php

$builder->limit(100);
$builder->limit(100, 20);
$builder->limit("100", "20");

```

public *string* | *array* **getLimit** ()

Mengembalikan klausa TERBATAS saat ini

public **offset** (*mixed* $offset)

Menetapkan klausa OFFSET

```php
<?php

$builder->offset(30);

```

public *string* | *array* **getOffset** ()

Mengembalikan klausa OFFSET saat ini

public [Phalcon\Mvc\Model\Query\Builder](Phalcon_Mvc_Model_Query_Builder) **groupBy** (*string* | *array* $group)

Menetapkan klausa OLEH KELOMPOK

```php
<?php

$builder->groupBy(
    [
        "Robots.name",
    ]
);

```

public *string* **getGroupBy** ()

Mengembalikan klausa OLEH KELOMPOK

final public *string* **getPhql** ()

Mengembalikan sebuah PHQL pernyataan dibangun berdasarkan bangunan parameter

public **getQuery** ()

Mengembalikan kueri yang dibuat

final public **autoescape** (*mixed* $identifier)

Secara otomatis melepaskan pengidentifikasi tapi hanya jika mereka harus diloloskan.

private **_conditionBetween** (*mixed* $clause, *mixed* $operator, *mixed* $expr, *mixed* $minimum, *mixed* $maximum)

Menambahkan kondisi BETWEEN

private **_conditionNotBetween** (*mixed* $clause, *mixed* $operator, *mixed* $expr, *mixed* $minimum, *mixed* $maximum)

Menambahkan kondisi NOT BETWEEN

private **_conditionIn** (*mixed* $clause, *mixed* $operator, *mixed* $expr, *array* $values)

Tambahkan dalam kondisi

private **_conditionNotIn** (*mixed* $clause, *mixed* $operator, *mixed* $expr, *array* $values)

Menambahkan kondisi NOT IN