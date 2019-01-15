* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Mvc\ViewInterface'

* * *

# Interface **Phalcon\Mvc\ViewInterface**

*implements* [Phalcon\Mvc\ViewBaseInterface](/4.0/en/api/Phalcon_Mvc_ViewBaseInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/mvc/viewinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>

## Methods

abstract public **setLayoutsDir** (*mixed* $layoutsDir)

...

abstract public **getLayoutsDir** ()

...

abstract public **setPartialsDir** (*mixed* $partialsDir)

...

abstract public **getPartialsDir** ()

...

abstract public **setBasePath** (*mixed* $basePath)

...

abstract public **getBasePath** ()

...

abstract public **setRenderLevel** (*mixed* $level)

...

abstract public **setMainView** (*mixed* $viewPath)

...

abstract public **getMainView** ()

...

abstract public **setLayout** (*mixed* $layout)

...

abstract public **getLayout** ()

...

abstract public **setTemplateBefore** (*mixed* $templateBefore)

...

abstract public **cleanTemplateBefore** ()

...

abstract public **setTemplateAfter** (*mixed* $templateAfter)

...

abstract public **cleanTemplateAfter** ()

...

abstract public **getControllerName** ()

...

abstract public **getActionName** ()

...

abstract public **getParams** ()

...

abstract public **start** ()

...

abstract public **registerEngines** (*array* $engines)

...

abstract public **render** (*mixed* $controllerName, *mixed* $actionName, [*mixed* $params])

...

abstract public **pick** (*mixed* $renderView)

...

abstract public **finish** ()

...

abstract public **getActiveRenderPath** ()

...

abstract public **disable** ()

...

abstract public **enable** ()

...

abstract public **reset** ()

...

abstract public **isDisabled** ()

...

abstract public **setViewsDir** (*mixed* $viewsDir) inherited from [Phalcon\Mvc\ViewBaseInterface](/4.0/en/api/Phalcon_Mvc_ViewBaseInterface)

...

abstract public **getViewsDir** () inherited from [Phalcon\Mvc\ViewBaseInterface](/4.0/en/api/Phalcon_Mvc_ViewBaseInterface)

...

abstract public **setParamToView** (*mixed* $key, *mixed* $value) inherited from [Phalcon\Mvc\ViewBaseInterface](/4.0/en/api/Phalcon_Mvc_ViewBaseInterface)

...

abstract public **setVar** (*mixed* $key, *mixed* $value) inherited from [Phalcon\Mvc\ViewBaseInterface](/4.0/en/api/Phalcon_Mvc_ViewBaseInterface)

...

abstract public **getParamsToView** () inherited from [Phalcon\Mvc\ViewBaseInterface](/4.0/en/api/Phalcon_Mvc_ViewBaseInterface)

...

abstract public **getCache** () inherited from [Phalcon\Mvc\ViewBaseInterface](/4.0/en/api/Phalcon_Mvc_ViewBaseInterface)

...

abstract public **cache** ([*mixed* $options]) inherited from [Phalcon\Mvc\ViewBaseInterface](/4.0/en/api/Phalcon_Mvc_ViewBaseInterface)

...

abstract public **setContent** (*mixed* $content) inherited from [Phalcon\Mvc\ViewBaseInterface](/4.0/en/api/Phalcon_Mvc_ViewBaseInterface)

...

abstract public **getContent** () inherited from [Phalcon\Mvc\ViewBaseInterface](/4.0/en/api/Phalcon_Mvc_ViewBaseInterface)

...

abstract public **partial** (*mixed* $partialPath, [*mixed* $params]) inherited from [Phalcon\Mvc\ViewBaseInterface](/4.0/en/api/Phalcon_Mvc_ViewBaseInterface)

...