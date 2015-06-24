Class **Phalcon\\Http\\Request**
================================

*implements* :doc:`Phalcon\\Http\\RequestInterface <Phalcon_Http_RequestInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`

Encapsulates request information for easy and secure access from application controllers.    The request object is a simple value object that is passed between the dispatcher and controller classes. It packages the HTTP request environment.    

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

public  **setDI** (*unknown* $dependencyInjector)

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the internal dependency injector



public *mixed*  **get** ([*unknown* $name], [*unknown* $filters], [*unknown* $defaultValue], [*unknown* $notAllowEmpty], [*unknown* $noRecursive])

Gets a variable from the $_REQUEST superglobal applying filters if needed. If no parameters are given the $_REQUEST superglobal is returned 

.. code-block:: php

    <?php

    //Returns value from $_REQUEST["user_email"] without sanitizing
    $userEmail = $request->get("user_email");
    
    //Returns value from $_REQUEST["user_email"] with sanitizing
    $userEmail = $request->get("user_email", "email");




public *mixed*  **getPost** ([*unknown* $name], [*unknown* $filters], [*unknown* $defaultValue], [*unknown* $notAllowEmpty], [*unknown* $noRecursive])

Gets a variable from the $_POST superglobal applying filters if needed If no parameters are given the $_POST superglobal is returned 

.. code-block:: php

    <?php

    //Returns value from $_POST["user_email"] without sanitizing
    $userEmail = $request->getPost("user_email");
    
    //Returns value from $_POST["user_email"] with sanitizing
    $userEmail = $request->getPost("user_email", "email");




public *mixed*  **getPut** ([*unknown* $name], [*unknown* $filters], [*unknown* $defaultValue], [*unknown* $notAllowEmpty], [*unknown* $noRecursive])

Gets a variable from put request 

.. code-block:: php

    <?php

    //Returns value from $_PUT["user_email"] without sanitizing
    $userEmail = $request->getPut("user_email");
    
    //Returns value from $_PUT["user_email"] with sanitizing
    $userEmail = $request->getPut("user_email", "email");




public *mixed*  **getQuery** ([*unknown* $name], [*unknown* $filters], [*unknown* $defaultValue], [*unknown* $notAllowEmpty], [*unknown* $noRecursive])

Gets variable from $_GET superglobal applying filters if needed If no parameters are given the $_GET superglobal is returned 

.. code-block:: php

    <?php

    //Returns value from $_GET["id"] without sanitizing
    $id = $request->getQuery("id");
    
    //Returns value from $_GET["id"] with sanitizing
    $id = $request->getQuery("id", "int");
    
    //Returns value from $_GET["id"] with a default value
    $id = $request->getQuery("id", null, 150);




public *mixed*  **getServer** (*unknown* $name)

Gets variable from $_SERVER superglobal



public *boolean*  **has** (*unknown* $name)

Checks whether $_REQUEST superglobal has certain index



public *boolean*  **hasPost** (*string* $name)

Checks whether $_POST superglobal has certain index



public *boolean*  **hasQuery** (*unknown* $name)

Checks whether $_GET superglobal has certain index



final public *boolean*  **hasServer** (*unknown* $name)

Checks whether $_SERVER superglobal has certain index



final public *string*  **getHeader** (*unknown* $header)

Gets HTTP header from request data



public *string*  **getScheme** ()

Gets HTTP schema (http/https)



public *boolean*  **isAjax** ()

Checks whether request has been made using ajax



public *boolean*  **isSoapRequested** ()

Checks whether request has been made using SOAP



public *boolean*  **isSecureRequest** ()

Checks whether request has been made using any secure layer



public *string*  **getRawBody** ()

Gets HTTP raw request body



public *string*  **getJsonRawBody** ([*unknown* $associative])

Gets decoded JSON HTTP raw request body



public *string*  **getServerAddress** ()

Gets active server address IP



public *string*  **getServerName** ()

Gets active server name



public *string*  **getHttpHost** ()

