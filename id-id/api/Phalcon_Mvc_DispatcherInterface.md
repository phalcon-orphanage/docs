---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Mvc\DispatcherInterface'
---
# Interface **Phalcon\Mvc\DispatcherInterface**

*implements* [Phalcon\DispatcherInterface](Phalcon_DispatcherInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/dispatcherinterface.zep)

## Metode

abstrak umum **setControllerSuffix** (*campuran* $controllerSuffix)

...

abstrak umum **setDefaultController** (*campuran* $controllerName)

...

abstrak umum **setControllerName** (*campuran* $controllerName)

...

abstrak (umum **getControllerName**)

...

abstrak (umum **getLastController**)

...

abstrak (umum **getActiveController**)

...

abstract public **setActionSuffix** (*mixed* $actionSuffix) inherited from [Phalcon\DispatcherInterface](Phalcon_DispatcherInterface)

...

abstract public **getActionSuffix** () inherited from [Phalcon\DispatcherInterface](Phalcon_DispatcherInterface)

...

abstract public **setDefaultNamespace** (*mixed* $defaultNamespace) inherited from [Phalcon\DispatcherInterface](Phalcon_DispatcherInterface)

...

abstract public **setDefaultAction** (*mixed* $actionName) inherited from [Phalcon\DispatcherInterface](Phalcon_DispatcherInterface)

...

abstract public **setNamespaceName** (*mixed* $namespaceName) inherited from [Phalcon\DispatcherInterface](Phalcon_DispatcherInterface)

...

abstract public **setModuleName** (*mixed* $moduleName) inherited from [Phalcon\DispatcherInterface](Phalcon_DispatcherInterface)

...

abstract public **setActionName** (*mixed* $actionName) inherited from [Phalcon\DispatcherInterface](Phalcon_DispatcherInterface)

...

abstract public **getActionName** () inherited from [Phalcon\DispatcherInterface](Phalcon_DispatcherInterface)

...

abstract public **setParams** (*mixed* $params) inherited from [Phalcon\DispatcherInterface](Phalcon_DispatcherInterface)

...

abstract public **getParams** () inherited from [Phalcon\DispatcherInterface](Phalcon_DispatcherInterface)

...

abstract public **setParam** (*mixed* $param, *mixed* $value) inherited from [Phalcon\DispatcherInterface](Phalcon_DispatcherInterface)

...

abstract public **getParam** (*mixed* $param, [*mixed* $filters]) inherited from [Phalcon\DispatcherInterface](Phalcon_DispatcherInterface)

...

abstract public **hasParam** (*mixed* $param) inherited from [Phalcon\DispatcherInterface](Phalcon_DispatcherInterface)

...

abstract public **isFinished** () inherited from [Phalcon\DispatcherInterface](Phalcon_DispatcherInterface)

...

abstract public **getReturnedValue** () inherited from [Phalcon\DispatcherInterface](Phalcon_DispatcherInterface)

...

abstract public **dispatch** () inherited from [Phalcon\DispatcherInterface](Phalcon_DispatcherInterface)

...

abstract public **forward** (*mixed* $forward) inherited from [Phalcon\DispatcherInterface](Phalcon_DispatcherInterface)

...