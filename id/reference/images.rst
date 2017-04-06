Image
=====

:doc:`Phalcon\\Image <../api/Phalcon_Image>` adalah komponen yang memungkinkan anda memanipulasi file gambar.
Beberapa operasi dapat dilakukan pada objek gambar sama.

.. highlights::

    Panduan ini tidak dimaksudkan sebagai dokumentasi lengkap metode yang tersedia dan argumennya.
    Kunjungi :doc:`API <../api/index>` untuk referensi lengkap.

Adapter
-------
Kompoen ini menggunakan adapter untuk membungkus program pemanipulasi gambar tertentu.
Program pemanipulasi gambar berikut didukung:

+--------------------------------------------------------------------------------+--------------------------------------------+
| Kelas                                                                          | Keterangann                                |
+================================================================================+============================================+
| :doc:`Phalcon\\Image\\Adapter\\Gd <../api/Phalcon_Image_Adapter_Gd>`           | Butuh `GD PHP extension`_.                 |
+--------------------------------------------------------------------------------+--------------------------------------------+
| :doc:`Phalcon\\Image\\Adapter\\Imagick <../api/Phalcon_Image_Adapter_Imagick>` | Butuh `ImageMagick PHP extension`_.        |
+--------------------------------------------------------------------------------+--------------------------------------------+

Mengimplementasi adapter anda sendiri
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Interface :doc:`Phalcon\\Image\\AdapterInterface <../api/Phalcon_Image_AdapterInterface>` harus diimplementasi untuk menciptakan adapter anda sendiri atau menurunkan yang sudah ada.

Menyimpan dan menampilkan gambar
-------------------------------
Sebelum kita mulai dengan beragam fitur komponen image, harus dipahami bagaimana menyimpan dan menampilkan gambar ini.

.. code-block:: php

    <?php

    $image = new \Phalcon\Image\Adapter\Gd("image.jpg");

    // ...

    // Timpa gambar asli
    $image->save();

.. code-block:: php

    <?php

    $image = new \Phalcon\Image\Adapter\Gd("image.jpg");

    // ...

    // Simpan sebagai 'new-image.jpg'
    $image->save("new-image.jpg");

Anda dapat juga mengubah format gambar:

.. code-block:: php

    <?php

    $image = new \Phalcon\Image\Adapter\Gd("image.jpg");

    // ...

    // Simpan sebagai file PNG
    $image->save("image.png");

Ketika menyimpan sebagai sebuah JPEG, anda dapat pula menentukan kualtias sebagai parameter kedua.

.. code-block:: php

    <?php

    $image = new \Phalcon\Image\Adapter\Gd("image.jpg");

    // ...

    // Simpan sebagai file JPEG dengan kualitas 80%
    $image->save("image.jpg", 80);

Mengubah ukuran gambar
----------------------
Ada beberapa mode pengubahan ukuran:

- :code:`\Phalcon\Image::WIDTH`
- :code:`\Phalcon\Image::HEIGHT`
- :code:`\Phalcon\Image::NONE`
- :code:`\Phalcon\Image::TENSILE`
- :code:`\Phalcon\Image::AUTO`
- :code:`\Phalcon\Image::INVERSE`
- :code:`\Phalcon\Image::PRECISE`

:code:`\Phalcon\Image::WIDTH`
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Tinggi akan otomatis dihitung untuk menjaga proporsi sama; Jika anda menentukan tinggi, ia akan diabaikan.

.. code-block:: php

    <?php

    $image = new \Phalcon\Image\Adapter\Gd("image.jpg");

    $image->resize(
        300,
        null,
        \Phalcon\Image::WIDTH
    );

    $image->save("resized-image.jpg");

:code:`\Phalcon\Image::HEIGHT`
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Lebar otomatis dihitung untuk menjaga proporsi sama; jika anda menentukan lebar, ia akan diabaikan.

.. code-block:: php

    <?php

    $image = new \Phalcon\Image\Adapter\Gd("image.jpg");

    $image->resize(
        null,
        300,
        \Phalcon\Image::HEIGHT
    );

    $image->save("resized-image.jpg");

:code:`\Phalcon\Image::NONE`
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Konstan :code:`NONE` mengabaikan rasio image asli.
Lebar dan tinggi tidak diperlukan.
Jika ukuran tidak ditentukan, ukuran asli akan digunakan.
Jika proporsi berubah dari proporsi asli, gambar bisa jadi terdistorsi atau molor.

.. code-block:: php

    <?php

    $image = new \Phalcon\Image\Adapter\Gd("image.jpg");

    $image->resize(
        400,
        200,
        \Phalcon\Image::NONE
    );

    $image->save("resized-image.jpg");

