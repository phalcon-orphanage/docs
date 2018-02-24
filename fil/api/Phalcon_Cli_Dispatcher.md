# Class **Phalcon\\Cli\\Dispatcher**

*extends* abstract class [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

*implements* [Phalcon\Events\EventsAwareInterface](/en/3.2/api/Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](/en/3.2/api/Phalcon_Di_InjectionAwareInterface), [Phalcon\DispatcherInterface](/en/3.2/api/Phalcon_DispatcherInterface), [Phalcon\Cli\DispatcherInterface](/en/3.2/api/Phalcon_Cli_DispatcherInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/cli/dispatcher.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Dispatching is the process of taking the command-line arguments, extracting the module name, task name, action name, and optional parameters contained in it, and then instantiating a task and calling an action on it.

```php
<?php

use Phalcon\Di;
use Phalcon\Cli\Dispatcher;

$di = new Di();
$dispatcher = new Dispatcher();
$dispatcher->setDi($di);

$dispatcher->setTaskName("posts");
$dispatcher->setActionName("index");
$dispatcher->setParams([]);

$handle = $dispatcher->dispatch();

```

## Constants

*integer* **EXCEPTION_NO_DI**

*integer* **EXCEPTION_CYCLIC_ROUTING**

*integer* **EXCEPTION_HANDLER_NOT_FOUND**

*integer* **EXCEPTION_INVALID_HANDLER**

*integer* **EXCEPTION_INVALID_PARAMS**

*integer* **EXCEPTION_ACTION_NOT_FOUND**

## Methods

public **setTaskSuffix** (*mixed* $taskSuffix)

Sets the default task suffix

public **setDefaultTask** (*mixed* $taskName)

Sets the default task name

public **setTaskName** (*mixed* $taskName)

Sets the task name to be dispatched

public **getTaskName** ()

Gets last dispatched task name

protected **_throwDispatchException** (*mixed* $message, [*mixed* $exceptionCode])

Throws an internal exception

protected **_handleException** ([Exception](http://php.net/manual/en/class.exception.php) $exception)

Handles a user exception

public **getLastTask** ()

Returns the latest dispatched controller

public **getActiveTask** ()

Returns the active task in the dispatcher

public **setOptions** (*array* $options)

Set the options to be dispatched

public **getOptions** ()

Get dispatched options

public **getOption** (*mixed* $option, [*string* | *array* $filters], [*mixed* $defaultValue])

Gets an option by its name or numeric index

public **hasOption** (*mixed* $option)

Check if an option exists

public **callActionMethod** (*mixed* $handler, *mixed* $actionMethod, [*array* $params])

Calls the action method.

public **setDI** ([Phalcon\DiInterface](/en/3.2/api/Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Sets the dependency injector

public **getDI** () inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Returns the internal dependency injector

public **setEventsManager** ([Phalcon\Events\ManagerInterface](/en/3.2/api/Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Sets the events manager

public **getEventsManager** () inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Returns the internal event manager

public **setActionSuffix** (*mixed* $actionSuffix) inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Sets the default action suffix

public **getActionSuffix** () inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Gets the default action suffix

public **setModuleName** (*mixed* $moduleName) inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Sets the module where the controller is (only informative)

public **getModuleName** () inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Gets the module where the controller class is

public **setNamespaceName** (*mixed* $namespaceName) inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Sets the namespace where the controller class is

public **getNamespaceName** () inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Gets a namespace to be prepended to the current handler name

public **setDefaultNamespace** (*mixed* $namespaceName) inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Sets the default namespace

public **getDefaultNamespace** () inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Returns the default namespace

public **setDefaultAction** (*mixed* $actionName) inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Sets the default action name

public **setActionName** (*mixed* $actionName) inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Sets the action name to be dispatched

public **getActionName** () inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Gets the latest dispatched action name

public **setParams** (*array* $params) inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Sets action params to be dispatched

public **getParams** () inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Gets action params

public **setParam** (*mixed* $param, *mixed* $value) inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Set a param by its name or numeric index

public *mixed* **getParam** (*mixed* $param, [*string* | *array* $filters], [*mixed* $defaultValue]) inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Gets a param by its name or numeric index

public *boolean* **hasParam** (*mixed* $param) inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Check if a param exists

public **getActiveMethod** () inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Returns the current method to be/executed in the dispatcher

public **isFinished** () inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Checks if the dispatch loop is finished or has more pendent controllers/tasks to dispatch

public **setReturnedValue** (*mixed* $value) inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Sets the latest returned value by an action manually

public *mixed* **getReturnedValue** () inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Returns value returned by the latest dispatched action

public **setModelBinding** (*mixed* $value, [*mixed* $cache]) inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Enable/Disable model binding during dispatch

```php
<?php

$di->set('dispatcher', function() {
    $dispatcher = new Dispatcher();

    $dispatcher->setModelBinding(true, 'cache');
    return $dispatcher;
});

```

public **setModelBinder** ([Phalcon\Mvc\Model\BinderInterface](/en/3.2/api/Phalcon_Mvc_Model_BinderInterface) $modelBinder, [*mixed* $cache]) inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Enable model binding during dispatch

```php
<?php

$di->set('dispatcher', function() {
    $dispatcher = new Dispatcher();

    $dispatcher->setModelBinder(new Binder(), 'cache');
    return $dispatcher;
});

```

public **getModelBinder** () inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Gets model binder

public *object* **dispatch** () inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Dispatches a handle action taking into account the routing parameters

protected *object* **_dispatch** () inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Dispatches a handle action taking into account the routing parameters

public **forward** (*array* $forward) inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Forwards the execution flow to another controller/action.

```php
<?php

$this->dispatcher->forward(
    [
        "controller" => "posts",
        "action"     => "index",
    ]
);

```

public **wasForwarded** () inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Check if the current executed action was forwarded by another one

public **getHandlerClass** () inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Possible class name that will be located to dispatch the request

public **getBoundModels** () inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

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

protected **_resolveEmptyProperties** () inherited from [Phalcon\Dispatcher](/en/3.2/api/Phalcon_Dispatcher)

Set empty properties to their defaults (where defaults are available)
