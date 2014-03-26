使用缓存提升性能
================================
Phalcon 提供 :doc:`Phalcon\\Cache <cache>` 类，以便更快的访问经常使用的数据或已经处理过的数据。
:doc:`Phalcon\\Cache <cache>` 使用C语言编写，实现更高的性能，并减少系统开销。
这个类提供前端和后端两个组件，前端组件作为输入源或接口，后端提供存储选项。

什么时候使用缓存?
------------------------
虽然这个组件是非常高效快速的，但如果使用不当，也有可能导致性能问题，从而得不偿失。
我们建议你在使用缓存之前检查以下情况：

* 进行复杂的数据计算，每次返回相同的结果(不经常修改)
* 使用了大量的助手工具，并且生成的输出几乎问题一样的
* 不断的访问数据库，且这些数据很少改变

.. highlights::

    *注意* 即便已经使用了缓存，过一段时间后，你应该检查你的缓存的命中率，尤其你使用的是Memcache或者Apc时。使用后端提供的相关工具，很容易完成命中率检查。

缓存行为
----------------
缓存的执行分为两个部分：

* **Frontend**: 这一部分主要负责检查KEY是否过期以及在存储到backend之前/从backend取数据之后执行额外的数据转换
* **Backend**: 这部分主要负责沟通，并根据前端的需求读写数据。

片断缓存
------------------------
片断缓存是缓存HTML或者TEXT文本的一部分，然后原样返回。输出自动捕获来自ob_* 函数或PHP输出，以便它可以保存到缓存中。 下面的例子演示了这种用法。
它接收PHP生成的输出，并将其存储到一个文件中，文件的内容172800秒(2天)更新一次。

这种缓存机制的实现，使我们既能获得性能，而又不执行Phalcon\\Tag::linkTo的调用。

.. code-block:: php

    <?php

    //Create an Output frontend. Cache the files for 2 days
    $frontCache = new Phalcon\Cache\Frontend\Output(array(
        "lifetime" => 172800
    ));

    // Create the component that will cache from the "Output" to a "File" backend
    // Set the cache file directory - it's important to keep the "/" at the end of
    // the value for the folder
    $cache = new Phalcon\Cache\Backend\File($frontCache, array(
        "cacheDir" => "../app/cache/"
    ));

    // Get/Set the cache file to ../app/cache/my-cache.html
    $content = $cache->start("my-cache.html");

    // If $content is null then the content will be generated for the cache
    if ($content === null) {

        //Print date and time
        echo date("r");

        //Generate a link to the sign-up action
        echo Phalcon\Tag::linkTo(
            array(
                "user/signup",
                "Sign Up",
                "class" => "signup-button"
            )
        );

        // Store the output into the cache file
        $cache->save();

    } else {

        // Echo the cached output
        echo $content;
    }

*NOTE* In the example above, our code remains the same, echoing output to the user as it has been doing before.
缓存组件透明的捕获该输出，并将其存储到缓存文件中(前提是已经生成cache对象),或将其之前的缓存发送给用户，从而避免代价昂贵的开销。

Caching Arbitrary Data
----------------------
缓存是应用程序重要的组成部分。缓存可以减少数据库负载，重复使用常用的数据（但不更新），从而加快了您的应用程序。

File Backend Example
^^^^^^^^^^^^^^^^^^^^
缓存适配器之一'File'，此适配器的属性只有一个，它用来指定缓存文件的存储位置。使用 cacheDir选项进行控制，且 *必须* 以'/'结尾。

.. code-block:: php

    <?php

    // Cache the files for 2 days using a Data frontend
    $frontCache = new Phalcon\Cache\Frontend\Data(array(
        "lifetime" => 172800
    ));

    // Create the component that will cache "Data" to a "File" backend
    // Set the cache file directory - important to keep the "/" at the end of
    // of the value for the folder
    $cache = new Phalcon\Cache\Backend\File($frontCache, array(
        "cacheDir" => "../app/cache/"
    ));

    // Try to get cached records
    $cacheKey = 'robots_order_id.cache';
    $robots    = $cache->get($cacheKey);
    if ($robots === null) {

        // $robots is null because of cache expiration or data does not exist
        // Make the database call and populate the variable
        $robots = Robots::find(array("order" => "id"));

        // Store it in the cache
        $cache->save($cacheKey, $robots);
    }

    // Use $robots :)
    foreach ($robots as $robot) {
       echo $robot->name, "\n";
    }

