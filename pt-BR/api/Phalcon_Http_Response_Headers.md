---
layout: default
language: 'en'
version: '4.0'
title: 'Phalcon\Http\Response\Headers'
---
# Class **Phalcon\Http\Response\Headers**

*implements* [Phalcon\Http\Response\HeadersInterface](Phalcon_Http_Response_HeadersInterface)

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/response/headers.zep)

This class is a bag to manage the response headers

## Methods

public **set** (*mixed* $name, *mixed* $value)

Sets a header to be sent at the end of the request

public **get** (*mixed* $name)

Gets a header value from the internal bag

public **setRaw** (*mixed* $header)

Sets a raw header to be sent at the end of the request

public **remove** (*mixed* $header)

Removes a header to be sent at the end of the request

public **send** ()

Sends the headers to the client

public **reset** ()

Reset set headers

public **toArray** ()

Returns the current headers as an array

public static **__set_state** (*array* $data)

Restore a \Phalcon\Http\Response\Headers object