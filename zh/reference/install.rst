安装（Installation）
====================
作为PHP C拓展形式的Phalcon，需要一个略微不同于传统PHP的库或框架的安装方法。你可以选择一个当前系统的一个二进制包下载，或者使用源代码构建它。

Windows
-------
要在Windows上使用Phalcon，你可以下载一个DLL库。编辑php.ini文件，并且在最后附加上：

.. code-block:: bash

    extension=php_phalcon.dll

重启你的Web服务器。

下面的视频是一个在Windows上安装Phalcon的步骤指南:

.. raw:: html

    <div align="center"><iframe src="http://player.vimeo.com/video/40265988" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>

相关指南（Related Guides）
^^^^^^^^^^^^^^^^^^^^^^^^^^
.. toctree::
    :maxdepth: 1

    xampp
    wamp

Linux/Solaris
-------------
在Linux/Solaris系统下，你能很轻易从源代码编译和安装这个拓展:

基本要求（Requirements）
^^^^^^^^^^^^^^^^^^^^^^^^
必要的包:

* PHP >= 5.3 development resources
* GCC compiler (Linux/Solaris)
* Git (如果不是已经安装在你的系统，且你没有从Github上下载这个包并通过FTP/SFTP上传到你的服务器上)

通用平台下安装指定的软件包：

.. code-block:: bash

    # Ubuntu
    sudo apt-get install php5-dev libpcre3-dev gcc make php5-mysql

    # Suse
    sudo yast -i gcc make autoconf php5-devel php5-pear php5-mysql

    # CentOS/RedHat/Fedora
    sudo yum install php-devel pcre-devel gcc make

    # Solaris
    pkg install gcc-45 php-53 apache-php53

编译（Compilation）
^^^^^^^^^^^^^^^^^^^
创建扩展:

.. code-block:: bash

    git clone --depth=1 git://github.com/phalcon/cphalcon.git
    cd cphalcon/build
    sudo ./install

添加扩展到你的php配置文件:

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

重启Web服务器.

如果你在 Ubuntu/Debian 下使用 php5-fpm，重启命令为：

.. code-block:: bash

    sudo service php5-fpm restart

Phalcon自动检测你的系统架构，然而，您可以强制编译为一个特定的架构：

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

* PHP >= 5.4 development resources
* XCode

.. code-block:: bash

    # brew
    brew tap homebrew/homebrew-php
    brew install php54-phalcon
    brew install php55-phalcon
    brew install php56-phalcon

    # MacPorts
    sudo port install php54-phalcon
    sudo port install php55-phalcon
    sudo port install php56-phalcon

Add extension to your PHP configuration.

FreeBSD
-------
对于FreeBSD，仅仅只需要简单的命令进行安装：

.. code-block:: bash

    pkg_add -r phalcon

或者

.. code-block:: bash

    export CFLAGS="-O2 --fvisibility=hidden"
    cd /usr/ports/www/phalcon && make install clean

安装说明（Installation Notes）
------------------------------
常见Web服务器的安装说明：

.. toctree::
    :maxdepth: 1

    apache
    nginx
    cherokee
    built-in
