---
layout: default
language: 'es-es'
version: '4.0'
title: 'Phalcon\Image'
---

* [Phalcon\Image\Adapter\AbstractAdapter](#image-adapter-abstractadapter)
* [Phalcon\Image\Adapter\AdapterInterface](#image-adapter-adapterinterface)
* [Phalcon\Image\Adapter\Gd](#image-adapter-gd)
* [Phalcon\Image\Adapter\Imagick](#image-adapter-imagick)
* [Phalcon\Image\Enum](#image-enum)
* [Phalcon\Image\Exception](#image-exception)
* [Phalcon\Image\ImageFactory](#image-imagefactory)

<h1 id="image-adapter-abstractadapter">Abstract Class Phalcon\Image\Adapter\AbstractAdapter</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Image/Adapter/AbstractAdapter.zep)

| Namespace | Phalcon\Image\Adapter | | Uses | Phalcon\Image\Enum, Phalcon\Image\Exception | | Implements | AdapterInterface |

Phalcon\Image\Adapter

Todos los adaptadores de imagen deben usar esta clase

## Propiedades

```php
//
protected static checked = false;

//
protected file;

/**
 * Image height
 *
 * @var int
 */
protected height;

//
protected image;

/**
 * Image mime type
 *
 * @var string
 */
protected mime;

//
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
public function getHeight(): int
```

```php
public function getImage()
```

```php
public function getMime(): string
```

```php
public function getRealpath()
```

```php
public function getType(): int
```

```php
public function getWidth(): int
```

```php
public function liquidRescale( int $width, int $height, int $deltaX = int, int $rigidity = int ): AbstractAdapter;
```

Este método escala las imágenes usando el método de reescalado líquido. Solo para soporte Imagick

```php
public function mask( AdapterInterface $watermark ): AdapterInterface;
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
public function render( string $ext = null, int $quality = int ): string;
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
public function text( string $text, mixed $offsetX = bool, mixed $offsetY = bool, int $opacity = int, string $color = string, int $size = int, string $fontfile = null ): AdapterInterface;
```

Añade un texto a un imagen con una opacidad especificada

```php
public function watermark( AdapterInterface $watermark, int $offsetX = int, int $offsetY = int, int $opacity = int ): AdapterInterface;
```

Añade una marca de agua a una imagen con una opacidad especificada

<h1 id="image-adapter-adapterinterface">Interface Phalcon\Image\Adapter\AdapterInterface</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Image/Adapter/AdapterInterface.zep)

| Namespace | Phalcon\Image\Adapter | | Uses | Phalcon\Image\Enum |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team <team@phalcon.io>

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.

## Métodos

```php
public function background( string $color, int $opacity = int ): AdapterInterface;
```

```php
public function blur( int $radius ): AdapterInterface;
```

```php
public function crop( int $width, int $height, int $offsetX = null, int $offsetY = null ): AdapterInterface;
```

```php
public function flip( int $direction ): AdapterInterface;
```

```php
public function mask( AdapterInterface $watermark ): AdapterInterface;
```

```php
public function pixelate( int $amount ): AdapterInterface;
```

```php
public function reflection( int $height, int $opacity = int, bool $fadeIn = bool ): AdapterInterface;
```

```php
public function render( string $ext = null, int $quality = int ): string;
```

```php
public function resize( int $width = null, int $height = null, int $master = static-constant-access ): AdapterInterface;
```

```php
public function rotate( int $degrees ): AdapterInterface;
```

```php
public function save( string $file = null, int $quality = int ): AdapterInterface;
```

```php
public function sharpen( int $amount ): AdapterInterface;
```

```php
public function text( string $text, int $offsetX = int, int $offsetY = int, int $opacity = int, string $color = string, int $size = int, string $fontfile = null ): AdapterInterface;
```

```php
public function watermark( AdapterInterface $watermark, int $offsetX = int, int $offsetY = int, int $opacity = int ): AdapterInterface;
```

<h1 id="image-adapter-gd">Class Phalcon\Image\Adapter\Gd</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Image/Adapter/Gd.zep)

| Namespace | Phalcon\Image\Adapter | | Uses | Phalcon\Image\Enum, Phalcon\Image\Exception | | Extends | AbstractAdapter |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team <team@phalcon.io>

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.

## Propiedades

```php
//
protected static checked = false;

```

## Métodos

```php
public function __construct( string $file, int $width = null, int $height = null );
```

```php
public function __destruct();
```

```php
public static function check(): bool;
```

```php
public static function getVersion(): string;
```

```php
protected function processBackground( int $r, int $g, int $b, int $opacity );
```

```php
protected function processBlur( int $radius );
```

```php
protected function processCreate( int $width, int $height );
```

```php
protected function processCrop( int $width, int $height, int $offsetX, int $offsetY );
```

```php
protected function processFlip( int $direction );
```

```php
protected function processMask( AdapterInterface $mask );
```

```php
protected function processPixelate( int $amount );
```

```php
protected function processReflection( int $height, int $opacity, bool $fadeIn );
```

```php
protected function processRender( string $ext, int $quality );
```

```php
protected function processResize( int $width, int $height );
```

```php
protected function processRotate( int $degrees );
```

```php
protected function processSave( string $file, int $quality );
```

```php
protected function processSharpen( int $amount );
```

```php
protected function processText( string $text, int $offsetX, int $offsetY, int $opacity, int $r, int $g, int $b, int $size, string $fontfile );
```

```php
protected function processWatermark( AdapterInterface $watermark, int $offsetX, int $offsetY, int $opacity );
```

<h1 id="image-adapter-imagick">Class Phalcon\Image\Adapter\Imagick</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Image/Adapter/Imagick.zep)

| Namespace | Phalcon\Image\Adapter | | Uses | Phalcon\Image\Enum, Phalcon\Image\Exception | | Extends | AbstractAdapter |

Phalcon\Image\Adapter\Imagick

Soporte para manipulación de imágenes. Permite cambiar el tamaño de las imágenes, recortar, etc.

```php
$image = new \Phalcon\Image\Adapter\Imagick("upload/test.jpg");

$image->resize(200, 200)->rotate(90)->crop(100, 100);

if ($image->save()) {
    echo "success";

}
```

## Propiedades

```php
//
protected static checked = false;

//
protected static version = 0;

```

## Métodos

```php
public function __construct( string $file, int $width = null, int $height = null );
```

Constructor \Phalcon\Image\Adapter\Imagick

```php
public function __destruct();
```

Destruye la imagen cargada para liberar recursos.

```php
public static function check(): bool;
```

Comprueba si Imagick está habilitado

```php
public function getInternalImInstance(): \Imagick;
```

Obtiene una instancia

```php
public function setResourceLimit( int $type, int $limit );
```

Establece los limites para un recurso particular en megabytes

@link http://php.net/manual/ru/imagick.constants.php#imagick.constants.resourcetypes

```php
protected function processBackground( int $r, int $g, int $b, int $opacity );
```

Ejecuta un fondo.

```php
protected function processBlur( int $radius );
```

Desenfoca una imagen

```php
protected function processCrop( int $width, int $height, int $offsetX, int $offsetY );
```

Ejecuta un recorte.

```php
protected function processFlip( int $direction );
```

Ejecuta un giro.

```php
protected function processLiquidRescale( int $width, int $height, int $deltaX, int $rigidity );
```

Este método escala las imágenes usando el método de reescalado líquido. Solo para soporte Imagick

```php
protected function processMask( AdapterInterface $image );
```

Combina una imagen en otra

```php
protected function processPixelate( int $amount );
```

Pixela una imagen

```php
protected function processReflection( int $height, int $opacity, bool $fadeIn );
```

Ejecuta un reflejo.

```php
protected function processRender( string $extension, int $quality ): string;
```

Ejecuta un renderizado.

```php
protected function processResize( int $width, int $height );
```

Ejecuta un cambio de tamaño.

```php
protected function processRotate( int $degrees );
```

Ejecuta una rotación.

```php
protected function processSave( string $file, int $quality );
```

Ejecuta un guardado.

```php
protected function processSharpen( int $amount );
```

Ejecuta un ajuste de nitidez.

```php
protected function processText( string $text, mixed $offsetX, mixed $offsetY, int $opacity, int $r, int $g, int $b, int $size, string $fontfile );
```

Ejecuta un texto

```php
protected function processWatermark( AdapterInterface $image, int $offsetX, int $offsetY, int $opacity );
```

Ejecuta una marca de agua.

<h1 id="image-enum">Class Phalcon\Image\Enum</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Image/Enum.zep)

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

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Image/Exception.zep)

| Namespace | Phalcon\Image | | Extends | \Phalcon\Exception |

Este fichero es parte del Framework Phalcon.

(c) Phalcon Team <team@phalcon.io>

Para obtener toda la información sobre derechos de autor y licencias, por favor vea el archivo LICENSE.txt que se distribuyó con este código fuente.

<h1 id="image-imagefactory">Class Phalcon\Image\ImageFactory</h1>

[Código fuente en GitHub](https://github.com/phalcon/cphalcon/blob/v{{ pageVersion }}.0/phalcon/Image/ImageFactory.zep)

| Namespace | Phalcon\Image | | Uses | Phalcon\Config, Phalcon\Factory\AbstractFactory, Phalcon\Helper\Arr, Phalcon\Image\Adapter\AdapterInterface | | Extends | AbstractFactory |

Phalcon\Image/ImageFactory

## Métodos

```php
public function __construct( array $services = [] );
```

Constructor TagFactory.

```php
public function load( mixed $config ): AdapterInterface;
```

Factoría para crear una instancia desde un objeto Config

```php
public function newInstance( string $name, string $file, int $width = null, int $height = null ): AdapterInterface;
```

Crea una nueva instancia

```php
protected function getAdapters(): array;
```
