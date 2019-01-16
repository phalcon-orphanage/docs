---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Http\Cookie'
---
# Class **Phalcon\Http\Cookie**

*implements* [Phalcon\Http\CookieInterface](Phalcon_Http_CookieInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/http/cookie.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Provide OO wrappers to manage a HTTP cookie


## Methods
public  **__construct** (*string* $name, [*mixed* $value], [*int* $expire], [*string* $path], [*boolean* $secure], [*string* $domain], [*boolean* $httpOnly])

Phalcon\Http\Cookie constructor



public  **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Sets the dependency injector



public  **getDI** ()

Returns the internal dependency injector



public [Phalcon\Http\Cookie](Phalcon_Http_Cookie) **setValue** (*string* $value)

Sets the cookie's value



public *mixed* **getValue** ([*string* | *array* $filters], [*string* $defaultValue])

Returns the cookie's value



public  **send** ()

Sends the cookie to the HTTP client
Stores the cookie definition in session



public  **restore** ()

Reads the cookie-related info from the SESSION to restore the cookie as it was set
This method is automatically called internally so normally you don't need to call it



public  **delete** ()

Deletes the cookie by setting an expire time in the past



public **setSignKey** (*string* $signKey = null): [Phalcon\Http\CookieInterface](Phalcon_Http_CookieInterface)

Sets the cookie's sign key. The `$signKey` MUST be at least 32 characters long and generated using a cryptographically secure pseudo random generator.

You can use `null` to disable cookie signing.

See: [Phalcon\Security\Random](Phalcon_Security_Random)
Throws: [Phalcon\Http\Cookie\Exception](Phalcon_Http_Cookie_Exception)



public  **useEncryption** (*mixed* $useEncryption)

Sets if the cookie must be encrypted/decrypted automatically



public  **isUsingEncryption** ()

Check if the cookie is using implicit encryption



public  **setExpiration** (*mixed* $expire)

Sets the cookie's expiration time



public  **getExpiration** ()

Returns the current expiration time



public  **setPath** (*mixed* $path)

Sets the cookie's expiration time



public  **getName** ()

Returns the current cookie's name



public  **getPath** ()

Returns the current cookie's path



public  **setDomain** (*mixed* $domain)

Sets the domain that the cookie is available to



public  **getDomain** ()

Returns the domain that the cookie is available to



public  **setSecure** (*mixed* $secure)

Sets if the cookie must only be sent when the connection is secure (HTTPS)



public  **getSecure** ()

Returns whether the cookie must only be sent when the connection is secure (HTTPS)



public  **setHttpOnly** (*mixed* $httpOnly)

Sets if the cookie is accessible only through the HTTP protocol



public  **getHttpOnly** ()

Returns if the cookie is accessible only through the HTTP protocol



public  **__toString** ()

Magic __toString method converts the cookie's value to string



