Class **Phalcon_Cache_Backend_Apc**
===================================

Allows to cache output fragments, PHP data and raw data using an APC backend  

.. code-block:: php

    <?php
    
    // Cache data for 2 days
    $frontendOptions = array(
        'lifetime' => 172800
    );
    
    $cache = Phalcon_Cache::factory('Data', 'Apc', $frontendOptions, array());
    
    // Cache arbitrary data
    $cache->store('my-data', array(1, 2, 3, 4, 5));
    
    // Get data
    $data = $cache->get('my-data');

Methods
---------

**mixed** **get** (int|string $keyName, long $lifetime)

Returns a cached content

**save** (int|string $keyName, string $content, long $lifetime, boolean $stopBuffer)

Stores cached content into the APC backend

**boolean** **delete** (string|int $keyName)

Deletes a value from the cache using its key

**array** **queryKeys** (string $prefix)

Query the existing cached keys

