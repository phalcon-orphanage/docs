---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Cli\Dispatcher'
---
# Class **Phalcon\Cli\Dispatcher**

*extends* abstract class [Phalcon\Dispatcher](Phalcon_Dispatcher)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\DispatcherInterface](Phalcon_DispatcherInterface), [Phalcon\Cli\DispatcherInterface](Phalcon_Cli_DispatcherInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/cli/dispatcher.zep)

El despachado es el proceso de tomar los argumentos de las linea de comandos, extrayendo el nombre de módulo, nombre de la tarea, nombre de la acción, y los parámetros opcionales contenidos en ella, y luego instanciando una tarea y llamando una acción en ella.

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

## Constantes

*integer* **EXCEPTION_NO_DI**

*integer* **EXCEPTION_CYCLIC_ROUTING**

*integer* **EXCEPTION_HANDLER_NOT_FOUND**

*integer* **EXCEPTION_INVALID_HANDLER**

*integer* **EXCEPTION_INVALID_PARAMS**

*integer* **EXCEPTION_ACTION_NOT_FOUND**

## Métodos

public **setTaskSuffix** (*mixed* $taskSuffix)

Establece el sufijo de tareas estándar

public **setDefaultTask** (*mixed* $taskName)

Establece el nombre de tareas estándar

public **setTaskName** (*mixed* $taskName)

Establece el nombre de tareas para ser distribuida

public **getTaskName** ()

Obtiene el nombre de la última tarea enviada

protected **_throwDispatchException** (*mixed* $message, [*mixed* $exceptionCode])

Arroja una excepción interna

protected **_handleException** ([Exception](https://php.net/manual/en/class.exception.php) $exception)

Maneja una excepción de usuario

public **getLastTask** ()

Devuelve el ultimo controlador distribuido

public **getActiveTask** ()

Devuelve la tarea activa en el distribuidor

public **setOptions** (*array* $options)

Establece las opciones para ser distribuidas

public **getOptions** ()

Get dispatched options

public **getOption** (*mixed* $option, [*string* | *array* $filters], [*mixed* $defaultValue])

Obtiene una opción por su nombre o índice numérico

public **hasOption** (*mixed* $option)

Comprueba si existe una opción

public **callActionMethod** (*mixed* $handler, *mixed* $actionMethod, [*array* $params])

Llama el método de acción.

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Configura el inyector de dependencia

public **getDI** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Devuelve el inyector de dependencias interno

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Establece el administrador de eventos

public **getEventsManager** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Devuelve el administrador de eventos interno

public **setActionSuffix** (*mixed* $actionSuffix) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Configura el sufijo de acción por defecto

public **getActionSuffix** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Obtiene el sufijo de acción por defecto

public **setModuleName** (*mixed* $moduleName) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Establece el módulo donde está el controlador (solo informativo)

public **getModuleName** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Obtiene el módulo donde está la clase controlador

public **setNamespaceName** (*mixed* $namespaceName) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Establece el espacio del nombre donde está la clase controlador

public **getNamespaceName** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Obtiene el espacio del nombre para ser antepuesto al nombre del manejador actual

public **setDefaultNamespace** (*mixed* $namespaceName) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Establece el espacio de nombres por defecto

public **getDefaultNamespace** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Devuelve el espacio de nombres por defecto

public **setDefaultAction** (*mixed* $actionName) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Establece el nombre de acción predeterminado

public **setActionName** (*mixed* $actionName) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Establece el nombre de acción para ser enviado

public **getActionName** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Obtiene el nombre de acción distribuido más reciente

public **setParams** (*array* $params) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Establece los parámetros de acción para ser enviados

public **getParams** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Obtiene los parámetros de acción

public **setParam** (*mixed* $param, *mixed* $value) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Establece un parámetro por su nombre o índice numérico

public *mixed* **getParam** (*mixed* $param, [*string* | *array* $filters], [*mixed* $defaultValue]) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Obtiene un parámetro por su nombre o índice numérico

public *boolean* **hasParam** (*mixed* $param) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Comprueba si un parámetro existe

public **getActiveMethod** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Devuelve el método actual para ser ejecutado en el distribuidor

public **isFinished** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Comprueba si el bucle del distribuidor ha finalizado o si tiene mas controladores o tareas pendientes para ser enviados

public **setReturnedValue** (*mixed* $value) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Configura manualmente el valor más reciente devuelto por una acción

public *mixed* **getReturnedValue** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Devuelve el valor devuelto por la acción de distribución mas reciente

public **setModelBinding** (*mixed* $value, [*mixed* $cache]) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Habilita o deshabilita el enlace modelo duriante la distribución

```php
<?php

$di->set('dispatcher', function() {
    $dispatcher = new Dispatcher();

    $dispatcher->setModelBinding(true, 'cache');
    return $dispatcher;
});

```

public **setModelBinder** ([Phalcon\Mvc\Model\BinderInterface](Phalcon_Mvc_Model_BinderInterface) $modelBinder, [*mixed* $cache]) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Habilita el enlace modelo durante la distribución

```php
<?php

$di->set('dispatcher', function() {
    $dispatcher = new Dispatcher();

    $dispatcher->setModelBinder(new Binder(), 'cache');
    return $dispatcher;
});

```

public **getModelBinder** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Obtiene el enlazador modelo

public *object* **dispatch** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Distribuye una acción de manejo tomando en cuenta los parámetros de enrutamiento

protected *object* **_dispatch** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Distribuye una acción de manejo tomando en cuenta los parámetros de enrutamiento

public **forward** (*array* $forward) inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Deriva el flujo de ejecución a otro controlador/acción.

```php
<?php

$this->dispatcher->forward(
    [
        "controller" => "posts",
        "action"     => "index",
    ]
);

```

public **wasForwarded** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Comprueba si la acción ejecutada actual fue reenviada por otra

public **getHandlerClass** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

El nombre posible de la clase que será ubicado para enviar la solicitud

public **getBoundModels** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Devuelve los modelos enlazados de la instancia del enlazador

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

protected **_resolveEmptyProperties** () inherited from [Phalcon\Dispatcher](Phalcon_Dispatcher)

Establece propiedades vacías a sus valores por defecto (en el caso en que los valores por defecto estén disponibles)