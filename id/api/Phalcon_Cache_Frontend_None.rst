Class **Phalcon\\Cache\\Frontend\\None**
========================================

*implements* :doc:`Phalcon\\Cache\\FrontendInterface <Phalcon_Cache_FrontendInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cache/frontend/none.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Discards any kind of frontend data input. This frontend does not have expiration time or any other options  

.. code-block:: php

    <?php

    <?php
    
    //Create a None Cache
    $frontCache = new \Phalcon\Cache\Frontend\None();
    
    // Create the component that will cache "Data" to a "Memcached" backend
    // Memcached connection settings
    $cache = new \Phalcon\Cache\Backend\Memcache($frontCache, array(
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
-------

public  **getLifetime** ()

Returns cache lifetime, always one second expiring content



public  **isBuffering** ()

Check whether if frontend is buffering output, always false



public  **start** ()

Starts output frontend



public *string* **getContent** ()

Returns output cached content



public  **stop** ()

Stops output frontend



public  **beforeStore** (*mixed* $data)

Prepare data to be stored



public  **afterRetrieve** (*mixed* $data)

Prepares data to be retrieved to user



