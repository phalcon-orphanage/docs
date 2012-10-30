Class **Phalcon\\Loader**
=========================

This component helps to load your project classes automatically based on some conventions 

.. code-block:: php

    <?php

     //Creates the autoloader
     $loader = new Phalcon\Loader();
    
     //Register some namespaces
     $loader->registerNamespaces(array(
       'Example\\Base' => 'vendor/example/base/',
       'Example\\Adapter' => 'vendor/example/adapter/',
       'Example' => 'vendor/example/'
     ));
    
     //register autoloader
     $loader->register();
    
     //Requiring class will automatically include file vendor/example/adapter/Some.php
     $adapter = Example\Adapter\Some();



Methods
---------

public  **__construct** ()

...


public  **setEventsManager** (:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` $eventsManager)

Sets the events manager



public :doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>`  **getEventsManager** ()

Returns the internal event manager



public :doc:`Phalcon\\Loader <Phalcon_Loader>`  **setExtensions** (*array* $extensions)

Sets an array of extensions that the Loader must check together with the path



public :doc:`Phalcon\\Loader <Phalcon_Loader>`  **registerNamespaces** (*array* $namespaces)

Register namespaces and their related directories



public :doc:`Phalcon\\Loader <Phalcon_Loader>`  **registerPrefixes** (*unknown* $prefixes)

Register directories on which "not found" classes could be found



public :doc:`Phalcon\\Loader <Phalcon_Loader>`  **registerDirs** (*array* $directories)

Register directories on which "not found" classes could be found



public :doc:`Phalcon\\Loader <Phalcon_Loader>`  **registerClasses** (*unknown* $classes)

Register classes and their locations



public :doc:`Phalcon\\Loader <Phalcon_Loader>`  **register** ()

Register the autoload method



public  **unregister** ()

Unregister the autoload method



public *boolean*  **autoLoad** (*string* $className)

Makes the work of autoload registered classes



public *string*  **getFoundPath** ()

Get the path when a class was found



public *string*  **getCheckedPath** ()

Get the path the loader is checking for a path



