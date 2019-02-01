---
layout: article
language: 'fa-ir'
version: '4.0'
title: 'Phalcon\Http\CookieInterface'
---
# Interface **Phalcon\Http\CookieInterface**

[سورس کد در گیت هاب](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/cookieinterface.zep)

## روش ها

abstract public **setValue** (*mixed* $value)

...

abstract public **getValue** ([*mixed* $filters], [*mixed* $defaultValue])

...

abstract public **send** ()

...

abstract public **delete** ()

...

abstract public **useEncryption** (*mixed* $useEncryption)

...

abstract public **isUsingEncryption** ()

...

abstract public **setExpiration** (*mixed* $expire)

...

abstract public **getExpiration** ()

...

abstract public **setPath** (*mixed* $path)

...

عمومی انتزاعی **دریافت نام** ()

...

abstract public **getPath** ()

...

abstract public **setDomain** (*mixed* $domain)

...

abstract public **getDomain** ()

...

abstract public **setSecure** (*mixed* $secure)

...

abstract public **getSecure** ()

...

abstract public **setHttpOnly** (*mixed* $httpOnly)

...

abstract public **getHttpOnly** ()

...