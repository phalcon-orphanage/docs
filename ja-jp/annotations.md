---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'Annotations'
keywords: 'annotations, routing, annotations parser, docblocks'
---

# Annotations Parser

* * *

![](/assets/images/document-status-under-review-red.svg)

## Overview

It is the first time that an annotations parser component is written in C for the PHP world. `Phalcon\Annotations` is a general purpose component that provides ease of parsing and caching annotations in PHP classes to be used in applications.

Annotations are read from docblocks in classes, methods and properties. An annotation can be placed at any position in the docblock:

```php
<?php

/**
 * This is the class description
 *
 * @AmazingClass(true)
 */
class Example
{
    /**
     * This a property with a special feature
     *
     * @SpecialFeature
     */
    protected $someProperty;

    /**
     * This is a method
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
 * This a property with a special feature
 *
 * @SpecialFeature
 *
 * More comments
 *
 * @AnotherSpecialFeature(true)
 */
```

The parser is highly flexible, the following docblock is valid:

```php
<?php

/**
 * This a property with a special feature @SpecialFeature({
someParameter='the value', false

 })  More comments @AnotherSpecialFeature(true) @MoreAnnotations
 **/
```

However, to make the code more maintainable and understandable it is recommended to place annotations at the end of the docblock:

```php
<?php

/**
 * This a property with a special feature
 * More comments
 *
 * @SpecialFeature({someParameter='the value', false})
 * @AnotherSpecialFeature(true)
 */
```

## Factory

There are many annotations adapters available (see [Adapters](#adapters)). The one you use will depend on the needs of your application. The traditional way of instantiating such an adapter is as follows:

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
    'adapter'  => 'memory',      // Load the Memory adapter
];

$annotations = Factory::load($options);
```

The Factory loader provides more flexibility when dealing with instantiating annotations adapters from configuration files.

## Reading Annotations

A reflector is implemented to easily get the annotations defined on a class using an object-oriented interface:

```php
<?php

use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;

$reader = new MemoryAdapter();

// Reflect the annotations in the class Example
$reflector = $reader->get('Example');

// Read the annotations in the class' docblock
$annotations = $reflector->getClassAnnotations();

// Traverse the annotations
foreach ($annotations as $annotation) {
    // Print the annotation name
    echo $annotation->getName(), PHP_EOL;

    // Print the number of arguments
    echo $annotation->numberArguments(), PHP_EOL;

    // Print the arguments
    print_r($annotation->getArguments());
}
```

The annotation reading process is very fast, however, for performance reasons it is recommended to store the parsed annotations using an adapter. Adapters cache the processed annotations avoiding the need of parse the annotations again and again.

[Phalcon\Annotations\Adapter\Memory](api/Phalcon_Annotations_Adapter_Memory) was used in the above example. This adapter only caches the annotations while the request is running and for this reason the adapter is more suitable for development. There are other adapters to swap out when the application is in production stage.

## Types of Annotations

Annotations may have parameters or not. A parameter could be a simple literal (`strings`, `number`, `boolean`, `null`), an `array`, a hashed list or other annotation:

```php
<?php

/**
 * Simple Annotation
 *
 * @SomeAnnotation
 */

/**
 * Annotation with parameters
 *
 * @SomeAnnotation('hello', 'world', 1, 2, 3, false, true)
 */

/**
 * Annotation with named parameters
 *
 * @SomeAnnotation(first='hello', second='world', third=1)
 * @SomeAnnotation(first: 'hello', second: 'world', third: 1)
 */

/**
 * Passing an array
 *
 * @SomeAnnotation([1, 2, 3, 4])
 * @SomeAnnotation({1, 2, 3, 4})
 */

/**
 * Passing a hash as parameter
 *
 * @SomeAnnotation({first=1, second=2, third=3})
 * @SomeAnnotation({'first'=1, 'second'=2, 'third'=3})
 * @SomeAnnotation({'first': 1, 'second': 2, 'third': 3})
 * @SomeAnnotation(['first': 1, 'second': 2, 'third': 3])
 */

/**
 * Nested arrays/hashes
 *
 * @SomeAnnotation({'name'='SomeName', 'other'={
 *     'foo1': 'bar1', 'foo2': 'bar2', {1, 2, 3},
 * }})
 */

/**
 * Nested Annotations
 *
 * @SomeAnnotation(first=@AnotherAnnotation(1, 2, 3))
 */
```

## Practical Usage

Next we will explain some practical examples of annotations in PHP applications:

### Cache Enabler with Annotations

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
use Phalcon\Plugin;

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

        // Return normally if the method doesn't have a 'Cache' annotation
        if (!$annotations->has('Cache')) {
            return true;
        }

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

### Private/Public areas with Annotations

You can use annotations to tell the ACL which controllers belong to the administrative areas:

```php
<?php

use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Resource;
use Phalcon\Events\Event;
use Phalcon\Plugin;
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

        // The controller is not private? Continue normally
        if (!$annotations->getClassAnnotations()->has('Private')) {
            return true;
        }

        // Check if the session variable is active?
        if ($this->session->get('auth')) {
            return true;
        }

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
```

## Annotations Adapters

This component makes use of adapters to cache or no cache the parsed and processed annotations thus improving the performance or providing facilities to development/testing:

| Class                                                                           | Description                                                                                                                                                                       |
| ------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| [Phalcon\Annotations\Adapter\Memory](api/Phalcon_Annotations_Adapter_Memory) | The annotations are cached only in memory. When the request ends the cache is cleaned reloading the annotations in each request. This adapter is suitable for a development stage |
| [Phalcon\Annotations\Adapter\Files](api/Phalcon_Annotations_Adapter_Files)   | Parsed and processed annotations are stored permanently in PHP files improving performance. This adapter must be used together with a bytecode cache.                             |
| [Phalcon\Annotations\Adapter\Apcu](api/Phalcon_Annotations_Adapter_Apcu)     | Parsed and processed annotations are stored permanently in the APCu cache improving performance. This is the fastest adapter                                                      |

### Implementing your own adapters

The [Phalcon\Annotations\AdapterInterface](api/Phalcon_Annotations_AdapterInterface) interface must be implemented in order to create your own annotations adapters or extend the existing ones.

## External Resources

* [Tutorial: Creating a custom model's initializer with Annotations](https://blog.phalcon.io/post/tutorial-creating-a-custom-models-initializer)