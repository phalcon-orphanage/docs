<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Управление ресурсами</a> <ul>
        <li>
          <a href="#add">Добавление ресурсов</a>
        </li>
        <li>
          <a href="#resources-local-remote">Локальные/удалённые ресурсы</a>
        </li>
        <li>
          <a href="#collections">Коллекции</a>
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
      </ul>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Управление ресурсами

`Phalcon\Assets` — это компонент позволяющий разработчику управлять статичными ресурсами в веб-приложении, такими как каскадные таблицы стилей или скрипты.

`Phalcon\Assets\Manager` доступен в контейнере сервисов и вы можете добавлять ресурсы из любой части приложения, где контейнер доступен.

<a name='add'></a>

## Добавление ресурсов

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

## Локальные/удалённые ресурсы

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

## Коллекции

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

С использованием синтаксиса Volt:

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

## Префиксы

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

## Минификация/Фильтрация

`Phalcon\Assets` provides built-in minification of JavaScript and CSS resources. You can create a collection of resources instructing the Assets Manager which ones must be filtered and which ones must be left as they are. In addition to the above, Jsmin by [Douglas Crockford](http://www.crockford.com) is part of the core extension offering minification of JavaScript files for maximum performance. In the CSS land, CSSMin by [Ryan Day](https://github.com/soldair) is also available to minify CSS files:

The following example shows how to minify a collection of resources:

```php
<?php

$manager

    // These JavaScripts are located in the page's bottom
    ->collection('jsFooter')

    // The name of the final output
    ->setTargetPath('final.js')

    // The script tag is generated with this URI
    ->setTargetUri('production/final.js')

    // This is a remote resource that does not need filtering
    ->addJs('code.jquery.com/jquery-1.10.0.min.js', false, false)

    // These are local resources that must be filtered
    ->addJs('common-functions.js')
    ->addJs('page-functions.js')

    // Join all the resources in a single file
    ->join(true)

    // Use the built-in Jsmin filter
    ->addFilter(
        new Phalcon\Assets\Filters\Jsmin()
    )

    // Use a custom filter
    ->addFilter(
        new MyApp\Assets\Filters\LicenseStamper()
    );
```

A collection can contain JavaScript or CSS resources but not both. Some resources may be remote, that is, they're obtained by HTTP from a remote source for further filtering. It is recommended to convert the external resources to local for better performance.

As seen above, the `addJs()` method is used to add resources to the collection, the second parameter indicates whether the resource is external or not and the third parameter indicates whether the resource should be filtered or left as is:

```php
<?php

// These Javascripts are located in the page's bottom
$jsFooterCollection = $manager->collection('jsFooter');

// This a remote resource that does not need filtering
$jsFooterCollection->addJs('code.jquery.com/jquery-1.10.0.min.js', false, false);

// These are local resources that must be filtered
$jsFooterCollection->addJs('common-functions.js');
$jsFooterCollection->addJs('page-functions.js');
```

Filters are registered in the collection, multiple filters are allowed, content in resources are filtered in the same order as filters were registered:

```php
<?php

// Use the built-in Jsmin filter
$jsFooterCollection->addFilter(
    new Phalcon\Assets\Filters\Jsmin()
);

// Use a custom filter
$jsFooterCollection->addFilter(
    new MyApp\Assets\Filters\LicenseStamper()
);
```

Note that both built-in and custom filters can be transparently applied to collections. The last step is to decide if all the resources in the collection must be joined into a single file or serve each of them individually. To tell the collection that all resources must be joined you can use the `join()` method.

If resources are going to be joined, we need also to define which file will be used to store the resources and which URI will be used to show it. These settings are set up with `setTargetPath()` and `setTargetUri()`:

```php
<?php

$jsFooterCollection->join(true);

// The name of the final file path
$jsFooterCollection->setTargetPath('public/production/final.js');

// The script HTML tag is generated with this URI
$jsFooterCollection->setTargetUri('production/final.js');
```

<a name='builtin-filters'></a>

### Встроенные фильтры

Phalcon provides 2 built-in filters to minify both JavaScript and CSS, their C-backend provide the minimum overhead to perform this task:

| Filter                             | Description                                                                                                  |
| ---------------------------------- | ------------------------------------------------------------------------------------------------------------ |
| `Phalcon\Assets\Filters\Jsmin`  | Minifies JavaScript by removing unnecessary characters that are ignored by Javascript interpreters/compilers |
| `Phalcon\Assets\Filters\Cssmin` | Minifies CSS by removing unnecessary characters that are already ignored by browsers                         |

<a name='custom-filters'></a>

### Пользовательские фильтры

In addition to the built-in filters, you can create your own filters. These can take advantage of existing and more advanced tools like [YUI](http://yui.github.io/yuicompressor/), [Sass](http://sass-lang.com/), [Closure](https://developers.google.com/closure/compiler/), etc.:

```php
<?php

use Phalcon\Assets\FilterInterface;

/**
 * Filters CSS content using YUI
 *
 * @param string $contents
 * @return string
 */
class CssYUICompressor implements FilterInterface
{
    protected $options;

    /**
     * CssYUICompressor constructor
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * Do the filtering
     *
     * @param string $contents
     *
     * @return string
     */
    public function filter($contents)
    {
        // Write the string contents into a temporal file
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

        // Return the contents of file
        return file_get_contents('temp/my-temp-file-2.css');
    }
}
```

Usage:

```php
<?php

// Get some CSS collection
$css = $this->assets->get('head');

// Add/Enable the YUI compressor filter in the collection
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

In a previous example, we used a custom filter called `LicenseStamper`:

```php
<?php

use Phalcon\Assets\FilterInterface;

/**
 * Adds a license message to the top of the file
 *
 * @param string $contents
 *
 * @return string
 */
class LicenseStamper implements FilterInterface
{
    /**
     * Do the filtering
     *
     * @param string $contents
     * @return string
     */
    public function filter($contents)
    {
        $license = '/* (c) 2015 Your Name Here */';

        return $license . PHP_EOL . PHP_EOL . $contents;
    }
}
```

<a name='custom-output'></a>

## Пользовательский вывод

The `outputJs()` and `outputCss()` methods are available to generate the necessary HTML code according to each type of resources. You can override this method or print the resources manually in the following way:

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