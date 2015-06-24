MVC Applications
================
All the hard work behind orchestrating the operation of MVC in Phalcon is normally done by
:doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`. This component encapsulates all the complex
operations required in the background, instantiating every component needed and integrating it with the
project, to allow the MVC pattern to operate as desired.

Single or Multi Module Applications
-----------------------------------
With this component you can run various types of MVC structures:

Single Module
^^^^^^^^^^^^^
Single MVC applications consist of one module only. Namespaces can be used but are not necessary.
An application like this would have the following file structure:

.. code-block:: php

    single/
        app/
            controllers/
            models/
            views/
        public/
            css/
            img/
            js/

If namespaces are not used, the following bootstrap file could be used to orchestrate the MVC flow:

.. code-block:: php

    <?php

    $loader = new \Phalcon\Loader();

    $loader->registerDirs(
        array(
            '../apps/controllers/',
            '../apps/models/'
        )
    )->register();

    $di = new \Phalcon\DI\FactoryDefault();

    // Registering the view component
    $di->set('view', function() {
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir('../apps/views/');
        return $view;
    });

    try {
        $application = new \Phalcon\Mvc\Application();
        $application->setDI($di);
        echo $application->handle()->getContent();
    } catch(Phalcon\Exception $e) {
        echo $e->getMessage();
    }

If namespaces are used, the following bootstrap can be used:

.. code-block:: php

    <?php

    $loader = new \Phalcon\Loader();

    // Use autoloading with namespaces prefixes
    $loader->registerNamespaces(
        array(
            'Single\Controllers' => '../apps/controllers/',
            'Single\Models'      => '../apps/models/',
        )
    )->register();

    $di = new \Phalcon\DI\FactoryDefault();

    // Register the dispatcher setting a Namespace for controllers
    // Pay special attention to the double slashes at the end of the
    // parameter used in the setDefaultNamespace function
    $di->set('dispatcher', function() {
        $dispatcher = new \Phalcon\Mvc\Dispatcher();
        $dispatcher->setDefaultNamespace('Single\Controllers');
        return $dispatcher;
    });

    // Registering the view component
    $di->set('view', function() {
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir('../apps/views/');
        return $view;
    });

    try {
        $application = new \Phalcon\Mvc\Application();
        $application->setDI($di);
        echo $application->handle()->getContent();
    } catch(Phalcon\Exception $e){
        echo $e->getMessage();
    }


Multi Module
^^^^^^^^^^^^
A multi-module application uses the same document root for more than one module. In this case the following file structure can be used:

.. code-block:: php

    multiple/
      apps/
        frontend/
           controllers/
           models/
           views/
           Module.php
        backend/
           controllers/
           models/
           views/
           Module.php
      public/
        css/
        img/
        js/

Each directory in apps/ have its own MVC structure. A Module.php is present to configure specific settings of each module like autoloaders or custom services:

.. code-block:: php

    <?php

    namespace Multiple\Backend;

    use Phalcon\Mvc\ModuleDefinitionInterface;

    class Module implements ModuleDefinitionInterface
    {

        /**
         * Register a specific autoloader for the module
         */
        public function registerAutoloaders()
        {

            $loader = new \Phalcon\Loader();

            $loader->registerNamespaces(
                array(
                    'Multiple\Backend\Controllers' => '../apps/backend/controllers/',
                    'Multiple\Backend\Models'      => '../apps/backend/models/',
                )
            );

            $loader->register();
        }

        /**
         * Register specific services for the module
         */
        public function registerServices($di)
        {

            //Registering a dispatcher
            $di->set('dispatcher', function() {
                $dispatcher = new \Phalcon\Mvc\Dispatcher();
                $dispatcher->setDefaultNamespace("Multiple\Backend\Controllers");
                return $dispatcher;
            });

            //Registering the view component
            $di->set('view', function() {
                $view = new \Phalcon\Mvc\View();
                $view->setViewsDir('../apps/backend/views/');
                return $view;
            });
        }

    }

A special bootstrap file is required to load the a multi-module MVC architecture:

.. code-block:: php

    <?php

    $di = new \Phalcon\DI\FactoryDefault();

    //Specify routes for modules
    $di->set('router', function () {

        $router = new \Phalcon\Mvc\Router();

        $router->setDefaultModule("frontend");

        $router->add(
            "/login",
            array(
                'module'     => 'backend',
                'controller' => 'login',
                'action'     => 'index',
            )
        );

        $router->add(
            "/admin/products/:action",
            array(
                'module'     => 'backend',
                'controller' => 'products',
                'action'     => 1,
            )
        );

        $router->add(
            "/products/:action",
            array(
                'controller' => 'products',
                'action'     => 1,
            )
        );

        return $router;

    });

    try {

        //Create an application
        $application = new \Phalcon\Mvc\Application();
        $application->setDI($di);

        // Register the installed modules
        $application->registerModules(
            array(
                'frontend' => array(
                    'className' => 'Multiple\Frontend\Module',
                    'path'      => '../apps/frontend/Module.php',
                ),
                'backend'  => array(
                    'className' => 'Multiple\Backend\Module',
                    'path'      => '../apps/backend/Module.php',
                )
            )
        );

        //Handle the request
        echo $application->handle()->getContent();

    } catch(Phalcon\Exception $e){
        echo $e->getMessage();
    }

If you want to maintain the module configuration in the bootstrap file you can use an anonymous function to register the
module:

.. code-block:: php

    <?php

    //Creating a view component
    $view = new \Phalcon\Mvc\View();

    // Register the installed modules
    $application->registerModules(
        array(
            'frontend' => function($di) use ($view) {
                $di->setShared('view', function() use ($view) {
                    $view->setViewsDir('../apps/frontend/views/');
                    return $view;
                });
            },
            'backend' => function($di) use ($view) {
                $di->setShared('view', function() use ($view) {
                    $view->setViewsDir('../apps/backend/views/');
                    return $view;
                });
            }
        )
    );

When :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` have modules registered, always is
necessary that every matched route returns a valid module. Each registered module has an associated class
offering functions to set the module itself up. Each module class definition must implement two
methods: registerAutoloaders() and registerServices(), they will be called by
:doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` according to the module to be executed.

Understanding the default behavior
----------------------------------
If you've been following the :doc:`tutorial <tutorial>` or have generated the code using :doc:`Phalcon Devtools <tools>`,
you may recognize the following bootstrap file:

.. code-block:: php

    <?php

    try {

        // Register autoloaders
        //...

        // Register services
        //...

        // Handle the request
        $application = new \Phalcon\Mvc\Application();
        $application->setDI($di);
        echo $application->handle()->getContent();

    } catch (\Phalcon\Exception $e) {
        echo "PhalconException: ", $e->getMessage();
    }

The core of all the work of the controller occurs when handle() is invoked:

.. code-block:: php

    <?php

    echo $application->handle()->getContent();

If you do not wish to use :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`, the code above can be changed as follows:

