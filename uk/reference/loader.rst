Class Autoloader
================

:doc:`Phalcon\\Loader <../api/Phalcon_Loader>` allows you to load project classes automatically,
based on some predefined rules. Since this component is written in C, it provides the lowest overhead in
reading and interpreting external PHP files.

The behavior of this component is based on the PHP's capability of `autoloading classes`_. If a class that does
not yet exist is used in any part of the code, a special handler will try to load it.
:doc:`Phalcon\\Loader <../api/Phalcon_Loader>` serves as the special handler for this operation.
By loading classes on a need-to-load basis, the overall performance is increased since the only file
reads that occur are for the files needed. This technique is called `lazy initialization`_.

With this component you can load files from other projects or vendors, this autoloader is `PSR-0 <https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md>`_ and `PSR-4 <https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4.md>`_ compliant.

:doc:`Phalcon\\Loader <../api/Phalcon_Loader>` offers four options to autoload classes. You can use them one at a time or combine them.

Security Layer
--------------
:doc:`Phalcon\\Loader <../api/Phalcon_Loader>` offers a security layer sanitizing by default class names avoiding possible inclusion of unauthorized files.
Consider the following example:

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

The above auto-loader lacks any kind of security. If a function mistakenly launches the auto-loader and
a malicious prepared string is used as parameter this would allow to execute any file accessible by the application:

.. code-block:: php

    <?php

    // This variable is not filtered and comes from an insecure source
    $className = "../processes/important-process";

    // Check if the class exists triggering the auto-loader
    if (class_exists($className)) {
        // ...
    }

If '../processes/important-process.php' is a valid file, an external user could execute the file without
authorization.

To avoid these or most sophisticated attacks, :doc:`Phalcon\\Loader <../api/Phalcon_Loader>` removes invalid characters from the class name,
reducing the possibility of being attacked.

Registering Namespaces
----------------------
If you're organizing your code using namespaces, or using external libraries which do, the :code:`registerNamespaces()` method provides the autoloading mechanism. It
takes an associative array; the keys are namespace prefixes and their values are directories where the classes are located in. The namespace
separator will be replaced by the directory separator when the loader tries to find the classes. Always remember to add a trailing slash at
the end of the paths.

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

Registering Directories
-----------------------
The third option is to register directories, in which classes could be found. This option is not recommended in terms of performance,
since Phalcon will need to perform a significant number of file stats on each folder, looking for the file with the same name as the class.
It's important to register the directories in relevance order. Remember always add a trailing slash at the end of the paths.

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

Registering Classes
-------------------
The last option is to register the class name and its path. This autoloader can be very useful when the folder convention of the
project does not allow for easy retrieval of the file using the path and the class name. This is the fastest method of autoloading.
However the more your application grows, the more classes/files need to be added to this autoloader, which will effectively make
maintenance of the class list very cumbersome and it is not recommended.

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

Registering Files
-----------------
You can also registers files that are "non-classes" hence needing a "require". This is very useful for including files that only have functions:

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

These files are automatically loaded in the :code:`register()` method.

Additional file extensions
--------------------------
Some autoloading strategies such as  "prefixes", "namespaces" or "directories" automatically append the "php" extension at the end of the checked file. If you
are using additional extensions you could set it with the method "setExtensions". Files are checked in the order as it were defined:

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

Modifying current strategies
----------------------------
Additional auto-loading data can be added to existing values by passing "true" as the second parameter:

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

Autoloading Events
------------------
In the following example, the EventsManager is working with the class loader, allowing us to obtain debugging information regarding the flow of operation:

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

Some events when returning boolean false could stop the active operation. The following events are supported:

+------------------+---------------------------------------------------------------------------------------------------------------------+---------------------+
| Event Name       | Triggered                                                                                                           | Can stop operation? |
+==================+=====================================================================================================================+=====================+
| beforeCheckClass | Triggered before starting the autoloading process                                                                   | Yes                 |
+------------------+---------------------------------------------------------------------------------------------------------------------+---------------------+
| pathFound        | Triggered when the loader locate a class                                                                            | No                  |
+------------------+---------------------------------------------------------------------------------------------------------------------+---------------------+
| afterCheckClass  | Triggered after finish the autoloading process. If this event is launched the autoloader didn't find the class file | No                  |
+------------------+-----------------------------------------------------------+---------------------------------------------------------+---------------------+

Troubleshooting
---------------
Some things to keep in mind when using the universal autoloader:

* Auto-loading process is case-sensitive, the class will be loaded as it is written in the code
* Strategies based on namespaces/prefixes are faster than the directories strategy
* If a cache bytecode like APC_ is installed this will used to retrieve the requested file (an implicit caching of the file is performed)

.. _autoloading classes: http://www.php.net/manual/en/language.oop5.autoload.php
.. _lazy initialization: http://en.wikipedia.org/wiki/Lazy_initialization
.. _APC: http://php.net/manual/en/book.apc.php
