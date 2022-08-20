---
layout: default
language: 'es-es'
version: '5.0'
title: 'Imagen'
upgrade: '#image'
keywords: 'imagen, gd, imagick'
---

# Imagen
- - -
![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Resumen
El espacio de nombres `Phalcon\Image` expone el adaptador que ofrece la funcionalidad de manipulación de imagen. Estos adaptadores están diseñados para permitir múltiples operaciones a realizar sobre la misma imagen.

## Adaptadores
Este componente usa adaptadores que ofrecen métodos para manipular imágenes. You can easily create your own adapter using the [Phalcon\Image\Adapter\AdapterInterface][image-adapter-adapterinterface].

| Clase                                                     | Descripción                                       |
| --------------------------------------------------------- | ------------------------------------------------- |
| [Phalcon\Image\Adapter\Gd][image-adapter-gd]           | Requires the [GD PHP extension][gd]               |
| [Phalcon\Image\Adapter\Imagick][image-adapter-imagick] | Requires the [ImageMagick PHP extension][imagick] |

## Constantes
[Phalcon\Image\Enum][image-enum] holds constants for image resizing and flipping. Las constantes disponibles son:

**Redimensionar**

- `AUTO`
- `HEIGHT`
- `INVERSE`
- `NONE`
- `PRECISE`
- `TENSILE`
- `WIDTH`

**Dar la vuelta**

- `HORIZONTAL`
- `VERTICAL`

## Supported images (GD)

- IMAGETYPE_GIF
- IMAGETYPE_JPEG
- IMAGETYPE_JPEG2000
- IMAGETYPE_PNG
- IMAGETYPE_WEBP
- IMAGETYPE_WBMP
- IMAGETYPE_XBM

## Getters
Each adapter offers getters to provide information about the component:

| Método                  | Descripción                                       |
| ----------------------- | ------------------------------------------------- |
| `getHeight(): int`      | Returns the image height                          |
| `getImage(): mixed`     | Returns the image                                 |
| `getMime(): string`     | Returns the image mime type                       |
| `getRealpath(): string` | Returns the real path where the image is located  |
| `getType(): int`        | Returns the image type (This is driver dependent) |
| `getWidth(): int`       | Returns the image width                           |

## GD
[Phalcon\Image\Adapters\Gd][image-adapter-gd] utilizes the [GD PHP extension][gd]. Para poder usar este adaptador, debe estar presente la extensión en su sistema. El adaptador ofrece todos los métodos descritos a continuación en la sección de operaciones.

## Imagick
[Phalcon\Image\Adapters\Imagick][image-adapter-imagick] utilizes the [ImageMagick PHP extension][imagick]. Para poder usar este adaptador, debe estar presente la extensión en su sistema. El adaptador ofrece todos los métodos descritos a continuación en la sección de operaciones.

## Operaciones
### `background()`
Establece el color de fondo para la imagen. The available parameters are:
- `color` - `string` - the color in hex format
- `opacity` - `int` - the opacity (optional - default `100`).

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

$image->background('#000033', 70);

$image->save('background-image.jpg');
```

### `blur()`
Desenfoca la imagen. El parámetro entero pasado especifica el radio para la operación de desenfoque. El rango está entre 0 (no efecto) y 100 (muy borroso):

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

$image->blur(50);

$image->save('blur-image.jpg');
```

### `crop()`
Puede recortar imágenes programáticamente. The `crop()` method accepts the following parameters:

| Parámetro      | Descripción             |
| -------------- | ----------------------- |
| `int $width`   | the width               |
| `int $height`  | the height              |
| `int $offsetX` | the X offset (optional) |
| `int $offsetY` | the Y offset (optional) |

El siguiente ejemplo recorta 100px por 100px desde el centro de la imagen:

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

$width   = 100;
$height  = 100;
$offsetX = ($image->getWidth() - $width) / 2;
$offsetY = ($image->getHeight() - $height) / 2;

$image->crop($width, $height, $offsetX, $offsetY);

$image->save('crop-image.jpg');
```

### `flip()`
Puede dar la vuelta a una imagen horizontal o verticalmente. El método `flip()` acepta un entero, que representa la dirección. Puede usar las constantes para esta operación:

- `Phalcon\Image\Enum::HORIZONTAL`
- `Phalcon\Image\Enum::VERTICAL`

```php
<?php

use Phalcon\Image\Adapter\Gd;
use Phalcon\Image\Enum;

$image = new Gd('image.jpg');

$image->flip(Enum::HORIZONTAL);

$image->save('flip-image.jpg');
```

### `liquidRescale()`
This method is only available in the [Phalcon\Image\Imagick][image-adapter-imagick] adapter. It uses the [liquid][imagick-liquidrescale] rescaling method to rescale the image. The method accepts the following parameters:

| Parámetro       | Descripción                                                                                                        |
| --------------- | ------------------------------------------------------------------------------------------------------------------ |
| `int $width`    | the new width                                                                                                      |
| `int $height`   | the new height                                                                                                     |
| `int $deltaX`   | How much the seam can traverse on x-axis. Pasando `0` causa que las costuras sean rectas. (optional - default `0`) |
| `int $rigidity` | Introduces a bias for non-straight seams. (optional - default `0`)                                                 |

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

$image->liquidRescale(500, 200, 3, 25);

$image->save('liquidrescale-image.jpg');
```

### `mask()`
Crea una imagen compuesta a partir de dos imágenes. Acepta la primera imagen como parámetro.

```php
<?php

use Phalcon\Image\Adapter\Gd;

$front = new Gd('front.jpg');
$back  = new Gd('back.jpg');

$front->mask($front);

$front->save('mask-image.jpg');
```

### `pixelate()`
Añade pixelación a la imagen. El método acepta un único parámetro entero. Cuanto mayor sea el número, más pixelada se vuelve la imagen:

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

$image->pixelate(10);

$image->save('pixelate-image.jpg');
```

### `reflection()`
Añade reflejo a la imagen. The method accepts the following parameters:

| Parámetro      | Descripción                                            |
| -------------- | ------------------------------------------------------ |
| `int $height`  | the height                                             |
| `int $opacity` | the opacity (optional - default `100`)                 |
| `bool $fadeIn` | whether to fade in or not (optional - default `false`) |

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

$image->reflection(100, 75, true);

$image->save('reflection-image.jpg');
```

### `render()`
Renderiza la imagen y la devuelve como una cadena binaria. The method accepts the following parameters:

| Método         | Descripción                                         |
| -------------- | --------------------------------------------------- |
| `string $ext`  | the extension (optional)                            |
| `int $quality` | the quality of the image (optional - default `100`) |

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

// ....

echo $image->render('jpg', 90);
```

### `resize()`
Redimensiona la imagen basada en los parámetros pasados. The method accepts the following parameters:

| Parámetro     | Descripción                                              |
| ------------- | -------------------------------------------------------- |
| `int $width`  | the width (optional)                                     |
| `int $height` | the height (optional)                                    |
| `int $master` | constant signifying the resizing method (default `AUTO`) |

**Constantes**
- `Phalcon\Image\Enum::AUTO`
- `Phalcon\Image\Enum::HEIGHT`
- `Phalcon\Image\Enum::INVERSE`
- `Phalcon\Image\Enum::NONE`
- `Phalcon\Image\Enum::PRECISE`
- `Phalcon\Image\Enum::TENSILE`
- `Phalcon\Image\Enum::WIDTH`

If any of the parameters are not correct, a [Phalcon\Image\Exception][image-exception] will be thrown.

**HEIGHT**

La anchura se generará automáticamente para mantener las mismas proporciones; si especifica un anchura, será ignorada.

```php
<?php

use Phalcon\Image\Adapter\Gd;
use Phalcon\Image\Enum;

$image = new Gd('image.jpg');

$image->resize(null, 300, Enum::HEIGHT);

$image->save('resize-height-image.jpg');
```

**INVERSE**

Redimensiona e invierte la anchura y altura pasadas

```php
<?php

use Phalcon\Image\Adapter\Gd;
use Phalcon\Image\Enum;

$image = new Gd('image.jpg');

$image->resize(400, 200, Enum::INVERSE);

$image->save('resize-inverse-image.jpg');
```

**NONE**

- La constante `NONE` ignora el ratio original de la imagen.
- Ni la anchura ni la altura son necesarias.
- Si no se especifica una dimensión, se usará la dimensión original.
- Si las nuevas proporciones difieren de las proporciones originales, la imagen se puede distorsionar y estirar.

```php
<?php

use Phalcon\Image\Adapter\Gd;
use Phalcon\Image\Enum;

$image = new Gd('image.jpg');

$image->resize(400, 200, Enum::NONE);

$image->save('resize-none-image.jpg');
```

**TENSILE**

- Similar a la constante `NONE`, la constante `TENSILE` ignora el ratio de la imagen original.
- Se requiere tanto anchura como altura.
- Si las nuevas proporciones difieren de las proporciones originales, la imagen se puede distorsionar y estirar.

```php
<?php

use Phalcon\Image\Adapter\Gd;
use Phalcon\Image\Enum;

$image = new Gd('image.jpg');

$image->resize(400, 200, Enum::TENSILE);

$image->save('resize-tensile-image.jpg');
```

**WIDTH**

La altura se generará automáticamente para mantener las mismas proporciones; si especifica una altura, se ignorará.

```php
<?php

use Phalcon\Image\Adapter\Gd;
use Phalcon\Image\Enum;

$image = new Gd('image.jpg');

$image->resize(300, null, Enum::WIDTH);

$image->save('resize-width-image.jpg');
```

### `rotate()`
Rota una imagen basándose en los grados dados. Positive numbers rotate the image clockwise while negative counterclockwise.

El ejemplo siguiente rota una imagen 90 grados en el sentido de las agujas del reloj

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

$image->rotate(90);

$image->save('rotate-image.jpg');
```

### `save()`
Después de manipular su imagen, probablemente querrá guardarla. Si sólo desea obtener de vuelta el resultado de la manipulación como una cadena, puede usar el método `render()`.

The `save()` method accepts the filename and quality as parameters:

| Propiedad      | Descripción                                        |
| -------------- | -------------------------------------------------- |
| `string $file` | the target file name (optional)                    |
| `int $quality` | the quality of the image (optional - default `-1`) |

Si no se especifica un nombre de fichero, la imagen manipulada sobreescribirá la imagen original.

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

$image->rotate(90);

$image->save();
```

Al especificar un nombre de fichero, la imagen manipulada se guardará con ese nombre, dejando la imagen original intacta.

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

$image->rotate(90);

$image->save('rotate-image.jpg');
```

También puede cambiar el formato de la imagen usando una extensión distinta. Esta funcionalidad depende del adaptador con el que esté trabajando.

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

$image->rotate(90);

$image->save('rotate-image.png');
```

Cuando guarda como JPEG, también puede especificar la calidad como segundo parámetro:

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

$image->rotate(90);

$image->save('rotate-image.jpg', 90);
```

### `sharpen()`
Ajusta la nitidez de la imagen. El parámetro entero pasado especifica la cantidad para la operación de afinado. El rango está entre 0 (sin efecto) y 100 (muy nítido):

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

$image->sharpen(50);

$image->save('sharpen-image.jpg');
```

### `text()`
Puede añadir texto a su imagen llamando a `text()`. The available parameters are:

| Propiedad                     | Descripción                                                 |
| ----------------------------- | ----------------------------------------------------------- |
| `string $text`                | the text                                                    |
| `int&vert;false $offsetX` | the X offset, `false` to disable                            |
| `int&vert;false $offsetY` | the Y offset, `false` to disable                            |
| `int $opacity`                | the opacity of the text (optional - default `100`)          |
| `string $color`               | the color for the text (optional - default `"000000"`)      |
| `int $size`                   | the size of the font for the text (optional - default `12`) |
| `string $fontfile`            | the font file to be used for the text (optional)            |

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

$image->text(
    'Phalcon Framework',
    10,
    10,
    75,
    '000033',
    14,
    '/app/assets/fonts/titilium.tff'
);

$image->save('text-image.jpg');
```

### `watermark()`
Añade una marca de agua a una imagen. The available parameters are:

| Propiedad                     | Descripción                                         |
| ----------------------------- | --------------------------------------------------- |
| `AdapterInterface $watermark` | the image to use for the watermark                  |
| `int $offsetX`                | the X offset (optional)                             |
| `int $offsetY`                | the Y offset (optional)                             |
| `int $opacity`                | the opacity of the image (optional - default `100`) |

The following example puts the watermark in the top left corner of the image:

```php
<?php

use Phalcon\Image\Adapter\Gd;

$watermark = new Gd('watermark.jpg');
$image     = new Gd('image.jpg');

$offsetX = 10;
$offsetY = 10;
$opacity = 70;

$image->watermark(
    $watermark,
    $offsetX,
    $offsetY,
    $opacity
);

$image->save('watermark-image.jpg');
```

También puede manipular la imagen de marca de agua antes de aplicarla a la imagen principal. In the following example we resize, rotate and sharpen the watermark and put it in the bottom right corner with a 10px margin:

```php
<?php

use Phalcon\Image\Adapter\Gd;

$watermark = new Gd('watermark.jpg');
$image     = new Gd('image.jpg');

$watermark->resize(100, 100);
$watermark->rotate(90);
$watermark->sharpen(5);

$offsetX = ($image->getWidth() - $watermark->getWidth() - 10);
$offsetY = ($image->getHeight() - $watermark->getHeight() - 10);

$opacity = 70;

$image->watermark(
    $watermark,
    $offsetX,
    $offsetY,
    $opacity
);

$image->save('watermark-image.jpg');
```

## Fábrica (Factory)
### `newInstance`

The [Phalcon\Image\ImageFactory][image-imagefactory] offers an easy way to create image adapter objects. Ya hay dos adaptadores preestablecidos para usted:

- `gd`- [Phalcon\Image\Adapter\Gd][image-adapter-gd]
- `imagick` - [Phalcon\Image\Adapter\Imagick][image-adapter-imagick]

Llamar `newInstance()` con la clave relevante así como parámetros devolverá el adaptador relevante. The factory always returns a new instance of [Phalcon\Image\Adapter\AdapterInterface][image-adapter-adapterinterface].

```php
<?php

use Phalcon\Image\ImageFactory;

$factory = new ImageFactory();

$image = $factory->newInstance('gd', 'image.jpg');
```

The available parameters for `newInstance()` are:

| Propiedad      | Descripción                        |
| -------------- | ---------------------------------- |
| `string $name` | the name of the adapter            |
| `string $file` | the file name                      |
| `int $width`   | the width of the image (optional)  |
| `int $height`  | the height of the image (optional) |

### `load`
La Fábrica de Imágenes también ofrece el método `load`, que acepta un objeto de configuración. Este objeto puede ser un vector o un objeto [Phalcon\Config](config), con las directivas a usar para configurar el adaptador de imagen. El objeto requiere el elemento `adapter`, así como el elemento `file`. `width` y `height` también se pueden configurar como opciones.

```php
<?php

use Phalcon\Image\ImageFactory;

$factory = new ImageFactory();
$options = [
    'adapter' => 'gd',
    'file'    => 'image.jpg',
    'width'   => 400,
    'height'  => 200,
];

$image = $factory->load($options);
```

## Excepciones
Any exceptions thrown in the Image components will be of type [Phalcon\Image\Exception][image-exception]. Puede usar esta excepción para capturar selectivamente sólo las excepciones lanzadas desde este componente.

```php
<?php

use Phalcon\Image\Adapter\Gd;
use Phalcon\Image\Exception;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function index()
    {
        try {
            $image = new Gd('image.jpg');
            $image->pixelate(10);

            $image->save('pixelated-image.jpg');
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}
```

## Personalizado
The [Phalcon\Image\Adapter\AdapterInterface][image-adapter-adapterinterface] interface must be implemented in order to create your own image adapters or extend the existing ones. You can then easily add it to the [Phalcon\Image\ImageFactory][image-imagefactory].

```php
<?php

use Phalcon\Image\Adapter\AdapterInterface;
use Phalcon\Image\Enum;

class MyImageAdapter implements AdapterInterface
{
    /**
     * Manipulate the background
     */
    public function background(
        string $color, 
        int $opacity = 100
    );

    /**
     * Blur the image
     */
    public function blur(int $radius);

    /**
     * Crop the image
     */
    public function crop(
        int $width, 
        int $height, 
        int $offsetX = null, 
        int $offsetY = null
    );

    /**
     * Flip the image
     */
    public function flip(int $direction);

    /**
     * Add a mask to the image
     */
    public function mask(AdapterInterface $watermark);

    /**
     * Pixelate the image
     */
    public function pixelate(int $amount);

    /**
     * Add a reflection to the image
     */
    public function reflection(
        int $height, 
        int $opacity = 100, 
        bool $fadeIn = false
    );

    /**
     * Render the image
     */
    public function render(
        string $ext = null, 
        int $quality = 100
    );

    /**
     * Resize the image
     */
    public function resize(
        int $width = null, 
        int $height = null, 
        int $master = Enum::AUTO
    );

    /**
     * Rotate the image
     */
    public function rotate(int degrees);

    /**
     * Save the image
     */
    public function save(string $file = null, int $quality = 100);

    /**
     * Sharpen the image
     */
    public function sharpen(int $amount);

    /**
     * Add text to the image
     */
    public function text(
        string $text, 
        int $offsetX = 0, 
        int $offsetY = 0, 
        int $opacity = 100, 
        string $color = "000000", 
        int $size = 12, 
        string $fontfile = null
    );

    /**
     * Add a watermark to the image
     */
    public function watermark(
        AdapterInterface $watermark, 
        int $offsetX = 0, 
        int $offsetY = 0, 
        int $opacity = 100
    );
}
```


[gd]: https://php.net/manual/en/book.image.php
[imagick]: https://php.net/manual/en/book.imagick.php
[image-adapter-adapterinterface]: api/phalcon_image#image-adapter-adapterinterface
[image-adapter-gd]: api/phalcon_image#image-adapter-gd
[image-adapter-gd]: api/phalcon_image#image-adapter-gd
[image-adapter-imagick]: api/phalcon_image#image-adapter-imagick
[image-adapter-imagick]: api/phalcon_image#image-adapter-imagick
[image-adapter-imagick]: api/phalcon_image#image-adapter-imagick
[image-enum]: api/phalcon_image#image-enum
[image-exception]: api/phalcon_image#image-exception
[image-imagefactory]: api/phalcon_image#image-imagefactory
[imagick-liquidrescale]: https://www.php.net/manual/en/imagick.liquidrescaleimage.php 
