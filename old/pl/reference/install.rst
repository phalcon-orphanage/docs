Instalacja
==========
Rozszerzenia PHP wymagają nieco innej metody instalacji niż tradycyjna biblioteka PHP lub framework.
Możesz pobrać pakiet binarny dla wybranego przez siebie systemu lub skompilować go ze źródeł.

Windows
-------
Aby korzystać z Phalcon na systemie Windows możesz `pobrać`_ bibliotekę DLL. Edytuj swój plik php.ini i dodaj na jego końcu:

.. code-block:: bash

    extension=php_phalcon.dll

Zrestartuj swój serwer.

Poniższy filmik jest przewodnikiem "krok po kroku" jak zainstalować Phalcon na systemie Windows:

.. raw:: html

    <div align="center"><iframe src="https://player.vimeo.com/video/40265988" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>

Powiązane Przewodniki
^^^^^^^^^^^^^^^^^^^^^
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
Na systemach Linux/Solaris możesz w łatwy sposób skompilować i zainstalować rozszerzenie z kodu źródłowego:

Wstępnie wymagane pakiety:

* Pliki źródłowe PHP >= 5.5
* Kompilator GCC (Linux/Solaris)
* Git (jeśli nie jest jeszcze zainstalowany na twoim systemie - chyba ze pobierzesz pakiet z GitHub i prześlesz go na swój serwer przez FTP/SFTP)

Specyficzne pakiety dla wspólnych platform:

.. code-block:: bash

    # Ubuntu
    sudo apt-get install php5-dev libpcre3-dev gcc make php5-mysql

    # Suse
    sudo yast -i gcc make autoconf php5-devel php5-pear php5-mysql

    # CentOS/RedHat/Fedora
    sudo yum install php-devel pcre-devel gcc make

    # Solaris
    pkg install gcc-45 php-56 apache-php56

Tworzenie rozszerzenia:

.. code-block:: bash

    git clone git://github.com/phalcon/cphalcon.git

    cd cphalcon/build

    sudo ./install

Dodaj rozszerzenie do swojej konfiguracji PHP:

.. code-block:: bash

    # Suse: Stwórz plik o nazwie phalcon.ini w /etc/php5/conf.d/ z następującą zawartością:
    extension=phalcon.so

    # CentOS/RedHat/Fedora: Stwórz plik o nazwie phalcon.ini w /etc/php.d/ z następującą zawartością:
    extension=phalcon.so

    # Ubuntu/Debian z apache2: Stwórz plik o nazwie 30-phalcon.ini w /etc/php5/apache2/conf.d/ z następującą zawartością:
    extension=phalcon.so

    # Ubuntu/Debian z php5-fpm: Stwórz plik o nazwie 30-phalcon.ini w /etc/php5/fpm/conf.d/ z następującą zawartością:
    extension=phalcon.so

    # Ubuntu/Debian z php5-cli: Stwórz plik o nazwie 30-phalcon.ini w /etc/php5/cli/conf.d/ z następującą zawartością:
    extension=phalcon.so

Zrestartuj serwer.

If you are running Ubuntu/Debian with php5-fpm, restart it:

.. code-block:: bash

    sudo service php5-fpm restart

Phalcon automatycznie wykrywa architekturę twojego systemu, możesz jednak wymusić kompilację dla konkretnej architektury:

.. code-block:: bash

    cd cphalcon/build

    # One of the following:
    sudo ./install 32bits
    sudo ./install 64bits
    sudo ./install safe

Jeżeli autoinstalator wyrzuca błąd, spróbuj skompilować rozszerzenie ręcznie:

.. code-block:: bash

    cd cphalcon/build/64bits

    export CFLAGS="-O2 --fvisibility=hidden"

    ./configure --enable-phalcon

    make && sudo make install

Mac OS X
--------
Na systemach Mac OS X możesz skompilować rozszerzenie z kodu źródłowego:

Wymagania
^^^^^^^^^
Wstępnie wymagane pakiety:

* Pliki źródłowe PHP >= 5.5
* XCode

.. code-block:: bash

    # brew
    brew tap homebrew/homebrew-php
    brew install php55-phalcon
    brew install php56-phalcon

    # MacPorts
    sudo port install php55-phalcon
    sudo port install php56-phalcon

Dodaj rozszerzenie do swojej konfiguracji PHP.

FreeBSD
-------
Dostępny jest port dla Free BSD. Wystarczy tylko użyć tej prostej komendy aby go zainstalować:

.. code-block:: bash

    pkg_add -r phalcon

lub

.. code-block:: bash

    export CFLAGS="-O2 --fvisibility=hidden"

    cd /usr/ports/www/phalcon

    make install clean

Sprawdzenie instalacji
----------------------
Sprawdź wynik funkcji :code:`phpinfo()` w poszukiwaniu sekcji zawierającej "Phalcon"
lub uruchom poniższy kod:

.. code-block:: php

    <?php print_r(get_loaded_extensions()); ?>

Rozszerzenie Phalcon powinno pojawić się jako część wyniku:

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

Uwagi instalacyjne
------------------
Informacje o instalacji dla serwerów WWW:

.. toctree::
    :maxdepth: 1

    apache
    nginx
    cherokee
    built-in

.. _pobrać: http://phalconphp.com/pl/download
