Class **Phalcon\\Events\\Event**
================================

This class offers contextual information of a fired event in the EventsManager


Methods
---------

public  **__construct** (*string* $type, *object* $source, *mixed* $data, *unknown* $cancelable)

Phalcon\\Events\\Event constructor



public  **setType** (*string* $eventType)

Set the event's type



public *string*  **getType** ()

Returns the event's type



public *object*  **getSource** ()

Returns the event's source



public  **setData** (*string* $data)

Set the event's data



public *mixed*  **getData** ()

Returns the event's data



public  **setCancelable** (*boolean* $cancelable)

Sets if the event is cancelable



public *boolean*  **getCancelable** ()

Check whether the event is cancelable



public  **stop** ()

Stops the event preventing propagation



public  **isStopped** ()

Check whether the event is currently stopped



