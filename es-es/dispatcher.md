* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Despachando Controladores

[Phalcon\Mvc\Dispatcher](api/Phalcon_Mvc_Dispatcher) is the component responsible for instantiating controllers and executing the required actions on them in an MVC application. Entender su funcionamiento y capacidades nos ayuda a sacarle más provecho a los servicios prestados por el framework.

<a name='dispatch-loop'></a>

## Bucle de despacho

Esto es un proceso importante que tiene mucho que ver con el flujo MVC, especialmente con la parte de controlador. El trabajo se produce en el despachador de controladores (dispatcher). Los archivos del controlador son leídos, cargados e instanciados. Entonces se ejecutan las acciones requeridas. Si una acción reenvia (forward) a otro controlador/acción, el dispatcher comienza otra vez. To better illustrate this, the following example shows approximately the process performed within [Phalcon\Mvc\Dispatcher](api/Phalcon_Mvc_Dispatcher):

```php
<?php

// Bucle dispatch 
while (!$finished) {
    $finished = true;

    $controllerClass = $controllerName . 'Controller';

    // Instanciamos la clase del controlador mediante autoloaders
    $controller = new $controllerClass();

    // Ejecutamos la acción
    call_user_func_array(
        [
            $controller,
            $actionName . 'Action'
        ],
        $params
    );

    // '$finished' debe ser recargado para chequear si el flujo fue enviado a otro controlador
    $finished = true;
}
```

El código anterior carece de validaciones, filtros y controles adicionales, pero demuestra el flujo normal de operación del dispatcher.

<a name='dispatch-loop-events'></a>

### Eventos del bucle de despacho

[Phalcon\Mvc\Dispatcher](api/Phalcon_Mvc_Dispatcher) is able to send events to an [EventsManager](/4.0/en/events) if it is present. Los eventos se desencadenan mediante el tipo `dispatch`. Si algún evento devuelve `false` podría detener la operación activa. Son soportados los siguientes eventos:

| Nombre de evento     | Disparado                                                                                                                                                                                                         | ¿Detiene la operación? | Activa en             |
| -------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ---------------------- | --------------------- |
| beforeDispatchLoop   | Activado antes de entrar en el bucle de despacho. En este momento el distribuidor no sabe si existen el controlador o las acciones a ejecutarse. El dispatcher sólo conoce la información pasada por el Router.   | Si                     | Oyentes               |
| beforeDispatch       | Activado después de entrar en el bucle de despacho. En este momento el distribuidor no sabe si existen el controlador o las acciones a ejecutarse. El dispatcher sólo conoce la información pasada por el Router. | Si                     | Oyentes               |
| beforeExecuteRoute   | Dispara antes de ejecutar el método de controlador/acción. En este punto el dispatcher ha sido inicializado el controlador y sabe que si existe la acción.                                                        | Si                     | Listeners/Controllers |
| initialize           | Permite inicializar globalmente el controlador en la solicitud                                                                                                                                                    | No                     | Controladores         |
| afterExecuteRoute    | Se activa después de ejecutar el método controlador/acción. No se puede detener la operación, sólo utilice este evento para hacer limpieza tras ejecutar la acción                                                | No                     | Listeners/Controllers |
| beforeNotFoundAction | Se activa cuando la acción no se encuentra en el controlador                                                                                                                                                      | Si                     | Oyentes               |
| beforeException      | Disparado antes de que el dispatcher lance una excepción                                                                                                                                                          | Si                     | Oyentes               |
| afterDispatch        | Se activa después de ejecutar el método controlador/acción. No se puede detener la operación, sólo utilice este evento para hacer limpieza tras ejecutar la acción                                                | Si                     | Oyentes               |
| afterDispatchLoop    | Activa después de salir del bucle de despacho                                                                                                                                                                     | No                     | Oyentes               |
| afterBinding         | Se dispara después de que los modelos están enlazados pero antes de ejecutar la ruta                                                                                                                              | Si                     | Listeners/Controllers |

The [INVO](/4.0/en/tutorial-invo) tutorial shows how to take advantage of dispatching events implementing a security filter with [Acl](/4.0/en/acl)

En el ejemplo siguiente se muestra cómo adjuntar oyentes (listeners) a este componente:

```php
<?php

use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

$di->set(
    'dispatcher',
    function () {
        // Creamos el EventManager
        $eventsManager = new EventsManager();

        // Adjuntamos un listener al tipo 'dispatch'
        $eventsManager->attach(
            'dispatch',
            function (Event $event, $dispatcher) {
                // ...
            }
        );

        $dispatcher = new MvcDispatcher();

        // Enlazamos el eventsManager a la vista
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    },
    true
);
```

Un controlador instanciado automáticamente actúa como un detector de eventos de dispatch, así que usted puede implementar métodos como callbacks:

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

