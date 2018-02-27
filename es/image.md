<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Improving Performance with Cache</a>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Images

`Phalcon\Image` es el componente que permite manipular archivos de imagen. Pueden realizar múltiples operaciones sobre el mismo objeto de la imagen.

<a name='adapters'></a>

## Adapters

Este componente hace uso de adaptadores para encapsular programas específicos de manipulación de imagen. Son compatibles los siguientes programas de manipulación de imágenes:

| Clase                              | Descripción                                                                           |
| ---------------------------------- | ------------------------------------------------------------------------------------- |
| `Phalcon\Image\Adapter\Gd`      | Requiere la [extensión GD PHP](http://php.net/manual/en/book.image.php)               |
| `Phalcon\Image\Adapter\Imagick` | Requiere la [extensión de PHP ImageMagick](http://php.net/manual/en/book.imagick.php) |

<a name='adapters-custom'></a>

### Implementing your own adapters

The `Phalcon\Image\AdapterInterface` interface must be implemented in order to create your own image adapters or extend the existing ones.

<a name='saving-rendering'></a>

## Guardando y leyendo imágenes

Before we begin with the various features of the image component, it's worth understanding how to save and render these images.

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

// ...

// Overwrite the original image
$image->save();
```

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

// ...

// Save to 'new-image.jpg'
$image->save('new-image.jpg');
```

You can also change the format of the image:

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

// ...

// Save as a PNG file
$image->save('image.png');
```

When saving as a JPEG, you can also specify the quality as the second parameter:

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

// ...

// Save as a JPEG with 80% quality
$image->save('image.jpg', 80);
```

<a name='resizing'></a>

## Redimensionando imágenes

There are several modes of resizing:

* `\Phalcon\Image::WIDTH`
* `\Phalcon\Image::HEIGHT`
* `\Phalcon\Image::NONE`
* `\Phalcon\Image::TENSILE`
* `\Phalcon\Image::AUTO`
* `\Phalcon\Image::INVERSE`
* `\Phalcon\Image::PRECISE`

<a name='resizing-width'></a>

### `\Phalcon\Image::WIDTH`

The height will automatically be generated to keep the proportions the same; if you specify a height, it will be ignored.

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

The width will automatically be generated to keep the proportions the same; if you specify a width, it will be ignored.

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

For example, to get a 100px by 100px square from the centre of the image:

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

// Rotate an image by 90 degrees clockwise
$image->rotate(90);

$image->save('rotated-image.jpg');
```

<a name='flipping'></a>

## Volteando imágenes

You can flip an image horizontally (using the `\Phalcon\Image::HORIZONTAL` constant) and vertically (using the `\Phalcon\Image::VERTICAL` constant):

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

// Flip an image horizontally
$image->flip(
    \Phalcon\Image::HORIZONTAL
);

$image->save('flipped-image.jpg');
```

<a name='sharpening'></a>

## Afilado de imágenes

The `sharpen()` method takes a single parameter - an integer between 0 (no effect) and 100 (very sharp):

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

// Put the watermark in the top left corner
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

Of course, you can also manipulate the watermarked image before applying it to the main image:

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

$watermark = new \Phalcon\Image\Adapter\Gd('me.jpg');

$watermark->resize(100, 100);
$watermark->rotate(90);
$watermark->sharpen(5);

// Put the watermark in the bottom right corner with a 10px margin
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

The `blur()` method takes a single parameter - an integer between 0 (no effect) and 100 (very blurry):

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

$image->blur(50);

$image->save('blurred-image.jpg');
```

<a name='pixelating'></a>

## Pixelando imágenes

The `pixelate()` method takes a single parameter - the higher the integer, the more pixelated the image becomes:

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

$image->pixelate(10);

$image->save('pixelated-image.jpg');
```