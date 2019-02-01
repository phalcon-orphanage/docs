---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\Model\Criteria'
---
# Class **Phalcon\Mvc\Model\Criteria**

*implements* [Phalcon\Mvc\Model\CriteriaInterface](Phalcon_Mvc_Model_CriteriaInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/model/criteria.zep)

This class is used to build the array parameter required by Phalcon\Mvc\Model::find() and Phalcon\Mvc\Model::findFirst() using an object-oriented interface.

```php
<?php

$robots = Robots::query()
    ->where("type = :type:")
    ->andWhere("year < 2000")
    ->bind(["type" => "mechanical"])
    ->limit(5, 10)
    ->orderBy("name")
    ->execute();

```

## Metode

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Menetapkan kontainer Injector Ketergantungan

publik **mendapatkanDI** ()

Mengembalikan kontainer DependencyInjector

public **setModelName** (*mixed* $modelName)

Tetapkan model di mana kueri akan dieksekusi

public **getModelName** ()

Mengembalikan nama model internal yang menjadi kriteria untuk diterapkan

public **bind** (*array* $bindParams, [*mixed* $merge])

Menetapkan parameter terikat dalam kriteria Metode ini menggantikan semua parameter terikat yang telah ditetapkan sebelumnya

public **bindTypes** (*array* $bindTypes)

Menetapkan tipe pengikat dalam kriteria Metode ini menggantikan semua parameter terikat yang telah ditetapkan sebelumnya

public **distinct** (*mixed* $distinct)

Set PILIH DISTINCT / PILIH SEMUA bendera

public [Phalcon\Mvc\Model\Criteria](Phalcon_Mvc_Model_Criteria) **columns** (*string* | *array* $columns)

Menetapkan kolom yang akan ditanyakan

```php
<?php

$criteria->columns(
    [
        "id",
        "name",
    ]
);

```

public **join** (*mixed* $model, [*mixed* $conditions], [*mixed* $alias], [*mixed* $type])

Menambahkan INNER bergabung ke kueri

```php
<?php

$criteria->join("Robots");
$criteria->join("Robots", "r.id = RobotsParts.robots_id");
$criteria->join("Robots", "r.id = RobotsParts.robots_id", "r");
$criteria->join("Robots", "r.id = RobotsParts.robots_id", "r", "LEFT");

```

public **innerJoin** (*mixed* $model, [*mixed* $conditions], [*mixed* $alias])

Menambahkan INNER bergabung ke kueri

```php
<?php

$criteria->innerJoin("Robots");
$criteria->innerJoin("Robots", "r.id = RobotsParts.robots_id");
$criteria->innerJoin("Robots", "r.id = RobotsParts.robots_id", "r");

```

public **leftJoin** (*mixed* $model, [*mixed* $conditions], [*mixed* $alias])

Menambahkan KIRI bergabung ke kueri

```php
<?php

$criteria->leftJoin("Robots", "r.id = RobotsParts.robots_id", "r");

```

public **rightJoin** (*mixed* $model, [*mixed* $conditions], [*mixed* $alias])

Menambahkan RIGHT bergabung ke kueri

```php
<?php

$criteria->rightJoin("Robots", "r.id = RobotsParts.robots_id", "r");

```

public **where** (*mixed* $conditions, [*mixed* $bindParams], [*mixed* $bindTypes])

Menetapkan parameter kondisi dalam kriteria

public **addWhere** (*mixed* $conditions, [*mixed* $bindParams], [*mixed* $bindTypes])

Menambahkan kondisi pada kondisi saat ini menggunakan operator AND (tidak berlaku lagi)

public **andWhere** (*mixed* $conditions, [*mixed* $bindParams], [*mixed* $bindTypes])

Appends a condition to the current conditions using an AND operator

public **orWhere** (*mixed* $conditions, [*mixed* $bindParams], [*mixed* $bindTypes])

Menambahkan kondisi ke kondisi saat ini dengan menggunakan operator OR

public **betweenWhere** (*mixed* $expr, *mixed* $minimum, *mixed* $maximum)

Menambahkan kondisi antara kondisi saat ini

```php
<?php

$criteria->betweenWhere("price", 100.25, 200.50);

```

public **notBetweenWhere** (*mixed* $expr, *mixed* $minimum, *mixed* $maximum)

Appends a NOT BETWEEN condition to the current conditions

```php
<?php

$criteria->notBetweenWhere("price", 100.25, 200.50);

```

public **inWhere** (*mixed* $expr, *array* $values)

Menambahkan aplikasi DI kondisi ke kondisi saat ini

```php
<?php

$criteria->inWhere("id", [1, 2, 3]);

```

public **notInWhere** (*mixed* $expr, *array* $values)

Menambahkan sebuah TIDAK DALAM kondisi untuk kondisi saat ini

```php
<?php

$criteria->notInWhere("id", [1, 2, 3]);

```

public **conditions** (*mixed* $conditions)

Menambahkan parameter kondisi ke kriteria

public **order** (*mixed* $orderColumns)

Adds the order-by parameter to the criteria (deprecated)

public **orderBy** (*mixed* $orderColumns)

Menambahkan perintah-oleh klausul untuk kriteria

public **groupBy** (*mixed* $group)

Menambahkan kelompok-oleh ayat untuk kriteria

public **having** (*mixed* $having)

Menambahkan klausul dengan kriteria

public **limit** (*mixed* $limit, [*mixed* $offset])

Menambahkan parameter batas ke kriteria.

```php
<?php

$criteria->limit(100);
$criteria->limit(100, 200);
$criteria->limit("100", "200");

```

public **forUpdate** ([*mixed* $forUpdate])

Adds the "for_update" parameter to the criteria

public **sharedLock** ([*mixed* $sharedLock])

Adds the "shared_lock" parameter to the criteria

public **cache** (*array* $cache)

Menetapkan pengaturan cache dalam kriteria Metode ini menggantikan semua pengaturan cache yang telah di tetapkan sebelumnya

public **getWhere** ()

Mengembalikan parameter kondisi dalam kriteria

public *string* | *array* | *null* **getColumns** ()

Mengembalikan kolom yang akan ditanyakan

public **getConditions** ()

Mengembalikan parameter kondisi dalam kriteria

public *int* | *array* | *null* **getLimit** ()

Returns the limit parameter in the criteria, which will be an integer if limit was set without an offset, an array with 'number' and 'offset' keys if an offset was set with the limit, or null if limit has not been set.

public **getOrderBy** ()

Mengembalikan urutan klausa dalam kriteria

public **getGroupBy** ()

Mengembalikan klausa kelompok dalam kriteria

public **getHaving** ()

Mengembalikan klausa yang ada di dalam kriteria

publik *array* **MendapatkanParams** ()

Mengembalikan semua parameter yang telah didefinisikan dalam kriteria

public static **fromInput** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector, *mixed* $modelName, *array* $data, [*mixed* $operator])

Builds a Phalcon\Mvc\Model\Criteria based on an input array like $_POST

public **createBuilder** ()

Menciptakan query builder dari kriteria.

```php
<?php

$builder = Robots::query()
    ->where("type = :type:")
    ->bind(["type" => "mechanical"])
    ->createBuilder();

```

publik **menjalankan** ()

Mengeksekusi sebuah penemuan menggunakan parameter dibangun dengan kriteria