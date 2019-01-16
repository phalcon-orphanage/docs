* * *

layout: article language: 'en' version: '4.0'

* * *

##### This article reflects v3.4 and has not yet been revised

{:.alert .alert-danger}

<a name='overview'></a>

# Escapado contextual

Websites and web applications are vulnerable to [XSS](https://www.owasp.org/index.php/XSS) attacks and although PHP provides escaping functionality, in some contexts it is not sufficient/appropriate. [Phalcon\Escaper](api/Phalcon_Escaper) provides contextual escaping and is written in Zephir, providing the minimal overhead when escaping different kinds of texts.

We designed this component based on the [XSS (Cross Site Scripting) Prevention Cheat Sheet](https://www.owasp.org/index.php/XSS_(Cross_Site_Scripting)_Prevention_Cheat_Sheet) created by the [OWASP](https://www.owasp.org).

Additionally, this component relies on [mbstring](https://php.net/manual/en/book.mbstring.php) to support almost any charset.

To illustrate how this component works and why it is important, consider the following example:

```php
<?php

use Phalcon\Escaper;

// Título del documento con etiquetas HTML maliciosas adicionales
$maliciousTitle = "</title><script>alert(1)</script>";

// Nombre de clase CSS maliciosa
$className = ";`(";

// Nombre de fuente CSS maliciosa
$fontName = "Verdana\"</style>";

// Texto Javascript malicioso
$javascriptText = "';</script>Hello";

// Crear un escapador
$e = new Escaper();

?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title>
            <?php echo $e->escapeHtml($maliciousTitle); ?>
        </title>

        <style type="text/css">
            .<?php echo $e->escapeCss($className); ?> {
                font-family: "<?php echo $e->escapeCss($fontName); ?>";
                color: red;
            }
        </style>

    </head>

    <body>

        <div class='<?php echo $e->escapeHtmlAttr($className); ?>'>
            hola
        </div>

        <script>
            var some = '<?php echo $e->escapeJs($javascriptText); ?>';
        </script>

    </body>
</html>
```

Which produces the following:

```html
<br /><html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title>
            &lt;/title&gt;&lt;script&gt;alert(1)&lt;/script&gt;
        </title>

        <style type="text/css">
            .\3c \2f style\3e {
                font-family: "Verdana\22 \3c \2f style\3e";
                color: red;
            }
        </style>

    </head>

    <body>

        <div class='&#x3c &#x2f style&#x3e '>
            hola
        </div>

        <script>
            var some = '\x27\x3b\x3c\2fscript\x3eHello';
        </script>

    </body>
</html>
```

Every text was escaped according to its context. Use the appropriate context is important to avoid XSS attacks.

<a name='html'></a>

## Escapando HTML

The most common situation when inserting unsafe data is between HTML tags:

```html
<div class="comments">
    <!-- ¡Escapar datos no confiables aquí! -->
</div>
```

You can escape those data using the `escapeHtml` method:

```php
<div class="comments">
    <?php echo $e->escapeHtml('></div><h1>mi ataque</h1>'); ?>
</div>
```

Which produces:

```html
<div class="comments">
    &gt;&lt;/div&gt;&lt;h1&gt;mi ataque&lt;/h1&gt;
</div>
```

<a name='html-attributes'></a>

## Escapando atributos HTML

Escaping HTML attributes is different from escaping HTML content. The escaper works by changing every non-alphanumeric character to the form. This kind of escaping is intended to most simpler attributes excluding complex ones like `href` or `url`:

```html
<table width="¡Escapar datos no confiables aquí!">
    <tr>
        <td>
            Hola
        </td>
    </tr>
</table>
```

You can escape a HTML attribute by using the `escapeHtmlAttr` method:

```php
<table width="<?php echo $e->escapeHtmlAttr('"><h1>Hola</table'); ?>">
    <tr>
        <td>
            Hola
        </td>
    </tr>
</table>
```

Which produces:

```html
<table width="&#x22;&#x3e;&#x3c;h1&#x3e;Hola&#x3c;&#x2f;table">
    <tr>
        <td>
            Hola
        </td>
    </tr>
</table>
```

<a name='urls'></a>

## Escapando URLs

Some HTML attributes like `href` or `url` need to be escaped differently:

```html
<a href="¡Escapar datos no confiables aquí!">
    Algún enlace
</a>
```

You can escape a HTML attribute by using the :code:`escapeUrl` method:

```php
<a href="<?php echo $e->escapeUrl('"><script>alert(1)</script><a href="#'); ?>">
    Algún enlace
</a>
```

Which produces:

```html
<a href="%22%3E%3Cscript%3Ealert%281%29%3C%2Fscript%3E%3Ca%20href%3D%22%23">
    Algún enlace
</a>
```

<a name='css'></a>

## Escapando CSS

CSS identifiers/values can be escaped too:

```html
<a style="color: ¡Escapar datos no confiables aquí!">
    Algunos enlaces
</a>
```

You can escape a CSS identifiers/value by using the :code:`escapeCss` method:

```php
<a style="color: <?php echo $e->escapeCss('"><script>alert(1)</script><a href="#'); ?>">
    Algún enlace
</a>
```

Which produces:

```html
<a style="color: \22 \3e \3c script\3e alert\28 1\29 \3c \2f script\3e \3c a\20 href\3d \22 \23 ">
    Algún enlace
</a>
```

<a name='javascript'></a>

## Escapando JavaScript

Strings to be inserted into JavaScript code also must be properly escaped:

```html
<script>
    document.title = '¡Escapar datos no confiables aquí!';
</script>
```

You can escape JavaScript code by using the `escapeJs` method:

```php
<script>
    document.title = '<?php echo $e->escapeJs("'; alert(100); var x='"); ?>';
</script>
```

```html
<script>
    document.title = '\x27; alert(100); var x\x3d\x27';
</script>
```