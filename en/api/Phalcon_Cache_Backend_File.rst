Class **Phalcon\\Cache\\Backend\\File**
=======================================

*extends* :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

Allows to cache output fragments using a file backend 

.. code-block:: php

    <?php

    //Cache the file for 2 days
    $frontendOptions = array(
    	'lifetime' => 172800
    );
    
    //Set the cache directory
    $backendOptions = array(
    	'cacheDir' => '../app/cache/'
    );
    
    $cache = Phalcon_Cache::factory('Output', 'File', $frontendOptions, $backendOptions);
    
    $content = $cache->start('my-cache');
    if($content===null){
      	echo '<h1>', time(), '</h1>';
      	$cache->save();
    } else {
    	echo $content;
    }



Methods
---------

public  **__construct** (*mixed* $frontendObject, *array* $backendOptions)

Phalcon\\Backend\\Adapter\\File constructor



public *mixed*  **get** (*int|string* $keyName, *long* $lifetime)

Returns a cached content



public  **save** (*int|string* $keyName, *string* $content, *long* $lifetime, *boolean* $stopBuffer)

Stores cached content into the file backend



public *boolean*  **delete** (*int|string* $keyName)

Deletes a value from the cache by its key



public *array*  **queryKeys** (*string* $prefix)

Query the existing cached keys



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



