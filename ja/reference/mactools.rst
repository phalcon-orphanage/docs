Phalcon 開発者ツール / Mac OS X 向け
===================================

下記のステップは OS X / macOS に Phalcon 開発者ツールをインストールするための手順を示すものです。

前提条件
-------------
Phalcon 開発者ツールの実行には、Phalcon PHP 拡張が必須です。もしまだインストールしていないのなら、:doc:`インストール <install>` のセクションを参照してください。

ダウンロード
--------
Download_ セクションで、開発者ツールを同梱したクロスプラットフォームのパッケージがダウンロードできます。また、Github_ から clone でもできます。

ターミナルアプリケーションを開き:

.. figure:: ../_static/img/mac-1.png
   :align: center

コピー & ペーストでターミナルに下記のコマンドを貼り付けます:

.. code-block:: bash

    git clone git://github.com/phalcon/phalcon-devtools.git

ツールを clone したフォルダに移動し、". ./phalcon.sh" を実行します（コマンドの最初のドットを忘れないでください）。:

.. code-block:: bash

    cd phalcon-devtools/

    . ./phalcon.sh

ターミナルで次のコマンドを入力し、スクリプト phalcon.php へのシンボリックリンクを作成します。:

.. code-block:: bash

    ln -s ~/phalcon-tools/phalcon.php ~/phalcon-tools/phalcon

    chmod +x ~/phalcon-tools/phalcon

"phalcon" とコマンドを入力すると下記のようになります。:

.. figure:: ../_static/img/mac-5.png
   :align: center

   おめでとうございます！これで Phalcon 開発者ツールがインストールされました！

関連ガイド
^^^^^^^^^^^^^^
* :doc:`Phalcon 開発者ツール <tools>`
* :doc:`Phalcon 開発者ツール / Windows 向け <wintools>`
* :doc:`Phalcon 開発者ツール / Linux 向け <linuxtools>`

.. _Download: http://phalconphp.com/download
.. _Github: https://github.com/phalcon/phalcon-devtools
