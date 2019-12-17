---
layout: default
language: 'it-it'
version: '4.0'
upgrade: '#assets'
title: 'Assets'
keywords: 'assets, js, css'
---

# Assets Management

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview

`Phalcon\Assets` is a component that allows you to manage static assets such as CSS stylesheets or JavaScript libraries in a web application.

[Phalcon\Assets\Manager](api/phalcon_assets#assets-manager) is the component you can use to register your assets and use them throughout your application. If you are using the [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) container, the Assets Manager is already registered for you. You can access it using the `assets` key from your Di container.

```php
<?php

use Phalcon\Di\FactoryDefault();

$container = new FactoryDefault();
$manager   = $container->get('assets')
```

## Assets

Assets can be added to the manager or a collection using the Asset related classes. The [Phalcon\Assets\Asset](api/phalcon_assets#assets-asset) class. The object accepts the necessary data to create the asset. * `type`: can be `css`, `js` or something else, depending on whether you want to extend the functionality of the component. * `path` : the path of the asset * `local`: whether this is a local asset or not * `filter`: any filter attached to this asset * `attributes`: attributes relative to the asset * `version`: version of the asset * `autoVersion`: let the component auto version this asset or not

```php
<?php

use Phalcon\Assets\Asset;

$asset = new Asset(
    'css',
    'css/bootstrap.css',
    true,
    null,
    [],
    '1.0',
    true
);
```

#### CSS

You can also use the [Phalcon\Assets\Asset\Css](api/phalcon_assets#assets-asset-css) class to create a CSS asset. This class is a helper class that extends the [Phalcon\Assets\Asset](api/phalcon_assets#assets-asset) class and internally sets the first parameter to `css`.

```php
<?php

use Phalcon\Assets\Asset\Css;

$asset = new Css(
    'css/bootstrap.css',
    true,
    null,
    [],
    '1.0',
    true
);
```

#### JS

You can also use the [Phalcon\Assets\Asset\Js](api/phalcon_assets#assets-asset-js) class to create a JS asset. This class is a helper class that extends the [Phalcon\Assets\Asset](api/phalcon_assets#assets-asset) class and internally sets the first parameter to `js`.

```php
<?php

use Phalcon\Assets\Asset\Js;

$asset = new Js(
    'js/bootstrap.js',
    true,
    null,
    [],
    '1.0',
    true
);
```

### Inline

There are times that the application needs generated CSS or JS to be injected into the view. You can use the [Phalcon\Assets\Inline](api/phalcon_assets#assets-inline) class to generate this content. The object can be created with the following parameters: * `type`: can be `css`, `js` or something else, depending on whether you want to extend the functionality of the component. * `content`: the content to be injected * `filter`: any filter attached to this asset * `attributes`: attributes relative to the asset

```php
<?php

use Phalcon\Assets\Inline;

$asset = new Inline(
    'css',
    '.spinner {color: blue; }'
);
```

#### CSS

You can also use the [Phalcon\Assets\Inline\Css](api/phalcon_assets#assets-inline-css) class to create an inline CSS asset. This class is a helper class that extends the [Phalcon\Assets\Inline](api/phalcon_assets#assets-inline) class and internally sets the first parameter to `css`.

```php
<?php

use Phalcon\Assets\Inline\Css;

$asset = new Css(
    '.spinner {color: blue; }'
);
```

#### JS

You can also use the [Phalcon\Assets\Inline\Js](api/phalcon_assets#assets-inline-js) class to create an inline JS asset. This class is a helper class that extends the [Phalcon\Assets\Inline](api/phalcon_assets#assets-inline) class and internally sets the first parameter to `js`.

```php
<?php

use Phalcon\Assets\Asset\Js;

$asset = new Js(
    'alert("hello");'
);
```

### Custom

Implementing the [Phalcon\Assets\AssetInterface](api/phalcon_assets#assets-assetinterface) enables you to create different asset classes that can be handled by the Asset Manager.

## Exception

Any exceptions thrown in the Assets Manager component will be of type [Phalcon\Assets\Exception](api/phalcon_assets#assets-exception). You can use this exception to selectively catch exceptions thrown only from this component.

```php
<?php

use Phalcon\Assets\Exception;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function index()
    {
        try {
            // Add some local CSS assets
            $this->assets->addCss('css/style.css');
            $this->assets->addCss('css/index.css');
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}

```

## Adding Assets

### Files

Assets supports two built-in assets: CSS and JavaScript assets. You can also create other asset types if you need. The assets manager internally stores two default collections of assets - one for JavaScript and another for CSS.

You can easily add assets to these collections:

```php
<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function index()
    {
        // Add some local CSS assets
        $this->assets->addCss('css/style.css');
        $this->assets->addCss('css/index.css');

        // And some local JavaScript assets
        $this->assets->addJs('js/jquery.js');
        $this->assets->addJs('js/bootstrap.min.js');
    }
}
```

For better page load performance, it is recommended to place JavaScript links at the end of the HTML instead of in the `<head>` element. However this might not be always feasible based on the Javascript files you need to load and their dependencies.

You can also add assets to the manager by using Asset objects:

```php
<?php

use Phalcon\Assets\Asset\Css;
use Phalcon\Assets\Asset\Js;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $css1 = new Css('css/style.css');
        $css2 = new Css('css/index.css');

        $this->assets->addAsset($css1);
        $this->assets->addAssetByType('css', $css2);

        $js1 = new Js('js/jquery.js');
        $js2 = new Js('js/bootstrap.min.js');
        $this->assets->addAsset($css1);

        $this->assets->addAssetByType('css', $css2);
    }
}
```

### Inline

You can also add inline assets to the manager. Inline assets represent strings of CSS or JS that need to be injected in your views dynamically (not from an asset file). `addInlineCode()`, `addInlineCodeByType()`, `addInlineCss()` and `addInlineJs()` are available for your use.

```php
<?php

use Phalcon\Assets\Manager;
use Phalcon\Assets\Inline;

$css      = '.spinner {color: blue; }';
$js       = 'alert("hello")';
$manager  = new Manager();
$assetCss = new Inline('css', $css};
$assetJs  = new Inline('js', $js};

$manager
    ->addInlineCode($assetCss)
    ->addInlineCode($assetJs)
;

$manager
    ->addInlineByType('css', $assetCss)
    ->addInlineByType('js', $assetJs)
;

$manager
    ->addInlineCss($css)
    ->addInlineJs($js)
;
```

## Local/Remote Assets

Local assets are those who are provided by the same application and they are located in a public location (usually `public`). The URLs for local assets are generated using the <url> service.

Remote assets are those such as common libraries like [jQuery](https://jquery.com), [Bootstrap](https://getbootstrap.com), etc. that are provided by a [CDN](https://en.wikipedia.org/wiki/Content_delivery_network).

The second parameter of `addCss()` and `addJs()` signifies whether asset is local or not (`true` is local, `false` is remote). By default, the assets manager will assume the asset is local:

```php
<?php

public function indexAction()
{
    $this->assets->addCss(
        '//cdn.assets.com/bootstrap/4/css/library.min.css', 
        false
    );

    $this->assets->addCss('css/style.css', true);
    $this->assets->addCss('css/extra.css');
}
```

## Collections

[Phalcon\Assets\Collections](api/phalcon_assets#assets-collection) are objects that group assets of the same type. The assets manager implicitly creates two collections: `css` and `js`. You can create additional collections to group specific assets to make it easier to place those assets in the views:

```php
<?php

// Javascript - header
$headerCollection = $this->assets->collection('headerJs');

$headerCollection->addJs('js/jquery.js');
$headerCollection->addJs('js/bootstrap.min.js');

// Javascript - footer
$footerCollection = $this->assets->collection('footerJs');

$footerCollection->addJs('js/jquery.js');
$footerCollection->addJs('js/bootstrap.min.js');
```

### Get

The *getter* methods exposed by the component, allow you to get the collection from anywhere in your code and manipulate it according to your needs. The manager offers `get()`, `getCollection()`, `getCss()` and `getJs()`. These methods will return back the collection that the manager stores. The `getCss()` and `getJs()` will return the built-in - pre registered - collections.

The `collection()` method acts as a *creator* and *getter* at the same time. It allows you to create a collection and get it back so that you can then add assets to it. The `getCss()` and `getJs()` perform the same function i.e. create the collection if it does not exist and return it. Those two collections set the predefined `css` and `js` collections in the manager.

```php
<?php

$headerCollection = $this->assets->collection('headerJs');

$headerCollection = $this->assets->get('headerJs');
```

### Exists

The `exists` method allows you to check if a particular collection exists in the manager;

```php
<?php

$headerCollection = $this->assets->collection('headerJs');

echo $this->assets->has('headerJs'); // true
```

### Set

If the built-in `css` and `js` collections are not sufficient for your needs, you can attach a new collection to the manager by using `se()`.

```php
<?php

use Phalcon\Assets\Collection;

$collection = new Collection();

$this->assets->set('outputJs', $collection);
```

## URL Prefixes

Collections can be URL-prefixed, allowing you to change the prefix easily based on the needs of your application. An example of this can be changing from local to production environments and using a different [CDN](https://en.wikipedia.org/wiki/Content_delivery_network) URL for your assets:

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

You can also chain the method calls if that syntax is more preferable:

```php
<?php

$headerCollection = $this
    ->assets
    ->collection('header')
    ->setPrefix('https://cdn.example.com/')
    ->setLocal(false)
    ->addJs('js/jquery.js')
    ->addJs('js/bootstrap.min.js');
```

### Built-In Filters

Assets can be filtered i.e. manipulated before their output to the view. Although Phalcon v3 offered minifiers for JavaScript and CSS, license limitations do not allow us to continue using those libraries. For v4 we are offering only the [Phalcon\Assets\Filters\None](api/phalcon_assets#assets-filters-none) filter (which does not change the asset contents) and the [Phalcon\Assets\FilterInterface](api/phalcon_assets#assets-filterinterface) interface, offering the ability to create custom filters.

### Custom Filters

Creating custom filters is very easy. You can use this extensibility to take advantage of existing and more advanced filtering/minification tools like [YUI](https://yui.github.io/yuicompressor), [Sass](https://sass-lang.com), [Closure](https://developers.google.com/closure/compiler), etc.:

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

In a previous example, we used a custom filter called `LicenseStamper`, which adds the license message at the top of the file:

```php
<?php

use Phalcon\Assets\FilterInterface;

/**
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
        $license = '/* (c) 2019 Your Name Here */';

        return $license . PHP_EOL . PHP_EOL . $contents;
    }
}
```

## Output

After all the assets have been added to their relevant collections you can use the output methods to *print* HTML in your views. These methods are `output()`, `outputCss()`, `outputJs()`, `outputInline()`, `outputInlineCss()` and `outputInlineJs()`.

To output files:

```php
<?php

// Javascript - header
$headerCollection = $this->assets->collection('headerJs');

$headerCollection->addJs('js/jquery.js');
$headerCollection->addJs('js/bootstrap.min.js');

// Javascript - footer
$footerCollection = $this->assets->collection('footerJs');

$footerCollection->addJs('js/jquery.js');
$footerCollection->addJs('js/bootstrap.min.js');
```

Then in the views:

```php
<html>
    <head>
        <title>Some amazing website</title>

        <?php $this->assets->outputJs('headerJs'); ?>
    </head>

    <body>
        <!-- ... -->

        <?php $this->assets->outputJs('footerJs'); ?>
    </body>
<html>
```

Volt syntax:

```twig
<html>
    <head>
        <title>Some amazing website</title>

        {% raw %}{{ assets.outputCss('header') }}{% endraw %}
    </head>

    <body>
        <!-- ... -->

        {% raw %}{{ assets.outputJs('footer') }}{% endraw %}
    </body>
<html>
```

To output inline:

```php
<?php

$css      = '.spinner {color: blue; }';
$js       = 'alert("hello")';
$assetCss = new Inline('css', $css};
$assetJs  = new Inline('js', $js};

$this
    ->assets
    ->addInlineCss($css)
    ->addInlineJs($js)
;
```

Then in the views:

```php
<html>
    <head>
        <title>Some amazing website</title>
    </head>
    <?php $this->assets->outputInlineCss(); ?>
    <body>

        <!-- ... -->

        <?php $this->assets->outputInlineJs(); ?>
    </body>
<html>
```

Volt syntax:

```twig
<html>
    <head>
        <title>Some amazing website</title>

        {% raw %}{{ assets.outputInlineCss() }}{% endraw %}
    </head>

    <body>
        <!-- ... -->

        {% raw %}{{ assets.outputInlineJs() }}{% endraw %}
    </body>
<html>
```

The lines above will be translated to:

```html
<html>
    <head>
        <title>Some amazing website</title>

        <style>.spinner {color: blue; }</style>
    </head>

    <body>
        <!-- ... -->

        <script type="application/javascript">alert("hello")</script>
    </body>
<html>
```

## Custom Output

The `outputJs()` and `outputCss()` methods are available to generate the necessary HTML code according to each type of assets. You can override this method or print the assets manually in the following way:

```php
<?php

use Phalcon\Tag;

$jsCollection = $this->assets->collection('js');

foreach ($jsCollection as $asset) {
    echo Tag::javascriptInclude(
        $asset->getPath()
    );
}
```

## Implicit Vs Explicit Output

There are times that you might need to implicitly output the output of the manager. To do this, you can use the `useImplicitOutput()` method. Calling `output()` after that will *echo* the HTML on the screen.

```php
<?php

$this
    ->assets
    ->useImplicitOutput(true)
    ->addCss('css/style.css')
    ->output()
;
```

## Versioning

The `Assets` components also support versioning (automatic or manual). Versioning of assets is also known as [cache busting](https://www.keycdn.com/support/what-is-cache-busting). In short, CSS and JS files can easily be cached at the browser level. As such any updates that are pushed to the production system with a release, could include updated CSS and JS files. Since browsers cache those assets, the updated content will not be delivered to the user's browser immediately, resulting in potential loss of functionality. By versioning assets, we ensure that the browsers are instructed to download the asset files again and thus receive the latest CSS and JS code from the server.

To add a version number to your assets, you need to add the version string while creating the asset object:

```php
<?php

use Phalcon\Assets\Asset\Css;

$asset = new Css(
    'css/bootstrap.css',
    true,
    null,
    [],
    '1.0'
);
```

The above will result in the following script as the output:

```html
<link rel="stylesheet" href="css/bootstrap.css?ver=1.0"
```

You can then store the version in your configuration file or any other storage and update it when a new release is pushed to production.

### Auto Versioning

You can also use the file time of the asset file to control the versioning of your assets.

```php
<?php

use Phalcon\Assets\Asset\Css;

$asset = new Css(
    'css/bootstrap.css',
    true,
    null,
    [],
    null,
    true
);
```

The above will result in the following script as the output (assuming that your file was modified in May 20th 2019): Assuming that your file was last modified in May 20, the version

```html
<link rel="stylesheet" href="css/bootstrap.css?ver=1558392141">
```

> **NOTE** Using the auto version feature is not recommended for production environments, since Phalcon will need to read the modification time of the asset file for every request. This will result to unnecessary read operations on the file system. 
{: .alert .alert-warning }

## Improving Performance

There are many ways to optimize processing assets. One method is to allow your web server to handle the assets, thus improving response time. First we need to set up the Assets Manager. We will use a base controller, but you can use the manager anywhere you need to, accessing it from the Di container:

```php
<?php

namespace App\Controllers;

use Phalcon\Mvc\Controller;

/**
 * App\Controllers\ControllerBase
 *
 * This is the base controller for all controllers in the application.
 */
class ControllerBase extends Controller
{
    public function onConstruct()
    {
        $this
            ->assets
            ->useImplicitOutput(false)
            ->collection('global')
            ->addJs('https://code.jquery.com/jquery-4.0.1.js', false, true)
        ;
    }
}
```

Then we need to configure the routing:

```php
<?php

/**
 * Define custom routes.
 * This file gets included in the router service definition.
 */
$router = new Phalcon\Mvc\Router();

$router->addGet(
    '/assets/(css|js)/([\w.-]+)\.(css|js)',
    [
        'controller' => 'assets',
        'action'     => 'serve',
        'type'       => 1,
        'collection' => 2,
        'extension'  => 3,
    ]
);

// Other routes...
```

Finally, we need to create a controller to handle asset requests:

```php
<?php

namespace App\Controllers;

use Phalcon\Http\Response;

/**
 * Serve site assets.
 */
class AssetsController extends ControllerBase
{
    public function serveAction(): Response
    {
        // Getting a response instance
        $response = new Response();

        // Prepare output path
        $collectionName = $this->dispatcher->getParam('collection');
        $extension      = $this->dispatcher->getParam('extension');
        $type           = $this->dispatcher->getParam('type');
        $targetPath     = "assets/{$type}/{$collectionName}.{$extension}";

        // Setting up the content type
        $contentType = $type == 'js' ? 'application/javascript' : 'text/css';
        $response->setContentType($contentType, 'UTF-8');

        // Check collection existence
        if (!$this->assets->exists($collectionName)) {
            return $response->setStatusCode(404, 'Not Found');
        }

        // Setting up the Assets Collection
        $collection = $this->assets
            ->collection($collectionName)
            ->setTargetUri($targetPath)
            ->setTargetPath($targetPath);

        // Store content to the disk and return fully qualified file path
        $contentPath = $this->assets->output(
            $collection,
            function (array $parameters) {
                return BASE_PATH . '/public/' . $parameters[0];
            },
            $type
        );

        // Set the content of the response
        $response->setContent(
            file_get_contents($contentPath)
        );

        // Return the response
        return $response;
    }
}
```

If precompiled assets exist in the file system they must be served directly by web server. So to get the benefit of static assets we have to update our server configuration. We will use an example configuration for Nginx. For Apache it will be a little different:

```nginx
location ~ ^/assets/ {
    expires 1y;
    add_header Cache-Control public;
    add_header ETag "";

    # If the file exists as a static file serve it directly without
    # running all the other rewrite tests on it
    try_files $uri $uri/ @phalcon;
}

location / {
    try_files $uri $uri/ @phalcon;
}

location @phalcon {
    rewrite ^(.*)$ /index.php?_url=$1;
}

```

# Other Configuration Directives

We need to create `assets/js` and `assets/css` directories in the document root of the application (eg. `public`).

Every time the application requests assets such as `/assets/js/global.js` the application will check whether the asset exists. If yes, it will be handled by the web server. Alternatively it will be redirected to the `AssetsController` for handling from the application.

We do not recommend to use the above example in production environments and for high load applications. However, the example does show what is possible using this component. The implementation you choose depends on the needs of your application.

In most cases, your web server, [CDN](https://en.wikipedia.org/wiki/Content_delivery_network) or services such as [Varnish HTTP Cache](https://varnish-cache.org/) would be more preferable.