Class **Phalcon\\Cache\\Frontend\\Base64**
==========================================

*extends* class :doc:`Phalcon\\Cache\\Frontend\\Data <Phalcon_Cache_Frontend_Data>`

*implements* :doc:`Phalcon\\Cache\\FrontendInterface <Phalcon_Cache_FrontendInterface>`

Allows to cache data converting/deconverting them to base64.  This adapters uses the base64_encode/base64_decode PHP's functions  

.. code-block:: php

    <?php

     // Cache the files for 2 days using a Base64 frontend
     $frontCache = new Phalcon\Cache\Frontend\Base64(array(
        "lifetime" => 172800
     ));
    
     //Create a MongoDB cache
     $cache = new Phalcon\Cache\Backend\Mongo($frontCache, array(
    	'server' => "mongodb://localhost",
          'db' => 'caches',
    	'collection' => 'images'
     ));
    
     // Try to get cached image
     $cacheKey = 'some-image.jpg.cache';
     $image    = $cache->get($cacheKey);
     if ($image === null) {
    
         // Store the image in the cache
         $cache->save($cacheKey, file_get_contents('tmp-dir/some-image.jpg'));
     }
    
     header('Content-Type: image/jpeg');
     echo $image;



Methods
-------

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



