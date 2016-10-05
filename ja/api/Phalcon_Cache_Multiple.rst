Class **Phalcon\\Cache\\Multiple**
==================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cache/multiple.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

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

public  **__construct** ([:doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>`\ [] $backends])

Phalcon\\Cache\\Multiple constructor



public  **push** (:doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>` $backend)

Adds a backend



public *mixed* **get** (*string* | *int* $keyName, [*long* $lifetime])

Returns a cached content reading the internal backends



public  **start** (*string* | *int* $keyName, [*long* $lifetime])

Starts every backend



public  **save** ([*string* $keyName], [*string* $content], [*long* $lifetime], [*boolean* $stopBuffer])

Stores cached content into all backends and stops the frontend



public *boolean* **delete** (*string* | *int* $keyName)

Deletes a value from each backend



public *boolean* **exists** ([*string* | *int* $keyName], [*long* $lifetime])

Checks if cache exists in at least one backend



public  **flush** ()

Flush all backend(s)



