Dispatching Controllers
=======================
:doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>` is the component responsible for instantiating controllers and executing the required actions
on them in an MVC application. Understanding its operation and capabilities helps us get more out of the services provided by the framework.

The Dispatch Loop
-----------------
This is an important process that has much to do with the MVC flow itself, especially with the controller part. The work occurs within the controller
dispatcher. The controller files are read, loaded, and instantiated. Then the required actions are executed. If an action forwards the flow to another
controller/action, the controller dispatcher starts again. To better illustrate this, the following example shows approximately the process performed
within :doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>`:

.. code-block:: php

    <?php

    //Dispatch loop
    while (!$finished) {

        $finished = true;

        $controllerClass = $controllerName . "Controller";

        //Instantiating the controller class via autoloaders
        $controller = new $controllerClass();

        // Execute the action
        call_user_func_array(array($controller, $actionName . "Action"), $params);

        // '$finished' should be reloaded to check if the flow
        // was forwarded to another controller
        $finished = true;
    }

The code above lacks validations, filters and additional checks, but it demonstrates the normal flow of operation in the dispatcher.

Dispatch Loop Events
^^^^^^^^^^^^^^^^^^^^
:doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>` is able to send events to an :doc:`EventsManager <events>` if it is present. Events are triggered using the type "dispatch". Some events when returning boolean false could stop the active operation. The following events are supported:

+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+
| Event Name           | Triggered                                                                                                                                                                                                      | Can stop operation? |
+======================+================================================================================================================================================================================================================+=====================+
| beforeDispatchLoop   | Triggered before entering in the dispatch loop. At this point the dispatcher don't know if the controller or the actions to be executed exist. The Dispatcher only knows the information passed by the Router. | Yes                 |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+
| beforeDispatch       | Triggered after entering in the dispatch loop. At this point the dispatcher don't know if the controller or the actions to be executed exist. The Dispatcher only knows the information passed by the Router.  | Yes                 |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+
| beforeExecuteRoute   | Triggered before executing the controller/action method. At this point the dispatcher has been initialized the controller and know if the action exist.                                                        | Yes                 |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+
| afterExecuteRoute    | Triggered after executing the controller/action method. As operation cannot be stopped, only use this event to make clean up after execute the action                                                          | No                  |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+
| beforeNotFoundAction | Triggered when the action was not found in the controller                                                                                                                                                      | Yes                 |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+
| beforeException      | Triggered before the dispatcher throws any exception                                                                                                                                                           | Yes                 |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+
| afterDispatch        | Triggered after executing the controller/action method. As operation cannot be stopped, only use this event to make clean up after execute the action                                                          | Yes                 |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+
| afterDispatchLoop    | Triggered after exiting the dispatch loop                                                                                                                                                                      | No                  |
+----------------------+----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+---------------------+

The :doc:`INVO <tutorial-invo>` tutorial shows how to take advantage of dispatching events implementing a security filter with :doc:`Acl <acl>`

The following example demonstrates how to attach listeners to this component:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Dispatcher as MvcDispatcher,
        Phalcon\Events\Manager as EventsManager;

    $di->set('dispatcher', function(){

        //Create an event manager
        $eventsManager = new EventsManager();

        //Attach a listener for type "dispatch"
        $eventsManager->attach("dispatch", function($event, $dispatcher) {
            //...
        });

        $dispatcher = new MvcDispatcher();

        //Bind the eventsManager to the view component
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;

    }, true);

An instantiated controller automatically acts as a listener for dispatch events, so you can implement methods as callbacks:

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function beforeExecuteRoute($dispatcher)
        {
            // Executed before every found action
        }

        public function afterExecuteRoute($dispatcher)
        {
            // Executed after every found action
        }

    }

Forwarding to other actions
---------------------------
The dispatch loop allows us to forward the execution flow to another controller/action. This is very useful to check if the user can
access to certain options, redirect users to other screens or simply reuse code.

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
            $this->dispatcher->forward(array(
                "controller" => "post",
                "action" => "index"
            ));
        }

    }

Keep in mind that making a "forward" is not the same as making an HTTP redirect. Although they apparently got the same result.
The "forward" doesn't reload the current page, all the redirection occurs in a single request, while the HTTP redirect needs two requests
to complete the process.

More forwarding examples:

.. code-block:: php

    <?php

    // Forward flow to another action in the current controller
    $this->dispatcher->forward(array(
        "action" => "search"
    ));

    // Forward flow to another action in the current controller
    // passing parameters
    $this->dispatcher->forward(array(
        "action" => "search",
        "params" => array(1, 2, 3)
    ));


A forward action accepts the following parameters:

+----------------+--------------------------------------------------------+
| Parameter      | Triggered                                              |
+================+========================================================+
| controller     | A valid controller name to forward to.                 |
+----------------+--------------------------------------------------------+
| action         | A valid action name to forward to.                     |
+----------------+--------------------------------------------------------+
| params         | An array of parameters for the action                  |
+----------------+--------------------------------------------------------+
| namespace      | A valid namespace name where the controller is part of |
+----------------+--------------------------------------------------------+

Getting Parameters
------------------
When a route provides named parameters you can receive them in a controller, a view or any other component that extends
:doc:`Phalcon\\DI\\Injectable <../api/Phalcon_DI_Injectable>`.

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
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

Handling Not-Found Exceptions
-----------------------------
Using the :doc:`EventsManager <events>` it's possible to insert a hook point before the dispatcher throws an exception
when the controller/action combination wasn't found:

.. code-block:: php

    <?php

    use Phalcon\Dispatcher,
        Phalcon\Mvc\Dispatcher as MvcDispatcher,
        Phalcon\Events\Manager as EventsManager;

    $di->set('dispatcher', function() {

        //Create an EventsManager
        $eventsManager = new EventsManager();

        //Attach a listener
        $eventsManager->attach("dispatch:beforeException", function($event, $dispatcher, $exception) {

            switch ($exception->getCode()) {
                case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                    $dispatcher->forward(array(
                        'controller' => 'index',
                        'action' => 'show404'
                    ));
                    return false;
                }
            }
        });

        $dispatcher = new MvcDispatcher();

        //Bind the EventsManager to the dispatcher
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;

    }, true);

Implementing your own Dispatcher
--------------------------------
The :doc:`Phalcon\\Mvc\\DispatcherInterface <../api/Phalcon_Mvc_DispatcherInterface>` interface must be implemented to create your own dispatcher
replacing the one provided by Phalcon.
