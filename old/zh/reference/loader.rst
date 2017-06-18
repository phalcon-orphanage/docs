类加载器（Class Autoloader）
================

:doc:`Phalcon\\Loader <../api/Phalcon_Loader>` 允许我们基于一些预定于的规则，自动的加载项目中的类。得益于该组件是C实现的，我们可以以更低的消耗去读取和解析这些外部的PHP文件。

这个组件的行为是基于PHP的 `autoloading classes`_ 特性。如果在代码的任何地方用到了一个尚不存在的类，一个特殊的处理程序会尝试去加载它。:doc:`Phalcon\\Loader <../api/Phalcon_Loader>` 扮演的正是这个角色。
通过按需加载的方式加载类，由于文件读取行为只在需要的时候发生，整体性能会的带提高。这个技术就是所谓的“惰性初始模式( `lazy initialization`_ ) 。

通过这个组件我们可以加载其他项目或者类库中的文件，加载器兼容  `PSR-0 <https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md>`_ 和 `PSR-4 <https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4.md>`_ 。

:doc:`Phalcon\\Loader <../api/Phalcon_Loader>` 提供了四种类加载方式，我们可以选择其中一个或者组合起来使用。

安全层（Security Layer）
------------------------
:doc:`Phalcon\\Loader <../api/Phalcon_Loader>` 默认会提供一个安全层过滤类名，以避免载入一些不安全的文件。

请看下面的类子：

.. code-block:: php

    <?php

    // Basic autoloader
    spl_autoload_register(
        function ($className) {
            $filepath = $className . ".php";

            if (file_exists($filepath)) {
                require $filepath;
            }
        }
    );

上面这个加载器缺乏任何安全措施。如果一个方法触发了加载器并且传入了一个蓄意准备的 string 作为参数，那么程序将允许执行应用可以访问的任何文件。

.. code-block:: php

    <?php

    // This variable is not filtered and comes from an insecure source
    $className = "../processes/important-process";

    // Check if the class exists triggering the auto-loader
    if (class_exists($className)) {
        // ...
    }

如果 '../processes/important-process.php' 是一个有效的文件，那么外部用户可以执行未经授权的执行它。

为了避免类似的或者其他更为复杂的攻击， :doc:`Phalcon\\Loader <../api/Phalcon_Loader>` 会移除类名中所有的不合法字符，以降低被攻击的可能。

注册命名空间（Registering Namespaces）
--------------------------------------
如果你的代码用命名空间组织，或者你要使用的外部类库使用了命名空间，那么 :code:`registerNamespaces()` 方法提供了相应的加载机制。它接收一个关联数组作为参数，键名是命名空间的前缀，值是这些类对应的文件所在的目录。
当加载器尝试寻找文件时，命名空间的分隔符会被替换成目录分隔符。记得在路径的末尾加上斜杠。

.. code-block:: php

    <?php

    use Phalcon\Loader;

    // Creates the autoloader
    $loader = new Loader();

    // Register some namespaces
    $loader->registerNamespaces(
        [
           "Example\Base"    => "vendor/example/base/",
           "Example\Adapter" => "vendor/example/adapter/",
           "Example"         => "vendor/example/",
        ]
    );

    // Register autoloader
    $loader->register();

    // The required class will automatically include the
    // file vendor/example/adapter/Some.php
    $some = new \Example\Adapter\Some();

注册文件夹（Registering Directories）
-------------------------------------
第三个方式是注册存放类文件的文件夹。由于性能问题这个方式并不推荐，因为Phalcon在目录里面查找跟类名同名的文件的时候，会在每个目录里面产生相当多的 file stats 操作。
请注意按照相关的顺序注册文件夹，同时，记得在每个文件夹路径末尾加上斜杠。

.. code-block:: php

    <?php

    use Phalcon\Loader;

    // Creates the autoloader
    $loader = new Loader();

    // Register some directories
    $loader->registerDirs(
        [
            "library/MyComponent/",
            "library/OtherComponent/Other/",
            "vendor/example/adapters/",
            "vendor/example/",
        ]
    );

    // Register autoloader
    $loader->register();

    // The required class will automatically include the file from
    // the first directory where it has been located
    // i.e. library/OtherComponent/Other/Some.php
    $some = new \Some();

注册类名（Registering Classes）
-------------------------------
最后一个方法是注册类名和它对应的文件路径。这个加载器在项目的目录结构约定上无法简单的通过路径和类名检索文件的时候相当有用。这也是最快的一种类加载方法。
然而，随着项目的增长，越来越多的 类/文件 需要加到加载器列表里，维护类列表会变的相当痛苦，因此也不推荐使用。

