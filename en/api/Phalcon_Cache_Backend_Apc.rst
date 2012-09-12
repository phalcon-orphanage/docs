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

*mixed* public **get** (*string* $keyName, *long* $lifetime)

Returns a cached content



public **save** (*string* $keyName, *string* $content, *long* $lifetime, *boolean* $stopBuffer)

Stores cached content into the file backend



*boolean* public **delete** (*string* $keyName)

Deletes a value from the cache by its key



*array* public **queryKeys** (*string* $prefix)

Query the existing cached keys



public **__construct** (*mixed* $frontendObject, *array* $backendOptions) inherited from Phalcon_Cache_Backend

Phalcon\\Cache\\Backend constructor



*mixed* public **start** (*int|string* $keyName) inherited from Phalcon_Cache_Backend

Starts a cache. The $keyname allow to identify the created fragment



*mixed* public **getFrontend** () inherited from Phalcon_Cache_Backend

Returns front-end instance adapter related to the back-end



*boolean* public **isFresh** () inherited from Phalcon_Cache_Backend

Checks whether the last cache is fresh or cached



*boolean* public **isStarted** () inherited from Phalcon_Cache_Backend

Checks whether the cache has started buffering or not



*string* public **getLastKey** () inherited from Phalcon_Cache_Backend

Gets the last key stored by the cache



