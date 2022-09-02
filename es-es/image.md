---
layout: default
language: 'es-es'
version: '4.0'
title: 'Imagen'
keywords: 'imagen, gd, imagick'
---

# Imagen

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ pageVersion }}.svg)

## Resumen

El espacio de nombres `Phalcon\Image` expone el adaptador que ofrece la funcionalidad de manipulación de imagen. Estos adaptadores están diseñados para permitir múltiples operaciones a realizar sobre la misma imagen.

## Adaptadores

Este componente usa adaptadores que ofrecen métodos para manipular imágenes. Puede crear fácilmente su propio adaptador usando [Phalcon\Image\Adapter\AdapterInterface](api/phalcon_image#image-adapter-adapterinterface).

| Clase                                                                       | Descripción                                                                         |
| --------------------------------------------------------------------------- | ----------------------------------------------------------------------------------- |
| [Phalcon\Image\Adapter\Gd](api/phalcon_image#image-adapter-gd)           | Requiere la [extensión PHP GD](https://php.net/manual/en/book.image.php)            |
| [Phalcon\Image\Adapter\Imagick](api/phalcon_image#image-adapter-imagick) | Requiere la [extensión PHP ImageMagick](https://php.net/manual/en/book.imagick.php) |

## Constantes

[Phalcon\Image\Enum](api/phalcon_image#image-enum) mantiene constantes para redimensionar y voltear la imagen. Las constantes disponibles son:

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

## Getters

Cada adaptador ofrece *getters* para proporcionar información sobre el componente: - `getHeight()` - `int` - Devuelve la altura de la imagen - `getImage()` - `mixed` - Devuelve la imagen - `getMime()` - `string` - Devuelve el tipo mime de la imagen - `getRealpath()` - `string` - Devuelve la ruta real en la que se ubica la imagen - `getType()` - `int` - Devuelve el tipo de imagen (Esto depende del driver) - `getWidth()` - `int` - Devuelve la anchura de la imagen

## GD

[Phalcon\Image\Adapters\Gd](api/phalcon_image#image-adapter-gd) usa la [extensión PHP GD](https://php.net/manual/en/book.image.php). Para poder usar este adaptador, debe estar presente la extensión en su sistema. El adaptador ofrece todos los métodos descritos a continuación en la sección de operaciones.

## Imagick

[Phalcon\Image\Adapters\Imagick](api/phalcon_image#image-adapter-imagick) usa la [extensión PHP ImageMagick](https://php.net/manual/en/book.imagick.php). Para poder usar este adaptador, debe estar presente la extensión en su sistema. El adaptador ofrece todos los métodos descritos a continuación en la sección de operaciones.

## Operaciones

### `background()`

Establece el color de fondo para la imagen. Los parámetros disponibles son: - `color` - `string` - El color en formato hexadecimal - `opacity` - `int` - la opacidad (opcional - por defecto `100`).

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

Puede recortar imágenes programáticamente. El método `crop()` acepta los siguientes parámetros: - `width` - `int` - la anchura - `height` - `int` - la altura - `offsetX` - `int` - el desplazamiento X (opcional) - `offsetY` - `int` - el desplazamiento Y (opcional)

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

Este método sólo está disponible en el adaptador [Phalcon\Image\Imagick](api/phalcon_image#image-adapter-imagick). Usa el método de reescalado [liquid](https://www.php.net/manual/en/imagick.liquidrescaleimage.php) para reescalar la imagen. El método acepta los siguientes parámetros: - `width` - `int` - la nueva anchura - `height` - `int` - la nueva altura - `deltaX` - `int` - Cuánto puede atravesar la costura en el eje X. Pasando `0` causa que las costuras sean rectas. (opcional - por defecto `0`) - `rigidity` - `int` - Introduce un sesgo para costuras no rectas. (optional - por defecto `0`).

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

Añade reflejo a la imagen. El método acepta los siguientes parámetros: - `height` - `int` - la altura - `opacity` - `int` - la opacidad (opcional - por defecto `100`) - `fadeIn` - `bool` - si desvanecer o no (opcional - por defecto `false`)

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

$image->reflection(100, 75, true);

$image->save('reflection-image.jpg');
```

### `render()`

Renderiza la imagen y la devuelve como una cadena binaria. El método acepta los siguientes parámetros: - `ext` - `string` - la extensión (opcional) - `quality` - `int` - la calidad de la imagen (opcional - por defecto `100`)

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

// ....

echo $image->render('jpg', 90);
```

### `resize()`

Redimensiona la imagen basada en los parámetros pasados. El método acepta los siguiente parámetros: - `width` - `int` - la anchura (opcional) - `height` - `int` - la altura (opcional) - `master` - `int` - constante que representa el método de redimensionado (por defecto `AUTO`) - `Phalcon\Image\Enum::AUTO` - `Phalcon\Image\Enum::HEIGHT` - `Phalcon\Image\Enum::INVERSE` - `Phalcon\Image\Enum::NONE` - `Phalcon\Image\Enum::PRECISE` - `Phalcon\Image\Enum::TENSILE` - `Phalcon\Image\Enum::WIDTH`

Si alguno de los parámetros no es correcto, se lanzará [Phalcon\Image\Exception](api/phalcon_image#image-exception).

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

Rota una imagen basándose en los grados dados. Los números positivos rotan la imagen en el sentido de las agujas del reloj, mientras que los negativos en el sentido contrario a las agujas del reloj.

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

El método `save()` acepta el nombre del fichero y calidad como parámetros: - `file` - `string` - el nombre del fichero destino (opcional) - `quality` - `int` - la calidad de la imagen (opcional - por defecto `-1`)

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

Puede añadir texto a su imagen llamando a `text()`. Los parámetros disponibles son: - `text` - `string` - el texto - `offsetX` - `int`/`false` - el desplazamiento X, `false` para deshabilitar - `offsetY` - `int`/`false` - el desplazamiento Y, `false` para deshabilitar - `opacity` - `int` - la opacidad del texto (opcional - por defecto `100`) - `color` - `string` - el color del texto (opcional - por defecto `"000000"`) - `size` - `int` - el tamaño de la fuente del texto (opcional - por defecto `12`) - `fontfile` - `string` - el fichero fuente a usar para el texto (opcional)

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

Añade una marca de agua a una imagen. Los parámetros disponibles son: - `watermark` - `AdapterInterface` - la imagen a usar para la marca de agua - `offsetX` - `int` - el desplazamiento X (opcional) - `offsetY` - `int` - el desplazamiento Y (opcional) - `opacity` - `int` - la opacidad de la imagen (opcional - por defecto `100`)

El ejemplo siguiente pone la marca de agua en la esquina superior izquierda de la imagen:

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

También puede manipular la imagen de marca de agua antes de aplicarla a la imagen principal. En el siguiente ejemplo redimensionamos, rotamos y afinamos la imagen de agua y la colocamos en la esquina inferior derecha con un margen de 10px:

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

[Phalcon\Image\ImageFactory](api/phalcon_image#image-imagefactory) ofrece una forma fácil de crear objetos adaptadores de imagen. Ya hay dos adaptadores preestablecidos para usted:

- `gd`- [Phalcon\Image\Adapter\Gd](api/phalcon_image#image-adapter-gd) 
- `imagick` - [Phalcon\Image\Adapter\Imagick](api/phalcon_image#image-adapter-imagick)

Llamar `newInstance()` con la clave relevante así como parámetros devolverá el adaptador relevante. La fábrica siempre devuelve una nueva instancia de [Phalcon\Image\Adapter\AdapterInterface](api/phalcon_image#image-adapter-adapterinterface).

```php
<?php

use Phalcon\Image\ImageFactory;

$factory = new ImageFactory();

$image = $factory->newInstance('gd', 'image.jpg');
```

Los parámetros disponibles para `newInstance()` son: - `name` - `string` - el nombre del adaptador - `file` - `string` - el nombre del fichero - `width` - `int` - la anchura de la imagen (opcional) - `height` - `int` - la altura de la imagen (opcional)

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

Cualquier excepción lanzada en los componentes Imagen serán del tipo [Phalcon\Image\Exception](api/phalcon_image#image-exception). Puede usar esta excepción para capturar selectivamente sólo las excepciones lanzadas desde este componente.

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

Se debe implementar la interfaz [Phalcon\Image\Adapter\AdapterInterface](api/phalcon_image#image-adapter-adapterinterface) para poder crear sus propios adaptadores de imagen o extender los existentes. Entonces puede fácilmente añadirlo a [Phalcon\Image\ImageFactory](api/phalcon_image#image-imagefactory).

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
     * Add a watermark tot he image
     */
    public function watermark(
        AdapterInterface $watermark, 
        int $offsetX = 0, 
        int $offsetY = 0, 
        int $opacity = 100
    );
}
```
