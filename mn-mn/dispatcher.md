---
layout: default
language: 'en'
version: '4.0'
title: 'Dispatcher'
keywords: 'dispatcher, mvc, dispatch loop'
---

# Dispatcher Component

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview

The [Phalcon\Mvc\Dispatcher](api/phalcon_mvc#mvc-dispatcher) is the component responsible for instantiating controllers and executing the required actions on them in an MVC application. Dispatching is the process of taking the request object, extracting the module name, controller name, action name, and optional parameters contained in it, and then instantiating a controller and calling an action of that controller.

```php
<?php

use Phalcon\Di;
use Phalcon\Mvc\Dispatcher);

$container  = new Di();
$dispatcher = new Dispatcher();

$dispatcher->setDI($container);

$dispatcher->setControllerName("posts");
$dispatcher->setActionName("index");
$dispatcher->setParams([]);

$controller = $dispatcher->dispatch();
```

## Methods

```php
public function callActionMethod(
    mixed $handler, 
    string $actionMethod, 
    array $params = []
)
```

Calls an action method with a handler and parameters

```php
public function dispatch(): object | bool
```

Process the results of the router by calling into the appropriate controller action(s) including any routing data or injected parameters. Returns the dispatched handler class (the Controller for Mvc dispatching or a Task for CLI dispatching) or `false` if an exception occurred and the operation was stopped by returning `false` in the exception handler. Throws an Exception if any uncaught or unhandled exception occurs during the dispatcher process.

```php
public function forward(
    array $forward
): void
```

Forwards the execution flow to another controller/action.

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use App\Back\Bootstrap as Back;
use App\Front\Bootstrap as Front;

$modules = [
    "frontend" => [
        "className" => Front::class,
        "path"      => __DIR__ . "/app/Modules/Front/Bootstrap.php",
        "metadata"  => [
            "controllersNamespace" => "App\Front\Controllers",
        ],
    ],
    "backend" => [
        "className" => Back::class,
        "path"      => __DIR__ . "/app/Modules/Back/Bootstrap.php",
        "metadata"  => [
            "controllersNamespace" => "App\Back\Controllers",
        ],
    ],
];

$application->registerModules($modules);

$eventsManager  = $container->getShared("eventsManager");

$eventsManager->attach(
    "dispatch:beforeForward",
    function (
        Event $event, 
        Dispatcher $dispatcher, 
        array $forward
    ) use ($modules) {
        $metadata = $modules[$forward["module"]]["metadata"];

        $dispatcher->setModuleName(
            $forward["module"]
        );

        $dispatcher->setNamespaceName(
            $metadata["controllersNamespace"]
        );
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

```php
public function getActionName(): string
```

Gets the latest dispatched action name

```php
public function getActionSuffix(): string
```

Gets the default action suffix

```php
public function getActiveController(): ControllerInterface
```

Returns the active controller in the dispatcher

```php
public function getActiveMethod(): string
```

Returns the current method to be/executed in the dispatcher

```php
public function getBoundModels(): array
```

Returns bound models from binder instance

```php
<?php

use Phalcon\Mvc\Dispatcher;

/**
 * @property Dispatcher $dispatcher
 */
class InvoicesController extends Controller
{
    public function viewAction(Invoices $invoice)
    {
        $boundModels = $this
            ->dispatcher
            ->getBoundModels()
        ;
    }
}
```

```php
public function getControllerClass(): string
```

Possible controller class name that will be located to dispatch the request

```php
public function getControllerName(): string
```

Gets last dispatched controller name

```php
public function getDefaultNamespace(): string
```

Returns the default namespace

```php
public function getHandlerClass(): string
```

Possible class name that will be located to dispatch the request

```php
public function getHandlerSuffix(): string
```

Gets the default handler suffix

```php
public function getLastController(): ControllerInterface
```

Returns the latest dispatched controller

```php
public function getModelBinder(): BinderInterface | null
```

Gets the model binder

```php
public function getModuleName(): string
```

Gets the module where the controller class is

```php
public function getNamespaceName(): string
```

Gets a namespace to be prepended to the current handler name

```php
public function getParam(
    mixed $param, 
    string | array $filters = null, 
    mixed $defaultValue = null
): mixed
```

Gets a parameter by its name or numeric index

```php
public function getParams(): array
```

Gets action params

```php
public function getPreviousActionName(): string
```

Gets previous dispatched action name

```php
public function getPreviousControllerName(): string
```

Gets previous dispatched controller name

```php
public function getPreviousNamespaceName(): string
```

Gets previous dispatched namespace name

```php
public function getReturnedValue(): var
```

Returns value returned by the latest dispatched action

```php
public function hasParam(
    mixed $param
): bool
```

Check if a param exists

```php
public function isFinished(): bool
```

Checks if the dispatch loop is finished or has more pendent controllers/tasks to dispatch

```php
public function setActionName(
    string $actionName
): void
```

Sets the action name to be dispatched

```php
public function setActionSuffix(
    string $actionSuffix
): void
```

Sets the default action suffix

```php
public function setControllerName(
    string $controllerName
)
```

Sets the controller name to be dispatched

```php
public function setControllerSuffix(
    string $controllerSuffix
)
```

Sets the default controller suffix

```php
public function setDefaultAction(
    string $actionName
): void
```

Sets the default action name

```php
public function setDefaultController(
    string $controllerName
)
```

Sets the default controller name

```php
public function setDefaultNamespace(
    string $namespaceName
): void
```

Sets the default namespace

```php
public function setHandlerSuffix(
    string $handlerSuffix
): void
```

Sets the default suffix for the handler

```php
public function setModelBinder(
    BinderInterface $modelBinder, 
    mixed $cache = null
): DispatcherInterface
```

Enable model binding during dispatch

```php
$container->set(
    'dispatcher',
    function() {
        $dispatcher = new Dispatcher();

        $dispatcher->setModelBinder(
            new Binder(),
            'cache'
        );

        return $dispatcher;
    }
);
```

```php
public function setModuleName(
    string $moduleName
): void
```

Sets the module where the controller is (only informative)

```php
public function setNamespaceName(
    string $namespaceName
): void
```

Sets the namespace where the controller class is

```php
public function setParam(
    mixed $param, 
    mixed $value
): void
```

Set a param by its name or numeric index

```php
public function setParams(
    array $params
): void
```

Sets action params to be dispatched

```php
public function setReturnedValue(
    mixed $value
): void
```

Sets the latest returned value by an action manually

```php
public function wasForwarded(): bool
```

Check if the current executed action was forwarded by another one

## Dispatch Loop

This is an important process that has much to do with the MVC flow itself, especially with the controller part. The work occurs within the controller dispatcher. The controller files are read, loaded, and instantiated. Then the required actions are executed. If an action forwards the flow to another controller/action, the controller dispatcher starts again. To better illustrate this, the following example shows approximately the process performed within the [Phalcon\Mvc\Dispatcher](api/phalcon_mvc#mvc-dispatcher) component.

```php
<?php

$finished = false;

while (true !== $finished) {
    $finished = true;

    $controllerClass = $controllerName . 'Controller';
    $controller      = new $controllerClass();

    call_user_func_array(
        [
            $controller,
            $actionName . 'Action',
        ],
        $params
    );

    $finished = true;
}
```

In the code above, we are calculating the controller name, instantiate it and call the relevant action. After that we finish the loop. The example is very simplified and lacks validations, filters and additional checks, but it demonstrates the normal flow of operation within the dispatcher.

## Forwarding

The dispatch loop allows you to forward the execution flow to another controller/action. This is very useful in situations when checking if the user has access to certain areas, and if not allowed be forwarded to other controllers and actions, thus allowing you to reuse code.

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

/**
 * @property Dispatcher $dispatcher
 */
class InvoicesController extends Controller
{
    public function saveAction($year, $postTitle)
    {
        // ... 

        $this->dispatcher->forward(
            [
                'controller' => 'invoices',
                'action'     => 'list',
            ]
        );
    }
}
```

> **NOTE**: Keep in mind that performing a `forward` is not the same as making a HTTP redirect. Although they produce the same result, performing a `forward` will not reload the current page, while the HTTP redirect needs two requests to complete the process.
{: .alert .alert-info }

Examples:

```php
<?php

$this->dispatcher->forward(
    [
        'action' => 'search',
    ]
);
```

Forward flow to another action in the current controller

```php
<?php

$this->dispatcher->forward(
    [
        'action' => 'search',
        'params' => [1, 2, 3],
    ]
);
```

Forward flow to another action in the current controller, passing parameters

A `forward` action accepts the following parameters:

| Parameter    | Description                                             |
| ------------ | ------------------------------------------------------- |
| `controller` | A valid controller name to forward to.                  |
| `action`     | A valid action name to forward to.                      |
| `params`     | An array of parameters for the action.                  |
| `namespace`  | A valid namespace name where the controller is part of. |

## Parameters

### Preparing

By using events or hook points available by the [Phalcon\Mvc\Dispatcher](api/phalcon_mvc#mvc-dispatcher), you can easily adjust your application to accept any URL schema that suits your application. This is particularly useful when upgrading your application and want to transform some legacy URLs. For instance you might want your URLs to be:

``` https://domain.com/controller/key1/value1/key2/value

    Since parameters are passed with the order that they are defined in the URL to actions, you can transform them to the desired schema:
    
    ```php
    <?php
    
    use Phalcon\Dispatcher;
    use Phalcon\Mvc\Dispatcher as MvcDispatcher;
    use Phalcon\Events\Event;
    use Phalcon\Events\Manager;
    
    $container->set(
        'dispatcher',
        function () {
            $eventsManager = new Manager();
    
            $eventsManager->attach(
                'dispatch:beforeDispatchLoop',
                function (Event $event, $dispatcher) {
                    $params    = $dispatcher->getParams();
                    $keyParams = [];
    
                    foreach ($params as $index => $value) {
                        if ($index & 1) {
                            $key = $params[$index - 1];
    
                            $keyParams[$key] = $value;
                        }
                    }
    
                    $dispatcher->setParams($keyParams);
                }
            );
    
            $dispatcher = new MvcDispatcher();
            $dispatcher->setManager($eventsManager);
    
            return $dispatcher;
        }
    );
    

If the desired schema is:

    https://example.com/controller/key1:value1/key2:value
    

you can use the following code:

```php
<?php

use Phalcon\Dispatcher;
use Phalcon\Events\Event;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;

$container->set(
    'dispatcher',
    function () {
        $eventsManager = new Manager();

        $eventsManager->attach(
            'dispatch:beforeDispatchLoop',
            function (Event $event, $dispatcher) {
                $params    = $dispatcher->getParams();
                $keyParams = [];

                foreach ($params as $param) {
                    $parts = explode(':', $param);
                    $key   = $parts[0];
                    $value = $parts[1];

                    $keyParams[$key] = $value;
                }

                $dispatcher->setParams($keyParams);
            }
        );

        $dispatcher = new MvcDispatcher();
        $dispatcher->setManager($eventsManager);

        return $dispatcher;
    }
);
```

## Getting

When a route provides named parameters you can receive them in a controller, a view or any other component that extends [Phalcon\Di\Injectable](api/phalcon_di#di-factorydefault)

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

/**
 * @property Dispatcher $dispatcher
 */
class InvoicesController extends Controller
{
    public function viewAction()
    {
        $invoiceId = $this
            ->dispatcher
            ->getParam('invoiceId', 'int')
        ;
        $filter = $this
            ->dispatcher
            ->getParam('filter', 'string')
        ;

        // ...
    }
}
```

In the example above, we get the `invoiceId` as the first parameter passed and automatically sanitize it as an `integer`. The second parameter is the `filter` one, which is sanitized as a `string`

## Actions

You can also define an arbitrary schema for actions `before` the dispatch loop is invoked.

### Camelize Names

If the original URL is

    https://example.com/admin/invoices/show-unpaid
    

and for example you want to camelize `show-unpaid` to `ShowUnpaid`, the `beforeDispatchLoop` can be used to achieve that.

```php
<?php

use Phalcon\Text;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as Manager;

$container->set(
    'dispatcher',
    function () {
        $eventsManager = new Manager();

        $eventsManager->attach(
            'dispatch:beforeDispatchLoop',
            function (Event $event, $dispatcher) {
                $dispatcher->setActionName(
                    Text::camelize(
                        $dispatcher->getActionName()
                    )
                );
            }
        );

        $dispatcher = new MvcDispatcher();
        $dispatcher->setManager($eventsManager);

        return $dispatcher;
    }
);
```

### Filter File Extensions

If the original URL always contains a `.php` extension:

    https://example.com/admin/invoices/show-unpaid.php
    https://example.com/admin/invoices/index.php
    

You can remove it before dispatch the controller/action combination:

```php
<?php

use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Event;
use Phalcon\Events\Manager;

$container->set(
    'dispatcher',
    function () {
        $eventsManager = new Manager();

        $eventsManager->attach(
            'dispatch:beforeDispatchLoop',
            function (Event $event, $dispatcher) {
                $action = $dispatcher->getActionName();
                $action = preg_replace('/\.php$/', '', $action);

                $dispatcher->setActionName($action);
            }
        );

        $dispatcher = new MvcDispatcher();
        $dispatcher->setManager($eventsManager);

        return $dispatcher;
    }
);
```

> **NOTE**: The code above can be used as is or adjusted to help with legacy URL transformations or other use cases where we need to manipulate the action name.
{: .alert .alert-info }

### Model Injection

There are instances that you might want to inject automatically model instances that have been matched with the parameters passed in the URL.

Our controller is:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property View $view
 */
class InvoicesController extends Controller
{
    public function viewAction(Invoices $invoice)
    {
        $this->view->invoice = $invoice;
    }
}
```

The `viewAction` receives an instance of the model `Invoices`. If you try to execute this method without any checks and manipulations, the call will fail. You can however inspect the passed parameters before the dispatch loop and manipulate the parameters accordingly.

```php
<?php

use \Exception;
use Phalcon\Events\Event;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use \ReflectionMethod;

$container->set(
    'dispatcher',
    function () {
        $eventsManager = new Manager();

        $eventsManager->attach(
            'dispatch:beforeDispatchLoop',
            function (Event $event, $dispatcher) {
                $controllerName = $dispatcher->getControllerClass();
                $actionName     = $dispatcher->getActiveMethod();

                try {
                    $reflection = new ReflectionMethod(
                        $controllerName, 
                        $actionName
                    );
                    $parameters = $reflection->getParameters();

                    foreach ($parameters as $parameter) {
                        $className = $parameter->getClass()->name;

                        if (is_subclass_of($className, Model::class)) {
                            $model = $className::findFirstById(
                                $dispatcher->getParams()[0]
                            );

                            $dispatcher->setParams(
                                [
                                    $model,
                                ]
                            );
                        }
                    }
                } catch (Exception $e) {
                }
            }
        );

        $dispatcher = new MvcDispatcher();
        $dispatcher->setManager($eventsManager);

        return $dispatcher;
    }
);
```

In the example above, we get the controller class and acive method from the dispatcher. Looping through the parameters, we use reflection to check the method to be executed. We calculate the model name and also check if the parameter is expecting a model name. If yes, we override the parameter by passing the model found. If an exception was thrown, we can handle that accordingly, for instance if the class or action do not exist or the record has not been found.

The above example has been simplified. You can adjust it according to your needs and inject any kind of dependency or model to an action before it gets executed.

The dispatcher also comes with an option to handle this internally for all models passed into a controller action by using the [Phalcon\Mvc\Model\Binder](api/phalcon_mvc#mvc-model-binder) object.

```php
<?php

use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Model\Binder;

$dispatcher = new Dispatcher();

$dispatcher->setModelBinder(
    new Binder()
);

return $dispatcher;
```

> **NOTE**: The [Phalcon\Mvc\Model\Binder](api/phalcon_mvc#mvc-model-binder) component uses PHP's Reflection API internally, which consumes additional processing cycles. For that reason, it has the ability to use a `cache` instance or a cache service name. To use this feature, you can pass the cache service name or instance as the second argument in the `setModelBinder()` method or by just passing the cache instance in the `Binder` constructor.
{: .alert .alert-warning }

Also, by using the [Phalcon\Mvc\Model\Binder\BindableInterface](api/phalcon_mvc#mvc-model-binder-bindableinterface) in controllers, you can define the models binding in base controllers.

In the example below, we have a base controller `CrudController` which `InvoicesController` extends from.

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\View;

/**
 * @property View $view
 */
class CrudController extends Controller
{
    public function viewAction(Model $model)
    {
        $this->view->model = $model;
    }
}
```

In the `InvoicesController` we will define which model the controller is associated with. This is done by implementing the [Phalcon\Mvc\Model\Binder\BindableInterface](api/phalcon_mvc#mvc-model-binder-bindableinterface), which will make the `getModelName()` method available. This method is used to return the model name. It can return string with just one model name or an associative array with the key is the parameter name.

```php
<?php

use Phalcon\Mvc\Model\Binder\BindableInterface;

class InvoicesController extends CrudController implements BindableInterface
{
    public static function getModelName()
    {
        return Invoices::class;
    }
}
```

By declaring the model associated with the `InvoicesController` the binder can check the controller for the `getModelName()` method before passing the defined model into the parent `view` action.

If your project structure does not use any base controllers, you can of course still bind the model directly into the controller action:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property View $view
 */
class InvoicesController extends Controller
{
    public function showAction(Invoices $invoice)
    {
        $this->view->invoice = $invoice;
    }
}
```

> Currently the binder will only use the models primary key to perform a `findFirst()` on. An example route for the above would be `/posts/show/{1}`
{: .alert .alert-warning }

## Not-Found (404)

If an [Events Manager](events) has been defined, you can use it to intercept exceptions that are thrown when the controller/action pair are not found.

```php
<?php

use Exception;
use Phalcon\Dispatcher;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Event;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Dispatcher\Exception as DispatchException;

$container->setShared(
    'dispatcher',
    function () {
        $eventsManager = new Manager();

        $eventsManager->attach(
            'dispatch:beforeException',
            function (
                Event $event, 
                $dispatcher, 
                Exception $exception
            ) {
                // 404
                if ($exception instanceof DispatchException) {
                    $dispatcher->forward(
                        [
                            'controller' => 'index',
                            'action'     => 'fourOhFour',
                        ]
                    );

                    return false;
                }
            }
        );

        $dispatcher = new MvcDispatcher();
        $dispatcher->setManager($eventsManager);

        return $dispatcher;
    }
);
```

or use an alternative systax checking for the exception.

```php
<?php

use Exception;
use Phalcon\Dispatcher\Exception as DispatcherException;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Event;
use Phalcon\Events\Manager;

$container->setShared(
    'dispatcher',
    function () {
        $eventsManager = new Manager();

        $eventsManager->attach(
            'dispatch:beforeException',
            function (
                Event $event, 
                $dispatcher, 
                Exception $exception
            ) {
                switch ($exception->getCode()) {
                    case DispatcherException::EXCEPTION_HANDLER_NOT_FOUND:
                    case DispatcherException::EXCEPTION_ACTION_NOT_FOUND:
                        // 404
                        $dispatcher->forward(
                            [
                                'controller' => 'index',
                                'action'     => 'fourOhFour',
                            ]
                        );

                        return false;
                }
            }
        );

        $dispatcher = new MvcDispatcher();
        $dispatcher->setManager($eventsManager);

        return $dispatcher;
    }
);
```

We cam move this method in a plugin class:

```php
<?php

use Exception;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Dispatcher\Exception as DispatchException;

class ExceptionsPlugin
{
    public function beforeException(
        Event $event, 
        Dispatcher $dispatcher, 
        Exception $exception
    ) {
        $action = 'fiveOhThree';

        if ($exception instanceof DispatchException) {
            $action = 'fourOhFour';
        }

        $dispatcher->forward(
            [
                'controller' => 'index',
                'action'     => $action,
            ]
        );

        return false;
    }
}
```

> **NOTE**: Only exceptions produced by the dispatcher and exceptions produced in the executed action notify the `beforeException` events. Exceptions produced in listeners or controller events are redirected to the latest try/catch.
{: .alert .alert-danger }

## Events

[Phalcon\Mvc\Dispatcher](api/phalcon_mvc#mvc-dispatcher) is able to send events to an [Manager](events) if it is present. Events are triggered using the type `dispatch`. Some events when returning boolean `false` could stop the active operation. The following events are supported:

| Event Name             | Triggered                                                                                                                   | Can stop |
| ---------------------- | --------------------------------------------------------------------------------------------------------------------------- |:--------:|
| `afterBinding`         | After models are bound but before executing route                                                                           |   Yes    |
| `afterDispatch`        | After executing the controller/action method.                                                                               |   Yes    |
| `afterDispatchLoop`    | After exiting the dispatch loop                                                                                             |    No    |
| `afterExecuteRoute`    | After executing the controller/action method.                                                                               |    No    |
| `beforeDispatch`       | After entering in the dispatch loop. The Dispatcher only knows the information passed by the Router.                        |   Yes    |
| `beforeDispatchLoop`   | Before entering in the dispatch loop. The Dispatcher only knows the information passed by the Router.                       |   Yes    |
| `beforeException`      | Before the dispatcher throws any exception                                                                                  |   Yes    |
| `beforeExecuteRoute`   | Before executing the controller/action method. The Dispatcher has initialized the controller and knows if the action exist. |   Yes    |
| `beforeNotFoundAction` | when the action was not found in the controller                                                                             |   Yes    |
| `initialize`           | Allow to globally initialize the controller in the request                                                                  |    No    |

The [INVO](https://github.com/phalcon/invo) sample application, demonstrates how you can take advantage of dispatching events, implementing a security filter with [Acl](acl)

The following example demonstrates how to attach listeners to this component:

```php
<?php

use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Event;
use Phalcon\Events\Manager;

$container->set(
    'dispatcher',
    function () {
        $eventsManager = new Manager();

        $eventsManager->attach(
            'dispatch',
            function (Event $event, $dispatcher) {
                // ...
            }
        );

        $dispatcher = new MvcDispatcher();
        $dispatcher->setManager($eventsManager);

        return $dispatcher;
    },
    true
);
```

An instantiated controller automatically acts as a listener for dispatch events, so you can implement methods as callbacks:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

class InvoicesController extends Controller
{
    public function beforeExecuteRoute(
        Dispatcher $dispatcher
    ) {
        // ...
    }

    public function afterExecuteRoute(
        Dispatcher $dispatcher
    ) {
        // ...
    }
}
```

> **NOTE**: Methods on event listeners accept an [Phalcon\Events\Event](api/phalcon_events#events-event) object as their first parameter - methods in controllers do not.
{: .alert .alert-warning }

## Events Manager

You can use the `dispatcher::beforeForward` event to change modules and perform redirections easier.

```php
<?php

use App\Back\Bootstrap;
use Phalcon\Di;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Event;

$container = new Di();

$modules = [
    'backend' => [
        'className' => Bootstrap::class,
        'path'      => '/app/Modules/Back/Bootstrap.php',
        'metadata'  => [
            'controllersNamespace' => 'App\Back\Controllers',
        ],
    ],
];

$manager = new Manager();
$manager->attach(
    'dispatch:beforeForward',
    function (
        Event $event, 
        Dispatcher $dispatcher, 
        array $forward
    ) use ($modules) {
        $moduleName = $forward['module'];
        $metadata   = $modules[$moduleName]['metadata'];

        $dispatcher->setModuleName($moduleName);
        $dispatcher->setNamespaceName(
            $metadata['controllersNamespace']
        );
    }
);

$dispatcher = new Dispatcher();
$dispatcher->setDI($container);
dispatcher->setManager($manager);
$container->set('dispatcher', $dispatcher);

$dispatcher->forward(
    [
        'module'     => 'backend',
        'controller' => 'invoices',
        'action'     => 'index',
    ]
);

echo $dispatcher->getModuleName();
```

## Custom

The [Phalcon\Mvc\DispatcherInterface](api/phalcon_mvc#mvc-dispatcherinterface) interface must be implemented to create your own dispatcher.

```php
<?php

namespace MyApp\Mvc

use Phalcon\Mvc\DispatcherInterface;

class MyDispatcher implements DispatcherInterface
{
    /**
     * Dispatches a handle action taking into account the routing parameters
     */
    public function dispatch(): object | bool;

    /**
     * Forwards the execution flow to another controller/action
     */
    public function forward(array $forward): void;

    /**
     * Gets last dispatched action name
     */
    public function getActionName(): string;

    /**
     * Gets the default action suffix
     */
    public function getActionSuffix(): string;

    /**
     * Returns the active controller in the dispatcher
     */
    public function getActiveController(): ControllerInterface;

    /**
     * Gets last dispatched controller name
     */
    public function getControllerName(): string;

    /**
     * Gets the default handler suffix
     */
    public function getHandlerSuffix(): string;

    /**
     * Returns the latest dispatched controller
     */
    public function getLastController(): ControllerInterface;

    /**
     * Gets a param by its name or numeric index
     *
     * @param string|array filters
     */
    public function getParam($param, $filters = null);

    /**
     * Gets action params
     */
    public function getParams(): array;

    /**
     * Returns value returned by the latest dispatched action
     */
    public function getReturnedValue();

    /**
     * Check if a param exists
     */
    public function hasParam($param): bool;

    /**
     * Checks if the dispatch loop is finished or has more pendent
     * controllers/tasks to dispatch
     */
    public function isFinished(): bool;

    /**
     * Sets the action name to be dispatched
     */
    public function setActionName(string $actionName): void;

    /**
     * Sets the default action suffix
     */
    public function setActionSuffix(string $actionSuffix): void;

    /**
     * Sets the default controller suffix
     */
    public function setControllerSuffix(string $controllerSuffix);

    /**
     * Sets the controller name to be dispatched
     */
    public function setControllerName(string $controllerName);

    /**
     * Sets the default action name
     */
    public function setDefaultAction(string $actionName): void;

    /**
     * Sets the default controller name
     */
    public function setDefaultController(string $controllerName);

    /**
     * Sets the default namespace
     */
    public function setDefaultNamespace(string $defaultNamespace): void;

    /**
     * Sets the default suffix for the handler
     */
    public function setHandlerSuffix(string $handlerSuffix): void;

    /**
     * Sets the module name which the application belongs to
     */
    public function setModuleName(string $moduleName): void;

    /**
     * Sets the namespace which the controller belongs to
     */
    public function setNamespaceName(string $namespaceName): void;

    /**
     * Set a param by its name or numeric index
     *
     * @param  mixed value
     */
    public function setParam($param, $value): void;

    /**
     * Sets action params to be dispatched
     */
    public function setParams(array $params): void;
}
```