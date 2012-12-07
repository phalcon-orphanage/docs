Class **Phalcon\\Cache\\Frontend\\Base64**
==========================================

<<<<<<< HEAD
Allows to cache data converting/deconverting them to base64. This adapters uses the base64_encode/base64_decode PHP's functions 

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
         $cache->save($cacheKey, file_put_contents('tmp-dir/some-image.jpg'));
     }
    
     header('Content-Type: image/jpeg');
     echo $image;


=======
*implements* :doc:`Phalcon\\Cache\\FrontendInterface <Phalcon_Cache_FrontendInterface>`
>>>>>>> 0.7.0

Methods
---------

public  **__construct** (*unknown* $frontendOptions)

...


public  **getLifetime** ()

...


public  **isBuffering** ()

...


public  **start** ()

...


public  **getContent** ()

...


public  **stop** ()

...


public  **beforeStore** (*unknown* $data)

...


public  **afterRetrieve** (*unknown* $data)

...


