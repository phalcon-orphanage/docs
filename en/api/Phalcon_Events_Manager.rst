Class **Phalcon\\Events\\Manager**
==================================

*implements* Phalcon\Events\ManagerInterface

Phalcon Events Manager, offers an easy way to intercept and manipulate, if needed, the normal flow of operation. With the EventsManager the developer can create hooks or plugins that will offer monitoring of data, manipulation, conditional execution and much more.


Methods
---------

public  **attach** (*string* $eventType, *object* $handler)

Attach a listener to the events manager



public  **dettachAll** (*unknown* $type)

Removes all events from the EventsManager



public *mixed*  **fire** (*string* $eventType, *object* $source, *mixed* $data, *int* $cancelable)

Fires a event in the events manager causing that the acive listeners will be notified about it



public *boolean*  **hasListeners** (*string* $type)

Check whether certain type of event has listeners



public *array*  **getListeners** (*string* $type)

Returns all the attached listeners of a certain type



