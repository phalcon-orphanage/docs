Class **Phalcon\\Http\\Response\\Headers**
==========================================

This class is a bag to manage the response headers


Methods
---------

public  **__construct** ()

Phalcon\\Http\\Response\\Headers constructor



public  **set** (*string* $name, *string* $value)

Sets a header to be sent at the end of the request



public *string*  **get** (*string* $name)

Gets a header value from the internal bag



public  **setRaw** (*string* $header)

Sets a raw header to be sent at the end of the request



public *boolean*  **send** ()

Sends the headers to the client



public  **reset** ()

Reset set headers



public static :doc:`Phalcon\\Http\\Response\\Headers <Phalcon_Http_Response_Headers>`  **__set_state** (*unknown* $data)

Restore a Phalcon\\Http\\Response\\Headers object



