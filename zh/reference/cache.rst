使用缓存提高性能（Improving Performance with Cache）
================================
Phalcon提供的 :doc:`Phalcon\\Cache <cache>` 类可以更快地接入获取使用频繁或者已经被处理的数据。
 :doc:`Phalcon\\Cache <cache>` 是用C来编写的，因此有着更高的性能并且能够减少从后端获取昂价资源所带来的负载。
这个类使用了由前端和后端组件组成的内部结构。前端组件如输入源或者接口，后端组件则为这个类提供了存储的选项。

什么情况下使用缓存？（When to implement cache?）
------------------------
尽管这个组件运行非常快速，但如果不加考虑就使用它会适得其反，特别在不需要或者不适宜使用缓存时。
我们建议你在使用缓存前核对一下场景：

* 你正在进行复杂的运算，并且每次都返回相同的结果（或者变动很少）
* 你正在使用大量的插件生成大部分时间几乎都是相同的页面输出
* 你正在频繁地接入数据库并且这些数据变动甚少

.. highlights::

    *温馨提示* 即使使用了这些缓存，你仍然应该定期检测缓存的命中率。
    通过后台提供的相关工具，这一点很容易做得到，特别是使用Memcache或者APC时。

缓存行为（Caching Behavior）
----------------
缓存流程可以分为两部分：

* **前端**: 此部分负责检测是否key已失效并且在保存数据和抓取数据后提供额外的转换操作。
* **后端**: 此部分负责通讯，并根据前端进行数据的读/写。

缓存输出片段（Caching Output Fragments）
------------------------
输出片段是指一小块缓存和返回都一样的HTML或者文本内容。输出的内容应该是能自动
被 ob_* 函数捕获或者直接是PHP输出，这样才能缓存起来。以下实例演示了这样的使用。
它接收PHP生成的页面输出并保存在一个文件里面。缓存文件的内容每隔172800秒（2天）刷新一次。

使用这个缓存机制，无论何时调用这块代码，我们都可以通过避免重复执行辅助插件 Phalcon\\Tag::linkTo 从而获得更高的性能。

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

*温馨提示* 在上面的实例中，我们的代码维持不变，即输出给用户的内容和之前展示的内容是一样的。我们的缓存组件
以透明的方式捕获了页面输出并保存在缓存文件（当缓存生成时）或者在早期的一次调用时将它发送回用户预编译，故而可以避免高昂的操作。

缓存任意数据（Caching Arbitrary Data）
----------------------
仅仅是缓存数据，对于你的应用来说也是同等重要的。缓存通过重用常用的（非更新的）数据可以减少数据库的加载，
从而加速你的应用。

文件后端存储器例子（File Backend Example）
^^^^^^^^^^^^^^^^^^^^
其中一个缓存适配器是文件'File'。文件适配器的配置中只需要一个key：指明缓存文件存放的目录位置。
这个配置通过cacheDir选项控制，必须，且要以反斜杠结尾。

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

Memcached 后端存储器例子（Memcached Backend Example）
^^^^^^^^^^^^^^^^^^^^^^^^^
The above example changes slightly (especially in terms of configuration) when we are using a Memcached backend.

