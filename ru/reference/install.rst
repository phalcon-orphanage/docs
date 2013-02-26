Установка
============
Расширения для PHP устанавливаются несколько иначе чем обычные библиотеки или php-фреймворки. Вы можете скачать готовый бинарный
файл для своей системы, или собрать его их исходников самостоятельно.

During the last few months, we have extensively researched PHP's behavior, investigating areas for significant
optimizations (big or small). Through understanding of the Zend Engine, we managed to remove unecessary validations,
compacted code, performed optimizations and generated low-level solutions so as to achieve maximum performance
from Phalcon.

Последние несколько месяцев мы глубоко исследовали возможности PHP для любой оптимизации большой или маленькой.
Поняв Zend Engine, мы смогли убрать лишние проверки, уменьшить код и выполнить такие низкоуровневые оптимизации, которые позволили добиться максимальной
производителньости от Phalcon.

.. highlights::
	Phalcon работает с PHP 5.3.1, но ошибки в старых версиях PHP вызывают утечки памяти, и для надёжной работы рекомендуем использовать как минимум PHP 5.3.11, а лучше еще новее.

.. highlights::
	В PHP версии ниже 5.3.9 есть ошибки влиязие на безопасность, эти версии не рекомендуется использовать. `Подробнее <http://www.infoworld.com/d/security/php-539-fixes-hash-collision-dos-vulnerability-183947>`_

Windows
-------
Для использования Phalcon в среде Windows достаточно скачать DLL библиотеку и добавить в конце php.ini :

	extension=php_phalcon.dll

Перезапустить веб-сервер.

существует обучающий скринкаст с пошаговой установкой Phalcon на Windows:

.. raw:: html

	<div align="center"><iframe src="http://player.vimeo.com/video/40265988" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>

Краткое руководство
^^^^^^^^^^^^^^

.. toctree::
	:maxdepth: 1

	xampp
	wamp

Linux/Solaris/Mac
-----------------
Пользователи Linux/Solaris/Mac могут очень просто собрать Phalcon из исходных файлов:

Требования
^^^^^^^^^^^^
Необходимы пакеты:

* Иструменты разработки PHP 5.3.x/5.4.x
* Компилятор GCC (Linux/Solaris) или Xcode (Mac)
* Git (если он не установлен - пакет можно загрузить с GitHub и закачать на свой сервер по FTP/SFTP)

Специфичные пакеты для разных платформ:

.. code-block:: bash

	#Ubuntu
	sudo apt-get install git-core gcc autoconf
	sudo apt-get install php5-dev php5-mysql

	#Suse
	sudo yast -i gcc make autoconf2.13
	sudo yast -i php5-devel php5-mysql

	#CentOS/RedHat
	sudo yum install gcc make
	sudo yum install php-devel

	#Solaris
	pkg install gcc-45
	pkg install php-53 apache-php53

Компиляция
^^^^^^^^^^^
Создайте расширение:

.. code-block:: bash

	git clone git://github.com/phalcon/cphalcon.git
	cd cphalcon/build
	sudo ./install

Добавьте его в php.ini

.. code-block:: bash

	extension=phalcon.so

Перезапустите веб-сервер.

При компиляции Phalcon сам выявляет тип платформы, но можно указать и явно:

.. code-block:: bash

	sudo ./install 32bits
	sudo ./install 64bits
	sudo ./install safe

FreeBSD
-------
Порт доступен для FreeBSD. Для установки служат простые команды:

.. code-block:: bash

	pkg_add -r phalcon

или

.. code-block:: bash

	export CFLAGS="-O2 -fno-delete-null-pointer-checks"
	cd /usr/ports/www/phalcon && make install clean

Замечанпия по установке
------------------

Установка на разные веб-сервера:

.. toctree::
	:maxdepth: 1

	apache
	nginx
	cherokee
