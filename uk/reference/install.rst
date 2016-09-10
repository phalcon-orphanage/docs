Installation
============
PHP extensions require a slightly different installation method to a traditional PHP-based library or framework.
You can either download a binary package for the system of your choice or build it from the sources.

Windows
-------
To use phalcon on Windows you can download_ a DLL library. Edit your php.ini file and then append at the end:

.. code-block:: bash

    extension=php_phalcon.dll

Restart your webserver.

The following screencast is a step-by-step guide to install Phalcon on Windows:

.. raw:: html

    <div align="center"><iframe src="https://player.vimeo.com/video/40265988" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>

Related Guides
^^^^^^^^^^^^^^
.. toctree::
    :maxdepth: 1

    xampp
    wamp

Linux/Solaris
-------------

Debian / Ubuntu
^^^^^^^^^^^^^^^
To add the repository to your distribution:

.. code-block:: bash

    # Stable releases
    curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash

    # Nightly releases
    curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.deb.sh | sudo bash

This only needs to be done only once, unless your distribution changes or you want to switch from stable to nightly builds.

To install Phalcon:

.. code-block:: bash

    sudo apt-get install php5-phalcon

    # or for PHP 7

    sudo apt-get install php7.0-phalcon

RPM distributions (i.e. CentOS)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
To add the repository to our distribution:

.. code-block:: bash

    # Stable releases
    curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.rpm.sh | sudo bash

    # Nightly releases
    curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.rpm.sh | sudo bash

This only needs to be done only once, unless your distribution changes or you want to switch from stable to nightly builds.

To install Phalcon:

.. code-block:: bash

    sudo yum install php56u-phalcon

    # or for PHP 7

    sudo yum install php70u-phalcon

Compile from source
^^^^^^^^^^^^^^^^^^^
On a Linux/Solaris system you can easily compile and install the extension from the source code:

Prerequisite packages are:

* PHP >= 5.5 development resources
* GCC compiler (Linux/Solaris)
* Git (if not already installed in your system - unless you download the package from GitHub and upload it on your server via FTP/SFTP)

Specific packages for common platforms:

.. code-block:: bash

    # Ubuntu
    sudo apt-get install php5-dev libpcre3-dev gcc make php5-mysql

    # Suse
    sudo yast -i gcc make autoconf php5-devel php5-pear php5-mysql

    # CentOS/RedHat/Fedora
    sudo yum install php-devel pcre-devel gcc make

    # Solaris
    pkg install gcc-45 php-56 apache-php56

Creating the extension:

.. code-block:: bash

    git clone git://github.com/phalcon/cphalcon.git

    cd cphalcon/build

    sudo ./install

Add extension to your PHP configuration:

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

Restart the webserver.

If you are running Ubuntu/Debian with php5-fpm, restart it:

.. code-block:: bash

    sudo service php5-fpm restart

Phalcon automatically detects your architecture, however, you can force the compilation for a specific architecture:

.. code-block:: bash

    cd cphalcon/build

    # One of the following:
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
A port is available for FreeBSD. Just only need these simple line commands to install it:

.. code-block:: bash

    pkg_add -r phalcon

or

.. code-block:: bash

    export CFLAGS="-O2 --fvisibility=hidden"

    cd /usr/ports/www/phalcon

    make install clean

Checking your installation
--------------------------
Check your :code:`phpinfo()` output for a section referencing "Phalcon" or execute the code snippet below:

.. code-block:: php

    <?php print_r(get_loaded_extensions()); ?>

The Phalcon extension should appear as part of the output:

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

Installation Notes
------------------
Installation notes for Web Servers:

.. toctree::
    :maxdepth: 1

    apache
    nginx
    cherokee
    built-in

.. _download: http://phalconphp.com/en/download
