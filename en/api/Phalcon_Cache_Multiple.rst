Class **Phalcon\\Cache\\Multiple**
==================================

Allows to read to chained backend adapters writing to multiple backends  

.. code-block:: php

    <?php

       use Phalcon\Cache\Frontend\Data as DataFrontend,
           Phalcon\Cache\Multiple,
           Phalcon\Cache\Backend\Apc as ApcCache,
           Phalcon\Cache\Backend\Memcache as MemcacheCache,
           Phalcon\Cache\Backend\File as FileCache;
    
       $ultraFastFrontend = new DataFrontend(array(
           "lifetime" => 3600
       ));
    
       $fastFrontend = new DataFrontend(array(
           "lifetime" => 86400
       ));
    
       $slowFrontend = new DataFrontend(array(
           "lifetime" => 604800
       ));
    
       //Backends are registered from the fastest to the slower
       $cache = new Multiple(array(
           new ApcCache($ultraFastFrontend, array(
               "prefix" => 'cache',
           )),
           new MemcacheCache($fastFrontend, array(
               "prefix" => 'cache',
               "host" => "localhost",
               "port" => "11211"
           )),
           new FileCache($slowFrontend, array(
               "prefix" => 'cache',
               "cacheDir" => "../app/cache/"
           ))
       ));
    
       //Save, saves in every backend
       $cache->save('my-key', $data);



Methods
-------

public  **__construct** ([*unknown* $backends])

Phalcon\\Cache\\Multiple constructor



public  **push** (*unknown* $backend)

Adds a backend



public *mixed*  **get** (*unknown* $keyName, [*unknown* $lifetime])

Returns a cached content reading the internal backends



public  **start** (*unknown* $keyName, [*unknown* $lifetime])

Starts every backend



public  **save** ([*unknown* $keyName], [*unknown* $content], [*unknown* $lifetime], [*unknown* $stopBuffer])

Stores cached content into all backends and stops the frontend



public *boolean*  **delete** (*unknown* $keyName)

Deletes a value from each backend



public *boolean*  **exists** ([*unknown* $keyName], [*unknown* $lifetime])

Checks if cache exists in at least one backend



