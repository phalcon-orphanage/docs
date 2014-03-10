%{cache_06ac1885f3b22cac3acb8fef0ae8ee71}%

================================
%{cache_d8421a5a215219954badc01c72c33db8}%


%{cache_2b70fe8d1826a4e23acf89d33ef5f6b5}%

------------------------
%{cache_adf301b4ffdcf215970175563ee6a903}%


* {%cache_7c6d2499e794e7178ddf37db0974ca57%}
* {%cache_8e660014ba66b283ac0a77af0ebab448%}
* {%cache_216cd8fbfa6aaad8fe14fcb91d04869a%}

.. highlights::

    *NOTE* Even after implementing the cache, you should check the hit ratio of your cache over a period of time. This can easily
    be done, especially in the case of Memcache or Apc, with the relevant tools that backends provide.


%{cache_7c9d91a45b7f7bb2fafb4299a61e0840}%

----------------
%{cache_1472c7d751cd680997c7e65cd9e8deeb}%


* {%cache_67fd59e4c5562c5563990bbb2fc4f50f%}
* {%cache_db29a57760b7259630566c13d1912cd9%}

%{cache_a30294c78d838e8593e4a0bc1059c46a}%

------------------------
%{cache_8ca64dcebd79c1a9cd31749101484866}%


%{cache_04959022cca6bdfd14abdfcd55ea50b3}%

.. code-block:: php

    <?php

    //{%cache_41a11b1a04dfedec02baf80cf4eaf762%}
    $frontCache = new Phalcon\Cache\Frontend\Output(array(
        "lifetime" => 172800
    ));

    // {%cache_11e456117d271495bc967de753b45149%}
    // {%cache_955b78a3edefc5b19e177287616694ba%}
    // {%cache_5fcfde64f24f43d708d7cf2548f2076c%}
    $cache = new Phalcon\Cache\Backend\File($frontCache, array(
        "cacheDir" => "../app/cache/"
    ));

    // {%cache_eff938041f42201190f587959a23dfd1%}
    $content = $cache->start("my-cache.html");

    // {%cache_89f2a437bdfa2001a281e5decbad302e%}
    if ($content === null) {

        //{%cache_a03ec28be539470ccf2ca917b1bd647a%}
        echo date("r");

        //{%cache_91e2ee7e7ef772b62b39f1f432ad8354%}
        echo Phalcon\Tag::linkTo(
            array(
                "user/signup",
                "Sign Up",
                "class" => "signup-button"
            )
        );

        // {%cache_d581137e0d9bdf3758eaaca91853dd0c%}
        $cache->save();

    } else {

        // {%cache_3c863c5a660c5145280a5be84766e095%}
        echo $content;
    }

*NOTE* In the example above, our code remains the same, echoing output to the user as it has been doing before. Our cache component
%{cache_84e4419f93b729fa91b8ff96a4a94f46}%

%{cache_6ae3524ecce11faef5aab7af70762fc7}%

----------------------
%{cache_402407b0e6ae3113ed1ec183e4b5200f}%


%{cache_99a52a4b8c30cc90f7ded0df6998ba16}%

^^^^^^^^^^^^^^^^^^^^
%{cache_6ba467224dd45213b045859a05029af8}%


.. code-block:: php

    <?php

    // {%cache_6a929840227fcdc8bb3d4b16b53e599e%}
    $frontCache = new Phalcon\Cache\Frontend\Data(array(
        "lifetime" => 172800
    ));

    // {%cache_989062527cdac2872e9cffda4653ecd8%}
    // {%cache_b6981c87706285da49e15242b7d785bf%}
    // {%cache_985becda271eb01dd0940ab4705aa629%}
    $cache = new Phalcon\Cache\Backend\File($frontCache, array(
        "cacheDir" => "../app/cache/"
    ));

    // {%cache_d99623f9040482f1edf8fed520e01ef6%}
    $cacheKey = 'robots_order_id.cache';
    $robots    = $cache->get($cacheKey);
    if ($robots === null) {

        // {%cache_71968ac3edfdbeb821bbbd7d492718de%}
        // {%cache_4aa8dcff400337e4dd2ef094fb66e362%}
        $robots = Robots::find(array("order" => "id"));

        // {%cache_f3762eaf6f2e3ac209ccfb08fd036c9c%}
        $cache->save($cacheKey, $robots);
    }

    // {%cache_062c759655f7a03e81a39817083b59bb%}
    foreach ($robots as $robot) {
       echo $robot->name, "\n";
    }

%{cache_c5935671738c0da3f5ff4aed032d31c0}%

^^^^^^^^^^^^^^^^^^^^^^^^^
%{cache_79aadee161b6a59afce96cf849258882}%


.. code-block:: php

    <?php

    //{%cache_59b2defd92fc3a622a6e444101392bbe%}
    $frontCache = new Phalcon\Cache\Frontend\Data(array(
        "lifetime" => 3600
    ));

    // {%cache_415c404a0afde56e80fc82290caab243%}
    // {%cache_27c9c860a0e993fc9cd8fe1f98c2dd13%}
    $cache = new Phalcon\Cache\Backend\Libmemcached($frontCache, array(
        "host" => "localhost",
        "port" => "11211"
    ));

    // {%cache_d99623f9040482f1edf8fed520e01ef6%}
    $cacheKey = 'robots_order_id.cache';
    $robots    = $cache->get($cacheKey);
    if ($robots === null) {

        // {%cache_71968ac3edfdbeb821bbbd7d492718de%}
        // {%cache_4aa8dcff400337e4dd2ef094fb66e362%}
        $robots = Robots::find(array("order" => "id"));

        // {%cache_f3762eaf6f2e3ac209ccfb08fd036c9c%}
        $cache->save($cacheKey, $robots);
    }

    // {%cache_062c759655f7a03e81a39817083b59bb%}
    foreach ($robots as $robot) {
       echo $robot->name, "\n";
    }

