Class **Phalcon\\Mvc\\Dispatcher**
==================================

Phalcon\\Mvc\\Dispatcher   Dispatching is the process of taking the request object, extracting the module name,  controller name, action name, and optional parameters contained in it, and then  instantiating a controller and calling an action of that controller.   

.. code-block:: php

    <?php

    
    
    $di = new Phalcon\DI();
    
    $dispatcher = new Phalcon\Mvc\Dispatcher($di);
    
    $dispatcher->setControllerName('posts');
    $dispatcher->setActionName('index');
    $dispatcher->setParams(array());
    
    $controller = $dispatcher->dispatch();
    
    





Methods
---------

**__construct** ()

**setDI** (*Phalcon\DI* **$dependencyInjector**)

:doc:`Phalcon\\DI <Phalcon_DI>` **getDI** ()

**setEventsManager** (*Phalcon\Events\Manager* **$eventsManager**)

:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` **getEventsManager** ()

**setDefaultNamespace** (*string* **$namespace**)

**setDefaultController** (*string* **$controllerName**)

**setDefaultAction** (*string* **$actionName**)

**setControllerName** (*string* **$controllerName**)

*string* **getControllerName** ()

**setActionName** (*string* **$actionName**)

*string* **getActionName** ()

**setParams** (*array* **$params**)

*array* **getParams** ()

**setParam** (*mixed* **$param**, *mixed* **$value**)

*mixed* **getParam** (*mixed* **$param**)

:doc:`Phalcon\\Mvc\\Controller <Phalcon_Mvc_Controller>` **dispatch** ()

**_throwDispatchException** ()

**forward** (*array* **$forward**)

*boolean* **isFinished** ()

:doc:`Phalcon\\Mvc\\Controller <Phalcon_Mvc_Controller>` **getLastController** ()

*mixed* **getReturnedValue** ()

:doc:`Phalcon\\Mvc\\Controller <Phalcon_Mvc_Controller>` **getActiveController** ()

