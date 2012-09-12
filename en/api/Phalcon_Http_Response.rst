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

public  **setDI** (:doc:`Phalcon\\DI <Phalcon_DI>` $dependencyInjector)

Sets the dependency injector



public :doc:`Phalcon\\DI <Phalcon_DI>`  **getDI** ()

Returns the internal dependency injector



public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **setStatusCode** (*int* $code, *string* $message)

Sets the HTTP response code 

.. code-block:: php

    <?php

    $response->setStatusCode(404, "Not Found");




public :doc:`Phalcon\\Http\\Response\\Headers <Phalcon_Http_Response_Headers>`  **getHeaders** ()

Returns headers set by the user



public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **setHeader** (*string* $name, *string* $value)

Overwrites a header in the response 

.. code-block:: php

    <?php

    $response->setHeader("Content-Type", "text/plain");




public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **setRawHeader** (*string* $header)

Send a raw header to the response 

.. code-block:: php

    <?php

    $response->setRawHeader("HTTP/1.1 404 Not Found");




public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **resetHeaders** ()

Resets all the stablished headers



public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **setExpires** (*DateTime* $datetime)

Sets output expire time header



public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **setNotModified** ()

Sends a Not-Modified response



public  **setContentType** (*unknown* $contentType, *unknown* $charset)

Sets the response content-type mime, optionally the charset 

.. code-block:: php

    <?php

    $response->setContentType('application/pdf');
    $response->setContentType('text/plain', 'UTF-8');




public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **redirect** (*string* $location, *boolean* $externalRedirect, *int* $statusCode)

Redirect by HTTP to another action or URL 

.. code-block:: php

    <?php

    $response->redirect("posts/index");
    $response->redirect("http://en.wikipedia.org", true);
    $response->redirect("http://www.example.com/new-location", true, 301);




public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **setContent** (*string* $content)

Sets HTTP response body 

.. code-block:: php

    <?php

    $response->setContent("<h1>Hello!</h1>");




public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **appendContent** (*string* $content)

Appends a string to the HTTP response body



public *string*  **getContent** ()

Gets HTTP response body



public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **sendHeaders** ()

Sends headers to the client



public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **send** ()

Prints out HTTP response to the client



