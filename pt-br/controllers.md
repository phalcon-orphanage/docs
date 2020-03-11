---
layout: default
language: 'pt-br'
version: '4.0'
title: 'Controllers'
keywords: 'controllers, mvc'
---

# Controllers

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview

A controller is a class that contains business logic for an application. It is also responsible for executing the requests from users. Controllers have methods called *actions* that contain such business logic and handle user requests.

An action is any public method in a controller with the `Action` suffix. These *actions* are accessible by a URL and are responsible for interpreting the request and creating the response. Usually responses are in the form of a rendered view, but there are other ways to create responses as well.

Controllers in Phalcon **must** have the suffix `Controller` in their file and class name and **must** extend the [Phalcon\Mvc\Controller](api/phalcon_mvc#mvc-controller) class.

> **NOTE**: The default controller (when no controller has been specified in the UR)L is **IndexController** and the default action (when no action has been specified in the URL) is **indexAction**.
{: .alert .alert-info }

## Routing

[Routing](routing) is further explained in the relevant document. However the default route is:

```bash
/:module/:controller/:action/:parameter1/:parameter2
```

You can find more information about modules in the <application> document. For an application that does not have any modules, the default routes are:

```bash
/:controller/:action/:parameter1/:parameter2
```

As a result, the URL:

```bash
https://dev.phalcon.ld/invoices/list/2/25
```

will have:

| Slug       | Description    |
| ---------- | -------------- |
| `invoices` | **Controller** |
| `list`     | **Action**     |
| `2`        | **Parameter1** |
| `25`       | **Parameter2** |

The above will call the `InvoicesController` and `listAction`. The parameters will be available through the <request> in the controller and action.

Controller classes can be in any folder in your application, so long as your autoloader knows where to look for them when called. [Phalcon\Loader](loader) has numerous options for registering directories, namespaces etc. to help with the discovery of the controllers.

A sample controller is as follows:

```php
<?php

use Phalcon\Mvc\Controller;

class InvoicesController extends Controller
{
    public function indexAction()
    {

    }

    public function listAction(int $page = 1, int $perPage = 25)
    {

    }
}
```

## Initialization

[Phalcon\Mvc\Controller](api/phalcon_mvc#mvc-controller) calls the `initialize()` method (if present) first, before any action is executed on a controller.

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Tag;

/**
 * @property Tag $tag
 */
class InvoicesController extends Controller
{
    public function initialize()
    {
        $this->tag->setTitle('Invoices Management');
    }

    public function listAction(int $page = 1, int $perPage = 25)
    {

    }
}
```

> **NOTE**: The use of the `__construct()` method is not recommended.
{: .alert .alert-warning }


> 
> **NOTE**: The `initialize()` method is only called if the `beforeExecuteRoute` event has been executed successfully. This is to ensure that if you have authorization checking code in the event, `initialize` will never be invoked
{: .alert .alert-warning }

If you want to execute some initialization logic just after the controller object is constructed then you can implement the `onConstruct()` method:

```php
<?php

use Phalcon\Mvc\Controller;

class InvoicesController extends Controller
{
    public function onConstruct()
    {
        // ...
    }
}
```

> **NOTE**: Note that `onConstruct()` is executed even if the action to be executed does not exist in the controller or the user does not have access to it (assuming custom access control is implemented in the application).
{: .alert .alert-warning }

## Dispatch Loop

The dispatch loop will be executed within the [Dispatcher](dispatcher) until there are no actions left to be executed. In the examples above we showed code in only one action, which will be executed with the appropriate request.

We can utilize the [Dispatcher](dispatcher) object to forward the request to a different module, controller or action, thus creating a more complex flow of operations in the dispatch loop.

```php
<?php

use Phalcon\Dispatcher;
use Phalcon\Flash\Direct;
use Phalcon\Mvc\Controller;

/**
 * @property Dispatcher $dispatcher
 * @property Direct     $flash
 */
class InvoicesController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction($year, $postTitle)
    {
        $this->flash->error(
            "You do not have permission to access this area"
        );

        // Forward flow to another action
        $this->dispatcher->forward(
            [
                'controller' => 'users',
                'action'     => 'login',
            ]
        );
    }
}
```

If users do not have permission to access the particular action, they will be forwarded to the `login` action in the `UsersController`.

```php
<?php

use Phalcon\Mvc\Controller;

class UsersController extends Controller
{
    public function indexAction()
    {

    }

    public function loginAction()
    {

    }
}
```

The above is a simple example of forwarding for users that are not logged in or do not have access. You can check the Events section below on how you can leverage events to do the same thing globally for your application.

There is no limit on the `forward` calls you can have in your application. You have to be careful though, since forwarding could lead to circular references, at which point your application will halt. If there are no other actions to be dispatched by the dispatch loop, the dispatcher will automatically invoke the view layer of the MVC that is managed by [Phalcon\Mvc\View](views).

## Actions

Actions are methods that are called to execute the necessary functionality for our application. Actions **must** be suffixed by `Action` and they match a route request from the user.

```php
<?php

use Phalcon\Mvc\Controller;

class InvoicesController extends Controller
{
    public function listAction(int $page = 1, int $perPage = 25)
    {

    }

    public function other()
    {

    }
}
```

For the above example:

```php
/invoices/list
```

will tell the dispatcher to call the `listAction` method with any parameters passed. However

```bash
/invoices/other
```

will result in a `404` - page not found.

## Parameters

Additional URI parameters are defined as action parameters, so that they can be easily accessed using local variables. A controller can optionally extend [Phalcon\Mvc\Controller](api/phalcon_mvc#mvc-controller). By doing this, the controller can have easy access to the application services.

Parameters without a default value are handled as required. Setting optional values for parameters is done as in PHP:

```php
<?php

use Phalcon\Mvc\Controller;

class InvoicesController extends Controller
{
    public function indexAction()
    {

    }

    public function listAction(int $page = 1, int $perPage = 25)
    {

    }
}
```

> **NOTE**: You will need to add additional code to ensure that the data passed is of the correct type and either use the default value or have a correct value. If not, you will end up with errors.
{: .alert .alert-warning }

For the example above, the URL to call the method is:

```php
/invoices/list/2/10
```

However, you will need to ensure that you account for a URL like this one:

```php
/invoices/list/wrong-value/another-wrong-value
```

The above URL will not match the `int` for the `$page` or `perPage` and thus result in an error. You might want to consider a strategy to counter that. One way is to remove the types and ensure that your parameters are converted in the action:

```php
<?php

use Phalcon\Mvc\Controller;

class InvoicesController extends Controller
{
    public function indexAction()
    {

    }

    public function listAction($page = 1, $perPage = 25)
    {
        $page    = (int) $page;
        $perPage = (int) $perPage;
    }
}
```

You can also remove the parameters from the action declaration and retrieve them from the dispatcher instead. Parameters are assigned in the same order as they were passed in the route. You can get a parameter from its name as follows:

```php
<?php

use Phalcon\Dispatcher;
use Phalcon\Mvc\Controller;

/**
 * @property Dispatcher $dispatcher
 */
class InvoicesController extends Controller
{
    public function indexAction()
    {

    }

    public function listAction()
    {
        $year      = $this->dispatcher->getParam('year');
        $postTitle = $this->dispatcher->getParam('postTitle');
    }
}
```

The above parameters will match the route the way it was defined.

## Events

Controllers automatically act as listeners for <dispatcher> <events>, implementing methods with those event names allowing you to implement hook points before/after the actions are executed:

```php
<?php

use Phalcon\Dispatcher;
use Phalcon\Flash\Direct;
use Phalcon\Mvc\Controller;

/**
 * @property Dispatcher\ $dispatcher
 * @property Direct      $flash
 */
class InvoicesController extends Controller
{
    public function beforeExecuteRoute($dispatcher)
    {
        // This is executed before every found action
        if ($dispatcher->getActionName() === 'save') {
            $this->flash->error(
                "You do not have permission to save invoices"
            );

            $this->dispatcher->forward(
                [
                    'controller' => 'home',
                    'action'     => 'index',
                ]
            );

            return false;
        }
    }

    public function afterExecuteRoute($dispatcher)
    {
        // Executed after every found action
    }
}
```

## Request - Response

If you have already registered a [Request](request) and [Response](response) services to your DI container or have simply instantiated the [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) one, you can access these objects as properties in your controller.

For [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault), your objects will be [Phalcon\Http\Request](api/phalcon_http#http-request) for `request` and [Phalcon\Http\Response](api/phalcon_http#http-response) for response. The `request` contains the request from the user, including all the variables set by the method use (`GET`, `POST` etc.) along with additional information regarding the request. The `response` contains data that we need to send back such as `content-type`, status code, payload etc.

> **NOTE**: In order to access the services from your controller, you will need to extend the `Phalcon\Mvc\Controller` class
{: .alert .alert-info }

```php
<?php

use Phalcon\Http\Request;
use Phalcon\Mvc\Controller;

/**
 * @property Request  $request
 */
class InvoicesController extends Controller
{
    public function indexAction()
    {

    }

    public function listAction()
    {
        if (true === $this->request->isPost()) {
            $page   = $this
                ->request
                ->getPost('page', 'int', 1)
            ;
            $perPage = $this
                ->request
                ->getPost('perPage', 'int', 25)
            ;
        }
    }
}
```

The code above first checks if the request is a `POST` request. If yes, then it gets two variables from the `$_POST` superglobal. The syntax we use is: - Get the variable (`page`) - If it exists, sanitize it to an integer - If it does not exist, return the default `1`

Using this technique, we ensure that all input is properly sanitized and defaults are set.

The response object is not called directly in most cases, rather it is built gradually or attached to the `afterDispatch` event. If for instance we need to send JSON back to the user as a result of an AJAX request, we can do so directly in the action, interacting with the response:

```php
<?php

use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;

/**
 * @property Request  $request
 * @property Response $response
 */
class InvoicesController extends Controller
{
    public function indexAction()
    {

    }

    public function listAction()
    {
        if (true === $this->request->isPost()) {
            $page   = $this
                ->request
                ->getPost('page', 'int', 1)
            ;
            $perPage = $this
                ->request
                ->getPost('perPage', 'int', 25)
            ;

            // ......

            $data = $records->toArray();

            $this
                ->response
                ->setStatusCode(200, 'OK')
                ->setJsonContent($data)
            ;
        }
    }
}
```

Assuming that you have code that sets the status code and content type for the response in the `afterDispatch` or `afterExecuteRoute` events, you can always return directly the data. Phalcon will set that as the returned payload. This is particularly useful when writing APIs.

```php
<?php

use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property Request  $request
 * @property Response $response
 * @property View     $view
 */
class InvoicesController extends Controller
{
    public function indexAction()
    {

    }

    public function listAction()
    {
        if (true === $this->request->isPost()) {
            $page   = $this
                ->request
                ->getPost('page', 'int', 1)
            ;
            $perPage = $this
                ->request
                ->getPost('perPage', 'int', 25)
            ;

            // ......

            return $records->toArray();
        }
    }

    public function afterExecuteRoute($dispatcher)
    {
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
        $this->response->setHeader('Cache-Control', 'no-store');

        /** @var array $data */
        $data = $dispatcher->getReturnedValue();
        $dispatcher->setReturnedValue([]);

        if (true !== $this->response->isSent()) {
            $this->response->setJsonContent($data);

            return $this->response->send();
        }
    }
}
```

In the above example, we return an array from our action. The `afterExecuteRoute` method disables the view, sets the content type to JSON, and then if the response has not been sent, sets the JSON content and sends the response.

## Session

Sessions help us maintain persistent data between requests. You can access a [Phalcon\Session\Bag](api/phalcon_session#session-bag) from any controller using the property `persistent` to encapsulate data that needs to be persistent:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Session\Bag;

/**
 * @property Bag $persistent
 */
class UserController extends Controller
{
    public function indexAction()
    {
        $this->persistent->name = 'Darth';
    }

    public function welcomeAction()
    {
        echo 'Welcome, ', $this->persistent->name;
    }
}
```

> **NOTE**: Note that the `persistent` service is automatically registered for any component (including controllers) that extend the `Phalcon\Di\Injectable` class
{: .alert .alert-info }

## Dependency Injection

You can create a controller as a stand alone class. However you can extend the [Phalcon\Mvc\Controller](api/phalcon_mvc#mvc-controller) class which will expose the whole DI container to you. Each service will be available using its name as a property of the controller:

```php
<?php

use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;

/**
 * @property Request  $request
 * @property Response $response
 * @property View     $view
 */
class InvoicesController extends Controller
{
    public function indexAction()
    {

    }

    public function listAction()
    {
        if (true === $this->request->isPost()) {
            $page   = $this
                ->request
                ->getPost('page', 'int', 1)
            ;
            $perPage = $this
                ->request
                ->getPost('perPage', 'int', 25)
            ;

            // ......

            return $records->toArray();
        }
    }

    public function afterExecuteRoute($dispatcher)
    {
        $this->view->disable();
        $this->response->setContentType('application/json', 'UTF-8');
        $this->response->setHeader('Cache-Control', 'no-store');

        /** @var array $data */
        $data = $dispatcher->getReturnedValue();
        $dispatcher->setReturnedValue([]);

        if (true !== $this->response->isSent()) {
            $this->response->setJsonContent($data);

            return $this->response->send();
        }
    }
}
```

In the above example, we access the `request`, `response` and `view` services that are automatically injected in our controller.

## Services as Controllers

Services can act as controllers. Controllers are classes that are always requested from the DI container. As a result, any other class registered with the correct name can easily replace a controller:

```php
<?php

use MyApp\Controllers\InvoicesController;
use MyApp\Components\AlternativeInvoice;

$container->set(
    InvoicesController::class,
    function () {
        return new AlternativeInvoice();
    }
);
```