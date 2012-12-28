万能的类文件加载器
======================
:doc:`Phalcon\\Loader <../api/Phalcon_Loader>` 这个组件允许你根据预定义规则自动加载项目中的类文件。
此组件采用C语言编写，在读取和解析PHP文件方面，使用了最低的性能开销。

此组件功能是基于PHP自身的 `autoloading classes`_ 实现的。如果在任何代码部分未找到类，那么它将尝试使用特殊的处理加载它,:doc:`Phalcon\\Loader <../api/Phalcon_Loader>` 就是用于处理这种任务的。加载类文件采用按需加载的方式，只有需要某个类文件时，才会进行加载及文件读取。这种技术被称为延时初始化( `lazy initialization`_ )。

使用此组件，你可以从其他项目或vendors(不知道是什么，应该指的是其他服务器)加载文件，autoloader 采用 `PSR-0 <https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md>`_ 标准。

:doc:`Phalcon\\Loader <../api/Phalcon_Loader>` 提供四种方式自动加载类文件，你可以一次只使用其中一个，或者混合使用。

Registering Namespaces
----------------------
如果你的代码使用了命名空间或外部库文件，可以使用registerNamespaces()，它提供了一种自动加载机制，可以通过传递一个关联数组，key是命名空间前辍，value是类文件存放的目录。当加载并试图查找类文件时，分隔符被替换成目录分隔符，以便正确加载类文件。还有一点请注意，value末尾一定要以"/"结尾。

.. code-block:: php

    <?php

    // Creates the autoloader
    $loader = new \Phalcon\Loader();

    //Register some namespaces
    $loader->registerNamespaces(
        array(
           "Example\Base"    => "vendor/example/base/",
           "Example\Adapter" => "vendor/example/adapter/",
           "Example"         => "vendor/example/",
        )
    );

    // register autoloader
    $loader->register();

    // The required class will automatically include the
    // file vendor/example/adapter/Some.php
    $some = new Example\Adapter\Some();

Registering Prefixes
----------------------
这种策略非常类似上面讲到的命名空间的加载机制。它也需要一个关联数组，key是前辍，value是类所在的目录。加载的时候，命名空间分隔符和下划线"_"将要被替换为目录分隔符。还是请注意，value的结尾一定要以"/"作为结束符。

.. code-block:: php

    <?php

    // Creates the autoloader
    $loader = new \Phalcon\Loader();

    //Register some prefixes
    $loader->registerPrefixes(
        array(
           "Example_Base"    => "vendor/example/base/",
           "Example_Adapter" => "vendor/example/adapter/",
           "Example_"         => "vendor/example/",
        )
    );

    // register autoloader
    $loader->register();

    // The required class will automatically include the
    // file vendor/example/adapter/Some.php
    $some = new Example_Adapter_Some();

Registering Directories
-----------------------
第三种方式是注册目录，在注册的目录中找到类文件。在性能方面，不建议使用此种方式，因为Phalcon将对注册的所有目录及文件进行查找，直接查找具有相同名称的类文件。注册目录时的顺序是非常重要的。请注意，结尾以"/"结束。

.. code-block:: php

    <?php

    // Creates the autoloader
    $loader = new \Phalcon\Loader();

    // Register some directories
    $loader->registerDirs(
        array(
            "library/MyComponent/",
            "library/OtherComponent/Other/",
            "vendor/example/adapters/",
            "vendor/example/"
        )
    );

    // register autoloader
    $loader->register();

    // The required class will automatically include the file from
    // the first directory where it has been located
    // i.e. library/OtherComponent/Other/Some.php
    $some = new Some();

Registering Classes
-------------------
最后一种方式是注册类的名称和路径。这种加载方面是最快的一种加载方式。然而，随着应用程序的增长，更多的类及文件需要加载，这将使维护工作变得非常麻烦，因为不太建议使用。

.. code-block:: php

    <?php

    // Creates the autoloader
    $loader = new \Phalcon\Loader();

    // Register some classes
    $loader->registerClasses(
        array(
            "Some"         => "library/OtherComponent/Other/Some.php",
            "Example\Base" => "vendor/example/adapters/Example/BaseClass.php",
        )
    );

    // register autoloader
    $loader->register();

    // Requiring a class will automatically include the file it references
    // in the associative array
    // i.e. library/OtherComponent/Other/Some.php
    $some = new Some();

其他扩展名文件的加载
--------------------------
一些自动加载策略，如"prefixes","namespaces",或"directories"都会自动加载扩展名为".php"的文件。如果你想自动加载其他扩展类型的文件时，你可以使用"setExtensions"方法。示例如下：

.. code-block:: php

    <?php

     // Creates the autoloader
    $loader = new \Phalcon\Loader();

    //Set file extensions to check
    $loader->setExtensions(array("php", "inc", "phb"));

Modifying current strategies
----------------------------
通过下面的方式可以把需要后来加载的其他文件合并到上述加载策略中：

.. code-block:: php

    <?php

    // Adding more directories
    $loader->registerDirs(
        array(
            "../app/library/"
            "../app/plugins/"
        ),
        true
    );

通过传递第二个参数"true"，可以让新的目录或类文件合并到上述四种加载策略中。

Autoloading Events
------------------
在下面的例子中，EventsManager与类加载器协同工作，使我们能够获得操作流程的调试信息：

.. code-block:: php

    <?php

    $eventsManager = new \Phalcon\Events\Manager();

    $loader = new \Phalcon\Loader();

    $loader->registerNamespaces(array(
       'Example\\Base' => 'vendor/example/base/',
       'Example\\Adapter' => 'vendor/example/adapter/',
       'Example' => 'vendor/example/'
    ));

    //Listen all the loader events
    $eventsManager->attach('loader', function($event, $loader) {
        if ($event->getType() == 'beforeCheckPath') {
            echo $loader->getCheckedPath();
        }
    });

    $loader->setEventsManager($eventsManager);

    $loader->register();

当事件返回布尔值false时，可以停止激活的操作。支持以下一些事件：

+------------------+---------------------------------------------------------------------------------------------------------------------+---------------------+
| Event Name       | Triggered                                                                                                           | Can stop operation? |
+==================+=====================================================================================================================+=====================+
| beforeCheckClass | Triggered before start the autoloading process                                                                      | Yes                 |
+------------------+---------------------------------------------------------------------------------------------------------------------+---------------------+
| pathFound        | Triggered when the loader locate a class                                                                            | No                  |
+------------------+---------------------------------------------------------------------------------------------------------------------+---------------------+
| afterCheckClass  | Triggered after finish the autoloading process. If this event is launched the autoloader didn't find the class file | No                  |
+------------------+-----------------------------------------------------------+---------------------------------------------------------+---------------------+

.. _autoloading classes: http://www.php.net/manual/en/language.oop5.autoload.php
.. _lazy initialization: http://en.wikipedia.org/wiki/Lazy_initialization
