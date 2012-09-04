Orchestrating MVC
=================
All the hard work behind orchestrating the operation of MVC in Phalcon is normally done by :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`. This component encapsulates all the complex operations behind instantiating every component needed and integrating it with the rest to allow the MVC pattern to operate as desired.

Understanding the default behavior
----------------------------------
If you've been following the tutorials_ or have generated the code using Tools, you may recognize the boostrap application like this:

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

Dispatch Loop
-------------
The Dispatch Loop is another important process that has much to do with the MVC flow itself, especially with the controller part. The work occurs within the controller dispatcher. The controller files are read, loaded, instantiated, to then the required actions are executed. If an action forwards the flow to another controller/action, the controller dispatcher starts again. To better illustrate this, the following example shows approximately the process performed within :doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>`:

.. code-block:: php

    <?php

    //Dispatch loop
    while (!$finished) {

        $finished = true;

        $controllerClass = \Phalcon\Text::camelize($controllerName) . "Controller";

        // Check if class is already loaded
        if (!class_exists($controllerClass)) {

            $controllerPath = $controllersDir . $controllerClass . ".php";

            if (file_exists($controllerPath)) {
                require $controllerPath;
            } else {
                throw new \Phalcon\Mvc\Dispatcher\Exception(
                    "File for controller class " . $controllerClass . " doesn't exist"
                );
            }

            if (!class_exists($controllerClass)) {
                throw new \Phalcon\Mvc\Dispatcher\Exception(
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
