Class **Phalcon\\Http\\Response\\Cookies**
==========================================

*implements* :doc:`Phalcon\\Http\\Response\\CookiesInterface <Phalcon_Http_Response_CookiesInterface>`, :doc:`Phalcon\\Di\\InjectionAwareInterface <Phalcon_Di_InjectionAwareInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/http/response/cookies.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

This class is a bag to manage the cookies A cookies bag is automatically registered as part of the 'response' service in the DI


Methods
-------

public  **setDI** (*unknown* $dependencyInjector)

Sets the dependency injector



public  **getDI** ()

Returns the internal dependency injector



public  **useEncryption** (*unknown* $useEncryption)

Set if cookies in the bag must be automatically encrypted/decrypted



public  **isUsingEncryption** ()

Returns if the bag is automatically encrypting/decrypting cookies



public  **set** (*unknown* $name, [*unknown* $value], [*unknown* $expire], [*unknown* $path], [*unknown* $secure], [*unknown* $domain], [*unknown* $httpOnly])

Sets a cookie to be sent at the end of the request This method overrides any cookie set before with the same name



public  **get** (*unknown* $name)

Gets a cookie from the bag



public  **has** (*unknown* $name)

Check if a cookie is defined in the bag or exists in the _COOKIE superglobal



public  **delete** (*unknown* $name)

Deletes a cookie by its name This method does not removes cookies from the _COOKIE superglobal



public  **send** ()

Sends the cookies to the client Cookies aren't sent if headers are sent in the current request



public  **reset** ()

Reset set cookies



