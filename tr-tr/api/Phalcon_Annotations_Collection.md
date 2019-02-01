---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Annotations\Collection'
---
# Class **Phalcon\Annotations\Collection**

*implements* [Iterator](https://php.net/manual/en/class.iterator.php), [Traversable](https://php.net/manual/en/class.traversable.php), [Countable](https://php.net/manual/en/class.countable.php)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/collection.zep)

Represents a collection of annotations. This class allows to traverse a group of annotations easily

```php
<?php

// Ek açıklamalarla git
foreach ($classAnnotations as $annotation) {
    echo "Name=", $annotation->getName(), PHP_EOL;
}
// Ek açıklamaların belirli bir özelliğe sahip olup olmadığını kontrol edin
var_dump($classAnnotations->has("Cacheable"));

// Koleksiyonun belirli bir açıklaması alın
$annotation = $classAnnotations->get("Cacheable");

```

## Metodlar

herkese açık **__düzenle** ([*dizi* $Yansıma Verileri])

Phalcon\Annotations\Collection constructor

herkese açık **say** ()

Koleksiyondaki ek açıklamalar sayısını geri getirir

herkese açık **geri sarma** ()

Dahili yineleyiciyi başa sarar

public [Phalcon\Annotations\Annotation](Phalcon_Annotations_Annotation) **current** ()

Yineleyicide geçerli ek açıklamayı geri getirir

herkese açık **anahtar** ()

Yineleyicideki şuanki konumu/anahtarı döner

herkese açık **sonraki** ()

İç yineleyici işaretçisini sıradaki konuma taşır

herkese açık **geçerli** ()

Yineleyici içindeki mevcut ek açıklamanın geçerli olup olmadığını kontrol eder

herkese açık ** Açıklamaları al** ()

Dahili ek açıklamaları bir dizi olarak döndürür

herkese açık **al** (*dizi* $isim)

Bir isim ile eşleşen ilk ek açıklamayı döndürür

herkese açık **Hepsini al** (*dizi* $isim)

Bir isim ile eşleşen tüm ek açıklamaları döndürür

herkese açık **var** (*dizi* $isim)

Künyede açıklama var mı kontrol edin