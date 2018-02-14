# Class **Phalcon\\Image\\Adapter\\Imagick**

*extends* abstract class [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

*implements* [Phalcon\Image\AdapterInterface](/en/3.1.2/api/Phalcon_Image_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/image/adapter/imagick.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Image manipulation support. Allows images to be resized, cropped, etc.

```php
<?php

$image = new \Phalcon\Image\Adapter\Imagick("upload/test.jpg");

$image->resize(200, 200)->rotate(90)->crop(100, 100);

if ($image->save()) {
    echo "success";
}

```

## Methods
public static  **check** ()

Checks if Imagick is enabled

public  **__construct** (*mixed* $file, [*mixed* $width], [*mixed* $height])

\\Phalcon\\Image\\Adapter\\Imagick constructor

protected  **_resize** (*mixed* $width, *mixed* $height)

Execute a resize.

protected  **_liquidRescale** (*mixed* $width, *mixed* $height, *mixed* $deltaX, *mixed* $rigidity)

This method scales the images using liquid rescaling method. Only support Imagick

protected  **_crop** (*mixed* $width, *mixed* $height, *mixed* $offsetX, *mixed* $offsetY)

Execute a crop.

protected  **_rotate** (*mixed* $degrees)

Execute a rotation.

protected  **_flip** (*mixed* $direction)

Execute a flip.

protected  **_sharpen** (*mixed* $amount)

Execute a sharpen.

protected  **_reflection** (*mixed* $height, *mixed* $opacity, *mixed* $fadeIn)

Execute a reflection.

protected  **_watermark** ([Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter) $image, *mixed* $offsetX, *mixed* $offsetY, *mixed* $opacity)

Execute a watermarking.

protected  **_text** (*mixed* $text, *mixed* $offsetX, *mixed* $offsetY, *mixed* $opacity, *mixed* $r, *mixed* $g, *mixed* $b, *mixed* $size, *mixed* $fontfile)

Execute a text

protected  **_mask** ([Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter) $image)

Composite one image onto another

protected  **_background** (*mixed* $r, *mixed* $g, *mixed* $b, *mixed* $opacity)

Execute a background.

protected  **_blur** (*mixed* $radius)

Blur image

protected  **_pixelate** (*mixed* $amount)

Pixelate image

protected  **_save** (*mixed* $file, *mixed* $quality)

Execute a save.

protected  **_render** (*mixed* $extension, *mixed* $quality)

Execute a render.

public  **__destruct** ()

Destroys the loaded image to free up resources.

public  **getInternalImInstance** ()

Get instance

public  **setResourceLimit** (*mixed* $type, *mixed* $limit)

Sets the limit for a particular resource in megabytes

public  **getImage** () inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

...

public  **getRealpath** () inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

...

public  **getWidth** () inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Image width

public  **getHeight** () inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Image height

public  **getType** () inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Image type
Driver dependent

public  **getMime** () inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Image mime type

public  **resize** ([*mixed* $width], [*mixed* $height], [*mixed* $master]) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Resize the image to the given size

public  **liquidRescale** (*mixed* $width, *mixed* $height, [*mixed* $deltaX], [*mixed* $rigidity]) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

This method scales the images using liquid rescaling method. Only support Imagick

public  **crop** (*mixed* $width, *mixed* $height, [*mixed* $offsetX], [*mixed* $offsetY]) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Crop an image to the given size

public  **rotate** (*mixed* $degrees) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Rotate the image by a given amount

public  **flip** (*mixed* $direction) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Flip the image along the horizontal or vertical axis

public  **sharpen** (*mixed* $amount) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Sharpen the image by a given amount

public  **reflection** (*mixed* $height, [*mixed* $opacity], [*mixed* $fadeIn]) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Add a reflection to an image

public  **watermark** ([Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter) $watermark, [*mixed* $offsetX], [*mixed* $offsetY], [*mixed* $opacity]) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Add a watermark to an image with the specified opacity

public  **text** (*mixed* $text, [*mixed* $offsetX], [*mixed* $offsetY], [*mixed* $opacity], [*mixed* $color], [*mixed* $size], [*mixed* $fontfile]) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Add a text to an image with a specified opacity

public  **mask** ([Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter) $watermark) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Composite one image onto another

public  **background** (*mixed* $color, [*mixed* $opacity]) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Set the background color of an image

public  **blur** (*mixed* $radius) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Blur image

public  **pixelate** (*mixed* $amount) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Pixelate image

public  **save** ([*mixed* $file], [*mixed* $quality]) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Save the image

public  **render** ([*mixed* $ext], [*mixed* $quality]) inherited from [Phalcon\Image\Adapter](/en/3.1.2/api/Phalcon_Image_Adapter)

Render the image and return the binary string

