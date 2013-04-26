Class **Phalcon\\Http\\Response\\Cookies**
==========================================

*implements* :doc:`Phalcon\\DI\\InjectionAwareInterface <Phalcon_DI_InjectionAwareInterface>`

This class is a bag to manage the cookies A cookies bag is automatically registered as part of the 'response' service in the DI


Methods
---------

public  **setDI** (:doc:`Phalcon\\DiInterface <Phalcon_DiInterface>` $dependencyInjector)

Sets the dependency injector



public :doc:`Phalcon\\DiInterface <Phalcon_DiInterface>`  **getDI** ()

Returns the internal dependency injector



public :doc:`Phalcon\\Http\\Response\\Cookies <Phalcon_Http_Response_Cookies>`  **set** (*string* $name, [*mixed* $value], [*int* $expire], [*string* $path])

Sets a cookie to be sent at the end of the request This method overrides any cookie set before with the same name



public :doc:`Phalcon\\Http\\Cookie <Phalcon_Http_Cookie>`  **get** (*string* $name)

Gets a cookie from the bag



public *boolean*  **send** ()

Sends the cookies to the client



public :doc:`Phalcon\\Http\\Response\\Cookies <Phalcon_Http_Response_Cookies>`  **reset** ()

Reset set cookies



