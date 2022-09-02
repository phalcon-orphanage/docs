---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Escaper'
---

* [Phalcon\Escaper](#escaper)
* [Phalcon\Escaper\EscaperInterface](#escaper-escaperinterface)
* [Phalcon\Escaper\Exception](#escaper-exception)

<h1 id="escaper">Class Phalcon\Escaper</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Escaper.zep)

| Namespace | Phalcon | | Uses | Phalcon\Di\DiInterface, Phalcon\Escaper\EscaperInterface, Phalcon\Escaper\Exception | | Implements | EscaperInterface |

Phalcon\Escaper

Escapa diferentes tipos de texto asegurándolos. Al usar este componente puede prevenir ataques XSS.

Este componente sólo trabaja con UTF-8. La extensión PREG necesita ser compilada con el soporte UTF-8.

```php
$escaper = new \Phalcon\Escaper();

$escaped = $escaper->escapeCss("font-family: <Verdana>");

echo $escaped; // font\2D family\3A \20 \3C Verdana\3E
```

## Propiedades

```php
/**
 * @var bool
 */
protected doubleEncode = true;

/**
 * @var string
 */
protected encoding = utf-8;

/**
 * @var int
 */
protected flags = 3;

```

## Métodos

```php
public function attributes( string $attribute = null ): string;
```

Escapa una cadena de atributo HTML

```php
public function css( string $input ): string;
```

Escapa cadenas CSS reemplazando caracteres no alfanuméricos por su representación hexadecimal escapada

```php
final public function detectEncoding( string $str ): string | null;
```

Detecta la codificación de caracteres de una cadena a ser gestionada por un codificador. Gestión especial para chr(172) y chr(128) a chr(159) que fallan al ser detectados por mb_detect_encoding()

```php
public function escapeCss( string $css ): string;
```

Escapa cadenas CSS reemplazando caracteres no alfanuméricos por su representación hexadecimal escapada

```php
public function escapeHtml( string $text = null ): string;
```

Escapa una cadena HTML. Internamente usa htmlspecialchars

```php
public function escapeHtmlAttr( string $attribute = null ): string;
```

Escapa una cadena de atributo HTML

```php
public function escapeJs( string $js ): string;
```

Escapa cadenas JavaScript reemplazando caracteres no alfanuméricos por su representación hexadecimal escapada

```php
public function escapeUrl( string $url ): string;
```

Escapa una URL. Internamente usa rawurlencode

```php
public function getEncoding(): string;
```

Devuelve la codificación interna usada por el escapador

```php
public function getFlags(): int;
```

Devuelve los parámetros actuales para htmlspecialchars

```php
public function html( string $input = null ): string;
```

Escapa una cadena HTML. Internamente usa htmlspecialchars

```php
public function js( string $input ): string;
```

Escapa cadenas javascript reemplazando caracteres no alfanuméricos por su representación hexadecimal escapada

```php
final public function normalizeEncoding( string $str ): string;
```

Utilidad para normalizar la codificación de una cadena a UTF-32.

```php
public function setDoubleEncode( bool $doubleEncode ): void;
```

Establece el double_encode para ser usado por el escapador

```php
$escaper->setDoubleEncode(false);
```

```php
public function setEncoding( string $encoding ): void;
```

Configura la codificación a ser usada por el escapador

```php
$escaper->setEncoding("utf-8");
```

```php
public function setFlags( int $flags ): Escaper;
```

Establece el tipo de comillas HTML para htmlspecialchars

```php
$escaper->setFlags(ENT_XHTML);
```

```php
public function setHtmlQuoteType( int $flags ): void;
```

Establece el tipo de comillas HTML para htmlspecialchars

```php
$escaper->setHtmlQuoteType(ENT_XHTML);
```

```php
public function url( string $url ): string;
```

Escapa una URL. Internamente usa rawurlencode

<h1 id="escaper-escaperinterface">Interface Phalcon\Escaper\EscaperInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Escaper/EscaperInterface.zep)

| Namespace | Phalcon\Escaper |

Interfaz para Phalcon\Escaper

## Métodos

```php
public function escapeCss( string $css ): string;
```

Escapa cadenas CSS reemplazando caracteres no alfanuméricos por su representación hexadecimal

```php
public function escapeHtml( string $text ): string;
```

Escapa una cadena HTML

```php
public function escapeHtmlAttr( string $text ): string;
```

Escapa una cadena de atributo HTML

```php
public function escapeJs( string $js ): string;
```

Escapa cadenas Javascript reemplazando caracteres no alfanuméricos por su representación hexadecimal

```php
public function escapeUrl( string $url ): string;
```

Escapa una URL. Internamente usa rawurlencode

```php
public function getEncoding(): string;
```

Devuelve la codificación interna usada por el escapador

```php
public function setEncoding( string $encoding ): void;
```

Configura la codificación a ser usada por el escapador

```php
public function setHtmlQuoteType( int $quoteType ): void;
```

Establece el tipo de comillas HTML para htmlspecialchars

<h1 id="escaper-exception">Class Phalcon\Escaper\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Escaper/Exception.zep)

| Namespace | Phalcon\Escaper | | Extends | \Phalcon\Exception |

Las excepciones lanzadas en Phalcon\Escaper usarán esta clase
