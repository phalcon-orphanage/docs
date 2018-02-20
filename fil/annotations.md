<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Annotations Parser</a> <ul>
        <li>
          <a href="#factory">Factory</a>
        </li>
        <li>
          <a href="#reading">Reading Annotations</a>
        </li>
        <li>
          <a href="#types">Types of Annotations</a>
        </li>
        <li>
          <a href="#usage">Practical Usage</a> <ul>
            <li>
              <a href="#usage-cache">Cache Enabler with Annotations</a>
            </li>
            <li>
              <a href="#usage-access-management">Private/Public areas with Annotations</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#adapters">Annotations Adapters</a> <ul>
            <li>
              <a href="#adapters-custom">Implementing your own adapters</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#resources">External Resources</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Annotations Parser

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

<a name='factory'></a>

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

<a name='reading'></a>

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

`Phalcon\Annotations\Adapter\Memory` was used in the above example. This adapter only caches the annotations while the request is running and for this reason the adapter is more suitable for development. May mga iba pang mga adapter na maaaring ipalit kapag ang aplikasyon ay nasa production stage na.

<a name='types'></a>

## Mga Uri ng Anotasyon

Ang mga anotasyon ay maaaring mayroong mga parameter o wala. Ang parameter ay maaaring isang simpleng literal (mga string, numero, boolean, null), isang array, o naka-hash na lista o ibang anotasyon:

```php
<?php

/**
 * Simpleng Anotasyon
 *
 * @SomeAnnotation
 */

/**
 * Anotasyon na may mga parameter
 *
 * @SomeAnnotation('hello', 'world', 1, 2, 3, false, true)
 */

/**
 * Anotasyon na may pinangalanang mga parameter
 *
 * @SomeAnnotation(first='hello', second='world', third=1)
 * @SomeAnnotation(first: 'hello', second: 'world', third: 1)
 */

/**
 * Pagpasa ng array
 *
 * @SomeAnnotation([1, 2, 3, 4])
 * @SomeAnnotation({1, 2, 3, 4})
 */

/**
 * Pagpasa ng hash bilang parameter
 *
 * @SomeAnnotation({first=1, second=2, third=3})
 * @SomeAnnotation({'first'=1, 'second'=2, 'third'=3})
 * @SomeAnnotation({'first': 1, 'second': 2, 'third': 3})
 * @SomeAnnotation(['first': 1, 'second': 2, 'third': 3])
 */

/**
 * Naka-nest na mga arrays/hashes
 *
 * @SomeAnnotation({'name'='SomeName', 'other'={
 *     'foo1': 'bar1', 'foo2': 'bar2', {1, 2, 3},
 * }})
 */

/**
 * Naka-nest na mga Anotasyon
 *
 * @SomeAnnotation(first=@AnotherAnnotation(1, 2, 3))
 */
```

<a name='usage'></a>

## Praktikal na Paggamit

Sa sunod ay aming ipapaliwanag ang ilan sa pratikal na mga halimbawa ng mga anotasyon sa PHP na mga aplikasyon:

<a name='usage-cache'></a>

### Cache Enabler na may mga Anotasyon

Tayo ay magkunwari na nalikha natin ang sumusunod na controller at gusto mong maglikha ng plugin na awtomatikong nagpapatakbo sa cache kung ang huling aksyon na pinatakbo ay nakamarka na maaaring i-cache. Una sa lahat, ating i-rehistro ang plugin sa Dispatcher na serbisyo para maabisuhan kung ang route at napatakbo na:

```php
<?php

use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Events\Manager as EventsManager;

$di['dispatcher'] = function () {
    $eventsManager = new EventsManager();

    // I-attach ang plugin sa 'dispatch' na mga events
    $eventsManager->attach(
        'dispatch',
        new CacheEnablerPlugin()
    );

    $dispatcher = new MvcDispatcher();

    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
};
```

Ang `CacheEnablerPlugin` ay isang plugin na nagsusundo sa bawat aksyon na pinatakbo ng dispatcher na nagpapagana ng cache kung kinakailangan:

