* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Dispatching Controllers

[Phalcon\Mvc\Dispatcher](api/Phalcon_Mvc_Dispatcher) is the component responsible for instantiating controllers and executing the required actions on them in an MVC application. Understanding its operation and capabilities helps us get more out of the services provided by the framework.

<a name='dispatch-loop'></a>

## The Dispatch Loop

This is an important process that has much to do with the MVC flow itself, especially with the controller part. The work occurs within the controller dispatcher. The controller files are read, loaded, and instantiated. Then the required actions are executed. If an action forwards the flow to another controller/action, the controller dispatcher starts again. To better illustrate this, the following example shows approximately the process performed within [Phalcon\Mvc\Dispatcher](api/Phalcon_Mvc_Dispatcher):

```php
<?php

// Dispatch loop
while (!$finished) {
    $finished = true;

    $controllerClass = $controllerName . 'Controller';

    // Instantiating the controller class via autoloaders
    $controller = new $controllerClass();

    // Execute the action
    call_user_func_array(
        [
            $controller,
            $actionName . 'Action'
        ],
        $params
    );

    // '$finished' should be reloaded to check if the flow was forwarded to another controller
    $finished = true;
}
```

The code above lacks validations, filters and additional checks, but it demonstrates the normal flow of operation in the dispatcher.

<a name='dispatch-loop-events'></a>

### Dispatch Loop Events

[Phalcon\Mvc\Dispatcher](api/Phalcon_Mvc_Dispatcher) is able to send events to an [EventsManager](/4.0/en/events) if it is present. Events are triggered using the type `dispatch`. Some events when returning boolean `false` could stop the active operation. The following events are supported:

| Event Name           | Triggered                                                                                                                                                                                                      | Can stop operation? | Triggered on          |
| -------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------- | --------------------- |
| beforeDispatchLoop   | Triggered before entering in the dispatch loop. At this point the dispatcher don't know if the controller or the actions to be executed exist. The Dispatcher only knows the information passed by the Router. | Tak                 | Listeners             |
| beforeDispatch       | Triggered after entering in the dispatch loop. At this point the dispatcher don't know if the controller or the actions to be executed exist. The Dispatcher only knows the information passed by the Router.  | Tak                 | Listeners             |
| beforeExecuteRoute   | Triggered before executing the controller/action method. At this point the dispatcher has been initialized the controller and know if the action exist.                                                        | Tak                 | Listeners/Controllers |
| initialize           | Allow to globally initialize the controller in the request                                                                                                                                                     | Nie                 | Controllers           |
| afterExecuteRoute    | Triggered after executing the controller/action method. As operation cannot be stopped, only use this event to make clean up after execute the action                                                          | Nie                 | Listeners/Controllers |
| beforeNotFoundAction | Triggered when the action was not found in the controller                                                                                                                                                      | Tak                 | Listeners             |
| beforeException      | Triggered before the dispatcher throws any exception                                                                                                                                                           | Tak                 | Listeners             |
| afterDispatch        | Triggered after executing the controller/action method. As operation cannot be stopped, only use this event to make clean up after execute the action                                                          | Tak                 | Listeners             |
| afterDispatchLoop    | Triggered after exiting the dispatch loop                                                                                                                                                                      | Nie                 | Listeners             |
| afterBinding         | Triggered after models are bound but before executing route                                                                                                                                                    | Tak                 | Listeners/Controllers |

The [INVO](/4.0/en/tutorial-invo) tutorial shows how to take advantage of dispatching events implementing a security filter with [Acl](/4.0/en/acl)

The following example demonstrates how to attach listeners to this component:

```php
<?php

use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

$di->set(
    'dispatcher',
    function () {
        // Create an event manager
        $eventsManager = new EventsManager();

        // Attach a listener for type 'dispatch'
        $eventsManager->attach(
            'dispatch',
            function (Event $event, $dispatcher) {
                // ...
            }
        );

        $dispatcher = new MvcDispatcher();

        // Bind the eventsManager to the view component
        $dispatcher->setEventsManager($eventsManager);

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

class PostsController extends Controller
{
    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        // Executed before every found action
    }

    public function afterExecuteRoute(Dispatcher $dispatcher)
    {
        // Executed after every found action
    }
}
```

<h5 class='alert alert-warning'>Methods on event listeners accept an <a href="api/Phalcon_Events_Event">Phalcon\Events\Event</a> object as their first parameter - methods in controllers do not. </h5>

