Class **Phalcon\\Image\\Adapter\\GD**
=====================================

*extends* abstract class :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`

*implements* :doc:`Phalcon\\Image\\AdapterInterface <Phalcon_Image_AdapterInterface>`

Image manipulation support. Allows images to be resized, cropped, etc.  

.. code-block:: php

    <?php

    $image = new Phalcon\Image\Adapter\GD("upload/test.jpg");
    $image->resize(200, 200)->rotate(90)->crop(100, 100);
    if ($image->save()) {
    	echo 'success';
    }



Methods
---------

public static *boolean*  **check** ()

Checks if GD is enabled



public  **__construct** (*string* $file, [*unknown* $width], [*unknown* $height])

Phalcon\\Image\\GD constructor



protected  **_resize** (*int* $width, *int* $height)

Execute a resize.



protected :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **_liquidRescale** (*unknown* $width, *unknown* $height, *unknown* $delta_x, *unknown* $rigidity)

This method scales the images using liquid rescaling method. Only support Imagick



protected  **_crop** (*int* $width, *int* $height, *int* $offset_x, *int* $offset_y)

Execute a crop.



protected  **_rotate** (*int* $degrees)

Execute a rotation.



protected  **_flip** (*int* $direction)

Execute a flip.



protected  **_sharpen** (*int* $amount)

Execute a sharpen.



protected  **_reflection** (*int* $height, *int* $opacity, *boolean* $fade_in)

Execute a reflection.



protected  **_watermark** (:doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>` $watermark, *int* $offset_x, *int* $offset_y, *int* $opacity)

Execute a watermarking.



protected  **_text** (*unknown* $text, *int* $offset_x, *int* $offset_y, *int* $opacity, *int* $r, *int* $g, *int* $b, *int* $size, *string* $fontfile)

Execute a text



protected  **_mask** (*unknown* $mask)

Composite one image onto another



protected  **_background** (*int* $r, *int* $g, *int* $b, *unknown* $quality)

Execute a background.



protected  **_blur** (*unknown* $radius)

Blur image



protected  **_pixelate** (*unknown* $amount)

Pixelate image



protected *boolean*  **_save** (*string* $file, *int* $quality)

Execute a save.



protected *string*  **_render** (*string* $type, *int* $quality)

Execute a render.



protected *resource*  **_create** (*int* $width, *int* $height)

Create an empty image with the given width and height.



public  **__destruct** ()

Destroys the loaded image to free up resources.



public *string*  **getRealPath** () inherited from Phalcon\\Image\\Adapter

Returns the real path of the image file



public *int*  **getWidth** () inherited from Phalcon\\Image\\Adapter

Returns the width of images



public *int*  **getHeight** () inherited from Phalcon\\Image\\Adapter

Returns the height of images



public *int*  **getType** () inherited from Phalcon\\Image\\Adapter

Returns the type of images



public *string*  **getMime** () inherited from Phalcon\\Image\\Adapter

Returns the mime of images



public *resource*  **getImage** () inherited from Phalcon\\Image\\Adapter

Returns the image of images



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **resize** ([*unknown* $width], [*unknown* $height], [*unknown* $master]) inherited from Phalcon\\Image\\Adapter

Resize the image to the given size. Either the width or the height can be omitted and the image will be resized proportionally.



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **liquidRescale** (*unknown* $width, *unknown* $height, [*unknown* $delta_x], [*unknown* $rigidity]) inherited from Phalcon\\Image\\Adapter

This method scales the images using liquid rescaling method. Only support Imagick



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **crop** (*unknown* $width, *unknown* $height, [*unknown* $offset_x], [*unknown* $offset_y]) inherited from Phalcon\\Image\\Adapter

Crop an image to the given size. Either the width or the height can be omitted and the current width or height will be used.



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **rotate** (*unknown* $degrees) inherited from Phalcon\\Image\\Adapter

Rotate the image by a given amount.



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **flip** (*unknown* $direction) inherited from Phalcon\\Image\\Adapter

Flip the image along the horizontal or vertical axis.



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **sharpen** (*unknown* $amount) inherited from Phalcon\\Image\\Adapter

Sharpen the image by a given amount.



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **reflection** ([*unknown* $height], [*unknown* $opacity], [*unknown* $fade_in]) inherited from Phalcon\\Image\\Adapter

Add a reflection to an image. The most opaque part of the reflection will be equal to the opacity setting and fade out to full transparent. Alpha transparency is preserved.



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **watermark** (*unknown* $watermark, [*unknown* $offset_x], [*unknown* $offset_y], [*unknown* $opacity]) inherited from Phalcon\\Image\\Adapter

Add a watermark to an image with a specified opacity. Alpha transparency will be preserved.



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **text** (*unknown* $text, [*unknown* $offset_x], [*unknown* $offset_y], [*unknown* $opacity], [*unknown* $color], [*unknown* $size], [*unknown* $fontfile]) inherited from Phalcon\\Image\\Adapter

Add a text to an image with a specified opacity.



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **mask** (*unknown* $mask) inherited from Phalcon\\Image\\Adapter

Composite one image onto another



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **background** (*unknown* $color, [*unknown* $quality]) inherited from Phalcon\\Image\\Adapter

Set the background color of an image. This is only useful for images with alpha transparency.



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **blur** ([*unknown* $radius]) inherited from Phalcon\\Image\\Adapter

Blur image



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **pixelate** ([*unknown* $amount]) inherited from Phalcon\\Image\\Adapter

Pixelate image



public *boolean*  **save** ([*unknown* $file], [*unknown* $quality]) inherited from Phalcon\\Image\\Adapter

Save the image. If the filename is omitted, the original image will be overwritten.



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **render** ([*unknown* $ext], [*unknown* $quality]) inherited from Phalcon\\Image\\Adapter

Render the image and return the binary string.



