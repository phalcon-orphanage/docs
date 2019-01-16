* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# Analizador de anotaciones

It is the first time that an annotations parser component is written in C for the PHP world. `Phalcon\Annotations` is a general purpose component that provides ease of parsing and caching annotations in PHP classes to be used in applications.

Annotations are read from docblocks in classes, methods and properties. An annotation can be placed at any position in the docblock:

```php
<?php

/**
 * Descripción de la clase
 *
 * @AmazingClass(true)
 */
class Example
{
    /**
     * Esta es una propiedad con una característica especial
     *
     * @SpecialFeature
     */
    protected $someProperty;

    /**
     * Este es un método
     *
     * @SpecialFeature
     */
    public function someMethod()
    {
        // ...
    }
}
```

An annotation has the following syntax:

```php
/**
 * @NombreAnotacion
 * @NombreAnotacion(parámetro1, parámetro2, ...)
 */
```

Also, an annotation can be placed at any part of a docblock:

```php
<?php

/**
 * Esta es una propiedad con una característica especial
 *
 * @SpecialFeature
 *
 * Mas comentarios
 *
 * @AnotherSpecialFeature(true)
 */
```

The parser is highly flexible, the following docblock is valid:

```php
<?php

/**
 * Esta es una propiedad con una característica especial @SpecialFeature({
someParameter='the value', false

 })  Más comentarios @AnotherSpecialFeature(true) @MoreAnnotations
 **/
```

However, to make the code more maintainable and understandable it is recommended to place annotations at the end of the docblock:

```php
<?php

/**
 * Esta es una propiedad con una característica especial
 * Más comentarios
 *
 * @SpecialFeature({someParameter='the value', false})
 * @AnotherSpecialFeature(true)
 */
```

<a name='factory'></a>

## Factory