<a name='forwarding'></a>

## Forwarding to other actions

The dispatch loop allows us to forward the execution flow to another controller/action. This is very useful to check if the user can access to certain options, redirect users to other screens or simply reuse code.

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function saveAction($year, $postTitle)
    {
        // ... Store some product and forward the user

        // Forward flow to the index action
        $this->dispatcher->forward(
            [
                'controller' => 'posts',
                'action'     => 'index',
            ]
        );
    }
}
```

Keep in mind that making a `forward` is not the same as making a HTTP redirect. Although they apparently got the same result. The `forward` doesn't reload the current page, all the redirection occurs in a single request, while the HTTP redirect needs two requests to complete the process.

More forwarding examples:

```php
<?php

// Forward flow to another action in the current controller
$this->dispatcher->forward(
    [
        'action' => 'search'
    ]
);

// Forward flow to another action in the current controller
// passing parameters
$this->dispatcher->forward(
    [
        'action' => 'search',
        'params' => [1, 2, 3]
    ]
);
```

A `forward` action accepts the following parameters:

| Parametr     | Description                                             |
| ------------ | ------------------------------------------------------- |
| `controller` | A valid controller name to forward to.                  |
| `action`     | A valid action name to forward to.                      |
| `params`     | An array of parameters for the action.                  |
| `namespace`  | A valid namespace name where the controller is part of. |

<a name='forwarding-events-manager'></a>

### Using the Events Manager

You can use the `dispatcher::beforeForward` event to change modules and redirect easier and "cleaner":

```php
<?php

use Phalcon\Di;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Event;

$di = new Di();

$modules = [
  'backend' => [
      'className' => 'App\Backend\Bootstrap',
      'path'      => '/app/Modules/Backend/Bootstrap.php',
      'metadata'  => [
          'controllersNamespace' => 'App\Backend\Controllers',
      ],
  ],
];

$manager = new Manager();

$manager->attach(
  'dispatch:beforeForward',
  function (Event $event, Dispatcher $dispatcher, array $forward) use ($modules) {
      $metadata = $modules[$forward['module']]['metadata'];
      $dispatcher->setModuleName($forward['module']);
      $dispatcher->setNamespaceName($metadata['controllersNamespace']);
  }
);

$dispatcher = new Dispatcher();
$dispatcher->setDI($di);
$dispatcher->setEventsManager($manager);
$di->set('dispatcher', $dispatcher);
$dispatcher->forward(
  [
      'module'     => 'backend',
      'controller' => 'posts',
      'action'     => 'index',
  ]
);

echo $dispatcher->getModuleName(); // will display properly 'backend'
```

<a name='preparing-parameters'></a>

## Preparing Parameters

Thanks to the hook points provided by [Phalcon\Mvc\Dispatcher](api/Phalcon_Mvc_Dispatcher) you can easily adapt your application to any URL schema; i.e. you might want your URLs look like: `https://example.com/controller/key1/value1/key2/value`. Since parameters are passed with the order that they are defined in the URL to actions, you can transform them to adopt the desired schema:

```php
<?php

use Phalcon\Dispatcher;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

$di->set(
    'dispatcher',
    function () {
        // Create an EventsManager
        $eventsManager = new EventsManager();

        // Attach a listener
        $eventsManager->attach(
            'dispatch:beforeDispatchLoop',
            function (Event $event, $dispatcher) {
                $params = $dispatcher->getParams();

                $keyParams = [];

                // Use odd parameters as keys and even as values
                foreach ($params as $i => $value) {
                    if ($i & 1) {
                        // Previous param
                        $key = $params[$i - 1];

                        $keyParams[$key] = $value;
                    }
                }

                // Override parameters
                $dispatcher->setParams($keyParams);
            }
        );

        $dispatcher = new MvcDispatcher();

        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);
```

If the desired schema is: `https://example.com/controller/key1:value1/key2:value`, the following code is required:

```php
<?php

use Phalcon\Dispatcher;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

$di->set(
    'dispatcher',
    function () {
        // Create an EventsManager
        $eventsManager = new EventsManager();

        // Attach a listener
        $eventsManager->attach(
            'dispatch:beforeDispatchLoop',
            function (Event $event, $dispatcher) {
                $params = $dispatcher->getParams();

                $keyParams = [];

                // Explode each parameter as key,value pairs
                foreach ($params as $number => $value) {
                    $parts = explode(':', $value);

                    $keyParams[$parts[0]] = $parts[1];
                }

                // Override parameters
                $dispatcher->setParams($keyParams);
            }
        );

        $dispatcher = new MvcDispatcher();

        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);
```

