---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Http\Response\Cookies'
---
# Class **Phalcon\Http\Response\Cookies**

*implements* [Phalcon\Http\Response\CookiesInterface](Phalcon_Http_Response_CookiesInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/http/response/cookies.zep)

Bu sınıf, çerezleri yönetmek için bir çantadır Çerez çantası, 'yanıt' hizmetinin bir parçası olarak otomatik olarak DI'ya kaydedilir

## Metodlar

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Bağımlılık enjektörünü ayarlar

public **getDI** ()

Returns the internal dependency injector

public **setSignKey** (*string* $signKey = null): [Phalcon\Http\CookieInterface](Phalcon_Http_CookieInterface)

Sets the cookie's sign key. The `$signKey` MUST be at least 32 characters long and generated using a cryptographically secure pseudo random generator.

You can use `null` to disable cookie signing.

See: [Phalcon\Security\Random](Phalcon_Security_Random) Throws: [Phalcon\Http\Cookie\Exception](Phalcon_Http_Cookie_Exception)

public **useEncryption** (*mixed* $useEncryption)

Çantadaki çerezlerin otomatik olarak şifrelenmesi/şifrelerin çözülmesi gerekiyorsa ayarlayın

public **isUsingEncryption** ()

Returns if the bag is automatically encrypting/decrypting cookies

public **set** (*mixed* $name, [*mixed* $value], [*mixed* $expire], [*mixed* $path], [*mixed* $secure], [*mixed* $domain], [*mixed* $httpOnly])

İsteğin sonunda gönderilecek bir çerez bilgisi belirler. Bu yöntem, daha önce aynı adla ayarlanmış tüm tanımlama bilgilerini geçersiz kılar

public **get** (*mixed* $name)

Çantadan bir çerez alır

public **has** (*mixed* $name)

Check if a cookie is defined in the bag or exists in the _COOKIE superglobal

public **delete** (*mixed* $name)

Bir tanımlama bilgilerini adıyla siler Bu yöntem, tanımlama bilgilerini _COOKIE süper küreselinden kaldırmaz

public **send** ()

Çerezleri müşteriye gönderir Mevcut talebin üstbilgileri gönderilirse çerezler gönderilmez

public **reset** ()

Ayarlanmış çerezleri sıfırla