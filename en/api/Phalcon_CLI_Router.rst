Class **Phalcon\\CLI\\Router**
==============================

*implements* :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`

Methods
---------

public  **__construct** ()

Phalcon\\CLI\\Router constructor



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the internal dependency injector



public  **setDefaultModule** (*string* $moduleName)

Sets the name of the default module



public  **setDefaultTask** (*string* $taskName)

Sets the default controller name



public  **setDefaultAction** (*string* $actionName)

Sets the default action name



public  **handle** ([*array* $arguments])

Handles routing information received from command-line arguments



public *string*  **getModuleName** ()

Returns proccesed module name



public *string*  **getTaskName** ()

Returns proccesed task name



public *string*  **getActionName** ()

Returns proccesed action name



public *array*  **getParams** ()

Returns proccesed extra params



