Dependency Injection
====================
Phalcon\DI is a component that implements Dependency Injection of services and it's itself a container for them.

Since Phalcon is highly decoupled, Phalcon\DI is essential to integrate the different components of the framework. The developer can also use the component to inject dependencies and manage global instances of different classes used in the application.

Basically, this component implements the `Inversion of Control`_ pattern. Applying this, the objects do not receive their dependencies using setters or constructors, but requesting a service dependency injector. This reduces the overall complexity, since there is only one way to get the required dependencies within a component.

Additionally, this pattern increases testability in the code, thus making it less prone to errors.

.. code-block:: php

    <?php

    //Without DI

    class SomeComponent {

        public function someDbTask(){
            $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
                "host" => "localhost",
                "username" => "root",
                "password" => "secret",
                "dbname" => "invo"
            ));
        }

    }

    $some = new SomeComponent();
    $some->someDbTask();

.. code-block:: php

    <?php

    //With DI

    class SomeComponent {

        protected $_di;

        public function setDI($di){
            $this->_di = $di;
        }

		public function someDbTask(){
            $connection = $this->_di->get('db');
            // ...
        }

    }

	$di = new Phalcon\DI();

	$di->set('db', function(){
		return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
			"host" => "localhost",
			"username" => "root",
			"password" => "secret",
			"dbname" => "invo"
		));
	});

	$some = new SomeComponent();

	$some->setDI($di);

	$some->someDbTask();

Registering services in the Container
-------------------------------------
Services can be registered by the framework itself or the developer. When a component A requires component B (or an instance of its class) to operate, it can request component B from the container, rather than creating a new instance component B.

This way of working gives us many advantages:

* We can replace a component, one created by ourselves or a third party one easily.
* We have full control of the object initialization, allowing us to set this objects as you need before delivery them to components.
* We can have a global instances of components in a structured way.

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

.. `Inversion of Control`: http://en.wikipedia.org/wiki/Inversion_of_control