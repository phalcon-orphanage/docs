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

    <div align="center"><iframe src="https://player.vimeo.com/video/40265988" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>

Краткое руководство
^^^^^^^^^^^^^^^^^^^
.. toctree::
    :maxdepth: 1

    xampp
    wamp

Linux/Solaris
-------------

Debian / Ubuntu
^^^^^^^^^^^^^^^
Для того, чтобы добавить репозиторий в ваш дистрибутив:

.. code-block:: bash

    # Стабильные релизы
    curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash

    # Ночные сборки
    curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.deb.sh | sudo bash

Это требуется сделать лишь один раз, либо в том случае, если изменился ваш дистрибутив, или вы хотите перейти со стабильных на ночные сборки.

Для установки Phalcon:

.. code-block:: bash

    sudo apt-get install php5-phalcon

    # или для PHP 7

    sudo apt-get install php7.0-phalcon

RPM дистрибутивы (например, такие, как CentOS)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Для того, чтобы добавить репозиторий в ваш дистрибутив:

.. code-block:: bash

    # Стабильные релизы
    curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.rpm.sh | sudo bash

    # Ночные сборки
    curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.rpm.sh | sudo bash

Это требуется сделать лишь один раз, либо в том случае, если изменился ваш дистрибутив, или вы хотите перейти со стабильных на ночные сборки.

Для установки Phalcon:

.. code-block:: bash

    sudo yum install php56u-phalcon

    # или для PHP 7

    sudo yum install php70u-phalcon

Компиляция из исходного кода
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Пользователи систем Linux/Solaris могут просто собрать Phalcon из исходных файлов:

Необходимы пакеты:

* Пакеты для разработки PHP >= 5.5
* Компилятор GCC (Linux/Solaris)
* Git (если не установлен, иначе, архив можно скачать с GitHub и затем загрузить на свой сервер по FTP/SFTP)

Пакеты, специфичные для различных платформ:

.. code-block:: bash

    # Ubuntu
    sudo apt-get install php5-dev libpcre3-dev gcc make php5-mysql

    # Suse
    sudo yast -i gcc make autoconf php5-devel php5-pear php5-mysql

    # CentOS/RedHat/Fedora
    sudo yum install php-devel pcre-devel gcc make

    # Solaris
    pkg install gcc-45 php-56 apache-php56

Создание расширения:

.. code-block:: bash

    git clone git://github.com/phalcon/cphalcon.git

    cd cphalcon/build

    sudo ./install

Добавьте его в вашу PHP конфигурацию:

.. code-block:: bash

    # Suse: создайте файл phalcon.ini в /etc/php5/conf.d/ со следующим содержимым:
    extension=phalcon.so

    # CentOS/RedHat/Fedora: создайте файл phalcon.ini в /etc/php.d/ со следующим содержимым:
    extension=phalcon.so

    # Ubuntu/Debian с apache2: создайте файл 30-phalcon.ini в /etc/php5/apache2/conf.d/ со следующим содержимым:
    extension=phalcon.so

    # Ubuntu/Debian с php5-fpm: создайте файл 30-phalcon.ini в /etc/php5/fpm/conf.d/ со следующим содержимым:
    extension=phalcon.so

    # Ubuntu/Debian с php5-cli: создайте файл 30-phalcon.ini в /etc/php5/cli/conf.d/ со следующим содержимым:
    extension=phalcon.so

Перезапустите веб-сервер.

Если вы используете Ubuntu/Debian с php5-fpm, то перезапустите и его:

.. code-block:: bash

    sudo service php5-fpm restart

При компиляции Phalcon сам выявляет тип платформы, но можно указать и явно:

.. code-block:: bash

    cd cphalcon/build

    # One of the following:
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

* Пакеты для разработки PHP >= 5.5
* XCode

.. code-block:: bash

    # brew
    brew tap homebrew/homebrew-php
    brew install php55-phalcon
    brew install php56-phalcon

    # MacPorts
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

    cd /usr/ports/www/phalcon

    make install clean

Проверка установки
------------------
Проверьте, есть ли в результатах :code:`phpinfo()` секция "Phalcon", или выполните следующий код:

.. code-block:: php

    <?php print_r(get_loaded_extensions()); ?>

В результате вы должны увидеть Phalcon в списке:

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
