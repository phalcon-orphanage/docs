Class **Phalcon\\Cache\\Backend\\Mongo**
========================================

*extends* :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

<<<<<<< HEAD
Allows to cache output fragments, PHP data or raw data to a MongoDb backend 
=======
*implements* :doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>`

Allows to cache output fragments, PHP data or raw data to a MongoDb backend  
>>>>>>> 0.7.0

.. code-block:: php

    <?php

     // Cache data for 2 days
     $frontCache = new Phalcon\Cache\Frontend\Base64(array(
        "lifetime" => 172800
     ));
    
     //Create a MongoDB cache
     $cache = new Phalcon\Cache\Backend\Mongo($frontCache, array(
    	'server' => "mongodb://localhost",
          'db' => 'caches',
    	'collection' => 'images'
     ));
    
     //Cache arbitrary data
     $cache->store('my-data', file_get_contents('some-image.jpg'));
    
     //Get data
     $data = $cache->get('my-data');



Methods
---------

<<<<<<< HEAD
public  **__construct** (*mixed* $frontendObject, *array* $backendOptions)

Phalcon\\Backend\\Adapter\\Mongo constructor
=======
public  **__construct** (:doc:`Phalcon\\Cache\\FrontendInterface <Phalcon_Cache_FrontendInterface>` $frontend, *array* $options)

Phalcon\\Cache\\Backend\\Mongo constructor
>>>>>>> 0.7.0



protected *MongoCollection*  **_getCollection** ()

Returns a MongoDb collection based on the backend parameters



public *mixed*  **get** (*int|string* $keyName, *long* $lifetime)

Returns a cached content



public  **save** (*int|string* $keyName, *string* $content, *long* $lifetime, *boolean* $stopBuffer)

<<<<<<< HEAD
Stores cached content into the Mongo backend
=======
Stores cached content into the Mongo backend and stops the frontend
>>>>>>> 0.7.0



public *boolean*  **delete** (*int|string* $keyName)

Deletes a value from the cache by its key



public *array*  **queryKeys** (*string* $prefix)

Query the existing cached keys



<<<<<<< HEAD
public *boolean*  **exists** (*string* $keyName)

Checks if cache exists.
=======
public *boolean*  **exists** (*string* $keyName, *long* $lifetime)

Checks if cache exists and it hasn't expired
>>>>>>> 0.7.0



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



