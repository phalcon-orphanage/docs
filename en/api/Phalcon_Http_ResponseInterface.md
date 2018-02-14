# Interface **Phalcon\\Http\\ResponseInterface**

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/http/responseinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>

## Methods
abstract public  **setStatusCode** (*mixed* $code, [*mixed* $message])

...

abstract public  **getHeaders** ()

...

abstract public  **setHeader** (*mixed* $name, *mixed* $value)

...

abstract public  **setRawHeader** (*mixed* $header)

...

abstract public  **resetHeaders** ()

...

abstract public  **setExpires** ([DateTime](http://php.net/manual/en/class.datetime.php) $datetime)

...

abstract public  **setNotModified** ()

...

abstract public  **setContentType** (*mixed* $contentType, [*mixed* $charset])

...

abstract public  **setContentLength** (*mixed* $contentLength)

...

abstract public  **redirect** ([*mixed* $location], [*mixed* $externalRedirect], [*mixed* $statusCode])

...

abstract public  **setContent** (*mixed* $content)

...

abstract public  **setJsonContent** (*mixed* $content)

...

abstract public  **appendContent** (*mixed* $content)

...

abstract public  **getContent** ()

...

abstract public  **sendHeaders** ()

...

abstract public  **sendCookies** ()

...

abstract public  **send** ()

...

abstract public  **setFileToSend** (*mixed* $filePath, [*mixed* $attachmentName])

...

