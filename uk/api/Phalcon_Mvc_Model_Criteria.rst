Class **Phalcon\\Mvc\\Model\\Criteria**
=======================================

*implements* :doc:`Phalcon\\Mvc\\Model\\CriteriaInterface <Phalcon_Mvc_Model_CriteriaInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/model/criteria.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This class is used to build the array parameter required by Phalcon\\Mvc\\Model::find() and Phalcon\\Mvc\\Model::findFirst() using an object-oriented interface.  

.. code-block:: php

    <?php

    $robots = Robots::query()
        ->where("type = :type:")
        ->andWhere("year < 2000")
        ->bind(array("type" => "mechanical"))
        ->limit(5, 10)
        ->orderBy("name")
        ->execute();



Methods
-------

public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the DependencyInjector container



public  **getDI** ()

Returns the DependencyInjector container



public  **setModelName** (*unknown* $modelName)

Set a model on which the query will be executed



public  **getModelName** ()

Returns an internal model name on which the criteria will be applied



public  **bind** (*array* $bindParams)

Sets the bound parameters in the criteria This method replaces all previously set bound parameters



public  **bindTypes** (*array* $bindTypes)

Sets the bind types in the criteria This method replaces all previously set bound parameters



public  **distinct** (*unknown* $distinct)

Sets SELECT DISTINCT / SELECT ALL flag



public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **columns** (*string|array* $columns)

Sets the columns to be queried 

.. code-block:: php

    <?php

    $criteria->columns(array('id', 'name'));




public  **join** (*unknown* $model, [*unknown* $conditions], [*unknown* $alias], [*unknown* $type])

Adds a INNER join to the query 

.. code-block:: php

    <?php

    $criteria->join('Robots');
    $criteria->join('Robots', 'r.id = RobotsParts.robots_id');
    $criteria->join('Robots', 'r.id = RobotsParts.robots_id', 'r');
    $criteria->join('Robots', 'r.id = RobotsParts.robots_id', 'r', 'LEFT');




public  **innerJoin** (*unknown* $model, [*unknown* $conditions], [*unknown* $alias])

Adds a INNER join to the query 

.. code-block:: php

    <?php

    $criteria->innerJoin('Robots');
    $criteria->innerJoin('Robots', 'r.id = RobotsParts.robots_id');
    $criteria->innerJoin('Robots', 'r.id = RobotsParts.robots_id', 'r');




public  **leftJoin** (*unknown* $model, [*unknown* $conditions], [*unknown* $alias])

Adds a LEFT join to the query 

.. code-block:: php

    <?php

    $criteria->leftJoin('Robots', 'r.id = RobotsParts.robots_id', 'r');




public  **rightJoin** (*unknown* $model, [*unknown* $conditions], [*unknown* $alias])

Adds a RIGHT join to the query 

.. code-block:: php

    <?php

    $criteria->rightJoin('Robots', 'r.id = RobotsParts.robots_id', 'r');




public  **where** (*unknown* $conditions, [*unknown* $bindParams], [*unknown* $bindTypes])

Sets the conditions parameter in the criteria



public  **addWhere** (*unknown* $conditions, [*unknown* $bindParams], [*unknown* $bindTypes])

Appends a condition to the current conditions using an AND operator (deprecated)



public  **andWhere** (*unknown* $conditions, [*unknown* $bindParams], [*unknown* $bindTypes])

Appends a condition to the current conditions using an AND operator



public  **orWhere** (*unknown* $conditions, [*unknown* $bindParams], [*unknown* $bindTypes])

Appends a condition to the current conditions using an OR operator



public  **betweenWhere** (*unknown* $expr, *unknown* $minimum, *unknown* $maximum)

Appends a BETWEEN condition to the current conditions 

.. code-block:: php

    <?php

    $criteria->betweenWhere('price', 100.25, 200.50);




public  **notBetweenWhere** (*unknown* $expr, *unknown* $minimum, *unknown* $maximum)

Appends a NOT BETWEEN condition to the current conditions 

.. code-block:: php

    <?php

    $criteria->notBetweenWhere('price', 100.25, 200.50);




public  **inWhere** (*unknown* $expr, *array* $values)

Appends an IN condition to the current conditions 

.. code-block:: php

    <?php

    $criteria->inWhere('id', [1, 2, 3]);




public  **notInWhere** (*unknown* $expr, *array* $values)

Appends a NOT IN condition to the current conditions 

.. code-block:: php

    <?php

    $criteria->notInWhere('id', [1, 2, 3]);




public  **conditions** (*unknown* $conditions)

Adds the conditions parameter to the criteria



public  **order** (*unknown* $orderColumns)

Adds the order-by parameter to the criteria (deprecated)



public  **orderBy** (*unknown* $orderColumns)

Adds the order-by clause to the criteria



public  **groupBy** (*unknown* $group)

Adds the group-by clause to the criteria



public  **having** (*unknown* $having)

Adds the having clause to the criteria



public  **limit** (*unknown* $limit, [*unknown* $offset])

Adds the limit parameter to the criteria



public  **forUpdate** ([*unknown* $forUpdate])

Adds the "for_update" parameter to the criteria



public  **sharedLock** ([*unknown* $sharedLock])

Adds the "shared_lock" parameter to the criteria



public  **cache** (*array* $cache)

Sets the cache options in the criteria This method replaces all previously set cache options



public  **getWhere** ()

Returns the conditions parameter in the criteria



public *string|array|null*  **getColumns** ()

Returns the columns to be queried



public  **getConditions** ()

Returns the conditions parameter in the criteria



public *int|array|null*  **getLimit** ()

Returns the limit parameter in the criteria, which will be an integer if limit was set without an offset, an array with 'number' and 'offset' keys if an offset was set with the limit, or null if limit has not been set.



public  **getOrder** ()

Returns the order clause in the criteria



public  **getGroupBy** ()

Returns the group clause in the criteria



public  **getHaving** ()

Returns the having clause in the criteria



public *array*  **getParams** ()

Returns all the parameters defined in the criteria



public static  **fromInput** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector, *unknown* $modelName, *array* $data, [*unknown* $operator])

Builds a Phalcon\\Mvc\\Model\\Criteria based on an input array like _POST



public  **execute** ()

Executes a find using the parameters built with the criteria



