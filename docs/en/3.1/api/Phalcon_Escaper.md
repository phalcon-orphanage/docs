# Class **Phalcon\\Escaper**

*implements* [Phalcon\EscaperInterface](/en/3.1.2/api/Phalcon_EscaperInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/escaper.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Escapes different kinds of text securing them. By using this component you may
prevent XSS attacks.

This component only works with UTF-8. The PREG extension needs to be compiled with UTF-8 support.

```php
<?php

$escaper = new \Phalcon\Escaper();

$escaped = $escaper->escapeCss("font-family: <Verdana>");

echo $escaped; // font\2D family\3A \20 \3C Verdana\3E

```


## Methods
public  **setEncoding** (*mixed* $encoding)

Sets the encoding to be used by the escaper

```php
<?php

$escaper->setEncoding("utf-8");

```



public  **getEncoding** ()

Returns the internal encoding used by the escaper



public  **setHtmlQuoteType** (*mixed* $quoteType)

Sets the HTML quoting type for htmlspecialchars

```php
<?php

$escaper->setHtmlQuoteType(ENT_XHTML);

```



public  **setDoubleEncode** (*mixed* $doubleEncode)

Sets the double_encode to be used by the escaper

```php
<?php

$escaper->setDoubleEncode(false);

```



final public  **detectEncoding** (*mixed* $str)

Detect the character encoding of a string to be handled by an encoder
Special-handling for chr(172) and chr(128) to chr(159) which fail to be detected by mb_detect_encoding()



final public  **normalizeEncoding** (*mixed* $str)

Utility to normalize a string's encoding to UTF-32.



public  **escapeHtml** (*mixed* $text)

Escapes a HTML string. Internally uses htmlspecialchars



public  **escapeHtmlAttr** (*mixed* $attribute)

Escapes a HTML attribute string



public  **escapeCss** (*mixed* $css)

Escape CSS strings by replacing non-alphanumeric chars by their hexadecimal escaped representation



public  **escapeJs** (*mixed* $js)

Escape javascript strings by replacing non-alphanumeric chars by their hexadecimal escaped representation



public  **escapeUrl** (*mixed* $url)

Escapes a URL. Internally uses rawurlencode



