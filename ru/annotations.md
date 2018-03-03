<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Парсер аннотаций</a> 
      <ul>
        <li>
          <a href="#factory">Фабрика</a>
        </li>
        <li>
          <a href="#reading">Чтение аннотаций</a>
        </li>
        <li>
          <a href="#types">Типы аннотаций</a>
        </li>
        <li>
          <a href="#usage">Практическое использование</a> 
          <ul>
            <li>
              <a href="#usage-cache">Кэширование с помощью аннотаций</a>
            </li>
            <li>
              <a href="#usage-access-management">Контроль доступа и аннотации</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#adapters">Адаптеры аннотаций</a> 
          <ul>
            <li>
              <a href="#adapters-custom">Реализация собственных адаптеров</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#resources">Дополнительная литература</a>
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

<a name='factory'></a>

## Фабрика

Существует множество адаптеров аннотаций (см. [Адаптеры](#adapters)). Используемый вами, будет зависеть от нужд вашего приложения. Традиционный способ инициализации экземпляра адаптера выглядит следующим образом:

```php
<?php

use Phalcon\Annotations\Adapter\Memory as MemoryAdapter;

$reader = new MemoryAdapter();

// .....
```

Однако, вы можете использовать фабричный метод, чтобы достигнуть того же самого:

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

Фабричный загрузчик обеспечивает большую гибкость, при создании экземпляров адаптеров аннотаций из конфигурационных файлов.

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

Процесс чтения аннотаций является очень быстрым. Тем не менее, по причинам производительности, мы рекомендуем использовать адаптер для хранения обработанных аннотаций. Адаптеры кэшируют обработанные аннотации, избегая необходимости в их разборе снова и снова.

В примере выше был использован `Phalcon\Annotations\Adapter\Memory`. Этот адаптер кэширует аннотации только в процессе работы, поэтому он более подходит для разработки. Существуют и другие адаптеры, которые можно использовать в промышленной эксплуатации.

<a name='types'></a>

## Типы аннотаций

Аннотации могут иметь или не иметь параметров. Параметры могут быть простыми литералам (строкой, числом, булевым типом, null), массивом, хешированным списком или другими аннотациями:

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

Далее мы разберем несколько примеров по использованию аннотаций в PHP приложениях:

<a name='usage-cache'></a>

### Кэширование с помощью аннотаций

Давайте представим, что у нас есть контроллер и разработчик хочет сделать плагин, который автоматически запускает кэширование если последнее запущенное действие было помечено как имеющее возможность кэширования. Прежде всего, мы зарегистрируем плагин в сервисе Dispatcher, чтобы получать уведомление при выполнении маршрута:

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

`CacheEnablerPlugin` это плагин, который перехватывает каждое запущенное действие в диспетчере, включая кэширование если необходимо:

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

Теперь мы можем использовать аннотации в контроллере:

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

Вы можете использовать аннотации для того, чтобы сообщить ACL механизму какие контроллеры являются закрытыми для публичного доступа:

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

Компонент поддерживает адаптеры с возможностью кэширования проанализированных аннотаций. Это позволяет увеличивать производительность в боевом режиме и моментальное обновление данных при разработке и тестировании:

| Класс                                   | Описание                                                                                                                                                                         |
| --------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `Phalcon\Annotations\Adapter\Memory` | Аннотации в этом случае хранятся в памяти до завершения запроса. При перезагрузке страницы разбор будет осуществлён заново. Идеально для стадии разработки.                      |
| `Phalcon\Annotations\Adapter\Files`  | Разобранные аннотации хранятся в PHP-файлах, увеличивая производительность без необходимости постоянно анализа. Рекомендуется совместное использование с кэшированием байт-кода. |
| `Phalcon\Annotations\Adapter\Apc`    | Разобранные аннотации хранятся в APC-кэше, самый быстрый адаптер.                                                                                                                |
| `Phalcon\Annotations\Adapter\Xcache` | Разобранные аннотации хранятся в XCache-кэше. Также является быстрым адаптером.                                                                                                  |

<a name='adapters-custom'></a>

### Реализация собственных адаптеров

Для создания своего адаптера необходимо реализовать интерфейс `Phalcon\Annotations\AdapterInterface`, или использовать наследование от существующего адаптера.

<a name='resources'></a>

## Внешние ресурсы

* [Урок: Создание собственного инициализатора моделей с использованием аннотаций](https://blog.phalconphp.com/post/tutorial-creating-a-custom-models-initializer)