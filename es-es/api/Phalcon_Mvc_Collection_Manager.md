---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Mvc\Collection\Manager'
---
# Class **Phalcon\Mvc\Collection\Manager**

*implements* [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/collection/manager.zep)

Este componente controla la inicialización de modelos, manteniendo el registro de relaciones entre los diferentes modelos de la aplicación.

A CollectionManager is injected to a model via a Dependency Injector Container such as Phalcon\Di.

```php
<?php

$di = new \Phalcon\Di();

$di->set(
    "collectionManager",
    function () {
        return new \Phalcon\Mvc\Collection\Manager();
    }
);

$robot = new Robots($di);

```

## Métodos

public **getServiceName** ()

...

public **setServiceName** (*mixed* $serviceName)

...

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Configura el contenedor DependencyInjector

public **getDI** ()

Devuelve el contenedor DependencyInjector

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Establece el gestor de eventos

public **getEventsManager** ()

Devuelve el administrador de eventos interno

public **setCustomEventsManager** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model, [Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager)

Configura un administrador de eventos personalizado para un modelo específico

public **getCustomEventsManager** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model)

Devuelve el administrador de eventos personalizado relacionado a un modelo

public **initialize** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model)

Inicializa un modelo en el administrador de modelos

public **isInitialized** (*mixed* $modelName)

Comprueba si un modelo está ya inicializado

public **getLastInitialized** ()

Obtiene el modelo inicializado más reciente

public **setConnectionService** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model, *mixed* $connectionService)

Obtiene un servicio de conexión para un modelo específico

public **getConnectionService** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model)

Obtiene un servicio de conexión para un modelo específico

public **useImplicitObjectIds** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model, *mixed* $useImplicitObjectIds)

Establece si un modelo debe utilizar ids de objetos implícitos

public **isUsingImplicitObjectIds** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model)

Comprueba si un modelo está utilizando ids de objeto implícitos

public *Mongo* **getConnection** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model)

Devuelve la conexión relacionada a un modelo

public **notifyEvent** (*mixed* $eventName, [Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model)

Recibe los eventos generados en los modelos y los envía al administrador de eventos si está disponible. Notifica los comportamientos que están escuchando en el modelo

public **missingMethod** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model, *mixed* $eventName, *mixed* $data)

Envía un evento a los escuchas y a los comportamientos. Este método espera que el punto de conexión de escuchas o comportamientos devuelva true, lo que significa que se implementó al menos uno

public **addBehavior** ([Phalcon\Mvc\CollectionInterface](Phalcon_Mvc_CollectionInterface) $model, [Phalcon\Mvc\Collection\BehaviorInterface](Phalcon_Mvc_Collection_BehaviorInterface) $behavior)

Enlaza un comportamiento a un modelo