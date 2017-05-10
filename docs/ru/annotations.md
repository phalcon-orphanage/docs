<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Парсер аннотаций</a> <ul>
        <li>
          <a href="#reading">Чтение аннотаций</a>
        </li>
        <li>
          <a href="#types">Типы аннотаций</a>
        </li>
        <li>
          <a href="#usage">Практическое использование</a> <ul>
            <li>
              <a href="#usage-cache">Кэширование с помощью аннотаций</a>
            </li>
            <li>
              <a href="#usage-access-management">Контроль доступа и аннотации</a>
            </li>
          </ul>
        </li>
        
        <li>
          <a href="#adapters">Адаптеры аннотаций</a> <ul>
            <li>
              <a href="#adapters-custom">Реализация собственных адаптеров</a>
            </li>
          </ul>
        </li>
        
        <li>
          <a href="#resources">Дополнительная информация</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Парсер аннотаций

Изначально компонент парсера аннотаций был написан на языке C для мира PHP. `Phalcon\Annotations` — это компонент общего назначения, который обеспечивает простоту синтаксического анализа и кеширования аннотаций в PHP-классах, для последующего их использования в приложениях.

Аннотации читаются из блоков комментариев docblock в классах, его методах и свойствах. Аннотации могут быть помещены в любое место блока документации docblock:

```php
<?php

/**
 * Это специальное свойство
 *
 * @AmazingClass(true)
 */
class Example
{
    /**
     * Это свойство с особенностью
     *
     * @SpecialFeature
     */
    protected $someProperty;

    /**
     * Это метод
     *
     * @SpecialFeature
     */
    public function someMethod()
    {
        // ...
    }
}
```

Аннотации имеют следующий синтаксис:

```php
/**
 * @Annotation-Name
 * @Annotation-Name(param1, param2, ...)
 */
```

Аннотации также могут быть помещены в любую часть блока документации:

```php
<?php

/**
 * Это специальное свойство
 *
 * @SpecialFeature
 *
 * Еще комментарии
 *
 * @AnotherSpecialFeature(true)
 */
```

Парсер является очень гибким инструментом, поэтому следующий блок документации также является правильным:

```php
<?php

/**
 * Это специальное свойство @SpecialFeature({
someParameter='the value', false

 })  Еще комментарии @AnotherSpecialFeature(true) @MoreAnnotations
 **/
```

Тем не менее, рекомендуется помещать аннотации в конце блоков документации, чтобы сделать код более понятным и удобным для поддержки:

```php
<?php

/**
 * Это специальное свойство
 * Еще комментарии
 *
 * @SpecialFeature({someParameter='the value', false})
 * @AnotherSpecialFeature(true)
 */
```

<a name='reading'></a>

## Чтение аннотаций

Для простого получения аннотаций класса с использованием объектно-ориентированного интерфейса, реализован рефлектор:

```php
<?php

use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;

$reader = new MemoryAdapter();

// Отразить аннотации в классе Example
$reflector = $reader->get('Example');

// Прочесть аннотации в блоке документации класса
$annotations = $reflector->getClassAnnotations();

// Произвести обход всех аннотаций
foreach ($annotations as $annotation) {
    // Вывести название аннотации
    echo $annotation->getName(), PHP_EOL;

    // Вывести количество аргументов
    echo $annotation->numberArguments(), PHP_EOL;

    // Вывести аргументы
    print_r($annotation->getArguments());
}
```

Процесс чтения аннотаций является очень быстрым. Тем не менее, по причинам производительности, мы рекомендуем использовать адаптер для хранения обработанных аннотаций. Adapters cache the processed annotations avoiding the need of parse the annotations again and again.

`Phalcon\Annotations\Adapter\Memory` was used in the above example. This adapter only caches the annotations while the request is running and for this reason the adapter is more suitable for development. There are other adapters to swap out when the application is in production stage.

<a name='types'></a>

## Типы аннотаций

Annotations may have parameters or not. A parameter could be a simple literal (strings, number, boolean, null), an array, a hashed list or other annotation:

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

<a name='usage'></a>

## Практическое использование

Next we will explain some practical examples of annotations in PHP applications:

<a name='usage-cache'></a>

### Кэширование с помощью аннотаций

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

### Контроль доступа и аннотации

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

## Адаптеры аннотаций

This component makes use of adapters to cache or no cache the parsed and processed annotations thus improving the performance or providing facilities to development/testing:

| Class | Description | |\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---+\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\---\----| | `Phalcon\Annotations\Adapter\Memory` | The annotations are cached only in memory. When the request ends the cache is cleaned reloading the annotations in each request. This adapter is suitable for a development stage | | `Phalcon\Annotations\Adapter\Files` | Parsed and processed annotations are stored permanently in PHP files improving performance. This adapter must be used together with a bytecode cache. | | `Phalcon\Annotations\Adapter\Apc` | Parsed and processed annotations are stored permanently in the APC cache improving performance. This is the faster adapter | | `Phalcon\Annotations\AdapterXcache` | Parsed and processed annotations are stored permanently in the XCache cache improving performance. This is a fast adapter too |

<a name='adapters-custom'></a>

### Реализация собственных адаптеров

Для создания своего адаптера необходимо реализовать интерфейс `Phalcon\Annotations\AdapterInterface`, или использовать наследование от существующего адаптера.

<a name='resources'></a>

## Дополнительная информация

- [Tutorial: Creating a custom model's initializer with Annotations](https://blog.phalconphp.com/post/tutorial-creating-a-custom-models-initializer)