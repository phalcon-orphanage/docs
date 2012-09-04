Class **Phalcon\Mvc\View**
==========================

*extends* :doc:`Phalcon\\Mvc\\User <Phalcon_Mvc_User>`

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

public **__construct** (*unknown* $options)

public **setViewsDir** (*unknown* $viewsDir)

public **getViewsDir** ()

public **setBasePath** (*unknown* $basePath)

public **setRenderLevel** (*unknown* $level)

public **setMainView** (*unknown* $viewPath)

public **setTemplateBefore** (*unknown* $templateBefore)

public **cleanTemplateBefore** ()

public **setTemplateAfter** (*unknown* $templateAfter)

public **cleanTemplateAfter** ()

public **setParamToView** (*unknown* $key, *unknown* $value)

public **setVar** (*unknown* $key, *unknown* $value)

public **getParamsToView** ()

public **getControllerName** ()

public **getActionName** ()

public **getParams** ()

public **start** ()

protected **_loadTemplateEngines** ()

protected **_engineRender** ()

public **registerEngines** (*unknown* $engines)

public **render** (*unknown* $controllerName, *unknown* $actionName, *unknown* $params)

public **pick** (*unknown* $renderView)

public **partial** (*unknown* $partialPath)

public **finish** ()

protected **_createCache** ()

public **getCache** ()

public **cache** (*unknown* $options)

public **setContent** (*unknown* $content)

public **getContent** ()

public **getActiveRenderPath** ()

public **disable** ()

public **setDI** (*unknown* $dependencyInjector)

public **getDI** ()

public **setEventsManager** (*unknown* $eventsManager)

public **getEventsManager** ()

public **__get** (*unknown* $propertyName)

