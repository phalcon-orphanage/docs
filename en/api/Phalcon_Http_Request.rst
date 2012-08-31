Class **Phalcon\\Http\\Request**
================================

Phalcon\\Http\\Request   <p>Encapsulates request information for easy and secure access from application controllers.</p>   <p>The request object is a simple value object that is passed between the dispatcher and controller classes.  It packages the HTTP request environment.</p>  

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

**setDI** (*unknown* **$dependencyInjector**)

**getDI** ()

*mixed* **getPost** (*string* **$name**, *string|array* **$filters**)

*mixed* **getQuery** (*string* **$name**, *string|array* **$filters**)

*mixed* **getServer** (*string* **$name**)

*boolean* **hasPost** (*string* **$name**)

*boolean* **hasQuery** (*string* **$name**)

*mixed* **hasServer** (*string* **$name**)

*string* **getHeader** (*string* **$header**)

*string* **getScheme** ()

*boolean* **isAjax** ()

*boolean* **isSoapRequested** ()

*boolean* **isSecureRequest** ()

*string* **getRawBody** ()

*string* **getServerAddress** ()

*string* **getServerName** ()

*string* **getHttpHost** ()

*string* **getClientAddress** ()

*string* **getMethod** ()

*string* **getUserAgent** ()

**isMethod** (*string|array* **$methods**)

*boolean* **isPost** ()

*boolean* **isGet** ()

*boolean* **isPut** ()

*boolean* **isHead** ()

*boolean* **isDelete** ()

*boolean* **isOptions** ()

*boolean* **hasFiles** ()

:doc:`Phalcon\\Http\\Request\\File[] <Phalcon_Http_Request_File[]>` **getUploadedFiles** ()

*string* **getHTTPReferer** ()

*array* **_getQualityHeader** ()

*string* **_getBestQuality** ()

*array* **getAcceptableContent** ()

*array* **getBestAccept** ()

*array* **getClientCharsets** ()

*string* **getBestCharset** ()

*array* **getLanguages** ()

*string* **getBestLanguage** ()

