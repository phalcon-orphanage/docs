Installation
============

PHP extensions require a different installation method of traditional php-based libraries or frameworks. You can either download a binary package for the system of your choice or build it from sources.  

For the last months we have made research on PHP behavior looking for small and big optimizations, studying deeply the Zend Engine to achieve the omission of unnecessary validations generating low-level solutions to get the best possible performance. 

.. highlights::
   Phalcon compiles from PHP 5.3.1, but due to old PHP bugs causing memory leaks, we highly recommend you to use at least PHP 5.3.8 or superior. 

Windows
-------

To use phalcon on Windows you can download a DLL library. Edit your php.ini file and then append at the end:

    extension=php_phalcon.dll

Finally restart your webserver.

The following screencast is a step-by-step guide to install Phalcon on Windows: 

.. raw:: html

   <div align="center"><iframe src="http://player.vimeo.com/video/40265988" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>

Related Guides
^^^^^^^^^^^^^^

* :doc:`Detailed Installation on XAMPP for Windows </reference/xampp>` 
* :doc:`Detailed Installation on WAMP for Windows </reference/wamp>`

Unix/Linux
----------

On platform Unix/Linux you can easily compile and install the extension from source code: 

Requirements
^^^^^^^^^^^^
We need some packages previously installed.

* PHP 5.x development resources
* GCC compiler (Linux) or Xcode (Mac)

.. code-block:: php 

    #Ubuntu
    sudo apt-get install php5-dev php5-mysql gcc

    #Suse
    yast2 -i php5-pear php5-dev php5-mysql gcc

Compilation
^^^^^^^^^^^
On platform Unix/Linux you can easily compile and install the extension from source code: 

.. code-block:: php 

    # git clone git://github.com/phalcon/cphalcon.git
    # cd cphalcon/release
    # export CFLAGS="-O2 -fno-delete-null-pointer-checks"
    # phpize
    # ./configure --enable-phalcon
    # make
    # sudo make install

Add extension to your php.ini

    # extension=phalcon.so

Finally restart the webserver 


FreeBSD
^^^^^^^
A port is available for FreeBSD. Just only need these simple line commands to install it:

    # pkg_add -r phalcon

or

.. code-block:: php

    export CFLAGS="-O2 -fno-delete-null-pointer-checks"
    # cd /usr/ports/www/phalcon && make install clean

Installation Notes
^^^^^^^^^^^^^^^^^^

Installation notes for Web Servers:

* Nginx Notes

