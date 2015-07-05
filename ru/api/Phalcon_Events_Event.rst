Class **Phalcon\\Events\\Event**
================================

This class offers contextual information of a fired event in the EventsManager


Methods
-------

public  **setType** (*unknown* $type)

Event type



public  **getType** ()

Event type



public  **getSource** ()

Event source



public  **setData** (*unknown* $data)

Event data



public  **getData** ()

Event data



public  **getCancelable** ()

Is event cancelable?



public  **__construct** (*unknown* $type, *unknown* $source, [*unknown* $data], [*unknown* $cancelable])

Phalcon\\Events\\Event constructor



public  **stop** ()

Stops the event preventing propagation



public  **isStopped** ()

Check whether the event is currently stopped



