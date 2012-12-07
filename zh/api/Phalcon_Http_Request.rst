Class **Phalcon\\Http\\Request**
================================

<<<<<<< HEAD
Encapsulates request information for easy and secure access from application controllers.   The request object is a simple value object that is passed between the dispatcher and controller classes. It packages the HTTP request environment.   
=======
*implements* :doc:`Phalcon\\Http\\RequestInterface <Phalcon_Http_RequestInterface>`, :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`

Encapsulates request information for easy and secure access from application controllers.    The request object is a simple value object that is passed between the dispatcher and controller classes. It packages the HTTP request environment.    
>>>>>>> 0.7.0

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

<<<<<<< HEAD
public  **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector)
=======
public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)
>>>>>>> 0.7.0

Sets the dependency injector



<<<<<<< HEAD
public :doc:`Phalcon\\DI <Phalcon_DI>`  **getDI** ()
=======
public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()
>>>>>>> 0.7.0

Returns the internal dependency injector



<<<<<<< HEAD
public *mixed*  **get** (*string* $name, *string|array* $filters)
=======
public *mixed*  **get** (*string* $name, *string|array* $filters, *mixed* $defaultValue)
>>>>>>> 0.7.0

Gets a variable from the $_REQUEST superglobal applying filters if needed 

.. code-block:: php

    <?php

    //Returns value from $_REQUEST["user_email"] without sanitizing
    $userEmail = $request->get("user_email");
    
    //Returns value from $_REQUEST["user_email"] with sanitizing
    $userEmail = $request->get("user_email", "email");




<<<<<<< HEAD
public *mixed*  **getPost** (*string* $name, *string|array* $filters)
=======
public *mixed*  **getPost** (*string* $name, *string|array* $filters, *mixed* $defaultValue)
>>>>>>> 0.7.0

Gets a variable from the $_POST superglobal applying filters if needed 

.. code-block:: php

    <?php

    //Returns value from $_POST["user_email"] without sanitizing
    $userEmail = $request->getPost("user_email");
    
    //Returns value from $_POST["user_email"] with sanitizing
    $userEmail = $request->getPost("user_email", "email");




<<<<<<< HEAD
public *mixed*  **getQuery** (*string* $name, *string|array* $filters)
=======
public *mixed*  **getQuery** (*string* $name, *string|array* $filters, *mixed* $defaultValue)
>>>>>>> 0.7.0

Gets variable from $_GET superglobal applying filters if needed 

.. code-block:: php

    <?php

    //Returns value from $_GET["id"] without sanitizing
    $id = $request->getQuery("id");
    
    //Returns value from $_GET["id"] with sanitizing
    $id = $request->getQuery("id", "int");
<<<<<<< HEAD
=======
    
    //Returns value from $_GET["id"] with a default value
    $id = $request->getQuery("id", null, 150);
>>>>>>> 0.7.0




public *mixed*  **getServer** (*string* $name)

Gets variable from $_SERVER superglobal



public *boolean*  **has** (*string* $name)

Checks whether $_SERVER superglobal has certain index



public *boolean*  **hasPost** (*string* $name)

Checks whether $_POST superglobal has certain index



public *boolean*  **hasQuery** (*string* $name)

Checks whether $_SERVER superglobal has certain index



public *mixed*  **hasServer** (*string* $name)

Checks whether $_SERVER superglobal has certain index



public *string*  **getHeader** (*string* $header)

Gets HTTP header from request data



public *string*  **getScheme** ()

Gets HTTP schema (http/https)



public *boolean*  **isAjax** ()

Checks whether request has been made using ajax. Checks if $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest'



public *boolean*  **isSoapRequested** ()

Checks whether request has been made using SOAP



public *boolean*  **isSecureRequest** ()

Checks whether request has been made using any secure layer



public *string*  **getRawBody** ()

Gets HTTP raws request body



public *string*  **getServerAddress** ()

Gets active server address IP



public *string*  **getServerName** ()

Gets active server name



public *string*  **getHttpHost** ()

Gets information about schema, host and port used by the request



public *string*  **getClientAddress** (*boolean* $trustForwardedHeader)

Gets most possibly client IPv4 Address. This methods search in $_SERVER['REMOTE_ADDR'] and optionally in $_SERVER['HTTP_X_FORWARDED_FOR']



public *string*  **getMethod** ()

Gets HTTP method which request has been made



public *string*  **getUserAgent** ()

Gets HTTP user agent used to made the request



<<<<<<< HEAD
public  **isMethod** (*string|array* $methods)
=======
public *boolean*  **isMethod** (*string|array* $methods)
>>>>>>> 0.7.0

Check if HTTP method match any of the passed methods



public *boolean*  **isPost** ()

Checks whether HTTP method is POST. if $_SERVER['REQUEST_METHOD']=='POST'



public *boolean*  **isGet** ()

Checks whether HTTP method is GET. if $_SERVER['REQUEST_METHOD']=='GET'



public *boolean*  **isPut** ()

Checks whether HTTP method is PUT. if $_SERVER['REQUEST_METHOD']=='PUT'



public *boolean*  **isHead** ()

Checks whether HTTP method is HEAD. if $_SERVER['REQUEST_METHOD']=='HEAD'



public *boolean*  **isDelete** ()

Checks whether HTTP method is DELETE. if $_SERVER['REQUEST_METHOD']=='DELETE'



public *boolean*  **isOptions** ()

Checks whether HTTP method is OPTIONS. if $_SERVER['REQUEST_METHOD']=='OPTIONS'



public *boolean*  **hasFiles** ()

Checks whether request include attached files



public :doc:`Phalcon\\Http\\Request\\File <Phalcon_Http_Request_File>` [] **getUploadedFiles** ()

Gets attached files as Phalcon\\Http\\Request\\File instances



public *string*  **getHTTPReferer** ()

Gets web page that refers active request. ie: http://www.google.com



protected *array*  **_getQualityHeader** ()

Process a request header and return an array of values with their qualities



protected *string*  **_getBestQuality** ()

Process a request header and return the one with best quality



public *array*  **getAcceptableContent** ()

Gets array with mime/types and their quality accepted by the browser/client from $_SERVER['HTTP_ACCEPT']



public *array*  **getBestAccept** ()

Gets best mime/type accepted by the browser/client from $_SERVER['HTTP_ACCEPT']



public *array*  **getClientCharsets** ()

Gets charsets array and their quality accepted by the browser/client from $_SERVER['HTTP_ACCEPT_CHARSET']



public *string*  **getBestCharset** ()

Gets best charset accepted by the browser/client from $_SERVER['HTTP_ACCEPT_CHARSET']



public *array*  **getLanguages** ()

Gets languages array and their quality accepted by the browser/client from $_SERVER['HTTP_ACCEPT_LANGUAGE']



public *string*  **getBestLanguage** ()

Gets best language accepted by the browser/client from $_SERVER['HTTP_ACCEPT_LANGUAGE']



