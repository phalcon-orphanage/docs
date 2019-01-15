* * *

layout: article language: 'en' version: '4.0'

* * *

<h5 class="alert alert-warning">This article reflects v3.4 and has not yet been revised</h5>

<a name='overview'></a>

# Images

[Phalcon\Image](api/Phalcon_Image) is the component that allows you to manipulate image files. Multiple operations can be performed on the same image object.

<a name='adapters'></a>

## Adapters

Este componente hace uso de adaptadores para encapsular programas específicos de manipulación de imagen. Son compatibles los siguientes programas de manipulación de imágenes:

| Clase                                                                 | Descripción                                                                          |
| --------------------------------------------------------------------- | ------------------------------------------------------------------------------------ |
| [Phalcon\Image\Adapter\Gd](api/Phalcon_Image_Adapter_Gd)           | Requires the [GD PHP extension](https://php.net/manual/en/book.image.php)            |
| [Phalcon\Image\Adapter\Imagick](api/Phalcon_Image_Adapter_Imagick) | Requires the [ImageMagick PHP extension](https://php.net/manual/en/book.imagick.php) |

<a name='adapters-factory'></a>

### Factory

Carga una clase de adaptador de imagen utilizando la opción de `adapter`.

```php
<?php

use Phalcon\Image\Factory;

$options = [
    'width'   => 200,
    'height'  => 200,
    'file'    => 'upload/test.jpg',
    'adapter' => 'imagick',
];

$image = Factory::load($options);
```

<a name='adapters-custom'></a>

### Implementando sus propios adaptadores

The [Phalcon\Image\AdapterInterface](api/Phalcon_Image_AdapterInterface) interface must be implemented in order to create your own image adapters or extend the existing ones.

<a name='saving-rendering'></a>

## Guardando y leyendo imágenes

Antes de comenzar con las distintas características de los componentes de la imagen, vale la pena entender cómo guardar y representar estas imágenes.

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

// ...

// Sobreescribir la imagen original
$image->save();
```

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

// ...

// Guardar como 'new-image.jpg'
$image->save('new-image.jpg');
```

También puede cambiar el formato de la imagen:

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

// ...

// Guardar como un archivo PNG
$image->save('image.png');
```

Cuando se guarda como un archivo JPEG, puede especificar la calidad como segundo parámetro:

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

// ...

// Guardar como JPEG con calidad al 80%
$image->save('image.jpg', 80);
```

<a name='resizing'></a>

## Redimensionando imágenes

Hay varios modos de redimensionamiento:

* `\Phalcon\Image::WIDTH`
* `\Phalcon\Image::HEIGHT`
* `\Phalcon\Image::NONE`
* `\Phalcon\Image::TENSILE`
* `\Phalcon\Image::AUTO`
* `\Phalcon\Image::INVERSE`
* `\Phalcon\Image::PRECISE`

<a name='resizing-width'></a>

### `\Phalcon\Image::WIDTH`

Automáticamente se generará la altura para mantener las proporciones del mismo; Si se especifica una altura, se ignorará.

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

$image->resize(
    300,
    null,
    \Phalcon\Image::WIDTH
);

$image->save('resized-image.jpg');
```

<a name='resizing-height'></a>

### `\Phalcon\Image::HEIGHT`

Se generará automáticamente el ancho para mantener las proporciones del mismo; Si se especifica un ancho, se ignorará.

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

$image->resize(
    null,
    300,
    \Phalcon\Image::HEIGHT
);

$image->save('resized-image.jpg');
```

<a name='resizing-none'></a>

### `\Phalcon\Image::NONE`

* La constante `NONE` ignora la relación de la imagen original.
* Ni el ancho ni la altura son requeridos.
* Si una dimensión no se especifica, se utilizará la dimensión original.
* Si las nuevas proporciones difieren de las proporciones originales, la imagen puede distorsionarse y estirarse.

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

$image->resize(
    400,
    200,
    \Phalcon\Image::NONE
);

$image->save('resized-image.jpg');
```

<a name='resizing-tensile'></a>

### `\Phalcon\Image::TENSILE`

* Similar a la constante de `NONE`, la constante `TENSILE` ignora la relación de la imagen original.
* Anchura y altura son necesarios.
* Si las nuevas proporciones difieren de las proporciones originales, la imagen puede distorsionarse y estirarse.

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

$image->resize(
    400,
    200,
    \Phalcon\Image::TENSILE
);

$image->save('resized-image.jpg');
```

<a name='cropping'></a>

## Recortar imágenes

Por ejemplo, para obtener un cuadrado de 100x100 pixels del centro de la imagen:

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

$width   = 100;
$height  = 100;
$offsetX = (($image->getWidth() - $width) / 2);
$offsetY = (($image->getHeight() - $height) / 2);

$image->crop($width, $height, $offsetX, $offsetY);

$image->save('cropped-image.jpg');
```

<a name='rotating'></a>

## Rotación de imágenes

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

// Rotar una imagen 90º en sentido de las agujas del reloj
$image->rotate(90);

$image->save('rotated-image.jpg');
```

<a name='flipping'></a>

## Volteando imágenes

Puede voltear una imagen horizontalmente (utilizando la constante de `\Phalcon\Image::HORIZONTAL`) y verticalmente (con la constante `\Phalcon\Image::VERTICAL`):

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

// Voltear imagen horizontalmente
$image->flip(
    \Phalcon\Image::HORIZONTAL
);

$image->save('flipped-image.jpg');
```

<a name='sharpening'></a>

## Afilado de imágenes

El método `sharpen()` toma un solo parámetro, un número entero entre 0 (ningún efecto) y 100 (muy agudo):

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

$image->sharpen(50);

$image->save('sharpened-image.jpg');
```

<a name='watermarks'></a>

## Agregar marcas de agua a imágenes

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

$watermark = new \Phalcon\Image\Adapter\Gd('me.jpg');

// Poner la marca de agua en la esquina superior izquierda
$offsetX = 10;
$offsetY = 10;

$opacity = 70;

$image->watermark(
    $watermark,
    $offsetX,
    $offsetY,
    $opacity
);

$image->save('watermarked-image.jpg');
```

Por supuesto, también puede manipular la imagen de marca de agua antes de aplicarla a la imagen principal:

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

$watermark = new \Phalcon\Image\Adapter\Gd('me.jpg');

$watermark->resize(100, 100);
$watermark->rotate(90);
$watermark->sharpen(5);

// Poner marca de agua en la esquina inferior derecha con 10px de margen
$offsetX = ($image->getWidth() - $watermark->getWidth() - 10);
$offsetY = ($image->getHeight() - $watermark->getHeight() - 10);

$opacity = 70;

$image->watermark(
    $watermark,
    $offsetX,
    $offsetY,
    $opacity
);

$image->save('watermarked-image.jpg');
```

<a name='blurring'></a>

## Imágenes borrosas

El método `blur()` toma un solo parámetro, un número entero entre 0 (ningún efecto) y 100 (muy borrosa):

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

$image->blur(50);

$image->save('blurred-image.jpg');
```

<a name='pixelating'></a>

## Pixelando imágenes

El método `pixelate()` toma un solo parámetro, cuanto mayor sea el número entero, el más pixelada la imagen que se convierte:

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

$image->pixelate(10);

$image->save('pixelated-image.jpg');
```