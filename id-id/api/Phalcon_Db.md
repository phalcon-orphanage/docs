---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Db'
---
# Abstract class **Phalcon\Db**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db.zep)

Phalcon\Db and its related classes provide a simple SQL database interface for Phalcon Framework. The Phalcon\Db is the basic class you use to connect your PHP application to an RDBMS. Ada kelas adaptor yang berbeda untuk setiap merek RDBMS.

This component is intended to lower level database operations. If you want to interact with databases using higher level of abstraction use Phalcon\Mvc\Model.

Phalcon\Db is an abstract class. You only can use it with a database adapter like Phalcon\Db\Adapter\Pdo

```php
<?php

use Phalcon\Db;
use Phalcon\Db\Exception;
use Phalcon\Db\Adapter\Pdo\Mysql as MysqlConnection;

try {
    $connection = new MysqlConnection(
        [
            "host"     => "192.168.0.11",
            "username" => "sigma",
            "password" => "secret",
            "dbname"   => "blog",
            "port"     => "3306",
        ]
    );

    $result = $connection->query(
        "SELECT * FROM robots LIMIT 5"
    );

    $result->setFetchMode(Db::FETCH_NUM);

    while ($robot = $result->fetch()) {
        print_r($robot);
    }
} catch (Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}

```

## Constants

*bilangan bulat* **FETCH_LAZY**

*bilangan bulat* **FETCH_ASSOC**

*bilangan bulat* **FETCH_NAMED**

*bilangan bulat* **FETCH_NUM**

*bilangan bulat* **FETCH_BOTH**

*bilangan bulat* **FETCH_OBJ**

*bilangan bulat* **FETCH_BOUND**

*bilangan bulat* **FETCH_COLUMN**

*bilanganbulat* **FETCH_CLASS**

*integer* **FETCH_INTO**

*integer* **FETCH_FUNC**

*integer* **FETCH_GROUP**

*integer* **FETCH_UNIQUE**

*integer* **FETCH_KEY_PAIR**

*integer* **FETCH_CLASSTYPE**

*integer* **FETCH_SERIALIZE**

*integer* **FETCH_PROPS_LATE**

## Metode

public static **pengaturan** (*array* $pilihan)

Mengaktifkan/menonaktifkan pilihan pada komponen Database