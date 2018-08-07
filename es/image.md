<div class="article-menu">
    <ul>
        <li>
            <a href="#overview">Imágenes</a>
            <ul>
                <li>
                    <a href="#adapters">Adaptadores</a>
                    <ul>
                        <li>
                            <a href="#adapters-factory">Factory</a>
                        </li>
                        <li>
                            <a href="#adapters-custom">Implementar tus propios adaptadores</a>
                        </li>
                    </ul>
                </li>
                <li><a href="#saving-rendering">Guardando y leyendo imágenes</a>
                </li>
                <li><a href="#resizing">Redimensionando imágenes</a>
                    <ul>
                        <li><a href="#resizing-width"><code>\Phalcon\Image::WIDTH</code></a>
                        </li>
                        <li><a href="#resizing-height"><code>\Phalcon\Image::HEIGHT</code></a>
                        </li>
                        <li>
                            <a href="#resizing-none"><code>\Phalcon\Image::NONE</code></a>
                        </li>
                        <li><a href="#resizing-tensile"><code>\Phalcon\Image::TENSILE</code></a>
                        </li>
                    </ul>
                </li>
                <li><a href="#cropping">Recortar imágenes</a></li>
                <li><a href="#rotating">Rotación de imágenes</a></li>
                <li><a href="#flipping">Volteando imágenes</a></li>
                <li><a href="#sharpening">Afilado de imágenes</a></li>
                <li><a href="#watermarks">Agregar marcas de agua a imágenes</a></li>
                <li><a href="#blurring">Imágenes borrosas</a></li>
                <li><a href="#pixelating">Pixelando imágenes</a></li>
            </ul>
        </li>
    </ul>
</div>

<a name='overview'></a>

# Imágenes

`Phalcon\Image` es el componente que permite manipular archivos de imagen. Se pueden realizar múltiples operaciones sobre el mismo objeto de imagen.

<a name='adapters'></a>

## Adaptadores

Este componente hace uso de adaptadores para encapsular programas específicos de manipulación de imágenes. Son compatibles con los siguientes programas de manipulador de imágenes:

| Clase                              | Descripción                                                                           |
| ---------------------------------- | ------------------------------------------------------------------------------------- |
| `Phalcon\Image\Adapter\Gd`      | Requiere la [extensión GD PHP](http://php.net/manual/en/book.image.php)               |
| `Phalcon\Image\Adapter\Imagick` | Requiere la [extensión de PHP ImageMagick](http://php.net/manual/en/book.imagick.php) |

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

### Implementar tus propios adaptadores

Debe implementar la interfaz `Phalcon\Image\AdapterInterface` para crear sus propios adaptadores imagen o extender los ya existentes.

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

// Guardar como archivo PNG
$image->save('image.png');
```

Cuando se guarda como un archivo JPEG, puede especificar la calidad como segundo parámetro:

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

// ...

// Guardar como JPEG en 80% de calidad
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