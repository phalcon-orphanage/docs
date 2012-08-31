Class **Phalcon_Response**
==========================

Encapsulates the HTTP response message.  

.. code-block:: php

    <?php
    
    $response = Phalcon_Response::getInstance();
    $response->setStatusCode(200, "OK");
    $response->setContent("<html><body>Hello</body></html>");
    $response->send();

Methods
---------

**Phalcon_Response** **getInstance** ()

Returns singleton Phalcon_Response instance

**Phalcon_Response** **setStatusCode** (int $code, strign $message)

Sets the HTTP response code

**Phalcon_Response_Headers** **getHeaders** ()

Returns headers set by the user

**Phalcon_Response** **setHeader** (string $name, string $value)

Overwrites a header in the response 

.. code-block:: php

    <?php
    
    $response->setHeader("Content-Type", "text/plain");
    
**Phalcon_Response** **setRawHeader** (string $header)

Send a raw header to the response 

.. code-block:: php

    <?php
    
    $response->setRawHeader("HTTP/1.1 404 Not Found");
    
**Phalcon_Response** **setExpires** (DateTime $datetime)

Sets output expire time header

**setNotModified** ()

Sends a Not-Modified response

**setContentType** (unknown $contentType, unknown $charset)

Sets the response content-type mime, optionally the charset 

.. code-block:: php

    <?php
    
    $response->setContentType('text/plain', 'UTF-8');
    
**Phalcon_Response** **redirect** (string $location, boolean $externalRedirect, int $statusCode)

Redirect by HTTP to another action or URL 

.. code-block:: php

    <?php
    
    $response->redirect("posts/index");
    $response->redirect("http://en.wikipedia.org", true);
    $response->redirect("http://www.example.com/new-location", true, 301);
    
**setContent** (string $content)

Sets HTTP response body 

.. code-block:: php

    <?php
    
    $response->setContent("<h1>Hello!</h1>");
    
**Phalcon_Response** **appendContent** (string $content)

Appends a string to the HTTP response body

**string** **getContent** ()

Gets HTTP response body

**sendHeaders** ()

Sends headers to the client

**Phalcon_Response** **send** ()

Prints out HTTP response to the client

**reset** ()

Resets the internal singleton

