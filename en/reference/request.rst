Request Environment
===================
Every HTTP request (usually originated by a browser) contains additional information regarding the request such as header data, files, variables etc. A web based application needs to parse that information so as to provide the correct response back to the requester. :doc:`Phalcon_Request <../api/Phalcon_Request>` encapsulates the information of the request, allowing you to access it in an object oriented way.

As there is only one request environment for each request, :doc:`Phalcon_Request <../api/Phalcon_Request>` implements the `singleton pattern`_ with a lazy initialization. This means that you only have one instance of that class per request.

.. code-block:: php

    <?php
    
    // Getting the singleton instance
    $request = Phalcon_Request::getInstance();
    
    // Check whether the request was made with method POST
    if ($request->isPost() == true) {
        // Check whether the request was made with Ajax
        if ($request->isAjax() == true) {
            echo "Request was made using POST and AJAX";
        }
    }

:doc:`Phalcon_Request <../api/Phalcon_Request>` can be used in any part of the application by invoking the getInstance() method like this:

.. code-block:: php
    
    <?php

    $request = Phalcon_Request::getInstance();

Getting Values
-----------------
PHP automatically fills the superglobal arrays $_GET and $_POST depending on the type of the request. These arrays contain the values present in forms submitted or the parameters sent via the URL. The variables in the arrays are never sanitized and can contain illegal characters or even malicious code, which can lead to `SQL injection`_ or `Cross Site Scripting (XSS)`_ attacks.

:doc:`Phalcon_Request <../api/Phalcon_Request>` allows you to access the values stored in the $_GET and $_POST arrays and sanitize or filter them with :doc:`Phalcon_Filter <../api/Phalcon_Filter>`. The following examples offer the same behavior: 

.. code-block:: php

    <?php

    // Manually applying the filter
    $filter = new Phalcon_Filter();
    $email  = $filter->sanitize($_POST["user_email"], "email");
    
    // Manually applying the filter to the value
    $filter = new Phalcon_Filter();
    $email  = $filter->sanitize($request->getPost("user_email"), "email");
    
    // Automatically applying the filter
    $email = $request->getPost("user_email", "email");


Accessing the Request from Controllers
--------------------------------------
The most common place to access the request environment is in an action of a controller. To access the :doc:`Phalcon_Request <../api/Phalcon_Request>` object from a controller you will need to use the $this->request public property of the controller:

.. code-block:: php

    <?php
    
    class PostsController extends Phalcon_Controller
    {
    
        function indexAction()
        {

        }

        function saveAction()
        {

            // Check if request has made with POST
            if ($this->request->isPost() == true) {

                // Access POST data
                $customerName = $this->request->getPost("name");
                $customerBorn = $this->request->getPost("born");

            }

        }
    
    }

Uploading Files
---------------
Another common task is file uploading. :doc:`Phalcon_Request <../api/Phalcon_Request>` offers an object oriented way to achieve this task:

.. code-block:: php

    <?php
    
    class PostsController extends Phalcon_Controller
    {
    
        function uploadAction()
        {
            // Check if the user has uploaded files
            if ($this->request->hasFiles() == true) {
                // Print the real file names and sizes
                foreach ($this->request->getUploadedFiles() as $file) {
                    echo $file->getName(), " ", $file->getSize(), "\n";
                }
            }
        }
    
    }

Each object returned by Phalcon_Request::getUploadedFiles() is an instance of the :doc:`Phalcon_Request_File <../api/Phalcon_Request_File>` class. Using the $_FILES superglobal array offers the same behavior. :doc:`Phalcon_Request_File <../api/Phalcon_Request_File>` encapsulates only the information related to each file uploaded with the request. 

Working with Headers
--------------------
As mentioned above, request headers contain useful information that allow us to send the proper response back to the user. The following examples show usages of that information: 

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


.. _singleton pattern: http://en.wikipedia.org/wiki/Singleton_pattern
.. _SQL injection: http://en.wikipedia.org/wiki/SQL_injection
.. _Cross Site Scripting (XSS): http://en.wikipedia.org/wiki/Cross-site_scripting 