class PostsController extends Controller
{
    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        // Ejecutado antes de cada acción encontrada
    }

    public function afterExecuteRoute(Dispatcher $dispatcher)
    {
        // Ejecutada después de cada acción encontrada
    }
}
```

<h5 class='alert alert-warning'>Methods on event listeners accept an <a href="api/Phalcon_Events_Event">Phalcon\Events\Event</a> object as their first parameter - methods in controllers do not. </h5>

<a name='forwarding'></a>

## Reenvío a otras acciones

El bucle de despacho nos permite cambiar el flujo de ejecución a otro controlador/acción. Esto es muy útil para comprobar si el usuario puede acceder a ciertas opciones, redirigir a los usuarios a otras pantallas o simplemente reutilizar código.

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
        // ... Almacenar algún producto y reenviar al usuario

        // Cambiar el flujo al index action
        $this->dispatcher->forward(
            [
                'controller' => 'posts',
                'action'     => 'index',
            ]
        );
    }
}
```

Tenga en cuenta que un `forward` no es lo mismo que hacer una redirección HTTP. Aunque al parecer consiguen el mismo resultado. El `forward` no vuelve a cargar la página actual, todo el redireccionamiento se produce en una sola solicitud, mientras que la redirección HTTP necesita de dos solicitudes para completar el proceso.

Más ejemplos de forward:

```php
<?php

// Cambiar el flujo a otra action en el controlador actual
$this->dispatcher->forward(
    [
        'action' => 'search'
    ]
);

// Cambiar el flujo a otra action en el controlador actual pero pasando parámetros
$this->dispatcher->forward(
    [
        'action' => 'search',
        'params' => [1, 2, 3]
    ]
);
```

Un `forward` acepta los siguientes parámetros:

| Parameter    | Descripción                                                 |
| ------------ | ----------------------------------------------------------- |
| `controller` | Un nombre de controlador válido donde reenviar.             |
| `action`     | Un nombre válido de acción donde reenviar.                  |
| `params`     | Un array de parámetros para la acción.                      |
| `namespace`  | Un espacio de nombres valido donde es parte el controlador. |

<a name='forwarding-events-manager'></a>

### Usando el administrador de eventos

Puede utilizar el evento `dispatcher::beforeForward` para cambiar módulos y redirigir de una forma más fácil y limpia:

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

echo $dispatcher->getModuleName(); // mostrará 'backend'
```

<a name='preparing-parameters'></a>

## Preparando parámetros

Thanks to the hook points provided by [Phalcon\Mvc\Dispatcher](api/Phalcon_Mvc_Dispatcher) you can easily adapt your application to any URL schema; i.e. you might want your URLs look like: `https://example.com/controller/key1/value1/key2/value`. Los parámetros se pasan con el orden que se definen en la dirección URL a las acciones, puede transformar y adoptar el esquema que Ud. desee:

```php
<?php

use Phalcon\Dispatcher;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

$di->set(
    'dispatcher',
    function () {
        // Crear el EventsManager
        $eventsManager = new EventsManager();

        // Adjuntar el listener
        $eventsManager->attach(
            'dispatch:beforeDispatchLoop',
            function (Event $event, $dispatcher) {
                $params = $dispatcher->getParams();

                $keyParams = [];

                // Usar parámetros impares como claves y pares como valores
                foreach ($params as $i => $value) {
                    if ($i & 1) {
                        // Parámetro anterior
                        $key = $params[$i - 1];

                        $keyParams[$key] = $value;
                    }
                }

                // Sobreescribimos los parámetros
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
        // Crear el EventsManager
        $eventsManager = new EventsManager();

        // Adjuntar el listener
        $eventsManager->attach(
            'dispatch:beforeDispatchLoop',
            function (Event $event, $dispatcher) {
                $params = $dispatcher->getParams();

                $keyParams = [];

                // Separar cada parámetro en pares clave valor
                foreach ($params as $number => $value) {
                    $parts = explode(':', $value);

                    $keyParams[$parts[0]] = $parts[1];
                }

                // Sobre escribimos los parámetros
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

## Obtener parámetros

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
        // Obtener el título pasado en la URL como parámetro
        // o preparado en un evento
        $title = $this->dispatcher->getParam('title');

        // Obtener el año del post pasado en la URL como parámetro
        // o preparado en un evento además de filtrado
        $year = $this->dispatcher->getParam('year', 'int');

        // ...
    }
}
```

<a name='preparing-actions'></a>

## Preparación de acciones

También puede definir un esquema arbitrario para acciones `before` en el bucle de despacho.

<a name='preparing-actions-camelizing-action-names'></a>

### Camelizar acciones

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
        // Creamos el EventsManager
        $eventsManager = new EventsManager();

        // Camelizar actions
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

### Quitar extensiones

Si la dirección URL original contiene siempre una extensión `.php`:

```php
https://example.com/admin/products/show-latest-products.php
https://example.com/admin/products/index.php
```

Se puede quitar antes de despachar al controlador/acción:

