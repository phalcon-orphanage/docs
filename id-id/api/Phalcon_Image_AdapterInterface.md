---
layout: article
language: 'id-id'
version: '4.0'
title: 'Phalcon\Image\AdapterInterface'
---
# Interface **Phalcon\Image\AdapterInterface**

[Sumber di GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/image/adapterinterface.zep)

## Metode

abstrak publik ** ubah ukuran ** ([ * campuran * $ width ], [ * campuran * $ height ], [ * mixed * $ master ])

...

public abstract ** tanaman </ 0> ( * dicampur </ 1> $ lebar , * dicampur </ 1> $ tinggi , [ * dicampur </ 1> $ offsetx ], [ * dicampur </ 1> $ offsetY ])</p> 

...

publik abstrak ** putar </ 0> ( * dicampur </ 1> $ derajat )</p> 

...

publik abstrak ** flip </ 0> ( * dicampur </ 1> $ direction )</p> 

...

publik abstrak ** mempertajam </ 0> ( * campuran </ 1> $ amount )</p> 

...

abstrak publik ** pantulan </ 0> ( * campuran </ 1> $ height , [ * campuran </ 1> $ kegelapan ], [ * campuran </ 1> $ fadeIn ])</p> 

...

abstract public **watermark** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $watermark, [*mixed* $offsetX], [*mixed* $offsetY], [*mixed* $opacity])

...

teks abstrak ** teks </ 0> ( * campuran </ 1> $ teks , [ * campuran </ 1> $ offsetX ], [ * campuran </ 1> $ offsetY ], [ < 1> 1> campuran </ 1> $ kegelapan ], [ * campuran </ 1> $ warna ], [ * campuran </ 1> $ ukuran ], [ * campuran </ 1> $ fontfile ])</p> 

...

abstract public **mask** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $watermark)

...

abstrak publik ** latar belakang </ 0> ( * campuran </ 1> $ warna , [ * campuran </ 1> $ kegelapan ])</p> 

...

publik abstrak ** blur </ 0> ( * campuran </ 1> $ radius )</p> 

...

publik abstrak ** pixelate </ 0> ( * campuran </ 1> $ amount )</p> 

...

abstrak publik ** simpan </ 0> ([ * campuran </ 1> $ file ], [ * campuran </ 1> $ quality ])</p> 

...

abstrak publik ** buat </ 0> ([ * campuran </ 1> $ ext ], [ * campuran </ 1> $ quality ])</p> 

...