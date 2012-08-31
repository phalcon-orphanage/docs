Class **Phalcon\\Cache\\Backend\\Apc**
======================================

*extends* :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

Allows to cache output fragments, PHP data and raw data using a memcache backend  

.. code-block:: php

    <?php

     //Cache data for 2 days
    $frontendOptions = array(
    'lifetime' => 172800
    );
    
    $cache = Phalcon_Cache::factory('Data', 'Apc', $frontendOptions, array());
    
     //Cache arbitrary data
    $cache->store('my-data', array(1, 2, 3, 4, 5));
    
     //Get data
    $data = $cache->get('my-data');



Methods
---------

*mixed* public **get** (*int|string* $keyName, *long* $lifetime)

Returns a cached content



public **save** (*int|string* $keyName, *string* $content, *long* $lifetime, *boolean* $stopBuffer)

Stores cached content into the file backend



*boolean* public **delete** (*string|int* $keyName)

Deletes a value from the cache by its key



*array* public **queryKeys** (*string* $prefix)

Query the existing cached keys



public **__construct** (*unknown* $frontendObject, *unknown* $backendOptions)

public **start** (*unknown* $keyName)

public **getFrontend** ()

public **isFresh** ()

public **isStarted** ()

public **getLastKey** ()