```php
<?php

use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Event;
use Phalcon\Events\Manager as EventsManager;

$di->set(
    'dispatcher',
    function () {
        // Creamos un EventsManager
        $eventsManager = new EventsManager();

        // Quitamos la extensión antes del bucle de despacho
        $eventsManager->attach(
            'dispatch:beforeDispatchLoop',
            function (Event $event, $dispatcher) {
                $action = $dispatcher->getActionName();

                // Quitamos al extensión
                $action = preg_replace('/\.php$/', '', $action);

                // Reescribimos el action
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

### Inyectando instancias de modelos

En este ejemplo, el desarrollador quiere inspeccionar los parámetros que recibirá una acción con el fin de inyectar dinámicamente instancias del modelo.

El controlador se ve de la siguiente manera:

```php
<?php

use Phalcon\Mvc\Controller;

class PostsController extends Controller
{
    /**
     * Ver posts
     *
     * @param \Posts $post
     */
    public function showAction(Posts $post)
    {
        $this->view->post = $post;
    }
}
```

El método `showAction` recibe una instancia del modelo `\Posts`, el desarrollador podría inspeccionar esto antes de despachar la acción preparando el parámetro acordemente:

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
        // Creamos un EventsManager
        $eventsManager = new EventsManager();

        $eventsManager->attach(
            'dispatch:beforeDispatchLoop',
            function (Event $event, $dispatcher) {
                // Posible nombre de clase del controlador
                $controllerName = $dispatcher->getControllerClass();

                // Posible nombre de método
                $actionName = $dispatcher->getActiveMethod();

                try {
                    // Obtenemos el reflection para el método a ser ejecutado
                    $reflection = new ReflectionMethod($controllerName, $actionName);

                    $parameters = $reflection->getParameters();

                    // Chequeamos los parámetros
                    foreach ($parameters as $parameter) {
                        // Obtenemos el nombre del modelo esperado
                        $className = $parameter->getClass()->name;

                        // Chequeamos si el parámetros es instancia del modelo
                        if (is_subclass_of($className, Model::class)) {
                            $model = $className::findFirstById($dispatcher->getParams()[0]);

                            // Reescribimos el parámetro por la instancia del modelo
                            $dispatcher->setParams([$model]);
                        }
                    }
                } catch (Exception $e) {
                    // Ocurrió una excepción. Quizás la clase o el action no existen?
                }
            }
        );

        $dispatcher = new MvcDispatcher();

        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);
```

El ejemplo anterior ha sido simplificado. Un desarrollador puede mejorarlo para inyectar cualquier tipo de dependencia o modelo en las acciones antes de ser ejecutadas.

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

Por ejemplo, si tienes un controlador base `CrudController` y un `PostsController` que se extiende del anterior. El `CrudController` se verá algo como esto:

```php
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model;

class CrudController extends Controller
{
    /**
     * Mostrar
     *
     * @param Model $model
     */
    public function showAction(Model $model)
    {
        $this->view->model = $model;
    }
}
```

En el `PostsController` se debe definir que modelo el controlador está asociado. This is done by implementing the [Phalcon\Mvc\Model\Binder\BindableInterface](api/Phalcon_Mvc_Model_Binder_BindableInterface) which will add the `getModelName()` method from which you can return the model name. Puede devolver un string con un nombre de modelo o un array asociativo donde clave es el nombre del parámetro y el valor el nombre del modelo.

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

Al declarar el modelo asociado con `PostsController` el vinculador (binder) puede comprobar en controlador padre el método `getModelName()` antes de pasar el modelo definido al action.

Si la estructura del proyecto no utiliza un controlador padre, usted puede por supuesto todavía vincular el modelo directamente en la acción del controlador:

```php
use Phalcon\Mvc\Controller;
use Models\Posts;

class PostsController extends Controller
{
    /**
     * Ver posts
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

## Gestión de excepciones "Not Found"

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
        // Creamos un EventsManager
        $eventsManager = new EventsManager();

        // Adjuntamos un listener
        $eventsManager->attach(
            'dispatch:beforeException',
            function (Event $event, $dispatcher, Exception $exception) {
                // Gestor de excepciones 404 
                if ($exception instanceof DispatchException) {
                    $dispatcher->forward(
                        [
                            'controller' => 'index',
                            'action'     => 'show404',
                        ]
                    );

                    return false;
                }

                // Modo alternativo, el controlador o el acción no existen
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

        // Vinculamos el EventsManager con el dispatcher
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);
```

Por supuesto, este método puede ser movido en clases plugin independientes, permitiendo que más de una clase tome acciones cuando una excepción se produce en el circuito de despacho:

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
        // Acción por defecto
        $action = 'show503';

        // Gestor de excepciones 404 
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

## Implementar tu propio despachador

The [Phalcon\Mvc\DispatcherInterface](api/Phalcon_Mvc_DispatcherInterface) interface must be implemented to create your own dispatcher replacing the one provided by Phalcon.