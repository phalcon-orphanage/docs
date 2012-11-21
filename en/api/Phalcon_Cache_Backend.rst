Class **Phalcon\\Cache\\Backend**
=================================

This class implements common functionality for backend adapters. All the backend cache adapter must extend this class


Methods
---------

public  **__construct** (:doc:`Phalcon\\Cache\\FrontendInterface <Phalcon_Cache_FrontendInterface>` $frontendObject, *array* $backendOptions)

Phalcon\\Cache\\Backend constructor



public *mixed*  **start** (*int|string* $keyName)

Starts a cache. The $keyname allows to identify the created fragment



public  **stop** (*boolean* $stopBuffer)

Stops the frontend without store any cached content



public *mixed*  **getFrontend** ()

Returns front-end instance adapter related to the back-end



public *boolean*  **isFresh** ()

Checks whether the last cache is fresh or cached



public *boolean*  **isStarted** ()

Checks whether the cache has starting buffering or not



public *string*  **getLastKey** ()

Gets the last key stored by the cache



