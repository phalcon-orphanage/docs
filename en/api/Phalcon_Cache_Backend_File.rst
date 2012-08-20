Class **Phalcon_Cache_Backend_File**
====================================

Allows to cache output fragments using a file backend  

.. code-block:: php

    <?php

    // Cache the file for 2 days
    $frontendOptions = array(
        'lifetime' => 172800
    );
    
    //Set the cache directory
    $backendOptions = array(
    	'cacheDir' => '../app/cache/'
    );
    
    $cache = Phalcon_Cache::factory('Output', 'File', $frontendOptions, $backendOptions);
    
    $content = $cache->start('my-cache');
    if ($content === null){
        echo '<h1>', time(), '</h1>';
        $cache->save();
    } else {
        echo $content;
    }

Methods
---------

**__construct** (mixed $frontendObject, array $backendOptions)

Phalcon_Backend_Adapter_File constructor

**mixed** **get** (int|string $keyName, long $lifetime)

Returns a cached content

**save** (int|string $keyName, string $content, long $lifetime, boolean $stopBuffer)

Stores cached content into the file backend

**boolean** **delete** (int|string $keyName)

Deletes a value from the cache using its key

**array** **queryKeys** (string $prefix)

Query the existing cached keys

