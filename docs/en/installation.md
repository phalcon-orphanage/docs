<div class='article-menu' markdown='1'>

- [Requirements](#requirements)
    - [Hardware](#requirements-hardware)
    - [Software](#requirements-software)
- [Installation](#installation)
    - [Linux](#installation-linux)
        - [DEB based distributions (Debian, Ubuntu, etc.)](#installation-linux-debian)
            - [Repository installation](#installation-linux-debian-repository)
                - [Stable releases](#installation-linux-debian-repository-stable)
                - [Nightly releases](#installation-linux-debian-repository-nightly)
            - [Phalcon installation](#installation-linux-debian-phalcon)
                - [PHP 5.7](#installation-linux-debian-phalcon-php5)
                - [PHP 7](#installation-linux-debian-phalcon-php7)
        - [RPM based distributions (CentOS, Fedora, etc.)](#installation-linux-rpm)
            - [Repository installation](#installation-linux-rpm-reposotiry)
                - [Stable releases](#installation-linux-rpm-repository-stable)
                - [Nightly releases](#installation-linux-rpm-repository-nightly)
            - [Phalcon installation](#installation-linux-rpm-phalcon)
                - [PHP 5.7](#installation-linux-rpm-phalcon-php5)
                - [PHP 7](#installation-linux-rpm-phalcon-php7)
    - MacOS
    - Windows
    - Compile from source

</div>

<a name='requirements'></a>
# Requirements

<a name='requirements-hardware'></a>
## Hardware

<a name='requirements-software'></a>
## Software

<a name='installation'></a>
# Installation
Since Phalcon is compiled as a PHP extension, its installation is somewhat different than any other traditional PHP framework. Phalcon needs to be installed and loaded as a module on your web server.

<a name='installation-linux'></a>
## Linux
To install Phalcon on linux, you will need to add our repository in your distribution and then install it. 

<a name='installation-linux-debian'></a>
### DEB based distributions (Debian, Ubuntu, etc.)
<a name='installation-linux-debian-repository'></a>
#### Repository installation
Add the repository to your distribution:

<a name='installation-linux-debian-repository-stable'></a>
##### Stable releases
```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash
```

or 

<a name='installation-linux-debian-repository-nightly'></a>
##### Nightly releases
```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.deb.sh | sudo bash
```

##### This only needs to be done only once, unless your distribution changes or you want to switch from stable to nightly builds. ##### {.alert .alert-warning}

<a name='installation-linux-debian-phalcon'></a>
#### Phalcon installation
To install Phalcon you need to issue the following commands in your terminal:

<a name='installation-linux-debian-phalcon-php5'></a>
##### PHP 5.7
```bash
sudo apt-get update
sudo apt-get install php5-phalcon
```

<a name='installation-linux-debian-phalcon-php7'></a>
##### PHP 7
```bash
sudo apt-get update
sudo apt-get install php7.0-phalcon
```

<a name='installation-linux-rpm'></a>
### RPM based distributions (CentOS, Fedora, etc.)
<a name='installation-linux-rpm-reposotiry'></a>
#### Repository installation
Add the repository to your distribution:

<a name='installation-linux-rpm-repository-stable'></a>
##### Stable releases
```bash
curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.rpm.sh | sudo bash
```

or

<a name='installation-linux-rpm-repository-nightly'></a>
##### Nightly releases
```bash
curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.rpm.sh | sudo bash
```

##### This only needs to be done only once, unless your distribution changes or you want to switch from stable to nightly builds. ##### {.alert .alert-warning}

<a name='installation-linux-rpm-phalcon'></a>
#### Phalcon installation
To install Phalcon you need to issue the following commands in your terminal:

<a name='installation-linux-rpm-phalcon-php5'></a>
##### PHP 5.7
```bash
sudo yum update
sudo yum install php56u-phalcon
```

<a name='installation-linux-rpm-phalcon-php7'></a>
##### PHP 7
```bash
sudo yum update
sudo yum install php70u-phalcon
```

<a name='installation-macos'></a>
## MacOS

<a name='installation-windows'></a>
## Windows
To use Phalcon on Windows, you will need to install the phalcon.dll. We have compiled several DLLs depending on the target platform. The DLLs can be found in our [download][dll-download] page.
To use phalcon on Windows you can download a DLL library. Edit your php.ini file and then append at the end:

.. code-block:: bash

    extension=php_phalcon.dll

Restart your webserver.



--------------------------------------------------------------------------------

#### Dev environments

- Vagrant
- Docker
- Homestead Improved


#### Sample applications
Hello World
Configuration Files

#### Web Server Configuration
Apache
    .htaccess
    VirtualHost/Directory

nginX


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

[download-dll](https://phalconphp.com/en/download/windows)