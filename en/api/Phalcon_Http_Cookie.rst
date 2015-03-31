Class **Phalcon\\Http\\Cookie**
===============================

*implements* :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`

Provide OO wrappers to manage a HTTP cookie


Methods
-------

public  **__construct** (*string* $name, [*mixed* $value], [*int* $expire], [*string* $path], [*boolean* $secure], [*string* $domain], [*boolean* $httpOnly])

Phalcon\\Http\\Cookie constructor



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the internal dependency injector



public *Phalcon\\Http\\CookieInterface*  **setValue** (*string* $value)

Sets the cookie's value



public *mixed*  **getValue** ([*string|array* $filters], [*string* $defaultValue])

Returns the cookie's value



public :doc:`Phalcon\\Http\\Cookie <Phalcon_Http_Cookie>`  **send** ()

Sends the cookie to the HTTP client Stores the cookie definition in session



public :doc:`Phalcon\\Http\\Cookie <Phalcon_Http_Cookie>`  **restore** ()

Reads the cookie-related info from the SESSION to restore the cookie as it was set This method is automatically called internally so normally you don't need to call it



public  **delete** ()

Deletes the cookie by setting an expire time in the past



public :doc:`Phalcon\\Http\\Cookie <Phalcon_Http_Cookie>`  **useEncryption** (*boolean* $useEncryption)

Sets if the cookie must be encrypted/decrypted automatically



public *boolean*  **isUsingEncryption** ()

Check if the cookie is using implicit encryption



public :doc:`Phalcon\\Http\\Cookie <Phalcon_Http_Cookie>`  **setExpiration** (*int* $expire)

Sets the cookie's expiration time



public *string*  **getExpiration** ()

Returns the current expiration time



public :doc:`Phalcon\\Http\\Cookie <Phalcon_Http_Cookie>`  **setPath** (*string* $path)

Sets the cookie's path



public *string*  **getPath** ()

Returns the current cookie's path



public :doc:`Phalcon\\Http\\Cookie <Phalcon_Http_Cookie>`  **setDomain** (*string* $domain)

Sets the domain that the cookie is available to



public *string*  **getDomain** ()

Returns the domain that the cookie is available to



public :doc:`Phalcon\\Http\\Cookie <Phalcon_Http_Cookie>`  **setSecure** (*boolean* $secure)

Sets if the cookie must only be sent when the connection is secure (HTTPS)



public *boolean*  **getSecure** ()

Returns whether the cookie must only be sent when the connection is secure (HTTPS)



public :doc:`Phalcon\\Http\\Cookie <Phalcon_Http_Cookie>`  **setHttpOnly** (*boolean* $httpOnly)

Sets if the cookie is accessible only through the HTTP protocol



public *boolean*  **getHttpOnly** ()

Returns if the cookie is accessible only through the HTTP protocol



public *mixed*  **__toString** ()

Magic __toString method converts the cookie's value to string



