---
layout: default
language: 'fa-ir'
version: '4.0'
title: 'Image'
keywords: 'image, gd, imagick'
---

# Image

* * *

![](/assets/images/document-status-stable-success.svg) ![](/assets/images/version-{{ page.version }}.svg)

## Overview

The `Phalcon\Image` namespace exposes adapter that offer image manipulating functionality. These adapters are designed to allow multiple operations to be performed on the same image.

## Adapters

This component uses adapters that offer methods to manipulate images. You can easily create your own adapter using the [Phalcon\Image\Adapter\AdapterInterface](api/phalcon_image#image-adapter-adapterinterface).

| Class                                                                       | Description                                                                          |
| --------------------------------------------------------------------------- | ------------------------------------------------------------------------------------ |
| [Phalcon\Image\Adapter\Gd](api/phalcon_image#image-adapter-gd)           | Requires the [GD PHP extension](https://php.net/manual/en/book.image.php)            |
| [Phalcon\Image\Adapter\Imagick](api/phalcon_image#image-adapter-imagick) | Requires the [ImageMagick PHP extension](https://php.net/manual/en/book.imagick.php) |

## Constants

[Phalcon\Image\Enum](api/phalcon_image#image-enum) holds constants for image resizing and flipping. The available constants are:

**Resize**

- `AUTO`
- `HEIGHT`
- `INVERSE`
- `NONE`
- `PRECISE`
- `TENSILE`
- `WIDTH`

**Flip**

- `HORIZONTAL`
- `VERTICAL`

## Getters

Each adapter offers getters to provide information about the component: - `getHeight()` - `int` - Returns the image height - `getImage()` - `mixed` - Returns the image - `getMime()` - `string` - Returns the image mime type - `getRealpath()` - `string` - Returns the real path where the image is located - `getType()` - `int` - Returns the image type (This is driver dependent) - `getWidth()` - `int` - Returns the image width

## GD

[Phalcon\Image\Adapters\Gd](api/phalcon_image#image-adapter-gd) utilizes the [GD PHP extension](https://php.net/manual/en/book.image.php). In order for you to use this adapter, the extension has to be present in your system. The adapter offers all the methods described below in the operations section.

## Imagick

[Phalcon\Image\Adapters\Imagick](api/phalcon_image#image-adapter-imagick) utilizes the [ImageMagick PHP extension](https://php.net/manual/en/book.imagick.php). In order for you to use this adapter, the extension has to be present in your system. The adapter offers all the methods described below in the operations section.

## Operations

### `background()`

Sets the background color for the image. The available parameters are: - `color` - `string` - the color in hex format - `opacity` - `int` - the opacity (optional - default `100`).

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

$image->background('#000033', 70);

$image->save('background-image.jpg');
```

### `blur()`

Blurs the image. The passed integer parameter specifies the radius for the blur operation. The range is between 0 (no effect) and 100 (very blurry):

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

$image->blur(50);

$image->save('blur-image.jpg');
```

### `crop()`

You can crop images programmatically. The `crop()` method accepts the following parameters: - `width` - `int` - the width - `height` - `int` - the height - `offsetX` - `int` - the X offset (optional) - `offsetY` - `int` - the Y offset (optional)

The following example crops 100px by 100px from the center of the image:

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

You can flip an image horizontally or vertically. The `flip()` method accepts an integer, signifying the direction. You can use the constants for this operation:

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

This method is only available in the [Phalcon\Image\Imagick](api/phalcon_image#image-adapter-imagick) adapter. It uses the [liquid](https://www.php.net/manual/en/imagick.liquidrescaleimage.php) rescaling method to rescale the image. The method accepts the following parameters: - `width` - `int` - the new width - `height` - `int` - the new height - `deltaX` - `int` - How much the seam can traverse on x-axis. Passing `0` causes the seams to be straight. (optional - default `0`) - `rigidity` - `int` - Introduces a bias for non-straight seams. (optional - default `0`).

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

$image->liquidRescale(500, 200, 3, 25);

$image->save('liquidrescale-image.jpg');
```

### `mask()`

Creates a composite image from two images. Accepts the first image as a parameter.

```php
<?php

use Phalcon\Image\Adapter\Gd;

$front = new Gd('front.jpg');
$back  = new Gd('back.jpg');

$front->mask($front);

$front->save('mask-image.jpg');
```

### `pixelate()`

Adds pixelation to the image. The method accepts a single integer parameter. The higher the number, the more pixelated the image becomes:

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

$image->pixelate(10);

$image->save('pixelate-image.jpg');
```

### `reflection()`

Adds reflection to the image. The method accepts the following parameters: - `height` - `int` - the height - `opacity` - `int` - the opacity (optional - default `100`) - `fadeIn` - `bool` - whether to fade in or not (optional - default `false`)

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

$image->reflection(100, 75, true);

$image->save('reflection-image.jpg');
```

### `render()`

Renders the image and returns it back as a binary string. The method accepts the following parameters: - `ext` - `string` - the extension (optional) - `quality` - `int` - the quality of the image (optional - default `100`)

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

// ....

echo $image->render('jpg', 90);
```

### `resize()`

Resizes the image based on the passed parameters. The method accepts the following parameters: - `width` - `int` - the width (optional) - `height` - `int` - the height (optional) - `master` - `int` - constant signifying the resizing method (default `AUTO`) - `Phalcon\Image\Enum::AUTO` - `Phalcon\Image\Enum::HEIGHT` - `Phalcon\Image\Enum::INVERSE` - `Phalcon\Image\Enum::NONE` - `Phalcon\Image\Enum::PRECISE` - `Phalcon\Image\Enum::TENSILE` - `Phalcon\Image\Enum::WIDTH`

If any of the parameters are not correct, a [Phalcon\Image\Exception](api/phalcon_image#image-exception) will be thrown.

**HEIGHT**

The width will automatically be generated to keep the proportions the same; if you specify a width, it will be ignored.

```php
<?php

use Phalcon\Image\Adapter\Gd;
use Phalcon\Image\Enum;

$image = new Gd('image.jpg');

$image->resize(300, null, Enum::HEIGHT);

$image->save('resize-height-image.jpg');
```

**INVERSE**

Resizes and inverts the width and height passed

```php
<?php

use Phalcon\Image\Adapter\Gd;
use Phalcon\Image\Enum;

$image = new Gd('image.jpg');

$image->resize(400, 200, Enum::INVERSE);

$image->save('resize-inverse-image.jpg');
```

**NONE**

- The `NONE` constant ignores the original image's ratio.
- Neither width and height are required.
- If a dimension is not specified, the original dimension will be used.
- If the new proportions differ from the original proportions, the image may be distorted and stretched.

```php
<?php

use Phalcon\Image\Adapter\Gd;
use Phalcon\Image\Enum;

$image = new Gd('image.jpg');

$image->resize(400, 200, Enum::NONE);

$image->save('resize-none-image.jpg');
```

**TENSILE**

- Similar to the `NONE` constant, the `TENSILE` constant ignores the original image's ratio.
- Both width and height are required.
- If the new proportions differ from the original proportions, the image may be distorted and stretched.

```php
<?php

use Phalcon\Image\Adapter\Gd;
use Phalcon\Image\Enum;

$image = new Gd('image.jpg');

$image->resize(400, 200, Enum::TENSILE);

$image->save('resize-tensile-image.jpg');
```

**WIDTH**

The height will automatically be generated to keep the proportions the same; if you specify a height, it will be ignored.

```php
<?php

use Phalcon\Image\Adapter\Gd;
use Phalcon\Image\Enum;

$image = new Gd('image.jpg');

$image->resize(300, null, Enum::WIDTH);

$image->save('resize-width-image.jpg');
```

### `rotate()`

Rotates an image based on the given degrees. Positive numbers rotate the image clockwise while negative counter clockwise.

The following example rotates an image by 90 degrees clockwise

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

$image->rotate(90);

$image->save('rotate-image.jpg');
```

### `save()`

After manipulating your image, you will most likely want to save it. If you wish to just get the result of the manipulations back as a string, you can use the `render()` method.

The `save()` method accepts the filename and quality as parameters: - `file` - `string` - the target file name (optional) - `quality` - `int` - the quality of the image (optional - default `-1`)

If a file name is not specified, the manipulated image will overwrite the original image.

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

$image->rotate(90);

$image->save();
```

When specifying a file name, the manipulated image will be saved with that name, leaving the original image unchanged.

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

$image->rotate(90);

$image->save('rotate-image.jpg');
```

You can also change the format of the image using a different extension. This functionality depends on the adapter you are working with.

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

$image->rotate(90);

$image->save('rotate-image.png');
```

When saving as a JPEG, you can also specify the quality as the second parameter:

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

$image->rotate(90);

$image->save('rotate-image.jpg', 90);
```

### `sharpen()`

Sharpens the image. The passed integer parameter specifies the amount for the blur operation. The range is between 0 (no effect) and 100 (very sharp):

```php
<?php

use Phalcon\Image\Adapter\Gd;

$image = new Gd('image.jpg');

$image->sharpen(50);

$image->save('sharpen-image.jpg');
```

### `text()`

You can add text to your image by calling `text()`. The available parameters are: - `text` - `string` - the text - `offsetX` - `int`/`false` - the X offset, `false` to disable - `offsetY` - `int`/`false` - the Y offset, `false` to disable - `opacity` - `int` - the opacity of the text (optional - default `100`) - `color` - `string` - the color for the text (optional - default `"000000"`) - `size` - `int` - the size of the font for the text (optional - default `12`) - `fontfile` - `string` - the font file to be used for the text (optional)

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

Adds a watermark to an image. The available parameters are: - `watermark` - `AdapterInterface` - the image to use for the watermark - `offsetX` - `int` - the X offset (optional) - `offsetY` - `int` - the Y offset (optional) - `opacity` - `int` - the opacity of the text (optional - default `100`)

The following example puts the watermark at the top left corner of the image:

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

You can also manipulate the watermarked image before applying it to the main image. In the following example we resize, rotate and sharpen the watermark and put it at the bottom right corner with a 10px margin:

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

## Factory

### `newInstance`

The [Phalcon\Image\ImageFactory](api/phalcon_image#image-imagefactory) offers an easy way to create image adapter objects. There are two adapters already preset for you:

- `gd`- [Phalcon\Image\Adapter\Gd](api/phalcon_image#image-adapter-gd) 
- `imagick` - [Phalcon\Image\Adapter\Imagick](api/phalcon_image#image-adapter-imagick)

Calling `newInstance()` with the relevant key as well as parameters will return the relevant adapter. The factory always returns a new instance of [Phalcon\Image\Adapter\AdapterInterface](api/phalcon_image#image-adapter-adapterinterface).

```php
<?php

use Phalcon\Image\ImageFactory;

$factory = new ImageFactory();

$image = $factory->newInstance('gd', 'image.jpg');
```

The available parameters for `newInstance()` are: - `name` - `string` - the name of the adapter - `file` - `string` - the file name - `width` - `int` - the width of the image (optional) - `height` - `int` - the height of the image (optional)

### `load`

The Image Factory also offers the `load` method, which accepts a configuration object. This object can be an array or a [Phalcon\Config](config) object, with directives that are used to set up the image adapter. The object requires the `adapter` element, as well as the `file` element. `width` and `height` can also be set as options.

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

## Exceptions

Any exceptions thrown in the Image components will be of type [Phalcon\Image\Exception](api/phalcon_image#image-exception). You can use this exception to selectively catch exceptions thrown only from this component.

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

## Custom

The [Phalcon\Image\Adapter\AdapterInterface](api/phalcon_image#image-adapter-adapterinterface) interface must be implemented in order to create your own image adapters or extend the existing ones. You can then easily add it to the [Phalcon\Image\ImageFactory](api/phalcon_image#image-imagefactory).

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