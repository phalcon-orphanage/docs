Dependency Injection
====================

Phalcon\DI is a component that implements Dependency Injection of services and it's itself a container for them.

In short, objects should not be instantiated inside a class, rather injected using constructors and/or setter methods. This pattern increases testability in the code, thus making it less prone to errors.

Registering services in the Container
-------------------------------------
Services can be registered by the framework itself or the developer. When a component A requires component B (or an instance of its class) to operate, it can request component B from the container, rather than creating a new instance component B.

Services can be registered in several ways:

.. code-block:: php

    <?php

	//Create the Dependency Injector Container
	$di = new Phalcon\DI();

	//By its class name
	$di->set("request", "Phalcon\Http\Request");

	//Using an anonymous function, the instance will lazy loaded
	$di->set("request", function(){
	    return new Phalcon\Http\Request();
	});

	//Registering directly an instance
	$di->set("request", new Phalcon\Http\Request());

	//Using an array definition
	$di->set("request", array(
	    "className" => "Phalcon\Http\Request"
	));