Gets information about schema, host and port used by the request



final public *string*  **getURI** ()

Gets HTTP URI which request has been made



public *string|boolean*  **getClientAddress** ([*unknown* $trustForwardedHeader])

Gets most possible client IPv4 Address. This method search in _SERVER['REMOTE_ADDR'] and optionally in _SERVER['HTTP_X_FORWARDED_FOR']



final public *string*  **getMethod** ()

Gets HTTP method which request has been made



public *string*  **getUserAgent** ()

Gets HTTP user agent used to made the request



public *boolean*  **isMethod** (*unknown* $methods)

Check if HTTP method match any of the passed methods



public *boolean*  **isPost** ()

Checks whether HTTP method is POST. if _SERVER["REQUEST_METHOD"]==="POST"



public *boolean*  **isGet** ()

Checks whether HTTP method is GET. if _SERVER["REQUEST_METHOD"]==="GET"



public *boolean*  **isPut** ()

Checks whether HTTP method is PUT. if _SERVER["REQUEST_METHOD"]==="PUT"



public *boolean*  **isPatch** ()

Checks whether HTTP method is PATCH. if _SERVER["REQUEST_METHOD"]==="PATCH"



public *boolean*  **isHead** ()

Checks whether HTTP method is HEAD. if _SERVER["REQUEST_METHOD"]==="HEAD"



public *boolean*  **isDelete** ()

Checks whether HTTP method is DELETE. if _SERVER["REQUEST_METHOD"]==="DELETE"



public *boolean*  **isOptions** ()

Checks whether HTTP method is OPTIONS. if _SERVER["REQUEST_METHOD"]==="OPTIONS"



public *boolean*  **hasFiles** ([*unknown* $onlySuccessful])

Checks whether request include attached files



private  **hasFileHelper** (*unknown* $data, *unknown* $onlySuccessful)

...


public :doc:`Phalcon\\Http\\Request\\File <Phalcon_Http_Request_File>` [] **getUploadedFiles** ([*unknown* $notErrored])

Gets attached files as Phalcon\\Http\\Request\\File instances



protected *array*  **smoothFiles** (*unknown* $names, *unknown* $types, *unknown* $tmp_names, *unknown* $sizes, *unknown* $errors, *unknown* $prefix)

smooth out $_FILES to have plain array with all files uploaded



public *array*  **getHeaders** ()

Returns the available headers in the request



public *string*  **getHTTPReferer** ()

Gets web page that refers active request. ie: http://www.google.com



protected *array*  **_getQualityHeader** (*unknown* $serverIndex, *unknown* $name)

Process a request header and return an array of values with their qualities



protected *string*  **_getBestQuality** (*unknown* $qualityParts, *unknown* $name)

Process a request header and return the one with best quality



public *mixed*  **getContentType** ()

Gets content type which request has been made



public *array*  **getAcceptableContent** ()

Gets array with mime/types and their quality accepted by the browser/client from _SERVER["HTTP_ACCEPT"]



public *string*  **getBestAccept** ()

Gets best mime/type accepted by the browser/client from _SERVER["HTTP_ACCEPT"]



public *array*  **getClientCharsets** ()

Gets charsets array and their quality accepted by the browser/client from _SERVER["HTTP_ACCEPT_CHARSET"]



public *string*  **getBestCharset** ()

Gets best charset accepted by the browser/client from _SERVER["HTTP_ACCEPT_CHARSET"]



public *array*  **getLanguages** ()

Gets languages array and their quality accepted by the browser/client from _SERVER["HTTP_ACCEPT_LANGUAGE"]



public *string*  **getBestLanguage** ()

Gets best language accepted by the browser/client from _SERVER["HTTP_ACCEPT_LANGUAGE"]



public *array*  **getBasicAuth** ()

Gets auth info accepted by the browser/client from $_SERVER['PHP_AUTH_USER']



public *array*  **getDigestAuth** ()

Gets auth info accepted by the browser/client from $_SERVER['PHP_AUTH_DIGEST']



