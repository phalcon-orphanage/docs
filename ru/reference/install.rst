Установка
=========
Расширения для PHP устанавливаются несколько иначе, чем обычные библиотеки или PHP фреймворки.
Вы можете скачать готовый бинарный файл для своей системы или собрать его из исходников самостоятельно.

Windows
-------
Для использования Phalcon в Windows достаточно `скачать`_ DLL библиотеку и добавить в конце php.ini:

.. code-block:: bash

    extension=php_phalcon.dll

Затем перезапустите ваш веб-сервер.

Существует обучающий скринкаст с пошаговой установкой Phalcon на Windows:

.. raw:: html

    <div align="center"><iframe src="http://player.vimeo.com/video/40265988" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>

Краткое руководство
^^^^^^^^^^^^^^^^^^^
.. toctree::
    :maxdepth: 1

    xampp
    wamp

Linux/Solaris
-------------
Пользователи систем Linux/Solaris могут просто собрать Phalcon из исходных файлов:

Требования
^^^^^^^^^^
Необходимы пакеты:

* Пакеты для разработки PHP >= 5.3
* Компилятор GCC (Linux/Solaris)
* Git (если не установлен, иначе, архив можно скачать с GitHub и затем загрузить на свой сервер по FTP/SFTP)

Пакеты, специфичные для различных платформ:

.. code-block:: bash

    # Ubuntu
    sudo apt-get install php5-dev libpcre3-dev gcc make php5-mysql

    # Suse
    sudo yast -i gcc make autoconf2.13 php5-devel php5-pear php5-mysql

    # CentOS/RedHat/Fedora
    sudo yum install php-devel pcre-devel gcc make

    # Solaris
    pkg install gcc-45 php-53 apache-php53

Компиляция
^^^^^^^^^^
Создание расширения:

.. code-block:: bash

    git clone --depth=1 git://github.com/phalcon/cphalcon.git
    cd cphalcon/build
    sudo ./install

Добавьте его в вашу PHP конфигурацию:

.. code-block:: bash

    # Suse: добавьте эту строку в php.ini
    extension=phalcon.so

    # Centos/RedHat/Fedora: создайте файл phalcon.ini в /etc/php.d/ со следующим содержимым:
    extension=phalcon.so

    # Ubuntu/Debian: создайте файл 30-phalcon.ini в /etc/php5/conf.d/ со следующим содержимым:
    extension=phalcon.so

    # Debian с php5-fpm: создайте файл 30-phalcon.ini в /etc/php5/fpm/conf.d/ со следующим содержимым:
    extension=phalcon.so

Перезапустите веб-сервер.

Если вы используете Debian с php5-fpm, то перезапустите и его:

.. code-block:: bash

    sudo service php5-fpm restart

При компиляции Phalcon сам выявляет тип платформы, но можно указать и явно:

.. code-block:: bash

    cd cphalcon/build
    sudo ./install 32bits
    sudo ./install 64bits
    sudo ./install safe

Если автоматическая установка завершается с ошибкой, то попробуйте собрать расширение вручную:

.. code-block:: bash

    cd cphalcon/build/64bits
    export CFLAGS="-O2 --fvisibility=hidden"
    ./configure --enable-phalcon
    make && sudo make install

Mac OS X
--------
В Mac OS X вы можете скомпилировать и установить расширение из исходников:

Требования
^^^^^^^^^^
Необходимы пакеты:

* Пакеты для разработки PHP >= 5.4
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

Добавьте его в вашу PHP конфигурацию.

FreeBSD
-------
Порт доступен для FreeBSD. Для установки достаточно пары простых команд:

.. code-block:: bash

    pkg_add -r phalcon

или

.. code-block:: bash

    export CFLAGS="-O2 --fvisibility=hidden"
    cd /usr/ports/www/phalcon && make install clean

Замечания по установке
----------------------
Установка на разные веб-сервера:

.. toctree::
    :maxdepth: 1

    apache
    nginx
    cherokee
    built-in

.. _скачать: http://phalconphp.com/ru/download
