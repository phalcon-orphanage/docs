---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Image\Adapter'
---
# Abstract class **Phalcon\Image\Adapter**

*implements* [Phalcon\Image\AdapterInterface](Phalcon_Image_AdapterInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/image/adapter.zep)

Tüm resim bağdaştırıcıları bu sınıfı kullanmalıdır

## Metodlar

public **getImage** ()

...

public **getRealpath** ()

...

public **getWidth** ()

Resim genişliği

public **getHeight** ()

Resim yüksekliği

genel **getType** ()

Resim türü Sürücü bağlı

public **getMime** ()

Resim mime türü

public **resize** ([*mixed* $width], [*mixed* $height], [*mixed* $master])

Görüntüyü verilen boyuta göre yeniden boyutlandır

public **liquidRescale** (*mixed* $width, *mixed* $height, [*mixed* $deltaX], [*mixed* $rigidity])

This method scales the images using liquid rescaling method. Only support Imagick

public **crop** (*mixed* $width, *mixed* $height, [*mixed* $offsetX], [*mixed* $offsetY])

Görüntüyü belirtilen boyuta kırp

public **rotate** (*mixed* $degrees)

Görüntüyü verilen miktarda döndür

public **flip** (*mixed* $direction)

Flip the image along the horizontal or vertical axis

public **sharpen** (*mixed* $amount)

Görüntüyü verilen miktarda keskinleştirir

public **reflection** (*mixed* $height, [*mixed* $opacity], [*mixed* $fadeIn])

Bir resme yansıtma ekleyin

public **watermark** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $watermark, [*mixed* $offsetX], [*mixed* $offsetY], [*mixed* $opacity])

Add a watermark to an image with the specified opacity

public **text** (*mixed* $text, [*mixed* $offsetX], [*mixed* $offsetY], [*mixed* $opacity], [*mixed* $color], [*mixed* $size], [*mixed* $fontfile])

Belirtilen bir opaklıkla görüntüye bir metin ekleyin

public **mask** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $watermark)

Bir görüntüyü başka bir görüntüye birleştir

public **background** (*mixed* $color, [*mixed* $opacity])

Bir resmin arka plan rengini ayarlama

public **blur** (*mixed* $radius)

Resim bulanıklığı

public **pixelate** (*mixed* $amount)

Görüntü pikselleştirme

public **save** ([*mixed* $file], [*mixed* $quality])

Resmi kaydet

public **render** ([*mixed* $ext], [*mixed* $quality])

Görüntüyü oluşturun ve ikili dizgiyi döndürün