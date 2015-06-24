Class **Phalcon\\Loader**
=========================

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

This component helps to load your project classes automatically based on some conventions  

.. code-block:: php

    <?php

     //Creates the autoloader
     $loader = new Loader();
    
     //Register some namespaces
     $loader->registerNamespaces(array(
       'Example\Base' => 'vendor/example/base/',
       'Example\Adapter' => 'vendor/example/adapter/',
       'Example' => 'vendor/example/'
     ));
    
     //register autoloader
     $loader->register();
    
     //Requiring this class will automatically include file vendor/example/adapter/Some.php
     $adapter = Example\Adapter\Some();



Methods
-------

public  **__construct** ()

Phalcon\\Loader constructor



public  **setEventsManager** (*unknown* $eventsManager)

Sets the events manager



public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** ()

Returns the internal event manager



public :doc:`Phalcon\\Loader <Phalcon_Loader>`  **setExtensions** (*unknown* $extensions)

Sets an array of extensions that the loader must try in each attempt to locate the file



public *boolean*  **getExtensions** ()

Return file extensions registered in the loader



public :doc:`Phalcon\\Loader <Phalcon_Loader>`  **registerNamespaces** (*unknown* $namespaces, [*unknown* $merge])

Register namespaces and their related directories



public  **getNamespaces** ()

Return current namespaces registered in the autoloader



public :doc:`Phalcon\\Loader <Phalcon_Loader>`  **registerPrefixes** (*unknown* $prefixes, [*unknown* $merge])

Register directories on which "not found" classes could be found



public  **getPrefixes** ()

Return current prefixes registered in the autoloader



public :doc:`Phalcon\\Loader <Phalcon_Loader>`  **registerDirs** (*unknown* $directories, [*unknown* $merge])

Register directories on which "not found" classes could be found



public  **getDirs** ()

Return current directories registered in the autoloader



public :doc:`Phalcon\\Loader <Phalcon_Loader>`  **registerClasses** (*unknown* $classes, [*unknown* $merge])

Register classes and their locations



public  **getClasses** ()

Return the current class-map registered in the autoloader



public :doc:`Phalcon\\Loader <Phalcon_Loader>`  **register** ()

Register the autoload method



public :doc:`Phalcon\\Loader <Phalcon_Loader>`  **unregister** ()

Unregister the autoload method



public *boolean*  **autoLoad** (*unknown* $className)

Makes the work of autoload registered classes



public *string*  **getFoundPath** ()

Get the path when a class was found



public *string*  **getCheckedPath** ()

Get the path the loader is checking for a path



