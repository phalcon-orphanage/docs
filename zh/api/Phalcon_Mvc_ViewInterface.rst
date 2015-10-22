Interface **Phalcon\\Mvc\\ViewInterface**
=========================================

*implements* :doc:`Phalcon\\Mvc\\ViewBaseInterface <Phalcon_Mvc_ViewBaseInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/viewinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Methods
-------

abstract public  **setLayoutsDir** (*unknown* $layoutsDir)

...


abstract public  **getLayoutsDir** ()

...


abstract public  **setPartialsDir** (*unknown* $partialsDir)

...


abstract public  **getPartialsDir** ()

...


abstract public  **setBasePath** (*unknown* $basePath)

...


abstract public  **getBasePath** ()

...


abstract public  **setRenderLevel** (*unknown* $level)

...


abstract public  **setMainView** (*unknown* $viewPath)

...


abstract public  **getMainView** ()

...


abstract public  **setLayout** (*unknown* $layout)

...


abstract public  **getLayout** ()

...


abstract public  **setTemplateBefore** (*unknown* $templateBefore)

...


abstract public  **cleanTemplateBefore** ()

...


abstract public  **setTemplateAfter** (*unknown* $templateAfter)

...


abstract public  **cleanTemplateAfter** ()

...


abstract public  **getControllerName** ()

...


abstract public  **getActionName** ()

...


abstract public  **getParams** ()

...


abstract public  **start** ()

...


abstract public  **registerEngines** (*unknown* $engines)

...


abstract public  **render** (*unknown* $controllerName, *unknown* $actionName, [*unknown* $params])

...


abstract public  **pick** (*unknown* $renderView)

...


abstract public  **finish** ()

...


abstract public  **getActiveRenderPath** ()

...


abstract public  **disable** ()

...


abstract public  **enable** ()

...


abstract public  **reset** ()

...


abstract public  **isDisabled** ()

...


abstract public  **setViewsDir** (*unknown* $viewsDir) inherited from Phalcon\\Mvc\\ViewBaseInterface

...


abstract public  **getViewsDir** () inherited from Phalcon\\Mvc\\ViewBaseInterface

...


abstract public  **setParamToView** (*unknown* $key, *unknown* $value) inherited from Phalcon\\Mvc\\ViewBaseInterface

...


abstract public  **setVar** (*unknown* $key, *unknown* $value) inherited from Phalcon\\Mvc\\ViewBaseInterface

...


abstract public  **getParamsToView** () inherited from Phalcon\\Mvc\\ViewBaseInterface

...


abstract public  **getCache** () inherited from Phalcon\\Mvc\\ViewBaseInterface

...


abstract public  **cache** ([*unknown* $options]) inherited from Phalcon\\Mvc\\ViewBaseInterface

...


abstract public  **setContent** (*unknown* $content) inherited from Phalcon\\Mvc\\ViewBaseInterface

...


abstract public  **getContent** () inherited from Phalcon\\Mvc\\ViewBaseInterface

...


abstract public  **partial** (*unknown* $partialPath, [*unknown* $params]) inherited from Phalcon\\Mvc\\ViewBaseInterface

...


