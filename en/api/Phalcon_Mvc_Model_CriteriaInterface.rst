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



abstract public :doc:`Phalcon\\Mvc\\Model\\CriteriaInterface <Phalcon_Mvc_Model_CriteriaInterface>`  **where** (*string* $conditions)

Adds the conditions parameter to the criteria



abstract public :doc:`Phalcon\\Mvc\\Model\\CriteriaInterface <Phalcon_Mvc_Model_CriteriaInterface>`  **conditions** (*string* $conditions)

Adds the conditions parameter to the criteria



abstract public :doc:`Phalcon\\Mvc\\Model\\CriteriaInterface <Phalcon_Mvc_Model_CriteriaInterface>`  **order** (*string* $orderColumns)

Adds the order-by parameter to the criteria



abstract public :doc:`Phalcon\\Mvc\\Model\\CriteriaInterface <Phalcon_Mvc_Model_CriteriaInterface>`  **limit** (*int* $limit, [*int* $offset])

Adds the limit parameter to the criteria



abstract public :doc:`Phalcon\\Mvc\\Model\\CriteriaInterface <Phalcon_Mvc_Model_CriteriaInterface>`  **forUpdate** ([*boolean* $forUpdate])

Adds the "for_update" parameter to the criteria



abstract public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **sharedLock** ([*boolean* $sharedLock])

Adds the "shared_lock" parameter to the criteria



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



abstract public static  **fromInput** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector, *string* $modelName, *array* $data)

Builds a Phalcon\\Mvc\\Model\\Criteria based on an input array like $_POST



abstract public :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`  **execute** ()

Executes a find using the parameters built with the criteria



