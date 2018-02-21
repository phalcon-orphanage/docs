# Class **Phalcon\\Annotations\\Adapter\\Apc**

*extends* abstract class [Phalcon\Annotations\Adapter](/en/3.2/api/Phalcon_Annotations_Adapter)

*uygulamalar* [Phalcon\Açıklamalar\Ara birim adaptörü](/en/3.2/api/Phalcon_Annotations_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/annotations/adapter/apc.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Stores the parsed annotations in APC. This adapter is suitable for production

```php
<?php

use Phalcon\Annotations\Adapter\Apc;

$annotations = new Apc();

```

## Methods

herkese açık **__düzenle**([* sıra* $seçenekler])

Phalcon\\Açıklamalar\\uyarlama\\Apc kurucusu

herkese açık **oku** (*karışık*$anahtar)

Reads parsed annotations from APC

public **write** (*mixed* $key, [Phalcon\Annotations\Reflection](/en/3.2/api/Phalcon_Annotations_Reflection) $data)

Writes parsed annotations to APC

herkese açık **okuyucu ayarla** ([Phalcon\Açıklamalar\Okuyucu arayüzü](/en/3.2/api/Phalcon_Annotations_ReaderInterface) $okuyucu) miras alınan [Phalcon\Açıklamalar\uyarlanan](/en/3.2/api/Phalcon_Annotations_Adapter)

Sets the annotations parser

herkese açık ** okuyucu ekle** () miras alınan [Phalcon\Açıklamalar\uyarlanan](/en/3.2/api/Phalcon_Annotations_Adapter)

Returns the annotation reader

herkese açık **al** (*dizi* | *nesne* $sınıf adı) [Phalcon\Açıklamalar\uyarlayıcı](/en/3.2/api/Phalcon_Annotations_Adapter)'dan alındı

Parses or retrieves all the annotations found in a class

herkese açık **Yöntemleri al** (*karışık* $sınıf adı) [Phalcon\Açıklamalar\uyarlayıcı](/en/3.2/api/Phalcon_Annotations_Adapter)'dan alındı

Returns the annotations found in all the class' methods

public **getMethod** (*mixed* $className, *mixed* $methodName) inherited from [Phalcon\Annotations\Adapter](/en/3.2/api/Phalcon_Annotations_Adapter)

Returns the annotations found in a specific method

herkese açık **Özellikleri al** (*karışık* $sınıf adı)[Phalcon\Açıklamalar\uyarlayıcı](/en/3.2/api/Phalcon_Annotations_Adapter)'dan alındı

Returns the annotations found in all the class' methods

herkese açık **Özellik al** (*karışık* $sınıf adı, *karışık* $Özellik adı) [Phalcon\Açıklamalar\Uyarlayıcı](/en/3.2/api/Phalcon_Annotations_Adapter)'dan alındı

Returns the annotations found in a specific property