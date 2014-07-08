安装（Installation）
============
PHP extensions require a slightly different installation method to a traditional php-based library or framework. You can either
download a binary package for the system of your choice or build it from the sources.

.. highlights::
    Phalcon compiles from PHP 5.3.1, but because of old PHP bugs causing memory leaks, we highly recommend you use at least PHP 5.3.11 or greater.

.. highlights::
    PHP versions below 5.3.9 have several security flaws and these aren't recommended for production web sites. `Learn more <http://www.infoworld.com/d/security/php-539-fixes-hash-collision-dos-vulnerability-183947>`_

Windows
-------
To use phalcon on Windows you can download a DLL library. Edit your php.ini file and then append at the end:

    extension=php_phalcon.dll

Restart your webserver.

The following screencast is a step-by-step guide to install Phalcon on Windows:

.. raw:: html

    <div align="center"><iframe src="http://player.vimeo.com/video/40265988" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>

相关指南（Related Guides）
^^^^^^^^^^^^^^
.. toctree::
    :maxdepth: 1

    xampp
    wamp

Linux/Solaris/Mac
-----------------
On a Linux/Solaris/Mac system you can easily compile and install the extension from the source code:

基本要求（Requirements）
^^^^^^^^^^^^
Prerequisite packages are:

* PHP 5.3.x/5.4.x/5.5.x development resources
* GCC compiler (Linux/Solaris) or Xcode (Mac)
* Git (if not already installed in your system - unless you download the package from GitHub and upload it on your server via FTP/SFTP)

Specific packages for common platforms:

.. code-block:: bash

    #Ubuntu
    sudo apt-get install gcc make git-core libpcre3-dev php5-dev 

    #Suse
    sudo yast -i gcc make php5-devel
    #or
    sudo zypper install gcc make php5-devel

    #CentOS/Fedora/RHEL
    sudo yum install git gcc make pcre-devel php-devel

    #Solaris
    pkg install gcc-45 php-53 apache-php53

编译（Compilation）
^^^^^^^^^^^
Creating the extension:

.. code-block:: bash

    git clone git://github.com/phalcon/cphalcon.git
    cd cphalcon/build
    sudo ./install

Add extension to your php configuration:

.. code-block:: bash
    
    #Ubuntu: Add this line in your php.ini
    extension=phalcon.so
    
    #Centos/RedHat: Add a file called phalcon.ini in /etc/php.d/ with this content:
    extension=phalcon.so

Restart the webserver.

Phalcon automatically detects your architecture, however, you can force the compilation for a specific architecture:

.. code-block:: bash

    sudo ./install 32bits
    sudo ./install 64bits
    sudo ./install safe

FreeBSD
-------
A port is available for FreeBSD. Just only need these simple line commands to install it:

.. code-block:: bash

    pkg_add -r phalcon

or

.. code-block:: bash

    export CFLAGS="-O2 -fno-delete-null-pointer-checks"
    cd /usr/ports/www/phalcon && make install clean

安装说明（Installation Notes）
------------------
Installation notes for Web Servers:

.. toctree::
    :maxdepth: 1

    apache
    nginx
    cherokee
    built-in
