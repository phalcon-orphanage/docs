Phalcon Developer Tools di Linux
================================

Langkah berikut akan memandu anda melalui proses menginstal Phalcon Developer Tools untuk Linux.

Prasyarat
---------
Ekstensi PHP Phalcon diperlukan untuk menjalankan Phalcon Tools. Jika belum menginstall, silakan lihat :doc:`Installation <install>` untuk instruksi.

Download
--------
Anda dapat mendownload cross platform package berisi developer tools dari bagian Download_. Anda dapat juga clone dari Github_.

Buka terminal dan ketik perintah berikut:

.. code-block:: bash

    git clone git://github.com/phalcon/phalcon-devtools.git

.. figure:: ../_static/img/linux-1.png
   :align: center

Lalu masuk ke folder di mana tools diclone dan jalankan ". ./phalcon.sh", (Jangan lupa titik di awal perintah):

.. code-block:: bash

    cd phalcon-devtools/

    . ./phalcon.sh

.. figure:: ../_static/img/linux-2.png
   :align: center

Buat symbolink ke script phalcon.php:

.. code-block:: bash

    ln -s ~/phalcon-devtools/phalcon.php /usr/bin/phalcon

    chmod ugo+x /usr/bin/phalcon

Selamat Phalcon tools anda sudah terinstall!

Panduan Terkait
^^^^^^^^^^^^^^^
* :doc:`Menggunakan Developer Tools <tools>`
* :doc:`Instalasi pada Windows <wintools>`
* :doc:`Instalasi pada Mac <mactools>`

.. _Download: http://phalconphp.com/download
.. _Github: https://github.com/phalcon/phalcon-devtools
