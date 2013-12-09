Class **Phalcon\\Cache\\Backend\\Xcache**
=========================================

*extends* abstract class :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

*implements* :doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>`

Allows to cache output fragments, PHP data and raw data using an XCache backend  

.. code-block:: php

    <?php

    //Cache data for 2 days
    $frontCache = new Phalcon\Cache\Frontend\Data(array(
    	'lifetime' => 172800
    ));
    
      $cache = new Phalcon\Cache\Backend\Xcache($frontCache, array(
          'prefix' => 'app-data'
      ));
    
    //Cache arbitrary data
    $cache->save('my-data', array(1, 2, 3, 4, 5));
    
    //Get data
    $data = $cache->get('my-data');



Methods
---------

public  **__construct** (:doc:`Phalcon\\Cache\\FrontendInterface <Phalcon_Cache_FrontendInterface>` $frontend, [*array* $options])

Phalcon\\Cache\\Backend\\Xcache constructor



public *mixed*  **get** (*string* $keyName, [*long* $lifetime])

Returns cached content



public  **save** ([*string* $keyName], [*string* $content], [*long* $lifetime], [*boolean* $stopBuffer])

Stores cached content into the XCache backend and stops the frontend



public *boolean*  **delete** (*string* $keyName)

Deletes a value from the cache by its key



public *array*  **queryKeys** ([*string* $prefix])

Query the existing cached keys



public *boolean*  **exists** ([*string* $keyName], [*long* $lifetime])

Checks if the cache entry exists and has not expired



public *mixed*  **increment** ([*unknown* $key_name], [*long* $value])

Atomic increment of a given key, by number $value



public *mixed*  **decrement** ([*unknown* $key_name], [*long* $value])

Atomic decrement of a given key, by number $value



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



