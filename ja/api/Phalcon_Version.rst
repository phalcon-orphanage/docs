Class **Phalcon\\Version**
==========================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/version.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

このクラスはインストールされたフレームワークのバージョンを参照できます。


定数
---------

*integer* **VERSION_MAJOR**

*integer* **VERSION_MEDIUM**

*integer* **VERSION_MINOR**

*integer* **VERSION_SPECIAL**

*integer* **VERSION_SPECIAL_NUMBER**

メソッド
-------

protected static  **_getVersion** ()

バージョン番号を示す。フォーマットは ABBCCDE となる。それぞれ、A はメジャーバージョン、B は 2 桁で中間バージョン、C は 2 桁でマイナーバージョン、D は特別リリース属性を示し、1 は Alpha、2 は Beta、3 は RC、4 は安定板を示す。E は特別リリースのバージョンの番号、例えば RC1 や Beta2 等を示す。



final protected static  **_getSpecial** (*mixed* $special)

特別リリースの番号を変換する。特別リリースの番号が 1 の場合、この関数は ALPHA を返す。



public static  **get** ()

アクティブなバージョンを文字列で返す。

.. code-block:: php

    <?php

     echo Phalcon\Version::get();




public static  **getId** ()

アクティブなバージョンを数値で返す。

.. code-block:: php

    <?php

     echo Phalcon\Version::getId();




public static  **getPart** (*mixed* $part)

特定の部分のバージョンを返す。渡されるパラメータが間違っている場合、全てのバージョンを返す。

.. code-block:: php

    <?php

     echo Phalcon\Version::getPart(Phalcon\Version::VERSION_MAJOR);
