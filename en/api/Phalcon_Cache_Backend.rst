Class **Phalcon\\Cache\\Backend**
=================================

Methods
---------

public  **__construct** (:doc:`Phalcon\\Cache\\FrontendInterface <Phalcon_Cache_FrontendInterface>` $frontend, [*array* $options])

Phalcon\\Cache\\Backend constructor



public *mixed*  **start** (*int|string* $keyName, [*long* $lifetime])

Starts a cache. The $keyname allows to identify the created fragment



public  **stop** ([*boolean* $stopBuffer])

Stops the frontend without store any cached content



public *mixed*  **getFrontend** ()

Returns front-end instance adapter related to the back-end



public *array*  **getOptions** ()

Returns the backend options



public *boolean*  **isFresh** ()

Checks whether the last cache is fresh or cached



public *boolean*  **isStarted** ()

Checks whether the cache has starting buffering or not



public  **setLastKey** (*string* $lastKey)

Sets the last key used in the cache



public *string*  **getLastKey** ()

Gets the last key stored by the cache



