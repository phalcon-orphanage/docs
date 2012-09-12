Class **Phalcon\\Cache\\Backend\\Apc**
======================================

*extends* :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

Allows to cache output fragments, PHP data and raw data using a memcache backend 

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

Stores cached content into the file backend



public *boolean*  **delete** (*string* $keyName)

Deletes a value from the cache by its key



public *array*  **queryKeys** (*string* $prefix)

Query the existing cached keys



public  **__construct** (*mixed* $frontendObject, *array* $backendOptions) inherited from Phalcon\Cache\Backend

Phalcon\\Cache\\Backend constructor



public *mixed*  **start** (*int|string* $keyName) inherited from Phalcon\Cache\Backend

Starts a cache. The $keyname allow to identify the created fragment



public *mixed*  **getFrontend** () inherited from Phalcon\Cache\Backend

Returns front-end instance adapter related to the back-end



public *boolean*  **isFresh** () inherited from Phalcon\Cache\Backend

Checks whether the last cache is fresh or cached



public *boolean*  **isStarted** () inherited from Phalcon\Cache\Backend

Checks whether the cache has started buffering or not



public *string*  **getLastKey** () inherited from Phalcon\Cache\Backend

Gets the last key stored by the cache



