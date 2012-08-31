Class **Phalcon\\Http\\Response**
=================================

Phalcon\\Http\\Response   Encapsulates the HTTP response message.  

.. code-block:: php

    <?php

    
    $response = new Phalcon\Http\Response();
    $response->setStatusCode(200, "OK");
    $response->setContent("<html><body>Hello</body></html>");
    $response->send();
    





Methods
---------

**setDI** (*unknown* **$dependencyInjector**)

**getDI** ()

:doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>` **setStatusCode** (*int* **$code**, *string* **$message**)

:doc:`Phalcon\\Http\\Response\\Headers <Phalcon_Http_Response_Headers>` **getHeaders** ()

:doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>` **setHeader** (*string* **$name**, *string* **$value**)

:doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>` **setRawHeader** (*string* **$header**)

:doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>` **resetHeaders** ()

:doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>` **setExpires** (*DateTime* **$datetime**)

:doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>` **setNotModified** ()

**setContentType** (*unknown* **$contentType**, *unknown* **$charset**)

:doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>` **redirect** (*string* **$location**, *boolean* **$externalRedirect**, *int* **$statusCode**)

:doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>` **setContent** (*string* **$content**)

:doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>` **appendContent** (*string* **$content**)

*string* **getContent** ()

:doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>` **sendHeaders** ()

:doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>` **send** ()