.. code-block:: php

    <?php

    // Request the services from the services container
    $router = $di->get('router');
    $router->handle();

    $view = $di->getShared('view');

    $dispatcher = $di->get('dispatcher');

    // Pass the proccessed router parameters to the dispatcher
    $dispatcher->setControllerName($router->getControllerName());
    $dispatcher->setActionName($router->getActionName());
    $dispatcher->setParams($router->getParams());

    // Start the view
    $view->start();

    // Dispatch the request
    $dispatcher->dispatch();

    // Render the related views
    $view->render(
        $dispatcher->getControllerName(),
        $dispatcher->getActionName(),
        $dispatcher->getParams()
    );

    // Finish the view
    $view->finish();

    $response = $di->get('response');

    // Pass the output of the view to the response
    $response->setContent($view->getContent());

    // Send the request headers
    $response->sendHeaders();

    // Print the response
    echo $response->getContent();

Although the above is a lot more verbose than the code needed while using :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`,
it offers an alternative in boostraping your application. Depending on your needs, you might want to have full control of what
should be instantiated or not, or replace certain components with those of your own to extend the default functionality.

Application Events
------------------
:doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` is able to send events to the :doc:`EventsManager <events>`
(if it is present). Events are triggered using the type "application". The following events are supported:

+---------------------+--------------------------------------------------------------+
| Event Name          | Triggered                                                    |
+=====================+==============================================================+
| beforeStartModule   | Before initialize a module, only when modules are registered |
+---------------------+--------------------------------------------------------------+
| afterStartModule    | After initialize a module, only when modules are registered  |
+---------------------+--------------------------------------------------------------+
| beforeHandleRequest | Before execute the dispatch loop                             |
+---------------------+--------------------------------------------------------------+
| afterHandleRequest  | After execute the dispatch loop                              |
+---------------------+--------------------------------------------------------------+

The following example demonstrates how to attach listeners to this component:

.. code-block:: php

    <?php

    $eventsManager = new Phalcon\Events\Manager();

    $application->setEventsManager($eventsManager);

    $eventsManager->attach(
        "application",
        function($event, $application) {
            // ...
        }
    );

External Resources
------------------

* `MVC examples on Github <https://github.com/phalcon/mvc>`_
