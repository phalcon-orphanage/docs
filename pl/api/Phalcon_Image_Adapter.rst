Abstract class **Phalcon\\Image\\Adapter**
==========================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/image/adapter.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

All image adapters must use this class


Methods
-------

public  **getImage** ()

...


public  **getRealpath** ()

...


public  **getWidth** ()

Image width



public  **getHeight** ()

Image height



public  **getType** ()

Image type Driver dependent



public  **getMime** ()

Image mime type



public  **resize** ([*unknown* $width], [*unknown* $height], [*unknown* $master])

Resize the image to the given size



public  **liquidRescale** (*unknown* $width, *unknown* $height, [*unknown* $deltaX], [*unknown* $rigidity])

This method scales the images using liquid rescaling method. Only support Imagick



public  **crop** (*unknown* $width, *unknown* $height, [*unknown* $offsetX], [*unknown* $offsetY])

Crop an image to the given size



public  **rotate** (*unknown* $degrees)

Rotate the image by a given amount



public  **flip** (*unknown* $direction)

Flip the image along the horizontal or vertical axis



public  **sharpen** (*unknown* $amount)

Sharpen the image by a given amount



public  **reflection** (*unknown* $height, [*unknown* $opacity], [*unknown* $fadeIn])

Add a reflection to an image



public  **watermark** (:doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>` $watermark, [*unknown* $offsetX], [*unknown* $offsetY], [*unknown* $opacity])

Add a watermark to an image with the specified opacity



public  **text** (*unknown* $text, [*unknown* $offsetX], [*unknown* $offsetY], [*unknown* $opacity], [*unknown* $color], [*unknown* $size], [*unknown* $fontfile])

Add a text to an image with a specified opacity



public  **mask** (:doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>` $watermark)

Composite one image onto another



public  **background** (*unknown* $color, [*unknown* $opacity])

Set the background color of an image



public  **blur** (*unknown* $radius)

Blur image



public  **pixelate** (*unknown* $amount)

Pixelate image



public  **save** ([*unknown* $file], [*unknown* $quality])

Save the image



public  **render** ([*unknown* $ext], [*unknown* $quality])

Render the image and return the binary string



