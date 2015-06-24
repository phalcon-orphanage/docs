Class **Phalcon\\Http\\Response**
=================================

*implements* :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`

Part of the HTTP cycle is return responses to the clients. Phalcon\\HTTP\\Response is the Phalcon component responsible to achieve this task. HTTP responses are usually composed by headers and body.  

.. code-block:: php

    <?php

    $response = new \Phalcon\Http\Response();
    $response->setStatusCode(200, "OK");
    $response->setContent("<html><body>Hello</body></html>");
    $response->send();



Methods
-------

public  **__construct** ([*unknown* $content], [*unknown* $code], [*unknown* $status])

Phalcon\\Http\\Response constructor



public  **setDI** (*unknown* $dependencyInjector)

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the internal dependency injector



public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setStatusCode** (*unknown* $code, [*unknown* $message])

Sets the HTTP response code 

.. code-block:: php

    <?php

    $response->setStatusCode(404, "Not Found");




public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setHeaders** (*unknown* $headers)

Sets a headers bag for the response externally



public :doc:`Phalcon\\Http\\Response\\HeadersInterface <Phalcon_Http_Response_HeadersInterface>`  **getHeaders** ()

Returns headers set by the user



public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setCookies** (*unknown* $cookies)

Sets a cookies bag for the response externally



public :doc:`Phalcon\\Http\\Response\\CookiesInterface <Phalcon_Http_Response_CookiesInterface>`  **getCookies** ()

Returns coookies set by the user



public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setHeader** (*unknown* $name, *unknown* $value)

Overwrites a header in the response 

.. code-block:: php

    <?php

    $response->setHeader("Content-Type", "text/plain");




public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setRawHeader** (*unknown* $header)

Send a raw header to the response 

.. code-block:: php

    <?php

    $response->setRawHeader("HTTP/1.1 404 Not Found");




public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **resetHeaders** ()

Resets all the stablished headers



public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setExpires** (*unknown* $datetime)

Sets a Expires header to use HTTP cache 

.. code-block:: php

    <?php

    $this->response->setExpires(new DateTime());




public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setNotModified** ()

Sends a Not-Modified response



public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setContentType** (*unknown* $contentType, [*unknown* $charset])

Sets the response content-type mime, optionally the charset 

.. code-block:: php

    <?php

    $response->setContentType('application/pdf');
    $response->setContentType('text/plain', 'UTF-8');




public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setEtag** (*unknown* $etag)

Set a custom ETag 

.. code-block:: php

    <?php

    $response->setEtag(md5(time()));




public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **redirect** ([*unknown* $location], [*unknown* $externalRedirect], [*unknown* $statusCode])

Redirect by HTTP to another action or URL 

.. code-block:: php

    <?php

      //Using a string redirect (internal/external)
    $response->redirect("posts/index");
    $response->redirect("http://en.wikipedia.org", true);
    $response->redirect("http://www.example.com/new-location", true, 301);
    
    //Making a redirection based on a named route
    $response->redirect(array(
    	"for" => "index-lang",
    	"lang" => "jp",
    	"controller" => "index"
    ));




public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setContent** (*unknown* $content)

Sets HTTP response body 

.. code-block:: php

    <?php

    response->setContent("<h1>Hello!</h1>");




public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setJsonContent** (*unknown* $content, [*unknown* $jsonOptions])

Sets HTTP response body. The parameter is automatically converted to JSON 

.. code-block:: php

    <?php

    $response->setJsonContent(array("status" => "OK"));




public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **appendContent** (*unknown* $content)

Appends a string to the HTTP response body



public *string*  **getContent** ()

Gets the HTTP response body



public *boolean*  **isSent** ()

Check if the response is already sent



public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **sendHeaders** ()

Sends headers to the client



public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **sendCookies** ()

Sends cookies to the client



public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **send** ()

Prints out HTTP response to the client



public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setFileToSend** (*unknown* $filePath, [*unknown* $attachmentName], [*unknown* $attachment])

Sets an attached file to be sent at the end of the request



