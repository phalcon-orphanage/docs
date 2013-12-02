Class **Phalcon\\Cache\\Frontend\\Json**
========================================

*implements* :doc:`Phalcon\\Cache\\FrontendInterface <Phalcon_Cache_FrontendInterface>`

Allows to cache data converting/deconverting them to JSON.  This adapters uses the json_encode/json_decode PHP's functions  As the data is encoded in JSON other systems accessing the same backend could process them  

.. code-block:: php

    <?php

     // Cache the data for 2 days
     $frontCache = new Phalcon\Cache\Frontend\Json(array(
        "lifetime" => 172800
     ));
    
     //Create the Cache setting memcached connection options
     $cache = new Phalcon\Cache\Backend\Memcache($frontCache, array(
    	'host' => 'localhost',
    	'port' => 11211,
      	'persistent' => false
     ));
    
     //Cache arbitrary data
     $cache->save('my-data', array(1, 2, 3, 4, 5));
    
     //Get data
     $data = $cache->get('my-data');



Methods
---------

public  **__construct** ([*array* $frontendOptions])

Phalcon\\Cache\\Frontend\\Base64 constructor



public *integer*  **getLifetime** ()

Returns the cache lifetime



public *boolean*  **isBuffering** ()

Check whether if frontend is buffering output



public  **start** ()

Starts output frontend. Actually, does nothing



public *string*  **getContent** ()

Returns output cached content



public  **stop** ()

Stops output frontend



public *string*  **beforeStore** (*mixed* $data)

Serializes data before storing it



public *mixed*  **afterRetrieve** (*mixed* $data)

Unserializes data after retrieving it



