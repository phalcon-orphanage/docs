Class **Phalcon\\Cache\\Backend\\Memcache**
===========================================

*extends* :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

Allows to cache output fragments, PHP data or raw data to a memcache backend This adapter uses the special memcached key "_PHCM" to store all the keys internally used by the adapter 

.. code-block:: php

    <?php

    //Cache data for 2 days
    $frontendOptions = array(
    	'lifetime' => 172800
    );
    
    //Set memcached server connection settings
    $backendOptions = array(
    	'host' => 'localhost',
    	'port' => 11211,
    	'persistent' => false
    );
    
    $cache = Phalcon_Cache::factory('Data', 'Memcache', $frontendOptions, $backendOptions);
    
    //Cache arbitrary data
    $cache->store('my-data', array(1, 2, 3, 4, 5));
    
    //Get data
    $data = $cache->get('my-data');



Methods
---------

public  **__construct** (*mixed* $frontendObject, *array* $backendOptions)

Phalcon\\Backend\\Adapter\\Memcache constructor



protected  **_connect** ()

Create internal connection to memcached



public *mixed*  **get** (*int|string* $keyName, *long* $lifetime)

Returns a cached content



public  **save** (*int|string* $keyName, *string* $content, *long* $lifetime, *boolean* $stopBuffer)

Stores cached content into the file backend



public *boolean*  **delete** (*int|string* $keyName)

Deletes a value from the cache by its key



public *array*  **queryKeys** (*string* $prefix)

Query the existing cached keys



public  **__destruct** ()

Destructs the backend closing the memcached connection



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