Memcached Backend Example
^^^^^^^^^^^^^^^^^^^^^^^^^
上面的例子稍微改变一下(主要是配置方面)，就可以使用Memcache做为后端存储器了。

.. code-block:: php

    <?php

    //Cache data for one hour
    $frontCache = new Phalcon\Cache\Frontend\Data(array(
        "lifetime" => 3600
    ));

    // Create the component that will cache "Data" to a "Memcached" backend
    // Memcached connection settings
    $cache = new Phalcon\Cache\Backend\Memcached($frontCache, array(
        "host" => "localhost",
        "port" => "11211"
    ));

    // Try to get cached records
    $cacheKey = 'robots_order_id.cache';
    $robots    = $cache->get($cacheKey);
    if ($robots === null) {

        // $robots is null because of cache expiration or data does not exist
        // Make the database call and populate the variable
        $robots = Robots::find(array("order" => "id"));

        // Store it in the cache
        $cache->save($cacheKey, $robots);
    }

    // Use $robots :)
    foreach ($robots as $robot) {
       echo $robot->name, "\n";
    }

Querying the cache
------------------
缓存唯一标识符元素为KEY，在后端文件中，KEY值即是实际文件名。从缓存中检索数据，我们只需要通过KEY来调用即可。如果该KEY不存在，get方法将返回null。

.. code-block:: php

    <?php

    // Retrieve products by key "myProducts"
    $products = $cache->get("myProducts");

如果你想知道缓存中都有哪些KEY，你可以调用queryKeys方法：

.. code-block:: php

    <?php

    // Query all keys used in the cache
    $keys = $cache->queryKeys();
    foreach ($keys as $key) {
        $data = $cache->get($key);
        echo "Key=", $key, " Data=", $data;
    }

    //Query keys in the cache that begins with "my-prefix"
    $keys = $cache->queryKeys("my-prefix");


删除缓存数据
----------------------------
很多时候，你需要强行删除无效的缓存条目(由于数据更新的原因)，唯一的要求就是，你得知道该缓存的KEY。

.. code-block:: php

    <?php

    // Delete an item with a specific key
    $cache->delete("someKey");

    // Delete all items from the cache
    $keys = $cache->queryKeys();
    foreach ($keys as $key) {
    	$cache->delete($key);
    }


检测缓存是否存在
------------------------
通过给定的KEY值，可以检测缓存是否存在。

.. code-block:: php

    <?php

    if ($cache->exists("someKey")) {
        echo $cache->get("someKey");
    }
    else {
        echo "Cache does not exists!";
    }


前端适配器
-----------------
The available frontend adapters that are used as interfaces or input sources to the cache are:

+---------+--------------------------------------------------------------------------------------------------------------------------------+--------------------------------------------------------------------------------+
| Adapter | Description                                                                                                                    | Example                                                                        |
+=========+================================================================================================================================+================================================================================+
| Output  | Read input data from standard PHP output                                                                                       | :doc:`Phalcon\\Cache\\Frontend\\Output <../api/Phalcon_Cache_Frontend_Output>` |
+---------+--------------------------------------------------------------------------------------------------------------------------------+--------------------------------------------------------------------------------+
| Data    | It's used to cache any kind of PHP data (big arrays, objects, text, etc). The data is serialized before stored in the backend. | :doc:`Phalcon\\Cache\\Frontend\\Data <../api/Phalcon_Cache_Frontend_Data>`     |
+---------+--------------------------------------------------------------------------------------------------------------------------------+--------------------------------------------------------------------------------+
| Base64  | It's used to cache binary data. The data is serialized using base64_encode before be stored in the backend.                    | :doc:`Phalcon\\Cache\\Frontend\\Base64 <../api/Phalcon_Cache_Frontend_Base64>` |
+---------+--------------------------------------------------------------------------------------------------------------------------------+--------------------------------------------------------------------------------+
| None    | It's used to cache any kind of PHP data without serializing them.                                                              | :doc:`Phalcon\\Cache\\Frontend\\Data <../api/Phalcon_Cache_Frontend_None>`     |
+---------+--------------------------------------------------------------------------------------------------------------------------------+--------------------------------------------------------------------------------+

