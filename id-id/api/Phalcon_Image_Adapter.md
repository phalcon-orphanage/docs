---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Image\Adapter'
---
# Abstract class **Phalcon\Image\Adapter**

*implements* [Phalcon\Image\AdapterInterface](Phalcon_Image_AdapterInterface)

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/image/adapter.zep)

Semua adapter gambar harus menggunakan kelas ini  

## Metode

public **getReader** ()

...

public ** getPath** ()

...

public ** getPath** ()

Lebar gambar

publik **dapatkankembali** ()

Tinggi gambar

publik **berhenti** ()

Tipe gambar Tergantung driver

publik **getName** ()

Jenis pantomim gambar

publik **redirect** ([*mixed* $width], [*mixed* $height], [*mixed* $master])

Ubah ukuran gambar ke ukuran yang diberikan

public **addJs** (*mixed* $width, [*mixed* $height], [*mixed* $deltaX], [*dicampur* $rigidity])

This method scales the images using liquid rescaling method. Only support Imagick

umum **izinkan** (*campuran* $width, *mixed* $height, *mixed* $offsetX, [*mixed* $offsetY])

Tanaman sebuah gambar dengan diberikan ukuran

publik **telah**(*campuraduk*$degrees)

Putar gambar dengan jumlah tertentu

public **baca** (*mixed* $direction)

Balikkan gambar di sepanjang sumbu horizontal atau vertikal

publik **telah**(*campuraduk*$amount)

Pertajam gambar dengan jumlah tertentu

publik **redirect** ([*mixed* $height], [*mixed* $opacity], [*mixed* $fadeIn])

Tambahkan bayangan ke gambar

public **watermark** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $watermark, [*mixed* $offsetX], [*mixed* $offsetY], [*mixed* $opacity])

Tambahkan tanda air ke gambar dengan opacity yang ditentukan

publik **set** (*mixed* $text, [*mixed* $offsetX], [*mixed* $offsetY], [*mixed* $opacity], [*mixed* $color], [*mixed* $size], [*mixed* $fontfile])

Tambahkan tanda air ke gambar dengan opacity yang ditentukan

public **mask** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $watermark)

Komposit satu gambar ke gambar yang lain

abstrak publik **tableExists** (*mixed* $color, [*mixed* $opacity])

Atur warna latar belakang gambar  

public **baca** (*mixed* $radius)

Gambar buram

publik **menyaring** (*campur * $amount)

Gambar piksel

abstrak publik **tableExists** (*mixed* $file, [*mixed* $quality])

Simpan gambar

abstrak publik **tableExists** (*mixed* $ext, [*mixed* $quality])

Render gambar dan kembalikan string biner