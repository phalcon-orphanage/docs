Dispatching Controllers
=======================


The Dispatch Loop
-----------------
This is another important process that has much to do with the MVC flow itself, especially with the controller part. The work occurs within the controller dispatcher. The controller files are read, loaded, instantiated, to then the required actions are executed. If an action forwards the flow to another controller/action, the controller dispatcher starts again. To better illustrate this, the following example shows approximately the process performed within :doc:`Phalcon\\Mvc\\Dispatcher <../api/Phalcon_Mvc_Dispatcher>`:

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

+----------------------+--------------------------------------------------------------+---------------------+
| Event Name           | Triggered                                                    | Can stop operation? |
+======================+==============================================================+=====================+
| beforeDispatchLoop   | Triggered before enter in the dispatch loop                  | Yes                 |
+----------------------+--------------------------------------------------------------+---------------------+
| beforeExecuteRoute   | Triggered before execute the controller/action method        | Yes                 |
+----------------------+--------------------------------------------------------------+---------------------+
| afterExecuteRoute    | Triggered after execute the controller/action method         | No                  |
+----------------------+--------------------------------------------------------------+---------------------+
| beforeNotFoundAction | Triggered when the action was not found in the controller    | Yes                 |
+----------------------+--------------------------------------------------------------+---------------------+
| afterDispatchLoop    | Triggered after exit the dispatch loop                       | No                  |
+----------------------+--------------------------------------------------------------+---------------------+

The :doc`INVO <tutorial-invo>` explanation shows how to take advantage of dispatching events implementing a security filter with :doc:`Acl <acl>`

