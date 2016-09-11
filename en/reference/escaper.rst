Contextual Escaping
===================

Websites and web applications are vulnerable to XSS_ attacks and although PHP provides escaping functionality, in some contexts
it is not sufficient/appropriate. :doc:`Phalcon\\Escaper <../api/Phalcon_Escaper>` provides contextual escaping and is written in Zephir, providing
the minimal overhead when escaping different kinds of texts.

We designed this component based on the `XSS (Cross Site Scripting) Prevention Cheat Sheet`_ created by the OWASP_.

Additionally, this component relies on mbstring_ to support almost any charset.

To illustrate how this component works and why it is important, consider the following example:

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

Which produces the following:

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

Every text was escaped according to its context. Use the appropriate context is important to avoid XSS attacks.

Escaping HTML
-------------
The most common situation when inserting unsafe data is between HTML tags:

.. code-block:: html

    <div class="comments">
        <!-- Escape untrusted data here! -->
    </div>

You can escape those data using the :code:`escapeHtml` method:

.. code-block:: html+php

    <div class="comments">
        <?php echo $e->escapeHtml('></div><h1>myattack</h1>'); ?>
    </div>

Which produces:

.. code-block:: html

    <div class="comments">
        &gt;&lt;/div&gt;&lt;h1&gt;myattack&lt;/h1&gt;
    </div>

Escaping HTML Attributes
------------------------
Escaping HTML attributes is different from escaping HTML content. The escaper works by changing every non-alphanumeric
character to the form. This kind of escaping is intended to most simpler attributes excluding complex ones like 'href' or 'url':

.. code-block:: html

    <table width="Escape untrusted data here!">
        <tr>
            <td>
                Hello
            </td>
        </tr>
    </table>

You can escape a HTML attribute by using the :code:`escapeHtmlAttr` method:

.. code-block:: html+php

    <table width="<?php echo $e->escapeHtmlAttr('"><h1>Hello</table'); ?>">
        <tr>
            <td>
                Hello
            </td>
        </tr>
    </table>

Which produces:

.. code-block:: html

    <table width="&#x22;&#x3e;&#x3c;h1&#x3e;Hello&#x3c;&#x2f;table">
        <tr>
            <td>
                Hello
            </td>
        </tr>
    </table>

Escaping URLs
-------------
Some HTML attributes like 'href' or 'url' need to be escaped differently:

.. code-block:: html

    <a href="Escape untrusted data here!">
        Some link
    </a>

You can escape a HTML attribute by using the :code:`escapeUrl` method:

.. code-block:: html+php

    <a href="<?php echo $e->escapeUrl('"><script>alert(1)</script><a href="#'); ?>">
        Some link
    </a>

Which produces:

.. code-block:: html

    <a href="%22%3E%3Cscript%3Ealert%281%29%3C%2Fscript%3E%3Ca%20href%3D%22%23">
        Some link
    </a>

Escaping CSS
------------
CSS identifiers/values can be escaped too:

.. code-block:: html

    <a style="color: Escape untrusted data here">
        Some link
    </a>

You can escape a CSS identifiers/value by using the :code:`escapeCss` method:

.. code-block:: html+php

    <a style="color: <?php echo $e->escapeCss('"><script>alert(1)</script><a href="#'); ?>">
        Some link
    </a>

Which produces:

.. code-block:: html

    <a style="color: \22 \3e \3c script\3e alert\28 1\29 \3c \2f script\3e \3c a\20 href\3d \22 \23 ">
        Some link
    </a>

Escaping JavaScript
-------------------
Strings to be inserted into JavaScript code also must be properly escaped:

.. code-block:: html

    <script>
        document.title = 'Escape untrusted data here';
    </script>

You can escape JavaScript code by using the :code:`escapeJs` method:

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
.. _mbstring: http://php.net/manual/en/book.mbstring.php
