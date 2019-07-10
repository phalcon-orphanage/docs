---
layout: default
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Image\Adapter\Gd'
---

# Class **Phalcon\Image\Adapter\Gd**

*extends* abstract class [Phalcon\Image\Adapter](Phalcon_Image)

*implements* [Phalcon\Image\AdapterInterface](Phalcon_Image)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/image/adapter/gd.zep)

## 方法

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

protected **_watermark** ([Phalcon\Image\Adapter](Phalcon_Image) $watermark, *mixed* $offsetX, *mixed* $offsetY, *mixed* $opacity)

...

protected **_text** (*mixed* $text, *mixed* $offsetX, *mixed* $offsetY, *mixed* $opacity, *mixed* $r, *mixed* $g, *mixed* $b, *mixed* $size, *mixed* $fontfile)

...

protected **_mask** ([Phalcon\Image\Adapter](Phalcon_Image) $mask)

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

public **getImage** () inherited from [Phalcon\Image\Adapter](Phalcon_Image)

...

public **getRealpath** () inherited from [Phalcon\Image\Adapter](Phalcon_Image)

...

public **getWidth** () inherited from [Phalcon\Image\Adapter](Phalcon_Image)

Image width

public **getHeight** () inherited from [Phalcon\Image\Adapter](Phalcon_Image)

Image height

public **getType** () inherited from [Phalcon\Image\Adapter](Phalcon_Image)

Image type Driver dependent

public **getMime** () inherited from [Phalcon\Image\Adapter](Phalcon_Image)

Image mime type

public **resize** ([*mixed* $width], [*mixed* $height], [*mixed* $master]) inherited from [Phalcon\Image\Adapter](Phalcon_Image)

Resize the image to the given size

public **liquidRescale** (*mixed* $width, *mixed* $height, [*mixed* $deltaX], [*mixed* $rigidity]) inherited from [Phalcon\Image\Adapter](Phalcon_Image)

This method scales the images using liquid rescaling method. Only support Imagick

public **crop** (*mixed* $width, *mixed* $height, [*mixed* $offsetX], [*mixed* $offsetY]) inherited from [Phalcon\Image\Adapter](Phalcon_Image)

Crop an image to the given size

public **rotate** (*mixed* $degrees) inherited from [Phalcon\Image\Adapter](Phalcon_Image)

Rotate the image by a given amount

public **flip** (*mixed* $direction) inherited from [Phalcon\Image\Adapter](Phalcon_Image)

Flip the image along the horizontal or vertical axis

public **sharpen** (*mixed* $amount) inherited from [Phalcon\Image\Adapter](Phalcon_Image)

Sharpen the image by a given amount

public **reflection** (*mixed* $height, [*mixed* $opacity], [*mixed* $fadeIn]) inherited from [Phalcon\Image\Adapter](Phalcon_Image)

Add a reflection to an image

public **watermark** ([Phalcon\Image\Adapter](Phalcon_Image) $watermark, [*mixed* $offsetX], [*mixed* $offsetY], [*mixed* $opacity]) inherited from [Phalcon\Image\Adapter](Phalcon_Image)

Add a watermark to an image with the specified opacity

public **text** (*mixed* $text, [*mixed* $offsetX], [*mixed* $offsetY], [*mixed* $opacity], [*mixed* $color], [*mixed* $size], [*mixed* $fontfile]) inherited from [Phalcon\Image\Adapter](Phalcon_Image)

Add a text to an image with a specified opacity

public **mask** ([Phalcon\Image\Adapter](Phalcon_Image) $watermark) inherited from [Phalcon\Image\Adapter](Phalcon_Image)

Composite one image onto another

public **background** (*mixed* $color, [*mixed* $opacity]) inherited from [Phalcon\Image\Adapter](Phalcon_Image)

Set the background color of an image

public **blur** (*mixed* $radius) inherited from [Phalcon\Image\Adapter](Phalcon_Image)

Blur image

public **pixelate** (*mixed* $amount) inherited from [Phalcon\Image\Adapter](Phalcon_Image)

Pixelate image

public **save** ([*mixed* $file], [*mixed* $quality]) inherited from [Phalcon\Image\Adapter](Phalcon_Image)

Save the image

public **render** ([*mixed* $ext], [*mixed* $quality]) inherited from [Phalcon\Image\Adapter](Phalcon_Image)

Render the image and return the binary string