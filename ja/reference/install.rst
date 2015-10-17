インストール
======
PHP拡張モジュールは、従来のPHPベースのライブラリやフレームワークとは若干異なるインストール方法をとります。
あなたのシステム向けのバイナリパッケージをダウンロードするか、ソースコードからビルドする２つの方法があります。

.. highlights::
    PhalconはPHP 5.3.1以降でコンパイルできますが、古いPHPはメモリリークを引き起こすバグがあるため、少なくとも PHP 5.3.11以降を使用することを推奨しています。

.. highlights::
   PHP 5.3.9 以前のものには、いくつかのセキュリティ的な欠陥があり、商用環境のWEBサイトでの使用は推奨しておりません。 `詳細はこちら <http://www.infoworld.com/d/security/php-539-fixes-hash-collision-dos-vulnerability-183947>`_

Windows
-------
Windows上でPhalconを使用するには、DLLライブラリをダウンロードします。そして php.iniを編集し、最後に次の行を追加します。

    extension=php_phalcon.dll

最後にWEBサーバーを再起動します。

次のスクリーンキャストは、Windows上にPhalconをインストールするステップバイステップガイドです。

.. raw:: html

    <div align="center"><iframe src="http://player.vimeo.com/video/40265988" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>

関連ガイド
^^^^^^^^^^^^^^
.. toctree::
    :maxdepth: 1

    xampp
    wamp

Linux/Solaris/Mac
-----------------
Linux/Solaris/Mac の環境では、簡単に拡張モジュールをソースコードからコンパイルしてインストールすることができます。

必要条件
^^^^
必要となるパッケージは次の通りです：

* PHP 5.3.x/5.4.x/5.5.x development resources
* GCC compiler (Linux/Solaris) or Xcode (Mac)
* Git (if not already installed in your system - unless you download the package from GitHub and upload it on your server via FTP/SFTP)

一般的なプラットフォームにおける具体的なパッケージ:

.. code-block:: bash

    #Ubuntu
    sudo apt-get install git-core gcc autoconf
    sudo apt-get install php5-dev php5-mysql

    #Suse
    sudo yast -i gcc make autoconf2.13
    sudo yast -i php5-devel php5-pear php5-mysql

    #CentOS/RedHat
    sudo yum install gcc make
    sudo yum install php-devel

    #Solaris
    pkg install gcc-45
    pkg install php-53 apache-php53

コンパイル
^^^^^
拡張モジュールの作成：

.. code-block:: bash

    git clone git://github.com/phalcon/cphalcon.git
    cd cphalcon/build
    sudo ./install

php.iniに拡張モジュールを追加します。

.. code-block:: bash

    extension=phalcon.so

最後にWEBサーバーを再起動します。

Phalconは自動的にシステムのアーキテクチャを判定しますが、指定したアーキテクチャ向けにコンパイルすることを強制することができます。

.. code-block:: bash

    sudo ./install 32bits
    sudo ./install 64bits
    sudo ./install safe

FreeBSD
-------
FreeBSDではportを利用することができます。インストールするには、次のシンプルなコマンドを叩くだけです。

.. code-block:: bash

    pkg_add -r phalcon

or

.. code-block:: bash

    export CFLAGS="-O2 -fno-delete-null-pointer-checks"
    cd /usr/ports/www/phalcon && make install clean

インストール ノート
----------
各WEBサーバーにおけるインストールノート

.. toctree::
    :maxdepth: 1

    apache
    nginx
    cherokee
    built-in
