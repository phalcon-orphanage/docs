Class **Phalcon\\Escaper**
==========================

*implements* :doc:`Phalcon\\EscaperInterface <Phalcon_EscaperInterface>`

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

.. code-block:: php

    <?php

     $escaper->setEncoding('utf-8');




public *string*  **getEncoding** ()

Returns the internal encoding used by the escaper



public  **setHtmlQuoteType** (*int* $quoteType)

Sets the HTML quoting type for htmlspecialchars 

.. code-block:: php

    <?php

     $escaper->setHtmlQuoteType(ENT_XHTML);




public *string*  **detectEncoding** (*string* $str)

Detect the character encoding of a string to be handled by an encoder Special-handling for chr(172) and chr(128) to chr(159) which fail to be detected by mb_detect_encoding()



public *string*  **normalizeEncoding** (*string* $str)

Utility to normalize a string's encoding to UTF-32.



public *string*  **escapeHtml** (*string* $text)

Escapes a HTML string. Internally uses htmlspeciarchars



public *string*  **escapeHtmlAttr** (*string* $attribute)

Escapes a HTML attribute string



public *string*  **escapeCss** (*string* $css)

Escape CSS strings by replacing non-alphanumeric chars by their hexadecimal escaped representation



public *string*  **escapeJs** (*string* $js)

Escape javascript strings by replacing non-alphanumeric chars by their hexadecimal escaped representation



public *string*  **escapeUrl** (*string* $url)

Escapes a URL. Internally uses rawurlencode



