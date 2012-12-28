Universal Class Loader
======================
:doc:`Phalcon\\Loader <../api/Phalcon_Loader>` is a component that allows you to load project classes automatically, based on some predefined rules.
Since this component is written in C, it provides the lowest overhead in reading and interpreting external PHP files.

The behavior of this component is based on the PHP's capability of `autoloading classes`_. If a class that does not exist is used in any part of the
code, a special handler will try to load it. :doc:`Phalcon\\Loader <../api/Phalcon_Loader>` serves as the special handler for this operation. By
loading classes on a need to load basis, the overall performance is increased since the only file reads that occur are for the files needed. This
technique is called `lazy initialization`_.

With this component you can load files from other projects or vendors, this autoloader is `PSR-0 <https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md>`_ compliant.

:doc:`Phalcon\\Loader <../api/Phalcon_Loader>` offers four options to autoload classes. You can use them one at a time or combine them.

Registering Namespaces
----------------------
If you're organizing your code using namespaces, or external libraries do so, the registerNamespaces() provides the autoloading mechanism. It
takes an associative array, which keys are namespace prefixes and their values are directories where the classes are located in. The namespace
separator will be replaced by the directory separator when the loader try to find the classes. Remember always to add a trailing slash at
the end of the paths.

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
This strategy is similar to the namespaces strategy. It takes an associative array, which keys are prefixes and their values are directories
where the classes are located in. The namespace separator and the "_" underscore character will be replaced by the directory separator when
the loader try to find the classes. Remember always to add a trailing slash at the end of the paths.

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
The third option is to register directories, in which classes could be found. This option is not recommended in terms of performance,
since Phalcon will need to perform a significant number of file stats on each folder, looking for the file with the same name as the class.
It's important to register the directories in relevance order. Remember always add a trailing slash at the end of the paths.

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
The last option is to register the class name and its path. This autoloader can be very useful when the folder convention of the
project does not allow for easy retrieval of the file using the path and the class name. This is the fastest method of autoloading.
However the more your application grows, the more classes/files need to be added to this autoloader, which will effectively make
maintenance of the class list very cumbersome and it is not recommended.

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

Additional file extensions
--------------------------
Some autoloading strategies such as  "prefixes", "namespaces" or "directories" automatically append the "php" extension at the end of the checked file. If you
are using additional extensions you could set it with the method "setExtensions". Files are checked in the order as it were defined:

.. code-block:: php

    <?php

     // Creates the autoloader
    $loader = new \Phalcon\Loader();

    //Set file extensions to check
    $loader->setExtensions(array("php", "inc", "phb"));

Modifying current strategies
----------------------------
Additional data could be added to the existing values for strategies in the following way:

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

Passing "true" as second parameter will merge the current values with new ones in any strategy.

Autoloading Events
------------------
In the following example, the EventsManager is working with the class loader, allowing us to obtain debugging information regarding the flow of operation:

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

Some events when returning boolean false could stop the active operation. The following events are supported:

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
