---
layout: article
language: 'de-de'
version: '4.0'
---
##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# Anmerkungen (Annotations)-Parser

It is the first time that an annotations parser component is written in C for the PHP world. `Phalcon\Annotations` is a general purpose component that provides ease of parsing and caching annotations in PHP classes to be used in applications.

Annotations are read from docblocks in classes, methods and properties. An annotation can be placed at any position in the docblock:

```php
<?php

/**
 * Das ist die Klassenbeschreibung
 *
 * @AmazingClass(true)
 */
class Example
{
    /**
     * Dies ist eine Spezialeigenschaft
     *
     * @SpecialFeature
     */
    protected $someProperty;

    /**
     * Dies ist eine Method
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
 * @Annotation-Name
 * @Annotation-Name(param1, param2, ...)
 */
```

Also, an annotation can be placed at any part of a docblock:

```php
<?php

/**
 * Das ist eine Eigenschaft mit einer speziellen Funktion
 *
 * @SpecialFeature
 *
 * Weitere Kommentare
 *
 * @AnotherSpecialFeature(true)
 */
```

The parser is highly flexible, the following docblock is valid:

```php
<?php

/**
 * Dies ist eine Eigenschaft mit einer speziellen Funktion @SpecialFeature({
someParameter='the value', false

 })  mehr Kommentare @AnotherSpecialFeature(true) @MoreAnnotations
 **/
```

However, to make the code more maintainable and understandable it is recommended to place annotations at the end of the docblock:

```php
<?php

/**
 * Dies ist eine Eigenschaft mit einer speziellen Funktion
 * Weitere Kommentare
 *
 * @SpecialFeature({someParameter='the value', false})
 * @AnotherSpecialFeature(true)
 */
```

<a name='factory'></a>

## Factory

