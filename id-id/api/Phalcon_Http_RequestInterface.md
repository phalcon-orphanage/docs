---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Http\RequestInterface'
---
# Interface **Phalcon\Http\RequestInterface**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/requestinterface.zep)

## Metode

abstrak umum **get** ([*mixed* $name], [*mixed* $filters], [*mixed* $defaultValue])

...

abstrak umum **getPost** ([*mixed* $name], [*mixed* $filters], [*mixed* $defaultValue])

...

abstrak umum **getQuery** ([*mixed* $name], [*mixed* $filters], [*mixed* $defaultValue])

...

abstrak umu m **getServer** (*mixed* $name)

...

abstraksi umum **has** (*mixed* $name)

...

abstrak umum **hasPost** (*mixed* $name)

...

abstrak umum **hasPut** (*mixed* $name)

...

abstrak umum **hasQuery** (*mixed* $name)

...

abstrak umum **hasServer** (*mixed* $name)

...

abstrak umum **getHeader** (*mixed* $header)

...

abstrak umum **getScheme** ()

...

abstrak umum **isAjax** ()

...

abstrak umum **isSoapRequested** ()

...

abstrak umum **isSecureRequest** ()

...

abstrak umum **getRawBody** ()

...

abstrak publik **getServerAddress** ()

...

abstrak publik **getServerName** ()

...

abstrak publik **getHttpHost** ()

...

abstrak publik **getPort** ()

...

abstrak publik **getClientAddress** ([*mixed* $trustForwardedHeader])

...

abstrak publik **getMethod** ()

...

abstrak publik **getUserAgent** ()

...

abstrak publik **isMethod** (*mixed* $methods, [*mixed* $strict])

...

abstrak publik **isPost** ()

...

abstrak publik **isGet** ()

...

abstrak publik **isPut** ()

...

abstrak publik **isHead** ()

...

abstrak publik **isDelete** ()

...

abstrak publik **isOptions** ()

...

abstrak publik **isPurge** ()

...

abstrak publik **isTrace** ()

...

abstrak publik **isConnect** ()

...

abstrak publik **hasFiles** ([*mixed* $onlySuccessful])

...

abstrak publik **getUploadedFiles** ([*mixed* $onlySuccessful])

...

abstrak publik **getHTTPReferer** ()

...

abstrak publik **getAcceptableContent** ()

...

abstrak publik **getBestAccept** ()

...

abstrak publik **getClientCharsets** ()

...

abstrak publik **getBestCharset** ()

...

abstrak publik **getLanguages** ()

...

abstrak publik **getBestLanguage** ()

...

abstrak publik **getBasicAuth** ()

...

abstrak publik **getDigestAuth** ()

...