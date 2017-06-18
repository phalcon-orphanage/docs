<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Управление ресурсами</a> <ul>
        <li>
          <a href="#add">Adding Resources</a>
        </li>
        <li>
          <a href="#resources-local-remote">Локальные/удалённые ресурсы</a>
        </li>
        <li>
          <a href="#collections">Collections</a>
        </li>
        <li>
          <a href="#url-prefixes">Префиксы</a>
        </li>
        <li>
          <a href="#minification-filtering">Минификация/Фильтрация</a> <ul>
            <li>
              <a href="#builtin-filters">Встроенные фильтры</a>
            </li>
            <li>
              <a href="#custom-filters">Пользовательские фильтры</a>
            </li>
          </ul>
        </li>
        
        <li>
          <a href="#custom-output">Пользовательский вывод</a>
        </li>
        <li>
          <a href="#improving-performance">Повышение производительности</a>
        </li>
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Assets Management

`Phalcon\Assets` — это компонент позволяющий разработчику управлять статичными ресурсами в веб-приложении, такими как каскадные таблицы стилей или скрипты.

`Phalcon\Assets\Manager` доступен в контейнере сервисов и вы можете добавлять ресурсы из любой части приложения, где контейнер доступен.

<a name='add'></a>

## Adding Resources

Поддерживаются ресурсы двух типов: CSS и JavaScript. Но при необходимости, можно реализовать поддержку любых других. Внутренний механизм менеджера ресурсов хранит две коллекции, одну для JavaScript, а другую для CSS.

Добавить ресурсы в эти коллекции очень просто:

```php
<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function index()
    {
        // Добавляем некоторые локальные CSS ресурсы
        $this->assets->addCss('css/style.css');
        $this->assets->addCss('css/index.css');

        // А теперь некоторые локальные JavaScript ресурсы
        $this->assets->addJs('js/jquery.js');
        $this->assets->addJs('js/bootstrap.min.js');
    }
}
```

Далее, добавленные ресурсы могут быть отображены в представлениях:

```php
<html>
    <head>
        <title>Некоторый удивительный веб-сайт</title>

        <?php $this->assets->outputCss(); ?>
    </head>

    <body>
        <!-- ... -->

        <?php $this->assets->outputJs(); ?>
    </body>
<html>
```

С использованием синтаксиса Volt:

```volt
<html>
    <head>
        <title>Некоторый удивительный веб-сайт</title>

        {{ assets.outputCss() }}
    </head>

    <body>
        <!-- ... -->

        {{ assets.outputJs() }}
    </body>
<html>
```

В целях достижения лучшей производительности, рекомендуется размещать загрузку JavaScript-скриптов в конце страницы, а не в `<head>`.

<a name='local-remote'></a>

## Local/Remote resources

Локальные ресурсы это те, которые предоставляются вами в том же приложении. Обычно они расположены в корневом каталоге приложения. Ссылки на локальные ресурсы генерируются с помощью сервиса `url`, чаще с применением `Phalcon\Mvc\Url`.

