Class **Phalcon\\Http\\Response**
=================================

*implements* :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/http/response.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Part of the HTTP cycle is return responses to the clients.
Phalcon\\HTTP\\Response is the Phalcon component responsible to achieve this task.
HTTP responses are usually composed by headers and body.

.. code-block:: php

    <?php

    $response = new \Phalcon\Http\Response();

    $response->setStatusCode(200, "OK");
    $response->setContent("<html><body>Hello</body></html>");

    $response->send();



Methods
-------

public  **__construct** ([*mixed* $content], [*mixed* $code], [*mixed* $status])

Phalcon\\Http\\Response constructor



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the dependency injector



public  **getDI** ()

Returns the internal dependency injector



public  **setStatusCode** (*mixed* $code, [*mixed* $message])

Sets the HTTP response code

.. code-block:: php

    <?php

    $response->setStatusCode(404, "Not Found");




public  **getStatusCode** ()

Returns the status code

.. code-block:: php

    <?php

    print_r(
        $response->getStatusCode()
    );




public  **setHeaders** (:doc:`Phalcon\\Http\\Response\\HeadersInterface <Phalcon_Http_Response_HeadersInterface>` $headers)

Sets a headers bag for the response externally



public  **getHeaders** ()

Returns headers set by the user



public  **setCookies** (:doc:`Phalcon\\Http\\Response\\CookiesInterface <Phalcon_Http_Response_CookiesInterface>` $cookies)

Sets a cookies bag for the response externally



public :doc:`Phalcon\\Http\\Response\\CookiesInterface <Phalcon_Http_Response_CookiesInterface>` **getCookies** ()

Returns cookies set by the user



public  **setHeader** (*mixed* $name, *mixed* $value)

Overwrites a header in the response

.. code-block:: php

    <?php

    $response->setHeader("Content-Type", "text/plain");




public  **setRawHeader** (*mixed* $header)

Send a raw header to the response

.. code-block:: php

    <?php

    $response->setRawHeader("HTTP/1.1 404 Not Found");




public  **resetHeaders** ()

Resets all the established headers



public  **setExpires** (`DateTime <http://php.net/manual/en/class.datetime.php>`_ $datetime)

Sets an Expires header in the response that allows to use the HTTP cache

.. code-block:: php

    <?php

    $this->response->setExpires(
        new DateTime()
    );




public  **setLastModified** (`DateTime <http://php.net/manual/en/class.datetime.php>`_ $datetime)

Sets Last-Modified header

.. code-block:: php

    <?php

    $this->response->setLastModified(
        new DateTime()
    );




public  **setCache** (*mixed* $minutes)

Sets Cache headers to use HTTP cache

.. code-block:: php

    <?php

    $this->response->setCache(60);




public  **setNotModified** ()

Sends a Not-Modified response



public  **setContentType** (*mixed* $contentType, [*mixed* $charset])

Sets the response content-type mime, optionally the charset

.. code-block:: php

    <?php

    $response->setContentType("application/pdf");
    $response->setContentType("text/plain", "UTF-8");




public  **setContentLength** (*mixed* $contentLength)

Sets the response content-length

.. code-block:: php

    <?php

    $response->setContentLength(2048);




public  **setEtag** (*mixed* $etag)

Set a custom ETag

.. code-block:: php

    <?php

    $response->setEtag(md5(time()));




public  **redirect** ([*mixed* $location], [*mixed* $externalRedirect], [*mixed* $statusCode])

Redirect by HTTP to another action or URL

.. code-block:: php

    <?php

    // Using a string redirect (internal/external)
    $response->redirect("posts/index");
    $response->redirect("http://en.wikipedia.org", true);
    $response->redirect("http://www.example.com/new-location", true, 301);

    // Making a redirection based on a named route
    $response->redirect(
        [
            "for"        => "index-lang",
            "lang"       => "jp",
            "controller" => "index",
        ]
    );




public  **setContent** (*mixed* $content)

Sets HTTP response body

.. code-block:: php

    <?php

    $response->setContent("<h1>Hello!</h1>");




public  **setJsonContent** (*mixed* $content, [*mixed* $jsonOptions], [*mixed* $depth])

Sets HTTP response body. The parameter is automatically converted to JSON
and also sets default header: Content-Type: "application/json; charset=UTF-8"

.. code-block:: php

    <?php

    $response->setJsonContent(
        [
            "status" => "OK",
        ]
    );




public  **appendContent** (*mixed* $content)

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



public  **setFileToSend** (*mixed* $filePath, [*mixed* $attachmentName], [*mixed* $attachment])

Sets an attached file to be sent at the end of the request



