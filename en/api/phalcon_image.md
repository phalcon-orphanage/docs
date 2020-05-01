---
layout: default
language: 'en'
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

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Image/Adapter/AbstractAdapter.zep)

| Namespace  | Phalcon\Image\Adapter |
| Uses       | Phalcon\Image\Enum, Phalcon\Image\Exception |
| Implements | AdapterInterface |

Phalcon\Image\Adapter

All image adapters must use this class


## Properties
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

## Methods

 Set the background color of an image
 
```php
public function background( string $color, int $opacity = int ): AdapterInterface;
```

 Blur image
 
```php
public function blur( int $radius ): AdapterInterface;
```

 Crop an image to the given size
 
```php
public function crop( int $width, int $height, int $offsetX = null, int $offsetY = null ): AdapterInterface;
```

 Flip the image along the horizontal or vertical axis
 
```php
public function flip( int $direction ): AdapterInterface;
```


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

This method scales the images using liquid rescaling method. Only support
Imagick
```php
public function liquidRescale( int $width, int $height, int $deltaX = int, int $rigidity = int ): AbstractAdapter;
```

 Composite one image onto another
 
```php
public function mask( AdapterInterface $watermark ): AdapterInterface;
```

 Pixelate image
 
```php
public function pixelate( int $amount ): AdapterInterface;
```

 Add a reflection to an image
 
```php
public function reflection( int $height, int $opacity = int, bool $fadeIn = bool ): AdapterInterface;
```

 Render the image and return the binary string
 
```php
public function render( string $ext = null, int $quality = int ): string;
```

 Resize the image to the given size
 
```php
public function resize( int $width = null, int $height = null, int $master = static-constant-access ): AdapterInterface;
```

 Rotate the image by a given amount
 
```php
public function rotate( int $degrees ): AdapterInterface;
```

 Save the image
 
```php
public function save( string $file = null, int $quality = int ): AdapterInterface;
```

 Sharpen the image by a given amount
 
```php
public function sharpen( int $amount ): AdapterInterface;
```

 Add a text to an image with a specified opacity
 
```php
public function text( string $text, mixed $offsetX = bool, mixed $offsetY = bool, int $opacity = int, string $color = string, int $size = int, string $fontfile = null ): AdapterInterface;
```

 Add a watermark to an image with the specified opacity
 
```php
public function watermark( AdapterInterface $watermark, int $offsetX = int, int $offsetY = int, int $opacity = int ): AdapterInterface;
```



<h1 id="image-adapter-adapterinterface">Interface Phalcon\Image\Adapter\AdapterInterface</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Image/Adapter/AdapterInterface.zep)

| Namespace  | Phalcon\Image\Adapter |
| Uses       | Phalcon\Image\Enum |

This file is part of the Phalcon Framework.

(c) Phalcon Team <team@phalcon.io>

For the full copyright and license information, please view the LICENSE.txt
file that was distributed with this source code.


## Methods


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

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Image/Adapter/Gd.zep)

| Namespace  | Phalcon\Image\Adapter |
| Uses       | Phalcon\Image\Enum, Phalcon\Image\Exception |
| Extends    | AbstractAdapter |

This file is part of the Phalcon Framework.

(c) Phalcon Team <team@phalcon.io>

For the full copyright and license information, please view the LICENSE.txt
file that was distributed with this source code.


## Properties
```php
//
protected static checked = false;

```

## Methods


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

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Image/Adapter/Imagick.zep)

| Namespace  | Phalcon\Image\Adapter |
| Uses       | Phalcon\Image\Enum, Phalcon\Image\Exception |
| Extends    | AbstractAdapter |

Phalcon\Image\Adapter\Imagick

Image manipulation support. Allows images to be resized, cropped, etc.

```php
$image = new \Phalcon\Image\Adapter\Imagick("upload/test.jpg");

$image->resize(200, 200)->rotate(90)->crop(100, 100);

if ($image->save()) {
    echo "success";

}
```


## Properties
```php
//
protected static checked = false;

//
protected static version = 0;

```

## Methods

\Phalcon\Image\Adapter\Imagick constructor
```php
public function __construct( string $file, int $width = null, int $height = null );
```

Destroys the loaded image to free up resources.
```php
public function __destruct();
```

Checks if Imagick is enabled
```php
public static function check(): bool;
```

Get instance
```php
public function getInternalImInstance(): \Imagick;
```

Sets the limit for a particular resource in megabytes

@link http://php.net/manual/ru/imagick.constants.php#imagick.constants.resourcetypes
```php
public function setResourceLimit( int $type, int $limit );
```

Execute a background.
```php
protected function processBackground( int $r, int $g, int $b, int $opacity );
```

Blur image
```php
protected function processBlur( int $radius );
```

Execute a crop.
```php
protected function processCrop( int $width, int $height, int $offsetX, int $offsetY );
```

Execute a flip.
```php
protected function processFlip( int $direction );
```

This method scales the images using liquid rescaling method. Only support
Imagick
```php
protected function processLiquidRescale( int $width, int $height, int $deltaX, int $rigidity );
```

Composite one image onto another
```php
protected function processMask( AdapterInterface $image );
```

Pixelate image
```php
protected function processPixelate( int $amount );
```

Execute a reflection.
```php
protected function processReflection( int $height, int $opacity, bool $fadeIn );
```

Execute a render.
```php
protected function processRender( string $extension, int $quality ): string;
```

Execute a resize.
```php
protected function processResize( int $width, int $height );
```

Execute a rotation.
```php
protected function processRotate( int $degrees );
```

Execute a save.
```php
protected function processSave( string $file, int $quality );
```

Execute a sharpen.
```php
protected function processSharpen( int $amount );
```

Execute a text
```php
protected function processText( string $text, mixed $offsetX, mixed $offsetY, int $opacity, int $r, int $g, int $b, int $size, string $fontfile );
```

Execute a watermarking.
```php
protected function processWatermark( AdapterInterface $image, int $offsetX, int $offsetY, int $opacity );
```



<h1 id="image-enum">Class Phalcon\Image\Enum</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Image/Enum.zep)

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

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Image/Exception.zep)

| Namespace  | Phalcon\Image |
| Extends    | \Phalcon\Exception |

This file is part of the Phalcon Framework.

(c) Phalcon Team <team@phalcon.io>

For the full copyright and license information, please view the LICENSE.txt
file that was distributed with this source code.



<h1 id="image-imagefactory">Class Phalcon\Image\ImageFactory</h1>

[Source on GitHub](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/Image/ImageFactory.zep)

| Namespace  | Phalcon\Image |
| Uses       | Phalcon\Config, Phalcon\Factory\AbstractFactory, Phalcon\Helper\Arr, Phalcon\Image\Adapter\AdapterInterface |
| Extends    | AbstractFactory |

Phalcon\Image/ImageFactory


## Methods

TagFactory constructor.
```php
public function __construct( array $services = [] );
```

Factory to create an instance from a Config object
```php
public function load( mixed $config ): AdapterInterface;
```

Creates a new instance
```php
public function newInstance( string $name, string $file, int $width = null, int $height = null ): AdapterInterface;
```


```php
protected function getAdapters(): array;
```

