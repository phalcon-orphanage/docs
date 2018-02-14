# Class **Phalcon\\Mvc\\Dispatcher**

*extends* abstract class [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

*implements* [Phalcon\Events\EventsAwareInterface](/[[language]]/[[version]]/api/Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](/[[language]]/[[version]]/api/Phalcon_Di_InjectionAwareInterface), [Phalcon\DispatcherInterface](/[[language]]/[[version]]/api/Phalcon_DispatcherInterface), [Phalcon\Mvc\DispatcherInterface](/[[language]]/[[version]]/api/Phalcon_Mvc_DispatcherInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/mvc/dispatcher.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Dispatching is the process of taking the request object, extracting the module name,
controller name, action name, and optional parameters contained in it, and then
instantiating a controller and calling an action of that controller.

```php
<?php

$di = new \Phalcon\Di();

$dispatcher = new \Phalcon\Mvc\Dispatcher();

$dispatcher->setDI($di);

$dispatcher->setControllerName("posts");
$dispatcher->setActionName("index");
$dispatcher->setParams([]);

$controller = $dispatcher->dispatch();

```


## Constants
*integer* **EXCEPTION_NO_DI**

*integer* **EXCEPTION_CYCLIC_ROUTING**

*integer* **EXCEPTION_HANDLER_NOT_FOUND**

*integer* **EXCEPTION_INVALID_HANDLER**

*integer* **EXCEPTION_INVALID_PARAMS**

*integer* **EXCEPTION_ACTION_NOT_FOUND**

## Methods
public  **setControllerSuffix** (*mixed* $controllerSuffix)

Sets the default controller suffix



public  **setDefaultController** (*mixed* $controllerName)

Sets the default controller name



public  **setControllerName** (*mixed* $controllerName)

Sets the controller name to be dispatched



public  **getControllerName** ()

Gets last dispatched controller name



public  **getPreviousNamespaceName** ()

Gets previous dispatched namespace name



public  **getPreviousControllerName** ()

Gets previous dispatched controller name



public  **getPreviousActionName** ()

Gets previous dispatched action name



protected  **_throwDispatchException** (*mixed* $message, [*mixed* $exceptionCode])

Throws an internal exception



protected  **_handleException** ([Exception](http://php.net/manual/en/class.exception.php) $exception)

Handles a user exception



public  **forward** (*array* $forward)

Forwards the execution flow to another controller/action.

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use App\Backend\Bootstrap as Backend;
use App\Frontend\Bootstrap as Frontend;

// Registering modules
$modules = [
    "frontend" => [
        "className" => Frontend::class,
        "path"      => __DIR__ . "/app/Modules/Frontend/Bootstrap.php",
        "metadata"  => [
            "controllersNamespace" => "App\Frontend\Controllers",
        ],
    ],
    "backend" => [
        "className" => Backend::class,
        "path"      => __DIR__ . "/app/Modules/Backend/Bootstrap.php",
        "metadata"  => [
            "controllersNamespace" => "App\Backend\Controllers",
        ],
    ],
];

$application->registerModules($modules);

// Setting beforeForward listener
$eventsManager  = $di->getShared("eventsManager");

$eventsManager->attach(
    "dispatch:beforeForward",
    function(Event $event, Dispatcher $dispatcher, array $forward) use ($modules) {
        $metadata = $modules[$forward["module"]]["metadata"];

        $dispatcher->setModuleName($forward["module"]);
        $dispatcher->setNamespaceName($metadata["controllersNamespace"]);
    }
);

// Forward
$this->dispatcher->forward(
    [
        "module"     => "backend",
        "controller" => "posts",
        "action"     => "index",
    ]
);

```



public  **getControllerClass** ()

Possible controller class name that will be located to dispatch the request



public  **getLastController** ()

Returns the latest dispatched controller



public  **getActiveController** ()

Returns the active controller in the dispatcher



public  **setDI** ([Phalcon\DiInterface](/[[language]]/[[version]]/api/Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Sets the dependency injector



public  **getDI** () inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Returns the internal dependency injector



public  **setEventsManager** ([Phalcon\Events\ManagerInterface](/[[language]]/[[version]]/api/Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Sets the events manager



public  **getEventsManager** () inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Returns the internal event manager



public  **setActionSuffix** (*mixed* $actionSuffix) inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Sets the default action suffix



public  **getActionSuffix** () inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Gets the default action suffix



public  **setModuleName** (*mixed* $moduleName) inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Sets the module where the controller is (only informative)



public  **getModuleName** () inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Gets the module where the controller class is



public  **setNamespaceName** (*mixed* $namespaceName) inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Sets the namespace where the controller class is



public  **getNamespaceName** () inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Gets a namespace to be prepended to the current handler name



public  **setDefaultNamespace** (*mixed* $namespaceName) inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Sets the default namespace



public  **getDefaultNamespace** () inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Returns the default namespace



public  **setDefaultAction** (*mixed* $actionName) inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Sets the default action name



public  **setActionName** (*mixed* $actionName) inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Sets the action name to be dispatched



public  **getActionName** () inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Gets the latest dispatched action name



public  **setParams** (*array* $params) inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Sets action params to be dispatched



public  **getParams** () inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Gets action params



public  **setParam** (*mixed* $param, *mixed* $value) inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Set a param by its name or numeric index



public *mixed* **getParam** (*mixed* $param, [*string* | *array* $filters], [*mixed* $defaultValue]) inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Gets a param by its name or numeric index



public *boolean* **hasParam** (*mixed* $param) inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Check if a param exists



public  **getActiveMethod** () inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Returns the current method to be/executed in the dispatcher



public  **isFinished** () inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Checks if the dispatch loop is finished or has more pendent controllers/tasks to dispatch



public  **setReturnedValue** (*mixed* $value) inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Sets the latest returned value by an action manually



public *mixed* **getReturnedValue** () inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Returns value returned by the latest dispatched action



public  **setModelBinding** (*mixed* $value, [*mixed* $cache]) inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Enable/Disable model binding during dispatch

```php
<?php

$di->set('dispatcher', function() {
    $dispatcher = new Dispatcher();

    $dispatcher->setModelBinding(true, 'cache');
    return $dispatcher;
});

```



public  **setModelBinder** ([Phalcon\Mvc\Model\BinderInterface](/[[language]]/[[version]]/api/Phalcon_Mvc_Model_BinderInterface) $modelBinder, [*mixed* $cache]) inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Enable model binding during dispatch

```php
<?php

$di->set('dispatcher', function() {
    $dispatcher = new Dispatcher();

    $dispatcher->setModelBinder(new Binder(), 'cache');
    return $dispatcher;
});

```



public  **getModelBinder** () inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Gets model binder



public *object* **dispatch** () inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Dispatches a handle action taking into account the routing parameters



protected *object* **_dispatch** () inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Dispatches a handle action taking into account the routing parameters



public  **wasForwarded** () inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Check if the current executed action was forwarded by another one



public  **getHandlerClass** () inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Possible class name that will be located to dispatch the request



public  **callActionMethod** (*mixed* $handler, *mixed* $actionMethod, [*array* $params]) inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

...


public  **getBoundModels** () inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Returns bound models from binder instance

```php
<?php

class UserController extends Controller
{
    public function showAction(User $user)
    {
        $boundModels = $this->dispatcher->getBoundModels(); // return array with $user
    }
}

```



protected  **_resolveEmptyProperties** () inherited from [Phalcon\Dispatcher](/[[language]]/[[version]]/api/Phalcon_Dispatcher)

Set empty properties to their defaults (where defaults are available)



