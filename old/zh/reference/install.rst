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

    <div align="center"><iframe src="https://player.vimeo.com/video/40265988" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>

相关指南（Related Guides）
^^^^^^^^^^^^^^^^^^^^^^^^^^
.. toctree::
    :maxdepth: 1

    xampp
    wamp

Linux/Solaris
-------------

Debian / Ubuntu
^^^^^^^^^^^^^^^
添加仓库到你的分发:

.. code-block:: bash

    # 稳定版本
    curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash

    # 试运行版
    curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.deb.sh | sudo bash

这个仅仅需要做一次, 除非你的distribution发生了变化或者你想选择从稳定版切换到试运行版.

安装 Phalcon:

.. code-block:: bash

    sudo apt-get install php5-phalcon

    # 或者 PHP7 版本

    sudo apt-get install php7.0-phalcon

RPM分发(RPM distributions) (比如 CentOS)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
添加仓库到你的分发:

.. code-block:: bash

    # 稳定版本
    curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.rpm.sh | sudo bash

    # 试运行版
    curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.rpm.sh | sudo bash

这个仅仅需要做一次, 除非你的distribution发生了变化或者你想选择从稳定版切换到试运行版.

安装 Phalcon:

.. code-block:: bash

    sudo yum install php56u-phalcon

    # 或者 PHP7 版本

    sudo yum install php70u-phalcon

从源码编译(Compile from source)
^^^^^^^^^^^^^^^^^^^
在Linux/Solaris系统下，你能很轻易从源代码编译和安装这个拓展:

必要的包:

* PHP >= 5.5 开发资源
* GCC 编译器 (Linux/Solaris)
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
    pkg install gcc-45 php-56 apache-php56

创建扩展:

.. code-block:: bash

    git clone git://github.com/phalcon/cphalcon.git

    cd cphalcon/build

    sudo ./install

添加扩展到你的php配置文件:

.. code-block:: bash

    # Suse: 在 /etc/php5/conf.d/ 目录下添加一个名为 phalcon.ini 的文件, 内容如下:
    extension=phalcon.so

    # CentOS/RedHat/Fedora: 在 /etc/php.d/ 目录下添加一个名为 phalcon.ini 的文件, 内容如下:
    extension=phalcon.so

    # Ubuntu/Debian with apache2: 在 /etc/php5/apache2/conf.d/ 目录下添加一个名为 30-phalcon.ini 的文件, 内容如下:
    extension=phalcon.so

    # Ubuntu/Debian with php5-fpm: 在 /etc/php5/fpm/conf.d/ 目录下添加一个名为 30-phalcon.ini 的文件, 内容如下:
    extension=phalcon.so

    # Ubuntu/Debian with php5-cli: 在 /etc/php5/cli/conf.d/ 目录下添加一个名为 30-phalcon.ini 的文件, 内容如下:
    extension=phalcon.so

重启Web服务器.

如果你在 Ubuntu/Debian 下使用 php5-fpm，重启命令为：

.. code-block:: bash

    sudo service php5-fpm restart

Phalcon自动检测你的系统架构，然而，您可以强制编译为一个特定的架构：

.. code-block:: bash

    cd cphalcon/build

    # 下面的选择一个执行:
    sudo ./install 32bits
    sudo ./install 64bits
    sudo ./install safe

如果自动安装失败，请尝试手动编译安装：

.. code-block:: bash

    cd cphalcon/build/64bits

    export CFLAGS="-O2 --fvisibility=hidden"

    ./configure --enable-phalcon

    make && sudo make install

Mac OS X
--------
在Mac OS X系统中你可以通过源代码来编译和安装扩展：

要求
^^^^^^^^^^^^
提前要有的包:

* PHP >= 5.5 开发资源
* XCode

.. code-block:: bash

    # brew
    brew tap homebrew/homebrew-php
    brew install php55-phalcon
    brew install php56-phalcon

    # MacPorts
    sudo port install php55-phalcon
    sudo port install php56-phalcon

添加扩展到你的PHP配置文件。

FreeBSD
-------
对于FreeBSD，仅仅只需要简单的命令进行安装：

.. code-block:: bash

    pkg_add -r phalcon

或者

.. code-block:: bash

    export CFLAGS="-O2 --fvisibility=hidden"

    cd /usr/ports/www/phalcon

    make install clean

确认安装（Checking your installation）
--------------------------------------
请检查你的 :code:`phpinfo()` 输出了一个"Phalcon"部分引用或者执行以下代码片段:

.. code-block:: php

    <?php print_r(get_loaded_extensions()); ?>

Phalcon 拓展应该作为输出的一部分出现:

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

安装说明（Installation Notes）
------------------------------
常见Web服务器的安装说明：

.. toctree::
    :maxdepth: 1

    apache
    nginx
    cherokee
    built-in
