* * *

layout: article language: 'zh-cn' version: '4.0' title: 'Phalcon\Http\Response\CookiesInterface'

* * *

# Interface **Phalcon\Http\Response\CookiesInterface**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/http/response/cookiesinterface.zep" class="btn btn-default btn-sm">源码在GitHub</a>

## 方法

abstract public **useEncryption** (*mixed* $useEncryption)

...

abstract public **isUsingEncryption** ()

...

abstract public **set** (*mixed* $name, [*mixed* $value], [*mixed* $expire], [*mixed* $path], [*mixed* $secure], [*mixed* $domain], [*mixed* $httpOnly])

...

abstract public **get** (*mixed* $name)

...

abstract public **has** (*mixed* $name)

...

abstract public **delete** (*mixed* $name)

...

abstract public **send** ()

...

abstract public **reset** ()

...