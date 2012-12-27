Generating URLs and Paths
=========================

在Phalcon应用程序中，使用 :doc:`Phalcon\\Mvc\\Url <../api/Phalcon_Mvc_Url>` 组件生成URL。它能够生成基于路由的独立的URL。

Setting a base URI
------------------
根据你的应用程序安装到主机文档目录的位置，你的应用程序URI可能会出现一个基础的URI。

例如，如果你的主机文档目录是 /var/www/htdocs，而你的应用程序安装到 /var/www/htdocs/invo，那么基础URI即为 /invo/.如果你使用虚拟主机的形式安装此应用，那么baseUri即为 /. 执行以下代码，你可以检测你的应用程序的baseUri.

.. code-block:: php

    <?php

    $url = new Phalcon\Mvc\Url();
    echo $url->getBaseUri();

默认情况下，Phalcon 会自动检测应用程序的baseUri.但如果你想提高应用程序性能的话，最好还是手工设置：

.. code-block:: php

    <?php

    $url = new Phalcon\Mvc\Url();

    $url->setBaseUri('/invo/');

通常情况下，此组件必须被注册到服务容器中，因此你可以直接这样设置它：

.. code-block:: php

    <?php

    $di->set('url', function(){
    	$url = new Phalcon\Mvc\Url();
    	$url->setBaseUri('/invo/');
    	return $url;
    });

Generating URIs
---------------
如果你使用的是 :doc:`Router <routing>` 的默认行为。你的应用程序会匹配路由模式 : /:controller/:action/:params. 因此，很容易通过"get"方法得到：

.. code-block:: php

    <?php echo $url->get("products/save") ?>

请注意，预先设置baseUri并不是必须的。如果你已经通过设置路由命名，你可以很容易改变它。例如，你有以下途径：

.. code-block:: php

    <?php

    $route->add('/blog/{$year}/{month}/{title}', array(
        'controller' => 'posts',
        'action' => 'show'
    ))->setName('show-post');

生成URL还可以通过以下方式：

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
你还可以使用此组件在不使用重写规则的情况下创建URL：

.. code-block:: php

    <?php

    $url = new Phalcon\Mvc\Url();

    //Pass the URI in $_GET["_url"]
    $url->setBaseUri('/invo/index.php?_url=/');

    //This produce: /invo/index.php?_url=/products/save
    echo $url->get("products/save");

你也可以使用 $_SERVER["REQUEST_URI"]:

.. code-block:: php

    <?php

    $url = new Phalcon\Mvc\Url();

    //Pass the URI using $_SERVER["REQUEST_URI"]
    $url->setBaseUri('/invo/index.php?_url=/');

    //Pass the URI in $_GET["_url"]
    $url->setBaseUri('/invo/index.php/');

在这种情况下，你必须手工处理路由中的URI：

.. code-block:: php

    <?php

    $router = new Phalcon\Mvc\Router();

    // ... define routes

    $uri = str_replace($_SERVER["SCRIPT_NAME"], '', $_SERVER["REQUEST_URI"]);
    $router->handle($uri);

产生的路由看起来像这样：

.. code-block:: php

    <?php

    //This produce: /invo/index.php/products/save
    echo $url->get("products/save");

Implementing your own Url Generator
-----------------------------------
The :doc:`Phalcon\\Mvc\\UrlInterface <../api/Phalcon_Mvc_UrlInterface>` interface must be implemented to create your own URL generator replacing the one providing by Phalcon.
