Interface **Phalcon\\Http\\Response\\CookiesInterface**
=======================================================

Phalcon\\Http\\Response\\CookiesInterface initializer


Methods
---------

abstract public :doc:`Phalcon\\Http\\Response\\CookiesInterface <Phalcon_Http_Response_CookiesInterface>`  **useEncryption** (*boolean* $useEncryption)

Set if cookies in the bag must be automatically encrypted/decrypted



abstract public *boolean*  **isUsingEncryption** ()

Returns if the bag is automatically encrypting/decrypting cookies



abstract public :doc:`Phalcon\\Http\\Response\\CookiesInterface <Phalcon_Http_Response_CookiesInterface>`  **set** (*string* $name, [*mixed* $value], [*int* $expire], [*string* $path], [*boolean* $secure], [*boolean* $httpOnly])

Sets a cookie to be sent at the end of the request



abstract public :doc:`Phalcon\\Http\\Cookie <Phalcon_Http_Cookie>`  **get** (*string* $name)

Gets a cookie from the bag



abstract public *boolean*  **send** ()

Sends the cookies to the client



abstract public :doc:`Phalcon\\Http\\Response\\CookiesInterface <Phalcon_Http_Response_CookiesInterface>`  **reset** ()

Reset set cookies



