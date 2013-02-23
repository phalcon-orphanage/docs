Interface **Phalcon\\Http\\ResponseInterface**
==============================================

Phalcon\\Http\\ResponseInterface initializer


Methods
---------

abstract public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setStatusCode** (*int* $code, *string* $message)

Sets the HTTP response code



abstract public :doc:`Phalcon\\Http\\Response\\Headers <Phalcon_Http_Response_Headers>`  **getHeaders** ()

Returns headers set by the user



abstract public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setHeader** (*string* $name, *string* $value)

Overwrites a header in the response



abstract public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setRawHeader** (*string* $header)

Send a raw header to the response



abstract public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **resetHeaders** ()

Resets all the stablished headers



abstract public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setExpires** (*DateTime* $datetime)

Sets output expire time header



abstract public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setNotModified** ()

Sends a Not-Modified response



abstract public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setContentType** (*string* $contentType, *string* $charset)

Sets the response content-type mime, optionally the charset



abstract public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **redirect** (*string* $location, *boolean* $externalRedirect, *int* $statusCode)

Redirect by HTTP to another action or URL



abstract public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **setContent** (*string* $content)

Sets HTTP response body



abstract public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **appendContent** (*string* $content)

Appends a string to the HTTP response body



abstract public *string*  **getContent** ()

Gets the HTTP response body



abstract public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **sendHeaders** ()

Sends headers to the client



abstract public :doc:`Phalcon\\Http\\ResponseInterface <Phalcon_Http_ResponseInterface>`  **send** ()

Prints out HTTP response to the client



