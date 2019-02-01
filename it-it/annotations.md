---
layout: article
language: 'it-it'
version: '4.0'
---
**This article reflects v3.4 and has not yet been revised**

<a name='overview'></a>

# Parser di annotazioni

It is the first time that an annotations parser component is written in C for the PHP world. `Phalcon\Annotations` is a general purpose component that provides ease of parsing and caching annotations in PHP classes to be used in applications.

Annotations are read from docblocks in classes, methods and properties. An annotation can be placed at any position in the docblock:

```php
<?php

/**
 * Questa è una descrizione della classe
 *
 * @AmazingClass(true)
 */
class Example
{
    /**
     * Questa p una proprietà con una caratteristica speciale
     *
     * @SpecialFeature
     */
    protected $someProperty;

    /**
     * Questo è un metodo
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
 * Questa è una proprietà con una caratteristica speciale
 *
 * @SpecialFeature
 *
 * Altri commenti
 *
 * @AnotherSpecialFeature(true)
 */
```

The parser is highly flexible, the following docblock is valid:

```php
<?php

/**
 * Questa proprietà con una caratteristica speciale @SpecialFeature({
someParameter='the value', false

 })  Altri commenti @AnotherSpecialFeature(true) @MoreAnnotations
 **/
```

However, to make the code more maintainable and understandable it is recommended to place annotations at the end of the docblock:

```php
<?php

/**
 * Questa è una proprietà con una caratteristica speciale
 * Altri commenti
 *
 * @SpecialFeature({someParameter='the value', false})
 * @AnotherSpecialFeature(true)
 */
```

<a name='factory'></a>

## "Fabbrica" (Factory)

