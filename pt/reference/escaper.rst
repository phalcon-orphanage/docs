Escape de contexto
===================

Sites e aplicações web são vulneráveis a ataques XSS_ e, embora o PHP fornecer funcionalidades para escapar, em alguns contextos, ainda não é suficiente ou adequado.
:doc:`Phalcon\\Escaper <../api/Phalcon_Escaper>` fornece um escape de contexto e é escrito em Zephir, fornecendo o mínimo de sobrecarga ao escapar diferentes tipos de textos.

Nós projetamos este componente baseado no `XSS (Cross Site Scripting) Prevention Cheat Sheet`_ criado pela OWASP_.

Além disso, este componente depende mbstring_ para suportar quase todo o conjunto de caracteres.

Para ilustrar como este componente funciona e por que é importante, considere o seguinte exemplo:

.. code-block:: html+php

    <?php

    use Phalcon\Escaper;

    // Document title with malicious extra HTML tags
    $maliciousTitle = "</title><script>alert(1)</script>";

    // Malicious CSS class name
    $className = ";`(";

    // Malicious CSS font name
    $fontName = "Verdana\"</style>";

    // Malicious Javascript text
    $javascriptText = "';</script>Hello";

    // Create an escaper
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
                hello
            </div>

            <script>
                var some = '<?php echo $e->escapeJs($javascriptText); ?>';
            </script>

        </body>
    </html>

Que produz o seguinte:

.. code-block:: html

    <html>
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
                hello
            </div>

            <script>
                var some = '\x27\x3b\x3c\2fscript\x3eHello';
            </script>

        </body>
    </html>

Todo texto tem escapado de acordo com o seu contexto. Use o contexto apropriado para evitar ataques XSS.

Escapando HTML
--------------
A situação mais comum quando inserimos dados inseguros entre tags HTML:

.. code-block:: html

    <div class="comments">
        <!-- Escape untrusted data here! -->
    </div>

Você pode escapar esses dados usando o método :code:`escapeHtml`:

.. code-block:: html+php

    <div class="comments">
        <?php echo $e->escapeHtml('></div><h1>myattack</h1>'); ?>
    </div>

Que produz:

.. code-block:: html

    <div class="comments">
        &gt;&lt;/div&gt;&lt;h1&gt;myattack&lt;/h1&gt;
    </div>

Escapando atributos HTML
------------------------
Escapando atributos HTML é diferente que escapar conteúdo HTML. O escapador trabalha sempre alterando caracteres não alfa-numéricos
no formulário. Esse tipo de escape se destina a muitos atributos simples, excluindo complexos como 'href' ou 'url':

.. code-block:: html

    <table width="Escape untrusted data here!">
        <tr>
            <td>
                Hello
            </td>
        </tr>
    </table>

Você pode escapar um atributo HTML usando o método :code:`escapeHtmlAttr`:

.. code-block:: html+php

    <table width="<?php echo $e->escapeHtmlAttr('"><h1>Hello</table'); ?>">
        <tr>
            <td>
                Hello
            </td>
        </tr>
    </table>

Que produz:

.. code-block:: html

    <table width="&#x22;&#x3e;&#x3c;h1&#x3e;Hello&#x3c;&#x2f;table">
        <tr>
            <td>
                Hello
            </td>
        </tr>
    </table>

Escapando URLs
--------------
Muitos atributos HTML como 'href' ou 'url' precisam ser escapados de forma diferente:

.. code-block:: html

    <a href="Escape untrusted data here!">
        Some link
    </a>

Você pode escapar um atributo HTML usando o método :code:`escapeUrl`

.. code-block:: html+php

    <a href="<?php echo $e->escapeUrl('"><script>alert(1)</script><a href="#'); ?>">
        Some link
    </a>

Que produz:

.. code-block:: html

    <a href="%22%3E%3Cscript%3Ealert%281%29%3C%2Fscript%3E%3Ca%20href%3D%22%23">
        Some link
    </a>

Escapando CSS
-------------
Indentificadores/valores CSS podem ser escapados também:

.. code-block:: html

    <a style="color: Escape untrusted data here">
        Some link
    </a>

Você pode escapar um atributo HTML usando o método :code:`escapeCss`:

.. code-block:: html+php

    <a style="color: <?php echo $e->escapeCss('"><script>alert(1)</script><a href="#'); ?>">
        Some link
    </a>

Que produz:

.. code-block:: html

    <a style="color: \22 \3e \3c script\3e alert\28 1\29 \3c \2f script\3e \3c a\20 href\3d \22 \23 ">
        Some link
    </a>

Escapando JavaScript
--------------------
Textos podem ser inseridos no código JavaScript, também devem ser devidamente escapados:

.. code-block:: html

    <script>
        document.title = 'Escape untrusted data here';
    </script>

Você pode escapar um atributo HTML  usando o método :code:`escapeJs`:

.. code-block:: html+php

    <script>
        document.title = '<?php echo $e->escapeJs("'; alert(100); var x='"); ?>';
    </script>

.. code-block:: html

    <script>
        document.title = '\x27; alert(100); var x\x3d\x27';
    </script>

.. _OWASP: https://www.owasp.org
.. _XSS: https://www.owasp.org/index.php/XSS
.. _`XSS (Cross Site Scripting) Prevention Cheat Sheet`: https://www.owasp.org/index.php/XSS_(Cross_Site_Scripting)_Prevention_Cheat_Sheet
.. _mbstring: http://php.net/manual/pt_BR/book.mbstring.php