实现自定义的前端适配器
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
The :doc:`Phalcon\\Cache\\FrontendInterface <../api/Phalcon_Cache_FrontendInterface>` interface must be implemented in order to create your own frontend adapters or extend the existing ones.

后端适配器
----------------
可用的后端存储器列表：

+-----------+------------------------------------------------+------------+---------------------+-----------------------------------------------------------------------------------+
| Adapter   | Description                                    | Info       | Required Extensions | Example                                                                           |
+===========+================================================+============+=====================+===================================================================================+
| File      | Stores data to local plain files               |            |                     | :doc:`Phalcon\\Cache\\Backend\\File <../api/Phalcon_Cache_Backend_File>`          |
+-----------+------------------------------------------------+------------+---------------------+-----------------------------------------------------------------------------------+
| Memcached | Stores data to a memcached server              | Memcached_ | memcache_           | :doc:`Phalcon\\Cache\\Backend\\Memcache <../api/Phalcon_Cache_Backend_Memcache>`  |
+-----------+------------------------------------------------+------------+---------------------+-----------------------------------------------------------------------------------+
| APC       | Stores data to the Alternative PHP Cache (APC) | APC_       | `APC extension`_    | :doc:`Phalcon\\Cache\\Backend\\Apc <../api/Phalcon_Cache_Backend_Apc>`            |
+-----------+------------------------------------------------+------------+---------------------+-----------------------------------------------------------------------------------+
| Mongo     | Stores data to Mongo Database                  | MongoDb_   | `Mongo`_            | :doc:`Phalcon\\Cache\\Backend\\Mongo <../api/Phalcon_Cache_Backend_Mongo>`        |
+-----------+------------------------------------------------+------------+---------------------+-----------------------------------------------------------------------------------+

实现自定义后端适配器
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
The :doc:`Phalcon\\Cache\\BackendInterface <../api/Phalcon_Cache_BackendInterface>` interface must be implemented in order to create your own backend adapters or extend the existing ones.

文件缓存选项
^^^^^^^^^^^^^^^^^^^^
This backend will store cached content into files in the local server. The available options for this backend are:

+----------+-----------------------------------------------------------+
| Option   | Description                                               |
+==========+===========================================================+
| cacheDir | A writable directory on which cached files will be placed |
+----------+-----------------------------------------------------------+

Memcached缓存选项
^^^^^^^^^^^^^^^^^^^^^^^^^
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

APC缓存选项
^^^^^^^^^^^^^^^^^^^
This backend will store cached content on Alternative PHP Cache (APC_). This cache backend does not require any additional configuration options.

Mongo缓存选项
^^^^^^^^^^^^^^^^^^^^^^^^^
This backend will store cached content on a MongoDB server. The available options for this backend are:

+------------+---------------------------------------------+
| Option     | Description                                 |
+============+=============================================+
| server     | A MongoDB connection string                 |
+------------+---------------------------------------------+
| db         | Mongo database name                         |
+------------+---------------------------------------------+
| collection | Mongo collection in the database            |
+------------+---------------------------------------------+


.. _Memcached: http://php.net/manual/en/book.apc.php
.. _memcache: http://pecl.php.net/package/memcache
.. _APC: http://php.net/manual/en/book.apc.php
.. _APC extension: http://pecl.php.net/package/APC
.. _MongoDb: http://mongodb.org/
.. _Mongo: http://pecl.php.net/package/mongo
