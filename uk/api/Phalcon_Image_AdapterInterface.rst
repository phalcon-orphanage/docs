Interface **Phalcon\\Image\\AdapterInterface**
==============================================

.. role:: raw-html(raw)
   :format: html

:raw-html:`<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/image/adapterinterface.zep" class="btn btn-default btn-sm">Source on GitHub</a>`

Methods
-------

abstract public  **resize** ([*unknown* $width], [*unknown* $height], [*unknown* $master])

...


abstract public  **crop** (*unknown* $width, *unknown* $height, [*unknown* $offsetX], [*unknown* $offsetY])

...


abstract public  **rotate** (*unknown* $degrees)

...


abstract public  **flip** (*unknown* $direction)

...


abstract public  **sharpen** (*unknown* $amount)

...


abstract public  **reflection** (*unknown* $height, [*unknown* $opacity], [*unknown* $fadeIn])

...


abstract public  **watermark** (:doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>` $watermark, [*unknown* $offsetX], [*unknown* $offsetY], [*unknown* $opacity])

...


abstract public  **text** (*unknown* $text, [*unknown* $offsetX], [*unknown* $offsetY], [*unknown* $opacity], [*unknown* $color], [*unknown* $size], [*unknown* $fontfile])

...


abstract public  **mask** (:doc:`Phalcon\\Image\\Adapter <Phalcon_Image_Adapter>` $watermark)

...


abstract public  **background** (*unknown* $color, [*unknown* $opacity])

...


abstract public  **blur** (*unknown* $radius)

...


abstract public  **pixelate** (*unknown* $amount)

...


abstract public  **save** ([*unknown* $file], [*unknown* $quality])

...


abstract public  **render** ([*unknown* $ext], [*unknown* $quality])

...


