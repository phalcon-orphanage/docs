---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Db\Result\Pdo'
---
# Class **Phalcon\Db\Result\Pdo**

*implements* [Phalcon\Db\ResultInterface](Phalcon_Db_ResultInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/db/result/pdo.zep)

Encapsula los componentes internos del conjunto de resultados

```php
<?php

$result = $connection->query("SELECT * FROM robots ORDER BY name");

$result->setFetchMode(
    \Phalcon\Db::FETCH_NUM
);

while ($robot = $result->fetchArray()) {
    print_r($robot);
}

```

## Métodos

public **__construct** ([Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface) $connection, [PDOStatement](https://php.net/manual/en/class.pdostatement.php) $result, [*string* $sqlStatement], [*array* $bindParams], [*array* $bindTypes])

Phalcon\Db\Result\Pdo constructor

public **execute** ()

Allows to execute the statement again. Some database systems don't support scrollable cursors, So, as cursors are forward only, we need to execute the cursor again to fetch rows from the begining

public **fetch** ([*mixed* $fetchStyle], [*mixed* $cursorOrientation], [*mixed* $cursorOffset])

Obtiene una matriz/objeto de cadenas que corresponde a la fila recuperada, o FALSO si no hay más filas. This method is affected by the active fetch flag set using Phalcon\Db\Result\Pdo::setFetchMode

```php
<?php

$result = $connection->query("SELECT * FROM robots ORDER BY name");

$result->setFetchMode(
    \Phalcon\Db::FETCH_OBJ
);

while ($robot = $result->fetch()) {
    echo $robot->name;
}

```

public **fetchArray** ()

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

public **fetchAll** ([*mixed* $fetchStyle], [*mixed* $fetchArgument], [*mixed* $ctorArgs])

Returns an array of arrays containing all the records in the result This method is affected by the active fetch flag set using Phalcon\Db\Result\Pdo::setFetchMode

```php
<?php

$result = $connection->query(
    "SELECT * FROM robots ORDER BY name"
);

$robots = $result->fetchAll();

```

public **numRows** ()

Obtiene el número de filas devueltas por un conjunto de resultados

```php
<?php

$result = $connection->query(
    "SELECT * FROM robots ORDER BY name"
);

echo "There are ", $result->numRows(), " rows in the resultset";

```

public **dataSeek** (*mixed* $number)

Mueve el cursor del conjunto de resultados interno a otra posición que nos permite buscar una determinada fila

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

public **setFetchMode** (*mixed* $fetchMode, [*mixed* $colNoOrClassNameOrObject], [*mixed* $ctorargs])

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

public **getInternalResult** ()

Obtiene el objeto de resultado PDO interno