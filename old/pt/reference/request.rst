Solicitações
============

A cada solicitação HTTP (geralmente se origina de um browser) contém informações adicionais sobre a solicitação como dados de cabeçalho, arquivos, variáveis, etc. Um aplicativo baseado na web precisa analisar essas informações de modo a proporcionar a correta resposta de volta para o solicitador. :doc:`Phalcon\\Http\\Request <../api/Phalcon_Http_Request>` encapsula a
informações do pedido, permitindo que você acessá-lo de uma forma orientada a objetos.

.. code-block:: php

    <?php

    use Phalcon\Http\Request;

    // Getting a request instance
    $request = new Request();

    // Check whether the request was made with method POST
    if ($request->isPost()) {
        // Check whether the request was made with Ajax
        if ($request->isAjax()) {
            echo "Request was made using POST and AJAX";
        }
    }

Obtendo Valores
---------------
PHP automatically fills the superglobal arrays :code:`$_GET` and :code:`$_POST` depending on the type of the request. These arrays
contain the values present in forms submitted or the parameters sent via the URL. The variables in the arrays are
never sanitized and can contain illegal characters or even malicious code, which can lead to `SQL injection`_ or
`Cross Site Scripting (XSS)`_ attacks.

:doc:`Phalcon\\Http\\Request <../api/Phalcon_Http_Request>` allows you to access the values stored in the :code:`$_REQUEST`,
:code:`$_GET` and :code:`$_POST` arrays and sanitize or filter them with the 'filter' service, (by default
:doc:`Phalcon\\Filter <filter>`). The following examples offer the same behavior:

.. code-block:: php

    <?php

    use Phalcon\Filter;

    $filter = new Filter();

    // Manually applying the filter
    $email = $filter->sanitize($_POST["user_email"], "email");

    // Manually applying the filter to the value
    $email = $filter->sanitize($request->getPost("user_email"), "email");

    // Automatically applying the filter
    $email = $request->getPost("user_email", "email");

    // Setting a default value if the param is null
    $email = $request->getPost("user_email", "email", "some@example.com");

    // Setting a default value if the param is null without filtering
    $email = $request->getPost("user_email", null, "some@example.com");


Accessing the Request from Controllers
--------------------------------------
The most common place to access the request environment is in an action of a controller. To access the
:doc:`Phalcon\\Http\\Request <../api/Phalcon_Http_Request>` object from a controller you will need to use
the :code:`$this->request` public property of the controller:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function indexAction()
        {

        }

        public function saveAction()
        {
            // Check if request has made with POST
            if ($this->request->isPost()) {
                // Access POST data
                $customerName = $this->request->getPost("name");
                $customerBorn = $this->request->getPost("born");
            }
        }
    }

Uploading Files
---------------
Another common task is file uploading. :doc:`Phalcon\\Http\\Request <../api/Phalcon_Http_Request>` offers
an object-oriented way to achieve this task:

.. code-block:: php

    <?php

    use Phalcon\Mvc\Controller;

    class PostsController extends Controller
    {
        public function uploadAction()
        {
            // Check if the user has uploaded files
            if ($this->request->hasFiles()) {
                $files = $this->request->getUploadedFiles();

                // Print the real file names and sizes
                foreach ($files as $file) {
                    // Print file details
                    echo $file->getName(), " ", $file->getSize(), "\n";

                    // Move the file into the application
                    $file->moveTo(
                        "files/" . $file->getName()
                    );
                }
            }
        }
    }

Each object returned by :code:`Phalcon\Http\Request::getUploadedFiles()` is an instance of the
:doc:`Phalcon\\Http\\Request\\File <../api/Phalcon_Http_Request_File>` class. Using the :code:`$_FILES` superglobal
array offers the same behavior. :doc:`Phalcon\\Http\\Request\\File <../api/Phalcon_Http_Request_File>` encapsulates
only the information related to each file uploaded with the request.

Working with Headers
--------------------
As mentioned above, request headers contain useful information that allow us to send the proper response back to
the user. The following examples show usages of that information:

.. code-block:: php

    <?php

    // Get the Http-X-Requested-With header
    $requestedWith = $request->getHeader("HTTP_X_REQUESTED_WITH");

    if ($requestedWith === "XMLHttpRequest") {
        echo "The request was made with Ajax";
    }

    // Same as above
    if ($request->isAjax()) {
        echo "The request was made with Ajax";
    }

    // Check the request layer
    if ($request->isSecure()) {
        echo "The request was made using a secure layer";
    }

    // Get the servers's IP address. ie. 192.168.0.100
    $ipAddress = $request->getServerAddress();

    // Get the client's IP address ie. 201.245.53.51
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
