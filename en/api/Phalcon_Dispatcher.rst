Class **Phalcon_Dispatcher**
============================

Dispatching is the process of taking the request object, extracting the module name, controller name, action name, and optional parameters contained in it, and then instantiating a controller and calling the relevant action of that controller.   

.. code-block:: php

    <?php
    
    
    $dispatcher = new Phalcon_Dispatcher();
    
    $request  = Phalcon_Request::getInstance();
    $response = Phalcon_Response::getInstance();
    
    $dispatcher->setBasePath('./');
    $dispatcher->setControllersDir('tests/controllers/');
    
    $dispatcher->setControllerName('posts');
    $dispatcher->setActionName('index');
    $dispatcher->setParams(array());

    $controller = $dispatcher->dispatch($request, $response);

Methods
---------

**setControllersDir** (string $controllersDir)

Sets default controllers directory. Depending of your platform, always add a trailing slash or backslash

**string** **getControllersDir** ()

Gets active controllers directory

**setBasePath** (string $basePath)

Sets base path for controllers folder. Depending of your platform, always add a trailing slash or backslash

**string** **getBasePath** ()

Gets base path for controllers folder

**setDefaultController** (string $controllerName)

Sets the default controller name

**setDefaultAction** (string $actionName)

Sets the default action name

**setControllerName** (string $controllerName)

Sets the controller name to be dispatched

**string** **getControllerName** ()

Gets last dispatched controller name

**setActionName** (string $actionName)

Sets the action name to be dispatched

**string** **getActionName** ()

Gets last dispatched action name

**setParams** (array $params)

Sets action params to be dispatched

**array** **getParams** ()

Gets action params

**setParam** (mixed $param, mixed $value)

Set a param by its name or numeric index

**mixed** **getParam** (mixed $param)

Gets a param by its name or numeric index

**Phalcon_Controller** **dispatch** (Phalcon_Request $request, Phalcon_Response $response, Phalcon_View $view, Phalcon_Model_Manager $model)

Dispatches a controller action taking into account the routing parameters

**_throwDispatchException** (Phalcon_Response $response, string $message)

Throws an internal exception

**forward** (string $uri)

Routes to a controller/action using a string or array uri

**boolean** **isFinished** ()

Checks if the dispatch loop is finished or have more pendent controller to disptach

**array** **getControllers** ()

Returns all instantiated controllers whitin the dispatcher

**Phalcon_Controller** **getLastController** ()

Returns the last dispatched controller

**mixed** **getReturnedValue** ()

Returns value returned by the last dispatched action

