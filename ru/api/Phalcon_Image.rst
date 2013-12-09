Abstract class **Phalcon\\Image**
=================================

Image manipulation support. Allows images to be resized, cropped, etc.  

.. code-block:: php

    <?php

    $image = new Phalcon\Image\Adapter\GD("upload/test.jpg");
    $image->resize(200, 200);
    $image->save();



Constants
---------

*integer* **NONE**

*integer* **WIDTH**

*integer* **HEIGHT**

*integer* **AUTO**

*integer* **INVERSE**

*integer* **PRECISE**

*integer* **TENSILE**

*integer* **HORIZONTAL**

*integer* **VERTICAL**

*integer* **GD**

*integer* **IMAGICK**

