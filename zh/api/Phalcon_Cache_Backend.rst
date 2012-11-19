Class **Phalcon\\Cache\\Backend**
=================================

This class implements common functionality for backend adapters. All the backend cache adapter must extend this class


Methods
---------

public  **__construct** (*mixed* $frontendObject, *array* $backendOptions)

Phalcon\\Cache\\Backend constructor



public *mixed*  **start** (*int|string* $keyName)

Starts a cache. The $keyname allow to identify the created fragment



public *mixed*  **getFrontend** ()

Returns front-end instance adapter related to the back-end



public *boolean*  **isFresh** ()

Checks whether the last cache is fresh or cached



public *boolean*  **isStarted** ()

Checks whether the cache has started buffering or not



public *string*  **getLastKey** ()

Gets the last key stored by the cache



abstract public  **get** ()

...


