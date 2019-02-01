---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Image\Adapter'
---
# Abstract class **Phalcon\Image\Adapter**

*implements* [Phalcon\Image\AdapterInterface](Phalcon_Image_AdapterInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/image/adapter.zep)

所有图像适配器必须都使用此类

## 方法

public **getImage** ()

...

public **getRealpath** ()

...

public **getWidth** ()

图片宽度

public **getHeight** ()

图像高度

public **getType** ()

图像类型和驱动程序有关

public **getMime** ()

图像 mime 类型

public **resize** ([*mixed* $width], [*mixed* $height], [*mixed* $master])

将图像调整为给定大小

public **liquidRescale** (*mixed* $width, *mixed* $height, [*mixed* $deltaX], [*mixed* $rigidity])

This method scales the images using liquid rescaling method. Only support Imagick

public **crop** (*mixed* $width, *mixed* $height, [*mixed* $offsetX], [*mixed* $offsetY])

作物对给定大小的图像

public **rotate** (*mixed* $degrees)

旋转图像，按给定的数量

public **flip** (*mixed* $direction)

翻转图像沿水平或垂直轴

public **sharpen** (*mixed* $amount)

一个给定值锐化图像

public **reflection** (*mixed* $height, [*mixed* $opacity], [*mixed* $fadeIn])

向图像添加一个反射

public **watermark** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $watermark, [*mixed* $offsetX], [*mixed* $offsetY], [*mixed* $opacity])

向指定的不透明度设置为图像添加水印

public **text** (*mixed* $text, [*mixed* $offsetX], [*mixed* $offsetY], [*mixed* $opacity], [*mixed* $color], [*mixed* $size], [*mixed* $fontfile])

将文本添加到具有指定的不透明度的图像

public **mask** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $watermark)

将一个图像合成到另一个图像上

public **background** (*mixed* $color, [*mixed* $opacity])

设置图像的背景颜色

public **blur** (*mixed* $radius)

模糊图像。

public **pixelate** (*mixed* $amount)

像素化图像

public **save** ([*mixed* $file], [*mixed* $quality])

保存图像

public **render** ([*mixed* $ext], [*mixed* $quality])

呈现图像，且返回二进制字符串