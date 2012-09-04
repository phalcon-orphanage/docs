Class **Phalcon\\Cache\\Backend**
=================================

This class implements common functionality for backend adapters. All the backend cache adapter must extend this class


Methods
---------

public **__construct** (*mixed* $frontendObject, *array* $backendOptions)

Phalcon\\Cache\\Backend constructor



*mixed* public **start** (*int|string* $keyName)

Starts a cache. The $keyname allow to identify the created fragment



*mixed* public **getFrontend** ()

Returns front-end instance adapter related to the back-end



*boolean* public **isFresh** ()

Checks whether the last cache is fresh or cached



*boolean* public **isStarted** ()

Checks whether the cache has started buffering or not



*string* public **getLastKey** ()

Gets the last key stored by the cache



abstract public **get** ()

