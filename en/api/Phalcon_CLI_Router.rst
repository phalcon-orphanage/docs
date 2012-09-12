Class **Phalcon\\CLI\\Router**
==============================

Phalcon\\CLI\\Router is the standard framework router. Routing is the process of taking a command-line arguments and decomposing it into parameters to determine which module, task, and action of that task should receive the request   

.. code-block:: php

    <?php

    $router = new Phalcon\CLI\Router();
    $router->handle(array());
    echo $router->getTaskName();



Methods
---------

public **__construct** ()

...


public **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector)

Sets the dependency injector



:doc:`Phalcon\\DI <Phalcon_DI>` public **getDI** ()

Returns the internal dependency injector



public **setDefaultModule** (*string* $moduleName)

Sets the name of the default module



public **setDefaultTask** (*unknown* $taskName)

Sets the default controller name



public **setDefaultAction** (*string* $actionName)

Sets the default action name



public **handle** ()

Handles routing information received from command-line arguments



*string* public **getModuleName** ()

Returns proccesed module name



*string* public **getTaskName** ()

Returns proccesed task name



*string* public **getActionName** ()

Returns proccesed action name



*array* public **getParams** ()

Returns proccesed extra params



