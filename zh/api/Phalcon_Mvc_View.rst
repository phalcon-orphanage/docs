Class **Phalcon\\Mvc\\View**
============================

*extends* :doc:`Phalcon\\DI\\Injectable <Phalcon_DI_Injectable>`

<<<<<<< HEAD
Phalcon\\Mvc\\View is a class for working with the "view" portion of the model-view-controller pattern. That is, it exists to help keep the view script separate from the model and controller scripts. It provides a system of helpers, output filters, and variable escaping. 
=======
*implements* :doc:`Phalcon\\Events\\EventsAwareInterface <Phalcon_Events_EventsAwareInterface>`, :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`, :doc:`Phalcon\\Mvc\\ViewInterface <Phalcon_Mvc_ViewInterface>`

Phalcon\\Mvc\\View is a class for working with the "view" portion of the model-view-controller pattern. That is, it exists to help keep the view script separate from the model and controller scripts. It provides a system of helpers, output filters, and variable escaping.  
>>>>>>> 0.7.0

.. code-block:: php

    <?php

     //Setting views directory
     $view = new Phalcon\Mvc\View();
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

Methods
---------

public  **__construct** (*array* $options)

Phalcon\\Mvc\\View constructor



public  **setViewsDir** (*string* $viewsDir)

Sets views directory. Depending of your platform, always add a trailing slash or backslash



public *string*  **getViewsDir** ()

Gets views directory



public  **setBasePath** (*string* $basePath)

Sets base path. Depending of your platform, always add a trailing slash or backslash 

.. code-block:: php

    <?php

     $view->setBasePath(__DIR__.'/');




public  **setRenderLevel** (*string* $level)

Sets the render level for the view 

.. code-block:: php

    <?php

     //Render the view related to the controller only
     $this->view->setRenderLevel(Phalcon\Mvc\View::LEVEL_VIEW);




public  **setMainView** (*unknown* $viewPath)

Sets default view name. Must be a file without extension in the views directory 

.. code-block:: php

    <?php

     //Renders as main view views-dir/inicio.phtml
     $this->view->setMainView('inicio');




public  **setTemplateBefore** (*string|array* $templateBefore)

Appends template before controller layout



public  **cleanTemplateBefore** ()

Resets any template before layouts



public  **setTemplateAfter** (*string|array* $templateAfter)

Appends template after controller layout



public  **cleanTemplateAfter** ()

Resets any template before layouts



public  **setParamToView** (*string* $key, *mixed* $value)

Adds parameters to views (alias of setVar)



public  **setVar** (*string* $key, *mixed* $value)

Adds parameters to views



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



protected *array*  **_loadTemplateEngines** ()

Loads registered template engines, if none is registered it will use Phalcon\\Mvc\\View\\Engine\\Php



protected  **_engineRender** ()

Checks whether view exists on registered extensions and render it



public  **registerEngines** (*array* $engines)

Register templating engines 

.. code-block:: php

    <?php

    $this->view->registerEngines(array(
      ".phtml" => "Phalcon\Mvc\View\Engine\Php",
      ".volt" => "Phalcon\Mvc\View\Engine\Volt",
      ".mhtml" => "MyCustomEngine"
    ));




public  **render** (*string* $controllerName, *string* $actionName, *array* $params)

Executes render process from dispatching data 

.. code-block:: php

    <?php

     $view->start();
     //Shows recent posts view (app/views/posts/recent.phtml)
     $view->render('posts', 'recent');
     $view->finish();




public  **pick** (*string* $renderView)

Choose a view different to render than last-controller/last-action 

.. code-block:: php

    <?php

     class ProductsController extends Phalcon\Mvc\Controller
     {
    
        public function saveAction()
        {
    
             //Do some save stuff...
    
             //Then show the list view
             $this->view->pick("products/list");
        }
     }




public *string*  **partial** (*string* $partialPath)

Renders a partial view 

.. code-block:: php

    <?php

     //Show a partial inside another view
     $this->partial('shared/footer');




public  **finish** ()

Finishes the render process by stopping the output buffering



<<<<<<< HEAD
protected :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`  **_createCache** ()
=======
protected :doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>`  **_createCache** ()
>>>>>>> 0.7.0

Create a Phalcon\\Cache based on the internal cache options



<<<<<<< HEAD
public :doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>`  **getCache** ()
=======
public :doc:`Phalcon\\Cache\\BackendInterface <Phalcon_Cache_BackendInterface>`  **getCache** ()
>>>>>>> 0.7.0

Returns the cache instance used to cache



public  **cache** (*boolean|array* $options)

Cache the actual view render to certain level



public  **setContent** (*string* $content)

Externally sets the view content 

.. code-block:: php

    <?php

    $this->view->setContent("<h1>hello</h1>");




public *string*  **getContent** ()

Returns cached ouput from another view stage



public *string*  **getActiveRenderPath** ()

Returns the path of the view that is currently rendered



public  **disable** ()

<<<<<<< HEAD
Disable view. Don't show any view or template



public  **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector) inherited from Phalcon\\DI\\Injectable
=======
Disables the auto-rendering process



public  **enable** ()

Enables the auto-rendering process



public  **reset** ()

Resets the view component to its factory default values



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector) inherited from Phalcon\\DI\\Injectable
>>>>>>> 0.7.0

Sets the dependency injector



<<<<<<< HEAD
public :doc:`Phalcon\\DI <Phalcon_DI>`  **getDI** () inherited from Phalcon\\DI\\Injectable
=======
public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** () inherited from Phalcon\\DI\\Injectable
>>>>>>> 0.7.0

Returns the internal dependency injector



<<<<<<< HEAD
public  **setEventsManager** (:doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>` $eventsManager) inherited from Phalcon\\DI\\Injectable
=======
public  **setEventsManager** (:doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>` $eventsManager) inherited from Phalcon\\DI\\Injectable
>>>>>>> 0.7.0

Sets the event manager



<<<<<<< HEAD
public :doc:`Phalcon\\Events\\Manager <Phalcon_Events_Manager>`  **getEventsManager** () inherited from Phalcon\\DI\\Injectable
=======
public :doc:`Phalcon\\Events\\ManagerInterface <Phalcon_Events_ManagerInterface>`  **getEventsManager** () inherited from Phalcon\\DI\\Injectable
>>>>>>> 0.7.0

Returns the internal event manager



public  **__get** (*string* $propertyName) inherited from Phalcon\\DI\\Injectable

Magic method __get