```php
<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\User\Plugin;

/**
 * Nagpapagana sa cache para sa isang view kung ang pinakabagong
 * pinatakbog aksyon ay mayroong anotasyon na @Cache
 */
class CacheEnablerPlugin extends Plugin
{
    /**
     * Ang event na ito ay pinapatakbo bago pinapatakbo ng dispatcher ang bawat route
     */
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        // Parse the annotations in the method currently executed
        $annotations = $this->annotations->getMethod(
            $dispatcher->getControllerClass(),
            $dispatcher->getActiveMethod()
        );

        // Suriin kung ang method ay mayroong anotasyon na 'Cache'
        if ($annotations->has('Cache')) {
            // The method has the annotation 'Cache'
            $annotation = $annotations->get('Cache');

            // Kunin ang lifetime
            $lifetime = $annotation->getNamedParameter('lifetime');

            $options = [
                'lifetime' => $lifetime,
            ];

            // Suriin kung mayroong inilarawan ang gumagamit na cache key
            if ($annotation->hasNamedParameter('key')) {
                $options['key'] = $annotation->getNamedParameter('key');
            }

            // Paganahin ang cache para sa kasalukuyang method
            $this->view->cache($options);
        }
    }
}
```

Ngayon, maaari na nating gamitin ang anotasyon sa isang controller:

```php
<?php

use Phalcon\Mvc\Controller;

class NewsController extends Controller
{
    public function indexAction()
    {

    }

    /**
     * Ito ay isang komento
     *
     * @Cache(lifetime=86400)
     */
    public function showAllAction()
    {
        $this->view->article = Articles::find();
    }

    /**
     * Ito ay isang komento
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

### Pribado/Publikong mga bahagi na may mga Anotasyon

Maaari kang gumamit ng mga anotasyon para sabihan ang ACL kung aling mga controller ang kabilang sa tagapangasiwang mga bahagi:

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
 * Ito ang security plugin na nagkokontrol sa mgg gumamagit na ma-access lang nila ang mga module na naka-assign sa kanila
 */
class SecurityAnnotationsPlugin extends Plugin
{
    /**
     * Ang aksyon ay pinapatakbo bago ipatakbo ang kahit anong aksyon sa loob ng aplikasyon
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     *
     * @return bool
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        // Posibleng pangalan ng controller na class
        $controllerName = $dispatcher->getControllerClass();

        // Posibleng pangalan ng method
        $actionName = $dispatcher->getActiveMethod();

        // Kumuha ng mga anotasyon sa controller na class
        $annotations = $this->annotations->get($controllerName);

        // Ang controller ay pribado?
        if ($annotations->getClassAnnotations()->has('Private')) {
            // Suriin kung ang sesyon na variable ay aktibo?
            if (!$this->session->get('auth')) {

                // Ang gumagamit ay hindi naka-logged redirect para maka-login
                $dispatcher->forward(
                    [
                        'controller' => 'session',
                        'action'     => 'login',
                    ]
                );

                return false;
            }
        }

        // Normal na magpatuloy
        return true;
    }
}
```

<a name='adapters'></a>

## Mga Adpator ng mga Anotasyon

Ang komponent na ito ay gumagamit sa mga adaptor para mag-cache o hindi mag-cache sa mga naka-parse at naprosesong mga anotasyon na nagpapahusay sa performance at nagbibigay ng mga pasilidad para sa development/testing:

| Klase                                   | Paglalarawan                                                                                                                                                                      |
| --------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `Phalcon\Annotations\Adapter\Memory` | The annotations are cached only in memory. When the request ends the cache is cleaned reloading the annotations in each request. This adapter is suitable for a development stage |
| `Phalcon\Annotations\Adapter\Files`  | Parsed and processed annotations are stored permanently in PHP files improving performance. This adapter must be used together with a bytecode cache.                             |
| `Phalcon\Annotations\Adapter\Apc`    | Parsed and processed annotations are stored permanently in the APC cache improving performance. This is the faster adapter                                                        |
| `Phalcon\Annotations\Adapter\Xcache` | Parsed and processed annotations are stored permanently in the XCache cache improving performance. This is a fast adapter too                                                     |

<a name='adapters-custom'></a>

### Implementing your own adapters

The `Phalcon\Annotations\AdapterInterface` interface must be implemented in order to create your own annotations adapters or extend the existing ones.

<a name='resources'></a>

## External Resources

- [Tutorial: Creating a custom model's initializer with Annotations](https://blog.phalconphp.com/post/tutorial-creating-a-custom-models-initializer)