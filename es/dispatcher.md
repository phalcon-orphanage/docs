<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Despachando Controladores</a> <ul>
        <li>
          <a href="#dispatch-loop">Bucle de despacho</a> <ul>
            <li>
              <a href="#dispatch-loop-events">Eventos del bucle de despacho</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#forwarding">Reenvío a otras acciones</a>
        </li>
        <li>
          <a href="#preparing-parameters">Preparando parámetros</a>
        </li>
        <li>
          <a href="#getting-parameters">Obtener parámetros</a>
        </li>
        <li>
          <a href="#preparing-actions">Preparación de acciones</a> <ul>
            <li>
              <a href="#preparing-actions-camelizing-action-names">Camelizar acciones</a>
            </li>
            <li>
              <a href="#preparing-actions-removing-legacy-extensions">Quitar extensiones</a>
            </li>
            <li>
              <a href="#preparing-actions-inject-model-instances">Inyectando instancias de modelos</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#handling-404">Gestión de excepciones "Not Found"</a>
        </li>
        <li>
          <a href="#custom">Implementar tu propio despachador</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Despachando Controladores

`Phalcon\Mvc\Dispatcher` es el componente responsable de crear instancias de controladores y ejecutar las acciones requeridas de ellos en una aplicación MVC. Entender su funcionamiento y capacidades nos ayuda a sacarle más provecho a los servicios prestados por el framework.

<a name='dispatch-loop'></a>

## Bucle de despacho

Esto es un proceso importante que tiene mucho que ver con el flujo MVC, especialmente con la parte de controlador. El trabajo se produce en el despachador de controladores (dispatcher). Los archivos del controlador son leídos, cargados e instanciados. Entonces se ejecutan las acciones requeridas. Si una acción reenvia (forward) a otro controlador/acción, el dispatcher comienza otra vez. Para ilustrar mejor esto, en el ejemplo siguiente se muestra aproximadamente el proceso realizado dentro de `Phalcon\Mvc\Dispatcher`:

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

`Phalcon\Mvc\Dispatcher` es capaz de enviar eventos al [EventsManager](/[[language]]/[[version]]/events) (si está presente). Los eventos se desencadenan mediante el tipo `dispatch`. Si algún evento devuelve `false` podría detener la operación activa. Son soportados los siguientes eventos:

| Nombre de Evento     | Activador                                                                                                                                                                                                       | ¿Puede detener la operación? | Activa en             |
| -------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ---------------------------- | --------------------- |
| beforeDispatchLoop   | Activado antes de entrar en el bucle de despacho. En este momento el distribuidor no sabe si existen el controlador o las acciones a ejecutarse. El dispatcher sólo conoce la información pasada por el Router. | Sí                           | Listeners             |
| beforeDispatch       | Activado después de entrar en el bucle de despacho. En este momento el dispatcher no sabe si existen el controlador o las acciones a ejecutarse. El dispatcher sólo conoce la información pasada por el Router. | Sí                           | Listeners             |
| beforeExecuteRoute   | Dispara antes de ejecutar el método de controlador/acción. En este punto el dispatcher ha sido inicializado el controlador y sabe que si existe la acción.                                                      | Sí                           | Listeners/Controllers |
| initialize           | Permite inicializar globalmente el controlador en la solicitud                                                                                                                                                  | No                           | Controllers           |
| afterExecuteRoute    | Se activa después de ejecutar el método controlador/acción. No se puede detener la operación, sólo utilice este evento para hacer limpieza tras ejecutar la acción                                              | No                           | Listeners/Controllers |
| beforeNotFoundAction | Se activa cuando la acción no se encuentra en el controlador                                                                                                                                                    | Sí                           | Listeners             |
| beforeException      | Disparado antes de que el dispatcher lance una excepción                                                                                                                                                        | Sí                           | Listeners             |
| afterDispatch        | Se activa después de ejecutar el método controlador/acción. No se puede detener la operación, sólo utilice este evento para hacer limpieza tras ejecutar la acción                                              | Sí                           | Listeners             |
| afterDispatchLoop    | Activa después de salir del bucle de despacho                                                                                                                                                                   | No                           | Listeners             |
| afterBinding         | Se dispara después de que los modelos están enlazados pero antes de ejecutar la ruta                                                                                                                            | Sí                           | Listeners/Controllers |

