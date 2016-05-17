Class **Phalcon\\Http\\Request**
================================

*implements* :doc:`Phalcon\\Http\\RequestInterface <Phalcon_Http_RequestInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/http/request.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Encapsulates request information for easy and secure access from application controllers.  The request object is a simple value object that is passed between the dispatcher and controller classes. It packages the HTTP request environment.  

.. code-block:: php

    <?php

    $request = new \Phalcon\Http\Request();
    if ($request->isPost() == true) {
    	if ($request->isAjax() == true) {
    		echo 'Request was made using POST and AJAX';
    	}
    }



Methods
-------

public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the dependency injector



public  **getDI** ()

Returns the internal dependency injector



public  **get** ([*unknown* $name], [*unknown* $filters], [*unknown* $defaultValue], [*unknown* $notAllowEmpty], [*unknown* $noRecursive])

Gets a variable from the $_REQUEST superglobal applying filters if needed. If no parameters are given the $_REQUEST superglobal is returned 

.. code-block:: php

    <?php

    //Returns value from $_REQUEST["user_email"] without sanitizing
    $userEmail = $request->get("user_email");
    
    //Returns value from $_REQUEST["user_email"] with sanitizing
    $userEmail = $request->get("user_email", "email");




public  **getPost** ([*unknown* $name], [*unknown* $filters], [*unknown* $defaultValue], [*unknown* $notAllowEmpty], [*unknown* $noRecursive])

Gets a variable from the $_POST superglobal applying filters if needed If no parameters are given the $_POST superglobal is returned 

.. code-block:: php

    <?php

    //Returns value from $_POST["user_email"] without sanitizing
    $userEmail = $request->getPost("user_email");
    
    //Returns value from $_POST["user_email"] with sanitizing
    $userEmail = $request->getPost("user_email", "email");




public  **getPut** ([*unknown* $name], [*unknown* $filters], [*unknown* $defaultValue], [*unknown* $notAllowEmpty], [*unknown* $noRecursive])

Gets a variable from put request 

.. code-block:: php

    <?php

    //Returns value from $_PUT["user_email"] without sanitizing
    $userEmail = $request->getPut("user_email");
    
    //Returns value from $_PUT["user_email"] with sanitizing
    $userEmail = $request->getPut("user_email", "email");




public  **getQuery** ([*unknown* $name], [*unknown* $filters], [*unknown* $defaultValue], [*unknown* $notAllowEmpty], [*unknown* $noRecursive])

Gets variable from $_GET superglobal applying filters if needed If no parameters are given the $_GET superglobal is returned 

.. code-block:: php

    <?php

    //Returns value from $_GET["id"] without sanitizing
    $id = $request->getQuery("id");
    
    //Returns value from $_GET["id"] with sanitizing
    $id = $request->getQuery("id", "int");
    
    //Returns value from $_GET["id"] with a default value
    $id = $request->getQuery("id", null, 150);




final protected  **getHelper** (*array* $source, [*unknown* $name], [*unknown* $filters], [*unknown* $defaultValue], [*unknown* $notAllowEmpty], [*unknown* $noRecursive])

Helper to get data from superglobals, applying filters if needed. If no parameters are given the superglobal is returned.



public  **getServer** (*unknown* $name)

Gets variable from $_SERVER superglobal



public  **has** (*unknown* $name)

Checks whether $_REQUEST superglobal has certain index



public  **hasPost** (*unknown* $name)

Checks whether $_POST superglobal has certain index



public  **hasPut** (*unknown* $name)

Checks whether the PUT data has certain index



public  **hasQuery** (*unknown* $name)

Checks whether $_GET superglobal has certain index



final public  **hasServer** (*unknown* $name)

Checks whether $_SERVER superglobal has certain index



final public  **getHeader** (*unknown* $header)

Gets HTTP header from request data



public  **getScheme** ()

Gets HTTP schema (http/https)



public  **isAjax** ()

Checks whether request has been made using ajax



public  **isSoapRequested** ()

Checks whether request has been made using SOAP



public  **isSecureRequest** ()

Checks whether request has been made using any secure layer



public  **getRawBody** ()

Gets HTTP raw request body



public  **getJsonRawBody** ([*unknown* $associative])

Gets decoded JSON HTTP raw request body



public  **getServerAddress** ()

Gets active server address IP



public  **getServerName** ()

Gets active server name



public  **getHttpHost** ()

Gets information about schema, host and port used by the request



final public  **getURI** ()

Gets HTTP URI which request has been made



public  **getClientAddress** ([*unknown* $trustForwardedHeader])

Gets most possible client IPv4 Address. This method search in _SERVER['REMOTE_ADDR'] and optionally in _SERVER['HTTP_X_FORWARDED_FOR']



final public  **getMethod** ()

Gets HTTP method which request has been made



public  **getUserAgent** ()

Gets HTTP user agent used to made the request



public  **isValidHttpMethod** (*unknown* $method)

Checks if a method is a valid HTTP method



public  **isMethod** (*unknown* $methods, [*unknown* $strict])

Check if HTTP method match any of the passed methods When strict is true it checks if validated methods are real HTTP methods



public  **isPost** ()

Checks whether HTTP method is POST. if _SERVER["REQUEST_METHOD"]==="POST"



public  **isGet** ()

Checks whether HTTP method is GET. if _SERVER["REQUEST_METHOD"]==="GET"



public  **isPut** ()

Checks whether HTTP method is PUT. if _SERVER["REQUEST_METHOD"]==="PUT"



public  **isPatch** ()

Checks whether HTTP method is PATCH. if _SERVER["REQUEST_METHOD"]==="PATCH"



public  **isHead** ()

Checks whether HTTP method is HEAD. if _SERVER["REQUEST_METHOD"]==="HEAD"



public  **isDelete** ()

Checks whether HTTP method is DELETE. if _SERVER["REQUEST_METHOD"]==="DELETE"



public  **isOptions** ()

Checks whether HTTP method is OPTIONS. if _SERVER["REQUEST_METHOD"]==="OPTIONS"



public  **hasFiles** ([*unknown* $onlySuccessful])

Checks whether request include attached files



final protected  **hasFileHelper** (*unknown* $data, *unknown* $onlySuccessful)

Recursively counts file in an array of files



public  **getUploadedFiles** ([*unknown* $onlySuccessful])

Gets attached files as Phalcon\\Http\\Request\\File instances



final protected  **smoothFiles** (*array* $names, *array* $types, *array* $tmp_names, *array* $sizes, *array* $errors, *unknown* $prefix)

Smooth out $_FILES to have plain array with all files uploaded



public  **getHeaders** ()

Returns the available headers in the request



public  **getHTTPReferer** ()

Gets web page that refers active request. ie: http://www.google.com



final protected  **_getQualityHeader** (*unknown* $serverIndex, *unknown* $name)

Process a request header and return an array of values with their qualities



final protected  **_getBestQuality** (*array* $qualityParts, *unknown* $name)

Process a request header and return the one with best quality



public  **getContentType** ()

Gets content type which request has been made



public  **getAcceptableContent** ()

Gets an array with mime/types and their quality accepted by the browser/client from _SERVER["HTTP_ACCEPT"]



public  **getBestAccept** ()

Gets best mime/type accepted by the browser/client from _SERVER["HTTP_ACCEPT"]



public  **getClientCharsets** ()

Gets a charsets array and their quality accepted by the browser/client from _SERVER["HTTP_ACCEPT_CHARSET"]



public  **getBestCharset** ()

Gets best charset accepted by the browser/client from _SERVER["HTTP_ACCEPT_CHARSET"]



public  **getLanguages** ()

Gets languages array and their quality accepted by the browser/client from _SERVER["HTTP_ACCEPT_LANGUAGE"]



public  **getBestLanguage** ()

Gets best language accepted by the browser/client from _SERVER["HTTP_ACCEPT_LANGUAGE"]



public  **getBasicAuth** ()

Gets auth info accepted by the browser/client from $_SERVER['PHP_AUTH_USER']



public  **getDigestAuth** ()

Gets auth info accepted by the browser/client from $_SERVER['PHP_AUTH_DIGEST']



