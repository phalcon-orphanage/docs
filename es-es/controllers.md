---
layout: default
language: 'es-es'
version: '5.0'
title: 'Controladores'
keywords: 'controllers, mvc'
---

# Controladores
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
Un controlador es una clase que contiene la lógica de negocio para una aplicación. También es responsable de ejecutar las solicitudes de los usuarios. Controllers have methods called _actions_ that contain such business logic and handle user requests.

Una acción es cualquier método público en un controlador con el sufijo `Action`. These _actions_ are accessible by a URL and are responsible for interpreting the request and creating the response. Normalmente las respuestas tienen forma de una vista renderizada, pero también hay otras formas de crear respuestas.

Controllers in Phalcon **must** have the suffix `Controller` in their file and class name and **must** extend the [Phalcon\Mvc\Controller][mvc-controller] class.

> **NOTE**: The default controller (when no controller has been specified in the UR)L is **IndexController** and the default action (when no action has been specified in the URL) is **indexAction**. 
> 
> {: .alert .alert-info }

## Ruteo
El [enrutamiento](routing) se explica más en detalle en el documento correspondiente. However, the default route is:

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

| Slug       | Descripción     |
| ---------- | --------------- |
| `invoices` | **Controlador** |
| `list`     | **Acción**      |
| `2`        | **Parameter1**  |
| `25`       | **Parameter2**  |

La dirección arriba descrita llamará a `InvoiceController` y `listAction`. Los parámetros estarán disponibles a través de la solicitud [](request) en el controlador y la acción.

Las clases de controlador pueden estar en cualquier carpeta de la aplicación, siempre y cuando el autoloader sepa dónde buscarlas en el momento en el que se las llame. [Phalcon\Autoload\Loader](autoload) has numerous options for registering directories, namespaces etc. to help with the discovery of the controllers.

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
[Phalcon\Mvc\Controller][mvc-controller] calls the  `initialize()` method (if present) first, before any action is executed on a controller.

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
> 
> {: .alert .alert-warning }


> **NOTE**: The `initialize()` method is only called if the `beforeExecuteRoute` event has been executed successfully. This is to ensure that if you have authorization checking code in the event, `initialize` will never be invoked 
> 
> {: .alert .alert-warning }

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

> **NOTE**: Note that `onConstruct()` is executed even if the action to be executed does not exist in the controller or the user does not have access to it (assuming custom access control is implemented in the application). 
> 
> {: .alert .alert-warning }

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
Las acciones son métodos que se llaman para ejecutar la funcionalidad necesaria para nuestra aplicación. Actions **must** be suffixed by `Action` and they match a route request from the user.

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

Para el ejemplo anterior:

```php
/invoices/list
```

le dirá al dispatcher que llame al método `listAction` con los parámetros que se le hayan pasado. Sin embargo

```bash
/invoices/other
```

devolverá un `404` - página no encontrada.

## Parámetros
Los parámetros adicionales del URI se definen como parámetros de la acción, de modo que puedan ser fácilmente accesibles usando variables locales. A controller can optionally extend [Phalcon\Mvc\Controller][mvc-controller]. De esta manera, el controlador puede acceder fácilmente a los servicios de la aplicación.

Los parámetros sin ningún valor por defecto son tratados como obligatorios. Establecer los parámetros con valores opcionales se realiza como de costumbre en PHP:

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

> **NOTE**: You will need to add additional code to ensure that the data passed is of the correct type and either use the default value or have a correct value. Sinó, acabarás con errores. 
> 
> {: .alert .alert-warning }

Para el ejemplo anterior, la URL para llamar al método es:

```php
/invoices/list/2/10
```
Sin embargo, tendrás que asegurarte de tener en cuenta una URL como ésta:

```php
/invoices/list/wrong-value/another-wrong-value
```
En la URL anterior ni el parámetro `$page` ni `$perPage` concordarán con el tipo `int` y por lo tanto se producirá un error. Puede que quieras considerar otra estrategia para contrarrestar esto. Una forma de solucionarlo es eliminar los tipos y asegurarse de que los parámetros se convierten al tipo correcto dentro de la acción:

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

