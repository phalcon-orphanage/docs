* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Http\Response\Cookies'

* * *

# Class **Phalcon\Http\Response\Cookies**

*implements* [Phalcon\Http\Response\CookiesInterface](Phalcon_Http_Response_CookiesInterface), [Phalcon\Di\InjectionAwareInterface](Phalcon_Di_InjectionAwareInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/http/response/cookies.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This class is a bag to manage the cookies A cookies bag is automatically registered as part of the 'response' service in the DI

## Methods

public **setDI** ([Phalcon\DiInterface](Phalcon_DiInterface) $dependencyInjector)

Sets the dependency injector

public **getDI** ()

Returns the internal dependency injector

public **setSignKey** (*string* $signKey = null): [Phalcon\Http\CookieInterface](Phalcon_Http_CookieInterface)

Sets the cookie's sign key. The `$signKey` MUST be at least 32 characters long and generated using a cryptographically secure pseudo random generator.

You can use `null` to disable cookie signing.

See: [Phalcon\Security\Random](Phalcon_Security_Random) Throws: [Phalcon\Http\Cookie\Exception](Phalcon_Http_Cookie_Exception)

public **useEncryption** (*mixed* $useEncryption)

Set if cookies in the bag must be automatically encrypted/decrypted

public **isUsingEncryption** ()

Returns if the bag is automatically encrypting/decrypting cookies

public **set** (*mixed* $name, [*mixed* $value], [*mixed* $expire], [*mixed* $path], [*mixed* $secure], [*mixed* $domain], [*mixed* $httpOnly])

Sets a cookie to be sent at the end of the request This method overrides any cookie set before with the same name

public **get** (*mixed* $name)

Gets a cookie from the bag

public **has** (*mixed* $name)

Check if a cookie is defined in the bag or exists in the _COOKIE superglobal

public **delete** (*mixed* $name)

Deletes a cookie by its name This method does not removes cookies from the _COOKIE superglobal

public **send** ()

Sends the cookies to the client Cookies aren't sent if headers are sent in the current request

public **reset** ()

Reset set cookies