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

public **__construct** ()

public **setEventsManager** (*unknown* $eventsManager)

:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` public **getEventsManager** ()

Returns the internal event manager



public **setExtensions** (*array* $extensions)

Sets an array of extensions that the Loader must check together with the path



public **registerNamespaces** (*array* $namespaces)

Register namespaces and their related directories



public **registerPrefixes** (*unknown* $prefixes)

Register directories on which "not found" classes could be found



public **registerDirs** (*array* $directories)

Register directories on which "not found" classes could be found



public **registerClasses** (*unknown* $classes)

Register classes and their locations



public **register** ()

Register the autoload method



public **unregister** ()

Unregister the autoload method



*boolean* public **autoLoad** (*string* $className)

Makes the work of autoload registered classes



public **getFoundPath** ()

public **getCheckedPath** ()

