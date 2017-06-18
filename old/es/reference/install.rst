Instalación
===========
Las extensiones de PHP requieren un método diferente de instalación a los frameworks o bibliotecas tradicionales.
Puedes descargar tanto un paquete binario para tu sistema o compilarlo desde el código fuente.

Windows
-------
Para usar Phalcon en Windows debes descargar_ un DLL y ubicarlo en el directorio de extensiones. Edita el php.ini y agrega al final:

.. code-block:: bash

    extension=php_phalcon.dll

Finalmente, reinicia el servidor web.

El siguiente video explica como instalar Phalcon en Windows paso a paso, el material se encuentra en Inglés.

.. raw:: html

    <div align="center"><iframe src="https://player.vimeo.com/video/40265988" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>

Guías Relacionadas
^^^^^^^^^^^^^^^^^^
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
En un sistema Linux/Solaris puedes compilar e instalar la extensión fácilmente desde la fuente del repositorio:

Los paquetes requeridos son:

* PHP >= 5.5 fuentes de desarrollo (development resources)
* Compilador GCC (Linux/Solaris)
* Git (a menos que descargues el paquete manualmente desde Github)

Paquetes específicos para plataformas comunes:

.. code-block:: bash

    # Ubuntu
    sudo apt-get install php5-dev libpcre3-dev gcc make php5-mysql

    # Suse
    sudo yast -i gcc make autoconf php5-devel php5-pear php5-mysql

    # CentOS/RedHat/Fedora
    sudo yum install php-devel pcre-devel gcc make

    # Solaris
    pkg install gcc-45 php-56 apache-php56

Compilando la extensión:

.. code-block:: bash

    git clone git://github.com/phalcon/cphalcon.git

    cd cphalcon/build

    sudo ./install

Añadiendo la extensión a php.ini:

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

Reiniciando el servidor web.

If you are running Ubuntu/Debian with php5-fpm, restart it:

.. code-block:: bash

    sudo service php5-fpm restart

Phalcon automáticamente detecta tu arquitectura de procesador, sin embargo, puedes forzar la compilación para la arquitectura deseada:

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
Existe una variante disponible para FreeBSD. Solo necesitas esta simple línea de comandos para instalarlo:

.. code-block:: bash

    pkg_add -r phalcon

o

.. code-block:: bash

    export CFLAGS="-O2 --fvisibility=hidden"

    cd /usr/ports/www/phalcon

    make install clean

Revisando tu instalación
------------------------
Revisa que la salida de tu :code:`phpinfo()` incluya una sección mencionando "Phalcon" o ejecuta el siguiente código a continuación:

.. code-block:: php

    <?php print_r(get_loaded_extensions()); ?>

La extensión de Phalcon debe aparecer como parte de la salida:

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

Notas para la instalación
-------------------------
Notas para los servidores web:

.. toctree::
    :maxdepth: 1

    apache
    nginx
    cherokee
    built-in

.. _descargar: http://phalconphp.com/es/download
