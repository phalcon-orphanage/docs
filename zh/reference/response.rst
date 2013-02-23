Returning Responses
===================

HTTP周期的一部分工作是将用户请求的内容正确返回给用户。Phalcon框架使用组件 :doc:`Phalcon\\HTTP\\Response <../api/Phalcon_Http_Response>` 来实现这个任务。HTTP响应（HTTP responses）通常由头部信息及网页主体组成。下面是基本的使用语法：

.. code-block:: php

    <?php

    // Getting a request instance
    $request = new \Phalcon\Http\Request();

    //Set status code
    $response->setRawHeader(404, "Not Found");

    //Set the content of the response
    $response->setContent("Sorry, the page doesn't exist");

    //Send response to the client
    $response->send();

发送头部信息(Working with Headers)
--------------------------------------------
头部信息(Headers)是整个HTTP响应中的重要组成部分。它包括响应状态，如HTTP状态，响应的类型等非常有用的信息。

你可以通过以下方法设置头部信息：

.. code-block:: php

    <?php

    //Setting it by its name
    $response->setHeader("Content-Type", "application/pdf");
    $response->setHeader("Content-Disposition", 'attachment; filename="downloaded.pdf"');

    //Setting a raw header
    $response->setRawHeader("HTTP/1.1 200 OK");

HTTP头部信息由 :doc:`Phalcon\\HTTP\\Response\\Headers <../api/Phalcon_Http_Response_Headers>` 管理，这个类允许在向客户端发回数据前，向客户端发送HTTP头部信息：

.. code-block:: php

    <?php

    //Get the headers bag
    $headers = $response->getHeaders();

    //Get a header by its name
    $contentType = $response->getHeaders()->get("Content-Type");

使用重定向(Making Redirections)
---------------------------------------
使用 :doc:`Phalcon\\HTTP\\Response <../api/Phalcon_Http_Response>` ，你可以实现HTTP重定向:

.. code-block:: php

    <?php

    //Making a redirection using the local base uri
    $response->redirect("posts/index");

    //Making a redirection to an external URL
    $response->redirect("http://en.wikipedia.org", true);

    //Making a redirection specifyng the HTTP status code
    $response->redirect("http://www.example.com/new-location", true, 301);

所有由 "url"服务(by default :doc:`Phalcon\\Mvc\\Url <url>`)产生的内部连接，你可以在程序中这样使用重定向到其他路由上：

.. code-block:: php

    <?php

    //Making a redirection based on a named route
    $response->redirect(array(
        "for" => "index-lang",
        "lang" => "jp",
        "controller" => "index"
    ));

需要注意的是，重定向不会禁用视图组件。因此，如果你想从一个controller/action重定向到另一个controller/acton上，视图将正常显示。当然，你也可以使用 $this->view->disable() 禁用视图输出。


