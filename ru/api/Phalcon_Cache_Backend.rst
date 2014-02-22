Abstract class **Phalcon\\Cache\\Backend**
==========================================

*implements* :doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>`

This class implements common functionality for backend adapters. A backend cache adapter may extend this class


Methods
-------

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



public *int*  **getLifetime** ()

Gets the last lifetime set



abstract public *mixed*  **get** (*int|string* $keyName, [*long* $lifetime]) inherited from Phalcon\\Cache\\BackendInterface

Returns a cached content



abstract public  **save** ([*int|string* $keyName], [*string* $content], [*long* $lifetime], [*boolean* $stopBuffer]) inherited from Phalcon\\Cache\\BackendInterface

Stores cached content into the file backend and stops the frontend



abstract public *boolean*  **delete** (*int|string* $keyName) inherited from Phalcon\\Cache\\BackendInterface

Deletes a value from the cache by its key



abstract public *array*  **queryKeys** ([*string* $prefix]) inherited from Phalcon\\Cache\\BackendInterface

Query the existing cached keys



abstract public *boolean*  **exists** ([*string* $keyName], [*long* $lifetime]) inherited from Phalcon\\Cache\\BackendInterface

Checks if cache exists and it hasn't expired



abstract public *boolean*  **flush** () inherited from Phalcon\\Cache\\BackendInterface

Immediately invalidates all existing items.



