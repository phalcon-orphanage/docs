---
layout: article
language: 'pl-pl'
version: '4.0'
---
**This article reflects v3.4 and has not yet been revised**

<a name='overview'></a>

# Parser adnotacji

It is the first time that an annotations parser component is written in C for the PHP world. `Phalcon\Annotations` is a general purpose component that provides ease of parsing and caching annotations in PHP classes to be used in applications.

Annotations are read from docblocks in classes, methods and properties. An annotation can be placed at any position in the docblock:

```php
<? php / ** * jest to opis klasy ** @AmazingClass(true) * / Klasa przykład {/ ** * ta właściwość ze specjalną funkcją ** @SpecialFeature * / chroniony $someProperty;      / ** * Jest to metoda ** @SpecialFeature * publicznych funkcji someMethod() {/ /...
    } }
```

An annotation has the following syntax:

```php
/ ** * @Annotation-Name * @Annotation-Name(param1, param2,...) */
```

Also, an annotation can be placed at any part of a docblock:

```php
<? php / ** * ta właściwość ze specjalną funkcją ** @SpecialFeature ** więcej uwag ** @AnotherSpecialFeature(true) * /
```

The parser is highly flexible, the following docblock is valid:

```php
<? php / ** * tę właściwość przy użyciu specjalnych funkcji @SpecialFeature ({someParameter = 'wartość', false}) więcej komentarze @AnotherSpecialFeature(true) @MoreAnnotations ** /
```

However, to make the code more maintainable and understandable it is recommended to place annotations at the end of the docblock:

```php
<?php

/**
 * To jest właściwość ze specjalną funkcją
 * Więcej komentarzy
 *
 * @SpecialFeature({someParameter='the value', false})
 * @AnotherSpecialFeature(true)
 */
```

<a name='factory'></a>

## Fabryka

