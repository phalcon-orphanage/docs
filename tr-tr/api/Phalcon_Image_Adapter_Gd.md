---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Görüntü\Bağdaştırıcı\Gd'
---
# Class **Phalcon\Image\Adapter\Gd**

*extends* abstract class [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

*implements* [Phalcon\Image\AdapterInterface](Phalcon_Image_AdapterInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/image/adapter/gd.zep)

## Metodlar

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

Resim genişliği

public **getHeight** () inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Resim yüksekliği

public **getType** () inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Resim türü Sürücü bağlı

public **getMime** () inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Resim mime türü

public **resize** ([*mixed* $width], [*mixed* $height], [*mixed* $master]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Görüntüyü verilen boyuta göre yeniden boyutlandır

public **liquidRescale** (*mixed* $width, *mixed* $height, [*mixed* $deltaX], [*mixed* $rigidity]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

This method scales the images using liquid rescaling method. Only support Imagick

public **crop** (*mixed* $width, *mixed* $height, [*mixed* $offsetX], [*mixed* $offsetY]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Görüntüyü belirtilen boyuta kırp

public **rotate** (*mixed* $degrees) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Görüntüyü verilen miktarda döndür

public **flip** (*mixed* $direction) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Flip the image along the horizontal or vertical axis

public **sharpen** (*mixed* $amount) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Görüntüyü verilen miktarda keskinleştirir

public **reflection** (*mixed* $height, [*mixed* $opacity], [*mixed* $fadeIn]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Bir resme yansıtma ekleyin

public **watermark** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $watermark, [*mixed* $offsetX], [*mixed* $offsetY], [*mixed* $opacity]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Add a watermark to an image with the specified opacity

public **text** (*mixed* $text, [*mixed* $offsetX], [*mixed* $offsetY], [*mixed* $opacity], [*mixed* $color], [*mixed* $size], [*mixed* $fontfile]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Belirtilen bir opaklıkla görüntüye bir metin ekleyin

public **mask** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $watermark) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Bir görüntüyü başka bir görüntüye birleştir

public **background** (*mixed* $color, [*mixed* $opacity]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Bir resmin arka plan rengini ayarlama

public **blur** (*mixed* $radius) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Resim bulanıklığı

public **pixelate** (*mixed* $amount) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Görüntü pikselleştirme

public **save** ([*mixed* $file], [*mixed* $quality]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Resmi kaydet

public **render** ([*mixed* $ext], [*mixed* $quality]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Görüntüyü oluşturun ve ikili dizgiyi döndürün