---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Http\CookieInterface'
---
# Interface **Phalcon\Http\CookieInterface**

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/cookieinterface.zep)

## 方法

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

abstract public **getName** ()

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