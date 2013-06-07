Interface **Phalcon\\EscaperInterface**
=======================================

Phalcon\\EscaperInterface initializer


Methods
---------

abstract public  **setEncoding** (*string* $encoding)

Sets the encoding to be used by the escaper



abstract public *string*  **getEncoding** ()

Returns the internal encoding used by the escaper



abstract public  **setHtmlQuoteType** (*int* $quoteType)

Sets the HTML quoting type for htmlspecialchars



abstract public *string*  **escapeHtml** (*string* $text)

Escapes a HTML string



abstract public *string*  **escapeHtmlAttr** (*unknown* $attribute)

Escapes a HTML attribute string



abstract public *string*  **escapeCss** (*string* $css)

Escape CSS strings by replacing non-alphanumeric chars by their hexadecimal representation



abstract public *string*  **escapeJs** (*string* $js)

Escape Javascript strings by replacing non-alphanumeric chars by their hexadecimal representation



abstract public *string*  **escapeUrl** (*string* $url)

Escapes a URL. Internally uses rawurlencode



