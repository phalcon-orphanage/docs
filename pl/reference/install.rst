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

    <div align="center"><iframe src="http://player.vimeo.com/video/40265988" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>

Powiązane Przewodniki
^^^^^^^^^^^^^^^^^^^^^
.. toctree::
    :maxdepth: 1

    xampp
    wamp

Linux/Solaris
-------------
Na systemach Linux/Solaris możesz w łatwy sposób skompilować i zainstalować rozszerzenie z kodu źródłowego:

Wymagania
^^^^^^^^^
Wstępnie wymagane pakiety:

* Pliki źródłowe PHP >= 5.3
* Kompilator GCC (Linux/Solaris)
* Git (jeśli nie jest jeszcze zainstalowany na twoim systemie - chyba ze pobierzesz pakiet z GitHub i prześlesz go na swój serwer przez FTP/SFTP)

Specyficzne pakiety dla wspólnych platform:

.. code-block:: bash

    # Ubuntu
    sudo apt-get install php5-dev libpcre3-dev gcc make php5-mysql

    # Suse
    sudo yast -i gcc make autoconf2.13 php5-devel php5-pear php5-mysql

    # CentOS/RedHat/Fedora
    sudo yum install php-devel pcre-devel gcc make

    # Solaris
    pkg install gcc-45 php-53 apache-php53

Kompilacja
^^^^^^^^^^
Tworzenie rozszerzenia:

.. code-block:: bash

    git clone --depth=1 git://github.com/phalcon/cphalcon.git
    cd cphalcon/build
    sudo ./install

Dodaj rozszerzenie do swojej konfiguracji PHP:

.. code-block:: bash

    # Suse: Dodaj ta linię do swojego pliku php.ini
    extension=phalcon.so

    # Centos/RedHat/Fedora: Stwórz plik o nazwie phalcon.ini w /etc/php.d/ z następującą zawartością:
    extension=phalcon.so

    # Ubuntu/Debian: Stwórz plik o nazwie 30-phalcon.ini w /etc/php.d/ z następującą zawartością:
    extension=phalcon.so

    # Debian z php5-fpm: Stwórz plik o nazwie 30-phalcon.ini w /etc/php5/fpm/conf.d/ z następującą zawartością:
    extension=phalcon.so

Zrestartuj serwer.

If you are running Debian with php5-fpm, restart it:

.. code-block:: bash

    sudo service php5-fpm restart

Phalcon automatycznie wykrywa architekturę twojego systemu, możesz jednak wymusić kompilację dla konkretnej architektury:

.. code-block:: bash

    cd cphalcon/build
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

* Pliki źródłowe PHP >= 5.4
* XCode

.. code-block:: bash

    # brew
    brew tap homebrew/homebrew-php
    brew install php54-phalcon
    brew install php55-phalcon
    brew install php56-phalcon

    # MacPorts
    sudo port install php54-phalcon
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
    cd /usr/ports/www/phalcon && make install clean

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
