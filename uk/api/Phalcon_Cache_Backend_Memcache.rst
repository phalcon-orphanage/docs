Class **Phalcon\\Cache\\Backend\\Memcache**
===========================================

*extends* abstract class :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

*implements* :doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cache/backend/memcache.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Allows to cache output fragments, PHP data or raw data to a memcache backend  This adapter uses the special memcached key "_PHCM" to store all the keys internally used by the adapter  

.. code-block:: php

    <?php

     // Cache data for 2 days
     $frontCache = new \Phalcon\Cache\Frontend\Data(array(
        "lifetime" => 172800
     ));
    
     //Create the Cache setting memcached connection options
     $cache = new \Phalcon\Cache\Backend\Memcache($frontCache, array(
    	'host' => 'localhost',
    	'port' => 11211,
      	'persistent' => false
     ));
    
     //Cache arbitrary data
     $cache->save('my-data', array(1, 2, 3, 4, 5));
    
     //Get data
     $data = $cache->get('my-data');



Methods
-------

public  **__construct** (:doc:`Phalcon\\Cache\\FrontendInterface <Phalcon_Cache_FrontendInterface>` $frontend, [*array* $options])

Phalcon\\Cache\\Backend\\Memcache constructor



public  **_connect** ()

Create internal connection to memcached



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



public *long*  **increment** ([*string* $keyName], [*unknown* $value])

Increment of given $keyName by $value



public *long*  **decrement** ([*string* $keyName], [*long* $value])

Decrement of $keyName by given $value



public  **flush** ()

Immediately invalidates all existing items.



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


public *mixed*  **start** (*int|string* $keyName, [*int* $lifetime]) inherited from Phalcon\\Cache\\Backend

Starts a cache. The keyname allows to identify the created fragment



public  **stop** ([*unknown* $stopBuffer]) inherited from Phalcon\\Cache\\Backend

Stops the frontend without store any cached content



public  **isFresh** () inherited from Phalcon\\Cache\\Backend

Checks whether the last cache is fresh or cached



public  **isStarted** () inherited from Phalcon\\Cache\\Backend

Checks whether the cache has starting buffering or not



public *int*  **getLifetime** () inherited from Phalcon\\Cache\\Backend

Gets the last lifetime set



