Class **Phalcon\\Cache\\Backend\\Mongo**
========================================

*extends* abstract class :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

*implements* :doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cache/backend/mongo.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Allows to cache output fragments, PHP data or raw data to a MongoDb backend

.. code-block:: php

    <?php

    use Phalcon\Cache\Backend\Mongo;
    use Phalcon\Cache\Frontend\Base64;

    // Cache data for 2 days
    $frontCache = new Base64(
        [
            "lifetime" => 172800,
        ]
    );

    // Create a MongoDB cache
    $cache = new Mongo(
        $frontCache,
        [
            "server"     => "mongodb://localhost",
            "db"         => "caches",
            "collection" => "images",
        ]
    );

    // Cache arbitrary data
    $cache->save(
        "my-data",
        file_get_contents("some-image.jpg")
    );

    // Get data
    $data = $cache->get("my-data");



Methods
-------

public  **__construct** (:doc:`Phalcon\\Cache\\FrontendInterface <Phalcon_Cache_FrontendInterface>` $frontend, [*array* $options])

Phalcon\\Cache\\Backend\\Mongo constructor



final protected *MongoCollection* **_getCollection** ()

Returns a MongoDb collection based on the backend parameters



public  **get** (*mixed* $keyName, [*mixed* $lifetime])

Returns a cached content



public  **save** ([*int* | *string* $keyName], [*string* $content], [*int* $lifetime], [*boolean* $stopBuffer])

Stores cached content into the file backend and stops the frontend



public *boolean* **delete** (*int* | *string* $keyName)

Deletes a value from the cache by its key



public  **queryKeys** ([*mixed* $prefix])

Query the existing cached keys.

.. code-block:: php

    <?php

    $cache->save("users-ids", [1, 2, 3]);
    $cache->save("projects-ids", [4, 5, 6]);

    var_dump($cache->queryKeys("users")); // ["users-ids"]




public  **exists** ([*string* $keyName], [*int* $lifetime])

Checks if cache exists and it isn't expired



public *collection->remove(...)* **gc** ()

gc



public  **increment** (*int* | *string* $keyName, [*mixed* $value])

Increment of a given key by $value



public  **decrement** (*int* | *string* $keyName, [*mixed* $value])

Decrement of a given key by $value



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