<a name='getting-parameters'></a>

## Getting Parameters

When a route provides named parameters you can receive them in a controller, a view or any other component that extends [Phalcon\Di\Injectable](api/Phalcon_Di_Injectable).

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function saveAction()
    {
        // Get the post's title passed in the URL as parameter
        // or prepared in an event
        $title = $this->dispatcher->getParam('title');

        // Get the post's year passed in the URL as parameter
        // or prepared in an event also filtering it
        $year = $this->dispatcher->getParam('year', 'int');

        // ...
    } }
```

<a name='preparing-actions'></a>

## Preparing actions

You can also define an arbitrary schema for actions `before` in the dispatch loop.

<a name='preparing-actions-camelizing-action-names'></a>

### Camelize action names

If the original URL is: `https://example.com/admin/products/show-latest-products`, and for example you want to camelize `show-latest-products` to `ShowLatestProducts`, the following code is required:

```php
<?php

use Phalcon\Text;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

$di->set(
    'dispatcher',
    function () {
        // Create an EventsManager
        $eventsManager = new EventsManager();

        // Camelize actions
        $eventsManager->attach(
            'dispatch:beforeDispatchLoop',
            function (Event $event, $dispatcher) {
                $dispatcher->setActionName(
                    Text::camelize($dispatcher->getActionName())
                );
            }
        );

        $dispatcher = new MvcDispatcher();

        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);
```

<a name='preparing-actions-removing-legacy-extensions'></a>

### Remove legacy extensions

If the original URL always contains a `.php` extension:

```php
https://example.com/admin/products/show-latest-products.php
https://example.com/admin/products/index.php
```

You can remove it before dispatch the controller/action combination:

```php
<?php

use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

$di->set(
    'dispatcher',
    function () {
        // Create an EventsManager
        $eventsManager = new EventsManager();

        // Remove extension before dispatch
        $eventsManager->attach(
            'dispatch:beforeDispatchLoop',
            function (Event $event, $dispatcher) {
                $action = $dispatcher->getActionName();

                // Remove extension
                $action = preg_replace('/\.php$/', '', $action);

                // Override action
                $dispatcher->setActionName($action);
            }
        );

        $dispatcher = new MvcDispatcher();

        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);
```

<a name='preparing-actions-inject-model-instances'></a>

### Inject model instances

In this example, the developer wants to inspect the parameters that an action will receive in order to dynamically inject model instances.

The controller looks like:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    /**
     * Shows posts
     *
     * @param \Posts $post
     */
    public function showAction(Posts $post)
    {
        $this->view->post = $post;
    }
}
```

Method `showAction` receives an instance of the model `\Posts`, the developer could inspect this before dispatch the action preparing the parameter accordingly:

```php
<?php

use \Exception;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use \ReflectionMethod;

