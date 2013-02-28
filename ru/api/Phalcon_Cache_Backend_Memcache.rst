Class **Phalcon\\Cache\\Backend\\Memcache**
===========================================

*extends* :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

*implements* :doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>`

Allows to cache output fragments, PHP data or raw data to a memcache backend  This adapter uses the special memcached key "_PHCM" to store all the keys internally used by the adapter  

.. code-block:: php

    <?php

     // Cache data for 2 days
     $frontCache = new Phalcon\Cache\Frontend\Data(array(
        "lifetime" => 172800
     ));
    
     //Create the Cache setting memcached connection options
     $cache = new Phalcon\Cache\Backend\Memcache($frontCache, array(
    	'host' => 'localhost',
    	'port' => 11211,
      	'persistent' => false
     ));
    
     //Cache arbitrary data
     $cache->save('my-data', array(1, 2, 3, 4, 5));
    
     //Get data
     $data = $cache->get('my-data');



Methods
---------

public  **__construct** (*Phalcon\\Cache\\FrontendInterface* $frontend, [*array* $options])

Phalcon\\Cache\\Backend\\Memcache constructor



protected  **_connect** ()

Create internal connection to memcached



public *mixed*  **get** (*int|string* $keyName, [*long* $lifetime])

Returns a cached content



public  **save** ([*int|string* $keyName], [*string* $content], [*long* $lifetime], [*boolean* $stopBuffer])

Stores cached content into the Memcached backend and stops the frontend



public *boolean*  **delete** (*int|string* $keyName)

Deletes a value from the cache by its key



public *array*  **queryKeys** ([*string* $prefix])

Query the existing cached keys



public *boolean*  **exists** ([*string* $keyName], [*long* $lifetime])

Checks if cache exists and it hasn't expired



public *mixed*  **start** (*int|string* $keyName, [*long* $lifetime]) inherited from Phalcon\\Cache\\Backend

Starts a cache. The $keyname allows to identify the created fragment



public  **stop** ([*boolean* $stopBuffer]) inherited from Phalcon\\Cache\\Backend

Stops the frontend without store any cached content



public *mixed*  **getFrontend** () inherited from Phalcon\\Cache\\Backend

Returns front-end instance adapter related to the back-end



public *array*  **getOptions** () inherited from Phalcon\\Cache\\Backend

Returns the backend options



public *boolean*  **isFresh** () inherited from Phalcon\\Cache\\Backend

Checks whether the last cache is fresh or cached



public *boolean*  **isStarted** () inherited from Phalcon\\Cache\\Backend

Checks whether the cache has starting buffering or not



public  **setLastKey** (*string* $lastKey) inherited from Phalcon\\Cache\\Backend

Sets the last key used in the cache



public *string*  **getLastKey** () inherited from Phalcon\\Cache\\Backend

Gets the last key stored by the cache



