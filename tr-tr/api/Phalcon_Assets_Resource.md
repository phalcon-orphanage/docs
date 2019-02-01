---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Assets\Resource'
---
# Class **Phalcon\Assets\Resource**

*implements* [Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/resource.zep)

Bir varlık kaynağını temsil eder

```php
<?php

$resource = new \Phalcon\Assets\Resource("js", "javascripts/jquery.js");

```

## Metodlar

genel **getType** ()

public **getPath** ()

public **getLocal** ()

public **getFilter** ()

public **getAttributes** ()

public **getSourcePath** ()

...

public **getTargetPath** ()

...

public **getTargetUri** ()

...

public **__construct** (*string* $type, *string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])

Phalcon\Assets\Resource constructor

public **setType** (*mixed* $type)

Kaynağın türünü ayarlar

public **setPath** (*mixed* $path)

Kaynağın yolunu ayarlar

public **setLocal** (*mixed* $local)

Kaynağın yerel mi yoksa harici mi olduğunu ayarlar

public **setFilter** (*mixed* $filter)

Kaynağın filtrelenmesi gerekip gerekmediğini ayarlar

public **setAttributes** (*array* $attributes)

Ek HTML özellikleri ayarlar

public **setTargetUri** (*mixed* $targetUri)

Oluşturulan HTML için hedef URI ayarlar

public **setSourcePath** (*mixed* $sourcePath)

Kaynağın anahtarı ile kaynağın kaynak yolunu ayarlar

public **setTargetPath** (*mixed* $targetPath)

Kaynağın hedef yolunu ayarlar

public **getContent** ([*mixed* $basePath])

Kaynağın içeriğini bir dizge olarak döndürür İsteğe bağlı olarak kaynağın bulunduğu bir taban yolu ayarlanabilir

public **getRealTargetUri** ()

Oluşturulan HTML için gerçek hedef URL'yi döndürür

public **getRealSourcePath** ([*mixed* $basePath])

Kaynağın bulunduğu tam konumu döndürür

public **getRealTargetPath** ([*mixed* $basePath])

Kaynağın yazıldığı tam konumu döndürür

public **getResourceKey** ()

Kaynağın anahtarının getirir.