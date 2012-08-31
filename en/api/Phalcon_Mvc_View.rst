Class **Phalcon\\Mvc\\View**
============================

*extends* :doc:`Phalcon\\Mvc\\User <Phalcon_Mvc_User>`

Phalcon\\Mvc\\View   Phalcon\\Mvc\\View is a class for working with the "view" portion of the model-view-controller pattern.  That is, it exists to help keep the view script separate from the model and controller scripts.  It provides a system of helpers, output filters, and variable escaping.   

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

integer **LEVEL_MAIN_LAYOUT**

integer **LEVEL_AFTER_TEMPLATE**

integer **LEVEL_LAYOUT**

integer **LEVEL_BEFORE_TEMPLATE**

integer **LEVEL_ACTION_VIEW**

integer **LEVEL_NO_RENDER**

Methods
---------

**__construct** (*array* **$options**)

**setViewsDir** (*string* **$viewsDir**)

*string* **getViewsDir** ()

**setBasePath** (*string* **$basePath**)

**setRenderLevel** (*string* **$level**)

**setMainView** (*unknown* **$viewPath**)

**setTemplateBefore** (*string|array* **$templateBefore**)

**cleanTemplateBefore** ()

**setTemplateAfter** (*string|array* **$templateAfter**)

**cleanTemplateAfter** ()

**setParamToView** (*string* **$key**, *mixed* **$value**)

**setVar** (*string* **$key**, *mixed* **$value**)

*array* **getParamsToView** ()

*string* **getControllerName** ()

*string* **getActionName** ()

**getParams** ()

**start** ()

*array* **_loadTemplateEngines** ()

**_engineRender** ()

**registerEngines** (*array* **$engines**)

**render** (*string* **$controllerName**, *string* **$actionName**, *array* **$params**)

**pick** (*string* **$renderView**)

**partial** (*string* **$partialPath**)

**finish** ()

:doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>` **_createCache** ()

:doc:`Phalcon\\Cache\\Backend <Phalcon_Cache_Backend>` **getCache** ()

**cache** (*boolean|array* **$options**)

**setContent** (*string* **$content**)

*string* **getContent** ()

**getActiveRenderPath** ()

**disable** ()

**setDI** (*unknown* **$dependencyInjector**)

**getDI** ()

**setEventsManager** (*unknown* **$eventsManager**)

**getEventsManager** ()

**__get** (*unknown* **$propertyName**)

