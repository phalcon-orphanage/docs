Class **Phalcon\\Cache\\Frontend\\Base64**
==========================================

*implements* :doc:`Phalcon\\Cache\\FrontendInterface <Phalcon_Cache_FrontendInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cache/frontend/base64.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Allows to cache data converting/deconverting them to base64.  This adapter uses the base64_encode/base64_decode PHP's functions  

.. code-block:: php

    <?php

    <?php
    
     // Cache the files for 2 days using a Base64 frontend
     $frontCache = new \Phalcon\Cache\Frontend\Base64(array(
        "lifetime" => 172800
     ));
    
     //Create a MongoDB cache
     $cache = new \Phalcon\Cache\Backend\Mongo($frontCache, array(
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

public  **__construct** ([*array* $frontendOptions])

Phalcon\\Cache\\Frontend\\Base64 constructor



public  **getLifetime** ()

Returns the cache lifetime



public  **isBuffering** ()

Check whether if frontend is buffering output



public  **start** ()

Starts output frontend. Actually, does nothing in this adapter



public *string* **getContent** ()

Returns output cached content



public  **stop** ()

Stops output frontend



public *string* **beforeStore** (*mixed* $data)

Serializes data before storing them



public *mixed* **afterRetrieve** (*mixed* $data)

Unserializes data after retrieval



