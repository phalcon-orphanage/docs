Class **Phalcon\\Mvc\\Model\\Behavior\\SoftDelete**
===================================================

*extends* abstract class :doc:`Phalcon\\Mvc\\Model\\Behavior <Phalcon_Mvc_Model_Behavior>`

*implements* :doc:`Phalcon\\Mvc\\Model\\BehaviorInterface <Phalcon_Mvc_Model_BehaviorInterface>`

Instead of permanently delete a record it marks the record as deleted changing the value of a flag column


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



