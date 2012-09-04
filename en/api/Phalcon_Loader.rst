Class **Phalcon\\Loader**
=========================

Methods
---------

public **__construct** ()

public **setEventsManager** (*unknown* $eventsManager)

:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` public **getEventsManager** ()

Returns the internal event manager



public **setExtensions** (*array* $extensions)

Sets an array of extensions that the Loader must check together with the path



public **registerNamespaces** (*array* $namespaces)

Register namespaces and their related directories



public **registerPrefixes** (*unknown* $prefixes)

Register directories on which "not found" classes could be found



public **registerDirs** (*array* $directories)

Register directories on which "not found" classes could be found



public **registerClasses** (*unknown* $classes)

Register classes and their locations



public **register** ()

Register the autoload method



public **unregister** ()

Unregister the autoload method



*boolean* public **autoLoad** (*string* $className)

Makes the work of autoload registered classes



public **getFoundPath** ()

public **getCheckedPath** ()

