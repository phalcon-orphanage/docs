<div class='article-menu'>
  <ul>
    <li>
      <a href="#overview">Pagpapa-unlad ng Pagganap kasama ng Cache</a>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Mga imahe

`Phalcon\Image` ay ang bahagi na nagbibigay-daan sa iyo upang manipulahin ang mga file ng imahe. Maramihang mga operasyon ay maaaring isagawa sa parehong bagay ng imahe.

<a name='adapters'></a>

## Mga adaptor

Ang bahaing ito na gumagamit sa mga adaptor upang isarado ang tiyak na imahe na nagmamanipula sa mga programa. Ang mga sumusunod na mga imahe ng nagmamanupula na mga programa ay suportado:

| Klase                              | Paglalarawan                                                                              |
| ---------------------------------- | ----------------------------------------------------------------------------------------- |
| `Phalcon\Image\Adapter\Gd`      | Nangangailangan ng [GD PHP extension](http://php.net/manual/en/book.image.php)            |
| `Phalcon\Image\Adapter\Imagick` | Nangangailangan ng [ImageMagick PHP extension](http://php.net/manual/en/book.imagick.php) |

<a name='adapters-custom'></a>

### Pagapatupad ng iyong mga adaptor

Ang `Phalcon\Image\AdapterInterface` interface na dapat na maipatupad upang makagawa na sariling adaptor ng mga imahe o palawigin ang mga umiiiral na.

<a name='saving-rendering'></a>

## Pagsave at pagrender ng mga imahe

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

## Pag-iba ng sukat ng mga imahe

Mayroong maraming paraan ng pag-iba ng sukat:

* `\Phalcon\Image::LAPAD`
* `\Phalcon\Image::TAAS`
* `\Phalcon\Image::WALA`
* `\Phalcon\Image::UNAT`
* `\Phalcon\Image::AWTOMATIKO`
* `\Phalcon\Image::BALIKTAD`
* `\Phalcon\Image::SAKTO`

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

* Ang `NONE` na hindi nagbabago ay hindi pinapansin ang ratio ng orihinal na imahe.
* Hindi lapad at taas ang kailangan.
* Kung ang isang dimensyon ay hindi natukoy, ang orihinal na dimensyon ay gagamitin.
* Kung ang mga bagong proporsyon ay naiiba mula sa orihinal na proporsyon, ang imahe ay maaaring magulo at nakaunat.

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

* Katulad ng `NONE` na hindi nagbabago, ang `TENSILE` hindi nagbabago ay binabalewala ang ratio ng orihinal na imahe.
* Ang lapad at taas ay kailangan.
* Kung ang mga bagong proporsyon ay naiiba mula sa orihinal na proprosyon, ang imahe ay maaaring magulo at nakaunat.

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

## Pag-crop ng mga imahe

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

## Pag-ikot ng mga imahe

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

// Rotate an image by 90 degrees clockwise
$image->rotate(90);

$image->save('rotated-image.jpg');
```

<a name='flipping'></a>

## Pagbaliktad ng mga imahe

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

## Pagpapatalas ng mga imahe

Ang `sharpen()` na paraan ay kumukuha ng isang parameto - isang integer sa pagitan ng 0 (walang epekto) at 100 (napakatalas):

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

$image->sharpen(50);

$image->save('sharpened-image.jpg');
```

<a name='watermarks'></a>

## Pagdagdag ng mga watermark sa mga imahe

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

## Pagpapalabo ng mga imahe

Ang `blur()` na paraan ay kumukuha ng isang parametro - isang integer sa pagitan ng 0 (walang epekto) at 100 (napakalabo):

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

$image->blur(50);

$image->save('blurred-image.jpg');
```

<a name='pixelating'></a>

## Pagpixelate ng mga imahe

Ang `pixelate()` na paraan ay kumukuha ng isang parametro - mas mataas ang integer, mas nagiging pagpixelate ang imahe:

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

$image->pixelate(10);

$image->save('pixelated-image.jpg');
```