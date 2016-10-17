インストール
============
PHP 拡張モジュールは、従来の PHP ベースのライブラリやフレームワークとは若干異なるインストール方法をとります。
あなたのシステム向けのバイナリパッケージをダウンロードするか、ソースコードからビルドする２つの方法があります。

Windows
-------
Windows 上で Phalcon を使用するには、DLLライブラリをダウンロードします。そして php.ini を編集し、最後に次の行を追加します。

.. code-block:: bash

    extension=php_phalcon.dll

最後に WEB サーバーを再起動します。

次のスクリーンキャストは、Windows 上に Phalcon をインストールするステップバイステップガイドです。

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

Debian / Ubuntu
^^^^^^^^^^^^^^^
下記の方法でディストリビューションにリポジトリを追加します:

.. code-block:: bash

    # 安定板
    curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash

    # ナイトリービルド
    curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.deb.sh | sudo bash

この作業は、あなたがディストリビューションを変更したり安定板とナイトリーを選び直すといった事情がなければ、実施は一度だけしか必要ありません。

Phalcon をインストールするには:

.. code-block:: bash

    sudo apt-get install php5-phalcon

    # PHP 7 の場合

    sudo apt-get install php7.0-phalcon

RPM ディストリビューション (CentOS 等)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
下記の方法でディストリビューションにリポジトリを追加します:

.. code-block:: bash

    # 安定板
    curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.rpm.sh | sudo bash

    # ナイトリービルド
    curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.rpm.sh | sudo bash

この作業は、あなたがディストリビューションを変更したり安定板とナイトリーを選び直すといった事情がなければ、実施は一度だけしか必要ありません。

Phalcon をインストールするには:

.. code-block:: bash

    sudo yum install php56u-phalcon

    # PHP 7 の場合
｀
    sudo yum install php70u-phalcon

ソースからコンパイルする
^^^^^^^^^^^^^^^^^^^
Linux/Solaris の環境では、簡単に拡張モジュールをソースコードからコンパイルしてインストールすることができます。

必要となるパッケージは次の通りです：

* PHP >= 5.5 開発リソース
* GCC コンパイラ (Linux/Solaris)
* Git (まだインストールしていないなら。GitHub からダウンロードしたり、サーバーには FTP/SFTP でアップロードでもしない限り、すでに入っていると思いますが)

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

拡張モジュールの作成：

.. code-block:: bash

    git clone git://github.com/phalcon/cphalcon.git

    cd cphalcon/build

    sudo ./install

php.ini に拡張モジュールを追加します。

.. code-block:: bash

    # Suse の場合: /etc/php5/conf.d/ に下記内容が書いてある phalcon.ini を追加します:
    extension=phalcon.so

    # CentOS/RedHat/Fedora の場合: /etc/php.d/ に下記内容が書いてある phalcon.ini を追加します:
    extension=phalcon.so

    # Ubuntu/Debian、Apache2 で構成している場合: /etc/php5/apache2/conf.d/ に、下記内容の 30-phalcon.ini を追加します:
    extension=phalcon.so

    # Ubuntu/Debian、php5-fpm で構成している場合: /etc/php5/fpm/conf.d/ に、下記内容の 30-phalcon.ini を追加します:
    extension=phalcon.so

    # Ubuntu/Debian、php5-cli で構成している場合: /etc/php5/cli/conf.d/ に、下記内容の 30-phalcon.ini を追加します:
    extension=phalcon.so

最後に WEB サーバーを再起動します。

Ubuntu/Debian、php5-fpm で構成している場合は、これも再起動します:

.. code-block:: bash

    sudo service php5-fpm restart

Phalcon は自動的にシステムのアーキテクチャを判定しますが、指定したアーキテクチャ向けにコンパイルすることを強制することができます。

.. code-block:: bash

    cd cphalcon/build

    # 次のどれか一つ:
    sudo ./install 32bits
    sudo ./install 64bits
    sudo ./install safe

自動判別インストーラが失敗する場合は手動でビルドしてみます:

.. code-block:: bash

    cd cphalcon/build/64bits

    export CFLAGS="-O2 --fvisibility=hidden"

    ./configure --enable-phalcon

    make && sudo make install

Mac OS X
--------
macOS, OS X システムではソースコードからコンパイル、そしてインストールすることができます:

前提条件
^^^^^^^^^^^^
必須パッケージは下記の通り:

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

これであなたの PHP 環境に拡張モジュールが入ります。

FreeBSD
-------
FreeBSD では port を利用することができます。インストールするには、次のシンプルなコマンドを叩くだけです。

.. code-block:: bash

    pkg_add -r phalcon

または

.. code-block:: bash

    export CFLAGS="-O2 --fvisibility=hidden"

    cd /usr/ports/www/phalcon

    make install clean

インストールの確認
------------------
:code:`phpinfo()` の "Phalcon" のセクションの出力を確認するか、 次のコードスニペットを実行してみてください。

.. code-block:: php

    <?php print_r(get_loaded_extensions()); ?>

Phalcon 拡張モジュールは下記のように出力の一部に現れるでしょう。

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
各 WEB サーバーにおけるインストールノート

.. toctree::
    :maxdepth: 1

    apache
    nginx
    cherokee
    built-in
