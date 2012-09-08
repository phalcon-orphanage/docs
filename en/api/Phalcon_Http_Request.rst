Class **Phalcon\\Http\\Request**
================================

Encapsulates request information for easy and secure access from application controllers.   The request object is a simple value object that is passed between the dispatcher and controller classes. It packages the HTTP request environment.   

.. code-block:: php

    <?php

    $request = new Phalcon\Http\Request();
    if ($request->isPost() == true) {
        if ($request->isAjax() == true) {
            echo 'Request was made using POST and AJAX';
        }
    }



Methods
---------

public **setDI** (*unknown* $dependencyInjector)

public **getDI** ()

*mixed* public **getPost** (*string* $name, *string|array* $filters)

Gets variable from $_POST superglobal applying filters if needed 

.. code-block:: php

    <?php

    // Returns value from $_POST["user_email"] without sanitizing
    $userEmail = $request->getPost("user_email");
    
    // Returns value from $_POST["user_email"] with sanitizing
    $userEmail = $request->getPost("user_email", "email");




*mixed* public **getQuery** (*string* $name, *string|array* $filters)

Gets variable from $_GET superglobal applying filters if needed 

.. code-block:: php

    <?php

    // Returns value from $_GET["id"] without sanitizing
    $id = $request->getQuery("id");
    
    // Returns value from $_GET["id"] with sanitizing
    $id = $request->getQuery("id", "int");




*mixed* public **getServer** (*string* $name)

Gets variable from $_SERVER superglobal



*boolean* public **hasPost** (*string* $name)

Checks whether $_POST superglobal has certain index



*boolean* public **hasQuery** (*string* $name)

Checks whether $_SERVER superglobal has certain index



*mixed* public **hasServer** (*string* $name)

Checks whether $_SERVER superglobal has certain index



*string* public **getHeader** (*string* $header)

Gets HTTP header from request data



*string* public **getScheme** ()

Gets HTTP schema (http/https)



*boolean* public **isAjax** ()

Checks whether request has been made using ajax



*boolean* public **isSoapRequested** ()

Checks whether request has been made using SOAP



*boolean* public **isSecureRequest** ()

Checks whether request has been made using any secure layer



*string* public **getRawBody** ()

Gets HTTP raws request body



*string* public **getServerAddress** ()

Gets active server address IP



*string* public **getServerName** ()

Gets active server name



*string* public **getHttpHost** ()

Gets information about schema, host and port used by the request



*string* public **getClientAddress** ()

Gets most possibly client IPv4 Address. This methods search in $_SERVER['HTTP_X_FORWARDED_FOR'] and $_SERVER['REMOTE_ADDR']



*string* public **getMethod** ()

Gets HTTP method which request has been made



*string* public **getUserAgent** ()

Gets HTTP user agent used to made the request



public **isMethod** (*string|array* $methods)

Check if HTTP method match any of the passed methods



*boolean* public **isPost** ()

Checks whether HTTP method is POST. if $_SERVER['REQUEST_METHOD']=='POST'



*boolean* public **isGet** ()

Checks whether HTTP method is GET. if $_SERVER['REQUEST_METHOD']=='GET'



*boolean* public **isPut** ()

Checks whether HTTP method is PUT. if $_SERVER['REQUEST_METHOD']=='PUT'



*boolean* public **isHead** ()

Checks whether HTTP method is HEAD. if $_SERVER['REQUEST_METHOD']=='HEAD'



*boolean* public **isDelete** ()

Checks whether HTTP method is DELETE. if $_SERVER['REQUEST_METHOD']=='DELETE'



*boolean* public **isOptions** ()

Checks whether HTTP method is OPTIONS. if $_SERVER['REQUEST_METHOD']=='OPTIONS'



*boolean* public **hasFiles** ()

Checks whether request include attached files



:doc:`Phalcon\\Http\\Request\\File <../api/Phalcon_Http_Request_File>` public **getUploadedFiles** ()

Gets attached files as Phalcon\\Http\\Request\\File instances



*string* public **getHTTPReferer** ()

Gets web page that refers active request. ie: http://www.google.com



*array* protected **_getQualityHeader** ()

Process a request header and return an array of values with their qualities



*string* protected **_getBestQuality** ()

Process a request header and return the one with best quality



*array* public **getAcceptableContent** ()

Gets array with mime/types and their quality accepted by the browser/client from $_SERVER['HTTP_ACCEPT']



*array* public **getBestAccept** ()

Gets best mime/type accepted by the browser/client from $_SERVER['HTTP_ACCEPT']



*array* public **getClientCharsets** ()

Gets charsets array and their quality accepted by the browser/client from $_SERVER['HTTP_ACCEPT_CHARSET']



*string* public **getBestCharset** ()

Gets best charset accepted by the browser/client from $_SERVER['HTTP_ACCEPT_CHARSET']



*array* public **getLanguages** ()

Gets languages array and their quality accepted by the browser/client from $_SERVER['HTTP_ACCEPT_LANGUAGE']



*string* public **getBestLanguage** ()

Gets best language accepted by the browser/client from $_SERVER['HTTP_ACCEPT_LANGUAGE']



