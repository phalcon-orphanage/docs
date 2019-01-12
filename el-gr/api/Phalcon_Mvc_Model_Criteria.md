* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Mvc\Model\Criteria'

* * *

# Class **Phalcon\Mvc\Model\Criteria**

*implements* [Phalcon\Mvc\Model\CriteriaInterface](/4.0/en/api/Phalcon_Mvc_Model_CriteriaInterface), [Phalcon\Di\InjectionAwareInterface](/4.0/en/api/Phalcon_Di_InjectionAwareInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/mvc/model/criteria.zep" class="btn btn-default btn-sm">Source on GitHub</a>

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

## Methods

public **setDI** ([Phalcon\DiInterface](/4.0/en/api/Phalcon_DiInterface) $dependencyInjector)

Sets the DependencyInjector container

public **getDI** ()

Returns the DependencyInjector container

public **setModelName** (*mixed* $modelName)

Set a model on which the query will be executed

public **getModelName** ()

Returns an internal model name on which the criteria will be applied

public **bind** (*array* $bindParams, [*mixed* $merge])

Sets the bound parameters in the criteria This method replaces all previously set bound parameters

public **bindTypes** (*array* $bindTypes)

Sets the bind types in the criteria This method replaces all previously set bound parameters

public **distinct** (*mixed* $distinct)

Sets SELECT DISTINCT / SELECT ALL flag

public [Phalcon\Mvc\Model\Criteria](/4.0/en/api/Phalcon_Mvc_Model_Criteria) **columns** (*string* | *array* $columns)

Sets the columns to be queried

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

Adds an INNER join to the query

```php
<?php

$criteria->join("Robots");
$criteria->join("Robots", "r.id = RobotsParts.robots_id");
$criteria->join("Robots", "r.id = RobotsParts.robots_id", "r");
$criteria->join("Robots", "r.id = RobotsParts.robots_id", "r", "LEFT");

```

public **innerJoin** (*mixed* $model, [*mixed* $conditions], [*mixed* $alias])

Adds an INNER join to the query

```php
<?php

$criteria->innerJoin("Robots");
$criteria->innerJoin("Robots", "r.id = RobotsParts.robots_id");
$criteria->innerJoin("Robots", "r.id = RobotsParts.robots_id", "r");

```

public **leftJoin** (*mixed* $model, [*mixed* $conditions], [*mixed* $alias])

Adds a LEFT join to the query

```php
<?php

$criteria->leftJoin("Robots", "r.id = RobotsParts.robots_id", "r");

```

public **rightJoin** (*mixed* $model, [*mixed* $conditions], [*mixed* $alias])

Adds a RIGHT join to the query

```php
<?php

$criteria->rightJoin("Robots", "r.id = RobotsParts.robots_id", "r");

```

public **where** (*mixed* $conditions, [*mixed* $bindParams], [*mixed* $bindTypes])

Sets the conditions parameter in the criteria

public **addWhere** (*mixed* $conditions, [*mixed* $bindParams], [*mixed* $bindTypes])

Appends a condition to the current conditions using an AND operator (deprecated)

public **andWhere** (*mixed* $conditions, [*mixed* $bindParams], [*mixed* $bindTypes])

Appends a condition to the current conditions using an AND operator

public **orWhere** (*mixed* $conditions, [*mixed* $bindParams], [*mixed* $bindTypes])

Appends a condition to the current conditions using an OR operator

public **betweenWhere** (*mixed* $expr, *mixed* $minimum, *mixed* $maximum)

Appends a BETWEEN condition to the current conditions

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

Appends an IN condition to the current conditions

```php
<?php

$criteria->inWhere("id", [1, 2, 3]);

```

public **notInWhere** (*mixed* $expr, *array* $values)

Appends a NOT IN condition to the current conditions

```php
<?php

$criteria->notInWhere("id", [1, 2, 3]);

```

public **conditions** (*mixed* $conditions)

Adds the conditions parameter to the criteria

public **order** (*mixed* $orderColumns)

Adds the order-by parameter to the criteria (deprecated)

public **orderBy** (*mixed* $orderColumns)

Adds the order-by clause to the criteria

public **groupBy** (*mixed* $group)

Adds the group-by clause to the criteria

public **having** (*mixed* $having)

Adds the having clause to the criteria

public **limit** (*mixed* $limit, [*mixed* $offset])

Adds the limit parameter to the criteria.

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

Sets the cache options in the criteria This method replaces all previously set cache options

public **getWhere** ()

Returns the conditions parameter in the criteria

public *string* | *array* | *null* **getColumns** ()

Returns the columns to be queried

public **getConditions** ()

Returns the conditions parameter in the criteria

public *int* | *array* | *null* **getLimit** ()

Returns the limit parameter in the criteria, which will be an integer if limit was set without an offset, an array with 'number' and 'offset' keys if an offset was set with the limit, or null if limit has not been set.

public **getOrderBy** ()

Returns the order clause in the criteria

public **getGroupBy** ()

Returns the group clause in the criteria

public **getHaving** ()

Returns the having clause in the criteria

public *array* **getParams** ()

Returns all the parameters defined in the criteria

public static **fromInput** ([Phalcon\DiInterface](/4.0/en/api/Phalcon_DiInterface) $dependencyInjector, *mixed* $modelName, *array* $data, [*mixed* $operator])

Builds a Phalcon\Mvc\Model\Criteria based on an input array like $_POST

public **createBuilder** ()

Creates a query builder from criteria.

```php
<?php

$builder = Robots::query()
    ->where("type = :type:")
    ->bind(["type" => "mechanical"])
    ->createBuilder();

```

public **execute** ()

Executes a find using the parameters built with the criteria