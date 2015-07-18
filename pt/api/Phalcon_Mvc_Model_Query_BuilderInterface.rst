Interface **Phalcon\\Mvc\\Model\\Query\\BuilderInterface**
==========================================================

Methods
-------

abstract public  **__construct** ([*unknown* $params])

...


abstract public  **columns** (*unknown* $columns)

...


abstract public  **getColumns** ()

...


abstract public  **from** (*unknown* $models)

...


abstract public  **addFrom** (*unknown* $model, [*unknown* $alias])

...


abstract public  **getFrom** ()

...


abstract public  **join** (*unknown* $model, [*unknown* $conditions], [*unknown* $alias])

...


abstract public  **innerJoin** (*unknown* $model, [*unknown* $conditions], [*unknown* $alias])

...


abstract public  **leftJoin** (*unknown* $model, [*unknown* $conditions], [*unknown* $alias])

...


abstract public  **rightJoin** (*unknown* $model, [*unknown* $conditions], [*unknown* $alias])

...


abstract public  **where** (*unknown* $conditions, [*unknown* $bindParams], [*unknown* $bindTypes])

...


abstract public  **andWhere** (*unknown* $conditions, [*unknown* $bindParams], [*unknown* $bindTypes])

...


abstract public  **orWhere** (*unknown* $conditions, [*unknown* $bindParams], [*unknown* $bindTypes])

...


abstract public  **betweenWhere** (*unknown* $expr, *unknown* $minimum, *unknown* $maximum)

...


abstract public  **notBetweenWhere** (*unknown* $expr, *unknown* $minimum, *unknown* $maximum)

...


abstract public  **inWhere** (*unknown* $expr, *unknown* $values)

...


abstract public  **notInWhere** (*unknown* $expr, *unknown* $values)

...


abstract public  **getWhere** ()

...


abstract public  **orderBy** (*unknown* $orderBy)

...


abstract public  **getOrderBy** ()

...


abstract public  **having** (*unknown* $having)

...


abstract public  **getHaving** ()

...


abstract public  **limit** (*unknown* $limit, [*unknown* $offset])

...


abstract public  **getLimit** ()

...


abstract public  **groupBy** (*unknown* $group)

...


abstract public  **getGroupBy** ()

...


abstract public  **getPhql** ()

...


abstract public  **getQuery** ()

...


