---
layout: default
language: 'ja-jp'
upgrade: '#url'
version: '4.0'
title: 'URL'
keywords: 'url, url handling, url generation, static url, dynamic url'
---

# Url Component

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview

[Phalcon\Url](api/phalcon_url#url) is the component responsible of generate URLs in a Phalcon application. It can also be used to construct URLs based on routes.

```php
<?php

use Phalcon\Url;

$url = new Url();

$url->setBaseUri("/portal/");
echo $url->get("invoices/edit/1"); // /portal/invoices/edit/1 

echo $url->get(
    [
        "for"   => "invoices-edit", // route name
        "title" => "Edit Invoice",  // title
        "id"    => 1,               // route parameter
    ]                             
);
```

## Generation

The [Phalcon\Url](api/phalcon_url#url) component can generate URLs that are static as well as dynamic ones. Dynamic URLs can be generated also based on parameters or routes of your application, as defined using the \[Router\]\[routing\] component.

## Static URLs

Static URLs are the ones that refer to static resources. Those can be images, CSS/JS assets, videos etc. The [Phalcon\Url](api/phalcon_url#url) component offers an easy way to generate those URLs.

```php
<?php

use Phalcon\Url;

$url = new Url();

echo $url->getStatic("img/logo.png");
```

Along with `getStatic()`, the component also offers the getter `getStaticBaseUri()` and setter `setStaticBaseUri()` methods, which allow you to set a prefix for all of your static URLs. This functionality can be especially helpful when you need to set up a CDN or a different location on where your assets are stored.

```php
<?php

use Phalcon\Url;

$url = new Url();

$this->setStaticBaseUri('https://assets.phalcon.io/');

echo $url->getStaticBaseUri(); // https://assets.phalcon.io/
```

and when in need to use a CDN for your production environment:

```php
<?php

use Phalcon\Url;

$url = new Url();

if ($environment === 'production') {
    $this->setStaticBaseUri('https://assets.phalcon.io/');
}

echo $url->getStatic('img/logo.png'); // https://assets.phalcon.io/img/logo.png
```

The above code will prefix all the static assets with `https://assets.phalcon.io`, ensuring that assets in your production environment use the CDN URL, while local development loads them directly from your machine.

> **NOTE**: The trailing slash in the `setStaticBaseUrl()` parameter is optional. If it is not specified, it will automatically be appended to the passed parameter
{: .alert .alert-info }

Finally, depending on the routes you have specified, you can retrieve a static resource which is defined in a named route by passing an array to `getStatic()` and using `for` keyword as a key and the name of the route as a value.

```php
<?php

use Phalcon\Url;

$url = new Url();

echo $url->getStatic(
    [
        'for' => 'logo-cdn',
    ]
);
```

## Dynamic URLs

Dynamic URLs are URLs that are generated dynamically i.e. based on the routes or URLs of your application. The [Phalcon\Url](api/phalcon_url#url) component offers an easy way to generate those URLs.

Depending of which directory of your document root your application is installed, it may have a base URI or not. For example, if your document root is `/var/www/htdocs` and your application is installed in `/var/www/htdocs/app` then your baseUri will be `/app/`. If you are using a VirtualHost or your application is installed on the document root, then your base URI is `/`.

If you are unsure and want to find out what your base URI is, you can execute the following code in your application's folder:

```php
<?php

use Phalcon\Url;

$url = new Url();

echo $url->getBaseUri();
```

By default, Phalcon will try to detect your base URI. It is recommended that you specify the base URI yourself,m because it increases performance slightly.

```php
<?php

use Phalcon\Url;

$url = new Url();

echo $url->get("/portal/invoices/edit/1");
```

Along with `get()`, the component also offers the getter `getBaseUri()` and setter `setBaseUri()` methods, which allow you to set a prefix for all of your URLs. This functionality can be especially helpful when you need to set up a `prefix` for your URLs i.e. if you are working with modules that have a specific prefix for all routes.

```php
<?php

use Phalcon\Url;

$url = new Url();

$this->setBaseUri('/portal/');

echo $url->getBaseUri(); // /portal/

echo $url->get('invoices/edit/1'); // /portal/invoices/edit/1
```

The above code will prefix all the URLs with `/portal/`, allowing you to *group* URLs easier. For instance if you have the `InvoicesController` and you want the URLs to be prefixed with `/portal/`, you can use `setBaseUri()` in the `initialize()` method:

```php
<?php

use Phalcon\Url;
use Phalcon\Mvc\Controller

/**
 * @property Url $url
 */
class InvoicesController extends Controller
{
    public function initialize()
    {
        $this->url->setBaseUri('/portal/');
    }
}
```

And now we can generate any URL using `get()` in subsequent actions, that will be prefixed with `/portal/`

> **NOTE**: The trailing slash in the `setBaseUrl()` parameter is optional. If it is not specified, it will automatically be appended to the passed parameter
{: .alert .alert-info }


### Routing

If you are using the [Router](routing) with its default behavior, your application is able to match routes based on the following pattern:

> /:controller/:action/:params
{: .alert .alert-info }


Therefore, it is easy to create routes that satisfy that pattern (or any other pattern defined in the router) passing a string to the method `get()`:

```php
<?php echo $url->get('products/save'); ?>
```

Note that is not necessary to prepend the base URI. If you have named routes you can easily define it dynamically. For instance for the following route:

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router();

$router
    ->add(
        '/portal/invoices/edit/{id}',
        [
            'module'     => 'portal',
            'controller' => 'invoices',
            'action'     => 'edit',
        ]
    )
    ->setName('invoices-edit');
```

You can now generate a URL which is defined in the `invoice-edit` named route, by passing an array to `get()` and using `for` keyword as a key and the name of the route as a value.

```php
<?php

use Phalcon\Url;

$url = new Url();

echo $url->get(
    [
        'for' => 'invoices-edit',
        'id'  => 1,
    ]
);
```

The above will produce `/portal/invoices/edit/1`.

### mod_rewrite

Developers that are utilizing `mod_rewrite` in their Apache installations, [Phalcon\Url](api/phalcon_url#url) offers the necessary functionality to replace `mod_rewrite`. This is especially useful if the target system does not have the module installed or you cannot install it yourself.

The following example shows you how to replace `mod_rewrite` with [Phalcon\Url](api/phalcon_url#url):

```php
<?php

use Phalcon\Url;

$url = new Url();

$url->setBaseUri('/app/public/index.php?_url=/'); // $_GET['_url']

echo $url->get('products/save'); // /app/public/index.php?_url=/portal/invoices/save
```

You can also use `$_SERVER['REQUEST_URI']`. This requires a bit more work, since we need to utilize the [Router](routing) component to populate the `$_SERVER['REQUEST_URI']`. Our routes setup needs to change to:

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router();

// ... Define routes

$uri = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI']);

$router->handle($uri);
```

and now the application can process the URI as expected:

```php
<?php

use Phalcon\Url;

$url = new Url();

$url->setBaseUri('/app/public/index.php'); // $_SERVER['REQUEST_URI']

echo $url->get('products/save'); // /app/public/index.php/portal/invoices/save
```

> **NOTE**: If you can, avoid replacing `mod_rewrite` with the code above. Having the necessary route matching mechanism handled by the web server is much faster than handling things in your own application.
{: .alert .alert-info }

### View/Volt

The function `url` is available in volt to generate URLs using this component:

```twig
{% raw %}
<a href='{{ url('invoices/edit/1') }}'>Edit</a>
{% endraw %}
```

Generate static routes:

```twig
{% raw %}
<link rel='stylesheet' href='{{ static_url('css/style.css') }}' type='text/css' />
{% endraw %}
```

## Path

Although a `path` is not really a URL, the [Phalcon\Url](api/phalcon_url#url) offers methods that allow you to create paths for your application, the same way as URLs.

```php
<?php

use Phalcon\Url;

$url = new Url();

echo $url->path("/data/app/storage/");
```

Along with `path()`, the component also offers the getter `getBasePath()` and setter `setBasePath()` methods, which allow you to set a prefix for all of your paths.

```php
<?php

use Phalcon\Url;

$url = new Url();

$this->setBasePath('/data/app/');

echo $url->getBasePath(); // /data/app/

echo $url->path('storage/config.php'); // /data/app/storage/config.php
```

The above code will prefix all the paths with `/data/app/`.

> **NOTE**: The trailing slash in the `setBasePath()` parameter is optional. If it is not specified, it will automatically be appended to the passed parameter
{: .alert .alert-info }

## Exceptions

Any exceptions thrown in the [Phalcon\Url](api/phalcon_url#url) component will be of type [Phalcon\Url\Exception](api/phalcon_url#url-exception). You can use this exception to selectively catch exceptions thrown only from this component.

```php
<?php

use Phalcon\Url\Exception;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function index()
    {
        try {
            // Get some configuration values
            $this->url->get('/portal/invoices/list');
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
```

## Custom

The \[Phalcon\UrlInterface\]\[url-interface\] is available if you wish to implement your own `Url` component. Implementing this interface will ensure that your custom component will work with the Phalcon.

## 依存性の注入

If you use the [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) container, the [Phalcon\Url](api/phalcon_url#url) is already registered for you. However you might want to override the default registration in order to set your own `setBaseUri()`. Alternatively if you are not using the [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) and instead are using the [Phalcon\Di](di) the registration is the same. By doing so, you will be able to access your configuration object from controllers, models, views and any component that implements `Injectable`.

An example of the registration of the service as well as accessing it is below:

```php
<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Url;

// Create a container
$container = new FactoryDefault();

$container->set(
    'url',
    function () {
        $url = new Url();

        $url->setBaseUri('/portal/');

        return $url;
    },
    true
);
```

The component is now available in your controllers using the `url` key

```php
<?php

use Phalcon\Mvc\Controller;
use Phalcon\Url;

/**
 * @property Url $url
 */
class MyController extends Controller
{
    private function getUrl(): string
    {
        return $this->url->get('/portal/invoices/link');
    }
}
```

Also in your views (Volt syntax) the `url` helper method offers the same functionality:

```twig
{% raw %}{{ url('/portal/invoices/link') }}{% endraw %}
```

You can of course access the object the same way as any registered service in the Di container:

```twig
{% raw %}{{ url.get('/portal/invoices/link') }}{% endraw %}
```