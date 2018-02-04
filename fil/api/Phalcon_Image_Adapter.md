# Abstract class **Phalcon\\Image\\Adapter**

*implements* [Phalcon\Image\AdapterInterface](/en/3.2/api/Phalcon_Image_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/image/adapter.zep" class="btn btn-default btn-sm">Source on GitHub</a>

All image adapters must use this class

## Methods

public **getImage** ()

...

public **getRealpath** ()

...

public **getWidth** ()

Image width

public **getHeight** ()

Image height

public **getType** ()

Image type Driver dependent

public **getMime** ()

Image mime type

public **resize** ([*mixed* $width], [*mixed* $height], [*mixed* $master])

Resize the image to the given size

public **liquidRescale** (*mixed* $width, *mixed* $height, [*mixed* $deltaX], [*mixed* $rigidity])

This method scales the images using liquid rescaling method. Only support Imagick

public **crop** (*mixed* $width, *mixed* $height, [*mixed* $offsetX], [*mixed* $offsetY])

Crop an image to the given size

public **rotate** (*mixed* $degrees)

Rotate the image by a given amount

public **flip** (*mixed* $direction)

Flip the image along the horizontal or vertical axis

public **sharpen** (*mixed* $amount)

Sharpen the image by a given amount

public **reflection** (*mixed* $height, [*mixed* $opacity], [*mixed* $fadeIn])

Add a reflection to an image

public **watermark** ([Phalcon\Image\Adapter](/en/3.2/api/Phalcon_Image_Adapter) $watermark, [*mixed* $offsetX], [*mixed* $offsetY], [*mixed* $opacity])

Add a watermark to an image with the specified opacity

public **text** (*mixed* $text, [*mixed* $offsetX], [*mixed* $offsetY], [*mixed* $opacity], [*mixed* $color], [*mixed* $size], [*mixed* $fontfile])

Add a text to an image with a specified opacity

public **mask** ([Phalcon\Image\Adapter](/en/3.2/api/Phalcon_Image_Adapter) $watermark)

Composite one image onto another

public **background** (*mixed* $color, [*mixed* $opacity])

Set the background color of an image

public **blur** (*mixed* $radius)

Blur image

public **pixelate** (*mixed* $amount)

Pixelate image

public **save** ([*mixed* $file], [*mixed* $quality])

Save the image

public **render** ([*mixed* $ext], [*mixed* $quality])

Render the image and return the binary string