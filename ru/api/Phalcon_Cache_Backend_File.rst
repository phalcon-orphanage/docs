Class **Phalcon\\Cache\\Backend\\File**
=======================================

*extends* abstract class :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

*implements* :doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cache/backend/file.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Allows to cache output fragments using a file backend  

.. code-block:: php

    <?php

     use Phalcon\Cache\Backend\File;
     use Phalcon\Cache\Frontend\Output as FrontOutput;
    
     // Cache the file for 2 days
     $frontendOptions = [
         'lifetime' => 172800
     ];
    
     // Create an output cache
     $frontCache = FrontOutput($frontOptions);
    
     // Set the cache directory
     $backendOptions = [
         'cacheDir' => '../app/cache/'
     ];
    
     // Create the File backend
     $cache = new File($frontCache, $backendOptions);
    
     $content = $cache->start('my-cache');
     if ($content === null) {
         echo '<h1>', time(), '</h1>';
         $cache->save();
     } else {
         echo $content;
     }



Methods
-------

public  **__construct** (:doc:`Phalcon\\Cache\\FrontendInterface <Phalcon_Cache_FrontendInterface>` $frontend, *array* $options)

Phalcon\\Cache\\Backend\\File constructor



public  **get** (*mixed* $keyName, [*mixed* $lifetime])

Returns a cached content



public  **save** ([*int* | *string* $keyName], [*string* $content], [*int* $lifetime], [*boolean* $stopBuffer])

Stores cached content into the file backend and stops the frontend



public *boolean* **delete** (*int* | *string* $keyName)

Deletes a value from the cache by its key



public *array* **queryKeys** ([*string* | *int* $prefix])

Query the existing cached keys



public *boolean* **exists** ([*string* | *int* $keyName], [*int* $lifetime])

Checks if cache exists and it isn't expired



public *mixed* **increment** ([*string* | *int* $keyName], [*int* $value])

Increment of a given key, by number $value



public *mixed* **decrement** ([*string* | *int* $keyName], [*int* $value])

Decrement of a given key, by number $value



public  **flush** ()

Immediately invalidates all existing items.



public  **getKey** (*mixed* $key)

Return a file-system safe identifier for a given key



public  **useSafeKey** (*mixed* $useSafeKey)

Set whether to use the safekey or not



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



