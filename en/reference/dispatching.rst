

Orchestrating MVC
=================
All the hard work behind orchestrating the operation of MVC in Phalcon is normally done by. This component encapsulatesall the dirty details of instantiate every component to then integrate it with each others making the MVC pattern work as desired. 

Understanding the default behavior
----------------------------------
If you've been following the tutorials or have generated the code using Tools,you may recognize the boostrap application like this: 

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

The main point of all the work occurs in the method dispatchLoop:

.. code-block:: php

    <?php

    echo $front->dispatchLoop()->getContent();

Internally and based on the config set, Phalcon_Controller_Front performs the following steps to complete a request:

- Checks if a request instance has been previously set, otherwise, instantiate a Phalcon_Request object
- Checks if a response instance has been previously set, otherwise, instantiate a Phalcon_Response object
- Checks if a dispatcher instance has been set, otherwise, instantiate a Phalcon_Dispatcher object. This object receives the controllersDir option set by config.
- Checks if a router instance has been set, otherwise, instantiate a Phalcon_Router_Rewrite object. By default the router will handle the URI placed at $_GET['_url']
- Starts the view component. This enable output buffering by calling internally the function ob_start
- The processed controller/action/parameters by the router is passed to the dispatcher.
- The dispatcher locate the selected controller in the controllers directory, instantiating it, executing the action passing the routing parameters to it
- The view takes the last controller/action executed and renders the related views
- The view is stoped returning all the content buffered
- This content is passed to the response object

Let's say if Phalcon_Controller_Front had never existed or just want more control over the process.The following PHP code is necessary to do the same stuff: 

.. code-block:: php

    <?php
    
    //Read the config
    $config = new Phalcon_Config_Adapter_Ini("app/config/config.ini");
    
    //Instantiate a router
    $router = new Phalcon_Router_Regex();
    
    //Handle URI data
    $router->handle();
    
    //Instantiate both request and response objects
    $request = Phalcon_Request::getInstance();
    $response = Phalcon_Response::getInstance();
    
    //Instantiate View component setting views directory
    $view = new Phalcon_View();
    $view->setBasePath($basePath);
    $view->setViewsDir($config->phalcon->viewsDir);
    
    //Instantiate Model Manager component setting models directory
    $modelManager = new Phalcon_Model_Manager();
    $modelManager->setBasePath($basePath);
    $modelManager->setModelsDir($config->phalcon->modelsDir);
    
    //Starts the view, also enabling output buffering
    $view->start();
    
    //Instantiate a Dispatcher passing the proccesed parameters to it
    $dispatcher = new Phalcon_Dispatcher();
    $dispatcher->setControllersDir($config->phalcon->controllersDir);
    $dispatcher->setBasePath($basePath);
    $dispatcher->setControllerName($router->getControllerName());
    $dispatcher->setActionName($router->getActionName());
    $dispatcher->setParams($router->getParams());
    
    //Run the dispatch loop
    $dispatcher->dispatch($request, $response, $view, $modelManager);
    
    //Takes the last controller/action and render its related views
    $view->render($dispatcher->getControllerName(), $dispatcher->getActionName(), $dispatcher->getParams());
    $view->finish();
    
    //Pass the buffered content to the response
    $response->setContent($view->getContent());
    
    //Print out the response
    echo $response->getContent();

Actually, you could use the above code as your default bootstrap giving you more control overthe execution with almost the same result. 

Dispatch Loop
-------------
The Dispatch Loop is another important process that has much to do with the MVC flow itself, especially with the controller part.This work occurs within the controller dispatcher. The controller files are read, loaded, instantiated, to then execute the required actions. If some action request forward the flow to another controller/action the process start again. To ilustrate better, in plain PHP, approximately this process is performed within :

.. code-block:: php

    <?php
    
    //Dispatch loop
    while(!$finished){
    
       $finished = true;
    
       $controllerClass = Phalcon_Text::camelize($controllerName)."Controller";
    
       //Check if class is already loaded
       if(!class_exists($controllerClass)){
    
          $controllerPath = $controllersDir.$controllerClass.".php";
    
          if (file_exists($controllerPath)) {
             require $controllerPath;
          } else {
             throw new Phalcon_Dispatcher_Exception("File for controller class ".$controllerClass." doesn't exist");
          }
    
          if(!class_exists($controllerClass)){
            throw new Phalcon_Dispatcher_Exception("Class ".$controllerClass." was not found on controller file");
          }
    
       }
    
       //Instantiate the controller passing request/response/view/model-manager objects
       $controller = new $controllerClass(null, $request, $response, $view, $model);
    
       //Execute the action
       call_user_func_array(array($controller, $actionName."Action"), $params);
    
       //Finished should be reloaded to check if the flow was forwarded to another controller
       //$finished = false;
    
    }

Anyway, the previous code lacks of many validations, filters and other things to make the example more concise.