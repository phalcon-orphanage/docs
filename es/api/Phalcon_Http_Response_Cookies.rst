Class **Phalcon\\Http\\Response\\Cookies**
==========================================

*implements* :doc:`Phalcon\\Http\\Response\\CookiesInterface <Phalcon_Http_Response_CookiesInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`

This class is a bag to manage the cookies A cookies bag is automatically registered as part of the 'response' service in the DI


Methods
-------

public  **setDI** (*unknown* $dependencyInjector)

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the internal dependency injector



public :doc:`Phalcon\\Http\\Response\\Cookies <Phalcon_Http_Response_Cookies>`  **useEncryption** (*unknown* $useEncryption)

Set if cookies in the bag must be automatically encrypted/decrypted



public *boolean*  **isUsingEncryption** ()

Returns if the bag is automatically encrypting/decrypting cookies



public :doc:`Phalcon\\Http\\Response\\Cookies <Phalcon_Http_Response_Cookies>`  **set** (*unknown* $name, [*unknown* $value], [*unknown* $expire], [*unknown* $path], [*unknown* $secure], [*unknown* $domain], [*unknown* $httpOnly])

Sets a cookie to be sent at the end of the request This method overrides any cookie set before with the same name



public :doc:`Phalcon\\Http\\Cookie <Phalcon_Http_Cookie>`  **get** (*unknown* $name)

Gets a cookie from the bag



public *boolean*  **has** (*unknown* $name)

Check if a cookie is defined in the bag or exists in the _COOKIE superglobal



public *boolean*  **delete** (*unknown* $name)

Deletes a cookie by its name This method does not removes cookies from the _COOKIE superglobal



public *boolean*  **send** ()

Sends the cookies to the client Cookies aren't sent if headers are sent in the current request



public :doc:`Phalcon\\Http\\Response\\Cookies <Phalcon_Http_Response_Cookies>`  **reset** ()

Reset set cookies



