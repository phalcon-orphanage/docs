Class **Phalcon\\Mvc\\Model\\Criteria**
=======================================

<<<<<<< HEAD
=======
*implements* :doc:`Phalcon\\Mvc\\Model\\CriteriaInterface <Phalcon_Mvc_Model_CriteriaInterface>`, :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`

>>>>>>> 0.7.0
This class allows to build the array parameter required by Phalcon\\Mvc\\Model::find and Phalcon\\Mvc\\Model::findFirst, using an object-oriented interfase


Methods
---------

public  **__construct** ()

<<<<<<< HEAD
...


public  **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector)
=======
Phalcon\\Mvc\\Model\\Criteria constructor



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)
>>>>>>> 0.7.0

Sets the DependencyInjector container



<<<<<<< HEAD
public :doc:`Phalcon\\DI <Phalcon_DI>`  **getDI** ()
=======
public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()
>>>>>>> 0.7.0

Returns the DependencyInjector container



<<<<<<< HEAD
public  **setModelName** (*string* $modelName)
=======
public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **setModelName** (*string* $modelName)
>>>>>>> 0.7.0

Set a model on which the query will be executed



public *string*  **getModelName** ()

Returns an internal model name on which the criteria will be applied



public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **bind** (*string* $bindParams)

Adds the bind parameter to the criteria



public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **where** (*string* $conditions)

Adds the conditions parameter to the criteria



public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **conditions** (*string* $conditions)

Adds the conditions parameter to the criteria



public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **order** (*string* $orderColumns)

Adds the order-by parameter to the criteria



public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **limit** (*int* $limit, *int* $offset)

Adds the limit parameter to the criteria



public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **forUpdate** (*boolean* $forUpdate)

Adds the "for_update" parameter to the criteria



public :doc:`Phalcon\\Mvc\\Model\\Criteria <Phalcon_Mvc_Model_Criteria>`  **sharedLock** (*boolean* $sharedLock)

Adds the "shared_lock" parameter to the criteria



public *string*  **getWhere** ()

Returns the conditions parameter in the criteria



public *string*  **getConditions** ()

Returns the conditions parameter in the criteria



public *string*  **getLimit** ()

Returns the limit parameter in the criteria



public *string*  **getOrder** ()

Returns the order parameter in the criteria



public *string*  **getParams** ()

Returns all the parameters defined in the criteria



<<<<<<< HEAD
public static  **fromInput** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector, *string* $modelName, *array* $data)
=======
public static  **fromInput** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector, *string* $modelName, *array* $data)
>>>>>>> 0.7.0

Builds a Phalcon\\Mvc\\Model\\Criteria based on an input array like $_POST



<<<<<<< HEAD
public :doc:`Phalcon\\Mvc\\Model\\Resultset <Phalcon_Mvc_Model_Resultset>`  **execute** ()
=======
public :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`  **execute** ()
>>>>>>> 0.7.0

Executes a find using the parameters built with the criteria



