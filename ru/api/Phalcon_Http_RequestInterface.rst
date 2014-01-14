Interface **Phalcon\\Http\\RequestInterface**
=============================================

Phalcon\\Http\\RequestInterface initializer


Methods
-------

abstract public *mixed*  **get** ([*string* $name], [*string|array* $filters], [*mixed* $defaultValue])

Gets a variable from the $_REQUEST superglobal applying filters if needed



abstract public *mixed*  **getPost** ([*string* $name], [*string|array* $filters], [*mixed* $defaultValue])

Gets a variable from the $_POST superglobal applying filters if needed



abstract public *mixed*  **getQuery** ([*string* $name], [*string|array* $filters], [*mixed* $defaultValue])

Gets variable from $_GET superglobal applying filters if needed



abstract public *mixed*  **getServer** (*string* $name)

Gets variable from $_SERVER superglobal



abstract public *boolean*  **has** (*string* $name)

Checks whether $_SERVER superglobal has certain index



abstract public *boolean*  **hasPost** (*string* $name)

Checks whether $_POST superglobal has certain index



abstract public *boolean*  **hasQuery** (*string* $name)

Checks whether $_SERVER superglobal has certain index



abstract public *mixed*  **hasServer** (*string* $name)

Checks whether $_SERVER superglobal has certain index



abstract public *string*  **getHeader** (*string* $header)

Gets HTTP header from request data



abstract public *string*  **getScheme** ()

Gets HTTP schema (http/https)



abstract public *boolean*  **isAjax** ()

Checks whether request has been made using ajax. Checks if $_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest'



abstract public *boolean*  **isSoapRequested** ()

Checks whether request has been made using SOAP



abstract public *boolean*  **isSecureRequest** ()

Checks whether request has been made using any secure layer



abstract public *string*  **getRawBody** ()

Gets HTTP raws request body



abstract public *string*  **getServerAddress** ()

Gets active server address IP



abstract public *string*  **getServerName** ()

Gets active server name



abstract public *string*  **getHttpHost** ()

Gets information about schema, host and port used by the request



abstract public *string*  **getClientAddress** ([*boolean* $trustForwardedHeader])

Gets most possibly client IPv4 Address. This methods search in $_SERVER['REMOTE_ADDR'] and optionally in $_SERVER['HTTP_X_FORWARDED_FOR']



abstract public *string*  **getMethod** ()

Gets HTTP method which request has been made



abstract public *string*  **getUserAgent** ()

Gets HTTP user agent used to made the request



abstract public *boolean*  **isMethod** (*string|array* $methods)

Check if HTTP method match any of the passed methods



abstract public *boolean*  **isPost** ()

Checks whether HTTP method is POST. if $_SERVER['REQUEST_METHOD']=='POST'



abstract public *boolean*  **isGet** ()

Checks whether HTTP method is GET. if $_SERVER['REQUEST_METHOD']=='GET'



abstract public *boolean*  **isPut** ()

Checks whether HTTP method is PUT. if $_SERVER['REQUEST_METHOD']=='PUT'



abstract public *boolean*  **isHead** ()

Checks whether HTTP method is HEAD. if $_SERVER['REQUEST_METHOD']=='HEAD'



abstract public *boolean*  **isDelete** ()

Checks whether HTTP method is DELETE. if $_SERVER['REQUEST_METHOD']=='DELETE'



abstract public *boolean*  **isOptions** ()

Checks whether HTTP method is OPTIONS. if $_SERVER['REQUEST_METHOD']=='OPTIONS'



abstract public *boolean*  **hasFiles** ([*boolean* $notErrored])

Checks whether request include attached files



abstract public :doc:`Phalcon\\Http\\Request\\FileInterface <Phalcon_Http_Request_FileInterface>` [] **getUploadedFiles** ([*boolean* $notErrored])

Gets attached files as Phalcon\\Http\\Request\\FileInterface compatible instances



abstract public *string*  **getHTTPReferer** ()

Gets web page that refers active request. ie: http://www.google.com



abstract public *array*  **getAcceptableContent** ()

Gets array with mime/types and their quality accepted by the browser/client from $_SERVER['HTTP_ACCEPT']



abstract public *array*  **getBestAccept** ()

Gets best mime/type accepted by the browser/client from $_SERVER['HTTP_ACCEPT']



abstract public *array*  **getClientCharsets** ()

Gets charsets array and their quality accepted by the browser/client from $_SERVER['HTTP_ACCEPT_CHARSET']



abstract public *string*  **getBestCharset** ()

Gets best charset accepted by the browser/client from $_SERVER['HTTP_ACCEPT_CHARSET']



abstract public *array*  **getLanguages** ()

Gets languages array and their quality accepted by the browser/client from $_SERVER['HTTP_ACCEPT_LANGUAGE']



abstract public *string*  **getBestLanguage** ()

Gets best language accepted by the browser/client from $_SERVER['HTTP_ACCEPT_LANGUAGE']



