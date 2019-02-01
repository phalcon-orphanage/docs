---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Http\Cookie'
---
# Class **Phalcon\Http\Cookie**

*implements* [Phalcon\Http\CookieInterface](Phalcon_Http_CookieInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/cookie.zep)

提供面向对象包装器来管理 HTTP cookie

## 方法

public **__construct** (*string* $name, [*mixed* $value], [*int* $expire], [*string* $path], [*boolean* $secure], [*string* $domain], [*boolean* $httpOnly])

Phalcon\Http\Cookie constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

设置依赖注入器

public **getDI** ()

返回内部依赖注入器

public [Phalcon\Http\Cookie](Phalcon_Http_Cookie) **setValue** (*string* $value)

设置 cookie 的值

public *mixed* **getValue** ([*string* | *array* $filters], [*string* $defaultValue])

返回的 cookie 的值

public **send** ()

发送到 HTTP 客户端 cookie 在会话中存储的 cookie 定义

public **restore** ()

从会话恢复 cookie，因为它是设置此方法设置的 cookie 相关信息将自动在内部调用的读取所以通常你不需要调用它

public **delete** ()

删除 cookie 将过期时间设置在过去

public **setSignKey** (*string* $signKey = null): [Phalcon\Http\CookieInterface](Phalcon_Http_CookieInterface)

Sets the cookie's sign key. The `$signKey` MUST be at least 32 characters long and generated using a cryptographically secure pseudo random generator.

You can use `null` to disable cookie signing.

See: [Phalcon\Security\Random](Phalcon_Security_Random) Throws: [Phalcon\Http\Cookie\Exception](Phalcon_Http_Cookie_Exception)

public **useEncryption** (*mixed* $useEncryption)

如果该 cookie 必须加密/解密自动，设置

public **isUsingEncryption** ()

如果该 cookie 使用隐式加密检查

public **setExpiration** (*mixed* $expire)

设置 cookie 的过期时间

public **getExpiration** ()

返回当前的过期时间

public **setPath** (*mixed* $path)

设置 cookie 的过期时间

public **getName** ()

返回当前 cookie 的名称

public **getPath** ()

返回当前 cookie 路径

public **setDomain** (*mixed* $domain)

设置 cookie 是可用的域

public **getDomain** ()

返回的 cookie 是可用的域

public **setSecure** (*mixed* $secure)

如果安全 (HTTPS) 连接时，必须只有发送 cookie，设置

public **getSecure** ()

返回是否只必须发送 cookie 安全 (HTTPS) 连接时

public **setHttpOnly** (*mixed* $httpOnly)

如果该 cookie 是只能通过 HTTP 协议访问，设置

public **getHttpOnly** ()

返回如果 cookie 是只能通过 HTTP 协议访问

public **__toString** ()

神奇的 __toString 方法将 cookie 的值转换为字符串