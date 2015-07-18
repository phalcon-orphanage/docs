Class **Phalcon\\Image\\Adapter\\Gd**
=====================================

*extends* abstract class :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`

*implements* :doc:`Phalcon\\Image\\AdapterInterface <Phalcon_Image_AdapterInterface>`

Methods
-------

public static  **check** ()

...


public  **__construct** (*unknown* $file, [*unknown* $width], [*unknown* $height])

...


protected  **_resize** (*unknown* $width, *unknown* $height)

...


protected  **_crop** (*unknown* $width, *unknown* $height, *unknown* $offsetX, *unknown* $offsetY)

...


protected  **_rotate** (*unknown* $degrees)

...


protected  **_flip** (*unknown* $direction)

...


protected  **_sharpen** (*unknown* $amount)

...


protected  **_reflection** (*unknown* $height, *unknown* $opacity, *unknown* $fadeIn)

...


protected  **_watermark** (*unknown* $watermark, *unknown* $offsetX, *unknown* $offsetY, *unknown* $opacity)

...


protected  **_text** (*unknown* $text, *unknown* $offsetX, *unknown* $offsetY, *unknown* $opacity, *unknown* $r, *unknown* $g, *unknown* $b, *unknown* $size, *unknown* $fontfile)

...


protected  **_mask** (*unknown* $mask)

...


protected  **_background** (*unknown* $r, *unknown* $g, *unknown* $b, *unknown* $opacity)

...


protected  **_blur** (*unknown* $radius)

...


protected  **_pixelate** (*unknown* $amount)

...


protected  **_save** (*unknown* $file, *unknown* $quality)

...


protected  **_render** (*unknown* $ext, *unknown* $quality)

...


protected  **_create** (*unknown* $width, *unknown* $height)

...


public  **__destruct** ()

...


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



public  **watermark** (*unknown* $watermark, [*unknown* $offsetX], [*unknown* $offsetY], [*unknown* $opacity]) inherited from Phalcon\\Image\\Adapter

Add a watermark to an image with the specified opacity



public  **text** (*unknown* $text, [*unknown* $offsetX], [*unknown* $offsetY], [*unknown* $opacity], [*unknown* $color], [*unknown* $size], [*unknown* $fontfile]) inherited from Phalcon\\Image\\Adapter

Add a text to an image with a specified opacity



public  **mask** (*unknown* $watermark) inherited from Phalcon\\Image\\Adapter

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



