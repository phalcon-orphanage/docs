# Class **Phalcon\\Mvc\\Model\\Query\\Builder**

*implements* [Phalcon\Mvc\Model\Query\BuilderInterface](/en/3.1.2/api/Phalcon_Mvc_Model_Query_BuilderInterface), [Phalcon\Di\InjectionAwareInterface](/en/3.1.2/api/Phalcon_Di_InjectionAwareInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/query/builder.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Helps to create PHQL queries using an OO interface

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

## Methods
public  **__construct** ([*mixed* $params], [[Phalcon\DiInterface](/en/3.1.2/api/Phalcon_DiInterface) $dependencyInjector])

Phalcon\\Mvc\\Model\\Query\\Builder constructor

public  **setDI** ([Phalcon\DiInterface](/en/3.1.2/api/Phalcon_DiInterface) $dependencyInjector)

Sets the DependencyInjector container

public  **getDI** ()

Returns the DependencyInjector container

public  **distinct** (*mixed* $distinct)

Sets SELECT DISTINCT / SELECT ALL flag

```php
<?php

$builder->distinct("status");
$builder->distinct(null);

```

public  **getDistinct** ()

Returns SELECT DISTINCT / SELECT ALL flag

public  **columns** (*mixed* $columns)

Sets the columns to be queried

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

Return the columns to be queried

public  **from** (*mixed* $models)

Sets the models who makes part of the query

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

public  **addFrom** (*mixed* $model, [*mixed* $alias], [*mixed* $with])

Add a model to take part of the query

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

Return the models who makes part of the query

public [Phalcon\Mvc\Model\Query\Builder](/en/3.1.2/api/Phalcon_Mvc_Model_Query_Builder) **join** (*string* $model, [*string* $conditions], [*string* $alias], [*string* $type])

Adds an INNER join to the query

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

public [Phalcon\Mvc\Model\Query\Builder](/en/3.1.2/api/Phalcon_Mvc_Model_Query_Builder) **innerJoin** (*string* $model, [*string* $conditions], [*string* $alias])

Adds an INNER join to the query

```php
<?php

// Inner Join model 'Robots' with automatic conditions and alias
$builder->innerJoin("Robots");

// Inner Join model 'Robots' specifying conditions
$builder->innerJoin("Robots", "Robots.id = RobotsParts.robots_id");

// Inner Join model 'Robots' specifying conditions and alias
$builder->innerJoin("Robots", "r.id = RobotsParts.robots_id", "r");

```

public [Phalcon\Mvc\Model\Query\Builder](/en/3.1.2/api/Phalcon_Mvc_Model_Query_Builder) **leftJoin** (*string* $model, [*string* $conditions], [*string* $alias])

Adds a LEFT join to the query

```php
<?php

$builder->leftJoin("Robots", "r.id = RobotsParts.robots_id", "r");

```

public [Phalcon\Mvc\Model\Query\Builder](/en/3.1.2/api/Phalcon_Mvc_Model_Query_Builder) **rightJoin** (*string* $model, [*string* $conditions], [*string* $alias])

Adds a RIGHT join to the query

```php
<?php

$builder->rightJoin("Robots", "r.id = RobotsParts.robots_id", "r");

```

public *array* **getJoins** ()

Return join parts of the query

public [Phalcon\Mvc\Model\Query\Builder](/en/3.1.2/api/Phalcon_Mvc_Model_Query_Builder) **where** (*mixed* $conditions, [*array* $bindParams], [*array* $bindTypes])

Sets the query conditions

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

public [Phalcon\Mvc\Model\Query\Builder](/en/3.1.2/api/Phalcon_Mvc_Model_Query_Builder) **andWhere** (*string* $conditions, [*array* $bindParams], [*array* $bindTypes])

Appends a condition to the current conditions using a AND operator

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

public [Phalcon\Mvc\Model\Query\Builder](/en/3.1.2/api/Phalcon_Mvc_Model_Query_Builder) **orWhere** (*string* $conditions, [*array* $bindParams], [*array* $bindTypes])

Appends a condition to the current conditions using an OR operator

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

public  **betweenWhere** (*mixed* $expr, *mixed* $minimum, *mixed* $maximum, [*mixed* $operator])

Appends a BETWEEN condition to the current conditions

```php
<?php

$builder->betweenWhere("price", 100.25, 200.50);

```

public  **notBetweenWhere** (*mixed* $expr, *mixed* $minimum, *mixed* $maximum, [*mixed* $operator])

Appends a NOT BETWEEN condition to the current conditions

```php
<?php

$builder->notBetweenWhere("price", 100.25, 200.50);

```

public  **inWhere** (*mixed* $expr, *array* $values, [*mixed* $operator])

Appends an IN condition to the current conditions

```php
<?php

$builder->inWhere("id", [1, 2, 3]);

```

public  **notInWhere** (*mixed* $expr, *array* $values, [*mixed* $operator])

Appends a NOT IN condition to the current conditions

```php
<?php

$builder->notInWhere("id", [1, 2, 3]);

```

public *string* | *array* **getWhere** ()

Return the conditions for the query

public [Phalcon\Mvc\Model\Query\Builder](/en/3.1.2/api/Phalcon_Mvc_Model_Query_Builder) **orderBy** (*string* | *array* $orderBy)

Sets an ORDER BY condition clause

```php
<?php

$builder->orderBy("Robots.name");
$builder->orderBy(["1", "Robots.name"]);

```

public *string* | *array* **getOrderBy** ()

Returns the set ORDER BY clause

public  **having** (*mixed* $having)

Sets a HAVING condition clause. You need to escape PHQL reserved words using [ and ] delimiters

```php
<?php

$builder->having("SUM(Robots.price) > 0");

```

public  **forUpdate** (*mixed* $forUpdate)

Sets a FOR UPDATE clause

```php
<?php

$builder->forUpdate(true);

```

public *string* | *array* **getHaving** ()

Return the current having clause

public  **limit** (*mixed* $limit, [*mixed* $offset])

Sets a LIMIT clause, optionally an offset clause

```php
<?php

$builder->limit(100);
$builder->limit(100, 20);
$builder->limit("100", "20");

```

public *string* | *array* **getLimit** ()

Returns the current LIMIT clause

public  **offset** (*mixed* $offset)

Sets an OFFSET clause

```php
<?php

$builder->offset(30);

```

public *string* | *array* **getOffset** ()

Returns the current OFFSET clause

public [Phalcon\Mvc\Model\Query\Builder](/en/3.1.2/api/Phalcon_Mvc_Model_Query_Builder) **groupBy** (*string* | *array* $group)

Sets a GROUP BY clause

```php
<?php

$builder->groupBy(
    [
        "Robots.name",
    ]
);

```

public *string* **getGroupBy** ()

Returns the GROUP BY clause

final public *string* **getPhql** ()

Returns a PHQL statement built based on the builder parameters

public  **getQuery** ()

Returns the query built

final public  **autoescape** (*mixed* $identifier)

Automatically escapes identifiers but only if they need to be escaped.

