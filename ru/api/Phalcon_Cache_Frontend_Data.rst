Class **Phalcon\\Cache\\Frontend\\Data**
========================================

*implements* :doc:`Phalcon\\Cache\\FrontendInterface <Phalcon_Cache_FrontendInterface>`

Allows to cache native PHP data in a serialized form  

.. code-block:: php

    <?php

    <?php
    
    // Cache the files for 2 days using a Data frontend
    $frontCache = new \Phalcon\Cache\Frontend\Data(array(
    	"lifetime" => 172800
    ));
    
    // Create the component that will cache "Data" to a "File" backend
    // Set the cache file directory - important to keep the "/" at the end of
    // of the value for the folder
    $cache = new \Phalcon\Cache\Backend\File($frontCache, array(
    	"cacheDir" => "../app/cache/"
    ));
    
    // Try to get cached records
    $cacheKey = 'robots_order_id.cache';
    $robots    = $cache->get($cacheKey);
    if ($robots === null) {
    
    	// $robots is null due to cache expiration or data does not exist
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
-------

public  **__construct** ([*unknown* $frontendOptions])

Phalcon\\Cache\\Frontend\\Data constructor



public  **getLifetime** ()

Returns the cache lifetime



public  **isBuffering** ()

Check whether if frontend is buffering output



public  **start** ()

Starts output frontend. Actually, does nothing



public *string*  **getContent** ()

Returns output cached content



public  **stop** ()

Stops output frontend



public  **beforeStore** (*unknown* $data)

Serializes data before storing them



public  **afterRetrieve** (*unknown* $data)

Unserializes data after retrieval



