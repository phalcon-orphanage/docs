---
layout: default
title: 'Phalcon\Image'
---

{%- include env-setup.html -%}

* [Phalcon\Image\Adapter\AbstractAdapter](#image-adapter-abstractadapter)
* [Phalcon\Image\Adapter\AdapterInterface](#image-adapter-adapterinterface)
* [Phalcon\Image\Adapter\Gd](#image-adapter-gd)
* [Phalcon\Image\Adapter\Imagick](#image-adapter-imagick)
* [Phalcon\Image\Enum](#image-enum)
* [Phalcon\Image\Exception](#image-exception)
* [Phalcon\Image\ImageFactory](#image-imagefactory)

<h1 id="image-adapter-abstractadapter">Abstract Class Phalcon\Image\Adapter\AbstractAdapter</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/{{ pageVersion }}.x/phalcon/Image/Adapter/AbstractAdapter.zep)

| Namespace | Phalcon\Image\Adapter | | Uses | Phalcon\Image\Enum, Phalcon\Image\Exception | | Implements | AdapterInterface |

Todos los adaptadores de imagen deben usar esta clase


## Propiedades
```php
/**
 * @var string
 */
protected file;

/**
 * Image height
 *
 * @var int
 */
protected height;

/**
 * @var mixed|null
 */
protected image;

/**
 * Image mime type
 *
 * @var string
 */
protected mime;

/**
 * @var string
 */
protected realpath;

/**
 * Image type
 *
 * Driver dependent
 *
 * @var int
 */
protected type;

/**
 * Image width
 *
 * @var int
 */
protected width;

```

## Métodos

```php
public function background( string $color, int $opacity = int ): AdapterInterface;
```
Establece el color de fondo de una imagen


```php
public function blur( int $radius ): AdapterInterface;
```
Desenfoca una imagen


```php
public function crop( int $width, int $height, int $offsetX = null, int $offsetY = null ): AdapterInterface;
```
Recorta una imagen al tamaño dado


```php
public function flip( int $direction ): AdapterInterface;
```
Da la vuelta a la imagen a lo largo del eje horizontal o vertical


```php
public function getHeight(): int;
```

```php
public function getImage();
```

```php
public function getMime(): string;
```

```php
public function getRealpath(): string;
```

```php
public function getType(): int;
```

```php
public function getWidth(): int;
```

```php
public function mask( AdapterInterface $mask ): AdapterInterface;
```
Combina una imagen en otra


```php
public function pixelate( int $amount ): AdapterInterface;
```
Pixela una imagen


```php
public function reflection( int $height, int $opacity = int, bool $fadeIn = bool ): AdapterInterface;
```
Añade un reflejo a una imagen


```php
public function render( string $extension = null, int $quality = int ): string;
```
Renderiza la imagen y devuelve la cadena binaria


```php
public function resize( int $width = null, int $height = null, int $master = static-constant-access ): AdapterInterface;
```
Redimensiona la imagen al tamaño dado


```php
public function rotate( int $degrees ): AdapterInterface;
```
Rota la imagen en la cantidad indicada


```php
public function save( string $file = null, int $quality = int ): AdapterInterface;
```
Guarda la imagen


```php
public function sharpen( int $amount ): AdapterInterface;
```
Ajusta la nitidez de la imagen en la cantidad indicada


```php
public function text( string $text, mixed $offsetX = bool, mixed $offsetY = bool, int $opacity = int, string $color = string, int $size = int, string $fontFile = null ): AdapterInterface;
```
Añade un texto a un imagen con una opacidad especificada


```php
public function watermark( AdapterInterface $watermark, int $offsetX = int, int $offsetY = int, int $opacity = int ): AdapterInterface;
```
Añade una marca de agua a una imagen con una opacidad especificada


```php
protected function checkHighLow( int $value, int $min = int, int $max = int ): int;
```





<h1 id="image-adapter-adapterinterface">Interface Phalcon\Image\Adapter\AdapterInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/{{ pageVersion }}.x/phalcon/Image/Adapter/AdapterInterface.zep)

| Namespace | Phalcon\Image\Adapter | | Uses | Phalcon\Image\Enum |

Interface for Phalcon\Image\Adapter classes


## Métodos

```php
public function background( string $color, int $opacity = int ): AdapterInterface;
```
Add a background to an image


```php
public function blur( int $radius ): AdapterInterface;
```
Blur an image


```php
public function crop( int $width, int $height, int $offsetX = null, int $offsetY = null ): AdapterInterface;
```
Crop an image


```php
public function flip( int $direction ): AdapterInterface;
```
Flip an image


```php
public function mask( AdapterInterface $mask ): AdapterInterface;
```
Add a mask to an image


```php
public function pixelate( int $amount ): AdapterInterface;
```
Pixelate an image


```php
public function reflection( int $height, int $opacity = int, bool $fadeIn = bool ): AdapterInterface;
```
Reflect an image


```php
public function render( string $extension = null, int $quality = int ): string;
```
Render an image


```php
public function resize( int $width = null, int $height = null, int $master = static-constant-access ): AdapterInterface;
```
Resize an image


```php
public function rotate( int $degrees ): AdapterInterface;
```
Rotate an image


```php
public function save( string $file = null, int $quality = int ): AdapterInterface;
```
Save an image


```php
public function sharpen( int $amount ): AdapterInterface;
```
Sharpen an image


```php
public function text( string $text, int $offsetX = int, int $offsetY = int, int $opacity = int, string $color = string, int $size = int, string $fontFile = null ): AdapterInterface;
```
Adds text on an image


```php
public function watermark( AdapterInterface $watermark, int $offsetX = int, int $offsetY = int, int $opacity = int ): AdapterInterface;
```
Add a watermark on an image




<h1 id="image-adapter-gd">Class Phalcon\Image\Adapter\Gd</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/{{ pageVersion }}.x/phalcon/Image/Adapter/Gd.zep)

| Namespace | Phalcon\Image\Adapter | | Uses | Phalcon\Image\Enum, Phalcon\Image\Exception | | Extends | AbstractAdapter |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team <team@phalcon.io>

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.


## Métodos

```php
public function __construct( string $file, int $width = null, int $height = null );
```

```php
public function __destruct();
```
Destructor


```php
public function getVersion(): string;
```

```php
protected function processBackground( int $red, int $green, int $blue, int $opacity ): void;
```

```php
protected function processBlur( int $radius ): void;
```

```php
protected function processCreate( int $width, int $height );
```

```php
protected function processCrop( int $width, int $height, int $offsetX, int $offsetY ): void;
```

```php
protected function processFlip( int $direction ): void;
```

```php
protected function processMask( AdapterInterface $mask );
```

```php
protected function processPixelate( int $amount ): void;
```

```php
protected function processReflection( int $height, int $opacity, bool $fadeIn ): void;
```

```php
protected function processRender( string $extension, int $quality );
```

```php
protected function processResize( int $width, int $height ): void;
```

```php
protected function processRotate( int $degrees ): void;
```

```php
protected function processSave( string $file, int $quality ): bool;
```

```php
protected function processSharpen( int $amount ): void;
```

```php
protected function processText( string $text, mixed $offsetX, mixed $offsetY, int $opacity, int $red, int $green, int $blue, int $size, string $fontFile = null ): void;
```

```php
protected function processWatermark( AdapterInterface $watermark, int $offsetX, int $offsetY, int $opacity ): void;
```





<h1 id="image-adapter-imagick">Class Phalcon\Image\Adapter\Imagick</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/{{ pageVersion }}.x/phalcon/Image/Adapter/Imagick.zep)

| Namespace  | Phalcon\Image\Adapter | | Uses       | Imagick, ImagickDraw, ImagickDrawException, ImagickException, ImagickPixel, ImagickPixelException, Phalcon\Image\Enum, Phalcon\Image\Exception | | Extends    | AbstractAdapter |

Phalcon\Image\Adapter\Imagick

Soporte para manipulación de imágenes. Resize, rotate, crop etc.

```php
$image = new \Phalcon\Image\Adapter\Imagick("upload/test.jpg");

$image->resize(200, 200)->rotate(90)->crop(100, 100);

if ($image->save()) {
    echo "success";
}
```


## Propiedades
```php
/**
 * @var int
 */
protected version = 0;

```

## Métodos

```php
public function __construct( string $file, int $width = null, int $height = null );
```
Constructor


```php
public function __destruct();
```
Destruye la imagen cargada para liberar recursos.


```php
public function liquidRescale( int $width, int $height, int $deltaX = int, int $rigidity = int ): AbstractAdapter;
```
Este método escala las imágenes usando el método de reescalado líquido. Solo para soporte Imagick


```php
public function setResourceLimit( int $type, int $limit ): void;
```
Establece los limites para un recurso particular en megabytes


```php
protected function processBackground( int $red, int $green, int $blue, int $opacity ): void;
```
Ejecuta un fondo.


```php
protected function processBlur( int $radius ): void;
```
Desenfoca una imagen


```php
protected function processCrop( int $width, int $height, int $offsetX, int $offsetY ): void;
```
Ejecuta un recorte.


```php
protected function processFlip( int $direction ): void;
```
Ejecuta un giro.


```php
protected function processMask( AdapterInterface $image ): void;
```
Combina una imagen en otra


```php
protected function processPixelate( int $amount ): void;
```
Pixela una imagen


```php
protected function processReflection( int $height, int $opacity, bool $fadeIn ): void;
```
Ejecuta un reflejo.


```php
protected function processRender( string $extension, int $quality ): string;
```
Ejecuta un renderizado.


```php
protected function processResize( int $width, int $height ): void;
```
Ejecuta un cambio de tamaño.


```php
protected function processRotate( int $degrees ): void;
```
Ejecuta una rotación.


```php
protected function processSave( string $file, int $quality ): void;
```
Ejecuta un guardado.


```php
protected function processSharpen( int $amount ): void;
```
Ejecuta un ajuste de nitidez.


```php
protected function processText( string $text, mixed $offsetX, mixed $offsetY, int $opacity, int $red, int $green, int $blue, int $size, string $fontFile = null ): void;
```
Ejecuta un texto


```php
protected function processWatermark( AdapterInterface $image, int $offsetX, int $offsetY, int $opacity ): void;
```
Add Watermark




<h1 id="image-enum">Class Phalcon\Image\Enum</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/{{ pageVersion }}.x/phalcon/Image/Enum.zep)

| Namespace | Phalcon\Image |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team <team@phalcon.io>

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.


## Constantes
```php
const AUTO = 4;
const HEIGHT = 3;
const HORIZONTAL = 11;
const INVERSE = 5;
const NONE = 1;
const PRECISE = 6;
const TENSILE = 7;
const VERTICAL = 12;
const WIDTH = 2;
```


<h1 id="image-exception">Class Phalcon\Image\Exception</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/{{ pageVersion }}.x/phalcon/Image/Exception.zep)

| Namespace  | Phalcon\Image | | Extends    | \Exception |

Exceptions thrown in Phalcon\Image will use this class



<h1 id="image-imagefactory">Class Phalcon\Image\ImageFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/{{ pageVersion }}.x/phalcon/Image/ImageFactory.zep)

| Namespace  | Phalcon\Image | | Uses       | Phalcon\Factory\AbstractFactory, Phalcon\Image\Adapter\AdapterInterface | | Extends    | AbstractFactory |



## Métodos

```php
public function __construct( array $services = [] );
```
Constructor


```php
public function load( mixed $config ): AdapterInterface;
```
Factoría para crear una instancia desde un objeto Config


```php
public function newInstance( string $name, string $file, int $width = null, int $height = null ): AdapterInterface;
```
Crea una nueva instancia


```php
protected function getExceptionClass(): string;
```

```php
protected function getServices(): array;
```
Devuelve los adaptadores disponibles
