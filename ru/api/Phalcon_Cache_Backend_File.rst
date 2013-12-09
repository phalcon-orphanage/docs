Class **Phalcon\\Cache\\Backend\\File**
=======================================

*extends* abstract class :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

*implements* :doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>`

Allows to cache output fragments using a file backend  

.. code-block:: php

    <?php

    //Cache the file for 2 days
    $frontendOptions = array(
    	'lifetime' => 172800
    );
    
      //Create a output cache
      $frontCache = \Phalcon\Cache\Frontend\Output($frontOptions);
    
    //Set the cache directory
    $backendOptions = array(
    	'cacheDir' => '../app/cache/'
    );
    
      //Create the File backend
      $cache = new \Phalcon\Cache\Backend\File($frontCache, $backendOptions);
    
    $content = $cache->start('my-cache');
    if ($content === null) {
      	echo '<h1>', time(), '</h1>';
      	$cache->save();
    } else {
    	echo $content;
    }



Methods
---------

public  **__construct** (:doc:`Phalcon\\Cache\\FrontendInterface <Phalcon_Cache_FrontendInterface>` $frontend, [*array* $options])

Phalcon\\Cache\\Backend\\File constructor



public *mixed*  **get** (*int|string* $keyName, [*long* $lifetime])

Returns a cached content



public  **save** ([*int|string* $keyName], [*string* $content], [*long* $lifetime], [*boolean* $stopBuffer])

Stores cached content into the file backend and stops the frontend



public *boolean*  **delete** (*int|string* $keyName)

Deletes a value from the cache by its key



public *array*  **queryKeys** ([*string* $prefix])

Query the existing cached keys



public *boolean*  **exists** ([*string* $keyName], [*long* $lifetime])

Checks if cache exists and it isn't expired



public *mixed*  **increment** ([*string* $keyName], [*long* $value])

Increment of a given key, by number $value



public *mixed*  **decrement** ([*string* $keyName], [*long* $value])

Decrement of a given key, by number $value



public *boolean*  **flush** ()

Immediately invalidates all existing items.



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



public *int*  **getLifetime** () inherited from Phalcon\\Cache\\Backend

Gets the last lifetime set



