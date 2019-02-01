---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Görüntü\Bağdaştırıcı\Imagick'
---
# Class **Phalcon\Image\Adapter\Imagick**

*extends* abstract class [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

*implements* [Phalcon\Image\AdapterInterface](Phalcon_Image_AdapterInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/image/adapter/imagick.zep)

Image manipulation support. Allows images to be resized, cropped, etc.

```php
<?php

$image = new \Phalcon\Image\Adapter\Imagick("upload/test.jpg");

$image->resize(200, 200)->rotate(90)->crop(100, 100);

if ($image->save()) {
    echo "success";
}

```

## Metodlar

public static **check** ()

Imagick etkin olup olmadığını denetler

public **__construct** (*mixed* $file, [*mixed* $width], [*mixed* $height])

\Phalcon\Image\Adapter\Imagick constructor

protected **_resize** (*mixed* $width, *mixed* $height)

Bir yeniden boyutlandırma çalıştır.

protected **_liquidRescale** (*mixed* $width, *mixed* $height, *mixed* $deltaX, *mixed* $rigidity)

This method scales the images using liquid rescaling method. Only support Imagick

protected **_crop** (*mixed* $width, *mixed* $height, *mixed* $offsetX, *mixed* $offsetY)

Execute a crop.

protected **_rotate** (*mixed* $degrees)

Execute a rotation.

protected **_flip** (*mixed* $direction)

Execute a flip.

protected **_sharpen** (*mixed* $amount)

Execute a sharpen.

protected **_reflection** (*mixed* $height, *mixed* $opacity, *mixed* $fadeIn)

Execute a reflection.

protected **_watermark** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $image, *mixed* $offsetX, *mixed* $offsetY, *mixed* $opacity)

Execute a watermarking.

protected **_text** (*mixed* $text, *mixed* $offsetX, *mixed* $offsetY, *mixed* $opacity, *mixed* $r, *mixed* $g, *mixed* $b, *mixed* $size, *mixed* $fontfile)

Execute a text

protected **_mask** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $image)

Bir görüntüyü başka bir görüntüye birleştir

protected **_background** (*mixed* $r, *mixed* $g, *mixed* $b, *mixed* $opacity)

Execute a background.

protected **_blur** (*mixed* $radius)

Resim bulanıklığı

protected **_pixelate** (*mixed* $amount)

Görüntü pikselleştirme

protected **_save** (*mixed* $file, *mixed* $quality)

Execute a save.

protected **_render** (*mixed* $extension, *mixed* $quality)

Execute a render.

public **__destruct** ()

Kaynakları boşaltmak için yüklenen görüntü yok eder.

public **getInternalImInstance** ()

Örneği al

public **setResourceLimit** (*mixed* $type, *mixed* $limit)

Belli bir özkaynağın sınırını megabayt olarak tanımlar

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