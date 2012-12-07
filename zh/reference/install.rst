安装
<<<<<<< HEAD
====

与传统的基于 PHP 开发的库和框架不同，PHP 扩展需要一个略微不同的安装方法。你可以下载适合你的系统的二进制包或者使用源代码编译。
=======
============

PHP extensions require a slightly different installation method to a traditional php-based library or framework. You can either download a binary package for the system of your choice or build it from the sources.
>>>>>>> 0.7.0

During the last few months, we have extensively researched PHP's behavior, investigating areas for significant optimizations (big or small). Through understanding of the Zend Engine, we managed to remove unecessary validations, compacted code, performed optimizations and generated low-level solutions so as to achieve maximum performance from Phalcon.

.. highlights::
<<<<<<< HEAD
   Phalcon 可以在 PHP 5.3.1 上编译，但存在陈旧的 PHP 错误导致内存泄漏，我们强烈建议使用 PHP 5.3.11 或以上版本.
=======
   Phalcon compiles from PHP 5.3.1, but due to old PHP bugs causing memory leaks, we highly recommend you to use at least PHP 5.3.11 or greater.
>>>>>>> 0.7.0

Windows
-------

<<<<<<< HEAD
在 windows 上安装任何扩展都是很简单的，安装 phalcon 也是一样，下载 .dll 文件，放到 extension 目录，然后修改 php.ini 文件，加入以下行：

    extension=php_phalcon.dll

重启 web server.

以下视频是教你如何一步一步在 windows 上安装 phalcon
=======
在windows上安装任何扩展都是很简单的，安装phalcon也是一样，下载.dll文件，放到extension目录，然后修改php.ini文件，加入以下行：

    extension=php_phalcon.dll

重启web server.

以下视频是教你如何一步一步在windows上安装phalcon
>>>>>>> 0.7.0

.. raw:: html

   <div align="center"><iframe src="http://player.vimeo.com/video/40265988" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>

<<<<<<< HEAD
相关教程
^^^^^^^^
=======
Related Guides
^^^^^^^^^^^^^^
>>>>>>> 0.7.0

.. toctree::
   :maxdepth: 1

   xampp
   wamp

Unix/Linux
----------

<<<<<<< HEAD
在 Unix/Linux 操作系统上，你可以很容易的从源代码编译和安装扩展

系统需求
^^^^^^^^
需要的软件包如下：

* PHP 5.x 开发资源
* GCC 编译器 (Linux) 或 Xcode (Mac)
* Git (如果没有预装在系统上，也可以在服务器上使用 FTP/SFTP 从 Github 下载源代码包)
=======
在Unix/Linux操作系统上，你可以很容易的从源代友编译和安装扩展

Requirements
^^^^^^^^^^^^
Prerequisite packages are:

* PHP 5.x development resources
* GCC compiler (Linux) or Xcode (Mac)
* Git (if not already installed in your system - unless you download the package from GitHub and upload it on your server via FTP/SFTP)
>>>>>>> 0.7.0

.. code-block:: bash

    #Ubuntu
    sudo apt-get install php5-dev php5-mysql gcc
    sudo apt-get install git-core

    #Suse
    yast2 -i php5-pear php5-dev php5-mysql gcc
    yast2 -i git-core

<<<<<<< HEAD
编译
^^^^
创建扩展：
=======
Compilation
^^^^^^^^^^^
Creating the extension:
>>>>>>> 0.7.0

.. code-block:: bash

    git clone git://github.com/phalcon/cphalcon.git
    cd cphalcon/build
    ./install

<<<<<<< HEAD
（译者备注）./install 其实是默认包含了 phpize, configure, make, make install 命令。如果您的机器中 phpize, php-config 不在环境命令中，请执行以下操作后再执行 ./install
=======
（译者备注）./install其实是默认包含了phpize,configure,make,make install命令。如果您的机器中phpize,php-config不在环境命令中，请执行以下操作后再执行./install
>>>>>>> 0.7.0

.. code-block:: bash

   ln -s phpdir/bin/phpize /usr/bin
   ln -s phpdir/bin/php-cofnig /usr/bin

<<<<<<< HEAD
phpdir 是你的 php 安装路径。

编辑 php.ini 文件，加入扩展
=======
phpdir是你的php安装路径。

编辑php.ini文件，加入扩展
>>>>>>> 0.7.0

.. code-block:: bash

    extension=phalcon.so

<<<<<<< HEAD
重启 web server，如果是 php-fpm，重启 php-fpm 即可

FreeBSD
^^^^^^^
FreeBSD 下已有 port 安装，仅需要简单的命令就可以安装：
=======
重启web server,如果是php-fpm,重启php-fpm即可

FreeBSD
^^^^^^^
A port is available for FreeBSD. Just only need these simple line commands to install it:
>>>>>>> 0.7.0

.. code-block:: bash

    pkg_add -r phalcon

or

.. code-block:: bash

    export CFLAGS="-O2 -fno-delete-null-pointer-checks"
    cd /usr/ports/www/phalcon && make install clean

<<<<<<< HEAD
安装说明
^^^^^^^^

Web 服务器安装说明如下：

.. toctree::
   :maxdepth: 1

=======
Installation Notes
^^^^^^^^^^^^^^^^^^

Installation notes for Web Servers:

.. toctree::
   :maxdepth: 1
   
   apache
>>>>>>> 0.7.0
   nginx

