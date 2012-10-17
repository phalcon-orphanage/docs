Class **Phalcon\\Escaper**
==========================

Escapes different kinds of text securing them


Methods
---------

public  **setEnconding** (*string* $encoding)

Sets the encoding to be used by the escaper



public *string*  **getEncoding** ()

Returns the internal encoding used by the escaper



public *string*  **escapeHtml** (*string* $text)

Escapes a HTML string. Internally uses htmlspeciarchars



public  **escapeHtmlAttr** (*unknown* $text)

...


public *string*  **escapeUrl** (*string* $url)

Escapes a URL. Internally uses rawurlencode



