Request Environment
===================
每一个HTTP请求（通常是由浏览器发起的）包含额外的信息，如头数据的请求，文件，变量等。
基于Web的应用程序的文件需要分析这些信息，以提供正确的
响应返回给请求者。 :doc:`Phalcon\\HTTP\\Request <../api/Phalcon_Http_Request>` 封装
信息的请求，允许你在一个面向对象的方法来访问它。

.. code-block:: php

    <?php

    // Getting a request instance
    $request = new \Phalcon\Http\Request();

    // Check whether the request was made with method POST
    if ($request->isPost() == true) {
        // Check whether the request was made with Ajax
        if ($request->isAjax() == true) {
            echo "Request was made using POST and AJAX";
        }
    }

获取数据
-----------------
PHP根据请求的类型自动填充超全局变量$_GET 和 $_POST。这些数组包含表单提交或通过URL请求的参数。这些数组中的变量值是未加过滤的，可能包含非法字符，甚至是恶意代码，这可能会导致 `SQL injection`_ or `Cross Site Scripting (XSS)`_ 攻击。

:doc:`Phalcon\\HTTP\\Request <../api/Phalcon_Http_Request>` 允许你访问$_REQUEST,
$_GET 和 $_POST 这些数组中的值，并且可以通过"filter" (by default
:doc:`Phalcon\\Filter <filter>`) 服务对他们进行过滤或消毒。下面的例子提供与原始PHP获取数据相同的行为：

.. code-block:: php

    <?php

    // Manually applying the filter
    $filter = new Phalcon\Filter();

    $email  = $filter->sanitize($_POST["user_email"], "email");

    // Manually applying the filter to the value
    $filter = new Phalcon\Filter();
    $email  = $filter->sanitize($request->getPost("user_email"), "email");

    // Automatically applying the filter
    $email = $request->getPost("user_email", "email");

    // Setting a default value if the param is null
    $email = $request->getPost("user_email", "email", "some@example.com");

    // Setting a default value if the param is null without filtering
    $email = $request->getPost("user_email", null, "some@example.com");


在控制器中使用Request
--------------------------------------
访问请求最常见的地方发生在controller/action中。要想在控制器中访问 :doc:`Phalcon\\HTTP\\Request <../api/Phalcon_Http_Request>` 对象，你可以使用 $this->request 这个公共属性：

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function indexAction()
        {

        }

        public function saveAction()
        {

            // Check if request has made with POST
            if ($this->request->isPost() == true) {

                // Access POST data
                $customerName = $this->request->getPost("name");
                $customerBorn = $this->request->getPost("born");

            }

        }

    }

文件上传
---------------
另一种常见的任务是文件上传。:doc:`Phalcon\\HTTP\\Request <../api/Phalcon_Http_Request>` 提供了一个面向对象的方式来实现这个任务：

.. code-block:: php

    <?php

    class PostsController extends \Phalcon\Mvc\Controller
    {

        public function uploadAction()
        {
            // Check if the user has uploaded files
            if ($this->request->hasFiles() == true) {
                // Print the real file names and sizes
                foreach ($this->request->getUploadedFiles() as $file) {

                    //Print file details
                    echo $file->getName(), " ", $file->getSize(), "\n";


                    //Move the file into the application
                    $file->moveTo('files/');
                }
            }
        }

    }

Phalcon\\Http\\Request::getUploadedFiles() 返回的每个对象是类文件 :doc:`Phalcon\\Http\\Request\\File <../api/Phalcon_Http_Request_File>` 的实际对象。使用 $_FILES 超全局变量提供了相同的行为。:doc:`Phalcon\\Http\\Request\\File <../api/Phalcon_Http_Request_File>` 封装了上传请求中的单个文件信息。

Working with Headers
--------------------
正如上面提到的，请求头非常有用，它使我们能够发送适当的响应返回给用户。下面的例子将向你展示使用的方法：

.. code-block:: php

    <?php

    // get the Http-X-Requested-With header
    $requestedWith = $response->getHeader("X_REQUESTED_WITH");
    if ($requestedWith == "XMLHttpRequest") {
        echo "The request was made with Ajax";
    }

    // Same as above
    if ($request->isAjax()) {
        echo "The request was made with Ajax";
    }

    // Check the request layer
    if ($request->isSecureRequest() == true) {
        echo "The request was made using a secure layer";
    }

    // Get the servers's ip address. ie. 192.168.0.100
    $ipAddress = $request->getServerAddress();

    // Get the client's ip address ie. 201.245.53.51
    $ipAddress = $request->getClientAddress();

    // Get the User Agent (HTTP_USER_AGENT)
    $userAgent = $request->getUserAgent();

    // Get the best acceptable content by the browser. ie text/xml
    $contentType = $request->getAcceptableContent();

    // Get the best charset accepted by the browser. ie. utf-8
    $charset = $request->getBestCharset();

    // Get the best language accepted configured in the browser. ie. en-us
    $language = $request->getBestLanguage();


.. _SQL injection: http://en.wikipedia.org/wiki/SQL_injection
.. _Cross Site Scripting (XSS): http://en.wikipedia.org/wiki/Cross-site_scripting
