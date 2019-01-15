* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Mvc\Model\Query\BuilderInterface'

* * *

# Interface **Phalcon\Mvc\Model\Query\BuilderInterface**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/mvc/model/query/builderinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>

## Constants

*string* **OPERATOR_OR**

*string* **OPERATOR_AND**

## Methods

abstract public **columns** (*mixed* $columns)

...

abstract public **getColumns** ()

...

abstract public **from** (*mixed* $models)

...

abstract public **addFrom** (*mixed* $model, [*mixed* $alias])

...

abstract public **getFrom** ()

...

abstract public **join** (*mixed* $model, [*mixed* $conditions], [*mixed* $alias], [*mixed* $type])

...

abstract public **innerJoin** (*mixed* $model, [*mixed* $conditions], [*mixed* $alias])

...

abstract public **leftJoin** (*mixed* $model, [*mixed* $conditions], [*mixed* $alias])

...

abstract public **rightJoin** (*mixed* $model, [*mixed* $conditions], [*mixed* $alias])

...

abstract public **getJoins** ()

...

abstract public **where** (*mixed* $conditions, [*mixed* $bindParams], [*mixed* $bindTypes])

...

abstract public **andWhere** (*mixed* $conditions, [*mixed* $bindParams], [*mixed* $bindTypes])

...

abstract public **orWhere** (*mixed* $conditions, [*mixed* $bindParams], [*mixed* $bindTypes])

...

abstract public **betweenWhere** (*mixed* $expr, *mixed* $minimum, *mixed* $maximum, [*mixed* $operator])

...

abstract public **notBetweenWhere** (*mixed* $expr, *mixed* $minimum, *mixed* $maximum, [*mixed* $operator])

...

abstract public **inWhere** (*mixed* $expr, *array* $values, [*mixed* $operator])

...

abstract public **notInWhere** (*mixed* $expr, *array* $values, [*mixed* $operator])

...

abstract public **getWhere** ()

...

abstract public **orderBy** (*mixed* $orderBy)

...

abstract public **getOrderBy** ()

...

abstract public **having** (*mixed* $having)

...

abstract public **getHaving** ()

...

abstract public **limit** (*mixed* $limit, [*mixed* $offset])

...

abstract public **getLimit** ()

...

abstract public **groupBy** (*mixed* $group)

...

abstract public **getGroupBy** ()

...

abstract public **getPhql** ()

...

abstract public **getQuery** ()

...