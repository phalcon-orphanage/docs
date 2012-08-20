Class **Phalcon_Cache**
=======================

Phalcon_Cache can be used to cache output fragments, PHP data and raw data in order to improve performance  

.. code-block:: php

    <?php
    
    // Cache the file for 2 days
    $frontendOptions = array(
      'lifetime' => 172800
    );
    
    // Set the cache directory
    $backendOptions = array(
      'cacheDir' => '../app/cache/'
    );
    
    $cache = Phalcon_Cache::factory(
        'Output', 'File', $frontendOptions, $backendOptions
    );
    
    $content = $cache->start('my-cache');
    if ($content === null) {
        echo time();
        $cache->save();
    } else {
        echo $content;
    }

Methods
---------

**Phalcon_Cache_Backend_File** **factory** (string $frontendAdapter, string $backendAdapter, array $frontendOptions, array $backendOptions)

Creates different cache backends based on their adapters