:code:`\Phalcon\Image::TENSILE`
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Mirip dengan konstan :code:`NONE` constant, konstan :code:`TENSILE` mengabaikan rasio gambar asli.
Lebar dan tinggi wajib ada.
Jika proporsi berubah dari proporsi asli, gambar bisa jadi terdistorsi atau molor.


.. code-block:: php

    <?php

    $image = new \Phalcon\Image\Adapter\Gd("image.jpg");

    $image->resize(
        400,
        200,
        \Phalcon\Image::NONE
    );

    $image->save("resized-image.jpg");

Memotong gambar
---------------
Contoh, untuk mendapatkan bujur sanglar 100px kali 100 px dari pusat gambar:

.. code-block:: php

    <?php

    $image = new \Phalcon\Image\Adapter\Gd("image.jpg");

    $width   = 100;
    $height  = 100;
    $offsetX = (($image->getWidth() - $width) / 2);
    $offsetY = (($image->getHeight() - $height) / 2);

    $image->crop($width, $height, $offsetX, $offsetY);

    $image->save("cropped-image.jpg");

Memutar gambar
--------------
.. code-block:: php

    <?php

    $image = new \Phalcon\Image\Adapter\Gd("image.jpg");

    // Putar gambar 90 derajat searah jarum jam
    $image->rotate(90);

    $image->save("rotated-image.jpg");

Membalik gambar
---------------
Anda dapat membalik gambar secara horizontal (menggunakan konstan :code:`\Phalcon\Image::HORIZONTAL`) dan secara vertikal (menggunakan konstan :code:`\Phalcon\Image::VERTICAL`):

.. code-block:: php

    <?php

    $image = new \Phalcon\Image\Adapter\Gd("image.jpg");

    // Balik gambar secara horizontal
    $image->flip(
        \Phalcon\Image::HORIZONTAL
    );

    $image->save("flipped-image.jpg");

Menajamkan gambar
-----------------
Metode :code:`sharpen()` butuh satu parameter - sebuah nilai integer antara 0 (tanpa efek) dan 100 (sangat tajam):

.. code-block:: php

    <?php

    $image = new \Phalcon\Image\Adapter\Gd("image.jpg");

    $image->sharpen(50);

    $image->save("sharpened-image.jpg");

Menambah watermark ke gambar
----------------------------

.. code-block:: php

    <?php

    $image = new \Phalcon\Image\Adapter\Gd("image.jpg");

    $watermark = new \Phalcon\Image\Adapter\Gd("me.jpg");

    // Letakkan watermark di pojok kiri atas
    $offsetX = 10;
    $offsetY = 10;

    $opacity = 70;

    $image->watermark(
        $watermark,
        $offsetX,
        $offsetY,
        $opacity
    );

    $image->save("watermarked-image.jpg");

Tentu anda dapat memanipulasi gambar bertanda air sebelum menerapkan ke gambar utama:

.. code-block:: php

    <?php

    $image = new \Phalcon\Image\Adapter\Gd("image.jpg");

    $watermark = new \Phalcon\Image\Adapter\Gd("me.jpg");

    $watermark->resize(100, 100);
    $watermark->rotate(90);
    $watermark->sharpen(5);

    // Letakkan watermark di pojok kanan bawah dengan margin 10px
    $offsetX = ($image->getWidth() - $watermark->getWidth() - 10);
    $offsetY = ($image->getHeight() - $watermark->getHeight() - 10);

    $opacity = 70;

    $image->watermark(
        $watermark,
        $offsetX,
        $offsetY,
        $opacity
    );

    $image->save("watermarked-image.jpg");

Mengaburkan gambar
------------------
Metode :code:`blur()` butuh satu parameter - sebuah nilai integer antara 0 (tanpa efek) dan 100 (sangat kabur):

.. code-block:: php

    <?php

    $image = new \Phalcon\Image\Adapter\Gd("image.jpg");

    $image->blur(50);

    $image->save("blurred-image.jpg");

Pikselasi gambar
----------------
Metode :code:`pixelate()` single parameter - semakin tinggi nilai integer, semakin bertitik-titik gambar jadinya:

.. code-block:: php

    <?php

    $image = new \Phalcon\Image\Adapter\Gd("image.jpg");

    $image->pixelate(10);

    $image->save("pixelated-image.jpg");

.. _`GD PHP extension`: http://php.net/manual/en/book.image.php
.. _`ImageMagick PHP extension`: http://php.net/manual/en/book.imagick.php