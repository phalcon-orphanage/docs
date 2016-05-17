Class **Phalcon\\Events\\Event**
================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/events/event.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

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



public  **__construct** (*string* $type, *object* $source, [*mixed* $data], [*boolean* $cancelable])

Phalcon\\Events\\Event constructor



public  **stop** ()

Stops the event preventing propagation



public  **isStopped** ()

Check whether the event is currently stopped



