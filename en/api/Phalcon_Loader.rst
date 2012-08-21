Class **Phalcon_Loader**
========================

This component helps to load your project classes automatically based on several conventions  

.. code-block:: php

    <?php
    
    // Creates the autoloader
    $loader = new Phalcon\Loader();

    // Register some namespaces
    $loader->registerNamespaces(
        array(
            'Example\\Base'    => 'vendor/example/base/',
            'Example\\Adapter' => 'vendor/example/adapter/',
            'Example'          => 'vendor/example/',
        )
    );

    // register the autoloader
    $loader->register();

    // Requiring class will automatically include file vendor/example/adapter/Some.php
    $adapter = Example\Adapter\Some();

Methods
---------

**registerNamespaces** (array $namespaces)

Register namespaces and their related directories

**registerDirs** (array $directories)

Register directories on which "not found" classes could be found

**registerClasses** (unknown $classes)

Register classes and their locations

**register** ()

Register the autoload method

**boolean** **autoLoad** (string $className)

Makes the work of autoload registered classes

