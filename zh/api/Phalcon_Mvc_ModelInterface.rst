Interface **Phalcon\\Mvc\\ModelInterface**
==========================================

Phalcon\\Mvc\\ModelInterface initializer


Methods
-------

abstract public :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **setTransaction** (:doc:`Phalcon\\Mvc\\Model\\TransactionInterface <Phalcon_Mvc_Model_TransactionInterface>` $transaction)

Sets a transaction related to the Model instance



abstract public *string*  **getSource** ()

Returns table name mapped in the model



abstract public *string*  **getSchema** ()

Returns schema name where table mapped is located



abstract public  **setConnectionService** (*string* $connectionService)

Sets both read/write connection services



abstract public  **setWriteConnectionService** (*string* $connectionService)

Sets the DependencyInjection connection service used to write data



abstract public  **setReadConnectionService** (*string* $connectionService)

Sets the DependencyInjection connection service used to read data



abstract public *string*  **getReadConnectionService** ()

Returns DependencyInjection connection service used to read data



abstract public *string*  **getWriteConnectionService** ()

Returns DependencyInjection connection service used to write data



abstract public :doc:`Phalcon\\Db\\AdapterInterface <Phalcon_Db_AdapterInterface>`  **getReadConnection** ()

Gets internal database connection



abstract public :doc:`Phalcon\\Db\\AdapterInterface <Phalcon_Db_AdapterInterface>`  **getWriteConnection** ()

Gets internal database connection



abstract public :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>`  **assign** (*array* $data, [*array* $columnMap])

Assigns values to a model from an array



abstract public static :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>`  $result **cloneResultMap** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $base, *array* $data, *array* $columnMap, [*int* $dirtyState], [*boolean* $keepSnapshots])

Assigns values to a model from an array returning a new model



abstract public static :doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>`  **cloneResult** (:doc:`Phalcon\\Mvc\\Model <Phalcon_Mvc_Model>` $base, *array* $data, [*int* $dirtyState])

Assigns values to a model from an array returning a new model



abstract public static  **cloneResultMapHydrate** (*array* $data, *array* $columnMap, *int* $hydrationMode)

Returns an hydrated result based on the data and the column map



abstract public static :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`  **find** ([*array* $parameters])

Allows to query a set of records that match the specified conditions



abstract public static :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>`  **findFirst** ([*array* $parameters])

Allows to query the first record that match the specified conditions



abstract public static :doc:`Phalcon\\Mvc\\Model\\CriteriaInterface <Phalcon_Mvc_Model_CriteriaInterface>`  **query** ([:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector])

Create a criteria for a especific model



abstract public static *int*  **count** ([*array* $parameters])

Allows to count how many records match the specified conditions



abstract public static *double*  **sum** ([*array* $parameters])

Allows to calculate a summatory on a column that match the specified conditions



abstract public static *mixed*  **maximum** ([*array* $parameters])

Allows to get the maximum value of a column that match the specified conditions



abstract public static *mixed*  **minimum** ([*array* $parameters])

Allows to get the minimum value of a column that match the specified conditions



abstract public static *double*  **average** ([*array* $parameters])

Allows to calculate the average value on a column matching the specified conditions



abstract public *boolean*  **fireEvent** (*string* $eventName)

Fires an event, implicitly calls behaviors and listeners in the events manager are notified



abstract public *boolean*  **fireEventCancel** (*string* $eventName)

Fires an event, implicitly calls behaviors and listeners in the events manager are notified This method stops if one of the callbacks/listeners returns boolean false



abstract public  **appendMessage** (:doc:`Phalcon\\Mvc\\Model\\MessageInterface <Phalcon_Mvc_Model_MessageInterface>` $message)

Appends a customized message on the validation process



abstract public *boolean*  **validationHasFailed** ()

Check whether validation process has generated any messages



abstract public :doc:`Phalcon\\Mvc\\Model\\MessageInterface <Phalcon_Mvc_Model_MessageInterface>` [] **getMessages** ([*unknown* $filter])

Returns all the validation messages



abstract public *boolean*  **save** ([*array* $data], [*array* $whiteList])

Inserts or updates a model instance. Returning true on success or false otherwise.



abstract public *boolean*  **create** ([*array* $data], [*array* $whiteList])

Inserts a model instance. If the instance already exists in the persistance it will throw an exception Returning true on success or false otherwise.



abstract public *boolean*  **update** ([*array* $data], [*array* $whiteList])

Updates a model instance. If the instance doesn't exist in the persistance it will throw an exception Returning true on success or false otherwise.



abstract public *boolean*  **delete** ()

Deletes a model instance. Returning true on success or false otherwise.



abstract public *int*  **getOperationMade** ()

Returns the type of the latest operation performed by the ORM Returns one of the OP_* class constants



abstract public  **refresh** ()

Refreshes the model attributes re-querying the record from the database



abstract public *mixed*  **readAttribute** (*string* $attribute)

Reads an attribute value by its name



abstract public  **writeAttribute** (*string* $attribute, *mixed* $value)

Writes an attribute value by its name



abstract public :doc:`Phalcon\\Mvc\\Model\\ResultsetInterface <Phalcon_Mvc_Model_ResultsetInterface>`  **getRelated** (*string* $alias, [*array* $arguments])

Returns related records based on defined relations



