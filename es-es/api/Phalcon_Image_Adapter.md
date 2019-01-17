---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Image\Adapter'
---
# Abstract class **Phalcon\Image\Adapter**

*implements* [Phalcon\Image\AdapterInterface](Phalcon_Image_AdapterInterface)

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/image/adapter.zep)

Todo adaptador de imagen debe utilizar esta clase

## Métodos

public **getImage** ()

...

public **getRealpath** ()

...

public **getWidth** ()

Obtiene el ancho de la imagen

public **getHeight** ()

Obtiene la altura de la imagen

public **getType** ()

Tipo de imagen. Dependiente del controlador

public **getMime** ()

Obtiene el tipo MIME de la imagen

public **resize** ([*mixed* $width], [*mixed* $height], [*mixed* $master])

Redimensiona el tamaño de la imagen al tamaño indicado

public **liquidRescale** (*mixed* $width, *mixed* $height, [*mixed* $deltaX], [*mixed* $rigidity])

This method scales the images using liquid rescaling method. Only support Imagick

public **crop** (*mixed* $width, *mixed* $height, [*mixed* $offsetX], [*mixed* $offsetY])

Recorta una imagen al tamaño indicado

public **rotate** (*mixed* $degrees)

Rota la imagen en la cantidad indicada en grados

public **flip** (*mixed* $direction)

Voltea la imagen a los largo del eje vertical u horizontal

public **sharpen** (*mixed* $amount)

Ajusta la nitidez de la imagen en la cantidad indicada

public **reflection** (*mixed* $height, [*mixed* $opacity], [*mixed* $fadeIn])

Agrega un reflejo a una imagen

public **watermark** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $watermark, [*mixed* $offsetX], [*mixed* $offsetY], [*mixed* $opacity])

Agrega una marca de agua a una imagen con la opacidad especificada

public **text** (*mixed* $text, [*mixed* $offsetX], [*mixed* $offsetY], [*mixed* $opacity], [*mixed* $color], [*mixed* $size], [*mixed* $fontfile])

Agrega un texto a una imagen con la opacidad especificada

public **mask** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $watermark)

Combina una imagen con otra

public **background** (*mixed* $color, [*mixed* $opacity])

Establece el color de fondo de una imagen

public **blur** (*mixed* $radius)

Desenfoca la imagen

public **pixelate** (*mixed* $amount)

Pixelar una imagen

public **save** ([*mixed* $file], [*mixed* $quality])

Guarda la imagen

public **render** ([*mixed* $ext], [*mixed* $quality])

Renderiza la imagen y devuelve la cadena binaria