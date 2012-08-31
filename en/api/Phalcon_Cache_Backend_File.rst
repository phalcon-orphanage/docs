Class **Phalcon\\Cache\\Backend\\File**
=======================================

*extends* :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

Phalcon\\Cache\\Backend\\File   Allows to cache output fragments using a file backend  

.. code-block:: php

    <?php

    
    //Cache the file for 2 days
    $frontendOptions = array(
    	'lifetime' => 172800
    );
    
    //Set the cache directory
    $backendOptions = array(
    	'cacheDir' => '../app/cache/'
    );
    
    $cache = Phalcon_Cache::factory('Output', 'File', $frontendOptions, $backendOptions);
    
    $content = $cache->start('my-cache');
    if($content===null){
      	echo '<h1>', time(), '</h1>';
      	$cache->save();
    } else {
    	echo $content;
    }
    





Methods
---------

**__construct** (*mixed* **$frontendObject**, *array* **$backendOptions**)

*mixed* **get** (*int|string* **$keyName**, *long* **$lifetime**)

**save** (*int|string* **$keyName**, *string* **$content**, *long* **$lifetime**, *boolean* **$stopBuffer**)

*boolean* **delete** (*int|string* **$keyName**)

*array* **queryKeys** (*string* **$prefix**)

**start** (*unknown* **$keyName**)

**getFrontend** ()

**isFresh** ()

**isStarted** ()

**getLastKey** ()

