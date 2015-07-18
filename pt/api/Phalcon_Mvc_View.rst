Class **Phalcon\\Mvc\\View**
============================

*extends* abstract class :doc:`Phalcon\\Di\\Injectable <Phalcon_Di_Injectable>`

*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`, :doc:`Phalcon\\Mvc\\ViewInterface <Phalcon_Mvc_ViewInterface>`, :doc:`Phalcon\\Mvc\\ViewBaseInterface <Phalcon_Mvc_ViewBaseInterface>`

Phalcon\\Mvc\\View is a class for working with the "view" portion of the model-view-controller pattern. That is, it exists to help keep the view script separate from the model and controller scripts. It provides a system of helpers, output filters, and variable escaping.  

.. code-block:: php

    <?php

     //Setting views directory
     $view = new \Phalcon\Mvc\View();
     $view->setViewsDir('app/views/');
    
     $view->start();
     //Shows recent posts view (app/views/posts/recent.phtml)
     $view->render('posts', 'recent');
     $view->finish();
    
     //Printing views output
     echo $view->getContent();



Constants
---------

*integer* **LEVEL_MAIN_LAYOUT**

*integer* **LEVEL_AFTER_TEMPLATE**

*integer* **LEVEL_LAYOUT**

*integer* **LEVEL_BEFORE_TEMPLATE**

*integer* **LEVEL_ACTION_VIEW**

*integer* **LEVEL_NO_RENDER**

*integer* **CACHE_MODE_NONE**

*integer* **CACHE_MODE_INVERSE**

Methods
-------

public  **getRenderLevel** ()

...


public  **getCurrentRenderLevel** ()

...


public  **getRegisteredEngines** ()





public  **__construct** ([*array* $options])

Phalcon\\Mvc\\View constructor



public  **setViewsDir** (*unknown* $viewsDir)

Sets the views directory. Depending of your platform, always add a trailing slash or backslash



public  **getViewsDir** ()

Gets views directory



public  **setLayoutsDir** (*unknown* $layoutsDir)

Sets the layouts sub-directory. Must be a directory under the views directory. Depending of your platform, always add a trailing slash or backslash 

.. code-block:: php

    <?php

     $view->setLayoutsDir('../common/layouts/');




public  **getLayoutsDir** ()

Gets the current layouts sub-directory



public  **setPartialsDir** (*unknown* $partialsDir)

Sets a partials sub-directory. Must be a directory under the views directory. Depending of your platform, always add a trailing slash or backslash 

.. code-block:: php

    <?php

     $view->setPartialsDir('../common/partials/');




public  **getPartialsDir** ()

Gets the current partials sub-directory



public  **setBasePath** (*unknown* $basePath)

Sets base path. Depending of your platform, always add a trailing slash or backslash 

.. code-block:: php

    <?php

     	$view->setBasePath(__DIR__ . '/');




public  **getBasePath** ()

Gets base path



public  **setRenderLevel** (*unknown* $level)

Sets the render level for the view 

.. code-block:: php

    <?php

     	//Render the view related to the controller only
     	$this->view->setRenderLevel(View::LEVEL_VIEW);




public :doc:`Phalcon\\Mvc\\View <Phalcon_Mvc_View>`  **disableLevel** (*int|array* $level)

Disables a specific level of rendering 

.. code-block:: php

    <?php

     //Render all levels except ACTION level
     $this->view->disableLevel(View::LEVEL_ACTION_VIEW);




public  **setMainView** (*unknown* $viewPath)

Sets default view name. Must be a file without extension in the views directory 

.. code-block:: php

    <?php

     	//Renders as main view views-dir/base.phtml
     	$this->view->setMainView('base');




public  **getMainView** ()

Returns the name of the main view



public  **setLayout** (*unknown* $layout)

Change the layout to be used instead of using the name of the latest controller name 

.. code-block:: php

    <?php

     	$this->view->setLayout('main');




public  **getLayout** ()

Returns the name of the main view



public :doc:`Phalcon\\Mvc\\View <Phalcon_Mvc_View>`  **setTemplateBefore** (*string|array* $templateBefore)

Sets a template before the controller layout



public  **cleanTemplateBefore** ()

Resets any "template before" layouts



public :doc:`Phalcon\\Mvc\\View <Phalcon_Mvc_View>`  **setTemplateAfter** (*string|array* $templateAfter)

Sets a "template after" controller layout



public  **cleanTemplateAfter** ()

Resets any template before layouts



public :doc:`Phalcon\\Mvc\\View <Phalcon_Mvc_View>`  **setParamToView** (*string* $key, *mixed* $value)

Adds parameters to views (alias of setVar) 

.. code-block:: php

    <?php

    $this->view->setParamToView('products', $products);




public :doc:`Phalcon\\Mvc\\View <Phalcon_Mvc_View>`  **setVars** (*array* $params, [*boolean* $merge])

Set all the render params 

.. code-block:: php

    <?php

    $this->view->setVars(array('products' => $products));




public :doc:`Phalcon\\Mvc\\View <Phalcon_Mvc_View>`  **setVar** (*string* $key, *mixed* $value)

Set a single view parameter 

.. code-block:: php

    <?php

    $this->view->setVar('products', $products);




public *mixed*  **getVar** (*string* $key)

Returns a parameter previously set in the view



public *array*  **getParamsToView** ()

Returns parameters to views



public *string*  **getControllerName** ()

Gets the name of the controller rendered



public *string*  **getActionName** ()

Gets the name of the action rendered



public *array*  **getParams** ()

Gets extra parameters of the action rendered



public  **start** ()

Starts rendering process enabling the output buffering



protected  **_loadTemplateEngines** ()

Loads registered template engines, if none is registered it will use Phalcon\\Mvc\\View\\Engine\\Php



protected  **_engineRender** (*array* $engines, *string* $viewPath, *boolean* $silence, *boolean* $mustClean, [:doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>` $cache])

