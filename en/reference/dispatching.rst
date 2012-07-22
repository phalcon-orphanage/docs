Orchestrating MVC
=================
All the hard work behind orchestrating the operation of MVC in Phalcon is normally done by :doc:`Phalcon_Controller_Front <../api/Phalcon_Controller_Front>`. This component encapsulates all the complex operations behind instantiating every component needed and integrating it with the rest to allow the MVC pattern to operate as desired. 

Understanding the default behavior
----------------------------------
If you've been following the tutorials_ or have generated the code using Tools, you may recognize the boostrap application like this: 

.. code-block:: php

    <?php
    
    try {
    
        $front = Phalcon_Controller_Front::getInstance();
    
        $config = new Phalcon_Config_Adapter_Ini("../app/config/config.ini");
        $front->setConfig($config);
    
        echo $front->dispatchLoop()->getContent();
    
    } catch (Phalcon_Exception $e) {
        echo "PhalconException: ", $e->getMessage();
    }

The core of all the work of the controller occurs when dispatchLoop() is invoked:

.. code-block:: php

    <?php

    echo $front->dispatchLoop()->getContent();

Internally and based on the config set, :doc:`Phalcon_Controller_Front <../api/Phalcon_Controller_Front>` performs the following steps for a request:

- Checks if a request instance has been previously set, otherwise, instantiates a :doc:`Phalcon_Request <../api/Phalcon_Request>` object
- Checks if a response instance has been previously set, otherwise, instantiates a :doc:`Phalcon_Response <../api/Phalcon_Response>` object
- Checks if a dispatcher instance has been set, otherwise, instantiates a :doc:`Phalcon_Dispatcher <../api/Phalcon_Dispatcher>` object. This object receives the controllersDir option set by config.
- Checks if a router instance has been set, otherwise, instantiates a :doc:`Phalcon_Router_Rewrite <../api/Phalcon_Router_Rewrite>` object. By default the router will handle the URI placed at $_GET['_url']
- Starts the view component. This enables output buffering by calling internally the function ob_start
- The processed controller/action/parameters by the router is passed to the dispatcher.
- The dispatcher locates the selected controller in the controllers directory, instantiates it and executes the action, passing the routing parameters to it
- The view takes the last controller/action executed and renders the related views
- The view returns all the buffered content
- This content is passed to the response object

You can of course not use :doc:`Phalcon_Controller_Front <../api/Phalcon_Controller_Front>` if you wish. The above example becomes:

.. code-block:: php

    <?php
    
    // Read the config
    $config = new Phalcon_Config_Adapter_Ini("app/config/config.ini");
    
    // Instantiate a router
    $router = new Phalcon_Router_Regex();
    
    // Handle URI data
    $router->handle();
    
    // Instantiate both request and response objects
    $request  = Phalcon_Request::getInstance();
    $response = Phalcon_Response::getInstance();
    
    // Instantiate View component setting views directory
    $view = new Phalcon_View();
    $view->setBasePath($basePath);
    $view->setViewsDir($config->phalcon->viewsDir);
    
    // Instantiate Model Manager component setting models directory
    $modelManager = new Phalcon_Model_Manager();
    $modelManager->setBasePath($basePath);
    $modelManager->setModelsDir($config->phalcon->modelsDir);
    
    // Starts the view, also enabling output buffering
    $view->start();
    
    // Instantiate a Dispatcher passing the proccesed parameters to it
    $dispatcher = new Phalcon_Dispatcher();
    $dispatcher->setControllersDir($config->phalcon->controllersDir);
    $dispatcher->setBasePath($basePath);
    $dispatcher->setControllerName($router->getControllerName());
    $dispatcher->setActionName($router->getActionName());
    $dispatcher->setParams($router->getParams());
    
    // Run the dispatch loop
    $dispatcher->dispatch($request, $response, $view, $modelManager);
    
    // Takes the last controller/action and render its related views
    $view->render(
        $dispatcher->getControllerName(), 
        $dispatcher->getActionName(), 
        $dispatcher->getParams()
    );
    $view->finish();
    
    // Pass the buffered content to the response
    $response->setContent($view->getContent());
    
    // Print out the response
    echo $response->getContent();

As you can see the same operation can be done with fewer lines of code or with a more verbose way of coding. The above example might be preferred in cases where you need to have full control over the whole bootstrap process.

Dispatch Loop
-------------
The Dispatch Loop is another important process that has much to do with the MVC flow itself, especially with the controller part. The work occurs within the controller dispatcher. The controller files are read, loaded, instantiated, to then the required actions are executed. If an action forwards the flow to another controller/action, the controller dispatcher starts again. To better illustrate this, the following example shows approximately the process performed within :doc:`Phalcon_Dispatcher <../api/Phalcon_Dispatcher>`:

.. code-block:: php

    <?php
    
    //Dispatch loop
    while (!$finished) {
    
        $finished = true;

        $controllerClass = Phalcon_Text::camelize($controllerName) . "Controller";

        // Check if class is already loaded
        if (!class_exists($controllerClass)) {

            $controllerPath = $controllersDir . $controllerClass . ".php";

            if (file_exists($controllerPath)) {
                require $controllerPath;
            } else {
                throw new Phalcon_Dispatcher_Exception(
                    "File for controller class " . $controllerClass . " doesn't exist"
                );
            }

            if (!class_exists($controllerClass)) {
                throw new Phalcon_Dispatcher_Exception(
                    "Class " . $controllerClass . " was not found in the controller file"
                );
            }

        }

        // Instantiate the controller passing the 
        // request/response/view/model-manager objects
        $controller = new $controllerClass(null, $request, $response, $view, $model);

        // Execute the action
        call_user_func_array(array($controller, $actionName . "Action"), $params);

        // Finished should be reloaded to check if the flow was forwarded to another controller
        // $finished = false;
    
    }

The code above lacks validations, filters and additional checks, but it demonstrates the normal flow of operation in the dispatcher.

.. _tutorials: tutorial