El [tutorial INVO](/[[language]]/[[version]]/tutorial-invo) muestra cómo tomar ventaja de la implementación de eventos implementando un filtro de seguridad con [ACL](/[[language]]/[[version]]/acl)

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

<h5 class='alert alert-warning'>Métodos en los listeners aceptan un objeto <code>Phalcon\Events\Event</code> como su primer parámetro. Los métodos en controladores no lo aceptan, solo el dispatcher. </h5>

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

Un forward acepta los siguientes parámetros:

| Parámetro  | Activador                                         |
| ---------- | ------------------------------------------------- |
| controller | Un nombre de controlador válido donde reenviar.   |
| action     | Un nombre válido de acción donde reenviar.        |
| params     | Un array de parámetros para la acción             |
| namespace  | Un namespace valido donde es parte el controlador |

<a name='preparing-parameters'></a>

## Preparando parámetros

Gracias a los datos suministrados por `Phalcon\Mvc\Dispatcher` puede adaptar fácilmente su aplicación a cualquier esquema de URL; es decir, es posible que desee tener URLs como: `http://example.com/controller/key1/value1/key2/value`. Los parámetros se pasan con el orden que se definen en la dirección URL a las acciones, puede transformar y adoptar el esquema que Ud. desee:

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

Si el esquema deseado es: `http://example.com/controller/key1:value1/key2:value`, utilice el siguiente código:

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

Cuando una ruta proporciona parámetros con nombre puede recibirlos en un controlador, una vista o cualquier otro componente que extienda de `Phalcon\Di\Injectable`.

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

Si la URL original es: `http://example.com/admin/products/show-latest-products` y por ejemplo quieres camelizar `show-lastest-products` a `ShowLatestProducts`, el siguiente código es necesario:

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
http://example.com/admin/products/show-latest-products.php
http://example.com/admin/products/index.php
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

A partir de la versión 3.1.x el dispatcher viene con una opción para manejar esto internamente para que cualquier modelo sea pasado a una acción de controlador mediante `Phalcon\Mvc\Model\Binder`.

```php
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Model\Binder;

$dispatcher = new Dispatcher();

$dispatcher->setModelBinder(new Binder());

return $dispatcher;
```

<h5 class='alert alert-warning'>Dado que el objeto Binder está utilizando internamente Reflection Api que puede ser pesado, existe la capacidad de establecer el caché. Esto puede hacerse mediante segundo argumento en <code>setModelBinder()</code> que también puede aceptar el nombre del servicio o simplemente pasando la instancia de caché al constructor de <code>Binder</code>. </h5>

También introduce una nueva interfaz `Phalcon\Mvc\Model\Binder\BindableInterface` que permite definir los controladores asociados para permitir modelos vinculantes en los base controllers.

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

En el `PostsController` se debe definir que modelo el controlador está asociado. Esto se hace mediante la aplicación de la interfaz `Phalcon\Mvc\Model\Binder\BindableInterface` que se agrega el método `getModelName()` donde se debe devolver el nombre del modelo. Puede devolver un string con un nombre de modelo o un array asociativo donde clave es el nombre del parámetro y el valor el nombre del modelo.

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

<h5 class='alert alert-warning'>Actualmente el Binder usa solamente de la clave primaria de modelos para realizar un <code>findFirst()</code>. Una ruta de ejemplo para lo anterior <code>/posts/show/{1}</code> </h5>

<a name='handling-404'></a>

## Gestión de excepciones "Not Found"

Utilizando el [EventsManager](/[[language]]/[[version]]/events) es posible insertar un punto de anclaje antes de que el dispatcher arroje una excepción cuando no se encontró la combinación controlador/acción:

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

<h5 class='alert alert-danger'>Las únicas excepciones producidas por el dispatcher y las excepciones producidas en la acción ejecutada son notificadas en los eventos de <code>beforeException</code>. Las excepciones producidas en los listeners o eventos de controladores se redirigen en el último try/catch. </h5>

<a name='custom'></a>

## Implementar tu propio despachador

Debe implementar la interfaz `Phalcon\Mvc\DispatcherInterface` para crear su propio despachador reemplazando a uno proporcionado por Phalcon.