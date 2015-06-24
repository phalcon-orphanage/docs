Class **Phalcon\\Events\\Manager**
==================================

*implements* :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`

Phalcon Events Manager, offers an easy way to intercept and manipulate, if needed, the normal flow of operation. With the EventsManager the developer can create hooks or plugins that will offer monitoring of data, manipulation, conditional execution and much more.


Methods
-------

public  **attach** (*unknown* $eventType, *unknown* $handler, [*unknown* $priority])

Attach a listener to the events manager



public  **detach** (*unknown* $eventType, *unknown* $handler)

Detach the listener from the events manager



public  **enablePriorities** (*unknown* $enablePriorities)

Set if priorities are enabled in the EventsManager



public *boolean*  **arePrioritiesEnabled** ()

Returns if priorities are enabled



public  **collectResponses** (*unknown* $collect)

Tells the event manager if it needs to collect all the responses returned by every registered listener in a single fire



public  **isCollecting** ()

Check if the events manager is collecting all all the responses returned by every registered listener in a single fire



public *array*  **getResponses** ()

Returns all the responses returned by every handler executed by the last 'fire' executed



public  **detachAll** ([*unknown* $type])

Removes all events from the EventsManager



public  **dettachAll** ([*unknown* $type])

Alias of detachAll



final public *mixed*  **fireQueue** (*unknown* $queue, *unknown* $event)

Internal handler to call a queue of events



public *mixed*  **fire** (*unknown* $eventType, *unknown* $source, [*unknown* $data], [*unknown* $cancelable])

Fires an event in the events manager causing that active listeners be notified about it 

.. code-block:: php

    <?php

    $eventsManager->fire('db', $connection);




public *boolean*  **hasListeners** (*unknown* $type)

Check whether certain type of event has listeners



public *array*  **getListeners** (*unknown* $type)

Returns all the attached listeners of a certain type



