* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Http\RequestInterface'

* * *

# Interface **Phalcon\Http\RequestInterface**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/http/requestinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>

## Methods

abstract public **get** ([*mixed* $name], [*mixed* $filters], [*mixed* $defaultValue])

...

abstract public **getPost** ([*mixed* $name], [*mixed* $filters], [*mixed* $defaultValue])

...

abstract public **getQuery** ([*mixed* $name], [*mixed* $filters], [*mixed* $defaultValue])

...

abstract public **getServer** (*mixed* $name)

...

abstract public **has** (*mixed* $name)

...

abstract public **hasPost** (*mixed* $name)

...

abstract public **hasPut** (*mixed* $name)

...

abstract public **hasQuery** (*mixed* $name)

...

abstract public **hasServer** (*mixed* $name)

...

abstract public **getHeader** (*mixed* $header)

...

abstract public **getScheme** ()

...

abstract public **isAjax** ()

...

abstract public **isSoapRequested** ()

...

abstract public **isSecureRequest** ()

...

abstract public **getRawBody** ()

...

abstract public **getServerAddress** ()

...

abstract public **getServerName** ()

...

abstract public **getHttpHost** ()

...

abstract public **getPort** ()

...

abstract public **getClientAddress** ([*mixed* $trustForwardedHeader])

...

abstract public **getMethod** ()

...

abstract public **getUserAgent** ()

...

abstract public **isMethod** (*mixed* $methods, [*mixed* $strict])

...

abstract public **isPost** ()

...

abstract public **isGet** ()

...

abstract public **isPut** ()

...

abstract public **isHead** ()

...

abstract public **isDelete** ()

...

abstract public **isOptions** ()

...

abstract public **isPurge** ()

...

abstract public **isTrace** ()

...

abstract public **isConnect** ()

...

abstract public **hasFiles** ([*mixed* $onlySuccessful])

...

abstract public **getUploadedFiles** ([*mixed* $onlySuccessful])

...

abstract public **getHTTPReferer** ()

...

abstract public **getAcceptableContent** ()

...

abstract public **getBestAccept** ()

...

abstract public **getClientCharsets** ()

...

abstract public **getBestCharset** ()

...

abstract public **getLanguages** ()

...

abstract public **getBestLanguage** ()

...

abstract public **getBasicAuth** ()

...

abstract public **getDigestAuth** ()

...