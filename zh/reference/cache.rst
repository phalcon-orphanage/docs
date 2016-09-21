使用缓存提高性能（Improving Performance with Cache）
====================================================

Phalcon提供的 :doc:`Phalcon\\Cache <cache>` 类可以更快地接入获取使用频繁或者已经被处理的数据。
:doc:`Phalcon\\Cache <cache>` 是用C来编写的，因此有着更高的性能并且能够减少从后端获取昂价资源所带来的负载。
这个类使用了由前端和后端组件组成的内部结构。前端组件如输入源或者接口，后端组件则为这个类提供了存储的选项。

什么情况下使用缓存？（When to implement cache?）
------------------------------------------------
尽管这个组件运行非常快速，但如果不加考虑就使用它会适得其反，特别在不需要或者不适宜使用缓存时。
我们建议你在使用缓存前核对一下场景：

* 你正在进行复杂的运算，并且每次都返回相同的结果（或者变动很少）
* 你正在使用大量的插件生成大部分时间几乎都是相同的页面输出
* 你正在频繁地接入数据库并且这些数据变动甚少

.. highlights::

    *温馨提示* 即使使用了这些缓存，你仍然应该定期检测缓存的命中率。
    通过后台提供的相关工具，这一点很容易做得到，特别是使用Memcache或者APC时。

缓存行为（Caching Behavior）
----------------------------
缓存流程可以分为两部分：

* **前端**: 此部分负责检测是否key已失效并且在保存数据和抓取数据后提供额外的转换操作。
* **后端**: 此部分负责通讯，并根据前端进行数据的读/写。

缓存输出片段（Caching Output Fragments）
----------------------------------------
输出片段是指一小块缓存和返回都一样的HTML或者文本内容。输出的内容应该是能自动
被 ob_* 函数捕获或者直接是PHP输出，这样才能缓存起来。以下实例演示了这样的使用。
它接收PHP生成的页面输出并保存在一个文件里面。缓存文件的内容每隔172800秒（2天）刷新一次。

使用这个缓存机制，无论何时调用这块代码，我们都可以通过避免重复执行辅助插件 :code:`Phalcon\Tag::linkTo()` 从而获得更高的性能。

