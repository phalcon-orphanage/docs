Class **Phalcon\\Http\\Cookie**
===============================

*implements* :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`

Provide OO wrappers to manage a HTTP cookie


Methods
-------

public  **__construct** (*unknown* $name, [*unknown* $value], [*unknown* $expire], [*unknown* $path], [*unknown* $secure], [*unknown* $domain], [*unknown* $httpOnly])

Phalcon\\Http\\Cookie constructor



public  **setDI** (*unknown* $dependencyInjector)

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the internal dependency injector



public :doc:`Phalcon\\Http\\Cookie <Phalcon_Http_Cookie>`  **setValue** (*unknown* $value)

Sets the cookie's value



public *mixed*  **getValue** ([*unknown* $filters], [*unknown* $defaultValue])

Returns the cookie's value



public :doc:`Phalcon\\Http\\Cookie <Phalcon_Http_Cookie>`  **send** ()

Sends the cookie to the HTTP client Stores the cookie definition in session



public :doc:`Phalcon\\Http\\Cookie <Phalcon_Http_Cookie>`  **restore** ()

Reads the cookie-related info from the SESSION to restore the cookie as it was set This method is automatically called internally so normally you don't need to call it



public  **delete** ()

Deletes the cookie by setting an expire time in the past



public :doc:`Phalcon\\Http\\Cookie <Phalcon_Http_Cookie>`  **useEncryption** (*unknown* $useEncryption)

Sets if the cookie must be encrypted/decrypted automatically



public *boolean*  **isUsingEncryption** ()

Check if the cookie is using implicit encryption



public :doc:`Phalcon\\Http\\Cookie <Phalcon_Http_Cookie>`  **setExpiration** (*unknown* $expire)

Sets the cookie's expiration time



public *string*  **getExpiration** ()

Returns the current expiration time



public :doc:`Phalcon\\Http\\Cookie <Phalcon_Http_Cookie>`  **setPath** (*unknown* $path)

Sets the cookie's expiration time



public *string*  **getName** ()

Returns the current cookie's name



public *string*  **getPath** ()

Returns the current cookie's path



public :doc:`Phalcon\\Http\\Cookie <Phalcon_Http_Cookie>`  **setDomain** (*unknown* $domain)

Sets the domain that the cookie is available to



public *string*  **getDomain** ()

Returns the domain that the cookie is available to



public :doc:`Phalcon\\Http\\Cookie <Phalcon_Http_Cookie>`  **setSecure** (*unknown* $secure)

Sets if the cookie must only be sent when the connection is secure (HTTPS)



public *boolean*  **getSecure** ()

Returns whether the cookie must only be sent when the connection is secure (HTTPS)



public :doc:`Phalcon\\Http\\Cookie <Phalcon_Http_Cookie>`  **setHttpOnly** (*unknown* $httpOnly)

Sets if the cookie is accessible only through the HTTP protocol



public *boolean*  **getHttpOnly** ()

Returns if the cookie is accessible only through the HTTP protocol



public *string*  **__toString** ()

Magic __toString method converts the cookie's value to string



