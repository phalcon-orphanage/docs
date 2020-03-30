---
layout: default
language: 'es-es'
version: '4.0'
title: 'Controladores'
keywords: 'controllers, mvc'
---

# Controladores

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Controladores

Un controlador es una clase que contiene la lógica de negocio para una aplicación. También es responsable de ejecutar las solicitudes de los usuarios. Los controladores tienen métodos llamados *acciones* que contienen esa lógica de negocio y gestionan las solicitudes de los usuarios.

Una acción es cualquier método público en un controlador con el sufijo `Action`. Estas *acciones* son accesibles a través de una URL y son responsables de interpretar la solicitud y crear la respuesta. Normalmente las respuestas tienen forma de una vista renderizada, pero también hay otras formas de crear respuestas.

Los controladores en Phalcon **deben** tener el sufijo `Controller` en su nombre de archivo y de clase y **deben** extender la clase [Phalcon\Mvc\Controller](api/phalcon_mvc#mvc-controller).

> **NOTA**: El controlador por defecto (cuando no se ha especificado ninguno en la URL) es **IndexController** y la acción por defecto (cuando no se ha especificado ninguna en la URL) es **indexAction**.
{: .alert .alert-info }

## Enrutamiento

El [enrutamiento](routing) se explica más en detalle en el documento correspondiente. No obstante, el formato de ruta por defecto es:

```bash
/:module/:controller/:action/:parameter1/:parameter2
```

Puedes encontrar más información acerca de los módulos en el documento dedicado a la [aplicación](application). Para una aplicación que no tiene ningún módulo, el formato de ruta por defecto es:

```bash
/:controller/:action/:parameter1/:parameter2
```

Como resultado, la URL:

```bash
https://dev.phalcon.ld/invoices/list/2/25
```

tendrá:

| Slug       | Descripción    |
| ---------- | -------------- |
| `invoices` | **Controller** |
| `list`     | **Action**     |
| `2`        | **Parameter1** |
| `25`       | **Parameter2** |

La dirección arriba descrita llamará a `InvoiceController` y `listAction`. Los parámetros estarán disponibles a través de la solicitud [](request) en el controlador y la acción.

Las clases de controlador pueden estar en cualquier carpeta de la aplicación, siempre y cuando el autoloader sepa dónde buscarlas en el momento en el que se las llame. [Phalcon\Loader](loader) tiene numerosas opciones para registrar directorios, espacios de nombres, etc. con el propósito de ayudar a descubrir los controladores.

A continuación un ejemplo de controlador:

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

## Inicialización

[Phalcon\Mvc\Controller](api/phalcon_mvc#mvc-controller) llama al método `initialize()` (si está presente) primero, antes de que cualquier acción se ejecute en un controlador.

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

> **NOTE**: No se recomienda el uso del método `__construct()`.
{: .alert .alert-warning }


> 
> **NOTE**: El método `initialize()` solo se llama si el evento `beforeExecuteRoute` se ha ejecutado correctamente. Esto es así para asegurar que si tienes el código de verificación de autorización en el evento, `inicialize` nunca será invocado.
{: .alert .alert-warning }

Si deseas ejecutar alguna lógica de inicialización justo después de que el objeto del controlador sea construido, entonces puedes implementar el método `onConstruct()`:

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

> **NOTA**: Ten en cuenta que `onConstruct()` se ejecuta incluso si la acción a ejecutar no existe en el controlador o el usuario no tiene acceso a él (asumiendo que el control de acceso personalizado está implementado en la aplicación).
{: .alert .alert-warning }

## Dispatch Loop

El dispatch loop se ejecutará dentro del [Dispatcher](dispatcher) hasta que no quede ninguna acción por ejecutar. En los ejemplos anteriores se mostraba el código en una única acción, la cual se ejecutará con la solicitud apropiada.

Podemos utilizar el objeto [Dispatcher](dispatcher) para reenviar la solicitud a un módulo, controlador o acción diferente, creando así un flujo de operaciones más complejo en el dispatch loop.

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

Si los usuarios no tienen permiso para acceder a una determinada acción, entonces serán reenviados a la acción de `inicio de sesión` en el controlador `UsersController`.

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

Lo anterior es un simple ejemplo de reenvio para los usuarios que no han iniciado sesión o que no tienen acceso. Puedes consultar la sección de Eventos más abajo sobre cómo aprovechar los eventos para hacer lo mismo globalmente para tu aplicación.

No hay límite para las llamadas de `reenvío` que puedas tener en tu aplicación. Sin embargo, hay que tener cuidado ya que el reenvío podría conducir a referencias circulares, momento en el cual tu aplicación se detendrá. Si no hay otras acciones que enviar por el dispatch loop, el dispatcher invocará automáticamente la capa de la vista del MVC administrada por [Phalcon\Mvc\View](views).

## Acciones

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

## Eventos

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