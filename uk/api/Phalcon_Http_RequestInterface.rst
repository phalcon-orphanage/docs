Interface **Phalcon\\Http\\RequestInterface**
=============================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/http/requestinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Methods
-------

abstract public  **get** ([*unknown* $name], [*unknown* $filters], [*unknown* $defaultValue])

...


abstract public  **getPost** ([*unknown* $name], [*unknown* $filters], [*unknown* $defaultValue])

...


abstract public  **getQuery** ([*unknown* $name], [*unknown* $filters], [*unknown* $defaultValue])

...


abstract public  **getServer** (*unknown* $name)

...


abstract public  **has** (*unknown* $name)

...


abstract public  **hasPost** (*unknown* $name)

...


abstract public  **hasPut** (*unknown* $name)

...


abstract public  **hasQuery** (*unknown* $name)

...


abstract public  **hasServer** (*unknown* $name)

...


abstract public  **getHeader** (*unknown* $header)

...


abstract public  **getScheme** ()

...


abstract public  **isAjax** ()

...


abstract public  **isSoapRequested** ()

...


abstract public  **isSecureRequest** ()

...


abstract public  **getRawBody** ()

...


abstract public  **getServerAddress** ()

...


abstract public  **getServerName** ()

...


abstract public  **getHttpHost** ()

...


abstract public  **getClientAddress** ([*unknown* $trustForwardedHeader])

...


abstract public  **getMethod** ()

...


abstract public  **getUserAgent** ()

...


abstract public  **isMethod** (*unknown* $methods, [*unknown* $strict])

...


abstract public  **isPost** ()

...


abstract public  **isGet** ()

...


abstract public  **isPut** ()

...


abstract public  **isHead** ()

...


abstract public  **isDelete** ()

...


abstract public  **isOptions** ()

...


abstract public  **hasFiles** ([*unknown* $onlySuccessful])

...


abstract public  **getUploadedFiles** ([*unknown* $onlySuccessful])

...


abstract public  **getHTTPReferer** ()

...


abstract public  **getAcceptableContent** ()

...


abstract public  **getBestAccept** ()

...


abstract public  **getClientCharsets** ()

...


abstract public  **getBestCharset** ()

...


abstract public  **getLanguages** ()

...


abstract public  **getBestLanguage** ()

...


abstract public  **getBasicAuth** ()

...


abstract public  **getDigestAuth** ()

...


