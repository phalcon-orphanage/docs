Instalación
===========
Las extensiones de PHP requieren un método diferente de instalación a los frameworks o librerias tradicionales. 
Puedes descargar tanto un paquete binario para tu sistema o compilarlo desde el código fuente.

.. highlights::
	Phalcon compila desde PHP 5.3.1, pero debido a errores antiguos de PHP que causan memory leaks, recomendamos usar al menos 5.3.11.

.. highlights::
	Versiones inferiores a PHP 5.3.9 tienen fallos de seguridad y no son recomendadas para sitios en producción. `Aprender más <http://www.infoworld.com/d/security/php-539-fixes-hash-collision-dos-vulnerability-183947>`_

Windows
-------
Para usar Phalcon en Windows debes descargar un DLL y ubicarlo en el directorio de extensiones. Edita el php.ini y agrega al final:

	extension=php_phalcon.dll

Reiniciar el servidor web.

El siguiente screencast explica como instalar Phalcon en Windows paso a paso:

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
On a Linux/Solaris/Mac system you can easily compile and install the extension from the source code:

Requirements
^^^^^^^^^^^^
Prerequisite packages are:

* PHP 5.3.x/5.4.x development resources
* GCC compiler (Linux/Solaris) or Xcode (Mac)
* Git (if not already installed in your system - unless you download the package from GitHub and upload it on your server via FTP/SFTP)

Specific packages for common platforms:

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

Compilation
^^^^^^^^^^^
Creating the extension:

.. code-block:: bash

	git clone git://github.com/phalcon/cphalcon.git
	cd cphalcon/build
	sudo ./install

Add extension to your php.ini

.. code-block:: bash

	extension=phalcon.so

Restart the webserver.

Phalcon automatically detects your architecture, however, you can force the compilation for a specific architecture:

.. code-block:: bash

	sudo ./install 32bits
	sudo ./install 64bits
	sudo ./install safe

FreeBSD
-------
A port is available for FreeBSD. Just only need these simple line commands to install it:

.. code-block:: bash

	pkg_add -r phalcon

or

.. code-block:: bash

	export CFLAGS="-O2 -fno-delete-null-pointer-checks"
	cd /usr/ports/www/phalcon && make install clean

Installation Notes
------------------

Installation notes for Web Servers:

.. toctree::
	:maxdepth: 1

	apache
	nginx
	cherokee