There are many annotations adapters available (see [Adapters](#adapters)). Quello che si usa dipenderà dalle esigenze dell'applicazione. The traditional way of instantiating such an adapter is as follows:

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
    'adapter'  => 'memory',      // Carica l'adattatore Memory
];

$annotations = Factory::load($options);
```

The Factory loader provides more flexibility when dealing with instantiating annotations adapters from configuration files.

<a name='reading'></a>

## Lettura delle annotazioni

A reflector is implemented to easily get the annotations defined on a class using an object-oriented interface:

```php
<?php

use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;

$reader = new MemoryAdapter();

// "Accende il riflettore" sulle annotazioni nella classe Example
$reflector = $reader->get('Example');

// Legge le annotazioni nella classe docblock
$annotations = $reflector->getClassAnnotations();

// Scorre le annotazioni
foreach ($annotations as $annotation) {
    // Stampa il nome dell'annotazione
    echo $annotation->getName(), PHP_EOL;

    // Stampa il numero degli argomenti
    echo $annotation->numberArguments(), PHP_EOL;

    // Stampa gli argomenti
    print_r($annotation->getArguments());
}
```

The annotation reading process is very fast, however, for performance reasons it is recommended to store the parsed annotations using an adapter. Adapters cache the processed annotations avoiding the need of parse the annotations again and again.

[Phalcon\Annotations\Adapter\Memory](api/Phalcon_Annotations_Adapter_Memory) was used in the above example. This adapter only caches the annotations while the request is running and for this reason the adapter is more suitable for development. There are other adapters to swap out when the application is in production stage.

<a name='types'></a>

## Tipi di annotazioni

Annotations may have parameters or not. A parameter could be a simple literal (strings, number, boolean, null), an array, a hashed list or other annotation:

```php
<?php

/**
 * Annotazione semplice
 *
 * @SomeAnnotation
 */

/**
 * Annotazione con parametri
 *
 * @SomeAnnotation('Ciao', 'mondo 1, 2, 3, false, true)
 */

/**
 * Annotazioni con parametri nominati
 *
 * @SomeAnnotation(primo='Ciao', secondo='mondo', terzo=1)
 * @SomeAnnotation(primo: 'Ciao', secondo: 'mondo', terzo: 1)
 */

/**
 * Passiamo un array
 *
 * @SomeAnnotation([1, 2, 3, 4])
 * @SomeAnnotation({1, 2, 3, 4})
 */

/**
 * Passiamo un hash come parametro
 *
 * @SomeAnnotation({primo=1, secondo=2, terzo=3})
 * @SomeAnnotation({'primo'=1, 'secondo'=2, 'terzo'=3})
 * @SomeAnnotation({'primo': 1, 'secondo': 2, 'terzo': 3})
 * @SomeAnnotation(['primo': 1, 'secondo': 2, 'terzo': 3])
 */

/**
 * arrays/hashes nidificati
 *
 * @SomeAnnotation({'nome'='QualcheNome', 'altro'={
 *     'foo1': 'bar1', 'foo2': 'bar2', {1, 2, 3},
 * }})
 */

/**
 * Annotazioni nidificate
 *
 * @SomeAnnotation(first=@AnotherAnnotation(1, 2, 3))
 */
```

<a name='usage'></a>

## Utilizzo pratico

Next we will explain some practical examples of annotations in PHP applications:

<a name='usage-cache'></a>

### Abilitatore di cache con annotazioni

Let's pretend we've created the following controller and you want to create a plugin that automatically starts the cache if the last action executed is marked as cacheable. First off all, we register a plugin in the Dispatcher service to be notified when a route is executed:

```php
<?php

use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Manager as EventsManager;

$di['dispatcher'] = function () {
    $eventsManager = new EventsManager();

    // Allega il plugin agli eventi 'dispatch' 
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
 * Attiva la cache per una vista if l'ultima
 * azione eseguita ha l'annotazione @Cache
 */
class CacheEnablerPlugin extends Plugin
{
    /**
     * Questo evento è eseguito prima che ogni inoltro sia eseguito dal dispatcher (spedizioniere)
     */
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        // Parsa le annotazioni nel metodo correntemente in esecuzione
        $annotations = $this->annotations->getMethod(
            $dispatcher->getControllerClass(),
            $dispatcher->getActiveMethod()
        );

        // Controlla se il metodo ha una annotazione 'Cache'
        if ($annotations->has('Cache')) {
            // Il metodo ha l'annotazione 'Cache'
            $annotation = $annotations->get('Cache');

            // Ottieni il lifetime
            $lifetime = $annotation->getNamedParameter('lifetime');

            $options = [
                'lifetime' => $lifetime,
            ];

            // Controlla se c'è una chiave di cache definita dall'utente
            if ($annotation->hasNamedParameter('key')) {
                $options['key'] = $annotation->getNamedParameter('key');
            }

            // Abilita la cache per il metodo corrente
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
     * Questo è un commento
     *
     * @Cache(lifetime=86400)
     */
    public function showAllAction()
    {
        $this->view->article = Articles::find();
    }

    /**
     * Questo è un commento
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

### Area pubblica e privata con annotazioni

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
 * Questo è il plugin di sicurezza che coi controlli che gli utenti abbiano l'accesso solo ai moduli a loro assegnati
 */
class SecurityAnnotationsPlugin extends Plugin
{
    /**
     * Questa azione è eseguita prima di ogni altra azione nell'applicazione
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     *
     * @return bool
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        // Possibile nome della classe controllore
        $controllerName = $dispatcher->getControllerClass();

        // Possibile nome del metodo
        $actionName = $dispatcher->getActiveMethod();

        // Ottieni le annotazioni nella classe controllore
        $annotations = $this->annotations->get($controllerName);

        // Il controllore è privato?
        if ($annotations->getClassAnnotations()->has('Private')) {
            // Controlla se la variabile di sessione è attiva?
            if (!$this->session->get('auth')) {

                // L'utente  non è loggata, redirezionato al login
                $dispatcher->forward(
                    [
                        'controller' => 'session',
                        'action'     => 'login',
                    ]
                );

                return false;
            }
        }

        // Continua normalmente
        return true;
    }
}
```

<a name='adapters'></a>

## Adattatori di annotazioni

This component makes use of adapters to cache or no cache the parsed and processed annotations thus improving the performance or providing facilities to development/testing:

| Classe                                                                          | Descrizione                                                                                                                                                                       |
| ------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| [Phalcon\Annotations\Adapter\Memory](api/Phalcon_Annotations_Adapter_Memory) | The annotations are cached only in memory. When the request ends the cache is cleaned reloading the annotations in each request. This adapter is suitable for a development stage |
| [Phalcon\Annotations\Adapter\Files](api/Phalcon_Annotations_Adapter_Files)   | Parsed and processed annotations are stored permanently in PHP files improving performance. This adapter must be used together with a bytecode cache.                             |
| [Phalcon\Annotations\Adapter\Apc](api/Phalcon_Annotations_Adapter_Apc)       | Parsed and processed annotations are stored permanently in the APC cache improving performance. This is the faster adapter                                                        |
| [Phalcon\Annotations\Adapter\Xcache](api/Phalcon_Annotations_Adapter_Xcache) | Parsed and processed annotations are stored permanently in the XCache cache improving performance. This is a fast adapter too                                                     |

<a name='adapters-custom'></a>

### Implementazione di adattatori personalizzati

The [Phalcon\Annotations\AdapterInterface](api/Phalcon_Annotations_AdapterInterface) interface must be implemented in order to create your own annotations adapters or extend the existing ones.

<a name='resources'></a>

## Risorse esterne

* [Esercitazione: Creazione di inizializzatore di un modello personalizzato con annotazioni](https://blog.phalconphp.com/post/tutorial-creating-a-custom-models-initializer)