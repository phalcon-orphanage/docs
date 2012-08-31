Class **Phalcon\\Cache\\Backend\\Memcache**
===========================================

*extends* :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

Allows to cache output fragments, PHP data or raw data to a memcache backend   This adapter uses the special memcached key "_PHCM" to store all the keys internally used by the adapter  

.. code-block:: php

    <?php

    
    
     //Cache data for 2 days
    $frontendOptions = array(
    'lifetime' => 172800
    );
    
     //Set memcached server connection settings
    $backendOptions = array(
    'host' => 'localhost',
      'port' => 11211,
      'persistent' => false
    );
    
    $cache = Phalcon_Cache::factory('Data', 'Memcache', $frontendOptions, $backendOptions);
    
     //Cache arbitrary data
    $cache->store('my-data', array(1, 2, 3, 4, 5));
    
     //Get data
    $data = $cache->get('my-data');
    
    





Methods
---------

**__construct** (*mixed* **$frontendObject**, *array* **$backendOptions**)

**_connect** ()

*mixed* **get** (*int|string* **$keyName**, *long* **$lifetime**)

**save** (*int|string* **$keyName**, *string* **$content**, *long* **$lifetime**, *boolean* **$stopBuffer**)

*boolean* **delete** (*int|string* **$keyName**)

*array* **queryKeys** (*string* **$prefix**)

**__destruct** ()

**start** (*unknown* **$keyName**)

**getFrontend** ()

**isFresh** ()

**isStarted** ()

**getLastKey** ()

