---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Assets\Resource\Css'
---
# Class **Phalcon\Assets\Resource\Css**

*extends* class [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

*implements* [Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/resource/css.zep)

CSS kaynaklarını temsil eder

## Metodlar

yerel **__construct** (*string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])

public **getType** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

public **getPath** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

public **getLocal** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

public **getFilter** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

public **getAttributes** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

public **getSourcePath** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

...

public **getTargetPath** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

...

public **getTargetUri** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

...

public **setType** (*mixed* $type) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

Kaynağın türünü ayarlar

public **setPath** (*mixed* $path) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

Kaynağın yolunu ayarlar

public **setLocal** (*mixed* $local) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

Kaynağın yerel mi yoksa harici mi olduğunu ayarlar

public **setFilter** (*mixed* $filter) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

Kaynağın filtrelenmesi gerekip gerekmediğini ayarlar

public **setAttributes** (*array* $attributes) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

Ek HTML özellikleri ayarlar

public **setTargetUri** (*mixed* $targetUri) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

Oluşturulan HTML için hedef URI ayarlar

public **setSourcePath** (*mixed* $sourcePath) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

Kaynağın anahtarı ile kaynağın kaynak yolunu ayarlar

public **setTargetPath** (*mixed* $targetPath) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

Kaynağın hedef yolunu ayarlar

public **getContent** ([*mixed* $basePath]) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

Kaynağın içeriğini bir dizge olarak döndürür İsteğe bağlı olarak kaynağın bulunduğu bir taban yolu ayarlanabilir

public **getRealTargetUri** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

Oluşturulan HTML için gerçek hedef URL'yi döndürür

public **getRealSourcePath** ([*mixed* $basePath]) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

Kaynağın bulunduğu tam konumu döndürür

public **getRealTargetPath** ([*mixed* $basePath]) inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

Kaynağın yazıldığı tam konumu döndürür

public **getResourceKey** () inherited from [Phalcon\Assets\Resource](Phalcon_Assets_Resource)

Kaynağın anahtarının getirir.