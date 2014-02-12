Abstract class **Phalcon\\Image\\Adapter**
==========================================

*implements* :doc:`Phalcon\\Image\\AdapterInterface <Phalcon_Image_AdapterInterface>`

Base class for Phalcon\\Image adapters


Methods
-------

public *string*  **getRealPath** ()

Returns the real path of the image file



public *int*  **getWidth** ()

Returns the width of images



public *int*  **getHeight** ()

Returns the height of images



public *int*  **getType** ()

Returns the type of images



public *string*  **getMime** ()

Returns the mime of images



public *resource*  **getImage** ()

Returns the image of images



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **resize** ([*unknown* $width], [*unknown* $height])

Resize the image to the given size. Either the width or the height can be omitted and the image will be resized proportionally.



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **liquidRescale** (*unknown* $width, *unknown* $height, [*unknown* $delta_x], [*unknown* $rigidity])

This method scales the images using liquid rescaling method. Only support Imagick



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **crop** (*unknown* $width, *unknown* $height, [*unknown* $offset_x], [*unknown* $offset_y])

Crop an image to the given size. Either the width or the height can be omitted and the current width or height will be used.



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **rotate** (*unknown* $degrees)

Rotate the image by a given amount.



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **flip** (*unknown* $direction)

Flip the image along the horizontal or vertical axis.



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **sharpen** (*unknown* $amount)

Sharpen the image by a given amount.



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **reflection** ([*unknown* $height], [*unknown* $opacity], [*unknown* $fade_in])

Add a reflection to an image. The most opaque part of the reflection will be equal to the opacity setting and fade out to full transparent. Alpha transparency is preserved.



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **watermark** (*unknown* $watermark, [*unknown* $offset_x], [*unknown* $offset_y], [*unknown* $opacity])

Add a watermark to an image with a specified opacity. Alpha transparency will be preserved.



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **text** (*unknown* $text, [*unknown* $offset_x], [*unknown* $offset_y], [*unknown* $opacity], [*unknown* $color], [*unknown* $size], [*unknown* $fontfile])

Add a text to an image with a specified opacity.



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **mask** (*unknown* $mask)

Composite one image onto another



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **background** (*unknown* $color, [*unknown* $quality])

Set the background color of an image. This is only useful for images with alpha transparency.



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **blur** ([*unknown* $radius])

Blur image



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **pixelate** ([*unknown* $amount])

Pixelate image



public *boolean*  **save** ([*unknown* $file], [*unknown* $quality])

Save the image. If the filename is omitted, the original image will be overwritten.



public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **render** ([*unknown* $type], [*unknown* $quality])

Render the image and return the binary string.



