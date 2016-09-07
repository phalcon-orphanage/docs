インストール
============
PHP拡張モジュールは、従来のPHPベースのライブラリやフレームワークとは若干異なるインストール方法をとります。
あなたのシステム向けのバイナリパッケージをダウンロードするか、ソースコードからビルドする２つの方法があります。

Windows
-------
Windows上でPhalconを使用するには、DLLライブラリをダウンロードします。そして php.iniを編集し、最後に次の行を追加します。

.. code-block:: bash

    extension=php_phalcon.dll

最後にWEBサーバーを再起動します。

次のスクリーンキャストは、Windows上にPhalconをインストールするステップバイステップガイドです。

.. raw:: html

    <div align="center"><iframe src="https://player.vimeo.com/video/40265988" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>

関連ガイド
^^^^^^^^^^^^^^
.. toctree::
    :maxdepth: 1

    xampp
    wamp

Linux/Solaris
-------------
Linux/Solaris の環境では、簡単に拡張モジュールをソースコードからコンパイルしてインストールすることができます。

必要条件
^^^^^^^^
必要となるパッケージは次の通りです：

* PHP >= 5.5 development resources
* GCC compiler (Linux/Solaris)
* Git (if not already installed in your system - unless you download the package from GitHub and upload it on your server via FTP/SFTP)

一般的なプラットフォームにおける具体的なパッケージ:

.. code-block:: bash

    # Ubuntu
    sudo apt-get install php5-dev libpcre3-dev gcc make php5-mysql

    # Suse
    sudo yast -i gcc make autoconf php5-devel php5-pear php5-mysql

    # CentOS/RedHat/Fedora
    sudo yum install php-devel pcre-devel gcc make

    # Solaris
    pkg install gcc-45 php-56 apache-php56

コンパイル
^^^^^^^^^^
拡張モジュールの作成：

.. code-block:: bash

    git clone --depth=1 git://github.com/phalcon/cphalcon.git
    cd cphalcon/build
    sudo ./install

php.iniに拡張モジュールを追加します。

.. code-block:: bash

    # Suse: Add a file called phalcon.ini in /etc/php5/conf.d/ with this content:
    extension=phalcon.so

    # CentOS/RedHat/Fedora: Add a file called phalcon.ini in /etc/php.d/ with this content:
    extension=phalcon.so

    # Ubuntu/Debian with apache2: Add a file called 30-phalcon.ini in /etc/php5/apache2/conf.d/ with this content:
    extension=phalcon.so

    # Ubuntu/Debian with php5-fpm: Add a file called 30-phalcon.ini in /etc/php5/fpm/conf.d/ with this content:
    extension=phalcon.so

    # Ubuntu/Debian with php5-cli: Add a file called 30-phalcon.ini in /etc/php5/cli/conf.d/ with this content:
    extension=phalcon.so

最後にWEBサーバーを再起動します。

If you are running Ubuntu/Debian with php5-fpm, restart it:

.. code-block:: bash

    sudo service php5-fpm restart

Phalconは自動的にシステムのアーキテクチャを判定しますが、指定したアーキテクチャ向けにコンパイルすることを強制することができます。

.. code-block:: bash

    cd cphalcon/build
    sudo ./install 32bits
    sudo ./install 64bits
    sudo ./install safe

If the automatic installer fails try building the extension manually:

.. code-block:: bash

    cd cphalcon/build/64bits
    export CFLAGS="-O2 --fvisibility=hidden"
    ./configure --enable-phalcon
    make && sudo make install

Mac OS X
--------
On a Mac OS X system you can compile and install the extension from the source code:

Requirements
^^^^^^^^^^^^
Prerequisite packages are:

* PHP >= 5.5 development resources
* XCode

.. code-block:: bash

    # brew
    brew tap homebrew/homebrew-php
    brew install php55-phalcon
    brew install php56-phalcon

    # MacPorts
    sudo port install php55-phalcon
    sudo port install php56-phalcon

Add extension to your PHP configuration.

FreeBSD
-------
FreeBSDではportを利用することができます。インストールするには、次のシンプルなコマンドを叩くだけです。

.. code-block:: bash

    pkg_add -r phalcon

or

.. code-block:: bash

    export CFLAGS="-O2 --fvisibility=hidden"
    cd /usr/ports/www/phalcon && make install clean

インストールの確認
------------------
:code:`phpinfo()` の "Phalcon"のセクションの出力を確認するか、 次のコードスニペットを実行してみてください。

.. code-block:: php

    <?php print_r(get_loaded_extensions()); ?>

Phalcon拡張モジュールは下記のように出力の一部に現れるでしょう。

.. code-block:: php

    Array
    (
        [0] => Core
        [1] => libxml
        [2] => filter
        [3] => SPL
        [4] => standard
        [5] => phalcon
        [6] => pdo_mysql
    )

インストール ノート
-------------------
各WEBサーバーにおけるインストールノート

.. toctree::
    :maxdepth: 1

    apache
    nginx
    cherokee
    built-in
