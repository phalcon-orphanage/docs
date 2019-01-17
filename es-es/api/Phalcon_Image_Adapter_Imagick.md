---
layout: article
language: 'en'
version: '4.0'
title: 'Phalcon\Image\Adapter\Imagick'
---
# Class **Phalcon\Image\Adapter\Imagick**

*extends* abstract class [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

*implements* [Phalcon\Image\AdapterInterface](Phalcon_Image_AdapterInterface)

[Source on Github](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/image/adapter/imagick.zep)

Image manipulation support. Allows images to be resized, cropped, etc.

```php
<?php

$image = new \Phalcon\Image\Adapter\Imagick("upload/test.jpg");

$image->resize(200, 200)->rotate(90)->crop(100, 100);

if ($image->save()) {
    echo "success";
}

```

## Métodos

public static **check** ()

Checks if Imagick is enabled

public **__construct** (*mixed* $file, [*mixed* $width], [*mixed* $height])

\Phalcon\Image\Adapter\Imagick constructor

protected **_resize** (*mixed* $width, *mixed* $height)

Execute a resize.

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

Combina una imagen con otra

protected **_background** (*mixed* $r, *mixed* $g, *mixed* $b, *mixed* $opacity)

Execute a background.

protected **_blur** (*mixed* $radius)

Desenfoca la imagen

protected **_pixelate** (*mixed* $amount)

Pixelar una imagen

protected **_save** (*mixed* $file, *mixed* $quality)

Execute a save.

protected **_render** (*mixed* $extension, *mixed* $quality)

Execute a render.

public **__destruct** ()

Destroys the loaded image to free up resources.

public **getInternalImInstance** ()

Get instance

public **setResourceLimit** (*mixed* $type, *mixed* $limit)

Sets the limit for a particular resource in megabytes

public **getImage** () inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

...

public **getRealpath** () inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

...

public **getWidth** () inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Obtiene el ancho de la imagen

public **getHeight** () inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Obtiene la altura de la imagen

public **getType** () inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Tipo de imagen. Dependiente del controlador

public **getMime** () inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Obtiene el tipo MIME de la imagen

public **resize** ([*mixed* $width], [*mixed* $height], [*mixed* $master]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Redimensiona el tamaño de la imagen al tamaño indicado

public **liquidRescale** (*mixed* $width, *mixed* $height, [*mixed* $deltaX], [*mixed* $rigidity]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

This method scales the images using liquid rescaling method. Only support Imagick

public **crop** (*mixed* $width, *mixed* $height, [*mixed* $offsetX], [*mixed* $offsetY]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Recorta una imagen al tamaño indicado

public **rotate** (*mixed* $degrees) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Rota la imagen en la cantidad indicada en grados

public **flip** (*mixed* $direction) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Voltea la imagen a los largo del eje vertical u horizontal

public **sharpen** (*mixed* $amount) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Ajusta la nitidez de la imagen en la cantidad indicada

public **reflection** (*mixed* $height, [*mixed* $opacity], [*mixed* $fadeIn]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Agrega un reflejo a una imagen

public **watermark** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $watermark, [*mixed* $offsetX], [*mixed* $offsetY], [*mixed* $opacity]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Agrega una marca de agua a una imagen con la opacidad especificada

public **text** (*mixed* $text, [*mixed* $offsetX], [*mixed* $offsetY], [*mixed* $opacity], [*mixed* $color], [*mixed* $size], [*mixed* $fontfile]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Agrega un texto a una imagen con la opacidad especificada

public **mask** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $watermark) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Combina una imagen con otra

public **background** (*mixed* $color, [*mixed* $opacity]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Establece el color de fondo de una imagen

public **blur** (*mixed* $radius) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Desenfoca la imagen

public **pixelate** (*mixed* $amount) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Pixelar una imagen

public **save** ([*mixed* $file], [*mixed* $quality]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Guarda la imagen

public **render** ([*mixed* $ext], [*mixed* $quality]) inherited from [Phalcon\Image\Adapter](Phalcon_Image_Adapter)

Renderiza la imagen y devuelve la cadena binaria