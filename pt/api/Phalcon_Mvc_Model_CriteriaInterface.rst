Interface **Phalcon\\Mvc\\Model\\CriteriaInterface**
====================================================

Phalcon\\Mvc\\Model\\CriteriaInterface initializer


Methods
---------

abstract public :doc:`Phalcon\\Mvc\\Model\\CriteriaInterface <Phalcon_Mvc_Model_CriteriaInterface>`  **setModelName** (*string* $modelName)

Set a model on which the query will be executed



abstract public *string*  **getModelName** ()

Returns an internal model name on which the criteria will be applied



abstract public :doc:`Phalcon\\Mvc\\Model\\CriteriaInterface <Phalcon_Mvc_Model_CriteriaInterface>`  **bind** (*string* $bindParams)

Adds the bind parameter to the criteria



abstract public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **bindTypes** (*string* $bindTypes)

Sets the bind types in the criteria This method replaces all previously set bound parameters



abstract public :doc:`Phalcon\\Mvc\\Model\\CriteriaInterface <Phalcon_Mvc_Model_CriteriaInterface>`  **where** (*string* $conditions)

Adds the conditions parameter to the criteria



abstract public :doc:`Phalcon\\Mvc\\Model\\CriteriaInterface <Phalcon_Mvc_Model_CriteriaInterface>`  **conditions** (*string* $conditions)

Adds the conditions parameter to the criteria



abstract public :doc:`Phalcon\\Mvc\\Model\\CriteriaInterface <Phalcon_Mvc_Model_CriteriaInterface>`  **orderBy** (*string* $orderColumns)

Adds the order-by parameter to the criteria



abstract public :doc:`Phalcon\\Mvc\\Model\\CriteriaInterface <Phalcon_Mvc_Model_CriteriaInterface>`  **limit** (*int* $limit, [*int* $offset])

Sets the limit parameter to the criteria



abstract public :doc:`Phalcon\\Mvc\\Model\\CriteriaInterface <Phalcon_Mvc_Model_CriteriaInterface>`  **forUpdate** ([*boolean* $forUpdate])

Sets the "for_update" parameter to the criteria



abstract public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **sharedLock** ([*boolean* $sharedLock])

Sets the "shared_lock" parameter to the criteria



abstract public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **andWhere** (*string* $conditions, [*array* $bindParams], [*array* $bindTypes])

Appends a condition to the current conditions using an AND operator



abstract public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **orWhere** (*string* $conditions, [*array* $bindParams], [*array* $bindTypes])

Appends a condition to the current conditions using an OR operator



abstract public :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <Phalcon_Mvc_Model_Query_Builder>`  **betweenWhere** (*string* $expr, *mixed* $minimum, *mixed* $maximum)

Appends a BETWEEN condition to the current conditions 

.. code-block:: php

    <?php

    $builder->betweenWhere('price', 100.25, 200.50);




abstract public :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <Phalcon_Mvc_Model_Query_Builder>`  **notBetweenWhere** (*string* $expr, *mixed* $minimum, *mixed* $maximum)

Appends a NOT BETWEEN condition to the current conditions 

.. code-block:: php

    <?php

    $builder->notBetweenWhere('price', 100.25, 200.50);




abstract public :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <Phalcon_Mvc_Model_Query_Builder>`  **inWhere** (*string* $expr, *array* $values)

Appends an IN condition to the current conditions 

.. code-block:: php

    <?php

    $builder->inWhere('id', [1, 2, 3]);




abstract public :doc:`Phalcon\\Mvc\\Model\\Query\\Builder <Phalcon_Mvc_Model_Query_Builder>`  **notInWhere** (*string* $expr, *array* $values)

Appends a NOT IN condition to the current conditions 

.. code-block:: php

    <?php

    $builder->notInWhere('id', [1, 2, 3]);




abstract public *string*  **getWhere** ()

Returns the conditions parameter in the criteria



abstract public *string*  **getConditions** ()

Returns the conditions parameter in the criteria



abstract public *string*  **getLimit** ()

Returns the limit parameter in the criteria



abstract public *string*  **getOrder** ()

Returns the order parameter in the criteria



abstract public *string*  **getParams** ()

Returns all the parameters defined in the criteria



abstract public static *static*  **fromInput** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector, *string* $modelName, *array* $data)

Builds a Phalcon\\Mvc\\Model\\Criteria based on an input array like $_POST



abstract public :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`  **execute** ()

Executes a find using the parameters built with the criteria



