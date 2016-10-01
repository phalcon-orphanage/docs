Interface **Phalcon\\Mvc\\DispatcherInterface**
===============================================

*implements* :doc:`Phalcon\\DispatcherInterface <Phalcon_DispatcherInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/dispatcherinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Methods
-------

abstract public  **setControllerSuffix** (*mixed* $controllerSuffix)

...


abstract public  **setDefaultController** (*mixed* $controllerName)

...


abstract public  **setControllerName** (*mixed* $controllerName)

...


abstract public  **getControllerName** ()

...


abstract public  **getLastController** ()

...


abstract public  **getActiveController** ()

...


abstract public  **setActionSuffix** (*mixed* $actionSuffix) inherited from :doc:`Phalcon\\DispatcherInterface <Phalcon_DispatcherInterface>`

...


abstract public  **getActionSuffix** () inherited from :doc:`Phalcon\\DispatcherInterface <Phalcon_DispatcherInterface>`

...


abstract public  **setDefaultNamespace** (*mixed* $defaultNamespace) inherited from :doc:`Phalcon\\DispatcherInterface <Phalcon_DispatcherInterface>`

...


abstract public  **setDefaultAction** (*mixed* $actionName) inherited from :doc:`Phalcon\\DispatcherInterface <Phalcon_DispatcherInterface>`

...


abstract public  **setNamespaceName** (*mixed* $namespaceName) inherited from :doc:`Phalcon\\DispatcherInterface <Phalcon_DispatcherInterface>`

...


abstract public  **setModuleName** (*mixed* $moduleName) inherited from :doc:`Phalcon\\DispatcherInterface <Phalcon_DispatcherInterface>`

...


abstract public  **setActionName** (*mixed* $actionName) inherited from :doc:`Phalcon\\DispatcherInterface <Phalcon_DispatcherInterface>`

...


abstract public  **getActionName** () inherited from :doc:`Phalcon\\DispatcherInterface <Phalcon_DispatcherInterface>`

...


abstract public  **setParams** (*mixed* $params) inherited from :doc:`Phalcon\\DispatcherInterface <Phalcon_DispatcherInterface>`

...


abstract public  **getParams** () inherited from :doc:`Phalcon\\DispatcherInterface <Phalcon_DispatcherInterface>`

...


abstract public  **setParam** (*mixed* $param, *mixed* $value) inherited from :doc:`Phalcon\\DispatcherInterface <Phalcon_DispatcherInterface>`

...


abstract public  **getParam** (*mixed* $param, [*mixed* $filters]) inherited from :doc:`Phalcon\\DispatcherInterface <Phalcon_DispatcherInterface>`

...


abstract public  **hasParam** (*mixed* $param) inherited from :doc:`Phalcon\\DispatcherInterface <Phalcon_DispatcherInterface>`

...


abstract public  **isFinished** () inherited from :doc:`Phalcon\\DispatcherInterface <Phalcon_DispatcherInterface>`

...


abstract public  **getReturnedValue** () inherited from :doc:`Phalcon\\DispatcherInterface <Phalcon_DispatcherInterface>`

...


abstract public  **dispatch** () inherited from :doc:`Phalcon\\DispatcherInterface <Phalcon_DispatcherInterface>`

...


abstract public  **forward** (*mixed* $forward) inherited from :doc:`Phalcon\\DispatcherInterface <Phalcon_DispatcherInterface>`

...


