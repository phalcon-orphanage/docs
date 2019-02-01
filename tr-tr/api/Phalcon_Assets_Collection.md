---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Assets\Collection'
---
# Class **Phalcon\Assets\Collection**

*implements* [Countable](https://php.net/manual/en/class.countable.php), [Iterator](https://php.net/manual/en/class.iterator.php), [Traversable](https://php.net/manual/en/class.traversable.php)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/assets/collection.zep)

Kaynak koleksiyonlarını temsil eder

## Metodlar

public **getPrefix** ()

...

public **getLocal** ()

...

yerel **getResources** ()

...

public **getCodes** ()

...

public **getPosition** ()

...

public **getFilters** ()

...

public **getAttributes** ()

...

public **getJoin** ()

...

public **getTargetUri** ()

...

public **getTargetPath** ()

...

public **getTargetLocal** ()

...

public **getSourcePath** ()

...

genel**__construct** ()

Phalcon\Assets\Collection constructor

public **add** ([Phalcon\Assets\Resource](Phalcon_Assets_Resource) $resource)

Koleksiyone bir kaynak ekler

public **addInline** ([Phalcon\Assets\Inline](Phalcon_Assets_Inline) $code)

Koleksiyone bir satır içi kod ekler

public **has** ([Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface) $resource)

Kaynağın koleksiyona eklendiğini denetler.

```php
<?php

use Phalcon\Assets\Resource;
use Phalcon\Assets\Collection;

$collection = new Collection();

$resource = new Resource("js", "js/jquery.js");
$resource->has($resource); // doğru

```

public **addCss** (*mixed* $path, [*mixed* $local], [*mixed* $filter], [*mixed* $attributes])

Koleksiyona bir CSS kaynağı ekler

herkese açık **SatıriçiCssekle** (*karışık* $content, [*karışık* $filter], [*karışık* $attributes])

Koleksiyone bir satır içi CSS ekler

public [Phalcon\Assets\Collection](Phalcon_Assets_Collection) **addJs** (*string* $path, [*boolean* $local], [*boolean* $filter], [*array* $attributes])

Koleksiyona Javascript kaynağı ekler

public **addInlineJs** (*mixed* $content, [*mixed* $filter], [*mixed* $attributes])

Koleksiyona bir satır içi javascript ekler

herkese açık **say** ()

Formdaki öğelerin sayısını döndürür

herkese açık **geri sarma** ()

Dahili yineleyiciyi başa sarar

public **current** ()

Yineleyicide geçerli kaynağa döndürür

public *int* **key** ()

Yineleyicideki şuanki konumu/anahtarı döner

herkese açık **sonraki** ()

İç yineleyici işaretçisini sıradaki konuma taşır

herkese açık **geçerli** ()

Yineleyicideki geçerli öğenin geçerli olup olmadığını kontrol etme

public **setTargetPath** (*mixed* $targetPath)

Filtrelenen/birleşen çıktısının dosyanın hedef yolunu ayarlar

public **setSourcePath** (*mixed* $sourcePath)

Bu koleksiyondaki tüm kaynaklar için bir ana kaynak yolu ayarlar

public **setTargetUri** (*mixed* $targetUri)

Oluşturulan HTML için hedef URI ayarlar

public **setPrefix** (*mixed* $prefix)

Tüm kaynaklar için ortak bir ön ek ayarlar

public **setLocal** (*mixed* $local)

Koleksiyonun varsayılan olarak yerel kaynakları kullanıp kullanmasını ayarlar

public **setAttributes** (*array* $attributes)

Ek HTML özellikleri ayarlar

public **setFilters** (*array* $filters)

Koleksiyon içindeki filtre listesini ayarlar

public **setTargetLocal** (*mixed* $targetLocal)

Yerel hedefi ayarlar

public **join** (*mixed* $join)

Koleksiyondaki tüm filtrelenmiş kaynaklar tek bir sonuç dosyasında mı birleştirilsin diye ayarlar

public **getRealTargetPath** (*mixed* $basePath)

Birleştirilmiş/filtrelenmiş koleksiyonun yazıldığı tam konumu döner

public **addFilter** ([Phalcon\Assets\FilterInterface](Phalcon_Assets_FilterInterface) $filter)

Koleksiyona filtre ekler

final protected **addResource** ([Phalcon\Assets\ResourceInterface](Phalcon_Assets_ResourceInterface) $resource)

Koleksiyona kaynak veya satır içi kod ekler