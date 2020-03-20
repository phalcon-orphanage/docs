---
layout: default
language: 'ja-jp'
version: '4.0'
title: 'Escaper'
keywords: 'escaper, escape html, escape js, escape css'
---

# Escaper

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview

Websites and web applications are vulnerable to [XSS](https://www.owasp.org/index.php/XSS) attacks and although PHP provides escaping functionality, in some contexts it is not sufficient/appropriate. [Phalcon\Escaper](api/phalcon_escaper#escaper) provides contextual escaping and is written in [Zephir](https://zephir-lang.com), providing the minimal overhead when escaping different kinds of texts.

We designed this component based on the [XSS (Cross Site Scripting) Prevention Cheat Sheet](https://www.owasp.org/index.php/XSS_(Cross_Site_Scripting)_Prevention_Cheat_Sheet) created by the [OWASP](https://www.owasp.org). Additionally, this component relies on [mbstring](https://secure.php.net/manual/en/book.mbstring.php) to support almost any charset. To illustrate how this component works and why it is important, consider the following example:

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

You can escape text prior to printing it to your views using `escapeHtml()`. Without escaping you could potentially echo unsafe data in your HTML output.

```php
<?php

use Phalcon\Escaper;

$escaper = new Escaper();

$title = '</title><script>alert(1)</script>';
echo $escaper->escapeHtml($title);
// &lt;/title&gt;&lt;script&gt;alert(1)&lt;/script&gt;
```

HTML syntax:

```html
<?php echo $this->escaper->escapeHtml($title); ?>
```

Volt syntax:

```twig
{% raw %}{{ title | escape }}{% endraw %}
```

## HTML Attributes

Escaping attributes is different than escaping HTML content. The escaper works by changing every non-alphanumeric character to a safe format. It uses [htmlspecialchars](https://www.php.net/manual/en/function.htmlspecialchars.php) internally. This kind of escaping is intended escape excluding complex ones such as `href` or `url`. To escape attributes, you can use the `escapeHtmlAttr() method`

```php
<?php

use Phalcon\Escaper;

$escaper = new Escaper();

$attr = '"><h1>Hello</table';
echo $escaper->escapeHtmlAttr($attr);
// &#x22;&#x3e;&#x3c;h1&#x3e;Hello&#x3c;&#x2f;table
```

HTML syntax:

```html
<?php echo $this->escaper->escapeHtmlAttr($attr); ?>
```

Volt syntax:

```twig
{% raw %}{{ attr | escape_attr }}{% endraw %}
```

## URLs

`escapeUrl()` can be used to escape attributes such as `href` or `url`:

```php
<?php

use Phalcon\Escaper;

$escaper = new Escaper();

$url = '"><script>alert(1)</script><a href="#';
echo $escaper->escapeHtmlAttr($url);
// %22%3E%3Cscript%3Ealert%281%29%3C%2Fscript%3E%3Ca%20href%3D%22%23
```

HTML syntax:

```html
<?php echo $this->escaper->escapeHtmlAttr($url); ?>
```

## CSS

CSS identifiers/values can be escaped by using `escapeCss()`:

```php
<?php

use Phalcon\Escaper;

$escaper = new Escaper();

$css = '"><script>alert(1)</script><a href="#';
echo $escaper->escapeCss($css);
// \22 \3e \3c script\3e alert\28 1\29 \3c \2f script\3e \3c a\20 href\3d \22 \23 
```

HTML syntax:

```html
<?php echo $this->escaper->escapeCss($css); ?>
```

Volt syntax:

```twig
{% raw %}{{ css | escape_css }}{% endraw %}
```

## JavaScript

Content printed into javascript code must be properly escaped. `escapeJs()` helps with this task:

```php
<?php

use Phalcon\Escaper;

$escaper = new Escaper();

$js = "'; alert(100); var x='";
echo $escaper->escapeJs($js);
// \x27; alert(100); var x\x3d\x27
```

HTML syntax:

```html
<?php echo $this->escaper->escapeJs($js); ?>
```

Volt syntax:

```twig
{% raw %}{{ js | escape_js }}{% endraw %}
```

## Encoding

[Phalcon\Escape](api/phalcon_escaper#escaper) also offers methods regarding the encoding of the text to be escaped.

### `detectEncoding()`

Detects the character encoding of a string to be handled by an encoder. Special-handling for `chr(172)` and `chr(128)` to `chr(159)` which fail to be detected [mb_detect_encoding](https://www.php.net/manual/en/function.mb-detect-encoding.php). The method returns a `string` with the detected encoding or `null`

```php
<?php

use Phalcon\Escaper;

$escaper = new Escaper();

echo $escaper->detectEncoding('ḂḃĊċḊḋḞḟĠġṀṁ'); // UTF-8
```

### `getEncoding()`

Returns the internal encoding used by the escaper

```php
<?php

use Phalcon\Escaper;

$escaper = new Escaper();

echo $escaper->getEncoding();
```

### `normalizeEncoding()`

Utility method that normalizes a string's encoding to UTF-32.

```php
<?php

use Phalcon\Escaper;

$escaper = new Escaper();

echo $escaper->normalizeEncoding('ḂḃĊċḊḋḞḟĠġṀṁ');  
```

### `setEncoding()`

Sets the encoding to be used by the escaper

```php
<?php

use Phalcon\Escaper;

$escaper = new Escaper();

$escaper->setEncoding('utf-8');

echo $escaper->getEncoding(); // 'utf-8'
```

### `setDoubleEncode()`

Sets the escaper to use double encoding or not (default `true`)

```php
<?php

use Phalcon\Escaper;

$escaper = new Escaper();

$escaper->setDoubleEncode(false);
```

### `setHtmlQuoteType()`

You can set the quote type to be used by the escaper. The passed variable is one of the constants that [htmlspecialchars](https://www.php.net/manual/en/function.htmlspecialchars.php) accepts: - `ENT_COMPAT` - `ENT_QUOTES` - `ENT_NOQUOTES` - `ENT_IGNORE` - `ENT_SUBSTITUTE` - `ENT_DISALLOWED` - `ENT_HTML401` - `ENT_XML1` - `ENT_XHTML` - `ENT_HTML5`

```php
<?php

use Phalcon\Escaper;

$escaper = new Escaper();

$escaper->setHtmlQuoteType(ENT_XHTML);
```

## Exceptions

Any exceptions thrown in the Escaper component will be of type [Phalcon\Escaper\Exception](api/phalcon_escaper#escaper-exception). It is thrown when the data supplied to the component is not valid. You can use these exceptions to selectively catch exceptions thrown only from this component.

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

## 依存性の注入

If you use the [Phalcon\Di\FactoryDefault](api/phalcon_di#di-factorydefault) container, the [Phalcon\Escaper](api/phalcon_escaper#escaper) is already registered for you with the name `escaper`.

An example of the registration of the service as well as accessing it is below:

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

You can now use the component in a controller (or a component that implements Phalcon\Di\Injectable)

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

## Custom

Phalcon also offers the [Phalcon\Escaper\EscaperInterface](api/phalcon_escaper#escaper-escaperinterface) which can be implemented in a custom class. The class can offer the escaper functionality you require.

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