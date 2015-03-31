Class **Phalcon\\Mvc\\Model\\Criteria**
=======================================

*implements* :doc:`Phalcon\\Mvc\\Model\\CriteriaInterface <Phalcon_Mvc_Model_CriteriaInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`

This class is used to build the array parameter required by Phalcon\\Mvc\\Model::find() and Phalcon\\Mvc\\Model::findFirst() using an object-oriented interface.  

.. code-block:: php

    <?php

    $robots = Robots::query()
        ->where("type = :type:")
        ->andWhere("year < 2000")
        ->bind(array("type" => "mechanical"))
        ->limit(5, 10)
        ->order("name")
        ->execute();



Methods
-------

public  **setDI** (*unknown* $dependencyInjector)

Sets the DependencyInjector container



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the DependencyInjector container



public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **setModelName** (*unknown* $modelName)

Set a model on which the query will be executed



public *string*  **getModelName** ()

Returns an internal model name on which the criteria will be applied



public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **bind** (*unknown* $bindParams)

Sets the bound parameters in the criteria This method replaces all previously set bound parameters



public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **bindTypes** (*unknown* $bindTypes)

Sets the bind types in the criteria This method replaces all previously set bound parameters



public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **columns** (*unknown* $columns)

Sets the columns to be queried 

.. code-block:: php

    <?php

    $criteria->columns(array('id', 'name'));




public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **join** (*unknown* $model, [*unknown* $conditions], [*unknown* $alias], [*unknown* $type])

Adds a INNER join to the query 

.. code-block:: php

    <?php

    $criteria->join('Robots');
    $criteria->join('Robots', 'r.id = RobotsParts.robots_id');
    $criteria->join('Robots', 'r.id = RobotsParts.robots_id', 'r');
    $criteria->join('Robots', 'r.id = RobotsParts.robots_id', 'r', 'LEFT');




public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **innerJoin** (*unknown* $model, [*unknown* $conditions], [*unknown* $alias])

Adds a INNER join to the query 

.. code-block:: php

    <?php

    $criteria->innerJoin('Robots');
    $criteria->innerJoin('Robots', 'r.id = RobotsParts.robots_id');
    $criteria->innerJoin('Robots', 'r.id = RobotsParts.robots_id', 'r');




public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **leftJoin** (*unknown* $model, [*unknown* $conditions], [*unknown* $alias])

Adds a LEFT join to the query 

.. code-block:: php

    <?php

    $criteria->leftJoin('Robots', 'r.id = RobotsParts.robots_id', 'r');




public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **rightJoin** (*unknown* $model, [*unknown* $conditions], [*unknown* $alias])

Adds a RIGHT join to the query 

.. code-block:: php

    <?php

    $criteria->rightJoin('Robots', 'r.id = RobotsParts.robots_id', 'r');




public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **where** (*unknown* $conditions, [*unknown* $bindParams], [*unknown* $bindTypes])

Sets the conditions parameter in the criteria



public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **addWhere** (*unknown* $conditions, [*unknown* $bindParams], [*unknown* $bindTypes])

Appends a condition to the current conditions using an AND operator (deprecated)



public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **andWhere** (*unknown* $conditions, [*unknown* $bindParams], [*unknown* $bindTypes])

Appends a condition to the current conditions using an AND operator



public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **orWhere** (*unknown* $conditions, [*unknown* $bindParams], [*unknown* $bindTypes])

Appends a condition to the current conditions using an OR operator



public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **betweenWhere** (*unknown* $expr, *unknown* $minimum, *unknown* $maximum)

Appends a BETWEEN condition to the current conditions 

.. code-block:: php

    <?php

    $criteria->betweenWhere('price', 100.25, 200.50);




public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **notBetweenWhere** (*unknown* $expr, *unknown* $minimum, *unknown* $maximum)

Appends a NOT BETWEEN condition to the current conditions 

.. code-block:: php

    <?php

    $criteria->notBetweenWhere('price', 100.25, 200.50);




public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **inWhere** (*unknown* $expr, *unknown* $values)

Appends an IN condition to the current conditions 

.. code-block:: php

    <?php

    $criteria->inWhere('id', [1, 2, 3]);




public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **notInWhere** (*unknown* $expr, *unknown* $values)

Appends a NOT IN condition to the current conditions 

.. code-block:: php

    <?php

    $criteria->notInWhere('id', [1, 2, 3]);




public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **conditions** (*unknown* $conditions)

Adds the conditions parameter to the criteria



public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **order** (*unknown* $orderColumns)

Adds the order-by parameter to the criteria (deprecated)



public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **orderBy** (*unknown* $orderColumns)

Adds the order-by parameter to the criteria



public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **limit** (*unknown* $limit, [*unknown* $offset])

Adds the limit parameter to the criteria



public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **forUpdate** ([*unknown* $forUpdate])

Adds the "for_update" parameter to the criteria



public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **sharedLock** ([*unknown* $sharedLock])

Adds the "shared_lock" parameter to the criteria



public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **cache** (*unknown* $cache)

Sets the cache options in the criteria This method replaces all previously set cache options



public *string|null*  **getWhere** ()

Returns the conditions parameter in the criteria



public *string|array|null*  **getColumns** ()

Returns the columns to be queried



public *string|null*  **getConditions** ()

Returns the conditions parameter in the criteria



public *int|array|null*  **getLimit** ()

Returns the limit parameter in the criteria, which will be an integer if limit was set without an offset, an array with 'number' and 'offset' keys if an offset was set with the limit, or null if limit has not been set.



public *string|null*  **getOrder** ()

Returns the order parameter in the criteria



public *array*  **getParams** ()

Returns all the parameters defined in the criteria



public static :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **fromInput** (*unknown* $dependencyInjector, *unknown* $modelName, *unknown* $data)

Builds a Phalcon\\Mvc\\Model\\Criteria based on an input array like _POST



public :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`  **execute** ()

Executes a find using the parameters built with the criteria