There are many annotations adapters available (see [Adapters](#adapters)). El que desee utilizar dependerá de las necesidades de su aplicación. The traditional way of instantiating such an adapter is as follows:

```php
<?php

use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;

$reader = new MemoryAdapter();

// .....
```

However you can also utilize the factory method to achieve the same thing:

```php
<?php


use Phalcon\Annotations\Factory;

$options = [
    'prefix'   => 'annotations',
    'lifetime' => '3600',
    'adapter'  => 'memory',      // Cargar adaptador de memoria
];

$annotations = Factory::load($options);
```

The Factory loader provides more flexibility when dealing with instantiating annotations adapters from configuration files.

<a name='reading'></a>

## Leyendo anotaciones

A reflector is implemented to easily get the annotations defined on a class using an object-oriented interface:

```php
<?php

use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;

$reader = new MemoryAdapter();

// Reflejamos las anotaciones en la clase Example
$reflector = $reader->get('Example');

// Leemos las anotaciones de la clase
$annotations = $reflector->getClassAnnotations();

// Iteramos las anotaciones
foreach ($annotations as $annotation) {
    // Imprimir el nombre de la anotación
    echo $annotation->getName(), PHP_EOL;

    // Imprimir número de argumentos
    echo $annotation->numberArguments(), PHP_EOL;

    // Imprimir argumentos
    print_r($annotation->getArguments());
}
```

The annotation reading process is very fast, however, for performance reasons it is recommended to store the parsed annotations using an adapter. Adapters cache the processed annotations avoiding the need of parse the annotations again and again.

[Phalcon\Annotations\Adapter\Memory](api/Phalcon_Annotations_Adapter_Memory) was used in the above example. This adapter only caches the annotations while the request is running and for this reason the adapter is more suitable for development. There are other adapters to swap out when the application is in production stage.

<a name='types'></a>

## Tipos de anotaciones

Annotations may have parameters or not. A parameter could be a simple literal (strings, number, boolean, null), an array, a hashed list or other annotation:

```php
<?php

/**
 * Anotación simple
 *
 * @SomeAnnotation
 */

/**
 * Anotación con parametros
 *
 * @SomeAnnotation('hello', 'world', 1, 2, 3, false, true)
 */

/**
 * Anotación con parámetros con nombres
 *
 * @SomeAnnotation(first='hello', second='world', third=1)
 * @SomeAnnotation(first: 'hello', second: 'world', third: 1)
 */

/**
 * Pasando un array
 *
 * @SomeAnnotation([1, 2, 3, 4])
 * @SomeAnnotation({1, 2, 3, 4})
 */

/**
 * Pasando un hash como parámetro
 *
 * @SomeAnnotation({first=1, second=2, third=3})
 * @SomeAnnotation({'first'=1, 'second'=2, 'third'=3})
 * @SomeAnnotation({'first': 1, 'second': 2, 'third': 3})
 * @SomeAnnotation(['first': 1, 'second': 2, 'third': 3])
 */

/**
 * Arrays/hashes anidados
 *
 * @SomeAnnotation({'name'='SomeName', 'other'={
 *     'foo1': 'bar1', 'foo2': 'bar2', {1, 2, 3},
 * }})
 */

/**
 * Anotaciones anidadas
 *
 * @SomeAnnotation(first=@AnotherAnnotation(1, 2, 3))
 */
```

<a name='usage'></a>

## Usos prácticos

Next we will explain some practical examples of annotations in PHP applications:

<a name='usage-cache'></a>

### Activar cache con anotaciones

Let's pretend we've created the following controller and you want to create a plugin that automatically starts the cache if the last action executed is marked as cacheable. First off all, we register a plugin in the Dispatcher service to be notified when a route is executed:

```php
<?php

use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Manager as EventsManager;

$di['dispatcher'] = function () {
    $eventsManager = new EventsManager();

    // Adjuntamos el plugin al evento 'dispatch' 
    $eventsManager->attach(
        'dispatch',
        new CacheEnablerPlugin()
    );

    $dispatcher = new MvcDispatcher();

    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
};
```

`CacheEnablerPlugin` is a plugin that intercepts every action executed in the dispatcher enabling the cache if needed:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\User\Plugin;

/**
 * Activa el cache para una vista,
 * si la última acción tiene la anotación @Cache
 */
class CacheEnablerPlugin extends Plugin
{
    /**
     * Este evento es ejecutado antes que cada ruta esa ejecutada en el dispatcher
     */
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        // Analizar las anotaciones en el método actualmente ejecutado
        $annotations = $this->annotations->getMethod(
            $dispatcher->getControllerClass(),
            $dispatcher->getActiveMethod()
        );

        // Comprobamos si el método tiene la anotación @Cache
        if ($annotations->has('Cache')) {
            // El método tiene la anotación 'Cache'
            $annotation = $annotations->get('Cache');

            // Obtenemos el 'lifetime'
            $lifetime = $annotation->getNamedParameter('lifetime');

            $options = [
                'lifetime' => $lifetime,
            ];

            // Comprobamos si el usuario definio un cache key o clave de cacheo
            if ($annotation->hasNamedParameter('key')) {
                $options['key'] = $annotation->getNamedParameter('key');
            }

            // Activamos el cache en el método actual
            $this->view->cache($options);
        }
    }
}
```

Now, we can use the annotation in a controller:

```php
<?php

use Phalcon\Mvc\Controller;

class NewsController extends Controller
{
    public function indexAction()
    {

    }

    /**
     * Este es un comentario
     *
     * @Cache(lifetime=86400)
     */
    public function showAllAction()
    {
        $this->view->article = Articles::find();
    }

    /**
     * Este es un comentario
     *
     * @Cache(key='my-key', lifetime=86400)
     */
    public function showAction($slug)
    {
        $this->view->article = Articles::findFirstByTitle($slug);
    }
}
```

<a name='usage-access-management'></a>

### Áreas privadas y públicas con anotaciones

You can use annotations to tell the ACL which controllers belong to the administrative areas:

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl\Adapter\Memory as AclList;

/**
 * Este es un plugin de seguridad que controla que los usuarios solo tengan acceso a los módulos que están asignados
 */
class SecurityAnnotationsPlugin extends Plugin
{
    /**
     * Eta acción es ejecutada antes de ejecutar cada action en la aplicación
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     *
     * @return bool
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        // Posible nombre de clase para el controlador
        $controllerName = $dispatcher->getControllerClass();

        // Posible nombre del método
        $actionName = $dispatcher->getActiveMethod();

        // Obtenemos las anotaciones en la clase controlador
        $annotations = $this->annotations->get($controllerName);

        // El controlador es privado?
        if ($annotations->getClassAnnotations()->has('Private')) {
            // Chequeamos si la variable de sesión está activa?
            if (!$this->session->get('auth')) {

                // El usuario no esta logeado, redirigimos al login
                $dispatcher->forward(
                    [
                        'controller' => 'session',
                        'action'     => 'login',
                    ]
                );

                return false;
            }
        }

        // Continuamos normalmente
        return true;
    }
}
```

<a name='adapters'></a>

## Adaptadores de anotaciones

This component makes use of adapters to cache or no cache the parsed and processed annotations thus improving the performance or providing facilities to development/testing:

| Clase                                                                           | Descripción                                                                                                                                                                                      |
| ------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| [Phalcon\Annotations\Adapter\Memory](api/Phalcon_Annotations_Adapter_Memory) | Las anotaciones son cacheadas en memoria. Cuando la petición finaliza la caché se limpia. Las anotaciones se recargan en cada solicitud. Este adaptador es adecuado para una etapa de desarrollo |
| [Phalcon\Annotations\Adapter\Files](api/Phalcon_Annotations_Adapter_Files)   | Las anotaciones analizadas y procesadas se almacenan permanentemente en archivos para mejorar el rendimiento. Este adaptador se debe utilizar junto con un caché bytecode.                       |
| [Phalcon\Annotations\Adapter\Apc](api/Phalcon_Annotations_Adapter_Apc)       | Las anotaciones analizadas y procesadas se almacenan permanentemente en la caché de APC. Este es el adaptador más rápido                                                                         |
| [Phalcon\Annotations\Adapter\Xcache](api/Phalcon_Annotations_Adapter_Xcache) | Las anotaciones analizadas y procesadas se almacenan permanentemente en el cache XCache para mejorar el rendimiento. Este también es un adaptador rápido                                         |

<a name='adapters-custom'></a>

### Implementando sus propios adaptadores

The [Phalcon\Annotations\AdapterInterface](api/Phalcon_Annotations_AdapterInterface) interface must be implemented in order to create your own annotations adapters or extend the existing ones.

<a name='resources'></a>

## Recursos externos

* [Tutorial: Creando el inicializador de modelos personalizado con anotaciones](https://blog.phalconphp.com/post/tutorial-creating-a-custom-models-initializer)