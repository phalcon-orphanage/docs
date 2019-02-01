---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Image\Adaptor\Imagick'
---
# Class **Phalcon\Image\Adapter\Imagick**

*extends* abstract class [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

*implements* [Phalcon\Image\AdapterInterface](Phalcon_Image_AdapterInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/image/adapter/imagick.zep)

Image manipulation support. Allows images to be resized, cropped, etc.

```php
<?php

$image =baru\Phalcon\Gambar\Adaptor\Imagick ("upload/test.jpg");
upload
$image->(200, 200)->(90)->tanaman(100, 100);

jika ($image-> save ()) {
    echo "sukses

```

## Metode

publik statis **memeriksa** ()

Memeriksa apakah imagick diaktifkan

publik **__membangun** (*campuran* $file, [*campuran* $width], [*campuran* $height])

\Phalcon\Image\Adapter\Imagick constructor

protected **_resize** (*mixed* $width, *mixed* $height)

Jalankan ukurannya.

terlindung **_Rescale cair** (*campuran* $width, *campuran* $height, *campuran* $deltaX, *campuran* $rigidity)

This method scales the images using liquid rescaling method. Only support Imagick

protected **_crop**(* mixed * $width,*mixed* $height,* mixed* $offsetX,*mixed* $offsetY)

Menjalankan sebuah tanaman.

terlindung **_memutar** (*bercampur* $degrees)

Jalankan rotasi.

terlindung **_flip** (*bercampur* $direction)

Jalankan membalik.

terlindung **_sharpen** (*bercampur* $amount)

Jalankan pertajam.

terlindung **_refleksi** (*bercampur* $height, *bercampur* $opacity, *bercampur* $fadeIn)

Jalankan sebuah refleksi.

protected **_watermark** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $image, *mixed* $offsetX, *mixed* $offsetY, *mixed* $opacity)

Jalankan watermarking.

protected **_text** (*mixed* $text, *mixed* $offsetX, *mixed* $offsetY, *mixed* $opacity, *mixed* $r, *mixed* $g, *mixed* $b, *mixed* $size, *mixed* $fontfile)

Jalankan teks

protected **_mask** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $image)

Komposit satu gambar ke gambar yang lain

terlindung **_latar belakang** (*bercampur* $r, *bercampur* $g, *bercampur* $b, *bercampur* $opacity)

Jalankan latar belakang.

terlindung **_blur** (*bercampur* $radius)

Gambar buram

terlindung **_pixelate** (*berlindung* $amount)

Gambar piksel

terlindung **_menyimpan** (*bercampur* $file, *bercampur* $quality)

Jalankan menyimpan.

terlindung **_memberikan** (*campuran* $extension, *campuran* $quality)

Jalankan memberikan.

publik **__penghancuran** ()

Hancurkan gambar yang dimuat untuk membebaskan sumber daya.

publik **mendapatkan Contoh Internal** ()

Dapatkan contoh

publik **mengatur Batas Sumber Daya** (*campuran* $type, *campuran* $limit)

Menetapkan batas sumber daya tertentu dalam megabyte

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