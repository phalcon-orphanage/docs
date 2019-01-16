* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Db\Result\Pdo'

* * *

# Class **Phalcon\Db\Result\Pdo**

*implements* [Phalcon\Db\ResultInterface](Phalcon_Db_ResultInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/db/result/pdo.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Encapsulates the resultset internals

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

## Metody

public **__construct** ([Phalcon\Db\AdapterInterface](Phalcon_Db_AdapterInterface) $connection, [PDOStatement](https://php.net/manual/en/class.pdostatement.php) $result, [*string* $sqlStatement], [*array* $bindParams], [*array* $bindTypes])

Phalcon\Db\Result\Pdo constructor

public **execute** ()

Allows to execute the statement again. Some database systems don't support scrollable cursors, So, as cursors are forward only, we need to execute the cursor again to fetch rows from the begining

public **fetch** ([*mixed* $fetchStyle], [*mixed* $cursorOrientation], [*mixed* $cursorOffset])

Fetches an array/object of strings that corresponds to the fetched row, or FALSE if there are no more rows. This method is affected by the active fetch flag set using Phalcon\Db\Result\Pdo::setFetchMode

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

Gets number of rows returned by a resultset

```php
<?php

$result = $connection->query(
    "SELECT * FROM robots ORDER BY name"
);

echo "There are ", $result->numRows(), " rows in the resultset";

```

public **dataSeek** (*mixed* $number)

Moves internal resultset cursor to another position letting us to fetch a certain row

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

Gets the internal PDO result object