Interface **Phalcon\\Mvc\\Model\\Query\\BuilderInterface**
==========================================================

Phalcon\\Mvc\\Model\\Query\\BuilderInterface initializer


Methods
---------

abstract public  **__construct** (*array* $params)

Phalcon\\Mvc\\Model\\Query\\Builder



abstract public :doc:`Phalcon\\Mvc\\Model\\Query\\BuilderInterface <Phalcon_Mvc_Model_Query_BuilderInterface>`  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the DependencyInjector container



abstract public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the DependencyInjector container



abstract public :doc:`Phalcon\\Mvc\\Model\\Query\\BuilderInterface <Phalcon_Mvc_Model_Query_BuilderInterface>`  **columns** (*string|array* $columns)

Sets the columns to be queried



abstract public *string|array*  **getColumns** ()

Return the columns to be queried



abstract public :doc:`Phalcon\\Mvc\\Model\\Query\\BuilderInterface <Phalcon_Mvc_Model_Query_BuilderInterface>`  **from** (*string|array* $models)

Sets the models who makes part of the query



abstract public :doc:`Phalcon\\Mvc\\Model\\Query\\BuilderInterface <Phalcon_Mvc_Model_Query_BuilderInterface>`  **addFrom** (*string* $model, *string* $alias)

Add a model to take part of the query



abstract public *string|array*  **getFrom** ()

Return the models who makes part of the query



abstract public :doc:`Phalcon\\Mvc\\Model\\Query\\BuilderInterface <Phalcon_Mvc_Model_Query_BuilderInterface>`  **join** (*string* $model, *string* $conditions, *string* $alias)

Sets the models who makes part of the query



abstract public :doc:`Phalcon\\Mvc\\Model\\Query\\BuilderInterface <Phalcon_Mvc_Model_Query_BuilderInterface>`  **where** (*string* $conditions)

Sets conditions for the query



abstract public *string|array*  **getWhere** ()

Return the conditions for the query



abstract public :doc:`Phalcon\\Mvc\\Model\\Query\\BuilderInterface <Phalcon_Mvc_Model_Query_BuilderInterface>`  **orderBy** (*string* $orderBy)

Sets a ORDER BY condition clause



abstract public *string|array*  **getOrderBy** ()

Return the set ORDER BY clause



abstract public :doc:`Phalcon\\Mvc\\Model\\Query\\BuilderInterface <Phalcon_Mvc_Model_Query_BuilderInterface>`  **having** (*string* $having)

Sets a HAVING condition clause



abstract public *string|array*  **getHaving** ()

Return the columns to be queried



abstract public :doc:`Phalcon\\Mvc\\Model\\Query\\BuilderInterface <Phalcon_Mvc_Model_Query_BuilderInterface>`  **limit** (*int* $limit, *int* $offset)

Sets a LIMIT clause



abstract public *string|array*  **getLimit** ()

Returns the current LIMIT clause



abstract public :doc:`Phalcon\\Mvc\\Model\\Query\\BuilderInterface <Phalcon_Mvc_Model_Query_BuilderInterface>`  **groupBy** (*string* $group)

Sets a LIMIT clause



abstract public *string*  **getGroupBy** ()

Returns the GROUP BY clause



abstract public *string*  **getPhql** ()

Returns a PHQL statement built based on the builder parameters



abstract public :doc:`Phalcon\\Mvc\\Model\\QueryInterface <Phalcon_Mvc_Model_QueryInterface>`  **getQuery** ()

Returns the query built



