Class **Phalcon\\Mvc\\Collection\\Behavior\\Timestampable**
===========================================================

*extends* abstract class :doc:`Phalcon\\Mvc\\Collection\\Behavior <Phalcon_Mvc_Collection_Behavior>`

*implements* :doc:`Phalcon\\Mvc\\Collection\\BehaviorInterface <Phalcon_Mvc_Collection_BehaviorInterface>`

Allows to automatically update a model’s attribute saving the datetime when a record is created or updated


Methods
-------

public  **notify** (*unknown* $type, *unknown* $model)

Listens for notifications from the models manager



public  **__construct** ([*array* $options]) inherited from Phalcon\\Mvc\\Collection\\Behavior

Phalcon\\Mvc\\Collection\\Behavior



protected  **mustTakeAction** (*unknown* $eventName) inherited from Phalcon\\Mvc\\Collection\\Behavior

Checks whether the behavior must take action on certain event



protected *array*  **getOptions** ([*string* $eventName]) inherited from Phalcon\\Mvc\\Collection\\Behavior

Returns the behavior options related to an event



public  **missingMethod** (*unknown* $model, *unknown* $method, [*unknown* $arguments]) inherited from Phalcon\\Mvc\\Collection\\Behavior

Acts as fallbacks when a missing method is called on the collection



