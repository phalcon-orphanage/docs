Class **Phalcon\\Http\\Cookie**
===============================

*implements* :doc:`Phalcon\\Http\\CookieInterface <Phalcon_Http_CookieInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/http/cookie.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Provide OO wrappers to manage a HTTP cookie


Methods
-------

public  **__construct** (*string* $name, [*mixed* $value], [*int* $expire], [*string* $path], [*boolean* $secure], [*string* $domain], [*boolean* $httpOnly])

Phalcon\\Http\\Cookie constructor



public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the dependency injector



public  **getDI** ()

Returns the internal dependency injector



public :doc:`Phalcon\\Http\\Cookie <Phalcon_Http_Cookie>` **setValue** (*string* $value)

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



