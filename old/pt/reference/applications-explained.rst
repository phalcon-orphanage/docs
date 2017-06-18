Understanding How Phalcon Applications Work
===========================================

If you've been following the :doc:`tutorial <tutorial>` or have generated the code using :doc:`Phalcon Devtools <tools>`,
you may recognize the following bootstrap file:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Application;

    // Register autoloaders
    // ...

    // Register services
    // ...

    // Handle the request
    $application = new Application($di);

    try {
        $response = $application->handle();

        $response->send();
    } catch (\Exception $e) {
        echo "Exception: ", $e->getMessage();
    }

The core of all the work of the controller occurs when handle() is invoked:

.. code-block:: php

    <?php

    $response = $application->handle();

Manual bootstrapping
--------------------
If you do not wish to use :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`, the code above can be changed as follows:

.. code-block:: php

    <?php

    // Get the 'router' service
    $router = $di["router"];

    $router->handle();

    $view = $di["view"];

    $dispatcher = $di["dispatcher"];

    // Pass the processed router parameters to the dispatcher

    $dispatcher->setControllerName(
        $router->getControllerName()
    );

    $dispatcher->setActionName(
        $router->getActionName()
    );

    $dispatcher->setParams(
        $router->getParams()
    );

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

    $response = $di["response"];

    // Pass the output of the view to the response
    $response->setContent(
        $view->getContent()
    );

    // Send the response
    $response->send();

The following replacement of :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>` lacks of a view component making it suitable for Rest APIs:

.. code-block:: php

    <?php

    use Phalcon\Http\ResponseInterface;

    // Get the 'router' service
    $router = $di["router"];

    $router->handle();

    $dispatcher = $di["dispatcher"];

    // Pass the processed router parameters to the dispatcher

    $dispatcher->setControllerName(
        $router->getControllerName()
    );

    $dispatcher->setActionName(
        $router->getActionName()
    );

    $dispatcher->setParams(
        $router->getParams()
    );

    // Dispatch the request
    $dispatcher->dispatch();

    // Get the returned value by the last executed action
    $response = $dispatcher->getReturnedValue();

    // Check if the action returned is a 'response' object
    if ($response instanceof ResponseInterface) {
        // Send the response
        $response->send();
    }

Yet another alternative that catch exceptions produced in the dispatcher forwarding to other actions consequently:

.. code-block:: php

    <?php

    use Phalcon\Http\ResponseInterface;

    // Get the 'router' service
    $router = $di["router"];

    $router->handle();

    $dispatcher = $di["dispatcher"];

    // Pass the processed router parameters to the dispatcher

    $dispatcher->setControllerName(
        $router->getControllerName()
    );

    $dispatcher->setActionName(
        $router->getActionName()
    );

    $dispatcher->setParams(
        $router->getParams()
    );

    try {
        // Dispatch the request
        $dispatcher->dispatch();
    } catch (Exception $e) {
        // An exception has occurred, dispatch some controller/action aimed for that

        // Pass the processed router parameters to the dispatcher
        $dispatcher->setControllerName("errors");
        $dispatcher->setActionName("action503");

        // Dispatch the request
        $dispatcher->dispatch();
    }

    // Get the returned value by the last executed action
    $response = $dispatcher->getReturnedValue();

    // Check if the action returned is a 'response' object
    if ($response instanceof ResponseInterface) {
        // Send the response
        $response->send();
    }

Although the above implementations are a lot more verbose than the code needed while using :doc:`Phalcon\\Mvc\\Application <../api/Phalcon_Mvc_Application>`,
it offers an alternative in bootstrapping your application. Depending on your needs, you might want to have full control of what
should be instantiated or not, or replace certain components with those of your own to extend the default functionality.
