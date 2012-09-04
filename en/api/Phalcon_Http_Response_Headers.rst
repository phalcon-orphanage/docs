Class **Phalcon\\Http\\Response\\Headers**
==========================================

Methods
---------

public **__construct** ()

public **set** (*string* $name, *string* $value)

Sets a header to be sent at the end of the request



*string* public **get** (*string* $name)

Sets a header value from the internal bag



public **setRaw** (*string* $header)

Sets a raw header to be sent at the end of the request



public **send** ()

Sends the headers to the client



public **reset** ()

Reset set headers



public static **__set_state** (*unknown* $data)

Restore a Phalcon\\Http\\Response\\Headers object



