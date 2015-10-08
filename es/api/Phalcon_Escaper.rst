Class **Phalcon\\Escaper**
==========================

*implements* :doc:`Phalcon\\EscaperInterface <Phalcon_EscaperInterface>`

Escapes different kinds of text securing them. By using this component you may prevent XSS attacks.  This component only works with UTF-8. The PREG extension needs to be compiled with UTF-8 support.  

.. code-block:: php

    <?php

    $escaper = new \Phalcon\Escaper();
    $escaped = $escaper->escapeCss("font-family: <Verdana>");
    echo $escaped; // font\2D family\3A \20 \3C Verdana\3E



Methods
-------

public  **setEncoding** (*unknown* $encoding)

Sets the encoding to be used by the escaper 

.. code-block:: php

    <?php

     $escaper->setEncoding('utf-8');




public  **getEncoding** ()

Returns the internal encoding used by the escaper



public  **setHtmlQuoteType** (*unknown* $quoteType)

Sets the HTML quoting type for htmlspecialchars 

.. code-block:: php

    <?php

     $escaper->setHtmlQuoteType(ENT_XHTML);




final public  **detectEncoding** (*unknown* $str)

Detect the character encoding of a string to be handled by an encoder Special-handling for chr(172) and chr(128) to chr(159) which fail to be detected by mb_detect_encoding()



final public  **normalizeEncoding** (*unknown* $str)

Utility to normalize a string's encoding to UTF-32.



public  **escapeHtml** (*unknown* $text)

Escapes a HTML string. Internally uses htmlspecialchars



public  **escapeHtmlAttr** (*unknown* $attribute)

Escapes a HTML attribute string



public  **escapeCss** (*unknown* $css)

Escape CSS strings by replacing non-alphanumeric chars by their hexadecimal escaped representation



public  **escapeJs** (*unknown* $js)

Escape javascript strings by replacing non-alphanumeric chars by their hexadecimal escaped representation



public  **escapeUrl** (*unknown* $url)

Escapes a URL. Internally uses rawurlencode



