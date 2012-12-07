Class **Phalcon\\Loader**
=========================

<<<<<<< HEAD
This component helps to load your project classes automatically based on some conventions 
=======
*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

This component helps to load your project classes automatically based on some conventions  
>>>>>>> 0.7.0

.. code-block:: php

    <?php

     //Creates the autoloader
     $loader = new Phalcon\Loader();
    
     //Register some namespaces
     $loader->registerNamespaces(array(
<<<<<<< HEAD
       'Example\\Base' => 'vendor/example/base/',
       'Example\\Adapter' => 'vendor/example/adapter/',
=======
       'Example\Base' => 'vendor/example/base/',
       'Example\Adapter' => 'vendor/example/adapter/',
>>>>>>> 0.7.0
       'Example' => 'vendor/example/'
     ));
    
     //register autoloader
     $loader->register();
    
<<<<<<< HEAD
     //Requiring class will automatically include file vendor/example/adapter/Some.php
=======
     //Requiring this class will automatically include file vendor/example/adapter/Some.php
>>>>>>> 0.7.0
     $adapter = Example\Adapter\Some();



Methods
---------

public  **__construct** ()

<<<<<<< HEAD
...


public  **setEventsManager** (:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` $eventsManager)
=======
Phalcon\\Loader constructor



public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager)
>>>>>>> 0.7.0

Sets the events manager



<<<<<<< HEAD
public :doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>`  **getEventsManager** ()
=======
public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** ()
>>>>>>> 0.7.0

Returns the internal event manager



public :doc:`Phalcon\\Loader <Phalcon_Loader>`  **setExtensions** (*array* $extensions)

Sets an array of extensions that the Loader must check together with the path



<<<<<<< HEAD
public :doc:`Phalcon\\Loader <Phalcon_Loader>`  **registerNamespaces** (*array* $namespaces)
=======
public *boolean*  **getExtensions** ()

Return file extensions registered in the loader



public :doc:`Phalcon\\Loader <Phalcon_Loader>`  **registerNamespaces** (*array* $namespaces, *boolean* $merge)
>>>>>>> 0.7.0

Register namespaces and their related directories



<<<<<<< HEAD
public :doc:`Phalcon\\Loader <Phalcon_Loader>`  **registerPrefixes** (*unknown* $prefixes)
=======
public  **getNamespaces** ()

Return current namespaces registered in the autoloader



public :doc:`Phalcon\\Loader <Phalcon_Loader>`  **registerPrefixes** (*unknown* $prefixes, *boolean* $merge)
>>>>>>> 0.7.0

Register directories on which "not found" classes could be found



<<<<<<< HEAD
public :doc:`Phalcon\\Loader <Phalcon_Loader>`  **registerDirs** (*array* $directories)
=======
public  **getPrefixes** ()

Return current prefixes registered in the autoloader



public :doc:`Phalcon\\Loader <Phalcon_Loader>`  **registerDirs** (*array* $directories, *boolean* $merge)
>>>>>>> 0.7.0

Register directories on which "not found" classes could be found



<<<<<<< HEAD
public :doc:`Phalcon\\Loader <Phalcon_Loader>`  **registerClasses** (*unknown* $classes)
=======
public  **getDirs** ()

Return current directories registered in the autoloader



public :doc:`Phalcon\\Loader <Phalcon_Loader>`  **registerClasses** (*array* $classes, *boolean* $merge)
>>>>>>> 0.7.0

Register classes and their locations



<<<<<<< HEAD
=======
public  **getClasses** ()

Return the current class-map registered in the autoloader



>>>>>>> 0.7.0
public :doc:`Phalcon\\Loader <Phalcon_Loader>`  **register** ()

Register the autoload method



<<<<<<< HEAD
public  **unregister** ()
=======
public :doc:`Phalcon\\Loader <Phalcon_Loader>`  **unregister** ()
>>>>>>> 0.7.0

Unregister the autoload method



public *boolean*  **autoLoad** (*string* $className)

Makes the work of autoload registered classes



public *string*  **getFoundPath** ()

Get the path when a class was found



public *string*  **getCheckedPath** ()

Get the path the loader is checking for a path



