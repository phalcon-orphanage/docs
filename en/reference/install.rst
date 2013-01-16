Installation
============

PHP extensions require a slightly different installation method to a traditional php-based library or framework. You can either
download a binary package for the system of your choice or build it from the sources.

During the last few months, we have extensively researched PHP's behavior, investigating areas for significant
optimizations (big or small). Through understanding of the Zend Engine, we managed to remove unecessary validations,
compacted code, performed optimizations and generated low-level solutions so as to achieve maximum performance
from Phalcon.

.. highlights::
	Phalcon compiles from PHP 5.3.1, but because of old PHP bugs causing memory leaks, we highly recommend you to use at least PHP 5.3.11 or greater.

.. highlights::
	PHP versions below 5.3.9 have several security flaws and they aren't recommended for production web sites. `Learn more <http://www.infoworld.com/d/security/php-539-fixes-hash-collision-dos-vulnerability-183947>`_

Windows
-------

To use phalcon on Windows you can download a DLL library. Edit your php.ini file and then append at the end:

	extension=php_phalcon.dll

Restart your webserver.

The following screencast is a step-by-step guide to install Phalcon on Windows:

.. raw:: html

	<div align="center"><iframe src="http://player.vimeo.com/video/40265988" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>

Related Guides
^^^^^^^^^^^^^^

.. toctree::
	:maxdepth: 1

	xampp
	wamp

Linux/Solaris/Mac
-----------------
On a Linux/Solaris/Mac system you can easily compile and install the extension from the source code:

Requirements
^^^^^^^^^^^^
Prerequisite packages are:

* PHP 5.3.x/5.4.x development resources
* GCC compiler (Linux/Solaris) or Xcode (Mac)
* Git (if not already installed in your system - unless you download the package from GitHub and upload it on your server via FTP/SFTP)

.. code-block:: bash

	#Ubuntu
	sudo apt-get install php5-dev php5-mysql gcc autoconf
	sudo apt-get install git-core

	#Suse
	yast2 -i php5-pear php5-devel php5-mysql gcc autoconf2.13
	yast2 -i git-core

	#Solaris
	pkg install php-53 apache-php53 gcc-45

Compilation
^^^^^^^^^^^
Creating the extension:

.. code-block:: bash

	git clone git://github.com/phalcon/cphalcon.git
	cd cphalcon/build
	sudo ./install

Add extension to your php.ini

.. code-block:: bash

	extension=phalcon.so

Restart the webserver

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

	apache
	nginx