$di->set(
    'dispatcher',
    function () {
        // Create an EventsManager
        $eventsManager = new EventsManager();

        $eventsManager->attach(
            'dispatch:beforeDispatchLoop',
            function (Event $event, $dispatcher) {
                // Possible controller class name
                $controllerName = $dispatcher->getControllerClass();

                // Possible method name
                $actionName = $dispatcher->getActiveMethod();

                try {
                    // Get the reflection for the method to be executed
                    $reflection = new ReflectionMethod($controllerName, $actionName);

                    $parameters = $reflection->getParameters();

                    // Check parameters
                    foreach ($parameters as $parameter) {
                        // Get the expected model name
                        $className = $parameter->getClass()->name;

                        // Check if the parameter expects a model instance
                        if (is_subclass_of($className, Model::class)) {
                            $model = $className::findFirstById($dispatcher->getParams()[0]);

                            // Override the parameters by the model instance
                            $dispatcher->setParams([$model]);
                        }
                    }
                } catch (Exception $e) {
                    // An exception has occurred, maybe the class or action does not exist?
                }
            }
        );

        $dispatcher = new MvcDispatcher();

        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);
```

The above example has been simplified. A developer can improve it to inject any kind of dependency or model in actions before be executed.

From 3.1.x onwards the dispatcher also comes with an option to handle this internally for all models passed into a controller action by using [Phalcon\Mvc\Model\Binder](api/Phalcon_Mvc_Model_Binder).

```php
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Model\Binder;

$dispatcher = new Dispatcher();

$dispatcher->setModelBinder(new Binder());

return $dispatcher;
```

<h5 class='alert alert-warning'>Since the Binder object is using internally Reflection Api which can be heavy, there is ability to set cache. This can be done by using second argument in <code>setModelBinder()</code> which can also accept service name or just by passing cache instance to <code>Binder</code> constructor. </h5>

It also introduces a new interface [Phalcon\Mvc\Model\Binder\BindableInterface](api/Phalcon_Mvc_Model_Binder_BindableInterface) which allows you to define the controllers associated models to allow models binding in base controllers.

For example, you have a base `CrudController` which your `PostsController` extends from. Your `CrudController` looks something like this:

```php
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model;

class CrudController extends Controller
{
    /**
     * Show action
     *
     * @param Model $model
     */
    public function showAction(Model $model)
    {
        $this->view->model = $model;
    }
}
```

In your PostsController you need to define which model the controller is associated with. This is done by implementing the [Phalcon\Mvc\Model\Binder\BindableInterface](api/Phalcon_Mvc_Model_Binder_BindableInterface) which will add the `getModelName()` method from which you can return the model name. It can return string with just one model name or associative array where key is parameter name.

```php
use Phalcon\Mvc\Model\Binder\BindableInterface;
use Models\Posts;

class PostsController extends CrudController implements BindableInterface
{
    public static function getModelName()
    {
        return Posts::class;
    }
}
```

By declaring the model associated with the `PostsController` the binder can check the controller for the `getModelName()` method before passing the defined model into the parent show action.

If your project structure does not use any parent controller you can of course still bind the model directly into the controller action:

```php
use Phalcon\Mvc\Controller;
use Models\Posts;

class PostsController extends Controller
{
    /**
     * Shows posts
     *
     * @param Posts $post
     */
    public function showAction(Posts $post)
    {
        $this->view->post = $post;
    }
}
```

<h5 class='alert alert-warning'>Currently the binder will only use the models primary key to perform a <code>findFirst()</code> on. An example route for the above would be <code>/posts/show/{1}</code> </h5>

<a name='handling-404'></a>

## Handling Not-Found Exceptions

Using the [EventsManager](/4.0/en/events) it's possible to insert a hook point before the dispatcher throws an exception when the controller/action combination wasn't found:

```php
<?php

use Exception;
use Phalcon\Dispatcher;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Dispatcher\Exception as DispatchException;

$di->setShared(
    'dispatcher',
    function () {
        // Create an EventsManager
        $eventsManager = new EventsManager();

        // Attach a listener
        $eventsManager->attach(
            'dispatch:beforeException',
            function (Event $event, $dispatcher, Exception $exception) {
                // Handle 404 exceptions
                if ($exception instanceof DispatchException) {
                    $dispatcher->forward(
                        [
                            'controller' => 'index',
                            'action'     => 'show404',
                        ]
                    );

                    return false;
                }

                // Alternative way, controller or action doesn't exist
                switch ($exception->getCode()) {
                    case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                    case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                        $dispatcher->forward(
                            [
                                'controller' => 'index',
                                'action'     => 'show404',
                            ]
                        );

                        return false;
                }
            }
        );

        $dispatcher = new MvcDispatcher();

        // Bind the EventsManager to the dispatcher
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);
```

Of course, this method can be moved onto independent plugin classes, allowing more than one class take actions when an exception is produced in the dispatch loop:

```php
<?php

use Exception;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Dispatcher\Exception as DispatchException;

class ExceptionsPlugin
{
    public function beforeException(Event $event, Dispatcher $dispatcher, Exception $exception)
    {
        // Default error action
        $action = 'show503';

        // Handle 404 exceptions
        if ($exception instanceof DispatchException) {
            $action = 'show404';
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

<h5 class='alert alert-danger'>Only exceptions produced by the dispatcher and exceptions produced in the executed action are notified in the <code>beforeException</code> events. Exceptions produced in listeners or controller events are redirected to the latest try/catch. </h5>

<a name='custom'></a>

## Implementing your own Dispatcher

The [Phalcon\Mvc\DispatcherInterface](api/Phalcon_Mvc_DispatcherInterface) interface must be implemented to create your own dispatcher replacing the one provided by Phalcon.