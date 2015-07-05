Class **Phalcon\\Cache\\Backend\\Mongo**
========================================

*extends* abstract class :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

*implements* :doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>`

Allows to cache output fragments, PHP data or raw data to a MongoDb backend  

.. code-block:: php

    <?php

     // Cache data for 2 days
     $frontCache = new \Phalcon\Cache\Frontend\Base64(array(
    	"lifetime" => 172800
     ));
    
     //Create a MongoDB cache
     $cache = new \Phalcon\Cache\Backend\Mongo($frontCache, array(
    	'server' => "mongodb://localhost",
          'db' => 'caches',
    	'collection' => 'images'
     ));
    
     //Cache arbitrary data
     $cache->save('my-data', file_get_contents('some-image.jpg'));
    
     //Get data
     $data = $cache->get('my-data');



Methods
-------

public  **__construct** (*unknown* $frontend, [*unknown* $options])

Phalcon\\Cache\\Backend\\Mongo constructor



final protected *MongoCollection*  **_getCollection** ()

Returns a MongoDb collection based on the backend parameters



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



public *collection->remove(...)*  **gc** ()

gc



public *mixed*  **increment** (*unknown* $keyName, [*unknown* $value])

Increment of a given key by $value



public *mixed*  **decrement** (*int|string* $keyName, [*long* $value])

Decrement of a given key by $value



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


public *mixed*  **start** (*unknown* $keyName, [*unknown* $lifetime]) inherited from Phalcon\\Cache\\Backend

Starts a cache. The keyname allows to identify the created fragment



public  **stop** ([*unknown* $stopBuffer]) inherited from Phalcon\\Cache\\Backend

Stops the frontend without store any cached content



public  **isFresh** () inherited from Phalcon\\Cache\\Backend

Checks whether the last cache is fresh or cached



public  **isStarted** () inherited from Phalcon\\Cache\\Backend

Checks whether the cache has starting buffering or not



public *int*  **getLifetime** () inherited from Phalcon\\Cache\\Backend

Gets the last lifetime set



