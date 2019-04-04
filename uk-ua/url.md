---
layout: default
language: 'uk-ua'
version: '4.0'
---
# Url Component

* * *

## Generating URLs and Paths

[Phalcon\Url](api/Phalcon_Url) is the component responsible of generate URLs in a Phalcon application. It's capable of produce independent URLs based on routes.

## Setting a base URI

Depending of which directory of your document root your application is installed, it may have a base URI or not.

For example, if your document root is `/var/www/htdocs` and your application is installed in `/var/www/htdocs/invo` then your baseUri will be `/invo/`. If you are using a VirtualHost or your application is installed on the document root, then your baseUri is `/`. Execute the following code to know the base URI detected by Phalcon:

```php
<?php

use Phalcon\Url;

$url = new Url();

echo $url->getBaseUri();
```

By default, Phalcon automatically may detect your baseUri, but if you want to increase the performance of your application is recommended setting up it manually:

```php
<?php

use Phalcon\Url;

$url = new Url();

// Setting a relative base URI
$url->setBaseUri('/invo/');

// Setting a full domain as base URI
$url->setBaseUri('//my.domain.com/');

// Setting a full domain as base URI
$url->setBaseUri('https://my.domain.com/my-app/');
```

Usually, this component must be registered in the Dependency Injector container, so you can set up it there:

```php
<?php

use Phalcon\Url;

$di->set(
    'url',
    function () {
        $url = new Url();

        $url->setBaseUri('/invo/');

        return $url;
    }
);
```

## Generating URIs

If you are using the [Router](routing) with its default behavior, your application is able to match routes based on the following pattern:

> /:controller/:action/:params
{: .alert .alert-info }

Accordingly it is easy to create routes that satisfy that pattern (or any other pattern defined in the router) passing a string to the method `get`:

```php
<?php echo $url->get('products/save'); ?>
```

Note that isn't necessary to prepend the base URI. If you have named routes you can easily change it creating it dynamically. For Example if you have the following route:

```php
<?php

$router
    ->add(
        '/blog/{year}/{month}/{title}',
        [
            'controller' => 'posts',
            'action'     => 'show',
        ]
    )
    ->setName('show-post');
```

A URL can be generated in the following way:

```php
<?php

// This produces: /blog/2015/01/some-blog-post
$url->get(
    [
        'for'   => 'show-post',
        'year'  => '2015',
        'month' => '01',
        'title' => 'some-blog-post',
    ]
);
```

## Producing URLs without mod_rewrite

You can use this component also to create URLs without mod_rewrite:

```php
<?php

use Phalcon\Url;

$url = new Url();

// Pass the URI in $_GET['_url']
$url->setBaseUri('/invo/index.php?_url=/');

// This produce: /invo/index.php?_url=/products/save
echo $url->get('products/save');
```

You can also use `$_SERVER['REQUEST_URI']`:

```php
<?php

use Phalcon\Url;

$url = new Url();

// Pass the URI in $_GET['_url']
$url->setBaseUri('/invo/index.php?_url=/');

// Pass the URI using $_SERVER['REQUEST_URI']
$url->setBaseUri('/invo/index.php/');
```

In this case, it's necessary to manually handle the required URI in the Router:

```php
<?php

use Phalcon\Mvc\Router;

$router = new Router();

// ... Define routes

$uri = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI']);

$router->handle($uri);
```

The produced routes would look like:

```php
<?php

// This produce: /invo/index.php/products/save
echo $url->get('products/save');
```

## Producing URLs from Volt

The function `url` is available in volt to generate URLs using this component:

```twig
{% raw %}
<a href='{{ url('posts/edit/1002') }}'>Edit</a>
{% endraw %}
```

Generate static routes:

```twig
{% raw %}
<link rel='stylesheet' href='{{ static_url('css/style.css') }}' type='text/css' />
{% endraw %}
```

## Static vs. Dynamic URIs

This component allow you to set up a different base URI for static resources in the application:

```php
<?php

use Phalcon\Url;

$url = new Url();

// Dynamic URIs are
$url->setBaseUri('/');

// Static resources go through a CDN
$url->setStaticBaseUri('https://static.mywebsite.com/');
```

[Phalcon\Tag](api/Phalcon_Tag) will request both dynamic and static URIs using this component.

## Implementing your own URL Generator

The [Phalcon\UrlInterface](api/Phalcon_UrlInterface) interface must be implemented to create your own URL generator replacing the one provided by Phalcon.