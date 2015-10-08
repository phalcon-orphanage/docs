Abstract class **Phalcon\\Mvc\\Collection\\Behavior**
=====================================================

This is an optional base class for ORM behaviors


Methods
-------

public  **__construct** ([*array* $options])





protected  **mustTakeAction** (*unknown* $eventName)

Checks whether the behavior must take action on certain event



protected *array*  **getOptions** ([*string* $eventName])

Returns the behavior options related to an event



public  **notify** (*unknown* $type, *unknown* $model)

This method receives the notifications from the EventsManager



public  **missingMethod** (*unknown* $model, *unknown* $method, [*unknown* $arguments])

Acts as fallbacks when a missing method is called on the collection



