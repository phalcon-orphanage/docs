Class **Phalcon\\Cache\\Backend**
=================================

This class implements common functionality for backend adapters. All the backend cache adapter must extend this class


Methods
---------

<<<<<<< HEAD
public  **__construct** (*mixed* $frontendObject, *array* $backendOptions)
=======
public  **__construct** (:doc:`Phalcon\\Cache\\FrontendInterface <Phalcon_Cache_FrontendInterface>` $frontend, *array* $options)
>>>>>>> 0.7.0

Phalcon\\Cache\\Backend constructor



public *mixed*  **start** (*int|string* $keyName)

<<<<<<< HEAD
Starts a cache. The $keyname allow to identify the created fragment
=======
Starts a cache. The $keyname allows to identify the created fragment



public  **stop** (*boolean* $stopBuffer)

Stops the frontend without store any cached content
>>>>>>> 0.7.0



public *mixed*  **getFrontend** ()

Returns front-end instance adapter related to the back-end



<<<<<<< HEAD
=======
public *array*  **getOptions** ()

Returns the backend options



>>>>>>> 0.7.0
public *boolean*  **isFresh** ()

Checks whether the last cache is fresh or cached



public *boolean*  **isStarted** ()

<<<<<<< HEAD
Checks whether the cache has started buffering or not



public *string*  **getLastKey** ()

Gets the last key stored by the cache



abstract public  **get** ()

...
=======
Checks whether the cache has starting buffering or not



public  **setLastKey** (*string* $lastKey)

Sets the last key used in the cache



public *string*  **getLastKey** ()

Gets the last key stored by the cache

>>>>>>> 0.7.0


