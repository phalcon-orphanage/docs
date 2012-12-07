Class **Phalcon\\Http\\Response**
=================================

<<<<<<< HEAD
Part of the HTTP cycle is return responses to the clients. Phalcon\\HTTP\\Response is the Phalcon component responsible to achieve this task. HTTP responses are usually composed by headers and body. 
=======
*implements* :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`, :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`

Part of the HTTP cycle is return responses to the clients. Phalcon\\HTTP\\Response is the Phalcon component responsible to achieve this task. HTTP responses are usually composed by headers and body.  
>>>>>>> 0.7.0

.. code-block:: php

    <?php

    $response = new Phalcon\Http\Response();
    $response->setStatusCode(200, "OK");
    $response->setContent("<html><body>Hello</body></html>");
    $response->send();



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
public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **setStatusCode** (*int* $code, *string* $message)
=======
public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setStatusCode** (*int* $code, *string* $message)
>>>>>>> 0.7.0

Sets the HTTP response code 

.. code-block:: php

    <?php

    $response->setStatusCode(404, "Not Found");




<<<<<<< HEAD
public :doc:`Phalcon\\Http\\Response\\Headers <Phalcon_Http_Response_Headers>`  **getHeaders** ()
=======
public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setHeaders** (:doc:`Phalcon\\Http\\Response\\HeadersInterface <Phalcon_Http_Response_HeadersInterface>` $headers)

Sets a headers bag for the response externally



public :doc:`Phalcon\\Http\\Response\\HeadersInterface <Phalcon_Http_Response_HeadersInterface>`  **getHeaders** ()
>>>>>>> 0.7.0

Returns headers set by the user



<<<<<<< HEAD
public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **setHeader** (*string* $name, *string* $value)
=======
public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setCookies** (:doc:`Phalcon\\Http\\Response\\CookiesInterface <Phalcon_Http_Response_CookiesInterface>` $cookies)

Sets a cookies bag for the response externally



public :doc:`Phalcon\\Http\\Response\\CookiesInterface <Phalcon_Http_Response_CookiesInterface>`  **getCookies** ()

Returns coookies set by the user



public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setHeader** (*string* $name, *string* $value)
>>>>>>> 0.7.0

Overwrites a header in the response 

.. code-block:: php

    <?php

    $response->setHeader("Content-Type", "text/plain");




<<<<<<< HEAD
public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **setRawHeader** (*string* $header)
=======
public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setRawHeader** (*string* $header)
>>>>>>> 0.7.0

Send a raw header to the response 

.. code-block:: php

    <?php

    $response->setRawHeader("HTTP/1.1 404 Not Found");




<<<<<<< HEAD
public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **resetHeaders** ()
=======
public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **resetHeaders** ()
>>>>>>> 0.7.0

Resets all the stablished headers



<<<<<<< HEAD
public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **setExpires** (*DateTime* $datetime)
=======
public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setExpires** (*DateTime* $datetime)
>>>>>>> 0.7.0

Sets output expire time header



<<<<<<< HEAD
public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **setNotModified** ()
=======
public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setNotModified** ()
>>>>>>> 0.7.0

Sends a Not-Modified response



<<<<<<< HEAD
public  **setContentType** (*string* $contentType, *string* $charset)
=======
public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setContentType** (*string* $contentType, *string* $charset)
>>>>>>> 0.7.0

Sets the response content-type mime, optionally the charset 

.. code-block:: php

    <?php

    $response->setContentType('application/pdf');
    $response->setContentType('text/plain', 'UTF-8');




<<<<<<< HEAD
public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **redirect** (*string* $location, *boolean* $externalRedirect, *int* $statusCode)
=======
public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **redirect** (*string* $location, *boolean* $externalRedirect, *int* $statusCode)
>>>>>>> 0.7.0

Redirect by HTTP to another action or URL 

.. code-block:: php

    <?php

<<<<<<< HEAD
=======
      //Using a string redirect (internal/external)
>>>>>>> 0.7.0
    $response->redirect("posts/index");
    $response->redirect("http://en.wikipedia.org", true);
    $response->redirect("http://www.example.com/new-location", true, 301);




<<<<<<< HEAD
public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **setContent** (*string* $content)
=======
public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setContent** (*string* $content)
>>>>>>> 0.7.0

Sets HTTP response body 

.. code-block:: php

    <?php

    $response->setContent("<h1>Hello!</h1>");




<<<<<<< HEAD
public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **appendContent** (*string* $content)
=======
public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **appendContent** (*string* $content)
>>>>>>> 0.7.0

Appends a string to the HTTP response body



public *string*  **getContent** ()

<<<<<<< HEAD
Gets HTTP response body



public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **sendHeaders** ()
=======
Gets the HTTP response body



public *boolean*  **isSent** ()

Check if the response is already sent



public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **sendHeaders** ()
>>>>>>> 0.7.0

Sends headers to the client



<<<<<<< HEAD
public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **send** ()
=======
public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **send** ()
>>>>>>> 0.7.0

Prints out HTTP response to the client



