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
-------

public  **__construct** (*unknown* $frontend, [*unknown* $options])

Phalcon\\Cache\\Backend\\File constructor



public *mixed*  **get** (*unknown* $keyName, [*unknown* $lifetime])

Returns a cached content



public  **save** ([*unknown* $keyName], [*unknown* $content], [*unknown* $lifetime], [*unknown* $stopBuffer])

Stores cached content into the file backend and stops the frontend



public *boolean*  **delete** (*unknown* $keyName)

Deletes a value from the cache by its key



public *array*  **queryKeys** ([*unknown* $prefix])

Query the existing cached keys



public *boolean*  **exists** ([*unknown* $keyName], [*unknown* $lifetime])

Checks if cache exists and it isn't expired



public *mixed*  **increment** ([*unknown* $keyName], [*unknown* $value])

Increment of a given key, by number $value



public *mixed*  **decrement** ([*unknown* $keyName], [*unknown* $value])

Decrement of a given key, by number $value



public *boolean*  **flush** ()

Immediately invalidates all existing items.



public *string*  **getKey** (*unknown* $key)

Return a file-system safe identifier for a given key



public *this*  **useSafeKey** (*unknown* $useSafeKey)

Set whether to use the safekey or not



public  **getFrontend** () inherited from Phalcon\\Cache\\Backend

...


public  **setFrontend** (*unknown* $frontend) inherited from Phalcon\\Cache\\Backend

...


public  **getOptions** () inherited from Phalcon\\Cache\\Backend

...


public  **setOptions** (*unknown* $options) inherited from Phalcon\\Cache\\Backend

...


public  **getLastKey** () inherited from Phalcon\\Cache\\Backend

...


public  **setLastKey** (*unknown* $lastKey) inherited from Phalcon\\Cache\\Backend

...


public *mixed*  **start** (*unknown* $keyName, [*unknown* $lifetime]) inherited from Phalcon\\Cache\\Backend

Starts a cache. The keyname allows to identify the created fragment



public  **stop** ([*unknown* $stopBuffer]) inherited from Phalcon\\Cache\\Backend

Stops the frontend without store any cached content



public *boolean*  **isFresh** () inherited from Phalcon\\Cache\\Backend

Checks whether the last cache is fresh or cached



public *boolean*  **isStarted** () inherited from Phalcon\\Cache\\Backend

Checks whether the cache has starting buffering or not



public *int*  **getLifetime** () inherited from Phalcon\\Cache\\Backend

Gets the last lifetime set



