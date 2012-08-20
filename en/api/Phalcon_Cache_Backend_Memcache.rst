Class **Phalcon_Cache_Backend_Memcache**
========================================

Allows to cache output fragments, PHP data or raw data to a memcache backend. This adapter uses the special memcached key "_PHCM" to store all the keys internally used by the adapter.

.. code-block:: php

    <?php
    
    // Cache data for 2 days
    $frontendOptions = array(
        'lifetime' => 172800
    );
    
    // Set memcached server connection settings
    $backendOptions = array(
        'host'       => 'localhost',
        'port'       => 11211,
        'persistent' => false
    );
    
    $cache = Phalcon_Cache::factory('Data', 'Memcache', $frontendOptions, $backendOptions);
    
    // Cache arbitrary data
    $cache->store('my-data', array(1, 2, 3, 4, 5));
    
    // Get data
    $data = $cache->get('my-data');

Methods
---------

**__construct** (mixed $frontendObject, array $backendOptions)

Phalcon_Backend_Adapter_Memcache constructor

**_connect** ()

Create internal connection to memcached

**mixed** **get** (int|string $keyName, long $lifetime)

Returns a cached content

**save** (int|string $keyName, string $content, long $lifetime, boolean $stopBuffer)

Stores cached content into the memcached backend

**boolean** **delete** (int|string $keyName)

Deletes a value from the cache using its key

**array** **queryKeys** (string $prefix)

Query the existing cached keys

**__destruct** ()

Destructs the backend closing the memcached connection

