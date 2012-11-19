安装
============

PHP extensions require a slightly different installation method to a traditional php-based library or framework. You can either download a binary package for the system of your choice or build it from the sources.

During the last few months, we have extensively researched PHP's behavior, investigating areas for significant optimizations (big or small). Through understanding of the Zend Engine, we managed to remove unecessary validations, compacted code, performed optimizations and generated low-level solutions so as to achieve maximum performance from Phalcon.

.. highlights::
   Phalcon compiles from PHP 5.3.1, but due to old PHP bugs causing memory leaks, we highly recommend you to use at least PHP 5.3.11 or greater.

Windows
-------

在windows上安装任何扩展都是很简单的，安装phalcon也是一样，下载.dll文件，放到extension目录，然后修改php.ini文件，加入以下行：

    extension=php_phalcon.dll

重启web server.

以下视频是教你如何一步一步在windows上安装phalcon

.. raw:: html

   <div align="center"><iframe src="http://player.vimeo.com/video/40265988" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>

Related Guides
^^^^^^^^^^^^^^

.. toctree::
   :maxdepth: 1

   xampp
   wamp

Unix/Linux
----------

在Unix/Linux操作系统上，你可以很容易的从源代友编译和安装扩展

Requirements
^^^^^^^^^^^^
Prerequisite packages are:

* PHP 5.x development resources
* GCC compiler (Linux) or Xcode (Mac)
* Git (if not already installed in your system - unless you download the package from GitHub and upload it on your server via FTP/SFTP)

.. code-block:: bash

    #Ubuntu
    sudo apt-get install php5-dev php5-mysql gcc
    sudo apt-get install git-core

    #Suse
    yast2 -i php5-pear php5-dev php5-mysql gcc
    yast2 -i git-core

Compilation
^^^^^^^^^^^
Creating the extension:

.. code-block:: bash

    git clone git://github.com/phalcon/cphalcon.git
    cd cphalcon/build
    ./install

（备注）./install其实是默认包含了phpize,configure,make,make install命令。如果您的机器中phpize,php-config不在环境命令中，请执行以下操作后再执行./install

.. code-block:: bash

   ln -s phpdir/bin/phpize /usr/bin
   ln -s phpdir/bin/php-cofnig /usr/bin

phpdir是你的php安装路径。

编辑php.ini文件，加入扩展

.. code-block:: bash

    extension=phalcon.so

重启web server,如果是php-fpm,重启php-fpm即可

FreeBSD
^^^^^^^
A port is available for FreeBSD. Just only need these simple line commands to install it:

.. code-block:: bash

    pkg_add -r phalcon

or

.. code-block:: bash

    export CFLAGS="-O2 -fno-delete-null-pointer-checks"
    cd /usr/ports/www/phalcon && make install clean

Installation Notes
^^^^^^^^^^^^^^^^^^

Installation notes for Web Servers:

.. toctree::
   :maxdepth: 1

   nginx

