Interface **Phalcon\\Http\\ResponseInterface**
==============================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/http/responseinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Methods
-------

abstract public  **setStatusCode** (*unknown* $code, [*unknown* $message])

...


abstract public  **getHeaders** ()

...


abstract public  **setHeader** (*unknown* $name, *unknown* $value)

...


abstract public  **setRawHeader** (*unknown* $header)

...


abstract public  **resetHeaders** ()

...


abstract public  **setExpires** (*unknown* $datetime)

...


abstract public  **setNotModified** ()

...


abstract public  **setContentType** (*unknown* $contentType, [*unknown* $charset])

...


abstract public  **redirect** ([*unknown* $location], [*unknown* $externalRedirect], [*unknown* $statusCode])

...


abstract public  **setContent** (*unknown* $content)

...


abstract public  **setJsonContent** (*unknown* $content)

...


abstract public  **appendContent** (*unknown* $content)

...


abstract public  **getContent** ()

...


abstract public  **sendHeaders** ()

...


abstract public  **sendCookies** ()

...


abstract public  **send** ()

...


abstract public  **setFileToSend** (*unknown* $filePath, [*unknown* $attachmentName])

...


