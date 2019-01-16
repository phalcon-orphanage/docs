* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Mvc\Model\Query'

* * *

# Class **Phalcon\Mvc\Model\Query**

*implements* [Phalcon\Mvc\Model\QueryInterface](Phalcon_Mvc_Model_QueryInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/mvc/model/query.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This class takes a PHQL intermediate representation and executes it.

```php
<?php

$phql = "SELECT c.price*0.16 AS taxes, c.* FROM Cars AS c JOIN Brands AS b
         WHERE b.name = :name: ORDER BY c.name";

$result = $manager->executeQuery(
    $phql,
    [
        "name" => "Lamborghini",
    ]
);

foreach ($result as $row) {
    echo "Name: ",  $row->cars->name, "\n";
    echo "Price: ", $row->cars->price, "\n";
    echo "Taxes: ", $row->taxes, "\n";
}

```

## Constants

*integer* **TYPE_SELECT**

*integer* **TYPE_INSERT**

*integer* **TYPE_UPDATE**

*integer* **TYPE_DELETE**

## Methods

public **__construct** ([*string* $phql], [[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector], [*mixed* $options])

Phalcon\Mvc\Model\Query constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Sets the dependency injection container

public **getDI** ()

Returns the dependency injection container

public **setUniqueRow** (*mixed* $uniqueRow)

Tells to the query if only the first row in the resultset must be returned

public **getUniqueRow** ()

Check if the query is programmed to get only the first row in the resultset

final protected **_getQualified** (*array* $expr)

Replaces the model's name to its source name in a qualified-name expression

final protected **_getCallArgument** (*array* $argument)

Resolves an expression in a single call argument

final protected **_getCaseExpression** (*array* $expr)

Resolves an expression in a single call argument

final protected **_getFunctionCall** (*array* $expr)

Resolves an expression in a single call argument

final protected *string* **_getExpression** (*array* $expr, [*boolean* $quoting])

Resolves an expression from its intermediate code into a string

final protected **_getSelectColumn** (*array* $column)

Resolves a column from its intermediate representation into an array used to determine if the resultset produced is simple or complex

final protected *string* **_getTable** ([Phalcon\Mvc\Model\ManagerInterface](Phalcon_Mvc_Model_ManagerInterface) $manager, *array* $qualifiedName)

Resolves a table in a SELECT statement checking if the model exists

final protected **_getJoin** ([Phalcon\Mvc\Model\ManagerInterface](Phalcon_Mvc_Model_ManagerInterface) $manager, *mixed* $join)

Resolves a JOIN clause checking if the associated models exist

final protected *string* **_getJoinType** (*array* $join)

Resolves a JOIN type

final protected *array* **_getSingleJoin** (*string* $joinType, *string* $joinSource, *string* $modelAlias, *string* $joinAlias, [Phalcon\Mvc\Model\RelationInterface](Phalcon_Mvc_Model_RelationInterface) $relation)

Resolves joins involving has-one/belongs-to/has-many relations

final protected *array* **_getMultiJoin** (*string* $joinType, *string* $joinSource, *string* $modelAlias, *string* $joinAlias, [Phalcon\Mvc\Model\RelationInterface](Phalcon_Mvc_Model_RelationInterface) $relation)

Resolves joins involving many-to-many relations

final protected *array* **_getJoins** (*array* $select)

Processes the JOINs in the query returning an internal representation for the database dialect

final protected *array* **_getOrderClause** (*array* | *string* $order)

Returns a processed order clause for a SELECT statement

final protected **_getGroupClause** (*array* $group)

Returns a processed group clause for a SELECT statement

final protected **_getLimitClause** (*array* $limitClause)

Returns a processed limit clause for a SELECT statement

final protected **_prepareSelect** ([*mixed* $ast], [*mixed* $merge])

Analyzes a SELECT intermediate code and produces an array to be executed later

final protected **_prepareInsert** ()

Analyzes an INSERT intermediate code and produces an array to be executed later

final protected **_prepareUpdate** ()

Analyzes an UPDATE intermediate code and produces an array to be executed later

final protected **_prepareDelete** ()

Analyzes a DELETE intermediate code and produces an array to be executed later

public **parse** ()

Parses the intermediate code produced by Phalcon\Mvc\Model\Query\Lang generating another intermediate representation that could be executed by Phalcon\Mvc\Model\Query

public **getCache** ()

Returns the current cache backend instance

final protected **_executeSelect** (*mixed* $intermediate, *mixed* $bindParams, *mixed* $bindTypes, [*mixed* $simulate])

Executes the SELECT intermediate representation producing a Phalcon\Mvc\Model\Resultset

final protected [Phalcon\Mvc\Model\Query\StatusInterface](Phalcon_Mvc_Model_Query_StatusInterface) **_executeInsert** (*array* $intermediate, *array* $bindParams, *array* $bindTypes)

Executes the INSERT intermediate representation producing a Phalcon\Mvc\Model\Query\Status

final protected [Phalcon\Mvc\Model\Query\StatusInterface](Phalcon_Mvc_Model_Query_StatusInterface) **_executeUpdate** (*array* $intermediate, *array* $bindParams, *array* $bindTypes)

Executes the UPDATE intermediate representation producing a Phalcon\Mvc\Model\Query\Status

final protected [Phalcon\Mvc\Model\Query\StatusInterface](Phalcon_Mvc_Model_Query_StatusInterface) **_executeDelete** (*array* $intermediate, *array* $bindParams, *array* $bindTypes)

Executes the DELETE intermediate representation producing a Phalcon\Mvc\Model\Query\Status

final protected [Phalcon\Mvc\Model\ResultsetInterface](Phalcon_Mvc_Model_ResultsetInterface) **_getRelatedRecords** ([Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) $model, *array* $intermediate, *array* $bindParams, *array* $bindTypes)

Query the records on which the UPDATE/DELETE operation well be done

public *mixed* **execute** ([*array* $bindParams], [*array* $bindTypes])

Executes a parsed PHQL statement

public [Phalcon\Mvc\ModelInterface](Phalcon_Mvc_ModelInterface) **getSingleResult** ([*array* $bindParams], [*array* $bindTypes])

Executes the query returning the first result

public **setType** (*mixed* $type)

Sets the type of PHQL statement to be executed

public **getType** ()

Gets the type of PHQL statement executed

public **setBindParams** (*array* $bindParams, [*mixed* $merge])

Set default bind parameters

public *array* **getBindParams** ()

Returns default bind params

public **setBindTypes** (*array* $bindTypes, [*mixed* $merge])

Set default bind parameters

public **setSharedLock** ([*mixed* $sharedLock])

Set SHARED LOCK clause

public *array* **getBindTypes** ()

Returns default bind types

public **setIntermediate** (*array* $intermediate)

Allows to set the IR to be executed

public *array* **getIntermediate** ()

Returns the intermediate representation of the PHQL statement

public **cache** (*mixed* $cacheOptions)

Sets the cache parameters of the query

public **getCacheOptions** ()

Returns the current cache options

public **getSql** ()

Returns the SQL to be generated by the internal PHQL (only works in SELECT statements)

public static **clean** ()

Destroys the internal PHQL cache