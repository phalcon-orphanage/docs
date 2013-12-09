Class **Phalcon\\Cache\\Frontend\\Igbinary**
============================================

*extends* class :doc:`Phalcon\\Cache\\Frontend\\Data <Phalcon_Cache_Frontend_Data>`

*implements* :doc:`Phalcon\\Cache\\FrontendInterface <Phalcon_Cache_FrontendInterface>`

Allows to cache native PHP data in a serialized form using igbinary extension  

.. code-block:: php

    <?php

    // Cache the files for 2 days using Igbinary frontend
    $frontCache = new Phalcon\Cache\Frontend\Igbinary(array(
    	"lifetime" => 172800
    ));
    
    // Create the component that will cache "Igbinary" to a "File" backend
    // Set the cache file directory - important to keep the "/" at the end of
    // of the value for the folder
    $cache = new Phalcon\Cache\Backend\File($frontCache, array(
    	"cacheDir" => "../app/cache/"
    ));
    
    // Try to get cached records
    $cacheKey  = 'robots_order_id.cache';
    $robots    = $cache->get($cacheKey);
    if ($robots === null) {
    
    	// $robots is null due to cache expiration or data do not exist
    	// Make the database call and populate the variable
    	$robots = Robots::find(array("order" => "id"));
    
    	// Store it in the cache
    	$cache->save($cacheKey, $robots);
    }
    
    // Use $robots :)
    foreach ($robots as $robot) {
    	echo $robot->name, "\n";
    }



Methods
---------

public *string*  **beforeStore** (*mixed* $data)

Serializes data before storing them



public *mixed*  **afterRetrieve** (*mixed* $data)

Unserializes data after retrieval



public  **__construct** ([*array* $frontendOptions]) inherited from Phalcon\\Cache\\Frontend\\Data

Phalcon\\Cache\\Frontend\\Data constructor



public *int*  **getLifetime** () inherited from Phalcon\\Cache\\Frontend\\Data

Returns cache lifetime



public *boolean*  **isBuffering** () inherited from Phalcon\\Cache\\Frontend\\Data

Check whether if frontend is buffering output



public  **start** () inherited from Phalcon\\Cache\\Frontend\\Data

Starts output frontend. Actually, does nothing



public *string*  **getContent** () inherited from Phalcon\\Cache\\Frontend\\Data

Returns output cached content



public  **stop** () inherited from Phalcon\\Cache\\Frontend\\Data

Stops output frontend



