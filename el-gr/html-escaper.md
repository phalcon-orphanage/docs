---
layout: default
language: 'en'
version: '5.0'
title: 'Escaper'
upgrade: '#escaper'
keywords: 'escaper, escape html, escape js, escape css'
---

# Escaper
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Επισκόπηση
Websites and web applications are vulnerable to [XSS][xss] attacks and although PHP provides escaping functionality, in some contexts it is not sufficient/appropriate. [Phalcon\Html\Escaper][escaper] provides contextual escaping and is written in [Zephir][zephir], providing the minimal overhead when escaping different kinds of texts.

We designed this component based on the [XSS (Cross Site Scripting) Prevention Cheat Sheet][xss_cheat_sheet] created by the [OWASP][owasp]. Additionally, this component relies on [mbstring][mbstring] to support almost any charset. To illustrate how this component works and why it is important, consider the following example:

```php
<?php

use Phalcon\Html\Escaper;

$escaper = new Escaper();

$title = '</title><script>alert(1)</script>';
echo $escaper->html($title);
// &lt;/title&gt;&lt;script&gt;alert(1)&lt;/script&gt;

$css = ';`(';
echo $escaper->css($css);
// &#x3c &#x2f style&#x3e

$fontName = 'Verdana\"</style>';
echo $escaper->css($fontName);
// Verdana\22 \3c \2f style\3e

$js = "';</script>Hello";
echo $escaper->js($js);
// \x27\x3b\x3c\2fscript\x3eHello
```

## HTML
You can escape text prior to printing it to your views using `html()`. Without escaping you could potentially echo unsafe data in your HTML output.

```php
<?php

use Phalcon\Html\Escaper;

$escaper = new Escaper();

$title = '</title><script>alert(1)</script>';
echo $escaper->html($title);
// &lt;/title&gt;&lt;script&gt;alert(1)&lt;/script&gt;
```

HTML syntax:
```html
<?php echo $this->escaper->html($title); ?>
```

Volt syntax:
```twig
{% raw %}{{ title | escape }}{% endraw %}
```

## HTML Attributes
Escaping attributes is different from escaping HTML content. The escaper works by changing every non-alphanumeric character to a safe format. It uses [htmlspecialchars][htmlspecialchars] internally. This kind of escaping is intended escape excluding complex ones such as `href` or `url`. To escape attributes, you can use the `attributes()` method. This method has been renamed. The old method `escapeHtmlAttr()` will be removed in the future and emits a `@deprecated` warning.

```php
<?php

use Phalcon\Html\Escaper;

$escaper = new Escaper();

$attr = '"><h1>Hello</table';
echo $escaper->attributes($attr);
// &#x22;&#x3e;&#x3c;h1&#x3e;Hello&#x3c;&#x2f;table
```

HTML syntax:
```html
<?php echo $this->escaper->attributes($attr); ?>
```

Volt syntax:
```twig
{% raw %}{{ attr | escape_attr }}{% endraw %}
```

## URLs
`url()` can be used to escape attributes such as `href` or `url`. This method has been renamed. The old method `escapeUrl()` will be removed in the future and emits a `@deprecated` warning.

```php
<?php

use Phalcon\Html\Escaper;

$escaper = new Escaper();

$url = '"><script>alert(1)</script><a href="#';
echo $escaper->attributes($url);
// %22%3E%3Cscript%3Ealert%281%29%3C%2Fscript%3E%3Ca%20href%3D%22%23
```

HTML syntax:
```html
<?php echo $this->escaper->attributes($url); ?>
```

## CSS
CSS identifiers/values can be escaped by using `css()`. This method has been renamed. The old method `escapeCss()` will be removed in the future and emits a `@deprecated` warning.

```php
<?php

use Phalcon\Html\Escaper;

$escaper = new Escaper();

$css = '"><script>alert(1)</script><a href="#';
echo $escaper->css($css);
// \22 \3e \3c script\3e alert\28 1\29 \3c \2f script\3e \3c a\20 href\3d \22 \23 
```

HTML syntax:
```html
<?php echo $this->escaper->css($css); ?>
```

Volt syntax:
```twig
{% raw %}{{ css | escape_css }}{% endraw %}
```

## JavaScript
Content printed into javascript code must be properly escaped. `js()` helps with this task. This method has been renamed. The old method `escapeJs()` will be removed in the future and emits a `@deprecated` warning.

```php
<?php

use Phalcon\Html\Escaper;

$escaper = new Escaper();

$js = "'; alert(100); var x='";
echo $escaper->js($js);
// \x27; alert(100); var x\x3d\x27
```

HTML syntax:
```html
<?php echo $this->escaper->js($js); ?>
```

Volt syntax:
```twig
{% raw %}{{ js | escape_js }}{% endraw %}
```

## Encoding
[Phalcon\Html\Escape][escaper] also offers methods regarding the encoding of the text to be escaped.

### `detectEncoding()`
Detects the character encoding of a string to be handled by an encoder. Special-handling for `chr(172)` and `chr(128)` to `chr(159)` which fail to be detected [mb_detect_encoding][mb_detect_encoding]. The method returns a `string` with the detected encoding or `null`

```php
<?php

use Phalcon\Html\Escaper;

$escaper = new Escaper();

echo $escaper->detectEncoding('ḂḃĊċḊḋḞḟĠġṀṁ'); // UTF-8
```

### `getEncoding()`
Returns the internal encoding used by the escaper

```php
<?php

use Phalcon\Html\Escaper;

$escaper = new Escaper();

echo $escaper->getEncoding();
```

### `normalizeEncoding()`
Utility method that normalizes a string's encoding to UTF-32.

```php
<?php

use Phalcon\Html\Escaper;

$escaper = new Escaper();

echo $escaper->normalizeEncoding('ḂḃĊċḊḋḞḟĠġṀṁ');  
```

### `setEncoding()`
Sets the encoding to be used by the escaper

```php
<?php

use Phalcon\Html\Escaper;

$escaper = new Escaper();

$escaper->setEncoding('utf-8');

echo $escaper->getEncoding(); // 'utf-8'
```

### `setDoubleEncode()`
Sets the escaper to use double encoding or not (default `true`)

```php
<?php

use Phalcon\Html\Escaper;

$escaper = new Escaper();

$escaper->setDoubleEncode(false);
```

### `setFlags(int $flags)`
You can set the quote type to be used by the escaper. This method has been renamed. The old method `setHtmlQuoteType()` will be removed in the future and emits a `@deprecated` warning.

The passed variable is one of the constants that [htmlspecialchars][htmlspecialchars] accepts:
- `ENT_COMPAT`
- `ENT_QUOTES`
- `ENT_NOQUOTES`
- `ENT_IGNORE`
- `ENT_SUBSTITUTE`
- `ENT_DISALLOWED`
- `ENT_HTML401`
- `ENT_XML1`
- `ENT_XHTML`
- `ENT_HTML5`

```php
<?php

use Phalcon\Html\Escaper;

$escaper = new Escaper();

$escaper->setFlags(ENT_XHTML);
```

## Exceptions
Any exceptions thrown in the Escaper component will be of type [Phalcon\Html\Escaper\Exception][escaper-exception]. It is thrown when the data supplied to the component is not valid. You can use these exceptions to selectively catch exceptions thrown only from this component.

```php
<?php

use Phalcon\Html\Escaper;
use Phalcon\Html\Escaper\Exception;
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

## Dependency Injection
If you use the [Phalcon\Di\FactoryDefault][di-factorydefault] container, the [Phalcon\Html\Escaper][escaper] is already registered for you with the name `escaper`.

An example of the registration of the service as well as accessing it is below:

```php
<?php

use Phalcon\Di;
use Phalcon\Html\Escaper;

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

use Phalcon\Html\Escaper;
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
        echo $this->escaper->html('The post was correctly saved!');
    }
}
```

## Custom
Phalcon also offers the [Phalcon\Html\Escaper\EscaperInterface][escaper-escaperinterface] which can be implemented in a custom class. The class can offer the escaper functionality you require.

```php
<?php

namespace MyApp\Escaper;

use Phalcon\Html\Escaper\EscaperInterface;

class Custom extends EscaperInterface
{
    public function css(string $css): string;

    public function html(string $text): string;

    public function attributes(string $text): string;

    public function js(string $js): string;

    public function url(string $url): string;

    public function getEncoding(): string;

    public function setEncoding(string $encoding): void;

    public function setHtmlQuoteType(int $quoteType): void;
}
```

[di-factorydefault]: api/phalcon_di#di-factorydefault
[escaper]: api/phalcon_escaper#escaper
[escaper]: api/phalcon_escaper#escaper
[escaper-escaperinterface]: api/phalcon_escaper#escaper-escaperinterface
[escaper-exception]: api/phalcon_escaper#escaper-exception
[zephir]: https://zephir-lang.com
[htmlspecialchars]: https://www.php.net/manual/en/function.htmlspecialchars.php
[mb_detect_encoding]: https://www.php.net/manual/en/function.mb-detect-encoding.php
[mbstring]: https://www.php.net/manual/en/book.mbstring.php
[owasp]: https://www.owasp.org
[xss]: https://owasp.org/www-community/attacks/xss/
[xss_cheat_sheet]: https://cheatsheetseries.owasp.org/cheatsheets/Cross_Site_Scripting_Prevention_Cheat_Sheet.html
