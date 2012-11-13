Class **Phalcon\\Escaper**
==========================

*implements* Phalcon\EscaperInterface

Escapes different kinds of text securing them. By using this component you may prevent XSS attacks.  This component only works with UTF-8. The PREG extension needs to be compiled with UTF-8 support.  

.. code-block:: php

    <?php

     $escaper = new Phalcon\Escaper();
     $escaped = $escaper->escapeCss("font-family: <Verdana>");
     echo $escaped; // font\2D family\3A \20 \3C Verdana\3E



Methods
---------

public  **setEnconding** (*string* $encoding)

Sets the encoding to be used by the escaper



public *string*  **getEncoding** ()

Returns the internal encoding used by the escaper



public  **setHtmlQuoteType** (*int* $quoteType)

Sets the HTML quoting type for htmlspecialchars



public *string*  **escapeHtml** (*string* $text)

Escapes a HTML string. Internally uses htmlspeciarchars



public *string*  **escapeHtmlAttr** (*string* $text)

Escapes a HTML attribute string



public *string*  **cssSanitize** (*array* $matches)

Sanitizes CSS strings converting non-alphanumeric chars to their hexadecimal representation



public  **escapeCss** (*string* $css)

Escape CSS strings by replacing non-alphanumeric chars by their hexadecimal representation



public *string*  **escapeUrl** (*string* $url)

Escapes a URL. Internally uses rawurlencode



