安装
====

与传统的基于 PHP 开发的库和框架不同，PHP 扩展需要一个略微不同的安装方法。你可以下载适合你的系统的二进制包或者使用源代码编译。

During the last few months, we have extensively researched PHP's behavior, investigating areas for significant optimizations (big or small). Through understanding of the Zend Engine, we managed to remove unecessary validations, compacted code, performed optimizations and generated low-level solutions so as to achieve maximum performance from Phalcon.

.. highlights::
   Phalcon 可以在 PHP 5.3.1 上编译，但存在陈旧的 PHP 错误导致内存泄漏，我们强烈建议使用 PHP 5.3.11 或以上版本.

Windows
-------

在 windows 上安装任何扩展都是很简单的，安装 phalcon 也是一样，下载 .dll 文件，放到 extension 目录，然后修改 php.ini 文件，加入以下行：

    extension=php_phalcon.dll

重启 web server.

以下视频是教你如何一步一步在 windows 上安装 phalcon

.. raw:: html

   <div align="center"><iframe src="http://player.vimeo.com/video/40265988" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>

相关教程
^^^^^^^^

.. toctree::
   :maxdepth: 1

   xampp
   wamp

Unix/Linux
----------

在 Unix/Linux 操作系统上，你可以很容易的从源代码编译和安装扩展

系统需求
^^^^^^^^
需要的软件包如下：

* PHP 5.x 开发资源
* GCC 编译器 (Linux) 或 Xcode (Mac)
* Git (如果没有预装在系统上，也可以在服务器上使用 FTP/SFTP 从 Github 下载源代码包)

.. code-block:: bash

    #Ubuntu
    sudo apt-get install php5-dev php5-mysql gcc
    sudo apt-get install git-core

    #Suse
    yast2 -i php5-pear php5-dev php5-mysql gcc
    yast2 -i git-core

编译
^^^^
创建扩展：

.. code-block:: bash

    git clone git://github.com/phalcon/cphalcon.git
    cd cphalcon/build
    ./install

（译者备注）./install 其实是默认包含了 phpize, configure, make, make install 命令。如果您的机器中 phpize, php-config 不在环境命令中，请执行以下操作后再执行 ./install

.. code-block:: bash

   ln -s phpdir/bin/phpize /usr/bin
   ln -s phpdir/bin/php-cofnig /usr/bin

phpdir 是你的 php 安装路径。

编辑 php.ini 文件，加入扩展

.. code-block:: bash

    extension=phalcon.so

重启 web server，如果是 php-fpm，重启 php-fpm 即可

FreeBSD
^^^^^^^
FreeBSD 下已有 port 安装，仅需要简单的命令就可以安装：

.. code-block:: bash

    pkg_add -r phalcon

or

.. code-block:: bash

    export CFLAGS="-O2 -fno-delete-null-pointer-checks"
    cd /usr/ports/www/phalcon && make install clean

安装说明
^^^^^^^^

Web 服务器安装说明如下：

.. toctree::
   :maxdepth: 1

   nginx

