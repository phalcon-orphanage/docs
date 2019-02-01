---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Db\Result\Pdo'
---
# Class **Phalcon\Db\Result\Pdo**

*implements* [Phalcon\Db\ResultInterface](Phalcon_Db_ResultInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/result/pdo.zep)

Encapsulates the resultset internal

```php
<?php

$result = $connection->query("PILIH * DARI robot ORDER OLEH nama");

$result->setFetchMode(
    \Phalcon\Db::FETCH_NUM
);

sementara ($robot = $result->fetchArray()) {
    print_r($robot);
}

```

## Metode

public **__construct** ([Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface) $connection, [PDOStatement](https://php.net/manual/en/class.pdostatement.php) $result, [*string* $sqlStatement], [*array* $bindParams], [*array* $bindTypes])

Phalcon\Db\Result\Pdo constructor

publik **menjalankan** ()

Allows to execute the statement again. Some database systems don't support scrollable cursors, So, as cursors are forward only, we need to execute the cursor again to fetch rows from the begining

publik **mengambil** ([*campur* $fetchStyle], [*campur* $cursorOrientation], [*campur* $cursorOffset])

Mengambil sebuah array/objek dari string yang sesuai dengan baris yang diambil, atau FALSE jika tidak ada lagi baris. This method is affected by the active fetch flag set using Phalcon\Db\Result\Pdo::setFetchMode

```php
<?php

$result = $connection->query("PILIH * DARI robot ORDER OLEH nama");

$result->setFetchMode(
    \Phalcon\Db::FETCH_OBJ
);

sementara ($robot = $result->fetch()) {
    echo $robot->nama;
}

```

umum **fetch Array** ()

Returns an array of strings that corresponds to the fetched row, or FALSE if there are no more rows. This method is affected by the active fetch flag set using Phalcon\Db\Result\Pdo::setFetchMode

```php
<?php

$result = $connection->query("SELECT * FROM robots ORDER BY name");

$result->setFetchMode(
    \Phalcon\Db::FETCH_NUM
);

while ($robot = result->fetchArray()) {
    print_r($robot);
}

```

umum **fetchAll** ([*campuran* $fetchStyle], [*campuran* $fetchArgument], [*campuran* $ctorArgs])

Returns an array of arrays containing all the records in the result This method is affected by the active fetch flag set using Phalcon\Db\Result\Pdo::setFetchMode

```php
<?php

$result = $connection->query(
    "SELECT * FROM robots ORDER BY name"
);

$robots = $result->fetchAll();

```

public **numRows** ()

Mendapat jumlah baris yang dikembalikan oleh resultset

```php
<?php

$result = $connection->query(
    "SELECT * FROM robots ORDER BY name"
);

echo "There are ", $result->numRows(), " rows in the resultset";

```

umum **dataSeek** (*campuran* $nomor)

Memindahkan kursor resultset internal ke posisi lain yang memungkinkan kita untuk mengambil baris tertentu

```php
<?php

$result = $connection->query(
    "SELECT * FROM robots ORDER BY name"
);

// Move to third row on result
$result->dataSeek(2);

// Fetch third row
$row = $result->fetch();

```

umum **setFetchMode** (*campuran* $fetchMode, [*campuran* $colNoOrClassNameOrObject], [*campuran* $ctorargs])

Changes the fetching mode affecting Phalcon\Db\Result\Pdo::fetch()

```php
<?php

// Return array with integer indexes
$result->setFetchMode(
    \Phalcon\Db::FETCH_NUM
);

// Return associative array without integer indexes
$result->setFetchMode(
    \Phalcon\Db::FETCH_ASSOC
);

// Return associative array together with integer indexes
$result->setFetchMode(
    \Phalcon\Db::FETCH_BOTH
);

// Return an object
$result->setFetchMode(
    \Phalcon\Db::FETCH_OBJ
);

```

umum **getInternalResult** ()

Mendapat objek hasil PDO internal