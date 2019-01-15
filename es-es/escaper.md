* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Escapado contextual

Sitios y aplicaciones web son vulnerables a ataques [XSS](https://www.owasp.org/index.php/XSS) y aunque PHP proporciona funcionalidad de escape, en algunos contextos no es suficiente o adecuada. [Phalcon\Escaper](api/Phalcon_Escaper) provides contextual escaping and is written in Zephir, providing the minimal overhead when escaping different kinds of texts.

Hemos diseñado este componente basado en el [XSS (Cross Site Scripting) hoja de trucos de prevención](https://www.owasp.org/index.php/XSS_(Cross_Site_Scripting)_Prevention_Cheat_Sheet) creada por la [OWASP](https://www.owasp.org).

Additionally, this component relies on [mbstring](https://php.net/manual/en/book.mbstring.php) to support almost any charset.

Para ilustrar cómo funciona este componente y por qué es importante, considere el siguiente ejemplo:

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

El código anterior produce el siguiente código HTML:

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

Cada texto se escapó según su contexto. El uso del contexto adecuado es importante para evitar ataques XSS.

<a name='html'></a>

## Escapando HTML

La situación más común es cuando se insertan datos inseguros entre etiquetas HTML:

```html
<div class="comments">
    <!-- ¡Escapar datos no confiables aquí! -->
</div>
```

Se pueden escapar esos datos mediante el método `escapeHtml`:

```php
<div class="comments">
    <?php echo $e->escapeHtml('></div><h1>mi ataque</h1>'); ?>
</div>
```

Lo que produce:

```html
<div class="comments">
    &gt;&lt;/div&gt;&lt;h1&gt;mi ataque&lt;/h1&gt;
</div>
```

<a name='html-attributes'></a>

## Escapando atributos HTML

Escapar atributos HTML es diferente de escapar contenido HTML. El escaper funciona cambiando todos los caracteres no alfanuméricos. Este tipo de escape está destinado en su mayoría a atributos simples, exceptuando los complejos como `href` o `url`:

```html
<table width="¡Escapar datos no confiables aquí!">
    <tr>
        <td>
            Hola
        </td>
    </tr>
</table>
```

Se puede escapar un atributo HTML mediante el método `escapeHtmlAttr`:

```php
<table width="<?php echo $e->escapeHtmlAttr('"><h1>Hola</table'); ?>">
    <tr>
        <td>
            Hola
        </td>
    </tr>
</table>
```

Lo que produce:

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

Algunos atributos HTML como `href` o `url` necesitan un escapado diferente:

```html
<a href="¡Escapar datos no confiables aquí!">
    Algún enlace
</a>
```

Se puede escapar un atributo HTML mediante el método `escapeUrl`:

```php
<a href="<?php echo $e->escapeUrl('"><script>alert(1)</script><a href="#'); ?>">
    Algún enlace
</a>
```

Lo que produce:

```html
<a href="%22%3E%3Cscript%3Ealert%281%29%3C%2Fscript%3E%3Ca%20href%3D%22%23">
    Algún enlace
</a>
```

<a name='css'></a>

## Escapando CSS

Identificadores y valores de CSS también pueden ser escapados:

```html
<a style="color: ¡Escapar datos no confiables aquí!">
    Algunos enlaces
</a>
```

Se puede escapar identificadores y valores CSS mediante el método `escapeCss`:

```php
<a style="color: <?php echo $e->escapeCss('"><script>alert(1)</script><a href="#'); ?>">
    Algún enlace
</a>
```

Lo que produce:

```html
<a style="color: \22 \3e \3c script\3e alert\28 1\29 \3c \2f script\3e \3c a\20 href\3d \22 \23 ">
    Algún enlace
</a>
```

<a name='javascript'></a>

## Escapando JavaScript

Las cadenas para ser insertadas en el código JavaScript también deben ser correctamente escapadas:

```html
<script>
    document.title = '¡Escapar datos no confiables aquí!';
</script>
```

Puede escapar código JavaScript mediante el método `escapeJs`:

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