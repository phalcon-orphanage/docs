Instalação
==========
A instalação de uma extensão PHP é levemente diferente dos métodos tradicionais de instalação das bibliotecas de um framework baseado em PHP.
Você pode fazer o download dos pacotes binários construído para o seu sistema de sua escolha ou compilar-los a partir das fontes.

Windows
-------
Para utilizar o phalcon no Windows você pode fazer o download_ da biblioteca DLL. Editar o seu php.ini adicionando no final a seguinte instrução:

.. code-block:: bash

    extension=php_phalcon.dll

Reinicie seu servidor web.

O seguinte screencast é um passo-a-passo para instalação do Phalcon no Windows:

.. raw:: html

    <div align="center"><iframe src="https://player.vimeo.com/video/40265988" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>

Guias Relacionados
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
Nos sistemas Linux/Solaris você pode facilmente compilar e instalar a extensão diretamente dos códigos fontes:

Os pacotes pré-requisitos são:

* PHP >= 5.5 recursos de desenvolvimento
* Compilador GCC (Linux/Solaris)
* Git (caso ainda não esteja instalado no seu sistema - a menos que você faça o download do pacote no GitHub e depois o upload para o seu servidor via FTP/SFTP)

Pacotes específicos para plataformas em comum:

.. code-block:: bash

    # Ubuntu
    sudo apt-get install php5-dev libpcre3-dev gcc make php5-mysql

    # Suse
    sudo yast -i gcc make autoconf php5-devel php5-pear php5-mysql

    # CentOS/RedHat/Fedora
    sudo yum install php-devel pcre-devel gcc make

    # Solaris
    pkg install gcc-45 php-56 apache-php56

Criando a extensão:

.. code-block:: bash

    git clone git://github.com/phalcon/cphalcon.git

    cd cphalcon/build

    sudo ./install

Adicione a extensão ao seu php.ini

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

Reinicie o servidor web.

If you are running Ubuntu/Debian with php5-fpm, restart it:

.. code-block:: bash

    sudo service php5-fpm restart

Phalcon automaticamente detecta a sua arquitetura, no entanto, você poderá força a compilação para uma arquitetura especifica:

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
Um port esta disponível para o FreeBSD. Basta um simples comando na linha de comando para instalar-lo:

.. code-block:: bash

    pkg_add -r phalcon

ou

.. code-block:: bash

    export CFLAGS="-O2 --fvisibility=hidden"

    cd /usr/ports/www/phalcon

    make install clean

Verificar a sua instalação
--------------------------
Verifique o :code:`phpinfo()` de saída para ver se tem uma seção de referência com o nome "Phalcon" ou execute o código abaixo:

.. code-block:: php

    <?php print_r(get_loaded_extensions()); ?>

A extensão Phalcon deve aparecer como parte da saídat:

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

Notas de Instalação
-------------------
Notas de Instalação para os Servidores Web:

.. toctree::
    :maxdepth: 1

    apache
    nginx
    cherokee
    built-in

.. _download: http://phalconphp.com/pt/download
