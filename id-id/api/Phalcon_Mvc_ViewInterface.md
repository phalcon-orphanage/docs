---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\ViewInterface'
---
# Interface **Phalcon\Mvc\ViewInterface**

*implements* [Phalcon\Mvc\ViewBaseInterface](Phalcon_Mvc_ViewBaseInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/viewinterface.zep)

## Metode

abstrak publik **setLayoutsDir** (*mixed* $layoutsDir)

...

abstrak publik **getLayoutsDir** ()

...

abstrak publik **setPartialsDir** (*mixed* $partialsDir)

...

abstrak publik **getPartialsDir** ()

...

abstrak umum **mengatur Jalan Dasar** (*campuran* $basePath)

...

abstrak umum **mendapatkan Jalan Dasar** ()

...

abstrak publik **setRenderLevel** (*mixed* $level)

...

abstrak publik **setMainView** (*mixed* $viewPath)

...

abstrak publik **getMainView** ()

...

abstraj publik **setLayout** (*mixed* $layout)

...

abstrak publik **getLayout** ()

...

abstrak publik **setTemplateBefore** (*mixed* $templateBefore)

...

abstrak publik **cleanTemplateBefore** ()

...

abstrak publik **setTemplateAfter** (*mixed* $templateAfter)

...

abstrak publik **cleanTemplateAfter** ()

...

abstrak (umum **getControllerName**)

...

abstrak publik **getSchemaName** ()

...

abstrak publik **terakhirmendapatkankunci**()

...

abstrak publik 0 mulai 0

...

publik **mengaturatribut** (*array* $engines)

...

abstrak publik **api** (*campuran* $controllerName, *mixed* $actionName, [*mixed* $params])

...

abstrak publik **parse** (*dicampur* $renderView)

...

abstrak publik **isFinished** ()

...

abstrak umum **getActiveResource** ()

...

abstrak publik **isDelete** ()

...

abstrak publik **isDelete** ()

...

abstrak publik **reset** ()

...

abstrak publik **isDelete** ()

...

abstract public **setViewsDir** (*mixed* $viewsDir) inherited from [Phalcon\Mvc\ViewBaseInterface](Phalcon_Mvc_ViewBaseInterface)

...

abstract public **getViewsDir** () inherited from [Phalcon\Mvc\ViewBaseInterface](Phalcon_Mvc_ViewBaseInterface)

...

abstract public **setParamToView** (*mixed* $key, *mixed* $value) inherited from [Phalcon\Mvc\ViewBaseInterface](Phalcon_Mvc_ViewBaseInterface)

...

abstract public **setVar** (*mixed* $key, *mixed* $value) inherited from [Phalcon\Mvc\ViewBaseInterface](Phalcon_Mvc_ViewBaseInterface)

...

abstract public **getParamsToView** () inherited from [Phalcon\Mvc\ViewBaseInterface](Phalcon_Mvc_ViewBaseInterface)

...

abstract public **getCache** () inherited from [Phalcon\Mvc\ViewBaseInterface](Phalcon_Mvc_ViewBaseInterface)

...

abstract public **cache** ([*mixed* $options]) inherited from [Phalcon\Mvc\ViewBaseInterface](Phalcon_Mvc_ViewBaseInterface)

...

abstract public **setContent** (*mixed* $content) inherited from [Phalcon\Mvc\ViewBaseInterface](Phalcon_Mvc_ViewBaseInterface)

...

abstract public **getContent** () inherited from [Phalcon\Mvc\ViewBaseInterface](Phalcon_Mvc_ViewBaseInterface)

...

abstract public **partial** (*mixed* $partialPath, [*mixed* $params]) inherited from [Phalcon\Mvc\ViewBaseInterface](Phalcon_Mvc_ViewBaseInterface)

...