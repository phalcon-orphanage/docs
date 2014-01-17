Interface **Phalcon\\Http\\Response\\HeadersInterface**
=======================================================

Phalcon\\Http\\Response\\HeadersInterface initializer


Methods
-------

abstract public  **set** (*string* $name, *string* $value)

Sets a header to be sent at the end of the request



abstract public *string*  **get** (*string* $name)

Gets a header value from the internal bag



abstract public  **setRaw** (*string* $header)

Sets a raw header to be sent at the end of the request



abstract public *boolean*  **send** ()

Sends the headers to the client



abstract public  **reset** ()

Reset set headers



abstract public static :doc:`Phalcon\\Http\\Response\\HeadersInterface <Phalcon_Http_Response_HeadersInterface>`  **__set_state** (*array* $data)

Restore a Phalcon\\Http\\Response\\Headers object



