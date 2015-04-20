Class **Phalcon\\Http\\Response\\Headers**
==========================================

*implements* :doc:`Phalcon\\Http\\Response\\HeadersInterface <Phalcon_Http_Response_HeadersInterface>`

This class is a bag to manage the response headers


Methods
-------

public  **set** (*unknown* $name, *unknown* $value)

Sets a header to be sent at the end of the request



public *string*  **get** (*unknown* $name)

Gets a header value from the internal bag



public  **setRaw** (*unknown* $header)

Sets a raw header to be sent at the end of the request



public  **remove** (*unknown* $header)

Removes a header to be sent at the end of the request



public *boolean*  **send** ()

Sends the headers to the client



public  **reset** ()

Reset set headers



public *array*  **toArray** ()

Returns the current headers as an array



public static :doc:`Phalcon\\Http\\Response\\Headers <Phalcon_Http_Response_Headers>`  **__set_state** (*unknown* $data)

Restore a Phalcon\\Http\\Response\\Headers object



