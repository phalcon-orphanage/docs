---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Http\Response\Headers'
---
# Class **Phalcon\Http\Response\Headers**

*implements* [Phalcon\Http\Response\HeadersInterface](Phalcon_Http_Response_HeadersInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/response/headers.zep)

This class is a bag to manage the response headers

## Metodlar

public **set** (*mixed* $name, *mixed* $value)

İsteğin sonunda gönderilecek bir başlık belirler

public **get** (*mixed* $name)

Dahili çantadan bir başlık değeri alır

public **setRaw** (*mixed* $header)

İsteğin sonunda gönderilecek ham bir başlık ayarlar

public **remove** (*mixed* $header)

Removes a header to be sent at the end of the request

public **send** ()

Başlıkları istemciye gönderir

public **reset** ()

Ayarlanmış üst bilgileri sıfırla

public **toArray** ()

Geçerli başlıkları bir dizi olarak döndürür

public static **__set_state** (*array* $data)

Restore a \Phalcon\Http\Response\Headers object