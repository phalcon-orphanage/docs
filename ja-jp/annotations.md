---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'アノテーション'
keywords: 'annotations, routing, annotations parser, docblocks'
---

# アノテーション

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## 概要

Phalcon introduced the first annotations parser component written in C for PHP. The `Phalcon\Annotations` namespace contains general purpose components that offer an easy way to parse and cache annotations in PHP applications.

## 使い方

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

An example for a model is:

```php
<?php

use Phalcon\Mvc\Model;

/**
 * Customers
 *
 * Represents a customer record
 *
 * @Source('co_customers');
 * @HasMany("cst_id", "Invoices", "inv_cst_id")
 */
class Customers extends Model
{
    /**
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false, column="cst_id")
     */
    public $id;

    /**
     * @Column(type="string", nullable=false, column="cst_name_first")
     */
    public $nameFirst;

    /**
     * @Column(type="string", nullable=false, column="cst_name_last")
     */
    public $nameLast;
}
```

## Types

Annotations may have parameters or not. A parameter could be a simple literal (`strings`, `number`, `boolean`, `null`), an `array`, a hashed list or other annotation:

```php
/**
 * @SomeAnnotation
 */
```

Simple Annotation

```php
/**
 * @SomeAnnotation('hello', 'world', 1, 2, 3, false, true)
 */
```

Annotation with parameters

```php
/**
 * @SomeAnnotation(first='hello', second='world', third=1)
 * @SomeAnnotation(first: 'hello', second: 'world', third: 1)
 */
```

Annotation with named parameters

```php
/**
 * @SomeAnnotation([1, 2, 3, 4])
 * @SomeAnnotation({1, 2, 3, 4})
 */
```

Passing an array

```php
/**
 * @SomeAnnotation({first=1, second=2, third=3})
 * @SomeAnnotation({'first'=1, 'second'=2, 'third'=3})
 * @SomeAnnotation({'first': 1, 'second': 2, 'third': 3})
 * @SomeAnnotation(['first': 1, 'second': 2, 'third': 3])
 */
```

Passing a hash as parameter

```php
/**
 * @SomeAnnotation({'name'='SomeName', 'other'={
 *     'foo1': 'bar1', 'foo2': 'bar2', {1, 2, 3},
 * }})
 */
```

Nested arrays/hashes

```php
/**
 * @SomeAnnotation(first=@AnotherAnnotation(1, 2, 3))
 */
```

Nested Annotations

## Adapters

This component makes use of adapters to cache or no cache the parsed and processed annotations improving performance:

