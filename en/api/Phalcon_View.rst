Class **Phalcon_View**
======================

Phalcon_View is a class offering access to the "view" portion of the model-view-controller pattern. That is, it exists to help keep the view script separate from the model and controller scripts. It provides a system of helpers, output filters, and variable escaping.

.. code-block:: php

    <?php

    
    // Setting views directory
     $view = new Phalcon_View();
     $view->setViewsDir('app/views/');
    
     $view->start();

     // Shows recent posts view (app/views/posts/recent.phtml)
     $view->render('posts', 'recent');
     $view->finish();
    
    // Printing views output
     echo $view->getContent();

Constants
---------

integer **LEVEL_MAIN_LAYOUT**

integer **LEVEL_AFTER_TEMPLATE**

integer **LEVEL_LAYOUT**

integer **LEVEL_BEFORE_TEMPLATE**

integer **LEVEL_ACTION_VIEW**

integer **LEVEL_NO_RENDER**

Methods
---------

**__construct** (Phalcon_Config|stClass $options)

Phalcon_View constructor

**setViewsDir** (string $viewsDir)

Sets views directory. Depending of your platform, always add a trailing slash or backslash

**string** **getViewsDir** ()

Gets views directory

**setBasePath** (string $basePath)

Sets base path. Depending of your platform, always add a trailing slash or backslash  

.. code-block:: php

    <?php
    
    $view->setBasePath(__DIR__.'/');
     

**setRenderLevel** (string $level)

Sets the render level for the view  

.. code-block:: php

    <?php

    // Render the view related to the controller only
    $this->view->setRenderLevel(Phalcon_View::LEVEL_VIEW);
     

**setMainView** (unknown $viewPath)

Sets default view name. Must be a file without extension in the views directory  

.. code-block:: php

    <?php

    // Renders as main view views-dir/start.phtml
    $this->view->setMainView('start');
     

**setTemplateBefore** (string|array $templateBefore)

Appends template before controller layout

**cleanTemplateBefore** ()

Resets any template before layouts

**setTemplateAfter** (string|array $templateAfter)

Appends template after controller layout

**cleanTemplateAfter** ()

Resets any template before layouts

**setParamToView** (string $key, mixed $value)

Adds parameters to views (alias of setVar)

**setVar** (string $key, mixed $value)

Adds parameters to views

**array** **getParamsToView** ()

Returns parameters to views

**string** **getControllerName** ()

Gets the name of the controller rendered

**string** **getActionName** ()

Gets the name of the action rendered

**getParams** ()

Gets extra parameters of the action rendered

**start** ()

Starts rendering process enabling the output buffering

**array** **_loadTemplateEngines** ()

Loads registered template engines, if none is registered use Phalcon_View_Engine_Php

**_engineRender** (array $engines, string $viewPath, boolean $silence, Phalcon_Cache $cache)

Checks whether view exists on registered extensions and render it

**registerEngines** (array $engines)

Register templating engines 

.. code-block:: php

    <?php
    
    $this->view->registerEngines(
        array(
            ".phtml" => "Php",
            ".mhtml" => "Mustache"
        )
    );
    
**render** (string $controllerName, string $actionName, array $params)

Executes render process from request data 

.. code-block:: php

    <?php
    
    $view->start();
    
    //Shows recent posts view (app/views/posts/recent.phtml)
    $view->render('posts', 'recent');
    $view->finish();
    
**pick** (string $renderView)

Choose a view different to render than last-controller/last-action  

.. code-block:: php

    <?php
    
    class ProductsController extends Phalcon_Controller
    {
        function saveAction()
        {
            // Do some save related stuff...

            // Then show the list view
            $this->view->pick("products/list");
        }
    }
     
**partial** (string $partialPath)

Renders a partial view  

.. code-block:: php

    <?php
    
    // Show a partial inside another view
    $this->partial('shared/footer');
     
**finish** ()

Finishes the render process by stopping the output buffering

**setCache** (Phalcon_Cache_Backend|object $cache)

Set the cache object or cache parameters to do the resultset caching

**Phalcon_Cache** **_createCache** ()

Create a Phalcon_Cache based on the internal cache options

**Phalcon_Cache** **getCache** ()

Returns the cache instance used to cache

**cache** (boolean|array $options)

Cache the actual view render to certain level

**setContent** (string $content)

Externally sets the view content 

.. code-block:: php

    <?php 

    $this->view->setContent("<h1>hello</h1>");

**string** **getContent** ()

Returns cached ouput from another view stage

**disable** ()

Disable view. No show any view or template

