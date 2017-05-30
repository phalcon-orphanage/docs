# Abstract class **Phalcon\\Db**

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/db.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Phalcon\\Db and its related classes provide a simple SQL database interface for Phalcon Framework. The Phalcon\\Db is the basic class you use to connect your PHP application to an RDBMS. There is a different adapter class for each brand of RDBMS.

This component is intended to lower level database operations. If you want to interact with databases using higher level of abstraction use Phalcon\\Mvc\\Model.

Phalcon\\Db is an abstract class. You only can use it with a database adapter like Phalcon\\Db\\Adapter\\Pdo

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

*integer* **FETCH_LAZY**

*integer* **FETCH_ASSOC**

*integer* **FETCH_NAMED**

*integer* **FETCH_NUM**

*integer* **FETCH_BOTH**

*integer* **FETCH_OBJ**

*integer* **FETCH_BOUND**

*integer* **FETCH_COLUMN**

*integer* **FETCH_CLASS**

*integer* **FETCH_INTO**

*integer* **FETCH_FUNC**

*integer* **FETCH_GROUP**

*integer* **FETCH_UNIQUE**

*integer* **FETCH_KEY_PAIR**

*integer* **FETCH_CLASSTYPE**

*integer* **FETCH_SERIALIZE**

*integer* **FETCH_PROPS_LATE**

## Methods

public static **setup** (*array* $options)

Enables/disables options in the Database component