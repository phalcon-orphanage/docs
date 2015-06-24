Instalación
===========
Las extensiones de PHP requieren un método diferente de instalación a los frameworks o bibliotecas tradicionales.
Puedes descargar tanto un paquete binario para tu sistema o compilarlo desde el código fuente.

.. highlights::
	Phalcon puede ser compilado como mínimo para la version 5.3.1 de PHP, pero debido a errores antiguos de PHP que causan fallos y fugas de memoria, recomendamos usar al menos 5.3.11.

.. highlights::
	Versiones inferiores a PHP 5.3.9 tienen fallos de seguridad y no son recomendadas para sitios en producción. `Más información <http://www.infoworld.com/d/security/php-539-fixes-hash-collision-dos-vulnerability-183947>`_

Windows
-------
Para usar Phalcon en Windows debes descargar un DLL y ubicarlo en el directorio de extensiones. Edita el php.ini y agrega al final:

	extension=php_phalcon.dll

Finalmente, reinicia el servidor web.

El siguiente video explica como instalar Phalcon en Windows paso a paso, el material se encuentra en Inglés.

.. raw:: html

	<div align="center"><iframe src="http://player.vimeo.com/video/40265988" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>

Guías Relacionadas
^^^^^^^^^^^^^^^^^^

.. toctree::
	:maxdepth: 1

	xampp
	wamp

Linux/Solaris/Mac
-----------------
En un sistema Linux/Solaris/Mac puedes compilar e instalar la extensión fácilmente desde la fuente del repositorio:

Requerimientos
^^^^^^^^^^^^
Los paquetes requeridos son:

* PHP 5.3.x/5.4.x fuentes de desarrollo (development resources)
* Compilador GCC (Linux/Solaris) o Xcode (Mac)
* Git (a menos que descargues el paquete manualmente desde Github)

Paquetes específicos para plataformas comunes:

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

Compilación
^^^^^^^^^^^
Compilando la extensión:

.. code-block:: bash

	git clone git://github.com/phalcon/cphalcon.git
	cd cphalcon/build
	sudo ./install

Añadiendo la extensión a php.ini

.. code-block:: bash

	extension=phalcon.so

Reiniciando el servidor web.

Phalcon automáticamente detecta tu arquitectura de procesador, sin embargo, puedes forzar la compilación para la arquitectura deseada:

.. code-block:: bash

	sudo ./install 32bits
	sudo ./install 64bits
	sudo ./install safe

FreeBSD
-------
Existe una variante disponible para FreeBSD. Solo necesitas esta simple línea de comandos para instalarlo:

.. code-block:: bash

	pkg_add -r phalcon

o

.. code-block:: bash

	export CFLAGS="-O2 -fno-delete-null-pointer-checks"
	cd /usr/ports/www/phalcon && make install clean

Notas para la instalación
------------------

Notas para los servidores web:

.. toctree::
	:maxdepth: 1

	apache
	nginx
	cherokee