.. code-block:: php

    <?php

    use Phalcon\Tag;
    use Phalcon\Cache\Backend\File as BackFile;
    use Phalcon\Cache\Frontend\Output as FrontOutput;

    // Create an Output frontend. Cache the files for 2 days
    $frontCache = new FrontOutput(
        [
            "lifetime" => 172800,
        ]
    );

    // Create the component that will cache from the "Output" to a "File" backend
    // Set the cache file directory - it's important to keep the "/" at the end of
    // the value for the folder
    $cache = new BackFile(
        $frontCache,
        [
            "cacheDir" => "../app/cache/",
        ]
    );

    // Get/Set the cache file to ../app/cache/my-cache.html
    $content = $cache->start("my-cache.html");

    // If $content is null then the content will be generated for the cache
    if ($content === null) {
        // Print date and time
        echo date("r");

        // Generate a link to the sign-up action
        echo Tag::linkTo(
            [
                "user/signup",
                "Sign Up",
                "class" => "signup-button",
            ]
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
--------------------------------------
仅仅是缓存数据，对于你的应用来说也是同等重要的。缓存通过重用常用的（非更新的）数据可以减少数据库的加载，
从而加速你的应用。

文件后端存储器例子（File Backend Example）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
其中一个缓存适配器是文件'File'。文件适配器的配置中只需要一个key：指明缓存文件存放的目录位置。
这个配置通过cacheDir选项控制，必须，且要以反斜杠结尾。

.. code-block:: php

    <?php

    use Phalcon\Cache\Backend\File as BackFile;
    use Phalcon\Cache\Frontend\Data as FrontData;

    // Cache the files for 2 days using a Data frontend
    $frontCache = new FrontData(
        [
            "lifetime" => 172800,
        ]
    );

    // Create the component that will cache "Data" to a "File" backend
    // Set the cache file directory - important to keep the "/" at the end of
    // the value for the folder
    $cache = new BackFile(
        $frontCache,
        [
            "cacheDir" => "../app/cache/",
        ]
    );

    $cacheKey = "robots_order_id.cache";

    // Try to get cached records
    $robots = $cache->get($cacheKey);

    if ($robots === null) {
        // $robots is null because of cache expiration or data does not exist
        // Make the database call and populate the variable
        $robots = Robots::find(
            [
                "order" => "id",
            ]
        );

        // Store it in the cache
        $cache->save($cacheKey, $robots);
    }

    // Use $robots :)
    foreach ($robots as $robot) {
       echo $robot->name, "\n";
    }

Memcached 后端存储器例子（Memcached Backend Example）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
当我们改用Memcached作为后端存储器时，上面的实例改动很轻微（特别就配置而言）。

.. code-block:: php

    <?php

    use Phalcon\Cache\Frontend\Data as FrontData;
    use Phalcon\Cache\Backend\Libmemcached as BackMemCached;

    // Cache data for one hour
    $frontCache = new FrontData(
        [
            "lifetime" => 3600,
        ]
    );

    // Create the component that will cache "Data" to a "Memcached" backend
    // Memcached connection settings
    $cache = new BackMemCached(
        $frontCache,
        [
            "servers" => [
                [
                    "host"   => "127.0.0.1",
                    "port"   => "11211",
                    "weight" => "1",
                ]
            ]
        ]
    );

    $cacheKey = "robots_order_id.cache";

    // Try to get cached records
    $robots = $cache->get($cacheKey);

    if ($robots === null) {
        // $robots is null because of cache expiration or data does not exist
        // Make the database call and populate the variable
        $robots = Robots::find(
            [
                "order" => "id",
            ]
        );

        // Store it in the cache
        $cache->save($cacheKey, $robots);
    }

    // Use $robots :)
    foreach ($robots as $robot) {
       echo $robot->name, "\n";
    }

查询缓存（Querying the cache）
------------------------------
添加到缓存的元素根据唯一的key进行识别区分。这使用文件缓存作为后端时，key就是实际的文件名。
为了从缓存中获得数据，我们仅仅需要通过唯一的key调用即可。如果key不存在，get方法将会返回null。

.. code-block:: php

    <?php

    // Retrieve products by key "myProducts"
    $products = $cache->get("myProducts");

如果你想知道在缓存中存放了哪些key，你可以调用queryKeys方法：

.. code-block:: php

    <?php

    // Query all keys used in the cache
    $keys = $cache->queryKeys();

    foreach ($keys as $key) {
        $data = $cache->get($key);

        echo "Key=", $key, " Data=", $data;
    }

    // Query keys in the cache that begins with "my-prefix"
    $keys = $cache->queryKeys("my-prefix");

删除缓存数据（Deleting data from the cache）
--------------------------------------------
有些时机你需要强制废除一个缓存的实体（如对被缓存的数据进行了更新）。
而仅仅需要做的只是知道对应缓存的数据存放于哪个key即可。

.. code-block:: php

    <?php

    // Delete an item with a specific key
    $cache->delete("someKey");

    $keys = $cache->queryKeys();

    // Delete all items from the cache
    foreach ($keys as $key) {
        $cache->delete($key);
    }

检查缓存是否存在（Checking cache existence）
--------------------------------------------
也有可能需要根据一个给定的key来判断缓存是否存在：

.. code-block:: php

    <?php

    if ($cache->exists("someKey")) {
        echo $cache->get("someKey");
    } else {
        echo "Cache does not exists!";
    }

有效期（Lifetime）
------------------
“有效期”是指缓存可以多久时间（在以秒为单位）内有效。默认情况下，全部被创建的缓存都使用前端构建中设定的有效期。
你可以在创建时指定一个有效期或者在从缓存中获取数据时：

Setting the lifetime when retrieving:

.. code-block:: php

    <?php

    $cacheKey = "my.cache";

    // Setting the cache when getting a result
    $robots = $cache->get($cacheKey, 3600);

    if ($robots === null) {
        $robots = "some robots";

        // Store it in the cache
        $cache->save($cacheKey, $robots);
    }

在保存时设置有效期：

.. code-block:: php

    <?php

    $cacheKey = "my.cache";

    $robots = $cache->get($cacheKey);

    if ($robots === null) {
        $robots = "some robots";

        // Setting the cache when saving data
        $cache->save($cacheKey, $robots, 3600);
    }

多级缓存（Multi-Level Cache）
-----------------------------
缓存组件的特点，就是允许开发人员使用多级缓存。这个新特性非常有用，
因为你可以在多个缓存媒介结合不同的有效期中保存相同的数据，并在有效期内从首个最快的缓存适配器开始读取，直至到最慢的适配器。

.. code-block:: php

    <?php

    use Phalcon\Cache\Multiple;
    use Phalcon\Cache\Backend\Apc as ApcCache;
    use Phalcon\Cache\Backend\File as FileCache;
    use Phalcon\Cache\Frontend\Data as DataFrontend;
    use Phalcon\Cache\Backend\Memcache as MemcacheCache;

    $ultraFastFrontend = new DataFrontend(
        [
            "lifetime" => 3600,
        ]
    );

    $fastFrontend = new DataFrontend(
        [
            "lifetime" => 86400,
        ]
    );

    $slowFrontend = new DataFrontend(
        [
            "lifetime" => 604800,
        ]
    );

    // Backends are registered from the fastest to the slower
    $cache = new Multiple(
        [
            new ApcCache(
                $ultraFastFrontend,
                [
                    "prefix" => "cache",
                ]
            ),
            new MemcacheCache(
                $fastFrontend,
                [
                    "prefix" => "cache",
                    "host"   => "localhost",
                    "port"   => "11211",
                ]
            ),
            new FileCache(
                $slowFrontend,
                [
                    "prefix"   => "cache",
                    "cacheDir" => "../app/cache/",
                ]
            ),
        ]
    );

    // Save, saves in every backend
    $cache->save("my-key", $data);

前端适配器（Frontend Adapters）
-------------------------------
作为缓存的接口或者输入源的前端适配器有：

+------------------------------------------------------------------------------------+----------------------------------------------------------------------------------------------------+
| 适配器                                                                             | 描述                                                                                               |
+====================================================================================+====================================================================================================+
| :doc:`Phalcon\\Cache\\Frontend\\Output <../api/Phalcon_Cache_Frontend_Output>`     | 从标准PHP输出读取输入数据                                                                          |
+------------------------------------------------------------------------------------+----------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Cache\\Frontend\\Data <../api/Phalcon_Cache_Frontend_Data>`         | 可用于缓存任何类型的PHP数据（大数组，对象，文本等）。在存入后端前数据将会被序列化。                |
+------------------------------------------------------------------------------------+----------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Cache\\Frontend\\Base64 <../api/Phalcon_Cache_Frontend_Base64>`     | 可用于缓存二进制数据。在存入后端前数据会以base64_encode编码进行序列化。                            |
+------------------------------------------------------------------------------------+----------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Cache\\Frontend\\Json <../api/Phalcon_Cache_Frontend_Json>`         | 在存入后端前数据使用JSON编码。从缓存获取后进行JSON解码。此前端适配器可用于跨语言和跨框架共享数据。 |
+------------------------------------------------------------------------------------+----------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Cache\\Frontend\\Igbinary <../api/Phalcon_Cache_Frontend_Igbinary>` | 用于缓存任何类型的PHP数据（大数组，对象，文本等）。在存入后端前数据会使用IgBinary进行序列化。      |
+------------------------------------------------------------------------------------+----------------------------------------------------------------------------------------------------+
| :doc:`Phalcon\\Cache\\Frontend\\None <../api/Phalcon_Cache_Frontend_None>`         | 用于缓存任何类型的PHP数据而不作任何序列化操作。                                                    |
+------------------------------------------------------------------------------------+----------------------------------------------------------------------------------------------------+

自定义前端适配器（Implementing your own Frontend adapters）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
为了创建你自己的前端适配器或者扩展已有的适配器，你必须
实现 :doc:`Phalcon\\Cache\\FrontendInterface <../api/Phalcon_Cache_FrontendInterface>` 接口。

后端适配器（Backend Adapters）
------------------------------
用于存放缓存数据的后端适配器有：

+----------------------------------------------------------------------------------+------------------------------------------------+------------+---------------------+
| 适配器                                                                           | 描述                                           | 信息       | 需要的扩展          |
+==================================================================================+================================================+============+=====================+
| :doc:`Phalcon\\Cache\\Backend\\File <../api/Phalcon_Cache_Backend_File>`         | 在本地绝对路径的文件上存放数据                 |            |                     |
+----------------------------------------------------------------------------------+------------------------------------------------+------------+---------------------+
| :doc:`Phalcon\\Cache\\Backend\\Memcache <../api/Phalcon_Cache_Backend_Memcache>` | 在memcached服务器存放数据                      | Memcached_ | memcache_           |
+----------------------------------------------------------------------------------+------------------------------------------------+------------+---------------------+
| :doc:`Phalcon\\Cache\\Backend\\Apc <../api/Phalcon_Cache_Backend_Apc>`           | 在opcode缓存           （APC）中存放数据       | APC_       | `APC extension`_    |
+----------------------------------------------------------------------------------+------------------------------------------------+------------+---------------------+
| :doc:`Phalcon\\Cache\\Backend\\Mongo <../api/Phalcon_Cache_Backend_Mongo>`       | 在Mongo数据库中存放数据                        | MongoDb_   | `Mongo`_            |
+----------------------------------------------------------------------------------+------------------------------------------------+------------+---------------------+
| :doc:`Phalcon\\Cache\\Backend\\Xcache <../api/Phalcon_Cache_Backend_Xcache>`     | 在XCache中存放数据                             | XCache_    | `xcache extension`_ |
+----------------------------------------------------------------------------------+------------------------------------------------+------------+---------------------+
| :doc:`Phalcon\\Cache\\Backend\\Redis <../api/Phalcon_Cache_Backend_Redis>`       | Stores data in Redis                           | Redis_     | `redis extension`_  |
+----------------------------------------------------------------------------------+------------------------------------------------+------------+---------------------+

自定义后端适配器（Implementing your own Backend adapters）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
为了创建你自己的后端适配器或者扩展已有的后端适配器，你必须
实现 :doc:`Phalcon\\Cache\\BackendInterface <../api/Phalcon_Cache_BackendInterface>` 接口。

文件后端存储器选项（File Backend Options）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
此后端存储器把缓存内容存放到本地服务器的文件。对应的选项有：

+----------+-------------------------------------------------------------+
| 选项     | 描述                                                        |
+==========+=============================================================+
| prefix   | 自动追加到缓存key前面的前缀                                 |
+----------+-------------------------------------------------------------+
| cacheDir | 放置缓存文件且可写入的目录                                  |
+----------+-------------------------------------------------------------+

Memcached 后端存储器选项（Memcached Backend Options）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
此后端存储器将缓存的内容存放在memcached服务器。对应的选项有：

+------------+-------------------------------------------------------------+
| 选项       | 描述                                                        |
+============+=============================================================+
| prefix     | 自动追加到缓存key前面的前缀                                 |
+------------+-------------------------------------------------------------+
| host       | memcached 域名                                              |
+------------+-------------------------------------------------------------+
| port       | memcached 端口                                              |
+------------+-------------------------------------------------------------+
| persistent | 创建一个长连接的memcached连接？                             |
+------------+-------------------------------------------------------------+

APC 后端存储器选项（APC Backend Options）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
此后端存储器将缓存内容存放到opcode缓存（APC）。对应的选项有：

+------------+-------------------------------------------------------------+
| 选项       | 描述                                                        |
+============+=============================================================+
| prefix     | 自动追加到缓存key前面的前缀                                 |
+------------+-------------------------------------------------------------+

Mongo 后端存储器选项（Mongo Backend Options）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
此后端存储器将缓存内容存放到MongoDB服务器。对应的选项有：

+------------+-------------------------------------------------------------+
| 选项       | 描述                                                        |
+============+=============================================================+
| prefix     | 自动追加到缓存key前面的前缀                                 |
+------------+-------------------------------------------------------------+
| server     | MongoDB的连接串                                             |
+------------+-------------------------------------------------------------+
| db         | Mongo数据库名                                               |
+------------+-------------------------------------------------------------+
| collection | Mongo数据库连接                                             |
+------------+-------------------------------------------------------------+

XCache 后端存储器选项（XCache Backend Options）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
此后端存储器将缓存内容存放到XCache (XCache_)。对应的选项有：

+------------+-------------------------------------------------------------+
| 选项       | 描述                                                        |
+============+=============================================================+
| prefix     | 自动追加到缓存key前面的前缀                                 |
+------------+-------------------------------------------------------------+

Redis Backend Options
^^^^^^^^^^^^^^^^^^^^^
This backend will store cached content on a Redis server (Redis_). The available options for this backend are:

+------------+---------------------------------------------------------------+
| Option     | Description                                                   |
+============+===============================================================+
| prefix     | A prefix that is automatically prepended to the cache keys    |
+------------+---------------------------------------------------------------+
| host       | Redis host                                                    |
+------------+---------------------------------------------------------------+
| port       | Redis port                                                    |
+------------+---------------------------------------------------------------+
| auth       | Password to authenticate to a password-protected Redis server |
+------------+---------------------------------------------------------------+
| persistent | Create a persistent connection to Redis                       |
+------------+---------------------------------------------------------------+
| index      | The index of the Redis database to use                        |
+------------+---------------------------------------------------------------+

在 `Phalcon Incubator <https://github.com/phalcon/incubator>`_ 上还有更多针对这个组件可用的适配器

.. _Memcached: http://www.php.net/memcache
.. _memcache: http://pecl.php.net/package/memcache
.. _APC: http://php.net/apc
.. _APC extension: http://pecl.php.net/package/APC
.. _MongoDb: http://mongodb.org/
.. _Mongo: http://pecl.php.net/package/mongo
.. _XCache: http://xcache.lighttpd.net/
.. _XCache extension: http://pecl.php.net/package/xcache
.. _Redis: http://redis.io/
.. _redis extension: http://pecl.php.net/package/redis
