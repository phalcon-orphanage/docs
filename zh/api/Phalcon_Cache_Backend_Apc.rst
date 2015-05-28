Class **Phalcon\\Cache\\Backend\\Apc**
======================================

*extends* abstract class :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

*implements* :doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>`

Allows to cache output fragments, PHP data and raw data using an APC backend  

.. code-block:: php

    <?php

    //Cache data for 2 days
    $frontCache = new \Phalcon\Cache\Frontend\Data(array(
    	'lifetime' => 172800
    ));
    
      $cache = new \Phalcon\Cache\Backend\Apc($frontCache, array(
          'prefix' => 'app-data'
      ));
    
    //Cache arbitrary data
    $cache->save('my-data', array(1, 2, 3, 4, 5));
    
    //Get data
    $data = $cache->get('my-data');



Methods
-------

public *mixed*  **get** (*unknown* $keyName, [*unknown* $lifetime])

Returns a cached content



public  **save** ([*unknown* $keyName], [*unknown* $content], [*unknown* $lifetime], [*unknown* $stopBuffer])

Stores cached content into the APC backend and stops the frontend



public *mixed*  **increment** ([*unknown* $keyName], [*unknown* $value])

Increment of a given key, by number $value



public *mixed*  **decrement** ([*unknown* $keyName], [*unknown* $value])

Decrement of a given key, by number $value



public *boolean*  **delete** (*unknown* $keyName)

Deletes a value from the cache by its key



public *array*  **queryKeys** ([*unknown* $prefix])

Query the existing cached keys



public *boolean*  **exists** ([*unknown* $keyName], [*unknown* $lifetime])

Checks if cache exists and it hasn't expired



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


public  **__construct** (*unknown* $frontend, [*unknown* $options]) inherited from Phalcon\\Cache\\Backend

Phalcon\\Cache\\Backend constructor



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



