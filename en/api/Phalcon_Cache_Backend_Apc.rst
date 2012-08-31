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

*mixed* **get** (*int|string* **$keyName**, *long* **$lifetime**)

**save** (*int|string* **$keyName**, *string* **$content**, *long* **$lifetime**, *boolean* **$stopBuffer**)

*boolean* **delete** (*string|int* **$keyName**)

*array* **queryKeys** (*string* **$prefix**)

**__construct** (*unknown* **$frontendObject**, *unknown* **$backendOptions**)

**start** (*unknown* **$keyName**)

**getFrontend** ()

**isFresh** ()

**isStarted** ()

**getLastKey** ()

