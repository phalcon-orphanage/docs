%{escaper_de8049e2b4f8854b235a1e7a22dfbaa2}%
===================
%{escaper_4ac20f61e26bc5c1fb7aee9b14e2a6ca|:doc:`Phalcon\\Escaper <../api/Phalcon_Escaper>`}%

%{escaper_719863172fd23c83a6bbcb76c7e8894d|`XSS (Cross Site Scripting) Prevention Cheat Sheet`_}%

%{escaper_08393e32d6104e8736ab5e0d3ee9aaea}%

%{escaper_728347a820344a7ff74bc9b0ae25e678}%

.. code-block:: html+php

    <?php

        //{%escaper_fb033002084e4fb9302c7210a668ad3a%}
        $maliciousTitle = '</title><script>alert(1)</script>';

        //{%escaper_cf6109a346c45d45b177223d0df2bc6f%}
        $className = ';`(';

        //{%escaper_ce0b3c63223063a5edb0a1456200c46d%}
        $fontName = 'Verdana"</style>';

        //{%escaper_1ff2721b1bbbf23e07dc268591b01e9f%}
        $javascriptText = "';</script>Hello";

        //{%escaper_08e6b5c589201a50bbeeeb8cfeb2f11f%}
        $e = new Phalcon\Escaper();

    ?>

    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <title><?php echo $e->escapeHtml($maliciousTitle) ?></title>

        <style type="text/css">
        .<?php echo $e->escapeCss($className) ?> {
            font-family  : "<?php echo $e->escapeCss($fontName) ?>";
            color: red;
        }
        </style>

    </head>

    <body>

        <div class='<?php echo $e->escapeHtmlAttr($className) ?>'>hello</div>

        <script>var some = '<?php echo $e->escapeJs($javascriptText) ?>'</script>

    </body>
    </html>


%{escaper_c1e7387e17b71462fbf37bf19d1ebe7d}%

.. figure:: ../_static/img/escape.jpeg
    :align: center



%{escaper_df58314dce8aa78978d3dd9d394a2cf8}%

%{escaper_3c421fe61d042d8a313e7f283fcb029e}%
-------------
%{escaper_f790a86819ff16026454e841b7c630fa}%

.. code-block:: html

    <div class="comments"><!-- Escape untrusted data here! --></div>


%{escaper_453ec58c3b8e94c062611d4ac8d95370}%

.. code-block:: html+php

    <div class="comments"><?php echo $e->escapeHtml('></div><h1>myattack</h1>'); ?></div>


%{escaper_823d563bfe5fbbb4610153ba6b66d847}%

.. code-block:: html

    <div class="comments">&gt;&lt;/div&gt;&lt;h1&gt;myattack&lt;/h1&gt;</div>


%{escaper_f42f900384c47be51538fd470d563966}%
------------------------
%{escaper_6cdd64981a967a030d37d6e4c4c3a323}%

.. code-block:: html

    <table width="Escape untrusted data here!"><tr><td>Hello</td></tr></table>


%{escaper_303acdc2804c0b90eeda8e10f3bf6d3d}%

.. code-block:: html+php

    <table width="<?php echo $e->escapeHtmlAttr('"><h1>Hello</table'); ?>"><tr><td>Hello</td></tr></table>


%{escaper_823d563bfe5fbbb4610153ba6b66d847}%

.. code-block:: html

    <table width="&#x22;&#x3e;&#x3c;h1&#x3e;Hello&#x3c;&#x2f;table"><tr><td>Hello</td></tr></table>


%{escaper_e419c2cf096225f2fc480b112f27843b}%
-------------
%{escaper_1d8024733f3d40e69701e669f9b269ff}%

.. code-block:: html

    <a href="Escape untrusted data here!">Some link</a>


%{escaper_1b965025fba3ac113dbff5a8832299e3}%

.. code-block:: html+php

    <a href="<?php echo $e->escapeUrl('"><script>alert(1)</script><a href="#'); ?>">Some link</a>


%{escaper_823d563bfe5fbbb4610153ba6b66d847}%

.. code-block:: html

    <a href="%22%3E%3Cscript%3Ealert%281%29%3C%2Fscript%3E%3Ca%20href%3D%22%23">Some link</a>


%{escaper_d2c884d94f0259be48956dba248a17bb}%
------------
%{escaper_b7f186024e49c2f227a7f08d30e150dd}%

.. code-block:: html

    <a style="color: Escape unstrusted data here">Some link</a>


%{escaper_1a4284c5e36261902ab8d5d69532ecf8}%

.. code-block:: html+php

    <a style="color: <?php echo $e->escapeCss('"><script>alert(1)</script><a href="#'); ?>">Some link</a>


%{escaper_823d563bfe5fbbb4610153ba6b66d847}%

.. code-block:: html

    <a style="color: \22 \3e \3c script\3e alert\28 1\29 \3c \2f script\3e \3c a\20 href\3d \22 \23 ">Some link</a>


%{escaper_efd514d03a900c8d6b17fc477111718e}%
-------------------
%{escaper_15e2319e6ab4aef1b6e849669c613e4c}%

.. code-block:: html

    <script>document.title = 'Escape untrusted data here'</script>


%{escaper_ed5d4b6ecc85f27e025028b109548085}%

