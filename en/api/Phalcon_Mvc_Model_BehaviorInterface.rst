Interface **Phalcon\\Mvc\\Model\\BehaviorInterface**
====================================================

Phalcon\\Mvc\\Model\\BehaviorInterface initializer


Methods
---------

abstract public  **__construct** ([*array* $options])

Phalcon\\Mvc\\Model\\Behavior



abstract public  **notify** (*string* $type, *Phalcon\\Mvc\\Model\\Behavior* $model)

This method receives the notifications from the EventsManager



abstract public  **missingMethod** (*Phalcon\\Mvc\\ModelInterface* $model, *string* $method, [*array* $arguments])

Calls a method when it's missing in the model



