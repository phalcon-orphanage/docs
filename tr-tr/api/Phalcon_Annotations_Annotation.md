---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Annotations\Annotation'
---
# Class **Phalcon\Annotations\Annotation**

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/annotation.zep)

Bir çok açıklama içinde tek bir açıklama olduğunu gösterir

## Metodlar

herkese açık **__oluştur** (*dizi* $reflectionData)

Phalcon\Annotations\Annotation constructor

herkese açık ** isim al** ()

Ek açıklamanın adını döndürür

herkese açık *karışık* **İfadeal** (*dizi* $expr)

Bir açıklama ifadesini çözer

herkese açık *dizi* **İfadeArgümanlarınıal** ()

İfade argümanlarını çözümlemeden döner

herkese açık *dizi* **Argümanlarıal** ()

İfade argümanlarını getirir

public **numberArguments** ()

Bir ek açıklamada olan argüman sayısını döner

public *mixed* **getArgument** (*int* | *string* $position)

Belirli bir konumdaki bağımsız değişkeni döndürür

public *boolean* **hasArgument** (*int* | *string* $position)

Belirli bir konumdaki bağımsız değişkeni döndürür

public *mixed* **getNamedArgument** (*mixed* $name)

Adlandırılmış bir argümanı döndürür

public *mixed* **getNamedParameter** (*mixed* $name)

Adlandırılmış bir parametre döner