<div class='article-menu'>
  <ul>
    <li>
      <a href="#pangkalahatang-ideya">Pagpapabuti ng Pagsasagawa sa Cache</a>
    </li>
  </ul>
</div>

<a name='overview'></a>

# Mga Imahe

Ang `Phalcon\Imahe` ay ang komponent na pinapahintulotan ka na magmanipula ng imahe na mga file. Maramihang mga operasyon na maaaring ganapin sa parehong imahe na bagay.

<a name='adapters'></a>

## Mga Adapter

Ang komponent na ito ay gumagamit ng mga adapter para i-encapsulate ang tinukoy na manipulador ng imahe na mga programa. Ang sumusunod na manipulador ng imahe na mga programa ay suportado:

| Klase                              | Deskripsyon                                                                                   |
| ---------------------------------- | --------------------------------------------------------------------------------------------- |
| `Phalcon\Imahe\Adapter\Gd`      | Nangangailangan ng [GD PHP na ekstensyon](http://php.net/manual/en/book.image.php)            |
| `Phalcon\Imahe\Adapter\Imagick` | Nangangailangan ng [ImaheMagick PHP na ekstensyon](http://php.net/manual/en/book.imagick.php) |

<a name='adapters-custom'></a>

### Pagpapatupad ng iyong sariling mga adapter

Ang `Phalcon\Imahe\AdapterInterface` na interface ay dapat na ipatupad para maglikha ng iyong sariling mga adapter na sesyon o palawigin ang mga umiiral na.

<a name='saving-rendering'></a>

## Pag-save at pag-render ng mga imahe

Bago tayo magsimula sa iba't ibang mga tampok ng bahagi ng imahe, nararapat itong maunawaan kung paano i-save at i-render ang mga imaheng ito.

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

Kapag magse-save bilang isang JPEG, maaari mo ring tukuyin ang kalidad bilang pangalawang parameter:

```php
<?php

$image = bago \Phalcon\Imahe\Adapter\Gd('image.jpg');

// ...

// I-save bilang isang JPEG na may 80% na kalidad
$image->save('image.jpg', 80);
```

<a name='resizing'></a>

## Pagbabago ng laki ng mga imahe

Mayroong ilang mga mode ng pagbabago ng laki:

* `\Phalcon\Image::WIDTH`
* `\Phalcon\Image::HEIGHT`
* `\Phalcon\Image::NONE`
* `\Phalcon\Image::TENSILE`
* `\Phalcon\Image::AUTO`
* `\Phalcon\Image::INVERSE`
* `\Phalcon\Image::PRECISE`

<a name='resizing-width'></a>

### `\Phalcon\Image::WIDTH`

Ang taas ay awtomatikong mabubuo para panatilihin na magkapareho ang mga sukat; kung tinukoy mo ang isang taas, ito ay hindi papansinin.

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

Ang lapad ay awtomatikong mabubuo para panatilihin na magkapareho ang mga sukat; kung tinukoy mo ang isang lapad, ito ay hindi papansinin.

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

* Ang `NONE` na konstant ay hindi papansinin ang orihinal na ratio ng imahe.
* Alinma'y hindi kinakailangan ang lapad at taas.
* Kung ang isang dimensyon ay hindi tinukoy, ang orihinal na dimensyon ay gagamitin.
* Kung ang bagong mga proporsyon ay naiiba mula sa orihinal na mga proporsyon, ang imahe ay maaaring maging magulo at nakaunat.

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

* Katulad ng `NONE` na konstant, ang `TENSILE` na konstant ay hindi papansinin ang orihinal na ratio ng imahe.
* Parehong kinakailangan ang width at height.
* Kung ang bagong mga proporsyon ay naiiba mula sa orihinal na mga proporsyon, ang imahe ay maaaring maging distorted at stretched.

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

## Pag-crop ng mga imahe

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

## Umiikot na mga imahe

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

// Paikutin ang isang imahe sa pamamagitan ng 90 degrees na clockwise
$image->rotate(90);

$image->save('rotated-image.jpg');
```

<a name='flipping'></a>

## Pagbaligtad ng mga imahe

Maaari mong i-flip ang isang imahe nang pahalang (gamit ang `\Phalcon\Imahe::PAHALNG` konstant) at patayo (using the `\Phalcon\Imahe::PATAYO` konstant):

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

## Pagpapatalas ng mga imahe

Ang `sharpen()` na pamamaraan ay tumatagal ng isang solong parameter - isang integer sa pagitan ng 0 (walang epekto) at 100 (napaka matalim):

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

Siyempre, maaari mo ring manipulahin ang na-watermark na imahe bago i-apply ito sa pangunahing imahe:

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

## Pagpapalabo ng mga imahe

Ang `blur()` na paraan ay tumatagal ng isang parameter - isang integer sa pagitan ng 0 (walang epekto) at 100 (napaka malabo):

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

$image->blur(50);

$image->save('blurred-image.jpg');
```

<a name='pixelating'></a>

## Pag-pixelate ng mga imahe

Ang `pixelate()` na paraan ay tumatagal ng isang parameter - mas mataas ang integer, mas magiging pixelated ang imahe:

```php
<?php

$image = new \Phalcon\Image\Adapter\Gd('image.jpg');

$image->pixelate(10);

$image->save('pixelated-image.jpg');
```