Class **Phalcon\\Events\\Manager**
==================================

The new Phalcon Events Manager, offers an easy way to intercept and manipulate, if needed, the normal flow of operation. With the EventsManager the developer can create hooks or plugins that will offer monitoring of data, manipulation, conditional execution and much more.


Methods
---------

public  **__construct** ()

...


public  **attach** (*string* $eventType, *object* $handler)

Attach a listener to the events manager



public *mixed*  **fire** (*string* $eventType, *object* $source)

Fires a event in the events manager causing that the acive listeners will be notified about it



public *array*  **getListeners** (*string* $type)

Returns all the attached listeners of a certain type



