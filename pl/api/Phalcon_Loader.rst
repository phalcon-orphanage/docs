Class **Phalcon\\Loader**
=========================

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/loader.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

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



public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager)

Sets the events manager



public  **getEventsManager** ()

Returns the internal event manager



public  **setExtensions** (*array* $extensions)

Sets an array of file extensions that the loader must try in each attempt to locate the file



public  **getExtensions** ()

Returns the file extensions registered in the loader



public  **registerNamespaces** (*array* $namespaces, [*mixed* $merge])

Register namespaces and their related directories



protected  **prepareNamespace** (*array* $namespace)

...


public  **getNamespaces** ()

Returns the namespaces currently registered in the autoloader



public  **registerDirs** (*array* $directories, [*mixed* $merge])

Register directories in which "not found" classes could be found



public  **getDirs** ()

Returns the directories currently registered in the autoloader



public  **registerClasses** (*array* $classes, [*mixed* $merge])

Register classes and their locations



public  **getClasses** ()

Returns the class-map currently registered in the autoloader



public  **register** ()

Register the autoload method



public  **unregister** ()

Unregister the autoload method



public  **autoLoad** (*mixed* $className)

Autoloads the registered classes



public  **getFoundPath** ()

Get the path when a class was found



public  **getCheckedPath** ()

Get the path the loader is checking for a path



