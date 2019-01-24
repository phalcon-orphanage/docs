---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Image\Adapter\Gd'
---
# Class **Phalcon\Image\Adapter\Gd**

*extends* abstract class [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

*implements* [Phalcon\Image\AdapterInterface](Phalcon_Image_AdapterInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/image/adapter/gd.zep)

## Metode

publik statis **memeriksa** ()

...

publik **__membangun** (*campuran* $file, [*campuran* $width], [*campuran* $height])

...

protected **_resize** (*mixed* $width, *mixed* $height)

...

protected **_crop**(* mixed * $width,*mixed* $height,* mixed* $offsetX,*mixed* $offsetY)

...

terlindung **_memutar** (*bercampur* $degrees)

...

terlindung **_flip** (*bercampur* $direction)

...

terlindung **_sharpen** (*bercampur* $amount)

...

terlindung **_refleksi** (*bercampur* $height, *bercampur* $opacity, *bercampur* $fadeIn)

...

protected **_watermark** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $watermark, *mixed* $offsetX, *mixed* $offsetY, *mixed* $opacity)

...

protected **_text** (*mixed* $text, *mixed* $offsetX, *mixed* $offsetY, *mixed* $opacity, *mixed* $r, *mixed* $g, *mixed* $b, *mixed* $size, *mixed* $fontfile)

...

protected **_mask** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $mask)

...

terlindung **_latar belakang** (*bercampur* $r, *bercampur* $g, *bercampur* $b, *bercampur* $opacity)

...

terlindung **_blur** (*bercampur* $radius)

...

terlindung **_pixelate** (*berlindung* $amount)

...

terlindung **_menyimpan** (*bercampur* $file, *bercampur* $quality)

...

terlindung **_render** (*bercampur* $ext, *bercampur* $quality)

...

protected **_create** (*mixed* $width, *mixed* $height)

...

publik **__penghancuran** ()

...

public **getImage** () inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

...

public **getRealpath** () inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

...

public **getWidth** () inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Lebar gambar

public **getHeight** () inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Tinggi gambar

public **getType** () inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Tipe gambar Tergantung driver

public **getMime** () inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Jenis pantomim gambar

public **resize** ([*mixed* $width], [*mixed* $height], [*mixed* $master]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Ubah ukuran gambar ke ukuran yang diberikan

public **liquidRescale** (*mixed* $width, *mixed* $height, [*mixed* $deltaX], [*mixed* $rigidity]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

This method scales the images using liquid rescaling method. Only support Imagick

public **crop** (*mixed* $width, *mixed* $height, [*mixed* $offsetX], [*mixed* $offsetY]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Tanaman sebuah gambar dengan diberikan ukuran

public **rotate** (*mixed* $degrees) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Putar gambar dengan jumlah tertentu

public **flip** (*mixed* $direction) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Balikkan gambar di sepanjang sumbu horizontal atau vertikal

public **sharpen** (*mixed* $amount) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Pertajam gambar dengan jumlah tertentu

public **reflection** (*mixed* $height, [*mixed* $opacity], [*mixed* $fadeIn]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Tambahkan bayangan ke gambar

public **watermark** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $watermark, [*mixed* $offsetX], [*mixed* $offsetY], [*mixed* $opacity]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Tambahkan tanda air ke gambar dengan opacity yang ditentukan

public **text** (*mixed* $text, [*mixed* $offsetX], [*mixed* $offsetY], [*mixed* $opacity], [*mixed* $color], [*mixed* $size], [*mixed* $fontfile]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Tambahkan tanda air ke gambar dengan opacity yang ditentukan

public **mask** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $watermark) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Komposit satu gambar ke gambar yang lain

public **background** (*mixed* $color, [*mixed* $opacity]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Atur warna latar belakang gambar  

public **blur** (*mixed* $radius) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Gambar buram

public **pixelate** (*mixed* $amount) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Gambar piksel

public **save** ([*mixed* $file], [*mixed* $quality]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Simpan gambar

public **render** ([*mixed* $ext], [*mixed* $quality]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Render gambar dan kembalikan string biner