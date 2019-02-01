---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Http\Cookie'
---
# Class **Phalcon\Http\Cookie**

*implements* [Phalcon\Http\CookieInterface](Phalcon_Http_CookieInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/cookie.zep)

Provide OO wrappers to manage a HTTP cookie

## Metodlar

public **__construct** (*string* $name, [*mixed* $value], [*int* $expire], [*string* $path], [*boolean* $secure], [*string* $domain], [*boolean* $httpOnly])

Phalcon\Http\Cookie constructor

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Bağımlılık enjektörünü ayarlar

public **getDI** ()

Returns the internal dependency injector

public [Phalcon\Http\Cookie](Phalcon_Http_Cookie) **setValue** (*string* $value)

Çerezin değerini ayarlar

public *mixed* **getValue** ([*string* | *array* $filters], [*string* $defaultValue])

Çerezin değerini döndürür

public **send** ()

Çerezi HTTP istemcisine gönderir Çerez tanımını oturuma kaydeder

public **restore** ()

Reads the cookie-related info from the SESSION to restore the cookie as it was set This method is automatically called internally so normally you don't need to call it

public **delete** ()

Çerezi geçmişte dolma süresi belirleyerek siler

public **setSignKey** (*string* $signKey = null): [Phalcon\Http\CookieInterface](Phalcon_Http_CookieInterface)

Sets the cookie's sign key. The `$signKey` MUST be at least 32 characters long and generated using a cryptographically secure pseudo random generator.

You can use `null` to disable cookie signing.

See: [Phalcon\Security\Random](Phalcon_Security_Random) Throws: [Phalcon\Http\Cookie\Exception](Phalcon_Http_Cookie_Exception)

public **useEncryption** (*mixed* $useEncryption)

Sets if the cookie must be encrypted/decrypted automatically

public **isUsingEncryption** ()

Çerezin örtülü şifreleme kullanıp kullanmadığını kontrol edin

public **setExpiration** (*mixed* $expire)

Çerezin son kullanma süresini ayarlar

public **getExpiration** ()

Geçerli son kullanma süresini döndürür

public **setPath** (*mixed* $path)

Çerezin son kullanma süresini ayarlar

herkese açık ** isim al** ()

Geçerli çerezin adını döndürür

public **getPath** ()

Geçerli çerezin yolunu döndürür

public **setDomain** (*mixed* $domain)

Çerezin mevcut olduğu alan adını ayarlar

public **getDomain** ()

Çerezin mevcut olduğu alan adını döndürür

public **setSecure** (*mixed* $secure)

Çerezin yalnızca bağlantı güvenli olduğunda gönderileceğini ayarlar (HTTPS)

public **getSecure** ()

Çerezin yalnızca bağlantı güvenli olduğunda gönderilmesi gerekip gerekmediğini döndürür (HTTPS)

public **setHttpOnly** (*mixed* $httpOnly)

Çereze yalnızca HTTP protokolü aracılığıyla erişilebilir olup olmadığını ayarlar

public **getHttpOnly** ()

Tanımlama bilgisine yalnızca HTTP protokolü aracılığıyla erişilebiliyorsa döner

herkese açık **__ sırala** ()

Magic __toString method converts the cookie's value to string