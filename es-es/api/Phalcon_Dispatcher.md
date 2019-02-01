---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Dispatcher'
---
# Abstract class **Phalcon\Dispatcher**

*implements* [Phalcon\DispatcherInterface](Phalcon_DispatcherInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/dispatcher.zep)

This is the base class for Phalcon\Mvc\Dispatcher and Phalcon\Cli\Dispatcher. This class can't be instantiated directly, you can use it to create your own dispatchers.

## Constantes

*integer* **EXCEPTION_NO_DI**

*integer* **EXCEPTION_CYCLIC_ROUTING**

*integer* **EXCEPTION_HANDLER_NOT_FOUND**

*integer* **EXCEPTION_INVALID_HANDLER**

*integer* **EXCEPTION_INVALID_PARAMS**

*integer* **EXCEPTION_ACTION_NOT_FOUND**

## Métodos

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Configura el inyector de dependencia

public **getDI** ()

Devuelve el inyector de dependencias interno

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Establece el administrador de eventos

public **getEventsManager** ()

Devuelve el administrador de eventos interno

public **setActionSuffix** (*mixed* $actionSuffix)

Configura el sufijo de acción por defecto

public **getActionSuffix** ()

Obtiene el sufijo de acción por defecto

public **setModuleName** (*mixed* $moduleName)

Establece el módulo donde está el controlador (solo informativo)

public **getModuleName** ()

Obtiene el módulo donde está la clase controlador

public **setNamespaceName** (*mixed* $namespaceName)

Establece el espacio del nombre donde está la clase controlador

public **getNamespaceName** ()

Obtiene el espacio del nombre para ser antepuesto al nombre del manejador actual

public **setDefaultNamespace** (*mixed* $namespaceName)

Establece el espacio de nombres por defecto

public **getDefaultNamespace** ()

Devuelve el espacio de nombres por defecto

public **setDefaultAction** (*mixed* $actionName)

Establece el nombre de acción predeterminado

public **setActionName** (*mixed* $actionName)

Establece el nombre de acción para ser enviado

public **getActionName** ()

Obtiene el nombre de acción distribuido más reciente

public **setParams** (*array* $params)

Establece los parámetros de acción para ser enviados

public **getParams** ()

Obtiene los parámetros de acción

public **setParam** (*mixed* $param, *mixed* $value)

Establece un parámetro por su nombre o índice numérico

public *mixed* **getParam** (*mixed* $param, [*string* | *array* $filters], [*mixed* $defaultValue])

Obtiene un parámetro por su nombre o índice numérico

public *boolean* **hasParam** (*mixed* $param)

Comprueba si un parámetro existe

public **getActiveMethod** ()

Devuelve el método actual para ser ejecutado en el distribuidor

public **isFinished** ()

Comprueba si el bucle del distribuidor ha finalizado o si tiene mas controladores o tareas pendientes para ser enviados

public **setReturnedValue** (*mixed* $value)

Configura manualmente el valor más reciente devuelto por una acción

public *mixed* **getReturnedValue** ()

Devuelve el valor devuelto por la acción de distribución mas reciente

public **setModelBinding** (*mixed* $value, [*mixed* $cache])

Habilita o deshabilita el enlace modelo duriante la distribución

```php
<?php

$di->set('dispatcher', function() {
    $dispatcher = new Dispatcher();

    $dispatcher->setModelBinding(true, 'cache');
    return $dispatcher;
});

```

public **setModelBinder** ([Phalcon\Mvc\Model\BinderInterface](Phalcon_Mvc_Model_BinderInterface) $modelBinder, [*mixed* $cache])

Habilita el enlace modelo durante la distribución

```php
<?php

$di->set('dispatcher', function() {
    $dispatcher = new Dispatcher();

    $dispatcher->setModelBinder(new Binder(), 'cache');
    return $dispatcher;
});

```

public **getModelBinder** ()

Obtiene el enlazador modelo

public *object* **dispatch** ()

Distribuye una acción de manejo tomando en cuenta los parámetros de enrutamiento

protected *object* **_dispatch** ()

Distribuye una acción de manejo tomando en cuenta los parámetros de enrutamiento

public **forward** (*array* $forward)

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

public **wasForwarded** ()

Comprueba si la acción ejecutada actual fue reenviada por otra

public **getHandlerClass** ()

El nombre posible de la clase que será ubicado para enviar la solicitud

public **callActionMethod** (*mixed* $handler, *mixed* $actionMethod, [*array* $params])

...

public **getBoundModels** ()

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

protected **_resolveEmptyProperties** ()

Establece propiedades vacías a sus valores por defecto (en el caso en que los valores por defecto estén disponibles)