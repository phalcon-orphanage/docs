Interface **Phalcon\\Mvc\\Model\\BehaviorInterface**
====================================================

Methods
---------

abstract public  **__construct** ([*array* $options])

Phalcon\\Mvc\\Model\\Behavior



abstract public  **notify** (*string* $type, :doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model)

This method receives the notifications from the EventsManager



abstract public  **missingMethod** (:doc:`Phalcon\\Mvc\\ModelInterface <Phalcon_Mvc_ModelInterface>` $model, *string* $method, [*array* $arguments])

Calls a method when it's missing in the model



