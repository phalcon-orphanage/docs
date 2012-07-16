

Request Environment
===================
Normally, the HTTP client (usually a browser) sends as part of the request headers, files, variables, etc.Take advantage of that information is useful to return a better response to the user. encapsulates the most important information of therequest providing you object-oriented wrappers to access them. As there is only a request enviroment for each request, Phalcon_Requests implements the `singleton pattern <http://en.wikipedia.org/wiki/Singleton_pattern>`_ with a lazy initialization. This means that you only have one instance of that class per request.

.. code-block:: php

    <?php
    
    //Getting the singleton instance
    $request = Phalcon_Request::getInstance();
    
    //Check whether the request was made with method POST
    if ($request->isPost() == true) {
      //Check whether the request was made with Ajax
      if ($request->isAjax() == true) {
         echo "Request was made using POST and AJAX";
      }
    }

Phalcon_Request could be used in any part of the application, you only need to getthe internal instance of the class by calling Phalcon_Request::getInstance(). 

Recovering Values
-----------------
PHP automatically fills the superglobals $_GET and $_POST. These variables containsthe values present in forms or the parameters sent in the URL. Although they do a very good work, these values can contain extra characters and if aren't treated properly can lead to receive common attacks like  `SQL injection <http://en.wikipedia.org/wiki/SQL_injection>`_ or `Cross Site Scripting (XSS) <http://en.wikipedia.org/wiki/Cross-site_scripting>`_ .For that reason, with Phalcon_Request you can access $_GET and $_POST and sanitize/filter thereceived values together with  . The followingexamples have the same behavior: 

.. code-block:: php

    <?php

    //Manually applying the filter
    $filter = new Phalcon_Filter();
    $email = $fiter->sanitize($_POST["user_email"], "email");
    
    //Manually applying the filter to the value
    $filter = new Phalcon_Filter();
    $email = $fiter->sanitize($request->getPost("user_email"), "email");
    
    //Automatically applying the filter
    $email = $request->getPost("user_email", "email");



Accesing Request from Controllers
---------------------------------
A common place where surely you will need access the request environment is in the action controllers.There are several reasons to need the Phalcon_Request instance in this stage of the execution. You could access it simply by accesing the $this->request public property of the controller: 

.. code-block:: php

    <?php
    
    class PostsController extends Phalcon_Controller
    {
    
      function indexAction()
      {
    
      }
    
      function saveAction()
      {
    
        //Check if request has made with POST
        if ($this->request->isPost() == true) {
    
          //Access POST data
          $customerName = $this->request->getPost("name");
          $customerBorn = $this->request->getPost("born");
    
        }
    
      }
    
    }



Uploading Files
---------------
Another common task is deal with file uploads. Phalcon_Request provides youa object-oriented way to access the uploaded files: 

.. code-block:: php

    <?php
    
    class PostsController extends Phalcon_Controller
    {
    
      function uploadAction()
      {
        //Check if the user has uploaded files
        if ($this->request->hasFiles() == true) {
           //Print the real file names and sizes
           foreach ($this->request->getUploadedFiles() as $file){
              echo $file->getName(), " ", $file->getSize(), "\n";
           }
        }
      }
    
    }

Each object returned by Phalcon_Request::getUploadedFiles() is an instance of theclass. Using the $_FILES superglobalwill give you the same behavior. This class only encapsulates the information related to each file uploaded with the request. 

Working with Headers
--------------------
As mentioned above, request headers contains useful information that might help usto send a better response the the users. The following examples shows how to take advantage of that information: 

.. code-block:: php

    <?php
    
    //get the Http-X-Requested-With header
    $requestedWith = $response->getHeader("X_REQUESTED_WITH");
    if ($requestedWith == "XMLHttpRequest") {
        echo "The request was made with Ajax";
    }
    
    //Same as above
    if ($request->isAjax()) {
        echo "The request was made with Ajax";
    }
    
    //Check the request layer
    if ($request->isSecureRequest() == true) {
        echo "The request was made using a secure layer";
    }
    
    //Get the servers's ip address. ie. 192.168.0.100
    $ipAddress = $request->getServerAddress();
    
    //Get the client's ip address ie. 201.245.53.51
    $ipAddress = $request->getClientAddress();
    
    //Get the User Agent (HTTP_USER_AGENT)
    $userAgent = $request->getUserAgent();
    
    //Get the best acceptable content by the browser. ie text/xml
    $contentType = $request->getAcceptableContent();
    
    //Get the best charset accepted by the browser. ie. utf-8
    $charset = $request->getBestCharset();
    
    //Get the best language accepted configured in the browser. ie. en-us
    $language = $request->getBestLanguage();

