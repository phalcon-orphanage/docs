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



public  **getDI** ()

Returns the internal dependency injector



public  **setStatusCode** (*unknown* $code, [*unknown* $message])

Sets the HTTP response code 

.. code-block:: php

    <?php

    $response->setStatusCode(404, "Not Found");




public  **getStatusCode** ()

Returns the status code 

.. code-block:: php

    <?php

    print_r($response->getStatusCode());




public  **setHeaders** (*unknown* $headers)

Sets a headers bag for the response externally



public  **getHeaders** ()

Returns headers set by the user



public  **setCookies** (*unknown* $cookies)

Sets a cookies bag for the response externally



public :doc:`Phalcon\\Http\\Response\\CookiesInterface <Phalcon_Http_Response_CookiesInterface>`  **getCookies** ()

Returns coookies set by the user



public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **setHeader** (*unknown* $name, *unknown* $value)

Overwrites a header in the response 

.. code-block:: php

    <?php

    $response->setHeader("Content-Type", "text/plain");




public  **setRawHeader** (*unknown* $header)

Send a raw header to the response 

.. code-block:: php

    <?php

    $response->setRawHeader("HTTP/1.1 404 Not Found");




public  **resetHeaders** ()

Resets all the stablished headers



public  **setExpires** (*unknown* $datetime)

Sets a Expires header to use HTTP cache 

.. code-block:: php

    <?php

    $this->response->setExpires(new DateTime());




public  **setNotModified** ()

Sends a Not-Modified response



public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **setContentType** (*unknown* $contentType, [*unknown* $charset])

Sets the response content-type mime, optionally the charset 

.. code-block:: php

    <?php

    $response->setContentType('application/pdf');
    $response->setContentType('text/plain', 'UTF-8');




public  **setEtag** (*unknown* $etag)

Set a custom ETag 

.. code-block:: php

    <?php

    $response->setEtag(md5(time()));




public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **redirect** ([*unknown* $location], [*unknown* $externalRedirect], [*unknown* $statusCode])

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




public  **setContent** (*unknown* $content)

Sets HTTP response body 

.. code-block:: php

    <?php

    response->setContent("<h1>Hello!</h1>");




public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **setJsonContent** (*unknown* $content, [*unknown* $jsonOptions], [*unknown* $depth])

Sets HTTP response body. The parameter is automatically converted to JSON 

.. code-block:: php

    <?php

    $response->setJsonContent(array("status" => "OK"));




public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **appendContent** (*unknown* $content)

Appends a string to the HTTP response body



public  **getContent** ()

Gets the HTTP response body



public  **isSent** ()

Check if the response is already sent



public  **sendHeaders** ()

Sends headers to the client



public  **sendCookies** ()

Sends cookies to the client



public  **send** ()

Prints out HTTP response to the client



public :doc:`Phalcon\\Http\\Response <Phalcon_Http_Response>`  **setFileToSend** (*unknown* $filePath, [*unknown* $attachmentName], [*unknown* $attachment])

Sets an attached file to be sent at the end of the request