There are many annotations adapters available (see [Adapters](#adapters)). Welche Sie verwenden, hängt von den Anforderungen Ihrer Anwendung ab. The traditional way of instantiating such an adapter is as follows:

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
    'adapter'  => 'memory',      // Hauptspeicher Adapter laden
];

$annotations = Factory::load($options);
```

The Factory loader provides more flexibility when dealing with instantiating annotations adapters from configuration files.

<a name='reading'></a>

## Anmerkungen lesen

A reflector is implemented to easily get the annotations defined on a class using an object-oriented interface:

```php
<?php

use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;

$reader = new MemoryAdapter();

// Die Anmerkungen in der Example Klasse abbilden
$reflector = $reader->get('Example');

// Anmerkungen im docblock der Klasse lesen
$annotations = $reflector->getClassAnnotations();

// Durch alle Anmerkungen durchgehen
foreach ($annotations as $annotation) {
    // Name der Anmerkung ausgeben
    echo $annotation->getName(), PHP_EOL;

    // Anzahl Argumente ausgeben
    echo $annotation->numberArguments(), PHP_EOL;

    // Argumente ausgeben
    print_r($annotation->getArguments());
}
```

The annotation reading process is very fast, however, for performance reasons it is recommended to store the parsed annotations using an adapter. Adapters cache the processed annotations avoiding the need of parse the annotations again and again.

[Phalcon\Annotations\Adapter\Memory](api/Phalcon_Annotations_Adapter_Memory) was used in the above example. This adapter only caches the annotations while the request is running and for this reason the adapter is more suitable for development. There are other adapters to swap out when the application is in production stage.

<a name='types'></a>

## Arten von Anmerkungen

Annotations may have parameters or not. A parameter could be a simple literal (strings, number, boolean, null), an array, a hashed list or other annotation:

```php
<?php

/**
 * Einfache Anmerkung
 *
 * @SomeAnnotation
 */

/**
 * Anmerkung mit Parametern
 *
 * @SomeAnnotation('hello', 'world', 1, 2, 3, false, true)
 */

/**
 * Anmerkung mit benannten Parametern
 *
 * @SomeAnnotation(first='hello', second='world', third=1)
 * @SomeAnnotation(first: 'hello', second: 'world', third: 1)
 */

/**
 * Ein array mitgeben
 *
 * @SomeAnnotation([1, 2, 3, 4])
 * @SomeAnnotation({1, 2, 3, 4})
 */

/**
 * Einen Hash als Parameter mitgeben
 *
 * @SomeAnnotation({first=1, second=2, third=3})
 * @SomeAnnotation({'first'=1, 'second'=2, 'third'=3})
 * @SomeAnnotation({'first': 1, 'second': 2, 'third': 3})
 * @SomeAnnotation(['first': 1, 'second': 2, 'third': 3])
 */

/**
 * Geschachtelte arrays/hashes
 *
 * @SomeAnnotation({'name'='SomeName', 'other'={
 *     'foo1': 'bar1', 'foo2': 'bar2', {1, 2, 3},
 * }})
 */

/**
 * Geschachtelte Anmerkungen
 *
 * @SomeAnnotation(first=@AnotherAnnotation(1, 2, 3))
 */
```

<a name='usage'></a>

## Praktische Anwendung

Next we will explain some practical examples of annotations in PHP applications:

<a name='usage-cache'></a>

### Cache-Enabler mit Anmerkungen

Let's pretend we've created the following controller and you want to create a plugin that automatically starts the cache if the last action executed is marked as cacheable. First off all, we register a plugin in the Dispatcher service to be notified when a route is executed:

```php
<?php

use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Manager as EventsManager;

$di['dispatcher'] = function () {
    $eventsManager = new EventsManager();

    // Füge das plugin an die 'dispatch' Ereignisse
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
 * Befähigt den cache zur Einsicht, falls die letzte 
 * ausgeführte Aktion eine Anmerkungen @Cache besaß
 */
class CacheEnablerPlugin extends Plugin
{
    /**
     * Dieses Ereignis wird ausgeführt bevor jede route im dispatcher ausgeführt wird
     */
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        // Parse the annotations in the method currently executed
        $annotations = $this->annotations->getMethod(
            $dispatcher->getControllerClass(),
            $dispatcher->getActiveMethod()
        );

        // Prüfen, ob die Methode die Anmerkung 'Cache' besitzt
        if ($annotations->has('Cache')) {
            // The method has the annotation 'Cache'
            $annotation = $annotations->get('Cache');

            // Liefert die Lebensdauer
            $lifetime = $annotation->getNamedParameter('lifetime');

            $options = [
                'lifetime' => $lifetime,
            ];

            // Prüfen, ob es einen benutzerdefinierten cache Schlüssel gibt
            if ($annotation->hasNamedParameter('key')) {
                $options['key'] = $annotation->getNamedParameter('key');
            }

            // Cache für aktuelle methode aktivieren
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
     * Das ist ein Kommentar
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

### Private/öffentliche Bereiche mit Anmerkungen

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
 * Das ist ein Sicherheits Plugin welches steuert, ob Benutzer Zugang zu den Modulen besitzen, welche Sie nutzen wollen
 */
class SecurityAnnotationsPlugin extends Plugin
{
    /**
     * Diese Aktion wird ausgeführt bevor irgendeine andere Aktion in der Anwendung ausgeführt wird
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     *
     * @return bool
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        // Möglicher controller Klassenname
        $controllerName = $dispatcher->getControllerClass();

        // Möglicher Methoden Name
        $actionName = $dispatcher->getActiveMethod();

        // Liefert Anmerkungen in der Controller Klasse
        $annotations = $this->annotations->get($controllerName);

        // ist der Controller private?
        if ($annotations->getClassAnnotations()->has('Private')) {
            // Prüfen, ob die Session variable aktiv ist?
            if (!$this->session->get('auth')) {

                // Der Benutzer ist nicht eingeloggt , weiterleitung zum login
                $dispatcher->forward(
                    [
                        'controller' => 'session',
                        'action'     => 'login',
                    ]
                );

                return false;
            }
        }

        // Normal weiter
        return true;
    }
}
```

<a name='adapters'></a>

## Anmerkungen-Adapter

This component makes use of adapters to cache or no cache the parsed and processed annotations thus improving the performance or providing facilities to development/testing:

| Klasse                                                                          | Beschreibung                                                                                                                                                                      |
| ------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| [Phalcon\Annotations\Adapter\Memory](api/Phalcon_Annotations_Adapter_Memory) | The annotations are cached only in memory. When the request ends the cache is cleaned reloading the annotations in each request. This adapter is suitable for a development stage |
| [Phalcon\Annotations\Adapter\Files](api/Phalcon_Annotations_Adapter_Files)   | Parsed and processed annotations are stored permanently in PHP files improving performance. This adapter must be used together with a bytecode cache.                             |
| [Phalcon\Annotations\Adapter\Apc](api/Phalcon_Annotations_Adapter_Apc)       | Parsed and processed annotations are stored permanently in the APC cache improving performance. This is the faster adapter                                                        |
| [Phalcon\Annotations\Adapter\Xcache](api/Phalcon_Annotations_Adapter_Xcache) | Parsed and processed annotations are stored permanently in the XCache cache improving performance. This is a fast adapter too                                                     |

<a name='adapters-custom'></a>

### Implementierung von eigenen Adaptern

The [Phalcon\Annotations\AdapterInterface](api/Phalcon_Annotations_AdapterInterface) interface must be implemented in order to create your own annotations adapters or extend the existing ones.

<a name='resources'></a>

## Externe Ressourcen

* [Tutorial: Erstellen einer benutzerdefinierten Modell Initialisierung mit Anmerkungen](https://blog.phalconphp.com/post/tutorial-creating-a-custom-models-initializer)