También puedes eliminar los parámetros de la declaración de la acción y recuperarlos del dispatcher en su lugar. Los parámetros se asignan en el mismo orden en el que aparecen en la ruta. Puedes obtener un parámetro por su nombre de la siguiente manera:

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
        $page      = $this->dispatcher->getParam('page');
        $perPage = $this->dispatcher->getParam('perPage');
    }
}
```

Los parámetros anteriores coincidirán con la ruta tal y como fue definida.

## Eventos
Los controladores funcionan también como *escuchas (listeners)* de los [eventos](events) del *[despachador (dispatcher)](dispatcher)*. Tienen métodos para cada evento, por lo cual se pueden crear *puntos de enganche* antes y después de que las acciones sean ejecutadas:

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

## Solicitud - Respuesta
If you have already registered a [Request](request) and [Response](response) services to your DI container or have simply instantiated the [Phalcon\Di\FactoryDefault][di-factorydefault] one, you can access these objects as properties in your controller.

For [Phalcon\Di\FactoryDefault][di-factorydefault], your objects will be [Phalcon\Http\Request][request] for `request` and [Phalcon\Http\Response][response] for response. La `solicitud` contiene la solicitud del usuario, incluyendo todas las variables establecidas por el método (`GET`, `POST`, etc.) junto con información adicional sobre la solicitud. La `respuesta` contiene datos que necesitamos enviar como `content-type`, código de estado, payload, etc.

> **NOTE**: In order to access the services from your controller, you will need to extend the `Phalcon\Mvc\Controller` class 
> 
> {: .alert .alert-info }

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

El código anterior comprueba primero si la solicitud es una solicitud de tipo `POST`. Si es así, entonces obtiene dos variables del superglobal `$_POST`. The syntax we use is:
- Get the variable (`page`)
- If it exists, sanitize it to an integer
- If it does not exist, return the default `1`

Usando esta técnica, nos aseguramos de que toda la entrada esté correctamente saneada y que se establezcan los valores predeterminados.

El objeto de respuesta no se llama directamente en la mayoría de los casos, sino que se construye gradualmente o se une al evento `afterDispatch`. Si por ejemplo necesitamos devolver un JSON al usuario como resultado de una solicitud AJAX, podemos hacerlo directamente en la acción, interactuando con la respuesta:

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

Suponiendo que tengas un código que establece el código de estado y el tipo de contenido para la respuesta en los eventos `afterDispatch` o `afterExecuteRoute` siempre puedes devolver directamente los datos. Phalcon lo establecerá como el payload devuelto. Esto es particularmente útil al escribir APIs.

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

En el ejemplo anterior, devolvemos un array desde nuestra acción. El método `afterExecuteRoute` inhabilita la vista, establece el tipo de contenido a JSON, y si la respuesta no ha sido enviada, establece el contenido en formato JSON y envía la respuesta.

## Session
Las sesiones nos ayudan a mantener la persistencia de datos entre las solicitudes. You can access a [Phalcon\Session\Bag][session-bag] from any controller using the property `persistent` to encapsulate data that needs to be persistent:

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
> 
> {: .alert .alert-info }

## Inyección de Dependencias
You can create a controller as a stand-alone class. However, you can extend the [Phalcon\Mvc\Controller][mvc-controller] class which will expose the whole DI container to you. Cada servicio estará disponible utilizando su nombre como una propiedad del controlador:

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

En el ejemplo anterior, accedemos a los servicios de `solicitud`, `respuesta` y `vista` que son inyectados automáticamente en nuestro controlador.

## Servicios como controladores
Los servicios pueden actuar como controladores. Los controladores son clases que siempre son requeridas desde el contenedor DI. Como resultado, cualquier otra clase registrada con el nombre correcto puede reemplazar fácilmente un controlador:

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

[mvc-controller]: api/phalcon_mvc#mvc-controller
[di-factorydefault]: api/phalcon_di#di-factorydefault
[request]: api/phalcon_http#http-request
[response]: api/phalcon_http#http-response
[session-bag]: api/phalcon_session#session-bag
