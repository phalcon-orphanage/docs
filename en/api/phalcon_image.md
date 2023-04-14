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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/{{ pageVersion }}/phalcon/Image/Adapter/AbstractAdapter.zep)

| Namespace  | Phalcon\Image\Adapter |
| Uses       | Phalcon\Image\Enum, Phalcon\Image\Exception |
| Implements | AdapterInterface |

All image adapters must use this class


## Properties
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

## Methods

```php
public function background( string $color, int $opacity = int ): AdapterInterface;
```
Set the background color of an image


```php
public function blur( int $radius ): AdapterInterface;
```
Blur image


```php
public function crop( int $width, int $height, int $offsetX = null, int $offsetY = null ): AdapterInterface;
```
Crop an image to the given size


```php
public function flip( int $direction ): AdapterInterface;
```
Flip the image along the horizontal or vertical axis


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
Composite one image onto another


```php
public function pixelate( int $amount ): AdapterInterface;
```
Pixelate image


```php
public function reflection( int $height, int $opacity = int, bool $fadeIn = bool ): AdapterInterface;
```
Add a reflection to an image


```php
public function render( string $extension = null, int $quality = int ): string;
```
Render the image and return the binary string


```php
public function resize( int $width = null, int $height = null, int $master = static-constant-access ): AdapterInterface;
```
Resize the image to the given size


```php
public function rotate( int $degrees ): AdapterInterface;
```
Rotate the image by a given amount


```php
public function save( string $file = null, int $quality = int ): AdapterInterface;
```
Save the image


```php
public function sharpen( int $amount ): AdapterInterface;
```
Sharpen the image by a given amount


```php
public function text( string $text, mixed $offsetX = bool, mixed $offsetY = bool, int $opacity = int, string $color = string, int $size = int, string $fontFile = null ): AdapterInterface;
```
Add a text to an image with a specified opacity


```php
public function watermark( AdapterInterface $watermark, int $offsetX = int, int $offsetY = int, int $opacity = int ): AdapterInterface;
```
Add a watermark to an image with the specified opacity


```php
protected function checkHighLow( int $value, int $min = int, int $max = int ): int;
```





<h1 id="image-adapter-adapterinterface">Interface Phalcon\Image\Adapter\AdapterInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/{{ pageVersion }}/phalcon/Image/Adapter/AdapterInterface.zep)

| Namespace  | Phalcon\Image\Adapter |
| Uses       | Phalcon\Image\Enum |

Interface for Phalcon\Image\Adapter classes


## Methods

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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/{{ pageVersion }}/phalcon/Image/Adapter/Gd.zep)

| Namespace  | Phalcon\Image\Adapter |
| Uses       | Phalcon\Image\Enum, Phalcon\Image\Exception |
| Extends    | AbstractAdapter |

This file is part of the Phalcon Framework.

(c) Phalcon Team <team@phalcon.io>

For the full copyright and license information, please view the LICENSE.txt
file that was distributed with this source code.


## Methods

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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/{{ pageVersion }}/phalcon/Image/Adapter/Imagick.zep)

| Namespace  | Phalcon\Image\Adapter |
| Uses       | Imagick, ImagickDraw, ImagickDrawException, ImagickException, ImagickPixel, ImagickPixelException, Phalcon\Image\Enum, Phalcon\Image\Exception |
| Extends    | AbstractAdapter |

Phalcon\Image\Adapter\Imagick

Image manipulation support. Resize, rotate, crop etc.

```php
$image = new \Phalcon\Image\Adapter\Imagick("upload/test.jpg");

$image->resize(200, 200)->rotate(90)->crop(100, 100);

if ($image->save()) {
    echo "success";
}
```


## Properties
```php
/**
 * @var int
 */
protected version = 0;

```

## Methods

```php
public function __construct( string $file, int $width = null, int $height = null );
```
Constructor


```php
public function __destruct();
```
Destroys the loaded image to free up resources.


```php
public function liquidRescale( int $width, int $height, int $deltaX = int, int $rigidity = int ): AbstractAdapter;
```
This method scales the images using liquid rescaling method. Only support
Imagick


```php
public function setResourceLimit( int $type, int $limit ): void;
```
Sets the limit for a particular resource in megabytes


```php
protected function processBackground( int $red, int $green, int $blue, int $opacity ): void;
```
Execute a background.


```php
protected function processBlur( int $radius ): void;
```
Blur image


```php
protected function processCrop( int $width, int $height, int $offsetX, int $offsetY ): void;
```
Execute a crop.


```php
protected function processFlip( int $direction ): void;
```
Execute a flip.


```php
protected function processMask( AdapterInterface $image ): void;
```
Composite one image onto another


```php
protected function processPixelate( int $amount ): void;
```
Pixelate image


```php
protected function processReflection( int $height, int $opacity, bool $fadeIn ): void;
```
Execute a reflection.


```php
protected function processRender( string $extension, int $quality ): string;
```
Execute a render.


```php
protected function processResize( int $width, int $height ): void;
```
Execute a resize.


```php
protected function processRotate( int $degrees ): void;
```
Execute a rotation.


```php
protected function processSave( string $file, int $quality ): void;
```
Execute a save.


```php
protected function processSharpen( int $amount ): void;
```
Execute a sharpen.


```php
protected function processText( string $text, mixed $offsetX, mixed $offsetY, int $opacity, int $red, int $green, int $blue, int $size, string $fontFile = null ): void;
```
Execute a text


```php
protected function processWatermark( AdapterInterface $image, int $offsetX, int $offsetY, int $opacity ): void;
```
Add Watermark




<h1 id="image-enum">Class Phalcon\Image\Enum</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/{{ pageVersion }}/phalcon/Image/Enum.zep)

| Namespace  | Phalcon\Image |

This file is part of the Phalcon Framework.

(c) Phalcon Team <team@phalcon.io>

For the full copyright and license information, please view the LICENSE.txt
file that was distributed with this source code.


## Constants
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

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/{{ pageVersion }}/phalcon/Image/Exception.zep)

| Namespace  | Phalcon\Image |
| Extends    | \Exception |

Exceptions thrown in Phalcon\Image will use this class



<h1 id="image-imagefactory">Class Phalcon\Image\ImageFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/blob/{{ pageVersion }}/phalcon/Image/ImageFactory.zep)

| Namespace  | Phalcon\Image |
| Uses       | Phalcon\Factory\AbstractFactory, Phalcon\Image\Adapter\AdapterInterface |
| Extends    | AbstractFactory |



## Methods

```php
public function __construct( array $services = [] );
```
Constructor


```php
public function load( mixed $config ): AdapterInterface;
```
Factory to create an instance from a Config object


```php
public function newInstance( string $name, string $file, int $width = null, int $height = null ): AdapterInterface;
```
Creates a new instance


```php
protected function getExceptionClass(): string;
```



```php
protected function getServices(): array;
```
Returns the available adapters
