---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Http\Response\Headers'
---
# Class **Phalcon\Http\Response\Headers**

*implements* [Phalcon\Http\Response\HeadersInterface](Phalcon_Http_Response_HeadersInterface)

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/response/headers.zep)

Esta clase es una bolsa o contenedor para administrar las cabeceras de la respuesta

## Métodos

public **set** (*mixed* $name, *mixed* $value)

Configura una cabecera que será enviada al final de una solicitud

public **get** (*mixed* $name)

Obtiene el valor de una cabecera desde la bolsa interna

public **setRaw** (*mixed* $header)

Establece una cabecera sin procesar que será enviada al final de la solicitud

public **remove** (*mixed* $header)

Elimina una cabecera que será enviada al final de la solicitud

public **send** ()

Envía las cabeceras al cliente

public **reset** ()

Restablece las cabeceras configuradas

public **toArray** ()

Devuelve las cabeceras actuales como un arreglo

public static **__set_state** (*array* $data)

Restore a \Phalcon\Http\Response\Headers object