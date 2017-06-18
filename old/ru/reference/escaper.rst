Контекстное экранирование
=========================

Веб-сайты и веб приложения уязвимы к XSS_-атакам, несмотря на то, что PHP предоставляет некоторое количество функция для
экранирования, в некоторых случаях этого бывает недостаточно. Класс :doc:`Phalcon\\Escaper <../api/Phalcon_Escaper>` предоставляет
контекстное экранирование, позволяя выполнять экранированию любых текстов с минимальными затратами ресурсов.

Мы разработали компонент, базируемый на `XSS (Cross Site Scripting) Prevention Cheat Sheet`_ , созданный в OWASP_.

Этот компонент полагается на mbstring_ для того, чтобы поддерживать любую кодировку.

Для демонстрации работы компонента и его важности рассмотрим следующий пример:

.. code-block:: html+php

    <?php

    use Phalcon\Escaper;

    // Заголовок документа с вредоносным кодом
    $maliciousTitle = "</title><script>alert(1)</script>";

    // Вредоносные название CSS класса
    $className = ";`(";

    // Вредоносное название CSS шрифта
    $fontName = "Verdana\"</style>";

    // Вредоносный Javascript текст
    $javascriptText = "';</script>Hello";

    // Создаем компонент экранирования
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

В итоге получим такой HTML документ:

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

Все текстовые переменные были экранированы в соответствии с их контекстом. Использование необходимого контекста важно во избежания XSS-атак.

Экранирование HTML
------------------
Наиболее распространенная ситуация при вставке небезопасных данных между HTML-тегами:

.. code-block:: html

    <div class="comments">
        <!-- Экранируем данные, которым не доверяем! -->
    </div>

Вы можете экранировать эти данные с помощью метода :code:`escapeHtml`:

.. code-block:: html+php

    <div class="comments">
        <?php echo $e->escapeHtml('></div><h1>myattack</h1>'); ?>
    </div>

Что приведет к:

.. code-block:: html

    <div class="comments">
        &gt;&lt;/div&gt;&lt;h1&gt;myattack&lt;/h1&gt;
    </div>

Экранирование HTML-атрибутов
----------------------------
Экранирование HTML-атрибутов отличается от простого экранирования HTML-контента. Экранирование изменяет все символы,
не являющиеся буквами или цифрами. Этот вид экранирования предназначен для самых простых атрибутов, без учета сложных, таких как 'href' или 'url':

.. code-block:: html

    <table width="Экранируем данные, которым не доверяем!">
        <tr>
            <td>
                Привет
            </td>
        </tr>
    </table>

Вы можете экранировать HTML-атрибуты, используя метод escapeHtmlAttr:

.. code-block:: html+php

    <table width="<?php echo $e->escapeHtmlAttr('"><h1>Привет</table'); ?>">
        <tr>
            <td>
                Привет
            </td>
        </tr>
    </table>

Что приведет к:

.. code-block:: html

    <table width="&#x22;&#x3e;&#x3c;h1&#x3e;Hello&#x3c;&#x2f;table">
        <tr>
            <td>
                Привет
            </td>
        </tr>
    </table>

Экранирование ссылок
--------------------
Некоторые атрибуты, такие как 'href' или 'url' необходимо экранировать по-другому:

.. code-block:: html

    <a href="Экранируем данные, которым не доверяем!">
        Some link
    </a>

Вы можете экранировать этот HTML-атрибут, используя метод :code:`escapeUrl`:

.. code-block:: html+php

    <a href="<?php echo $e->escapeUrl('"><script>alert(1)</script><a href="#'); ?>">
        Ссылка
    </a>

Что приведет к:

.. code-block:: html

    <a href="%22%3E%3Cscript%3Ealert%281%29%3C%2Fscript%3E%3Ca%20href%3D%22%23">
        Ссылка
    </a>

Экранирование CSS
-----------------
CSS идентификаторы/значения также могут быть экранированы:

.. code-block:: html

    <a style="color: Экранируем данные, которым не доверяем!">
        Ссылка
    </a>

Экранирование в этом случае можно выполнить с помощью метода :code:`escapeCss`:

.. code-block:: html+php

    <a style="color: <?php echo $e->escapeCss('"><script>alert(1)</script><a href="#'); ?>">
        Ссылка
    </a>

Что приведет к:

.. code-block:: html

    <a style="color: \22 \3e \3c script\3e alert\28 1\29 \3c \2f script\3e \3c a\20 href\3d \22 \23 ">
        Ссылка
    </a>

Экранирование JavaScript
------------------------
Строки, которые попадают в код JavaScript, тоже должны быть правильно экранированы:

.. code-block:: html

    <script>
        document.title = 'Экранируем данные, которым не доверяем!';
    </script>

Для этого используем метод :code:`escapeJs`:

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
.. _mbstring: http://php.net/manual/ru/book.mbstring.php
