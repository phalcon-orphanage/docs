---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Cli\DispatcherInterface'
---
# Interface **Phalcon\Cli\DispatcherInterface**

*implements* [Phalcon\DispatcherInterface](Phalcon_DispatcherInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cli/dispatcherinterface.zep)

## Métodos

abstract public **setTaskSuffix** (*mixed* $taskSuffix)

...

abstract public **setDefaultTask** (*mixed* $taskName)

...

abstract public **setTaskName** (*mixed* $taskName)

...

abstract public **getTaskName** ()

...

abstract public **getLastTask** ()

...

abstract public **getActiveTask** ()

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