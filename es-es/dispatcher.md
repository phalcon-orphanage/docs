---
layout: default
language: 'es-es'
version: '4.0'
title: 'Despachador'
keywords: 'despachador, mvc, bucle de despacho'
---

# Componente Despachador

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

[Phalcon\Mvc\Dispatcher](api/phalcon_mvc#mvc-dispatcher) es el componente responsable de instanciar los controladores y ejecutar las acciones pertinentes en ellos en una aplicación MVC. Despachar es el proceso de tomar el objeto de solicitud, extraer el nombre del módulo, el nombre de controlador, el nombre de la acción, y los parámetros opcionales que contenga, y luego instanciar un controlador y llamar una acción de ese controlador.

```php
<?php

use Phalcon\Di;
use Phalcon\Mvc\Dispatcher;

$container  = new Di();
$dispatcher = new Dispatcher();

$dispatcher->setDI($container);

$dispatcher->setControllerName("posts");
$dispatcher->setActionName("index");
$dispatcher->setParams([]);

$controller = $dispatcher->dispatch();
```

## Métodos

```php
public function callActionMethod(
    mixed $handler, 
    string $actionMethod, 
    array $params = []
)
```

Llama a un método de acción con un manejador y parámetros

```php
public function dispatch(): object | bool
```

Procesa el resultado del enrutador llamando a la(s) acción(es) apropiadas del controlador incluyendo cualquier dato de enrutado o parámetros inyectados. Devuelve la clase manejadora despachada (el Controlador para el despachamiento Mvc o una Tarea para el despachamiento CLI) o `false` si ocurre una excepción y la operación se detiene devolviendo `false` en el manejador de la excepción. Lanza `Exception` si tiene lugar una excepción no capturada o manejada durante el proceso de despacho.

```php
public function forward(
    array $forward
): void
```

Reenvía el flujo de ejecución a otro controlador/acción.

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

$eventsManager = $container->getShared("eventsManager");

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

Obtiene el nombre de la última acción despachada

```php
public function getActionSuffix(): string
```

Obtiene el sufijo de acción por defecto

```php
public function getActiveController(): ControllerInterface
```

Devuelve el controlador activo en el despachador

```php
public function getActiveMethod(): string
```

Devuelve el método actual a ser ejecutado en el despachador

```php
public function getBoundModels(): array
```

Devuelve los modelos vinculados de la instancia del enlazador

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

Posible nombre de la clase del controlador que será localizada para despachar la petición

```php
public function getControllerName(): string
```

Obtiene el nombre del último controlador despachado

```php
public function getDefaultNamespace(): string
```

Devuelve el espacio de nombres por defecto

```php
public function getHandlerClass(): string
```

Posible nombre de clase que será localizada para despachar la petición

```php
public function getHandlerSuffix(): string
```

Obtiene el sufijo del manejador por defecto

```php
public function getLastController(): ControllerInterface
```

Devuelve el último controlador despachado

```php
public function getModelBinder(): BinderInterface | null
```

Obtiene el enlazador de modelos

```php
public function getModuleName(): string
```

Obtiene el módulo donde está la clase del controlador

```php
public function getNamespaceName(): string
```

Obtiene el espacio de nombres a anteponer al nombre del manejador actual

```php
public function getParam(
    mixed $param, 
    string | array $filters = null, 
    mixed $defaultValue = null
): mixed
```

Obtiene un parámetro por su nombre o índice numérico

```php
public function getParams(): array
```

Obtiene los parámetros de la acción

```php
public function getPreviousActionName(): string
```

Obtiene el nombre de la acción despachada anterior

```php
public function getPreviousControllerName(): string
```

Obtiene el nombre del controlador despachado anterior

```php
public function getPreviousNamespaceName(): string
```

Obtiene el espacio de nombres despachado anterior

```php
public function getReturnedValue(): mixed
```

Devuelve el valor devuelto por la última acción despachada

```php
public function hasParam(
    mixed $param
): bool
```

Comprueba si un parámetro existe

```php
public function isFinished(): bool
```

Comprueba si el bucle de despachado se ha terminado o tiene más controladores/tareas pendientes de despachar

```php
public function setActionName(
    string $actionName
): void
```

Establece el nombre de la acción a despachar

```php
public function setActionSuffix(
    string $actionSuffix
): void
```

Establece el sufijo de acción por defecto

```php
public function setControllerName(
    string $controllerName
)
```

Establece el nombre del controlador a despachar

```php
public function setControllerSuffix(
    string $controllerSuffix
)
```

Establece el sufijo de controlador por defecto

```php
public function setDefaultAction(
    string $actionName
): void
```

Establece el nombre de acción predeterminado

```php
public function setDefaultController(
    string $controllerName
)
```

Establece el nombre predeterminado del controlador

```php
public function setDefaultNamespace(
    string $namespaceName
): void
```

Establece el espacio de nombres por defecto

```php
public function setHandlerSuffix(
    string $handlerSuffix
): void
```

Establece el sufijo por defecto del manejador

```php
public function setModelBinder(
    BinderInterface $modelBinder, 
    mixed $cache = null
): DispatcherInterface
```

Habilita el enlazado de modelos durante el despacho

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

Establece el módulo donde está el controlador (sólo informativo)

```php
public function setNamespaceName(
    string $namespaceName
): void
```

Establece el espacio de nombres donde está la clase controlador

```php
public function setParam(
    mixed $param, 
    mixed $value
): void
```

Establece un parámetro por su nombre o índice numérico

```php
public function setParams(
    array $params
): void
```

Establece los parámetros de la acción a despachar

```php
public function setReturnedValue(
    mixed $value
): void
```

Establece manualmente el último valor devuelto por una acción

```php
public function wasForwarded(): bool
```

Comprueba si la acción ejecutada actual fue reenviada desde otra

## Bucle de Despacho

Es un proceso importante que tiene mucho por hacer con el flujo MVC en sí mismo, especialmente con la parte del controlador. El trabajo ocurre dentro del despachador del controlador. Los ficheros del controlador son leídos, cargados e instanciados. Luego se ejecutan las acciones requeridas. Si una acción reenvía el flujo a otro controlador/acción, el despachador del controlador empieza de nuevo. Para ilustrar mejor esto, el siguiente ejemplo muestra aproximadamente el proceso ejecutado en el componente [Phalcon\Mvc\Dispatcher](api/phalcon_mvc#mvc-dispatcher).

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

El el código anterior, estamos calculando el nombre del controlador, instanciándolo y llamando a la acción relevante. Después de eso terminamos el bucle. El ejemplo está muy simplificado y carece de validaciones, filtros y comprobaciones adicionales, pero demuestra el flujo normal de operación dentro del despachador.

## Reenvío

El bucle de despacho le permite reenviar el flujo de ejecución a otro controlador/acción. Esto es muy útil en situaciones donde comprobamos si el usuario tiene acceso a ciertas áreas, y si no se le permite es reenviado a otros controladores y acciones, lo que le permite reutilizar código.

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

> **NOTA**: Tenga en cuenta que ejecutar `forward` no es lo mismo que hacer una redirección HTTP. Aunque producen el mismo resultado, la ejecución de `forward` no recargará la página actual, mientras que la redirección HTTP necesita dos peticiones para completar el proceso.
{: .alert .alert-info }

Ejemplos:

```php
<?php

$this->dispatcher->forward(
    [
        'action' => 'search',
    ]
);
```

Reenvía el flujo a otra acción en el controlador actual

```php
<?php

$this->dispatcher->forward(
    [
        'action' => 'search',
        'params' => [1, 2, 3],
    ]
);
```

Reenvía el flujo a otra acción en el controlador actual, pasando parámetros

Una acción `forward` acepta los siguientes parámetros:

| Parámetro    | Descripción                                                      |
| ------------ | ---------------------------------------------------------------- |
| `controller` | Un nombre de controlador válido al que reenviar.                 |
| `action`     | Un nombre de acción válido al que reenviar.                      |
| `params`     | Un vector de parámetros para la acción.                          |
| `namespace`  | Un espacio de nombres válido del que forma parte el controlador. |

## Parámetros

### Preparación

Usando eventos o puntos de enganche disponibles mediante [Phalcon\Mvc\Dispatcher](api/phalcon_mvc#mvc-dispatcher), puede fácilmente ajustar su aplicación para aceptar cualquier esquema de URL que se adapte a su aplicación. Esto es particularmente útil cuando actualiza su aplicación y quiere transformar algunas URLs antiguas. Por ejemplo, podría querer que sus URLs fuesen:

    https://domain.com/controller/key1/value1/key2/value
    

Ya que los parámetros se pasan a la acciones en el orden en el que fueron definidos en la URL, puede transformarlos al esquema deseado:

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
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);
```

Si el esquema deseado es:

    https://example.com/controller/key1:value1/key2:value
    

puede usar el siguiente código:

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
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);
```

## Obtención

Cuando una ruta proporciona parámetros con nombres puede obtenerlos en un controlador, vista o cualquier otro componente que extienda [Phalcon\Di\Injectable](api/phalcon_di#di-factorydefault)

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

En el ejemplo anterior, obtenemos `invoiceId` como primer parámetro pasado y automáticamente se sanea como `integer`. El segundo parámetro es `filter`, que es saneado como `string`

## Acciones

También puede definir un esquema arbitrario para acciones `antes` de que el bucle de despacho sea invocado.

### Camelizar Nombres

SI la URL original es

    https://example.com/admin/invoices/show-unpaid
    

y por ejemplo quiere camelizar `show-unpaid` a `ShowUnpaid`, se puede usar para lograrlo `beforeDispatchLoop`.

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
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);
```

### Filtro Extensiones de Fichero

Si la URL original siempre contiene una extensión `.php`:

    https://example.com/admin/invoices/show-unpaid.php
    https://example.com/admin/invoices/index.php
    

Puede eliminarla antes de despachar la combinación controlador/acción:

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
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);
```

> **NOTA**: El código anterior se puede usar tal cual o ajustado para ayudar con las transformaciones de URL antiguas u otros casos de uso donde necesitamos manipular el nombre de la acción.
{: .alert .alert-info }

### Inyección de Modelo

Hay instancias en las que puede querer inyectar automáticamente instancias del modelo que se han emparejado con los parámetros pasados en la URL.

Nuestro controlador es:

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

`viewAction` recibe una instancia del modelo `Invoices`. Si intenta ejecutar este método sin ninguna comprobación ni manipulación, la llamada fallará. Sin embargo puede inspeccionar los parámetros pasados antes del bucle de despacho y manipular los parámetros en consecuencia.

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
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);
```

En el ejemplo anterior, obtenemos la clase controlador y el método activo desde el despachador. Recorriendo los parámetros, usamos la reflexión para comprobar el método a ejecutar. Calculamos el nombre del modelo y también comprobamos si el parámetro espera un nombre de modelo. Si es así, anulamos el parámetro pasando el modelo encontrado. Si se lanza alguna excepción, podemos manejarla en consecuencia, por ejemplo si la clase o acción no existen, o no se ha encontrado el registro.

El ejemplo anterior se ha simplificado. Puede ajustarlo acorde a sus necesidades e inyectar a una acción cualquier tipo de dependencia o modelo antes de que se ejecute.

El despachador también viene con una opción para manejar esto internamente para todos los modelos pasados en una acción de controlador usando el objeto [Phalcon\Mvc\Model\Binder](api/phalcon_mvc#mvc-model-binder).

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

> **NOTA**: El componente [Phalcon\Mvc\Model\Binder](api/phalcon_mvc#mvc-model-binder) usa internamente la API de Reflexión de PHP, que consume ciclos de procesamiento adicionales. Por esa razón, tiene la habilidad de usar una instancia de `cache` o un nombre de servicio de cache. Para usar esta característica, puede pasar el nombre del servicio de cache o la instancia como segundo argumento en el método `setModelBinder()` o sólo pasar la instancia de cache en el constructor `Binder`.
{: .alert .alert-warning }

También, mediante el uso de [Phalcon\Mvc\Model\Binder\BindableInterface](api/phalcon_mvc#mvc-model-binder-bindableinterface) en controladores, puede definir la vinculación de los modelos en los controladores base.

En el ejemplo anterior, tenemos un controlador base `CrudController` que extiende desde `InvoicesController`.

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

En `InvoicesController` definimos con qué modelo está asociado el controlador. Esto se hace implementando [Phalcon\Mvc\Model\Binder\BindableInterface](api/phalcon_mvc#mvc-model-binder-bindableinterface), que hará que el método `getModelName()` esté disponible. Este método se usa para devolver el nombre del modelo. Puede devolver una cadena con un nombre de modelo o un vector asociativo donde la clave es el parámetro nombre.

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

Al declarar el modelo asociado en `InvoicesController` el vinculador (*binder*) puede comprobar el controlador para el método `getModelName()` antes de pasar el modelo definido a la acción `view` del padre.

Si la estructura de su proyecto no usa ningún controlador base, por supuesto todavía puede vincular el modelo directamente en la acción del controlador:

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

> Actualmente, el vinculador (binder) solo utilizará la clave primaria de los modelos para realizar un `findFirst()`. Una ruta de ejemplo para lo anterior podría ser `/posts/show/{1}`
{: .alert .alert-warning }

## No-Encontrado (404)

Si se define un [Gestor de Eventos](events), puede usarlo para interceptar excepciones que se muestran cuando el par controlador/acción no se encuentra.

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
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);
```

o usar una comprobación de sintaxis alternativa para la excepción.

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
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }
);
```

Podemos mover este método a una clase plugin:

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

> **NOTA**: Sólo las excepciones producidas por el despachador y las excepciones producidas en la acción ejecutada notifican los eventos `beforeExcepcion`. Las excepciones producidas en oyentes o eventos de controlador son redirigidas al último try/catch.
{: .alert .alert-danger }

## Eventos

[Phalcon\Mvc\Dispatcher](api/phalcon_mvc#mvc-dispatcher) es capaz de enviar eventos a un [Gestor](events) si está presente. Los eventos son disparados usando el tipo `dispatch`. Algunos eventos cuando devuelven el booleano `false` podrían detener la operación activa. Se soportan los siguientes eventos:

| Nombre de evento       | Disparado                                                                                                                   | Puede detener |
| ---------------------- | --------------------------------------------------------------------------------------------------------------------------- |:-------------:|
| `afterBinding`         | Después de que los modelos estén enlazados pero antes de ejecutar la ruta                                                   |      Si       |
| `afterDispatch`        | Después de ejecutar el método controlador/acción.                                                                           |      Si       |
| `afterDispatchLoop`    | Después de salir del bucle de despacho                                                                                      |      No       |
| `afterExecuteRoute`    | Después de ejecutar el método controlador/acción.                                                                           |      No       |
| `afterInitialize`      | Permite inicializar globalmente el controlador en la petición                                                               |      No       |
| `beforeDispatch`       | Después de entrar en el bucle de despacho. El Despachador sólo conoce la información pasada por el Enrutador.               |      Si       |
| `beforeDispatchLoop`   | Antes de entrar en el bucle de despacho. El Despachador sólo conoce la información pasada por el Enrutador.                 |      Si       |
| `beforeException`      | Antes de que el despachador lance cualquier excepción                                                                       |      Si       |
| `beforeExecuteRoute`   | Antes de ejecutar el método controlador/acción. El Despachador ha inicializado el controlador y conoce si existe la acción. |      Si       |
| `beforeForward`        | Antes de reenviar al método controlador/acción. (Despachador MVC)                                                           |      No       |
| `beforeNotFoundAction` | cuando la acción no se ha encontrado en el controlador                                                                      |      Si       |

La aplicación de ejemplo [INVO](https://github.com/phalcon/invo), demuestra cómo puede sacar ventaja del despacho de eventos, implementando un filtro de seguridad con [Acl](acl)

En el ejemplo siguiente se muestra cómo adjuntar oyentes (listeners) a este componente:

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
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    },
    true
);
```

Un controlador instanciado automáticamente actúa como un oyente para despachar eventos, puede implementar métodos como llamadas de retorno (callbacks):

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

> **NOTA**: Los métodos de oyentes de eventos aceptan un objeto [Phalcon\Events\Event](api/phalcon_events#events-event) como primer parámetro - los métodos en controladores no.
{: .alert .alert-warning }

## Gestor de Eventos

Puede usar el evento `dispatcher::beforeForward` para cambiar los módulos y realizar redirecciones más fácilmente.

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

## Personalizado

Se debe implementar la interfaz [Phalcon\Mvc\DispatcherInterface](api/phalcon_mvc#mvc-dispatcherinterface) para crear su propio despachador.

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