| アダプター                                                                                       | Description                                                                  |
| ------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------- |
| [Phalcon\Annotations\Adapter\Apcu](api/phalcon_annotations#annotations-adapter-apcu)     | Use APCu to store parsed and processed annotations (production)              |
| [Phalcon\Annotations\Adapter\Memory](api/phalcon_annotations#annotations-adapter-memory) | Use memory to store annotations (development)                                |
| [Phalcon\Annotations\Adapter\Stream](api/phalcon_annotations#annotations-adapter-stream) | Use a file stream to store annotations. Must be used with a byte-code cache. |

### Apcu

[Phalcon\Annotations\Adapter\Apcu](api/phalcon_annotations#annotations-adapter-apcu) stores the parsed and processed annotations using the APCu cache. This adapter is suitable for production systems. However, once the web server restarts, the cache will be cleared and will have to be rebuilt. The adapter accepts two parameters in the constructor's `options` array: - `prefix` - the prefix for the key stored - `lifetime` - the cache lifetime

```php
<?php

use Phalcon\Annotations\Adapter\Apcu;

$adapter = new Apcu(
    [
        'prefix'   => 'my-prefix',
        'lifetime' => 3600,
    ]
);
```

Internally, the adapter stores data prefixing every key with `_PHAN`. This setting cannot be changed. It however gives you the option to scan APCu for keys that are prefixed with `_PHAN` and clear them if needed.

```php
<?php

use APCuIterator;

$result   = true;
$pattern  = "/^_PHAN/";
$iterator = new APCuIterator($pattern);

if (true === is_object($iterator)) {
    return false;
}

foreach ($iterator as $item) {
    if (true !== apcu_delete($item["key"])) {
        $result = false;
    }
}

return $result;
```

### Memory

[Phalcon\Annotations\Adapter\Memory](api/phalcon_annotations#annotations-adapter-memory) stores the parsed and processed annotations in memory. This adapter is suitable for development systems. The cache is rebuilt on every request, and therefore can immediately reflect changes while developing your application.

```php
<?php

use Phalcon\Annotations\Adapter\Memory;

$adapter = new Memory();
```

### Stream

[Phalcon\Annotations\Adapter\Stream](api/phalcon_annotations#annotations-adapter-stream) stores the parsed and processed annotations in a file on the server. This adapter can be used in production systems but it will increase the I/O since for every request the annotations cache files will need to be read from the file system. The adapter accepts one parameter in the constructor's `options` array: - `annotationsDir` - the directory to store the annotations cache

```php
<?php

use Phalcon\Annotations\Adapter\Stream;

$adapter = new Stream(
    [
        'annotationsDir' => '/app/storage/cache/annotations',
    ]
);
```

If there is a problem with storing the data in the folder due to permissions or any other reason, a [Phalcon\Annotations\Exception](api/phalcon_annotations#annotations-exception) will be thrown.

### Custom

[Phalcon\Annotations\Adapter\AdapterInterface](api/phalcon_annotations#annotations-adapter-adapterinterface) is available. Extending this interface will allow you to create custom adapters.

## Factory

### `newInstance`

We can easily create an annotations adapter class using the `new` keyword. However Phalcon offers the [Phalcon\Annotations\AnnotationsFactory](api/phalcon_annotations#annotations-annotationsfactory) class, so that developers can easily instantiate annotations adapters. The factory will accept an array of options which will in turn be used to instantiate the necessary adapter class. The factory always returns a new instance that implements the [Phalcon\Annotations\Adapter\AdapterInterface](api/phalcon_annotations#annotations-adapter-adapterinterface). The names of the preconfigured adapters are:

| Name     | アダプター                                                                                       |
| -------- | ------------------------------------------------------------------------------------------- |
| `apcu`   | [Phalcon\Annotations\Adapter\Apcu](api/phalcon_annotations#annotations-adapter-apcu)     |
| `memory` | [Phalcon\Annotations\Adapter\Memory](api/phalcon_annotations#annotations-adapter-memory) |
| `stream` | [Phalcon\Annotations\Adapter\Stream](api/phalcon_annotations#annotations-adapter-stream) |

The example below shows how you can create an Apcu annotations adapter:

```php
<?php

use Phalcon\Annotations\AnnotationsFactory;

$options = [
    'prefix'   => 'my-prefix',
    'lifetime' => 3600,
];

$factory = new AdapterFactory();
$apcu    = $factory->newInstance('apcu', $options);
```

### `load`

The [Phalcon\Annotations\AnnotationsFactory](api/phalcon_annotations#annotations-annotationsfactory) also offers the `load` method, which accepts a configuration object. This object can be an array or a [Phalcon\Config](config) object, with directives that are used to set up the adapter. The object requires the `adapter` element, as well as the `options` element with the necessary directives.

```php
<?php

use Phalcon\Annotations\AnnotationsFactory;

$options = [
    'adapter' => 'apcu',
    'options' => [
        'prefix'   => 'my-prefix',
        'lifetime' => 3600,
    ]
];

$factory = new AdapterFactory();
$apcu    = $factory->load($options);
```

## Reading Annotations

A reflector is implemented to easily get the annotations defined on a class using an object-oriented interface. [Phalcon\Annotations\Reader](api/phalcon_annotations#annotations-reader) is used along with [Phalcon\Annotations\Reflection](api/phalcon_annotations#annotations-reflection). They also utilize the collection [Phalcon\Annotations\Collection](api/phalcon_annotations#annotations-collection) that contains [Phalcon\Annotations\Annotation](api/phalcon_annotations#annotations-annotation) objects once the annotations are parsed.

```php
<?php

use Phalcon\Annotations\Adapter\Memory;

$adapter = new Memory();

$reflector   = $adapter->get('Invoices');
$annotations = $reflector->getClassAnnotations();

foreach ($annotations as $annotation) {
    echo $annotation->getName(), PHP_EOL;
    echo $annotation->numberArguments(), PHP_EOL;

    print_r($annotation->getArguments());
}
```

In the above example we first create the memory annotations adapter. We then call `get` on it to load the annotations from the `Invoices` class. The `getClassAnnotations` will return a [Phalcon\Annotations\Collection](api/phalcon_annotations#annotations-collection) class. We iterate through the collection and print out the name (`getName`), the number arguments (`numberArguments`) and then we print all the arguments (`getArguments`) on screen.

The annotation reading process is very fast, however, for performance reasons it is recommended to store the parsed annotations using an adapter so as to reduce unnecessary CPU cycles for parsing.

## Exceptions

Any exceptions thrown in the `Phalcon\Annotations` namespace will be of type [Phalcon\Annotations\Exception](api/phalcon_annotations#annotations-exception). You can use these exceptions to selectively catch exceptions thrown only from this component.

```php
<?php

use Phalcon\Annotations\Adapter\Memory;
use Phalcon\Annotations\Exception;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function index()
    {
        try {
            $adapter = new Memory();

            $reflector   = $adapter->get('Invoices');
            $annotations = $reflector->getClassAnnotations();

            foreach ($annotations as $annotation) {
                echo $annotation->getExpression('unknown-expression');
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
```

## Examples

**Controller based access**

You can use annotations to define which areas are controlled by the ACL. We can do this by registering a plugin in the events manager listening to the `beforeExceuteRoute` event, or simply implement the method in our base controller.

First we need to set the annotations manager in our DI container:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Annotations\Adapter\Apcu;

$container = new FactoryDefault();

$container->set(
    'annotations',
    function () {
        return new Apcu(
            [
                'lifetime' => 86400
            ]
        );
    }
);
```

and now in the base controller we implement the `beforeExceuteRoute` method:

```php
<?php

namespace MyApp\Controllers;

use Phalcon\Annotations\Adapter\Apcu;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Controller
use MyApp\Components\Auth;

/**
 * @property Apcu $annotations
 * @property Auth $auth 
 */
class BaseController extends Controller
{
    /**
     * @param Event $event
     * @param Dispatcher $dispatcher
     *
     * @return bool
     */
    public function beforeExceuteRoute(
        Dispatcher $dispatcher
    ) {
        $controllerName = $dispatcher->getControllerClass();

        $annotations = $this
            ->annotations
            ->get($controllerName)
        ;

        $exists = $annotations
            ->getClassAnnotations()
            ->has('Private')
        ;

        if (true !== $exists) {
            return true;
        }

        if (true === $this->auth->isLoggedIn()) {
            return true;
        }

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

> **NOTE** You can also implement the above to a listener and use the `beforeDispatch` event if you wish.
{: .alert .alert-info }

and in our controllers we can specify:

```php
<?php

namespace MyApp\Controllers;

use MyApp\Controllers\BaseController;

/**
 * @Private(true) 
 */
class Invoices extends BaseController
{
    public function indexAction()
    {
    }
}
```

**Group based access**

You might want to expand on the above and offer a more granular access control for your application. For this, we will also use the `beforeExceuteRoute` in the controller but will add the access metadata on each action. If we need a specific controller to be *locked* we can also use the `initialize` method.

First we need to set the annotations manager in our DI container:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Annotations\Adapter\Apcu;

$container = new FactoryDefault();

$container->set(
    'annotations',
    function () {
        return new Apcu(
            [
                'lifetime' => 86400
            ]
        );
    }
);
```

and now in the base controller we implement the `beforeExceuteRoute` method:

```php
<?php

namespace MyApp\Controllers;

use Phalcon\Annotations\Adapter\Apcu;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Controller;
use MyApp\Components\Auth;

/**
 * @property Apcu $annotations
 * @property Auth $auth 
 */
class BaseController extends Controller
{
    /**
     * @param Event $event
     * @param Dispatcher $dispatcher
     *
     * @return bool
     */
    public function beforeExceuteRoute(
        Dispatcher $dispatcher
    ) {
        $controllerName = $dispatcher->getControllerClass();
        $actionName     = $dispatcher->getActionName()
                        . 'Action';

        $data = $this
            ->annotations
            ->getMethod($controllerName, $actionName)
        ;
        $access    = $data->get('Access');
        $aclGroups = $access->getArguments();

        $user   = $this->acl->getUser();
        $groups = $user->getRelated('groups');

        $userGroups = [];
        foreach ($groups as $group) {
            $userGroups[] = $group->grp_name;
        }

        $allowed = array_intersect($userGroups, $aclGroups);
        $allowed = (count($allowed) > 0);

        if (true === $allowed) {
            return true;
        }

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

and in our controllers:

```php
<?php

namespace MyApp\Controllers;

use MyApp\Controllers\BaseController;

/**
 * @Private(true) 
 */
class Invoices extends BaseController
{
    /**
     * @Access(
     *     'Administrators',
     *     'Accounting',
     *     'Users',
     *     'Guests'
     * )
     */
    public function indexAction()
    {
    }

    /**
     * @Access(
     *     'Administrators',
     *     'Accounting',
     * )
     */
    public function listAction()
    {
    }

    /**
     * @Access(
     *     'Administrators',
     *     'Accounting',
     * )
     */
    public function viewAction()
    {
    }
}
```

## Additional Resources

* [Tutorial: Creating a custom model's initializer with Annotations](https://blog.phalcon.io/post/tutorial-creating-a-custom-models-initializer)