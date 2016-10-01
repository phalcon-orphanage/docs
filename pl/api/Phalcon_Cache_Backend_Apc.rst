Class **Phalcon\\Cache\\Backend\\Apc**
======================================

*extends* abstract class :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

*implements* :doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cache/backend/apc.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Allows to cache output fragments, PHP data and raw data using an APC backend  

.. code-block:: php

    <?php

     use Phalcon\Cache\Backend\Apc;
     use Phalcon\Cache\Frontend\Data as FrontData;
    
     // Cache data for 2 days
     $frontCache = new FrontData([
         'lifetime' => 172800
     ]);
    
     $cache = new Apc($frontCache, [
         'prefix' => 'app-data'
     ]);
    
     // Cache arbitrary data
     $cache->save('my-data', [1, 2, 3, 4, 5]);
    
     // Get data
     $data = $cache->get('my-data');



Methods
-------

public  **get** (*mixed* $keyName, [*mixed* $lifetime])

Returns a cached content



public  **save** ([*string* | *long* $keyName], [*string* $content], [*long* $lifetime], [*boolean* $stopBuffer])

Stores cached content into the APC backend and stops the frontend



public *mixed* **increment** ([*string* $keyName], [*long* $value])

Increment of a given key, by number $value



public *mixed* **decrement** ([*string* $keyName], [*long* $value])

Decrement of a given key, by number $value



public  **delete** (*mixed* $keyName)

Deletes a value from the cache by its key



public *array* **queryKeys** ([*string* $prefix])

Query the existing cached keys



public *boolean* **exists** ([*string* | *long* $keyName], [*long* $lifetime])

Checks if cache exists and it hasn't expired



public  **flush** ()

Immediately invalidates all existing items.



public  **getFrontend** () inherited from :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

...


public  **setFrontend** (*mixed* $frontend) inherited from :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

...


public  **getOptions** () inherited from :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

...


public  **setOptions** (*mixed* $options) inherited from :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

...


public  **getLastKey** () inherited from :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

...


public  **setLastKey** (*mixed* $lastKey) inherited from :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

...


public  **__construct** (:doc:`Phalcon\\Cache\\FrontendInterface <Phalcon_Cache_FrontendInterface>` $frontend, [*array* $options]) inherited from :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

Phalcon\\Cache\\Backend constructor



public *mixed* **start** (*int* | *string* $keyName, [*int* $lifetime]) inherited from :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

Starts a cache. The keyname allows to identify the created fragment



public  **stop** ([*mixed* $stopBuffer]) inherited from :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

Stops the frontend without store any cached content



public  **isFresh** () inherited from :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

Checks whether the last cache is fresh or cached



public  **isStarted** () inherited from :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

Checks whether the cache has starting buffering or not



public *int* **getLifetime** () inherited from :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

Gets the last lifetime set



