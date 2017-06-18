Class **Phalcon\\Events\\Event**
================================

*implements* :doc:`Phalcon\\Events\\EventInterface <Phalcon_Events_EventInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/events/event.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This class offers contextual information of a fired event in the EventsManager


Methods
-------

public  **getType** ()

Event type



public  **getSource** ()

Event source



public  **getData** ()

Event data



public  **__construct** (*string* $type, *object* $source, [*mixed* $data], [*boolean* $cancelable])

Phalcon\\Events\\Event constructor



public  **setData** ([*mixed* $data])

Sets event data.



public  **setType** (*mixed* $type)

Sets event type.



public  **stop** ()

Stops the event preventing propagation.

.. code-block:: php

    <?php

    if ($event->isCancelable()) {
        $event->stop();
    }




public  **isStopped** ()

Check whether the event is currently stopped.



public  **isCancelable** ()

Check whether the event is cancelable.

.. code-block:: php

    <?php

    if ($event->isCancelable()) {
        $event->stop();
    }




