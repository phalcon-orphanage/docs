# Class **Phalcon\\Http\\Response\\Cookies**

*implements* [Phalcon\Http\Response\CookiesInterface](/en/3.1.2/api/Phalcon_Http_Response_CookiesInterface), [Phalcon\Di\InjectionAwareInterface](/en/3.1.2/api/Phalcon_Di_InjectionAwareInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/http/response/cookies.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This class is a bag to manage the cookies
A cookies bag is automatically registered as part of the 'response' service in the DI


## Methods
public  **setDI** ([Phalcon\DiInterface](/en/3.1.2/api/Phalcon_DiInterface) $dependencyInjector)

Sets the dependency injector



public  **getDI** ()

Returns the internal dependency injector



public  **useEncryption** (*mixed* $useEncryption)

Set if cookies in the bag must be automatically encrypted/decrypted



public  **isUsingEncryption** ()

Returns if the bag is automatically encrypting/decrypting cookies



public  **set** (*mixed* $name, [*mixed* $value], [*mixed* $expire], [*mixed* $path], [*mixed* $secure], [*mixed* $domain], [*mixed* $httpOnly])

Sets a cookie to be sent at the end of the request
This method overrides any cookie set before with the same name



public  **get** (*mixed* $name)

Gets a cookie from the bag



public  **has** (*mixed* $name)

Check if a cookie is defined in the bag or exists in the _COOKIE superglobal



public  **delete** (*mixed* $name)

Deletes a cookie by its name
This method does not removes cookies from the _COOKIE superglobal



public  **send** ()

Sends the cookies to the client
Cookies aren't sent if headers are sent in the current request



public  **reset** ()

Reset set cookies