Удалённые ресурсы, такие как общие библиотеки, например [jQuery](https://jquery.com), [Bootstrap](http://getbootstrap.com) или пр., предоставляемые посредством [CDN](https://en.wikipedia.org/wiki/Content_delivery_network).

Второй параметр методов `addCss()` и `addJs()` говорит является ли ресурс локальным или нет (если `true`, то локальный, `false` — удалённый). По умолчанию, менеджер ресурсов будет предполагать, что ресурс является локальным:

```php
<?php

public function indexAction()
{
    // Добавляем некоторые удалённые CSS ресурсы
    $this->assets->addCss('//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css', false);

    // А теперь, некоторые локальные CSS ресурсы
    $this->assets->addCss('css/style.css', true);
    $this->assets->addCss('css/extra.css');
}
```

<a name='collections'></a>

## Collections

В коллекциях группируются однотипные ресурсы. Менеджер ресурсов всегда создает две коллекции: `css` и `js`. Для группирования специфичных ресурсов вы можете создавать дополнительные:

```php
<?php

// JavaScript ресурсы в коллекии header
$headerCollection = $this->assets->collection('header');

$headerCollection->addJs('js/jquery.js');
$headerCollection->addJs('js/bootstrap.min.js');

// JavaScript ресурсы в коллекии footer
$footerCollection = $this->assets->collection('footer');

$footerCollection->addJs('js/jquery.js');
$footerCollection->addJs('js/bootstrap.min.js');
```

Затем в представлении:

```php
<html>
    <head>
        <title>Некоторый удивительный веб-сайт</title>

        <?php $this->assets->outputJs('header'); ?>
    </head>

    <body>
        <!-- ... -->

        <?php $this->assets->outputJs('footer'); ?>
    </body>
<html>
```

Volt syntax:

```twig
<html>
    <head>
        <title>Некоторый удивительный веб-сайт</title>

        {{ assets.outputCss('header') }}
    </head>

    <body>
        <!-- ... -->

        {{ assets.outputJs('footer') }}
    </body>
<html>
```

<a name='url-prefixes'></a>

## URL Prefixes

К коллекциям могут применяться URL префиксы, это позволит в любой момент легко изменить расположение ресурсов с одного сервера на другой:

```php
<?php

$footerCollection = $this->assets->collection('footer');

if ($config->environment === 'development') {
    $footerCollection->setPrefix('/');
} else {
    $footerCollection->setPrefix('http:://cdn.example.com/');
}

$footerCollection->addJs('js/jquery.js');
$footerCollection->addJs('js/bootstrap.min.js');
```

Также, доступен синтаксис цепочки (Method chaining):

```php
<?php

$headerCollection = $assets
    ->collection('header')
    ->setPrefix('http://cdn.example.com/')
    ->setLocal(false)
    ->addJs('js/jquery.js')
    ->addJs('js/bootstrap.min.js');
```

<a name='minification-filtering'></a>

## Minification/Filtering

`Phalcon\Assets` предоставляет встроенную возможность минимизации JavaScript и CSS. Разработчик может создать коллекцию ресурсов, с указаниями для менеджера ресурсов, к каким ресурсам должны быть применены фильтры, а к каким нет. В дополнении к вышесказанному, `Jsmin` [Дугласа Крокфорда (Douglas Crockford)](http://www.crockford.com) входит в состав ядра минимизации JavaScript для увеличения производительности. Для минимизации CSS используется `CSSMin` [Райна Дэйя (Ryan Day)](https://github.com/soldair).

Следующий пример показывает, как минимизировать набор ресурсов:

```php
<?php

$manager

    // Этот JavaScript расположен внизу страницы
    ->collection('jsFooter')

    // Название получаемого файла
    ->setTargetPath('final.js')

    // С таким URI генерируется тэг HTML
    ->setTargetUri('production/final.js')

    // Это удалённый ресурс, не нуждающийся в фильтрации
    ->addJs('code.jquery.com/jquery-1.10.0.min.js', false, false)

    // Это локальные ресурсы, к которым необходимо применить фильтры
    ->addJs('common-functions.js')
    ->addJs('page-functions.js')

    // Объединяем все ресурсы в один файл
    ->join(true)

    // Используем встроенный фильтр Jsmin
    ->addFilter(
        new Phalcon\Assets\Filters\Jsmin()
    )

    // Используем пользовательский фильтр
    ->addFilter(
        new MyApp\Assets\Filters\LicenseStamper()
    );
```

Коллекция может содержать либо JavaScript, либо CSS ресурсы, но не оба типа ресурсов сразу. Некоторые ресурсы могут быть удалёнными, то есть, полученными с помощью HTTP-запроса для дальнейшей фильтрации. Рекомендуется преобразовывать внешние ресурсы в локальные, для устранения накладных расходов на их получение.

Как было замечено выше, метод `addJs()`, использующийся для добавления ресурсов в коллекцию, в качестве второго принимает параметр, указывающий является ли ресурс внешним или нет, а также третий параметр, указывающий, следует ли применять фильтр к ресурсу или оставить как есть:

```php
<?php

// Эти JavaScript ресурсы расположены внизу
$jsFooterCollection = $manager->collection('jsFooter');

// Это удалённый ресурс, не нуждающийся в фильтрации
$jsFooterCollection->addJs('code.jquery.com/jquery-1.10.0.min.js', false, false);

// Это локальные ресурсы, к которым необходимо применить фильтры
$jsFooterCollection->addJs('common-functions.js');
$jsFooterCollection->addJs('page-functions.js');
```

Фильтры регистрируются в коллекции. Допускается регистрировать несколько фильтров. Ресурсы в наборе фильтруются в том же порядке, в каком были зарегистрированы фильтры:

```php
<?php

// Используем встроенный фильтр Jsmin
$jsFooterCollection->addFilter(
    new Phalcon\Assets\Filters\Jsmin()
);

// Используем пользовательский фильтр
$jsFooterCollection->addFilter(
    new MyApp\Assets\Filters\LicenseStamper()
);
```

Обратите внимание, встроенные и пользовательские фильтры могут прозрачно применяться ко всей коллекции ресурсов. Последний шаг, определяет, стоит ли объединять все ресурсы набора в один файл, или использовать каждый по отдельности. Если все ресурсы набора должны объединяться в один файл, вы можете использовать метод `join()`.

Если ресурсы должны быть объединены, то вы должны также определить какой файл будет использоваться для хранения ресурсов и по какому URI он будет доступен. Эти параметры настраиваются при помощи методов `setTargetPath()` и `setTargetUri()`:

```php
<?php

$jsFooterCollection->join(true);

// Название получаемого файла
$jsFooterCollection->setTargetPath('public/production/final.js');

// С таким URI генерируется тэг HTML
$jsFooterCollection->setTargetUri('production/final.js');
```

<a name='builtin-filters'></a>

### Built-In Filters

Phalcon предоставляет два встроенных фильтра минимизации JavaScript и CSS ресурсов. Их реализация на языке Си обеспечивает минимальные накладные расходы для решения подобной задачи:

| Фильтр                             | Description                                                                                                   |
| ---------------------------------- | ------------------------------------------------------------------------------------------------------------- |
| `Phalcon\Assets\Filters\Jsmin`  | Минимизирует JavaScript удаляя не нужны символы, которые игнорируются интерпретатором/компилятором JavaScript |
| `Phalcon\Assets\Filters\Cssmin` | Минимизирует CSS удаляя ненужные символы, которые игнорируются браузерами                                     |

<a name='custom-filters'></a>

### Custom Filters

Кроме использования встроенных фильтров, вы можете создавать свои собственные фильтры. Вы можете воспользоваться существующими более продвинутыми инструментами, такими как [YUI](http://yui.github.io/yuicompressor/), [Sass](http://sass-lang.com/), [Closure](https://developers.google.com/closure/compiler/) и другие:

```php
<?php

use Phalcon\Assets\FilterInterface;

/**
 * Фильтрация CSS содержимого при помощи YUI
 *
 * @param string $contents
 * @return string
 */
class CssYUICompressor implements FilterInterface
{
    protected $options;

    /**
     * Конструктор CssYUICompressor
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * Выполнение фильтрации
     *
     * @param string $contents
     *
     * @return string
     */
    public function filter($contents)
    {
        // Запись содержимого во временный файл
        file_put_contents('temp/my-temp-1.css', $contents);

        system(
            $this->options['java-bin'] .
            ' -jar ' .
            $this->options['yui'] .
            ' --type css ' .
            'temp/my-temp-file-1.css ' .
            $this->options['extra-options'] .
            ' -o temp/my-temp-file-2.css'
        );

        // Возвращаем содержимое файла
        return file_get_contents('temp/my-temp-file-2.css');
    }
}
```

Применение:

```php
<?php

// Получаем некоторую CSS коллекцию
$css = $this->assets->get('head');

// Добавляем (включаем) фильтр YUI-компрессор к коллекции
$css->addFilter(
    new CssYUICompressor(
        [
            'java-bin'      => '/usr/local/bin/java',
            'yui'           => '/some/path/yuicompressor-x.y.z.jar',
            'extra-options' => '--charset utf8',
        ]
    )
);
```

В предыдущем примере мы использовали пользовательский фильтр, который назывался `LicenseStamper`:

```php
<?php

use Phalcon\Assets\FilterInterface;

/**
 * Добавляет лицензионное собщение в начало файла
 *
 * @param string $contents
 *
 * @return string
 */
class LicenseStamper implements FilterInterface
{
    /**
     * Выполнение фильтрации
     *
     * @param string $contents
     * @return string
     */
    public function filter($contents)
    {
        $license = '/* (c) 2015 Ваше имя здесь */';

        return $license . PHP_EOL . PHP_EOL . $contents;
    }
}
```

<a name='custom-output'></a>

## Custom Output

Методы `outputJs()` и `outputCss()` создают необходимые HTML-тэги в соответствии с каждым типом ресурсов. Однако вы можете переопределить эти методы или выводить ресурсы вручную, используя следующий подход:

```php
<?php

use Phalcon\Tag;

$jsCollection = $this->assets->collection('js');

foreach ($jsCollection as $resource) {
    echo Tag::javascriptInclude(
        $resource->getPath()
    );
}
```

<a name='improving-performance'></a>

## Improving performance

Существует множество способов оптимизации работы со статическими ресурсами. Ниже мы опишем простой метод, который позволит отдавать ресурсы непосредственно через веб-сервер, сокращая тем самым время ответа в целом.

Для начала нам понадобится настроить менеджер ресурсов. В этом примере будет использоваться некий базовый контроллер, однако вы можете использовать для этого сервис провайдер или любой другой подход:

```php
<?php

namespace App\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Assets\Filters\Jsmin;

/**
 * App\Controllers\ControllerBase
 *
 * Это базовый контроллер для приложения.
 */
class ControllerBase extends Controller
{
    public function onConstruct()
    {
        $this->assets
            ->useImplicitOutput(false)
            ->collection('global')
            ->addJs('https://code.jquery.com/jquery-3.2.1.js', false, true)
            ->addFilter(new Jsmin());
    }
}
```

Затем, нам понадобится настроит маршрутизацию:

```php
<?php
/*
 * Определяем маршруты.
 * Этот файл будет подключен при определении сервиса router.
 */
$router = new Phalcon\Mvc\Router();

$router->addGet('/assets/(css|js)/([\w.-]+)\.(css|js)', [
    'controller' => 'assets',
    'action'     => 'serve',
    'type'       => 1,
    'collection' => 2,
    'extension'  => 3,
]);

// Другие маршруты...
```

Наконец нам нужно создать контроллер для обработки запросов ресурсов:

```php
<?php

namespace App\Controllers;

use Phalcon\Http\Response;

/**
 * Обработчик запросов ресурсов.
 */
class AssetsController extends ControllerBase
{
    public function serveAction() : Response
    {
        // Создаём экземпляр Response
        $response = new Response();

        // Подготавливаем пути
        $collectionName = $this->dispatcher->getParam('collection');
        $extension      = $this->dispatcher->getParam('extension');
        $type           = $this->dispatcher->getParam('type');
        $targetPath     = "assets/{$type}/{$collectionName}.{$extension}";

        // Настраиваем тип ответа
        $contentType = $type == 'js' ? 'application/javascript' : 'text/css';
        $response->setContentType($contentType, 'UTF-8');

        // Проверяем на коллекцию на существование
        if (!$this->assets->exists($collectionName)) {
            return $response->setStatusCode(404, 'Not Found');
        }

        // Настраиваем коллекцию ресурсов
        $collection = $this->assets
            ->collection($collectionName)
            ->setTargetUri($targetPath)
            ->setTargetPath($targetPath);

        // Сохраняем содержимое на диск и возвращаем полный путь к сохранённому файлу
        $contentPath = $this->assets->output($collection, function (array $parameters) {
            return BASE_PATH . '/public/' . $parameters[0];
        }, $type);

        // Устанавливаем содержимое ответа
        $response->setContent(file_get_contents($contentPath));

        // Возвращаем объект Response
        return $response;
    }
}
```

Если обработанные ресурсы существуют на диске, они должны быть возвращены непосредственно веб-сервером. Таким образом, чтобы получить выгоду от работы со статикой, мы должны обновить конфигурацию веб-сервера. В примере ниже мы будем использовать конфигурацию для Nginx. Настройка других веб-серверов, например Apache, будет немного отличаться:

```nginx
location ~ ^/assets/ {
    expires 1y;
    add_header Cache-Control public;
    add_header ETag "";

    # Если статический ресур существует, обработать его веб-сервером,
    # без запуска PHP-приложения
    try_files $uri $uri/ @phalcon;
}

location / {
    try_files $uri $uri/ @phalcon;
}

location @phalcon {
    rewrite ^(.*)$ /index.php?_url=$1;
}
```

Нам понадобится создать директории `assets/js` и `assets/css` в корне приложения (например в `public`).

Каждый раз, когда пользователь запрашивает статический ресурс вида `/assets/js/global.js`, запрос будет послан на обработку контроллером `AssetsController`, если файла ещё нет в файловой системе. В противном случае, ресурс будет возвращён веб-сервером.

Мы рассмотрели не самый лучший пример. Однако, он отражает суть: грамотная конфигурация веб-сервера и приложения может повысить производительность вашего приложения многократно.

Узнать больше о конфигурировании веб-сервера и маршрутизации можно в соответствующих статьях [Настройка веб-сервера](/[[language]]/[[version]]/webserver-setup) и [Маршрутизация](/[[language]]/[[version]]/routing).