.. code-block:: php

    <?php

    //Cache data for one hour
    $frontCache = new Phalcon\Cache\Frontend\Data(array(
        "lifetime" => 3600
    ));

    // Create the component that will cache "Data" to a "Memcached" backend
    // Memcached connection settings
    $cache = new Phalcon\Cache\Backend\Libmemcached($frontCache, array(
	"servers" => array(
		array(
			"host" => "127.0.0.1",
			"port" => "11211",
			"weight" => "1"
		)
	)
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

查询缓存（Querying the cache）
------------------
The elements added to the cache are uniquely identified by a key. In the case of the File backend, the key is the
actual filename. To retrieve data from the cache, we just have to call it using the unique key. If the key does
not exist, the get method will return null.

.. code-block:: php

    <?php

    // Retrieve products by key "myProducts"
    $products = $cache->get("myProducts");

If you want to know which keys are stored in the cache you could call the queryKeys method:

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


删除缓存数据（Deleting data from the cache）
----------------------------
There are times where you will need to forcibly invalidate a cache entry (due to an update in the cached data).
The only requirement is to know the key that the data have been stored with.

.. code-block:: php

    <?php

    // Delete an item with a specific key
    $cache->delete("someKey");

    // Delete all items from the cache
    $keys = $cache->queryKeys();
    foreach ($keys as $key) {
        $cache->delete($key);
    }

检查缓存是否存在（Checking cache existence）
------------------------
It is possible to check if a cache already exists with a given key:

.. code-block:: php

    <?php

    if ($cache->exists("someKey")) {
        echo $cache->get("someKey");
    } else {
        echo "Cache does not exists!";
    }


有效期（Lifetime）
--------
A "lifetime" is a time in seconds that a cache could live without expire. By default, all the created caches use the lifetime set in the frontend creation.
You can set a specific lifetime in the creation or retrieving of the data from the cache:

Setting the lifetime when retrieving:

.. code-block:: php

    <?php

    $cacheKey = 'my.cache';

    //Setting the cache when getting a result
    $robots = $cache->get($cacheKey, 3600);
    if ($robots === null) {

        $robots = "some robots";

        // Store it in the cache
        $cache->save($cacheKey, $robots);
    }

Setting the lifetime when saving:

.. code-block:: php

    <?php

    $cacheKey = 'my.cache';

    $robots = $cache->get($cacheKey);
    if ($robots === null) {

        $robots = "some robots";

        //Setting the cache when saving data
        $cache->save($cacheKey, $robots, 3600);
    }

多级缓存（Multi-Level Cache）
-----------------
This feature ​of the cache component, ​allows ​the developer to implement a multi-level cache​. This new feature is very ​useful
because you can save the same data in several cache​ locations​ with different lifetimes, reading ​first from the one with
the faster adapter and ending with the slowest one until the data expire​s​:

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

前端适配器（Frontend Adapters）
-----------------
The available frontend adapters that are used as interfaces or input sources to the cache are:

+----------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------------------------------------+
| Adapter  | Description                                                                                                                                                          | Example                                                                            |
+==========+======================================================================================================================================================================+====================================================================================+
| Output   | Read input data from standard PHP output                                                                                                                             | :doc:`Phalcon\\Cache\\Frontend\\Output <../api/Phalcon_Cache_Frontend_Output>`     |
+----------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------------------------------------+
| Data     | It's used to cache any kind of PHP data (big arrays, objects, text, etc). Data is serialized before stored in the backend.                                           | :doc:`Phalcon\\Cache\\Frontend\\Data <../api/Phalcon_Cache_Frontend_Data>`         |
+----------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------------------------------------+
| Base64   | It's used to cache binary data. The data is serialized using base64_encode before be stored in the backend.                                                          | :doc:`Phalcon\\Cache\\Frontend\\Base64 <../api/Phalcon_Cache_Frontend_Base64>`     |
+----------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------------------------------------+
| Json     | Data is encoded in JSON before be stored in the backend. Decoded after be retrieved. This frontend is useful to share data with other languages or frameworks.       | :doc:`Phalcon\\Cache\\Frontend\\Json <../api/Phalcon_Cache_Frontend_Json>`         |
+----------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------------------------------------+
| IgBinary | It's used to cache any kind of PHP data (big arrays, objects, text, etc). Data is serialized using IgBinary before be stored in the backend.                         | :doc:`Phalcon\\Cache\\Frontend\\Igbinary <../api/Phalcon_Cache_Frontend_Igbinary>` |
+----------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------------------------------------+
| None     | It's used to cache any kind of PHP data without serializing them.                                                                                                    | :doc:`Phalcon\\Cache\\Frontend\\None <../api/Phalcon_Cache_Frontend_None>`         |
+----------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------+------------------------------------------------------------------------------------+

自定义前端适配器（Implementing your own Frontend adapters）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
The :doc:`Phalcon\\Cache\\FrontendInterface <../api/Phalcon_Cache_FrontendInterface>` interface must be implemented in order to create your own frontend adapters or extend the existing ones.

后端适配器（Backend Adapters）
----------------
The backend adapters available to store cache data are:

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
| XCache    | Stores data in XCache                          | XCache_    | `xcache extension`_ | :doc:`Phalcon\\Cache\\Backend\\Xcache <../api/Phalcon_Cache_Backend_Xcache>`      |
+-----------+------------------------------------------------+------------+---------------------+-----------------------------------------------------------------------------------+

自定义后端适配器（Implementing your own Backend adapters）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
The :doc:`Phalcon\\Cache\\BackendInterface <../api/Phalcon_Cache_BackendInterface>` interface must be implemented in order to create your own backend adapters or extend the existing ones.

文件后端存储器选项（File Backend Options）
^^^^^^^^^^^^^^^^^^^^
This backend will store cached content into files in the local server. The available options for this backend are:

+----------+-------------------------------------------------------------+
| Option   | Description                                                 |
+==========+=============================================================+
| prefix   | A prefix that is automatically prepended to the cache keys  |
+----------+-------------------------------------------------------------+
| cacheDir | A writable directory on which cached files will be placed   |
+----------+-------------------------------------------------------------+

Memcached 后端存储器选项（Memcached Backend Options）
^^^^^^^^^^^^^^^^^^^^^^^^^
This backend will store cached content on a memcached server. The available options for this backend are:

+------------+-------------------------------------------------------------+
| Option     | Description                                                 |
+============+=============================================================+
| prefix     | A prefix that is automatically prepended to the cache keys  |
+------------+-------------------------------------------------------------+
| host       | memcached host                                              |
+------------+-------------------------------------------------------------+
| port       | memcached port                                              |
+------------+-------------------------------------------------------------+
| persistent | create a persistent connection to memcached?                 |
+------------+-------------------------------------------------------------+

APC 后端存储器选项（APC Backend Options）
^^^^^^^^^^^^^^^^^^^
This backend will store cached content on Alternative PHP Cache (APC_). The available options for this backend are:

+------------+-------------------------------------------------------------+
| Option     | Description                                                 |
+============+=============================================================+
| prefix     | A prefix that is automatically prepended to the cache keys  |
+------------+-------------------------------------------------------------+

Mongo 后端存储器选项（Mongo Backend Options）
^^^^^^^^^^^^^^^^^^^^^
This backend will store cached content on a MongoDB server. The available options for this backend are:

+------------+-------------------------------------------------------------+
| Option     | Description                                                 |
+============+=============================================================+
| prefix     | A prefix that is automatically prepended to the cache keys  |
+------------+-------------------------------------------------------------+
| server     | A MongoDB connection string                                 |
+------------+-------------------------------------------------------------+
| db         | Mongo database name                                         |
+------------+-------------------------------------------------------------+
| collection | Mongo collection in the database                            |
+------------+-------------------------------------------------------------+

XCache 后端存储器选项（XCache Backend Options）
^^^^^^^^^^^^^^^^^^^^^^
This backend will store cached content on XCache (XCache_). The available options for this backend are:

+------------+-------------------------------------------------------------+
| Option     | Description                                                 |
+============+=============================================================+
| prefix     | A prefix that is automatically prepended to the cache keys  |
+------------+-------------------------------------------------------------+

There are more adapters available for this components in the `Phalcon Incubator <https://github.com/phalcon/incubator>`_

.. _Memcached: http://www.php.net/memcache
.. _memcache: http://pecl.php.net/package/memcache
.. _APC: http://php.net/apc
.. _APC extension: http://pecl.php.net/package/APC
.. _MongoDb: http://mongodb.org/
.. _Mongo: http://pecl.php.net/package/mongo
.. _XCache: http://xcache.lighttpd.net/
.. _XCache extension: http://pecl.php.net/package/xcache
