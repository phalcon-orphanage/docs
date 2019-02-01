---
layout: article
language: 'es-es'
version: '4.0'
title: 'Phalcon\Mvc\Micro'
---
# Class **Phalcon\Mvc\Micro**

*extends* abstract class [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

*implements* [Phalcon\Events\EventsAwareInterface](Phalcon_Events_EventsAwareInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface), [ArrayAccess](https://php.net/manual/en/class.arrayaccess.php)

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/mvc/micro.zep)

Con Phalcon se pueden crear aplicaciones "Micro-Framework like". Al hacer esto, solo se necesita escribir una cantidad mínima de código para crear una aplicación PHP. Las aplicaciones Micro son adecuadas de una manera práctica para aplicaciones pequeñas, APIs y prototipos.

```php
<?php

$app = new \Phalcon\Mvc\Micro();

$app->get(
    "/say/welcome/{name}",
    function ($name) {
        echo "<h1>Welcome $name!</h1>";
    }
);

$app->handle();

```

## Métodos

public **__construct** ([[Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector])

Phalcon\Mvc\Micro constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Configura el contenedor DependencyInjector

public [Phalcon\Mvc\Router\RouteInterface](Phalcon_Mvc_Router_RouteInterface) **map** (*string* $routePattern, *callable* $handler)

Asigna una ruta a un controlador sin ninguna restricción de método HTTP

public [Phalcon\Mvc\Router\RouteInterface](Phalcon_Mvc_Router_RouteInterface) **get** (*string* $routePattern, *callable* $handler)

Asigna una ruta a un controlador que solo coincide si el método HTTP es GET

public [Phalcon\Mvc\Router\RouteInterface](Phalcon_Mvc_Router_RouteInterface) **post** (*string* $routePattern, *callable* $handler)

Asigna una ruta a un controlador que solo coincide si el método HTTP es POST

public [Phalcon\Mvc\Router\RouteInterface](Phalcon_Mvc_Router_RouteInterface) **put** (*string* $routePattern, *callable* $handler)

Asigna una ruta a un controlador que solo coincide si el método HTTP es PUT

public [Phalcon\Mvc\Router\RouteInterface](Phalcon_Mvc_Router_RouteInterface) **patch** (*string* $routePattern, *callable* $handler)

Asigna una ruta a un controlador que solo coincide si el método HTTP es PATCH

public [Phalcon\Mvc\Router\RouteInterface](Phalcon_Mvc_Router_RouteInterface) **head** (*string* $routePattern, *callable* $handler)

Asigna una ruta a un controlador que solo coincide si el método HTTP es HEAD

public [Phalcon\Mvc\Router\RouteInterface](Phalcon_Mvc_Router_RouteInterface) **delete** (*string* $routePattern, *callable* $handler)

Asigna una ruta a un controlador que solo coincide si el método HTTP es DELETE

public [Phalcon\Mvc\Router\RouteInterface](Phalcon_Mvc_Router_RouteInterface) **options** (*string* $routePattern, *callable* $handler)

Asigna una ruta a un controlador que solo coincide si el método HTTP es OPTIONS

public **mount** ([Phalcon\Mvc\Micro\CollectionInterface](Phalcon_Mvc_Micro_CollectionInterface) $collection)

Monta una colección de controladores

public [Phalcon\Mvc\Micro](Phalcon_Mvc_Micro) **notFound** (*callable* $handler)

Configura un controlador que será llamado cuando el enrutador no coincida con ninguna de las rutas definidas

public [Phalcon\Mvc\Micro](Phalcon_Mvc_Micro) **error** (*callable* $handler)

Configura un controlador que será llamado cuando se arroje una excepción al controlar la ruta

public **getRouter** ()

Devuelve el enrutador interno utilizado por la aplicación

public [Phalcon\Di\ServiceInterface](Phalcon_Di_ServiceInterface) **setService** (*string* $serviceName, *mixed* $definition, [*boolean* $shared])

Configura un servicio desde el DI

public **hasService** (*mixed* $serviceName)

Comprueba si un servicio está registrado en el DI

public *object* **getService** (*string* $serviceName)

Obtiene un servicio del DI

public *mixed* **getSharedService** (*string* $serviceName)

Obtiene un servicio compartido del DI

public *mixed* **handle** ([*string* $uri])

Maneja toda la solicitud

public **stop** ()

Detiene la ejecución del software intermedio evitando que se ejecuten otras softwares intermedios

public **setActiveHandler** (*callable* $activeHandler)

Configura externamente el controlador que debe ser llamado por la ruta correspondiente

public *callable* **getActiveHandler** ()

Devuelve el controlador que será llamado por la ruta correspondiente

public *mixed* **getReturnedValue** ()

Devuelve el valor devuelto por el controlador ejecutado

public *boolean* **offsetExists** (*string* $alias)

Comprueba si un servicio está registrado en el contenedor de servicios interno utilizando la sintaxis del arreglo

public **offsetSet** (*string* $alias, *mixed* $definition)

Permite registrar un servicio compartido en el contenedor de servicios interno utilizando la sintaxis del arreglo

```php
<?php

$app["request"] = new \Phalcon\Http\Request();

```

public *mixed* **offsetGet** (*string* $alias)

Permite obtener un servicio compartido en el contenedor de servicios interno utilizando la sintaxis del arreglo

```php
<?php

var_dump(
    $app["request"]
);

```

public **offsetUnset** (*string* $alias)

Elimina un servicio del contenedor de servicios interno utilizando la sintaxis del arreglo

public [Phalcon\Mvc\Micro](Phalcon_Mvc_Micro) **before** (*callable* $handler)

Anexa un software intermedio before para ser llamado antes de ejecutar la ruta

public [Phalcon\Mvc\Micro](Phalcon_Mvc_Micro) **afterBinding** (*callable* $handler)

Anexa un software intermedio afterBinding para ser llamado después del enlace del modelo

public [Phalcon\Mvc\Micro](Phalcon_Mvc_Micro) **after** (*callable* $handler)

Anexa un software intermedio "after" para ser llamado después de ejecutar la ruta

public [Phalcon\Mvc\Micro](Phalcon_Mvc_Micro) **finish** (*callable* $handler)

Anexa un software intermedio "finish" para ser llamado cuando finalice la solicitud

public **getHandlers** ()

Devuelve los controladores internos adjuntos a la aplicación

public **getModelBinder** ()

Obtiene el enlazador modelo

public **setModelBinder** ([Phalcon\Mvc\Model\BinderInterface](Phalcon_Mvc_Model_BinderInterface) $modelBinder, [*mixed* $cache])

Configura el enlazador modelo

```php
<?php

$micro = new Micro($di);
$micro->setModelBinder(new Binder(), 'cache');

```

public **getBoundModels** ()

Devuelve los modelos enlazados de la instancia del enlazador

public **getDI** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Devuelve el inyector de dependencias interno

public **setEventsManager** ([Phalcon\Events\ManagerInterface](Phalcon_Events_ManagerInterface) $eventsManager) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Establece el gestor de eventos

public **getEventsManager** () inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Devuelve el administrador de eventos interno

public **__get** (*mixed* $propertyName) inherited from [Phalcon\Di\Injectable](Phalcon_Di_Injectable)

Magic method __get