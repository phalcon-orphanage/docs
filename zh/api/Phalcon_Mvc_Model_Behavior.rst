Abstract class **Phalcon\\Mvc\\Model\\Behavior**
================================================

*implements* :doc:`Phalcon\\Mvc\\Model\\BehaviorInterface <Phalcon_Mvc_Model_BehaviorInterface>`

This is an optional base class for ORM behaviors


Methods
-------

public  **__construct** ([*array* $options])





protected  **mustTakeAction** ()

Checks whether the behavior must take action on certain event



protected *array*  **getOptions** ()

Returns the behavior options related to an event



public  **notify** (*string* $type, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

This method receives the notifications from the EventsManager



public  **missingMethod** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *string* $method, [*array* $arguments])

Acts as fallbacks when a missing method is called on the model



