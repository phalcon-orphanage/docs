---
layout: article
language: 'tr-tr'
version: '4.0'
title: 'Phalcon\Annotations\Reader'
---
# Class **Phalcon\Annotations\Reader**

*implements* [Phalcon\Annotations\ReaderInterface](Phalcon_Annotations_ReaderInterface)

[Kaynak kodu GitHub'da](https://github.com/phalcon/cphalcon/tree/v{{ page.version }}.0/phalcon/annotations/reader.zep)

Bulunan ek açıklamaları içeren bir dizi döndürerek docblockları ayrıştırır

## Metodlar

public **parse** (*mixed* $className)

Sınıf dockblock'larından, yöntemlerinden ve/veya özelliklerinden ek açıklamalar okur

public static **parseDocBlock** (*mixed* $docBlock, [*mixed* $file], [*mixed* $line])

Bulunan ek açıklamaları döndüren ham bir doc bloğu ayrıştırır