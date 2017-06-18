# Class **Phalcon\\Http\\Response\\Headers**

*implements* [Phalcon\Http\Response\HeadersInterface](/en/3.1.2/api/Phalcon_Http_Response_HeadersInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/http/response/headers.zep" class="btn btn-default btn-sm">Source on GitHub</a>

This class is a bag to manage the response headers


## Methods
public  **set** (*mixed* $name, *mixed* $value)

Sets a header to be sent at the end of the request



public  **get** (*mixed* $name)

Gets a header value from the internal bag



public  **setRaw** (*mixed* $header)

Sets a raw header to be sent at the end of the request



public  **remove** (*mixed* $header)

Removes a header to be sent at the end of the request



public  **send** ()

Sends the headers to the client



public  **reset** ()

Reset set headers



public  **toArray** ()

Returns the current headers as an array



public static  **__set_state** (*array* $data)

Restore a \\Phalcon\\Http\\Response\\Headers object



