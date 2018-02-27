<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Images</a> <ul>
        <li>
          <a href="#adapters">Adapters</a> <ul>
            <li>
              <a href="#adapters-factory">Factory</a>
            </li>
            <li>
              <a href="#adapters-custom">Pagpapatupad ng iyong sariling mga adapter</a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#saving-rendering">Saving and rendering images</a>
        </li>
        <li>
          <a href="#resizing">Resizing images</a> <ul>
            <li>
              <a href="#resizing-width"><code>\Phalcon\Image::WIDTH</code></a>
            </li>
            <li>
              <a href="#resizing-height"><code>\Phalcon\Image::HEIGHT</code></a>
            </li>
            <li>
              <a href="#resizing-none"><code>\Phalcon\Image::NONE</code></a>
            </li>
            <li>
              <a href="#resizing-tensile"><code>\Phalcon\Image::TENSILE</code></a>
            </li>
          </ul>
        </li>
        <li>
          <a href="#cropping">Cropping images</a>
        </li>
        <li>
          <a href="#rotating">Rotating images</a>
        </li>
        <li>
          <a href="#flipping">Flipping images</a>
        </li>
        <li>
          <a href="#sharpening">Sharpening images</a>
        </li>
        <li>
          <a href="#watermarks">Adding watermarks to images</a>
        </li>
        <li>
          <a href="#blurring">Blurring images</a>
        </li>
        <li>
          <a href="#pixelating">Pixelating images</a>
        </li>
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

### Pagpapatupad ng iyong sariling mga adapter

Ang `Phalcon\Imahe\AdapterInterface` na interface ay dapat na ipatupad para makalikha ng iyong sariling mga adapter na sesyon o palawigin pa ang mga umiiral na.

<a name='saving-rendering'></a>

## Saving and rendering images

Bago tayo magsimula sa iba-iba na mga tampok ng komponent ng imahe, ito ay nararapat maunawaan kung paano i-save at i-render ang mga imaheng ito.

```php
<?php

$image = bago \Phalcon\Imahe\Adapter\Gd('image.jpg');

// ...

// I-overwrite ang orihinal na imahe
$image->save();
```

```php
<?php

$image = bago \Phalcon\Imahe\Adapter\Gd('image.jpg');

// ...

// I-save sa 'new-image.jpg'
$image->save('new-image.jpg');
```

Maaari mo ring baguhin ang pormat ng imahe:

```php
<?php

$image = bago \Phalcon\Imahe\Adapter\Gd('image.jpg');

// ...

// I-save bilang isang PNG na file
$image->save('image.png');
```

Kapag magse-save bilang isang JPEG, maaari mo ring banggitin ang kalidad bilang pangalawang parameter:

```php
<?php

$image = bago \Phalcon\Imahe\Adapter\Gd('image.jpg');

// ...

// I-save bilang isang JPEG na may 80% na kalidad
$image->save('image.jpg', 80);
```

<a name='resizing'></a>

## Resizing images

Mayroong ilang mga mode ng resizing:

- `\Phalcon\Image::WIDTH`
- `\Phalcon\Image::HEIGHT`
- `\Phalcon\Image::NONE`
- `\Phalcon\Image::TENSILE`
- `\Phalcon\Image::AUTO`
- `\Phalcon\Image::INVERSE`
- `\Phalcon\Image::PRECISE`

<a name='resizing-width'></a>

### `\Phalcon\Image::WIDTH`

Ang taas ay awtomatikong mabubuo para panatilihin na proporsyon ay magkatulad; kung tinukoy mo ang isang taas, ito ay babaliwalain.

```php
<?php

$image = bago \Phalcon\Imahe\Adapter\Gd('image.jpg');

$image->resize(
    300,
    null,
    \Phalcon\Image::WIDTH
);

$image->save('resized-image.jpg');
```

<a name='resizing-height'></a>

### `\Phalcon\Image::HEIGHT`

Ang lapad ay awtomatikong mabubuo para panatilihin na magkapareho ang proporsyon; kung tinukoy mo ang isang lapad, ito ay babaliwalain.

```php
<?php

$image = bago \Phalcon\Imahe\Adapter\Gd('image.jpg');

$image->resize(
    null,
    300,
    \Phalcon\Imahe::TAAS
);

$image->save('resized-image.jpg');
```

<a name='resizing-none'></a>

### `\Phalcon\Image::NONE`

- The `NONE` constant ignores the original image's ratio.
- Neither width and height are required.
- If a dimension is not specified, the original dimension will be used.
- If the new proportions differ from the original proportions, the image may be distorted and stretched.

```php
<?php

$image = bago \Phalcon\Imahe\Adapter\Gd('image.jpg');

$image->resize(
    400,
    200,
    \Phalcon\Imahe::WALA
);

$image->save('resized-image.jpg');
```

<a name='resizing-tensile'></a>

### `\Phalcon\Image::TENSILE`

- Katulad ng `NONE` na constant, ang `TENSILE` na constant ay hindi papansinin ang orihinal na ratio ng imahe.
- Parehong kinakailangan ang width at height.
- If the new proportions differ from the original proportions, the image may be distorted and stretched.

```php
<?php

$image = bago \Phalcon\Imahe\Adapter\Gd('image.jpg');

$image->resize(
    400,
    200,
    \Phalcon\Image::TENSILE
);

$image->save('resized-image.jpg');
```

<a name='cropping'></a>

## Cropping images

Halimbawa, para makakuha ng 100px by 100px na square mula sa sentro ng imahe:

```php
<?php

$image = new \Phalcon\Imahe\Adapter\Gd('image.jpg');

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

// Paikutin ang isang imahe sa pamamagitan ng 90 degrees na clockwise
$image->rotate(90);

$image->save('rotated-image.jpg');
```

<a name='flipping'></a>

## Flipping images

Maaari mong ibaligtad ang isang imahe nang pahalang (gamit ang `\Phalcon\Imahe::PAHALNG` konstant) at patayo (using the `\Phalcon\Imahe::PATAYO` konstant):

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

// Baligtarin ang isang imahe ng pahalang
$image->flip(
    \Phalcon\Image::HORIZONTALLY
);

$image->save('flipped-image.jpg');
```

<a name='sharpening'></a>

## Sharpening images

Ang `sharpen()` na pamamaraan ay kumukuha ng nag-iisang parameter - isang integer sa pagitan ng 0 (walang epekto) at 100 (napaka matalim):

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

// Lagyan ng watermark sa kaliwang sulok sa itaas
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

Siyempre, maaari ka ring magmanipula ng na-watermark na imahe bago i-apply ito sa pangunahing imahe:

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

$watermark = new \Phalcon\Image\Adapter\Gd('me.jpg');

$watermark->resize(100, 100);
$watermark->rotate(90);
$watermark->sharpen(5);

// Ilagay ang watermark sa ibabang kanang sulok na may margin na 10px
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

Ang `blur()` na paraan ay kumukuha ng nag-iisang parameter - isang integer sa pagitan ng 0 (walang epekto) at 100 (napaka malabo):

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

$image->blur(50);

$image->save('blurred-image.jpg');
```

<a name='pixelating'></a>

## Pixelating images

Ang `pixelate()` na paraan ay kumukuha ng nag-iisang parameter - mas mataas ang integer, mas magiging pixelated ang imahe:

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

$image->pixelate(10);

$image->save('pixelated-image.jpg');
```