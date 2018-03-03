# Class **Phalcon\\Annotations\\Adapter\\Apcu**

*uzanır soyut sınıfı *Phacon\Açıklamalar\uyarlayan</a>

*uygulamalar* [Phalcon\Açıklamalar\uyarlama ara bilimi](/en/3.2/api/Phalcon_Annotations_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/annotations/adapter/apcu.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Stores the parsed annotations in APCu. This adapter is suitable for production

```php
<?php

use Phalcon\Annotations\Adapter\Apcu;

$annotations = new Apcu();

```

## Methods

herkese açık **__düzenle** ([*sıra* $seçenekler])

Phalcon\\Açıklamalar\\uyarlayan\\Apcu yapımcısı

herkese açık **oku** (*karışık* $anahtar)

Reads parsed annotations from APCu

herkese açık **yaz** (*karışık* $anahtar, [Phalcon\Açıklamalar\yansıma](/en/3.2/api/Phalcon_Annotations_Reflection) $veri)

Writes parsed annotations to APCu

herkese açık **okuyucu ayarla** ([Phalcon\Açıklamalar\Okuyucu arayüzü](/en/3.2/api/Phalcon_Annotations_ReaderInterface) $okuyucu) miras alınan [Phalcon\Açıklamalar\uyarlanan](/en/3.2/api/Phalcon_Annotations_Adapter)

Sets the annotations parser

public **getReader** () inherited from [Phalcon\Annotations\Adapter](/en/3.2/api/Phalcon_Annotations_Adapter)

Returns the annotation reader

herkese açık **al** (*dizi* | *nesne* $sınıf adı) [Phalcon\Açıklamalar\uyarlayıcı](/en/3.2/api/Phalcon_Annotations_Adapter)'dan alındı

Parses or retrieves all the annotations found in a class

herkese açık **Yöntemleri al** (*karışık* $sınıf adı) [Phalcon\Açıklamalar\uyarlayıcı](/en/3.2/api/Phalcon_Annotations_Adapter)'dan alındı

Returns the annotations found in all the class' methods

herkese açık **Yöntemi al** (*karışık* $sınıf adı, *karışık* $yöntem adı) [Phalcon\Açıklamalar\uyarlayıcı](/en/3.2/api/Phalcon_Annotations_Adapter)'dan alındı

Returns the annotations found in a specific method

herkese açık **Özellikleri al** (*karışık* $sınıf adı)[Phalcon\Açıklamalar\uyarlayıcı](/en/3.2/api/Phalcon_Annotations_Adapter)'dan alındı

Returns the annotations found in all the class' methods

herkese açık **Özellik al** (*karışık* $sınıf adı, *karışık* $Özellik adı) [Phalcon\Açıklamalar\Uyarlayıcı](/en/3.2/api/Phalcon_Annotations_Adapter)

Returns the annotations found in a specific property