.. code-block:: php

    <?php

    use Phalcon\Loader;

    // Creates the autoloader
    $loader = new Loader();

    // Register some classes
    $loader->registerClasses(
        [
            "Some"         => "library/OtherComponent/Other/Some.php",
            "Example\Base" => "vendor/example/adapters/Example/BaseClass.php",
        ]
    );

    // Register autoloader
    $loader->register();

    // Requiring a class will automatically include the file it references
    // in the associative array
    // i.e. library/OtherComponent/Other/Some.php
    $some = new \Some();

注册文件（Registering Files）
-----------------
我们还可以注册那些不是类但是需要包含到应用里面的文件。这对引用那些只有函数的文件来说比较有用。

.. code-block:: php

    <?php

    use Phalcon\Loader;

    // Creates the autoloader
    $loader = new Loader();

    // Register some classes
    $loader->registerFiles(
        [
            "functions.php",
            "arrayFunctions.php",
        ]
    );

    // Register autoloader
    $loader->register();

这些文件文件会在 :code:`register()` 被自动加载进来。

额外的扩展名（Additional file extensions）
------------------------------------------
上面的加载策略，包括 "prefixes", "namespaces" or "directories" 等，会自动的在检索文件的最后面附加 “php” 后缀。如果我们使用了其他的后缀，我们可以通过 “setExtensions” 方法进行设置。文件会以我们定义的后缀顺序检索。

.. code-block:: php

    <?php

    use Phalcon\Loader;

    // Creates the autoloader
    $loader = new Loader();

    // Set file extensions to check
    $loader->setExtensions(
        [
            "php",
            "inc",
            "phb",
        ]
    );

修改当前策略（Modifying current strategies）
--------------------------------------------
我们可以向加载器注册方法的第二个参数传入 “true”，来将新定义的内容附加到当前方法已定义的内容之后。

.. code-block:: php

    <?php

    // Adding more directories
    $loader->registerDirs(
        [
            "../app/library/",
            "../app/plugins/",
        ],
        true
    );

自动加载事件（Autoloading Events）
----------------------------------
在下面的例子里面，我们将事件管理器（EventsManager）和加载器一起使用，这样我们可以根据接下来的操作获取一些调试信息。

.. code-block:: php

    <?php

    use Phalcon\Events\Event;
    use Phalcon\Events\Manager as EventsManager;
    use Phalcon\Loader;

    $eventsManager = new EventsManager();

    $loader = new Loader();

    $loader->registerNamespaces(
        [
            "Example\\Base"    => "vendor/example/base/",
            "Example\\Adapter" => "vendor/example/adapter/",
            "Example"          => "vendor/example/",
        ]
    );

    // Listen all the loader events
    $eventsManager->attach(
        "loader:beforeCheckPath",
        function (Event $event, Loader $loader) {
            echo $loader->getCheckedPath();
        }
    );

    $loader->setEventsManager($eventsManager);

    $loader->register();

下面是加载器支持的事件列表。一些事件返回 boolean false 的时候，可以终止当前活动的操作。

+------------------+---------------------------------------------------------------------------------------------------------------------+---------------------+
| 事件名称         | 触发情景                                                                                                            | 是否可以终止操作?   |
+==================+=====================================================================================================================+=====================+
| beforeCheckClass | 在加载操作执行之前触发                                                                                              | Yes                 |
+------------------+---------------------------------------------------------------------------------------------------------------------+---------------------+
| pathFound        | 在定位到一个类文件的时候触发                                                                                        | No                  |
+------------------+---------------------------------------------------------------------------------------------------------------------+---------------------+
| afterCheckClass  | 在加载操作执行之后触发。如果这个事件触发，说明加载器没有找到所需的类文件。                                          | No                  |
+------------------+-----------------------------------------------------------+---------------------------------------------------------+---------------------+

注意事项（Troubleshooting）
---------------------------
在使用加载器的时候，一些关键点需要牢记于心：

* 自动加载处理过程是大小写敏感的。类文件名与代码中所写的一致。
* 基于namespaces/prefixes机制的加载策略比基于directories的要快。
* 如果安装了类似 APC_ 的缓存工具，加载器隐式的用它来缓存文件检索结果，以便提高性能。

.. _autoloading classes: http://www.php.net/manual/en/language.oop5.autoload.php
.. _lazy initialization: http://en.wikipedia.org/wiki/Lazy_initialization
.. _APC: http://php.net/manual/en/book.apc.php
