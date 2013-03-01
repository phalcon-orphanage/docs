Class **Phalcon\\Mvc\\Model\\Behavior\\Timestampable**
======================================================

*extends* :doc:`Phalcon\\Mvc\\Model\\Behavior <Phalcon_Mvc_Model_Behavior>`

*implements* :doc:`Phalcon\\Mvc\\Model\\BehaviorInterface <Phalcon_Mvc_Model_BehaviorInterface>`

Allows to automatically update a model’s attribute saving the datetime when a record is created or updated


Methods
---------

public  **notify** (*string* $type, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

Listens for notifications from the models manager



public  **__construct** ([*array* $options]) inherited from Phalcon\\Mvc\\Model\\Behavior

Phalcon\\Mvc\\Model\\Behavior



protected  **mustTakeAction** () inherited from Phalcon\\Mvc\\Model\\Behavior

Checks whether the behavior must take action on certain event



protected *array*  **getOptions** () inherited from Phalcon\\Mvc\\Model\\Behavior

Returns the behavior options related to an event



public  **missingMethod** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *string* $method, [*array* $arguments]) inherited from Phalcon\\Mvc\\Model\\Behavior

Acts as fallbacks when a missing method is called on the model



