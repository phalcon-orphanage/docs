返回响应（Returning Responses）
===============================

:doc:`Phalcon\\Http\\Response <../api/Phalcon_Http_Response>` 是Phalcon中用来处理HTTP响应返回的组件。
HTTP响应通常是由响应头和响应体组成的。下面是一些基本用法:

.. code-block:: php

    <?php

    use Phalcon\Http\Response;

    // 获取一个响应实例
    $response = new Response();

    // 设置HTTP状态码
    $response->setStatusCode(404, "Not Found");

    // 设置响应内容
    $response->setContent("Sorry, the page doesn't exist");

    // 返回响应到客户端
    $response->send();

If you are using the full MVC stack there is no need to create responses manually. However, if you need to return a response
directly from a controller's action follow this example:

.. code-block:: php

    <?php

    use Phalcon\Http\Response;
    use Phalcon\Mvc\Controller;

    class FeedController extends Controller
    {
        public function getAction()
        {
            // Getting a response instance
            $response = new Response();

            $feed = // ... Load here the feed

            // Set the content of the response
            $response->setContent(
                $feed->asString()
            );

            // Return the response
            return $response;
        }
    }

使用头部信息（Working with Headers）
------------------------------------
在HTTP响应返回中，响应头（Headers）是非常重要的组成部分. 它包含了一些非常有用的信息，比如HTTP状态码，响应类型等等.

你可以使用如下方式来设置头信息:

.. code-block:: php

    <?php

    // Setting a header by its name
    $response->setHeader("Content-Type", "application/pdf");
    $response->setHeader("Content-Disposition", 'attachment; filename="downloaded.pdf"');

    // Setting a raw header
    $response->setRawHeader("HTTP/1.1 200 OK");

A :doc:`Phalcon\\Http\\Response\\Headers <../api/Phalcon_Http_Response_Headers>` bag internally manages headers. This class
retrieves the headers before sending it to client:

.. code-block:: php

    <?php

    // Get the headers bag
    $headers = $response->getHeaders();

    // Get a header by its name
    $contentType = $headers->get("Content-Type");

重定向（Making Redirections）
-----------------------------
可以通过 :doc:`Phalcon\\Http\\Response <../api/Phalcon_Http_Response>` 来执行HTTP重定向：

.. code-block:: php

    <?php

    // Redirect to the default URI
    $response->redirect();

    // Redirect to the local base URI
    $response->redirect("posts/index");

    // Redirect to an external URL
    $response->redirect("http://en.wikipedia.org", true);

    // Redirect specifying the HTTP status code
    $response->redirect("http://www.example.com/new-location", true, 301);

All internal URIs are generated using the 'url' service (by default :doc:`Phalcon\\Mvc\\Url <url>`). This example demonstrates
how you can redirect using a route you have defined in your application:

所有内部 URIs 都是通过 'url' 来生成的（ 默认是 :doc:`Phalcon\\Mvc\\Url <url>` ）。下面的例子演示如何通过一个应用内预先定义好的路由来重定向。

.. code-block:: php

    <?php

    // Redirect based on a named route
    return $response->redirect(
        [
            "for"        => "index-lang",
            "lang"       => "jp",
            "controller" => "index",
        ]
    );

Note that a redirection doesn't disable the view component, so if there is a view associated with the current action it
will be executed anyway. You can disable the view from a controller by executing :code:`$this->view->disable()`;

值得注意的是重定向并不禁用view组件，所以如果当前的action存在一个关联的view的话，将会继续执行它。在控制器中可以通过 :code:`$this->view->disable()` 来禁用view。

HTTP 缓存（HTTP Cache）
-----------------------
One of the easiest ways to improve the performance in your applications and reduce the traffic is using HTTP Cache.
Most modern browsers support HTTP caching and is one of the reasons why many websites are currently fast.

HTTP Cache can be altered in the following header values sent by the application when serving a page for the first time:

* *Expires:* With this header the application can set a date in the future or the past telling the browser when the page must expire.
* *Cache-Control:* This header allows to specify how much time a page should be considered fresh in the browser.
* *Last-Modified:* This header tells the browser which was the last time the site was updated avoiding page re-loads
* *ETag:* An etag is a unique identifier that must be created including the modification timestamp of the current page

设置过期时间（Setting an Expiration Time）
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
The expiration date is one of the easiest and most effective ways to cache a page in the client (browser).
Starting from the current date we add the amount of time the page will be stored
in the browser cache. Until this date expires no new content will be requested from the server:

.. code-block:: php

    <?php

    $expiryDate = new DateTime();
    $expiryDate->modify("+2 months");

    $response->setExpires($expiryDate);

The Response component automatically shows the date in GMT timezone as expected in an Expires header.

If we set this value to a date in the past the browser will always refresh the requested page:

.. code-block:: php

    <?php

    $expiryDate = new DateTime();
    $expiryDate->modify("-10 minutes");

    $response->setExpires($expiryDate);

Browsers rely on the client's clock to assess if this date has passed or not. The client clock can be modified to
make pages expire and this may represent a limitation for this cache mechanism.

Cache-Control
^^^^^^^^^^^^^
This header provides a safer way to cache the pages served. We simply must specify a time in seconds telling the browser
how long it must keep the page in its cache:

.. code-block:: php

    <?php

    // Starting from now, cache the page for one day
    $response->setHeader("Cache-Control", "max-age=86400");

The opposite effect (avoid page caching) is achieved in this way:

.. code-block:: php

    <?php

    // Never cache the served page
    $response->setHeader("Cache-Control", "private, max-age=0, must-revalidate");

E-Tag
^^^^^
An "entity-tag" or "E-tag" is a unique identifier that helps the browser realize if the page has changed or not between two requests.
The identifier must be calculated taking into account that this must change if the previously served content has changed:

.. code-block:: php

    <?php

    // Calculate the E-Tag based on the modification time of the latest news
    $mostRecentDate = News::maximum(
        [
            "column" => "created_at"
        ]
    );

    $eTag = md5($mostRecentDate);

    // Send an E-Tag header
    $response->setHeader("E-Tag", $eTag);
