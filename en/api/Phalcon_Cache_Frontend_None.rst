Class **Phalcon\\Cache\\Frontend\\None**
========================================

*extends* class :doc:`Phalcon\\Cache\\Frontend\\Data <Phalcon_Cache_Frontend_Data>`

*implements* :doc:`Phalcon\\Cache\\FrontendInterface <Phalcon_Cache_FrontendInterface>`

Discards any kind of frontend data input. This frontend does not have expiration time or any other options  

.. code-block:: php

    <?php

    //Create a None Cache
    $frontCache = new Phalcon\Cache\Frontend\None();
    
    // Create the component that will cache "Data" to a "Memcached" backend
    // Memcached connection settings
    $cache = new Phalcon\Cache\Backend\Memcache($frontCache, array(
    	"host" => "localhost",
    	"port" => "11211"
    ));
    
    // This Frontend always return the data as it's returned by the backend
    $cacheKey = 'robots_order_id.cache';
    $robots    = $cache->get($cacheKey);
    if ($robots === null) {
    
    	// This cache doesn't perform any expiration checking, so the data is always expired
    	// Make the database call and populate the variable
    	$robots = Robots::find(array("order" => "id"));
    
    	$cache->save($cacheKey, $robots);
    }
    
    // Use $robots :)
    foreach ($robots as $robot) {
    	echo $robot->name, "\n";
    }



Methods
---------

public *int*  **getLifetime** ()

Returns cache lifetime, always one second expiring content



public  **beforeStore** (*mixed* $data)

Prepare data to be stored



public  **afterRetrieve** (*mixed* $data)

Prepares data to be retrieved to user



public  **__construct** ([*array* $frontendOptions]) inherited from Phalcon\\Cache\\Frontend\\Data

Phalcon\\Cache\\Frontend\\Data constructor



public *boolean*  **isBuffering** () inherited from Phalcon\\Cache\\Frontend\\Data

Check whether if frontend is buffering output



public  **start** () inherited from Phalcon\\Cache\\Frontend\\Data

Starts output frontend. Actually, does nothing



public *string*  **getContent** () inherited from Phalcon\\Cache\\Frontend\\Data

Returns output cached content



public  **stop** () inherited from Phalcon\\Cache\\Frontend\\Data

Stops output frontend



