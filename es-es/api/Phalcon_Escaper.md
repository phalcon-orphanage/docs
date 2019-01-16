* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Escaper'

* * *

# Class **Phalcon\Escaper**

*implements* [Phalcon\EscaperInterface](Phalcon_EscaperInterface)

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/escaper.zep" class="btn btn-default btn-sm">Código fuente en GitHub</a>

Escapa diferentes tipos de textos haciéndolos seguros. Mediante el uso de este componente puede prevenir ataques XSS.

Este componente sólo funciona con UTF-8. La extensión PREG debe compilarse con soporte UTF-8.

```php
<?php

$escaper = new \Phalcon\Escaper();

$escaped = $escaper->escapeCss("font-family: <Verdana>");

echo $escaped; // font\2D family\3A \20 \3C Verdana\3E

```

## Métodos

public **setEncoding** (*mixed* $encoding)

Establece la codificación para ser utilizada por el escaper

```php
<?php

$escaper->setEncoding("utf-8");

```

public **getEncoding** ()

Devuelve la codificación interna utilizada por el escaper

public **setHtmlQuoteType** (*mixed* $quoteType)

Establece el tipo de comillas HTML para ser utilizadas en htmlspecialchars

```php
<?php

$escaper->setHtmlQuoteType(ENT_XHTML);

```

public **setDoubleEncode** (*mixed* $doubleEncode)

Establece el double_encode para ser utilizado por el escaper

```php
<?php

$escaper->setDoubleEncode(false);

```

final public **detectEncoding** (*mixed* $str)

Detecta la codificación de caracteres de una cadena para ser manejada por un codificador de Manejo especial para chr(172) y chr(128) a chr(159) que no pueden ser detectados por mb_detect_encoding()

final public **normalizeEncoding** (*mixed* $str)

Utilidad para normalizar una cadena de codificación a UTF-32.

public **escapeHtml** (*mixed* $text)

Escapa una cadena HTML. Internamente utiliza htmlspecialchars

public **escapeHtmlAttr** (*mixed* $attribute)

Escapa una cadena de atributo HTML

public **escapeCss** (*mixed* $css)

Escape cadenas de CSS sustituyendo caracteres no alfanuméricos por su representación hexadecimal

public **escapeJs** (*mixed* $js)

Escapa cadenas de javascript mediante la sustitución de caracteres no alfanuméricos por su representación hexadecimal

public **escapeUrl** (*mixed* $url)

Escapa a una dirección URL. Internamente utiliza rawurlencode