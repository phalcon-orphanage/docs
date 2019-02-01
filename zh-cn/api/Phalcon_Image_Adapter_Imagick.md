---
layout: article
language: 'zh-cn'
version: '4.0'
title: 'Phalcon\Image\Adapter\Imagick'
---
# Class **Phalcon\Image\Adapter\Imagick**

*extends* abstract class [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

*implements* [Phalcon\Image\AdapterInterface](Phalcon_Image_AdapterInterface)

[源码在GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/image/adapter/imagick.zep)

Image manipulation support. Allows images to be resized, cropped, etc.

```php
<?php

$image = new \Phalcon\Image\Adapter\Imagick("upload/test.jpg");

$image->resize(200, 200)->rotate(90)->crop(100, 100);

if ($image->save()) {
    echo "success";
}

```

## 方法

public static **check** ()

检查是否启用了 Imagick

public **__construct** (*mixed* $file, [*mixed* $width], [*mixed* $height])

\Phalcon\Image\Adapter\Imagick constructor

protected **_resize** (*mixed* $width, *mixed* $height)

执行调整大小。

protected **_liquidRescale** (*mixed* $width, *mixed* $height, *mixed* $deltaX, *mixed* $rigidity)

This method scales the images using liquid rescaling method. Only support Imagick

protected **_crop** (*mixed* $width, *mixed* $height, *mixed* $offsetX, *mixed* $offsetY)

执行剪裁

protected **_rotate** (*mixed* $degrees)

执行旋转。

protected **_flip** (*mixed* $direction)

执行一个翻转。

protected **_sharpen** (*mixed* $amount)

执行锐化。

protected **_reflection** (*mixed* $height, *mixed* $opacity, *mixed* $fadeIn)

执行一种反射。

protected **_watermark** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $image, *mixed* $offsetX, *mixed* $offsetY, *mixed* $opacity)

执行的水印。

protected **_text** (*mixed* $text, *mixed* $offsetX, *mixed* $offsetY, *mixed* $opacity, *mixed* $r, *mixed* $g, *mixed* $b, *mixed* $size, *mixed* $fontfile)

执行文本

protected **_mask** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $image)

将一个图像合成到另一个图像上

protected **_background** (*mixed* $r, *mixed* $g, *mixed* $b, *mixed* $opacity)

执行一个背景。

protected **_blur** (*mixed* $radius)

模糊图像。

protected **_pixelate** (*mixed* $amount)

像素化图像

protected **_save** (*mixed* $file, *mixed* $quality)

执行保存。

protected **_render** (*mixed* $extension, *mixed* $quality)

执行一个渲染。

public **__destruct** ()

销毁加载的图像以释放资源。

public **getInternalImInstance** ()

获取实例

public **setResourceLimit** (*mixed* $type, *mixed* $limit)

设置特定的资源限制以兆字节为单位

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