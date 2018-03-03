# Sınıf **Phalcon\\Açıklamalar\\Uyarlayıcı\\Dosyalar**

*uzanır* soyut sınıfı [Phacon\Açıklamalar\uyarlayan](/en/3.2/api/Phalcon_Annotations_Adapter)

*uygulamalar* [Phalcon\Açıklamalar\uyarlama ara bilimi](/en/3.2/api/Phalcon_Annotations_AdapterInterface)

<a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/annotations/adapter/files.zep" class="btn btn-default btn-sm">Source on GitHub</a>

Stores the parsed annotations in files. This adapter is suitable for production

```php
<?php

use Phalcon\Annotations\Adapter\Files;

$annotations = new Files(
    [
        "annotationsDir" => "app/cache/annotations/",
    ]
);

```

## Methods

herkese açık **__düzenle** ([*sıra* $seçenekler])

Phalcon\\Açıklamalar\\uyarlama\\Apc kurucusu

herkese açık [Phalcon\Açıklamalar\Yansıma](/en/3.2/api/Phalcon_Annotations_Reflection) **oku** (*dizi* $anahtar)

Reads parsed annotations from files

herkese açık **yaz** (*karışık* $anahtar, [Phalcon\Açıklamalar\yansıma](/en/3.2/api/Phalcon_Annotations_Reflection) $veri)

Writes parsed annotations to files

herkese açık **okuyucu ayarla** ([Phalcon\Açıklamalar\Okuyucu ara yüzü](/en/3.2/api/Phalcon_Annotations_ReaderInterface) $okuyucu) [Phalcon\Açıklamalar\uyarlanan](/en/3.2/api/Phalcon_Annotations_Adapter)'dan alındı

Sets the annotations parser

herkese açık ** okuyucu ekle** () [Phalcon\Açıklamalar\uyarlanan](/en/3.2/api/Phalcon_Annotations_Adapter)'dan alındı

Returns the annotation reader

herkese açık **al** (*dizi* | *nesne* $sınıf adı) [Phalcon\Açıklamalar\uyarlayıcı](/en/3.2/api/Phalcon_Annotations_Adapter)'dan alındı

Parses or retrieves all the annotations found in a class

herkese açık **Yöntemleri al** (*karışık* $sınıf adı) [Phalcon\Açıklamalar\uyarlayıcı](/en/3.2/api/Phalcon_Annotations_Adapter)'dan alındı

Returns the annotations found in all the class' methods

herkese açık **Yöntemi al** (*karışık* $sınıf adı, *karışık* $yöntem adı) [Phalcon\Açıklamalar\uyarlayıcı](/en/3.2/api/Phalcon_Annotations_Adapter)'dan alındı

Returns the annotations found in a specific method

public **getProperties** (*mixed* $className) inherited from [Phalcon\Annotations\Adapter](/en/3.2/api/Phalcon_Annotations_Adapter)

Returns the annotations found in all the class' methods

herkese açık **Özellik al** (*karışık* $sınıf adı, *karışık* $Özellik adı) [Phalcon\Açıklamalar\Uyarlayıcı](/en/3.2/api/Phalcon_Annotations_Adapter)'dan alındı

Returns the annotations found in a specific property