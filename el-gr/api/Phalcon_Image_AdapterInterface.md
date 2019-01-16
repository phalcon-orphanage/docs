* * *

layout: article language: 'en' version: '4.0' title: 'Phalcon\Image\AdapterInterface'

* * *

# Interface **Phalcon\Image\AdapterInterface**

<a href="https://github.com/phalcon/cphalcon/tree/v4.0.0/phalcon/image/adapterinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>

## Methods

abstract public **resize** ([*mixed* $width], [*mixed* $height], [*mixed* $master])

...

abstract public **crop** (*mixed* $width, *mixed* $height, [*mixed* $offsetX], [*mixed* $offsetY])

...

abstract public **rotate** (*mixed* $degrees)

...

abstract public **flip** (*mixed* $direction)

...

abstract public **sharpen** (*mixed* $amount)

...

abstract public **reflection** (*mixed* $height, [*mixed* $opacity], [*mixed* $fadeIn])

...

abstract public **watermark** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $watermark, [*mixed* $offsetX], [*mixed* $offsetY], [*mixed* $opacity])

...

abstract public **text** (*mixed* $text, [*mixed* $offsetX], [*mixed* $offsetY], [*mixed* $opacity], [*mixed* $color], [*mixed* $size], [*mixed* $fontfile])

...

abstract public **mask** ([Phalcon\Image\Adapter](Phalcon_Image_Adapter) $watermark)

...

abstract public **background** (*mixed* $color, [*mixed* $opacity])

...

abstract public **blur** (*mixed* $radius)

...

abstract public **pixelate** (*mixed* $amount)

...

abstract public **save** ([*mixed* $file], [*mixed* $quality])

...

abstract public **render** ([*mixed* $ext], [*mixed* $quality])

...