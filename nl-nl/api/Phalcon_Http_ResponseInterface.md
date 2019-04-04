---
layout: default
language: 'nl-nl'
version: '4.0'
title: 'Phalcon\Http\ResponseInterface'
---
# Interface **Phalcon\Http\ResponseInterface**

[Broncode op GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/responseinterface.zep)

## Methoden

abstract public **setStatusCode** (*mixed* $code, [*mixed* $message])

...

abstract public **getHeaders** ()

...

abstract public **setHeader** (*mixed* $name, *mixed* $value)

...

abstract public **setRawHeader** (*mixed* $header)

...

abstract public **resetHeaders** ()

...

abstract public **setExpires** ([DateTime](https://php.net/manual/en/class.datetime.php) $datetime)

...

abstract public **setNotModified** ()

...

abstract public **setContentType** (*mixed* $contentType, [*mixed* $charset])

...

abstract public **setContentLength** (*mixed* $contentLength)

...

abstract public **redirect** ([*mixed* $location], [*mixed* $externalRedirect], [*mixed* $statusCode])

...

abstract public **setContent** (*mixed* $content)

...

abstract public **setJsonContent** (*mixed* $content)

...

abstract public **appendContent** (*mixed* $content)

...

abstract public **getContent** ()

...

abstract public **sendHeaders** ()

...

abstract public **sendCookies** ()

...

abstract public **send** ()

...

abstract public **setFileToSend** (*mixed* $filePath, [*mixed* $attachmentName])

...