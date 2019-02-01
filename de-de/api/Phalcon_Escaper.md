---
layout: article
language: 'de-de'
version: '4.0'
title: 'Phalcon\Escaper'
---
# Class **Phalcon\Escaper**

*implements* [Phalcon\EscaperInterface](Phalcon_EscaperInterface)

[Quellcode auf GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/escaper.zep)

Escapes different kinds of text securing them. By using this component you may prevent XSS attacks.

This component only works with UTF-8. The PREG extension needs to be compiled with UTF-8 support.

```php
<?php

$escaper = new \Phalcon\Escaper();

$escaped = $escaper->escapeCss("font-family: <Verdana>");

echo $escaped; // font\2D family\3A \20 \3C Verdana\3E

```

## Methoden

public **setEncoding** (*mixed* $encoding)

Setzt die Codierung, welche vom Escaper verwendet werden soll

```php
<?php

$escaper->setEncoding("utf-8");

```

public **getEncoding** ()

Gibt die interne Codierung zurück, welche vom Escaper verwendet wird

public **setHtmlQuoteType** (*mixed* $quoteType)

Setzt den HTML-Zitierungstyp Typ für Htmlspecialchars

```php
<?php

$escaper->setHtmlQuoteType(ENT_XHTML);

```

public **setDoubleEncode** (*mixed* $doubleEncode)

Legt fest, ob der Escaper doppelt encodieren soll

```php
<?php

$escaper->setDoubleEncode(false);

```

final public **detectEncoding** (*mixed* $str)

Erkennt die Zeichencodierung einer Zeichenfolge, welche vom encoder behandelt werden soll Sonderbehandlung für chr(172) und chr(128), chr(159), die nicht durch mb_detect_encoding() nachgewiesen werden

final public **normalizeEncoding** (*mixed* $str)

Dienstprogramm zum normalisieren einer Zeichenfolge Kodierung nach UTF-32.

public **escapeHtml** (*mixed* $text)

Escapes a HTML string. Internally uses htmlspecialchars

public **escapeHtmlAttr** (*mixed* $attribute)

Maskiert einen HTML Eigenschafts-Zeichenfolge

public **escapeCss** (*mixed* $css)

Maskiert CSS-Zeichenfolgen indem nicht-alphanumerischen Zeichen ersetzen durch ihre hexadezimale Escapezeichen Darstellung ersetzt werden

public **escapeJs** (*mixed* $js)

Maskiert Javascript-Zeichenfolgen indem nicht-alphanumerischen Zeichen ersetzen durch ihre hexadezimale Escapezeichen Darstellung ersetzt werden

public **escapeUrl** (*mixed* $url)

Escapes a URL. Internally uses rawurlencode