Checks whether view exists on registered extensions and render it



public  **registerEngines** (*unknown* $engines)

Register templating engines 

.. code-block:: php

    <?php

    $this->view->registerEngines(array(
      ".phtml" => "Phalcon\Mvc\View\Engine\Php",
      ".volt"  => "Phalcon\Mvc\View\Engine\Volt",
      ".mhtml" => "MyCustomEngine"
    ));




public  **exists** (*unknown* $view)

Checks whether view exists



public  **render** (*string* $controllerName, *string* $actionName, [*array* $params])

Executes render process from dispatching data 

.. code-block:: php

    <?php

     //Shows recent posts view (app/views/posts/recent.phtml)
     $view->start()->render('posts', 'recent')->finish();




public :doc:`Phalcon\\Mvc\\View <Phalcon_Mvc_View>`  **pick** (*string|array* $renderView)

Choose a different view to render instead of last-controller/last-action 

.. code-block:: php

    <?php

     class ProductsController extends \Phalcon\Mvc\Controller
     {
    
        public function saveAction()
        {
    
             //Do some save stuff...
    
             //Then show the list view
             $this->view->pick("products/list");
        }
     }




public *string*  **getPartial** (*string* $partialPath, [*array* $params])

Renders a partial view 

.. code-block:: php

    <?php

     	//Retrieve the contents of a partial
     	echo $this->getPartial('shared/footer');

.. code-block:: php

    <?php

     	//Retrieve the contents of a partial with arguments
     	echo $this->getPartial('shared/footer', array('content' => $html));




public  **partial** (*string* $partialPath, [*array* $params])

Renders a partial view 

.. code-block:: php

    <?php

     	//Show a partial inside another view
     	$this->partial('shared/footer');

.. code-block:: php

    <?php

     	//Show a partial inside another view with parameters
     	$this->partial('shared/footer', array('content' => $html));




public *string*  **getRender** (*string* $controllerName, *string* $actionName, [*array* $params], [*mixed* $configCallback])

Perform the automatic rendering returning the output as a string 

.. code-block:: php

    <?php

     	$template = $this->view->getRender('products', 'show', array('products' => $products));




public  **finish** ()

Finishes the render process by stopping the output buffering



protected  **_createCache** ()

Create a Phalcon\\Cache based on the internal cache options



public  **isCaching** ()

Check if the component is currently caching the output content



public  **getCache** ()

Returns the cache instance used to cache



public :doc:`Phalcon\\Mvc\\View <Phalcon_Mvc_View>`  **cache** ([*boolean|array* $options])

Cache the actual view render to certain level 

.. code-block:: php

    <?php

      $this->view->cache(array('key' => 'my-key', 'lifetime' => 86400));




public  **setContent** (*unknown* $content)

Externally sets the view content 

.. code-block:: php

    <?php

    $this->view->setContent("<h1>hello</h1>");




public  **getContent** ()

Returns cached output from another view stage



public  **getActiveRenderPath** ()

Returns the path of the view that is currently rendered



public  **disable** ()

Disables the auto-rendering process



public  **enable** ()

Enables the auto-rendering process



public  **reset** ()

Resets the view component to its factory default values



public  **__set** (*string* $key, *mixed* $value)

Magic method to pass variables to the views 

.. code-block:: php

    <?php

    $this->view->products = $products;




public *mixed*  **__get** (*string* $key)

Magic method to retrieve a variable passed to the view 

.. code-block:: php

    <?php

    echo $this->view->products;




public  **isDisabled** ()

Whether automatic rendering is enabled



public *boolean*  **__isset** (*string* $key)

Magic method to retrieve if a variable is set in the view 

.. code-block:: php

    <?php

      echo isset($this->view->products);




public  **setDI** (*unknown* $dependencyInjector) inherited from Phalcon\\Di\\Injectable

Sets the dependency injector



public  **getDI** () inherited from Phalcon\\Di\\Injectable

Returns the internal dependency injector



public  **setEventsManager** (*unknown* $eventsManager) inherited from Phalcon\\Di\\Injectable

Sets the event manager



public  **getEventsManager** () inherited from Phalcon\\Di\\Injectable

Returns the internal event manager



