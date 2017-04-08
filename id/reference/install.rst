Instalasi
=========
Ektensi PHP butuh metode instalasi yang sedikit berbeda dibanding framework atau library PHP tradisional.
Anda bisa download paket binary sistem pilihan anda atau build dari source code.

Windows
-------
Untuk menggunakan Phalcon di Windows anda dapat download_ library DLL. Edit file php.ini anda dan menambahkan diakhir:

.. code-block:: bash

    extension=php_phalcon.dll

Restart webserver anda.

Screencast berikut adalah panduan langkah demi langkah menginstall Phalcon di Windows:

.. raw:: html

    <div align="center"><iframe src="https://player.vimeo.com/video/40265988" width="500" height="266" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>

Panduan Terkait
^^^^^^^^^^^^^^^
.. toctree::
    :maxdepth: 1

    xampp
    wamp

Linux/Solaris
-------------

Debian / Ubuntu
^^^^^^^^^^^^^^^
Untuk menambah repositori ke distribusi anda:

.. code-block:: bash

    # Stable releases
    curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | sudo bash

    # Nightly releases
    curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.deb.sh | sudo bash

Ini cukup dilakukan sekali kecuali distribusi anda berubah atau anda ingin beralih dari stable ke nightly build.

Untuk menginstall Phalcon:

.. code-block:: bash

    sudo apt-get install php5-phalcon

    # or for PHP 7

    sudo apt-get install php7.0-phalcon

Distribusi RPM (misal CentOS)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Untuk menambah repositori ke distribusi anda:


.. code-block:: bash

    # Stable releases
    curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.rpm.sh | sudo bash

    # Nightly releases
    curl -s https://packagecloud.io/install/repositories/phalcon/nightly/script.rpm.sh | sudo bash

Ini cukup dilakukan sekali kecuali distribusi anda berubah atau anda ingin beralih dari stable ke nightly build.

Untuk menginstall Phalcon:

.. code-block:: bash

    sudo yum install php56u-phalcon

    # or for PHP 7

    sudo yum install php70u-phalcon

Mengkompile dari source
^^^^^^^^^^^^^^^^^^^^^^^
Di sistem Linux/Solaris anda dapat dengan mudah mengkompile dan menginstall ekstensi dari source code:

Paket yang wajib:

* PHP >= 5.5 development resources
* GCC compiler (Linux/Solaris)
* Git (jika belum terinstall di sistem anda - kecuali anda download paket dari GitHub dan upload ke server lewat FTP/SFTP)

Paket tertentu dari platform umum:

.. code-block:: bash

    # Ubuntu
    sudo apt-get install php5-dev libpcre3-dev gcc make php5-mysql

    # Suse
    sudo yast -i gcc make autoconf php5-devel php5-pear php5-mysql

    # CentOS/RedHat/Fedora
    sudo yum install php-devel pcre-devel gcc make

    # Solaris
    pkg install gcc-45 php-56 apache-php56

Menciptakan ekstensi:

.. code-block:: bash

    git clone git://github.com/phalcon/cphalcon.git

    cd cphalcon/build

    sudo ./install

Tambahkan ekstensi ke konfigurasi PHP:

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

Restart webserver.

Jika Anda menggunakan Ubuntu/Debian dengan php5-fpm, restart:

.. code-block:: bash

    sudo service php5-fpm restart

Phalcon otomatis mendeteksi arsitektur anda, namun, anda dapat memaksa kompilasi untuk arsitekstur tertentu:

.. code-block:: bash

    cd cphalcon/build

    # One of the following:
    sudo ./install 32bits
    sudo ./install 64bits
    sudo ./install safe

Jika installer otomatis gagal, coba build ekstensi secara manual:

.. code-block:: bash

    cd cphalcon/build/64bits

    export CFLAGS="-O2 --fvisibility=hidden"

    ./configure --enable-phalcon

    make && sudo make install

Mac OS X
--------
Di sistem Mac OS X anda dapat mengkompile dan menginstall ekstensi dari source code:

Kebutuhan
^^^^^^^^^
Paket wajib:

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

Tambahkan ekstensi ke konfigurasi PHP anda.

FreeBSD
-------
Sebuah port tersedia untuk FreeBSD. Cuma butuh perintah sederhana berikut untuk menginstall:

.. code-block:: bash

    pkg_add -r phalcon

atau

.. code-block:: bash

    export CFLAGS="-O2 --fvisibility=hidden"

    cd /usr/ports/www/phalcon

    make install clean

Menguji instalasi anda
----------------------
Cek output :code:`phpinfo()` untuk bagian yang menyebut "Phalcon" atau jalankan potongan kode berikut:

.. code-block:: php

    <?php print_r(get_loaded_extensions()); ?>

Ekstensi Phalcon seharusnya muncul sebagai bagian output:

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

Catatan Instalasi
-----------------
Catatan instalasi untuk Web Server:

.. toctree::
    :maxdepth: 1

    apache
    nginx
    cherokee
    built-in

.. _download: http://phalconphp.com/en/download
