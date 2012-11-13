Interface **Phalcon\\Mvc\\DispatcherInterface**
===============================================

Phalcon\\Mvc\\DispatcherInterface initializer


Methods
---------

abstract public  **setControllerSuffix** (*string* $controllerSuffix)

Sets the default controller suffix



abstract public  **setDefaultController** (*string* $controllerName)

Sets the default controller name



abstract public  **setControllerName** (*string* $controllerName)

Sets the controller name to be dispatched



abstract public *string*  **getControllerName** ()

Gets last dispatched controller name



abstract public :doc:`Phalcon\\Mvc\\ControllerInterface <Phalcon_Mvc_ControllerInterface>`  **getLastController** ()

Returns the lastest dispatched controller



abstract public :doc:`Phalcon\\Mvc\\ControllerInterface <Phalcon_Mvc_ControllerInterface>`  **getActiveController** ()

Returns the active controller in the dispatcher



