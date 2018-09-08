<div class="article-menu">
    <ul>
        <li>
            <a href="#overview">Images</a>
            <ul>
                <li>
                    <a href="#adapters">Adapters</a>
                    <ul>
                        <li>
                            <a href="#adapters-factory">Factory</a>
                        </li>
                        <li>
                            <a href="#adapters-custom">Pagapatupad ng iyong mga adaptor</a>
                        </li>
                    </ul>
                </li>
                <li><a href="#saving-rendering">Saving and rendering images</a>
                </li>
                <li><a href="#resizing">Resizing images</a>
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
                <li><a href="#cropping">Cropping images</a></li>
                <li><a href="#rotating">Rotating images</a></li>
                <li><a href="#flipping">Flipping images</a></li>
                <li><a href="#sharpening">Sharpening images</a></li>
                <li><a href="#watermarks">Adding watermarks to images</a></li>
                <li><a href="#blurring">Blurring images</a></li>
                <li><a href="#pixelating">Pixelating images</a></li>
            </ul>
        </li>
    </ul>
</div>

<a name='overview'></a>

# Images

`Phalcon\Image` is the component that allows you to manipulate image files. Multiple operations can be performed on the same image object.

<a name='adapters'></a>

## Adapters

This component makes use of adapters to encapsulate specific image manipulator programs. The following image manipulator programs are supported:

| Class                              | Description                                                                         |
| ---------------------------------- | ----------------------------------------------------------------------------------- |
| `Phalcon\Image\Adapter\Gd`      | Requires the [GD PHP extension](http://php.net/manual/en/book.image.php)            |
| `Phalcon\Image\Adapter\Imagick` | Requires the [ImageMagick PHP extension](http://php.net/manual/en/book.imagick.php) |

<a name='adapters-factory'></a>

### Factory

Loads an Image Adapter class using `adapter` option.

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

### Pagapatupad ng iyong mga adaptor

Ang `Phalcon\Image\AdapterInterface` interface na dapat na maipatupad upang makagawa na sariling adaptor ng mga imahe o palawigin ang mga umiiiral na.

<a name='saving-rendering'></a>

## Saving and rendering images

Bago tayo magsimula sa ibat-ibang mga tampok ng bahagi ng imahe, mahalaga na maintindihan kung paano i-save at i-render ang mga imaheng ito.

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

Pwede mo ring baguhin ang porma ng imahe:

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

// ...

// Save as a PNG file
$image->save('image.png');
```

Kapag nagsave bilang isang JPEG, pwede mong tiyakin ang kalidad bilang pangalawang parametro:

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

// ...

// Save as a PNG file
$image->save('image.png');
```

<a name='resizing'></a>

## Resizing images

Mayroong maraming paraan ng pag-iba ng sukat:

* `\Phalcon\Image::WIDTH`
* `\Phalcon\Image::HEIGHT`
* `\Phalcon\Image::NONE`
* `\Phalcon\Image::TENSILE`
* `\Phalcon\Image::AUTO`
* `\Phalcon\Image::INVERSE`
* `\Phalcon\Image::PRECISE`

<a name='resizing-width'></a>

### `\Phalcon\Image::WIDTH`

Ang taas ay awtomatikong nagagawa upang matago ang mga proporsyon na magkapareho; kung titiyakin ang taas, ito ay mababaliwala.

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

Ang lapad ay awtomatikong nagagawa upang matago ang mga proporsyon na magkapareho; kung titiyakin, ito ay mababaliwala.

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

* The `NONE` constant ignores the original image's ratio.
* Neither width and height are required.
* If a dimension is not specified, the original dimension will be used.
* If the new proportions differ from the original proportions, the image may be distorted and stretched.

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

* Similar to the `NONE` constant, the `TENSILE` constant ignores the original image's ratio.
* Both width and height are required.
* If the new proportions differ from the original proportions, the image may be distorted and stretched.

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

## Cropping images

Sa halimbawa, para makakuha ng isang 100px by 100px na kwadrado galing sa gitna na imahe:

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

## Rotating images

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

// Rotate an image by 90 degrees clockwise
$image->rotate(90);

$image->save('rotated-image.jpg');
```

<a name='flipping'></a>

## Flipping images

Pwede mong baliktarin ang isang imahe (gamit ang `\Phalcon\Image::HORIZONTAL` constant) at pahalang (using the `\Phalcon\Image::VERTICAL` constant):

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

## Sharpening images

Ang `sharpen()` na paraan ay kumukuha ng isang parameto - isang integer sa pagitan ng 0 (walang epekto) at 100 (napakatalas):

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

$image->sharpen(50);

$image->save('sharpened-image.jpg');
```

<a name='watermarks'></a>

## Adding watermarks to images

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

Syempre, pwede mong manipulahin ang watermarked na imahe bago i-apply ito sa pangunahing imahe:

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

## Blurring images

Ang `blur()` na paraan ay kumukuha ng isang parametro - isang integer sa pagitan ng 0 (walang epekto) at 100 (napakalabo):

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

$image->blur(50);

$image->save('blurred-image.jpg');
```

<a name='pixelating'></a>

## Pixelating images

Ang `pixelate()` na paraan ay kumukuha ng isang parametro - mas mataas ang integer, mas nagiging pagpixelate ang imahe:

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

$image->pixelate(10);

$image->save('pixelated-image.jpg');
```