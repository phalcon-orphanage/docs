Class **Phalcon_Controller_Front**
==================================

Phalcon_Controller_Front implements a "Front Controller" pattern used in "Model-View-Controller" (MVC) applications.  Its purpose is to initialize the request environment, route the incoming request, and then dispatch  any discovered actions; it aggregates any responses and returns them when the process is complete  

.. code-block:: php

    <?php

    try {
    
      $front = Phalcon_Controller_Front::getInstance();
    
    //Setting directories
      $front->setControllersDir("../app/controllers/");
      $front->setModelsDir("../app/models/");
      $front->setViewsDir("../app/views/");
    
    //Get response
      $response = $front->dispatchLoop();
    
      echo $response->send();
    
     }
     catch(Phalcon_Exception $e){
      echo "PhalconException: ", $e->getMessage();
     }

Methods
---------

**setConfig** (stdClass $config)

Modifies multiple general settings using a Phalcon_Config object or a stdClass filled with parameters  

.. code-block:: php

    <?php

    $config = new Phalcon_Config(array(
      "database" => array(
        "adapter" => "Mysql",
        "host" => "localhost",
        "username" => "scott",
        "password" => "cheetah",
        "name" => "test_db"
      ),
      "phalcon" => array(
        "controllersDir" => "../app/controllers/",
        "modelsDir" => "../app/models/",
        "viewsDir" => "../app/views/"
      )
     ));
     $front->setConfig($config);





**setDatabaseConfig** (stdClass $database)

Sets the database default settings

**setControllersDir** (string $controllersDir)

Sets controllers directory. Depending of your platform, always add a trailing slash or backslash  

.. code-block:: php

    <?php  $front->setControllersDir("../app/controllers/"); 





**setModelsDir** (string $modelsDir)

Sets models directory. Depending of your platform, always add a trailing slash or backslash  

.. code-block:: php

    <?php  $front->setModelsDir("../app/models/"); 





**setViewsDir** (string $viewsDir)

Sets views directory. Depending of your platform, always add a trailing slash or backslash  

.. code-block:: php

    <?php  $front->setViewsDir("../app/views/"); 





**setRouter** (Phalcon_Router $router)

Replaces the default router with a predefined object  

.. code-block:: php

    <?php

     $router = new Phalcon_Router_Rewrite();
     $router->handle();
     $front->setRouter($router);





**Phalcon_Router** **getRouter** ()

Return active router

**setDispatcher** (Phalcon_Dispatcher $dispatcher)

Replaces the default dispatcher with a predefined object

**Phalcon_Dispatcher** **getDispatcher** ()

Return active Dispatcher

**setBaseUri** (string $baseUri)

Sets external uri which app is executed

**string** **getBaseUri** ()

Gets external uri where app is executed

**setBasePath** (string $basePath)

Sets local path where app/ directory is located. Depending of your platform, always add a trailing slash or backslash

**string** **getBasePath** ()

Gets local path where app/ directory is located

**setRequest** (Phalcon_Request $request)

Overwrites request object default object

**setResponse** (Phalcon_Response $response)

Overwrites response object default object

**setModelComponent** (Phalcon_Model_Manager $model)

Overwrites models manager default object

**Phalcon_Model_Manager** **getModelComponent** ()

Gets the models manager

**setViewComponent** (Phalcon_View $view)

Sets view component

**Phalcon_View** **getViewComponent** ()

Gets the views part manager

**Phalcon_View** **dispatchLoop** ()

Executes the dispatch loop

**Phalcon_Controller_Front** **getInstance** ()

Gets Phalcon_Controller_Front singleton instance

**reset** ()

Resets the internal singleton

