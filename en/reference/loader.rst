

Universal Class Loader
======================
helps to load your project classesautomatically based on some predefined conventions. This component is written in C giving you the lowest overhead reading and executing external PHP files. The behavior of this component is basically based on thePHP's capability of  `autoload classes <http://www.php.net/manual/en/language.oop5.autoload.php>`_ .This concept tells us that when a class that not exist is used in any part of the code, a special handler will try to load it. In this case, Phalcon_Loader is that kind of handler. Additionally, when you load classes as needed, the number of unnecessary files reads is decreased improving the overallperformance. This technique is also called  `lazy initialization <http://en.wikipedia.org/wiki/Lazy_initialization>`_ Principally, Phalcon_Loader gives you 3 alternatives to autoload classes. You can combine any of themor use a single one. 

Registering Namespaces
----------------------
If you're organizing your code using namespaces, or any external vendor does so,the registerNamespaces() method could be useful. It takes an associative array whose keys are namespaces prefixes and their values are directories where the classes are located in. Remember always add a trailing slash at the end of the paths. 

.. code-block:: php

    <?php
    
    //Creates the autoloader
    $loader = new Phalcon_Loader();
    
    //Register some namespaces
    $loader->registerNamespaces(array(
       "Example\Base" => "vendor/example/base/",
       "Example\Adapter" => "vendor/example/adapter/",
       "Example" => "vendor/example/"
    ));
    
    //register autoloader
    $loader->register();
    
    //Requiring class wil automatically include file vendor/example/adapter/Some.php
    $some = new Example\Adapter\Some();



Registering Directories
-----------------------
The second option is to register directories on which your classes could be found,this option is the less recommended because Phalcon must do many file stats in each directory looking for a file with the same name as the class. It's important to register the directories in relevance order. Remember always add a trailing slash at the end of the paths. 

.. code-block:: php

    <?php
    
    //Creates the autoloader
    $loader = new Phalcon_Loader();
    
    //Register some directories
    $loader->registerDirs(array(
       "library/MyComponent/",
       "library/OtherComponent/Other/",
       "vendor/example/adapters/",
       "vendor/example/"
    ));
    
    //register autoloader
    $loader->register();
    
    //Requiring a class will automatically load it from the first directory where it has been located
    //ie. library/OtherComponent/Other/Some.php
    $some = new Some();



Registering Classes
-------------------
The last alternative is register the class name and its path.This could be very usefull when the paths don't have any convention to easily find the path from the class name. Also, this is the easiest and fastest method, but if you have many classes in your application, is not recommended to use this method. 

.. code-block:: php

    <?php
    
    //Creates the autoloader
    $loader = new Phalcon_Loader();
    
    //Register some directories
    $loader->registerClasses(array(
       "Some" => "library/OtherComponent/Other/Some.php",
       "Example\Base" => "vendor/example/adapters/Example/BaseClass.php",
    ));
    
    //register autoloader
    $loader->register();
    
    //Requiring a class will automatically load it from the first directory where it has been located
    //ie. library/OtherComponent/Other/Some.php
    $some = new Some();

