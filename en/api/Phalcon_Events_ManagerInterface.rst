Interface **Phalcon\\Events\\ManagerInterface**
===============================================

Phalcon\\Events\\ManagerInterface initializer


Methods
---------

abstract public  **attach** (*string* $eventType, *object* $handler, [*unknown* $priority])

Attach a listener to the events manager



abstract public  **dettachAll** ([*string* $type])

Removes all events from the EventsManager



abstract public *mixed*  **fire** (*string* $eventType, *object* $source, [*mixed* $data], [*unknown* $cancelable])

Fires a event in the events manager causing that the acive listeners will be notified about it



abstract public *array*  **getListeners** (*string* $type)

Returns all the attached listeners of a certain type



