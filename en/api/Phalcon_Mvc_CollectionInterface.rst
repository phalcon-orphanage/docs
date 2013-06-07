Interface **Phalcon\\Mvc\\CollectionInterface**
===============================================

Phalcon\\Mvc\\CollectionInterface initializer


Methods
---------

abstract public  **__construct** ([:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector], [*unknown* $modelsManager])

Phalcon\\Mvc\\Collection



abstract public  **setId** (*mixed* $id)

Sets a value for the _id propery, creates a MongoId object if needed



abstract public *MongoId*  **getId** ()

Returns the value of the _id property



abstract public *array*  **getReservedAttributes** ()

Returns an array with reserved properties that cannot be part of the insert/update



abstract public *string*  **getSource** ()

Returns collection name mapped in the model



abstract public  **setConnectionService** (*string* $connectionService)

Sets a service in the services container that returns the Mongo database



abstract public *MongoDb*  **getConnection** ()

Retrieves a database connection



abstract public *mixed*  **readAttribute** (*string* $attribute)

Reads an attribute value by its name



abstract public  **writeAttribute** (*string* $attribute, *mixed* $value)

Writes an attribute value by its name



abstract public static :doc:`Phalcon\\Mvc\\Collection <Phalcon_Mvc_Collection>`  **cloneResult** (:doc:`Phalcon\\Mvc\\Collection <Phalcon_Mvc_Collection>` $collection, *array* $document)

Returns a cloned collection



abstract public *boolean*  **fireEvent** (*string* $eventName)

Fires an event, implicitly calls behaviors and listeners in the events manager are notified



abstract public *boolean*  **fireEventCancel** (*string* $eventName)

Fires an event, implicitly listeners in the events manager are notified This method stops if one of the callbacks/listeners returns boolean false



abstract public *boolean*  **validationHasFailed** ()

Check whether validation process has generated any messages



abstract public :doc:`Phalcon\\Mvc\\Model\\MessageInterface <Phalcon_Mvc_Model_MessageInterface>` [] **getMessages** ()

Returns all the validation messages



abstract public  **appendMessage** (:doc:`Phalcon\\Mvc\\Model\\MessageInterface <Phalcon_Mvc_Model_MessageInterface>` $message)

Appends a customized message on the validation process



abstract public *boolean*  **save** ()

Creates/Updates a collection based on the values in the atributes



abstract public static :doc:`Phalcon\\Mvc\\Collection <Phalcon_Mvc_Collection>`  **findById** (*string* $id)

Find a document by its id



abstract public static *array*  **findFirst** ([*array* $parameters])

Allows to query the first record that match the specified conditions



abstract public static *array*  **find** ([*array* $parameters])

Allows to query a set of records that match the specified conditions



abstract public static *array*  **count** ([*array* $parameters])

Perform a count over a collection



abstract public *boolean*  **delete** ()

Deletes a model instance. Returning true on success or false otherwise



