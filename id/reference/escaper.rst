Escape Kontekstual
==================

Website dan aplikasi web rawan serangan XSS_ dan meski PHP menyediakan fungsionalitas escape, di beberapa konteks
ia tidak cukup/cocok. :doc:`Phalcon\\Escaper <../api/Phalcon_Escaper>` menyediakan escape kontekstual dan ditulis dalam Zephir, menghadirkan overhead
minimal ketika escape beragam teks berbeda.

Kami merancang komponen ini berdasar `XSS (Cross Site Scripting) Prevention Cheat Sheet`_ yang dibuat OWASP_.

Tambahan lagi, komponen ini bergantung pada mbstring_ untuk mendukung hampir semua charset.

Untuk menggambarkan bagaimana komponen ini bekerja dan mengapa ia penting, lihat contoh berikut:

.. code-block:: html+php

    <?php

    use Phalcon\Escaper;

    // Title dokumen dengan HTML tags ekstra yang jahat
    $maliciousTitle = "</title><script>alert(1)</script>";

    // CSS class name yang jahat
    $className = ";`(";

    // CSS font name jahat
    $fontName = "Verdana\"</style>";

    // Javascript text jahat
    $javascriptText = "';</script>Hello";

    // Mmebuat escaper
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

Yang menghasilkan berikut ini:

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

Tiap teks diescape berdasarkan konteksnya masing-masing. Menggunakan konteks yang tepat penting untuk menghindari serangan XSS.

Escape HTML
-----------
Situasi umum ketika menyisipkan data tidak aman adalah antara tag HTML:

.. code-block:: html

    <div class="comments">
        <!-- Escape untrusted data here! -->
    </div>

Anda dapat escape data tersebut dengan metode :code:`escapeHtml`:

.. code-block:: html+php

    <div class="comments">
        <?php echo $e->escapeHtml('></div><h1>myattack</h1>'); ?>
    </div>

Yang menghasilkan:

.. code-block:: html

    <div class="comments">
        &gt;&lt;/div&gt;&lt;h1&gt;myattack&lt;/h1&gt;
    </div>

Escape Attribut HTML
--------------------
Escape atribut HTML berbeda dari escape konten HTML. Escaper bekerja dengan mengubah tiap karakter bukan alfanumerik
ke bentuk itu. Escape macam ini ditujukan untuk atribut paling sederhana dan tidak menyertakan atribut komplek seperti 'href' atau 'url':

.. code-block:: html

    <table width="Escape untrusted data here!">
        <tr>
            <td>
                Hello
            </td>
        </tr>
    </table>

Anda dapat escape atribut HTML menggunakan metode :code:`escapeHtmlAttr`:

.. code-block:: html+php

    <table width="<?php echo $e->escapeHtmlAttr('"><h1>Hello</table'); ?>">
        <tr>
            <td>
                Hello
            </td>
        </tr>
    </table>

Yang menghasilkan:

.. code-block:: html

    <table width="&#x22;&#x3e;&#x3c;h1&#x3e;Hello&#x3c;&#x2f;table">
        <tr>
            <td>
                Hello
            </td>
        </tr>
    </table>

Escape URL
----------
Beberapa atribut HTML seperti 'href' atau 'url' perlu di escape secara berbeda:

.. code-block:: html

    <a href="Escape untrusted data here!">
        Some link
    </a>

Anda dapat escape sebuah atribut HTMLmenggunakn metode :code:`escapeUrl`:

.. code-block:: html+php

    <a href="<?php echo $e->escapeUrl('"><script>alert(1)</script><a href="#'); ?>">
        Some link
    </a>

Yang manghasilkan:

.. code-block:: html

    <a href="%22%3E%3Cscript%3Ealert%281%29%3C%2Fscript%3E%3Ca%20href%3D%22%23">
        Some link
    </a>

Escape CSS
----------
Pengenal/nilai CSS dapat di escape juga:

.. code-block:: html

    <a style="color: Escape untrusted data here">
        Some link
    </a>

Anda dapat escape CSS menggunakan metode :code:`escapeCss`:

.. code-block:: html+php

    <a style="color: <?php echo $e->escapeCss('"><script>alert(1)</script><a href="#'); ?>">
        Some link
    </a>

Yang menghasilkan:

.. code-block:: html

    <a style="color: \22 \3e \3c script\3e alert\28 1\29 \3c \2f script\3e \3c a\20 href\3d \22 \23 ">
        Some link
    </a>

Escape JavaScript
-----------------
String yang disisipkan ke kode JavaScript juga harus di escape dengan benar:

.. code-block:: html

    <script>
        document.title = 'Escape untrusted data here';
    </script>

Anda dapat escape kode JavaScript menggunakan metode :code:`escapeJs`:

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
