* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# Парсер аннотаций

It is the first time that an annotations parser component is written in C for the PHP world. `Phalcon\Annotations` is a general purpose component that provides ease of parsing and caching annotations in PHP classes to be used in applications.

Annotations are read from docblocks in classes, methods and properties. An annotation can be placed at any position in the docblock:

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
 * Это специальное свойство
 *
 * @SpecialFeature
 *
 * Еще комментарии
 *
 * @AnotherSpecialFeature(true)
 */
```

The parser is highly flexible, the following docblock is valid:

```php
<?php

/**
 * Это специальное свойство @SpecialFeature({
someParameter='the value', false

 })  Еще комментарии @AnotherSpecialFeature(true) @MoreAnnotations
 **/
```

However, to make the code more maintainable and understandable it is recommended to place annotations at the end of the docblock:

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

<a name='factory'></a>

## Фабрика

There are many annotations adapters available (see [Adapters](#adapters)). Используемый вами, будет зависеть от нужд вашего приложения. The traditional way of instantiating such an adapter is as follows:

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
    'adapter'  => 'memory',      // Загрузка Memory адаптера
];

$annotations = Factory::load($options);
```

The Factory loader provides more flexibility when dealing with instantiating annotations adapters from configuration files.

<a name='reading'></a>

## Чтение аннотаций

A reflector is implemented to easily get the annotations defined on a class using an object-oriented interface:

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

The annotation reading process is very fast, however, for performance reasons it is recommended to store the parsed annotations using an adapter. Adapters cache the processed annotations avoiding the need of parse the annotations again and again.

[Phalcon\Annotations\Adapter\Memory](api/Phalcon_Annotations_Adapter_Memory) was used in the above example. This adapter only caches the annotations while the request is running and for this reason the adapter is more suitable for development. There are other adapters to swap out when the application is in production stage.

<a name='types'></a>

## Типы аннотаций

Annotations may have parameters or not. A parameter could be a simple literal (strings, number, boolean, null), an array, a hashed list or other annotation:

```php
<?php

/**
 * Простая аннотация
 *
 * @SomeAnnotation
 */

/**
 * Аннотация с параметрами
 *
 * @SomeAnnotation('hello', 'world', 1, 2, 3, false, true)
 */

/**
 * Аннотация с именованными параметрами
 *
 * @SomeAnnotation(first='hello', second='world', third=1)
 * @SomeAnnotation(first: 'hello', second: 'world', third: 1)
 */

/**
 * Передача массива
 *
 * @SomeAnnotation([1, 2, 3, 4])
 * @SomeAnnotation({1, 2, 3, 4})
 */

/**
 * Передача хеша в качестве параметра
 *
 * @SomeAnnotation({first=1, second=2, third=3})
 * @SomeAnnotation({'first'=1, 'second'=2, 'third'=3})
 * @SomeAnnotation({'first': 1, 'second': 2, 'third': 3})
 * @SomeAnnotation(['first': 1, 'second': 2, 'third': 3])
 */

/**
 * Вложенные массивы/хеши
 *
 * @SomeAnnotation({'name'='SomeName', 'other'={
 *     'foo1': 'bar1', 'foo2': 'bar2', {1, 2, 3},
 * }})
 */

/**
 * Вложенные аннотации
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

    // Привязать плагин к событию 'dispatch'
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
 * Включение кэша для представления, если
 * последнее запущенное действие имело аннотацию @Cache
 */
class CacheEnablerPlugin extends Plugin
{
    /**
     * Это событие запускается перед запуском каждого маршрута в диспетчере
     */
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        // Разбор аннотаций в текущем запущенном методе
        $annotations = $this->annotations->getMethod(
            $dispatcher->getControllerClass(),
            $dispatcher->getActiveMethod()
        );

        // Проверить, имеет ли метод аннотацию 'Cache'
        if ($annotations->has('Cache')) {
            // Метод имеет аннотацию 'Cache'
            $annotation = $annotations->get('Cache');

            // Получить время жизни кэша
            $lifetime = $annotation->getNamedParameter('lifetime');

            $options = [
                'lifetime' => $lifetime,
            ];

            // Проверить, есть ли определенный пользователем ключ кэша
            if ($annotation->hasNamedParameter('key')) {
                $options['key'] = $annotation->getNamedParameter('key');
            }

            // Включить кэш для текущего метода
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
     * Это комментарий
     *
     * @Cache(lifetime=86400)
     */
    public function showAllAction()
    {
        $this->view->article = Articles::find();
    }

    /**
     * Это комментарий
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
 * Это плагин безопастности, который контролирует,
 * что пользователи имеют доступ только к разрешенным модулям
 */
class SecurityAnnotationsPlugin extends Plugin
{
    /**
     * Этот метод будет вызван перед выполнением любого действия контроллера 
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     *
     * @return bool
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        // Название класса контроллера
        $controllerName = $dispatcher->getControllerClass();

        // Название метода
        $actionName = $dispatcher->getActiveMethod();

        // Получаем аннотации из класса контроллера
        $annotations = $this->annotations->get($controllerName);

        // Является ли контроллер приватным?
        if ($annotations->getClassAnnotations()->has('Private')) {
            // Проверяем аутентификацию с использованием сессии
            if (!$this->session->get('auth')) {

                // Пользователь не авторизован, перенаправляем на /login
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

| Класс                                                                           | Описание                                                                                                                                                                         |
| ------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| [Phalcon\Annotations\Adapter\Memory](api/Phalcon_Annotations_Adapter_Memory) | Аннотации в этом случае хранятся в памяти до завершения запроса. При перезагрузке страницы разбор будет осуществлён заново. Идеально для стадии разработки.                      |
| [Phalcon\Annotations\Adapter\Files](api/Phalcon_Annotations_Adapter_Files)   | Разобранные аннотации хранятся в PHP-файлах, увеличивая производительность без необходимости постоянно анализа. Рекомендуется совместное использование с кэшированием байт-кода. |
| [Phalcon\Annotations\Adapter\Apc](api/Phalcon_Annotations_Adapter_Apc)       | Разобранные аннотации хранятся в APC-кэше, самый быстрый адаптер.                                                                                                                |
| [Phalcon\Annotations\Adapter\Xcache](api/Phalcon_Annotations_Adapter_Xcache) | Разобранные аннотации хранятся в XCache-кэше. Также является быстрым адаптером.                                                                                                  |

<a name='adapters-custom'></a>

### Реализация собственных адаптеров

The [Phalcon\Annotations\AdapterInterface](api/Phalcon_Annotations_AdapterInterface) interface must be implemented in order to create your own annotations adapters or extend the existing ones.

<a name='resources'></a>

## Дополнительная литература

* [Урок: Создание собственного инициализатора моделей с использованием аннотаций](https://blog.phalconphp.com/post/tutorial-creating-a-custom-models-initializer)