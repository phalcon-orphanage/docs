Class **Phalcon\\Http\\Response**
=================================

Encapsulates the HTTP response message.  

.. code-block:: php

    <?php

    $response = new Phalcon\Http\Response();
    $response->setStatusCode(200, "OK");
    $response->setContent("<html><body>Hello</body></html>");
    $response->send();



Methods
---------

public **setDI** (*unknown* $dependencyInjector)

public **getDI** ()

:doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>` public **setStatusCode** (*int* $code, *string* $message)

Sets the HTTP response code



:doc:`Phalcon\\Http\\Response\\Headers <Phalcon_Http_Response_Headers>` public **getHeaders** ()

Returns headers set by the user



:doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>` public **setHeader** (*string* $name, *string* $value)

Overwrites a header in the response 

.. code-block:: php

    <?php

    $response->setHeader("Content-Type", "text/plain");




:doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>` public **setRawHeader** (*string* $header)

Send a raw header to the response 

.. code-block:: php

    <?php

    $response->setRawHeader("HTTP/1.1 404 Not Found");




:doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>` public **resetHeaders** ()

Resets all the stablished headers



:doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>` public **setExpires** (*DateTime* $datetime)

Sets output expire time header



:doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>` public **setNotModified** ()

Sends a Not-Modified response



public **setContentType** (*unknown* $contentType, *unknown* $charset)

Sets the response content-type mime, optionally the charset 

.. code-block:: php

    <?php

    $response->setContentType('text/plain', 'UTF-8');




:doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>` public **redirect** (*string* $location, *boolean* $externalRedirect, *int* $statusCode)

Redirect by HTTP to another action or URL 

.. code-block:: php

    <?php

    $response->redirect("posts/index");
    $response->redirect("http://en.wikipedia.org", true);
    $response->redirect("http://www.example.com/new-location", true, 301);




:doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>` public **setContent** (*string* $content)

Sets HTTP response body 

.. code-block:: php

    <?php

    $response->setContent("<h1>Hello!</h1>");




:doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>` public **appendContent** (*string* $content)

Appends a string to the HTTP response body



*string* public **getContent** ()

Gets HTTP response body



:doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>` public **sendHeaders** ()

Sends headers to the client



:doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>` public **send** ()

Prints out HTTP response to the client



