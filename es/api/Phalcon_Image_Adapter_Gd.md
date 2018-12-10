# Class **Phalcon\\Image\\Adapter\\Gd**

*extends* abstract class [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

*implements* [Phalcon\Image\AdapterInterface](/en/3.1.2/api/Phalcon_Image_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/image/adapter/gd.zep" class="btn btn-default btn-sm">Source on GitHub</a>

## Methods

public static **check** ()

...

public **__construct** (*mixed* $file, [*mixed* $width], [*mixed* $height])

...

protected **_resize** (*mixed* $width, *mixed* $height)

...

protected **_crop** (*mixed* $width, *mixed* $height, *mixed* $offsetX, *mixed* $offsetY)

...

protected **_rotate** (*mixed* $degrees)

...

protected **_flip** (*mixed* $direction)

...

protected **_sharpen** (*mixed* $amount)

...

protected **_reflection** (*mixed* $height, *mixed* $opacity, *mixed* $fadeIn)

...

protected **_watermark** ([Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter) $watermark, *mixed* $offsetX, *mixed* $offsetY, *mixed* $opacity)

...

protected **_text** (*mixed* $text, *mixed* $offsetX, *mixed* $offsetY, *mixed* $opacity, *mixed* $r, *mixed* $g, *mixed* $b, *mixed* $size, *mixed* $fontfile)

...

protected **_mask** ([Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter) $mask)

...

protected **_background** (*mixed* $r, *mixed* $g, *mixed* $b, *mixed* $opacity)

...

protected **_blur** (*mixed* $radius)

...

protected **_pixelate** (*mixed* $amount)

...

protected **_save** (*mixed* $file, *mixed* $quality)

...

protected **_render** (*mixed* $ext, *mixed* $quality)

...

protected **_create** (*mixed* $width, *mixed* $height)

...

public **__destruct** ()

...

public **getImage** () inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

...

public **getRealpath** () inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

...

public **getWidth** () inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Image width

public **getHeight** () inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Image height

public **getType** () inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Image type Driver dependent

public **getMime** () inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Image mime type

public **resize** ([*mixed* $width], [*mixed* $height], [*mixed* $master]) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Resize the image to the given size

public **liquidRescale** (*mixed* $width, *mixed* $height, [*mixed* $deltaX], [*mixed* $rigidity]) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

This method scales the images using liquid rescaling method. Only support Imagick

public **crop** (*mixed* $width, *mixed* $height, [*mixed* $offsetX], [*mixed* $offsetY]) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Crop an image to the given size

public **rotate** (*mixed* $degrees) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Rotate the image by a given amount

public **flip** (*mixed* $direction) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Flip the image along the horizontal or vertical axis

public **sharpen** (*mixed* $amount) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Sharpen the image by a given amount

public **reflection** (*mixed* $height, [*mixed* $opacity], [*mixed* $fadeIn]) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Add a reflection to an image

public **watermark** ([Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter) $watermark, [*mixed* $offsetX], [*mixed* $offsetY], [*mixed* $opacity]) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Add a watermark to an image with the specified opacity

public **text** (*mixed* $text, [*mixed* $offsetX], [*mixed* $offsetY], [*mixed* $opacity], [*mixed* $color], [*mixed* $size], [*mixed* $fontfile]) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Add a text to an image with a specified opacity

public **mask** ([Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter) $watermark) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Composite one image onto another

public **background** (*mixed* $color, [*mixed* $opacity]) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Set the background color of an image

public **blur** (*mixed* $radius) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Blur image

public **pixelate** (*mixed* $amount) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Pixelate image

public **save** ([*mixed* $file], [*mixed* $quality]) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Save the image

public **render** ([*mixed* $ext], [*mixed* $quality]) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Render the image and return the binary string