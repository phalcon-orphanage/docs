* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Controladores

<a name='using'></a>

## Uso de Controladores

Las acciones son métodos en un controlador que manejan las solicitudes. Por defecto todos los métodos públicos en un controlador son acciones y son accesibles por una URL. Las acciones son responsables de interpretar la consulta y crear una respuesta. Las respuestas son generalmente en forma de una vista renderizada, pero también hay otras formas de crear respuestas.

For instance, when you access a URL like this: `https://localhost/blog/posts/show/2015/the-post-title` Phalcon by default will decompose each part like this:

| Descripción           | Slug           |
| --------------------- | -------------- |
| **Phalcon Directory** | blog           |
| **Controller**        | posts          |
| **Action**            | show           |
| **Parameter**         | 2015           |
| **Parameter**         | the-post-title |

En este caso, el controlador `PostsController` se encargará de esta solicitud. There is no a special location to put controllers in an application, they could be loaded using [Phalcon\Loader](api/Phalcon_Loader), so you're free to organize your controllers as you need.

Los controladores deben tener el sufijo `Controller` mientras que las acciones tienen el sufijo `Action`. Un ejemplo de un controlador es el siguiente:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction($year, $postTitle)
    {

    }
}
```

Los parámetros adicionales del URI se definen como parámetros de acción, por lo que se puede acceder fácilmente usando variables locales. A controller can optionally extend [Phalcon\Mvc\Controller](api/Phalcon_Mvc_Controller). Haciendo esto, el controlador puede tener fácil acceso a los servicios de la aplicación.

Los parámetros sin un valor predeterminado son manejados como obligatorios. Ajuste los valores opcionales en los parámetros como se hace en PHP:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction($year = 2015, $postTitle = 'some default title')
    {

    }
}
```

Los parámetros se asignan en el mismo orden como fueron pasados en la ruta. Puede obtener un parámetro arbitrario por su nombre de la siguiente manera:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction()
    {
        $year      = $this->dispatcher->getParam('year');
        $postTitle = $this->dispatcher->getParam('postTitle');
    }
}
```

<a name='dispatch-loop'></a>

## Bucle de Despacho

El bucle de despacho se ejecutará dentro del Dispatcher hasta que no haya ninguna acción para ser ejecutada. En el ejemplo anterior se ha ejecutado sólo una acción. Ahora vamos a ver cómo el método `forward()` puede proporcionar un flujo más complejo de la operación en el bucle de despacho, enviando la ejecución a un controlador y acción diferente.

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function showAction($year, $postTitle)
    {
        $this->flash->error(
            "Ud. no tiene permisos para acceder a esta área"
        );

        // Cambiamos el flujo a otra acción
        $this->dispatcher->forward(
            [
                'controller' => 'users',
                'action'     => 'signin',
            ]
        );
    }
}
```

Si los usuarios no tienen permiso para acceder a una determinada acción entonces ellos se remitirán a la acción `signin` en el controlador `UsersController`.

```php
<?php

use Phalcon\Mvc\Controller;

class UsersController extends Controller
{
    public function indexAction()
    {

    }

    public function signinAction()
    {

    }
}
```

No hay un límite de `forwards` que pueda tener en su aplicación, siempre y cuando no den lugar a referencias circulares, en tal caso se detendrá la aplicación. If there are no other actions to be dispatched by the dispatch loop, the dispatcher will automatically invoke the view layer of the MVC that is managed by [Phalcon\Mvc\View](api/Phalcon_Mvc_View).

<a name='initializing'></a>

## Inicialización de Controladores

[Phalcon\Mvc\Controller](api/Phalcon_Mvc_Controller) offers the `initialize()` method, which is executed first, before any action is executed on a controller. No se recomienda el uso del método `__construct()`.

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public $settings;

    public function initialize()
    {
        $this->settings = [
            'mySetting' => 'value',
        ];
    }

    public function saveAction()
    {
        if ($this->settings['mySetting'] === 'value') {
            // ...
        }
    }
}
```

<h5 class='alert alert-warning'>The <code>initialize()</code> method is only called if the <code>beforeExecuteRoute</code> event is executed with success. This avoid that application logic in the initializer cannot be executed without authorization.</h5>

Si desea ejecutar cierta lógica de inicialización justo después de que se construye el objeto controlador puede implementar el método `onConstruct()`:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function onConstruct()
    {
        // ...
    }
}
```

