Class **Phalcon\\Http\\Response**
=================================

*implements* :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`, :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`

Part of the HTTP cycle is return responses to the clients. Phalcon\\HTTP\\Response is the Phalcon component responsible to achieve this task. HTTP responses are usually composed by headers and body.  

.. code-block:: php

    <?php

    $response = new Phalcon\Http\Response();
    $response->setStatusCode(200, "OK");
    $response->setContent("<html><body>Hello</body></html>");
    $response->send();



Methods
---------

public  **__construct** ([*string* $content], [*int* $code], [*string* $status])

Phalcon\\Http\\Response constructor



public  **setDI** (*Phalcon\\DiInterface* $dependencyInjector)

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the internal dependency injector



public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setStatusCode** (*int* $code, *string* $message)

Sets the HTTP response code 

.. code-block:: php

    <?php

    $response->setStatusCode(404, "Not Found");




public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setHeaders** (*Phalcon\\Http\\Response\\HeadersInterface* $headers)

Sets a headers bag for the response externally



public :doc:`Phalcon\\Http\\Response\\HeadersInterface <Phalcon_Http_Response_HeadersInterface>`  **getHeaders** ()

Returns headers set by the user



public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setCookies** (*Phalcon\\Http\\Response\\CookiesInterface* $cookies)

Sets a cookies bag for the response externally



public *Phalcon\\Http\\Response\\CookiesInterface*  **getCookies** ()

Returns coookies set by the user



public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setHeader** (*string* $name, *string* $value)

Overwrites a header in the response 

.. code-block:: php

    <?php

    $response->setHeader("Content-Type", "text/plain");




public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setRawHeader** (*string* $header)

Send a raw header to the response 

.. code-block:: php

    <?php

    $response->setRawHeader("HTTP/1.1 404 Not Found");




public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **resetHeaders** ()

Resets all the stablished headers



public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setExpires** (*DateTime* $datetime)

Sets a Expires header to use HTTP cache 

.. code-block:: php

    <?php

    $this->response->setExpires(new DateTime());




public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setNotModified** ()

Sends a Not-Modified response



public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setContentType** (*string* $contentType, [*string* $charset])

Sets the response content-type mime, optionally the charset 

.. code-block:: php

    <?php

    $response->setContentType('application/pdf');
    $response->setContentType('text/plain', 'UTF-8');




public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **redirect** ([*string* $location], [*boolean* $externalRedirect], [*int* $statusCode])

Redirect by HTTP to another action or URL 

.. code-block:: php

    <?php

      //Using a string redirect (internal/external)
    $response->redirect("posts/index");
    $response->redirect("http://en.wikipedia.org", true);
    $response->redirect("http://www.example.com/new-location", true, 301);




public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setContent** (*string* $content)

Sets HTTP response body 

.. code-block:: php

    <?php

    $response->setContent("<h1>Hello!</h1>");




public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **appendContent** (*string* $content)

Appends a string to the HTTP response body



public *string*  **getContent** ()

Gets the HTTP response body



public *boolean*  **isSent** ()

Check if the response is already sent



public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **sendHeaders** ()

Sends headers to the client



public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **send** ()

Prints out HTTP response to the client



