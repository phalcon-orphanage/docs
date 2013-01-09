Generating URLs and Paths
=========================

:doc:`Phalcon\\Mvc\\Url <../api/Phalcon_Mvc_Url>` is the component responsible of generate urls in a Phalcon application. It's
capable of produce independent urls based on routes.

Setting a base URI
------------------
Dependending of which directory of your document root your application is installed, it may have a base uri or not.

For example, If your document root is /var/www/htdocs and your application is installed in /var/www/htdocs/invo then your
baseUri will be /invo/. If you are using a VirtualHost or your application is installed on the document root then your baseUri is /.
Execute the following code to know the base uri detected by Phalcon:

.. code-block:: php

    <?php

    $url = new Phalcon\Mvc\Url();
    echo $url->getBaseUri();

By default, Phalcon automatically may detect your baseUri, but if you want to increase the performance of your application
is recommended to set up it manually:

.. code-block:: php

    <?php

    $url = new Phalcon\Mvc\Url();

    $url->setBaseUri('/invo/');

Usually, this component must be registered in the Dependency Injector container, so you can setup it on it:

.. code-block:: php

    <?php

    $di->set('url', function(){
    	$url = new Phalcon\Mvc\Url();
    	$url->setBaseUri('/invo/');
    	return $url;
    });

Generating URIs
---------------
If you are using the :doc:`Router <routing>` with its default behavior. Your application is able the match routes based on the
following pattern: /:controller/:action/:params. Accordingly it is easy to create routes that satisfy that pattern (or any other
pattern defined in the router) passing a string to the method "get":

.. code-block:: php

    <?php echo $url->get("products/save") ?>

Note that isn't necessary to prepend the base uri. If you have named routes you can easily change it creating it dinamically.
For Example if you have the following route:

.. code-block:: php

    <?php

    $route->add('/blog/{$year}/{month}/{title}', array(
        'controller' => 'posts',
        'action' => 'show'
    ))->setName('show-post');

A URL can be generated in the following way:

.. code-block:: php

    <?php

    //This produces: /blog/2012/01/some-blog-post
    $url->get(array(
        'for' => 'show-post',
        'year' => 2012,
        'month' => '01',
        'title' => 'some-blog-post'
    ));

Producing URLs without Mod-Rewrite
----------------------------------
You can use this component also to create urls without mod-rewrite:

.. code-block:: php

    <?php

    $url = new Phalcon\Mvc\Url();

    //Pass the URI in $_GET["_url"]
    $url->setBaseUri('/invo/index.php?_url=/');

    //This produce: /invo/index.php?_url=/products/save
    echo $url->get("products/save");

You can also use $_SERVER["REQUEST_URI"]:

.. code-block:: php

    <?php

    $url = new Phalcon\Mvc\Url();

    //Pass the URI using $_SERVER["REQUEST_URI"]
    $url->setBaseUri('/invo/index.php?_url=/');

    //Pass the URI in $_GET["_url"]
    $url->setBaseUri('/invo/index.php/');

In this case, it's neccesary to manually handle the required URI in the Router:

.. code-block:: php

    <?php

    $router = new Phalcon\Mvc\Router();

    // ... define routes

    $uri = str_replace($_SERVER["SCRIPT_NAME"], '', $_SERVER["REQUEST_URI"]);
    $router->handle($uri);

The produced routes would look like:

.. code-block:: php

    <?php

    //This produce: /invo/index.php/products/save
    echo $url->get("products/save");

Producing URLs from Volt
------------------------
The function "url" is available in volt to generate URLs using this component:

.. code-block:: html+jinja

    <a href="{{ url("posts/edit/1002") }}">Edit</a>

Implementing your own Url Generator
-----------------------------------
The :doc:`Phalcon\\Mvc\\UrlInterface <../api/Phalcon_Mvc_UrlInterface>` interface must be implemented to create your own URL
generator replacing the one provided by Phalcon.
