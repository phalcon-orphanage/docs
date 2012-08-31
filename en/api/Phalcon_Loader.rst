Class **Phalcon\\Loader**
=========================

Phalcon\\Loader   This component helps to load your project classes automatically based on some conventions  

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

**__construct** ()

**setEventsManager** (*unknown* **$eventsManager**)

:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` **getEventsManager** ()

**setExtensions** (*array* **$extensions**)

**registerNamespaces** (*array* **$namespaces**)

**registerPrefixes** (*unknown* **$prefixes**)

**registerDirs** (*array* **$directories**)

**registerClasses** (*unknown* **$classes**)

**register** ()

**unregister** ()

*boolean* **autoLoad** (*string* **$className**)

**getFoundPath** ()

**getCheckedPath** ()

