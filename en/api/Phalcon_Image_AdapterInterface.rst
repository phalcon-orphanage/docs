Interface **Phalcon\\Image\\AdapterInterface**
==============================================

Phalcon\\Image\\AdapterInterface initializer


Methods
-------

abstract public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **resize** ([*unknown* $width], [*unknown* $height])

Resize the image to the given size. Either the width or the height can be omitted and the image will be resized proportionally.



abstract public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **crop** (*unknown* $width, *unknown* $height, [*unknown* $offset_x], [*unknown* $offset_y])

Crop an image to the given size. Either the width or the height can be omitted and the current width or height will be used.



abstract public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **rotate** (*unknown* $degrees)

Rotate the image by a given amount.



abstract public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **flip** (*unknown* $direction)

Flip the image along the horizontal or vertical axis.



abstract public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **sharpen** (*unknown* $amount)

Sharpen the image by a given amount.



abstract public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **reflection** ([*unknown* $height], [*unknown* $opacity], [*unknown* $fade_in])

Add a reflection to an image. The most opaque part of the reflection will be equal to the opacity setting and fade out to full transparent. Alpha transparency is preserved.



abstract public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **watermark** (*unknown* $watermark, [*unknown* $offset_x], [*unknown* $offset_y], [*unknown* $opacity])

Add a watermark to an image with a specified opacity. Alpha transparency will be preserved.



abstract public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **background** (*unknown* $color, [*unknown* $quality])

Set the background color of an image. This is only useful for images with alpha transparency.



abstract public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **save** ([*unknown* $file], [*unknown* $quality])

Save the image. If the filename is omitted, the original image will be overwritten.



abstract public :doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>`  **render** ([*unknown* $type], [*unknown* $quality])

Render the image and return the binary string.