%{cache_d05c101ebb1909c9d72ef91e01cf89a2}%

------------------
%{cache_3ae0ffd78840acc40f2ebe7e2304c772}%


.. code-block:: php

    <?php

    // {%cache_1795edb9ba9a4d9f8d4d85bce0fdd063%}
    $products = $cache->get("myProducts");

%{cache_616ca431dc5beba8d732a59252636402}%

.. code-block:: php

    <?php

    // {%cache_9403821dad96cd6f938a8fc47a081716%}
    $keys = $cache->queryKeys();
    foreach ($keys as $key) {
        $data = $cache->get($key);
        echo "Key=", $key, " Data=", $data;
    }

    //{%cache_e5311d757533271a2fca9642ace44d5c%}
    $keys = $cache->queryKeys("my-prefix");


%{cache_ef270f6b7b53b2ff16cb9fced6aa0417}%

----------------------------
%{cache_0af2d797680bcdcbd10c4cc2b00dea02}%


.. code-block:: php

    <?php

    // {%cache_30924304cde46e46cc26b41abac3a809%}
    $cache->delete("someKey");

    // {%cache_93845048354030bb303a57ba33651759%}
    $keys = $cache->queryKeys();
    foreach ($keys as $key) {
        $cache->delete($key);
    }

%{cache_6638f014bd3ed173498a7d77910661cd}%

------------------------
%{cache_7ccf904fb74b4ad5fe39064a01b403c2}%


.. code-block:: php

    <?php

    if ($cache->exists("someKey")) {
        echo $cache->get("someKey");
    } else {
        echo "Cache does not exists!";
    }


%{cache_83b4b1fa9918be910381d8fd387c55fd}%

--------
%{cache_b3681defebf1d2af5ccac3b4119ceec6}%


%{cache_aecfdaefd5baa2b285505e485398b08d}%

.. code-block:: php

    <?php

    $cacheKey = 'my.cache';

    //{%cache_ecfd3939e33e951b1cdf184b2f8c335e%}
    $robots = $cache->get($cacheKey, 3600);
    if ($robots === null) {

        $robots = "some robots";

        // {%cache_f3762eaf6f2e3ac209ccfb08fd036c9c%}
        $cache->save($cacheKey, $robots);
    }

%{cache_7bbf5f4ae3ef33ddc2d7dabd5af22f7b}%

.. code-block:: php

    <?php

    $cacheKey = 'my.cache';

    $robots = $cache->get($cacheKey);
    if ($robots === null) {

        $robots = "some robots";

        //{%cache_372540a0fb2a18360b66eab2e85956fb%}
        $cache->save($cacheKey, $robots, 3600);
    }

%{cache_020ff5e13c915f51289bcc16a347f348}%

-----------------
%{cache_d263cfdbda65a2bf2de853b301110281}%


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

    //{%cache_00bc8a652749364a924e67bd2631f979%}
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

    //{%cache_8376c010cf364f6099bd9ec2242f95f0%}
    $cache->save('my-key', $data);

%{cache_1b1a3cb2e9456a2d81cd4d587ec4324e}%

-----------------
%{cache_e1796468b3088973c3307c2c1c50f7a6}%


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

%{cache_61a21d3b5fd23a15bcccc1482b40870e}%

^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{cache_e77ca7aed8c81e24579c19f86f18e02c}%


%{cache_902d7a8c16652aae3221595c8601c0af}%

----------------
%{cache_0c5acab923a04e8718efc8aa5f258c14}%


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

%{cache_297b2519b953eb1823cc82dba9b7b55b}%

^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
%{cache_ea6983dccc24a7af5bd8aa92f57d85a6}%


%{cache_31b59e1c932ab419df1003b4ddb7795d}%

^^^^^^^^^^^^^^^^^^^^
%{cache_cfd82201844dbf238f3f9211cdab3326}%


+----------+-------------------------------------------------------------+
| Option   | Description                                                 |
+==========+=============================================================+
| prefix   | A prefix that is automatically prepended to the cache keys  |
+----------+-------------------------------------------------------------+
| cacheDir | A writable directory on which cached files will be placed   |
+----------+-------------------------------------------------------------+

%{cache_76e4d69d0bdb5e97ab0b9a8ee5838fea}%

^^^^^^^^^^^^^^^^^^^^^^^^^
%{cache_ec4d4b24cc1f2864b0a354a815f087c0}%


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

%{cache_a710c13e5474dc1253d2547c745b985f}%

^^^^^^^^^^^^^^^^^^^
%{cache_d02994fdbc2fc39c08459a7520d37ef1}%


+------------+-------------------------------------------------------------+
| Option     | Description                                                 |
+============+=============================================================+
| prefix     | A prefix that is automatically prepended to the cache keys  |
+------------+-------------------------------------------------------------+

%{cache_97b207c9e38aa7f72bbf44a3a1045be9}%

^^^^^^^^^^^^^^^^^^^^^
%{cache_c613ead7f0b71f9d9aaf45d33ae1da20}%


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

%{cache_c9528b343d562f70d1a0951a59199cf9}%

^^^^^^^^^^^^^^^^^^^^^^
%{cache_419ec6612f1e5e70cf3077edcdc773aa}%


+------------+-------------------------------------------------------------+
| Option     | Description                                                 |
+============+=============================================================+
| prefix     | A prefix that is automatically prepended to the cache keys  |
+------------+-------------------------------------------------------------+

%{cache_9ec560cc1c6e7af9dc81cf707c3e1242}%

