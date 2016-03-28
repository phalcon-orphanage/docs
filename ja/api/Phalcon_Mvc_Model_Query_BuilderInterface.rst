Interface **Phalcon\\Mvc\\Model\\Query\\BuilderInterface**
==========================================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/query/builderinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Methods
-------

abstract public  **__construct** ([*mixed* $params])

...


abstract public  **columns** (*mixed* $columns)

...


abstract public  **getColumns** ()

...


abstract public  **from** (*mixed* $models)

...


abstract public  **addFrom** (*mixed* $model, [*mixed* $alias])

...


abstract public  **getFrom** ()

...


abstract public  **join** (*mixed* $model, [*mixed* $conditions], [*mixed* $alias])

...


abstract public  **innerJoin** (*mixed* $model, [*mixed* $conditions], [*mixed* $alias])

...


abstract public  **leftJoin** (*mixed* $model, [*mixed* $conditions], [*mixed* $alias])

...


abstract public  **rightJoin** (*mixed* $model, [*mixed* $conditions], [*mixed* $alias])

...


abstract public  **where** (*mixed* $conditions, [*mixed* $bindParams], [*mixed* $bindTypes])

...


abstract public  **andWhere** (*mixed* $conditions, [*mixed* $bindParams], [*mixed* $bindTypes])

...


abstract public  **orWhere** (*mixed* $conditions, [*mixed* $bindParams], [*mixed* $bindTypes])

...


abstract public  **betweenWhere** (*mixed* $expr, *mixed* $minimum, *mixed* $maximum)

...


abstract public  **notBetweenWhere** (*mixed* $expr, *mixed* $minimum, *mixed* $maximum)

...


abstract public  **inWhere** (*mixed* $expr, *array* $values)

...


abstract public  **notInWhere** (*mixed* $expr, *array* $values)

...


abstract public  **getWhere** ()

...


abstract public  **orderBy** (*mixed* $orderBy)

...


abstract public  **getOrderBy** ()

...


abstract public  **having** (*mixed* $having)

...


abstract public  **getHaving** ()

...


abstract public  **limit** (*mixed* $limit, [*mixed* $offset])

...


abstract public  **getLimit** ()

...


abstract public  **groupBy** (*mixed* $group)

...


abstract public  **getGroupBy** ()

...


abstract public  **getPhql** ()

...


abstract public  **getQuery** ()

...


