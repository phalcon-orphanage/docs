Dispatching Controllers
=======================
:doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>` is the component responsible of instantiate controllers and execute the required actions on them in an MVC application. Understand its operation and capabilities helps us get more out of the services provided by the framework.

The Dispatch Loop
-----------------
This is an important process that has much to do with the MVC flow itself, especially with the controller part. The work occurs within the controller dispatcher. The controller files are read, loaded, instantiated, to then the required actions are executed. If an action forwards the flow to another controller/action, the controller dispatcher starts again. To better illustrate this, the following example shows approximately the process performed within :doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>`:

.. code-block:: php

    <?php

    //Dispatch loop
    while (!$finished) {

        $finished = true;

        $controllerClass = $controllerName."Controller";

        //Instantiating the controller class via autoloaders
        $controller = new $controllerClass();

        // Execute the action
        call_user_func_array(array($controller, $actionName . "Action"), $params);

        // Finished should be reloaded to check if the flow was forwarded to another controller
        // $finished = false;

    }

The code above lacks validations, filters and additional checks, but it demonstrates the normal flow of operation in the dispatcher.

Dispatch Loop Events
^^^^^^^^^^^^^^^^^^^^
:doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>` is able to send events to a :doc:`EventsManager <events>` if it's present. Events are triggered using the type "dispatch". Some events when returning boolean false could stop the active operation. The following events are supported:

+----------------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+
| Event Name           | Triggered                                                                                                                                                                                                   | Can stop operation? |
+======================+=============================================================================================================================================================================================================+=====================+
| beforeDispatchLoop   | Triggered before enter in the dispatch loop. At this point the dispatcher don't know if the controller or the actions to be executed exist. The Dispatcher only knows the information passed by the Router. | Yes                 |
+----------------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+
| beforeExecuteRoute   | Triggered before execute the controller/action method. At this point the dispatcher has been initialized the controller and know if the action exist.                                                       | Yes                 |
+----------------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+
| afterExecuteRoute    | Triggered after execute the controller/action method. As operation cannot be stopped, only use this event to make clean up after execute the action                                                         | No                  |
+----------------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+
| beforeNotFoundAction | Triggered when the action was not found in the controller                                                                                                                                                   | Yes                 |
+----------------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+
| afterDispatchLoop    | Triggered after exit the dispatch loop                                                                                                                                                                      | No                  |
+----------------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+

The :doc:`INVO <tutorial-invo>` tutorial shows how to take advantage of dispatching events implementing a security filter with :doc:`Acl <acl>`

Forwarding to another actions
-----------------------------
The dispatch loop allow us to forward the execution flow to another controller/action. This is very useful to check if the user can access to certain options, redirect users to other screens or simply reuse code.

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function saveAction($year, $postTitle)
        {

            // .. store some product and forward the user

            // Forward flow to the index action
            $this->dispatcher->forward(array("controller" => "post", "action" => "index"));
        }

    }

Keep in mind that make a "forward" is not the same as making an HTTP redirect. Although they apparently got the same result.
The "forward" doesn't reloads the current page, all the redirection occurs in a single request, while the HTTP redirect needs two requests to complete the process.

Getting Parameters
------------------
When a route provides named parameters you can receive them in a controller, a view or any other component that extends :doc:`Phalcon\DI\Injectable <../api/Phalcon_DI_Injectable>`.

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\DI\Injectable
    {

        public function indexAction()
        {

        }

        public function saveAction()
        {

            // Get the post's title passed in the URL as parameter
            $title = $this->dispatcher->getParam("title");

            // Get the post's year passed in the URL as parameter
            // also filtering it
            $year = $this->dispatcher->getParam("year", "int");
        }

    }
