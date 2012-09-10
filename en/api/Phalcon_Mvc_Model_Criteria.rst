Class **Phalcon\\Mvc\\Model\\Criteria**
=======================================

This class allows to build the array parameter required by Phalcon\\Mvc\\Model::find and Phalcon\\Mvc\\Model::findFirst, using an object-oriented interfase


Methods
---------

public **__construct** ()

public **setDI** (*Phalcon\DI* $dependencyInjector)

Sets the DependencyInjector container



:doc:`Phalcon\\DI <Phalcon_DI>` public **getDI** ()

Returns the DependencyInjector container



public **setModelName** (*string* $modelName)

Set a model on which the query will be executed



*string* public **getModelName** ()

Returns an internal model name on which the criteria will be applied



:doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>` public **bind** (*string* $bindParams)

Adds the bind parameter to the criteria



:doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>` public **where** (*string* $conditions)

Adds the conditions parameter to the criteria



:doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>` public **conditions** (*string* $conditions)

Adds the conditions parameter to the criteria



:doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>` public **order** (*string* $orderColumns)

Adds the order-by parameter to the criteria



:doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>` public **limit** (*unknown* $limit)

Adds the limit parameter to the criteria



:doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>` public **forUpdate** (*unknown* $forUpdate)

Adds the "for_update" parameter to the criteria



:doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>` public **sharedLock** (*unknown* $sharedLock)

Adds the "shared_lock" parameter to the criteria



*string* public **getWhere** ()

Returns the conditions parameter in the criteria



*string* public **getConditions** ()

Returns the conditions parameter in the criteria



*string* public **getLimit** ()

Returns the limit parameter in the criteria



*string* public **getOrder** ()

Returns the order parameter in the criteria



*string* public **getParams** ()

Returns all the parameters defined in the criteria



public static **fromInput** (*Phalcon\DI* $dependencyInjector, *string* $modelName, *array* $data)

Builds a Phalcon\\Mvc\\Model\\Criteria based on an input array like $_POST



:doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>` public **execute** ()

Executes a find using the parameters built with the criteria



