---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Escaper'
---
# Class **Phalcon\Escaper**

*implements* [Phalcon\EscaperInterface](Phalcon_EscaperInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/escaper.zep)

Escapes different kinds of text securing them. By using this component you may prevent XSS attacks.

This component only works with UTF-8. The PREG extension needs to be compiled with UTF-8 support.

```php
<?php

$escaper = new \Phalcon\Escaper();

$escaped = $escaper->escapeCss("font-family: <Verdana>");

echo $escaped; // font\2D family\3A \20 \3C Verdana\3E

```

## Metode

public **setEncoding** (*mixed* $encoding)

Mengeset pengkodean untuk digunakan oleh escaper

```php
<?php

$escaper->setEncoding("utf-8");

```

public **getEncoding** ()

Mengembalikan pengkodean internal yang digunakan oleh escaper

public **setHtmlQuoteType** (*mixed* $quoteType)

Menetapkan jenis kutipan HTML untuk htmlspecialchars

```php
<?php

$escaper->setHtmlQuoteType(ENT_XHTML);

```

public **setDoubleEncode** (*mixed* $doubleEncode)

Menetapkan double_encode untuk digunakan oleh escaper

```php
<?php

$escaper->setDoubleEncode(false);

```

final public **detectEncoding** (*mixed* $str)

Mendeteksi pengkodean karakter dari sebuah string untuk ditangani oleh pengkode Penanganan khusus untuk chr(172) dan chr(128) sampai dengan chr(159) yang gagal untuk dideteksi dengan mb_detect_encoding()

final public **normalizeEncoding** (*mixed* $str)

Utilitas untuk menormalisasi sebuah pengkodean string ke UTF-32.

public **escapeHtml** (*mixed* $text)

Escapes a HTML string. Internally uses htmlspecialchars

public **escapeHtmlAttr** (*mixed* $attribute)

Meloloskan sebuah string atribut HTML

public **escapeCss** (*mixed* $css)

Meloloskan string-string CSS dengan mengganti karakter non-alphanumeric dengan representasi nilai hexadecimalnya yang diloloskan

public **escapeJs** (*mixed* $js)

Meloloskan string-string javascript dengan mengganti karakter non-alphanumeric dengan representasi nilai hexadecimalnya yang diloloskan

public **escapeUrl** (*mixed* $url)

Escapes a URL. Internally uses rawurlencode