<h5 class='alert alert-warning'>Be aware that <code>onConstruct()</code> method is executed even if the action to be executed doesn't exist in the controller or the user does not have access to it (according to custom control access provided by the developer).</h5>

<a name='injecting-services'></a>

## Inyección de servicios

If a controller extends [Phalcon\Mvc\Controller](api/Phalcon_Mvc_Controller) then it has easy access to the service container in application. Por ejemplo, si tenemos registrado un servicio como este:

```php
<?php

use Phalcon\Di;

$di = new Di();

$di->set(
    'storage',
    function () {
        return new Storage(
            '/some/directory'
        );
    },
    true
);
```

Entonces, podemos acceder a ese servicio de diferentes maneras:

```php
<?php

use Phalcon\Mvc\Controller;

class FilesController extends Controller
{
    public function saveAction()
    {
        // Inyección de servicios, simplemente accedemos por la propiedad con el mismo nombre
        $this->storage->save('/some/file');

        // Acceso al servicio desde el DI
        $this->di->get('storage')->save('/some/file');

        // Otra forma de acceder al servicio es utilizando los métodos mágicos
        $this->di->getStorage()->save('/some/file');

        // Otra forma válida de utilizar los métodos mágicos
        $this->getDi()->getStorage()->save('/some/file');

        // Utilizando la sintaxis de array
        $this->di['storage']->save('/some/file');
    }
}
```

If you're using Phalcon as a full-stack framework, you can read the services provided [by default](/4.0/en/di) in the framework.

<a name='request-response'></a>

## Request y Response

Suponiendo que el framework proporciona un conjunto de servicios previamente registrados. Explicaremos cómo interactuar con el entorno HTTP. The `request` service contains an instance of [Phalcon\Http\Request](api/Phalcon_Http_Request) and the `response` contains a [Phalcon\Http\Response](api/Phalcon_Http_Response) representing what is going to be sent back to the client.

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
        // Chequeamos si la consulta fue hecha por POST
        if ($this->request->isPost()) {
            // Accedemos al los datos POST
            $customerName = $this->request->getPost('name');
            $customerBorn = $this->request->getPost('born');
        }
    }
}
```

El objeto `response`, generalmente, no se utiliza directamente, pero se construye antes de la ejecución de la acción, a veces (como en un evento `afterDispatch`) puede ser útil para acceder directamente a la respuesta:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {

    }

    public function notFoundAction()
    {
        // Enviar la cabecera de respuesta HTTP 404
        $this->response->setStatusCode(404, 'Not Found');
    }
}
```

Learn more about the HTTP environment in their dedicated articles [request](/4.0/en/request) and [response](/4.0/en/response).

<a name='session-data'></a>

## Datos de Sesión

Las sesiones nos ayudan a mantener la persistencia de datos entre consultas. You can access a [Phalcon\Session\Bag](api/Phalcon_Session_Bag) from any controller to encapsulate data that needs to be persistent:

```php
<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        $this->persistent->name = 'Michael';
    }

    public function welcomeAction()
    {
        echo 'Welcome, ', $this->persistent->name;
    }
}
```

<a name='services'></a>

## Utilizando Servicios como Controladores

Los servicios pueden actuar como controladores, las clases de controladores son siempre solicitadas desde el contenedor de servicios. Por consiguiente, cualquier otra clase registrada con su nombre puede substituir fácilmente a un controlador:

```php
<?php

// Registrar un controlador como servicio
$di->set(
    'IndexController',
    function () {
        $component = new Component();

        return $component;
    }
);

// Registrar un controlador con su namespace como servicio
$di->set(
    'Backend\Controllers\IndexController',
    function () {
        $component = new Component();

        return $component;
    }
);
```

<a name='events'></a>

## Eventos en Controladores

Controllers automatically act as listeners for [dispatcher](/4.0/en/dispatcher) events, implementing methods with those event names allow you to implement hook points before/after the actions are executed:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    public function beforeExecuteRoute($dispatcher)
    {
        // Este método se ejecuta antes de cada acción
        if ($dispatcher->getActionName() === 'save') {
            $this->flash->error(
                "Ud. no tiene permisos para guardar publicaciones"
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
        // Ejecutado después de cada acción
    }
}
```