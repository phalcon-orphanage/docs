Class **Phalcon\\Cache\\Backend\\File**
=======================================

*extends* :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`

Allows to cache output fragments using a file backend  

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

public **__construct** (*mixed* $frontendObject, *array* $backendOptions)

Phalcon\\Backend\\Adapter\\File constructor



*mixed* public **get** (*int|string* $keyName, *long* $lifetime)

Returns a cached content



public **save** (*int|string* $keyName, *string* $content, *long* $lifetime, *boolean* $stopBuffer)

Stores cached content into the file backend



*boolean* public **delete** (*int|string* $keyName)

Deletes a value from the cache by its key



*array* public **queryKeys** (*string* $prefix)

Query the existing cached keys



public **start** (*unknown* $keyName)

public **getFrontend** ()

public **isFresh** ()

public **isStarted** ()

public **getLastKey** ()

