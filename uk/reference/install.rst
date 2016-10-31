Installation
============
PHP розширень вимагають дещо інший спосіб установки традиційного PHP на основі бібліотеки або фреймворка.
Ви можете або завантажити бінарний пакет для системи за вашим вибором або побудувати його з джерел.

Windows
-------
Щоб використовувати Phalcon на Windows ви можете download_ DLL бібліотеку. Edit your php.ini file і потім додати в кінці:

.. code-block:: bash

    extension=php_phalcon.dll

Перезапустіть ваш веб-сервер.

Наступний скрінкасти являє собою керівництво крок за кроком встановити Phalcon на Windows:

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
Щоб додати репозиторій до вашого дистрибутива:

.. code-block:: bash

    # Stable releases
    curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash

    # Nightly releases
    curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.deb.sh | sudo bash

Це необхідно зробити тільки один раз, якщо ваш дистрибутив не змінений або ви хочете перемкнутися зі стабільних на нічні збірки.

Для встановлення Phalcon:

.. code-block:: bash

    sudo apt-get install php5-phalcon

    # or for PHP 7

    sudo apt-get install php7.0-phalcon

RPM distributions (i.e. CentOS)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Щоб додати репозиторій до нашого дистрибутиву:

.. code-block:: bash

    # Stable releases
    curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.rpm.sh | sudo bash

    # Nightly releases
    curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.rpm.sh | sudo bash

Це необхідно зробити тільки один раз, якщо ваш дистрибутив не змінений або ви хочете перемкнутися зі стабільних на нічні збірки.

Для встановлення Phalcon:

.. code-block:: bash

    sudo yum install php56u-phalcon

    # or for PHP 7

    sudo yum install php70u-phalcon

Compile from source
^^^^^^^^^^^^^^^^^^^
На  Linux/Solaris ви можете легко зібрати і встановити розширення з вихідного коду:

Необхідні пакети:

* PHP >= 5.5 development resources
* GCC compiler (Linux/Solaris)
* Git (if not already installed in your system - unless you download the package from GitHub and upload it on your server via FTP/SFTP)

Конкретні пакети для загальних платформ:

.. code-block:: bash

    # Ubuntu
    sudo apt-get install php5-dev libpcre3-dev gcc make php5-mysql

    # Suse
    sudo yast -i gcc make autoconf php5-devel php5-pear php5-mysql

    # CentOS/RedHat/Fedora
    sudo yum install php-devel pcre-devel gcc make

    # Solaris
    pkg install gcc-45 php-56 apache-php56

Створіть розширення:

.. code-block:: bash

    git clone git://github.com/phalcon/cphalcon.git

    cd cphalcon/build

    sudo ./install

і додайте розширення в PHP конфігурацію:

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

Перезапустіть веб-сервер.

If you are running Ubuntu/Debian with php5-fpm, restart it:

.. code-block:: bash

    sudo service php5-fpm restart

Phalcon автоматично визначає архітектуру, однак, ви можете змусити компіляцію для конкретної архітектури:

.. code-block:: bash

    cd cphalcon/build

    # One of the following:
    sudo ./install 32bits
    sudo ./install 64bits
    sudo ./install safe

Якщо автоматичний установник не вдається, спробуйте будувати розширення вручну:

.. code-block:: bash

    cd cphalcon/build/64bits

    export CFLAGS="-O2 --fvisibility=hidden"

    ./configure --enable-phalcon

    make && sudo make install

Mac OS X
--------
В операційній системі Mac OS X ви можете зібрати і встановити розширення з вихідного коду:

Requirements
^^^^^^^^^^^^
Необхідні пакети:

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

Додайте розширення в PHP конфігурацію.

FreeBSD
-------
Порт доступний для FreeBSD. Просто потрібно тільки команди ці прості лінії, щоб встановити його:

.. code-block:: bash

    pkg_add -r phalcon

або

.. code-block:: bash

    export CFLAGS="-O2 --fvisibility=hidden"

    cd /usr/ports/www/phalcon

    make install clean

Checking your installation
--------------------------
Перевірте ваш :code:`phpinfo()` вивід для секції посилань "Phalcon" або виконати фрагмент коду нижче:

.. code-block:: php

    <?php print_r(get_loaded_extensions()); ?>

Розширення Phalcon має з'явитися як частина виходу:

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
Зауваження по встановленню для веб-серверів:

.. toctree::
    :maxdepth: 1

    apache
    nginx
    cherokee
    built-in

.. _download: http://phalconphp.com/uk/download
