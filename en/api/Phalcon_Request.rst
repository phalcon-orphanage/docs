Class **Phalcon_Request**
=========================

Encapsulates request information for easy and secure access from application controllers.

The request object is a simple value object that is passed between the dispatcher and controller classes. It packages the HTTP request environment.

.. code-block:: php

    <?php
    
    $request = Phalcon_Request::getInstance();
    if ($request->isPost() == true) {
        if ($request->isAjax() == true) {
            echo 'Request was made using POST and AJAX';
        }
    }

Methods
---------

**Phalcon_Request** **getInstance** ()

Gets the singleton instance of Phalcon_Request

**setFilter** (Phalcon_Filter $filter)

Overwrites Phalcon_Filter object used to sanitize input data 

.. code-block:: php

    <?php
    
     $request->setFilter($myFilter);
    
**Phalcon_Filter** **getFilter** ()

Returns the active filter object used to sanitize input data 

.. code-block:: php

    <?php
    
    // returns "100019.01"
     echo $request->getFilter()->sanitize("!100a019.01a", "float");
    
**mixed** **getPost** (string $name, string|array $filters)

Gets variable from $_POST superglobal applying filters if needed 

.. code-block:: php

    <?php


    // Returns value from $_POST["user_email"] without sanitizing
    $userEmail = $request->getPost("user_email");
    
    // Returns value from $_POST["user_email"] with sanitizing
    $userEmail = $request->getPost("user_email", "email");
    
**mixed** **getQuery** (string $name, string|array $filters)

Gets variable from $_GET superglobal applying filters if needed 

.. code-block:: php

    <?php


    // Returns value from $_GET["id"] without sanitizing
    $id = $request->getQuery("id");
    
    // Returns value from $_GET["id"] with sanitizing
    $id = $request->getQuery("id", "int");
    
**mixed** **getServer** (string $name)

Gets variable from $_SERVER superglobal

**boolean** **hasPost** (string $name)

Checks whether $_POST superglobal has certain index

**boolean** **hasQuery** (string $name)

Checks whether $_SERVER superglobal has certain index

**mixed** **hasServer** (string $name)

Checks whether $_SERVER superglobal has certain index

**string** **getHeader** (string $header)

Gets HTTP header from request data

**string** **getScheme** ()

Gets HTTP schema (http/https)

**boolean** **isAjax** ()

Checks whether request has been made using ajax

**boolean** **isSoapRequested** ()

Checks whether request has been made using SOAP

**boolean** **isSecureRequest** ()

Checks whether request has been made using any secure layer

**string** **getRawBody** ()

Gets HTTP raws request body

**string** **getServerAddress** ()

Gets active server address IP

**string** **getServerName** ()

Gets active server name

**string** **getHttpHost** ()

Gets information about schema, host and port used by the request

**string** **getClientAddress** ()

Gets most possibly client IPv4 Address. This methods search in $_SERVER['HTTP_X_FORWARDED_FOR'] and $_SERVER['REMOTE_ADDR']

**string** **getMethod** ()

Gets HTTP method which request has been made

**string** **getUserAgent** ()

Gets HTTP user agent used to made the request

**boolean** **isPost** ()

Checks whether HTTP method is POST. if $_SERVER['REQUEST_METHOD']=='POST'

**boolean** **isGet** ()

Checks whether HTTP method is GET. if $_SERVER['REQUEST_METHOD']=='GET'

**boolean** **isPut** ()

Checks whether HTTP method is PUT. if $_SERVER['REQUEST_METHOD']=='PUT'

**boolean** **isHead** ()

Checks whether HTTP method is HEAD. if $_SERVER['REQUEST_METHOD']=='HEAD'

**boolean** **isDelete** ()

Checks whether HTTP method is DELETE. if $_SERVER['REQUEST_METHOD']=='DELETE'

**boolean** **isOptions** ()

Checks whether HTTP method is OPTIONS. if $_SERVER['REQUEST_METHOD']=='OPTIONS'

**boolean** **hasFiles** ()

Checks whether request include attached files

**Phalcon_Request_File[]** **getUploadedFiles** ()

Gets attached files as Phalcon_Request_File instances

**string** **getHTTPReferer** ()

Gets web page that refers active request. i.e.: http://www.google.com

**array** **_getQualityHeader** (string $serverIndex, string $name)

Process a request header and return an array of values with their qualities

**string** **_getBestQuality** (array $qualityParts, string $name)

Process a request header and return the one with best quality

**array** **getAcceptableContent** ()

Gets array with mime types and their quality accepted by the browser/client from $_SERVER['HTTP_ACCEPT']

**array** **getBestAccept** ()

Gets best mime type accepted by the browser/client from $_SERVER['HTTP_ACCEPT']

**array** **getClientCharsets** ()

Gets charsets array accepted by the browser/client from $_SERVER['HTTP_ACCEPT_CHARSET']

**string** **getBestCharset** ()

Gets best charset accepted by the browser/client from $_SERVER['HTTP_ACCEPT_CHARSET']

**array** **getLanguages** ()

Gets languages array and their quality accepted by the browser/client from $_SERVER['HTTP_ACCEPT_LANGUAGE']

**string** **getBestLanguage** ()

Gets best language accepted by the browser/client from $_SERVER['HTTP_ACCEPT_LANGUAGE']

**reset** ()

Resets the internal singleton

