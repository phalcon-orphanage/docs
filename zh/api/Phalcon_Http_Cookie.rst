Class **Phalcon\\Http\\Cookie**
===============================

*implements* :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`

Provide OO wrappers to manage a HTTP cookie


Methods
---------

public  **__construct** (*string* $name, *mixed* $value, *int* $expire, *string* $path)

Phalcon\\Http\\Cookie constructor



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the internal dependency injector



public :doc:`Phalcon\\Http\\CookieInterface <Phalcon_Http_CookieInterface>`  **setValue** (*string* $value)

Sets the cookie's value



public *mixed*  **getValue** (*unknown* $filters, *unknown* $defaultValue)

Returns the cookie's value



public :doc:`Phalcon\\Http\\Cookie <Phalcon_Http_Cookie>`  **setExpiration** (*int* $expire)

Sets the cookie's expiration time



public *string*  **getExpiration** ()

Returns the current expiration time



public :doc:`Phalcon\\Http\\Cookie <Phalcon_Http_Cookie>`  **setPath** (*unknown* $path)

Sets the cookie's expiration time



public *string*  **getPath** ()

Returns the current cookie's path



public :doc:`Phalcon\\Http\\Cookie <Phalcon_Http_Cookie>`  **setSecure** (*boolean* $secure)

Sets if the cookie must only be sent when the connection is secure (HTTPS)



public *boolean*  **getSecure** ()

Returns whether the cookie must only be sent when the connection is secure (HTTPS)



