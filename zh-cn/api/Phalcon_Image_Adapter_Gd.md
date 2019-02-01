---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Image\Adapter\Gd'
---
# Class **Phalcon\Image\Adapter\Gd**

*extends* abstract class [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

*implements* [Phalcon\Image\AdapterInterface](Phalcon_Image_AdapterInterface)

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

protected **_watermark** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $watermark, *mixed* $offsetX, *mixed* $offsetY, *mixed* $opacity)

...

protected **_text** (*mixed* $text, *mixed* $offsetX, *mixed* $offsetY, *mixed* $opacity, *mixed* $r, *mixed* $g, *mixed* $b, *mixed* $size, *mixed* $fontfile)

...

protected **_mask** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $mask)

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

public **getImage** () inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

...

public **getRealpath** () inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

...

public **getWidth** () inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

图片宽度

public **getHeight** () inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

图像高度

public **getType** () inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

图像类型和驱动程序有关

public **getMime** () inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

图像 mime 类型

public **resize** ([*mixed* $width], [*mixed* $height], [*mixed* $master]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

将图像调整为给定大小

public **liquidRescale** (*mixed* $width, *mixed* $height, [*mixed* $deltaX], [*mixed* $rigidity]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

This method scales the images using liquid rescaling method. Only support Imagick

public **crop** (*mixed* $width, *mixed* $height, [*mixed* $offsetX], [*mixed* $offsetY]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

作物对给定大小的图像

public **rotate** (*mixed* $degrees) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

旋转图像，按给定的数量

public **flip** (*mixed* $direction) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

翻转图像沿水平或垂直轴

public **sharpen** (*mixed* $amount) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

一个给定值锐化图像

public **reflection** (*mixed* $height, [*mixed* $opacity], [*mixed* $fadeIn]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

向图像添加一个反射

public **watermark** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $watermark, [*mixed* $offsetX], [*mixed* $offsetY], [*mixed* $opacity]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

向指定的不透明度设置为图像添加水印

public **text** (*mixed* $text, [*mixed* $offsetX], [*mixed* $offsetY], [*mixed* $opacity], [*mixed* $color], [*mixed* $size], [*mixed* $fontfile]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

将文本添加到具有指定的不透明度的图像

public **mask** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $watermark) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

将一个图像合成到另一个图像上

public **background** (*mixed* $color, [*mixed* $opacity]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

设置图像的背景颜色

public **blur** (*mixed* $radius) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

模糊图像。

public **pixelate** (*mixed* $amount) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

像素化图像

public **save** ([*mixed* $file], [*mixed* $quality]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

保存图像

public **render** ([*mixed* $ext], [*mixed* $quality]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

呈现图像，且返回二进制字符串