Class **Phalcon\\Events\\Manager**
==================================

Methods
---------

public **__construct** ()

public **attach** (*string* $eventType, *object* $handler)

Attach a listener to the events manager



*mixed* public **fire** (*string* $eventType, *object* $source)

Fires a event in the events manager causing that the acive listeners will be notified about it



