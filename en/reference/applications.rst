MVC Applications
================
All the hard work behind orchestrating the operation of MVC in Phalcon is normally done by :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`. This component encapsulates all the complex operations behind instantiating every component needed and integrating it with the rest to allow the MVC pattern to operate as desired.

Single or Multi Module Applications
-----------------------------------
With this component you can run various kinds of MVC structures:

Single Module
^^^^^^^^^^^^^
Single MVC applications consist of one module only. Optionally can have namespaces or not. An application like this would have a file structure like this:

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

If you aren't using namespaces in the application, the following bootstrap file could be used to orchestrate the MVC flow:

.. code-block:: php

    <?php

    $loader = new \Phalcon\Loader();

    $loader->registerDirs(array(
        '../apps/controllers/',
        '../apps/models/'
    ))->register();

    $di = new \Phalcon\DI\FactoryDefault();

    //Registering the view component
    $di->set('view', function(){
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

instead, if you are using namespaces then you can use this:

.. code-block:: php

    <?php

    $loader = new \Phalcon\Loader();

    //Use autoloading with namespaces prefixes
    $loader->registerNamespaces(array(
        'Single\Controllers' => '../apps/controllers/',
        'Single\Models' => '../apps/models/'
    ))->register();

    $di = new \Phalcon\DI\FactoryDefault();

    //Register the dispatcher setting a Namespace for controllers
    $di->set('dispatcher', function() {
        $dispatcher = new \Phalcon\Mvc\Dispatcher();
        $dispatcher->setDefaultNamespace('Single\Controllers\\');
        return $dispatcher;
    });

    //Registering the view component
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
A multi-module application uses the same document root for more than one module. In this case the following file structure could be used:

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

    class Module {

        /**
         * Register a specific autoloader for the module
         */
        public function registerAutoloaders()
        {

            $loader = new \Phalcon\Loader();

            $loader->registerNamespaces(array(
                'Multiple\Backend\Controllers' => '../apps/backend/controllers/',
                'Multiple\Backend\Models' => '../apps/backend/models/',
            ));

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
                $dispatcher->setDefaultNamespace("Multiple\Backend\Controllers\\");
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

A special boostrap file is required to load the a multi-module MVC architecture:

.. code-block:: php

    <?php

    $di = new \Phalcon\DI\FactoryDefault();

    //Specify routes for modules
    $di->set('router', function(){

        $router = new \Phalcon\Mvc\Router();

        $router->setDefaultModule("frontend");

        $router->add("/login", array(
            'module' => 'backend',
            'controller' => 'login',
            'action' => 'index',
        ));

        $router->add("/admin/products/:action", array(
            'module' => 'backend',
            'controller' => 'products',
            'action' => 1,
        ));

        $router->add("/products/:action", array(
            'module' => 'frontend',
            'controller' => 'products',
            'action' => 1,
        ));

        return $router;

    });

    //Register the installed modules
    $this->registerModules(array(
        'frontend' => array(
            'className' => 'Multiple\Frontend\Module',
            'path' => '../apps/frontend/Module.php'
        ),
        'backend' => array(
            'className' => 'Multiple\Backend\Module',
            'path' => '../apps/backend/Module.php'
        )
    ));

    try {
        $application = new \Phalcon\Mvc\Application();
        $application->setDI($di);
        echo $application->handle()->getContent();
    } catch(Phalcon\Exception $e){
        echo $e->getMessage();
    }

When :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` have modules registered, always is necessary that every matched route return a valid module. The modules registration have an associated class that allows to set up the module itself. Each module class definition must implement two methods: registerAutoloaders and registerServices.

Understanding the default behavior
----------------------------------
If you've been following the tutorials_ or have generated the code using Tools_, you may recognize the boostrap application like this:

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

You can of course not use :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` if you wish. The above example explains the work made by this component:

.. code-block:: php

    <?php

    //Request the services from the DI container
    $router = $di->getShared('router');
    $router->handle();

    $view = $di->getShared('view');

    $dispatcher = $di->getShared('dispatcher');

    //Pass the proccessed router parameters to the dispatcher
    $dispatcher->setControllerName($router->getControllerName());
    $dispatcher->setActionName($router->getActionName());
    $dispatcher->setParams($router->getParams());

    //Start the view
    $view->start();

    //Dispatch the request
    $dispatcher->dispatch();

    //Render the related views
    $view->render(
        $dispatcher->getControllerName(),
        $dispatcher->getActionName(),
        $dispatcher->getParams()
    );

    //Finish the view
    $view->finish();

    $response = $di->getShared('response');

    //Pass the output of the view to the response
    $response->setContent($view->getContent());

    //Send the request headers
    $response->sendHeaders();

    // Print the response
    echo $response->getContent();

As you can see the same operation can be done with fewer lines of code or with a more verbose way of coding. The above example might be preferred in cases where you need to have full control over the whole bootstrap process.

Application Events
------------------
:doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` is able to send events to a :doc:`EventsManager <events>` if it's present. Events are triggered using the type "application". The following events are supported:

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

The following example shows how to attach listeners to this component:

.. code-block:: php

    <?php

    $eventsManager = new Phalcon\Events\Manager();

    $application->setEventsManager($eventsManager);

    $eventsManager->attach("application", function($event, $application) {
        // ...
    });

.. _tutorials: tutorial
.. _Tools: tools