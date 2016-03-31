Class **Phalcon\\Image\\Adapter\\Imagick**
==========================================

*extends* abstract class :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`

*implements* :doc:`Phalcon\\Image\\AdapterInterface <Phalcon_Image_AdapterInterface>`

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/image/adapter/imagick.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Image manipulation support. Allows images to be resized, cropped, etc.  

.. code-block:: php

    <?php

     $image = new Phalcon\Image\Adapter\Imagick("upload/test.jpg");
     $image->resize(200, 200)->rotate(90)->crop(100, 100);
     if ($image->save()) {
         echo 'success';
     }



Methods
-------

public static  **check** ()

Checks if Imagick is enabled



public  **__construct** (*unknown* $file, [*unknown* $width], [*unknown* $height])

\\Phalcon\\Image\\Adapter\\Imagick constructor



protected  **_resize** (*unknown* $width, *unknown* $height)

Execute a resize.



protected  **_liquidRescale** (*unknown* $width, *unknown* $height, *unknown* $deltaX, *unknown* $rigidity)

This method scales the images using liquid rescaling method. Only support Imagick



protected  **_crop** (*unknown* $width, *unknown* $height, *unknown* $offsetX, *unknown* $offsetY)

Execute a crop.



protected  **_rotate** (*unknown* $degrees)

Execute a rotation.



protected  **_flip** (*unknown* $direction)

Execute a flip.



protected  **_sharpen** (*unknown* $amount)

Execute a sharpen.



protected  **_reflection** (*unknown* $height, *unknown* $opacity, *unknown* $fadeIn)

Execute a reflection.



protected  **_watermark** (:doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>` $image, *unknown* $offsetX, *unknown* $offsetY, *unknown* $opacity)

Execute a watermarking.



protected  **_text** (*unknown* $text, *unknown* $offsetX, *unknown* $offsetY, *unknown* $opacity, *unknown* $r, *unknown* $g, *unknown* $b, *unknown* $size, *unknown* $fontfile)

Execute a text



protected  **_mask** (:doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>` $image)

Composite one image onto another



protected  **_background** (*unknown* $r, *unknown* $g, *unknown* $b, *unknown* $opacity)

Execute a background.



protected  **_blur** (*unknown* $radius)

Blur image



protected  **_pixelate** (*unknown* $amount)

Pixelate image



protected  **_save** (*unknown* $file, *unknown* $quality)

Execute a save.



protected  **_render** (*unknown* $extension, *unknown* $quality)

Execute a render.



public  **__destruct** ()

Destroys the loaded image to free up resources.



public  **getInternalImInstance** ()

Get instance



public  **setResourceLimit** (*unknown* $type, *unknown* $limit)

Sets the limit for a particular resource in megabytes



public  **getImage** () inherited from Phalcon\\Image\\Adapter

...


public  **getRealpath** () inherited from Phalcon\\Image\\Adapter

...


public  **getWidth** () inherited from Phalcon\\Image\\Adapter

Image width



public  **getHeight** () inherited from Phalcon\\Image\\Adapter

Image height



public  **getType** () inherited from Phalcon\\Image\\Adapter

Image type Driver dependent



public  **getMime** () inherited from Phalcon\\Image\\Adapter

Image mime type



public  **resize** ([*unknown* $width], [*unknown* $height], [*unknown* $master]) inherited from Phalcon\\Image\\Adapter

Resize the image to the given size



public  **liquidRescale** (*unknown* $width, *unknown* $height, [*unknown* $deltaX], [*unknown* $rigidity]) inherited from Phalcon\\Image\\Adapter

This method scales the images using liquid rescaling method. Only support Imagick



public  **crop** (*unknown* $width, *unknown* $height, [*unknown* $offsetX], [*unknown* $offsetY]) inherited from Phalcon\\Image\\Adapter

Crop an image to the given size



public  **rotate** (*unknown* $degrees) inherited from Phalcon\\Image\\Adapter

Rotate the image by a given amount



public  **flip** (*unknown* $direction) inherited from Phalcon\\Image\\Adapter

Flip the image along the horizontal or vertical axis



public  **sharpen** (*unknown* $amount) inherited from Phalcon\\Image\\Adapter

Sharpen the image by a given amount



public  **reflection** (*unknown* $height, [*unknown* $opacity], [*unknown* $fadeIn]) inherited from Phalcon\\Image\\Adapter

Add a reflection to an image



public  **watermark** (:doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>` $watermark, [*unknown* $offsetX], [*unknown* $offsetY], [*unknown* $opacity]) inherited from Phalcon\\Image\\Adapter

Add a watermark to an image with the specified opacity



public  **text** (*unknown* $text, [*unknown* $offsetX], [*unknown* $offsetY], [*unknown* $opacity], [*unknown* $color], [*unknown* $size], [*unknown* $fontfile]) inherited from Phalcon\\Image\\Adapter

Add a text to an image with a specified opacity



public  **mask** (:doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>` $watermark) inherited from Phalcon\\Image\\Adapter

Composite one image onto another



public  **background** (*unknown* $color, [*unknown* $opacity]) inherited from Phalcon\\Image\\Adapter

Set the background color of an image



public  **blur** (*unknown* $radius) inherited from Phalcon\\Image\\Adapter

Blur image



public  **pixelate** (*unknown* $amount) inherited from Phalcon\\Image\\Adapter

Pixelate image



public  **save** ([*unknown* $file], [*unknown* $quality]) inherited from Phalcon\\Image\\Adapter

Save the image



public  **render** ([*unknown* $ext], [*unknown* $quality]) inherited from Phalcon\\Image\\Adapter

Render the image and return the binary string



