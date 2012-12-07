Class **Phalcon\\Cache\\Backend\\Apc**
======================================

*extends* :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

<<<<<<< HEAD
Allows to cache output fragments, PHP data and raw data using a memcache backend 
=======
*implements* :doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>`

Allows to cache output fragments, PHP data and raw data using a memcache backend  
>>>>>>> 0.7.0

.. code-block:: php

    <?php

    //Cache data for 2 days
    $frontendOptions = array(
    	'lifetime' => 172800
    );
    
    //Cache data for 2 days
    $frontCache = new Phalcon\Cache\Frontend\Data(array(
    	'lifetime' => 172800
    ));
    
      $cache = new Phalcon\Cache\Backend\Apc($frontCache);
    
    //Cache arbitrary data
    $cache->store('my-data', array(1, 2, 3, 4, 5));
    
    //Get data
    $data = $cache->get('my-data');



Methods
---------

public *mixed*  **get** (*string* $keyName, *long* $lifetime)

Returns a cached content



public  **save** (*string* $keyName, *string* $content, *long* $lifetime, *boolean* $stopBuffer)

<<<<<<< HEAD
Stores cached content into the file backend
=======
Stores cached content into the APC backend and stops the frontend
>>>>>>> 0.7.0



public *boolean*  **delete** (*string* $keyName)

Deletes a value from the cache by its key



public *array*  **queryKeys** (*string* $prefix)

Query the existing cached keys



<<<<<<< HEAD
public *boolean*  **exists** (*string* $keyName)

Checks if cache exists.



public  **__construct** (*mixed* $frontendObject, *array* $backendOptions) inherited from Phalcon\\Cache\\Backend
=======
public *boolean*  **exists** (*string* $keyName, *long* $lifetime)

Checks if cache exists and it hasn't expired



public  **__construct** (:doc:`Phalcon\\Cache\\FrontendInterface <Phalcon_Cache_FrontendInterface>` $frontend, *array* $options) inherited from Phalcon\\Cache\\Backend
>>>>>>> 0.7.0

Phalcon\\Cache\\Backend constructor



public *mixed*  **start** (*int|string* $keyName) inherited from Phalcon\\Cache\\Backend

<<<<<<< HEAD
Starts a cache. The $keyname allow to identify the created fragment
=======
Starts a cache. The $keyname allows to identify the created fragment



public  **stop** (*boolean* $stopBuffer) inherited from Phalcon\\Cache\\Backend

Stops the frontend without store any cached content
>>>>>>> 0.7.0



public *mixed*  **getFrontend** () inherited from Phalcon\\Cache\\Backend

Returns front-end instance adapter related to the back-end



<<<<<<< HEAD
=======
public *array*  **getOptions** () inherited from Phalcon\\Cache\\Backend

Returns the backend options



>>>>>>> 0.7.0
public *boolean*  **isFresh** () inherited from Phalcon\\Cache\\Backend

Checks whether the last cache is fresh or cached



public *boolean*  **isStarted** () inherited from Phalcon\\Cache\\Backend

<<<<<<< HEAD
Checks whether the cache has started buffering or not
=======
Checks whether the cache has starting buffering or not



public  **setLastKey** (*string* $lastKey) inherited from Phalcon\\Cache\\Backend

Sets the last key used in the cache
>>>>>>> 0.7.0



public *string*  **getLastKey** () inherited from Phalcon\\Cache\\Backend

Gets the last key stored by the cache