There are many annotations adapters available (see [Adapters](#adapters)). Ten, którego użyjesz będzie polegał na potrzebach twojej aplikacji. The traditional way of instantiating such an adapter is as follows:

```php
<?php

use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;

$reader = new MemoryAdapter();

// .....
```

However you can also utilize the factory method to achieve the same thing:

```php
<?php


użyj Phalcon\Annotations\Factory;

$options = [
    'prefix'   => 'adnotacje',
    'lifetime' => '3600',
    'adapter'  => 'pamięć',      // Załaduj adapter Memory
];

$annotations = Factory::load($options);
```

The Factory loader provides more flexibility when dealing with instantiating annotations adapters from configuration files.

<a name='reading'></a>

## Czytanie adnotacji

A reflector is implemented to easily get the annotations defined on a class using an object-oriented interface:

```php
<?php

użyj Phalcon\Annotations\Adapter\Memory jako MemoryAdapter;

$reader = nowy MemoryAdapter();

// Reflektuj adnotacje w Klasie Example
$reflector = $reader->get('Example');

// Przeczytaj adnotacje w klasie' docblock
$annotations = $reflector->getClassAnnotations();

// Trawersuj adnotacje
foreach ($annotations as $annotation) {
    // Print the annotation name
    echo $annotation->getName(), PHP_EOL;

    // Drukuj liczbę argumentów
    echo $annotation->numberArguments(), PHP_EOL;

    // Drukuj argumenty
    print_r($annotation->getArguments());
}
```

The annotation reading process is very fast, however, for performance reasons it is recommended to store the parsed annotations using an adapter. Adapters cache the processed annotations avoiding the need of parse the annotations again and again.

[Phalcon\Annotations\Adapter\Memory](api/Phalcon_Annotations_Adapter_Memory) was used in the above example. This adapter only caches the annotations while the request is running and for this reason the adapter is more suitable for development. There are other adapters to swap out when the application is in production stage.

<a name='types'></a>

## Typy adnotacji

Annotations may have parameters or not. A parameter could be a simple literal (strings, number, boolean, null), an array, a hashed list or other annotation:

```php
<?php

/**
 * Prosta Adnotacja
 *
 * @JakaśAdnotacja
 */

/**
 * Adnotacja z parametrami
 *
 * @JakaśAdnotacja('witaj', 'świecie', 1, 2, 3, fałsz, prawda)
 */

/**
 * Adnotacja z nazwanymi parametrami
 *
 *
 * @JakaśAdnotacja(pierwsza='witaj', druga='świecie', trzecia=1)
 * @JakaśAdnotacja(pierwsza: 'witaj', druga: 'świecie', trzecia: 1)
 */

/**
 * Podanie szyku
 *
 * @JakaśAdnotacja([1, 2, 3, 4])
 * @JakaśAdnotacja({1, 2, 3, 4})
 */

/**
 *Podanie hashu jako parametru
 *
 * @JakaśAdnotacja({pierwsza=1, druga=2, trzecia=3})
 * @JakaśAdnotacja({'pierwsza'=1, 'druga'=2, 'trzecia'=3})
 * @JakaśAdnotacja({'pierwsza': 1, 'druga': 2, 'trzecia': 3})
 * @JakaśAdnotacja(['pierwsza': 1, 'druga': 2, 'trzecia': 3])
 */

/**
 * Zagnieżdżone szyki/hashe
 *
 * @JakaśAdnotacja({'nazwa'='JakaśNazwa', 'inne'={
 * 'foo1': 'bar1', 'foo2': 'bar2', {1, 2, 3},
 * }})
 */

/**
 * Zagnieżdżone Adnotacje
 *
 * @JakaśAdnotacja(pierwsza=@InnaAdnotacja(1, 2, 3))
 */
```

<a name='usage'></a>

## Praktyczne wykorzystanie

Next we will explain some practical examples of annotations in PHP applications:

<a name='usage-cache'></a>

### Włącznik pamięci podręcznej z adnotacjami

Let's pretend we've created the following controller and you want to create a plugin that automatically starts the cache if the last action executed is marked as cacheable. First off all, we register a plugin in the Dispatcher service to be notified when a route is executed:

```php
<?php

use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Manager as EventsManager;

$di['dispatcher'] = function () {
    $eventsManager = new EventsManager();

    // Attach the plugin to 'dispatch' events
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
 * Enables the cache for a view if the latest
 * executed action has the annotation @Cache
 */
class CacheEnablerPlugin extends Plugin
{
    /**
     * This event is executed before every route is executed in the dispatcher
     */
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        // Parse the annotations in the method currently executed
        $annotations = $this->annotations->getMethod(
            $dispatcher->getControllerClass(),
            $dispatcher->getActiveMethod()
        );

        // Check if the method has an annotation 'Cache'
        if ($annotations->has('Cache')) {
            // The method has the annotation 'Cache'
            $annotation = $annotations->get('Cache');

            // Get the lifetime
            $lifetime = $annotation->getNamedParameter('lifetime');

            $options = [
                'lifetime' => $lifetime,
            ];

            // Check if there is a user defined cache key
            if ($annotation->hasNamedParameter('key')) {
                $options['key'] = $annotation->getNamedParameter('key');
            }

            // Enable the cache for the current method
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
     * This is a comment
     *
     * @Cache(lifetime=86400)
     */
    public function showAllAction()
    {
        $this->view->article = Articles::find();
    }

    /**
     * This is a comment
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

### Prywatny/Publiczny obszar z adnotacjami

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
 * This is the security plugin which controls that users only have access to the modules they're assigned to
 */
class SecurityAnnotationsPlugin extends Plugin
{
    /**
     * This action is executed before execute any action in the application
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     *
     * @return bool
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        // Possible controller class name
        $controllerName = $dispatcher->getControllerClass();

        // Possible method name
        $actionName = $dispatcher->getActiveMethod();

        // Get annotations in the controller class
        $annotations = $this->annotations->get($controllerName);

        // The controller is private?
        if ($annotations->getClassAnnotations()->has('Private')) {
            // Check if the session variable is active?
            if (!$this->session->get('auth')) {

                // The user is no logged redirect to login
                $dispatcher->forward(
                    [
                        'controller' => 'session',
                        'action'     => 'login',
                    ]
                );

                return false;
            }
        }

        // Continue normally
        return true;
    }
}
```

<a name='adapters'></a>

## Adnotacje Adapterów

This component makes use of adapters to cache or no cache the parsed and processed annotations thus improving the performance or providing facilities to development/testing:

| Klasa                                                                          | Ious                                                                                                                                                                              |
| ------------------------------------------------------------------------------ | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| [Phalcon\Adnotacje\Adaptery\Pamięć](api/Phalcon_Annotations_Adapter_Memory) | The annotations are cached only in memory. When the request ends the cache is cleaned reloading the annotations in each request. This adapter is suitable for a development stage |
| [Phalcon\Adnotacje\Adaptery\Pliki](api/Phalcon_Annotations_Adapter_Files)   | Parsed and processed annotations are stored permanently in PHP files improving performance. This adapter must be used together with a bytecode cache.                             |
| [Phalcon\Adnotacje\Adaptery\Apc](api/Phalcon_Annotations_Adapter_Apc)       | Parsed and processed annotations are stored permanently in the APC cache improving performance. This is the faster adapter                                                        |
| [Phalcon\Adnotacje\Adaptery\Xcache](api/Phalcon_Annotations_Adapter_Xcache) | Parsed and processed annotations are stored permanently in the XCache cache improving performance. This is a fast adapter too                                                     |

<a name='adapters-custom'></a>

### Realizacja własnych kart

The [Phalcon\Annotations\AdapterInterface](api/Phalcon_Annotations_AdapterInterface) interface must be implemented in order to create your own annotations adapters or extend the existing ones.

<a name='resources'></a>

## Zasoby zewnętrzne

* [Samouczek: Tworzenie własnego modelu inicjatora z adnotacjami](https://blog.phalconphp.com/post/tutorial-creating-a-custom-models-initializer)