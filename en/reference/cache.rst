Improving Performance with Cache
================================
Phalcon provides the , it help us to cache output fragmentsavoiding the continuous reprocessing of code that every time returns the same output. Phalcon_Cache is very similar to the Zend Framework counterpart but is written in C to reach high performance.This component uses an internal structure of frontends and backends. Frontends acts as input sources and backends provides storage features. 

When to implement cache?
------------------------
Although this component is very fast, implementing it in unnecessary cases could lead to loss ofperformance rather than get it. We recommend you check this cases before use cache: 

* You are making complex calculations that everytime returns the same result (changing infrequently)
* You are using a lot of helpers and the output generated is almost always the same
* You are accessing database data constantly and these data rarely change

Caching Output Fragments
------------------------
The following example shows how to implement a cache using this component. It takes the output generatedby PHP and stores it into a file. The content of the file is refreshed each 172800 seconds (2 days). The implementation of the cache avoids the continuous execution of the helper Phalcon_Tag::linkTo. 

.. code-block:: php

    <?php
    
    //Cache the files for 2 days
    $frontendOptions = array(
      "lifetime" => 172800
    );
    
    //Set the cache file directory
    $backendOptions = array(
      "cacheDir" => "../app/cache/"
    );
    
    //Create a cache that caches from the "Output" to a "File" backend
    $cache = Phalcon_Cache::factory("Output", "File",
       $frontendOptions, $backendOptions);
    
    //Get/Set the cache file to ../app/cache/my-cache.html
    $content = $cache->start("my-cache.html");
    
    //If $content is null then the content will be created or will refreshed
    if ($content === null) {
    
      //Print date and time
      echo date("r");
    
      //Generate a link to the sign-up action
      echo Phalcon\Tag::linkTo(array(
        "user/signup",
        "Sign Up",
        "class" => "signup-button"
      ));
    
      //Stores the output into cache file
      $cache->save();
    } else {
    
      //Echo the cached output
      echo $content;
    }

Caching Arbitrary Data
----------------------
Remember the situations mentioned above? Caching data is very useful to reduce access todatabase systems or avoid avoid heavy processing frequently. 

.. code-block:: php

    <?php
    
    //Cache data for one hour
    $frontendOptions = array(
      "lifetime" => 3600
    );
    
    //Memcached connection settings
    $backendOptions = array(
      "host" => "localhost",
      "port" => "11211"
    );
    
    //Create a cache
    $cache = Phalcon_Cache::factory("Data", "Memcached", $frontendOptions, $backendOptions);
    
    //Try to get cached records
    $robots = $cache->get("robots");
    if($robots===null){
    
       //$robots are null due to cache expiration or data is nonexistent
       //Only here, the database system is accessed
       $robots = Robots::find(array("order" => "id"));
    
       $cache->save("robots", $robots);
    }
    
    //Use $robots normally
    foreach($robots as $robot){
       echo $robot->name, "\n";
    }

Querying the cache
------------------
Insofar as we add items to the cache, they are uniquely identified with the keys used to store them.If the cached data has expired or the key is not existent in the cache the method get will return null. 

.. code-block:: php

    <?php

    //Retrieve products by key "myProducts"
    $products = $cache->get("myProducts");

If you want to know which keys are stored in the cache you could call the queryKeys method:

.. code-block:: php

    <?php

    //Query all keys used in the cache
    $keys = $cache->queryKeys();
    foreach($keys as $key){
    	$data = $cache->get($key);
    	echo "Key=", $key, " Data=", $data;
    }
    
    //Query keys in the cache that begins with "my-prefix"
    $keys = $cache->queryKeys("my-prefix");


Deleting from the Cache
-----------------------
Additionally, sometimes may be necessary to remove items from the cache, this in order to forcethem to be refreshed from its origins. To delete an item you need to know the key with which it was created: 

.. code-block:: php

    <?php

    //Delete an item with a specific key
    $cache->queryKeys("someKey");
    
    //Delete all items from the cache
    $keys = $cache->queryKeys();
    foreach($keys as $key){
    	$cache->delete($key);
    }


Frontend Adapters
-----------------
This component makes use of frontend adapters to encapsulate the different input sources to cache.

+---------+-----------------------------------------------------------------------------------------------------------------------------------------------------+
| Adapter | Description                                                                                                                                         | 
+=========+=====================================================================================================================================================+
| Output  | Read input data from standard PHP output                                                                                                            | 
+---------+-----------------------------------------------------------------------------------------------------------------------------------------------------+
| Data    | It's used to cache any kind of PHP data (big arrays, objects, text, etc). This adapter always serializes the data before store it into the backend. | 
+---------+-----------------------------------------------------------------------------------------------------------------------------------------------------+
| None    | It's used to cache any kind of PHP data without serializing them.                                                                                   | 
+---------+-----------------------------------------------------------------------------------------------------------------------------------------------------+


Backend Adapters
----------------
Also, this component makes use of backend adapters to encapsulate storage details related to the cache.

+-----------+------------------------------------------------+-----------+---------------------+
| Adapter   | Description                                    | Info      | Required Extensions | 
+===========+================================================+===========+=====================+
| File      | Stores data to local plain files               |           |                     | 
+-----------+------------------------------------------------+-----------+---------------------+
| Memcached | Stores data to a memcached server              | Memcached | memcache            | 
+-----------+------------------------------------------------+-----------+---------------------+
| APC       | Stores data to the Alternative PHP Cache (APC) | APC       | APC                 | 
+-----------+------------------------------------------------+-----------+---------------------+


File Backend
^^^^^^^^^^^^
This backend will store cached content into files in the local server. The available options for this backend are: 

+----------+-----------------------------------------------------------+
| Option   | Description                                               | 
+==========+===========================================================+
| cacheDir | A writable directory on which cached files will be placed | 
+----------+-----------------------------------------------------------+


Memcached Backend
^^^^^^^^^^^^^^^^^
This backend will store cached content on a memcached server. The available options for this backend are: 

+------------+---------------------------------------------+
| Option     | Description                                 | 
+============+=============================================+
| host       | memcached host                              | 
+------------+---------------------------------------------+
| port       | memcached port                              | 
+------------+---------------------------------------------+
| persistent | create a persitent connection to memcached? | 
+------------+---------------------------------------------+


APC Backend
^^^^^^^^^^^
This backend will store cached content on Alternative PHP Cache (APC). This cache doesn't have any configuration. 