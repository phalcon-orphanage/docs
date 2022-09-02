---
layout: default
language: 'es-es'
version: '4.0'
title: 'Escaper'
keywords: 'escapador, escapar html, escapar js, escapar css'
---

# Escaper

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

Sitios y aplicaciones web son vulnerables a ataques [XSS](https://owasp.org/www-community/attacks/xss/) y aunque PHP proporciona funcionalidad de escape, en algunos contextos no es suficiente o adecuada. [Phalcon\Escaper](api/phalcon_escaper#escaper) proporciona escape contextual y está escrito en [Zephir](https://zephir-lang.com), provocando la sobrecarga mínima cuando al escapar distintos tipos de textos.

Hemos diseñado este componente basado en la [Hoja de Trucos de Prevención de XSS (Cross Site Scripting)](https://cheatsheetseries.owasp.org/cheatsheets/Cross_Site_Scripting_Prevention_Cheat_Sheet.html) creada por la [OWASP](https://www.owasp.org). Además, este componente se basa en la extensión [mbstring](https://www.php.net/manual/en/book.mbstring.php) para soportar casi cualquier conjunto de caracteres. Para ilustrar cómo funciona este componente y por qué es importante, considere el siguiente ejemplo:

```php
<?php

use Phalcon\Escaper;

$escaper = new Escaper();

$title = '</title><script>alert(1)</script>';
echo $escaper->escapeHtml($title);
// &lt;/title&gt;&lt;script&gt;alert(1)&lt;/script&gt;

$css = ';`(';
echo $escaper->escapeCss($css);
// &#x3c &#x2f style&#x3e

$fontName = 'Verdana\"</style>';
echo $escaper->escapeCss($fontName);
// Verdana\22 \3c \2f style\3e

$js = "';</script>Hello";
echo $escaper->escapeJs($js);
// \x27\x3b\x3c\2fscript\x3eHello
```

## HTML

Puede escapar el texto antes de imprimirlo en sus vistas usando `escapeHtml()`. Sin escapar podría mostrar datos potencialmente inseguros en su salida HTML.

```php
<?php

use Phalcon\Escaper;

$escaper = new Escaper();

$title = '</title><script>alert(1)</script>';
echo $escaper->escapeHtml($title);
// &lt;/title&gt;&lt;script&gt;alert(1)&lt;/script&gt;
```

Sintaxis HTML:

```html
<?php echo $this->escaper->escapeHtml($title); ?>
```

Sintaxis Volt:

```twig
{% raw %}{{ title | escape }}{% endraw %}
```

## Atributos HTML

El escape de atributos es diferente del escape de contenido HTML. El escape funciona cambiando cada carácter no alfanumérico a un formato seguro. Internamente usa [htmlspecialchars](https://www.php.net/manual/en/function.htmlspecialchars.php). Este tipo de escape está destinado a escapar atributos complejos como `href` o `url`. Para escapar atributos, puede usar el método `escapeHtmlAttr()`

```php
<?php

use Phalcon\Escaper;

$escaper = new Escaper();

$attr = '"><h1>Hello</table';
echo $escaper->escapeHtmlAttr($attr);
// &#x22;&#x3e;&#x3c;h1&#x3e;Hello&#x3c;&#x2f;table
```

Sintaxis HTML:

```html
<?php echo $this->escaper->escapeHtmlAttr($attr); ?>
```

Sintaxis Volt:

```twig
{% raw %}{{ attr | escape_attr }}{% endraw %}
```

## URLs

Se puede usar `escapeUrl()` para escapar atributos como `href` o `url`:

```php
<?php

use Phalcon\Escaper;

$escaper = new Escaper();

$url = '"><script>alert(1)</script><a href="#';
echo $escaper->escapeHtmlAttr($url);
// %22%3E%3Cscript%3Ealert%281%29%3C%2Fscript%3E%3Ca%20href%3D%22%23
```

Sintaxis HTML:

```html
<?php echo $this->escaper->escapeHtmlAttr($url); ?>
```

## CSS

Los Identificadores/valores CSS se pueden escapar usando `escapeCss()`:

```php
<?php

use Phalcon\Escaper;

$escaper = new Escaper();

$css = '"><script>alert(1)</script><a href="#';
echo $escaper->escapeCss($css);
// \22 \3e \3c script\3e alert\28 1\29 \3c \2f script\3e \3c a\20 href\3d \22 \23 
```

Sintaxis HTML:

```html
<?php echo $this->escaper->escapeCss($css); ?>
```

Sintaxis Volt:

```twig
{% raw %}{{ css | escape_css }}{% endraw %}
```

## JavaScript

El contenido impreso en código javascript debe ser escapado adecuadamente. `escapeJs()` ayuda en esta tarea:

```php
<?php

use Phalcon\Escaper;

$escaper = new Escaper();

$js = "'; alert(100); var x='";
echo $escaper->escapeJs($js);
// \x27; alert(100); var x\x3d\x27
```

Sintaxis HTML:

```html
<?php echo $this->escaper->escapeJs($js); ?>
```

Sintaxis Volt:

```twig
{% raw %}{{ js | escape_js }}{% endraw %}
```

## Codificación

[Phalcon\Escape](api/phalcon_escaper#escaper) también ofrece métodos para la codificación del texto a escapar.

### `detectEncoding()`

Detecta la codificación de caracteres de una cadena a ser gestionada por un codificador. Gestión especial para `chr(172)` y `chr(128)` a `chr(159)` que no se detectan [mb_detect_encoding](https://www.php.net/manual/en/function.mb-detect-encoding.php). El método devuelve `string` con la codificación detectada o `null`

```php
<?php

use Phalcon\Escaper;

$escaper = new Escaper();

echo $escaper->detectEncoding('ḂḃĊċḊḋḞḟĠġṀṁ'); // UTF-8
```

### `getEncoding()`

Devuelve la codificación interna usada por el escapador

```php
<?php

use Phalcon\Escaper;

$escaper = new Escaper();

echo $escaper->getEncoding();
```

### `normalizeEncoding()`

Método de utilidad que normaliza la codificación de una cadena a UTF-32.

```php
<?php

use Phalcon\Escaper;

$escaper = new Escaper();

echo $escaper->normalizeEncoding('ḂḃĊċḊḋḞḟĠġṀṁ');  
```

### `setEncoding()`

Configura la codificación a ser usada por el escapador

```php
<?php

use Phalcon\Escaper;

$escaper = new Escaper();

$escaper->setEncoding('utf-8');

echo $escaper->getEncoding(); // 'utf-8'
```

### `setDoubleEncode()`

Configura el escapador para usar doble codificación o no (por defecto `true`)

```php
<?php

use Phalcon\Escaper;

$escaper = new Escaper();

$escaper->setDoubleEncode(false);
```

### `setHtmlQuoteType()`

Puede configurar el tipo de comillas a usar por el escapador. La variable pasada es una de las constantes que acepta [htmlspecialchars](https://www.php.net/manual/en/function.htmlspecialchars.php): - `ENT_COMPAT` - `ENT_QUOTES` - `ENT_NOQUOTES` - `ENT_IGNORE` - `ENT_SUBSTITUTE` - `ENT_DISALLOWED` - `ENT_HTML401` - `ENT_XML1` - `ENT_XHTML` - `ENT_HTML5`

```php
<?php

use Phalcon\Escaper;

$escaper = new Escaper();

$escaper->setHtmlQuoteType(ENT_XHTML);
```

## Excepciones

Cualquier excepción lanzada en el componente `Escaper` será del tipo [Phalcon\Escaper\Exception](api/phalcon_escaper#escaper-exception). Se lanza cuando los datos proporcionados al componente no son válidos. Puede usar estas excepciones para capturar selectivamente sólo las excepciones lanzadas desde este componente.

```php
<?php

use Phalcon\Escaper;
use Phalcon\Escaper\Exception;
use Phalcon\Mvc\Controller;

/**
 * @property Escaper $escaper
 */
class IndexController extends Controller
{
    public function index()
    {
        try {
            echo $this->escaper->normalizeEncoding('ḂḃĊċḊḋḞḟĠġṀṁ');  
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
```

## Inyección de Dependencias

Si usa el contenedor [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault), [Phalcon\Escaper](api/phalcon_escaper#escaper) ya está registrado con el nombre `escaper`.

Un ejemplo de registro del servicio y acceso a él a continuación:

```php
<?php

use Phalcon\Di;
use Phalcon\Escaper;

$container = new Di();

$container->set(
    'escaper',
    function () use  {
        return new Escaper();
    }
);
```

Ahora puede usar el componente en un controlador (o un componente que implemente `Phalcon\Di\Injectable`)

```php
<?php

namespace MyApp;

use Phalcon\Escaper;
use Phalcon\Mvc\Controller;

/**
 * Invoices controller
 *
 * @property Escaper $escaper
 */
class InvoicesController extends Controller
{
    public function indexAction()
    {

    }

    public function saveAction()
    {
        echo $this->escaper->escapeHtml('The post was correctly saved!');
    }
}
```

## Personalizado

Phalcon también ofrece [Phalcon\Escaper\EscaperInterface](api/phalcon_escaper#escaper-escaperinterface) que se puede implementar en una clase personalizada. La clase puede ofrecer la funcionalidad de escape que requiera.

```php
<?php

namespace MyApp\Escaper;

use Phalcon\Escaper\EscaperInterface;

class Custom extends EscaperInterface
{
    /**
     * Escape CSS strings by replacing non-alphanumeric chars by their
     * hexadecimal representation
     */
    public function escapeCss(string $css): string;

    /**
     * Escapes a HTML string
     */
    public function escapeHtml(string $text): string;

    /**
     * Escapes a HTML attribute string
     */
    public function escapeHtmlAttr(string $text): string;

    /**
     * Escape Javascript strings by replacing 
     * non-alphanumeric chars by their hexadecimal 
     * representation
     */
    public function escapeJs(string $js): string;

    /**
     * Escapes a URL. Internally uses rawurlencode
     */
    public function escapeUrl(string $url): string;

    /**
     * Returns the internal encoding used by the escaper
     */
    public function getEncoding(): string;

    /**
     * Sets the encoding to be used by the escaper
     */
    public function setEncoding(string $encoding): void;

    /**
     * Sets the HTML quoting type for htmlspecialchars
     */
    public function setHtmlQuoteType(int $quoteType): void;
}
```
