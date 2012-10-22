Class **Phalcon\\Cache\\Backend\\Mongo**
========================================

*extends* :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

Allows to cache output fragments, PHP data or raw data to a MongoDb backend 

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

public  **__construct** (*mixed* $frontendObject, *array* $backendOptions)

Phalcon\\Backend\\Adapter\\Mongo constructor



protected *MongoCollection*  **_getCollection** ()

Returns a MongoDb collection based on the backend parameters



public *mixed*  **get** (*int|string* $keyName, *long* $lifetime)

Returns a cached content



public  **save** (*int|string* $keyName, *string* $content, *long* $lifetime, *boolean* $stopBuffer)

Stores cached content into the Mongo backend



public *boolean*  **delete** (*int|string* $keyName)

Deletes a value from the cache by its key



public *array*  **queryKeys** (*string* $prefix)

Query the existing cached keys



public *boolean*  **exists** ()

Checks if cache exists.



public *mixed*  **start** (*int|string* $keyName) inherited from Phalcon\\Cache\\Backend

Starts a cache. The $keyname allow to identify the created fragment



public *mixed*  **getFrontend** () inherited from Phalcon\\Cache\\Backend

Returns front-end instance adapter related to the back-end



public *boolean*  **isFresh** () inherited from Phalcon\\Cache\\Backend

Checks whether the last cache is fresh or cached



public *boolean*  **isStarted** () inherited from Phalcon\\Cache\\Backend

Checks whether the cache has started buffering or not



public *string*  **getLastKey** () inherited from Phalcon\\Cache\\Backend

Gets the last key stored by the cache



