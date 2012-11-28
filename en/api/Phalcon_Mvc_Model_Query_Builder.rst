Class **Phalcon\\Mvc\\Model\\Query\\Builder**
=============================================

*implements* :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`

Helps to create PHQL queries using an OO interface  

.. code-block:: php

    <?php



Methods
---------

public  **__construct** (*array* $params)





public :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <Phalcon_Mvc_Model_Query_Builder>`  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the DependencyInjector container



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the DependencyInjector container



public :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <Phalcon_Mvc_Model_Query_Builder>`  **columns** (*string|array* $columns)

Sets the columns to be queried



public *string|array*  **getColumns** ()

Return the columns to be queried



public :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <Phalcon_Mvc_Model_Query_Builder>`  **from** (*string|array* $models)

Sets the models who makes part of the query



public :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <Phalcon_Mvc_Model_Query_Builder>`  **addFrom** (*string* $model, *string* $alias)

Add a model to take part of the query



public *string|array*  **getFrom** ()

Return the models who makes part of the query



public :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <Phalcon_Mvc_Model_Query_Builder>`  **join** (*string* $model, *string* $conditions, *string* $alias)

Sets the models who makes part of the query



public :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <Phalcon_Mvc_Model_Query_Builder>`  **where** (*string* $conditions)

Sets conditions for the query



public *string|array*  **getWhere** ()

Return the conditions for the query



public :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <Phalcon_Mvc_Model_Query_Builder>`  **orderBy** (*string* $orderBy)

Sets a ORDER BY condition clause



public *string|array*  **getOrderBy** ()

Return the set ORDER BY clause



public :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <Phalcon_Mvc_Model_Query_Builder>`  **having** (*string* $having)

Sets a HAVING condition clause



public *string|array*  **getHaving** ()

Return the columns to be queried



public :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <Phalcon_Mvc_Model_Query_Builder>`  **limit** (*int* $limit, *int* $offset)

Sets a LIMIT clause



public *string|array*  **getLimit** ()

Returns the current LIMIT clause



public :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <Phalcon_Mvc_Model_Query_Builder>`  **groupBy** (*string* $group)

Sets a LIMIT clause



public *string*  **getGroupBy** ()

Returns the GROUP BY clause



public *string*  **getPhql** ()

Returns a PHQL statement built based on the builder parameters



public :doc:`Phalcon\\Mvc\\Model\\Query <Phalcon_Mvc_Model_Query>`  **getQuery** ()

Returns the query built



