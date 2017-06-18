上下文编码（Contextual Escaping）
=================================

网站及其它B/S应用极易受到 XSS_ 攻击，尽管PHP提供了转义功能，在某些情况下依然不够安全。在Phalcon中 :doc:`Phalcon\\Escaper <../api/Phalcon_Escaper>` 提供了上下文转义功能，这个模块是由C语言实现的，
这在进行转义时可以有更好的性能。

Phalcon的上下文转义组件基于 OWASP_ 提供的`XSS (Cross Site Scripting) 预防作弊表`_

另外，这个组件依赖于 mbstring_ 扩展，以支持几乎所有的字符集。

下面的例子中展示了这个组件是如何工作的：

.. code-block:: html+php

    <?php

    use Phalcon\Escaper;

    // 带有额外的html标签的恶意的文档标题
    $maliciousTitle = "</title><script>alert(1)</script>";

    // 恶意的css类名
    $className = ";`(";

    // 恶意的css字体名
    $fontName = "Verdana\"</style>";

    // 恶意的Javascript文本
    $javascriptText = "';</script>Hello";

    // 创建转义实例对象
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

结果如下：

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

Phalcon会根据文本所处的上下文进行转义。 恰当的上下文环境对防范XSS攻击来说是非常重要的。

HTML 编码（Escaping HTML）
--------------------------
最不安全的情形即是在html标签中插入非安全的数据。

.. code-block:: html

    <div class="comments">
        <!-- Escape untrusted data here! -->
    </div>

我们可以使用 :code:`escapeHtml` 方法对这些文本进行转义：

.. code-block:: html+php

    <div class="comments">
        <?php echo $e->escapeHtml('></div><h1>myattack</h1>'); ?>
    </div>

结果如下：

.. code-block:: html

    <div class="comments">
        &gt;&lt;/div&gt;&lt;h1&gt;myattack&lt;/h1&gt;
    </div>

HTML 属性编码（Escaping HTML Attributes）
-----------------------------------------
对html属性进行转义和对html内容进行转义略有不同。对html的属性进行转义是通过对所有的非字母和数字转义来实现的。类例的转义都会如此进行的，除了一些复杂的属性外如：href和url:

.. code-block:: html

    <table width="Escape untrusted data here!">
        <tr>
            <td>
                Hello
            </td>
        </tr>
    </table>

我们这里使用 :code:`escapeHtmlAttr` 方法对html属性进行转义：

.. code-block:: html+php

    <table width="<?php echo $e->escapeHtmlAttr('"><h1>Hello</table'); ?>">
        <tr>
            <td>
                Hello
            </td>
        </tr>
    </table>

结果如下：

.. code-block:: html

    <table width="&#x22;&#x3e;&#x3c;h1&#x3e;Hello&#x3c;&#x2f;table">
        <tr>
            <td>
                Hello
            </td>
        </tr>
    </table>

URL 编码（Escaping URLs）
-------------------------
一些html的属性如href或url需要使用特定的方法进行转义：

.. code-block:: html

    <a href="Escape untrusted data here!">
        Some link
    </a>

我们这里使用 :code:`escapeUrl` 方法进行url的转义：

.. code-block:: html+php

    <a href="<?php echo $e->escapeUrl('"><script>alert(1)</script><a href="#'); ?>">
        Some link
    </a>

结果如下：

.. code-block:: html

    <a href="%22%3E%3Cscript%3Ealert%281%29%3C%2Fscript%3E%3Ca%20href%3D%22%23">
        Some link
    </a>

CSS 编码（Escaping CSS）
------------------------
CSS标识/值也可以进行转义:

.. code-block:: html

    <a style="color: Escape untrusted data here">
        Some link
    </a>

这里我们使用 :code:`escapeCss` 方法进行转义：

.. code-block:: html+php

    <a style="color: <?php echo $e->escapeCss('"><script>alert(1)</script><a href="#'); ?>">
        Some link
    </a>

结果：

.. code-block:: html

    <a style="color: \22 \3e \3c script\3e alert\28 1\29 \3c \2f script\3e \3c a\20 href\3d \22 \23 ">
        Some link
    </a>

JavaScript 编码（Escaping JavaScript）
--------------------------------------
插入JavaScript代码的字符串也需要进行适当的转义：

.. code-block:: html

    <script>
        document.title = 'Escape untrusted data here';
    </script>

这里我们使用 :code:`escapeJs` 进行转义：

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
.. _`XSS (Cross Site Scripting) 预防作弊表`: https://www.owasp.org/index.php/XSS_(Cross_Site_Scripting)_Prevention_Cheat_Sheet
.. _mbstring: http://php.net/manual/en/book.mbstring.php
